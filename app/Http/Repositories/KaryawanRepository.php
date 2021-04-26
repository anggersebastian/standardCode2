<?php
namespace App\Http\Repositories;
use App\Karyawan;

class KaryawanRepository
{
    protected $karyawan;

    public function __construct(Karyawan $karyawan){
        $this->karyawan = $karyawan;
        dd($this->karyawan);
    }

    public function save($data){
        $karyawan = new $this->karyawan;

        $karyawan->name = $data['name'];
        $karyawan->email = $data['email'];
        $karyawan->phone = $data['phone'];
        $karyawan->team = $data['team'];
        $karyawan->save();

        return $karyawan->fresh();
    }
}










?>