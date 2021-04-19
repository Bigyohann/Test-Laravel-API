<?php

namespace App\Http\Controllers;

class ApiBaseController extends Controller
{
    function getApiInformation(): array
    {
       return [
           'version' => '0.1',
           'author' => 'Yohann BIGLIA'
       ];
    }
}
