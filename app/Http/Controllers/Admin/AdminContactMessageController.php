<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\Request;

class AdminContactMessageController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status');
        $search = $request->query('search');

        $query = ContactMessage::query();

        if ($status) {
            $query->where('status', $status);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('company', 'like', "%{$search}%")
                  ->orWhere('subject', 'like', "%{$search}%")
                  ->orWhere('message', 'like', "%{$search}%");
            });
        }

        $messages = $query->latest()->paginate(15)->withQueryString();
        $unreadCount = ContactMessage::unread()->count();

        return view('admin.messages.index', compact('messages', 'status', 'search', 'unreadCount'));
    }

    public function show(ContactMessage $contactMessage)
    {
        if (!$contactMessage->is_read) {
            $contactMessage->update(['is_read' => true]);
        }
        return view('admin.messages.show', ['message' => $contactMessage]);
    }

    public function updateStatus(Request $request, ContactMessage $contactMessage)
    {
        $validated = $request->validate([
            'status' => 'required|in:new,replied,archived',
            'admin_notes' => 'nullable|string',
        ]);

        $contactMessage->update($validated);

        return back()->with('success', 'Message status updated.');
    }

    public function destroy(ContactMessage $contactMessage)
    {
        $contactMessage->delete();
        return redirect()->route('admin.messages.index')->with('success', 'Message deleted.');
    }
}
