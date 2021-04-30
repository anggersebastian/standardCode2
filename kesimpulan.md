## Perbedaan

~ Crud1 (with repository)
Kelebihan : 
1. Lebih simple karena semua logic, validasi, & response berada di controller saja, dan untuk mengakses method query dari model berada di file repository.

~ Berikut contoh source code store & update di file controller tanpa service pattern:
    
    public function store(Request $request){
        $validator = Validator::make($request->all(),
        [
            'name' => 'required|max:50',
            'phone' => 'required|numeric|min:8|max:11',
            'email' => 'required|email',
            'team' => 'required'
        ]
        );

        $this->karyawan->store($request->all());
        return redirect()->route('karyawan.index')->with(['success' => 'Data Has Been Added !']);
    };

    public function update($id, Request $request){
        $validator = Validator::make($request->all(),
        [
            'name' => 'required|max:50',
            'phone' => 'required|numeric|min:8|max:11',
            'email' => 'required|email',
            'team' => 'required'
        ]
    );

~ Berikut contoh source code file repository: 

    public function store(array $karyawan){
        return Karyawan::create($karyawan);
    }

    public function get($id){
        return Karyawan::find($id);
    }

    public function update($id, array $karyawan){
        return Karyawan::find($id)->update($karyawan);
    }

	
Kekurangan : 
1. Dengan banyaknya source code di 1 controller membuat para developer harus membaca dan tracing ke setiap line fungsi. Untuk memastikan yang mana response, validasi dan lain-lain.


~ Crud2 (with service & repository)
Kelebihan :
1. Mudah untuk mencari fungsi validasi, response, dan logic karena dipisahkan di file yang berbeda.
2. Source code lebih clean dan ringkas.

3. Berikut contoh dokumentasi penggunaan service pattern, dengan membuat create update data karyawan di dalam 1 form dan di dalam 1 method service: 

~ 1. Buat route untuk create & edit di 1 method yang mengarah ke 1 form. Dan buat route untuk save data yang mana diarahkan ke 1 method service storeData di dalam controller.

contoh source code : 

Route::group(['prefix' => 'karyawan', 'as' => 'karyawan'], function () {
    Route::get('/create', 'KaryawanController@formKaryawan')->name('karyawan.form');
    Route::get('/edit/{id?}', 'KaryawanController@formKaryawan')->name('karyawan.edit');
    Route::any('/store/{id?}', 'KaryawanController@storeData')->name('karyawan.storeData');
    Route::post('/update/{id?}', 'KaryawanController@storeData')->name('karyawan.update');
});

~ 2. Buat 1 form yang digunakan untuk meng-create sekaligus edit, yang mana di form action dan value nya di beri kondisi.

contoh source code: 

<form action="{{ isset($storeKaryawan) ? url('karyawan/update', $storeKaryawan->id) : url('karyawan/store') }}" method="POST">
    {{ csrf_field() }}
    <div class="form-group">
        <label for="name">Name</label>
        <input type="text" class="form-control" name="name" value="{{ isset($storeKaryawan) ? ($storeKaryawan->name ? $storeKaryawan->name : '') : '' }}">
    </div>
    <div class="form-group">
        <label for="exampleFormControlInput1">Email address</label>
        <input type="email" class="form-control" name="email" value="{{ isset($storeKaryawan) ? ($storeKaryawan->email ? $storeKaryawan->email : '') : '' }}">
    </div>
    <div class="form-group">
        <label for="exampleFormControlInput1">Phone</label>
        <input type="number" class="form-control" name="phone" value="{{ isset($storeKaryawan) ? ($storeKaryawan->phone ? $storeKaryawan->phone : '') : '' }}">
    </div>
    <div class="form-group">
        <label>Select Team</label>
        <select class="form-control" name="team">
            <option value="DS">DS</option>
            <option value="IT">IT</option>
            <option value="Operational">Operational</option>
            <option value="Finance">Finance</option>
            <option value="Shipping">Shipping</option>
        </select>
    </div>
    <button class="btn btn-primary" type="submit">Save</button>
</form>

~ 3. Buat controller dengan nama method formKaryawan. Yang mana method ini akan dipakai untuk mengarahkan ke form dengan pengecekan validasi apakah create atau edit. Dan method storeData yang digunakan untuk mengirim data ke file service untuk divalidasi apakah create atau update. Selain itu di controller method storeData berfungsi untuk mengirim response berupa pesan alert yang bisa dipahami oleh user. Kalau case ini menggunakan function helpers.

contoh source code:

    public function formKaryawan(Request $request, $id = null){
        $storeKaryawan = $this->karyawanRepository->find($id);
        return view('karyawan.form', compact('storeKaryawan'));
    }                                   

    public function storeData(request $request, $id = null){
        $result =  $this->karyawanService->createData($request->all(), $id);

        if(isset($result['status']) && $result['message']){
            alertNotify($result['status'], $result['message']);
        }

        return redirect('karyawan');
    }

~ 4. Buat file service yang berfungsi untuk memvalidasi data yang akan di save, apakah create atau update. Jika success untuk find id maka akan dilanjut kan ke method query dari model find yang ada di repository. Jika failed find id, maka akan langsung create new data.

contoh source code:

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

~ 5. Tambah method find di file repository

contoh source code :
    
    public function find($id){
        return Karyawan::find($id);
    }

Kekurangan :
1. Menambahkan file baru