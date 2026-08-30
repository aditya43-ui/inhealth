<?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'daftarriwayat-v-grid',
    'dataProvider' => $modRiwayat->searchRiwayat(),
    'template' => "{summary}\n{items}\n{pager}",
    "replaceUrl" => true,
    'itemsCssClass' => 'table table-striped table-condensed',
    'columns' => [
        [
            'header' => 'No',
            'value' => '$row+1',
        ],
        [
            'header' => 'Tanggal Skrining Gizi Awal',
            'value' => function ($data) {
                return MyFormatter::formatDateTimeForUser($data->create_time);
            }
        ],
        [
            'header' => 'Tgl Pendaftaran/Tgl Admisi',
            'value' => function ($data) {
                return MyFormatter::formatDateTimeForUser($data->pendaftaran->tgl_pendaftaran);
            }
        ],
        [
            'header' => 'No Pendaftaran',
            'value' => function ($data) {
                return $data->pendaftaran->no_pendaftaran;
            }
        ],
        [
            'header' => 'Ruangan',
            'value' => function ($data) {
                return RuanganM::model()->findByPk($data->create_ruangan)->ruangan_nama;
            }
        ],
        [
            'header' => 'Nama PPA',
            'value' => function ($data) {
                return $data->pegawai->namaLengkap;
            }
        ],
        [
            'header' => 'Total Skor',
            'value' => function ($data) {
                return $data->total_skor;
            }
        ],
        [
            'header' => 'Detail',
            'type' => 'raw',
            'value' => function ($data) {
                return  "<center>" . CHtml::link("<i class='fa fa-eye'></i>", '#', array('onclick' => 'viewDetail(' . $data->skrininggizi_id . ');return false;', 'class' => '')) . "</center>";
            }
        ],
        [
            'header' => 'Ubah',
            'type' => 'raw',
            'value' => function ($data) {
                return "<center>" . CHtml::link("<i class='icon-eye-open'></i>", $this->createUrl('skriningGizi', array('pendaftaran_id' => $data->pendaftaran_id, 'ruangan' => $data->create_ruangan)), array('rel' => 'tooltip', 'title' => 'Klik ubah pemeriksaan')) . "</center>"; 
            }
        ],
        [
            'header' => 'Hapus',
            'type' => 'raw',
            'value' => function ($data) {
                return "<center>" . CHtml::link("<i class='icon-trash'></i>",'#', array('rel' => 'tooltip', 'title' => 'Klik untuk menghapus Reseptur', 'onclick' => 'hapusresep('.$data->skrininggizi_id.','.$data->pendaftaran_id.',this)' )) . "</center>";  
            }
        ],
        [
            'header' => 'Salin',
            'type' => 'raw',
            'value' => function ($data) {
                return "<center>" . CHtml::link("<i class='fa fa-copy'></i>", $this->createUrl('skriningGizi', array('pendaftaran_id' => $data->pendaftaran_id, 'ruangan' => $data->create_ruangan, 'salin' => true)), array('rel' => 'tooltip', 'title' => 'Klik ubah pemeriksaan')) . "</center>"; 
            }
        ],
        
    ],
    'afterAjaxUpdate' => 'function(id, data){
jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
)); ?>