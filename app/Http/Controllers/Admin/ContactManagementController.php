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

        // If no specific status is requested, default to showing only New and In Progress
        if (!$request->filled('status') && !$request->filled('search')) {
            $query->whereIn('status', ['new', 'in_progress']);
        } elseif ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Other Filters
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
            'active' => ContactRequest::active()->whereIn('status', ['new', 'in_progress'])->count()
        ];

        return view('admin.contacts.index', compact('contacts', 'stats'));
    }

    /**
     * Display a listing of resolved/closed requests (The Archive).
     */
    public function resolved(Request $request)
    {
        $query = ContactRequest::active()->whereIn('status', ['resolved', 'closed', 'spam']);

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('request_id', 'LIKE', "%{$request->search}%")
                  ->orWhere('email', 'LIKE', "%{$request->search}%")
                  ->orWhere('name', 'LIKE', "%{$request->search}%");
            });
        }

        $contacts = $query->orderBy('updated_at', 'desc')->paginate(15);

        return view('admin.contacts.resolved', compact('contacts'));
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
