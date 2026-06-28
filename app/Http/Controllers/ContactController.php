<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ContactController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'fname'     => ['required', 'string', 'max:100'],
            'lname'     => ['required', 'string', 'max:100'],
            'email'     => ['required', 'email', 'max:255'],
            'telephone' => ['nullable', 'string', 'max:30'],
            'subject'   => ['nullable', 'string', 'max:255'],
            'message'   => ['required', 'string', 'min:20'],
        ]);

        Message::create([
            'prenom'    => $validated['fname'],
            'nom'       => $validated['lname'],
            'email'     => $validated['email'],
            'telephone' => $validated['telephone'] ?? null,
            'sujet'     => $validated['subject'] ?? null,
            'message'   => $validated['message'],
            'ip'        => $request->ip(),
            'lu'        => false,
            'repondu'   => false,
            'important' => false,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Votre message a bien été envoyé. Je vous répondrai sous 24h !',
        ]);
    }
}