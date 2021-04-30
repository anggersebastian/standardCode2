<?php
namespace App\Services;

 use App\Http\Repositories\karyawanRepository; 
 use Exception; 
 use Illuminate\Support\Facades\DB; 
 use Illuminate\Support\Facades\Log; 
 use Illuminate\Support\Facades\Validator; 
 use Illuminate\Support\Facades\Response; 
 use invalidArgumentException;

class KaryawanService
{
    protected $karyawanRepository;
    
    public function __construct(KaryawanRepository $karyawanRepository){
        $this->karyawanRepository = $karyawanRepository;
    }

    public function createData($request, $id = null){
        try {
            $findKaryawan = $this->karyawanRepository->find($id);
            
            $validator = Validator::make($data, [
                'name' => 'required|max:50',
                'phone' => 'required|numeric',
                'email' => 'required|email',
                'team' => 'required'
            ]);
            
            if ($validator->fails()){
                throw new invalidArgumentException($validator->errors()->first());
            }
            $findKaryawan = $this->karyawanRepository->update($data);

            if(!$id) {
                $findKaryawan = new Karyawan();
                dd($findKaryawan);
                $findKaryawan->name = $request['name'];
                $findKaryawan->email = $request['email'];
                $findKaryawan->phone = $request['phone'];
                $findKaryawan->team = $request['team'];
                $findKaryawan->save();

                // return returnCustom('Success to save', true);
            }
            } catch (Exception $e) {
                Log::error('This error messsage is from method createData, Log: ' . $e->getMessage());
                // return returnCustom('Sorry can not store right now !');
            }
    }

    public function deleteId($id){
        try {
            $deleteKaryawan = $this->karyawanRepository->delete($id);
            } catch (Exception $e) {
            Log::info($e->getMessage());
            throw new InvalidArgumentException('Failed To Delete Data !');
            }
            
            return $deleteKaryawan;
    }
}
?>