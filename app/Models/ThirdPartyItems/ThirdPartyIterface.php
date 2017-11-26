<?php
namespace App\Models\ThirdPartyItems;
/**
 * Created by PhpStorm.
 * User: juancarlosjosecamacho
 * Date: 11/24/17
 * Time: 23:57
 */
interface ThirdPartyIterface
{
    public function makeRequest($params);
    public function processResponse($response);
}