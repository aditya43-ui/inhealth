<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form2.js', CClientScript::POS_END); ?>

<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'sapaketbmhp-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#SAPaketbmhpM_tipepaket_id',
));
?>

<!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') 
                            ?></p>-->

<?php echo $form->errorSummary($model); ?>

<div class="row-fluid">
    <div class="col-sm-6">
        <?php echo $form->dropDownListRow($model, 'tipepaket_id', CHtml::listData(TipepaketM::model()->findAll('tipepaket_aktif=true'), 'tipepaket_id', 'tipepaket_nama'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->textFieldRow($model, 'paketbmhp_nama', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)",)); ?>
        <?php echo $form->textFieldRow($model, 'paketbmhp_namalain', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)",)); ?>
    </div>
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'paketbmhp_nomorpaket', array('class' => 'span3 all-caps', 'onkeypress' => "return $(this).focusNextInputField(event)",)); ?>
        <?php echo $form->textFieldRow($model, 'hargapemakaian', array('class' => 'span3 integer-decimal', 'readonly'=>true,'onkeypress' => "return $(this).focusNextInputField(event)",)); ?>
    </div>
</div>
<div class="row-fluid">
    <div class="col-sm-12">
        <?php echo $this->renderPartial($this->path_view."_formTindakan", array('form'=>$form, 'model'=>$model), true); ?>
        <br/>
        <?php echo $this->renderPartial($this->path_view."_formObat", array('form'=>$form, 'model'=>$model), true); ?>
    </div>
</div>

<div class="form-actions">
    <?php
    echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
        array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
    );
    ?>
    <?php
    echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), Yii::app()->createUrl($this->module->id . '/paketbmhpM/admin'), array(
        'class' => 'btn btn-default',
        'title' => 'Ulang',
        'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
    ));
    echo CHtml::link(
        Yii::t('mds', '{icon} Pengaturan Paket BMHP', array('{icon}' => '<i class="icon-file icon-white"></i>')),
        $this->createUrl(Yii::app()->controller->id . '/admin', array('modul_id' => Yii::app()->session['modul_id'])),
        array('class' => 'btn btn-success',)
    );
    ?>
    <?php
    $content = $this->renderPartial($this->path_view . 'tips/tips', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>

<?php $this->endWidget(); ?>

<script>

var total_tindakan = 0;
var total_obat = 0;

function totalSemua() {
    $("#SAPaketbmhpM_hargapemakaian").val(formatThousandDecimal(total_tindakan + total_obat));
}

$(document).ready(function() {
    hitungTotalTindakan();
    hitungTotalObat();
});

</script>

<?php
//========= Dialog buat cari data obatAlkes =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogDaftarTindakan',
    'options' => array(
        'title' => 'Pencarian Daftar Tindakan',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 500,
        'resizable' => true,
    ),
));

$modDaftarTindakan = new SADaftarTindakanM('search');
$modDaftarTindakan->unsetAttributes();
if (isset($_GET['SADaftarTindakanM'])) {
    $modDaftarTindakan->attributes = $_GET['SADaftarTindakanM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'satarif-tindakan-m-grid',
    //'ajaxUrl'=>Yii::app()->createUrl('actionAjax/CariDataPasien'),
    'dataProvider' => $modDaftarTindakan->search(),
    'filter' => $modDaftarTindakan,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
					"id" => "selectDaftarTindakan",
					"onClick" => "$(\"#' . CHtml::activeId($model, 'daftartindakan_id') . '\").val(\"$data->daftartindakan_id\");
								  $(\"#' . CHtml::activeId($model, 'daftartindakan_nama') . '\").val(\"$data->daftartindakan_nama\");
								  $(\"#dialogDaftarTindakan\").dialog(\"close\");    
					"))',
        ),
        'daftartindakan_kode',
        'daftartindakan_nama',
        'tindakanmedis_nama',
        array(
            'name' => 'daftartindakan_karcis',
            'value' => '($data->daftartindakan_karcis)? "Ya" : "Tidak"',
            'filter' => false,
        ),
        array(
            'name' => 'daftartindakan_konsul',
            'type' => 'raw',
            'value' => '($data->daftartindakan_konsul)? "Ya" : "Tidak"',
            'filter' => false,
        ),
        array(
            'name' => 'daftartindakan_akomodasi',
            'type' => 'raw',
            'value' => '($data->daftartindakan_akomodasi)? "Ya" : "Tidak"',
            'filter' => false,
        ),
        array(
            'name' => 'daftartindakan_tindakan',
            'type' => 'raw',
            'value' => '($data->daftartindakan_tindakan) ? "Ya" : "Tidak"',
            'filter' => false,
        ),

    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
//========= end obatAlkes dialog =============================
?>

<?php
//========= Dialog buat cari data obatAlkes =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogObatAlkes',
    'options' => array(
        'title' => 'Pencarian Obat Alkes',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 500,
        'resizable' => true,
    ),
));

$modObatAlkes = new ObatalkesM('search');

$modObatAlkes->unsetAttributes();
if (isset($_GET['idKelasPelayanan'])) {
    $modObatAlkes->kelaspelayanan_id = $_GET['idKelasPelayanan'];
}
if (isset($_GET['ObatalkesM'])) {
    $modObatAlkes->attributes = $_GET['ObatalkesM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'obatAlkes-m-grid',
    //'ajaxUrl'=>Yii::app()->createUrl('actionAjax/CariDataPasien'),
    'dataProvider' => $modObatAlkes->search(),
    'filter' => $modObatAlkes,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                                            "id" => "selectPasien",
                                            "onClick" => "$(\"#idObatAlkes\").val(\"$data->obatalkes_id\");
                                                          $(\"#qtyPakai\").val(0);
                                                          $(\"#hargaPakai\").val(0);
                                                          $(\"#' . CHtml::activeId($model, 'obatalkes_id') . '\").val(\"$data->obatalkes_id\");
                                                          $(\"#' . CHtml::activeId($model, 'obatalkes_nama') . '\").val(\"".$data->obatalkes_nama." - ".$data->sumberdana->sumberdana_nama."\");
                                                          $(\"#dialogObatAlkes\").dialog(\"close\");    
                                                "))',
        ),
        'obatalkes_kategori',
        'obatalkes_golongan',
        'obatalkes_kode',
        'obatalkes_nama',
        array(
            'name' => 'sumberdanaNama',
            'type' => 'raw',
            'value' => '$data->sumberdana->sumberdana_nama',
        ),
        array(
            'name' => 'hargajual',
            'type' => 'raw',
            'value' => 'number_format($data->hargajual,0,".",",")',
            'filter' => false,
        ),
        array(
            'name' => 'harganetto',
            'type' => 'raw',
            'value' => 'number_format($data->harganetto,0,".",",")',
            'filter' => false,
        ),
        // 'hargajual',
        // 'harganetto',
        //        'obatalkes_kadarobat',
        //        'kemasanbesar',
        //        'kekuatan',
        //'tglkadaluarsa',
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
//========= end obatAlkes dialog =============================
?>