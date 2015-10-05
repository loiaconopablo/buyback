<div class="well">
    <table class="table">
        <col width="100">
        <tbody>
            <tr class="info">
                <td><b><?php echo GxHtml::encode($data->getAttributeLabel('id')); ?>:</b></td>
                <td><?php echo GxHtml::link(GxHtml::encode($data->id), array('view', 'id' => $data->id)); ?></td>
            </tr>	
            <tr>
                <td>
                    <b><?php echo GxHtml::encode($data->getAttributeLabel('brand')); ?>:</b>
                </td>
                <td>
                    <?php echo GxHtml::encode($data->brand); ?>
                </td>
            </tr>	
            <tr>
                <td>
                    <b><?php echo GxHtml::encode($data->getAttributeLabel('model')); ?>:</b>
                </td>
                <td>
                    <?php echo GxHtml::encode($data->model); ?>
                </td>
            </tr>	
            <tr>
                <td>
                    <b><?php echo GxHtml::encode($data->getAttributeLabel('movistar_a')); ?>:</b>
                </td>
                <td>
                    <?php echo GxHtml::encode($data->movistar_a); ?>
                </td>
            </tr>	
            <tr>
                <td>
                    <b><?php echo GxHtml::encode($data->getAttributeLabel('personal_a')); ?>:</b>
                </td>
                <td>
                    <?php echo GxHtml::encode($data->personal_a); ?>
                </td>
            </tr>
            <tr>
                <td>
                    <b><?php echo GxHtml::encode($data->getAttributeLabel('claro_a')); ?>:</b>
                </td>
                <td>
                    <?php echo GxHtml::encode($data->claro_a); ?>
                </td>
            </tr>
            <tr>
                <td>
                    <b><?php echo GxHtml::encode($data->getAttributeLabel('libre_a')); ?>:</b>
                </td>
                <td>
                    <?php echo GxHtml::encode($data->libre_a); ?>
                </td>
            </tr>
            <tr>
                <td>
                    <b><?php echo GxHtml::encode($data->getAttributeLabel('movistar_b')); ?>:</b>
                </td>
                <td>
                    <?php echo GxHtml::encode($data->movistar_b); ?>
                </td>
            </tr>	
            <tr>
                <td>
                    <b><?php echo GxHtml::encode($data->getAttributeLabel('personal_b')); ?>:</b>
                </td>
                <td>
                    <?php echo GxHtml::encode($data->personal_b); ?>
                </td>
            </tr>
            <tr>
                <td>
                    <b><?php echo GxHtml::encode($data->getAttributeLabel('claro_b')); ?>:</b>
                </td>
                <td>
                    <?php echo GxHtml::encode($data->claro_b); ?>
                </td>
            </tr>
            <tr>
                <td>
                    <b><?php echo GxHtml::encode($data->getAttributeLabel('libre_b')); ?>:</b>
                </td>
                <td>
                    <?php echo GxHtml::encode($data->libre_b); ?>
                </td>
            </tr>
            <tr>
                <td>
                    <b><?php echo GxHtml::encode($data->getAttributeLabel('bad_refurbish')); ?>:</b>
                </td>
                <td>
                    <?php echo GxHtml::encode($data->bad_refurbish); ?>
                </td>
            </tr>
            <tr>
                <td>
                    <b><?php echo GxHtml::encode($data->getAttributeLabel('bad_irreparable')); ?>:</b>
                </td>
                <td>
                    <?php echo GxHtml::encode($data->bad_irreparable); ?>
                </td>
            </tr>
            
        </tbody>
    </table>

</div>