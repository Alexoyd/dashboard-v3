<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LegalPage;

class LegalPageController extends Controller
{
    public function show($id)
    {
        $legalPage = LegalPage::findOrFail($id);
        return view('legal-pages.show', compact('legalPage'));
    }
}