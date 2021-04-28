<?php
namespace App\Http\Repositories;
use App\Karyawan;

class KaryawanRepository
{
    protected $karyawan;

    public function __construct(Karyawan $karyawan){
        $this->karyawan = $karyawan;
    }

    public function save(array $data){
        return Karyawan::create($data);
    }

    public function find($data, $id){
        return Karyawan::find($id)->update($data);
    }

    public function delete($id){
        return Karyawan::destroy($id);
    }
}










?>