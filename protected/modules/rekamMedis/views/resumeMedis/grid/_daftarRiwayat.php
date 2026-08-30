<?php
$modRiwayat = new ResumemedisR('searchDialog');
$modRiwayat->default = 'kosong';
if (isset($_GET['ResumemedisR'])) {
    $modRiwayat->attributes = $_GET['ResumemedisR'];
    $modRiwayat->default = isset($_GET['ResumemedisR']['default']) ? $_GET['ResumemedisR']['default'] : null;  
}

//dibuat karena untuk get data resume medis tidak dapat di iGET
if (isset($_GET['pendaftaran_id'])){
    $modPendafatran = PendaftaranT::model()->findByPk($_GET['pendaftaran_id']);
    $modRiwayat->pasien_id = $modPendafatran->pasien_id;
    $modRiwayat->pendaftaran_id = $modPendafatran->pendaftaran_id;
    $modRiwayat->default = isset($_GET['ResumemedisR']['default']) ? $_GET['ResumemedisR']['default'] : null;
}



$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'daftar-riwayat-grid',
    'dataProvider' => $modRiwayat->searchRiwayat(),
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        [
            'header' => '<center>Tanggal Pemeriksaan</center>',
            'value' => '!empty($data->tglresume)?MyFormatter::formatDateTimeForUser($data->tglresume):""'
        ],
        [
            'header' => '<center>Dokter</center>',
            'value' => '!empty($data->pegawai)?$data->pegawai->namaLengkap:""'
        ],
        [
            'header' => '<center>Lihat Detail</center>',
            'value' => function ($data) {
                echo CHtml::link("<i class='icon-form-lihat'></i>", 'javascript:;', ['onclick' => 'detail(' . $data->resumemedis_id . ')', 'rel' => 'tooltip', 'title' => 'detail resume medis pasien']);
            },
            'htmlOptions' => [
                'style' => 'text-align:center;'
            ]
        ],
        [
            'header' => '<center>Cetak</center>',
            'value' => function ($data) {
                echo CHtml::link("<i class='fa fa-print'></i>", 'javascript:;', ['onclick' => 'cetak(' . $data->resumemedis_id . ')', 'rel' => 'tooltip', 'title' => 'Cetak resume medis pasien']);
            },
            'htmlOptions' => [
                'style' => 'text-align:center;'
            ]
        ],
        [
            'header' => '<center>Rekam Medis</center>',
            'value' => function ($data) {
                if($data->is_verifikasirekammedis){
                    echo "<i class='icon-form-check'></i>";
                }else{
                    echo "";
                }
                
            },
            'htmlOptions' => [
                'style' => 'text-align:center;'
            ]
        ],
        [
            'header' => '<center>Hapus</center>',
            'value' => function ($data) {
                $onclick = 'hapus(' . $data->resumemedis_id . ')';
                // cek resume
                if(empty($data->pasienadmisi_id)) {
                    if ($data->pendaftaran->statusperiksa == Params::STATUSPERIKSA_SUDAH_PULANG || $data->pendaftaran->statusperiksa == Params::STATUSPERIKSA_SEDANG_DIRAWATINAP) {
                        $cekTindakLanjut = true;
                    } else {
                        $cekTindakLanjut = false;
                    }
    
                    if($cekTindakLanjut) {
                        $onclick = 'window.parent.myAlert("Resume tidak dapat dihapus karena sudah ditindak lanjut")';
                    }
                }

                if($data->create_loginpemakai_id != Yii::app()->user->getState('loginpemakai_id') || $data->create_ruangan != Yii::app()->user->getState('ruangan_id')) {
                    $onclick = 'window.parent.myAlert("Resume medis tidak bisa dihapus karena hak akses tidak sesuai")';
                }

                
                echo CHtml::link("<i class='icon-form-sampah'></i>", 'javascript:;', ['onclick' => $onclick, 'rel' => 'tooltip', 'title' => 'Hapus resume medis pasien']);
            },
            'htmlOptions' => [
                'style' => 'text-align:center;'
            ]
        ]
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
