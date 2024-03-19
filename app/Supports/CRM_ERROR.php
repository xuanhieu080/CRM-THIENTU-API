<?php

namespace App\Supports;

use App\Supports\FORUM;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CRM_ERROR
{
    public static function handle(\Exception $ex, $table = "unknown")
    {
        $errorCode = $ex->getCode();
        $errorCode = empty($errorCode) ? Response::HTTP_BAD_REQUEST : $errorCode;

        //        if (env('APP_DEBUG', false) == true) {
        //            $request = Request::capture();
        //            $param = $request->all();
        //            $data = [
        //                'server'     => ETC_POS::urlBase(),
        //                'time'       => date("Y-m-d H:i:s", time()),
        //
        //                'param'      => json_encode($param),
        //                'file'       => $ex->getFile(),
        //                'line'       => $ex->getLine(),
        //                'error'      => $ex->getMessage(),
        //            ];
        //
        //            //Write Log
        //        }
        $user_id = auth('api')->id() ?? 0;

        $request = Request::capture();
        $param = $request->all();
        $requestHost = parse_url($request->headers->get('origin'),  PHP_URL_HOST);
        $data = [
            'action'  => 'ERROR',
            'target'  => "Table: $table",
            'ip'      => $_SERVER['REMOTE_ADDR'] ?? 'null',
            //            'browser' => "Parent: $parent - Platform: $platform - Browser: $browser",
            'link'    => url()->current(),
            'domain'  => $requestHost,
            'time'    => date("Y-m-d H:i:s", time()),
            'user_id' => $user_id,
            'param'   => json_encode($param),
            'file'    => $ex->getFile(),
            'line'    => $ex->getLine(),
            'error'   => $ex->getMessage(),
        ];

//        $data = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
//        $html_entity_data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
//
//        \Illuminate\Support\Facades\Log::info($data);

        return ['message' => $ex->getMessage(), 'code' => $errorCode];

    }
}
