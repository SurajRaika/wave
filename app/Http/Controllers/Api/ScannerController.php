<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class ScannerController extends Controller
{
    /**
     * Scan business card images and extract information.
     */
    public function scan(Request $request)
    {
        // 1. Rate Limiting to prevent abuse (60 requests per minute per user)
        $userId = auth()->id();
        $executed = RateLimiter::attempt(
            'scan-card:' . $userId,
            $perMinute = 60,
            function() {
                // The actual logic is inside the return below
            }
        );

        if (!$executed) {
            return response()->json([
                'message' => 'Too many scanning requests. Please try again later.'
            ], 429);
        }

        // 2. Validation
        $request->validate([
            'front_image' => 'required|image|max:10240', // Max 10MB
            'back_image' => 'nullable|image|max:10240',
            'event_name' => 'nullable|string|max:255',
        ]);

        try {
            // 3. Store Images
            $frontPath = $request->file('front_image')->store('business_cards/front', 'public');
            $backPath = $request->hasFile('back_image') 
                ? $request->file('back_image')->store('business_cards/back', 'public') 
                : null;

            // 4. Call external OCR service (Mocking the external app call)
            // Replace with your actual external OCR app URL
            // $ocrResult = $this->callExternalOCR(Storage::disk('public')->path($frontPath));
            
            // For now, let's mock the result we expect from your external OCR app
            $extractedData = [
                'first_name' => 'John',
                'last_name' => 'Doe',
                'email' => 'john.doe@example.com',
                'phone' => '+1234567890',
                'job_title' => 'Product Manager',
                'company_name' => 'Tech Solutions Inc.',
                'notes' => 'Met at ' . ($request->event_name ?? 'Networking Event'),
            ];

            // 5. Save Company
            $company = null;
            if (!empty($extractedData['company_name'])) {
                $company = Company::firstOrCreate([
                    'name' => $extractedData['company_name']
                ]);
            }

            // 6. Save Contact
            $contact = Contact::create([
                'user_id' => $userId,
                'company_id' => $company ? $company->id : null,
                'first_name' => $extractedData['first_name'],
                'last_name' => $extractedData['last_name'],
                'email' => $extractedData['email'],
                'phone' => $extractedData['phone'],
                'job_title' => $extractedData['job_title'],
                'business_card_front' => $frontPath,
                'business_card_back' => $backPath,
                'event_name' => $request->event_name,
                'date_of_creation' => now(),
                'notes' => $extractedData['notes'],
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Contact extracted and saved successfully.',
                'data' => [
                    'contact' => $contact->load('company'),
                ]
            ], 201);

        } catch (\Exception $e) {
            // Log error
            \Log::error('Scanning Error: ' . $e->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => 'Failed to process business card.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Placeholder for the actual external OCR call.
     */
    private function callExternalOCR($filePath)
    {
        // Example logic for calling your external app
        /*
        $response = Http::attach(
            'image', file_get_contents($filePath), 'card.jpg'
        )->post('https://your-external-ocr-app.com/api/v1/extract');

        return $response->json();
        */
        
        return [];
    }
}
