<?php

/**
 * Digunakan untuk menampilkan data dengan template dashboard dua neon
 *
 * @category     views - dashboard
 * @author         Muhammad Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @website      <piindonesia.co.id>
 */

Yii::import("pendaftaranPenjadwalan.models.*");
class ModuleDashboardDuaController extends MyAuthController
{
  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - Dashboard Sistem Admin";
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
    $modPasienBaru = PendaftaranT::model()->count($criteria_pasienbaru);

    $criteria_pasienlama = new CDbCriteria();
    $criteria_pasienlama->compare('DATE(tgl_pendaftaran)', date("Y-m-d"));
    $criteria_pasienlama->compare('LOWER(statuspasien)', strtolower(Params::STATUSPASIEN_LAMA));
    $modPasienLama = PPPendaftaranT::model()->count($criteria_pasienlama);

    $criteria_chart = new CDbCriteria();
    $criteria_chart->select = array("date_part('year',tgl_pendaftaran) as tahun", "date_part('month',tgl_pendaftaran) as bulan", "count(pendaftaran_id) as jumlah");
    $criteria_chart->group = "date_part('year',tgl_pendaftaran), date_part('month',tgl_pendaftaran)";
    $criteria_chart->compare("date_part('year',tgl_pendaftaran)", date('Y'));
    $criteria_chart->addCondition("pasienbatalperiksa_id is null");
    $criteria_chart->order = 'tahun, bulan ASC';
    $modChart = PPPendaftaranT::model()->findAll($criteria_chart);

    $criteria_updatepasien = new CDbCriteria();
    $criteria_updatepasien->limit = 5;
    $criteria_updatepasien->order = 'tgl_pendaftaran DESC';
    $modUpdatePasien = PPPendaftaranT::model()->findAll($criteria_updatepasien);

    $criteria_map = new CDbCriteria();
    $criteria_map->join = "JOIN pasien_m ON pasien_m.pasien_id = t.pasien_id LEFT JOIN kecamatan_m ON pasien_m.kecamatan_id = kecamatan_m.kecamatan_id LEFT JOIN kabupaten_m ON pasien_m.kabupaten_id = kabupaten_m.kabupaten_id";
    $criteria_map->select = array("kabupaten_m.kabupaten_id","kabupaten_m.kabupaten_nama","kabupaten_m.longitude as longitude_kab","kabupaten_m.latitude as latitude_kab","kecamatan_m.kecamatan_id", "kecamatan_m.kecamatan_nama", "kecamatan_m.longitude", "kecamatan_m.latitude", "count(t.pendaftaran_id) as jumlahpasien");
    $criteria_map->group = 'kabupaten_m.kabupaten_id,kabupaten_m.kabupaten_nama,kecamatan_m.kecamatan_id,latitude_kab,longitude_kab,kecamatan_m.kecamatan_nama,kecamatan_m.longitude, kecamatan_m.latitude';
    $criteria_map->compare("date_part('year',t.tgl_pendaftaran)", date('Y'));
    $modMap = PPPendaftaranT::model()->findAll($criteria_map);
    
    // var_dump(print_r($modMap));die;
    $this->render('index', array(
      'tanggal_skg' => $tanggal_skg,
      'bulan_skg' => $bulan_skg,
      'modKunjunganToday' => $modKunjunganToday,
      'modPasienBaru' => $modPasienBaru,
      'modPasienLama' => $modPasienLama,
      'modChart' => $modChart,
      'modUpdatePasien' => $modUpdatePasien,
      'modMap' => $modMap
    ));
  }

    public function actionSetKabupaten() {
      if (Yii::app()->request->isAjaxRequest) {
          $data = array();
          $kabupaten = (isset($_POST['kabupaten']) ? trim($_POST['kabupaten']) : null);

          $criteria = new CDbCriteria();

          $criteria->join = "JOIN pasien_m ON pasien_m.pasien_id = t.pasien_id LEFT JOIN kecamatan_m ON pasien_m.kecamatan_id = kecamatan_m.kecamatan_id LEFT JOIN kabupaten_m ON pasien_m.kabupaten_id = kabupaten_m.kabupaten_id";
          $criteria->select = array("kabupaten_m.kabupaten_id","kabupaten_m.kabupaten_nama","kabupaten_m.longitude as longitude_kab","kabupaten_m.latitude as latitude_kab","kecamatan_m.kecamatan_id", "kecamatan_m.kecamatan_nama", "kecamatan_m.longitude", "kecamatan_m.latitude", "count(t.pendaftaran_id) as jumlahpasien");
          $criteria->group = 'kabupaten_m.kabupaten_id,kabupaten_m.kabupaten_nama,kecamatan_m.kecamatan_id,latitude_kab,longitude_kab,kecamatan_m.kecamatan_nama,kecamatan_m.longitude, kecamatan_m.latitude';
          $criteria->compare("date_part('year',t.tgl_pendaftaran)", date('Y'));
          $criteria->compare('LOWER(kabupaten_m.kabupaten_nama)', strtolower($kabupaten), true);

          $model = PPPendaftaranT::model()->findAll($criteria);

          $pas = array();
          if (count($model) > 0) {
              foreach ($model as $i => $map) {
                  if ($map['latitude'] != '' && $map['longitude'] != '') {
                      $pas[$i]['latitude'] = $map->latitude;
                      $pas[$i]['longitude'] = $map->longitude;
                      $pas[$i]['kecamatan_nama'] = $map->kecamatan_nama;
                      $pas[$i]['jumlah'] = $map->jumlahpasien;
                  }
              }

              $data['pasien'] = count($pas);
              $data['loadpasien'] = $pas;
          } else {
              $data['pasien'] = 0;
              $data['loadpasien'] = array();
          }

          echo CJSON::encode($data);
          Yii::app()->end();
      } else
          throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
  }
  
}
