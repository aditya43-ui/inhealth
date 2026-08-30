<?php
$this->breadcrumbs = array(
    'Informasi Stok Obat dan Alat Kesehatan',
);
?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <b>Stok Obat dan Alat Kesehatan</b>
        </div>
    </div>
    <div class="panel-body">
        <div id="divSearch-form">
            <?php echo $this->renderPartial($this->path_view . 'search', array(
                'model' => $model,
                'format' => $format,
                //'instalasiAsals'=>$instalasiAsals,
                //'ruanganAsals'=>$ruanganAsals
            )); ?>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Stok Obat dan Alat Kesehatan</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php
                Yii::app()->clientScript->registerScript('search', "
							$('#divSearch-form form').submit(function(){
									$('#informasi-grid').addClass('animation-loading');
								$.fn.yiiGridView.update('informasi-grid', {
									data: $(this).serialize()
								});
								return false;
							});
							");
                $provider = $model->searchDataObatInformasi();
                $provider->sort->defaultOrder = "obatalkes_nama";
                ?>
                <div class="search-form">
                    <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
                        'id' => 'informasi-grid',
                        'dataProvider' => $provider,
                        'template' => "{summary}\n{items}\n{pager}",
                        'itemsCssClass' => 'table table-bordered table-striped table-condensed',
                        'columns' => array(
                            array(
                                'header' => 'Jenis Kelompok',
                                'value' => '$data->lookup_name'
                            ),
                            array(
                                'name' => 'jenisobatalkes_nama',
                                'value' => '!empty($data->jenisobatalkes_id)?(($data->jenisobatalkes_nama==null)?$data->jenisobatalkes->jenisobatalkes_nama:$data->jenisobatalkes_nama):"-"',
                            ),
                            'obatalkes_golongan',
                            'obatalkes_kategori',
                            'obatalkes_kode',
                            'obatalkes_nama',
                            array(
                                'header' => 'Minimal Stok',
                                'type' => 'raw',
                                'value' => '$data->minimalstok'
                            ),
                            array(
                                'header' => 'Stok Awal',
                                'type' => 'raw',
                                //                                        'value'=>'MyFormatter::formatNumberForUser($data->getStokSebelum())',
                                'value' => '0',
                                'htmlOptions' => array('style' => 'text-align: right;'),
                            ),
                            array(
                                'header' => 'Stok Masuk',
                                'type' => 'raw',
                                'value' => function ($data) use (&$stok) {
                                    $criteria = new CDbCriteria();
                                    $criteria->compare('obatalkes_id', $data->obatalkes_id);
                                    // $criteria->addCondition("tglkadaluarsa = '".MyFormatter::formatDateTimeForDb($data->tglkadaluarsa)."' ");
                                    //if (Yii::app()->user->getState('ruangan_id') != Params::RUANGAN_ID_GUDANG_FARMASI)
                                    //{
                                    $criteria->addCondition("ruangan_id = " . Yii::app()->user->getState('ruangan_id'));
                                    //}
                                    $stok = StokobatalkesT::model()->findAll($criteria);
                                    $total = 0;
                                    foreach ($stok as $item) {
                                        $total += $item->qtystok_in;
                                    }
                                    $satuan = ($data->satuankecil_nama == null) ? $data->satuankecil->satuankecil_nama : $data->satuankecil_nama;

                                    return MyFormatter::formatNumberForPrint($total) . " " . $satuan;
                                },
                                'htmlOptions' => array(
                                    'style' => 'text-align: right;'
                                )
                            ),
                            array(
                                'header' => 'Stok Keluar',
                                'type' => 'raw',
                                'value' => function ($data) use (&$stok) {

                                    $total = 0;
                                    foreach ($stok as $item) {
                                        $total += $item->qtystok_out;
                                    }
                                    $satuan = ($data->satuankecil_nama == null) ? $data->satuankecil->satuankecil_nama : $data->satuankecil_nama;
                                    return MyFormatter::formatNumberForPrint($total) . " " . $satuan;
                                },
                                'htmlOptions' => array(
                                    'style' => 'text-align: right;'
                                )
                            ),
                            array(
                                'header' => 'Stok Akhir',
                                'type' => 'raw',
                                'value' => function ($data) use (&$stok) {

                                    $total = 0;
                                    foreach ($stok as $item) {
                                        $total += $item->qtystok_in - $item->qtystok_out;
                                    }
                                    $satuan = ($data->satuankecil_nama == null) ? $data->satuankecil->satuankecil_nama : $data->satuankecil_nama;
                                    return MyFormatter::formatNumberForPrint($total) . " " . $satuan;
                                },
                                'htmlOptions' => array(
                                    'style' => 'text-align: right;'
                                )
                            ),
                            array(
                                'header' => 'Harga Netto',
                                'type' => 'raw',
                                'value' => 'MyFormatter::formatNumberForUser($data->harganetto)',
                                'htmlOptions' => array('style' => 'text-align: right;'),
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
//=============================== Ganti Data Pasien Dialog =======================================
$this->beginWidget(
    'zii.widgets.jui.CJuiDialog',
    array(
        'id' => 'editlokasiobat',
        'options' => array(
            'title' => 'Ubah Data Lokasi Obat',
            'autoOpen' => false,
            'width' => 780,
            'height' => 480,
            'resizable' => true,
            "beforeClose" => 'js:function(){  $.fn.yiiGridView.update(\'informasi-grid\', {}); }'
        ),

    )
);
echo '<iframe name="frameEditLokasiObat" style="width:100%; height: 98%;"></iframe>';
$this->endWidget('zii.widgets.jui.CJuiDialog');
?>