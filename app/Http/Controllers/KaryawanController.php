<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\KaryawanService;
use App\Karyawan;
use App\Http\Repositories\KaryawanRepository;

class KaryawanController extends Controller
{
    protected $KaryawanService;

    public function __construct(KaryawanService $KaryawanService){
        $this->KaryawanService = $KaryawanService;
    }

    public function index(){
        $getKaryawan = Karyawan::get();
        return view('karyawan.index', compact('getKaryawan'));
    }

    // public function edit($id){
    //     $editKaryawan = Karyawan::find($id);
    //     return view('karyawan.edit', compact('id', 'editKaryawan'));
    // }

    public function formKaryawan(Request $request, $id = null){
        if ($id) {
            $getKaryawans = Karyawan::find($id);
            if (!$getKaryawans['status']) {
                alertNotify($getKaryawans['status'], $getKaryawans['message'], $request);
                return redirect(url('karyawan/edit/{id?}'));
            }
            $getKaryawans = $getKaryawans['message'];
        }

        return view('karyawan.form', compact('getKaryawans'));
    }

    public function storeData(request $request, $id = null){
        $result =  $this->KaryawanService->createData($request->all(), $id);

        if (!$result) {
            alertNotify($result['status'], $result['message'], $request);
        } else {
            alertNotify($result['status'], $result['message'], $request);
        }

        return redirect()->route('karyawan.index');
    }

    public function destroy($id){
        $result['data'] = $this->KaryawanService->deleteId($id);
        return redirect()->route('karyawan.index')->with(['failed' => 'Data Has Been Deleted !']);
    }
}
