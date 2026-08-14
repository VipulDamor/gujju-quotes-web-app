<?php

namespace App\Http\Controllers\Api\V1;

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
     * Handle the contact request from Android app.
     */
    public function store(Request $request)
    {
        // 1. Strict Validation
        $validator = Validator::make($request->all(), [
            'name' => 'nullable|string|max:100',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'category' => 'required|string|in:general,feedback,bug_report,feature_request,account,payment,content,copyright,privacy,other',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|min:10|max:5000',
            'app_version' => 'required|string|max:30',
            'platform' => 'required|string|in:android',
            'os_version' => 'required|string|max:50',
            'device_model' => 'required|string|max:100',
            'device_manufacturer' => 'required|string|max:100',
            'language' => 'required|string|max:20',
            'country' => 'required|string|max:10',
            'user_id' => 'nullable|integer',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Please correct the highlighted fields.',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // 2. Business Logic Execution
            $contact = $this->contactService->createRequest(
                $request->all(),
                $request->ip(),
                $request->header('User-Agent')
            );

            // 3. Structured Success Response
            return response()->json([
                'success' => true,
                'message' => 'Your message has been submitted successfully.',
                'data' => [
                    'request_id' => $contact->request_id
                ]
            ], 201);

        } catch (\Exception $e) {
            // 4. Safe Error Handling (Log internally, show generic to user)
            \Illuminate\Support\Facades\Log::error('Contact Submission Error: ' . $e->getMessage(), [
                'request' => $request->all(),
                'ip' => $request->ip()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Something went wrong. Please try again later.',
                'errors' => (object)[]
            ], 500);
        }
    }
}
