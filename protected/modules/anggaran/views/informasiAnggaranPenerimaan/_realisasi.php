<div class="white-container">
    <legend class="rim2">Transaksi Realisasi Anggaran Penerimaan</legend>
    <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'id' => 'realisasianggpen-t-form',
        'enableAjaxValidation' => false,
        'type' => 'horizontal',
        'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
        'focus' => '#' . CHtml::activeId($model, 'tglrealisasianggpen'),
    )); ?>
    <?php
    if (isset($_GET['sukses'])) {
        Yii::app()->user->setFlash('success', "Data realisasi anggaran penerimaan berhasil disimpan!");
    }
    ?>
    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
    <?php echo $form->errorSummary($modPenerimaan); ?>
    <?php echo $form->errorSummary($model); ?>
    <?php echo $this->renderPartial('_realisasiPenerimaan', array(
        'modTandaBuktiBayar' => $modTandaBuktiBayar,
        'modPenerimaan' => $modPenerimaan,
        'format' => $format,
        'form' => $form,
    )); ?>
    <?php /*
    <fieldset id="form-realisasipenerimaan" class="box">
        <legend class="rim">Data Penerimaan</legend>
		<div class="row">
			<div class="col-sm-4">
				<div class='control-group'>
					<?php echo CHtml::label('Tgl. Bukti Bayar <span class="required">*</span>', 'tglbuktibayar', array('class' => 'control-label')) ?>
					<div class="controls">
						<?php $modTandaBuktiBayar->tglbuktibayar = $format->formatDateTimeForUser($modTandaBuktiBayar->tglbuktibayar); ?>
						<?php 
							$this->widget('MyDateTimePicker', array(
								'model' => $modTandaBuktiBayar,
								'attribute' => 'tglbuktibayar', 
								'mode'=>'date',
								'options'=>array(
									'dateFormat' => Params::DATE_FORMAT,
								),
								'htmlOptions' => array('readonly' => true,
									'class' => "span2 required",
									'onkeypress' => "return $(this).focusNextInputField(event)"),
							));  
						?>
					</div>
				</div>
				<?php echo $form->textFieldRow($modPenerimaan,'noren_penerimaan',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'readonly'=>true)); ?>
			</div>
			<div class="span8">
				<div class="control-group">
					<?php echo $form->labelEx($modPenerimaan,'Periode Anggaran', array('class'=>'control-label')) ?>
						<div class="controls">
							<?php echo $form->textField($modPenerimaan,'deskripsiperiode',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'readonly'=>true)); ?>
							<?php echo $form->hiddenField($modPenerimaan,'konfiganggaran_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'readonly'=>true)); ?>
						</div>
				</div>
				<div class="control-group">
					<?php echo $form->labelEx($modPenerimaan,'Sumber Anggaran', array('class'=>'control-label')) ?>
						<div class="controls">
							<?php echo $form->textField($modPenerimaan,'sumberanggarannama',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'readonly'=>true)); ?>
							<?php echo $form->hiddenField($modPenerimaan,'sumberanggaran_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'readonly'=>true)); ?>
						</div>
				</div>
			<?php echo $form->hiddenField($modPenerimaan,'digitnilai',array('class'=>'span3 integer2', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'readonly'=>true)) ?>
			</div>
		</div>
    </fieldset>
 * 
 */ ?>
    <fieldset id="form-realisasianggpenerimaan" class="box">
        <legend class="rim">Data Realisasi Anggaran Penerimaan</legend>
        <div id="relangpen" class="row">
            <div class="col-sm-4">
                <div class="control-group">
                    <?php echo $form->labelEx($model, 'Termin Ke-', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php // echo $form->dropDownList($model, 'renanggaranpenerimaandet_id', CHtml::listData(AGRenanggaranpenerimaandetT::model()->findAllByAttributes(array('renanggpenerimaan_id'=>$modPenerimaan->renanggpenerimaan_id)), 'renanggaranpenerimaandet_id', 'renanggaran_ke'), array('empty'=>'-- Pilih --','class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'onchange'=>'terminke();')); 
                        ?>
                        <?php
                        $termin = array();
                        if (!empty($modPenerimaan->renanggpenerimaan_id)) {
                            $termin = $modDetail->getTermin($modPenerimaan->renanggpenerimaan_id);
                        }

                        echo $form->dropDownList($model, 'renanggaranpenerimaandet_id', CHtml::listData($termin, 'renanggaranpenerimaandet_id', 'renanggaran_ke'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'onchange' => 'terminke();')); ?>
                    </div>
                    <?php echo $form->hiddenField($model, 'penerimaanke', array('class' => 'span3 integer2', 'onkeypress' => "return $(this).focusNextInputField(event);", 'readonly' => true)); ?>
                </div>
                <div style="float:left;">
                    <?php echo $form->textFieldRow($model, 'nilaipenerimaan', array('class' => 'span3 integer2', 'onkeypress' => "return $(this).focusNextInputField(event);", 'readonly' => true)); ?>
                </div>
                <?php /*
				<div style="float:left;">
				<span id="digit-label-nilaipenerimaan" style="margin-left:10px;"></span>
				</div> */ ?>
            </div>
            <div class="col-sm-4">
                <?php echo $form->textFieldRow($model, 'realisasipenerimaan', array('class' => 'span3 integer2', 'onkeypress' => "return $(this).focusNextInputField(event);", 'onkeyup' => 'hitungJumlahBayar()')); ?>
                <?php echo $form->textFieldRow($modTandaBuktiBayar, 'biayamaterai', array('class' => 'span3 integer2', 'onkeypress' => "return $(this).focusNextInputField(event);", 'onkeyup' => 'hitungJumlahBayar()')); ?>
            </div>
            <div class="col-sm-4">
                <div class="control-group">
                    <?php echo $form->labelEx($modPenerimaan, 'Total Penerimaan', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->textField($modPenerimaan, 'nilaipenerimaananggaran', array('class' => 'span3 integer2', 'onkeypress' => "return $(this).focusNextInputField(event);", 'readonly' => true)); ?>
                    </div>
                    <span id="digit-label-totalpenerimaan" style="margin-left:10px;"></span>
                </div>
                <?php echo $form->textFieldRow($modTandaBuktiBayar, 'jmlpembayaran', array('class' => 'span3 integer2', 'onkeypress' => "return $(this).focusNextInputField(event);", 'readonly' => true)); ?>
            </div>
        </div>
    </fieldset>
    <fieldset id="form-realisasipenerimaanpembayaran" class="box">
        <legend class="rim">Penerimaan Pembayaran</legend>
        <div class="row">
            <div class="col-sm-4">
                <?php $carapembayaran = array("Tunai", "Transfer", "Cek"); ?>
                <?php echo $form->dropDownListRow($modTandaBuktiBayar, 'carapembayaran', $carapembayaran, array(
                    'empty' => '-- Pilih --',
                    'onkeypress' => "return $(this).focusNextInputField(event)",
                    'onchange' => 'setFormCaraPembayaran(this.value);',
                    'class' => 'span3 refreshable',
                )); ?>
                <?php $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                    'id' => 'form-transfer',
                    'content' => array(
                        'content-transfer' => array(
                            'header' => '<b>Pembayaran Transfer</b>',
                            'isi' => $this->renderPartial('_formTransfer', array(
                                'form' => $form,
                                'model' => $model
                            ), true),
                            'active' => false,
                        ),
                    ),
                    'htmlOptions' => array('style' => (($model->transfer) ? 'display:none' : '')),
                )); ?>
                <?php $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                    'id' => 'form-cek',
                    'content' => array(
                        'content-cek' => array(
                            'header' => '<b>Pembayaran Cek</b>',
                            'isi' => $this->renderPartial('_formCek', array(
                                'form' => $form,
                                'model' => $model
                            ), true),
                            'active' => false,
                        ),
                    ),
                    'htmlOptions' => array('style' => (($model->cek) ? 'display:none' : '')),
                )); ?>
            </div>
            <div class="span8">
                <?php echo $form->textFieldRow($modTandaBuktiBayar, 'darinama_bkm', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                <?php echo $form->textAreaRow($modTandaBuktiBayar, 'alamat_bkm', array('class' => 'span3 reqForm', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 32, 'readonly' => false)); ?>
            </div>
        </div>
    </fieldset>
    <fieldset id="form-realisasimengetahuimenyetujui" class="box">
        <div class="row">
            <div class="col-sm-6">
                <div class="control-group">
                    <?php echo $form->labelEx($model, 'peg_mengetahui_id', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->hiddenField($model, 'peg_mengetahui_id', array('readonly' => true)); ?>
                        <?php
                        $this->widget('MyJuiAutoComplete', array(
                            'model' => $model,
                            'attribute' => 'pegawaimengetahui_nama',
                            'source' => 'js: function(request, response) {
											   $.ajax({
												   url: "' . $this->createUrl('AutocompletePegawaiMengetahui') . '",
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
									$(this).val( ui.item.label);
									return false;
								}',
                                'select' => 'js:function( event, ui ) {
									$("#' . Chtml::activeId($model, 'peg_mengetahui_id') . '").val(ui.item.pegawai_id); 
									return false;
								}',
                            ),
                            'htmlOptions' => array(
                                'class' => 'pegawaimengetahui_nama',
                                'onkeyup' => "return $(this).focusNextInputField(event)",
                                'onblur' => 'if(this.value === "") $("#' . Chtml::activeId($model, 'peg_mengetahui_id') . '").val(""); '
                            ),
                            'tombolDialog' => array('idDialog' => 'dialogPegawaiMengetahui'),
                        ));
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="control-group">
                    <?php echo $form->labelEx($model, 'peg_menyetujui_id', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->hiddenField($model, 'peg_menyetujui_id', array('readonly' => true)); ?>
                        <?php
                        $this->widget('MyJuiAutoComplete', array(
                            'model' => $model,
                            'attribute' => 'pegawaimenyetujui_nama',
                            'source' => 'js: function(request, response) {
										   $.ajax({
											   url: "' . $this->createUrl('AutocompletePegawaiMenyetujui') . '",
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
								$(this).val( ui.item.label);
								return false;
							}',
                                'select' => 'js:function( event, ui ) {
								$("#' . Chtml::activeId($model, 'peg_menyetujui_id') . '").val(ui.item.pegawai_id); 
								return false;
							}',
                            ),
                            'htmlOptions' => array(
                                'class' => 'pegawaimenyetujui_nama',
                                'onkeyup' => "return $(this).focusNextInputField(event)",
                                'onblur' => 'if(this.value === "") $("#' . Chtml::activeId($model, 'peg_menyetujui_id') . '").val(""); '
                            ),
                            'tombolDialog' => array('idDialog' => 'dialogPegawaiMenyetujui'),
                        ));
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </fieldset>
    <div class="form-actions">
        <?php echo CHtml::htmlButton(
            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
            array(
                'class' => 'btn btn-danger',
                'type' => 'submit',
                'onKeypress' => 'return formSubmit(this,event)',
                'disabled' => isset($_GET['realisasianggpenerimaan_id']),
            )
        ); ?>
        <?php echo CHtml::link(
            Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
            $this->createUrl('realisasi'),
            array('class' => 'btn btn-default', 'onclick' => 'if(!confirm("' . Yii::t('mds', 'Apakah Anda akan mengulang input data ?') . '")) return false;')
        ); ?>
        <?php
        echo (!isset($_GET['realisasianggpenerimaan_id']) ?
            CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'disabled' => true)) :
            CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'disabled' => false, 'onclick' => 'print(\'REALISASI\')')));
        echo (!isset($_GET['realisasianggpenerimaan_id']) ?
            CHtml::htmlButton(Yii::t('mds', '{icon} Print Tanda Bukti Bayar', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'disabled' => true)) :
            CHtml::htmlButton(Yii::t('mds', '{icon} Print Tanda Bukti Bayar', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'disabled' => false, 'onclick' => 'print(\'TANDABUKTIBAYAR\')')));
        $urlPrint = $this->createUrl('printRealisasi', array('realisasianggpenerimaan_id' => isset($_GET['realisasianggpenerimaan_id']) ? $_GET['realisasianggpenerimaan_id'] : null));
        $js = <<< JSCRIPT
function print(jenisPrint)
{
    window.open("${urlPrint}"+"&jenisPrint="+jenisPrint,"",'location=_new, width=900px');
}
JSCRIPT;
        Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
        ?>

        <?php $content = $this->renderPartial('../tips/transaksiRealisasi', array(), true);
        $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content)); ?>
    </div>
</div>
<?php $this->endWidget(); ?>
<?php $this->renderPartial('_jsFunctions', array('model' => $model, 'modTandaBuktiBayar' => $modTandaBuktiBayar, 'modPenerimaan' => $modPenerimaan)); ?>

<?php
//========= Dialog buat cari data Pegawai Mengetahui =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPegawaiMengetahui',
    'options' => array(
        'title' => 'Pencarian Pegawai Mengetahui',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 500,
        'zIndex' => 1002,
        'resizable' => false,
    ),
));

$modPegawaiMengetahui = new AGPegawaiV('searchPegawaiMengetahui');
$modPegawaiMengetahui->unsetAttributes();
if (isset($_GET['AGPegawaiV'])) {
    $modPegawaiMengetahui->attributes = $_GET['AGPegawaiV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pegawaimengetahui-grid',
    'dataProvider' => $modPegawaiMengetahui->searchPegawaiMengetahui(),
    'filter' => $modPegawaiMengetahui,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small", 
                                    "href"=>"",
                                    "id" => "selectObat",
                                    "onClick" => "
                                                  $(\"#' . CHtml::activeId($model, 'peg_mengetahui_id') . '\").val(\"$data->pegawai_id\");
                                                  $(\"#' . CHtml::activeId($model, 'pegawaimengetahui_nama') . '\").val(\"$data->NamaLengkap\");
                                                  $(\"#dialogPegawaiMengetahui\").dialog(\"close\"); 
                                                  return false;
                                        "))',
        ),
        array(
            'header' => 'NIP',
            'value' => '$data->nomorindukpegawai',
        ),
        array(
            'header' => 'Gelar Depan',
            'filter' =>  CHtml::activeTextField($modPegawaiMengetahui, 'gelardepan'),
            'value' => '$data->gelardepan',
        ),
        array(
            'header' => 'Nama Pegawai',
            'filter' =>  CHtml::activeTextField($modPegawaiMengetahui, 'nama_pegawai'),
            'value' => '$data->nama_pegawai',
        ),
        array(
            'header' => 'Gelar Belakang',
            'filter' =>  CHtml::activeTextField($modPegawaiMengetahui, 'gelarbelakang_nama'),
            'value' => '$data->gelarbelakang_nama',
        ),
        array(
            'header' => 'Alamat Pegawai',
            'filter' =>  CHtml::activeTextField($modPegawaiMengetahui, 'alamat_pegawai'),
            'value' => '$data->alamat_pegawai',
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){
            jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
$this->endWidget();
//========= end Pegawai Mengetahui dialog =============================
?>

<?php
//========= Dialog buat cari data Pegawai Menyetujui =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPegawaiMenyetujui',
    'options' => array(
        'title' => 'Pencarian Pegawai Menyetujui',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 500,
        'zIndex' => 1002,
        'resizable' => false,
    ),
));

$modPegawaiMenyetujui = new AGPegawairuanganV('search');
$modPegawaiMenyetujui->unsetAttributes();
if (isset($_GET['AGPegawairuanganV'])) {
    $modPegawaiMenyetujui->attributes = $_GET['AGPegawairuanganV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pegawaimenyetujui-grid',
    'dataProvider' => $modPegawaiMenyetujui->searchPegawaiMenyetujui(),
    'filter' => $modPegawaiMenyetujui,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small", 
                                    "href"=>"",
                                    "id" => "selectObat",
                                    "onClick" => "
                                                  $(\"#' . CHtml::activeId($model, 'peg_menyetujui_id') . '\").val(\"$data->pegawai_id\");
                                                  $(\"#' . CHtml::activeId($model, 'pegawaimenyetujui_nama') . '\").val(\"$data->NamaLengkap\");
                                                  $(\"#dialogPegawaiMenyetujui\").dialog(\"close\"); 
                                                  return false;
                                        "))',
        ),
        array(
            'header' => 'NIP',
            'value' => '$data->nomorindukpegawai',
        ),
        array(
            'header' => 'Gelar Depan',
            'filter' =>  CHtml::activeTextField($modPegawaiMenyetujui, 'gelardepan'),
            'value' => '$data->gelardepan',
        ),
        array(
            'header' => 'Nama Pegawai',
            'filter' =>  CHtml::activeTextField($modPegawaiMenyetujui, 'nama_pegawai'),
            'value' => '$data->nama_pegawai',
        ),
        array(
            'header' => 'Gelar Belakang',
            'filter' =>  CHtml::activeTextField($modPegawaiMenyetujui, 'gelarbelakang_nama'),
            'value' => '$data->gelarbelakang_nama',
        ),
        array(
            'header' => 'Alamat Pegawai',
            'filter' =>  CHtml::activeTextField($modPegawaiMenyetujui, 'alamat_pegawai'),
            'value' => '$data->alamat_pegawai',
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){
            jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
$this->endWidget();
//========= end Pegawai Menyetujui dialog =============================
?>