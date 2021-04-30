<?php
namespace App\Http\Repositories;
use App\Karyawan;

class KaryawanRepository
{
    protected $karyawan;

    public function __construct(Karyawan $karyawan){
        $this->karyawan = $karyawan;
    }

    public function get(){
        return Karyawan::with([])->get();
    }
    public function save(array $data){
        return Karyawan::create($data);
    }

    public function find($id){
        return Karyawan::find($id);
    }

    public function update($data){
        return Karyawan::update($data);
    }

    public function delete($id){
        return Karyawan::destroy($id);
    }
}










?>