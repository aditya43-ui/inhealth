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
        'header' => 'NO MR',
        'type' => 'raw',
        'value' => '$data->no_rekam_medik',
      ),
      array(
        'header' => 'Tgl Datang',
        'type' => 'raw',
        'value' => '$data->tgl_pendaftaran',
      ),
      array(
        'header' => 'NAMA',
        'type' => 'raw',
        'value' => '$data->nama_pasien',
      ),
      array(
        'header' => 'ALAMAT ',
        'type' => 'raw',
        'value' => '$data->alamat_pasien',
      ),
      array(
        'header' => 'RUANG',
        'type' => 'raw',
        'value' => '$data->ruangan_nama',
      ),
      array(
        'header' => 'NO TELP',
        'type' => 'raw',
        'value' => '$data->no_mobile_pasien',
      ),
      array(
        'header' => 'KELURAHAN',
        'type' => 'raw',
        'value' => '$data->kelurahan_nama',
      ),
      array(
        'header' => 'KECAMATAN',
        'type' => 'raw',
        'value' => '$data->kecamatan_nama',
      ),
      array(
        'header' => 'KAB/KOTA',
        'type' => 'raw',
        'value' => '$data->kabupaten_nama',
      ),
      array(
        'header' => 'PROPINSI',
        'type' => 'raw',
        'value' => '$data->propinsi_nama',
      ),
      array(
        'header' => 'KELAMIN',
        'type' => 'raw',
        'value' => '$data->jeniskelamin',
      ),
      array(
        'header' => 'SUKU',
        'type' => 'raw',
        'value' => '$data->suku_nama',
      ),
      array(
        'header' => 'STATUS',
        'type' => 'raw',
        'value' => '$data->statusperiksa',
      ),
      array(
        'header' => 'BANGSA',
        'type' => 'raw',
        'value' => '$data->warga_negara',
      ),
      array(
        'header' => 'AGAMA',
        'type' => 'raw',
        'value' => '$data->agama',
      ),
      array(
        'header' => 'PENDIDIKAN',
        'type' => 'raw',
        'value' => '$data->pendidikan_nama',
      ),
      array(
        'header' => 'PEKERJAAN',
        'type' => 'raw',
        'value' => '$data->pekerjaan_nama',
      ),
      array(
        'header' => 'TGLLAHIR',
        'type' => 'raw',
        'value' => 'MyFormatter::formatDateTimeForUser($data->tanggal_lahir)',
      ),
      array(
        'header' => 'NIK',
        'type' => 'raw',
        'value' => '$data->no_identitas_pasien',
      ),
      array(
        'header' => 'SISTEM NOBILLING',
        'type' => 'raw',
        'value' => '$data->no_pendaftaran',
      ),
      array(
        'header' => 'TGL MASUK',
        'type' => 'raw',
        'value' => function($data){
          echo MyFormatter::formatDateTimeForUser(date('Y-m-d', strtotime($data->tgl_pendaftaran)));
        },
      ),
      array(
        'header' => 'JAM MASUK',
        'type' => 'raw',
        'value' => function ($data) {
          echo date('H:i:s', strtotime($data->tgl_pendaftaran));
        },
      ),
      array(
        'header' => 'DIAG MASUK',
        'type' => 'raw',
        'value' => '$data->diagnosamasuk',
      ),
      array(
        'header' => 'KELUHAN',
        'type' => 'raw',
        'value' => '$data->keluhan',
      ),
      array(
        'header' => 'TEKANAN DARAH',
        'type' => 'raw',
        'value' => '$data->tekanandarah',
      ),
      array(
        'header' => 'GOLONGAN DARAH',
        'type' => 'raw',
        'value' => '$data->golongandarah',
      ),
      array(
        'header' => 'TINGGI',
        'type' => 'raw',
        'value' => '$data->tinggibadan_cm',
      ),
      array(
        'header' => 'BERAT',
        'type' => 'raw',
        'value' => '$data->beratbadan_kg',
      ),
      array(
        'header' => 'CARAMASUK',
        'type' => 'raw',
        'value' => '$data->caramasuk_nama',
      ),
      array(
        'header' => 'PENJAMIN',
        'type' => 'raw',
        'value' => '$data->penjamin_nama',
      ),
      array(
        'header' => 'TGL PULANG',
        'type' => 'raw',
        'value' => function ($data) {
          echo MyFormatter::formatDateTimeForUser(date('Y-m-d', strtotime($data->tglselesaiperiksa)));
        },
      ),
      array(
        'header' => 'JAM PULANG',
        'type' => 'raw',
        'value' => function ($data) {
          echo date('H:i:s', strtotime($data->tglselesaiperiksa));
        },
      ),
      array(
        'header' => 'UMUR TAHUN UMUR BULAN UMUR HARI',
        'type' => 'raw',
        'value' => '$data->umur',
      ),
      array(
        'header' => 'KODEDOKTER',
        'type' => 'raw',
        'value' => '$data->kodedokter_bpjs',
      ),
      array(
        'header' => 'NAMADOKTER',
        'type' => 'raw',
        'value' => '$data->nama_pegawai',
      ),
      array(
        'header' => 'ICD UTAMA-DPJP',
        'type' => 'raw',
        'value' => '$data->diagnosa',
      ),
      array(
        'header' => 'JENIS PENYAKIT-DPJP',
        'type' => 'raw',
        'value' => '$data->jeniskasuspenyakit_nama',
      ),
      array(
        'header' => 'NAMA AYAH',
        'type' => 'raw',
        'value' => '$data->nama_ayah',
      ),
      array(
        'header' => 'NAMA IBU',
        'type' => 'raw',
        'value' => '$data->nama_ibu',
      ),
      array(
        'header' => 'Asal Rujukan',
        'type' => 'raw',
        'value' => '$data->asalrujukan',
      ),
      array(
        'header' => 'Alamat Rujukan',
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