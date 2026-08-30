<?php
Yii::import('perawatanIntensif.controllers.PasienRawatIntensifController'); //Untuk menggunakan function simpanAkomodasiOtomatis()
Yii::import('rawatInap.controllers.PasienRawatInapController'); //Untuk menggunakan function simpanAkomodasiOtomatis()
Yii::import('rawatJalan.models.*');
Yii::import('rawatInap.models.*');
Yii::import('application.modules.radiologi.models.ROPasienMasukPenunjangV');
class PemeriksaanPasienController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/column1';
  public $defaultAction = 'index';
  public $path_view = 'perawatanIntensif.views.pemeriksaanPasien.';

  public function actionIndex($pendaftaran_id, $pasienadmisi_id)
  {
    $modPendaftaran = PIPendaftaranT::model()->with('jeniskasuspenyakit')->findByPk($pendaftaran_id);
    $modPasien = PIPasienM::model()->findByPk($modPendaftaran->pasien_id);
    $modAdmisi = PIPasienAdmisiT::model()->findByPk($pasienadmisi_id);
    $modMasukKamar = PIMasukKamarT::model()->findByAttributes(array('pasienadmisi_id' => $modAdmisi->pasienadmisi_id));
    $format = new MyFormatter();

    if (!empty($modMasukKamar)) {
      $modPendaftaran->pegawai->nama_pegawai = $modMasukKamar->pegawai->NamaLengkap;
    } else {
      $modPendaftaran->pegawai->nama_pegawai   = $modPendaftaran->dokter->NamaLengkap;
    }
    if (Yii::app()->user->getState('akomodasiotomatis') == true) {
      PasienRawatInapController::saveAkomodasi($modPendaftaran, $modAdmisi);
      //				$akomodasitersimpan = PasienRawatIntensifController::simpanAkomodasiOtomatis($modAdmisi->tgladmisi, date("Y-m-d H:i:s"), $modAdmisi->pasienadmisi_id);
      //				if($akomodasitersimpan){
      //					Yii::app()->user->setFlash('success',"Akomodasi otomatis tersimpan!");
      //				}else{
      //					Yii::app()->user->setFlash('error',"Akomodasi otomatis gagal disimpan! Silakan atur master dan tarif akomodasi!");
      //				}
    }


    $this->render('index', array(
      'modPendaftaran' => $modPendaftaran,
      'modPasien' => $modPasien,
      'modAdmisi' => $modAdmisi,
    ));
  }

  public function actionGetRiwayatPasien($id)
  {
    $this->layout = '//layouts/iframe';

    $modKunjungan = RIPasienM::model()->findByPk($id);


    $this->render('rawatInap.views._periksaDataPasien._riwayatPasien_new', array(
      'modKunjungan'   => $modKunjungan,
    ));
  }

  public function actionDetailPersalinan($id)
  {
    $this->layout = '//layouts/iframe';
    $modPersalinan = PersalinanT::model()->findAllByAttributes(array('pasien_id' => $id), array('order' => 'pendaftaran_id DESC'));
    $format = new MyFormatter;
    $modPersalinanSearch = new PersalinanT('search');
    $modPasien = PasienM::model()->findByPK($id);
    $this->render('rawatJalan.views._periksaDataPasien._persalinan_new', array(
      'modPersalinan'       => $modPersalinan,
      'modPersalinanSearch'   => $modPersalinanSearch,
      'modPasien'         => $modPasien
    ));
  }

  public function actionDetailKelahiran($id)
  {
    $this->layout = '//layouts/iframe';
    $modKelahirans = array();
    $modPersalinan = PersalinanT::model()->findAllByAttributes(array('pasien_id' => $id), array('order' => 'pendaftaran_id DESC'));
    foreach ($modPersalinan as $persalinan) {
      $modKelahirans[] = KelahiranbayiT::model()->findByAttributes(array('persalinan_id' => $persalinan->persalinan_id));
    }
    $format = new MyFormatter;
    $modKelahiranSearch = new KelahiranbayiT('search');
    $modPasien = PasienM::model()->findByPK($id);
    $this->render('rawatJalan.views._periksaDataPasien._kelahiran_new', array(
      'modKelahirans'     => $modKelahirans,
      'modKelahiranSearch' => $modKelahiranSearch,
      'modPasien'       => $modPasien
    ));
  }

  public function actionDetailAnamnesa($id)
  {
    $this->layout = '//layouts/iframe';
    $modAnamnesa = AnamnesaT::model()->findAllByAttributes(array('pasien_id' => $id), array('order' => 'pendaftaran_id DESC'));
    $format = new MyFormatter;
    $modAnamnesaSearch = new AnamnesaT('search');
    $modPasien = PasienM::model()->findByPK($id);
    $this->render('rawatJalan.views._periksaDataPasien._anamnesa_new', array(
      'modAnamnesa'     => $modAnamnesa,
      'modAnamnesaSearch'   => $modAnamnesaSearch,
      'modPasien'       => $modPasien
    ));
  }

  public function actionDetailPeriksaFisik($id)
  {
    $this->layout = '//layouts/iframe';
    $modPemeriksaanFisik = RIPemeriksaanFisikT::model()->findAllByAttributes(array(
      'pasien_id' => $id
    ), array('order' => 'create_time DESC'));
    $format = new MyFormatter;
    $modPemeriksaanFisikSearch = new PemeriksaanFisikT('search');
    $modPasien = PasienM::model()->findByPK($id);
    $this->render('rawatJalan.views._periksaDataPasien._periksafisik_new', array(
      'modPemeriksaanFisik'     => $modPemeriksaanFisik,
      'modPemeriksaanFisikSearch'   => $modPemeriksaanFisikSearch,
      'modPasien'           => $modPasien,
    ));
  }

  public function actionDetailKePenunjang($id)
  {
    $this->layout = '//layouts/iframe';

    $this->render('rawatJalan.views._periksaDataPasien._kepenunjang_new', array(
      'pasien_id' => $id
    ));
  }

  public function actionDetailHasilLab($pasien_id)
  {
    $this->layout = '//layouts/iframe';
    $format = new MyFormatter();
    $judulLaporan = "Hasil Pemeriksaan Laboratorium";
    $modKunjungans = RJPasienMasukPenunjangV::model()->findAllByAttributes(array('pasien_id' => $pasien_id));

    $this->render('rawatInap.views.riwayatPasien.detailHasilLab_new', array(
      'format'           => $format,
      'modKunjungans'         => $modKunjungans,
      'judulLaporan'         => $judulLaporan,
    ));
  }

  public function actionDetailHasilRad($pasien_id, $caraPrint = '')
  {
    $this->layout = '//layouts/iframe';
    $modPasienMasukPenunjang = ROPasienMasukPenunjangV::model()->findAllByAttributes(array(
      'pasien_id' => $pasien_id
    ));

    $this->render('rawatInap.views.riwayatPasien.detailHasilRad_new', array(
      'masukpenunjangs' => $modPasienMasukPenunjang,
      'caraPrint'     => $caraPrint,
    ));
  }

  public function actionDetailKonsulKePoli($id)
  {
    $this->layout = '//layouts/iframe';

    $this->render('rawatJalan.views._periksaDataPasien._konsulpoli_new', array(
      'pasien_id' => $id
    ));
  }

  public function actionDetailTindakan($id)
  {
    $this->layout = '//layouts/iframe';
    $criteria = new CDbCriteria;
    $criteria->select = "pendaftaran_id";
    $criteria->order = "pendaftaran_id DESC";
    $criteria->group = "pendaftaran_id";
    $criteria->addCondition('pasien_id=' . $id);
    $modTindakan = RITindakanPelayananT::model()->findAll($criteria);
    $format = new MyFormatter;
    $modTindakanSearch = new RITindakanPelayananT('search');
    $modPasien = PasienM::model()->findByPK($id);
    $this->render('rawatJalan.views._periksaDataPasien._tindakan_new', array(
      'modTindakan'     => $modTindakan,
      'modTindakanSearch'   => $modTindakanSearch,
      'modPasien'       => $modPasien
    ));
  }

  public function actionDetailTerapi($id)
  {
    $this->layout = '//layouts/iframe';
    $modTerapi = ResepturT::model()->findAllByAttributes(array('pasien_id' => $id), array('order' => 'pendaftaran_id DESC'));
    $modDetailTerapi = new RIResepturDetailT('searchDetailTerapi');
    $format = new MyFormatter;
    $modPasien = PasienM::model()->findByPK($id);
    $this->render('rawatJalan.views._periksaDataPasien._terapi_new', array(
      'modTerapi'       => $modTerapi,
      'modDetailTerapi'   => $modDetailTerapi,
      'modPasien'       => $modPasien
    ));
  }

  public function actionDetailPemakaianBahan($id)
  {
    $this->layout = '//layouts/iframe';
    $criteria = new CDbCriteria;
    $criteria->select = "pendaftaran_id";
    $criteria->order = "pendaftaran_id DESC";
    $criteria->group = "pendaftaran_id";
    $criteria->addCondition('pasien_id=' . $id);
    $criteria->addCondition('penjualanresep_id is Null');
    $modBahan = RJObatalkesPasienT::model()->findAll($criteria);
    $format = new MyFormatter;
    $modPemakaianBahan = new RJObatalkesPasienT;
    $modPasien = PasienM::model()->findByPK($id);
    $this->render('rawatJalan.views._periksaDataPasien._pemakaianBahan_new', array(
      'modBahan'       => $modBahan,
      'modPemakaianBahan'   => $modPemakaianBahan,
      'modPasien'       => $modPasien
    ));
  }

  public function actionDetailDiagnosis($id)
  {
    $this->layout = '//layouts/iframe';

    $this->render('rawatJalan.views._periksaDataPasien._diagnosa_new', array(
      'pasien_id' => $id
    ));
  }

  public function actionDetailOperasi($id)
  {
    $this->layout = '//layouts/iframe';

    $this->render('rawatJalan.views._periksaDataPasien._operasi_new', array(
      'pasien_id' => $id
    ));
  }

  public function actionDetailPemeriksa($id)
  {
    $this->layout = '//layouts/iframe';

    $this->render('rawatJalan.views._periksaDataPasien._pemeriksa', array(
      'pasien_id' => $id
    ));
  }

  public function actionDetailRujukKeluar($id)
  {
    $this->layout = '//layouts/iframe';

    $this->render('rawatJalan.views._periksaDataPasien._rujukKeluar_new', array(
      'pasien_id' => $id
    ));
  }
}
