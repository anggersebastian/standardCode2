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
        $getKaryawan = $this->KaryawanService->getAll();
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
        
        $result['data'] = $this->KaryawanService->storeData($data);

        return redirect()->route('karyawan.index')->with(['success' => 'Data Has Been Added !']);
    }

    public function update(Request $request, $id){
        $data = $request->only([
            'name',
            'email',
            'phone',
            'team'
        ]);

        $result['data'] = $this->KaryawanService->storeData($data, $id); 

        return redirect()->route('karyawan.index')->with(['success' => 'Data Has Been Updated !']);
    }

    public function destroy($id){
        $result['data'] = $this->KaryawanService->deleteId($id);

        return redirect()->route('karyawan.index')->with(['failed' => 'Data Has Been Deleted !']);
    }
}
