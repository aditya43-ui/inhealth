<?php
// ===========================Dialog Details Tarif=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogDetailsTarif',
    // additional javascript options for the dialog plugin
    'options' => array(
        'title' => 'Komponen Tarif',
        'autoOpen' => false,
        'width' => 350,
        'height' => 350,
        'resizable' => false,
        'scroll' => false
    ),
));
?>
<?php
$this->breadcrumbs = array(
    'Informasi Tarif Rawat Jalan',
);
?>
<iframe src="" name="iframe" style="width:100%; height: 98%;"></iframe>
<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');
//===============================Akhir Dialog Details Tarif================================
Yii::app()->clientScript->registerScript('search', "
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('daftarTindakan-grid', {
			data: $(this).serialize()
	});
	return false;
});
", CClientScript::POS_READY);
?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'formCari',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
)); ?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <b>Tarif Rawat Jalan</b>
        </div>
    </div>
    <div class="panel-body">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-search"></i> Pencarian
                </div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-6">
                        <?php echo $form->dropDownListRow($modTarifTindakanRuanganV, 'jenistarif_id', CHtml::listData(JenistarifM::model()->findAllByAttributes(array('jenistarif_aktif' => true), array('order' => 'jenistarif_nama ASC')), 'jenistarif_id', 'jenistarif_nama'), array('class' => 'span3', 'empty' => '-- Pilih --')); ?>
                        <?php echo $form->dropDownListRow($modTarifTindakanRuanganV, 'kelompoktindakan_id', CHtml::listData(KelompoktindakanM::model()->findAllByAttributes(array('kelompoktindakan_aktif' => true), array('order' => 'kelompoktindakan_nama ASC')), 'kelompoktindakan_id', 'kelompoktindakan_nama'), array('class' => 'span3', 'empty' => '-- Pilih --')); ?>
                        <?php echo $form->dropDownListRow($modTarifTindakanRuanganV, 'komponenunit_id', CHtml::listData(KomponenunitM::model()->findAllByAttributes(array('komponenunit_aktif' => true), array('order' => 'komponenunit_nama ASC')), 'komponenunit_id', 'komponenunit_nama'), array('class' => 'span3', 'empty' => '-- Pilih --')); ?>
                    </div>
                    <div class="col-sm-6">
                        <?php echo $form->dropDownListRow($modTarifTindakanRuanganV, 'kategoritindakan_id', CHtml::listData($modTarifTindakanRuanganV->getKategoritindakanItems(), 'kategoritindakan_id', 'kategoritindakan_nama'), array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --')); ?>
                        <?php echo $form->dropDownListRow($modTarifTindakanRuanganV, 'kelaspelayanan_id', CHtml::listData($modTarifTindakanRuanganV->getKelasPelayananItems(), 'kelaspelayanan_id', 'kelaspelayanan_nama'), array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --')); ?>
                        <?php echo $form->textFieldRow($modTarifTindakanRuanganV, 'daftartindakan_nama', array('class' => 'custom-only span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'placeholder' => 'Nama Daftar Tindakan', 'maxlength' => 30)); ?>
                    </div>
                </div>
                <div class="form-actions">
                    <?php echo CHtml::htmlButton(
                        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
                        array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit', 'ajax' => array(
                            'type' => 'GET',
                            'url' => array("/" . $this->route),
                            'update' => '#daftarTindakan-grid',
                            'beforeSend' => 'function(){
							$("#daftarTindakan-grid").addClass("animation-loading");
						}',
                            'complete' => 'function(){
							$("#daftarTindakan-grid").removeClass("animation-loading");
						}',
                        ))
                    ); ?>
                    <?php echo CHtml::link(
                        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                        Yii::app()->createUrl($this->module->id . '/' . Yii::app()->controller->id . '/' . Yii::app()->controller->action->id . ''),
                        array(
                            'title' => 'Ulang', 'class' => 'btn btn-default',
                            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
                        )
                    ); ?>
                    <?php echo CHtml::htmlButton(
                        Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')),
                        array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print("PRINT")')
                    ); ?>
                    <?php
                    $content = $this->renderPartial('rawatJalan.views.tips.informasiTarif', array(), true);
                    $this->widget('UserTips', array('type' => 'admin', 'content' => $content));
                    ?>
                </div>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Tarif Rawat Jalan</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php echo $this->renderPartial($this->path_view . '_table', array('modTarifTindakanRuanganV' => $modTarifTindakanRuanganV)); ?>
            </div>
        </div>
    </div>
</div>
<?php $this->endWidget(); ?>
<?php
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$urlPrint =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/print');
$js = <<< JSCRIPT
    function cekForm(obj){
        $("#formCari :input[name='"+ obj.name +"']").val(obj.value);
    }
	function print(caraPrint){
        window.open("${urlPrint}/"+$('#formCari').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
    }
JSCRIPT;
Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
?>