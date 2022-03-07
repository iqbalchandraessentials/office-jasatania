<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Http\Resources\TransactionResource;
use App\Mail\Acceptance;
use App\Mail\Pengajuan;
use App\Models\Branch;
use App\Models\Customer;
use App\Models\Rate;
use App\Models\rCover;
use App\Models\Transactions;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class HosToHostController extends Controller
{

    public function pengajuanPolis(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'branch_code' => 'required',
            'branch_name' => 'required',
            'nomor_identitas' => 'min:10|required',
            'no_pk' => 'min:20|required',
            "nama_peserta" => "required",
            "no_telpon" => "min:9|required",
            "alamat" => "required",
            'jns_kelamin' => "required|in:wanita,pria",
            "periode_awal_asuransi" => "required|date_format:Y-m-d",
            "periode_akhir_asuransi" => "required|date_format:Y-m-d",
            "plafon_kredit" => 'int|required',
        ]);

        // check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $first = $request->tgl_mulai_asuransi;
        $cover = $request->jenis_cover;
        $last = $request->tgl_akhir_asuransi;
        $plafon_kredit = $request->plafon_kredit;


        $data =  $this->coverage($cover, $first, $last, $plafon_kredit);


        $customer = Customer::create([
            'branch_code' => $request->branch_code,
            'branch_name' => $request->branch_name,
            'nomor_identitas' => $request->nomor_identitas,
            'nama_peserta' => $request->nama_peserta,
            'no_telpon' => $request->no_telpon,
            'alamat' => $request->alamat,
            'kode_pos' => $request->kode_pos,
            'jns_kelamin' => $request->jns_kelamin,
            'tanggal_lahir' => $request->tanggal_lahir,
            'tempat_lahir' => $request->tempat_lahir,
            'usia' => $request->usia
        ]);

        $transaction = Transactions::create([
            'customer_id' => $customer->id,
            'produk' => 'GTI',
            'no_pk' => $request->no_pk,
            'jenis_kredit' => $request->jenis_kredit,
            'jenis_cover' => $data['jenis_cover'],
            'periode_awal_asuransi' => $request->periode_awal_asuransi,
            'periode_akhir_asuransi' => $request->periode_akhir_asuransi,
            'periode_asuransi' => $request->periode_asuransi,
            'tanggal_kredit' => $request->tanggal_kredit,
            'plafon_kredit' => $request->plafon_kredit,
            'bayar_premi' => $request->bayar_premi,
            'tgl_bayar_premi' => $request->tgl_bayar_premi,
            'no_bukti_bayar' => $request->no_bukti_bayar,
        ]);

        foreach ($data['r_cover'] as $key => $value) {
            rCover::create([
                'transcation_id' => $transaction->id,
                'rate_code' => $value['code_cover'],
                'rate' => $value['rate'],
                'premium' => $value['premium'],
                'scaling' => $value['scaling'],
                'description' => $value['description'],
                'sdate' => $value['sdate'],
                'edate' => $value['edate'],
            ]);
        };

        Mail::to('iqbalchandra96@gmail.com')->send(
            new Pengajuan(
                [
                    'transaction' => $transaction
                ]
            )
        );

        return ResponseFormatter::success([
            'Keterangan' => 'data berhasil telah kami terima, mohon menunggu persetujuan',
            'no_pk' => $transaction->no_pk,
            'no_polis' => 'N/A',
            'nama_peserta' => $customer->nama_peserta,
            'tgl_input' => date("Y-m-d h:i:s"),
            'tgl_polis' => $transaction->periode_awal_asuransi,
            "link_polis" => "N/A"
        ], 'oke,');
    }


    public function cetak($id)
    {
        $data = Transactions::with(['customer', 'perluasan'])->findOrFail($id);
        dd($data);
        // return $data;
        $pdf = PDF::loadview('cetak', ['data' => $data]);
        return $pdf->stream('laporan-pdf');
    }

    // fungsi persetujuan polis yang di ajukan
    public function akseptasi(Request $request, $id)
    {
        $no_polis = '00' . rand(10, 100) . '/SPPA/X/' . rand(10, 100);
        $item = Transactions::where('no_pk', $id)->with(['customer'])->firstOrFail();
        $validator = Validator::make($request->all(), [
            'akseptasi' => "required|in:Y,N",
        ]);
        // check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        if ($request->akseptasi == 'Y') {
            $message = 'telah kami setujui';
        } else {
            $message = 'belum dapat kami setujui dengan nomor polis : ';
        }

        $item->acceptance = $request->akseptasi;
        $item->no_polis = $no_polis;
        $item->save();


        Mail::to('iqbalchandra96@gmail.com')->send(
            new Acceptance(
                $item,
                $message,

            )
        );

        if ($request->akseptasi == 'Y') {
            return  ResponseFormatter::success(null, 'Polis has Accepted');
        } else {
            return ResponseFormatter::success(null, 'Polish has Decline');
        }
    }

    // fungsi persetujuan polis yang di ajukan
    public function show($id)
    {
        // dd($id);
        $item = Transactions::where('no_pk', $id)->with(['customer'])->firstOrFail();
        return ResponseFormatter::success('oke', [
            'Keterangan' => 'menunggu persetujuan',
            'no_pk' => $item->no_pk,
            'no_polis' => $item->no_polis,
            'nama_peserta' => $item->customer->nama_peserta,
            'tgl_input' => $item->created_at,
            'tgl_polis' => $item->periode_awal_asuransi,
            "link_polis" => $item->link_polis
        ]);
    }

    // cek rate
    public function cekRate(Request $request)
    {
        $first = $request->tgl_mulai_asuransi;
        $cover = $request->jenis_cover;
        $last = $request->tgl_akhir_asuransi;
        $plafon_kredit = $request->plafon_kredit;
        $data =  $this->coverage($cover, $first, $last, $plafon_kredit);
        return ResponseFormatter::success(
            [
                'tgl_mulai_asuransi' => $data['tgl_mulai_asuransi'],
                'tgl_akhir_asuransi' => $data['tgl_akhir_asuransi'],
                'rate' => $data['rate'],
                'premium' => $data['premium'],
                'jenis_cover' => $data['jenis_cover']
            ],
            'oke'
        );
    }

    // function perhitungan premi
    public function coverage($input, $sdate, $edate, $tsi)
    {
        $presentyear = $sdate;
        $awal  = date_create($sdate);
        $akhir = date_create($edate);
        $diff  = date_diff($akhir, $awal);
        $mYear = $diff->y;
        $mDays = $diff->days;
        $data = "";
        if ($input == null) {
            $data = ["FL"];
        } else {
            $data = explode(",", $input);
            array_push($data, "FL");
        }
        $rates = [];
        foreach ($data as $param) {
            $rate = Rate::where('code_cover', $param)->first();
            for ($i = 0; $i < $mYear; $i++) {
                $start  = date("Y-m-d", mktime(0, 0, 0, date("m", strtotime($presentyear)),   date("d", strtotime($presentyear)),   date("Y", strtotime($presentyear)) + $i));
                $end =  date('Y-m-d', strtotime($start . ' + 1 years'));

                $to = Carbon::createFromFormat('Y-m-d', $end);
                $from = Carbon::createFromFormat('Y-m-d', $start);
                $diff_in_days = $to->diffInDays($from);

                //* ($diff_in_days/365)
                $rates[] = [
                    // 'acceptance_id' => $p1,
                    'code_cover' => $rate->code_cover,
                    'rate' => $rate->rate,
                    'scaling' => 0,
                    'premium' => $tsi * $rate->rate / 100,
                    'description' => $rate->description,
                    'sdate' => $start,
                    'edate' => $end,
                    'created_at'    => Carbon::now()
                ];
                // print('['. $start . ' s.d ' . $end.']  ');
                if ($i == $mYear - 1) {
                    if ($diff->m != 0) {
                        $tos = Carbon::createFromFormat('Y-m-d', $edate);
                        $froms = Carbon::createFromFormat('Y-m-d', $end);
                        $diff_in_dayss = $tos->diffInDays($froms);
                        $rates[] = [
                            // 'acceptance_id' => $p1,
                            'code_cover' => $rate->code_cover,
                            'rate' => $rate->rate,
                            'scaling' => 20,
                            'premium' => $tsi * $rate->rate / 100  * 0.2,
                            'description' => $rate->description,
                            'sdate' => $end,
                            'edate' => $edate,
                            'created_at'    => Carbon::now()
                        ];
                        // print('['. $end . ' s.d ' . $edate.']  ');
                    }
                }
            }
        };

        $tPremi = 0;
        $tRate = 0;
        foreach ($rates as $key => $value) {
            $tPremi += $value['premium'];
            $tRate += $value['rate'];
        }
        return $hasil = [
            'tgl_mulai_asuransi' => $sdate,
            'tgl_akhir_asuransi' => $edate,
            'rate' => $tRate,
            'premium' => $tPremi,
            'jenis_cover' => implode(", ", $data),
            'r_cover' => $rates,
        ];
    }


    public function storeBranch(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($request->all(), [
            'branch_code' => 'required',
            'branch_name' => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $input = Branch::create($data);

        return new TransactionResource(true, 'data berhasil di save', $input);
    }
}
