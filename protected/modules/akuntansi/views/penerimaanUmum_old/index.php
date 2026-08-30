<div class="white-container" id="input-penerimaan-kas">
    <?php $totTagihan = 0; ?>
    <?php
        $this->widget('application.extensions.moneymask.MMask',array(
            'element'=>'.currency',
            'currency'=>'PHP',
            'config'=>array(
                'symbol'=>'Rp ',
                'defaultZero'=>true,
                'allowZero'=>true,
                'precision'=>0,
            )
        ));
    ?>
    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting.js'); ?>
    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
    <?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
        'id'=>'akpenerimaan-umum-t-form',
        'enableAjaxValidation'=>false,
            'type'=>'horizontal',
            'htmlOptions'=> array(
                'onKeyPress'=>'return disableKeyPress(event)'
                            , 'onsubmit'=>'return requiredCheck(this);'
            ),
			'focus'=>'#AKPenerimaanUmumT_nopenerimaan',
    )); ?>
    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
    <legend class="rim2">Transaksi <b>Penerimaan Kas</b></legend>
    <!--<p class="help-block"><?php // echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>-->
	<div class="row">
		<div class="col-sm-4">
			<div class="control-group">
				<?php $modPenUmum->tglpenerimaan = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modPenUmum->tglpenerimaan, 'yyyy-MM-dd hh:mm:ss','medium',null)); ?>
				<?php echo $form->labelEx($modPenUmum,'tglpenerimaan', array('class'=>'control-label')) ?>
				<div class="controls">
					<?php   
						$this->widget('MyDateTimePicker',
							array(
									'model'=>$modPenUmum,
									'attribute'=>'tglpenerimaan',
									'mode'=>'datetime',
									'options'=>array(
										'dateFormat'=>Params::DATE_FORMAT,
										'maxDate' => 'd',
									),
									'htmlOptions'=>array(
										'class'=>'dtPicker2-5 reqForm',
										'onkeypress'=>"return $(this).focusNextInputField(event)"
									),
							)
						); 
					?>

				</div>
			</div>
			<?php echo $form->textFieldRow($modPenUmum,'nopenerimaan',array('class'=>'span3 reqForm', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>20)); ?>
			<?php echo $form->dropDownListRow($modPenUmum,'kelompoktransaksi',LookupM::getItems('kelompoktransaksi'),array('class'=>'span3 reqForm', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
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
												   url: "'.Yii::app()->createUrl('billingKasir/ActionAutoComplete/jenisPenerimaan').'",
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
										   $(this).val(ui.item.value);
											return false;
										}',
									   'select'=>'js:function( event, ui ) {
											$("#AKPenerimaanUmumT_jenispenerimaan_id").val(ui.item.jenispenerimaan_id);
											getDataRekening(ui.item.jenispenerimaan_id);
											return false;
										}',
								),
								'htmlOptions'=>array('placeholder'=>'Kode/Nama Jenis Penerimaan','class'=>'span3 reqForm'),
								'tombolDialog' => array('idDialog' => 'dialogJenisPenerimaan',),
						)); 
					?>
				</div>
			</div>			
		</div>
		<div class="col-sm-4">
			<div class="control-group">
				<?php echo $form->labelEx($modPenUmum,'volume', array('class'=>'control-label')) ?>
				<div class="controls">
					<?php echo $form->textField($modPenUmum,'volume',array('onblur'=>'hitungTotalHarga()','class'=>'span1 reqForm', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
					<?php echo $form->dropDownList($modPenUmum,'satuanvol', LookupM::getItems('satuanumum'),array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
				</div>
			</div>
			<?php echo $form->textFieldRow($modPenUmum,'hargasatuan',array('onblur'=>'hitungTotalHarga()','class'=>'inputFormTabel currency reqForm', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
			<?php echo $form->textFieldRow($modPenUmum,'totalharga',array('readonly'=>true,'class'=>'inputFormTabel currency', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
		</div>
		<div class="col-sm-4">
			<?php echo $form->textAreaRow($modPenUmum,'keterangan_penerimaan',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
			<?php echo $form->textFieldRow($modPenUmum,'namapenandatangan',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
			<?php echo $form->textFieldRow($modPenUmum,'nippenandatangan',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
			<?php echo $form->textFieldRow($modPenUmum,'jabatanpenandatangan',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>  
		</div>
	</div>
    <fieldset class="box">
        <legend class="rim">
            <?php echo CHtml::checkBox('pakeAsuransi', true, array('onchange'=>'bukaUraian(this)','onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
            Pilih Jika Transaksi Ada Uraiannya
        </legend>
        <div id="div_tblInputUraian">
            <table id="tblInputUraian" class="table table-striped table-condensed">
                <thead>
                    <tr>
                        <th>Uraian</th>
                        <th>Volume</th>
                        <th>Satuan</th>
                        <th>Harga</th>
                        <th>Total</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $this->renderPartial('_rowUraian',array('form'=>$form, 'modUraian'=>$modUraian)); ?>
                </tbody>
            </table>
       </div>
    </fieldset>
    <fieldset class="box">
        <legend class="rim">Data Tambahan</legend>
        <table style="width: 100%; border: none;">
            <tr>
                <td width="50%">
                    <div>
                        <?php
                            $this->renderPartial('_rowListRekening',
                                array(
                                    'form'=>$form,
                                    'modUraian'=>$modUraian,
                                )
                            );
                        ?>
                    </div>
                </td>
                <td width="20%">
                    <div class="control-group">
                        <?php echo CHtml::label('Total Tagihan','totTagihan', array('class'=>'control-label inline')) ?>
                        <div class="controls">
                            <?php echo CHtml::textField('totTagihan',$totTagihan,array('readonly'=>true,'class'=>'inputFormTabel currency span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")) ?>
                        </div>
                    </div>
                    <?php echo $form->textFieldRow($modTandaBukti,'jmlpembulatan',array('readonly'=>true,'class'=>'inputFormTabel currency span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                    <?php echo $form->textFieldRow($modTandaBukti,'biayaadministrasi',array('onkeyup'=>'hitungJmlBayar();','class'=>'inputFormTabel currency span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                    <?php echo $form->textFieldRow($modTandaBukti,'biayamaterai',array('onkeyup'=>'hitungJmlBayar();','class'=>'inputFormTabel currency span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                    <?php echo $form->textFieldRow($modTandaBukti,'jmlpembayaran',array('onkeyup'=>'hitungKembalian();','readonly'=>true,'class'=>'inputFormTabel currency span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                    <?php echo $form->textFieldRow($modTandaBukti,'uangditerima',array('onkeyup'=>'hitungKembalian();','class'=>'inputFormTabel currency span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                    <?php echo $form->textFieldRow($modTandaBukti,'uangkembalian',array('class'=>'inputFormTabel currency span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>

                </td>
                <td width="30%">
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

                    <?php echo $form->textFieldRow($modTandaBukti,'darinama_bkm',array('class'=>'span3 reqForm', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
                    <?php echo $form->textAreaRow($modTandaBukti,'alamat_bkm',array('class'=>'span3 reqForm', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                    <?php echo $form->textFieldRow($modTandaBukti,'sebagaipembayaran_bkm',array('class'=>'span3 reqForm', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
                </td>
            </tr>
        </table>
    </fieldset>
      
    <div class="form-actions">
        <div style="float:left;margin-right:6px;">
            <?php
                $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
                $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai    
                $urlSave=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/index');
                $this->widget('bootstrap.widgets.BootButtonGroup', array(
                    'type'=>'primary',
                    'buttons'=>array(
                        array(
                            'label'=>'Simpan',
                            'icon'=>'entypo-check',
                            'url'=>"#",
                            'htmlOptions'=>
                                array(
                                    'onclick'=>'simpanPenerimaan(\'jurnal\');return false;',
                                )
                       ),
                        array(
                            'label'=>'',
                            'items'=>array(
                                array(
                                    'label'=>'Posting',
                                    'icon'=>'icon-ok',
                                    'url'=>"#",
                                    'itemOptions' => array(
                                        'onclick'=>'simpanPenerimaan(\'posting\');return false;'
                                    )
                                ),
                            )
                        ),
                    ),
                ));
                echo CHtml::htmlButton(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), array('style'=>'display:none','id' => 'reseter', 'class' => 'btn btn-default', 'type'=>'reset'));
                echo CHtml::hiddenField('url');
             ?>
        </div>
           <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="entypo-print"></i>')),array('class' => 'btn btn-info', 'type'=>'button','onclick'=>'print(\'PRINT\')')); ?>
           <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
                    Yii::app()->createUrl($this->module->id.'/penerimaanUmum/index'), 
                    array('class' => 'btn btn-default',
                          'onclick'=>'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;')); ?>
            <?php
//                $content = $this->renderPartial('../tips/transaksi',array(),true);
//                $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
            ?>
    </div>
</div>
<?php $this->renderPartial('_jsFunctions',array('form'=>$form,'modUraian'=>$modUraian)); ?>
<?php $this->endWidget(); ?>    
<?php 
//========= Dialog buat cari data Rek Kredit =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogJenisPenerimaan',
    'options'=>array(
        'title'=>'Daftar Jenis Penerimaan',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>600,
        'height'=>400,
        'resizable'=>false,
    ),
));

$modJenisPenerimaan = new JenispenerimaanM();
$modJenisPenerimaan->unsetAttributes();
if(isset($_GET['JenispenerimaanM'])) {
    $modJenisPenerimaan->attributes = $_GET['JenispenerimaanM'];
}
$this->widget('ext.bootstrap.widgets.HeaderGroupGridView',array(
	'id'=>'jenispenerimaan-m-grid',
        //'ajaxUrl'=>Yii::app()->createUrl('actionAjax/CariDataPasien'),
	'dataProvider'=>$modJenisPenerimaan->searchJenisPenerimaanRek(),
	'filter'=>$modJenisPenerimaan,
	'template'=>"{summary}\n{items}\n{pager}",
	'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
		array(
			'header' => 'No.',
			'value'=>'$this->grid->dataProvider->Pagination->CurrentPage*$this->grid->dataProvider->pagination->pageSize+$row+1',
		),
		array(
			'header'=>'Jenis Penerimaan',
			'name'=>'jenispenerimaan_nama',
			'value'=>'$data->jenispenerimaan_nama',
		),
		array(
			'header'=>'Nama Lain',
			'name'=>'jenispenerimaan_namalain',
			'value'=>'$data->jenispenerimaan_namalain',
		),
		array(
			'header'=>'Pilih',
			'type'=>'raw',
			'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
				"id" => "selectRekDebit",
				"onClick" =>"
					getDataRekening($data->jenispenerimaan_id);
					$(\"#AKPenerimaanUmumT_jenispenerimaan_id\").val(\"$data->jenispenerimaan_id\");
					$(\"#AKPenerimaanUmumT_jenisKodeNama\").val(\"$data->jenispenerimaan_nama\");
					$(\"#dialogJenisPenerimaan\").dialog(\"close\");    
					return false;
			"))',
		),
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));

$this->endWidget();
//========= end Rek Kredit dialog =============================
?>