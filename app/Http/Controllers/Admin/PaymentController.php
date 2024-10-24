<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tagihan;
use App\Models\Payment;
use Illuminate\Http\Request;
use App\Models\PaymentDetail;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Ramsey\Uuid\Uuid;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($user_id)
    {
        $bulan_now =  Carbon::now()->month;

<<<<<<< HEAD
        $tagihan = Tagihan::where('user_id', $user_id)->where('tunggakan', '>', 0)->get();
=======
        $tagihan = Tagihan::where('tunggakan', '>', 0)
                 ->where('user_id', $user_id)
                 ->get();
>>>>>>> 2f293f0af2b12019c62d7ce3efb0b5ab561f41aa
        $firstBillDate = Carbon::createFromDate(2024, 1, 1);
        $currentDate = Carbon::now();
        $allBulan = [];
        while ($firstBillDate->lte($currentDate)) {
            $allBulan[] = $firstBillDate->copy();
            $firstBillDate->addMonth();
        }

        $denda = $tagihan->sum('denda');
        $tagihanBulanIni = Tagihan::where('user_id', $user_id)->where('bulan', $bulan_now)->first();
        $totalPembayaran = $tagihan->sum('tunggakan') + $denda + $tagihanBulanIni->total_tagihan;

        return view('admin.pages.data-pembayaran.payment',  [
            'tagihan' => $tagihan,
            'allBulan' => $allBulan,
            'denda' => $denda,
            'tagihanBulanIni' => $tagihanBulanIni,
            'totalPembayaran' => $totalPembayaran
        ]);
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
    public function storePayment(Request $request, $id)
    {
        DB::beginTransaction();
        try {

            $lastPaymentCount = Payment::count();
            $newPaymentNumber = $lastPaymentCount + 1;

            $payment = new Payment();
            $payment->tagihan_id = $id;
            $payment->user_id = auth()->user()->id;
            $payment->jenis_pembayaran = $request->jenis_pembayaran;
            $payment->total_pembayaran = preg_replace('/[Rp. ]/', '', $request->total_pembayaran);
            $payment->kode_tagihan = 'Payment-' . $newPaymentNumber;
            $payment->bulan = date('F');
            $payment->tahun = date('Y');
            $payment->save();

            // Log::info('Payment ID after save: ' . $payment->id);

            if (!$payment->id) {
                throw new \Exception('Payment ID is not valid');
            }

            // $paymentId = $payment->id;
            $tagihan = Tagihan::findOrFail($id);
            $tagihan->status = 'tertagih';

            //Proses tunggakan
            if ($request->has('tunggakan')) {
                foreach ($request->input('tunggakan') as $id_tagihan) {
                    $tunggakan = Tagihan::findOrFail($id_tagihan);
                    $tunggakan->tunggakan = 0;
                    $tunggakan->save();

                    $paymentDetail = new PaymentDetail();
                    $paymentDetail->id_payments_detail = (string) Str::uuid();
                    $paymentDetail->payments_id = $payment->id; // Mengambil ID dari payment yang baru dibuat
                    $paymentDetail->payments_detail_type = 'T';
                    $paymentDetail->tagihan_id = $id_tagihan;
                    $paymentDetail->bulan = $tagihan->bulan;
                    $paymentDetail->tahun = $tagihan->tahun;
                    $paymentDetail->total = $tunggakan->total_tagihan;
                    $paymentDetail->save();
                }
            }

            // Proses denda
            if ($request->has('denda') && $request->input('denda')) {
                $tagihan->denda = 0;

                $paymentDetail = new PaymentDetail();
                $paymentDetail->id_payments_detail = (string) Str::uuid();
                $paymentDetail->payments_id = $payment->id;
                $paymentDetail->payments_detail_type = 'D';
                $paymentDetail->tagihan_id = $id_tagihan;
                $paymentDetail->bulan = $tagihan->bulan;
                $paymentDetail->tahun = $tagihan->tahun;
                $paymentDetail->total = $tunggakan->total_tagihan;
                $paymentDetail->save();
            }

            if ($request->has('tagihan_bulan_ini') && $request->input('tagihan_bulan_ini')) {
                $tagihan->total_tagihan = 0;
            }

            if ($request->has('nominal_deposit') && $request->input('nominal_deposit')) {
                $depositAmount = preg_replace('/[Rp. ]/', '', $request->input('nominal_deposit'));
                $tagihan->total_tagihan -= $depositAmount; // Mengurangi total tagihan

                // Menyimpan informasi deposit ke tabel tagihan
                $tagihan->deposit = $depositAmount;
            }


            $tagihan->save();

            DB::commit();

            return response()->json([
                'success' => true,
                'jenis_pembayaran' => $request->jenis_pembayaran,
                'message' => $request->jenis_pembayaran == 'cash'
                    ? 'Pembayaran dengan Cash Berhasil'
                    : 'Pembayaran dengan Transfer Berhasil',
                'redirect_url' => route('data-tagihan.index')
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memproses pembayaran: ' . $e->getMessage(),
            ], 500);
        }
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
}
