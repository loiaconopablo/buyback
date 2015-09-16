<?php if (!empty($model)) { ?>
    <table class="table table-condensed">
        <thead>
        </thead>
        <tbody>
            <tr>
                <th> <strong> Linea </strong></th>
                <th> <strong> Nombre PDV </strong></th>
                <th> <strong> Direccion PDV </strong></th>
                <th> <strong> Provincia PDV </strong></th>
                <th> <strong> Localidad PDV </strong></th>
                <th> <strong> Telefono PDV </strong></th>
                <th> <strong> Mail PDV </strong></th>
                <th> <strong> Referencia</strong></th>
                <th> <strong> Telefono Referencia </strong></th>
                <th> <strong> Mail Referencia </strong></th>
                <th> <strong> Usuario </strong></th>
                <th> <strong> Mail Usuario </strong></th>
            </tr>
            <?php foreach ($model as $row_number => $row): ?>
                <tr>
                    <td><b><?php echo $row_number ?></b></td>

                    <?php foreach ($row as $key => $value): ?>
                        <td>
                            <?php echo $value; ?>
                        </td>
                    <?php endforeach; ?>
                <tr>
                <?php endforeach; ?>
        </tbody>
    </table>
    <?php echo TbHtml::linkButton(Yii::t('app', 'Descargar insertados correctamente'), array('color' => TbHtml::BUTTON_COLOR_PRIMARY, 'size' => TbHtml::BUTTON_SIZE_DEFAULT, 'block' => true, 'url' => array('result'), 'target' => '_blank')); ?>
<?php }else { ?>
    <p> Puntos de Venta y Usuarios creados correctamente </p>
    <?php echo TbHtml::linkButton(Yii::t('app', 'Descargar insertados correctamente'), array('color' => TbHtml::BUTTON_COLOR_PRIMARY, 'size' => TbHtml::BUTTON_SIZE_DEFAULT, 'block' => true, 'url' => array('result'), 'target' => '_blank')); ?>
<?php } ?>
