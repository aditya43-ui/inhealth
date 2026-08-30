<?php
$modAntri = new AntrianT('searchDialog');
$modAntri->default = 'kosong';
if(isset($_GET['AntrianT'])){
    $modAntri->attributes = $_GET['AntrianT']; 
    $modAntri->default = isset($_GET['AntrianT']['default'])?$_GET['AntrianT']['default']:null;
}

$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'daftar-antrian-grid',
	'dataProvider'=>$modAntri->searchRiwayatPanggil2(),
//	'filter'=>$modAntri,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
            array(
                'header'=>'No',                    
                'value'=>'$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1',
            ),
            'jam_panggil',
            'barcode',
            'noantrian',
            [
                'header' => 'Poliklnik',
                'type' => 'raw',
                'value' => function($data){
                    return CHtml::link('<i class="'.MyIcon::getIcons('ubah').'"></i> '.$data->ruangan_nama, 'javascript:;', ['onclick'=>'ubahPoliklinik('.$data->antrian_id.',"generate");', 'class'=>'btn btn-default', 'rel'=>'tooltip', 'title'=>'Klik untuk mengubah ruangan poliklinik']);
                },
            ],
            [
                'header' => 'Kunjungan',
                'type' => 'raw',
                'value' => function($data){
                    if ($data->jenis_kunjungan == 'Fast Track'){
                        return CHtml::link('View '.$data->jenis_kunjungan,'javascript:;',[
                            'onclick'=>"detailFastTrack(this);",
                            'data-nama-pj' => $data->nama_pj,
                            'data-no-rm' => $data->no_rekam_medik,
                            'data-nama-pasien' => $data->nama_pasien,
                            'data-alasan' => $data->alasan_fasttrack,
                            'class' => 'btn btn-default btn-sm status-kunjungan',
                            'data-jenis-kunjungan'=>$data->jenis_kunjungan
                        ]);
                    }else{
                        return '<span class="status-kunjungan" data-jenis-kunjungan="'.$data->jenis_kunjungan.'">'.$data->jenis_kunjungan.'</span>';
                    }
                },
                'htmlOptions' => [
                    'class' => ''
                ]
            ],
            [
                'header' => 'Pembayaran',
                'name' => 'modelantrian_nama'                
            ],
            [
                'header' => 'Panggil',
                'type' => 'raw',
                'value' => function($data){
                    $panggil = CHtml::link("<i class='icon-volume-up'></i>",'javascript:;',['onclick'=>'panggilNoAntrian('.$data->antrian_id.')']);
                    if (($data->status_barcode == ParamsConst::STATUSBARCODE_ANTRIAN_PENDING)){
                        return $panggil;
                    }else{
                        if (empty($data->status_panggil)){
                            return ParamsConst::STATUSPANGGIL_ANTRIAN_TUNGGU;
                        }
                        if ($data->status_panggil == ParamsConst::STATUSPANGGIL_ANTRIAN_CALLOUTSIDE){
                            return CHtml::link($data->status_panggil,'javascript:;',['onclick'=>'panggilNoAntrian('.$data->antrian_id.',"'.$data->status_panggil.'")','class'=>'btn btn-warning','rel'=>'tooltip','title'=>'Klik untuk memanggil antrian ke layar antrian lantai 2']);
                        }
                       return $data->status_panggil;
                    }
                }
            ],
            [
                'header' => 'Status',
                'type' => 'raw',
                'value' => function($data){
                    if (!empty($data->status_barcode)){
                        if ($data->status_barcode == ParamsConst::STATUSBARCODE_ANTRIAN_PENDING){
                            return CHtml::link(ParamsConst::STATUSBARCODE_ANTRIAN_SELESAIPENDING,'javascript:;',['onclick'=>'statusBarcodeAntrian('.$data->antrian_id.',1)','class'=>'btn btn-gold btn-sm']);
                        }else{
                            return $data->status_barcode;
                        }
                    }else{
                        return 'Belum Barcode';                        
                    }
                }
            ]
	),
        'afterAjaxUpdate'=>'function(id, data){setStatus();jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));