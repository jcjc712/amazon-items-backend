<?php
namespace App\Models\ThirdPartyItems;
/**
 * Created by PhpStorm.
 * User: juancarlosjosecamacho
 * Date: 11/25/17
 * Time: 00:39
 */
class ThirdPartyFactory
{
    public static function create($service)
    {
        $className = 'App\Models\ThirdPartyItems\\'.$service.'Items';
        if(class_exists($className)===false && $className instanceof ThirdPartyIterface)
        {
            throw new \Exception('No existe servicio '.$service);
        }
        return new $className();
    }
}