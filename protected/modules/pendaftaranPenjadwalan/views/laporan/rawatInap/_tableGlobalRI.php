<?php
$table = 'ext.bootstrap.widgets.BootGridView';
if (isset($caraPrint)) {
    $data = $model->searchPrint();
    $template = '{items}';
    if ($caraPrint == 'EXCEL') {
        $table = 'ext.bootstrap.widgets.BootExcelGridView';
    }
} else {
    $data = $model->searchTable();
    $template = "{summary}{items}{pager}";
}
?>
<?php if (isset($caraPrint)) { ?>

<?php } else { ?>
<?php } ?>
<?php $this->widget($table, array(
    'id' => 'PPInfoKunjungan-v',
    'dataProvider' => $data,
    'template' => $template,
    'itemsCssClass' => 'table table-bordered datatable',
    'columns' => array(
        array(
            'header' => 'Tgl. Admisi',
            'type' => 'raw',
            'value' => function ($data) {
                if(!empty($data->tgladmisi)) {
                    echo MyFormatter::formatDateTimeForUser(date('Y-m-d', strtotime($data->tgladmisi)));
                }
            },
        ),
        array(
            'header' => 'Jam Admisi',
            'type' => 'raw',
            'value' => function ($data) {
                if(!empty($data->tgladmisi)) {
                    echo date('H:i:s', strtotime($data->tgladmisi));
                }
            },
        ),
        array(
            'header' => 'No. Rekam Medik',
            'type' => 'raw',
            'value' => '$data->no_rekam_medik',
        ),
        array(
            'header' => 'Nama Pasien',
            'type' => 'raw',
            'value' => '$data->nama_pasien',
        ),
        array(
            'header' => 'Jenis Kelamin',
            'type' => 'raw',
            'value' => '$data->jeniskelamin',
        ),
        array(
            'header' => 'Alamat',
            'type' => 'raw',
            'value' => '$data->alamat_pasien',
        ),
        'kelurahan_nama',
        'kecamatan_nama',
        'kabupaten_nama',
        [
            'header' => 'Provinsi',
            'name' => 'propinsi_nama'
        ],
        [
            'header' => 'No. Handphone',
            'type' => 'raw',
            'value' => function ($data) {
                echo "'" . $data->no_mobile_pasien;
            }
        ],
        'suku_nama',
        'statusperkawinan',

        'warga_negara',
        'agama',
        'pendidikan_nama',
        'pekerjaan_nama',
        [
            'header' => 'NIK',
            'type' => 'raw',
            'value' => function ($data) {
                echo "'" . $data->no_identitas_pasien;
            }
        ],
        'tanggal_lahir',
        'umur_tahun',
        'umur_bulan',
        'umur_hari',
        'golonganumur_nama',
        // 'kelompokumur_nama',
        'nama_ayah',
        'nama_ibu',
        'sistem',
        'kunjungan',
        'no_pendaftaran',
        'nama_pegawailoket',
        'carabayar_nama',
        'penjamin_nama',
        'ruangan_nama',
        'kelaspelayanan_nama',
        'kelastanggungan_nama',
        'caramasuk_nama',
        'icd_masuk',
        'diagnosa_masuk',
        'keluhan',
        'riwayatimunisasi',
        'tekanandarah',
        'golongandarah',
        'tinggibadan_cm',
        'beratbadan_kg',
        'nama_pegawaiverif',
        'icd_utama',
        'diagnosa_utama',
        'dtd_nama',
        // 'icd_komplikasi',
        'icd_komplikasi1',
        'icd_komplikasi2',
        'icd_komplikasi3',
        'icd_komplikasi4',
        'icd_komplikasi5',

        'icd_tindakan1',
        'icd_tindakan2',
        'icd_tindakan3',
        'icd_tindakan4',
        'icd_tindakan5',

        // 'icd_tindakanutama',
        // 'tindakanutama',
        // 'icd_tindakanlain',
        'tindakanlain',
        'kodedokter',
        'nama_pegawai',
        'spesialissubspesialis_nama',
        'kasus',
        'icd_utama_dpjp',
        'diagnosa_utama_dpjp',
        'dtd_dpjp_nama',

        // 'icd_komplikasi_dpjp',
        'icd_dpjp_komplikasi1',
        'icd_dpjp_komplikasi2',
        'icd_dpjp_komplikasi3',
        'icd_dpjp_komplikasi4',
        'icd_dpjp_komplikasi5',

        'icd_dpjp_tindakan1',
        'icd_dpjp_tindakan2',
        'icd_dpjp_tindakan3',
        'icd_dpjp_tindakan4',
        'icd_dpjp_tindakan5',
        
        'petugasrawatinap',
        'kodespesialis',
        'lamarawat',
        'carakeluar_nama',

        array(
            'header' => 'Tgl. Pulang',
            'type' => 'raw',
            'value' => function ($data) {
                if(!empty($data->tglpulang)) {
                    echo MyFormatter::formatDateTimeForUser(date('Y-m-d', strtotime($data->tglpulang)));
                }
            },
        ),
        array(
            'header' => 'Jam Pulang',
            'type' => 'raw',
            'value' => function ($data) {
                if(!empty($data->tglpulang)) {
                    echo date('H:i:s', strtotime($data->tglpulang));
                }
            },
        ),

        'asalrujukan_nama',
        'tanggal_rujukan',
        'no_rujukan',
        'alamatrujukan',
        'tgldiet',
        'tgloperasi1',
        'jenisoperasi1',
        'tgloperasi2',
        'jenisoperasi2',
        'tgloperasi3',
        'jenisoperasi3',
        'tgloperasi4',
        'jenisoperasi4',
        'tgloperasi5',
        'jenisoperasi5',
        'tirahbaring',
        'pulangmati',
        array(
            'header' => 'Tgl. Kematian',
            'type' => 'raw',
            'value' => function ($data) {
                if(!empty($data->tglmati)) {
                    echo MyFormatter::formatDateTimeForUser(date('Y-m-d', strtotime($data->tglmati)));
                }
            },
        ),
        array(
            'header' => 'Jam Kematian',
            'type' => 'raw',
            'value' => function ($data) {
                if(!empty($data->tglmati)) {
                    echo date('H:i:s', strtotime($data->tglmati));
                }
            },
        ),

        'icdmati',
        'sebabmati',

        array(
            'header' => 'Tgl. Setor DRM',
            'type' => 'raw',
            'value' => '$data->create_time'
        ),
        'ktp',
        'kodeicd',
        'kepalalist',
        'dischargesum',
        'formoperasi',
        'formanastesi',
        'formcairan',
        'formtransfusi',
        'formkematian',
        'formaskep',
        'generalconsent',
        'kelengkapanautopsi',
        'formic',
        'diagnosatindakan',
        'namadokteroperasi',
        'tandatangandokter',
        'namapasien',
        'tandatanganpasien',
        'namasaksi1',
        'tandatangansaksi1',
        'namasaksi2',
        'tandatangansaksi2',
        'tgllengkap',
        'tglverifikasikelengkapan',
        'ketsebabkematian',
        'f1_a',
        'f2_a',
        'f2_b',
        'f3_a',
        'f3_b',
        'f5_a_operasi',
        'f5_b_operasi',
        'f5_c_operasi',
        'f5_d_operasi',
        'f5_e_operasi',
        'f5_f_operasi',
        'f5_g_operasi',
        'f5_h_operasi',
        'f5_a_anastesi',
        'f5_b_anastesi',
        'f5_c_anastesi',
        'f5_a_kemoterapi',
        'f5_b_kemoterapi',
        'f5_a_transfusi',
        'f5_b_transfusi',
        'f5_c_transfusi',
        'f6_a_cppt',
        'f6_b_cppt',
        'f6_c_cppt',
        'f6_d_cppt',
        'f8_a_ringkasan',
        'f8_b_ringkasan',
        'f8_c_ringkasan',
        'f8_a_kematian',
        'f8_b_kematian',
        'casemix_a',
        'casemix_b',
        'f5_i_operasi',
        'f5_c_kemoterapi',
        'f8_d_ringkasan',
        'f8_e_ringkasan',
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
)); ?>