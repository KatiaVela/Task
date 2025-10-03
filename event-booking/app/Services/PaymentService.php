<?php

namespace App\Services;

class PaymentService {
    // simulate payment; accept amount & booking
    public function charge($booking, $amount){
        // simple simulation: if amount < 1000 succeed else random or fail
        if($amount <= 0) return ['status'=>'failed','provider_reference'=>null];
        // Example deterministic mock: succeed 90% of time
        $success = rand(1,100) <= 90;
        return [
            'status' => $success ? 'success':'failed',
            'provider_reference' => 'MOCK-'.uniqid(),
        ];
    }
}
