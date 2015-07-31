<?php
class DateHelper
{
	/**
     * @param  integer mes
     * @param  integer año
     * @return ingeger días hábiles
     */
    public static function getWeekdays($m,$y)
    {
        $lastday = date("t",mktime(0,0,0,$m,1,$y));

        $weekdays=0;

        for($d=29; $d<=$lastday; $d++) {

            $wd = date("w",mktime(0,0,0,$m,$d,$y));

            if($wd > 0 && $wd < 6) {
                $weekdays++;
            }
        }
        return $weekdays+20;
    }

    public static function number_of_working_days($from, $to) {
	    //$workingDays = [1, 2, 3, 4, 5]; # date format = N (1 = Monday, ...)
	    // $holidayDays = ['*-12-25', '*-01-01', '2013-12-23']; # variable and fixed holidays

	    $from = new DateTime($from);
	    $to = new DateTime($to);
	    $to->modify('+1 day');
	    $interval = new DateInterval('P1D');
	    $periods = new DatePeriod($from, $interval, $to);

	    $days = 0;
	    foreach ($periods as $period) {
	        if (!in_array($period->format('N'), $workingDays)) continue;
	        if (in_array($period->format('Y-m-d'), $holidayDays)) continue;
	        if (in_array($period->format('*-m-d'), $holidayDays)) continue;
	        $days++;
	    }
	    return $days;
	}

    /**
     * @return Array con los meses para dropdownlist
     */
    public static function getMonths()
    {
        return array(
                array('month_number' => 1, 'month_name' => 'Enero'),
                array('month_number' => 2, 'month_name' => 'Febrero'),
                array('month_number' => 3, 'month_name' => 'Marzo'),
                array('month_number' => 4, 'month_name' => 'Abril'),
                array('month_number' => 5, 'month_name' => 'Mayo'),
                array('month_number' => 6, 'month_name' => 'Junio'),
                array('month_number' => 7, 'month_name' => 'Julio'),
                array('month_number' => 8, 'month_name' => 'Agosto'),
                array('month_number' => 9, 'month_name' => 'Septiembre'),
                array('month_number' => 10, 'month_name' => 'Octubre'),
                array('month_number' => 11, 'month_name' => 'Noviembre'),
                array('month_number' => 12, 'month_name' => 'Diciembre'),

            );
    }

    /**
     * @param  integer numero del mes
     * @return integer cantidad de dias habiles del año
     */
    public static function getWorkingDaysOfTheMonth($month)
    {

    }
}