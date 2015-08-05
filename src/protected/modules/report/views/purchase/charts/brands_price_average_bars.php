<script type="text/javascript">
   google.setOnLoadCallback(drawChart);
    function drawChart() {
      var data = google.visualization.arrayToDataTable([
        ["Marca", "Precio"],
        <?php foreach($precio_promedio_por_marca as $precio_promedio): ?>
          ["<?php echo $precio_promedio->brand; ?>", <?php echo round($precio_promedio->price_average, 2); ?>],
        <?php endforeach; ?>
      ]);

      var view = new google.visualization.DataView(data);
      view.setColumns([0, 1,
                       { calc: "stringify",
                         sourceColumn: 1,
                         type: "string",
                         role: "annotation" }]);

      var options = {
        title: "<?php echo Yii::t('app', 'Precio promedio por marca'); ?>",
        width: 750,
        height: 400,
        bar: {groupWidth: "95%"},
        legend: { position: "none" },
      };
      var chart = new google.visualization.ColumnChart(document.getElementById("columnchart_values"));
      chart.draw(view, options);
  }
</script>
<div id="columnchart_values" style="width: 100%; height: 500px;"></div>