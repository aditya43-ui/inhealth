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
        <?php echo $this->renderPartial($this->path_view . 'search', array(
            'model' => $model,
            'format' => $format,
            'instalasiAsals' => $instalasiAsals,
            'ruanganAsals' => $ruanganAsals
        )); ?>
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
                //							$provider = $model->searchDataObatInformasi();
                //							$provider->sort->defaultOrder = "obatalkes_nama";
                ?>
                <div class="search-form">
                    <?php $this->widget('ext.bootstrap.widgets.HeaderGroupGridViewNonRp', array(
                        'id' => 'informasi-grid',
                        'dataProvider' => $model->searchDataObatInformasi(),
                        'template' => "{summary}\n{items}\n{pager}",
                        'itemsCssClass' => 'table table-bordered table-striped table-condensed',
                        'mergeHeaders' => array(
                            array(
                                'name' => 'Kondisi Obat Alkes',
                                'start' => 7,
                                'end' => 8,
                            ),
                        ),
                        'columns' => array(
                            array(
                                'header' => 'Instalasi',
                                'type' => 'raw',
                                'value' => '$data->instalasi_nama'
                            ),
                            array(
                                'header' => 'Ruangan',
                                'type' => 'raw',
                                'value' => '$data->ruangan_nama'
                            ),
                            array(
                                'header' => 'Jenis Obat Alkes',
                                'type' => 'raw',
                                'value' => '$data->jenisobatalkes_nama'
                            ),
                            array(
                                'header' => 'Kode Obat Alkes',
                                'type' => 'raw',
                                'value' => '$data->obatalkes_kode'
                            ),
                            array(
                                'header' => 'Nama Obat Alkes',
                                'type' => 'raw',
                                'value' => '$data->obatalkes_nama'
                            ),
                            array(
                                'header' => 'Stok Minimal',
                                'type' => 'raw',
                                //                                        'value' => '$data->minimalstok'
                                'value' => function ($data) {
                                    $modKonfigF = KonfigfarmasiK::model()->find();

                                    $minimalstok = 0;
                                    if ($modKonfigF->isstokminimalfarmasi) {
                                        $minimalstok = $data->minimalstok;
                                    } else {
                                        $modStokMinimal = StokminimalT::model()->findByAttributes(array('ruangan_id' => $data->ruangan_id, 'obatalkes_id' => $data->obatalkes_id));
                                        if (isset($modStokMinimal)) {
                                            $minimalstok = $modStokMinimal->jmlminimalstok;
                                        }
                                    }

                                    return MyFormatter::formatNumberForPrint($minimalstok,2);
                                }
                            ),
                            array(
                                'header' => 'Tanggal Kedaluwarsa',
                                'type' => 'raw',
                                'value' => 'MyFormatter::formatDateTimeForUser($data->tglkadaluarsa)'
                            ),
                            array(
                                'header' => 'Baik',
                                'type' => 'raw',
                                'value' => 'MyFormatter::formatNumberForPrint($data->qtystokoa_baik,2) ." ".$data->satuankecil_nama'
                            ),
                            array(
                                'header' => 'Rusak',
                                'type' => 'raw',
                                'value' => 'MyFormatter::formatNumberForPrint($data->qtystokoa_rusak,2) ." ".$data->satuankecil_nama'
                            ),
                            array(
                                'header' => 'Jumlah Obat Alkes',
                                'type' => 'raw',
                                'value' => 'MyFormatter::formatNumberForPrint($data->qtystokoa,2) ." ".$data->satuankecil_nama'
                            ),
                            array(
                                'header' => 'Rincian',
                                'type' => 'raw',
                                'value' => 'CHtml::link("<i class=\'icon-form-detail\'></i> ",  Yii::app()->controller->createUrl("rincian",array("id"=>$data->obatalkes_id,"ruangan_id"=>$data->ruangan_id,"frame"=>true)),array("id"=>"$data->obatalkes_id","target"=>"frameDetail","rel"=>"tooltip","title"=>"Rincian Stok Obat Alkes", "onclick"=>"window.parent.$(\'#dialogDetail\').dialog(\'open\')"));',
                                'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                            ),

                            //                                    'instalasi_nama',
                            //                                    'ruangan_nama',
                            //                                    array(
                            //                                        'header' => 'Jenis Kelompok',
                            //                                        'value' => '$data->lookup_name'
                            //                                    ),
                            //                                    array(
                            //                                        'name'=>'jenisobatalkes_nama',
                            //                                        'value'=>'!empty($data->jenisobatalkes_id)?(($data->jenisobatalkes_nama==null)?$data->jenisobatalkes->jenisobatalkes_nama:$data->jenisobatalkes_nama):"-"',
                            //                                    ),
                            //                                    'obatalkes_golongan',
                            //                                    'obatalkes_kategori',           
                            //                                    'obatalkes_kode',
                            //                                    'obatalkes_nama',
                            //                                       array(
                            //                                        'header'=>'Minimal Stok',
                            //                                        'type'=>'raw',
                            //                                        'value'=>'$data->minimalstok'
                            //                                           ),
                            //                                    array(
                            //                                        'header'=>'Tanggal kedaluwarsa',
                            //                                        'type'=>'raw',
                            //                                        'value'=>function($data) {  
                            //                                            $criteria = new CDbCriteria();
                            //                                            $criteria->select = "tglkadaluarsa";
                            //                                            $criteria->compare('obatalkes_id',$data->obatalkes_id);
                            //                                            $criteria->addCondition("ruangan_id = ".Yii::app()->user->getState('ruangan_id'));
                            //                                            $criteria->order = 'tglterima DESC';
                            //                                            $stok = StokobatalkesT::model()->find($criteria);
                            //                                            if (empty($stok)) {
                            //                                                return "-";
                            //                                            }
                            //                                            return MyFormatter::formatDateTimeForUser($stok->tglkadaluarsa);
                            //                                           }
                            //                                        ),
                            //                                    
                            //                                    array(
                            //                                        'header'=>'Stok Masuk',
                            //                                        'type'=>'raw',
                            //                                        'value'=>function($data) use (&$stok) {                                           
                            //                                            $criteria = new CDbCriteria();
                            //                                            $criteria->compare('obatalkes_id',$data->obatalkes_id);
                            //                                            // $criteria->addCondition("tglkadaluarsa = '".MyFormatter::formatDateTimeForDb($data->tglkadaluarsa)."' ");
                            //                                            //if (Yii::app()->user->getState('ruangan_id') != Params::RUANGAN_ID_GUDANG_FARMASI)
                            //                                            //{
                            //                                            $criteria->addCondition("ruangan_id = ".$data->ruangan_id);
                            //                                            //}
                            //                                            $stok = StokobatalkesT::model()->findAll($criteria);
                            //                                            $total = 0;
                            //                                            foreach ($stok as $item) {
                            //                                                $total += $item->qtystok_in;
                            //                                            }
                            //                                            $satuan = ($data->satuankecil_nama==null)?$data->satuankecil->satuankecil_nama:$data->satuankecil_nama;
                            //
                            //                                            return MyFormatter::formatNumberForPrint($total)." ".$satuan;
                            //
                            //                                        },
                            //                                        'htmlOptions'=>array(
                            //                                            'style'=>'text-align: right;'
                            //                                        )
                            //                                    ), 
                            //                                    array(
                            //                                        'header'=>'Stok Keluar',
                            //                                        'type'=>'raw',
                            //                                        'value'=>function($data) use (&$stok) {
                            //
                            //                                            $total = 0;
                            //                                            foreach ($stok as $item) {
                            //                                                    $total += $item->qtystok_out;
                            //                                            }
                            //                                            $satuan = ($data->satuankecil_nama==null)?$data->satuankecil->satuankecil_nama:$data->satuankecil_nama;
                            //                                            return MyFormatter::formatNumberForPrint($total)." ".$satuan;
                            //                                        },
                            //                                        'htmlOptions'=>array(
                            //                                            'style'=>'text-align: right;'
                            //                                        )
                            //                                    ),
                            //                                    array(
                            //                                        'header'=>'Stok Akhir',
                            //                                        'type'=>'raw',
                            //                                        'value'=>function($data) use (&$stok) {
                            //
                            //                                            $total = 0;
                            //                                            foreach ($stok as $item) {
                            //                                                $total += $item->qtystok_in - $item->qtystok_out;
                            //                                            }
                            //                                            $satuan = ($data->satuankecil_nama==null)?$data->satuankecil->satuankecil_nama:$data->satuankecil_nama;
                            ////                                            return MyFormatter::formatNumberForPrint($total)." ".$satuan;
                            //                                            return number_format($total,0,",",".")." ".$satuan;
                            //                                        },
                            //                                        'htmlOptions'=>array(
                            //                                            'style'=>'text-align: right;'
                            //                                        )
                            //                                    ),                                 
                        ),
                        'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                    )); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
//========= Dialog untuk Melihat detail Pengajuan Bahan Makanan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogDetail',
    'options' => array(
        'title' => 'Rincian Stok Obat Alkes',
        'autoOpen' => false,
        'modal' => true,
        'width' => 1000,
        'height' => 550,
        'resizable' => false,
    ),
));

echo '<iframe src="" name="frameDetail" style="width: 100%; height: 98%;"></iframe>';

$this->endWidget();
?>