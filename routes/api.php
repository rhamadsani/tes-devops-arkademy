<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/idnic/resource/listIDNICResource', function(){
    return [
        'ipv4' => [

        ],
        'ipv6' => [
            
        ],
        'asn' => [
            
        ]
    ];
});
Route::post('/idnic/resource/isIDNICResource', function(Request $request){
    
    function validateType($collections){
        $type = ['ipv4', 'ipv6', 'asn'];

        foreach($collections as $key => $data){
            if(!in_array($key, $type)){
                return [
                    'status' => false,
                    'message' => 'Unprocessable Entity',
                    'code' => 422
                ];
            }
        }
        return [
            'status' => true, 
        ];
    }

    function checkIp($dataCollections){
        //database action
        $dummy = [
            'ipv4' => [

            ],
            'ipv6' => [
                
            ],
            'asn' => [
                
            ]
        ];
        $newCollections = [];
        foreach($dataCollections as $key =>  $collections){
            // dd($key);
            if(is_array($collections)){
                foreach($collections as $data){
                    $status = in_array($data,$dummy[$key]);
                    $newCollections[$key][]=[
                        $key => $data,
                        'isIDNICResource' => $status,
                    ];
                }
            }else{
                $status = in_array($collections,$dummy[$key]);
                $newCollections[$key] = [
                    $key => $collections,
                    'isIDNICResource' => $status,
                ];
            }

        }
        return $newCollections;
    }
 
    $checkType = validateType($request->all());
    if(!$checkType['status'] || count($request->all()) == 0){
        return response()->json([
            isset($checkType['message'])? $checkType['message']:'Unprocessable Entity'
        ], isset($checkType['code'])? $checkType['code']:422);
    }
  
    $data = checkIp($request->all());
    // var_dump($data);
    return response()->json($data);
});