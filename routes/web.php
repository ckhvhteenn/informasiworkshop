<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\FrontController;
use Illuminate\Support\Facades\Route;

Route::get('/' , [FrontController::class, 'index'])->name('front.index');

Route::get('/category/{category:slug}' , [FrontController::class, 'category'])->name('front.category');

Route::get('/workshop/{workshop:slug}' , [FrontController::class, 'details'])->name('front.details');

Route::get('/check-booking' , [BookingController::class, 'checkBooking'])->name('front.check_booking');
Route::post('/check-booking/details' , [BookingController::class, 'checkBookingDetails'])->name('front.check_booking_details');

Route::get('/booking/payment' , [BookingController::class, 'payment'])->name('front.payments');
Route::post('/booking/payment' , [BookingController::class, 'paymentStore'])->name('front.payments_store');

Route::get('/booking/{workshop:slug}' , [BookingController::class, 'booking'])->name('front.booking');
Route::post('/booking/{workshop:slug}' , [BookingController::class, 'bookingStore'])->name('front.booking_store');

Route::get('/booking/finished/{booking_transaction}' , [BookingController::class, 'bookingFinished'])->name('front.booking_finished');