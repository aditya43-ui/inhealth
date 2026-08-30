<?php
$this->breadcrumbs = array(
    'Informasi Tarif Gizi',
);
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Infomasi <b>Tarif Gizi</b>
        </div>
    </div>
    <div class="panel-body">
        <?php $this->renderPartial('_search', array('modTarifTindakanRuanganV' => $modTarifTindakanRuanganV)); ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Tarif Gizi</b>
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
                            'value' => '$this->grid->getOwner()->renderPartial(\'gizi.views.informasiTarif._tarifTotal\',array(\'kelaspelayanan_id\'=>$data->kelaspelayanan_id,\'daftartindakan_id\'=>$data->daftartindakan_id, \'jenistarif_id\'=>$data->jenistarif_id),true)',
                            'htmlOptions' => array('style' => 'text-align: right'),
                        ),
                        array(
                            'name' => 'persencyto_tind',
                            'htmlOptions' => array('style' => 'text-align: right'),
                        ), array(
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
        'height' => 300,
        'resizable' => false,
        'scroll' => false
    ),
));
?>
<iframe src="" name="iframe" width="100%" height="98%"></iframe>
<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');
//===============================Akhir Dialog Details Tarif================================
?>
<?php $urlPrint = $this->createUrl('print'); ?>
<script>
    function printTarif() {
        //console.log("<?php echo $urlPrint; ?>&" + $("#formCari").serialize());
        window.open("<?php echo $urlPrint; ?>&" + $("#formCari :input").serialize() + "&caraPrint=PRINT", "", 'location=_new, width=900px');
    }
</script>