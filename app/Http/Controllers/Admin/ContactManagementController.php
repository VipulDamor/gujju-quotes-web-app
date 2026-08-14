<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactRequest;
use App\Services\ContactService;
use Illuminate\Http\Request;

class ContactManagementController extends Controller
{
    protected $contactService;

    public function __construct(ContactService $contactService)
    {
        $this->contactService = $contactService;
    }

    /**
     * Display a listing of contact requests with filters.
     */
    public function index(Request $request)
    {
        $query = ContactRequest::active();

        // Filters
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('request_id', 'LIKE', "%{$request->search}%")
                  ->orWhere('email', 'LIKE', "%{$request->search}%")
                  ->orWhere('name', 'LIKE', "%{$request->search}%");
            });
        }

        $contacts = $query->orderBy('created_at', 'desc')->paginate(15);

        $stats = [
            'new' => ContactRequest::active()->where('status', 'new')->count(),
            'total' => ContactRequest::active()->count()
        ];

        return view('admin.contacts.index', compact('contacts', 'stats'));
    }

    /**
     * Display detail view.
     */
    public function show($id)
    {
        $contact = ContactRequest::with(['responder', 'logs.admin'])->findOrFail($id);
        return view('admin.contacts.show', compact('contact'));
    }

    /**
     * Update status, priority or add response.
     */
    public function update(Request $request, $id)
    {
        $contact = ContactRequest::findOrFail($id);

        $validated = $request->validate([
            'status' => 'required|in:new,in_progress,resolved,closed,spam',
            'priority' => 'required|in:low,normal,high,urgent',
            'admin_response' => 'nullable|string',
            'internal_notes' => 'nullable|string',
        ]);

        $this->contactService->updateAdministrativeDetails(
            $contact,
            $validated,
            auth()->id(),
            $request->ip()
        );

        return redirect()->back()->with('success', 'Contact request updated successfully.');
    }

    /**
     * Soft delete.
     */
    public function destroy($id)
    {
        $contact = ContactRequest::findOrFail($id);
        $contact->update([
            'is_deleted' => true,
            'deleted_at' => now()
        ]);

        return redirect()->route('admin.contacts.index')->with('success', 'Request deleted.');
    }
}
