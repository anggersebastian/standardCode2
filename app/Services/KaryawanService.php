<?php
namespace App\Services;

 use App\Http\Repositories\karyawanRepository; 
 use Exception;
 use App\Karyawan;
 use Illuminate\Support\Facades\Log; 
 use Illuminate\Support\Facades\Validator; 

class KaryawanService
{
    protected $karyawanRepository;
    
    public function __construct(KaryawanRepository $karyawanRepository){
        $this->karyawanRepository = $karyawanRepository;
    }

    public function createData($request, $id = null){
        try { 
            $validator = Validator::make($data, [
                'name' => 'required|max:50',
                'phone' => 'required|numeric',
                'email' => 'required|email',
                'team' => 'required'
            ]);
            
            if ($validator->fails()){
                return returnCustom($validator->errors()->first());
            }

            $findKaryawan = $this->karyawanRepository->find($id);

            if(!$id) {
                $findKaryawan = new Karyawan();
            }
            $findKaryawan->name = $request['name'];
            $findKaryawan->email = $request['email'];
            $findKaryawan->phone = $request['phone'];
            $findKaryawan->team = $request['team'];
            $findKaryawan->save();

            return returnCustom('Success to save', true);
            } catch (Exception $e) {
                Log::error('This error messsage is from method createData, Log: ' . $e->getMessage());
                return returnCustom('Sorry can not store right now !');
            }
    }

    public function deleteId($id){
        try {
            $karyawan = $this->KaryawanRepository->find($id);
            if(!$karyawan){
                return returnCustom('user not found!');
            }
            $karyawan->delete();
            return returnCustom('success deleted data!');
            
            } catch (Exception $e) {
            Log::info('error while delete data karyawan, message: '. $e->getMessage());
            return returnCustom('Failed To Delete Data !');
            }
    }
}
?>