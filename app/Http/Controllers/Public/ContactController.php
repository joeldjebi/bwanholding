<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreContactMessageRequest;
use App\Models\ContactMessage;
use App\Models\Setting;

class ContactController extends Controller
{
    public function index()
    {
        return view('public.contact', [
            'seo' => ['title' => 'Contact - BWAN HOLDING', 'description' => 'Contactez BWAN HOLDING pour une demande commerciale, média, partenariat, recrutement ou support.'],
            'settings' => Setting::query()->pluck('valeur', 'cle'),
        ]);
    }

    public function store(StoreContactMessageRequest $request)
    {
        ContactMessage::create($request->validated());

        return back()->with('success', 'Merci. Votre message a été transmis aux équipes BWAN HOLDING.');
    }
}
