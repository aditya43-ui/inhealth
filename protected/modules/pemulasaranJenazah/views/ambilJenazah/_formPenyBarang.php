<?php
if (!empty($modPenyBarangs)) {
    foreach ($modPenyBarangs as $i => $penyBarang) { ?>
        <tr>
            <td><?php echo CHtml::activeTextField($penyBarang, "[$i]no_urutbrg", array('class' => 'inputFormTabel span1', 'readonly' => true)); ?></td>
            <td><?php echo CHtml::activeTextField($penyBarang, "[$i]jenisbarang_pasien"); ?></td>
            <td><?php echo CHtml::activeTextField($penyBarang, "[$i]namabarang_pasien"); ?></td>
            <td><?php echo CHtml::activeTextField($penyBarang, "[$i]keadaanbarang_pasien"); ?></td>
            <td>
                <?php
                //            if($removeButton){
                //                echo CHtml::link("<i class='icon-plus'></i>", '#', array('onclick'=>'addPenyBarang(this);return false;','rel'=>'tooltip','title'=>'Klik untuk menambah tindakan')); 
                //                echo "<br>";
                //                echo CHtml::link("<i class='icon-minus'></i>", '#', array('onclick'=>'batalPenyBarang(this);return false;','rel'=>'tooltip','title'=>'Klik untuk membatalkan tindakan'));
                //            } else {
                //                echo CHtml::link("<i class='icon-plus'></i>", '#', array('onclick'=>'addPenyBarang(this);return false;','rel'=>'tooltip','title'=>'Klik untuk menambah tindakan'));
                //            }
                ?>
            </td>
        </tr>
    <?php }
} else { ?>
    <tr>
        <td><?php echo CHtml::activeTextField($modPenyBarang, "[0]no_urutbrg", array('class' => 'inputFormTabel span1', 'readonly' => true)); ?></td>
        <td><?php echo CHtml::activeTextField($modPenyBarang, "[0]jenisbarang_pasien"); ?></td>
        <td><?php echo CHtml::activeTextField($modPenyBarang, "[0]namabarang_pasien", array('class' => 'required')); ?></td>
        <td><?php echo CHtml::activeTextField($modPenyBarang, "[0]keadaanbarang_pasien"); ?></td>
        <td style="width: 60px; text-align: center;">
            <?php
            if ($removeButton) {
                echo CHtml::link("<i class='icon-plus'></i>", '#', array('onclick' => 'addPenyBarang(this);return false;', 'rel' => 'tooltip', 'title' => 'Klik untuk menambah tindakan', 'style' => 'display: inline-block; margin-bottom: 10px;',));
                echo "<br>";
                echo CHtml::link("<i class='icon-minus'></i>", '#', array('onclick' => 'batalPenyBarang(this);return false;', 'rel' => 'tooltip', 'title' => 'Klik untuk membatalkan tindakan'));
            } else {
                echo CHtml::link("<i class='icon-plus'></i>", '#', array('onclick' => 'addPenyBarang(this);return false;', 'rel' => 'tooltip', 'title' => 'Klik untuk menambah tindakan'));
            }
            ?>
        </td>
    </tr>
<?php } ?>