<tr>
    <td>
        <?php 
            echo CHtml::activeTextField($modDetailResep, '[ii]tglresep_ok', ['readonly' => true, 'class' => 'span2']); 
            echo CHtml::activeHiddenField($modDetailResep, '[ii]petugasfarmasi_id', ['readonly' => true]); 
            echo CHtml::activeHiddenField($modDetailResep, '[ii]obatalkes_id', ['readonly' => true]); 
            echo CHtml::activeHiddenField($modDetailResep, '[ii]st_fornas', ['readonly' => true]); 
            echo CHtml::activeHiddenField($modDetailResep, '[ii]hargasatuan_reseptur', ['readonly' => true]); 
            echo CHtml::activeHiddenField($modDetailResep, '[ii]sumberdana_id', ['readonly' => true]); 
             
        ?>
    </td>
    <td><?= CHtml::activeTextField($modDetailResep, '[ii]noresep_ok', ['readonly' => true, 'class' => 'span2']) ?></td>
    <td><?= CHtml::activeTextField($modDetailResep, '[ii]nama_pasien', ['readonly' => true, 'class' => 'span2']) ?></td>
    <td><?= CHtml::activeTextField($modDetailResep, '[ii]petugasfarmasi_nama', ['readonly' => true]) ?></td>
    <td><?= CHtml::activeTextField($modDetailResep, '[ii]obatalkes_nama', ['readonly' => true]) ?></td>
    <td>
        <?php echo CHtml::activeTextField($modDetailResep, '[ii]paket_obat', ['readonly' => true]); ?>
    </td>
    <td><?= CHtml::activeTextField($modDetailResep, '[ii]jumlah', ['readonly' => true, 'class' => 'span1']) ?></td>
    <td><?= CHtml::activeTextArea($modDetailResep, '[ii]keterangan', ['readonly' => true]) ?></td>
    <td>
    	<a onclick="batalRowObat(this);return false;" rel="tooltip" href="javascript:void(0);" title="Klik untuk membatalkan penjualan obat alkes ini"><i class="icon-remove"></i></a>
    </td>
</tr>