<?php
namespace App\Services;

use App\Http\Repositories\KaryawanRepository;
use Exception;
use Illuminate\Support\Facades\Log;
use invalidArgumentException;

class KaryawanService
{
    protected $KaryawanRepository;
    
    public function __construct(KaryawanRepository $KaryawanRepository){
        $this->KaryawanRepository = $KaryawanRepository;
    }

    public function createData($data, $id = null){
        try {
            if($id) {
                $karyawanData = $this->KaryawanRepository->find($data, $id);
                if (!$karyawanData) {
                    return returnCustom('Update Not Found!');
                }
            }
            if (!$id) {
                $karyawanData = $this->KaryawanRepository->save($data);
            }

            return $karyawanData;

            } catch (Exception $e) {
                return $e->getMessage();
                return returnCustom('Err code CMP - MPS: ' . $e->getMessage());
            }
    }

    public function deleteId($id){
        try {
            $karyawan = $this->KaryawanRepository->delete($id);
        }   catch (Exception $e) {
            Log::info($e->getMessage());

            throw new InvalidArgumentException('Failed To Delete Data !');
        }
        return $karyawan;
    }
}
?>