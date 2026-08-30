<?php 
if (isset($a)){
    $i = $a;
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
        <?php echo CHtml::textField('no_urut',$i,array('readonly'=>true,'class'=>'span1 integer', 'style'=>'width:20px;')); ?>
		<?php echo CHtml::activeHiddenField($modPegawaiDiklat,'['.$i.']rencanadiklat_id',array('readonly'=>true,'class'=>'span2')); ?>
    </td>
    <td>
        <?php echo CHtml::activeTextField($modPegawaiDiklat,'['.$i.']nomorindukpegawai',array('readonly'=>true,'class'=>'span3','style'=>'width:140px;')); ?>
    </td>
    <td>
            <?php echo  CHtml::activeHiddenField($modPegawaiDiklat, '[0]pegawai_id',array('readonly'=>true,'class'=>'pegawai_id')); ?>
		<?php
		$this->widget('MyJuiAutoComplete', array(
			'model'=>$modPegawaiDiklat,
			'attribute' => '['.$i.']nama_pegawai',
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
        <?php echo CHtml::activeHiddenField($modPegawaiDiklat,'[0]jabatan_id',array('readonly'=>true,'class'=>'span3','style'=>'width:140px;')); ?>
        <?php echo CHtml::activeTextField($modPegawaiDiklat,'[0]jabatan_nama',array('readonly'=>true,'class'=>'span3','style'=>'width:140px;')); ?>
    </td>
    <td>
        <?php echo CHtml::activeFileField($modPegawaiDiklat,'[0]sertifikat',array('class'=>'span3')); ?>
    </td>
    <td class="td_date"><?php $this->widget('MyDateTimePicker',array(
                'model'=>$modPegawaiDiklat,
                'attribute'=>'[0]masaberlakusertifikat',
                'mode'=>'datetime',
                'options'=> array(
                    'showOn' => false,
                    'yearRange'=> "-150:+0",
                ),
                'htmlOptions'=>array(
					'class'=>'span2',
					'onkeyup'=>"return $(this).focusNextInputField(event)",
					'style' => 'width:130px;'
                ),
        )); ?>
    </td>
    <td class="internal_pelatihan_anti">
        <?php echo CHtml::activeTextField($modPegawaiDiklat,'[0]biaya_pelatihan',array('onblur'=>'hitungTotal()','readonly'=>false,'class'=>'span2 integer2','style'=>'text-align:right;')); ?>
    </td>
    <td class="internal_pelatihan_anti">
        <?php echo CHtml::activeTextField($modPegawaiDiklat,'[0]biaya_transportasi',array('onblur'=>'hitungTotal()','readonly'=>false,'class'=>'span2 integer2','style'=>'text-align:right;')); ?>
    </td>        
    <td class="internal_pelatihan_anti">
        <?php echo CHtml::activeTextField($modPegawaiDiklat,'[0]biaya_penginapan',array('onblur'=>'hitungTotal()','readonly'=>false,'class'=>'span2 integer2','style'=>'text-align:right;')); ?>
    </td>        
    <td class="internal_pelatihan_anti">
        <?php echo CHtml::activeTextField($modPegawaiDiklat,'[0]biaya_perjalanandinas',array('onblur'=>'hitungTotal()','readonly'=>false,'class'=>'span2 integer2','style'=>'text-align:right;')); ?>
    </td>        
    <td class="internal_pelatihan_anti">
        <?php echo CHtml::activeTextField($modPegawaiDiklat,'[0]biaya_lainlain',array('onblur'=>'hitungTotal()','readonly'=>false,'class'=>'span2 integer2','style'=>'text-align:right;')); ?>
    </td>        
    <td class="internal_pelatihan_anti">
        <?php echo CHtml::activeTextArea($modPegawaiDiklat,'[0]keterangan_lainlain',array('rows'=>7,'cols'=>15,'readonly'=>false,'class'=>'autogrow','style'=>'width:140px;')); ?>
    </td>        
    <td class="internal_pelatihan_anti">
        <?php echo CHtml::activeTextField($modPegawaiDiklat,'[0]total',array('readonly'=>true,'class'=>'span2 integer2','style'=>'text-align:right;')); ?>
    </td> 
</tr>
<?php
}else{
    if (count((array)$modDetail)>0){
        foreach ($modDetail as $i => $model){ 
	$i++;
        $modPegawaiDiklat->pegawai_id = $model->pegawai_id;
        $modPegawaiDiklat->nama_pegawai = !empty($model->pegawai->nama_pegawai)?$model->pegawai->nama_pegawai:null;
	$modPegawaiDiklat->nomorindukpegawai = !empty($model->pegawai->nomorindukpegawai)?$model->pegawai->nomorindukpegawai:null;
	$modPegawaiDiklat->jenisdiklat_nama = $modRencanaDiklat->jenisdiklat->jenisdiklat_nama;		
        $modPegawaiDiklat->jabatan_id = $model->jabatan_id;		
        $modPegawaiDiklat->jabatan_nama = !empty($model->jabatan->jabatan_nama)?$model->jabatan->jabatan_nama:'';	
        $modPegawaiDiklat->biaya_pelatihan = $model->biaya_pelatihan;
        $modPegawaiDiklat->biaya_transportasi = $model->biaya_transportasi;
        $modPegawaiDiklat->biaya_penginapan = $model->biaya_penginapan;
        $modPegawaiDiklat->biaya_perjalanandinas = $model->biaya_perjalanandinas;
        $modPegawaiDiklat->biaya_lainlain = $model->biaya_lainlain;
        $modPegawaiDiklat->keterangan_lainlain = $model->keterangan_lainlain;
        $modPegawaiDiklat->total = $model->total;
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
        <?php echo CHtml::textField('no_urut',$i,array('readonly'=>true,'class'=>'span1 integer', 'style'=>'width:20px;')); ?>
		<?php echo CHtml::activeHiddenField($modPegawaiDiklat,'['.$i.']rencanadiklat_id',array('readonly'=>true,'class'=>'span2')); ?>
    </td>
    <td>
        <?php echo CHtml::activeTextField($modPegawaiDiklat,'['.$i.']nomorindukpegawai',array('readonly'=>true,'class'=>'span3','style'=>'width:140px;')); ?>
    </td>
    <td>
            <?php echo  CHtml::activeHiddenField($modPegawaiDiklat, '['.$i.']pegawai_id',array('readonly'=>true)); ?>
            <?php echo  CHtml::activeTextField($modPegawaiDiklat, '['.$i.']nama_pegawai',array('readonly'=>true, 'style'=>'width:150px;')); ?>
    </td>       
    <td>
        <?php echo CHtml::activeHiddenField($modPegawaiDiklat,'[0]jabatan_id',array('readonly'=>true,'class'=>'span3','style'=>'width:140px;')); ?>
        <?php echo CHtml::activeTextField($modPegawaiDiklat,'[0]jabatan_nama',array('readonly'=>true,'class'=>'span3','style'=>'width:140px;')); ?>
    </td>
    <td>
        <?php echo CHtml::activeFileField($modPegawaiDiklat,'['.$i.']sertifikat',array('class'=>'span3')); ?>
    </td>
    <td class="td_date"><?php $this->widget('MyDateTimePicker',array(
                'model'=>$modPegawaiDiklat,
                'attribute'=>'['.$i.']masaberlakusertifikat',
                'mode'=>'datetime',
                'options'=> array(
                    'showOn' => false,
                    'yearRange'=> "-150:+0",
                ),
                'htmlOptions'=>array(
					'class'=>'span2',
					'onkeyup'=>"return $(this).focusNextInputField(event)",
					'style' => 'width:130px;'
                ),
        )); ?>
    </td>
    <td class="internal_pelatihan_anti">
        <?php echo CHtml::activeTextField($modPegawaiDiklat,'[0]biaya_pelatihan',array('onblur'=>'hitungTotal()','readonly'=>false,'class'=>'span2 integer2','style'=>'text-align:right;')); ?>
    </td>
    <td class="internal_pelatihan_anti">
        <?php echo CHtml::activeTextField($modPegawaiDiklat,'[0]biaya_transportasi',array('onblur'=>'hitungTotal()','readonly'=>false,'class'=>'span2 integer2','style'=>'text-align:right;')); ?>
    </td>        
    <td class="internal_pelatihan_anti">
        <?php echo CHtml::activeTextField($modPegawaiDiklat,'[0]biaya_penginapan',array('onblur'=>'hitungTotal()','readonly'=>false,'class'=>'span2 integer2','style'=>'text-align:right;')); ?>
    </td>        
    <td class="internal_pelatihan_anti">
        <?php echo CHtml::activeTextField($modPegawaiDiklat,'[0]biaya_perjalanandinas',array('onblur'=>'hitungTotal()','readonly'=>false,'class'=>'span2 integer2','style'=>'text-align:right;')); ?>
    </td>        
    <td class="internal_pelatihan_anti">
        <?php echo CHtml::activeTextField($modPegawaiDiklat,'[0]biaya_lainlain',array('onblur'=>'hitungTotal()','readonly'=>false,'class'=>'span2 integer2','style'=>'text-align:right;')); ?>
    </td>        
    <td class="internal_pelatihan_anti">
        <?php echo CHtml::activeTextArea($modPegawaiDiklat,'[0]keterangan_lainlain',array('rows'=>3,'cols'=>15,'readonly'=>false,'class'=>'autogrow','style'=>'width:140px;')); ?>
    </td>        
     <td class="internal_pelatihan_anti">
        <?php echo CHtml::activeTextField($modPegawaiDiklat,'[0]total',array('readonly'=>true,'class'=>'span2 integer2','style'=>'text-align:right;')); ?>
    </td> 
</tr>
<?php }}}  ?>
