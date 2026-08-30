<?php

Yii::import('sistemAdministrator.models.*');
class ModuleDashboardNeonDuaController extends MyAuthController
{
  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - Dashboard Pendaftaran dan Penjadwalan";
    $namaHari   = array("Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu", "Minggu");
    $namaBulan = array("", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
    $tanggal_skg = $namaHari[date('N')] . ", " . date('d') . " " . $namaBulan[date('n')] . " " . date('Y');
    $bulan_skg = $namaBulan[date('N')];

    $criteria_kunjungan = new CDbCriteria();
    $kunjungan_today = $criteria_kunjungan->compare('DATE(tgl_pendaftaran)', date("Y-m-d"));
    $modKunjunganToday = PPPendaftaranT::model()->count($kunjungan_today);

    $criteria_pasienbaru = new CDbCriteria();
    $criteria_pasienbaru->compare('DATE(tgl_pendaftaran)', date("Y-m-d"));
    $criteria_pasienbaru->compare('LOWER(statuspasien)', strtolower(Params::STATUSPASIEN_BARU));
    $modPasienBaru = PPPendaftaranT::model()->count($criteria_pasienbaru);

    $criteria_pasienlama = new CDbCriteria();
    $criteria_pasienlama->compare('DATE(tgl_pendaftaran)', date("Y-m-d"));
    $criteria_pasienlama->compare('LOWER(statuspasien)', strtolower(Params::STATUSPASIEN_LAMA));
    $modPasienLama = PPPendaftaranT::model()->count($criteria_pasienlama);

    $criteria_janjipoli = new CDbCriteria();
    $criteria_janjipoli->compare('DATE(tglbuatjanji)', date("Y-m-d"));
    $modJanjipoli = BuatjanjipoliT::model()->count($criteria_janjipoli);

    $criteria_chart = new CDbCriteria();
    $criteria_chart->select = array("date_part('year',tgl_pendaftaran) as tahun", "date_part('month',tgl_pendaftaran) as bulan", "count(pendaftaran_id) as jumlah");
    $criteria_chart->group = "date_part('year',tgl_pendaftaran), date_part('month',tgl_pendaftaran)";
    $criteria_chart->compare("date_part('year',tgl_pendaftaran)", date('Y'));
    $criteria_chart->addCondition("pasienbatalperiksa_id is null");
    $criteria_chart->order = 'tahun, bulan ASC';
    $modChart = PPPendaftaranT::model()->findAll($criteria_chart);

    $criteria_updatepasien = new CDbCriteria();
    $criteria_updatepasien->limit = 10;
    $criteria_updatepasien->order = 'tgl_pendaftaran DESC';
    $modUpdatePasien = PPPendaftaranT::model()->findAll($criteria_updatepasien);

    $criteria_map = new CDbCriteria();
    $criteria_map->join = "JOIN pasien_m ON pasien_m.pasien_id = t.pasien_id JOIN kecamatan_m ON pasien_m.kecamatan_id = kecamatan_m.kecamatan_id";
    $criteria_map->select = array("kecamatan_m.kecamatan_id","kecamatan_m.kecamatan_nama","kecamatan_m.longitude","kecamatan_m.latitude","count(t.pendaftaran_id) as jumlahpasien");
    $criteria_map->group = 'kecamatan_m.kecamatan_id,kecamatan_m.kecamatan_nama,kecamatan_m.longitude, kecamatan_m.latitude';
    $criteria_map->compare("date_part('year',t.tgl_pendaftaran)",date('Y'));
    $modMap = PPPendaftaranT::model()->findAll($criteria_map);

    $this->render('index', array(
      'tanggal_skg' => $tanggal_skg,
      'bulan_skg' => $bulan_skg,
      'modKunjunganToday' => $modKunjunganToday,
      'modPasienBaru' => $modPasienBaru,
      'modPasienLama' => $modPasienLama,
      'modChart' => $modChart,
      'modUpdatePasien' => $modUpdatePasien,
      'modMap' => $modMap,
      'modJanjipoli'=>$modJanjipoli
    ));
  }
}
