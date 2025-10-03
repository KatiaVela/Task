<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\EventController;
use App\Http\Controllers\Api\TicketController;
use App\Http\Controllers\Api\BookingController;
use App\Http\Controllers\Api\PaymentController;
// Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Public event routes
Route::get('/events', [EventController::class, 'index']);
Route::get('/events/{event}', [EventController::class, 'show']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    // Other protected routes here
    Route::post('/events', [EventController::class, 'store']);
    Route::put('/events/{event}', [EventController::class, 'update']);
    Route::delete('/events/{event}', [EventController::class, 'destroy']);
    // ... other protected routes
        Route::delete('/events/{event}', [EventController::class, 'destroy']);

        // Ticket management
        Route::post('/events/{event}/tickets', [TicketController::class, 'store']);
        Route::put('/tickets/{ticket}', [TicketController::class, 'update']);
        Route::delete('/tickets/{ticket}', [TicketController::class, 'destroy']);
    });

    // Customer routes
    Route::middleware(['role:customer'])->group(function () {
        // Bookings
        Route::post('/tickets/{ticket}/bookings', [BookingController::class, 'store'])
            ->middleware('prevent.double.booking');
        
        Route::get('/bookings', [BookingController::class, 'index']);
        Route::put('/bookings/{booking}/cancel', [BookingController::class, 'cancel']);
        
        // Payments
        Route::post('/bookings/{booking}/payment', [PaymentController::class, 'processPayment']);
        Route::get('/payments/{payment}', [PaymentController::class, 'show']);
    });

    // Admin routes
    Route::middleware(['role:admin'])->group(function () {
        Route::apiResource('events', EventController::class)->except(['index', 'show', 'store', 'update', 'destroy']);
        Route::apiResource('tickets', TicketController::class)->except(['index', 'show', 'store', 'update', 'destroy']);
        Route::apiResource('bookings', BookingController::class)->only(['index']);
    });

