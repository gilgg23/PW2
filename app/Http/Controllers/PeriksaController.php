<?php

namespace App\Http\Controllers;

use App\Models\Periksa;
use App\Models\Pasien;
use App\Models\Paramedik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PeriksaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $data_periksa = DB::table('periksa')
        ->leftJoin('pasien', 'periksa.pasien_id', '=', 'pasien.id')
        ->leftJoin('paramedik', 'periksa.dokter_id', '=', 'paramedik.id')
        ->select('periksa.*', 'pasien.nama as nama_pasien', 'paramedik.nama as nama_paramedik')
        ->get();


        $paramediks = Paramedik::all();
        $pasiens = Pasien::all();

        return view('periksa.index', compact('data_periksa','paramediks','pasiens'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $periksa = new Periksa();
        $periksa->tanggal = $request->tanggal;
        $periksa->berat = $request->berat;
        $periksa->tinggi = $request->tinggi;
        $periksa->tensi = $request->tensi;
        $periksa->keterangan = $request->keterangan;
        $periksa->pasien_id = $request->pasien_id;
        $periksa->dokter_id = $request->dokter_id;
        $periksa->save();
        return redirect('periksa');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = DB::table('periksa')
        ->leftJoin('pasien', 'periksa.pasien_id', '=', 'pasien.id')
        ->leftJoin('paramedik', 'periksa.dokter_id', '=', 'paramedik.id')
        ->select('periksa.*', 'pasien.nama as nama_pasien', 'paramedik.nama as nama_paramedik')
        ->get();
        $data_periksa = $data->where('id',$id);
        return view('periksa.detail', compact('data_periksa'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // $data_periksa = DB::table('periksa')->where('id', $id)->get();
        // $pasiens = DB::table('pasien')->get();
        // $paramediks = DB::table('paramedik')->get();
        // return view('periksa.edit', compact('data_periksa','pasiens','paramediks'));

        $data_periksa = DB::table('periksa')->where('id',$id)->get();
        $paramediks = DB::table('paramedik')->get();
        $pasiens = DB::table('pasien')->get();
        return view('periksa.edit', compact('data_periksa','paramediks','pasiens'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $periksa = Periksa::find($request->id);
        $periksa->tanggal = $request->tanggal;
        $periksa->berat = $request->berat;
        $periksa->tinggi = $request->tinggi;
        $periksa->tensi = $request->tensi;
        $periksa->keterangan = $request->keterangan;
        $periksa->pasien_id = $request->pasien_id;
        $periksa->dokter_id = $request->dokter_id;
        $periksa->save();
        return redirect('periksa');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::table('periksa')->where('id',$id)->delete();
        return redirect('periksa');
    }
}
