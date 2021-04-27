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
        $getKaryawan = Karyawan::all();
        return view('karyawan.index', compact('getKaryawan'));
    }

    public function edit($id){
        $editKaryawan = Karyawan::find($id);
        return view('karyawan.edit', compact('id','editKaryawan'));
    }

    public function store(request $request){
        $data = $request->only([    
            'name',
            'email',
            'phone',
            'team'
        ]);
        
        $result = ['status' => 200];
        
        try {
            $result['data'] = $this->KaryawanService->storeData($data);
        }   catch (Exception $e) {
                $result = [
                    'status' => 500,
                    'error' => $e->getMessage()
                ];
        }

        return response()->json($result, $result['status']);
    }

    public function update(Request $request, $id){
        $data = $request->only([
            'name',
            'email',
            'phone',
            'team'
        ]);

        $result = ['status' => 200];

        try {
            $result['data'] = $this->KaryawanService->storeData($data, $id);
        }   catch (Exception $e) {
            $result = [
                'status' => 500,
                'error' => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }

    public function destroy($id){
        $result = ['status' => 200];

        try {
            $result['data'] = $this->KaryawanService->deleteId($id);
        }   catch (Exception $e) {
            $result = [
                'status' => 500,
                'error' => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }
}
