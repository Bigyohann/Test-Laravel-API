<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Response;

class ApiController extends Controller
{
    function getApiInformation(): array
    {
       return [
           'version' => '0.1',
           'author' => 'Yohann BIGLIA'
       ];
    }

    /**
     * Normal Api Reponse formater
     * @param $data
     * @param $message
     * @param int $statusCode
     * @return mixed
     */
    protected function apiResponse( $message, $data = null, $statusCode = 200) {
        if ($data) {
            return response(['data' => $data, 'message'=>  $message], $statusCode);
        }
        return response(['message'=> $message], $statusCode);
    }

    /**
     * Error Api formater
     * @param $error
     * @param $statusCode
     * @return Application|ResponseFactory|Response
     */
    protected function errorApiReponse($error, $statusCode) {
            return response(['error' => $error], $statusCode);
    }
}
