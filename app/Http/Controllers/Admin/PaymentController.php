<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.pages.data-tagihan.payment-popup');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'tagihan_id' => 'required|exists:tagihans,id_tagihan',
            'amount' => 'required|numeric|min:0',
            'payment_method' => 'required|in:cash,transfer',
        ]);

        // Simpan data pembayaran
        $payment = Payment::create([
            'tagihan_id' => $request->tagihan_id,
            'amount' => $request->amount,
            'payment_method' => $request->payment_method,
        ]);

        // Redirect ke halaman detail pembayaran
        return redirect()->route('payment.detail', ['id' => $payment->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }


    public function processPayment(Request $request)
    {
        // Proses pembayaran
        $request->validate([
            'amount' => 'required|numeric',
            'payment_type' => 'required|string',
        ]);

        // Logika untuk menyimpan pembayaran ke database

        return redirect()->back()->with('success', 'Pembayaran berhasil diproses.');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
