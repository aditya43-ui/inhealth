<?php
/**
 * @author          M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version         2.0.0
 * @documentation   http://kbase..com
 * @issue           RSST-1338
 * - digunakan 
 */
?>
<tr>
    <td>
        <?php echo CHtml::textField('no_urut',0,array('readonly'=>true,'class'=>'span1 integer', 'style'=>'width:20px;')); ?>        
        <?php echo CHtml::activeHiddenField($modDetail,'[ii]peralatansterilisasi_id',array('readonly'=>true,'class'=>'span1 peralatan_id')); ?>
        <?php echo CHtml::activeHiddenField($modDetail,'[ii]jenisperalatan',array('readonly'=>true,'class'=>'span1 peralatan_id')); ?>
        <?php echo CHtml::activeHiddenField($modDetail,'[ii]barang_id',array('readonly'=>true,'class'=>'span1 peralatan_id')); ?>
    </td>    
    <td>
        <?php echo $modDetail->namaPeralatan; ?>
    </td>
    <td>
		<?php echo CHtml::activeTextField($modDetail, '[ii]penerimaansterilisasidet_jml', array('class'=>'span3 integer','style'=>'text-align:right;')); ?>
	</td>
    <td>
        <?php echo CHtml::activeTextField($modDetail, '[ii]penerimaansterilisasidet_ket', array('class'=>'span3')); ?>
    </td>
    <td>
        <?php echo CHtml::activeTextField($modDetail, '[ii]keadaanperalatan', array('readonly'=>'true','class'=>'keaadaan')); ?>
    </td>
    <td>
         <?php                         
                echo CHtml::link("<i class='icon-minus'></i>", '#', array('onclick'=>'batalBarang(this);return false;','rel'=>'tooltip','title'=>'Klik untuk membatalkan barang'));            
        ?>
    </td>
</tr>