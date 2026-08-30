<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'jenispengeluaran-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#',
)); ?>
<div class="row">
    <!--<p class="help-block"><?php // echo Yii::t('mds','Fields with <span class="required">*</span> are required.') 
                                ?></p>-->
    <?php echo $form->errorSummary($model); ?>
    <div class="col-sm-6">
        <div class='control-group'>
            <?php echo $form->labelEx($model, 'jenispengeluaran_kode', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'jenispengeluaran_kode', array('readonly' => true, 'class' => 'span3', 'maxlength' => 50)); ?>
            </div>
        </div>
        <div class='control-group'>
            <?php echo $form->labelEx($model, 'jenispengeluaran_nama', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'jenispengeluaran_nama', array('readonly' => true, 'class' => 'span3', 'maxlength' => 50)); ?>
            </div>
        </div>
        <div class='control-group'>
            <?php echo $form->labelEx($model, 'jenispengeluaran_namalain', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'jenispengeluaran_namalain', array('readonly' => true, 'class' => 'span3', 'maxlength' => 50)); ?>
            </div>
        </div>
        <div class='control-group'>
            <?php //echo $form->checkBoxRow($model,'jenispengeluaran_aktif',array('checked'=>'checked')); 
            ?>
        </div>
    </div>
    <div class="col-sm-6">
        <div class='control-group'>
            <?php
            $rekd = AKJnsPengeluaranRekM::model()->findByAttributes(array(
                'jenispengeluaran_id' => $model->jenispengeluaran_id,
                'debitkredit' => 'D',
            ));
            $rekk = AKJnsPengeluaranRekM::model()->findByAttributes(array(
                'jenispengeluaran_id' => $model->jenispengeluaran_id,
                'debitkredit' => 'K',
            ));

            $rek5 = empty($rekd) ? null : $rekd->rekening5_id;
            $rek5dat = empty($rekd) ? null : Rekening5M::model()->findByPk($rekd->rekening5_id);
            if (empty($rek5dat)) $rek5dat = new Rekening5M;
            $model->rekDebit = $rek5dat->nmrekening5;

            echo CHtml::label('Rekening Debit', 'rekening debit', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo CHtml::hiddenField('AKJnsPengeluaranRekM[rekening][1][rekening5_nb]', 'D', array('readonly' => true)); ?>
                <?php echo CHtml::hiddenField('AKJnsPengeluaranRekM[rekening][1][rekening5_id]', $rek5, array('readonly' => true)); ?>
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
                                $("#AKJnsPengeluaranRekM_rekening_1_rekening5_id").val(ui.item.rekening5_id);
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
            <?php echo CHtml::label('Rekening Kredit', 'rekening kredit', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                $rek5 = empty($rekk) ? null : $rekk->rekening5_id;
                $rek5dat = empty($rekk) ? null : Rekening5M::model()->findByPk($rekk->rekening5_id);
                if (empty($rek5dat)) $rek5dat = new Rekening5M;
                $model->rekKredit = $rek5dat->nmrekening5;

                ?>
                <?php echo CHtml::hiddenField('AKJnsPengeluaranRekM[rekening][2][rekening5_nb]', 'K', array('readonly' => true)); ?>
                <?php echo CHtml::hiddenField('AKJnsPengeluaranRekM[rekening][2][rekening5_id]', $rek5, array('readonly' => true)); ?>
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
                                $("#AKJnsPengeluaranRekM_rekening_2_rekening5_id").val(ui.item.rekening5_id);
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
    <?php echo CHtml::htmlButton(
        $model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="' . MyIcon::getIcons('simpan') . '"></i>')) :
            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="' . MyIcon::getIcons('simpan') . '"></i>')),
        array('class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
    );
    ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        Yii::app()->createUrl($this->module->id . '/jurnalRekPengeluaran/admin'),
        array(
            'class' => 'btn btn-default',
            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
        )
    );
    ?>
    <?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Jurnal Rekening Pengeluaran', array('{icon}' => '<i class="' . MyIcon::getIcons('pengaturan') . '"></i>')), $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'], 'tab' => isset($_GET['tab']) ? $_GET['tab'] : '')), array('class' => 'btn btn-success',)); ?>
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
        'height' => 600,
        'resizable' => false,
    ),
));

$modRekDebit = new RekeningakuntansiV('search');
$modRekDebit->unsetAttributes();
$modRekDebit->rekeninglast_nb = "D";
// $modRekDebit->rekening5_aktif = true;
$account = "";
if (isset($_GET['RekeningakuntansiV'])) {
    $modRekDebit->attributes = $_GET['RekeningakuntansiV'];
}


//$this->widget('ext.bootstrap.widgets.HeaderGroupGridViewNonRp',array(
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'rekdebit-m-grid',
    //'ajaxUrl'=>Yii::app()->createUrl('actionAjax/CariDataPasien'),
    'dataProvider' => $modRekDebit->searchAccounts($account),
    'filter' => $modRekDebit,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    //        JIKA INI DI AKTIFKAN MAKA FILTER AKAN HILANG
    //        'mergeHeaders'=>array(
    //            array(
    //                'name'=>'<p style="margin: 0; text-align: center;">Kode Rekening</p>',
    //                'start'=>1, //indeks kolom 3
    //                'end'=>5, //indeks kolom 4
    //            ),
    //        ),
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
				"id" => "selectRekDebit",
				"onClick" =>"
					$(\"#AKJnsPengeluaranRekM_rekening_1_rekening5_id\").val(\"$data->rekeninglast_id\");
					$(\"#AKJenispengeluaranM_rekDebit\").val(\"$data->nmrekeninglast\");                                                
					$(\"#dialogRekDebit\").dialog(\"close\");    
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
            'filter' => CHtml::activeDropDownList($modRekDebit, 'kelrekeninglast_id', CHtml::listData(
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
        ), /*
		array(
			'header'=>'Nama Lain',
			'name'=>'nmrekeninglain5',
			'value'=>'$data->nmrekeninglain5',
		), */
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
        'height' => 600,
        'resizable' => false,
    ),
));

$modRekKredit = new RekeningakuntansiV('search');
$modRekKredit->unsetAttributes();
$modRekKredit->rekeninglast_nb = "K";
//$account = "K";

$account = "";
if (isset($_GET['RekeningakuntansiV'])) {
    $modRekKredit->attributes = $_GET['RekeningakuntansiV'];
}

//$this->widget('ext.bootstrap.widgets.HeaderGroupGridViewNonRp',array(
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'rekkredit-m-grid',
    //'ajaxUrl'=>Yii::app()->createUrl('actionAjax/CariDataPasien'),
    'dataProvider' => $modRekKredit->searchAccounts($account),
    'filter' => $modRekKredit,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    //        JIKA INI DI AKTIFKAN MAKA FILTER AKAN HILANG
    //        'mergeHeaders'=>array(
    //            array(
    //                'name'=>'<p style="margin: 0; text-align: center;">Kode Rekening</p>',
    //                'start'=>1, //indeks kolom 3
    //                'end'=>4, //indeks kolom 4
    //            ),
    //        ),
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
				"id" => "selectRekDebit",
				"onClick" =>"
					$(\"#AKJnsPengeluaranRekM_rekening_2_rekening5_id\").val(\"$data->rekeninglast_id\");
					$(\"#AKJenispengeluaranM_rekKredit\").val(\"$data->nmrekeninglast\");
					$(\"#dialogRekKredit\").dialog(\"close\");    
					return false;
			"))',
        ),
        array(
            'header' => 'Kode Akun',
            'name' => 'kdrekening5',
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
        ), /*
		array(
			'header'=>'Nama Lain',
			'name'=>'nmrekeninglain5',
			'value'=>'$data->nmrekeninglain5',
		), */
        array(
            'header' => 'Saldo Normal',
            'name' => 'rekeninglast_nb',
            'value' => '($data->rekeninglast_nb == "K") ? "Kredit" : "Debit"',
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
        // window.parent.document.getElementById('frame').style= 'overflow-y:scroll;height:600px;';            
    }

    $('#tombolKreditRek, #tombolDebitRek').click(function() {
        changeSize();
    });
</script>