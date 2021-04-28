<?php
namespace App\Services;

use App\Http\Repositories\KaryawanRepository;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response;
use invalidArgumentException;

class KaryawanService
{
    protected $KaryawanRepository;
    

    public function __construct(KaryawanRepository $KaryawanRepository){
        $this->KaryawanRepository = $KaryawanRepository;
    }

    public function response(){
        $response = array('status','message' => 'success','Updated Successfull');
    }

    public function getAll(){
        return $this->KaryawanRepository->getAll();
    }

    public function storeData($data){
        $validator = Validator::make($data, [
            'name' => 'required|max:50',
            'phone' => 'required|numeric',
            'email' => 'required|email',
            'team' => 'required'
        ]);

        if ($validator->fails()){
            throw new invalidArgumentException($validator->errors()->first());
        }

        try {
            $result = $this->KaryawanRepository->save($data);
        }   catch (Exception $e) {
            throw new InvalidArgumentException('Failed To Create Data !');
        }
        
        return $result;   
    }

    public function updateData($data, $id = null){
        $validator = Validator::make($data, [
            'name' => 'required|max:50',
            'phone' => 'required|numeric',
            'email' => 'required|email',
            'team' => 'required'
        ]);

        if ($validator->fails()){
            throw new invalidArgumentException($validator->errors()->first());
        }

        try {
            $karyawan = $this->KaryawanRepository->update($data, $id);
        }   catch (Exception $e) {
            DB::rollback();
            Log::info($e->getMessage());

            throw new InvalidArgumentException('Update Failed !');
        }

        DB::commit();
        return $karyawan;
    }

    public function deleteId($id){
        try {
            $karyawan = $this->KaryawanRepository->delete($id);
        }   catch (Exception $e) {
            DB::rollback();
            Log::info($e->getMessage());

            throw new InvalidArgumentException('Failed To Delete Data !');
        }

        DB::commit();
        return $karyawan;
    }
}
?>