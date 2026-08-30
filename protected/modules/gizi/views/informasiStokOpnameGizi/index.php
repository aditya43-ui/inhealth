<div class="panel panel-primary panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <strong>Stok Opname Bahan Makanan</strong>
        </div>
    </div>
    <div class="panel-body">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title"><i class="entypo-search"></i> Pencarian</div>
            </div>
            <div class="panel-body">
                <?php echo $this->renderPartial($this->path_view . 'search', array('model' => $model, 'format' => $format)); ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <strong>Stok Opname Bahan Makanan</strong>
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
                                'header' => 'Tgl. Stock Opname',
                                'type' => 'raw',
                                'value' => 'MyFormatter::formatDateTimeForUser($data->tglstokopnamegizi)',
                            ),
                            'nostokopnamegizi',
                            array(
                                'header' => 'Tgl. Formulir Opname',
                                'type' => 'raw',
                                'value' => 'MyFormatter::formatDateTimeForUser($data->tglformulir)',
                            ),
                            'noformulir',
                            'jenisstokopnamegizi',
                            'keterangan_opname',
                            array(
                                'header' => 'Mengetahui',
                                'type' => 'raw',
                                'value' => '$data->Mengetahui',
                            ),
                            array(
                                'header' => 'Petugas 1',
                                'type' => 'raw',
                                'value' => '$data->Petugas1',
                            ),
                            array(
                                'header' => 'Petugas 2',
                                'type' => 'raw',
                                'value' => '$data->Petugas2',
                            ),
                            /*
                                    array(
                                        'header'=>'Total HPP',
                                        'type'=>'raw',
                                        'value'=>(Params::cekHiddenHargaGudangFarmasi()==true)?'"Rp".number_format($data->totalnetto,0,"",".")':'"Hidden"',
                                        'htmlOptions' => array('style'=>'text-align:right;')  
                                    ),
                                     * 
                                     */
                            array(
                                'header' => 'Detail',
                                'type' => 'raw',
                                'value' => 'CHtml::Link("<i class=\"icon-form-detail\"></i>","' . $this->getUrlPrint() . '&stokopnamegizi_id=$data->stokopnamegizi_id&frame=true",
                                            array("class"=>"", 
                                                "target"=>"stokopname",
                                                "onclick"=>"$(\"#dialogStokOpnameGizi\").dialog(\"open\");",
                                                "rel"=>"tooltip",
                                                "title"=>"Klik untuk melihat details stock opname",
                                            ))',
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
    'id' => 'dialogStokOpnameGizi',
    // additional javascript options for the dialog plugin
    'options' => array(
        'title' => 'Detail Stok Opname',
        'autoOpen' => false,
        'minWidth' => 900,
        'height' => 500,
        'resizable' => false,
    ),
));
?>
<iframe src="" name="stokopname" width="100%" height="500">
</iframe>
<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');
//===============================Akhir Dialog Details================================
?>
<!--/div-->