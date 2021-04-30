<?php

if (!function_exists('returnCustom')) {
    function returnCustom($message, $status = false)
    {
        return ['message' => $message, 'status' => $status,];
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
