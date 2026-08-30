<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'formCari',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'focus' => '#',
    'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event)'),
)); ?>
<?php $this->endWidget(); ?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <b>Tarif Rawat Darurat</b>
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
                <!--fieldset class="box"-->
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
                <iframe src="" name="iframe" width="100%" height="100%">
                </iframe>
                <?php
                $this->endWidget('zii.widgets.jui.CJuiDialog');
                //===============================Akhir Dialog Details Tarif================================
                Yii::app()->clientScript->registerScript('search', "
                            $('form#formCari').submit(function(){
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
                    'focus' => '#' . CHtml::activeId($modTarifTindakanRuanganV, 'daftartindakan_nama'),
                    'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event)'),
                )); ?>
                <div class="row" id="formCariInput">
                    <div class="col-sm-6">
                        <div class="control-group">
                            <?php echo $form->dropDownListRow($modTarifTindakanRuanganV, 'jenistarif_id', CHtml::listData(JenistarifM::model()->findAllByAttributes(array('jenistarif_aktif' => true), array('order' => 'jenistarif_nama ASC')), 'jenistarif_id', 'jenistarif_nama'), array('class' => 'span3', 'empty' => '-- Pilih --')); ?>
                        </div>
                        <div class="control-group">
                            <?php echo $form->dropDownListRow($modTarifTindakanRuanganV, 'kelompoktindakan_id', CHtml::listData(KelompoktindakanM::model()->findAllByAttributes(array('kelompoktindakan_aktif' => true), array('order' => 'kelompoktindakan_nama ASC')), 'kelompoktindakan_id', 'kelompoktindakan_nama'), array('class' => 'span3', 'empty' => '-- Pilih --')); ?>
                        </div>
                        <div class="control-group">
                            <?php echo $form->dropDownListRow($modTarifTindakanRuanganV, 'komponenunit_id', CHtml::listData(KomponenunitM::model()->findAllByAttributes(array('komponenunit_aktif' => true), array('order' => 'komponenunit_nama ASC')), 'komponenunit_id', 'komponenunit_nama'), array('class' => 'span3', 'empty' => '-- Pilih --')); ?>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="control-group">
                            <?php echo $form->dropDownListRow($modTarifTindakanRuanganV, 'kategoritindakan_id', CHtml::listData($modTarifTindakanRuanganV->getKategoritindakanItems(), 'kategoritindakan_id', 'kategoritindakan_nama'), array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --')); ?>
                        </div>
                        <div class="control-group">
                            <?php echo $form->dropDownListRow($modTarifTindakanRuanganV, 'kelaspelayanan_id', CHtml::listData($modTarifTindakanRuanganV->getKelasPelayananItems(), 'kelaspelayanan_id', 'kelaspelayanan_nama'), array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --')); ?>
                        </div>
                        <div class="control-group">
                            <?php echo $form->textFieldRow($modTarifTindakanRuanganV, 'daftartindakan_nama', array('class' => 'custom-only', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 30, 'placeholder' => 'Uraian Tindakan')); ?>
                        </div>
                    </div>
                </div>
                <!--</fieldset>-->
                <div class="form-actions">
                    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')), array(
                        'class' => 'btn btn-danger', 'type' => 'submit',
                        'ajax' => array(
                            'type' => 'GET',
                            'url' => array("/" . $this->route),
                            'update' => '#daftarTindakan-grid',
                            'beforeSend' => 'function(){
                                $("#daftarTindakan-grid").addClass("animation-loading");
                            }',
                            'complete' => 'function(){
                                $("#daftarTindakan-grid").removeClass("animation-loading");
                            }',
                        )
                    ));
                    ?>
                    <?php echo CHtml::link(
                        Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                        Yii::app()->createUrl($this->module->id . '/' . Yii::app()->controller->id . '/' . Yii::app()->controller->action->id . ''),
                        array(
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
                    <i class="entypo-credit-card"></i> Tabel <b>Tarif Rawat Darurat</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <!--div class="block-tabel"-->
                <?php echo $this->renderPartial('_tableTarif', array('modTarifTindakanRuanganV' => $modTarifTindakanRuanganV)); ?>
                <!--/div-->
            </div>
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div>
<?php $urlPrint = $this->createUrl('print'); ?>
<script>
    function printTarif() {
        //console.log("<?php echo $urlPrint; ?>&" + $("#formCari").serialize());
        window.open("<?php echo $urlPrint; ?>&" + $("#formCariInput :input").serialize() + "&caraPrint=PRINT", "", 'location=_new, width=900px');
    }
</script>