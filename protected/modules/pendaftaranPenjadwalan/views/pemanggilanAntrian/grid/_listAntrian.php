
<?php

$modAntri = new AntrianT;
$modAntri->default = 'kosong';
$modAntri->katakunci = '';

if(isset($_GET['AntrianT'])){
    $modAntri->attributes = $_GET['AntrianT']; 
    $modAntri->default = isset($_GET['AntrianT']['default'])?$_GET['AntrianT']['default']:null;
    $modAntri->katakunci = isset($_GET['AntrianT']['katakunci'])?$_GET['AntrianT']['katakunci']:null;
}

Yii::app()->clientScript->registerScript('search', "
$('.search-form form').submit(function(){
	return submitInformasiDetail();
});
");

?>
			<div class="col-sm-6">
                <label>Search</label>
				<?php echo CHtml::activeTextField($modAntri, 'katakunci', array('class'=>'span3 katakunci','onkeyup'=>'cariInformasi()'));
				 ?>
			</div>
 <br><br>
<div class="search-form form">

<?php
$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'daftar-antrian-grid',
	'dataProvider'=>$modAntri->searchRiwayatPanggil(),
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
            [
                'header' => 'Nomor Antrian',
                'type' => 'raw',
                'value' => function($data){
                    $ruangan = $data->ruangan;
                    $dt1 = $data->noantrian;
                    $hasil = explode('-',$dt1);
                    $noantrian2 = $hasil[1];
               
                if($data->modelantrian->modelantrian_id == Params::MODELANTRIAN_UMUM_ANTRIAN){
                    return strtoupper($data->modelantrian->modelantrian_singkatan."-".str_pad($noantrian2, 3, '0', STR_PAD_LEFT));
                       } else {
                        return strtoupper($ruangan->ruangan_singkatan . "-" . str_pad($noantrian2, 3, '0', STR_PAD_LEFT));
                    } 
                }
            ],
            [
                'header' => 'Poliklnik',
                'type' => 'raw',
                'value' => function($data){
                    if($data->ubah_ruangan_id == null) {
                        return CHtml::link('<i class="'.MyIcon::getIcons('ubah').'"></i> '.$data->ruangan_nama, 'javascript:;', ['onclick'=>'ubahPoliklinik('.$data->antrian_id.',"generate");', 'class'=>'btn btn-default', 'rel'=>'tooltip', 'title'=>'Klik untuk mengubah ruangan poliklinik']);
                    } else {
                        return CHtml::link('<i class="'.MyIcon::getIcons('ubah').'"></i> '.$data->ubahruangan->ruangan_nama, 'javascript:;', ['onclick'=>'ubahPoliklinik('.$data->antrian_id.',"generate");', 'class'=>'btn btn-default', 'rel'=>'tooltip', 'title'=>'Klik untuk mengubah ruangan poliklinik']);
                    }
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
                // 'name' => 'modelantrian_nama'
                'type' => 'raw',
                'value' => function($data) {
                    if($data->ubah_modelantrian_id != null) {
                        return $data->ubahmodelantrian->modelantrian_nama;
                    } else {
                        return $data->modelantrian_nama;
                    }
                }                
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
            ],
            [
                'header' => 'Daftar Ke Poliklinik',
                'type' => 'raw',
                'value' =>'CHtml::link("<i class=\'icon-form-poliklinik\'></i> ", 
                "index.php?r=pendaftaranPenjadwalan/PendaftaranRawatJalan/index&antrian_id=$data->antrian_id",array("id"=>"$data->antrian_id",
                    "title"=>"Klik untuk Mendaftarkan ke Rawat Jalan","rel"=>"tooltip")) ',
        'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
        ]
            
	),
        'afterAjaxUpdate'=>'function(id, data){setStatus();jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));

?>
<script>
   function cariInformasi(e) {


	$.fn.yiiGridView.update('daftar-antrian-grid', {
		data:$('.search-form form, .katakunci').serialize()
	});
    
	return false;


}

function submitInformasiDetail() {
	$(".katakunci").val("");
	return cariInformasi();
}
</script>

