<div class="white-container">
<fieldset id ="input-pengeluaran">
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting.js'); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
    'id'=>'kupengeluaran-umum-t-form',
    'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)',
                             'onsubmit'=>'return requiredCheck(this);'),
        'focus'=>'#',
)); ?>

<?php $this->widget('bootstrap.widgets.BootAlert'); ?>	
		<legend class='rim2'>Transaksi <b>Pengeluaran Kas</b></legend>
    <!--<p class="help-block"><?php // echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>-->

    <?php //echo $form->errorSummary(array($modPengUmum,$modBuktiKeluar)); ?>
	<div class="row">
		<div class="col-sm-4">
			<div class="control-group">
				<?php $modPengUmum->tglpengeluaran = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modPengUmum->tglpengeluaran, 'yyyy-MM-dd hh:mm:ss','medium',null)); ?>
				<?php echo $form->labelEx($modPengUmum,'tglpengeluaran', array('class'=>'control-label')) ?>
				<div class="controls">
					<?php   
						$this->widget('MyDateTimePicker',array(
								'model'=>$modPengUmum,
								'attribute'=>'tglpengeluaran',
								'mode'=>'datetime',
								'options'=> array(
									'dateFormat'=>Params::DATE_FORMAT,
									'maxDate' => 'd',
								),
								'htmlOptions'=>array('class'=>'dtPicker2-5 reqForm', 'onkeypress'=>"return $(this).focusNextInputField(event)"
								),
						)); 
					?>

				</div>
			</div>
			<?php echo $form->textFieldRow($modPengUmum,'nopengeluaran',array('class'=>'span3 reqForm', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>20)); ?>
			<?php echo $form->dropDownListRow($modPengUmum,'kelompoktransaksi',LookupM::getItems('kelompoktransaksi'),array('class'=>'span3 reqForm', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
			<?php echo $form->hiddenField($modPengUmum,'jenispengeluaran_id',array('readonly'=>true,'class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
			<?php //echo $form->textFieldRow($modPengUmum,'volume',array('onblur'=>'hitungTotalHarga()','class'=>'span1', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
			<?php //echo $form->dropDownListRow($modPengUmum,'satuanvol', LookupM::getItems('satuanumum'),array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
                
		</div>
		<div class="col-sm-4">
			<div class="control-group">
				<?php echo $form->labelEx($modPengUmum,'jenispengeluaran_id', array('class'=>'control-label')) ?>
				<div class="controls">
					<?php 
						$this->widget('MyJuiAutoComplete', array(
								'model'=>$modPengUmum,
								'attribute'=>'jenisKodeNama',
								'source'=>'js: function(request, response) {
											   $.ajax({
												   url: "'.$this->createUrl('AutocompleteJenisPengeluaran').'",
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
											$("#KUPengeluaranumumT_jenispengeluaran_id").val(ui.item.jenispengeluaran_id);
											getDataRekening(ui.item.jenispenerimaan_id);
											return false;
										}',
								),
								'htmlOptions'=>array('placeholder'=>'Nama Jenis Pengeluaran','class'=>'reqForm'),
								'tombolDialog' => array('idDialog' => 'dialogJenisPengeluaran',),
						)); 
					?>
				</div>
			</div>
			<div class="control-group">
				<?php echo $form->labelEx($modPengUmum,'volume', array('class'=>'control-label')) ?>
				<div class="controls">
					<?php echo $form->textField($modPengUmum,'volume',array('onblur'=>'hitungTotalHarga()','class'=>'span1', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
					<?php echo $form->dropDownList($modPengUmum,'satuanvol', LookupM::getItems('satuanumum'),array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
				</div>
			</div>
			<?php echo $form->textFieldRow($modPengUmum,'hargasatuan',array('onblur'=>'hitungTotalHarga()','class'=>'inputFormTabel integer reqForm', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>			
			<?php //echo $form->textFieldRow($modPengUmum,'namapenandatangan',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
			<?php //echo $form->textFieldRow($modPengUmum,'nippenandatangan',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
			<?php //echo $form->textFieldRow($modPengUmum,'jabatanpenandatangan',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
			<?php //echo $form->dropDownListRow($modPengUmum,'penjamin_id', CHtml::listData($modPengUmum->getPenjaminItems(1), 'penjamin_id', 'penjamin_nama'), array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
		</div>
		<div class="col-sm-4">
			<?php echo $form->textFieldRow($modPengUmum,'totalharga',array('readonly'=>true,'class'=>'inputFormTabel integer', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
			<?php echo $form->textAreaRow($modPengUmum,'keterangankeluar',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
		</div>
	</div>
        <fieldset class="box">
            <legend class="rim">
                <?php echo $form->checkBox($modPengUmum, 'isurainkeluarumum', array('checked'=>true,'onchange'=>'bukaUraian(this)','onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                Pilih Jika Transaksi Ada Uraiannya
            </legend>
            <div id="div_tblInputUraian">
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
                        <?php $this->renderPartial('_rowUraian',array('form'=>$form,'modUraian'=>$modUraian)); ?>
                    </tbody>
                </table>
            </div>
        </fieldset>
        <fieldset class="box">
            <legend class="rim">Data Tambahan</legend>
                <div class="row">
                        <div class="col-sm-4">
                                <?php
                                        $this->renderPartial('_rowListRekening',
                                                array(
                                                        'form'=>$form,'modUraian'=>$modUraian
                                                )
                                        );
                                ?>
                        </div>
                        <div class="col-sm-4">
                                <div class="control-group">
                                        <?php $modBuktiKeluar->tglkaskeluar = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modBuktiKeluar->tglkaskeluar, 'yyyy-MM-dd hh:mm:ss','medium',null)); ?>
                                        <?php echo $form->labelEx($modBuktiKeluar,'tglkaskeluar', array('class'=>'control-label inline')) ?>
                                        <div class="controls">
                                                <?php   
                                                                $this->widget('MyDateTimePicker',array(
                                                                                                'model'=>$modBuktiKeluar,
                                                                                                'attribute'=>'tglkaskeluar',
                                                                                                'mode'=>'datetime',
                                                                                                'options'=> array(
                                                                                                        'dateFormat'=>Params::DATE_FORMAT,
                                                                                                        'maxDate' => 'd',
                                                                                                ),
                                                                                                'htmlOptions'=>array('class'=>'dtPicker2-5', 'onkeypress'=>"return $(this).focusNextInputField(event)"
                                                                                                ),
                                                )); ?>

                                        </div>
                                </div>
                                <?php // echo $form->dropDownListRow($modBuktiKeluar,'tahun', CustomFunction::getTahun(null,null),array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>4)); ?>
                                <?php $modBuktiKeluar->tglkaskeluar = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modBuktiKeluar->tglkaskeluar, 'yyyy-MM-dd hh:mm:ss','medium',null)); ?>
                                <?php echo $form->textFieldRow($modBuktiKeluar,'nokaskeluar',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
                                <?php echo $form->textFieldRow($modBuktiKeluar,'biayaadministrasi',array('onkeyup'=>'hitungJmlBayar();','class'=>'inputFormTabel integer span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                                <?php echo $form->textFieldRow($modBuktiKeluar,'jmlkaskeluar',array('readonly'=>true,'class'=>'inputFormTabel integer span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                                <?php echo $form->dropDownListRow($modBuktiKeluar,'carabayarkeluar', LookupM::getItems('carabayarkeluar'),array('onchange'=>'formCarabayar(this.value)','class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
                                <div id="divCaraBayarTransfer" class="hide">
                                        <?php echo $form->textFieldRow($modBuktiKeluar,'melalubank',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
                                        <?php echo $form->textFieldRow($modBuktiKeluar,'denganrekening',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
                                        <?php echo $form->textFieldRow($modBuktiKeluar,'atasnamarekening',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
                                </div>
                        </div>
                        <div class="col-sm-4">
                                <?php echo $form->textFieldRow($modBuktiKeluar,'namapenerima',array('class'=>'span3 reqForm', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
                                <?php echo $form->textAreaRow($modBuktiKeluar,'alamatpenerima',array('class'=>'span3 reqForm', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                                <?php echo $form->textFieldRow($modBuktiKeluar,'untukpembayaran',array('class'=>'span3 reqForm', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
                        </div>
                </div>
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
                                        'onclick'=>'simpanPengeluaran(\'jurnal\');return false;',
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
                                            'onclick'=>'simpanPengeluaran(\'posting\');return false;'
                                        )
                                    ),
                                )
                            ),
                        ),
                    ));
                    echo CHtml::htmlButton(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), array('style'=>'display:none','id' => 'reseter', 'class' => 'btn btn-default', 'type'=>'reset'));
                 ?>
            </div>
                <?php //echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="entypo-print"></i>')), '#', array('class'=>'btn btn-info','onclick'=>"printKasir($('#FAPendaftaranT_pendaftaran_id').val());return false",'disabled'=>false)); ?>
                <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
                        Yii::app()->createUrl($this->module->id.'/pengeluaranKas/index'), 
                        array('class' => 'btn btn-default',
                              'onclick'=>'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;')); ?>
    <?php  
        $content = $this->renderPartial('../tips/transaksi',array(),true);
    //    $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
    ?>
        </div>
    
</fieldset>
</div> 
<?php $this->renderPartial('_jsFunctions',array('form'=>$form,'modUraian'=>$modUraian)); ?>	
<?php $this->endWidget(); ?>
<?php 
//========= Dialog buat cari data Rek Kredit =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogJenisPengeluaran',
    'options'=>array(
        'title'=>'Daftar Jenis Pengeluaran',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>600,
        'height'=>400,
        'resizable'=>false,
    ),
));

$modJenisPengeluaran = new JenispengeluaranM('search');
$modJenisPengeluaran->unsetAttributes();
if(isset($_GET['JenispengeluaranM'])) {
    $modJenisPengeluaran->attributes = $_GET['JenispengeluaranM'];
}
$this->widget('ext.bootstrap.widgets.HeaderGroupGridView',array(
	'id'=>'jenispengeluaran-m-grid',
        //'ajaxUrl'=>Yii::app()->createUrl('actionAjax/CariDataPasien'),
	'dataProvider'=>$modJenisPengeluaran->searchJnsPengeluaranInRek(),
	'filter'=>$modJenisPengeluaran,
	'template'=>"{summary}\n{items}\n{pager}",
	'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
                array(
                    'header' => 'No.',
                    'value'=>'$this->grid->dataProvider->Pagination->CurrentPage*$this->grid->dataProvider->pagination->pageSize+$row+1',
                ),
                array(
                    'header'=>'Jenis Pengeluaran',
                    'name'=>'jenispengeluaran_nama',
                    'value'=>'$data->jenispengeluaran_nama',
                ),
                array(
                    'header'=>'Nama Lain',
                    'name'=>'jenispengeluaran_namalain',
                    'value'=>'$data->jenispengeluaran_namalain',
                ),
                array(
                    'header'=>'Pilih',
                    'type'=>'raw',
                    'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                                    "id" => "selectRekDebit",
                                    "onClick" =>"
                                        getDataRekening($data->jenispengeluaran_id);
                                        $(\"#KUPengeluaranumumT_jenispengeluaran_id\").val(\"$data->jenispengeluaran_id\");
                                        $(\"#KUPengeluaranumumT_jenisKodeNama\").val(\"$data->jenispengeluaran_nama\");
                                        $(\"#dialogJenisPengeluaran\").dialog(\"close\");    
                                        return false;
                            "))',
                ),
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));

$this->endWidget();
//========= end Rek Kredit dialog =============================
?>