<?php
$this->breadcrumbs = array(
    'Informasi Tarif Pemularasan Jenazah',
);
$arrMenu = array();
$this->menu = $arrMenu;
$this->widget('bootstrap.widgets.BootAlert');
?>
<div class='panel panel-gradient'>
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <b>Tarif Pemularasan Jenazah</b>
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
                <?php
                // ===========================Dialog Details Tarif=========================================
                $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
                    'id' => 'dialogDetailsTarif',
                    // additional javascript options for the dialog plugin
                    'options' => array(
                        'title' => 'Komponen Tarif',
                        'autoOpen' => false,
                        'width' => 300,
                        'height' => 300,
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
                $('#search').submit(function(){
                        $.fn.yiiGridView.update('daftarTindakan-grid', {
                                data: $(this).serialize()
                        });
                        return false;
                });
                ", CClientScript::POS_READY);
                ?>
                <?php
                $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
                    'action' => Yii::app()->createUrl($this->route),
                    'method' => 'get',
                    'id' => 'search',
                    'type' => 'horizontal',
                    'htmlOptions' => array('enctype' => 'multipart/form-data'),
                    'focus' => '#' . CHtml::activeId($modTarifTindakanRuanganV, 'daftartindakan_nama'),
                )); ?>
                <table width='100%'>
                    <tr>
                        <td>
                            <?php echo $form->dropDownListRow($modTarifTindakanRuanganV, 'jenistarif_id', CHtml::listData(JenistarifM::model()->findAllByAttributes(array('jenistarif_aktif' => true)), 'jenistarif_id', 'jenistarif_nama'), array('class' => 'span4')); ?>
                            <?php echo $form->dropDownListRow($modTarifTindakanRuanganV, 'kategoritindakan_id', CHtml::listData(TariftindakanperdaruanganV::model()->getKategoritindakanItems(), 'kategoritindakan_id', 'kategoritindakan_nama'), array('class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --')); ?>
                        </td>
                        <td>
                            <?php echo $form->dropDownListRow($modTarifTindakanRuanganV, 'kelaspelayanan_id', CHtml::listData(TariftindakanperdaruanganV::model()->getKelasPelayananItems(), 'kelaspelayanan_id', 'kelaspelayanan_nama'), array('class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --')); ?>
                            <?php echo $form->textFieldRow($modTarifTindakanRuanganV, 'daftartindakan_nama', array('class' => 'span4', 'placeholder' => 'Nama Daftar Tindakan')); ?>
                        </td>
                    </tr>
                </table>
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
                    <?php
                    $content = $this->renderPartial('../tips/informasi3', array(), true);
                    $this->widget('UserTips', array('type' => 'admin', 'content' => $content));
                    ?>
                </div>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Tarif Pemularasan Jenazah</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'daftarTindakan-grid',
                    'dataProvider' => $modTarifTindakanRuanganV->searchInformasi(),
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-striped table-condensed table-bordered',
                    'columns' => array(
                        'kelompoktindakan_nama',
                        'kategoritindakan_nama',
                        'daftartindakan_nama',
                        'kelaspelayanan_nama',
                        array(
                            'name' => 'tarifTotal',
                            'name' => 'Tarif Total<br>(Rp)',
                            'value' => '$this->grid->getOwner()->renderPartial(\'_tarifTotal\',array(\'kelaspelayanan_id\'=>$data->kelaspelayanan_id,\'daftartindakan_id\'=>$data->daftartindakan_id),true)',
                        ),
                        array(
                            'name' => 'persencyto_tind',
                            'name' => 'Cyto<br>(%)',
                            'value' => '$data->persencyto_tind',
                        ),
                        array(
                            'name' => 'persendiskon_tind',
                            'name' => 'Keringanan<br>(%)',
                            'value' => '$data->persendiskon_tind',
                        ),
                        array(
                            'name' => 'Komponen Tarif',
                            'type' => 'raw',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                            'value' => 'CHtml::link("<i class=\'icon-form-komtarif\'></i> ",Yii::app()->controller->createUrl("' . Yii::app()->controller->id . '/detailsTarif",array("kelaspelayanan_id"=>$data->kelaspelayanan_id,"daftartindakan_id"=>$data->daftartindakan_id, "kategoritindakan_id"=>$data->kategoritindakan_id)) ,array("title"=>"Klik untuk Melihat Detail Tarif","target"=>"iframe", "onclick"=>"$(\"#dialogDetailsTarif\").dialog(\"open\");", "rel"=>"tooltip"))',
                        ),
                    ),
                    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                )); ?>
            </div>
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div>