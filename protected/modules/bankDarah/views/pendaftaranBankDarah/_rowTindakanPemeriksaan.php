<tr <?php if(!empty($modTindakan->tindakansudahbayar_id)){?> style="background-color: #00FF00;" <?php } ?>>
    <td>
        <?php echo CHtml::textField('no_urut',0,array('readonly'=>true,'class'=>'span1 integer', 'style'=>'width:20px;')); ?>
    </td>
    <td>
        <span name="[ii][pemeriksaanlab_nama]"><?php echo (!empty($modTindakan->daftartindakan_id) ? (isset($modTindakan->getPemeriksaanLab()->pemeriksaanlab_nama) ? $modTindakan->getPemeriksaanLab()->pemeriksaanlab_nama : $modTindakan->daftartindakan->daftartindakan_nama) : "-") ?></span>
        <?php echo CHtml::activeHiddenField($modTindakan,'['.$i.'][ii]tindakanpelayanan_id',array('readonly'=>true,'class'=>'span1')); ?>
        <?php echo CHtml::activeHiddenField($modTindakan,'['.$i.'][ii]tindakansudahbayar_id',array('readonly'=>true,'class'=>'span1')); ?>
        <?php echo CHtml::activeHiddenField($modTindakan,'['.$i.'][ii]pemeriksaanlab_id',array('readonly'=>true,'class'=>'span1')); ?>
        <?php echo CHtml::activeHiddenField($modTindakan,'['.$i.'][ii]daftartindakan_id',array('readonly'=>true,'class'=>'span1')); ?>
        <?php echo CHtml::activeHiddenField($modTindakan,'['.$i.'][ii]jenistarif_id',array('readonly'=>true,'class'=>'span1')); ?>
		<?php echo CHtml::activeHiddenField($modTindakan,'['.$i.'][ii]persencyto_tind',array('readonly'=>true,'class'=>'span1')); ?>
    </td>
    <td>
        <?php echo CHtml::activeTextField($modTindakan,'['.$i.'][ii]qty_tindakan',array('readonly'=>false,'onkeyup'=>'hitungTotal(this);','class'=>'span1 integer')); ?>
    </td>
    <td>
        <?php echo CHtml::activeTextField($modTindakan,'['.$i.'][ii]satuantindakan',array('readonly'=>true,'class'=>'span1')); ?>
    </td>
    <td>
        <?php echo CHtml::activeTextField($modTindakan,'['.$i.'][ii]tarif_satuan',array('readonly'=>true,'class'=>'span1 integer')); ?>
    </td>
	<td>
		<?php 
		echo CHtml::activeDropDownList($modTindakan,'['.$i.'][ii]cyto_tindakan',array('0'=>'Tidak','1'=>'Ya'),array('onChange'=>"hitungTarifCyto(this);",'class'=>'span1', 'style'=>'width:55px;')); ?>
	</td>
	<td>
		<?php echo CHtml::activeTextField($modTindakan,'['.$i.'][ii]tarif_cyto',array('class'=>'span1 integer', 'style'=>'width:70px;','readonly'=>true,'value'=>$modTindakan->tarifcyto_tindakan)); ?>
	</td>
    <td>
        <?php echo CHtml::activeTextField($modTindakan,'['.$i.'][ii]tarif_tindakan',array('readonly'=>true,'readonly'=>true,'class'=>'span1 integer','style'=>'width:96px')); ?>
    </td>
</tr>

