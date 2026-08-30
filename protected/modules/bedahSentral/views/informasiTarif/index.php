<?php
$this->breadcrumbs = array(
    'Infomasi Tarif Bedah Sentral',
);
Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
        $('.search-form').toggle();
        return false;
    });
    $('.search-form form').submit(function(){
        $.fn.yiiGridView.update('daftarTindakan-grid', {
                data: $(this).serialize()
        });
        return false;
    });
    ");
$this->widget('bootstrap.widgets.BootAlert');
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <b>Tarif Bedah Sentral</b>
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
                    'focus' => '#SARuanganM_instalasi_id',
                    'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event)'),
                )); ?>
                <div class="row">
                    <div class="col-sm-6">
                        <?php echo $form->dropDownListRow($modTarifTindakanRuanganV, 'jenistarif_id', CHtml::listData(JenistarifM::model()->findAllByAttributes(array('jenistarif_aktif' => true), array('order' => 'jenistarif_nama ASC')), 'jenistarif_id', 'jenistarif_nama'), array('class' => 'span3', 'empty' => '-- Pilih --')); ?>
                        <?php echo $form->dropDownListRow($modTarifTindakanRuanganV, 'kelompoktindakan_id', CHtml::listData(KelompoktindakanM::model()->findAllByAttributes(array('kelompoktindakan_aktif' => true), array('order' => 'kelompoktindakan_nama ASC')), 'kelompoktindakan_id', 'kelompoktindakan_nama'), array('class' => 'span3', 'empty' => '-- Pilih --')); ?>
                        <?php echo $form->dropDownListRow($modTarifTindakanRuanganV, 'komponenunit_id', CHtml::listData(KomponenunitM::model()->findAllByAttributes(array('komponenunit_aktif' => true), array('order' => 'komponenunit_nama ASC')), 'komponenunit_id', 'komponenunit_nama'), array('class' => 'span3', 'empty' => '-- Pilih --')); ?>
                    </div>
                    <div class="col-sm-6">
                        <?php echo $form->dropDownListRow($modTarifTindakanRuanganV, 'kategoritindakan_id', CHtml::listData($modTarifTindakanRuanganV->getKategoritindakanItems(), 'kategoritindakan_id', 'kategoritindakan_nama'), array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --')); ?>
                        <?php echo $form->dropDownListRow($modTarifTindakanRuanganV, 'kelaspelayanan_id', CHtml::listData($modTarifTindakanRuanganV->getKelasPelayananItems(), 'kelaspelayanan_id', 'kelaspelayanan_nama'), array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --')); ?>
                        <?php echo $form->textFieldRow($modTarifTindakanRuanganV, 'daftartindakan_nama', array('onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 30, 'class' => 'span3', 'placeholder' => 'Nama Daftar Tindakan')); ?>
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
                        array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'printTarif()')
                    ); ?>
                    <?php
                    $content = $this->renderPartial('../tips/informasiTarif', array(), true);
                    $this->widget('UserTips', array('type' => 'admin', 'content' => $content));
                    ?>
                </div>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Tarif Bedah Sentral</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php
                $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'daftarTindakan-grid',
                    'dataProvider' => $modTarifTindakanRuanganV->searchInformasi(),
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-striped table-condensed',
                    'columns' => array(
                        'jenistarif_nama',
                        'kelompoktindakan_nama',
                        'komponenunit_nama',
                        'kategoritindakan_nama',
                        'kelaspelayanan_nama',
                        'daftartindakan_nama',
                        array(
                            'name' => 'tarifTotal',
                            'value' => '$this->grid->getOwner()->renderPartial(\'_tarifTotal\',array(\'kelaspelayanan_id\'=>$data->kelaspelayanan_id,\'daftartindakan_id\'=>$data->daftartindakan_id, \'jenistarif_id\'=>$data->jenistarif_id),true)',
                            'htmlOptions' => array('style' => 'text-align: right;'),
                        ),
                        array(
                            'name' => 'persencyto_tind',
                            'htmlOptions' => array('style' => 'text-align: right'),
                        ),
                        array(
                            'name' => 'persendiskon_tind',
                            'htmlOptions' => array('style' => 'text-align: right'),
                        ),
                        array(
                            'name' => 'Komponen Tarif',
                            'type' => 'raw',
                            'value' => 'CHtml::link("<i class=\'icon-form-komtarif\'></i> ",Yii::app()->controller->createUrl("' . Yii::app()->controller->id . '/detailsTarif",array("kelaspelayanan_id"=>$data->kelaspelayanan_id,"daftartindakan_id"=>$data->daftartindakan_id, "kategoritindakan_id"=>$data->kategoritindakan_id, "jenistarif_id"=>$data->jenistarif_id)) ,array("title"=>"Klik untuk Melihat Detail Tarif","target"=>"iframe", "onclick"=>"$(\"#dialogDetailsTarif\").dialog(\"open\");", "rel"=>"tooltip"))', 'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                        ),
                    ),
                    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                ));
                ?>
            </div>
        </div>
    </div>
    <?php $this->endWidget(); ?>
</div>
<?php
// ===========================Dialog Details Tarif=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogDetailsTarif',
    // additional javascript options for the dialog plugin
    'options' => array(
        'title' => 'Komponen Tarif',
        'autoOpen' => false,
        'width' => 300,
        'height' => 350,
        'resizable' => false,
        'scroll' => false
    ),
));
?>
<iframe src="" name="iframe" style="width:100%; height: 98%;"></iframe>
<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');
//===============================Akhir Dialog Details Tarif================================
?>
<script type="text/javascript">
    $('form#formCari').submit(function() {
        $('#daftarTindakan-grid').addClass('animation-loading');
        $.fn.yiiGridView.update('daftarTindakan-grid', {
            data: $(this).serialize()
        });
        return false;
    });
</script>
<?php $urlPrint = $this->createUrl('print'); ?>
<script>
    function printTarif() {
        //console.log("<?php echo $urlPrint; ?>&" + $("#formCari").serialize());
        window.open("<?php echo $urlPrint; ?>&" + $("#formCari :input").serialize() + "&caraPrint=PRINT", "", 'location=_new, width=900px');
    }
</script>