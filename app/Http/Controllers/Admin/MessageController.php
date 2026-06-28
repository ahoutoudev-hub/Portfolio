<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class MessageController extends Controller
{
    public function index(Request $request): View
    {
        $query = Message::orderByDesc('created_at');

        if ($request->filled('statut')) {
            match ($request->statut) {
                'non_lu'   => $query->where('lu', false),
                'lu'       => $query->where('lu', true),
                'important'=> $query->where('important', true),
                'repondu'  => $query->where('repondu', true),
                default    => null,
            };
        }

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('nom',     'like', '%' . $request->search . '%')
                  ->orWhere('prenom','like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%')
                  ->orWhere('sujet', 'like', '%' . $request->search . '%');
            });
        }

        $messages = $query->paginate(15)->withQueryString();

        $stats = [
            'total'      => Message::count(),
            'non_lus'    => Message::where('lu', false)->count(),
            'importants' => Message::where('important', true)->count(),
            'repondus'   => Message::where('repondu', true)->count(),
        ];

        return view('admin.messages.messages_index', compact('messages', 'stats'));
    }

    public function show(Message $message): View
    {
        // Marquer comme lu automatiquement à l'ouverture
        if (!$message->lu) {
            $message->update(['lu' => true, 'lu_le' => now()]);
        }

        // Messages précédent / suivant
        $precedent = Message::where('id', '<', $message->id)->orderByDesc('id')->first();
        $suivant   = Message::where('id', '>', $message->id)->orderBy('id')->first();

        return view('admin.messages.messages_show', compact('message', 'precedent', 'suivant'));
    }

    public function destroy(Message $message): RedirectResponse
    {
        $nom = trim($message->prenom . ' ' . $message->nom);
        $message->delete();

        return redirect()
            ->route('messages.index')
            ->with('toast_success', 'Message de "' . $nom . '" supprimé.');
    }

    public function marquerLu(Message $message)
    {
        $message->update(['lu' => !$message->lu, 'lu_le' => $message->lu ? null : now()]);

        return response()->json([
            'lu'      => $message->lu,
            'message' => $message->lu ? 'Message marqué comme lu.' : 'Message marqué comme non lu.',
        ]);
    }

    public function toggleImportant(Message $message)
    {
        $message->update(['important' => !$message->important]);

        return response()->json([
            'important' => $message->important,
            'message'   => $message->important ? 'Message marqué important.' : 'Marqueur retiré.',
        ]);
    }

    public function marquerRepondu(Message $message)
    {
        $message->update(['repondu' => !$message->repondu]);

        return response()->json([
            'repondu' => $message->repondu,
            'message' => $message->repondu ? 'Marqué comme répondu.' : 'Marqué comme non répondu.',
        ]);
    }

    public function destroyMultiple(Request $request): RedirectResponse
    {
        $request->validate(['ids' => ['required', 'array'], 'ids.*' => ['integer', 'exists:messages,id']]);
        Message::whereIn('id', $request->ids)->delete();

        return back()->with('toast_success', count($request->ids) . ' message(s) supprimé(s).');
    }

    public function marquerTousLus(): RedirectResponse
    {
        Message::where('lu', false)->update(['lu' => true, 'lu_le' => now()]);

        return back()->with('toast_success', 'Tous les messages ont été marqués comme lus.');
    }
}
