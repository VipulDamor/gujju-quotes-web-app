<?php

namespace App\Services;

use App\Models\ContactRequest;
use App\Models\ContactRequestLog;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class ContactService
{
    /**
     * Store a new contact request with security and metadata.
     */
    public function createRequest(array $data, string $ip, string $userAgent)
    {
        return DB::transaction(function () use ($data, $ip, $userAgent) {
            $requestId = $this->generateRequestId();

            $contactRequest = ContactRequest::create([
                'request_id' => $requestId,
                'name' => strip_tags($data['name'] ?? null),
                'email' => filter_var($data['email'], FILTER_SANITIZE_EMAIL),
                'phone' => strip_tags($data['phone'] ?? null),
                'category' => $data['category'] ?? 'general',
                'subject' => strip_tags($data['subject']),
                'message' => strip_tags($data['message']),

                // App Info (Trusting provided but sanitizing)
                'app_version' => strip_tags($data['app_version']),
                'platform' => 'android',
                'os_version' => strip_tags($data['os_version']),
                'device_model' => strip_tags($data['device_model']),
                'device_manufacturer' => strip_tags($data['device_manufacturer']),
                'language' => strip_tags($data['language']),
                'country' => strip_tags($data['country']),

                // User context
                'user_id' => $data['user_id'] ?? null,
                'is_logged_in' => isset($data['user_id']) && !empty($data['user_id']),

                // Server generated
                'ip_address' => $ip,
                'user_agent' => $userAgent,
                'api_version' => 'v1',
            ]);

            return $contactRequest;
        });
    }

    /**
     * Update request status/priority and log the action.
     */
    public function updateAdministrativeDetails(ContactRequest $request, array $updates, int $adminId, string $ip)
    {
        return DB::transaction(function () use ($request, $updates, $adminId, $ip) {
            foreach ($updates as $field => $newValue) {
                $oldValue = $request->{$field};

                if ($oldValue != $newValue) {
                    $request->{$field} = $newValue;

                    // Log the change
                    ContactRequestLog::create([
                        'contact_request_id' => $request->id,
                        'admin_id' => $adminId,
                        'action' => "{$field}_changed",
                        'old_value' => $oldValue,
                        'new_value' => $newValue,
                        'ip_address' => $ip
                    ]);
                }
            }

            if (isset($updates['admin_response'])) {
                $request->responded_at = now();
                $request->responded_by = $adminId;
            }

            $request->save();
            return $request;
        });
    }

    /**
     * Generate a professional support reference ID.
     */
    private function generateRequestId(): string
    {
        $datePart = now()->format('Ymd');
        $randomPart = strtoupper(Str::random(6));
        return "CNT-{$datePart}-{$randomPart}";
    }
}
