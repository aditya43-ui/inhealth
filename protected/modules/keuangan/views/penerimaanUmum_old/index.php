<div class="white-container">
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
    'id'=>'kupenerimaan-umum-t-form',
    'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)',
                             // 'onsubmit'=>'return cekInput();'
                                'onsubmit'=>'return requiredCheck(this);'
            ),
        'focus'=>'#',
)); ?>

<?php $this->widget('bootstrap.widgets.BootAlert'); ?>

	<legend class="rim2">Transaksi <b>Penerimaan Umum</b></legend>
    <!--<p class="help-block"><?php // echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>-->
	<fieldset>
		<div class="row">
			<div class="col-sm-4">
				<?php //echo $form->textFieldRow($modPenUmum,'tglpenerimaan',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
				<div class="control-group">
					<?php $modPenUmum->tglpenerimaan = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modPenUmum->tglpenerimaan, 'yyyy-MM-dd hh:mm:ss','medium',null)); ?>
					<?php echo $form->labelEx($modPenUmum,'tglpenerimaan', array('class'=>'control-label')) ?>
					<div class="controls">
						<?php   
							$this->widget('MyDateTimePicker',array(
								'model'=>$modPenUmum,
								'attribute'=>'tglpenerimaan',
								'mode'=>'datetime',
								'options'=> array(
									'dateFormat'=>Params::DATE_FORMAT,
									'maxDate' => 'd',
								),
								'htmlOptions'=>array('class'=>'dtPicker2-5', 'onkeypress'=>"return $(this).focusNextInputField(event)"
								),
							));
						?>
					</div>
				</div>
				<?php echo $form->textFieldRow($modPenUmum,'nopenerimaan',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>20,'readonly'=>true)); ?>
				<?php echo $form->dropDownListRow($modPenUmum,'kelompoktransaksi',LookupM::getItems('kelompoktransaksi'),array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
				<?php echo $form->hiddenField($modPenUmum,'jenispenerimaan_id',array('readonly'=>true,'class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
				<div class="control-group">
					<?php echo $form->labelEx($modPenUmum,'jenispenerimaan_id', array('class'=>'control-label')) ?>
					<div class="controls">
						<?php 
							$this->widget('MyJuiAutoComplete', array(
								'model'=>$modPenUmum,
								'attribute'=>'jenisKodeNama',
								'source'=>'js: function(request, response) {
											   $.ajax({
												   url: "'.$this->createUrl('AutocompleteJenisPenerimaan').'",
												   dataType: "json",
												   data: {
													   term: request.term,
												   },
												   success: function (data) {
														   response(data);
												   }
											   })
											}',
								 'options'=>array(
									   'showAnim'=>'fold',
									   'minLength' => 2,
									   'focus'=> 'js:function( event, ui ) {
										   $(this).val("");
											return false;
										}',
									   'select'=>'js:function( event, ui ) {
											$("#KUPenerimaanUmumT_jenisKodeNama").val(ui.item.value);
											$("#KUPenerimaanUmumT_jenispenerimaan_id").val(ui.item.jenispenerimaan_id);
											return false;
										}',
								),
								'tombolDialog'=>array('idDialog'=>'dialogJenisPenerimaan','idTombol'=>'tombolJenisPenerimaanDialog'),
								'htmlOptions'=>array('placeholder'=>'Kode/Nama Jenis Penerimaan'),
							)); 
						?>
					</div>
				</div>
			</div>
			<div class="col-sm-4">
				<?php //echo $form->textFieldRow($modPenUmum,'volume',array('onblur'=>'hitungTotalHarga()','class'=>'span1', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
				<?php //echo $form->dropDownListRow($modPenUmum,'satuanvol', LookupM::getItems('satuanumum'),array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
				<div class="control-group">
					<?php //$modPenUmum->tglpenerimaan = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modPenUmum->tglpenerimaan, 'yyyy-MM-dd hh:mm:ss','medium',null)); ?>
					<?php echo $form->labelEx($modPenUmum,'volume', array('class'=>'control-label')) ?>
					<div class="controls">
						<?php echo $form->textField($modPenUmum,'volume',array('onblur'=>'hitungTotalHarga()','class'=>'span1', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
						<?php echo $form->dropDownList($modPenUmum,'satuanvol', LookupM::getItems('satuanumum'),array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
					</div>
				</div>
				<?php echo $form->textFieldRow($modPenUmum,'hargasatuan',array('onblur'=>'hitungTotalHarga()','class'=>'inputFormTabel integer', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
				<?php echo $form->textFieldRow($modPenUmum,'totalharga',array('readonly'=>true,'class'=>'inputFormTabel integer', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
			</div>
			<div class="col-sm-4">
				<?php echo $form->textAreaRow($modPenUmum,'keterangan_penerimaan',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
				<?php echo $form->textFieldRow($modPenUmum,'namapenandatangan',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
				<?php echo $form->textFieldRow($modPenUmum,'nippenandatangan',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
				<?php echo $form->textFieldRow($modPenUmum,'jabatanpenandatangan',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
				<?php //echo $form->dropDownListRow($modPenUmum,'penjamin_id', CHtml::listData($modPenUmum->getPenjaminItems(1), 'penjamin_id', 'penjamin_nama'), array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
			</div>
		</div>
	</fieldset>  
	
	<fieldset class="box">
		<legend class="rim">
            <?php echo CHtml::checkBox('adaUraian', true, array('onchange'=>'bukaUraian(this)','onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
            Pilih Jika Transaksi Ada Uraiannya
        </legend>
		<div id="div_tabeluraian">
			<table id="tblInputUraian" class="table table-bordered table-condensed">
				<thead>
					<tr>
						<th>
							Uraian
						</th>
						<th>Volume</th>
						<th>Satuan</th>
						<th>Harga</th>
						<th>Total</th>
						<th>&nbsp;</th>
					</tr>
				</thead>
				<tbody>
					<?php $this->renderPartial('_rowUraian',array('form'=>$form,'modUraian'=>$modUraian, 'removeButton'=>false)); ?>
				</tbody>
			</table>
		</div>		
	</fieldset>	
   
	<fieldset class="box">
		<legend class="rim">Data Tambahan</legend>
		<div class="row">
			<div class="col-sm-6">
				<div class="control-group">
                    <?php echo CHtml::label('Total Tagihan','totTagihan', array('class'=>'control-label inline')) ?>
                    <div class="controls">
                        <?php echo CHtml::textField('totTagihan',(isset($totTagihan) ? $totTagihan:null),array('readonly'=>true,'class'=>'inputFormTabel integer span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")) ?>
                    </div>
                </div>
                <?php echo $form->textFieldRow($modTandaBukti,'jmlpembulatan',array('readonly'=>true,'class'=>'inputFormTabel integer span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                <?php echo $form->textFieldRow($modTandaBukti,'biayaadministrasi',array('onkeyup'=>'hitungJmlBayar();','class'=>'inputFormTabel integer span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                <?php echo $form->textFieldRow($modTandaBukti,'biayamaterai',array('onkeyup'=>'hitungJmlBayar();','class'=>'inputFormTabel integer span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                <?php echo $form->textFieldRow($modTandaBukti,'jmlpembayaran',array('onkeyup'=>'hitungKembalian();','readonly'=>true,'class'=>'inputFormTabel integer span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                <?php echo $form->textFieldRow($modTandaBukti,'uangditerima',array('onkeyup'=>'hitungKembalian();','class'=>'inputFormTabel integer span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                <?php echo $form->textFieldRow($modTandaBukti,'uangkembalian',array('class'=>'inputFormTabel integer span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
			</div>
			<div class="col-sm-6">
				<div class="control-group">
                    <?php $modTandaBukti->tglbuktibayar = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modTandaBukti->tglbuktibayar, 'yyyy-MM-dd hh:mm:ss','medium',null)); ?>
                    <?php echo $form->labelEx($modTandaBukti,'tglbuktibayar', array('class'=>'control-label inline')) ?>
                    <div class="controls">
                        <?php   
							$this->widget('MyDateTimePicker',array(
								'model'=>$modTandaBukti,
								'attribute'=>'tglbuktibayar',
								'mode'=>'datetime',
								'options'=> array(
									'dateFormat'=>Params::DATE_FORMAT,
									'maxDate' => 'd',
								),
								'htmlOptions'=>array('class'=>'dtPicker2-5', 'onkeypress'=>"return $(this).focusNextInputField(event)"
								),
							));
						?>
                    </div>
                </div>
                <?php echo $form->dropDownListRow($modTandaBukti,'carapembayaran',  LookupM::getItems('carapembayaran'),array('onchange'=>'ubahCaraPembayaran(this)','class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
                <div class="control-group">
                    <?php echo CHtml::label('Menggunakan Kartu','pakeKartu', array('class'=>'control-label inline')) ?>
                    <div class="controls">
                        <?php echo CHtml::checkBox('pakeKartu',false,array('onchange'=>"enableInputKartu();", 'onkeypress'=>"return $(this).focusNextInputField(event);")) ?> <i class="icon-chevron-down"></i>
                    </div>
                </div>
                <div id="divDenganKartu" class="hide">
                    <?php echo $form->dropDownListRow($modTandaBukti,'dengankartu',  LookupM::getItems('dengankartu'),array('onchange'=>'enableInputKartu()','empty'=>'-- Pilih --','class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
                    <?php echo $form->textFieldRow($modTandaBukti,'bankkartu',array('readonly'=>true,'class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
                    <?php echo $form->textFieldRow($modTandaBukti,'nokartu',array('readonly'=>true,'class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
                    <?php echo $form->textFieldRow($modTandaBukti,'nostrukkartu',array('readonly'=>true,'class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
                </div>
				<?php echo $form->textFieldRow($modTandaBukti,'darinama_bkm',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
                <?php echo $form->textAreaRow($modTandaBukti,'alamat_bkm',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                <?php echo $form->textFieldRow($modTandaBukti,'sebagaipembayaran_bkm',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
			</div>
		</div>
	</fieldset>
    <div class="form-actions">
        <?php
			if ($modTandaBukti->isNewRecord) {
				echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-check"></i>')),
				array('class' => 'btn btn-danger', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)')); 
			} else {
				echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-check"></i>')),
								array('class' => 'btn btn-danger', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)','disabled'=>true)); 
			}
         ?>
		<?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
                    $this->createUrl('index'), 
                    array('class' => 'btn btn-default',
                          'onclick'=>'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;')); ?>
		<?php //TIDAK ADA FUNGSINYA >>> echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="entypo-print"></i>')), '#', array('class'=>'btn btn-info','onclick'=>"printKasir($('#FAPendaftaranT_pendaftaran_id').val());return false",'disabled'=>false)); ?>               
		<?php  
			$content = $this->renderPartial('tips/transaksi',array(),true);
			$this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
		?>
    </div>

<?php $this->endWidget(); ?>
<?php 
//========= Dialog buat cari data Jenis Penerimaan =========================

$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogJenisPenerimaan',
    'options'=>array(
        'title'=>'Pencarian Jenis Penerimaan',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>900,
        'height'=>540,
        'resizable'=>false,
    ),
));
$modJenispenerimaan = new JenispenerimaanM('searchJenisPenerimaan');
$modJenispenerimaan->unsetAttributes();
if(isset($_GET['JenispenerimaanM'])) {
    $modJenispenerimaan->attributes = $_GET['JenispenerimaanM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'pendaftaran-t-grid',
	'dataProvider'=>$modJenispenerimaan->searchJenisPenerimaan(),
	'filter'=>$modJenispenerimaan,
	'template'=>"{summary}\n{items}\n{pager}",
	'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
		array(
			'header'=>'Pilih',
			'type'=>'raw',
			'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
				"id" => "selectPendaftaran",
				"onClick" => "
					$(\"#dialogJenisPenerimaan\").dialog(\"close\");
					$(\"#KUPenerimaanUmumT_jenispenerimaan_id\").val(\"$data->jenispenerimaan_id\");
					$(\"#KUPenerimaanUmumT_jenisKodeNama\").val(\"$data->jenispenerimaan_kode - $data->jenispenerimaan_nama\");
				"))',
		),
		'jenispenerimaan_kode',
		'jenispenerimaan_nama',
		'jenispenerimaan_namalain',
	),
	'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));

$this->endWidget();
?>
<?php $this->renderPartial('_jsFunctions',array('modPenUmum'=>$modPenUmum,'form'=>$form,'modUraian'=>$modUraian)); ?>
</div>