<?php
$this->breadcrumbs = array(
    'Informasi Formulir Stok Opname Bahan Makanan',
); ?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-briefcase"></i> Informasi <b>Formulir Stok Opname Bahan Makanan</b>
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
                    <i class="entypo-credit-card"></i> Tabel <b>Formulir Stok Opname Bahan Makanan</b>
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
                        'columns' => array(
                            array(
                                'name' => 'tglformulir',
                                'type' => 'raw',
                                'value' => 'MyFormatter::formatDateTimeForUser($data->tglformulir)'
                            ),
                            'noformulir',
                            'totalvolume',
                            array(
                                'header' => 'Formulir',
                                'type' => 'raw',
                                'value' => 'CHtml::Link("<i class=\"icon-form-formulir\"></i>","' . $this->getUrlPrint() . '&formuliropnamegizi_id=$data->formuliropnamegizi_id&frame=true",
                                            array("class"=>"", 
                                                "target"=>"formulir",
                                                "onclick"=>"$(\"#dialogFormulir\").dialog(\"open\");",
                                                "rel"=>"tooltip",
                                                "title"=>"Klik untuk melihat detail formulir",
                                            ))',
                                'htmlOptions' => array('style' => 'text-align:left;'),
                            ),
                            array(
                                'header' => 'Stok Opname',
                                'type' => 'raw',
                                'value' => '(!empty($data->stokopnamegizi_id) ? "Sudah Stok Opname" : "").CHtml::link("<icon class=\"icon-form-stockopname\">", "' . $this->getUrlStokOpname() . '&formuliropnamegizi_id=$data->formuliropnamegizi_id", 
                                            array("rel"=>"tooltip",
                                            "title"=>"Klik untuk melakukan stok opname ".(!empty($data->stokopnamegizi_id) ? "lagi" : ""),))',
                                'htmlOptions' => array('style' => 'text-align:left;'),
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
        'minWidth' => 900,
        'height' => 320,
        'resizable' => false,
    ),
));
?>
<iframe src="" name="formulir" style="width: 100%; height: 98%;"></iframe>
<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');
//===============================Akhir Dialog Details================================
?>
<!--/div-->