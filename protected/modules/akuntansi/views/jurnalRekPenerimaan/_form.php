<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>

<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'jenispenerimaan-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this)'),
    'focus' => '#AKJenispenerimaanM_jenispenerimaan_kode',
));
?>
<?php
                if (isset($_GET['sukses'])) {
                    Yii::app()->user->setFlash('success', "Data Jurnal Berhasil di Posting");
                }
                $this->widget('bootstrap.widgets.BootAlert');
                ?>
<!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.')
                            ?></p>-->

<div class="row">
    <?php echo $form->errorSummary($model); ?>
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label(" Jenis Penerimaan ", '', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php
                echo $form->hiddenField($model, 'jenispenerimaan_id', array('readonly' => true, 'class' => 'required'));
                $this->widget('MyJuiAutoComplete', array(
                    'model' => $model,
                    'attribute' => 'jenispenerimaan_nama',
                    'sourceUrl' => Yii::app()->createUrl('/ActionAutoComplete/JenisPenerimaan'),
                    'options' => array(
                        'showAnim' => 'fold',
                        'minLength' => 2,
                        'focus' => 'js:function( event, ui ) {
															$(this).val(ui.item.jenispenerimaan);
															return false;
													}',
                        'select' => 'js:function( event, ui ) {
													$(this).val(ui.item.nmrincianobyek);
													 //$("#AKJnsPenerimaanRekM_rekening_2_rekening5_id").val(ui.item.rekening5_id);
															return false;
											  }'
                    ),
                    'htmlOptions' => array(
                        'onkeypress' => "return $(this).focusNextInputField(event)",
                        'placeholder' => 'Jenis Penerimaan',
                        'class' => 'span3 required',
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogPenjaminPasien', 'idTombol' => 'tombolPenjaminPasien'),
                ));
                ?>
            </div>
        </div>
        <?php /*
				<div class='control-group'>
					<?php echo $form->labelEx($model, 'jenispenerimaan_kode', array('class' => 'control-label')) ?>
					<div class="controls">
											<?php echo $form->textField($model, 'jenispenerimaan_kode', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
					</div>
				</div>

				<div class='control-group'>
					<?php echo $form->labelEx($model, 'jenispenerimaan_nama', array('class' => 'control-label')) ?>
					<div class="controls">
											<?php echo $form->textField($model, 'jenispenerimaan_nama', array('class' => 'span3', 'onkeyup' => "namaLain(this)", 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
					</div>
				</div>

				<div class='control-group'>
					<?php echo $form->labelEx($model, 'jenispenerimaan_namalain', array('class' => 'control-label')) ?>
					<div class="controls">
											<?php echo $form->textField($model, 'jenispenerimaan_namalain', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
					</div>
				</div>
				 *
				 */ ?>
    </div>
    <div class="col-sm-6">
        <div class='control-group hide'>
            <?php echo CHtml::label('Rekening Debit', 'rekening debit', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo CHtml::hiddenField('AKJnsPenerimaanRekM[rekening][1][rekening5_nb]', 'D', array('readonly' => true)); ?>
                <?php echo CHtml::hiddenField('AKJnsPenerimaanRekM[rekening][1][rekening5_id]', '', array('readonly' => true, 'class' => '')); ?>
                <?php
                $this->widget('MyJuiAutoComplete', array(
                    'model' => $model,
                    'attribute' => 'rekDebit',
                    'sourceUrl' => Yii::app()->createUrl('ActionAutoComplete/RekeningAkuntansiDebit'),
                    'options' => array(
                        'showAnim' => 'fold',
                        'minLength' => 2,
                        'focus' => 'js:function( event, ui ) {
                                                                                $(this).val(ui.item.nmrekening5);
                                                                                return false;
                                                                        }',
                        'select' => 'js:function( event, ui ) {
                                                                                                $(this).val(ui.item.nmrekening5);
                                                                                                $("#AKJnsPenerimaanRekM_rekening_1_rekening5_id").val(ui.item.rekening5_id);
                                                                                                        return false;
                                                                                          }'
                    ),
                    'htmlOptions' => array(
                        'onkeypress' => "return $(this).focusNextInputField(event)",
                        'placeholder' => 'Nama Rekening',
                        'class' => 'span3',
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogRekDebit',),
                ));
                ?>
            </div>
            <div class="controls">
                <?php
                echo CHtml::htmlButton(
                    '<i class="icon-plus icon-white"></i>',
                    array(
                        'onclick' => 'tambahRekeningDebit();return false;',
                        'class' => 'btn btn-primary',
                        'onkeypress' => "tambahRekeningDebit();return false;",
                        'rel' => "tooltip",
                        'title' => "Klik untuk menambahkan",
                    )
                );
                ?>
            </div>
        </div>

        <div class='control-group'>
            <?php echo CHtml::label('Rekening Kredit', 'rekening kredit', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo CHtml::hiddenField('AKJnsPenerimaanRekM[rekening][2][rekening5_nb]', 'K', array('readonly' => true)); ?>
                <?php echo CHtml::hiddenField('AKJnsPenerimaanRekM[rekening][2][rekening5_id]', '', array('readonly' => true, 'class' => '')); ?>
                <?php
                $this->widget('MyJuiAutoComplete', array(
                    'model' => $model,
                    'attribute' => 'rekKredit',
                    'sourceUrl' => Yii::app()->createUrl('ActionAutoComplete/RekeningAkuntansiKredit'),
                    'options' => array(
                        'showAnim' => 'fold',
                        'minLength' => 2,
                        'focus' => 'js:function( event, ui ) {
                                                                                $(this).val(ui.item.nmrincianobyek);
                                                                                return false;
                                                                        }',
                        'select' => 'js:function( event, ui ) {
                                                                                                $(this).val(ui.item.nmrincianobyek);
                                                                                                 $("#AKJnsPenerimaanRekM_rekening_2_rekening5_id").val(ui.item.rekening5_id);
                                                                                                        return false;
                                                                                          }'
                    ),
                    'htmlOptions' => array(
                        'onkeypress' => "return $(this).focusNextInputField(event)",
                        'placeholder' => 'Nama Rekening',
                        'class' => 'span3',
                        // 'style'=>'width:150px;',
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogRekKredit',),
                ));

                ?>
            </div>
            <div class="controls">
                <?php
                echo CHtml::htmlButton(
                    '<i class="icon-plus icon-white"></i>',
                    array(
                        'onclick' => 'tambahRekeningKredit();return false;',
                        'class' => 'btn btn-primary',
                        'onkeypress' => "tambahRekeningKredit();return false;",
                        'rel' => "tooltip",
                        'title' => "Klik untuk menambahkan",
                    )
                );
                ?>
            </div>
        </div>
    </div>
</div>

<div class="panel panel-success hide">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-credit-card"></i> Tabel <b>Rekening Debit</b>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <table class="table table-bordered datatable" id="tab_rekening_debit">
            <thead>
                <tr>
                    <th>Rekening Debit</th>
                    <th width="50px">Batal</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>
<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-credit-card"></i> Tabel <b>Rekening Kredit</b>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <table class="table table-bordered datatable" id="tab_rekening_kredit">
            <thead>
                <tr>
                    <th>Rekening Kredit</th>
                    <th width="50px">Batal</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
</div>
<div class="form-actions">
    <?php
    echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
        Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="' . MyIcon::getIcons('simpan') . '"></i>')), array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)'));
    ?>
    <?php
    echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), Yii::app()->createUrl($this->module->id . '/jurnalRekPenerimaan/admin'), array(
        'class' => 'btn btn-default',
        'onclick' => 'myConfirm("Apakah Anda yakin ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
    ));
    ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Pengaturan Jurnal Rekening Penerimaan', array('{icon}' => '<i class="' . MyIcon::getIcons('pengaturan') . '"></i>')),
        $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'], 'tab' => isset($_GET['tab']) ? $_GET['tab'] : '')),
        array('class' => 'btn btn-success',)
    ); ?>
    <?php
    $tips = array(
        '0' => 'autocomplete-search',
        '1' => 'tambah2',
        '2' => 'batal',
        '3' => 'simpan',
        '4' => 'ulang'
    );
    $content = $this->renderPartial('sistemAdministrator.views.tips.detailTips', array('tips' => $tips), true);
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
					$(\"#AKJnsPenerimaanRekM_rekening_1_rekening5_id\").val(\"$data->rekeninglast_id\");
					$(\"#AKJenispenerimaanM_rekDebit\").val(\"$data->namarekeninglast\");                                                
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
					$(\"#AKJnsPenerimaanRekM_rekening_2_rekening5_id\").val(\"$data->rekeninglast_id\");
					$(\"#AKJenispenerimaanM_rekKredit\").val(\"$data->namarekeninglast\");
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

<?php
//========= Dialog jenis penerimaan=========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPenjaminPasien',
    'options' => array(
        'title' => 'Daftar Jenis Penerimaan',
        'autoOpen' => false,
        'modal' => true,
        'width' => 800,
        'height' => 500,
        'resizable' => false,
    ),
));

$dialogPenjamin = new JenispenerimaanM('search');
$dialogPenjamin->unsetAttributes();

if (isset($_GET['JenispenerimaanM'])) {
    $dialogPenjamin->attributes = $_GET['JenispenerimaanM'];
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'penjaminpasien-m-grid',
    'dataProvider' => $dialogPenjamin->searchDialog(),
    'filter' => $dialogPenjamin,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small",
				"id" => "selectPenjaminPasien",
				"onClick" =>"
					$(\"#' . CHtml::activeId($model, 'jenispenerimaan_id') . '\").val(\"$data->jenispenerimaan_id\");
					$(\"#' . CHtml::activeId($model, 'jenispenerimaan_nama') . '\").val(\"$data->jenispenerimaan_nama\");
					$(\"#dialogPenjaminPasien\").dialog(\"close\");
					return false;
			"))',
        ),
        array(
            'header' => 'Kode',
            'name' => 'jenispenerimaan_kode',
            'value' => '$data->jenispenerimaan_kode',
        ),
        array(
            'header' => 'Nama',
            'name' => 'jenispenerimaan_nama',
            'value' => '$data->jenispenerimaan_nama'
        )

    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
//========= end jenis pemerimaan =============================
?>

<script type="text/javascript">
    function namaLain(nama) {
        document.getElementById('AKJenispenerimaanM_jenispenerimaan_namalain').value = nama.value.toUpperCase();
    }

    var id = "";

    function tambahRekeningDebit() {
        id = $("#AKJnsPenerimaanRekM_rekening_1_rekening5_id").val();
        if (id.trim() == "") {
            myAlert("Rekening Debit Belum Dipilih");
            return false;
        }
        $.post('<?php echo $this->createUrl('formRekening'); ?>', {
            id: id,
            debitkredit: 'D',
        }, function(data) {
            $("#AKJnsPenerimaanRekM_rekening_1_rekening5_id").val("");
            $("#AKJenispenerimaanM_rekDebit").val("");
            $("#tab_rekening_debit tbody").append(data.dat);
        }, 'json');
    }

    function tambahRekeningKredit() {
        id = $("#AKJnsPenerimaanRekM_rekening_2_rekening5_id").val();
        nama = $("#AKJenispenerimaanM_rekKredit").val();
        if (id.trim() == "") {
            myAlert("Rekening Kredit Belum Dipilih");
            return false;
        }
        $.post('<?php echo $this->createUrl('formRekening'); ?>', {
            id: id,
            debitkredit: 'K',
        }, function(data) {
            $("#AKJnsPenerimaanRekM_rekening_2_rekening5_id").val("");
            $("#AKJenispenerimaanM_rekKredit").val("");
            $("#tab_rekening_kredit tbody").append(data.dat);
        }, 'json');
    }

    function batalRekening(obj) {
        myConfirm("Apakah Anda yakin ingin menghapus rekening ini?", "Perhatian!",
            function(r) {
                if (r) {
                    $(obj).parents("tr").remove();
                }
            });
    }

    $('#tombolKreditRek, #tombolDebitRek,  #tombolPenjaminPasien').click(function() {
        changeSize();
    });
</script>