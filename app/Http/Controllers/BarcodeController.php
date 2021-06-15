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
        $info = DB::select("EXEC spWebSiparisBarkod ?", [request('barcode')])[0];
        if ((int) $info->KAYITTIP === 1) {
            session()->put('evrakno', $info->EVRAKNO);

            return collect($info);
        }
    }

    public function show(): array
    {
        $data = [];
        $data['orders'] = DB::select('EXEC spWebSiparisHareket ?', [session('evrakno')]);
        $data['products'] = [];
        $data['toplam'] = [];
        foreach ($data['orders'] as $order) {
            $data['toplam'][$order->MALKOD][$order->PALETBILGISI] = 0;
        }
        foreach ($data['orders'] as $order) {
            $data['products'][$order->MALKOD][] = DB::select("EXEC spWebLotHareket ?, ?, ?",
                [session('evrakno'),
                    $order->MALKOD,
                    $order->PALETBILGISI]);
        }

        foreach ($data['products'] as $malkod => $products) {
            foreach ($products as $product) {
                foreach ($product as $item) {
                    $data['toplam'][$malkod][$item->PALETBILGISI] += $item->MIKTAR;
                }
            }
        }

        return $data;
    }

    public function store(): void
    {
        $data = request()->validate([
            'evrakno' => 'required',
            'lotno' => 'required',
        ]);
        DB::insert('EXEC spWebPaletIns ?, ?', [$data['evrakno'], $data['lotno']]);
    }

    public function destroy(string $evrak_no, string $lot_no, string $palet): void
    {
        dd($palet);
        DB::delete('EXEC spWebPaletSil ?, ?, ?', [$evrak_no, $lot_no, $palet]);
    }
}
