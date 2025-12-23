<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Client;
use App\Models\ApiKey;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use App\Notifications\PdfUploaded;
use App\Notifications\NewQuestionnaireNotification;
class PdfUploadController extends Controller
{

    public function store(Request $request)
    {

    	Log::info('Début de la méthode store dans PdfUploadController');

    	if (!$request->user) {
        Log::error('Utilisateur non trouvé dans la requête');
        return response()->json(['error' => 'Unauthorized'], 401);
    	}

        // Récupérer l'utilisateur identifié par la clé API grâce au middleware
        $user = $request->user;
        Log::info('Utilisateur identifié', ['user_id' => $user->id]);

		// $request->validate([
		// 'first_name' => 'required|string',
		// 'last_name' => 'required|string',
		// 'form_sent_at' => 'required|date',
		// 'pdf_file' => 'required|file|mimes:pdf',
		// ]);
        try {
            Log::info('Données de la requête:', ['request' => $request->all()]);
        $validatedData = $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'form_sent_at' => 'required|date',
            'pdf_file' => 'required|file|mimes:pdf',
            'type' => 'required|in:questionnaire_medical,rdv_en_ligne', // Nouveau champ pour le type
        	'attachments.*' => 'nullable|file|mimes:odt,stl,docx,doc,pdf,jpg,jpeg,png|max:5120', // 5MB max par fichier
        ]);
            // Traitement du fichier PDF principal
            if ($request->hasFile('pdf_file') && $request->file('pdf_file')->isValid()) {
                $pdf = $request->file('pdf_file');
                // Traitez votre fichier ici
            } else {
                // Gestion de l'erreur si le fichier n'est pas valide
                return response()->json(['message' => 'Le fichier n\'est pas valide'], 400);
            }
        
        // Vérifier le nombre de pièces jointes (max 5)
        if ($request->hasFile('attachments')) {
            $attachmentsCount = count($request->file('attachments'));
            if ($attachmentsCount > 5) {
                return response()->json(['message' => 'Vous ne pouvez joindre que 5 pièces jointes maximum'], 400);
            }
        }
        
        Log::info('Validation des données réussie');

        Log::info('Début du processus de sauvegarde du fichier PDF');
        // Sauvegarder le fichier PDF principal
        $path = $request->file('pdf_file')->store('pdfs');
        Log::info('Fichier PDF téléchargé', ['path' => $path]);

        // Traiter les pièces jointes si présentes
        $attachmentsPaths = [];
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $index => $attachment) {
                if ($attachment->isValid()) {
                    $attachmentPath = $attachment->store('attachments');
                    $attachmentsPaths[] = [
                        'original_name' => $attachment->getClientOriginalName(),
                        'path' => $attachmentPath,
                        'size' => $attachment->getSize(),
                        'mime_type' => $attachment->getMimeType(),
                    ];
                    Log::info('Pièce jointe téléchargée', ['index' => $index, 'path' => $attachmentPath]);
                }
            }
        }
        
        // Créer une entrée dans la base de données
        $client = Client::create([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'form_sent_at' => $request->input('form_sent_at'),
            'pdf_path' => $path,
            'attachments' => !empty($attachmentsPaths) ? $attachmentsPaths : null,
            'type' => $request->input('type', 'questionnaire_medical'),
            'user_id' => $user->id,
        ]);
		
        // Envoi de la notification email
		Log::info('Envoi de la notification PdfUploaded', [
   			'to' => $user->email,
    		'client_id' => $client->id
		]);

		Notification::route('mail', $user->email)
    		->notify(new \App\Notifications\NewQuestionnaireNotification($client));
        
        return response()->json(['message' => 'Fichier téléchargé avec succès'], 200);
        } catch (\Exception $e) {
            Log::error('Erreur lors du téléchargement', [
                'exception_message' => $e->getMessage(),
                'exception_trace' => $e->getTraceAsString()
            ]);

            return response()->json(['message' => 'Erreur lors du téléchargement', 'error' => $e->getMessage()], 500);
        }
    }
    public function download($filename)
    {
        $path = storage_path('app/private/pdfs/' . $filename);

        if (file_exists($path)) {
            // Trouver le client correspondant
            $client = Client::where('pdf_path', 'pdfs/' . $filename)->first();
            
            // Marquer comme téléchargé si pas encore fait
            if ($client && !$client->downloaded_at) {
                $client->update(['downloaded_at' => now()]);
            }

            // Générer le nom de fichier personnalisé
            if ($client) {
                // Format : \"Questionnaire médical {nom} {prénom} {date} {heure}.pdf\"
                // Date au format français : 23-12-2025
                // Heure au format : HH-MM-SS
                $date = \Carbon\Carbon::parse($client->form_sent_at);
                $downloadName = sprintf(
                    'Questionnaire médical %s %s %s %s.pdf',
                    $client->last_name,
                    $client->first_name,
                    $date->format('d-m-Y'),
                    $date->format('H-i-s')
                );
            } else {
                // Fallback si le client n'est pas trouvé
                $downloadName = $filename;
            }

            return response()->download($path, $downloadName);
        } else {
            return response()->json(['message' => 'Fichier non trouvé'], 404);
        }
    }
    
    public function downloadAttachment($filename)
    {
        $path = storage_path('app/private/attachments/' . $filename);

        if (file_exists($path)) {
            return response()->download($path);
        } else {
            return response()->json(['message' => 'Pièce jointe non trouvée'], 404);
        }
    }
}
