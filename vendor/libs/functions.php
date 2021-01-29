<?php

/**
 * Форматированный вывод
 * @param mixed $var
 */
function debug($var)
{
    echo '<pre>' . print_r($var, true) . '</pre>';
}
