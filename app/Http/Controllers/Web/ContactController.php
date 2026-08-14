<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\ContactService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    protected $contactService;

    public function __construct(ContactService $contactService)
    {
        $this->contactService = $contactService;
    }

    /**
     * Show the contact form.
     */
    public function show()
    {
        return view('contact');
    }

    /**
     * Handle the contact form submission.
     */
    public function submit(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'category' => 'required|string|in:general,feedback,bug_report,feature_request,other',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|min:10|max:5000',
        ]);

        // Map web data to service structure (providing defaults for app-specific fields)
        $data = $request->all();
        $data['app_version'] = 'web-v1';
        $data['platform'] = 'web';
        $data['os_version'] = 'n/a';
        $data['device_model'] = 'Browser';
        $data['device_manufacturer'] = 'n/a';
        $data['language'] = app()->getLocale();
        $data['country'] = 'n/a';

        try {
            $contact = $this->contactService->createRequest(
                $data,
                $request->ip(),
                $request->header('User-Agent')
            );

            return redirect()->back()->with('success', 'Your message has been sent successfully. Support ID: ' . $contact->request_id);

        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Web Contact Submission Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong. Please try again later.')->withInput();
        }
    }
}
