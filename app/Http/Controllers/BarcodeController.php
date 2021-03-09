<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class BarcodeController extends Controller
{
    // OU0064381 => Evrak Barkodu
    //
    // 6BB00003001 - 6BB00003031 => Paketteki urun
    public function index()
    {
        $data = [];
        $data['orders'] = collect([]);
        $info = collect(DB::select("EXEC spWebSiparisBarkod ?", [request('barcode')])[0]);
        if ($info['KAYITTIP'] === 1) {
            $data['company'] = $info;
            $data['orders'] = collect(DB::select('EXEC spWebSiparisHareket ?', [request('barcode')]));

            return $data;
        }
        if ($info['KAYITTIP'] === 2) {
            $data['products'] = $info;

            return $data;
        }
    }

    public function store()
    {
        $data = request()->validate([
            'evrakno' => 'required',
            'lotno' => 'required',
        ]);

        DB::insert('EXEC spWebSiparisIns ? ?', [$data['evrakno'], $data['lotno']]);

    }
}
