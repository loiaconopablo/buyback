<script type="text/javascript">
  google.setOnLoadCallback(drawBrandPieChart);

  function drawBrandPieChart() {

    var data = google.visualization.arrayToDataTable([
      ['Marca', 'Cantidad'],
      <?php foreach($cantidad_por_marca as $registro): ?>
      	['<?php echo $registro->brand?>', <?php echo $registro->quantity?>],
      <?php endforeach; ?>
    ]);

    var options = {
      title: '<?php echo Yii::t('app', 'Marcas'); ?>'
    };

    var chart = new google.visualization.PieChart(document.getElementById('brands_piechart'));

    chart.draw(data, options);
  }
</script>
<div id="brands_piechart" style="width: 900px; height: 400px;"></div>