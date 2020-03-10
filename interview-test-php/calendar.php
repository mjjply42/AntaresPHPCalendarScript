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
        ],
        2=>[
            "message" => "\033[33m Year cannot be less than 1970.\033[0m\n\n", 
            "suggestion" => "\033[32m---Correct Examples---\n01 2020\n12 1992\n03 209\n----------------------\033[0m\n"
        ],
        3=>[
            "message" => "\033[33m Month has to be 1 - 12.\033[0m\n\n", 
            "suggestion" => "\033[32m---Correct Examples---\n01 2020\n12 1992\n03 209\n----------------------\033[0m\n"
        ]];
    return ($errorHeader.$errorMessages[$code]["message"].$errorMessages[$code]["suggestion"]);
}

function getMonthOutput($month, $year) {
        $start_date = "01-".$month."-".$year;
        $start_time = strtotime($start_date);

        $end_time = strtotime("+1 month", $start_time);

        for ($i = $start_time; $i < $end_time; $i += 86400)
            $list[] = date('Y-m-d-D', $i);
    return ($list);
}

function errorChecker($arg) {
    $error = 0;
    if (count($arg) > 3)
    {
        echo getErrorByCode(0);
        $error++;
    }
    if (count($arg) < 3)
    {
        echo getErrorByCode(1);
        $error++;
    }
    if (((int)$arg[2]) < 1970)
    {
        echo getErrorByCode(2);
        $error++;
    }
    if ((int)$arg[1] <= 0 || ((int)$arg[0]) > 12)
    {
        echo getErrorByCode(3);
        $error++;
    }
    if ($error > 0)
    {
        echo "\033[31mDetected $error error(s) above\033[0m\n";
        return (-1);
    }
    return (1);
}

function formatCalendarDays($firstDay, $monthArray) {
    $dayMatch = ["Sun"=>0, "Mon"=>1, "Tue"=>2, "Wed"=>3, "Thu"=>4, "Fri"=>5, "Sat"=>6];
    $calendarDays = "";
    $emptyDay = "  ";
    $nextDay = " ";
    $beginning = true;
    $day = 1;
    for ($i = 1; $i < (count($monthArray) + $dayMatch[$firstDay] + 1); $i++)
    {
        if ($dayMatch[$firstDay] == ($i -1))
            $beginning = false;
        if ($beginning)
        {
            $calendarDays .= $emptyDay.$nextDay;
            continue;
        }
        if ($day > 9)
            $calendarDays .= $day;
        else
        {
            $calendarDays .= $nextDay;
            $calendarDays .= $day;
        }
        if ($i % 7 == 0 && ($i + 1) < (count($monthArray) + $dayMatch[$firstDay] + 1))
            $calendarDays .= "\n";
        else
            $calendarDays .= $nextDay;
        $day++;
    }
    $calendarDays .= "\n";
    return ($calendarDays);
}

function printCalendar($month, $year, $monthArray) {
    $dash = "--------------------\n";
    $weekNames = "Su Mo Tu We Th Fr Sa\n";
    $dateObj = DateTime::createFromFormat('!m', ((int)$month));
    $monthName = $dateObj->format('F');
    $calendarDate = $monthName." ".$year."\n";
    $firstDay = (explode("-", $monthArray[0]))[3];
    $calendarDays = formatCalendarDays($firstDay, $monthArray);
    echo $dash.$calendarDate.$dash.$weekNames.$dash.$calendarDays.$dash;
    echo "\n\n\n";
}

(function($argv) {
    $error = 0;
    $monthCount = 3;
    $month = $argv[1];
    $year = $argv[2];
    if (errorChecker($argv) == -1)
        return;
    while ($monthCount )
    {
        if ($month > 12)
        {
            $year++;
            $month = 1;
        }
        $monthArray = (getMonthOutput($month, $year));
        printCalendar($month, $year, $monthArray);
        $month++;
        $monthCount--;
    }
})($argv);