<table class="table table-bordered table-striped table-condensed" id="tableMenuDiet">
    <thead>
        <th>Bahan Menu Diet</th>
        <th>Jumlah</th>
        <th>Satuan</th>
    </thead>
    <tbody>
        <?php
        foreach ($modBahan as $value) {
            $modMenuDiet = MenuDietM::model()->findByPk($value->menudiet_id);
            $modBahan = BahanmakananM::model()->findByPk($value->bahanmakanan_id);
        ?>
            <tr>
                <td><?php echo !empty($modBahan) ? $modBahan->namabahanmakanan : ""; ?></td>
                <td><?php echo $value->jmlbahan; ?></td>
                <td><?php echo $value->satuanbahan; ?></td>
            </tr>
        <?php
        }
        ?>
    </tbody>
</table>