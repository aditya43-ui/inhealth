<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'bank-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#SABankM_propinsi_id',
));
?>
<!--<p class="help-block"><?php // echo Yii::t('mds','Fields with <span class="required">*</span> are required.') 
                            ?></p>-->
<?php echo $form->errorSummary($model); ?>

<div class="row">
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo $form->labelEx($model, 'propinsi_id', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php $model->propinsi_id = (!empty($model->propinsi_id)) ? $model->propinsi_id : Yii::app()->user->getState('propinsi_id'); ?>
                <?php echo $form->dropDownList(
                    $model,
                    'propinsi_id',
                    CHtml::listData($model->getPropinsiItems(), 'propinsi_id', 'propinsi_nama'),
                    array(
                        'class' => 'span3', 'empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",
                        'ajax' => array(
                            'type' => 'POST',
                            'url' => Yii::app()->createUrl('ActionDynamic/GetKabupaten', array('encode' => false, 'model_nama' => 'SABankM')),
                            'update' => '#SABankM_kabupaten_id',
                        )
                    )
                ); ?>
                <?php
                //                                echo CHtml::htmlButton('<i class="icon-plus-sign icon-white"></i>', 
                //                                                        array('class' => 'btn btn-danger','onclick'=>"{addPropinsi(); $('#dialogAddPropinsi').dialog('open');}",
                //                                                              'id'=>'btnAddPropinsi','onkeypress'=>"return $(this).focusNextInputField(event)",
                //                                                              'rel'=>'tooltip','title'=>'Klik untuk menambah '.$model->getAttributeLabel('propinsi_id'))) 
                ?>
                <?php echo $form->error($model, 'propinsi_id'); ?>
            </div>
        </div>

        <div class="control-group">
            <?php echo $form->labelEx($model, 'kabupaten_id', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php $model->kabupaten_id = (!empty($model->kabupaten_id)) ? $model->kabupaten_id : Yii::app()->user->getState('kabupaten_id'); ?>
                <?php echo $form->dropDownList(
                    $model,
                    'kabupaten_id',
                    CHtml::listData($model->getKabupatenItems($model->propinsi_id), 'kabupaten_id', 'kabupaten_nama'),
                    array(
                        'class' => 'span3', 'empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",
                        'ajax' => array(
                            'type' => 'POST',
                            'url' => Yii::app()->createUrl('ActionDynamic/GetKecamatan', array('encode' => false, 'namaModel' => 'SABankM'))
                        )
                    )
                ); ?>
                <?php
                //                                echo CHtml::htmlButton('<i class="icon-plus-sign icon-white"></i>', 
                //                                                        array('class' => 'btn btn-danger','onclick'=>"{addKabupaten(); $('#dialogAddKabupaten').dialog('open');}",
                //                                                              'id'=>'btnAddKabupaten','onkeypress'=>"return $(this).focusNextInputField(event)",
                //                                                              'rel'=>'tooltip','title'=>'Klik untuk menambah '.$model->getAttributeLabel('kabupaten_id'))) 
                ?>
                <?php echo $form->error($model, 'kabupaten_id'); ?>
            </div>
        </div>

        <div class='control-group'>
            <?php echo $form->labelEx($model, 'kodepos', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'kodepos', array('placeholder' => 'Kode Pos', 'class' => 'span3 numbers-only', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50, 'style' => 'width:150px;text-align:right;')); ?>
            </div>
        </div>

        <div class='control-group'>
            <?php echo $form->labelEx($model, 'negara', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'negara', array('placeholder' => 'Negara', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100, 'style' => 'width:150px;')); ?>
            </div>
        </div>

        <div class='control-group'>
            <?php echo $form->labelEx($model, 'matauang_id', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->dropDownList(
                    $model,
                    'matauang_id',
                    CHtml::listData(MatauangM::model()->findAll(), 'matauang_id', 'matauang'),
                    array('class' => 'span3', 'empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)")
                ); ?>
            </div>
        </div>

        <div class='control-group'>
            <?php echo $form->labelEx($model, 'namabank', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'namabank', array('placeholder' => 'Nama Bank', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100, 'style' => 'width:150px;')); ?>
            </div>
        </div>

        <div class='control-group'>
            <?php echo $form->labelEx($model, 'norekening', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'norekening', array('placeholder' => 'No. Rekening', 'class' => 'span3  numbers-only', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100, 'style' => 'width:150px;text-align:right;')); ?>
            </div>
        </div>
        <div class='control-group'>
            <?php echo CHtml::label('Atas Nama <span class="required">*</span>', 'bank_atasnama', array('class' => 'control-label required')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'bank_atasnama', array('placeholder' => 'Atas Nama', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100, 'style' => 'width:150px;')); ?>
            </div>
        </div>
        <div class='control-group'>
            <?php echo $form->labelEx($model, 'alamatbank', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textArea($model, 'alamatbank', array('placeholder' => 'Alamat Bank', 'rows' => 3, 'cols' => 30, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'style' => 'width:150px;')); ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class='control-group'>
            <?php echo $form->labelEx($model, 'telpbank1', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'telpbank1', array('placeholder' => 'Telp Bank 1', 'class' => 'span3  numbers-only', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50, 'style' => 'width:150px;text-align:right;')); ?>
            </div>
        </div>

        <div class='control-group'>
            <?php echo $form->labelEx($model, 'telpbank2', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'telpbank2', array('placeholder' => 'Telp Bank 2', 'class' => 'span3  numbers-only', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50, 'style' => 'width:150px;;text-align:right;')); ?>
            </div>
        </div>

        <div class='control-group'>
            <?php echo $form->labelEx($model, 'faxbank', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'faxbank', array('placeholder' => 'Fax Bank', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50, 'style' => 'width:150px;')); ?>
            </div>
        </div>

        <div class='control-group'>
            <?php echo $form->labelEx($model, 'emailbank', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'emailbank', array('placeholder' => 'Email Bank', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50, 'style' => 'width:150px;')); ?>
            </div>
        </div>

        <div class='control-group'>
            <?php echo $form->labelEx($model, 'website', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'website', array('placeholder' => 'Website', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50, 'style' => 'width:150px;')); ?>
            </div>
        </div>

        <div class='control-group'>
            <?php echo $form->labelEx($model, 'cabangdari', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'cabangdari', array('placeholder' => 'Cabang dari', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100, 'style' => 'width:150px;')); ?>
            </div>
        </div>

        <?php if (!$model->isNewRecord) { ?>
            <div class='control-group'>
                <?php echo CHtml::label("", 'bank_aktif', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->checkBox($model, 'bank_aktif', array('onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                    <label for="SABankM_bank_aktif">Aktif</label>
                </div>
            </div>
        <?php } ?>
        <div class='control-group'>
            <?php echo CHtml::label("", '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->checkBox($model, 'ispenerimaan', array('onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                <label for="SABankM_ispenerimaan">Penerimaan</label>
            </div>
        </div>
    </div>
</div>

<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-file"></i> Jurnal Rekening Bank
        </div>
    </div>
    <div class="panel-body">

        <div class="row">
            <div class="col-sm-6">
                <div class='control-group'>
                    <?php
                    $rek = Rekening5M::model()->findByPk($rekDebit->rekening5_id);
                    if (!empty($rek)) $rekDebit->rekDebit = $rek->nmrekening5;
                    echo CHtml::label('Rekening Debit <span class="required">*</span>', 'rekening debit', array('class' => 'control-label required')) ?>
                    <div class="controls">
                        <?php echo CHtml::hiddenField('SABankRekM[rekening][1][rekening5_id]', $rekDebit->rekening5_id, array('readonly' => true)); ?>
                        <?php
                        $this->widget('MyJuiAutoComplete', array(
                            'model' => $rekDebit,
                            'attribute' => 'rekDebit',
                            'sourceUrl' => Yii::app()->createUrl('ActionAutoComplete/rekeningAkuntansi'),
                            'options' => array(
                                'showAnim' => 'fold',
                                'minLength' => 2,
                                'focus' => 'js:function( event, ui ) {
												$(this).val(ui.item.nmrincianobyek);
												return false;
											}',
                                'select' => 'js:function( event, ui ) {
														$(this).val(ui.item.nmrincianobyek);
														$("#SABankRekM_rekening_1_rekening5_id").val(ui.item.rincianobyek_id);
															return false;
													  }'
                            ),
                            'htmlOptions' => array(
                                'onkeypress' => "return $(this).focusNextInputField(event)",
                                'placeholder' => 'Nama Rekening',
                                'class' => 'span3',
                                'style' => 'width:150px;',
                            ),
                            'tombolDialog' => array('idDialog' => 'dialogRekDebit',),
                        ));
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class='control-group'>
                    <?php
                    $rek = Rekening5M::model()->findByPk($rekKredit->rekening5_id);
                    if (!empty($rek)) $rekKredit->rekKredit = $rek->nmrekening5;
                    echo CHtml::label('Rekening Kredit <span class="required">*</span>', 'rekening kredit', array('class' => 'control-label required')) ?>
                    <div class="controls">
                        <?php echo CHtml::hiddenField('SABankRekM[rekening][2][rekening5_id]', $rekKredit->rekening5_id, array('readonly' => true)); ?>
                        <?php
                        $this->widget('MyJuiAutoComplete', array(
                            'model' => $rekKredit,
                            'attribute' => 'rekKredit',
                            'sourceUrl' => Yii::app()->createUrl('ActionAutoComplete/rekeningAkuntansi'),
                            'options' => array(
                                'showAnim' => 'fold',
                                'minLength' => 2,
                                'focus' => 'js:function( event, ui ) {
									$(this).val(ui.item.nmrincianobyek);
									return false;
								}',
                                'select' => 'js:function( event, ui ) {
									$(this).val(ui.item.nmrincianobyek);
									$("#SABankRekM_rekening_2_rekening5_id").val(ui.item.rincianobyek_id);
									return false;
								}'
                            ),
                            'htmlOptions' => array(
                                'onkeypress' => "return $(this).focusNextInputField(event)",
                                'placeholder' => 'Nama Rekening',
                                'class' => 'span3',
                                'style' => 'width:150px;',
                            ),
                            'tombolDialog' => array('idDialog' => 'dialogRekKredit',),
                        ));
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="form-actions">
    <?php echo CHtml::htmlButton(
        $model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="' . MyIcon::getIcons('simpan') . '"></i>')),
        array('class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        Yii::app()->createUrl($this->module->id . '/bankM/admin'),
        array(
            'class' => 'btn btn-default',
            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r) {if(r) window.location = window.location.href;} ); return false;'
        )
    ); ?>
    <?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Bank Penerimaan / Pengeluaran RS', array('{icon}' => '<i class="' . MyIcon::getIcons('pengaturan') . '"></i>')), $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-success',)); ?>
    <?php
    $content = $this->renderPartial('akuntansi.views.tips.tipsaddedit', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>

<?php $this->endWidget(); ?>


<?php
//========= Dialog buat cari data Rek Debit =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogRekDebit',
    'options' => array(
        'title' => 'Daftar Rekening Debit',
        'autoOpen' => false,
        'modal' => true,
        'width' => 1000,
        'height' => 400,
        'resizable' => false,
    ),
));

$modRekDebit = new Rekeningakuntansi5V('searchDialogAccount');
$modRekDebit->unsetAttributes();
$modRekDebit->rekeninglast_nb = "D";
$account = "";
if (isset($_GET['Rekeningakuntansi5V'])) {
    $modRekDebit->attributes = $_GET['Rekeningakuntansi5V'];
    $modRekDebit->rekening5_id = (!empty($_GET['Rekeningakuntansi5V']['rekening5_id']) ? $_GET['Rekeningakuntansi5V']['rekening5_id']: null);
    $modRekDebit->rekening6_id = (!empty($_GET['Rekeningakuntansi5V']['rekening6_id']) ? $_GET['Rekeningakuntansi5V']['rekening6_id']: null);
    $modRekDebit->rekening7_id = (!empty($_GET['Rekeningakuntansi5V']['rekening7_id']) ? $_GET['Rekeningakuntansi5V']['rekening7_id']: null);

}

//$this->widget('ext.bootstrap.widgets.HeaderGroupGridViewNonRp',array(
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'rekdebit-m-grid',
    //'ajaxUrl'=>Yii::app()->createUrl('actionAjax/CariDataPasien'),
    'dataProvider' => $modRekDebit->searchDialogAccount(),
    'filter' => $modRekDebit,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small",
				"id" => "selectRekDebit",
				"onClick" =>"
                $(\"#SABankRekM_rekening_1_rekening5_id\").val(\"$data->rekeninglast_id\");
                $(\"#SABankRekM_rekDebit\").val(\"$data->namarekeninglast\");  
                $(\"#dialogRekDebit\").dialog(\"close\"); 
					return false;
			"))',
        ),
        array(
            'header' => 'Kode Akun',
            'type' => 'raw',
            'value' => '$data->koderekeninglast',
            'filter' => Chtml::activeTextField($modRekDebit, 'koderekeninglast', array('class' => 'numbers-only', 'maxlength' => 12))
        ),
        array(
            'header' => 'Kelompok Akun',
            'type' => 'raw',
            'value' => function ($data) {
                $kel = KelrekeningM::model()->findByPk($data->kelompokrekeninglast_id);
                return $kel ? $kel->namakelrekening : "-";
            },
            'filter' => CHtml::activeDropDownList($modRekDebit, 'kelompokrekeninglast_id', CHtml::listData(
                KelrekeningM::model()->findAll(array(
                    'condition' => 'kelrekening_aktif = true',
                    'order' => 'koderekeningkel',
                )),
                'kelrekening_id',
                'namakelrekening'
            ), array('empty' => '-- Pilih --')),
        ),
        array(
            'header' => 'Rekening Level 1',
            'type' => 'raw',
            'value' => function ($data) {
                return $data->namarekening1;
            },
            'filter' => CHtml::activeDropDownList($modRekDebit, 'rekening1_id', CHtml::listData(
                Rekeningakuntansi8V::model()->findAll(array(
                    'condition' => 'rekening1_id is not null',
                    'order' => 'namarekening1 ASC',
                )),
                'rekening1_id',
                'namarekening1'
            ), array('empty' => '-- Pilih --')),
        ),
        array(
            'header' => 'Rekening Level 2',
            'type' => 'raw',
            'value' => function ($data) {
                return $data->namarekening2;
            },
            'filter' => CHtml::activeDropDownList($modRekDebit, 'rekening2_id', CHtml::listData(
                Rekeningakuntansi8V::model()->findAll(array(
                    'condition' => 'rekening2_id is not null',
                    'order' => 'namarekening2 ASC',
                )),
                'rekening2_id',
                'namarekening2'
            ), array('empty' => '-- Pilih --')),
        ),
        array(
            'header' => 'Rekening Level 3',
            'type' => 'raw',
            'value' => function ($data) {
                return $data->namarekening3;
            },
            'filter' => CHtml::activeDropDownList($modRekDebit, 'rekening3_id', CHtml::listData(
                Rekeningakuntansi8V::model()->findAll(array(
                    'condition' => 'rekening3_id is not null',
                    'order' => 'namarekening3 ASC',
                )),
                'rekening3_id',
                'namarekening3'
            ), array('empty' => '-- Pilih --')),
        ),
        array(
            'header' => 'Rekening Level 4',
            'type' => 'raw',
            'value' => function ($data) {
                return $data->namarekening4;
            },
            'filter' => CHtml::activeDropDownList($modRekDebit, 'rekening4_id', CHtml::listData(
                Rekeningakuntansi8V::model()->findAll(array(
                    'condition' => 'rekening4_id is not null',
                    'order' => 'namarekening4 ASC',
                )),
                'rekening4_id',
                'namarekening4'
            ), array('empty' => '-- Pilih --')),
        ),
        array(
            'header' => 'Rekening Level 5',
            'type' => 'raw',
            'value' => function ($data) {
                return $data->namarekening5;
            },
            'filter' => CHtml::activeDropDownList($modRekDebit, 'rekening5_id', CHtml::listData(
                Rekeningakuntansi8V::model()->findAll(array(
                    'condition' => 'rekening5_id is not null',
                    'order' => 'namarekening5 ASC',
                )),
                'rekening5_id',
                'namarekening5'
            ), array('empty' => '-- Pilih --')),
            'visible' => ((Yii::app()->user->getState("levelrekeninglast") >= 6) ? true: false)
        ),
        array(
            'header' => 'Rekening Level 6',
            'type' => 'raw',
            'value' => function ($data) {
                return $data->namarekening6;
            },
            'filter' => CHtml::activeDropDownList($modRekDebit, 'rekening6_id', CHtml::listData(
                Rekeningakuntansi8V::model()->findAll(array(
                    'condition' => 'rekening6_id is not null',
                    'order' => 'namarekening6 ASC',
                )),
                'rekening6_id',
                'namarekening6'
            ), array('empty' => '-- Pilih --')),
            'visible' => ((Yii::app()->user->getState("levelrekeninglast") >= 7) ? true: false)
        ),
        array(
            'header' => 'Rekening Level 7',
            'type' => 'raw',
            'value' => function ($data) {
                return $data->namarekening7;
            },
            'filter' => CHtml::activeDropDownList($modRekDebit, 'rekening7_id', CHtml::listData(
                Rekeningakuntansi8V::model()->findAll(array(
                    'condition' => 'rekening7_id is not null',
                    'order' => 'namarekening7 ASC',
                )),
                'rekening7_id',
                'namarekening7'
            ), array('empty' => '-- Pilih --')),
            'visible' => ((Yii::app()->user->getState("levelrekeninglast") >= 8) ? true: false)
        ),
        array(
            'header' => 'Nama Rekening Terakhir',
            'type' => 'raw',
            'value' => '$data->namarekeninglast',
            'filter' => Chtml::activeTextField($modRekDebit, 'namarekeninglast', array('class' => 'custom-only'))
        ),
        array(
            'header' => 'Saldo Normal',
            'type' => 'raw',
            'value' => '($data->rekeninglast_nb == "D") ? "Debit" : "Kredit"',
            'filter' =>  CHtml::activeDropDownList($modRekDebit, 'rekeninglast_nb', array('D' => 'Debit', 'K' => 'Kredit'), array('empty' => "-- Pilih --")),
        ),

    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});'
        . '$(".numbers-only").keyup(function() {
            setNumbersOnly(this);
            });
            $(".custom-only").keyup(function() {
            setCustomOnly(this);
            });'
        . '}',
));

$this->endWidget();
//========= end Rek Debit dialog =============================
?>

<?php
//========= Dialog buat cari data Rek Kredit =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogRekKredit',
    'options' => array(
        'title' => 'Daftar Rekening Kredit',
        'autoOpen' => false,
        'modal' => true,
        'width' => 1000,
        'height' => 400,
        'resizable' => false,
    ),
));

$modRekKredit = new Rekeningakuntansi5V('searchDialogAccount');
$modRekKredit->unsetAttributes();
$modRekKredit->rekeninglast_nb = "K";
$account = "";
if (isset($_GET['Rekeningakuntansi5V'])) {
    $modRekKredit->attributes = $_GET['Rekeningakuntansi5V'];
    $modRekKredit->rekening5_id = (!empty($_GET['Rekeningakuntansi5V']['rekening5_id']) ? $_GET['Rekeningakuntansi5V']['rekening5_id']: null);
    $modRekKredit->rekening6_id = (!empty($_GET['Rekeningakuntansi5V']['rekening6_id']) ? $_GET['Rekeningakuntansi5V']['rekening6_id']: null);
    $modRekKredit->rekening7_id = (!empty($_GET['Rekeningakuntansi5V']['rekening7_id']) ? $_GET['Rekeningakuntansi5V']['rekening7_id']: null);
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'rekkredit-m-grid',
    'dataProvider' => $modRekKredit->searchDialogAccount(),
    'filter' => $modRekKredit,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small",
				"id" => "selectRekDebit",
				"onClick" =>"
                    $(\"#SABankRekM_rekening_2_rekening5_id\").val(\"$data->rekeninglast_id\");
                    $(\"#SABankRekM_rekKredit\").val(\"$data->namarekeninglast\");
                    $(\"#dialogRekKredit\").dialog(\"close\");     
					return false;
			"))',
        ),
        array(
            'header' => 'Kode Akun',
            'type' => 'raw',
            'value' => '$data->koderekeninglast',
            'filter' => Chtml::activeTextField($modRekKredit, 'koderekeninglast', array('class' => 'numbers-only', 'maxlength' => 12))
        ),
        array(
            'header' => 'Kelompok Akun',
            'type' => 'raw',
            'value' => function ($data) {
                $kel = KelrekeningM::model()->findByPk($data->kelompokrekeninglast_id);
                return $kel ? $kel->namakelrekening : "-";
            },
            'filter' => CHtml::activeDropDownList($modRekKredit, 'kelompokrekeninglast_id', CHtml::listData(
                KelrekeningM::model()->findAll(array(
                    'condition' => 'kelrekening_aktif = true',
                    'order' => 'koderekeningkel',
                )),
                'kelrekening_id',
                'namakelrekening'
            ), array('empty' => '-- Pilih --')),
        ),
        array(
            'header' => 'Rekening Level 1',
            'type' => 'raw',
            'value' => function ($data) {
                return $data->namarekening1;
            },
            'filter' => CHtml::activeDropDownList($modRekKredit, 'rekening1_id', CHtml::listData(
                Rekeningakuntansi8V::model()->findAll(array(
                    'condition' => 'rekening1_id is not null',
                    'order' => 'namarekening1 ASC',
                )),
                'rekening1_id',
                'namarekening1'
            ), array('empty' => '-- Pilih --')),
        ),
        array(
            'header' => 'Rekening Level 2',
            'type' => 'raw',
            'value' => function ($data) {
                return $data->namarekening2;
            },
            'filter' => CHtml::activeDropDownList($modRekKredit, 'rekening2_id', CHtml::listData(
                Rekeningakuntansi8V::model()->findAll(array(
                    'condition' => 'rekening2_id is not null',
                    'order' => 'namarekening2 ASC',
                )),
                'rekening2_id',
                'namarekening2'
            ), array('empty' => '-- Pilih --')),
        ),
        array(
            'header' => 'Rekening Level 3',
            'type' => 'raw',
            'value' => function ($data) {
                return $data->namarekening3;
            },
            'filter' => CHtml::activeDropDownList($modRekKredit, 'rekening3_id', CHtml::listData(
                Rekeningakuntansi8V::model()->findAll(array(
                    'condition' => 'rekening3_id is not null',
                    'order' => 'namarekening3 ASC',
                )),
                'rekening3_id',
                'namarekening3'
            ), array('empty' => '-- Pilih --')),
        ),
        array(
            'header' => 'Rekening Level 4',
            'type' => 'raw',
            'value' => function ($data) {
                return $data->namarekening4;
            },
            'filter' => CHtml::activeDropDownList($modRekKredit, 'rekening4_id', CHtml::listData(
                Rekeningakuntansi8V::model()->findAll(array(
                    'condition' => 'rekening4_id is not null',
                    'order' => 'namarekening4 ASC',
                )),
                'rekening4_id',
                'namarekening4'
            ), array('empty' => '-- Pilih --')),
        ),
        array(
            'header' => 'Rekening Level 5',
            'type' => 'raw',
            'value' => function ($data) {
                return $data->namarekening5;
            },
            'filter' => CHtml::activeDropDownList($modRekKredit, 'rekening5_id', CHtml::listData(
                Rekeningakuntansi8V::model()->findAll(array(
                    'condition' => 'rekening5_id is not null',
                    'order' => 'namarekening5 ASC',
                )),
                'rekening5_id',
                'namarekening5'
            ), array('empty' => '-- Pilih --')),
            'visible' => ((Yii::app()->user->getState("levelrekeninglast") >= 6) ? true: false)
        ),
        array(
            'header' => 'Rekening Level 6',
            'type' => 'raw',
            'value' => function ($data) {
                return $data->namarekening6;
            },
            'filter' => CHtml::activeDropDownList($modRekKredit, 'rekening6_id', CHtml::listData(
                Rekeningakuntansi8V::model()->findAll(array(
                    'condition' => 'rekening6_id is not null',
                    'order' => 'namarekening6 ASC',
                )),
                'rekening6_id',
                'namarekening6'
            ), array('empty' => '-- Pilih --')),
            'visible' => ((Yii::app()->user->getState("levelrekeninglast") >= 7) ? true: false)
        ),
        array(
            'header' => 'Rekening Level 7',
            'type' => 'raw',
            'value' => function ($data) {
                return $data->namarekening7;
            },
            'filter' => CHtml::activeDropDownList($modRekKredit, 'rekening7_id', CHtml::listData(
                Rekeningakuntansi8V::model()->findAll(array(
                    'condition' => 'rekening7_id is not null',
                    'order' => 'namarekening7 ASC',
                )),
                'rekening7_id',
                'namarekening7'
            ), array('empty' => '-- Pilih --')),
            'visible' => ((Yii::app()->user->getState("levelrekeninglast") >= 8) ? true: false)
        ),
        array(
            'header' => 'Nama Rekening Terakhir',
            'type' => 'raw',
            'value' => '$data->namarekeninglast',
            'filter' => Chtml::activeTextField($modRekKredit, 'namarekeninglast', array('class' => 'custom-only'))
        ),
        array(
            'header' => 'Saldo Normal',
            'type' => 'raw',
            'value' => '($data->rekeninglast_nb == "D") ? "Debit" : "Kredit"',
            'filter' =>  CHtml::activeDropDownList($modRekKredit, 'rekeninglast_nb', array('D' => 'Debit', 'K' => 'Kredit'), array('empty' => "-- Pilih --")),
        ),

    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});'
        . '$(".numbers-only").keyup(function() {
            setNumbersOnly(this);
            });
            $(".custom-only").keyup(function() {
            setCustomOnly(this);
            });'
        . '}',
));

$this->endWidget();
//========= end Rek Kredit dialog =============================
?>

<script>
    function cekValidasi() {
        if ($("#SABankM_namabank").val().trim() === "") {
            myAlert("Nama Bank harus diisi");
            return false;
        }

        if ($("#SABankM_norekening").val().trim() === "") {
            myAlert("No. Rekening Bank harus diisi");
            return false;
        }

        if ($("#SABankRekM_rekDebit").val().trim() == "") {
            myAlert("Rekening debit harus di isi");
            return false;
        }

        if ($("#SABankRekM_rekKredit").val().trim() == "") {
            myAlert("Rekening kredit harus di isi");
            return false;
        }

        return true;
    }
</script>