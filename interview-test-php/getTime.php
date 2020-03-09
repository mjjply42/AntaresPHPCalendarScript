<?php

function getErrorByCode($code) {
    $errorHeader = "\033[31mERROR:\033[0m";
    $errorMessages = [
        0=>[
            "message" => "\033[33m Too many arguments.\033[0m\n\n", 
            "suggestion" => "\033[32m---Correct Examples---\n01 2020\n12 1992\n03 209\n----------------------\033[0m\n"
        ], 
        1=>[
            "message" => "\033[33m Not enough arguments.\033[0m\n\n", 
            "suggestion" => "\033[32m---Correct Examples---\n01 2020\n12 1992\n03 209\n----------------------\033[0m\n"
        ]];
    return ($errorHeader.$errorMessages[$code]["message"].$errorMessages[$code]["suggestion"]);
}

function getMonthOutput($month, $year) {
    $start_date = "01-".$month."-".$year;
    $start_time = strtotime($start_date);

    $end_time = strtotime("+1 month", $start_time);

    for($i=$start_time; $i<$end_time; $i+=86400)
        $list[] = date('Y-m-d-D', $i);
    return ($list);
}

(function($arg) {

    if (count($arg) > 3)
    {
        echo getErrorByCode(0);
        return;
    }
    if (count($arg) < 3)
    {
        echo getErrorByCode(1);
        return;
    }
    print_r(getMonthOutput($arg[1], $arg[2]));
})($argv);