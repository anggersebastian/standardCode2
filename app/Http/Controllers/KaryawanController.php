<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\KaryawanService;
use App\Http\Repositories\KaryawanRepository;

class KaryawanController extends Controller
{
    public function index(){
        return view('karyawan.index');
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
}
