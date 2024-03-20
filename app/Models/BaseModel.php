<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Str;

class BaseModel extends Model
{

    public function toArray()
    {
        $array = parent::toArray();
        $renamed = [];
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $renamed[\Str::camel($key)] = $this->ToCamelCase($value);
            } else {
                $renamed[\Str::camel($key)] = $value;
            }
        }

        return $renamed;
    }

    public function ToCamelCase($array)
    {
        $renamed = [];
        foreach ($array as $key => $value) {
            $renamed[\Str::camel($key)] = $value;
        }

        return $renamed;
    }

    public function getAttribute($key)
    {
        if (array_key_exists($key, $this->relations)) {
            return parent::getAttribute($key);
        } else {
            if($key == 'posTags') {
                return parent::getAttribute($key);
            }

            return parent::getAttribute(Str::snake($key));
        }
    }

    public function setAttribute($key, $value)
    {
        return parent::setAttribute(Str::snake($key), $value);
    }

}
