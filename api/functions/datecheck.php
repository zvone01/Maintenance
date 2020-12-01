<?php

function day_check($date)
{
    $currentDay = DateTime::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s'));

    if($date->format('Y-m-d') == $currentDay->format('Y-m-d'))
         return 1;
    
    return 0;

}

function month_check($date)
{
    $currentDay = DateTime::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s'));

    if($date->format('Y-m') == $currentDay->format('Y-m'))
         return 1;
    
    return 0;

}