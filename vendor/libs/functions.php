<?php

/**
 * Распечатывает содрежимое массива
 * @param array $arr массив
 */
function debug($arr)
{
    echo '<pre>' . print_r($arr, true) . '</pre>';
}