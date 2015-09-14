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
