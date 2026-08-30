<style>
    .integerFloat {
        text-align: right;
    }
</style>
<?php
$this->breadcrumbs = array(
    'Jurnal Umum',
);
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id;
$this->widget('bootstrap.widgets.BootAlert');
?>
<div class="row" id="inputJurnalUmum">
    <div class='divForForm'>
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
    </div>
    <div class="col-sm-12">
        <div class="panel panel-gradient">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-briefcase"></i> Jurnal <b>Umum</b>
                </div>
            </div>
            <div class="panel-body">
                <?php
                Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js');
                Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting.js');
                $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
                    'id' => 'form-jurnal-umum',
                    'enableAjaxValidation' => false,
                    'type' => 'horizontal',
                    'htmlOptions' => array(
                        'onKeyPress' => 'return disableKeyPress(event)',
                        'onSubmit' => 'return requiredCheck(this);'
                    ),
                    'focus' => '#',
                ));
                $this->widget('bootstrap.widgets.BootAlert');
                ?>
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <i class="glyphicon glyphicon-file"></i> Data <b>Jurnal</b>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <?php
                            echo $form->hiddenField(
                                $model,
                                "jurnalrekening_id",
                                array(
                                    'class' => 'span1',
                                    'onkeypress' => "return $(this).focusNextInputField(event)",
                                    'readonly' => false
                                )
                            );
                            ?>
                            <div class="col-sm-6">
                                <?php echo $form->dropDownListRow($model, 'jenisjurnal_id', JenisjurnalM::items(), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'reqForm span4')); ?>
                                <div class="control-group">
                                    <?php echo $form->labelEx($model, 'tglbuktijurnal', array('class' => 'control-label')) ?>
                                    <div class="controls">
                                        <?php
                                        $model->tglbuktijurnal = MyFormatter::formatDateTimeForUser($model->tglbuktijurnal);
                                        $model->tglreferensi = MyFormatter::formatDateTimeForUser($model->tglreferensi);
                                        $this->widget('MyDateTimePicker', array(
                                            'model' => $model,
                                            'attribute' => 'tglbuktijurnal',
                                            'mode' => 'datetime',
                                            'options' => array(
                                                'dateFormat' => Params::DATE_FORMAT,
                                                'maxDate' => 'd',
                                            ),
                                            'htmlOptions' => array(
                                                'class' => 'reqForm span3', 'onkeypress' => "return $(this).focusNextInputField(event)",
                                            ),
                                        ));
                                        ?>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <?php echo $form->labelEx($model, 'tglreferensi', array('class' => 'control-label')) ?>
                                    <div class="controls">
                                        <?php
                                        $this->widget('MyDateTimePicker', array(
                                            'model' => $model,
                                            'attribute' => 'tglreferensi',
                                            'mode' => 'datetime',
                                            'options' => array(
                                                'dateFormat' => Params::DATE_FORMAT,
                                                'maxDate' => 'd',
                                            ),
                                            'htmlOptions' => array(
                                                'class' => 'reqForm span3', 'onkeypress' => "return $(this).focusNextInputField(event)",
                                            ),
                                        ));
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <?php echo $form->textFieldRow($model, 'nobuktijurnal', array('class' => 'span4 reqForm', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 32, 'readonly' => true)); ?>
                                <?php echo $form->textFieldRow($model, 'kodejurnal', array('class' => 'span4 reqForm', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 32, 'readonly' => true)); ?>
                                <?php
                                if (!empty($model->rekperiod_id)) {
                                    echo $form->hiddenField(
                                        $model,
                                        'rekperiod_id',
                                        array(
                                            'class' => 'span1',
                                            'onkeypress' => "return $(this).focusNextInputField(event)",
                                            'readonly' => false
                                        )
                                    );
                                }
                                //                    echo $form->dropDownListRow($model,'rekperiod_id', RekperiodM::items(),array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'reqForm'));
                                ?>
                                <?php echo $form->textFieldRow($model, 'noreferensi', array('placeholder' => 'No. Referensi', 'class' => 'span4 reqForm', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 32, 'readonly' => false)); ?>
                                <?php // echo $form->textFieldRow($model, 'nobku', array('class' => 'span4  numbers-only', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 32, 'readonly' => false));
                                ?>
                                <?php echo $form->textAreaRow($model, 'urianjurnal', array('placeholder' => 'Uraian Jurnal', 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 32, 'readonly' => false)); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <i class="glyphicon glyphicon-file"></i> Detail <b>Jurnal</b>
                        </div>
                    </div>
                    <div class="panel-body table-responsive">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="control-group">
                                    <label class="control-label">Pilih Rekening</label>
                                    <div class="controls">
                                        <?php
                                        echo CHtml::dropDownList('isJenisRekenig', "", LookupM::getItems('jenis_rekening'), array(
                                            'empty' => '-- Pilih --',
                                            'onkeypress' => "return $(this).focusNextInputField(event)",
                                            'onchange' => 'setSaldoNormal(this)',
                                            'class' => 'span4',
                                        ));
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <?php
                                $this->widget('MyJuiAutoComplete', array(
                                    'model' => $model,
                                    'attribute' => 'rekening_nama',
                                    'sourceUrl' => Yii::app()->createUrl('ActionAutoComplete/rekeningAkuntansi'),
                                    'options' => array(
                                        'showAnim' => 'fold',
                                        'minLength' => 2,
                                        'focus' => 'js:function( event, ui ){return false;}',
                                        'select' => 'js:function( event, ui ){
                                                    getDataRekening(ui.item.rekening1_id,ui.item.rekening2_id,ui.item.rekening3_id,ui.item.rekening4_id,ui.item.rekening5_id);
                                                    return false;
                                                }'
                                    ),
                                    'htmlOptions' => array(
                                        'onkeypress' => "return $(this).focusNextInputField(event)",
                                        'placeholder' => 'Pilih rekening yang akan dijurnal',
                                        'class' => 'span4',
                                    ),
                                    'tombolDialog' => array('idDialog' => 'dialogRincianRek',),
                                ));
                                ?>
                            </div>
                        </div>
                        <?php echo $this->renderPartial('__gridDetailJurnal', array('modelJurDetail' => $modelJurDetail, 'form' => $form)); ?>
                    </div>
                </div>
                <div class="form-actions">
                    <?php
                    $this->widget('bootstrap.widgets.BootButtonGroup', array(
                        'type' => 'danger', // '', 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
                        'buttons' => array(
                            array(
                                'label' => 'Posting Jurnal',
                                'icon' => 'entypo-check',
                                'url' => '#',
                                'htmlOptions' => array(
                                    'onclick' => 'simpanJurnalUmum(\'jurnal\');return false;',
                                    'id' => 'btn_submit_jurnal',
                                    'class' => 'btn_group_submit',
                                )
                            ),
                            array(
                                'label' => '',
                                'items' => array(
                                    array(
                                        'label' => 'Posting',
                                        'icon' => 'icon-download',
                                        'url' => '#',
                                        'itemOptions' => array(
                                            'onclick' => 'simpanJurnalUmum(\'posting\');return false;',
                                            'id' => 'btn_posting_jurnal',
                                        )
                                    ),
                                ),
                                'htmlOptions' => array(
                                    'id' => 'btn_submit_detail',
                                    'class' => 'btn_group_submit',
                                ),
                            ),
                        )
                    ));
                    $content = $this->renderPartial('tips', array(), true);
                    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<!--/div-->
<?php $this->endWidget(); ?>
<?php
//========= Dialog buat cari data Rek Debit =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogRincianRek',
    'options' => array(
        'title' => 'Saldo Rekening',
        'autoOpen' => false,
        'modal' => true,
        'width' => 1000,
        'height' => 600,
        'resizable' => false,
    ),
));
$modRekDebit = new Rekeningakuntansi5V('searchDialogAccount');
$modRekDebit->unsetAttributes();
if (isset($_GET['Rekeningakuntansi5V'])) {
    $modRekDebit->attributes = $_GET['Rekeningakuntansi5V'];
    $modRekDebit->rekening5_id = (!empty($_GET['Rekeningakuntansi5V']['rekening5_id']) ? $_GET['Rekeningakuntansi5V']['rekening5_id'] : null);
    $modRekDebit->rekening6_id = (!empty($_GET['Rekeningakuntansi5V']['rekening6_id']) ? $_GET['Rekeningakuntansi5V']['rekening6_id'] : null);
    $modRekDebit->rekening7_id = (!empty($_GET['Rekeningakuntansi5V']['rekening7_id']) ? $_GET['Rekeningakuntansi5V']['rekening7_id'] : null);
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
                getDataRekening(\'$data->rekening1_id\',\'$data->rekening2_id\',\'$data->rekening3_id\',\'$data->rekening4_id\',\'$data->rekeninglast_id\');
					$(\"#dialogRincianRek\").dialog(\"close\");  
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
            'visible' => ((Yii::app()->user->getState("levelrekeninglast") >= 6) ? true : false)
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
            'visible' => ((Yii::app()->user->getState("levelrekeninglast") >= 7) ? true : false)
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
            'visible' => ((Yii::app()->user->getState("levelrekeninglast") >= 8) ? true : false)
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
<?php echo $this->renderPartial('_jsFunctions', array('redirect' => $redirect)); ?>