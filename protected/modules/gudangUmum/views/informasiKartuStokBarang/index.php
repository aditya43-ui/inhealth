<?php
$this->breadcrumbs = array(
    'Informasi Kartu Stok Barang',
);
?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <b>Kartu Stok Barang</b>
        </div>
    </div>
    <div class="panel-body">
        <?php echo $this->renderPartial($this->path_view . 'search', array('model' => $model, 'format' => $format, 'instalasiAsals' => $instalasiAsals, 'ruanganAsals' => $ruanganAsals, 'disabled' => $disabled)); ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Kartu Stok Barang</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php
                Yii::app()->clientScript->registerScript('search', "
								$('#divSearch-form form').submit(function(){
									console.log($('#informasi-search').serialize());
									$.fn.yiiGridView.update('informasi-grid', {
										data: $('#informasi-search').serialize()
								});
								return false;
							});
							");
                ?>
                <div class="search-form">
                    <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
                        'id' => 'informasi-grid',
                        'dataProvider' => $model->search(),
                        'template' => "{summary}\n{items}\n{pager}",
                        'itemsCssClass' => 'table table-bordered table-striped table-condensed',
                        'columns' => array(
                            array(
                                'header' => 'Instalasi/<br>Ruangan',
                                'name' => 'ruangan_nama',
                                'type' => 'raw',
                                'value' => '$data->instalasi_nama."/<br>".$data->ruangan_nama',
                            ),
                            array(
                                'name' => 'tgltransaksi',
                                'header' => 'Tgl. Transaksi',
                                'type' => 'raw',
                                'value' => 'MyFormatter::formatDateTimeForUser($data->tgltransaksi)',
                                'htmlOptions' => array('style' => 'text-align: right;'),
                            ),
                            'jenisbarang_nama',
                            'barang_type',
                            array(
                                'header' => 'No. Transaksi',
                                'type' => 'raw',
                                'value' => '$data->noTransaksi',
                            ),
                            array(
                                'header' => 'Keterangan',
                                'type' => 'raw',
                                'value' => '$data->keteranganTransaksi',
                            ),
                            'barang_kode',
                            'barang_nama',
                            array(
                                'header' => 'Harga',
                                'type' => 'raw',
                                'value' => (Params::cekHiddenHargaGudangUmum() == true || Params::cekHiddenHargaGudangFarmasi() == true) ? 'MyFormatter::formatNumberForPrint($data->inventarisasi_hargasatuan)' : '"Hidden"',
                                'htmlOptions' => array(
                                    'style' => (Params::cekHiddenHargaGudangUmum() == true || Params::cekHiddenHargaGudangFarmasi() == true) ? 'text-align: right;' : 'text-align: center;',
                                ),
                            ),
                            array(
                                'header' => 'Stok Awal',
                                'value' => '"0 ".$data->barang_satuan',
                                'htmlOptions' => array(
                                    'style' => 'text-align: right;',
                                )
                            ),
                            array(
                                'name' => 'qtystok_in',
                                'value' => '$data->qtystok_in." ".$data->barang_satuan',
                                'htmlOptions' => array(
                                    'style' => 'text-align: right;',
                                )
                            ),
                            array(
                                'name' => 'qtystok_out',
                                'value' => '$data->qtystok_out." ".$data->barang_satuan',
                                'htmlOptions' => array(
                                    'style' => 'text-align: right;',
                                )
                            ),
                            array(
                                'header' => 'Sisa Stok',
                                'value' => '$data->getSisaStok($data->qtystok_in, $data->qtystok_out, $data->barang_satuan)',
                                'htmlOptions' => array(
                                    'style' => 'text-align: right;',
                                )
                            ),
                            array(
                                'header' => 'Harga Netto',
                                'type' => 'raw',
                                'value' => (Params::cekHiddenHargaGudangUmum() == true || Params::cekHiddenHargaGudangFarmasi() == true) ? 'MyFormatter::formatNumberForPrint($data->barang_harga)' : '"Hidden"',
                                'htmlOptions' => array(
                                    'style' => (Params::cekHiddenHargaGudangUmum() == true || Params::cekHiddenHargaGudangFarmasi() == true) ? 'text-align: right;' : 'text-align: center;',
                                ),
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
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$urlPrint =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/print');
?>

<script>
    function print(caraPrint) {
        window.open("<?php echo $urlPrint; ?>/" + $('#informasi-search').serialize() + "&caraPrint=" + caraPrint, "", 'location=_new, width=900px');
    }
</script>