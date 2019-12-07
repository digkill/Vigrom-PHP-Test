<?php

namespace App\Enum;

use Webmozart\Assert\Assert;

trait EnumTrait
{
    /**
     * Get all existing enum values.
     *
     * @return array|null
     */
    public static function values()
    {
        return array_values(self::extract());
    }


    /**
     * return all constants
     * @return array|null
     */
    public static function list()
    {
        return self::extract();
    }

    /**
     * return all constants with pretty Names
     *
     * @return array|null
     */
    public static function prettyList()
    {
        return self::prettyExtract();
    }

    /**
     * Get enum keys (names).
     *
     * @return array
     */
    public static function names()
    {
        return array_keys(self::extract());
    }

    public static function prettyNames()
    {
        return array_keys(self::prettyExtract());
    }

    /**
     * Get enum key (name) by value.
     *
     * @param int $value
     * @return string
     */
    public static function name($value)
    {
        Assert::integerish($value);
        Assert::true(self::valueExists($value), 'Provided value does not exists in enum class.');

        return array_search($value, self::extract());
    }

    public static function prettyName($value)
    {
        Assert::integerish($value);
        Assert::true(self::valueExists($value), 'Provided value does not exists in enum class.');

        return array_search($value, self::prettyExtract());
    }

    /**
     * Check if enum value exists.
     *
     * @param int $value
     * @return bool
     */
    public static function valueExists($value)
    {
        return in_array($value, self::extract(), true);
    }

    /**
     * Check if enum key (name) exists.
     *
     * @param string $name
     * @param $caseSensitive
     * @return bool
     */
    public static function nameExists($name, $caseSensitive = true)
    {
        Assert::stringNotEmpty($name);
        if (!$caseSensitive) {
            $name = strtoupper($name);
        }

        return array_key_exists($name, self::extract());
    }

    /**
     * Check if enum key (name) exists.
     *
     * @param string $name
     * @param bool $caseSensitive
     * @return bool
     */
    public static function prettyNameExists($name, $caseSensitive = true)
    {
        Assert::stringNotEmpty($name);
        if (!$caseSensitive) {
            $name = title_case($name);
        }

        return array_key_exists($name, self::prettyExtract());
    }

    /**
     *
     * @param $name
     * @param bool $caseSensitive
     * @return mixed
     */
    public static function valueByName($name, $caseSensitive = true)
    {
        if (!$caseSensitive) {
            $name = strtoupper($name);
        }

        Assert::true(self::nameExists($name), 'Invalid name provided.');

        $constants = self::extract();

        return $constants[$name];
    }

    /**
     *
     * @param $name
     * @param bool $caseSensitive
     * @return mixed
     */
    public static function valueByPrettyName($name, $caseSensitive = true)
    {
        if (!$caseSensitive) {
            $name = title_case($name);
        }

        Assert::true(self::prettyNameExists($name), 'Invalid name provided.');

        $constants = self::prettyExtract();

        return $constants[$name];
    }

    /**
     * Extract constants to associative array.
     *
     * @return array
     */
    private static function &extract()
    {
        static $list = null;
        if (!$list) {
            try {
                $reflection = new \ReflectionClass(__CLASS__);
            } catch (\ReflectionException $e) {
                //
            }
            $list = $reflection->getConstants();
        }

        return $list;
    }

    protected static function &prettyExtract()
    {
        static $list = null;

        if (!$list) {
            $list = iterator_to_array(self::prettyFormat());
        }
        return $list;
    }

    private static function prettyFormat()
    {
        foreach (self::extract() as $name => $value) {
            $name = strtolower(str_replace('_', ' ', $name));
            yield title_case($name) => $value;
        }
    }
}