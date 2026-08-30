<tr>
    <td>
        <?php echo CHtml::hiddenField('no_urut',0,array('readonly'=>true,'class'=>'span1 integer', 'style'=>'width:20px;')); ?>
        <?php echo CHtml::activeHiddenField($penerimaan,'[ii]penerimaansterilisasi_id',array('readonly'=>true,'class'=>'span1')); ?>
		<?php echo CHtml::activeHiddenField($penerimaan,'[ii]penerimaansterilisasidet_id',array('readonly'=>true,'class'=>'span1')); ?>
        <?php echo CHtml::activeHiddenField($penerimaan,'[ii]ruangan_id',array('readonly'=>true,'class'=>'span1')); ?>
        <?php echo CHtml::activeHiddenField($penerimaan,'[ii]peralatansterilisasi_id',array('readonly'=>true,'class'=>'span1')); ?>
		<?php echo CHtml::activeCheckBox($penerimaan,'[ii]checklist', array('class'=>'checklist','onclick'=>'setNol(this);')); ?>
    </td>
    <td>
        <span><?php echo (!empty($penerimaan->penerimaansterilisasi_tgl) ? MyFormatter::formatDateTimeForUser($penerimaan->penerimaansterilisasi_tgl) : "") ?>/<br><?php echo (!empty($penerimaan->penerimaansterilisasi_no) ? $penerimaan->penerimaansterilisasi_no : "") ?></span>
    </td>
    <td>
        <span><?php echo (!empty($penerimaan->ruangan_nama) ? $penerimaan->ruangan_nama : "") ?></span>
    </td>
    <td>
        <span><?php echo (!empty($penerimaan->peralatansterilisasi_nama) ? $penerimaan->peralatansterilisasi_nama : "") ?></span>
    </td>
	<td>
        <?php echo CHtml::activeTextField($penerimaan,'[ii]dekontaminasidetail_jml',array('readonly'=>false,'class'=>'span2 integer','style'=>'width:45px;','onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
    </td>
	<?php if(!empty($penerimaan->dekontaminasidetail_id)){ ?>
	<td>
		<ol type="1">
		<?php 
			$modDekontaminasiBahan = STDekontaminasibahanT::model()->findAllByAttributes(array('dekontaminasidetail_id'=>$penerimaan->dekontaminasidetail_id));
			foreach($modDekontaminasiBahan as $a=>$bahan){ ?>
			<li><?php echo $bahan->bahansterilisasi->bahansterilisasi_nama; ?></li>
		<?php } ?>
			</ol>
	</td>
	<?php }else{ ?>
		<td>
			<div style="display:block;">
				<?php echo CHtml::activeDropDownList($penerimaan, '[ii]bahansterilisasi_nama',array(),array('class'=>'fcbkcomplete hide')); ?>
			</div>
		</td>
	<?php } ?>
	<td>
        <?php echo CHtml::activeTextField($penerimaan, '[ii]dekontaminasidetail_lama',array('class'=>'span2')); ?>
    </td>
	<td>
        <?php echo CHtml::activeDropDownList($penerimaan, '[ii]dekontaminasidetail_ket', LookupM::getItems("statusdekontaminasi"),array('style'=>'width:80px;')); ?>
    </td>
</tr>