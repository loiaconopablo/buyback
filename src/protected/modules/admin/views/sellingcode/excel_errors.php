
<table class="table table-condensed">
    <thead>
    </thead>
    <tbody>
        <tr>
            <th> <strong> Linea </strong></th>
            <th> <strong> Marca </strong></th>
            <th> <strong> Modelo </strong></th>
            <th> <strong> Libre A </strong></th>
            <th> <strong> Movistar A </strong></th>
            <th> <strong> Personal A </strong></th>
            <th> <strong> Claro A </strong></th>
            <th> <strong> Libre B </strong></th>
            <th> <strong> Movistar B </strong></th>
            <th> <strong> Personal B </strong></th>
            <th> <strong> Claro B </strong></th>
            <th> <strong> BAD Refabricado </strong></th>
            <th> <strong> BAD Irreparable </strong></th>
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
