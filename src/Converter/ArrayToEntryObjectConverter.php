<?php
/**
 * Created by PhpStorm.
 * User: a.kooli
 * Date: 19.01.19
 * Time: 07:57
 */

namespace Converter;


use Entity\Entry;

class ArrayToEntryObjectConverter
{
    public function convert(array $input): Entry
    {
        return new Entry($input['content']);
    }

}