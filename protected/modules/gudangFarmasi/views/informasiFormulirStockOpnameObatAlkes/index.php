<?php
$this->breadcrumbs = array(
    'Informasi Formulir Stock Opname Obat Alkes',
);
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <b>Formulir Stock Opname Obat Alkes</b>
            <span class="pull-right">
                <a href="<?= !empty($linkHalaman) ? $linkHalaman : '#'; ?>" class="btn btn-default" target="_blank">
                    <i class="fas fa-external-link-alt"></i> Ke Halaman Transaksi
                </a>
            </span>
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
                <?php echo $this->renderPartial($this->path_view . 'search', array('model' => $model, 'format' => $format)); ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Formulir Stock Opname Obat Alkes</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php
                Yii::app()->clientScript->registerScript('search', "
                            $('#divSearch-form form').submit(function(){
                                $.fn.yiiGridView.update('rencana-m-grid', {
                                    data: $(this).serialize()
                                });
                                return false;
                            });
                            ");
                ?>
                <div class="block-tabel">
                    <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
                        'id' => 'rencana-m-grid',
                        'dataProvider' => $model->searchInformasi(),
                        'template' => "{summary}\n{items}\n{pager}",
                        'itemsCssClass' => 'table table-bordered table-striped table-condensed',
                        'replaceUrl' => true,
                        'columns' => array(
                            array(
                                'name' => 'tglformulir',
                                'type' => 'raw',
                                'value' => 'MyFormatter::formatDateTimeForUser($data->tglformulir)'
                            ),
                            'noformulir',
                            'totalvolume',
                            array(
                                'header' => 'Rak Obat',
                                'type' => 'raw',
                                'value' => function($data) {
                                    return $data->getRakByFormulir($data->formuliropname_id);
                                }
                            ),
                            array(
                                'header' => 'Total Harga (Rp)',
                                'type' => 'raw',
                                'value' => (Params::cekHiddenHargaGudangFarmasi() == true) ? 'MyFormatter::formatUang($data->totalharga)' : '"<p style=\"margin: 0; text-align: left;\">Hidden</p>"',
                                'htmlOptions' => array('style' => 'text-align: right;'),
                            ),
                            array(
                                'header' => 'Formulir',
                                'type' => 'raw',
                                'value' => 'CHtml::Link("<i class=\"icon-form-formulir\"></i>","' . $this->getUrlPrint() . '&formuliropname_id=$data->formuliropname_id&frame=true",
                                            array("class"=>"", 
                                                "target"=>"formulir",
                                                "onclick"=>"$(\"#dialogFormulir\").dialog(\"open\");",
                                                "rel"=>"tooltip",
                                                "title"=>"Klik untuk melihat details formulir",
                                            ))',
                                'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                            ),
                            array(
                                'header' => 'Stock Opname',
                                'type' => 'raw',
                                'value' => '(!empty($data->stokopname_id) ? "Sudah Stock Opname" : "").CHtml::link("<icon class=\"icon-form-stockopname\">", "' . $this->getUrlStokOpname() . '&formuliropname_id=$data->formuliropname_id", 
                                            array("rel"=>"tooltip",
                                            "title"=>"Klik untuk melakukan stock opname ".(!empty($data->stokopname_id) ? "lagi" : ""),))',
                                'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                            ),
                        ),
                        'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                    )); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
// ===========================Dialog Details=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogFormulir',
    // additional javascript options for the dialog plugin
    'options' => array(
        'title' => 'Details Formulir Opname',
        'autoOpen' => false,
        'zIndex' => 1003,
        'minWidth' => 900,
        'height' => 320,
        'resizable' => true,
    ),
));
?>
<iframe src="" name="formulir" style="width: 100%; height: 98%;"></iframe>
<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');
//===============================Akhir Dialog Details================================
?>
<!--/div-->