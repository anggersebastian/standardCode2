<?php
namespace App\Services;

use App\Http\Repositories\KaryawanRepository;
use Exception;
use illuminate\Support\Facades\DB;
use illuminate\Support\Facades\Log;
use illuminate\Support\Facades\Validator;
use invalidArgumentException;

class KaryawanService
{
    protected $karyawanRepository;

    public function __construct(KaryawanRepository $karyawanRepository){
        $this->karyawanRepository = $karyawanRepository;
    }

    public function storeData($data){
        $validator = Validator::make($data, [
            'name' => 'required|max:50',
            'phone' => 'required|numeric|min:8|max:11',
            'email' => 'required|email',
            'team' => 'required'
        ]);

        if ($validator->fails()){
            throw new ValidationException($validator->errors()->first());
        }

        $result = $this->karyawanRepository->save($data);

        return $result;
    }
}
?>