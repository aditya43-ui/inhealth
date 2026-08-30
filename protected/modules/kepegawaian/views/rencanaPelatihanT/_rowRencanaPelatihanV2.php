<?php
if (empty($model->rencanadiklat_id)) :
?>

<tr>
    <td>
            <div style="display:none;" class="tambahRow">
            <?php echo CHtml::link("<i class='icon-plus'></i>", '#', array('onclick'=>'addRowPelatihan(this);return false;','rel'=>'tooltip','title'=>'Klik untuk menambahkan rencana pelatihan')); ?>
            </div>
            <div style="display:none;" class="hapusRow">
            <?php echo CHtml::link("<i class='icon-minus'></i>", '#', array('onclick'=>'hapusPelatihan(this);return false;','rel'=>'tooltip','title'=>'Klik untuk membatalkan rencana pelatihan')); ?>
            </div>
    </td>
    <td>
        <?php echo CHtml::textField('no_urut','1',array('readonly'=>true,'class'=>'span1 integer', 'style'=>'width:20px;')); ?>
	</td>
    <td>
        <?php echo CHtml::activeTextField($model,'[0]nomorindukpegawai',array('readonly'=>true,'class'=>'span3','style'=>'width:140px;')); ?>
    </td>
	<td>
		<?php echo  CHtml::activeHiddenField($model, '[0]pegawai_id',array('readonly'=>true,'class'=>'pegawai_id')); ?>
		<?php
		$this->widget('MyJuiAutoComplete', array(
			'model'=>$model,
			'attribute' => '[0]pegawai_nama',
			'source' => 'js: function(request, response) {
							   $.ajax({
								   url: "' . $this->createUrl('AutocompletePegawai') . '",
								   dataType: "json",
								   data: {
									   term: request.term,
								   },
								   success: function (data) {
										   response(data);
								   }
							   })
							}',
			'options' => array(
				'showAnim' => 'fold',
				'minLength' => 3,
				'focus' => 'js:function( event, ui ) {
					$(this).val(ui.item.label);
					return false;
				}',
				'select' => 'js:function( event, ui ) {
					setPegawai($(this), ui.item);
					return false;
				}',
			),
			'tombolDialog'=>array("idDialog"=>'dialogPegawai','jsFunction'=>"setDialog(this);"),
			'htmlOptions'=>array('class'=>'span2 required','onkeypress'=>"return $(this).focusNextInputField(event)"),
		));
		?>
	</td>		
        <td>
            <?php echo CHtml::activeHiddenField($model,'[0]jabatan_id',array('readonly'=>true,'class'=>'span3','style'=>'width:140px;')); ?>
            <?php echo CHtml::activeTextField($model,'[0]jabatan_nama',array('readonly'=>true,'class'=>'span3','style'=>'width:140px;')); ?>
        </td>
        <td class="internal_pelatihan_anti">
            <?php echo CHtml::activeTextField($model,'[0]biaya_pelatihan',array('onkeyup'=>'hitungTotal()','readonly'=>false,'class'=>'span2 integer2','style'=>'text-align:right;')); ?>
        </td>
        <td class="internal_pelatihan_anti">
            <?php echo CHtml::activeTextField($model,'[0]biaya_transportasi',array('onkeyup'=>'hitungTotal()','readonly'=>false,'class'=>'span2 integer2','style'=>'text-align:right;')); ?>
        </td>        
        <td class="internal_pelatihan_anti">
            <?php echo CHtml::activeTextField($model,'[0]biaya_penginapan',array('onkeyup'=>'hitungTotal()','readonly'=>false,'class'=>'span2 integer2','style'=>'text-align:right;')); ?>
        </td>        
        <td class="internal_pelatihan_anti">
            <?php echo CHtml::activeTextField($model,'[0]biaya_perjalanandinas',array('onkeyup'=>'hitungTotal()','readonly'=>false,'class'=>'span2 integer2','style'=>'text-align:right;')); ?>
        </td>        
        <td class="internal_pelatihan_anti">
            <?php echo CHtml::activeTextField($model,'[0]biaya_lainlain',array('onkeyup'=>'hitungTotal()','readonly'=>false,'class'=>'span2 integer2','style'=>'text-align:right;')); ?>
        </td>        
        <td class="internal_pelatihan_anti">
            <?php echo CHtml::activeTextArea($model,'[0]keterangan_lainlain',array('rows'=>4,'cols'=>15,'readonly'=>false,'class'=>'autogrow span3','style'=>'width:140px;')); ?>
        </td>        
         <td class="internal_pelatihan_anti">
            <?php echo CHtml::activeTextField($model,'[0]total',array('readonly'=>true,'class'=>'span2 integer2','style'=>'text-align:right;')); ?>
        </td> 
</tr>

<?php else : ?>

<?php
	$model->pegawai_id = $model->pegawai_id;
	$model->pegawai_nama = $model->pegawai->nama_pegawai;
	$model->nomorindukpegawai = $model->pegawai->nomorindukpegawai;
	//$modPegawaiDiklat->jenisdiklat_nama = $modRencanaDiklat->jenisdiklat->jenisdiklat_nama;		
	$model->jabatan_id = $model->jabatan_id;
	$model->jabatan_nama = isset($model->jabatan_id)?$model->jabatan->jabatan_nama:null;	
	$model->biaya_pelatihan = MyFormatter::formatNumberForPrint($model->biaya_pelatihan);
	$model->biaya_transportasi = MyFormatter::formatNumberForPrint($model->biaya_transportasi);
	$model->biaya_penginapan = MyFormatter::formatNumberForPrint($model->biaya_penginapan);
	$model->biaya_perjalanandinas = MyFormatter::formatNumberForPrint($model->biaya_perjalanandinas);
	$model->biaya_lainlain = MyFormatter::formatNumberForPrint($model->biaya_lainlain);
	$model->keterangan_lainlain = $model->keterangan_lainlain;
	$model->total = MyFormatter::formatNumberForPrint($model->total);
	?>
<tr>
  <td>
        <div style="display:none;" class="tambahRow">
        <?php echo CHtml::link("<i class='icon-plus'></i>", '#', array('onclick'=>'addRowPelatihan(this);return false;','rel'=>'tooltip','title'=>'Klik untuk menambahkan rencana pelatihan')); ?>
        </div>
        <div class="hapusRow">
        <?php echo CHtml::link("<i class='icon-minus'></i>", '#', array('onclick'=>'hapusPelatihan(this);return false;','rel'=>'tooltip','title'=>'Klik untuk membatalkan rencana pelatihan')); ?>
        </div>
    </td>
    <td>
        <?php echo CHtml::textField('no_urut',0,array('readonly'=>true,'class'=>'span1 integer', 'style'=>'width:20px;')); ?>
		<?php echo CHtml::activeHiddenField($model,'[0]rencanadiklat_id',array('readonly'=>true,'class'=>'span2')); ?>
    </td>
    <td>
        <?php echo CHtml::activeTextField($model,'[0]nomorindukpegawai',array('readonly'=>true,'class'=>'span3','style'=>'width:140px;')); ?>
    </td>
    <td>
		<?php echo  CHtml::activeHiddenField($model, '[0]pegawai_id',array('readonly'=>true,'class'=>'pegawai_id')); ?>
		<?php
		$this->widget('MyJuiAutoComplete', array(
			'model'=>$model,
			'attribute' => '[0]pegawai_nama',
			'source' => 'js: function(request, response) {
							   $.ajax({
								   url: "' . $this->createUrl('AutocompletePegawai') . '",
								   dataType: "json",
								   data: {
									   term: request.term,
								   },
								   success: function (data) {
										   response(data);
								   }
							   })
							}',
			'options' => array(
				'showAnim' => 'fold',
				'minLength' => 3,
				'focus' => 'js:function( event, ui ) {
					$(this).val(ui.item.label);
					return false;
				}',
				'select' => 'js:function( event, ui ) {
					setPegawai($(this), ui.item);
					return false;
				}',
			),
			'tombolDialog'=>array("idDialog"=>'dialogPegawai','jsFunction'=>"setDialog(this);"),
			'htmlOptions'=>array('class'=>'span2 required','onkeypress'=>"return $(this).focusNextInputField(event)"),
		));
		?>
	</td>      
    <td>
        <?php echo CHtml::activeHiddenField($model,'[0]jabatan_id',array('readonly'=>true,'class'=>'span3','style'=>'width:140px;')); ?>
        <?php echo CHtml::activeTextField($model,'[0]jabatan_nama',array('readonly'=>true,'class'=>'span3','style'=>'width:140px;')); ?>
    </td>
    <td class="internal_pelatihan_anti">
        <?php echo CHtml::activeTextField($model,'[0]biaya_pelatihan',array('onblur'=>'hitungTotal()','readonly'=>false,'class'=>'span2 integer2','style'=>'text-align:right;')); ?>
    </td>
    <td class="internal_pelatihan_anti">
        <?php echo CHtml::activeTextField($model,'[0]biaya_transportasi',array('onblur'=>'hitungTotal()','readonly'=>false,'class'=>'span2 integer2','style'=>'text-align:right;')); ?>
    </td>        
    <td class="internal_pelatihan_anti">
        <?php echo CHtml::activeTextField($model,'[0]biaya_penginapan',array('onblur'=>'hitungTotal()','readonly'=>false,'class'=>'span2 integer2','style'=>'text-align:right;')); ?>
    </td>        
    <td class="internal_pelatihan_anti">
        <?php echo CHtml::activeTextField($model,'[0]biaya_perjalanandinas',array('onblur'=>'hitungTotal()','readonly'=>false,'class'=>'span2 integer2','style'=>'text-align:right;')); ?>
    </td>        
    <td class="internal_pelatihan_anti">
        <?php echo CHtml::activeTextField($model,'[0]biaya_lainlain',array('onblur'=>'hitungTotal()','readonly'=>false,'class'=>'span2 integer2','style'=>'text-align:right;')); ?>
    </td>        
    <td class="internal_pelatihan_anti">
        <?php echo CHtml::activeTextArea($model,'[0]keterangan_lainlain',array('rows'=>3,'cols'=>15,'readonly'=>false,'class'=>'autogrow','style'=>'width:140px;')); ?>
    </td>        
     <td class="internal_pelatihan_anti">
        <?php echo CHtml::activeTextField($model,'[0]total',array('readonly'=>true,'class'=>'span2 integer2','style'=>'text-align:right;')); ?>
    </td> 
</tr>

<?php endif; ?>

