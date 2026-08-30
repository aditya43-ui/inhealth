<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'reharga-jual-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#AKSumberdanaRekM_rekDebit',
)); ?>
<div class="row">
    <?php //if (isset($modDetails)){ echo $form->errorSummary($modDetails); } 
    ?>
    <?php echo $form->errorSummary($model); ?>
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label("Sumber Dana", '', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php
                echo $form->hiddenField($model, 'sumberdana_id', array('readonly' => true, 'class' => 'required'));
                $this->widget('MyJuiAutoComplete', array(
                    'model' => $model,
                    'attribute' => 'sumberdana_nama',
                    'sourceUrl' => Yii::app()->createUrl('/ActionAutoComplete/SumberDana'),
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
                        'placeholder' => 'Sumber Dana',
                        'class' => 'span3 required',
                        // 'style'=>'width:150px;',
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogPenjaminPasien', 'idTombol' => 'tombolPenjaminPasien'),
                ));
                ?>
            </div>
            <?php //echo $form->textFieldRow($model,'sumberdana_nama', array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)", 'readonly'=>false)); 
            ?>
        </div>
    </div>
    <div class="col-sm-6">
        <div class='control-group'>
            <?php echo $form->labelEx($model, 'rekening_debit', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                //$model->rekening_debit = $modeld->rekening5_id;
                echo $form->hiddenField($model, 'rekening_debit', array('class' => 'span3', 'maxlength' => 50)); ?>
                <?php
                //var_dump($model["D"]->rekeningdebit->nmrekening5); die;
                if (!empty($modeld->rekening5_id)) $model->rekDebit = $modeld->rekening5->nmrekening5;
                $this->widget('MyJuiAutoComplete', array(
                    'model' => $model,
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
                                $("#' . CHtml::activeId($model, 'rekening_debit') . '").val(ui.item.rekening5_id);
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
            <?php echo $form->labelEx($model, 'rekeningKredit', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                //$model->rekening_kredit = $modelk->rekening5_id;
                //if (!empty($modelk->rekening5_id)) $model->rekKredit = $modelk->rekening5->nmrekening5;
                echo $form->hiddenField($model, 'rekening_kredit', array('class' => 'span3', 'maxlength' => 50)); ?>
                <?php
                $this->widget('MyJuiAutoComplete', array(
                    'model' => $model,
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
                                $("#' . CHtml::activeId($model, 'rekening_debit') . '").val(ui.item.rekening5_id);
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
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        Yii::app()->createUrl($this->module->id . '/' . $this->id . '/create'),
        array(
            'class' => 'btn btn-default',
            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
        )
    ); ?>
    <?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Jurnal Rekening Sumber Dana', array('{icon}' => '<i class="' . MyIcon::getIcons('pengaturan') . '"></i>')), $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'], 'tab' => isset($_GET['tab']) ? $_GET['tab'] : '')), array('class' => 'btn btn-danger',)); ?>
    <?php
    $content = $this->renderPartial('akuntansi.views.tips.tipsaddedit3a', array(), true);
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
        'width' => 800,
        'height' => 700,
        'resizable' => false,
    ),
));
$account = "D";

$modRekDebit = new RekeningakuntansiV('searchAccounts');
$modRekDebit->unsetAttributes();
//$modRekDebit->rekening5_nb = $account;
$modRekDebit->rekening5_aktif = true;
if (isset($_GET['RekeningakuntansiV'])) {
    $modRekDebit->attributes = $_GET['RekeningakuntansiV'];
    // $modRekDebit->rekening5_nb = $account;
}

$c2 = new CDbCriteria();
$c3 = new CDbCriteria();
$c4 = new CDbCriteria();

$c2->compare('rekening1_id', $modRekDebit->rekening1_id);
$c2->addCondition('rekening2_aktif = true');
$c2->order = 'kdrekening2';

$r2 = Rekening2M::model()->findAll($c2);

$c3->compare('rekening2_id', $modRekDebit->rekening2_id);
$c3->addCondition('rekening3_aktif = true');
$c3->order = 'kdrekening3';

$r3 = Rekening3M::model()->findAll($c3);

$c4->compare('rekening3_id', $modRekDebit->rekening3_id);
$c4->addCondition('rekening4_aktif = true');
$c4->order = 'kdrekening4';

$r4 = Rekening4M::model()->findAll($c4);

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
                                                $(\"#SumberdanaM_rekening_debit\").val(\"$data->rekening5_id\");
                                                $(\"#SumberdanaM_rekDebit\").val(\"$data->nmrekening5\");                                                
                                                $(\"#dialogRekDebit\").dialog(\"close\");    
                                                return false;
                            "))',
        ),
        array(
            'header' => 'Kode Akun',
            'name' => 'kdrekening5',
            'value' => '$data->kdrekening5',
            'filter' => Chtml::activeTextField($modRekDebit, 'kdrekening5', array('class' => 'numbers-only', 'maxlength' => 10))
        ),
        array(
            'header' => 'Kelompok Akun',
            'type' => 'raw',
            'value' => function ($data) {
                $rek1 = Rekening1M::model()->findByPk($data->rekening1_id);
                $rek2 = KelrekeningM::model()->findByPk($rek1->kelrekening_id);
                return $rek2->namakelrekening;
            },
            'filter' => CHtml::activeDropDownList($modRekDebit, 'kelrekening_id', CHtml::listData(
                KelrekeningM::model()->findAll(array(
                    'condition' => 'kelrekening_aktif = true',
                    'order' => 'koderekeningkel',
                )),
                'kelrekening_id',
                'namakelrekening'
            ), array('empty' => '-- Pilih --')),
        ),
        array(
            'header' => 'Komponen',
            'name' => 'rekening1_id',
            'value' => '$data->nmrekening1',
            'filter' =>  CHtml::activeDropDownList(
                $modRekDebit,
                'rekening1_id',
                CHtml::listData(Rekening1M::model()->findAll(array(
                    'condition' => 'rekening1_aktif = true',
                    'order' => 'kdrekening1 asc',
                )), 'rekening1_id', 'nmrekening1'),
                array('empty' => '-- Pilih --')
            ),
        ),
        array(
            'header' => 'Unsur',
            'name' => 'rekening2_id',
            'value' => '$data->nmrekening2',
            'filter' =>  CHtml::activeDropDownList(
                $modRekDebit,
                'rekening2_id',
                CHtml::listData($r2, 'rekening2_id', 'nmrekening2'),
                array('empty' => '-- Pilih --')
            ),
        ),
        array(
            'header' => 'Kelompok Pos',
            'name' => 'rekening3_id',
            'value' => '$data->nmrekening3',
            'filter' =>  CHtml::activeDropDownList(
                $modRekDebit,
                'rekening3_id',
                CHtml::listData($r3, 'rekening3_id', 'nmrekening3'),
                array('empty' => '-- Pilih --')
            ),
        ),
        array(
            'header' => 'Pos',
            'name' => 'rekening4_id',
            'value' => '$data->nmrekening4',
            'filter' =>  CHtml::activeDropDownList(
                $modRekDebit,
                'rekening4_id',
                CHtml::listData($r4, 'rekening4_id', 'nmrekening4'),
                array('empty' => '-- Pilih --')
            ),
        ),
        array(
            'header' => 'Akun',
            'name' => 'nmrekening5',
            'value' => '$data->nmrekening5',
            'filter' => Chtml::activeTextField($modRekDebit, 'nmrekening5', array('class' => 'custom-only'))
        ),
        array(
            'header' => 'Saldo Normal',
            'name' => 'rekening5_nb',
            'value' => '($data->rekening5_nb == "D") ? "Debit" : "Kredit"',
            'filter' =>  CHtml::activeDropDownList($modRekDebit, 'rekening5_nb', array('D' => 'Debit', 'K' => 'Kredit'), array('empty' => "-- Pilih --")),
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});'
        . '$(".numbers-only").keyup(function() {
            setNumbersOnly(this);
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
        'width' => 800,
        'height' => 600,
        'resizable' => false,
    ),
));
$accounts = "K";
$modRekKredit = new RekeningakuntansiV('searchAccounts');
$modRekKredit->unsetAttributes();
//$modRekKredit->rekening5_nb = $accounts;
$modRekKredit->rekening5_aktif = true;

if (isset($_GET['RekeningakuntansiV'])) {
    $modRekKredit->attributes = $_GET['RekeningakuntansiV'];
    // $modRekKredit->rekening5_nb = $account;
}

$c2 = new CDbCriteria();
$c3 = new CDbCriteria();
$c4 = new CDbCriteria();

$c2->compare('rekening1_id', $modRekKredit->rekening1_id);
$c2->addCondition('rekening2_aktif = true');
$c2->order = 'kdrekening2';

$r2 = Rekening2M::model()->findAll($c2);

$c3->compare('rekening2_id', $modRekKredit->rekening2_id);
$c3->addCondition('rekening3_aktif = true');
$c3->order = 'kdrekening3';

$r3 = Rekening3M::model()->findAll($c3);

$c4->compare('rekening3_id', $modRekKredit->rekening3_id);
$c4->addCondition('rekening4_aktif = true');
$c4->order = 'kdrekening4';

$r4 = Rekening4M::model()->findAll($c4);

$this->widget('ext.bootstrap.widgets.HeaderGroupGridView', array(
    'id' => 'rekdebit1-m-grid',
    //'ajaxUrl'=>Yii::app()->createUrl('actionAjax/CariDataPasien'),
    'dataProvider' => $modRekKredit->searchAccounts(),
    'filter' => $modRekKredit,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    /*  'mergeHeaders'=>array(
            array(
                'name'=>'Kode Rekening',
                'start'=>1, //indeks kolom 3
                'end'=>5, //indeks kolom 4
            ),
        ),*/
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                                    "id" => "selectRekDebit",
                                    "onClick" =>"
                                                $(\"#SumberdanaM_rekening_kredit\").val(\"$data->rekening5_id\");
                                                $(\"#SumberdanaM_rekKredit\").val(\"$data->nmrekening5\");
                                                $(\"#dialogRekKredit\").dialog(\"close\");    
                                                return false;
                            "))',
        ),
        array(
            'header' => 'Kode Akun',
            'name' => 'kdrekening5',
            'value' => '$data->kdrekening5',
            'filter' => Chtml::activeTextField($modRekKredit, 'kdrekening5', array('class' => 'numbers-only', 'maxlength' => 10))
        ),
        array(
            'header' => 'Kelompok Akun',
            'type' => 'raw',
            'value' => function ($data) {
                $rek1 = Rekening1M::model()->findByPk($data->rekening1_id);
                $rek2 = KelrekeningM::model()->findByPk($rek1->kelrekening_id);
                return $rek2->namakelrekening;
            },
            'filter' => CHtml::activeDropDownList($modRekKredit, 'kelrekening_id', CHtml::listData(
                KelrekeningM::model()->findAll(array(
                    'condition' => 'kelrekening_aktif = true',
                    'order' => 'koderekeningkel',
                )),
                'kelrekening_id',
                'namakelrekening'
            ), array('empty' => '-- Pilih --')),
        ),
        array(
            'header' => 'Komponen',
            'name' => 'rekening1_id',
            'value' => '$data->nmrekening1',
            'filter' =>  CHtml::activeDropDownList(
                $modRekKredit,
                'rekening1_id',
                CHtml::listData(Rekening1M::model()->findAll(array(
                    'condition' => 'rekening1_aktif = true',
                    'order' => 'kdrekening1 asc',
                )), 'rekening1_id', 'nmrekening1'),
                array('empty' => '-- Pilih --')
            ),
        ),
        array(
            'header' => 'Unsur',
            'name' => 'rekening2_id',
            'value' => '$data->nmrekening2',
            'filter' =>  CHtml::activeDropDownList(
                $modRekKredit,
                'rekening2_id',
                CHtml::listData($r2, 'rekening2_id', 'nmrekening2'),
                array('empty' => '-- Pilih --')
            ),
        ),
        array(
            'header' => 'Kelompok Pos',
            'name' => 'rekening3_id',
            'value' => '$data->nmrekening3',
            'filter' =>  CHtml::activeDropDownList(
                $modRekKredit,
                'rekening3_id',
                CHtml::listData($r3, 'rekening3_id', 'nmrekening3'),
                array('empty' => '-- Pilih --')
            ),
        ),
        array(
            'header' => 'Pos',
            'name' => 'rekening4_id',
            'value' => '$data->nmrekening4',
            'filter' =>  CHtml::activeDropDownList(
                $modRekKredit,
                'rekening4_id',
                CHtml::listData($r4, 'rekening4_id', 'nmrekening4'),
                array('empty' => '-- Pilih --')
            ),
        ),
        array(
            'header' => 'Akun',
            'name' => 'nmrekening5',
            'value' => '$data->nmrekening5',
            'filter' => Chtml::activeTextField($modRekDebit, 'nmrekening5', array('class' => 'custom-only'))
        ),
        array(
            'header' => 'Saldo Normal',
            'name' => 'rekening5_nb',
            'value' => '($data->rekening5_nb == "D") ? "Debit" : "Kredit"',
            'filter' =>  CHtml::activeDropDownList($modRekKredit, 'rekening5_nb', array('D' => 'Debit', 'K' => 'Kredit'), array('empty' => "-- Pilih --")),
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
//========= end Rek Kredit dialog =============================
?>

<?php
//========= Dialog jenis penerimaan=========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPenjaminPasien',
    'options' => array(
        'title' => 'Daftar Sumber Dana',
        'autoOpen' => false,
        'modal' => true,
        'width' => 800,
        'height' => 500,
        'resizable' => false,
    ),
));

$dialogPenjamin = new SumberdanaM('search');
$dialogPenjamin->unsetAttributes();

if (isset($_GET['SumberdanaM'])) {
    $dialogPenjamin->attributes = $_GET['SumberdanaM'];
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
					$(\"#' . CHtml::activeId($model, 'sumberdana_id') . '\").val(\"$data->sumberdana_id\");					
					$(\"#' . CHtml::activeId($model, 'sumberdana_nama') . '\").val(\"$data->sumberdana_nama\");					
					$(\"#dialogPenjaminPasien\").dialog(\"close\");    
					return false;
			"))',
        ),
        array(
            'header' => 'Nama',
            'name' => 'sumberdana_nama',
            'value' => '$data->sumberdana_nama',
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
//========= end jenis pemerimaan =============================
?>

<script>
    function checkAllSumberdana() {
        if ($("#cekAll").is(":checked")) {
            $('#sumberdanarek-m-grid input[name*="pilihSumberdana"]').each(function() {
                $(this).attr('checked', true);
            })
        } else {
            $('#sumberdanarek-m-grid input[name*="pilihSumberdana"]').each(function() {
                $(this).removeAttr('checked');
            })
        }
        setAll();
    }

    function setAll(obj) {
        $('.cekList').each(function() {
            if ($(this).is(':checked')) {
                $(this).parents('tr').find('.cekList').val(1);
            } else {
                $(this).parents('tr').find('.cekList').val(0);
            }
        });
    }

    function changeSize() {
        window.parent.document.getElementById('frame').style = 'overflow-y:scroll;height:600px;';
    }


    $('#tombolKreditRek, #tombolDebitRek,  #tombolPenjaminPasien').click(function() {
        changeSize();
    });
</script>