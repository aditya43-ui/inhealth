<?php 
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'umum_pencarianpasien_grid',
    'dataProvider' => $model->searchPasienBerdasarkanUmum(),
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-responsive table-bordered table-striped table-condensed',
    'columns' => array(
        array(
            'header' => 'Tanggal Bukti Bayar <br> No. Bukti Bayar',
            'name' => 'tglbuktibayar',
            'type' => 'raw',
            'value' => '(isset($data->tandabuktibayar->tglbuktibayar) ? date("d/m/Y H:i:s",strtotime($data->tandabuktibayar->tglbuktibayar)) : "")."<br>".(isset($data->tandabuktibayar->nobuktibayar) ? $data->tandabuktibayar->nobuktibayar : "")',
        ),
        array(
            'name' => 'instalasi',
            'type' => 'raw',
            'value' => '(isset($data->pendaftaran->instalasi_id)?$data->pendaftaran->instalasi->instalasi_nama:"")',
        ),
        array(
            'header' => 'No. Pendaftaran / No. Rekam Medik',
            'value' => '(isset($data->pendaftaran_id)?$data->pendaftaran->no_pendaftaran:"")." / ".(isset($data->pasien_id)?$data->pasien->no_rekam_medik:"")',
        ),
        array(
            'name' => 'nama_pasien',
            'type' => 'raw',
            'value' => '(isset($data->pasien_id)?$data->pasien->namadepan." ".$data->pasien->nama_pasien:"")." / ".$data->nama_bin',
        ),
        array(
            'name' => 'alamat_pasien',
            'type' => 'raw',
            'value' => '(isset($data->pasien_id)?$data->pasien->alamat_pasien:"")',
        ),
        array(
            'header' => 'Jenis Penjamin / Penjamin',
            'name' => 'carabayar_nama',
            'type' => 'raw',
            'value' => '(isset($data->carabayar_id)?$data->carabayar->carabayar_nama:"")."<br>".(isset($data->penjamin_id)?$data->penjamin->penjamin_nama:"")',
        ),
        array(
            'header' => 'Total Tagihan (Rp)',
            'name' => 'total_tagihan',
            'type' => 'raw',
            'value' => 'number_format($data->totalbiayapelayanan,0,"",".")',
            'htmlOptions' => array('style' => 'text-align: right;'),
        ),
        array(
            'header' => 'Tanggungan Asuransi (Rp)',
            'name' => 'subsidi_asuransi',
            'type' => 'raw',
            'value' => 'number_format($data->totalsubsidiasuransi,0,"",".")',
            'htmlOptions' => array('style' => 'text-align: right;'),
        ),
        array(
            'header' => 'Tanggungan Pemerintah (Rp)',
            'name' => 'subsidi_pemerintah',
            'type' => 'raw',
            'value' => 'MyFormatter::formatNumberForPrint($data->totalsubsidipemerintah)',
            'htmlOptions' => array('style' => 'text-align: right;'),
        ),
        array(
            'header' => 'Tanggungan Rumah Sakit (Rp)',
            'name' => 'subsidi_rs',
            'type' => 'raw',
            'value' => 'number_format($data->totalsubsidirs,0,"",".")',
            'htmlOptions' => array('style' => 'text-align: right;'),
        ),
        array(
            'header' => 'Biaya (Rp)',
            'name' => 'iur_biaya',
            'type' => 'raw',
            'value' => 'number_format($data->totaliurbiaya,0,"",".")',
            'htmlOptions' => array('style' => 'text-align: right;'),
        ),
        array(
            'header' => 'Keringanan (Rp)',
            'name' => 'discount',
            'type' => 'raw',
            'value' => 'number_format($data->totaldiscount,0,"",".")',
            'htmlOptions' => array('style' => 'text-align: right;'),
        ),
        array(
            'header' => 'Pembebasan (Rp)',
            'type' => 'raw',
            'value' => 'number_format($data->totalpembebasan,0,"",".")',
            'htmlOptions' => array('style' => 'text-align: right;'),
        ),
        array(
            'header' => 'Jumlah Pembayaran (Rp)',
            'type' => 'raw',
            'value' => 'number_format($data->totalbayartindakan,0,"",".")',
            'htmlOptions' => array('style' => 'text-align: right;'),
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
?>