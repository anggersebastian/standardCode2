<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Karyawan;
use App\Services\karyawanService;
use App\Http\Repositories\karyawanRepository;

class KaryawanController extends Controller
{
    protected $karyawanService, $karyawanRepository;

    public function __construct(KaryawanService $karyawanService, KaryawanRepository $karyawanRepository){
        $this->karyawanService = $karyawanService;
        $this->karyawanRepository = $karyawanRepository;
    }

    public function index(){
        $getKaryawan = $this->karyawanRepository->get();
        return view('karyawan.index', compact('getKaryawan'));
    }
    
    public function formKaryawan(Request $request, $id = null){
        $storeKaryawan = $this->karyawanService->createData($request, $id);
        alertNotify($storeKaryawan['status'], $storeKaryawan['message']);

        return view('karyawan.form', compact('storeKaryawan'));
    }

    public function storeData(request $request, $id = null){
        $result =  $this->karyawanService->createData($request->all(), $id);
        
        if (!$result) {
            alertNotify($result['status'], $result['message'], $request);
        } else {
            alertNotify($result['status'], $result['message'], $request);
        }

        return redirect('karyawan');
    }

    public function destroy($id){
        $this->karyawanService->deleteId($id);
        return redirect()->back();
    }
}
