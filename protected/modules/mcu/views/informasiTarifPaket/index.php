<?php
// ===========================Dialog Details Tarif=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogDetailsTarif',
    // additional javascript options for the dialog plugin
    'options' => array(
        'title' => 'Paket Pelayanan',
        'autoOpen' => false,
        'width' => 500,
        'height' => 450,
        'resizable' => false,
        'scroll' => false
    ),
));
?>
<iframe src="" name="iframe" style="width:100%; height: 98%;"></iframe>
<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');
//===============================Akhir Dialog Details Tarif================================
Yii::app()->clientScript->registerScript('search', "
$('#formCari').submit(function(){
	$.fn.yiiGridView.update('daftarTindakan-grid', {
			data: $(this).serialize()
	});
	return false;
});
", CClientScript::POS_READY);
?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php
$this->breadcrumbs = array(
    'Informasi Tarif Paket Tindakan',
); ?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="fa fa-money"></i> Informasi <b>Tarif Paket Tindakan</b>
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
                <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
                    'id' => 'formCari',
                    'enableAjaxValidation' => false,
                    'type' => 'horizontal',
                    'action' => Yii::app()->createUrl($this->route),
                    'method' => 'get',
                )); ?>
                <div class="row">
                    <div class="col-sm-6">
                        <?php echo $form->textFieldRow($modTarifTindakanRuanganV, 'tipepaket_nama', array('placeholder' => 'Tipe Paket', 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                        <?php echo $form->dropDownListRow($modTarifTindakanRuanganV, 'kelaspelayanan_id', CHtml::listData($modTarifTindakanRuanganV->getKelasPelayananItems(), 'kelaspelayanan_id', 'kelaspelayanan_nama'), array('class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --')); ?>
                        <?php
                        $sp = LookupM::getItems('statusperiksa');
                        unset($sp['BATAL PERIKSA']);
                        $carabayar = CarabayarM::model()->findAll(array(
                            'condition' => 'carabayar_aktif = true',
                            'order' => 'carabayar_nourut',
                        )); ?>
                    </div>
                    <div class="col-sm-6">
                        <?php
                        $penjamin = PenjaminpasienM::model()->findAll(array(
                            'condition' => 'penjamin_aktif = true',
                            'order' => 'penjamin_nama',
                        ));
                        $pegawai = DokterV::model()->findAllByAttributes(array(
                            'instalasi_id' => Params::INSTALASI_ID_RD,
                            'pegawai_aktif' => true,
                        ), array(
                            'order' => 'nama_pegawai',
                        ));
                        foreach ($carabayar as $idx => $item) {
                            $penjamins = PenjaminpasienM::model()->findByAttributes(array(
                                'carabayar_id' => $item->carabayar_id,
                                'penjamin_aktif' => true,
                            ));
                            if (empty($penjamins)) unset($carabayar[$idx]);
                        }
                        echo $form->dropDownListRow($modTarifTindakanRuanganV, 'carabayar_id', CHtml::listData($carabayar, 'carabayar_id', 'carabayar_nama'), array(
                            'empty' => '-- Pilih --',
                            'class' => 'span4',
                            'ajax' => array(
                                'type' => 'POST',
                                'url' => $this->createUrl('/actionDynamic/getPenjaminPasien', array('encode' => false, 'namaModel' => get_class($modTarifTindakanRuanganV))),
                                'success' => 'function(data){$("#' . CHtml::activeId($modTarifTindakanRuanganV, "penjamin_id") . '").html(data); }',
                            ),
                        ));
                        echo $form->dropDownListRow($modTarifTindakanRuanganV, 'penjamin_id', CHtml::listData($penjamin, 'penjamin_id', 'penjamin_nama'), array('empty' => '-- Pilih --', 'class' => 'span4', 'maxlength' => 50));
                        ?>
                    </div>
                </div>
                <div class="form-actions">
                    <?php echo CHtml::htmlButton(
                        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
                        array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit')
                    ); ?>
                    <?php echo CHtml::link(
                        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                        Yii::app()->createUrl($this->module->id . '/' . Yii::app()->controller->id . '/' . Yii::app()->controller->action->id . ''),
                        array(
                            'title' => 'Ulang',
                            'class' => 'btn btn-default',
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
                    <?php $this->endWidget(); ?>
                </div>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Tarif Paket Tindakan</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php echo $this->renderPartial($this->path_view . '_table', array('modTarifTindakanRuanganV' => $modTarifTindakanRuanganV)); ?>
            </div>
        </div>
    </div>
</div>
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
<script>
    
$(document).ready(function() {
    var penj = jQuery('#<?php echo CHtml::activeId($modTarifTindakanRuanganV, 'penjamin_id') ?>');

    jQuery(penj).multiselect({
        includeSelectAllOption: true,
        buttonClass: "form-control",
        maxHeight: 300,
        // buttonWidth: '182px', //span3
        buttonWidth: '240px', //span4
        enableCaseInsensitiveFiltering: true
    }).hide();
});
</script>