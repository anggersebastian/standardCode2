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

    public function createData($data, $id = null){
        try {
            if($id) {
                $karyawanData = $this->KaryawanRepository->find($data, $id);
                $validator = Validator::make($data, [
                    'name' => 'required|max:50',
                    'phone' => 'required|numeric',
                    'email' => 'required|email',
                    'team' => 'required'
                ]);

                $karyawanData = ['status' => 'success', 'message' => 'Updated Successfully!'];
                if (!$karyawanData) {
                    return returnCustom('Update Not Found!');
                }
            }
            if (!$id) {
                $karyawanData = $this->KaryawanRepository->save($data);
                $karyawanData = ['status' => 'success', 'message' => 'Data Added Successfully!'];
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