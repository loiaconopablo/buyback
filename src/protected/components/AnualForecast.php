<?php
class AnualForecast extends CWidget
{
    public $year;

    public function init()
    {
        parent::init();
    }
 
    public function run()
    {
        $view_data = array();

        $view_data['year'] = $this->year;

        for($month = 1; $month <= 12; $month++) {
            $forecasts[$month] = Forecast::model()->getForecastByYearMonth($this->year, $month);

            $fromDate = $this->year . '-' . $month . '-01';
            $toDate = date('Y-m-t', strtotime($fromDate)) . ' 23:59:59';

            $compras[$month] = count(Purchase::model()->getTotalPurchaseBetweenDates($fromDate, $toDate));
        }

        $view_data['forecasts'] = $forecasts;
        $view_data['compras'] = $compras;

        $this->render('application.views.widgets.anual_forecast', array('view_data' => $view_data));
    }
}
