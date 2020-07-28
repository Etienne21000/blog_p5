<?php
namespace App\Model;

abstract class Entity
{
    public function hydrate($data)
    {
        foreach ($data as $key => $value)
        {
            $method = 'set' .str_replace('_', '', ucwords($key, '_'));
            if(method_exists($this, $method))
            {
                $this->$method($value);

            }
        }
    }
}