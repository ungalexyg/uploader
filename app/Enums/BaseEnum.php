<?php

namespace App\Enums;

use Illuminate\Support\Facades\File;
use ReflectionClass;

/**
 * Base Enum Functions
 * 
 * Enums are classes with constants 
 * which holds values that used in multiple places & related to certain topics 
 * the base enum hold several functions that helps to manage those constants
 */
class BaseEnum
{
    /**
     * getting all of the enum constants (key => value)
     *
     * @return array
     */
    public static function getValues()
    {
        $class = new ReflectionClass(get_called_class());
        return $class->getConstants();
    }

    /**
     * getting all of the enum constants reversed (value => key)
     *
     * @return array
     */
    public static function getKeys()
    {
        return array_flip(self::getValues());
    }

    /**
     * getting an enum value based on its key
     *
     * @param string $value
     * @return string
     */
    public static function getKeyByValue($value)
    {
        $array = self::getKeys();
        if (array_key_exists($value, $array)) {
            return $array[$value];
        } else {
            return null;
        }
    }

    /**
     * getting an enum key based on its value
     *
     * @param string $key
     * @return string
     */
    public static function getValueByKey($key)
    {
        $array = self::getValues();
        if (array_key_exists($key, $array)) {
            return $array[$key];
        } else {
            return null;
        }
    }

    /**
     * check existance of an enum based on its key
     *
     * @param string $key
     * @return boolean
     */
    public static function hasKey($key)
    {
        $array = self::getValues();
        return array_key_exists($key, $array);
    }

    /**
     * check existance of an enum based on its value
     *
     * @param string $value
     * @return boolean
     */
    public static function hasValue($value)
    {
        $array = self::getKeys();
        return array_key_exists($value, $array);
    }

    /**
     * getting all of the enums
     *
     * @return void
     */
    public static function getAllEnums()
    {
        $enums = [];
        $files = File::files(app_path('Enums'));

        foreach ($files as $file) {
            $enum = explode('.', $file->getFilename())[0];
            $class = '\\App\\Enums\\' . $enum;
            class_exists($class) ? $enums[$enum] = $class::getValues() : null;
        }

        return $enums;
    }
}
