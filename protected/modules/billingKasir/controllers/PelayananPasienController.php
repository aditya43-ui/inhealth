
<?php

class PelayananPasienController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/column1';
  public $defaultAction = 'index';
  public $path_view = 'billingKasir.views.pelayananPasien.';

  public $pembayaranpelayanan_tersimpan = false;
  public $tandabuktibayar_tersimpan = false;
  public $tindakansudahbayar_tersimpan = false;
  public $oasudahbayar_tersimpan = false;
  public $pemakaianuangmuka_tersimpan = false;
  public $bayarangsuran_tersimpan = false;
  public $bayarsemuatindakanoa = false;

  /**
   * Membuat dan menyimpan data baru.
   * jika dari informasi menggunakan @params:
   * - $_GET['pendaftaran_id']
   * - $_GET['pasienadmisi_id'] (untuk RI saja)
   */
  public function actionIndex($id = null, $pendaftaran_id = null)
  {
    $this->pageTitle = Yii::app()->name . " - Pelayanan Pasien";
    $format = new MyFormatter();
    $modKunjungan = new BKInfopasienpengunjungV;
    $model = new BKPembayaranpelayananT;
    $modTandabukti = new BKTandabuktibayarT;
    $modTandabukti->is_menggunakankartu = 0;
    $modTindakansudahbayar = new BKTindakansudahbayarT;
    $modOasudahbayar = new BKOasudahbayarT;
    $dataTindakans = array();
    $dataOas = array();

    if (!empty($pendaftaran_id)) {
      $modKunjungan = BKInfopasienpengunjungV::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));
    }

    $modKunjungan->tgl_pendaftaran = $format->formatDateTimeForUser($modKunjungan->tgl_pendaftaran);
    $modKunjungan->tanggal_lahir = $format->formatDateTimeForUser($modKunjungan->tanggal_lahir);

    if (!empty($modKunjungan->pasienadmisi_id)) { //replace dgn admisi
      $modKunjungan->instalasi_id = $modKunjungan->instalasiadmisi_id;
      $modKunjungan->ruangan_id = $modKunjungan->ruanganadmisi_id;
      $modKunjungan->kelaspelayanan_id = $modKunjungan->kelaspelayananadmisi_id;
      $modKunjungan->carabayar_id = $modKunjungan->carabayaradmisi_id;
      $modKunjungan->penjamin_id = $modKunjungan->penjaminadmisi_id;
      $modKunjungan->ruangan_nama = $modKunjungan->ruanganadmisi_nama;
      $modKunjungan->kelaspelayanan_nama = $modKunjungan->kelaspelayananadmisi_nama;
      $modKunjungan->carabayar_nama = $modKunjungan->carabayaradmisi_nama;
      $modKunjungan->penjamin_nama = $modKunjungan->penjaminadmisi_nama;
    }

    $this->render('index', array(
      'model' => $model,
      'modTandabukti' => $modTandabukti,
      'modKunjungan' => $modKunjungan,
      'dataTindakans' => $dataTindakans,
      'dataOas' => $dataOas,
    ));
  }


  /**
   * untuk menampilkan data kunjungan dari autocomplete
   * - no_pendaftaran
   * - no_rekam_medik
   * - nama_pasien
   */
  public function actionAutocompleteKunjungan()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter();
      $returnVal = array();
      $no_pendaftaran = isset($_GET['no_pendaftaran']) ? $_GET['no_pendaftaran'] : null;
      $no_rekam_medik = isset($_GET['no_rekam_medik']) ? $_GET['no_rekam_medik'] : null;
      $nama_pasien = isset($_GET['nama_pasien']) ? $_GET['nama_pasien'] : null;
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(no_pendaftaran)', strtolower($no_pendaftaran), true);
      $criteria->compare('LOWER(no_rekam_medik)', strtolower($no_rekam_medik), true);
      $criteria->compare('LOWER(nama_pasien)', strtolower($nama_pasien), true);
      $criteria->order = 'no_pendaftaran, no_rekam_medik, nama_pasien';
      $criteria->limit = 5;
      $criteria->addInCondition('instalasi_id', array(Params::INSTALASI_ID_RJ, Params::INSTALASI_ID_RD, Params::INSTALASI_ID_RI));
      $models = BKInfopasienpengunjungV::model()->findAll($criteria);
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }

        $returnVal[$i]['label'] = $model->no_pendaftaran . ' - ' . $model->no_rekam_medik . ' - ' . $model->nama_pasien . (!empty($model->nama_bin) ? "(" . $model->nama_bin . ")" : "");
        $returnVal[$i]['value'] = $model->no_pendaftaran;
        $returnVal[$i]['pasienadmisi_id'] = isset($model->pasienadmisi_id) ? $model->pasienadmisi_id : '';
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }
  /**
   * Mengurai data kunjungan berdasarkan:
   * - pendaftaran_id
   * - pasienadmisi_id
   * - no_pendaftaran
   * - no_rekam_medik
   * @throws CHttpException
   */
  public function actionGetDataKunjungan()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter();
      $pendaftaran_id = isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null;
      $pasienadmisi_id = isset($_POST['pasienadmisi_id']) ? $_POST['pasienadmisi_id'] : null;
      $no_pendaftaran = isset($_POST['no_pendaftaran']) ? $_POST['no_pendaftaran'] : null;
      $no_rekam_medik = isset($_POST['no_rekam_medik']) ? $_POST['no_rekam_medik'] : null;
      $returnVal = array();
      $criteria = new CDbCriteria();
      if (!empty($pendaftaran_id)) {
        $criteria->addCondition("pendaftaran_id = " . $pendaftaran_id);
      }
      if (!empty($pasienadmisi_id)) {
        $criteria->addCondition("pasienadmisi_id = " . $pasienadmisi_id);
      }
      $criteria->compare('LOWER(no_pendaftaran)', strtolower(trim($no_pendaftaran)));
      $criteria->compare('LOWER(no_rekam_medik)', strtolower(trim($no_rekam_medik)));
      // $criteria->addInCondition('instalasi_id', array(Params::INSTALASI_ID_RJ, Params::INSTALASI_ID_RD, Params::INSTALASI_ID_RI,Params::INSTALASI_ID_REHAB,Params::INSTALASI_ID_RAD, Params::INSTALASI_ID_LAB));
      $model = BKInfopasienpengunjungV::model()->find($criteria);

      $attributes = $model->attributeNames();
      foreach ($attributes as $j => $attribute) {
        $returnVal["$attribute"] = $model->$attribute;
      }


      $pendaftaran = PendaftaranT::model()->findByPk($model->pendaftaran_id);
      $asuransi = AsuransipasienM::model()->findByPk($pendaftaran->asuransipasien_id);

      $attributes = $model->attributeNames();
      foreach ($attributes as $j => $attribute) {
        $returnVal["$attribute"] = $model->$attribute;
      }


      $returnVal['kelastanggungan_id'] = null;
      $returnVal['kelastanggungan_nama'] = null;

      $returnVal['kelastanggungan_nilai'] = null;
      $returnVal['kelaspelayanan_nilai'] = Params::kelasPelayananNilai($model->kelaspelayanan_id);

      if (!empty($asuransi)) {
        $kelas = KelaspelayananM::model()->findByPk($asuransi->kelastanggunganasuransi_id);
        $returnVal['kelastanggungan_id'] = $kelas->kelaspelayanan_id;
        $returnVal['kelastanggungan_nama'] = $kelas->kelaspelayanan_nama;
        $returnVal['kelastanggungan_nilai'] = Params::kelasPelayananNilai($kelas->kelaspelayanan_id);
      }


      $returnVal['dokterpenerima'] = "";
      $returnVal['dpjp1'] = "";
      $returnVal['dpjp2'] = "";
      $returnVal['dpjp3'] = "";

      if (!empty($model->pasienadmisi_id)) { //replace dgn admisi
        $admisi = PasienadmisiT::model()->findByPk($model->pasienadmisi_id);

        $returnVal["instalasi_id"] = $model->instalasiadmisi_id;
        $returnVal["ruangan_id"] = $model->ruanganadmisi_id;
        $returnVal["kelaspelayanan_id"] = $model->kelaspelayananadmisi_id;
        $returnVal["carabayar_id"] = $model->carabayaradmisi_id;
        $returnVal["penjamin_id"] = $model->penjaminadmisi_id;
        $returnVal["ruangan_nama"] = $model->ruanganadmisi_nama;
        $returnVal["kelaspelayanan_nama"] = $model->kelaspelayananadmisi_nama;
        $returnVal["carabayar_nama"] = $model->carabayaradmisi_nama;
        $returnVal["penjamin_nama"] = $model->penjaminadmisi_nama;

        if (!empty($admisi->dokterpenerima_id)) {
          $peg = PegawaiM::model()->findByPk($admisi->dokterpenerima_id);
          $returnVal['dokterpenerima'] = $peg->namaLengkap;
        }

        if (!empty($admisi->pegawai_id)) {
          $peg = PegawaiM::model()->findByPk($admisi->pegawai_id);
          $returnVal['dpjp1'] = $peg->namaLengkap;
        }

        if (!empty($admisi->dpjp2_id)) {
          $peg = PegawaiM::model()->findByPk($admisi->dpjp2_id);
          $returnVal['dpjp2'] = $peg->namaLengkap;
        }

        if (!empty($admisi->dpjp3_id)) {
          $peg = PegawaiM::model()->findByPk($admisi->dpjp3_id);
          $returnVal['dpjp3'] = $peg->namaLengkap;
        }
      }
      $returnVal["tanggal_lahir"] = $format->formatDateTimeForUser($model->tanggal_lahir);
      $returnVal["tgl_pendaftaran"] = $format->formatDateTimeForUser($model->tgl_pendaftaran);
      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }
}
