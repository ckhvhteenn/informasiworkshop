<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Workshop;
use App\Services\FrontService;
use Illuminate\Http\Request;

class FrontController extends Controller
{
    protected $frontService;

    public function __construct(FrontService $frontService)
    {
        $this->frontService = $frontService;
    }

    public function index()
    {
        $data = $this->frontService->getFrontPageData();
        return view('front.index', $data);
    }

    public function details(Workshop $workshop)
    {
        return view('front.details', compact('workshop'));
    }

    public function category(Category $category)
    {
        return view('front.category', compact('category'));
    }

    // ✅ Tambahan Method Booking
    public function booking(Workshop $workshop)
    {
        return view('front.booking', compact('workshop'));
    }

    public function bookingStore(Request $request, Workshop $workshop)
    {
        // Contoh validasi sederhana
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            // Tambahkan field lain sesuai form
        ]);

        // Simpan ke dalam sistem booking kamu
        // Contoh logika:
        // $booking = Booking::create([...]);

        // Untuk sementara, redirect ke halaman pembayaran atau sukses
        return redirect()->route('front.booking_finished', ['booking_transaction' => 'dummy123']);
    }
}
