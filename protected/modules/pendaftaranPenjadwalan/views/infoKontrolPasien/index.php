<?php
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('#formSearch').submit(function(){
	$.fn.yiiGridView.update('ppinfokontrolpasien-grid', {
		data: $(this).serialize()
	});
    return false;
});
");
?>

<?php
$this->breadcrumbs = array(
    'Informasi Rencana Kontrol',
); ?>

<style type="text/css">
    input[readonly] {
        background-color: #F5F5F5;
        border-color: #DDDDDD;
        cursor: auto;
    }
</style>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-users"></i> Informasi <b>Rencana Kontrol</b>
        </div>
    </div>
    <div class="panel-body">
        <?php $this->renderPartial('_search', array('model' => $model, 'format' => $format)); ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Rencana Kontrol</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'ppinfokontrolpasien-grid',
                    'dataProvider' => $model->searchKontrolPasien(),
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
                    'columns' => array(
                        //			'tglrenkontrol',
                        array(
                            'header' => 'Tgl. Rencana Kontrol',
                            'type' => 'raw',
                            'value' => 'MyFormatter::formatDateTimeForUser($data->tglrenkontrol)',
                        ),
                        array(
                            'header' => 'Tgl. Pendaftaran/<br>No. Pendaftaran',
                            //                'name'=>'Tgl. Pendaftaran',
                            'type' => 'raw',
                            'value' => 'MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran)."/<br>".$data->no_pendaftaran',
                        ),
                        array(
                            'header' => 'No. Rekam Medik',
                            //                'name'=>'No. Pendaftaran <br> No. Rekam Kedik',
                            'type' => 'raw',
                            // 'value' => '$data->pasien->no_rekam_medik',
                            'value' => function ($data) {
                                return $data->pasien->no_rekam_medik
                                ."<br>".
                                CHtml::link("<i class=icon-form-print></i> Struk", "javascript:printStruk(" . $data->pendaftaran_id . ");", array("rel" => "tooltip", "title" => "Klik untuk print struk"));
                            },
                            'htmlOptions' => array('style' => 'width:120px')
                        ),
                        array(
                            'header' => 'Nama Pasien',
                            'name' => 'nama_pasien',
                            'type' => 'raw',
                            'value' => 'isset($data->pasien->namadepan)?$data->pasien->namadepan." ".$data->pasien->nama_pasien:" ".$data->pasien->nama_pasien',
                        ),
                        array(
                            'header' => 'Alamat',
                            // 'name'=>'pasien.alamat_pasien',
                            'type' => 'raw',
                            'value' => '$data->pasien->alamat_pasien',
                        ),
                        array(
                            'header' => 'No. Telepon/<br>No HP',
                            //                'name'=>'No. Telp <br> No. HP',
                            'type' => 'raw',
                            'value' => '$data->pasien->no_telepon_pasien."/<br>".$data->pasien->no_mobile_pasien',
                        ),

                        /* array(
                            'name'=>'Alamat Email',
                            'type'=>'raw',
                            'value'=>'$data->pasien->alamatemail',
                        ),*/
                        array(
                            'header' => 'Jenis Penjamin',
                            'name' => 'carabayar.carabayar_nama',
                            'type' => 'raw',
                            'value' => '$data->carabayar->carabayar_nama."/<br>".$data->penjamin->penjamin_nama',
                        ),
                        array(
                            'name' => 'Instalasi',
                            'type' => 'raw',
                            'value' => '$data->instalasi->instalasi_nama',
                        ),
                        array(
                            'name' => 'Ruangan',
                            'type' => 'raw',
                            'value' => '$data->ruangan->ruangan_nama',
                        ),
                        array(
                            'name' => 'Polik Tujuan',
                            'type' => 'raw',
                            'value' => function ($data) {
                                $r = RuanganM::model()->findByPk($data->ruangankontrol_id);

                                if (!empty($r)) {
                                    return $r->ruangan_nama;
                                } else {
                                    return '';
                                }
                            }
                        ),
                        array(
                            'header' => 'Daftar Rawat <br> Jalan',
                            'type' => 'raw',
                            'value' => function ($data) { //(empty($data->pendaftaran_id) ?(($data->tgljadwal <= date("Y-m-d H:i:s"))?"Sudah Melewati Jadwal": CHtml::link("<i class=icon-form-poliklinik></i>", "javascript:daftarKeRJ(\'$data->pasien_id\',\'$data->buatjanjipoli_id\');",array("id"=>"$data->pasien_id","rel"=>"tooltip","title"=>"Klik untuk Mendaftarkan ke Rawat Jalan"))): "Sudah Terdaftar") 

                                if ($data->tglrenkontrol <= date("Y-m-d H:i:s")) {
                                    return 'Sudah Melewati Jadwal yang Direncanakan';
                                } else {
                                    $sk = SuratketeranganR::model()->findByAttributes(array(
                                        'pendaftaran_id' => $data->pendaftaran_id,
                                        'jenissurat_id' => Params::SURAT_KETERANGAN_KONTROL,
                                    ));

                                    if (!empty($sk)) {

                                        $buatjanjipoli = BuatjanjipoliT::model()->findByAttributes(array('suratketerangan_id' => $sk->suratketerangan_id));

                                        if (!empty($buatjanjipoli)) {
                                            return 'Pasien Sudah Didaftarkan';
                                        } else {
                                            return CHtml::link(
                                                '<i class="icon-form-rj"></i> ',
                                                Yii::app()->createUrl('/pendaftaranPenjadwalan/PendaftaranRawatJalan/index', array(
                                                    'pasien_id' => $data->pasien_id,
                                                    'sk_id' => $sk->suratketerangan_id,
                                                )),
                                                array(
                                                    "id" => "$data->pasien_id",
                                                    "title" => "Klik untuk Mendaftarkan ke Rawat Jalan", "rel" => "tooltip"
                                                )
                                            );
                                        }
                                    } else {
                                        return '';
                                    }
                                }
                            },
                        ),
                        /*   array(
                            'header'=>'Daftar Rawat <br> Darurat',
                            'type'=>'raw',
                            'value'=>'CHtml::link("<i class=\'icon-form-rd\'></i> ", 
                                "index.php?r=pendaftaranPenjadwalan/PendaftaranRawatDarurat/index&pasien_id=$data->pasien_id",array("id"=>"$data->pasien_id",
                                    "title"=>"Klik untuk Mendaftarkan ke Rawat Darurat","rel"=>"tooltip"))',
                            'htmlOptions'=>array('style'=>'text-align:left;'),
                        ),*/
                    ),
                    'afterAjaxUpdate' => 'function(id, data){
                            jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});
                    }',
                )); ?>
                <?php
                    $urlPrintKarcisStruk = Yii::app()->createUrl('pendaftaranPenjadwalan/pendaftaranRawatJalan/printKarcis', array('pendaftaran_id' => ''));
                ?>
                <script type="text/javascript">
                    function printStruk(pendaftaran_id)
                    {
                        window.open('<?php echo $urlPrintKarcisStruk; ?>'+pendaftaran_id,'printwin','left=100,top=100,width=400,height=700');    
                    }
                </script>
            </div>
        </div>
    </div>
</div>