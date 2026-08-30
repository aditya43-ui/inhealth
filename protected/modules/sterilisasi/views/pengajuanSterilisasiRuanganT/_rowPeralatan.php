<?php
/**
 * @author          M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version         2.0.0
 * @documentation   http://kbase..com
 * @issue           RSST-1337
 * - digunakan 
 */
?>
<tr>
    <td>
        <?php echo CHtml::textField('no_urut',0,array('readonly'=>true,'class'=>'span1 integer', 'style'=>'width:20px;')); ?>        
        <?php echo CHtml::activeHiddenField($modDetail,'[ii]peralatansterilisasi_id',array('readonly'=>true,'class'=>'span1 peralatan_id')); ?>
        <?php echo CHtml::activeHiddenField($modDetail,'[ii]jenisperalatan',array('readonly'=>true,'class'=>'span1 peralatan_id')); ?>
    </td>
    <td>
        <?php echo $modDetail->namaPeralatan; ?>
    </td>
    <td>
		<?php echo CHtml::activeTextField($modDetail, '[ii]pengajuansterlilisasidet_jml', array('class'=>'span3 integer','style'=>'text-align:right;')); ?>
	</td>
    <td>
        <?php echo CHtml::activeTextField($modDetail, '[ii]pengajuansterlilisasidet_ket', array('class'=>'span3')); ?>
    </td>
    <td>
        <?php echo CHtml::activeTextField($modDetail, '[ii]keadaanperalatan', array('readonly'=>'true','class'=>'keaadaan')); ?>
    </td>
    <td>
        <a onclick="batalLinen(this);return false;" rel="tooltip" href="javascript:void(0);" title="Klik untuk membatalkan peralatan Sterilisasi "><i class="icon-form-silang"></i></a>
    </td>
</tr>