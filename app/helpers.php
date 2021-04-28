<?php

if (!function_exists('returnCustom')) {
    function returnCustom($message, $status = false)
    {
        return ['status' => $status, 'message' => $message];
    }
}

if (!function_exists('alertNotify')) {
    function alertNotify($isSuccess = true, $message = '', $request)
    {
        if ($isSuccess) {
            $request->session()->flash('alert-class', 'info');
            $request->session()->flash('status', $message);
        } else {
            $request->session()->flash('alert-class', 'danger');
            $request->session()->flash('status', $message);
        }
    }
}

if (!function_exists('nav_url')) {
    function nav_url()
    {
        $user = Sentinel::check();
        $menus = config('menu');
        $newMenu = [];
        $subMenu = [];
        foreach ($menus as $menu) {
            $isActive = false;
            $asHeader = !empty($menu['as']) ? $menu['as'] : null;
            if ($user->hasAccess($asHeader . "*")) {

                if (!empty($menu['sub']) and count($menu['sub']) > 0) {
                    foreach ($menu['sub'] as $sub) {
                        $asSub = !empty($sub['as']) ? $sub['as'] : null;
                        if ($user->hasAccess($asHeader . $asSub . "*")) {
                            $subActive = false;
                            $link = !empty($sub['link']) ? $sub['link'] : null;
                            if (Request::is('backend/' . $link . '/*') or Request::is('backend/' . $link)) {
                                $isActive = true;
                                $subActive = true;
                            }

                            $sub['is_active'] = $subActive;

                            $subMenu[] = $sub;
                        }
                    }
                }

                $menu['is_open'] = $isActive;
                $menu['sub'] = $subMenu;
                $subMenu = [];   // reset

                $newMenu[] = $menu;
            }
        }

        return $newMenu;
    }

    if (!function_exists('to_float')) {
        function to_float($string_number)
        {
            // NOTE: You don't really have to use floatval() here, it's just to prove that it's a legitimate float value.
            $number = floatval(str_replace('.', ',', str_replace(',', '', $string_number)));

            // At this point, $number is a "natural" float.
            return $number;
        }
    }
}

if (!function_exists('getCity')) {
    function getCity()
    {
        $str    = "{\"ambon\":\"Ambon\",\"balikpapan\":\"Balikpapan\",\"banda aceh\":\"Banda Aceh\",\"bandar lampung\":\"Bandar Lampung\",\"bandung\":\"Bandung\",\"bangka belitung\":\"Bangka Belitung\",\"banjar\":\"Banjar\",\"banjarbaru\":\"Banjarbaru\",\"banjarmasin\":\"Banjarmasin\",\"batam\":\"Batam\",\"batu\":\"Batu\",\"bau-bau\":\"Bau-Bau\",\"bekasi\":\"Bekasi\",\"bengkulu\":\"Bengkulu\",\"bima\":\"Bima\",\"binjai\":\"Binjai\",\"bitung\":\"Bitung\",\"blitar\":\"Blitar\",\"bogor\":\"Bogor\",\"bontang\":\"Bontang\",\"bukittinggi\":\"Bukittinggi\",\"cilegon\":\"Cilegon\",\"cimahi\":\"Cimahi\",\"cirebon\":\"Cirebon\",\"denpasar\":\"Denpasar\",\"depok\":\"Depok\",\"dumai\":\"Dumai\",\"garut\":\"Garut\",\"gorontalo\":\"Gorontalo\",\"jakarta\":\"Jakarta\",\"jambi\":\"Jambi\",\"jayapura\":\"Jayapura\",\"jember\":\"Jember\",\"jepara\":\"Jepara\",\"karawang\":\"Karawang\",\"kediri\":\"Kediri\",\"kendari\":\"Kendari\",\"kupang\":\"Kupang\",\"langsa\":\"Langsa\",\"lhokseumawe\":\"Lhokseumawe\",\"lubuklinggau\":\"Lubuklinggau\",\"madiun\":\"Madiun\",\"magelang\":\"Magelang\",\"makassar\":\"Makassar\",\"malang\":\"Malang\",\"manado\":\"Manado\",\"mataram\":\"Mataram\",\"medan\":\"Medan\",\"metro\":\"Metro\",\"mojokerto\":\"Mojokerto\",\"padang\":\"Padang\",\"padang sidempuan\":\"Padang Sidempuan\",\"palangkaraya\":\"Palangkaraya\",\"palembang\":\"Palembang\",\"palopo\":\"Palopo\",\"palu\":\"Palu\",\"pangkalpinang\":\"Pangkalpinang\",\"parepare\":\"Parepare\",\"pasuruan\":\"Pasuruan\",\"pekalongan\":\"Pekalongan\",\"pekanbaru\":\"Pekanbaru\",\"pematangsiantar\":\"Pematangsiantar\",\"pontianak\":\"Pontianak\",\"prabumulih\":\"Prabumulih\",\"probolinggo\":\"Probolinggo\",\"purwokerto\":\"Purwokerto\",\"salatiga\":\"Salatiga\",\"samarinda\":\"Samarinda\",\"semarang\":\"Semarang\",\"serang\":\"Serang\",\"singkawang\":\"Singkawang\",\"sorong\":\"Sorong\",\"surabaya\":\"Surabaya\",\"sukabumi\":\"Sukabumi\",\"surakarta\":\"Surakarta\",\"tangerang\":\"Tangerang\",\"tanjungbalai\":\"Tanjungbalai\",\"tanjungpinang\":\"Tanjungpinang\",\"tarakan\":\"Tarakan\",\"tasikmalaya\":\"Tasikmalaya\",\"tebingtinggi\":\"Tebingtinggi\",\"tegal\":\"Tegal\",\"ternate\":\"Ternate\",\"yogyakarta\":\"Yogyakarta\",\"banyuwangi\":\"Banyuwangi\"}";

        return json_decode($str);
    }
}

if (!function_exists('statusList')) {
    function statusList()
    {
        $list = ['request submitted', 'quoted', 'customer approved', 'customer paid', 'pick up', 'export customs', 'origin port',
            'on the way', 'destination port', 'import custom', 'on the road', 'arrived'];

        return $list;
    }
}

if (!function_exists('previousStatus')) {
    function previousStatus($status)
    {
        $statusList = statusList();
        if (in_array($status, $statusList)) {
            $key = array_search($status, $statusList);
            if (!$key) {
                return '';
            }

            if ($key > 0) {
                $prevKey = $key - 1;
                $prevStatus = $statusList[$prevKey];
                return $prevStatus;
            }
        }

        return '';
    }
}

if (!function_exists('checkProduction')) {
    function checkProduction(){
        if(strpos(url('/'),'https') !== false){
            return true;
        }
        return false;
    }
}

function dumpInvoice($dump)
{
    $result = [
        'flag'              => '',
        'kode_perusahaan'   => '',
        'account_number'    => '',
        'gross_amount'      => '',
        'pdf_url'           => ''
    ];

    $dumpArr    = json_decode($dump, true);
    if (isset($dumpArr['va_numbers'])) {
        $result['flag']             = $dumpArr['va_numbers'][0]['bank'];
        $result['account_number']   = $dumpArr['va_numbers'][0]['va_number'];
        $result['gross_amount']     = $dumpArr['gross_amount'];
        $result['pdf_url']          = $dumpArr['pdf_url'];
    } elseif (isset($dumpArr['permata_va_number'])) {
        $result['flag']             = 'Permata';
        $result['account_number']   = $dumpArr['permata_va_number'];
        $result['gross_amount']     = $dumpArr['gross_amount'];
        $result['pdf_url']          = $dumpArr['pdf_url'];
    }else {
        if(count($dumpArr) > 0){
            $result['flag']             = 'Mandiri';
            $result['account_number']   = isset($dumpArr['bill_key']) ? $dumpArr['bill_key'] : 0;
            $result['gross_amount']     = isset($dumpArr['gross_amount']) ? $dumpArr['gross_amount'] : 0;
            $result['pdf_url']          = isset($dumpArr['pdf_url']) ? $dumpArr['pdf_url'] : 'javascript:;';
            if (!empty($dumpArr['biller_code'])) {
                $result['kode_perusahaan']  = $dumpArr['biller_code'];
            }
        }
    }

    return $result;
}