<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookingRequest;
use App\Http\Requests\StoreCheckBookingRequest;
use App\Http\Requests\StorePaymentRequest;
use App\Models\Workshop;
use App\Services\BookingService;
use Illuminate\Support\Facades\Log;

class BookingController extends Controller
{
    protected $bookingService;

    public function __construct(BookingService $bookingService)
    {
        $this->bookingService = $bookingService;
    }

    public function booking(Workshop $workshop)
    {
        return view('booking.booking', compact('workshop'));
    }

    public function bookingStore(StoreBookingRequest $request, Workshop $workshop)
    {
        $validated = $request->validated();
        //dd($validated); 
        $validated['workshop_id'] = $workshop->id;

        try {
            $this->bookingService->storeBooking($validated);
            return redirect()->route('booking.payment');
        } catch (\Exception $e) {
            Log::error('Booking creation failed: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Unable to create booking. Please try again.']);
        }
    }

    public function payment()
    {
        $sessionData = $this->bookingService->getBookingDetails();
        //dd($sessionData); // Tambahkan ini
    
        if (!$sessionData) {
            return redirect()->route('front.index');
        }
    
        return view('booking.payment', $sessionData);
    }
    

    public function paymentStore(StorePaymentRequest $request)
    {
        $validated = $request->validated();

        try {
            $bookingTransactionId = $this->bookingService->finalizeBookingAndPayment($validated);
            return redirect()->route('front.booking_finished', $bookingTransactionId);
        } catch (\Exception $e) {
            Log::error('Payment storage failed: ' . $e->getMessage());
            return redirect()->back()->withErrors([
                'error' => 'Unable to store payment details. Please try again.'
            ]);
        }
    }

    public function bookingFinished($bookingTransactionId)
    {
        return view('booking.booking_finished', compact('bookingTransactionId'));
    }

    public function checkBooking()
    {
        return view('booking.my_booking');
    }

    public function checkBookingDetails(StoreCheckBookingRequest $request, $bookingId)
    {
        $validated = $request->validated();

        $bookingDetails = $this->bookingService->getBookingDetails($validated);

        if ($bookingDetails) {
            return view('booking.my_booking_details', [
                'myBookingDetails' => $bookingDetails
            ]);
        }

        return redirect()->route('front.check_booking')->withErrors([
            'error' => 'Transaction not found.'
        ]);
    }
}
