<div style=''>
  <?php
  $table = 'ext.bootstrap.widgets.BootGridView';
  if (isset($caraPrint)) {
    $data = $model->searchPrintRJ();
    $template = '{items}';
    if ($caraPrint == 'EXCEL') {
      $table = 'ext.bootstrap.widgets.BootExcelGridView';
    }
  } else {
    $data = $model->searchTableLaporan();
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
        'header' => 'No. Rekam Medik',
        'type' => 'raw',
        'value' => '$data->no_rekam_medik',
      ),
      array(
        'header' => 'Tgl. Pendaftaran',
        'type' => 'raw',
        'value' => 'date("Y-m-d", strtotime($data->tgl_pendaftaran))',
      ),
      array(
        'header' => 'Jam Pendaftaran',
        'type' => 'raw',
        'value' => 'date("H:i:s", strtotime($data->tgl_pendaftaran))',
      ),
      array(
        'header' => 'No. Pendaftaran',
        'type' => 'raw',
        'value' => '$data->no_pendaftaran',
      ),
      array(
        'header' => 'Kunjungan',
        'type' => 'raw',
        'value' => '$data->kunjungan',
      ),
      array(
        'header' => 'Nama Pasien',
        'type' => 'raw',
        'value' => '$data->nama_pasien',
      ),
      array(
        'header' => 'Alamat ',
        'type' => 'raw',
        'value' => '$data->alamat_pasien',
      ),
      array(
        'header' => 'Poliklinik',
        'type' => 'raw',
        'value' => '$data->ruangan_nama',
      ),
      array(
        'header' => 'No. Telepon',
        'type' => 'raw',
        'value' => function ($data) {
          echo "'" . $data->no_mobile_pasien;
        },
      ),
      array(
        'header' => 'Kelurahan',
        'type' => 'raw',
        'value' => '$data->kelurahan_nama',
      ),
      array(
        'header' => 'Kecamatan',
        'type' => 'raw',
        'value' => '$data->kecamatan_nama',
      ),
      array(
        'header' => 'Kota/Kabupaten',
        'type' => 'raw',
        'value' => '$data->kabupaten_nama',
      ),
      array(
        'header' => 'Provinsi',
        'type' => 'raw',
        'value' => '$data->propinsi_nama',
      ),
      array(
        'header' => 'Jenis Kelamin',
        'type' => 'raw',
        'value' => '$data->jeniskelamin',
      ),
      array(
        'header' => 'Suku',
        'type' => 'raw',
        'value' => '$data->suku_nama',
      ),
      array(
        'header' => 'Warga Negara',
        'type' => 'raw',
        'value' => '$data->warga_negara',
      ),
      array(
        'header' => 'Agama',
        'type' => 'raw',
        'value' => '$data->agama',
      ),
      array(
        'header' => 'Pendidikan',
        'type' => 'raw',
        'value' => '$data->pendidikan_nama',
      ),
      array(
        'header' => 'Pekerjaan',
        'type' => 'raw',
        'value' => '$data->pekerjaan_nama',
      ),
      array(
        'header' => 'Status Perkawinan',
        'type' => 'raw',
        'value' => '$data->statusperkawinan',
      ),
      array(
        'header' => 'Tgl. Lahir',
        'type' => 'raw',
        'value' => 'MyFormatter::formatDateTimeForUser($data->tanggal_lahir)',
      ),
      array(
        'header' => 'Umur Tahun',
        'type' => 'raw',
        'value' => '$data->umur_tahun',
      ),
      array(
        'header' => 'Umur Bulan',
        'type' => 'raw',
        'value' => '$data->umur_bulan',
      ),
      array(
        'header' => 'Umur Hari',
        'type' => 'raw',
        'value' => '$data->umur_hari',
      ),
      array(
        'header' => 'NIK',
        'type' => 'raw',
        'value' => '$data->no_identitas_pasien',
      ),
      array(
        'header' => 'Status Periksa',
        'type' => 'raw',
        'value' => '$data->statusperiksa',
      ),
      array(
        'header' => 'Sistem',
        'type' => 'raw',
        'value' => '$data->sistem',
      ),
      
      array(
        'header' => 'Tgl. Masuk',
        'type' => 'raw',
        'value' => function($data){
          echo MyFormatter::formatDateTimeForUser(date('Y-m-d', strtotime($data->tgl_pendaftaran)));
        },
      ),
      array(
        'header' => 'Jam Masuk',
        'type' => 'raw',
        'value' => function ($data) {
          echo date('H:i:s', strtotime($data->tgl_pendaftaran));
        },
      ),
      array(
        'header' => 'Kategori Asal Pasien',
        'type' => 'raw',
        'value' => '$data->kategoriasalpasien',
      ),
      array(
        'header' => 'Cara Masuk',
        'type' => 'raw',
        'value' => '$data->statusmasuk',
      ),
      array(
        'header' => 'Diagnosa Masuk',
        'type' => 'raw',
        'value' => '$data->diagnosamasuk',
      ),
      array(
        'header' => 'Keluhan',
        'type' => 'raw',
        'value' => '$data->keluhan',
      ),
      array(
        'header' => 'Tekanan Darah',
        'type' => 'raw',
        'value' => '$data->tekanandarah',
      ),
      array(
        'header' => 'Golongan Darah',
        'type' => 'raw',
        'value' => '$data->golongandarah',
      ),
      array(
        'header' => 'Tinggi Badan',
        'type' => 'raw',
        'value' => '$data->tinggibadan_cm',
      ),
      array(
        'header' => 'Berat Badan',
        'type' => 'raw',
        'value' => '$data->beratbadan_kg',
      ),
      array(
        'header' => 'Riwayat Imunisasi',
        'type' => 'raw',
        'value' => '$data->riwayatimunisasi',
      ),
      array(
        'header' => 'Jenis Penjamin',
        'type' => 'raw',
        'value' => '$data->carabayar_nama',
      ),
      array(
        'header' => 'Penjamin',
        'type' => 'raw',
        'value' => '$data->penjamin_nama',
      ),
      array(
        'header' => 'Cara Pulang',
        'type' => 'raw',
        'value' => '$data->carakeluar_nama',
      ),
      array(
        'header' => 'Kondisi Keluar',
        'type' => 'raw',
        'value' => '$data->kondisikeluar_nama',
      ),
      array(
        'header' => 'Tgl. Pulang',
        'type' => 'raw',
        'value' => function ($data) {
          echo MyFormatter::formatDateTimeForUser(date('Y-m-d', strtotime($data->tglselesaiperiksa)));
        },
      ),
      array(
        'header' => 'Jam Pulang',
        'type' => 'raw',
        'value' => function ($data) {
          echo date('H:i:s', strtotime($data->tglselesaiperiksa));
        },
      ),
      array(
        'header' => 'Petugas Loket',
        'type' => 'raw',
        'value' => '$data->nama_pegawailoket',
      ),
      array(
        'header' => 'Petugas Verifikasi',
        'type' => 'raw',
        'value' => '$data->nama_pegawaiverif',
      ),
      array(
        'header' => 'ICD 10 Utama',
        'type' => 'raw',
        'value' => '$data->icd_utama',
      ),
      array(
        'header' => 'Diagnosa 10 Utama',
        'type' => 'raw',
        'value' => '$data->diagnosa_utama',
      ),
      array(
        'header' => 'DTD ICD 10 Utama',
        'type' => 'raw',
        'value' => '$data->dtd_nama',
      ),
      array(
        'header' => 'ICD Komplikasi 1',
        'type' => 'raw',
        'value' => '$data->icd_komplikasi1',
      ),
      array(
        'header' => 'ICD Komplikasi 2',
        'type' => 'raw',
        'value' => '$data->icd_komplikasi2',
      ),
      array(
        'header' => 'ICD Komplikasi 3',
        'type' => 'raw',
        'value' => '$data->icd_komplikasi3',
      ),
      array(
        'header' => 'ICD Komplikasi 4',
        'type' => 'raw',
        'value' => '$data->icd_komplikasi4',
      ),
      array(
        'header' => 'ICD Komplikasi 5',
        'type' => 'raw',
        'value' => '$data->icd_komplikasi5',
      ),
      array(
        'header' => 'ICD Tindakan 1',
        'type' => 'raw',
        'value' => '$data->icd_tindakan1',
      ),
      array(
        'header' => 'ICD Tindakan 2',
        'type' => 'raw',
        'value' => '$data->icd_tindakan2',
      ),
      array(
        'header' => 'ICD Tindakan 3',
        'type' => 'raw',
        'value' => '$data->icd_tindakan3',
      ),
      array(
        'header' => 'ICD Tindakan 4',
        'type' => 'raw',
        'value' => '$data->icd_tindakan4',
      ),
      array(
        'header' => 'ICD Tindakan 5',
        'type' => 'raw',
        'value' => '$data->icd_tindakan5',
      ),

      array(
        'header' => 'Kode DPJP',
        'type' => 'raw',
        'value' => '$data->kodedokter_bpjs',
      ),
      array(
        'header' => 'Nama DPJP',
        'type' => 'raw',
        'value' => '$data->nama_pegawai',
      ),
      array(
        'header' => 'ICD 10 Utama - DPJP',
        'type' => 'raw',
        'value' => '$data->icd_utama_dpjp',
      ),  
      array(
        'header' => 'Diagnosa 10 Utama - DPJP',
        'type' => 'raw',
        'value' => '$data->diagnosa_utama_dpjp',
      ),

      array(
        'header' => 'DTD ICD 10 Utama - DPJP',
        'type' => 'raw',
        'value' => '$data->dtd_dpjp_nama',
      ),
      array(
        'header' => 'Kasus ICD 10 Utama - DPJP',
        'type' => 'raw',
        'value' => '$data->kasusdiagnosa',
      ),
      array(
        'header' => 'ICD Komplikasi 1 - DPJP',
        'type' => 'raw',
        'value' => '$data->icd_dpjp_komplikasi1',
      ),

      array(
        'header' => 'ICD Komplikasi 2 - DPJP',
        'type' => 'raw',
        'value' => '$data->icd_dpjp_komplikasi2',
      ),

      array(
        'header' => 'ICD Komplikasi 3 - DPJP',
        'type' => 'raw',
        'value' => '$data->icd_dpjp_komplikasi3',
      ),

      array(
        'header' => 'ICD Komplikasi 4 - DPJP',
        'type' => 'raw',
        'value' => '$data->icd_dpjp_komplikasi4',
      ),

      array(
        'header' => 'ICD Komplikasi 5 - DPJP',
        'type' => 'raw',
        'value' => '$data->icd_dpjp_komplikasi5',
      ),
      array(
        'header' => 'ICD Tindakan 1 - DPJP',
        'type' => 'raw',
        'value' => '$data->icd_dpjp_tindakan1',
      ),
      array(
        'header' => 'ICD Tindakan 2 - DPJP',
        'type' => 'raw',
        'value' => '$data->icd_dpjp_tindakan2',
      ),
      array(
        'header' => 'ICD Tindakan 3 - DPJP',
        'type' => 'raw',
        'value' => '$data->icd_dpjp_tindakan3',
      ),
      array(
        'header' => 'ICD Tindakan 4 - DPJP',
        'type' => 'raw',
        'value' => '$data->icd_dpjp_tindakan4',
      ),
      array(
        'header' => 'ICD Tindakan 5 - DPJP',
        'type' => 'raw',
        'value' => '$data->icd_dpjp_tindakan5',
      ),
      array(
        'header' => 'Nama Ayah',
        'type' => 'raw',
        'value' => '$data->nama_ayah',
      ),
      array(
        'header' => 'Nama Ibu',
        'type' => 'raw',
        'value' => '$data->nama_ibu',
      ),
      array(
        'header' => 'Asal Rujukan',
        'type' => 'raw',
        'value' => '$data->asalrujukan',
      ),
      array(
        'header' => 'Alamat Rujuk',
        'type' => 'raw',
        'value' => '$data->alamatrujukan',
      ),
      array(
        'header' => 'Tgl Rujukan',
        'type' => 'raw',
        'value' => '$data->tanggal_rujukan',
      ),
      array(
        'header' => 'No Rujukan',
        'type' => 'raw',
        'value' => '$data->no_rujukan',
      ),
      
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
  )); ?>
</div>