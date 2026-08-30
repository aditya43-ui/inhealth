<div class="panel panel-primary panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <strong>Stock Opname Obat Alkes</strong>
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
                    <i class="entypo-credit-card"></i> Tabel <strong>Stock Opname Obat Alkes</strong>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php
                $this->breadcrumbs = array(
                    'Informasi Stock Opname Obat Alkes',
                );
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
                                'header' => 'No.',
                                'type' => 'raw',
                                'value' => '$row+1',
                            ),
                            array(
                                'header' => 'Tanggal Stock Opname',
                                'type' => 'raw',
                                'value' => 'MyFormatter::formatDateTimeForUser($data->tglstokopname)',
                            ),
                            'nostokopname',
                            array(
                                'header' => 'Tanggal Formulir Opname',
                                'type' => 'raw',
                                'value' => 'MyFormatter::formatDateTimeForUser($data->tglformulir)',
                            ),
                            'noformulir',
                            'jenisstokopname',
                            'keterangan_opname',
                            array(
                                'header' => 'Total Nilai Persediaan (Rp)',
                                'type' => 'raw',
                                'value' => function ($data) {
                                    $oriDetStockOp = StokopnamedetT::model()->findAllByAttributes(array('stokopname_id' => $data->stokopname_id));
                                    $nilai = 0;
                                    if (count((array)$oriDetStockOp) > 0) {
                                        foreach ($oriDetStockOp as $dataDetStock) {
                                            $nilai += $dataDetStock->totalnilaipersediaan;
                                        }
                                    }
                                    return MyFormatter::formatNumberForPrint($nilai, 2);
                                },
                                'htmlOptions' => array('style' => 'text-align:right')
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
                            array(
                                'header' => 'Pegawai Mengetahui',
                                'type' => 'raw',
                                'value' => '$data->Mengetahui',
                            ),
                            array(
                                'header' => 'Detail',
                                'type' => 'raw',
                                'value' => 'CHtml::Link("<i class=\"icon-form-detail\"></i>","' . $this->getUrlPrint() . '&stokopname_id=$data->stokopname_id&frame=true",
                                            array("class"=>"",
                                                "target"=>"stokopname",
                                                "onclick"=>"$(\"#dialogStokOpname\").dialog(\"open\");",
                                                "rel"=>"tooltip",
                                                "title"=>"Klik untuk melihat details stock opname",
                                            ))',
                                'htmlOptions' => array('style' => 'text-align:left;'),
                            ),
                            array(
                                'header' => 'Batal',
                                'type' => 'raw',
                                'value' => function ($data) {
                                    return CHtml::link('<i class="icon-form-silang"></i>', "javascript:void(0)", array(
                                        'rel' => 'tooltip',
                                        'name' => 'Klik untuk membatalkan Stock Opname.',
                                        'onclick' => 'batalStockOpname(' . $data->stokopname_id . '); return false;'
                                    ));
                                }
                            ),
                        ),
                        'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                    )); ?>
                </div>
            </div>
        </div>
        <!-- <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title"><i class="entypo-search"></i> Pencarian</div>
            </div>
            <div class="panel-body">
                <?php //echo $this->renderPartial($this->path_view . 'search', array('model' => $model, 'format' => $format)); ?>
            </div>
        </div> -->
    </div>
</div>
<?php
// ===========================Dialog Details=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogStokOpname',
    // additional javascript options for the dialog plugin
    'options' => array(
        'title' => 'Details Stock Opname',
        'autoOpen' => false,
        'minWidth' => 900,
        'minHeight' => 100,
        'resizable' => false,
    ),
));
?>
<iframe src="" name="stokopname" width="100%" height="500px">
</iframe>
<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');
//===============================Akhir Dialog Details================================
?>
<!--/div-->
<script type="text/javascript">
    function batalStockOpname(id) {
        myConfirm("Apakah anda akan menghapus data stock opname ini?", "Peringatan", function(r) {
            if (r) {
                $.post("<?php echo $this->createUrl("batalStockOpname"); ?>", {
                    id: id
                }, function(data) {
                    if (data.ok == 1) {
                        myAlert("Transaksi Stock Opname berhasil dibatalkan");
                        $.fn.yiiGridView.update("rencana-m-grid");
                    } else {
                        myAlert(data.msg);
                    }
                }, "json");
            }
        });
    }
</script>