<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Services\PaymentService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PaymentTest extends TestCase
{
    use RefreshDatabase;

    public function test_payment_service_returns_valid_response()
    {
        // Create a booking
        $booking = Booking::factory()->create();
        
        // Create an instance of PaymentService
        $paymentService = new PaymentService();
        
        // Test the charge method
        $result = $paymentService->charge($booking, 100);
        
        // Assert the response structure
        $this->assertArrayHasKey('status', $result);
        $this->assertArrayHasKey('provider_reference', $result);
        $this->assertContains($result['status'], ['success', 'failed']);
    }
}