<?php

function responseJson($message, $optional = []): \Illuminate\Http\JsonResponse
{
    $array = [
        'status' => 200,
    ];

    if($message){
        $array['message'] = $message;
    }

    if($optional){
        $array = array_merge($array, $optional);
    }
    return response()->json($array);
}

function storeImage($path, $file)
{
    return \Illuminate\Support\Facades\Storage::put("public/$path", $file);
}

function image($path){
    if($path){
        return config('app.url')."/".str_replace('public/', 'storage/', $path);
    }

    return config('app.url')."/storage/avatar.jpeg";
}

