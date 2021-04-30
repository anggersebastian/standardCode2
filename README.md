<p align="center"><img src="https://laravel.com/assets/img/components/logo-laravel.svg"></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel attempts to take the pain out of development by easing common tasks used in the majority of web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, yet powerful, providing tools needed for large, robust applications. A superb combination of simplicity, elegance, and innovation give you tools you need to build any application with which you are tasked.

## Learning Laravel

Laravel has the most extensive and thorough documentation and video tutorial library of any modern web application framework. The [Laravel documentation](https://laravel.com/docs) is thorough, complete, and makes it a breeze to get started learning the framework.

If you're not in the mood to read, [Laracasts](https://laracasts.com) contains over 900 video tutorials on a range of topics including Laravel, modern PHP, unit testing, JavaScript, and more. Boost the skill level of yourself and your entire team by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for helping fund on-going Laravel development. If you are interested in becoming a sponsor, please visit the Laravel [Patreon page](http://patreon.com/taylorotwell):

- **[Vehikl](http://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[British Software Development](https://www.britishsoftware.co)**
- **[Styde](https://styde.net)**
- [Fragrantica](https://www.fragrantica.com)
- [SOFTonSOFA](https://softonsofa.com/)

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](http://laravel.com/docs/contributions).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell at taylor@laravel.com. All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).

## Perbedaan

~ Crud1 (with repository)
Kelebihan : 
1. lebih simple karena semua logic, validasi, & response berada di controller saja, dan untuk mengakses method query dari model berada di file repository.

contoh source code file controller:
    
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
    }

    public function update($id, Request $request){
        $validator = Validator::make($request->all(),
        [
            'name' => 'required|max:50',
            'phone' => 'required|numeric|min:8|max:11',
            'email' => 'required|email',
            'team' => 'required'
        ]
        );

contoh source code file repository: 
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
1. Dengan banyaknya source code di 1 controller membuat para developer harus membaca dan tracing ke setiap line fungsi. Untuk memastikan yang mana response, validasi dan lain-lain

~ Crud2 (with service & repository)
Kelebihan :
1. Mudah untuk mencari fungsi validasi, response, dan logic karena dipisahkan di file yang berbeda
2. Source code lebih clean dan ringkas

3. Berikut contoh dokumentasi penggunaan service pattern, dengan membuat create update data karyawan di dalam 1 form dan di dalam 1 method service: 

~ 1. Buat route untuk create & edit di 1 method yang mengarah ke form & buat route untuk save data yang mana diarahkan ke 1 method storeData di controller

contoh source code : 

Route::group(['prefix' => 'karyawan', 'as' => 'karyawan'], function () {
    Route::get('/create', 'KaryawanController@formKaryawan')->name('karyawan.form');
    Route::get('/edit/{id?}', 'KaryawanController@formKaryawan')->name('karyawan.edit');
    Route::any('/store/{id?}', 'KaryawanController@storeData')->name('karyawan.storeData');
    Route::post('/update/{id?}', 'KaryawanController@storeData')->name('karyawan.update');
});

~ 2. Buat 1 form yang dimana digunakan untuk meng-create & edit, yang mana di form action dan value nya di beri kondisi

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

~ 3. Buat controller dengan nama method form karyawan. Yang mana method ini akan dipakai untuk mengarahkan ke form. Dan method storeData yang digunakan untuk mengirim data ke file service untuk divalidasi apakah edit atau create. Selain itu di controller method storeData berfungsi untuk mengirim response berupa pesan alert yang bisa dipahami oleh user. Kalau case ini menggunakan function helpers.

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

~ 4. Buat file service yang berfungsi untuk memvalidasi data yang akan di save, apakah update atau create. Jika success untuk find id maka akan dilanjut kan ke method query dari model find yang ada di repository. Jika tidak find id maka akan langsung create new data.

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

~ 5. Tambah method find di file repository in

contoh source code :
    
    public function find($id){
        return Karyawan::find($id);
    }

Kekurangan :
1. Nambah file