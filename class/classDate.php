<?php
class DateClass
{
    var $day;
    var $month;
    var $year;
    var $totalDayInMonth;
    var $dateVariable;
    function timezone ()
    {
        if (function_exists("date_default_timezone_set") and
         function_exists("date_default_timezone_get")) {
            date_default_timezone_set(@date_default_timezone_get());
        }
    }
    function countTime ($time1, $time2)
    {
        $hour2 = substr($time2, 0, 2);
        $minute2 = substr($time2, 3, 2);
        $hour1 = substr($time1, 0, 2);
        $minute1 = substr($time1, 3, 2);
        $total_hour = $hour2 - $hour1;
        $total_minute = $minute2 - $minute1;
        if ($total_minute < 0) {
            $total_hour --;
            $total_minute = ($minute2 + 60) - $minute1;
        }
        $test = ' ' . $total_hour . ' Hour ' . $total_minute . ' minute ';
        return ($test);
    }
    function countTime2 ($time1, $time2)
    {
        $hour2 = substr($time2, 0, 2);
        $minute2 = substr($time2, 3, 2);
        $hour1 = substr($time1, 0, 2);
        $minute1 = substr($time1, 3, 2);
        $total_hour = $hour2 - $hour1;
        $total_minute = $minute2 - $minute1;
        if ($total_minute < 0) {
            $total_hour --;
            $total_minute = ($minute2 + 60) - $minute1;
        }
        $total = (60 * $total_hour) + $total_minute;
        return ($total);
    }
    function convertDateMysql ($dateVariable)
    {
        $this->dateVariable = $dateVariable;
        $checkLengthDate = strlen($this->dateVariable);
        if ($checkLengthDate == 6) {
            $this->day = substr($this->dateVariable, 6, 2);
            $this->month = substr($this->dateVariable, 4, 2);
            $this->year = substr($this->dateVariable, 0, 4);
        } elseif ($checkLengthDate == 10) {
            $this->day = substr($this->dateVariable, 8, 2);
            $this->month = substr($this->dateVariable, 5, 2);
            $this->year = substr($this->dateVariable, 0, 4);
        }
        return $this->day . "-" . $this->month . "-" . $this->year;
    }
    function ext_date ($dateVariable)
    {
        $this->dateVariable = $dateVariable;
        $checkLengthDate = strlen($this->dateVariable);
        if ($checkLengthDate == 6) {
            $this->day = substr($this->dateVariable, 6, 2);
            $this->month = substr($this->dateVariable, 4, 2);
            $this->year = substr($this->dateVariable, 2, 2);
        } elseif ($checkLengthDate == 10) {
            $this->day = substr($this->dateVariable, 8, 2);
            $this->month = substr($this->dateVariable, 5, 2);
            $this->year = substr($this->dateVariable, 2, 2);
        }
        return $this->month . "/" . $this->day . "/" . $this->year;
    }
    function changeZero ($dateInfo)
    {
        if (strlen($dateInfo) == 1) {
            $dateInfo = '0' . $dateInfo;
        }
        return ($dateInfo);
    }
    /* this function change date FROM day to month to year */
    function forwardDate ($date_receive, $type)
    {
        $this->dateVariable = $date_receive;
        $this->type = $type;
        $checkLengthDate = strlen($this->dateVariable);
        if ($checkLengthDate == 8) {
            $this->day = substr($this->dateVariable, 6, 2);
            $this->month = substr($this->dateVariable, 4, 2);
            $this->year = substr($this->dateVariable, 0, 4);
        } elseif ($checkLengthDate == 10) {
            $this->day = substr($this->dateVariable, 8, 2);
            $this->month = substr($this->dateVariable, 5, 2);
            $this->year = substr($this->dateVariable, 0, 4);
        }
        $this->totalDayInMonth = date('t', 
        mktime('0', '0', '0', $this->month, $this->day, $this->year));
        if ($this->type == 'day') {
            if ($this->day >= $this->totalDayInMonth) {
                $this->day = 1;
                if ($this->month == 12) {
                    $this->year ++;
                    $this->month = 1;
                } else {
                    $this->month = $this->month + 1;
                }
            } else {
                $this->day ++;
            }
            $this->day = $this->changeZero($this->day);
            $this->month = $this->changeZero($this->month);
            $returnDate = trim(
            $this->year . "-" . $this->month . "-" . $this->day);
        } elseif ($this->type == 'week') {
            if ($this->day > $this->totalDayInMonth) {
                $this->day = 1 + 7;
                if ($this->month == 12) {
                    $this->year ++;
                    $this->month = 1;
                } else {
                    $this->month = $this->month + 1;
                }
            } else {
                $this->day = $this->day + 7;
                if ($this->day > $this->totalDayInMonth) {
                    $this->day = $this->day - $this->totalDayInMonth;
                }
            }
            $this->day = $this->changeZero($this->day);
            $this->month = $this->changeZero($this->month);
            $returnDate = trim(
            $this->year . "-" . $this->month . "-" . $this->day);
        } elseif ($this->type == 'month') {
            if ($this->month == 12) {
                $this->year = $this->year + 1;
                $this->month = 1;
            } else {
                $this->month = $this->month + 1;
            }
            $this->month = $this->changeZero($this->month);
            $returnDate = $this->year . "-" . $this->month . "-" . $this->day;
        } elseif ($this->type == 'year') {
            $this->year = $this->year + 1;
            $returnDate = $this->year . "-" . $this->month . "-" . $this->day;
        }
        return ($returnDate);
    }
    function prevDate ($date_receive, $type)
    {
        $this->dateVariable = $date_receive;
        $this->type = $type;
        $checkLengthDate = strlen($this->dateVariable);
        if ($checkLengthDate == 8) {
            $this->day = substr($this->dateVariable, 6, 2);
            $this->month = substr($this->dateVariable, 4, 2);
            $this->year = substr($this->dateVariable, 0, 4);
        } elseif ($checkLengthDate == 10) {
            $this->day = substr($this->dateVariable, 8, 2);
            $this->month = substr($this->dateVariable, 5, 2);
            $this->year = substr($this->dateVariable, 0, 4);
        }
        $this->day = $this->changeZero($this->day);
        if ($this->type == 'day') {
            $this->day = $this->day - 1;
            $this->day = $this->changeZero($this->day);
            if ($this->day == 0) {
                $this->month = $this->month - 1;
                $this->day = date('t', 
                mktime(0, 0, 0, $this->month, 1, $this->year));
                if ($this->month == 0 or $this->month == '00') {
                    $this->day = 31;
                    $this->year = $this->year - 1;
                    $this->month = 12;
                }
            }
            if ($this->month == 2 && $this->day > 27) {
                $this->day = 28;
            }
            $returnDate = $this->year . "-" . $this->month . "-" . $this->day;
        } elseif ($this->type == 'week') {
            $date_day = $this->day;
            $this->day = $this->day - 7;
            $this->day = $this->changeZero($this->day);
            if ($this->day <= 0) {
                $this->month = $this->month - 1;
                $this->month = $this->changeZero($this->month);
                $this->day = date('t', 
                mktime(0, 0, 0, $this->month, 1, $this->year));
                $this->day = $this->day - 7 + $date_day;
                $this->day = $this->changeZero($this->day);
                if ($this->month == 0 or $this->month == '00') {
                    $this->day = 31;
                    $this->year = $this->year - 1;
                    $this->month = 12;
                }
            }
            if ($this->month == 2 && $this->day > 27) {
                $this->day = 28;
            }
            $returnDate = $this->year . "-" . $this->month . "-" . $this->day;
        } elseif ($this->type == 'month') {
            $this->month = $this->month - 1;
            if ($this->month == "0" or $this->month == "00") {
                $this->month = 12;
                $this->year = $this->year - 1;
            }
            $this->month = $this->changeZero($this->month);
            if ($this->month == 2 && $this->day > 27) {
                $this->day = 28;
            }
            $returnDate = $this->year . "-" . $this->month . "-" . $this->day;
        } elseif ($this->type == 'year') {
            $this->year = $this->year - 1;
            $returnDate = $this->year . "-" . $this->month . "-" . $this->day;
        }
        return ($returnDate);
    }
    function addDate ($dateLoop, $type, $counter)
    {
        for ($i = 0; $i < $counter; $i ++) {
            $dateLoop = $this->forwardDate($dateLoop, $type);
        }
        return $dateLoop;
    }
    function subDate ($dateLoop, $type, $counter)
    {
        //echo "tarikh: ".$dateLoop."<br>";
        for ($i = 0; $i < $counter; $i ++) {
            $dateLoop = $this->prevDate($dateLoop, $type);
            echo $dateLoop . "<br>";
        }
        if ($counter == - 1) {
            $dateLoop = $this->forwardDate($dateLoop, $type);
            echo $dateLoop . "<br>";
        }
        return $dateLoop;
    }
    function getWeekInMonth ($date_receive)
    {
        $this->day = substr($date_receive, 6, 2);
        $this->month = substr($date_receive, 4, 2);
        $this->year = substr($date_receive, 0, 4);
        $numberOfWeekFirstMonth = date('W', 
        mktime(0, 0, 0, $this->month, '01', $this->year));
        $numberOfWeek = date('W', 
        mktime(0, 0, 0, $this->month, $this->day, $this->year));
        $date_receive = $numberOfWeek - $numberOfWeekFirstMonth + 1;
        return ($date_receive);
    }
    function day ($date1, $date2)
    {
        $checkLengthDate = strlen($date1);
        if ($checkLengthDate == 6) {
            $day1 = substr($date1, 6, 2);
            $month1 = substr($date1, 4, 2);
            $year1 = substr($date1, 2, 2);
            $day2 = substr($date2, 6, 2);
            $month2 = substr($date2, 4, 2);
            $year2 = substr($date2, 2, 2);
        } elseif ($checkLengthDate == 10) {
            $day1 = substr($date1, 8, 2);
            $month1 = substr($date1, 5, 2);
            $year1 = substr($date1, 0, 4);
            $day2 = substr($date2, 8, 2);
            $month2 = substr($date2, 5, 2);
            $year2 = substr($date2, 0, 4);
        }
        $totalYear = $year2 - $year1;
        if ($totalYear > 1) {
            for ($i = 1; $i < $totalYear; $i ++) {
                $totalDayYear = $totalDayYear + 365;
            }
        } else {
            $totalDayYear = 0;
        }
        $totalMonth = $month2 - $month1;
        if ($totalMonth > 1) {
            for ($i = $month1 ++; $i < month2; $i ++) {
                $totalDayMonth = $totalDayMonth + date('j', $i);
            }
        } else {
            $totalDayMonth = 0;
        }
        if ($day1 > $day2) {
            $totalDay = (date('j', $month1) - $day1) + $day2;
        } else {
            $totalDay = $day2 - $day1;
        }
        $totalDay = $totalDay + $totalDayMonth + $totalDayYear;
        return ($totalDay . " day");
    }
    function firstdayweek ($date)
    {
        $lowEnd = date("w", $date);
        $lowEnd = - $lowEnd;
        $highEnd = $lowEnd + 6;
        $weekday = 0;
        for ($i = $lowEnd; $i <= $highEnd; $i ++) {
            $WeekDate[$weekday] = date("Y-m-d", 
            mktime(0, 0, 0, date("m", $date), date("d", $date) + $i + 1, 
            date("Y", $date)));
            $weekday ++;
        }
        echo $WeekDate[0];
    }
}
?>
