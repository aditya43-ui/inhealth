<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'sakompgajirek-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#',
));
?>

<!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') 
                            ?></p>-->

<?php echo $form->errorSummary($model); ?>

<div class="row">
    <div class="control-group">
        <?php echo $form->labelEx($model, "komponengaji_id", array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo $form->hiddenField($model, 'komponengaji_id'); ?>
            <?php
            $this->widget('MyJuiAutoComplete', array(
                'model' => $model,
                'attribute' => 'komponengaji_nama',
                'source' => 'js: function(request, response) {
												   $.ajax({
													   url: "' . $this->createUrl('KomponenGaji') . '",
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
                    'minLength' => 2,
                    'focus' => 'js:function( event, ui ) {
												$(this).val( ui.item.value);
												return false;
											}',
                    'select' => 'js:function( event, ui ) { 
												$("#' . CHtml::activeId($model, 'komponengaji_id') . '").val(ui.item.komponengaji_id);
												return false;
											}',
                ),
                'htmlOptions' => array(
                    'placeholder' => 'Kode / Nama Komponen Gaji',
                    'onkeypress' => "return $(this).focusNextInputField(event)",
                ),
                'tombolDialog' => array('idDialog' => 'dialogKompGaji'),
            ));
            ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo $form->labelEx($model, "rekening5_id", array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo $form->hiddenField($model, 'debitkredit'); ?>
            <?php echo $form->hiddenField($model, 'rekening5_id'); ?>
            <?php
            $this->widget('MyJuiAutoComplete', array(
                'model' => $model,
                'attribute' => 'nmrekening5',
                'source' => 'js: function(request, response) {
												   $.ajax({
													   url: "' . $this->createUrl('RekeningAkuntansi') . '",
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
                    'minLength' => 2,
                    'focus' => 'js:function( event, ui ) {
												$(this).val( ui.item.value);
												return false;
											}',
                    'select' => 'js:function( event, ui ) { 
												$("#' . CHtml::activeId($model, 'rekening5_id') . '").val(ui.item.rekening5_id);
												return false;
											}',
                ),
                'htmlOptions' => array(
                    'placeholder' => 'Kode / Nama Rekening',
                    'onkeypress' => "return $(this).focusNextInputField(event)",
                ),
                'tombolDialog' => array('idDialog' => 'dialogRek'),
            ));
            ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo $form->labelEx($model, 'debitkredit', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo $form->dropDownList($model, 'debitkredit', array("D" => "Debit", "K" => "Kredit"), array('class' => 'span3')); ?>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label"></label>
        <div class="controls">
            <?php echo $form->checkBox($model, 'ispenggajian', array('onclick' => 'setUntukTransaksi();')) . CHtml::activeLabel($model, 'ispenggajian'); ?>
            <br>
            <br>
            <?php echo $form->checkBox($model, 'ispembayarangaji', array('onclick' => 'setUntukTransaksi();')) . CHtml::activeLabel($model, 'ispembayarangaji'); ?>
        </div>
    </div>
</div>

<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
        array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
    ); ?>
    <?php
    echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        $this->createUrl('create'),
        array(
            'title' => 'Ulang',
            'class' => 'btn btn-default',
            'onclick' => 'return refreshForm(this);'
        )
    );
    ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Pengaturan Rekening Komponen Gaji', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
        $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])),
        array('class' => 'btn btn-success',)
    ); ?>
    <?php
    $content = $this->renderPartial('sistemAdministrator.views.tips.tipsaddedit', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>

<?php $this->endWidget(); ?>
<?php echo $this->renderPartial($this->path_view . '_jsFunctions', array('model' => $model)); ?>
<?php
//========= Dialog buat cari data Rekening Debit =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogRek',
    'options' => array(
        'title' => 'Rekening',
        'autoOpen' => false,
        'modal' => true,
        'width' => 1000,
        'height' => 500,
        'resizable' => false,
    ),
));

$modRekeningDebit = new SARekeningakuntansiV('search');
$modRekeningDebit->rekening5_aktif = true;
$modRekeningDebit->unsetAttributes();
if (isset($_GET['SARekeningakuntansiV'])) {
    $modRekeningDebit->attributes = $_GET['SARekeningakuntansiV'];
}

$c2 = new CDbCriteria();
$c3 = new CDbCriteria();
$c4 = new CDbCriteria();

$c2->compare('rekening1_id', $modRekeningDebit->rekening1_id);
$c2->addCondition('rekening2_aktif = true');
$c2->order = 'kdrekening2';

$r2 = Rekening2M::model()->findAll($c2);

$c3->compare('rekening2_id', $modRekeningDebit->rekening2_id);
$c3->addCondition('rekening3_aktif = true');
$c3->order = 'kdrekening3';

$r3 = Rekening3M::model()->findAll($c3);

$c4->compare('rekening3_id', $modRekeningDebit->rekening3_id);
$c4->addCondition('rekening4_aktif = true');
$c4->order = 'kdrekening4';

$r4 = Rekening4M::model()->findAll($c4);

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'rekeningdebit-m-grid',
    'dataProvider' => $modRekeningDebit->searchAccounts(),
    'filter' => $modRekeningDebit,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>",
                                "#",
                                array(
                                    "class"=>"btn-small", 
                                    "id" => "selectRekDebit",
                                    "onClick" => "
                                    $(\"#' . CHtml::activeId($model, 'rekening5_id') . '\").val(\'$data->rekening5_id\');
                                    $(\"#' . CHtml::activeId($model, 'nmrekening5') . '\").val(\'$data->nmrekening5\');

                                    $(\'#dialogRek\').dialog(\'close\');
                                    return false;"))'
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
            'filter' => CHtml::activeDropDownList($modRekeningDebit, 'kelrekening_id', CHtml::listData(
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
                $modRekeningDebit,
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
                $modRekeningDebit,
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
                $modRekeningDebit,
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
                $modRekeningDebit,
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
            'filter' =>  CHtml::activeHiddenField($modRekeningDebit, 'rekening5_nb', array('empty' => "-- Pilih --")),
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
?>

<?php
//========= Dialog buat cari data Komponen Gaji =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogKompGaji',
    'options' => array(
        'title' => 'Komponen Gaji',
        'autoOpen' => false,
        'modal' => true,
        'width' => 1000,
        'height' => 500,
        'resizable' => false,
    ),
));

$modKompGaji = new SAKomponengajiM('search');
$modKompGaji->unsetAttributes();
if (isset($_GET['SAKomponengajiM'])) {
    $modKompGaji->attributes = $_GET['SAKomponengajiM'];
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'komponengaji-m-grid',
    'dataProvider' => $modKompGaji->search(),
    'filter' => $modKompGaji,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>",
                                "#",
                                array(
                                    "class"=>"btn-small", 
                                    "id" => "selectKompGaji",
                                    "onClick" => "
                                    $(\"#' . CHtml::activeId($model, 'komponengaji_id') . '\").val(\'$data->komponengaji_id\');
                                    $(\"#' . CHtml::activeId($model, 'komponengaji_nama') . '\").val(\'$data->komponengaji_nama\');

                                    $(\'#dialogKompGaji\').dialog(\'close\');
                                    return false;"))'
        ),
        array(
            'header' => 'No. Urut',
            'name' => 'nourutgaji',
            'value' => '$data->nourutgaji',
        ),
        array(
            'header' => 'Kode',
            'name' => 'komponengaji_kode',
            'value' => '$data->komponengaji_kode',
        ),
        array(
            'header' => 'Nama',
            'name' => 'komponengaji_nama',
            'value' => '$data->komponengaji_nama',
        ),
        array(
            'header' => 'Singkatan',
            'name' => 'komponengaji_singkt',
            'value' => '$data->komponengaji_singkt',
        ),
        array(
            'header' => 'Potongan',
            'name' => 'ispotongan',
            'value' => '($data->ispotongan == 1)?"Ya":"Tidak"',
            'filter' => false,
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
?>

<?php
// $this->renderPartial($this->path_view . "_jsFunctions", array('model' => $model)); 
?>