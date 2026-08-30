<tr>
    <td>
        <?php echo CHtml::textField('no_urut',0,array('readonly'=>true,'class'=>'span1 integer', 'style'=>'width:20px;')); ?>
    </td>
    <td>
        <span name="[ii][operasi_nama]"> <?php echo isset($modRencanaOperasi->operasi_nama) ? $modRencanaOperasi->operasi_nama : ""; ?></span>
        <?php echo CHtml::activeHiddenField($modRencanaOperasi,'[ii]rencanaoperasi_id',array('readonly'=>true,'class'=>'span1')); ?>
        <?php echo CHtml::activeHiddenField($modRencanaOperasi,'[ii]operasi_id',array('readonly'=>true,'class'=>'span1')); ?>
        <?php echo CHtml::activeHiddenField($modRencanaOperasi,'[ii]daftartindakan_id',array('readonly'=>true,'class'=>'span1')); ?>
        <?php echo CHtml::activeHiddenField($modRencanaOperasi,'[ii]jenistarif_id',array('readonly'=>true,'class'=>'span1')); ?>
        <?php echo CHtml::activeHiddenField($modRencanaOperasi,'[ii]persencyto_tind',array('readonly'=>true,'class'=>'span1')); ?>
    </td>
    <td>
        <?php echo CHtml::activeTextField($modRencanaOperasi,'[ii]qty_tindakan',array('readonly'=>false,'onkeyup'=>'hitungTotal(this);','class'=>'span1 integer', 'style'=>'width:25px;')); ?>
    </td>
    <td>
        <?php echo CHtml::activeTextField($modRencanaOperasi,'[ii]satuantindakan',array('readonly'=>true,'class'=>'span1', 'style'=>'width:50px;')); ?>
    </td>
    <td hidden>
        <?php echo CHtml::activeTextField($modRencanaOperasi,'[ii]tarif_satuan',array('readonly'=>true,'class'=>'integer span1', 'style'=>'width:70px;')); ?>
    </td>
    <td hidden>
        <?php echo CHtml::activeTextField($modRencanaOperasi,'[ii]tarif_tindakan',array('readonly'=>true,'readonly'=>true,'class'=>'span1 integer', 'style'=>'width:70px;')); ?>
    </td>
	<td hidden>
		<?php 
		echo CHtml::activeDropDownList($modRencanaOperasi,'[ii]cyto_tindakan',array('0'=>'Tidak','1'=>'Ya'),array('onChange'=>"hitungTarifCyto(this);",'class'=>'span1', 'style'=>'width:55px;')); ?>
	</td>
	<td hidden>
		<?php echo CHtml::activeTextField($modRencanaOperasi,'[ii]tarif_cyto',array('class'=>'span1integer', 'style'=>'width:70px;','readonly'=>true)); ?>
	</td>
</tr>

