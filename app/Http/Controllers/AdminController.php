<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LegalPage;
use App\Models\User;
use App\Models\Client;
use App\Models\ApiKey;
use App\Models\EmailTemplate;
use App\Models\Setting;

class AdminController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();
        $totalClients = Client::count();
        $totalLegalPages = LegalPage::count();
        $totalEmailTemplates = EmailTemplate::count();
        
        return view('admin.index', compact('totalUsers', 'totalClients', 'totalLegalPages', 'totalEmailTemplates'));
    }

    public function legalPagesIndex()
    {
        $legalPages = LegalPage::all();
        return view('admin.legal-pages.index', compact('legalPages'));
    }

    public function legalPagesCreate()
    {
        return view('admin.legal-pages.create');
    }

    public function legalPagesStore(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        LegalPage::create($request->all());

        return redirect()->route('admin.legal-pages.index')->with('success', 'Page créée avec succès');
    }

    public function legalPagesEdit(LegalPage $legalPage)
    {
        return view('admin.legal-pages.edit', compact('legalPage'));
    }

    public function legalPagesUpdate(Request $request, LegalPage $legalPage)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $legalPage->update($request->all());

        return redirect()->route('admin.legal-pages.index')->with('success', 'Page mise à jour avec succès');
    }

    public function legalPagesDestroy(LegalPage $legalPage)
    {
        $legalPage->delete();
        return redirect()->route('admin.legal-pages.index')->with('success', 'Page supprimée avec succès');
    }

    public function clientsList()
    {
        $users = User::with(['clients', 'apiKeys'])->get();
        return view('admin.clients.index', compact('users'));
    }
    
    // ===== GESTION DES TEMPLATES D'EMAILS =====

    public function emailTemplatesIndex()
    {
        $emailTemplates = EmailTemplate::orderBy('display_name')->get();
        return view('admin.email-templates.index', compact('emailTemplates'));
    }

    public function emailTemplatesCreate()
    {
        return view('admin.email-templates.create');
    }

    public function emailTemplatesStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:email_templates,name',
            'display_name' => 'required|string|max:200',
            'subject' => 'required|string|max:255',
            'content' => 'required|string',
            'description' => 'nullable|string',
            'available_variables' => 'nullable|string',
            'is_active' => 'nullable|boolean'
        ]);

        // Traiter les variables disponibles
        $availableVariables = [];
        if ($request->available_variables) {
            $variables = explode(',', $request->available_variables);
            $availableVariables = array_map('trim', $variables);
        }

        EmailTemplate::create([
            'name' => $request->name,
            'display_name' => $request->display_name,
            'subject' => $request->subject,
            'content' => $request->content,
            'description' => $request->description,
            'available_variables' => $availableVariables,
            'is_active' => $request->has('is_active') ? true : false
        ]);

        return redirect()->route('admin.email-templates.index')->with('success', 'Template d\'email créé avec succès');
    }

    public function emailTemplatesEdit(EmailTemplate $emailTemplate)
    {
        return view('admin.email-templates.edit', compact('emailTemplate'));
    }

    public function emailTemplatesUpdate(Request $request, EmailTemplate $emailTemplate)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:email_templates,name,' . $emailTemplate->id,
            'display_name' => 'required|string|max:200',
            'subject' => 'required|string|max:255',
            'content' => 'required|string',
            'description' => 'nullable|string',
            'available_variables' => 'nullable|string',
            'is_active' => 'boolean'
        ]);

        // Traiter les variables disponibles
        $availableVariables = [];
        if ($request->available_variables) {
            $variables = explode(',', $request->available_variables);
            $availableVariables = array_map('trim', $variables);
        }

        $emailTemplate->update([
            'name' => $request->name,
            'display_name' => $request->display_name,
            'subject' => $request->subject,
            'content' => $request->content,
            'description' => $request->description,
            'available_variables' => $availableVariables,
            'is_active' => $request->has('is_active')
        ]);

        return redirect()->route('admin.email-templates.index')->with('success', 'Template d\'email mis à jour avec succès');
    }

    public function emailTemplatesDestroy(EmailTemplate $emailTemplate)
    {
        $emailTemplate->delete();
        return redirect()->route('admin.email-templates.index')->with('success', 'Template d\'email supprimé avec succès');
    }

    // ===== GESTION DES PARAMÈTRES SMTP =====

    public function settingsIndex()
    {
        $smtpSettings = [
            'mail_mailer' => Setting::get('mail_mailer', env('MAIL_MAILER', 'log')),
            'mail_host' => Setting::get('mail_host', env('MAIL_HOST', '')),
            'mail_port' => Setting::get('mail_port', env('MAIL_PORT', '587')),
            'mail_username' => Setting::get('mail_username', env('MAIL_USERNAME', '')),
            'mail_password' => Setting::get('mail_password', env('MAIL_PASSWORD', '')),
            'mail_encryption' => Setting::get('mail_encryption', env('MAIL_ENCRYPTION', 'tls')),
            'mail_from_address' => Setting::get('mail_from_address', env('MAIL_FROM_ADDRESS', 'hello@example.com')),
            'mail_from_name' => Setting::get('mail_from_name', env('MAIL_FROM_NAME', 'Laravel')),
        ];
        
        return view('admin.settings.index', compact('smtpSettings'));
    }

    public function settingsUpdate(Request $request)
    {
        $request->validate([
            'mail_mailer' => 'required|in:log,smtp,sendmail,array',
            'mail_host' => 'nullable|string|max:255',
            'mail_port' => 'nullable|integer|min:1|max:65535',
            'mail_username' => 'nullable|string|max:255',
            'mail_password' => 'nullable|string|max:255',
            'mail_encryption' => 'nullable|in:tls,ssl,null',
            'mail_from_address' => 'required|email|max:255',
            'mail_from_name' => 'required|string|max:255',
        ]);

        // Sauvegarder les paramètres en base
        Setting::set('mail_mailer', $request->mail_mailer, 'string', 'smtp', 'Driver de mail');
        Setting::set('mail_host', $request->mail_host, 'string', 'smtp', 'Serveur SMTP');
        Setting::set('mail_port', $request->mail_port, 'integer', 'smtp', 'Port SMTP');
        Setting::set('mail_username', $request->mail_username, 'string', 'smtp', 'Nom d\'utilisateur SMTP');
        Setting::set('mail_password', $request->mail_password, 'string', 'smtp', 'Mot de passe SMTP');
        Setting::set('mail_encryption', $request->mail_encryption ?: null, 'string', 'smtp', 'Encryption SMTP');
        Setting::set('mail_from_address', $request->mail_from_address, 'string', 'smtp', 'Adresse expéditeur');
        Setting::set('mail_from_name', $request->mail_from_name, 'string', 'smtp', 'Nom expéditeur');

        return redirect()->route('admin.settings.index')->with('success', 'Paramètres SMTP mis à jour avec succès');
    }

    // ===== MISE À JOUR GOOGLE ANALYTICS ID =====

    public function updateGoogleAnalyticsId(Request $request, User $user)
    {
        $request->validate([
            'google_analytics_id' => 'nullable|string|max:50',
        ]);

        $user->update([
            'google_analytics_id' => $request->google_analytics_id,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Google Analytics ID mis à jour avec succès'
        ]);
    }
}