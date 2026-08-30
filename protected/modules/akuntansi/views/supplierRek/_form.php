<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'reharga-jual-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#AKSupplierRekM_rekDebit',
)); ?>

<?php
//if (isset($modDetails)){ echo $form->errorSummary($modDetails); }
?>
<fieldset class="">
    <?php echo $form->errorSummary($model); ?>
    <div class="panel panel-success">
        <div class="panel-heading">
            <div class="panel-title"><b>Supplier</b></div>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-sm-12">

                    <div class="control-group">
                        <?php echo CHtml::label("Supplier *", '', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php
                            echo $form->hiddenField($model, 'supplier_id', array('readonly' => true, 'class' => 'required'));
                            $this->widget('MyJuiAutoComplete', array(
                                'model' => $model,
                                'attribute' => 'supplier_nama',
                                'sourceUrl' => Yii::app()->createUrl('/ActionAutoComplete/Supplier'),
                                'options' => array(
                                    'showAnim' => 'fold',
                                    'minLength' => 2,
                                    'focus' => 'js:function( event, ui ) {
																$(this).val(ui.item.supplier_nama);
																return false;
														}',
                                    'select' => 'js:function( event, ui ) {
														$(this).val(ui.item.supplier_nama);
														 //$("#AKJnsPenerimaanRekM_rekening_2_rekening5_id").val(ui.item.rekening5_id);
																return false;
												  }'
                                ),
                                'htmlOptions' => array(
                                    'onkeypress' => "return $(this).focusNextInputField(event)",
                                    'placeholder' => 'Supplier',
                                    'class' => 'span3 required',
                                    // 'style'=>'width:150px;',
                                ),
                                'tombolDialog' => array('idDialog' => 'dialogPenjaminPasien', 'idTombol' => 'tombolPenjaminPasien'),
                            ));
                            ?>
                        </div>
                    </div>

                </div>
                <!--<div class="col-sm-6">
                    <?php echo $form->textFieldRow($modSupplier, 'supplier_kode', array('class' => 'span2 numbersOnly', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 10)); ?>
                    <?php echo $form->textFieldRow($modSupplier, 'supplier_nama', array('class' => 'span3', 'onkeyup' => "namaLain(this)",  'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                    <?php echo $form->dropDownListRow(
                        $modSupplier,
                        'pbf_id',
                        CHtml::listData(PbfM::model()->findAll("pbf_aktif = TRUE ORDER BY pbf_nama ASC"), 'pbf_id', 'pbf_nama'),
                        array(
                            'readonly' => false, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)",
                            'empty' => '-- Pilih --',
                        )
                    ); ?>
                    <?php echo $form->textFieldRow($modSupplier, 'supplier_namalain', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                    <?php echo $form->textAreaRow($modSupplier, 'supplier_alamat', array('rows' => 4, 'cols' => 30, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                    <?php echo $form->textFieldRow($modSupplier, 'supplier_kodepos', array('style' => 'text-align:right;', 'class' => 'span1 numbersOnly', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                    <div class="control-group">
                        <?php echo CHtml::activeLabel($modSupplier, 'longitude', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php echo $form->textField($modSupplier, 'longitude', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                            <?php /* echo CHtml::htmlButton('<i class="entypo-search"></i>',
                                                    array(
            //						  'onclick'=>'$("#dialogLongitudeLatitude").dialog("open");return false;',
                                                              'class' => 'btn btn-danger',
                                                              'rel'=>"tooltip",
                                                              'id'=>'yw1',
                                                              'title'=>"Klik untuk mencari Longitude & Latitude",));
                                     */  ?>
                        </div>
                    </div>
                    <?php echo $form->textFieldRow($modSupplier, 'latitude', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>                    
                </div>
                <div class="col-sm-6">
                    <?php echo $form->dropDownListRow($modSupplier, 'supplier_propinsi', CHtml::listData($modSupplier->PropinsiItems, 'propinsi_nama', 'propinsi_nama'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)", 'ajax' => array('type' => 'POST', 'url' => $this->createUrl('GetKabupatendrNamaPropinsi', array('encode' => false, 'namaModel' => 'SASupplierM', 'attr' => 'supplier_propinsi')), 'update' => '#SASupplierM_supplier_kabupaten'))); ?>
                    <?php echo $form->dropDownListRow($modSupplier, 'supplier_kabupaten', CHtml::listData($modSupplier->KabupatenItems, 'kabupaten_nama', 'kabupaten_nama'), array('class' => 'inputRequire span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --',)); ?>  
                    <?php echo $form->textFieldRow($modSupplier, 'supplier_telp', array('style' => 'text-align:right;', 'class' => 'span2 numbersOnly', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                    <?php echo $form->textFieldRow($modSupplier, 'supplier_fax', array('style' => 'text-align:right;', 'class' => 'span2 numbersOnly', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>            
                    <?php echo $form->textFieldRow($modSupplier, 'supplier_npwp', array('class' => 'span3 numbersOnly', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100, 'style' => 'text-align:right;',)); ?>
                    <?php echo $form->textFieldRow($modSupplier, 'supplier_website', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                    <?php echo $form->textFieldRow($modSupplier, 'supplier_email', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                    <?php echo $form->textFieldRow($modSupplier, 'supplier_cp', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                    <?php echo $form->textFieldRow($modSupplier, 'supplier_norekening', array('class' => 'span2 numbersOnly', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100, 'style' => 'text-align:right;',)); ?>
                    <?php echo $form->dropDownListRow($modSupplier, 'supplier_jenis',  LookupM::model()->getItems('jenissupplier'), array('class' => 'span2 ', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
       
                </div>-->
            </div>
        </div>
    </div>
    <div class="panel panel-success">
        <div class="panel-heading">
            <div class="panel-title">Rekening Supplier</div>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-sm-6">
                    <div class='control-group'>
                        <?php echo $form->labelEx($model, 'rekening debit', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo CHtml::hiddenField('AKSupplierRekM[rekening][1][rekening5_nb]', 'D', array('class' => 'span3')); ?>
                            <?php echo CHtml::hiddenField('AKSupplierRekM[rekening][1][rekening5_id]', '', array('class' => 'span3')); ?>
                            <?php echo CHtml::hiddenField('AKSupplierRekM[rekening][1][rekening4_id]', '', array('class' => 'span3')); ?>
                            <?php echo CHtml::hiddenField('AKSupplierRekM[rekening][1][rekening3_id]', '', array('class' => 'span3')); ?>
                            <?php echo CHtml::hiddenField('AKSupplierRekM[rekening][1][rekening2_id]', '', array('class' => 'span3')); ?>
                            <?php echo CHtml::hiddenField('AKSupplierRekM[rekening][1][rekening1_id]', '', array('class' => 'span3')); ?>
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
                                                        $("#AKSupplierRekM_rekening_1_rekening5_id").val(ui.item.rekening5_id);
                                                        $("#AKSupplierRekM_rekening_1_rekening4_id").val(ui.item.rekening4_id);
                                                        $("#AKSupplierRekM_rekening_1_rekening3_id").val(ui.item.rekening3_id);
                                                        $("#AKSupplierRekM_rekening_1_rekening2_id").val(ui.item.rekening2_id);
                                                        $("#AKSupplierRekM_rekening_1_rekening1_id").val(ui.item.rekening1_id);
                                                            return false;
                                                      }'
                                ),
                                'htmlOptions' => array(
                                    'onkeypress' => "return $(this).focusNextInputField(event)",
                                    'placeholder' => 'Nama Rekening',
                                    'class' => 'span3',
                                    'style' => 'width:150px;',
                                ),
                                'tombolDialog' => array('idDialog' => 'dialogRekDebit', 'idTombol' => "tombolDebitRek"),
                            ));
                            ?>
                        </div>
                    </div>

                    <div class="control-group">
                        <?php echo CHtml::label("", '', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php echo  $form->radioButton($model, 'is_pilihan', array('value' => 'is_fakturpembelian', 'id' => 'pilih_fakturpembelian', 'uncheckValue' => null)); ?> <label>Faktur Pembelian</label>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class='control-group'>
                        <?php echo $form->labelEx($model, 'rekening kredit', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo CHtml::hiddenField('AKSupplierRekM[rekening][2][rekening5_nb]', 'K', array('class' => 'span3')); ?>
                            <?php echo CHtml::hiddenField('AKSupplierRekM[rekening][2][rekening5_id]', '', array('class' => 'span3')); ?>
                            <?php echo CHtml::hiddenField('AKSupplierRekM[rekening][2][rekening4_id]', '', array('class' => 'span3')); ?>
                            <?php echo CHtml::hiddenField('AKSupplierRekM[rekening][2][rekening3_id]', '', array('class' => 'span3')); ?>
                            <?php echo CHtml::hiddenField('AKSupplierRekM[rekening][2][rekening2_id]', '', array('class' => 'span3')); ?>
                            <?php echo CHtml::hiddenField('AKSupplierRekM[rekening][2][rekening1_id]', '', array('class' => 'span3')); ?>
                            <?php
                            $this->widget('MyJuiAutoComplete', array(
                                'model' => $model,
                                'attribute' => 'rekKredit',
                                'sourceUrl' => Yii::app()->createUrl('ActionAutoComplete/RekeningAkuntansiKredit'),
                                'options' => array(
                                    'showAnim' => 'fold',
                                    'minLength' => 2,
                                    'focus' => 'js:function( event, ui ) {
                                                $(this).val(ui.item.nmrekening5);
                                                return false;
                                            }',
                                    'select' => 'js:function( event, ui ) {
                                                        $(this).val(ui.item.nmrekening5);
                                                        $("#AKSupplierRekM_rekening_2_rekening5_id").val(ui.item.rekening5_id);
                                                        $("#AKSupplierRekM_rekening_2_rekening4_id").val(ui.item.rekening4_id);
                                                        $("#AKSupplierRekM_rekening_2_rekening3_id").val(ui.item.rekening3_id);
                                                        $("#AKSupplierRekM_rekening_2_rekening2_id").val(ui.item.rekening2_id);
                                                        $("#AKSupplierRekM_rekening_2_rekening1_id").val(ui.item.rekening1_id);
                                                            return false;
                                                      }'
                                ),
                                'htmlOptions' => array(
                                    'onkeypress' => "return $(this).focusNextInputField(event)",
                                    'placeholder' => 'Nama Rekening',
                                    'class' => 'span3',
                                    'style' => 'width:150px;',
                                ),
                                'tombolDialog' => array('idDialog' => 'dialogRekKredit', 'idTombol' => "tombolKreditRek"),
                            ));
                            ?>
                        </div>
                    </div>

                    <div class="control-group">
                        <?php echo CHtml::label("", '', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php echo  $form->radioButton($model, 'is_pilihan', array('value' => 'is_bayarkesupplier', 'id' => 'pilih_bayarkesupplier', 'uncheckValue' => null)); ?> <label>Bayar Ke Supplier</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</fieldset>
<div class="form-actions">
    <?php echo CHtml::htmlButton(
        $model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
        array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        Yii::app()->createUrl($this->module->id . '/' . $this->id . '/create'),
        array(
            'class' => 'btn btn-default',
            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
        )
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Pengaturan Supplier Rekening', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
        $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])),
        array('class' => 'btn btn-success',)
    ); ?>
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
        'height' => 500,
        'resizable' => false,
    ),
));
//$accountD = "D";

$modRekDebit = new RekeningakuntansiV('searchAccounts');
$modRekDebit->unsetAttributes();
//$modRekDebit->rekening5_nb = $accountD;
$modRekDebit->rekening5_aktif = true;
if (isset($_GET['RekeningakuntansiV'])) {
    $modRekDebit->attributes = $_GET['RekeningakuntansiV'];
    // $modRekDebit->rekening5_nb = $accountD;
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

$this->widget('ext.bootstrap.widgets.HeaderGroupGridViewNonRp', array(
    'id' => 'rekdebit-m-grid',
    //'ajaxUrl'=>Yii::app()->createUrl('actionAjax/CariDataPasien'),
    'dataProvider' => $modRekDebit->searchAccounts(),
    'filter' => $modRekDebit,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'mergeHeaders' => array(
        /*
            array(
                'name'=>'Kode Rekening',
                'start'=>1, //indeks kolom 3
                'end'=>5, //indeks kolom 4
            ), */
        //            array(
        //                'name'=>'Saldo Normal',
        //                'start'=>8, //indeks kolom 3
        //                'end'=>9, //indeks kolom 4
        //            ),
    ),
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                                    "id" => "selectRekDebit",
                                    "onClick" =>"
                                                $(\"#AKSupplierRekM_rekening_1_rekening5_id\").val(\"$data->rekening5_id\");
                                                $(\"#AKSupplierRekM_rekening_1_rekening4_id\").val(\"$data->rekening4_id\");
                                                $(\"#AKSupplierRekM_rekening_1_rekening3_id\").val(\"$data->rekening3_id\");
                                                $(\"#AKSupplierRekM_rekening_1_rekening2_id\").val(\"$data->rekening2_id\");
                                                $(\"#AKSupplierRekM_rekening_1_rekening1_id\").val(\"$data->rekening1_id\");
                                                $(\"#AKSupplierRekM_rekDebit\").val(\"$data->nmrekening5\");                                                
                                                $(\"#dialogRekDebit\").dialog(\"close\");    
                                                return false;
                            "))',
        ),
        array(
            'header' => 'Kode Akun',
            'name' => 'kdrekening5',
            'value' => '$data->kdrekening5',
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
        ), /*
                array(
                    'header'=>'Nama Lain',
                    'name'=>'nmrekeninglain5',
                    'value'=>'$data->nmrekeninglain5',
                ), */
        array(
            'header' => 'Saldo Normal',
            'name' => 'rekening5_nb',
            'value' => '($data->rekening5_nb == "D") ? "Debit" : "Kredit"',
            'filter' =>  CHtml::activeDropDownList($modRekDebit, 'rekening5_nb', array('D' => 'Debit', 'K' => 'Kredit'), array('empty' => "-- Pilih --")),
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
//$accountK = "K";

$modRekKredit = new RekeningakuntansiV('searchAccounts');
$modRekKredit->unsetAttributes();
//$modRekKredit->rekening5_nb = $accountK;
$modRekKredit->rekening5_aktif = true;

if (isset($_GET['RekeningakuntansiV'])) {
    $modRekKredit->attributes = $_GET['RekeningakuntansiV'];
    // $modRekKredit->rekening5_nb = $accountK;
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

$this->widget('ext.bootstrap.widgets.HeaderGroupGridViewNonRp', array(
    'id' => 'rekkredit-m-grid',
    //'ajaxUrl'=>Yii::app()->createUrl('actionAjax/CariDataPasien'),
    'dataProvider' => $modRekKredit->searchAccounts(),
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
                                                $(\"#AKSupplierRekM_rekening_2_rekening5_id\").val(\"$data->rekening5_id\");
                                                $(\"#AKSupplierRekM_rekening_2_rekening4_id\").val(\"$data->rekening4_id\");
                                                $(\"#AKSupplierRekM_rekening_2_rekening3_id\").val(\"$data->rekening3_id\");
                                                $(\"#AKSupplierRekM_rekening_2_rekening2_id\").val(\"$data->rekening2_id\");
                                                $(\"#AKSupplierRekM_rekening_2_rekening1_id\").val(\"$data->rekening1_id\");
                                                $(\"#AKSupplierRekM_rekKredit\").val(\"$data->nmrekening5\");
                                                $(\"#dialogRekKredit\").dialog(\"close\");    
                                                return false;
                            "))',
        ),
        array(
            'header' => 'Kode Akun',
            'name' => 'kdrekening5',
            'value' => '$data->kdrekening5',
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
        ), /*
                array(
                    'header'=>'Nama Lain',
                    'name'=>'nmrekeninglain5',
                    'value'=>'$data->nmrekeninglain5',
                ), */
        array(
            'header' => 'Saldo Normal',
            'name' => 'rekening5_nb',
            'value' => '($data->rekening5_nb == "K") ? "Kredit" : "Debit"',
            'filter' =>  CHtml::activeDropDownList($modRekKredit, 'rekening5_nb', array('D' => 'Debit', 'K' => 'Kredit'), array('empty' => "-- Pilih --")),
        ),

    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
//========= end Rek Kredit dialog =============================
?>

<?php
//========= Dialog supplier =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPenjaminPasien',
    'options' => array(
        'title' => 'Daftar Supplier',
        'autoOpen' => false,
        'modal' => true,
        'width' => 800,
        'height' => 500,
        'resizable' => false,
    ),
));

$dialogPenjamin = new SupplierM('search');
$dialogPenjamin->unsetAttributes();

if (isset($_GET['SupplierM'])) {
    $dialogPenjamin->attributes = $_GET['SupplierM'];
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
					$(\"#' . CHtml::activeId($model, 'supplier_id') . '\").val(\"$data->supplier_id\");					
					$(\"#' . CHtml::activeId($model, 'supplier_nama') . '\").val(\"$data->supplier_nama\");					
					$(\"#dialogPenjaminPasien\").dialog(\"close\");    
					return false;
			"))',
        ),
        array(
            'header' => 'Nama',
            'name' => 'supplier_nama',
            'value' => '$data->supplier_nama',
        ),
        //array(
        //	'header' => 'Nama',
        //	'name' => 'jenispengeluaran_nama',
        //	'value' => '$data->jenispengeluaran_nama'
        //)

    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
//========= end supplier =============================
?>

<script>
    function checkAllSupplier() {
        if ($("#cekAll").is(":checked")) {
            $('#supplierrek-m-grid input[name*="pilihSupplier"]').each(function() {
                $(this).attr('checked', true);
            })
        } else {
            $('#supplierrek-m-grid input[name*="pilihSupplier"]').each(function() {
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
</script>

<?php

$js = <<< JS
$('.numbersOnly').keyup(function() {
var d = $(this).attr('numeric');
var value = $(this).val();
var orignalValue = value;
value = value.replace(/[0-9]*/g, "");
var msg = "Only Integer Values allowed.";

if (d == 'decimal') {
value = value.replace(/\./, "");
msg = "Only Numeric Values allowed.";
}

if (value != '') {
orignalValue = orignalValue.replace(/([^0-9].*)/g, "")
$(this).val(orignalValue);
}
});
JS;
Yii::app()->clientScript->registerScript('numberOnly', $js, CClientScript::POS_READY);
?>

<?php
$this->widget('ext.LocationPicker2.CoordinatePicker', array(
    'model' => $model,
    'latitudeAttribute' => 'latitude',
    'longitudeAttribute' => 'longitude',
    //optional settings
    'editZoom' => 12,
    'pickZoom' => 7,
    'defaultLatitude' => $latitude,
    'defaultLongitude' => $longitude,
));
?>

<script type="text/javascript">
    function namaLain(nama) {
        document.getElementById('SupplierM_supplier_namalain').value = nama.value.toUpperCase();
    }

    function unCheckPilih(obj) {
        var pilih = $("#<?php echo CHtml::activeId($model, 'pilihTindakan') ?>");

        $("#pilih_isfakturpembelian").prop("checked", false);
        $("#pilih_isbayarkesupplier").prop("checked", false);
    }

    function changeSize() {
        window.parent.document.getElementById('frame').style = 'overflow-y:scroll;height:600px;';
    }

    $('#tombolKreditRek, #tombolDebitRek,  #tombolPenjaminPasien').click(function() {
        changeSize();
    });
</script>