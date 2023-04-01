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
