<?php
$this->widget('application.extensions.moneymask.MMask', array(
    'element' => '.currency',
    'currency' => 'PHP',
    'config' => array(
        'symbol' => 'Rp ',
        'defaultZero' => true,
        'allowZero' => true,
        'precision' => 0,
    )
));
?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting.js'); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'penjaminpasien-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#',
)); ?>
<div class="row">
    <!--<p class="help-block"><?php // echo Yii::t('mds','Fields with <span class="required">*</span> are required.') 
                                ?></p>-->
    <?php echo $form->errorSummary($modeld); ?>
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label('Cara Pembayaran', '', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($modlookup, 'lookup_name', array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)", 'readonly' => true)); ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class='control-group'>
            <?php echo $form->labelEx($modlookup, 'rekening_debit', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                $modlookup->rekening_debit = $modeld->rekening5_id;
                echo $form->hiddenField($modlookup, 'rekening_debit', array('class' => 'span3', 'maxlength' => 50)); ?>
                <?php
                //var_dump($model["D"]->rekeningdebit->nmrekening5); die;
                if (!empty($modeld->rekening5_id)) $modlookup->rekDebit = $modeld->rekening5->nmrekening5;
                $this->widget('MyJuiAutoComplete', array(
                    'model' => $modlookup,
                    'attribute' => 'rekDebit',
                    'sourceUrl' => Yii::app()->createUrl('ActionAutoComplete/rekeningAkuntansi'),
                    'options' => array(
                        'showAnim' => 'fold',
                        'minLength' => 2,
                        'focus' => 'js:function( event, ui ) {
                                $(this).val(ui.item.nmrekening1);
                                return false;
                            }',
                        'select' => 'js:function( event, ui ) {
                                $(this).val(ui.item.nmrekening5);
                                $("#' . CHtml::activeId($modlookup, 'rekening_debit') . '").val(ui.item.rekening5_id);
                                return false;
                            }'
                    ),
                    'htmlOptions' => array(
                        'onkeypress' => "return $(this).focusNextInputField(event)",
                        'placeholder' => 'Nama Rekening',
                        'class' => 'span3',
                        'style' => 'width:150px;',
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogRekDebit', 'idTombol' => 'tombolDebitRek'),
                ));
                ?>
            </div>
        </div>

        <div class='control-group'>
            <?php echo $form->labelEx($modlookup, 'rekeningKredit', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                $modlookup->rekening_kredit = $modelk->rekening5_id;
                if (!empty($modelk->rekening5_id)) $modlookup->rekKredit = $modelk->rekening5->nmrekening5;
                echo $form->hiddenField($modlookup, 'rekening_kredit', array('class' => 'span3', 'maxlength' => 50)); ?>
                <?php
                $this->widget('MyJuiAutoComplete', array(
                    'model' => $modlookup,
                    'attribute' => 'rekKredit',
                    'sourceUrl' => Yii::app()->createUrl('ActionAutoComplete/rekeningAkuntansi'),
                    'options' => array(
                        'showAnim' => 'fold',
                        'minLength' => 2,
                        'focus' => 'js:function( event, ui ) {
                                $(this).val(ui.item.nmrekening1);
                                return false;
                            }',
                        'select' => 'js:function( event, ui ) {
                                $(this).val(ui.item.nmrekening5);
                                $("#' . CHtml::activeId($modlookup, 'rekening_debit') . '").val(ui.item.rekening5_id);
                                return false;
                            }'
                    ),
                    'htmlOptions' => array(
                        'onkeypress' => "return $(this).focusNextInputField(event)",
                        'placeholder' => 'Nama Rekening',
                        'class' => 'span3',
                        'style' => 'width:150px;',
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogRekKredit', 'idTombol' => 'tombolKreditRek'),
                ));
                ?>
            </div>
        </div>
    </div>
</div>
<div class="form-actions">
    <?php
    echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="' . MyIcon::getIcons('simpan') . '"></i>')),
        array('class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
    );
    ?>
    <?php
    echo CHtml::link(
        Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        Yii::app()->createUrl($this->module->id . '/jurnalRekPenjamin/admin'),
        array(
            'class' => 'btn btn-default',
            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
        )
    );
    ?>

    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Pengaturan Jurnal Rekening Cara Pembayaran', array('{icon}' => '<i class="' . MyIcon::getIcons('pengaturan') . '"></i>')),
        $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'], 'tab' => isset($_GET['tab']) ? $_GET['tab'] : '')),
        array('class' => 'btn btn-success',)
    ); ?>

    <?php
    $tips = array(
        '0' => 'autocomplete-search',
        '1' => 'simpan',
        '2' => 'ulang',
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
        'height' => 500,
        'resizable' => false,
    ),
));

$modRekDebit = new RekeningakuntansiV('searchAccounts');
$modRekDebit->unsetAttributes();
$modRekDebit->rekeninglast_nb = "D";
// $modRekDebit->rekening5_aktif = true;
if (isset($_GET['RekeningakuntansiV'])) {
    $modRekDebit->attributes = $_GET['RekeningakuntansiV'];
    // $modRekDebit->rekening5_nb = $account;
}

$this->widget('ext.bootstrap.widgets.HeaderGroupGridView', array(
    'id' => 'rekdebit-m-grid',
    //'ajaxUrl'=>Yii::app()->createUrl('actionAjax/CariDataPasien'),
    'dataProvider' => $modRekDebit->searchAccounts(),
    'filter' => $modRekDebit,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    /*
        'mergeHeaders'=>array(
            array(
                'name'=>'Kode Rekening',
                'start'=>1, //indeks kolom 3
                'end'=>5, //indeks kolom 4
            ),
            array(
                'name'=>'Saldo Normal',
                'start'=>8, //indeks kolom 3
                'end'=>9, //indeks kolom 4
            ),
        ),
     * 
     */
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                                    "id" => "selectRekDebit",
                                    "onClick" =>"
                                                $(\"#AKLookupM_rekening_debit\").val(\"$data->rekeninglast_id\");
                                                $(\"#AKLookupM_rekDebit\").val(\"$data->nmrekeninglast\");                                                
                                                $(\"#dialogRekDebit\").dialog(\"close\");    
                                                return false;
                            "))',
        ),
        array(
            'header' => 'Kode Akun',
            'name' => 'kdrekeninglast',
            'value' => '$data->kdrekeninglast',
        ),
        'nmrekening1',
        'nmrekening2',
        'nmrekening3',
        'nmrekening4',
        'nmrekening5',
        'nmrekening6',
        'nmrekening7',
        'nmrekening8',
        'nmrekening9',
        'nmrekening10',
        array(
            'header' => 'Nama Rekening Terakhir',
            'name' => 'nmrekeninglast',
            'value' => '$data->nmrekeninglast',
        ),
        array(
            'header' => 'Saldo Normal',
            'name' => 'rekeninglast_nb',
            'value' => '($data->rekeninglast_nb == "D") ? "Debit" : "Kredit"',
            'filter' =>  CHtml::activeDropDownList($modRekDebit, 'rekeninglast_nb', array('D' => 'Debit', 'K' => 'Kredit'), array('empty' => "-- Pilih --")),
        ),

    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
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
        'width' => 800,
        'height' => 500,
        'resizable' => false,
    ),
));

$modRekKredit = new RekeningakuntansiV('searchAccounts');
$modRekKredit->unsetAttributes();
$modRekKredit->rekeninglast_nb = "K";
// $modRekKredit->rekening5_aktif = true;

if (isset($_GET['RekeningakuntansiV'])) {
    $modRekKredit->attributes = $_GET['RekeningakuntansiV'];
    // $modRekKredit->rekening5_nb = $account;
}


$this->widget('ext.bootstrap.widgets.HeaderGroupGridView', array(
    'id' => 'rekkredit-m-grid',
    //'ajaxUrl'=>Yii::app()->createUrl('actionAjax/CariDataPasien'),
    'dataProvider' => $modRekKredit->search(),
    'filter' => $modRekKredit,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    /*
        'mergeHeaders'=>array(
            array(
                'name'=>'Kode Rekening',
                'start'=>1, //indeks kolom 3
                'end'=>5, //indeks kolom 4
            ),
        ),
     * 
     */
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                                    "id" => "selectRekDebit",
                                    "onClick" =>"
                                                $(\"#AKLookupM_rekening_kredit\").val(\"$data->rekeninglast_id\");
                                                $(\"#AKLookupM_rekKredit\").val(\"$data->nmrekeninglast\");
                                                $(\"#dialogRekKredit\").dialog(\"close\");    
                                                return false;
                            "))',
        ),
        array(
            'header' => 'Kode Akun',
            'name' => 'kdrekeninglast',
            'value' => '$data->kdrekeninglast',
        ),
        array(
            'header' => 'Kelompok Akun',
            'type' => 'raw',
            'value' => function ($data) {
                // $rek1 = Rekening1M::model()->findByPk($data->rekening1_id);
                $rek2 = KelrekeningM::model()->findByPk($data->kelrekeninglast_id);
                return $rek2 ? $rek2->namakelrekening : "-";
            },
            'filter' => CHtml::activeDropDownList($modRekKredit, 'kelrekeninglast_id', CHtml::listData(
                KelrekeningM::model()->findAll(array(
                    'condition' => 'kelrekening_aktif = true',
                    'order' => 'koderekeningkel',
                )),
                'kelrekening_id',
                'namakelrekening'
            ), array('empty' => '-- Pilih --')),
        ),
        'nmrekening1',
        'nmrekening2',
        'nmrekening3',
        'nmrekening4',
        'nmrekening5',
        'nmrekening6',
        'nmrekening7',
        'nmrekening8',
        'nmrekening9',
        'nmrekening10',
        array(
            'header' => 'Nama Rekening Terakhir',
            'name' => 'nmrekeninglast',
            'value' => '$data->nmrekeninglast',
        ),
        array(
            'header' => 'Saldo Normal',
            'name' => 'rekeninglast_nb',
            'value' => '($data->rekeninglast_nb == "D") ? "Debit" : "Kredit"',
            'filter' =>  CHtml::activeDropDownList($modRekKredit, 'rekeninglast_nb', array('D' => 'Debit', 'K' => 'Kredit'), array('empty' => "-- Pilih --")),
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
//========= end Rek Kredit dialog =============================
?>

<script>
    function changeSize() {
        window.parent.document.getElementById('frame').style = 'overflow-y:scroll;height:600px;';
    }

    $('#tombolKreditRek, #tombolDebitRek,  #tombolPenjaminPasien').click(function() {
        changeSize();
    });
</script>