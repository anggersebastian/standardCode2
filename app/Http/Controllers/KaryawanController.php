<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
        if(isset($storeKaryawan['status']) && isset($storeKaryawan['message'])){
            alertNotify($storeKaryawan['status'], $storeKaryawan['message']);
        }

        $storeKaryawan = $this->karyawanRepository->find($id);
        return view('karyawan.form', compact('storeKaryawan'));
    }                                   

    public function storeData(request $request, $id = null){
        $result =  $this->karyawanService->createData($request->all(), $id);
        if(isset($result['status']) && $result['message']){
            alertNotify($result['status'], $result['message']);
        }

        return redirect('karyawan');
    }

    public function destroy(Request $request,$id){
        $result = $this->karyawanService->deleteId($id);
        if(isset($result['status']) && $result['message']){
            alertNotify($result['status'], $result['message'], $request);
        }

        return redirect()->back();
    }
}
