<div class="panel panel-primary panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">Informasi <strong>Penerimaan Persediaan</strong></div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Informasi Penerimaan Persediaan',
        );
        Yii::app()->clientScript->registerScript('search', "
                $('.search-button').click(function(){
                    $('.search-form').toggle();
                    return false;
                });
                $('.search-form form').submit(function(){
                    $.fn.yiiGridView.update('guterimapersediaan-t-grid', {
                        data: $(this).serialize()
                    });
                    return false;
                });
                ");
        $this->widget('bootstrap.widgets.BootAlert'); ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-search"></i> Pencarian
                </div>
            </div>
            <div class="panel-body">
                <?php $this->renderPartial('_search', array(
                    'model' => $model,
                )); ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Penerimaan Persediaan</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'guterimapersediaan-t-grid',
                    'dataProvider' => $model->searchInformasi(),
                    //	'filter'=>$model,
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-bordered table-striped table-condensed',
                    'columns' => array(
                        array(
                            'header' => 'Tanggal Terima',
                            'value' => 'MyFormatter::formatDateTimeForUser($data->tglterima)'
                        ),
                        array(
                            'header' => 'No. Penerimaan',
                            'value' => '$data->nopenerimaan',
                        ),
                        array(
                            'header' => 'Tgl. Permintaan/<br>No Permintaan',
                            'value' => function ($data) {
                                $tgl = !empty($data->pembelianbarang_id) ? MyFormatter::formatDateTimeForUser($data->pembelianbarang->tglpembelian) : '';
                                $no = !empty($data->pembelianbarang_id) ? $data->pembelianbarang->nopembelian : '';
                                echo $tgl . ' / <br>' . $no;
                            },
                        ),
                        array(
                            'header' => 'Pegawai Penerima',
                            'value' => 'isset($data->peg_penerima_id)?$data->penerima->namaLengkap:"-"',
                        ),
                        array(
                            'header' => 'Pegawai Mengetahui',
                            'value' => 'isset($data->peg_mengetahui_id)?$data->mengetahui->namaLengkap:"-"',
                        ),
                        array(
                            'header' => 'Supplier',
                            'value' => '!empty($data->supplier_id)?$data->supplier->supplier_nama:"-"'
                        ),
                        array(
                            'header' => 'Rincian',
                            'type' => 'raw',
                            'value' => 'CHtml::link("<i class=\'icon-form-detail\'></i> ",  Yii::app()->controller->createUrl("/gudangUmum/TerimapersediaanT/detailTerimaPersediaan",array("id"=>$data->terimapersediaan_id,"frame"=>1)),array("target"=>"frameDetail","rel"=>"tooltip","title"=>"Klik untuk Melihat Rincian Penerimaan Barang", "onclick"=>"window.parent.$(\'#dialogDetail\').dialog(\'open\')"));',    'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                        ),
                        array(
                            'header' => 'Retur Penerimaan',
                            'type' => 'raw',
                            'value' => '(empty($data->nofaktur) ? "Belum Difaktur":((empty($data->returpenerimaan_id)) ? CHtml::link("<i class=\'icon-form-retur\'></i> ",  Yii::app()->controller->createUrl("/gudangUmum/ReturpenerimaanT/index",array("id"=>$data->terimapersediaan_id)),array( "rel"=>"tooltip","title"=>"Klik untuk Retur Penerimaan Persediaan Barang", )) : "Telah Diretur"))',    'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                        ),
                    ),
                    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                )); ?>
            </div>
        </div>
    </div>
</div>
<?php
//========= Dialog untuk Melihat detail Pengajuan Bahan Makanan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogDetail',
    'options' => array(
        'title' => 'Rincian Penerimaan Barang',
        'autoOpen' => false,
        'modal' => true,
        'zIndex' => 1002,
        'width' => 1000,
        'height' => 600,
        'resizable' => false,
    ),
));
echo '<iframe src="" name="frameDetail" style="width: 100%; height: 98%;"></iframe>';
$this->endWidget();
?>