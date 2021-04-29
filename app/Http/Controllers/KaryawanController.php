<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\KaryawanService;
use App\Karyawan;
use App\Http\Repositories\KaryawanRepository;

class KaryawanController extends Controller
{
    protected $KaryawanService, $KaryawanRepository;

    public function __construct(KaryawanService $KaryawanService, KaryawanRepository $KaryawanRepository){
        $this->KaryawanService = $KaryawanService;
        $this->KaryawanRepository = $KaryawanRepository;
    }

    public function index(){
        $getKaryawan = Karyawan::get();
        return view('karyawan.index', compact('getKaryawan'));
    }
    
    public function formKaryawan(Request $request, $id = null){
        if ($id) {
            $getKaryawan = Karyawan::find($id);
            
            if (!$getKaryawan) {
                alertNotify($getKaryawan['status'], $getKaryawan['message'], $request);
                return redirect(url('karyawan'));
            }
            $getKaryawan = $getKaryawan['message'];
        }

        return view('karyawan.form', compact('getKaryawan'));
    }

    public function storeData(request $request, $id = null){
        $result =  $this->KaryawanService->createData($request->all(), $id);

        if (!$result) {
            alertNotify($result['status'], $result['message'], $request);
        } else {
            alertNotify($result['status'], $result['message'], $request);
        }

        return redirect('karyawan');
    }

    public function destroy($id){
        $this->KaryawanService->deleteId($id);
        return redirect()->back();
    }
}
