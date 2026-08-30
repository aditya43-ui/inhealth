<tr>
    <td>
        <?php 
		if (isset($modRencanaDetail->no_urut)){
			echo CHtml::activeTextField($modRencanaDetail,'['.$i.']no_urut',array('readonly'=>true,'class'=>'span1', 'style'=>'width:20px;')); 
		}else {
			echo CHtml::textField('no_urut',0,array('readonly'=>true,'class'=>'span1 integer2', 'style'=>'width:20px;')); 
		}
			?>
        <?php echo CHtml::activeHiddenField($modRencanaDetail,'['.$i.']rencanggaranpengdet_id',array('readonly'=>true,'class'=>'span1')); ?>
        <?php echo CHtml::activeHiddenField($modRencanaDetail,'['.$i.']subkegiatanprogram_id',array('readonly'=>true,'class'=>'span1')); ?>
        <?php echo CHtml::activeHiddenField($modRencanaDetail,'['.$i.']apprrencanggaran_id',array('readonly'=>true,'class'=>'span1')); ?>
    </td>
    <td>
        <?php echo (!empty($modRencanaDetail->programkerja_kode) ? $modRencanaDetail->programkerja_kode : "") ?>
    </td>
    <td>
        <?php echo (!empty($modRencanaDetail->subprogramkerja_kode) ? $modRencanaDetail->subprogramkerja_kode : "") ?>
    </td>
    <td>
        <?php echo (!empty($modRencanaDetail->kegiatanprogram_kode) ? $modRencanaDetail->kegiatanprogram_kode : "") ?>
    </td>
    <td>
        <?php echo (!empty($modRencanaDetail->subkegiatanprogram_kode) ? $modRencanaDetail->subkegiatanprogram_kode : "") ?>
    </td>
    <td>
        <?php echo (!empty($modRencanaDetail->subkegiatanprogram_nama) ? $modRencanaDetail->subkegiatanprogram_nama : "") ?>
    </td>
    <td>
        <div class="controls">
		<?php $modRencanaDetail->bulanrencana = $format->formatMonthForUser($modRencanaDetail->bulanrencana); ?>
		<?php 
			$this->widget('MyMonthPicker', array(
				'model' => $modRencanaDetail,
				'attribute' => '['.$i.']bulanrencana', 
				'value' => 'bulanrencana', 
				'options'=>array(
					'dateFormat' => Params::MONTH_FORMAT,
				),
				'htmlOptions' => array('readonly' => true,'style'=>'width:80px;'),
			));  
		?>
		</div>
    </td>
    <td>
			<?php echo CHtml::activeTextField($modRencanaDetail,'['.$i.']nilaiygdisetujui',array('class'=>'span2 integer2','style'=>'width:90px;','onkeyup'=>"hitungTotalRevisi(); return $(this).focusNextInputField(event);")); ?>
        <?php echo CHtml::activeHiddenField($modRencanaDetail,'['.$i.']nilaiapprove',array('readonly'=>true,'class'=>'span1')); ?>
    </td>
    <td>
        <a onclick="batalRevisi(this,<?php echo $modRencanaDetail->rencanggaranpengdet_id; ?>,<?php echo $modRencanaDetail->apprrencanggaran_id; ?>);return false;" rel="tooltip" href="javascript:void(0);" title="Klik untuk membatalkan rencana"><i class="icon-form-silang"></i></a>
    </td>
</tr>
