<?php
Yii::import('rawatInap.controllers.PasienRawatInapController');
Yii::import('rawatInap.models.*');

class InfoKunjunganRIController extends MyAuthController
{
  public $path_view = 'pendaftaranPenjadwalan.views.infoKunjunganRI.';
  public $path_view_RI = 'rawatInap.views.pasienRawatInap.';
  public $rujukantersimpan = false;
  public $successSave;
  public $successUpdateMasukKamar = false;
  public $successPasienPulang = false;
  public $successUpdatePendaftaran = false;
  public $successUpdatePasienAdmisi = false;
  public $successRujukanKeluar = true;
  public $successPaseinM = true;
  public $successSaveTindakanKomponen = true;
  public $asuransipasientersimpan = false;
  public $successSaveTindakan;
  public $simpan_rencanakontrol;
  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - Rawat Inap";
    $format = new MyFormatter();
    $modPPInfoKunjunganRIV = new PPInfoKunjunganRIV;
    $modPPInfoKunjunganRIV->tgl_awal = date('Y-m-d');
    $modPPInfoKunjunganRIV->tgl_akhir = date('Y-m-d');
    $modPPInfoKunjunganRIV->tgl_awall = date('Y-m-d');
    $modPPInfoKunjunganRIV->tgl_akhirl = date('Y-m-d');
    $modPPInfoKunjunganRIV->ceklis = false;
    $modPPInfoKunjunganRIV->statusperiksa =  Params::STATUSPERIKSA_SEDANG_DIRAWATINAP;
    $modPPInfoKunjunganRIV->pilihanPeriode = '1';
    if (isset($_REQUEST['PPInfoKunjunganRIV'])) {
      $modPPInfoKunjunganRIV->attributes = $_REQUEST['PPInfoKunjunganRIV'];
      $modPPInfoKunjunganRIV->ceklis = $_REQUEST['PPInfoKunjunganRIV']['ceklis'];
      $modPPInfoKunjunganRIV->pilihanPeriode = $_REQUEST['PPInfoKunjunganRIV']['pilihanPeriode'];
      $modPPInfoKunjunganRIV->is_verifikasidiagnosa = $_REQUEST['PPInfoKunjunganRIV']['is_verifikasidiagnosa'];
      $modPPInfoKunjunganRIV->rujukandari_id = $_REQUEST['PPInfoKunjunganRIV']['rujukandari_id'];
      $modPPInfoKunjunganRIV->kamarruangan_id = $_REQUEST['PPInfoKunjunganRIV']['kamarruangan_id'];
      $modPPInfoKunjunganRIV->create_loginpemakai_id = $_REQUEST['PPInfoKunjunganRIV']['create_loginpemakai_id'];
      $modPPInfoKunjunganRIV->tgl_awal = isset($_REQUEST['PPInfoKunjunganRIV']['tgl_awal']) ? $format->formatDateTimeForDb($_REQUEST['PPInfoKunjunganRIV']['tgl_awal']) : null;
      $modPPInfoKunjunganRIV->tgl_akhir = isset($_REQUEST['PPInfoKunjunganRIV']['tgl_akhir']) ? $format->formatDateTimeForDb($_REQUEST['PPInfoKunjunganRIV']['tgl_akhir']) : null;
      $modPPInfoKunjunganRIV->tgl_awall = $format->formatDateTimeForDb($_REQUEST['PPInfoKunjunganRIV']['tgl_awall']);
      $modPPInfoKunjunganRIV->tgl_akhirl = $format->formatDateTimeForDb($_REQUEST['PPInfoKunjunganRIV']['tgl_akhirl']);
    }
    if(Yii::app()->request->isAjaxRequest) {
      if(isset($_GET['ajax']) && $_GET['ajax'] == 'PPInfoKunjungan-v') {
        $this->renderPartial($this->path_view . '_table', ['modPPInfoKunjunganRIV' => $modPPInfoKunjunganRIV]);
        Yii::app()->end();
      }
    }
    /*

             $this->render(
                'pendaftaranPenjadwalan.views.infoKunjunganRI.index',
                 array('modPPInfoKunjunganRIV'=>$modPPInfoKunjunganRIV)
             );
             */
    $this->render($this->path_view . 'index', array('format' => $format, 'modPPInfoKunjunganRIV' => $modPPInfoKunjunganRIV));
  }

  public function actionGetKamarKosong($encode = false)
  {
    if (Yii::app()->request->isAjaxRequest) {
      if (isset($_POST['kelaspelayanan_id'])) {
        $ruangan_id = $_POST['ruangan_id'];
        $kelaspelayanan_id = ($_POST['kelaspelayanan_id'] == '' ? 0 : $_POST['kelaspelayanan_id']);

        $kamarKosong = array();
        if (!empty($ruangan_id)) {

          if (isset($_POST['all_kamar'])) {
            $kamarKosong = KamarruanganM::model()->findAllByAttributes(
              array(
                'ruangan_id' => $ruangan_id,
                'kelaspelayanan_id' => $kelaspelayanan_id,
                'kamarruangan_aktif' => true,
              )
            );
          } else {
            $kamarKosong = KamarruanganM::model()->findAllByAttributes(
              array(
                'ruangan_id' => $ruangan_id,
                'kelaspelayanan_id' => $kelaspelayanan_id,
                'kamarruangan_status' => (isset($_POST['is_status']) ? $_POST['is_status'] : true),
                'kamarruangan_aktif' => true,
              )
            );
          }


          $kamarKosong = CHtml::listData($kamarKosong, 'kamarruangan_id', 'KamarDanTempatTidurInUseV2');
        }
      } else {
        $ruangan_id = $_POST['ruangan_id'];
        $kamarKosong = array();
        if (!empty($ruangan_id)) {
          $kamarKosong = KamarruanganM::model()->findAllByAttributes(array('ruangan_id' => $ruangan_id, 'kamarruangan_status' => true));
          $kamarKosong = CHtml::listData($kamarKosong, 'kamarruangan_id', 'KamarDanTempatTidur');
        }
      }

      if ($encode) {
        echo CJSON::encode($kamarKosong);
      } else {
        if (empty($kamarKosong)) {
          echo CHtml::tag('option', array('value' => ''), CHtml::encode("-- Pilih --"), true);
        } else {
          if (count((array)$kamarKosong) > 1) {
            echo CHtml::tag('option', array('value' => ''), CHtml::encode("-- Pilih --"), true);
          }
          foreach ($kamarKosong as $value => $name) {
            echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
          }
        }
      }
    }
    Yii::app()->end();
  }
  public function actionGetKelasPelayanan($encode = false)
  {
    if (Yii::app()->request->isAjaxRequest) {
      $ruangan_id = $_POST['ruangan_id'];
      $kelaspelayanan = array();
      if (!empty($ruangan_id)) {
        $kelasRuangan = KelasruanganM::model()->findAllByAttributes(array('ruangan_id' => $ruangan_id));

        foreach ($kelasRuangan as $key => $value) {
          $kelaspelayanan[$key] = KelaspelayananM::model()->findByPk($value->kelaspelayanan_id);
        }
        $kelaspelayanan = CHtml::listData($kelaspelayanan, 'kelaspelayanan_id', 'kelaspelayanan_nama');
      }

      if ($encode) {
        echo CJSON::encode($kelaspelayanan);
      } else {
        if (empty($kelaspelayanan)) {
          echo CHtml::tag('option', array('value' => ''), CHtml::encode("-- Pilih --"), true);
        } else {
          echo CHtml::tag('option', array('value' => ''), CHtml::encode("-- Pilih --"), true);
          foreach ($kelaspelayanan as $value => $name) {
            echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
          }
        }
      }
    }
    Yii::app()->end();
  }
  public function actionSetDropdownRuangan($encode = false, $model_nama = '', $attr = '')
  {
    if (Yii::app()->request->isAjaxRequest) {
      $instalasi_id = null;
      if ($model_nama !== '' && $attr == '') {
        $instalasi_id = $_POST["$model_nama"]['instalasi_id'];
      } else if ($model_nama == '' && $attr !== '') {
        $instalasi_id = $_POST["$attr"];
      } else if ($model_nama !== '' && $attr !== '') {
        $instalasi_id = $_POST["$model_nama"]["$attr"];
      }
      $models = null;
      $models = CHtml::listData(RuanganM::getRuanganByInstalasi($instalasi_id), 'ruangan_id', 'ruangan_nama');

      if ($encode) {
        echo CJSON::encode($models);
      } else {
        echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
        if (count((array)$models) > 0) {
          foreach ($models as $value => $name) {
            echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
          }
        }
      }
    }
    Yii::app()->end();
  }
  /**
   * @author Deni Hamdani <denihamdani@piindonesia.co.id>
   * 
   * Menampilkan form Ubah Dokter DPJP
   * Ketika disubmit, mencatat record update DPJP + Update di pasienadmisi_t
   * 
   * @param type $id data id dari pasienadmisi_t
   * @param type $ubahdokter_id data id untuk ubahdokter_r
   */
  public function actionUbahDokterPeriksaRI($id, $ubahdokter_id = NULL)
  {
    $this->layout = "//layouts/iframe";
    $model = PPPasienAdmisiT::model()->findByAttributes(array('pendaftaran_id' => $id));
    $modUbahDokter = new PPUbahdokterR;
    $params = array('pegawai_id', 'dpjp2_id', 'dpjp3_id');
    if (!empty($ubahdokter_id)) {
      $modUbahDokter = PPUbahdokterR::model()->findByPk($ubahdokter_id);
    }
    if (isset($_POST['PPPasienAdmisiT'])) {
      // $model->attributes = $_POST['PPPasienAdmisiT'];
      $modUbahDokter->attributes = $_POST['PPUbahdokterR'];
      $modUbahDokter->pendaftaran_id = $_POST['PPPasienAdmisiT']['pendaftaran_id'];
      $modUbahDokter->dokterbaru_id = $_POST['PPPasienAdmisiT']['pegawai_id'];
      $modUbahDokter->tglubahdokter = date('Y-m-d H:i:s');
      $modUbahDokter->pasienadmisi_id = $model->pasienadmisi_id;
      $modUbahDokter->create_time = date('Y-m-d H:i:s');
      $modUbahDokter->create_loginpemakai_id = Yii::app()->user->id;
      $modUbahDokter->create_ruangan = Yii::app()->user->getState('ruangan_id');

      // var_dump($modUbahDokter->attributes, $_POST); die;

      $transaction = Yii::app()->db->beginTransaction();
      try {

        $ok = true;

        foreach ($params as $item) {
          echo "Kick ";
          $ok && $this->simpanUbahDokters($modUbahDokter, $model, $item, $_POST['PPPasienAdmisiT'][$item]);
        }
        //$attributes = array('pendaftaran_id'=>$_POST['PPPasienAdmisiT']['pendaftaran_id']);
        //$data = $model::model()->findByAttributes($attributes);
        // die;
        // var_dump($model->attributes); die;

        // $attributes = array('pegawai_id'=>$_POST['PPPasienAdmisiT']['pegawai_id']);
        // $save = $model::model()->updateByPk($model->pasienadmisi_id, $attributes);

        if ($ok) {
          $modUbahDokter->save();
          $transaction->commit();
          $this->redirect(array('ubahDokterPeriksaRI', 'id' => $model->pendaftaran_id, 'ubahdokter_id' => $modUbahDokter->ubahdokter_id, 'sukses' => 1));
        } else {
          echo CJSON::encode(array(
            'status' => 'proses_form',
            'div' => "<div class='flash-error'>Data gagal disimpan.</div>",
          ));
        }
        exit;
      } catch (Exception $exc) {
        $transaction->rollback();
      }
    }
    $this->render(
      $this->path_view . '_formUbahDokterPeriksaRI',
      array('model' => $model, 'modUbahDokter' => $modUbahDokter)
    );
  }


  public function actionPindahKamarPasienRI($pendaftaran_id)
  {
    $this->layout = '//layouts/iframe';
    $format = new MyFormatter();
    $modPindahKamar = new RIPindahkamarT;
    $modPasienAdmisi = new RIPasienAdmisiT;
    $modPasienPulang = new RIPasienPulangT;
    $modMasukKamar = new RIMasukKamarT;
    $modTindakan = null;

    $nama_modul = Yii::app()->controller->module->id;
    $nama_controller = Yii::app()->controller->id;
    $nama_action = Yii::app()->controller->action->id;
    $modul_id = ModulK::model()->findByAttributes(array('url_modul' => $nama_modul))->modul_id;
    $criteria = new CDbCriteria;
    $criteria->compare('modul_id', $modul_id);
    $criteria->compare('LOWER(modcontroller)', strtolower($nama_controller), true);
    $criteria->compare('LOWER(modaction)', strtolower($nama_action), true);
    if (isset($_POST['tujuansms'])) {
      $criteria->addInCondition('tujuansms', $_POST['tujuansms']);
    }
    $modSmsgateway = SmsgatewayM::model()->findAll($criteria);
    $smspasien = 1;

    $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
    $modPasienRIV = RIPasienRawatInapV::model()->findByAttributes(
      array('pasienadmisi_id' => $modPendaftaran->pasienadmisi_id)
    );
    $modMasukKamar = RIMasukKamarT::model()->findByPk(
      $modPasienRIV->masukkamar_id
    );

    $modPindahKamar->pasien_id = $modPasienRIV->pasien_id;
    $modPindahKamar->pendaftaran_id = $modPasienRIV->pendaftaran_id;
    $modPindahKamar->pasienadmisi_id = $modPasienRIV->pasienadmisi_id;
    $modPindahKamar->masukkamar_id = $modPasienRIV->masukkamar_id;
    $modPindahKamar->kamarruangan_id = !empty($modPasienRIV->kamarruangan_id) ? $modPasienRIV->kamarruangan_id : null;
    $modPindahKamar->is_titipan = $modPasienRIV->is_titipan;
    $modPindahKamar->pegawai_id = $modPendaftaran->pegawai_id;
    $modPindahKamar->carabayar_id = $modPendaftaran->carabayar_id;
    // $modPindahKamar->ruangan_id = $modPendaftaran->ruangan_id;
    $modPindahKamar->penjamin_id = $modPendaftaran->penjamin_id;
    // $modPindahKamar->kelaspelayanan_id = $modPasienRIV->kelaspelayanan_id;
    $modPindahKamar->jampindahkamar = date('H:i:s');
    $modPindahKamar->shift_id = Yii::app()->user->getState('shift_id');
    $modPindahKamar->nopindahkamar = MyGenerator::noMasukKamar($modPindahKamar->ruangan_id);
    $modPindahKamar->tglpindahkamar = date('d M Y');

    if (!empty($modPindahKamar->ruangan_id)) {
      $modRuang = RuanganM::model()->findByPk($modPindahKamar->ruangan_id);
      $modPindahKamar->instalasi_id = $modRuang->instalasi_id;
    }

    $tersimpan = 'Tidak';
    if (isset($_POST['RIPindahkamarT'])) {
      if ($_POST['RIPindahkamarT']['pendaftaran_id'] == '') {
        Yii::app()->user->setFlash('error', "Pendaftaran masih kosong coba cek lagi");
        $this->refresh();
      } else {
        $modPindahKamar->attributes = $_POST['RIPindahkamarT'];
        $modPindahKamar->tglpindahkamar = $format->formatDateTimeForDb($_POST['RIPindahkamarT']['tglpindahkamar']) . " " . $modPindahKamar->jampindahkamar;
        $pendaftaran_id = ((isset($_POST['RIPindahkamarT']['pendaftaran_id'])) ? $_POST['RIPindahkamarT']['pendaftaran_id'] : null);
        $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);

        $modPasienRIV = RIPasienRawatInapV::model()->findByAttributes(
          array(
            'pasienadmisi_id' => $modPendaftaran->pasienadmisi_id
          )
        );

        /* PASIEN MASUK KAMAR LAMA*/
        $modMasukKamar = RIMasukKamarT::model()->findByPk(
          $modPindahKamar->masukkamar_id
        );

        $kamar_asal = (!empty($modMasukKamar)) ? $modMasukKamar->kamarruangan->kamarruangan_nokamar . ' ' . $modMasukKamar->kamarruangan->kamarruangan_nobed : '-';

        /* PASIEN ADMISI*/
        $modPasienAdmisi = RIPasienAdmisiT::model()->findByPK(
          $modPindahKamar->pasienadmisi_id
        );

        /* END PASIEN ADMISI*/

        $modPindahKamar->pasien_id = $modPasienRIV->pasien_id;
        $modPindahKamar->pendaftaran_id = $modPasienRIV->pendaftaran_id;
        $modPindahKamar->pasienadmisi_id = $modPasienRIV->pasienadmisi_id;
        $modPindahKamar->shift_id = Yii::app()->user->getState('shift_id');
        $modPindahKamar->nopindahkamar = MyGenerator::noPindahKamar($modPindahKamar->ruangan_id);
        $modPindahKamar->carabayar_id = $modPasienAdmisi->carabayar_id;
        $modPindahKamar->penjamin_id = $modPasienAdmisi->penjamin_id;
        $modPindahKamar->pegawai_id = $modPasienAdmisi->pegawai_id;

        // die;

        /* PROSES SIMPAN DAN UPDATE */
        $transaction = Yii::app()->db->beginTransaction();
        $is_simpan = false;
        $errors = array();
        $pesan = array(
          'status' => 'success',
          'text' => 'Data Berhasil Disimpan'
        );


        /* PROSES PINDAH DOKUMEN RM */
        /*
					$dokrm = PengirimanrmT::model()->findByAttributes(array(
						'pendaftaran_id'=>$modPasienRIV->pendaftaran_id,
						'ruangan_id'=>Yii::app()->user->getState('ruangan_id'),
					), array(
						'order'=>'pengirimanrm_id desc',
					));
					if (!empty($dokrm)) {
						$doknew = new PengirimanrmT();
						//$doknew->attributes = $dokrm->attributes;
						$doknew->pengirimanrm_id = null;
						$doknew->pasien_id = $dokrm->pasien_id;
						$doknew->pendaftaran_id = $dokrm->pendaftaran_id;
						$doknew->ruanganpengirim_id = $dokrm->ruangan_id;
						$doknew->dokrekammedis_id = $dokrm->dokrekammedis_id;
						$doknew->ruangan_id = $modPindahKamar->ruangan_id;
						$doknew->nourut_keluar = MyGenerator::noUrutKeluarRM();
						$doknew->tglpengirimanrm = $modPindahKamar->tglpindahkamar;
						$doknew->kelengkapandokumen = true;

						$lp = LoginpemakaiK::model()->findByPk(Yii::app()->user->id);
						if (!empty($lp->pegawai_id)) {
							$pegawai = PegawaiM::model()->findByPk($lp->pegawai_id);
							$doknew->petugaspengirim = $pegawai->nama_pegawai;
						}


						$doknew->validate();
					}
                     * 
                     */

        try {
          /* simpan_pindah_kamar */
          // var_dump($modPindahKamar->attributes);
          $mk =  MasukkamarT::model()->findByPk($modPindahKamar->masukkamar_id);
          $modPindahKamar->masukkamar_id = null; //ini di isi masukkamar baru nanti
          if ($modPindahKamar->save()) {
            $modMasukKamar->pindahkamar_id = $modPindahKamar->pindahkamar_id;
            $modMasukKamar->tglkeluarkamar = $modPindahKamar->tglpindahkamar;
            $modMasukKamar->jamkeluarkamar = $modPindahKamar->jampindahkamar;

            $selisihHari = CustomFunction::hitungHari($modMasukKamar->tglmasukkamar, $modMasukKamar->tglkeluarkamar);

            $modMasukKamar->lamadirawat_kamar = $selisihHari;
          } else {
            $modMasukKamar->pindahkamar_id = null;
          }

          // var_dump($mk->kamarruangan_id);

          if (!empty($modPasienAdmisi->kamarruangan_id)) {
            //echo "Kick1"; die;
            KamarruanganM::model()->updateByPk(
              $modPasienAdmisi->kamarruangan_id,
              array('kamarruangan_status' => true, 'keterangan_kamar' => Params::KETERANGANKAMAR_TERSEDIA) //'OPEN'
            );
          } else if (!empty($mk) && !empty($mk->kamarruangan_id)) {
            //echo "Kick2"; die;
            KamarruanganM::model()->updateByPk(
              $mk->kamarruangan_id,
              array('kamarruangan_status' => true, 'keterangan_kamar' => Params::KETERANGANKAMAR_TERSEDIA) //'OPEN'
            );
          }
          // die;

          /* update_masuk_kamar lama*/
          if ($modMasukKamar->save()) {
            /* update_pasien_admisi */
            $is_simpan = true;

            if ($modPasienAdmisi->ruangan_id != $modPindahKamar->ruangan_id) {
              $is_simpan = $is_simpan && $this->simpanKirimRMPindahKamar($modPasienAdmisi, $modPindahKamar);
            }

            // var_dump($is_simpan); die;

            $modPasienAdmisi->ruangan_id = $modPindahKamar->ruangan_id;
            $modPasienAdmisi->kelaspelayanan_id = $modPindahKamar->kelaspelayanan_id;
            $modPasienAdmisi->kamarruangan_id = !empty($modPindahKamar->kamarruangan_id) ? $modPindahKamar->kamarruangan_id : null;
            if ($modPasienAdmisi->save()) {
              /* simpan_masuk_kamar_new */
              $is_simpan = true;
              $mod_masuk_kamar = new RIMasukKamarT();
              $mod_masuk_kamar->attributes = $modPindahKamar->attributes; //mengambil nilai ruangan_id, 
              $mod_masuk_kamar->pindahkamar_id = null; //karena record baru asumsi belum pernah pindah
              $mod_masuk_kamar->masukkamar_id = null; //record baru
              $mod_masuk_kamar->nomasukkamar = MyGenerator::noMasukKamar(Yii::app()->user->getState('ruangan_id'));
              $mod_masuk_kamar->tglmasukkamar = $modPindahKamar->tglpindahkamar;
              $mod_masuk_kamar->jammasukkamar = $modPindahKamar->jampindahkamar;
              $mod_masuk_kamar->kelaspelayanan_id = empty($modPindahKamar->kelaspelayanan_id) ?  $modMasukKamar->kelaspelayanan_id : $modPindahKamar->kelaspelayanan_id;
              $mod_masuk_kamar->create_time = date('Y-m-d H:i:s');
              $mod_masuk_kamar->create_loginpemakai_id = Yii::app()->user->id;
              $mod_masuk_kamar->create_ruangan = Yii::app()->user->getState('ruangan_id');
              $mod_masuk_kamar->kamarruangan_id = !empty($modPindahKamar->kamarruangan_id) ? $modPindahKamar->kamarruangan_id : null;

              if ($mod_masuk_kamar->save()) {
                $is_simpan = true;
                //if (!empty($dokrm)) {
                //	$doknew->save();
                //}
                //var_dump($doknew->save()); die;
                //update masukkamar_id (baru) pada pindahkamar_t
                $modPindahKamar->updateByPk($modPindahKamar->pindahkamar_id, array('masukkamar_id' => $mod_masuk_kamar->masukkamar_id));
                if (!empty($modPindahKamar->kamarruangan_id)) {
                  /* update_kamar_ruangan */
                  KamarruanganM::model()->updateByPk(
                    $modPindahKamar->kamarruangan_id,
                    array('kamarruangan_status' => false, 'keterangan_kamar' => Params::KETERANGANKAMAR_DIGUNAKAN) //'IN USE'
                  );
                }
              } else {
                $is_simpan = false;
                $pesan = array(
                  'status' => 'error',
                  'text' => 'Data Masuk Kamar Gagal Disimpan'
                );
                $errors[] = $pesan;
              }
            } else {
              $is_simpan = false;
              $pesan = array(
                'status' => 'error',
                'text' => 'Data Admisi Gagal Disimpan'
              );
              $errors[] = $pesan;
            }
          } else {
            $is_simpan = false;
            $pesan = array(
              'status' => 'error',
              'text' => 'Data Masuk Kamar Gagal Disimpan'
            );
            $errors[] = $pesan;
          }

          self::saveAkomodasi($modPendaftaran, $modPasienAdmisi);

          if ($is_simpan) {
            $tersimpan = 'Ya';

            //notifikasi pindah kamar ke ruangan tujuan
            $nama_pemakai = LoginpemakaiK::model()->findByPk($mod_masuk_kamar->create_loginpemakai_id);
            $tujuan = RuanganM::model()->findByPk($modPindahKamar->ruangan_id);
            $modul = ModulK::model()->findByPk($tujuan->modul_id);

            if ($modPindahKamar->ruangan_id != Yii::app()->user->getState('ruangan_id')) {
              $judul = 'PASIEN PINDAH KAMAR';
              $isi = $modPasienRIV->no_rekam_medik . ' ' . $modPasienRIV->namadepan . ' ' . $modPasienRIV->nama_pasien . ', ' . strtoupper($kamar_asal . ' - ' . $modPindahKamar->kamarruangan->kamarruangan_nokamar . ' ' . $modPindahKamar->kamarruangan->kamarruangan_nobed) . '<br/>'
                . MyFormatter::formatDateTimeForUser(date("Y-m-d", strtotime($mod_masuk_kamar->create_time))) . ', ' . $nama_pemakai->nama_pemakai;

              if (!empty($tujuan->modul_id)) {
                $ok = CustomFunction::broadcastNotif($judul, $isi, array(
                  array(
                    'instalasi_id' => $tujuan->instalasi_id,
                    'ruangan_id' => $tujuan->ruangan_id,
                    'modul_id' => $modul->modul_id
                  ),
                ));
              }

              $ok = CustomFunction::broadcastNotif($judul, $isi, array(
                array('instalasi_id' => Yii::app()->user->getState('instalasi_id'), 'ruangan_id' => Yii::app()->user->getState('ruangan_id'), 'modul_id' => Yii::app()->session['modul_id']),
                //array('instalasi_id'=>Params::INSTALASI_ID_KEUANGAN, 'ruangan_id'=> Params::RUANGAN_ID_KASIR, 'modul_id'=>Params::MODUL_ID_BILLINGKASIR ),
                array('instalasi_id' => Params::INSTALASI_ID_RM, 'ruangan_id' => Params::RUANGAN_ID_LOKET, 'modul_id' => Params::MODUL_ID_PENDAFTARAN),
                array('instalasi_id' => Params::INSTALASI_ID_RM, 'ruangan_id' => Params::RUANGAN_ID_REKAM_MEDIS, 'modul_id' => Params::MODUL_ID_REKAMMEDIS),
                array('instalasi_id' => Params::INSTALASI_ID_FARMASI, 'ruangan_id' => Params::RUANGAN_ID_APOTEK_1, 'modul_id' => Params::MODUL_ID_APOTEK),
              ));
            } else {
              $judul = 'PASIEN PINDAH KAMAR';
              $isi = $modPasienRIV->no_rekam_medik . ' ' . $modPasienRIV->namadepan . ' ' . $modPasienRIV->nama_pasien . ', ' . strtoupper($kamar_asal . ' - ' . $modPindahKamar->kamarruangan->kamarruangan_nokamar . ' ' . $modPindahKamar->kamarruangan->kamarruangan_nobed) . '<br/>'
                . MyFormatter::formatDateTimeForUser(date("Y-m-d", strtotime($mod_masuk_kamar->create_time))) . ', ' . $nama_pemakai->nama_pemakai;
              $ok = CustomFunction::broadcastNotif($judul, $isi, array(
                array('instalasi_id' => Yii::app()->user->getState('instalasi_id'), 'ruangan_id' => Yii::app()->user->getState('ruangan_id'), 'modul_id' => Yii::app()->session['modul_id']),
                //array('instalasi_id'=>Params::INSTALASI_ID_KEUANGAN, 'ruangan_id'=> Params::RUANGAN_ID_KASIR, 'modul_id'=>Params::MODUL_ID_BILLINGKASIR ),
                array('instalasi_id' => Params::INSTALASI_ID_RM, 'ruangan_id' => Params::RUANGAN_ID_LOKET, 'modul_id' => Params::MODUL_ID_PENDAFTARAN),
                array('instalasi_id' => Params::INSTALASI_ID_RM, 'ruangan_id' => Params::RUANGAN_ID_REKAM_MEDIS, 'modul_id' => Params::MODUL_ID_REKAMMEDIS),
                array('instalasi_id' => Params::INSTALASI_ID_FARMASI, 'ruangan_id' => Params::RUANGAN_ID_APOTEK_1, 'modul_id' => Params::MODUL_ID_APOTEK),
              ));
            }

            // SMS GATEWAY
            /*
							$modPasien = $modPasienAdmisi->pasien;
							$modRuangan = $modPasienAdmisi->ruangan;
							$modKamarRuangan = $modPasienAdmisi->kamarruangan;
							$modKelaspelayanan = $modPasienAdmisi->kelaspelayanan;
							$sms = new Sms();
							foreach ($modSmsgateway as $i => $smsgateway) {
								$isiPesan = $smsgateway->templatesms;

								$attributes = $modPasien->getAttributes();
								foreach($attributes as $attributes => $value){
									$isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
								}
								$attributes = $modRuangan->getAttributes();
								foreach($attributes as $attributes => $value){
									$isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
								}
								$attributes = $modKelaspelayanan->getAttributes();
								foreach($attributes as $attributes => $value){
									$isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
								}
								if($modKamarRuangan){
									$attributes = $modKamarRuangan->getAttributes();
									foreach($attributes as $attributes => $value){
										$isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
									}
								}
								$attributes = $modPindahKamar->getAttributes();
								foreach($attributes as $attributes => $value){
									$isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
								}
								$isiPesan = str_replace("{{hari}}",MyFormatter::getDayName($modPindahKamar->tglpindahkamar),$isiPesan);


								if($smsgateway->tujuansms == Params::TUJUANSMS_PASIEN && $smsgateway->statussms){
									if(!empty($modPasien->no_mobile_pasien)){
										$sms->kirim($modPasien->no_mobile_pasien,$isiPesan);
									}else{
										$smspasien = 0;
									}
								}
							}
							 * 
							 */
            // END SMS GATEWAY

            $transaction->commit();
            Yii::app()->user->setFlash($pesan['status'], $pesan['text']);
          } else {
            foreach ($errors as $val) {
              Yii::app()->user->setFlash($val['status'], $val['text']);
            }
            $transaction->rollback();
          }
        } catch (Exception $exc) {
          // echo "<pre>";
          // var_dump($exc);die;
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data gagal disimpan" . MyExceptionMessage::getMessage($exc, true));
        }
      }
    }
    $this->render(
      $this->path_view_RI . 'formPindahKamar',
      array(
        'modPindahKamar' => $modPindahKamar,
        'modPasienRIV' => $modPasienRIV,
        'modMasukKamar' => $modMasukKamar,
        'modTindakan' => $modTindakan,
        'tersimpan' => $tersimpan,
        'is_grid' => true,
        'smspasien' => $smspasien
      )
    );
  }

  public static function saveAkomodasi($modPendaftaran, $modPasienAdmisi)
  {
    $ok = true;
    $masuk = MasukkamarT::model()->findAllByAttributes(array(
      'pasienadmisi_id' => $modPasienAdmisi->pasienadmisi_id,
    ), array(
      'order' => 'masukkamar_id asc',
    ));

    $konfig = KonfigsystemK::model()->find();

    $limit_alert = $konfig->waktutampilalert_akomodasisdhterhitung;
    $limit_alert_time = (empty($limit_alert) ? 2 : $limit_alert) * 3600;

    $downer = 0;
    $base_masuk = array();

    foreach ($masuk as $idx => $item) {

      $next = !empty($masuk[$idx + 1]) ? $masuk[$idx + 1] : null;
      $prov = !empty($masuk[$idx - 1]) ? $masuk[$idx - 1] : null;
      $tgl_awal = $item->tglmasukkamar;
      $tgl_awal_pendek = date('Y-m-d', strtotime($item->tglmasukkamar));
      $tgl_akhir = date("Y-m-d H:i:s");

      $is_ada = false;
      $selisih = 0;
      if (!empty($next)) {
        $is_ada = true;
        $tgl_akhir = $next->tglmasukkamar;
      }

      $base_masuk[] = array(
        'data' => $item,
        'tgl_awal' => $tgl_awal,
        'tgl_awal_pendek' => date('Y-m-d', strtotime($tgl_awal)),
        'tgl_awal_time' => strtotime($tgl_awal),
        'tgl_akhir' => $tgl_akhir,
        'tgl_akhir_pendek' => date('Y-m-d', strtotime($tgl_akhir)),
        'tgl_akhir_time' => strtotime($tgl_akhir),
        'is_insert' => true,
        'selisih' => CustomFunction::hitungHariRawat($tgl_awal, $tgl_akhir),
      );
    }

    $cr_tindakan = new CDbCriteria;
    $cr_tindakan->compare('pendaftaran_id', $modPendaftaran->pendaftaran_id);
    $cr_tindakan->addCondition('masukkamar_id = :masuk_id and tgl_tindakan::date = :tgl');

    foreach ($base_masuk as $idx => $item) {
      $selisih = $item['tgl_akhir_time'] - $item['tgl_awal_time'];


      if ($selisih <= $limit_alert_time && $item['tgl_awal_pendek'] == $item['tgl_akhir_pendek']) {

        $tind = TindakanpelayananT::model()->findByAttributes(array(
          'masukkamar_id' => $item['data']->masukkamar_id,
        ), array(
          'condition' => "tgl_tindakan::date = '" . $item['tgl_awal_pendek'] . "'"
        ));

        if (empty($tind) && !empty($base_masuk[$idx + 1])) {
          $base_masuk[$idx]['is_insert'] = false;
        } else {
          if (!empty($base_masuk[$idx + 1])) {
            $base_masuk[$idx + 1]['is_insert'] = false;
          }
        }
      }
    }
    //            
    //            var_dump($base_masuk); die;

    foreach ($base_masuk as $det) {
      $item = $det['data'];

      $periode = new DatePeriod(new DateTime($det['tgl_awal_pendek']), new DateInterval('P1D'), new DateTime(date('Y-m-d', strtotime('+1 day', strtotime($det['tgl_akhir_pendek'])))));

      $idx = 0;
      foreach ($periode as $item2) {
        if ($idx == 0) {
          if (!$det['is_insert']) {
            continue;
          }
          $tgl = $item2->format('Y-m-d') . " " . date('H:i:s', strtotime($item->tglmasukkamar));
        } else {
          $timedata = "00::00:01";

          if ($konfig->akomodasiotomatis == true && $konfig->jenispenambahan_akomodasiranap == "is_waktupenambahan") {
            if (!empty($konfig->akomodasiotomatis)) {
              $timedata = $konfig->jam_jobakomodasiranap;
            }
          }

          $tgl = $item2->format('Y-m-d') . " " . $timedata;
        }

        $masuk_c = clone $item;
        $masuk_c->tglmasukkamar = $tgl;

        $cr = new CDbCriteria;
        $cr->addCondition("tgl_tindakan::date = '" . $item2->format('Y-m-d') . "'");
        $cr->compare("masukkamar_id", $item->masukkamar_id);

        $tindakan = TindakanpelayananT::model()->find($cr);

        if (empty($tindakan)) {
          self::simpanTindakanAkomodasi($modPasienAdmisi, $masuk_c, 1);
        }

        $idx++;
      }
    }

    return $ok;
  }

  public static function simpanTindakanAkomodasi($modPasienAdmisi, $masukkamar, $selisih)
  {
    $akomodasi_list = PasienRawatInapController::tindakanAkomodasi($masukkamar->kelaspelayanan_id, $masukkamar->penjamin_id, $masukkamar->ruangan_id);

    if (count((array)$akomodasi_list) == 0) {
      return true;
    }

    foreach ($akomodasi_list as $akomodasi) {
      $tindakan = new TindakanpelayananT;

      $tindakan->penjamin_id = $masukkamar->penjamin_id;
      $tindakan->pasien_id = $modPasienAdmisi->pasien_id;
      $tindakan->pasienadmisi_id = $modPasienAdmisi->pasienadmisi_id;
      $tindakan->kelaspelayanan_id = $modPasienAdmisi->kelaspelayanan_id;
      $tindakan->instalasi_id = $masukkamar->ruangan->instalasi_id;
      $tindakan->pendaftaran_id = $modPasienAdmisi->pendaftaran_id;
      $tindakan->shift_id = 1; //Yii::app()->user->getState('shift_id');
      $tindakan->daftartindakan_id = (isset($akomodasi->daftartindakan_id) ? $akomodasi->daftartindakan_id : "");
      $tindakan->carabayar_id = $modPasienAdmisi->carabayar_id;
      $tindakan->jeniskasuspenyakit_id = $modPasienAdmisi->pendaftaran->jeniskasuspenyakit_id;

      $tindakan->tarif_satuan = (isset($akomodasi->harga_tariftindakan) ? $akomodasi->harga_tariftindakan : "");
      $tindakan->qty_tindakan = 1;
      $tindakan->tarif_tindakan = $tindakan->tarif_satuan * $tindakan->qty_tindakan;
      $tindakan->satuantindakan = Params::SATUAN_TINDAKAN_PENDAFTARAN;
      $tindakan->cyto_tindakan = 0;
      $tindakan->tarifcyto_tindakan = 0;
      $tindakan->dokterpemeriksa1_id = NULL;
      $tindakan->discount_tindakan = 0;
      $tindakan->subsidiasuransi_tindakan = 0;
      $tindakan->subsidipemerintah_tindakan = 0;
      $tindakan->subsisidirumahsakit_tindakan = 0;
      $tindakan->iurbiaya_tindakan = 0;
      $tindakan->pembebasan_tindakan = 0;
      $tindakan->ruangan_id = $masukkamar->ruangan_id;
      $tindakan->tipepaket_id = PasienRawatInapController::tipePaketAkomodasi($modPasienAdmisi->pendaftaran, $modPasienAdmisi, $tindakan->daftartindakan_id);
      $tindakan->create_time = date('Y-m-d H:i:s');
      $tindakan->create_loginpemakai_id = 1;
      $tindakan->create_ruangan = $masukkamar->ruangan_id;
      $tindakan->tarif_rsakomodasi = 0;
      $tindakan->tarif_medis = 0;
      $tindakan->tarif_paramedis = 0;
      $tindakan->tarif_bhp = 0;
      $tindakan->tgl_tindakan = date('Y-m-d H:i:s', strtotime($masukkamar->tglmasukkamar));
      $tindakan->masukkamar_id = $masukkamar->masukkamar_id;

      $ok = true;

      if ($tindakan->validate()) {
        $ok = $ok && $tindakan->save();
        $tindakan->saveTindakanKomponen();

        //$komponen = TindakankomponenT::model()->findAllByAttributes(array(
        //    'tindakanpelayanan_id'=>$tindakan->tindakanpelayanan_id,
        //));
        //var_dump(count((array)$komponen));
      } else {
        $ok = false;
      }
    }

    return $ok;
    // var_dump($tindakan->attributes);
  }
  public function simpanUbahDokters($modUbahDokter, $admisi, $param, $item)
  {
    $ok = true;

    $dpjp = array(
      'pegawai_id' => 1,
      'dpjp2_id' => 2,
      'dpjp3_id' => 3,
    );

    $model = new PPUbahdokterR;
    $model->attributes = $modUbahDokter->attributes;
    $model->dokterlama_id = $admisi[$param];
    $model->dokterbaru_id = $item;
    $model->dpjp = $dpjp[$param];

    // var_dump($model->attributes, $admisi->attributes);

    if ($model->dokterlama_id == $model->dokterbaru_id) return true;

    if ($model->validate()) {
      $ok = $ok && $model->save();
    } else $ok = false;


    if ($param == 'pegawai_id') {
      $masukkamar = MasukkamarT::model()->findByAttributes(array('pasienadmisi_id' => $admisi->pasienadmisi_id));
      if (!empty($masukkamar)) {
        MasukkamarT::model()->updateByPk($masukkamar->masukkamar_id, array('pegawai_id' => $item));
      }
    }

    PasienadmisiT::model()->updateByPk($admisi->pasienadmisi_id, array($param => $item));

    return true;
  }

  /**
   * untuk mengubah cara bayar
   */
  public function actionUbahCaraBayarRI($id = null, $idSep = null)
  {
    $this->layout = "//layouts/iframe";
    if ($id == null) {
      if (isset($_POST['id'])) {
        $id = $_POST['id'];
      }
    }

    $model = new UbahcarabayarR;
    if ($id != null) {
      $modPendaftaran = PPPendaftaranT::model()->findByPk($id);
      if (!empty($modPendaftaran->pasienadmisi_id)) {
        $modAdmisi = PPPasienAdmisiT::model()->findByPk($modPendaftaran->pasienadmisi_id);
      }
      if (!empty($modPendaftaran)) {
        $modPasien = PPPasienM::model()->findByPk($modPendaftaran->pasien_id);
      }
    }
    $modRujukanBpjs = new PPRujukanbpjsT;
    $modAsuransiPasien = new PPAsuransipasienM;
    $modAsuransiPasienBpjs = new PPAsuransipasienbpjsM;
    $modSep = new PPSepT;

    if (isset($idSep)) {
      $modRujukanBpjs = PPRujukanbpjsT::model()->findByPk($modPendaftaran->rujukan_id);
      $modAsuransiPasienBpjs = PPAsuransipasienbpjsM::model()->findByPk($modPendaftaran->asuransipasien_id);
      $modSep = PPSepT::model()->findByPk($idSep);
    }


    if (isset($_POST['UbahcarabayarR'])) {
      $pendaftaran_id = $_POST['pendaftaran_id'];
      $model->attributes = $_POST['UbahcarabayarR'];
      $model->pendaftaran_id = $_POST['pendaftaran_id'];
      $model->carabayar_id = $_POST['PPPasienAdmisiT']['carabayar_id'];
      $modPendaftaran = PPPasienAdmisiT::model()->findByPk($pendaftaran_id);
      $model->tglubahcarabayar = date('Y-m-d H:i:s');

      $transaction = Yii::app()->db->beginTransaction();
      $ok = true;
      try {

        $modPendaftaran = PPPendaftaranT::model()->findByPk(
          $model->pendaftaran_id
        );

        if (isset($_POST['PPPendaftaranT'])) {
          $modPendaftaran->attributes = $_POST['PPPendaftaranT'];
        }
        if (isset($_POST['PPPasienAdmisiT'])) {
          $modAdmisi->attributes = $_POST['PPPasienAdmisiT'];
        }

        $modPendaftaran->carabayar_id = $_POST['PPPasienAdmisiT']['carabayar_id'];
        $modPendaftaran->penjamin_id = $_POST['UbahcarabayarR']['penjamin_id'];
        $modPendaftaran->status_konfirmasi = "-";
        $modPendaftaran->asuransipasien_id = null;

        if (isset($_POST['PPAsuransipasienM'])) {
          if (isset($_POST['PPAsuransipasienM']['asuransipasien_id'])) {
            if ($_POST['PPAsuransipasienM']['asuransipasien_id'] == "") {
              $modAsuransiPasien = PPAsuransipasienM::model()->findByPk($_POST['PPAsuransipasienM']['asuransipasien_id']);
            }
          }
          $modAsuransiPasien = $this->simpanAsuransiPasien($modAsuransiPasien, $modPendaftaran, $modPasien, $_POST['PPAsuransipasienM']);
          $modPendaftaran->status_konfirmasi = $modAsuransiPasien->status_konfirmasi;
          $modPendaftaran->tgl_konfirmasi = MyFormatter::formatDateTimeForDb($modAsuransiPasien->tgl_konfirmasi);
          $modPendaftaran->asuransipasien_id = $modAsuransiPasien->asuransipasien_id;
        } else {
          $this->asuransipasientersimpan = true;
          // $modPendaftaran->status_konfirmasi = $modAsuransiPasien->status_konfirmasi;
          // $modPendaftaran->tgl_konfirmasi = $modAsuransiPasien->tgl_konfirmasi;
          // $modPendaftaran->asuransipasien_id = $modAsuransiPasien->asuransipasien_id;
        }

        if ($model->save()) {
          $modPendaftaran->save();

          $modAdmisi->carabayar_id = $modPendaftaran->carabayar_id;
          $modAdmisi->penjamin_id = $modPendaftaran->penjamin_id;
          $modAdmisi->save();

          $modMasukKamar = MasukkamarT::model()->findByAttributes(['pasienadmisi_id' => $modAdmisi->pasienadmisi_id]);
          if (!empty($modMasukKamar)) {
            $modMasukKamar->carabayar_id = $modPendaftaran->carabayar_id;
            $modMasukKamar->penjamin_id = $modPendaftaran->penjamin_id;
            $modMasukKamar->save();
          }

          // $ok = $ok && $this->updateKarcis($modPendaftaran);


          if (isset($_POST['PPRujukanbpjsT'])) {
            $modRujukanBpjs = $this->simpanRujukanBpjs($modRujukanBpjs, $_POST['PPRujukanbpjsT']);
          } else {
            $this->rujukantersimpan = true;
          }

          $updatetindakan = TindakanpelayananT::model()->findAll("pendaftaran_id = " . $modPendaftaran->pendaftaran_id . " AND tindakansudahbayar_id IS NULL ");
          if (!empty($updatetindakan)) {
            foreach ($updatetindakan as $key => $tindakan) {
              $ok = $ok && $this->updateTindakan($tindakan, $modAdmisi);
            }
          }

          $updateobat = ObatalkespasienT::model()->findAll("pendaftaran_id = " . $modPendaftaran->pendaftaran_id . " AND oasudahbayar_id IS NULL ");
          if (!empty($updateobat)) {
            $jualResep = [];
            foreach ($updateobat as $key => $obatpas) {
              $obatpas->carabayar_id = $modPendaftaran->carabayar_id;
              $obatpas->penjamin_id = $modPendaftaran->penjamin_id;

              $ok &= $this->updateObatpasien($obatpas, $modPendaftaran);
              if (!empty($obatpas->penjualanresep_id)) {
                $jualResep[$obatpas->penjualanresep_id] = $obatpas->penjualanresep_id;
              }
            }

            if (!empty($jualResep)) {
              $cri = new CDbCriteria;
              $cri->select = " t.penjualanresep_id, SUM(oap.harganetto_oa * oap.qty_oa) as totharganetto, SUM(oap.hargajual_oa) as totalhargajual ";
              $cri->group  = " t.penjualanresep_id ";
              $cri->join = " JOIN obatalkespasien_t oap ON oap.penjualanresep_id = t.penjualanresep_id ";
              $resep = PenjualanresepT::model()->findAll($cri);

              if (!empty($resep)) {
                foreach ($resep as $val) {
                  $val->update();
                }
              }
            }
          }

          if (isset($_POST['PPAsuransipasienbpjsM'])) {
            if (isset($_POST['PPAsuransipasienbpjsM']['asuransipasien_id'])) {
              if ($_POST['PPAsuransipasienbpjsM']['asuransipasien_id'] != "") {
                $modAsuransiPasienBpjs = PPAsuransipasienM::model()->findByPk($_POST['PPAsuransipasienbpjsM']['asuransipasien_id']);
              }
            }
            $modAsuransiPasienBpjs = $this->simpanAsuransiPasien($modAsuransiPasienBpjs, $modPendaftaran, $modPasien, $_POST['PPAsuransipasienbpjsM']);
            $modPendaftaran->status_konfirmasi = $modAsuransiPasienBpjs->status_konfirmasi;
            $modPendaftaran->tgl_konfirmasi = Myformatter::formatDateTimeForDb($modAsuransiPasienBpjs->tgl_konfirmasi);
            $modPendaftaran->asuransipasien_id = $modAsuransiPasienBpjs->asuransipasien_id;

            $modPendaftaran->save();
          } else {
            $this->asuransipasientersimpan = true;
          }




          if (!empty($modRujukanBpjs->rujukan_id) && !empty($modAsuransiPasienBpjs->asuransipasien_id)) {
            PPPendaftaranT::model()->updateByPk($pendaftaran_id, array('carabayar_id' => $modPendaftaran->carabayar_id, 'penjamin_id' => $modPendaftaran->penjamin_id, 'rujukan_id' => $modRujukanBpjs->rujukan_id, 'asuransipasien_id' => $modAsuransiPasienBpjs->asuransipasien_id));
          } else if (!empty($modAsuransiPasien->asuransipasien_id)) {
            PPPendaftaranT::model()->updateByPk($pendaftaran_id, array('carabayar_id' => $modPendaftaran->carabayar_id, 'penjamin_id' => $modPendaftaran->penjamin_id, 'asuransipasien_id' => $modAsuransiPasien->asuransipasien_id));
          } else {
            PPPendaftaranT::model()->updateByPk($pendaftaran_id, array('carabayar_id' => $modPendaftaran->carabayar_id, 'penjamin_id' => $modPendaftaran->penjamin_id));
          }

          if (isset($_POST['PPSepT'])) {
            $modSep = $this->simpanSep($modPendaftaran, $modPasien, $modRujukanBpjs, $modAsuransiPasienBpjs, $_POST['PPSepT']);
          }

          if ($ok) {

            $this->notifUbahBayar($modAdmisi);

            $transaction->commit();
            if (isset($modSep->nosep)) {
              $this->redirect(array('ubahCaraBayarRI', 'id' => $model->pendaftaran_id, 'idSep' => $modSep->sep_id, 'sukses' => 1));
            } else {
              $this->redirect(array('ubahCaraBayarRI', 'id' => $model->pendaftaran_id, 'sukses' => 1));
            }
          } else {
            $transaction->rollback();
            Yii::app()->user->setFlash('error', "Data pasien gagal disimpan err1 !");
          }
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data pasien gagal disimpan err2 !");
        }
      } catch (Exception $exc) {
        echo '<pre>';
        var_dump($exc);
        die;
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data pasien gagal disimpan ! (X)" . MyExceptionMessage::getMessage($exc, true));
      }
    }


    $this->render(
      '_formUbahCaraBayar',
      array(
        'model' => $model,
        'modPendaftaran' => $modPendaftaran,
        'modAsuransiPasien' => $modAsuransiPasien,
        'modAsuransiPasienBpjs' => $modAsuransiPasienBpjs,
        'modRujukanBpjs' => $modRujukanBpjs,
        'modSep' => $modSep,
        'modAdmisi' => $modAdmisi,
      )
    );
  }

  // private function updateTindakan($post, $daftar) {
  //   $ok = true;
  //   $tarif_tindakan = $post->getTarifSatuan($post->daftartindakan_id, $post->kelaspelayanan_id, $daftar, $ubah = true);

  //   // $post->kelaspelayanan_id = $daftar->kelaspelayanan_id;
  //   $post->carabayar_id = $daftar->carabayar_id;
  //   $post->penjamin_id = $daftar->penjamin_id;
  //   $post->tarif_satuan = !empty($tarif_tindakan) ? $tarif_tindakan : 0;
  //   $post->tarif_tindakan = $post->tarif_satuan * $post->qty_tindakan;
  //   $post->iurbiaya_tindakan = $post->tarif_tindakan - ($post->subsidiasuransi_tindakan + $post->subsidipemerintah_tindakan + $post->subsisidirumahsakit_tindakan);
  //   $post->cyto_tindakan = !empty($post->cyto_tindakan)?$post->cyto_tindakan:0;
  //   $tinkom = TindakankomponenT::model()->deleteAll(" tindakanpelayanan_id = ".$post->tindakanpelayanan_id);

  //   // $new = clone $post;   
  //   // $new->isNewRecord = true;

  //   // $post->delete();

  //   if ($post->save()) {
  //     $ok = true;
  //     $this->saveTindakanKomponen($post, $tarif_tindakan);
  //   } else {            
  //     $ok = false;
  //   }        
  //   return $ok;
  // }

  // protected function saveTindakanKomponen($tindakan, $tarif_tindakan)
  // {  
  //   if(!empty($tarif_tindakan)){
  //     $valid = true;

  //     $modTindakanKomponen = new TindakankomponenT;
  //     $modTindakanKomponen->tindakanpelayanan_id = $tindakan->tindakanpelayanan_id;
  //     // $modTindakanKomponen->komponentarif_id = $tarif_tindakan['komponentarif_id'];
  //     $modTindakanKomponen->tarif_kompsatuan = $tarif_tindakan;
  //     $modTindakanKomponen->tarif_tindakankomp = $modTindakanKomponen->tarif_kompsatuan * $tindakan->qty_tindakan;
  //     if($tindakan->cyto_tindakan){
  //         $modTindakanKomponen->tarifcyto_tindakankomp = $tarif_tindakan['harga_tariftindakan'] * ($tarif_tindakan['persencyto_tind']/100);
  //     } else {
  //         $modTindakanKomponen->tarifcyto_tindakankomp = 0;
  //     }
  //     $modTindakanKomponen->subsidiasuransikomp = $tindakan->subsidiasuransi_tindakan;
  //     $modTindakanKomponen->subsidipemerintahkomp = $tindakan->subsidipemerintah_tindakan;
  //     $modTindakanKomponen->subsidirumahsakitkomp = $tindakan->subsisidirumahsakit_tindakan;
  //     $modTindakanKomponen->iurbiayakomp = $tindakan->iurbiaya_tindakan;
  //     $valid = $modTindakanKomponen->validate() && $valid;
  //     if($valid){
  //         $modTindakanKomponen->save();
  //     }

  //     return $valid;
  //   } 
  // }



  private function updateTindakan($post, $daftar)
  {
    $ok = true;

    if (!$post->is_paketbmhp) {
      $tarif_tindakan = $post->getTarifSatuan($post->daftartindakan_id, $post->kelaspelayanan_id, $daftar, $ubah = true);
    } else {
      $tarif_tindakan = $post->tarif_satuan;
    }

    // $post->kelaspelayanan_id = $daftar->kelaspelayanan_id;
    $post->carabayar_id = $daftar->carabayar_id;
    $post->penjamin_id = $daftar->penjamin_id;
    $post->tarif_satuan = !empty($tarif_tindakan) ? $tarif_tindakan : 0;
    $post->tarif_tindakan = $post->tarif_satuan * $post->qty_tindakan;
    $post->iurbiaya_tindakan = $post->tarif_tindakan - ($post->subsidiasuransi_tindakan + $post->subsidipemerintah_tindakan + $post->subsisidirumahsakit_tindakan);
    $post->cyto_tindakan = !empty($post->cyto_tindakan) ? $post->cyto_tindakan : 0;
    $tinkom = TindakankomponenT::model()->deleteAll(" tindakanpelayanan_id = " . $post->tindakanpelayanan_id);

    $detailLab = DetailhasilpemeriksaanlabT::model()->findAllByAttributes(array(
      'tindakanpelayanan_id' => $post->tindakanpelayanan_id,
    ));
    $detailRad = HasilpemeriksaanradT::model()->findAllByAttributes(array(
      'tindakanpelayanan_id' => $post->tindakanpelayanan_id,
    ));
    $detailRehab = HasilpemeriksaanrmT::model()->findAllByAttributes(array(
      'tindakanpelayanan_id' => $post->tindakanpelayanan_id,
    ));
    $detailOperasi = RencanaoperasiT::model()->findAllByAttributes(array(
      'tindakanpelayanan_id' => $post->tindakanpelayanan_id,
    ));

    // $new = clone $post;   
    // $new->isNewRecord = true;
    // $new->tindakanpelayanan_id = null;

    if ($post->save(false, array('carabayar_id', 'penjamin_id', 'tarif_satuan', 'tarif_tindakan', 'iurbiaya_tindakan', 'cyto_tindakan'))) {
      foreach ($detailLab as $item) {
        $item->tindakanpelayanan_id = $post->tindakanpelayanan_id;
        $item->save();
      }
      foreach ($detailRad as $item) {
        $item->tindakanpelayanan_id = $post->tindakanpelayanan_id;
        $item->save();
      }
      foreach ($detailRehab as $item) {
        $item->tindakanpelayanan_id = $post->tindakanpelayanan_id;
        $item->save();
      }
      foreach ($detailOperasi as $item) {
        $item->tindakanpelayanan_id = $post->tindakanpelayanan_id;
        $item->save();
      }

      // $post->delete();
      $this->saveTindakanKomponen($post, $tarif_tindakan);

      $ok = true;
    } else {
      $ok = false;
    }
    return $ok;
  }

  protected function saveTindakanKomponen($tindakan, $tarif_tindakan)
  {
    $res = Yii::app()->db
      ->createCommand("select ins_aftertindakanpelayanan_fix_id(" . $tindakan->tindakanpelayanan_id . ") as simpan")
      ->queryRow();

    // var_dump($res);
  }

  public function actionUbahKeteranganPendaftaran()
  {
    $model = new PendaftaranT;
    if (isset($_POST['PendaftaranT'])) {
      if ($_POST['PendaftaranT']['keterangan_pendaftaran'] != "") {
        $model->attributes = $_POST['PendaftaranT'];
        $transaction = Yii::app()->db->beginTransaction();
        try {
          $attributes = array('keterangan_pendaftaran' => $_POST['PendaftaranT']['keterangan_pendaftaran']);
          $save = $model::model()->updateByPk($_POST['PendaftaranT']['pendaftaran_id'], $attributes);
          if ($save) {
            $transaction->commit();
            echo CJSON::encode(array(
              'status' => 'proses_form',
              'div' => "<div class='flash-success'>Berhasil merubah Keterangan Pendaftaran.</div>",
            ));
          } else {
            echo CJSON::encode(array(
              'status' => 'proses_form',
              'div' => "<div class='flash-error'>Data gagal disimpan.</div>",
            ));
          }
          exit;
        } catch (Exception $exc) {
          $transaction->rollback();
        }
      } else {
        echo CJSON::encode(
          array(
            'status' => 'proses_form',
            'div' => "<div class='flash-success'>Berhasil merubah data Keterangan Pendaftaran.</div>",
          )
        );
        exit;
      }
    }

    if (Yii::app()->request->isAjaxRequest) {
      echo CJSON::encode(array(
        'status' => 'create_form',
        'div' => $this->renderPartial($this->path_view . '_formUbahKeterangan', array('model' => $model), true)
      ));
      exit;
    }
  }

  public function actionGetRujukanDari($encode = false, $namaModel = '')
  {
    if (Yii::app()->request->isAjaxRequest) {
      $asalrujukan_id = $_POST["$namaModel"]['asalrujukan_id'];

      if ($encode) {
        echo CJSON::encode($rujukandari);
      } else {
        if (empty($asalrujukan_id)) {
          echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
        } else {
          echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
          $rujukandari = RujukandariM::model()->findAllByAttributes(array('asalrujukan_id' => $asalrujukan_id), array('order' => 'namaperujuk'));
          $rujukandari = CHtml::listData($rujukandari, 'rujukandari_id', 'namaperujuk');
          foreach ($rujukandari as $value => $name) {
            echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
          }
        }
      }
    }
    Yii::app()->end();
  }
  public function simpanRujukanBpjs($modRujukanBpjs, $post)
  {
    $format = new MyFormatter();
    $modRujukanBpjs->attributes = $post;
    $modRujukanBpjs->kddiagnosa_rujukan = isset($post['kddiagnosa_rujukan']) ? ((count((array)$post['kddiagnosa_rujukan']) > 0) ? implode(', ', $post['kddiagnosa_rujukan']) : '') : '';
    $modRujukanBpjs->diagnosa_rujukan = isset($post['diagnosa_rujukan']) ? ((count((array)$post['diagnosa_rujukan']) > 0) ? implode(', ', $post['diagnosa_rujukan']) : '') : '';
    $modRujukanBpjs->tanggal_rujukan = $format->formatDateTimeForDb($modRujukanBpjs->tanggal_rujukan);

    if ($modRujukanBpjs->save()) {
      $this->rujukantersimpan = true;
    }
    return $modRujukanBpjs;
  }
  public function simpanAsuransiPasien($modAsuransiPasien, $postPendaftaran, $postPasien, $postAsuransiPasien)
  {
    $format = new MyFormatter();
    if (empty($postAsuransiPasien['asuransipasien_id'])) {
      $modAsuransiPasien = new PPAsuransipasienM();
      // $modAsuransiPasien = PPAsuransipasienM::model()->findByPk($_POST['PPAsuransipasienM']['asuransipasien_id']);
    }
    $modAsuransiPasien->attributes = $postAsuransiPasien;
    $modAsuransiPasien->pasien_id = isset($postPasien['pasien_id']) ? $postPasien['pasien_id'] : null;
    $modAsuransiPasien->penjamin_id = isset($postPendaftaran['penjamin_id']) ? $postPendaftaran['penjamin_id'] : null;
    $modAsuransiPasien->carabayar_id = isset($postPendaftaran['carabayar_id']) ? $postPendaftaran['carabayar_id'] : null;
    $modAsuransiPasien->create_loginpemakai_id = Yii::app()->user->id;
    $modAsuransiPasien->create_time = date("Y-m-d H:i:s");
    $modAsuransiPasien->tgl_konfirmasi = $format->formatDateTimeForDb($modAsuransiPasien->tgl_konfirmasi);
    if (empty($modAsuransiPasien->nopeserta)) $modAsuransiPasien->nopeserta = $modAsuransiPasien->nokartuasuransi;

    if ($postPendaftaran->carabayar_id == Params::CARABAYAR_ID_BPJS) {
      $kelas = KelaspelayananM::model()->findByAttributes(array('kelasbpjs_id' => $modAsuransiPasien->kelastanggunganasuransi_id));
      if (!empty($kelas)) {
        $modAsuransiPasien->kelastanggunganasuransi_id = $kelas->kelaspelayanan_id;
      }
      $modAsuransiPasien->status_konfirmasi = "SUDAH DIKONFIRMASI";
      $modAsuransiPasien->tgl_konfirmasi = date('Y-m-d H:i:s');
      $modAsuransiPasien->namaperusahaan = 'BPJS';
      // $modAsuransiPasien->nominal_tanggungan = KonfigsystemK::model()->find()->nominal_tanggunganbpjs;
    }


    if ($modAsuransiPasien->save()) {
      $this->asuransipasientersimpan = true;
    }

    // var_dump($modAsuransiPasien->attributes); die;

    return $modAsuransiPasien;
  }

  public function simpanSep($model, $modPasien, $modRujukanBpjs, $modAsuransiPasienBpjs, $postSep)
  {
    $reqSep = null;
    $modSep = new PPSepT;
    $bpjs = new Bpjs('http://api.asterix.co.id/SepWebRest');

    $modSep->tglsep = date('Y-m-d H:i:s');
    $modSep->nokartuasuransi = $modAsuransiPasienBpjs->nopeserta;
    $modSep->tglrujukan = $modRujukanBpjs->tanggal_rujukan;
    $modSep->norujukan = $modRujukanBpjs->no_rujukan;
    $modSep->ppkrujukan = $postSep['ppkrujukan'];
    $modSep->ppkpelayanan = Yii::app()->user->getState('ppkpelayanan');
    $modSep->jnspelayanan = ($model->instalasi_id == Params::INSTALASI_ID_RI) ? Params::JENISPELAYANAN_RI : Params::JENISPELAYANAN_RJ;
    $modSep->catatansep = $postSep['catatansep'];
    $data_diagnosa = explode(', ', $modRujukanBpjs->diagnosa_rujukan);
    $modSep->diagnosaawal = isset($data_diagnosa[0]) ? $data_diagnosa[0] : '';
    $modSep->politujuan = $model->ruangan_id;
    $modSep->klsrawat = $modAsuransiPasienBpjs->kelastanggunganasuransi_id;
    $modSep->tglpulang = date('Y-m-d H:i:s');
    $modSep->create_time = date('Y-m-d H:i:s');
    $modSep->create_loginpemakai_id = Yii::app()->user->id;
    $modSep->create_ruangan = Yii::app()->user->getState('ruangan_id');
    // var_dump($modSep->tglrujukan, $modSep->norujukan,  $modSep->norujukan, $modSep->ppkrujukan, $modSep->jnspelayanan, $modSep->catatansep, $modSep->politujuan, $modSep->klsrawat);die;

    $lakalantas = 2;

    //$reqSep = json_decode($bpjs->create_sep($modSep->nokartuasuransi, $modSep->tglsep, $modSep->tglrujukan, $modSep->norujukan, $modSep->ppkrujukan, $modSep->ppkpelayanan, $modSep->jnspelayanan, $modSep->catatansep, $modSep->diagnosaawal, $modSep->politujuan, $modSep->klsrawat, Yii::app()->user->id, $modPasien->no_rekam_medik, $lakalantas),true);
    $reqSep = json_decode($bpjs->create_sep($modSep->nokartuasuransi, $modSep->tglsep, $modSep->tglrujukan, $modSep->norujukan, $modSep->ppkrujukan, $modSep->ppkpelayanan, $modSep->jnspelayanan, $modSep->catatansep, $modSep->diagnosaawal, $modSep->politujuan, $modSep->klsrawat, Yii::app()->user->id, $modPasien->no_rekam_medik, $model->pendaftaran_id, $lakalantas), true);

    if ($reqSep['metadata']['code'] == 200) {
      $modSep->nosep = $reqSep['response'];
      if ($modSep->save()) {
        $this->septersimpan = true;
      }
    }

    return $modSep;
  }

  public function actionUbahKelasPelayananRI()
  {
    $model = new PasienadmisiT;
    if (isset($_POST['PasienadmisiT'])) {
      if ($_POST['PasienadmisiT']['kelaspelayanan_id'] != "") {
        $model->attributes = $_POST['PasienadmisiT'];
        $transaction = Yii::app()->db->beginTransaction();
        try {
          $attributes = array('pendaftaran_id' => $_POST['PasienadmisiT']['pendaftaran_id']);
          $data = $model::model()->findByAttributes($attributes);

          $attributes = array('kelaspelayanan_id' => $_POST['PasienadmisiT']['kelaspelayanan_id']);
          $save = $model::model()->updateByPk($data['pasienadmisi_id'], $attributes);

          if ($save) {
            $transaction->commit();
            echo CJSON::encode(array(
              'status' => 'proses_form',
              'div' => "<div class='flash-success'>Berhasil merubah Kelas Pelayanan.</div>",
            ));
          } else {
            echo CJSON::encode(array(
              'status' => 'proses_form',
              'div' => "<div class='flash-error'>Data gagal disimpan.</div>",
            ));
          }
          exit;
        } catch (Exception $exc) {
          $transaction->rollback();
        }
      } else {
        echo CJSON::encode(
          array(
            'status' => 'proses_form',
            'div' => "<div class='flash-success'>Berhasil merubah data Kelas Pelayanan.</div>",
          )
        );
        exit;
      }
    }

    if (Yii::app()->request->isAjaxRequest) {
      echo CJSON::encode(array(
        'status' => 'create_form',
        'div' => $this->renderPartial($this->path_view . '_formUbahKelasPelayananRI', array('model' => $model), true)
      ));
      exit;
    }
  }

  /*
         * Mencari kelas pelayanan berdasarkan ruangan_id di tabel KelasruanganM
         * and open the template in the editor.
         */
  public function actionSetDropdownKelasPelayanan()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $ruangan_id = $_POST['ruangan_id'];
      if ($ruangan_id) {
        $kelasPelayanan = KelasruanganM::model()->with('kelaspelayanan')->findAll('ruangan_id=' . $ruangan_id . ' and kelaspelayanan_aktif = true');
        $kelasPelayanan = CHtml::listData($kelasPelayanan, 'kelaspelayanan_id', 'kelaspelayanan.kelaspelayanan_nama');
      }
      if (empty($kelasPelayanan)) {
        echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
      } else {
        echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
        foreach ($kelasPelayanan as $value => $name) {
          echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
        }
      }
    }
    Yii::app()->end();
  }

  /**
   * Mengatur dropdown kabupaten
   * @param type $encode jika = true maka return array jika false maka set Dropdown 
   * @param type $model_nama
   * @param type $attr
   */
  public function actionSetDropdownKabupaten($encode = false, $model_nama = '', $attr = '')
  {
    if (Yii::app()->request->isAjaxRequest) {
      $modPasien = new PPPasienM;
      if ($model_nama !== '' && $attr == '') {
        $propinsi_id = $_POST["$model_nama"]['propinsi_id'];
      } elseif ($model_nama == '' && $attr !== '') {
        $propinsi_id = $_POST["$attr"];
      } elseif ($model_nama !== '' && $attr !== '') {
        $propinsi_id = $_POST["$model_nama"]["$attr"];
      }
      $kabupaten = null;
      if ($propinsi_id) {
        $kabupaten = $modPasien->getKabupatenItems($propinsi_id);
        $kabupaten = CHtml::listData($kabupaten, 'kabupaten_id', 'kabupaten_nama');
      }
      if ($encode) {
        echo CJSON::encode($kabupaten);
      } else {
        if (empty($kabupaten)) {
          echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
        } else {
          echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
          foreach ($kabupaten as $value => $name) {
            echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
          }
        }
      }
    }
    Yii::app()->end();
  }
  /**
   * Mengatur dropdown kecamatan
   * @param type $encode jika = true maka return array jika false maka set Dropdown 
   * @param type $model_nama
   * @param type $attr
   */
  public function actionSetDropdownKecamatan($encode = false, $model_nama = '', $attr = '')
  {
    if (Yii::app()->request->isAjaxRequest) {
      $modPasien = new PPPasienM;
      if ($model_nama !== '' && $attr == '') {
        $kabupaten_id = $_POST["$model_nama"]['kabupaten_id'];
      } elseif ($model_nama == '' && $attr !== '') {
        $kabupaten_id = $_POST["$attr"];
      } elseif ($model_nama !== '' && $attr !== '') {
        $kabupaten_id = $_POST["$model_nama"]["$attr"];
      }
      $kecamatan = null;
      if ($kabupaten_id) {
        $kecamatan = $modPasien->getKecamatanItems($kabupaten_id);
        $kecamatan = CHtml::listData($kecamatan, 'kecamatan_id', 'kecamatan_nama');
      }

      if ($encode) {
        echo CJSON::encode($kecamatan);
      } else {
        if (empty($kecamatan)) {
          echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
        } else {
          echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
          foreach ($kecamatan as $value => $name) {
            echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
          }
        }
      }
    }
    Yii::app()->end();
  }
  /**
   * Mengatur dropdown kelurahan
   * @param type $encode jika = true maka return array jika false maka set Dropdown 
   * @param type $model_nama
   * @param type $attr
   */
  public function actionSetDropdownKelurahan($encode = false, $model_nama = '', $attr = '')
  {
    if (Yii::app()->request->isAjaxRequest) {
      $modPasien = new PPPasienM;
      if ($model_nama !== '' && $attr == '') {
        $kecamatan_id = $_POST["$model_nama"]['kecamatan_id'];
      } elseif ($model_nama == '' && $attr !== '') {
        $kecamatan_id = $_POST["$attr"];
      } elseif ($model_nama !== '' && $attr !== '') {
        $kecamatan_id = $_POST["$model_nama"]["$attr"];
      }
      $kelurahan = null;
      if ($kecamatan_id) {
        $kelurahan = $modPasien->getKelurahanItems($kecamatan_id);
        //                    $kelurahan = KelurahanM::model()->findAll('kecamatan_id='.$kecamatan_id.'');
        $kelurahan = CHtml::listData($kelurahan, 'kelurahan_id', 'kelurahan_nama');
      }

      if ($encode) {
        echo CJSON::encode($kelurahan);
      } else {
        if (empty($kelurahan)) {
          echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
        } else {
          echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
          foreach ($kelurahan as $value => $name) {
            echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
          }
        }
      }
    }
    Yii::app()->end();
  }
  /**
   * set dropdown daerah pasien berdasarkan
   * propinsi_id
   * kabupaten_id
   * kecamatan_id
   * kelurahan_id
   * pasien_id
   */
  public function actionSetDropdownDaerahPasien()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      $modPasien = new PPPasienM;
      $propinsi_id = $_POST['propinsi_id'];
      $kabupaten_id = $_POST['kabupaten_id'];
      $kecamatan_id = $_POST['kecamatan_id'];
      $kelurahan_id = (isset($_POST['kelurahan_id']) ? $_POST['kelurahan_id'] : null);

      $propinsis = PropinsiM::model()->findAll('propinsi_aktif = TRUE');
      $propinsis = CHtml::listData($propinsis, 'propinsi_id', 'propinsi_nama');
      $propinsiOption = CHtml::tag('option', array('value' => ''), "-- Pilih --", true);
      foreach ($propinsis as $value => $name) {
        if ($value == $propinsi_id)
          $propinsiOption .= CHtml::tag('option', array('value' => $value, 'selected' => true), CHtml::encode($name), true);
        else
          $propinsiOption .= CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
      }
      $kabupatens = $modPasien->getKabupatenItems($propinsi_id);
      //                $kabupatens = KabupatenM::model()->findAllByAttributes(array('propinsi_id'=>$propinsi_id,'kabupaten_aktif'=>true,));
      $kabupatens = CHtml::listData($kabupatens, 'kabupaten_id', 'kabupaten_nama');
      $kabupatenOption = CHtml::tag('option', array('value' => ''), "-- Pilih --", true);
      foreach ($kabupatens as $value => $name) {
        if ($value == $kabupaten_id)
          $kabupatenOption .= CHtml::tag('option', array('value' => $value, 'selected' => true), CHtml::encode($name), true);
        else
          $kabupatenOption .= CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
      }
      $kecamatans = $modPasien->getKecamatanItems($kabupaten_id);
      //                $kecamatans = KecamatanM::model()->findAllByAttributes(array('kabupaten_id'=>$kabupaten_id,'kecamatan_aktif'=>true,));
      $kecamatans = CHtml::listData($kecamatans, 'kecamatan_id', 'kecamatan_nama');
      $kecamatanOption = CHtml::tag('option', array('value' => ''), "-- Pilih --", true);
      foreach ($kecamatans as $value => $name) {
        if ($value == $kecamatan_id)
          $kecamatanOption .= CHtml::tag('option', array('value' => $value, 'selected' => true), CHtml::encode($name), true);
        else
          $kecamatanOption .= CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
      }
      $kelurahans = $modPasien->getKelurahanItems($kecamatan_id);
      $kelurahans = CHtml::listData($kelurahans, 'kelurahan_id', 'kelurahan_nama');
      $kelurahanOption = CHtml::tag('option', array('value' => ''), "-- Pilih --", true);
      foreach ($kelurahans as $value => $name) {
        if ($value == $kelurahan_id)
          $kelurahanOption .= CHtml::tag('option', array('value' => $value, 'selected' => true), CHtml::encode($name), true);
        else
          $kelurahanOption .= CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
      }

      $dataList['listPropinsi'] = $propinsiOption;
      $dataList['listKabupaten'] = $kabupatenOption;
      $dataList['listKecamatan'] = $kecamatanOption;
      $dataList['listKelurahan'] = $kelurahanOption;

      echo json_encode($dataList);
      Yii::app()->end();
    }
  }

  public function actionListDokterRuangan()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      if (!empty($_POST['idRuangan'])) {
        $idRuangan = $_POST['idRuangan'];
        $data = DokterV::model()->findAllByAttributes(array('ruangan_id' => $idRuangan), array('order' => 'nama_pegawai'));
        $data = CHtml::listData($data, 'pegawai_id', 'NamaLengkap');

        if (empty($data)) {
          $option = CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
        } else {
          $option = CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
          foreach ($data as $value => $name) {
            $option .= CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
          }
        }

        $dataList['listDokter'] = $option;
      } else {
        $dataList['listDokter'] = $option = CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
      }

      echo json_encode($dataList);
      Yii::app()->end();
    }
  }

  public function actionGetPenjaminPasien($encode = false, $namaModel = '')
  {
    if (Yii::app()->request->isAjaxRequest) {
      $carabayar_id = $_POST["$namaModel"]['carabayar_id'];

      if ($encode) {
        echo CJSON::encode($penjamin);
      } else {
        if (empty($carabayar_id)) {
          echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
        } else {
          $penjamin = PenjaminpasienM::model()->findAllByAttributes(array('carabayar_id' => $carabayar_id), array('order' => 'penjamin_nama ASC'));
          if (count((array)$penjamin) > 1) {
            echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
          }
          $penjamin = CHtml::listData($penjamin, 'penjamin_id', 'penjamin_nama');
          foreach ($penjamin as $value => $name) {
            echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
          }
        }
      }
    }
    Yii::app()->end();
  }

  //		public function actionGetListCaraBayar()
  //		{
  //			if(Yii::app()->getRequest()->getIsAjaxRequest()) {
  //				$idCaraBayar = $_POST['idCaraBayar'];
  //
  //				$carabayars = CarabayarM::model()->findAllByAttributes(array('carabayar_aktif'=>true),array('order'=>'carabayar_nama'));
  //				$carabayars = CHtml::listData($carabayars,'carabayar_id','carabayar_nama');
  //				$Option = "";
  //				foreach($carabayars as $value=>$name)
  //				{
  //					if($value==$idCaraBayar)
  //						$Option .= CHtml::tag('option',array('value'=>$value,'selected'=>true),CHtml::encode($name),true);
  //					else
  //						$Option .= CHtml::tag('option',array('value'=>$value),CHtml::encode($name),true);
  //				}
  //
  //				$dataList['listCaraBayar'] = $Option;
  //
  //				$penjamins = PenjaminpasienM::model()->findAllByAttributes(array('carabayar_id'=>$idCaraBayar,'penjamin_aktif'=>true),array('order'=>'penjamin_nama'));
  //				$penjamins = CHtml::listData($penjamins,'penjamin_id','penjamin_nama');
  //				$Option = CHtml::tag('option',array('value'=>''),CHtml::encode('-- Pilih --'),true);
  //				foreach($penjamins as $value=>$name)
  //				{
  //					if($value==$idCaraBayar)
  //						$Option .= CHtml::tag('option',array('value'=>$value,'selected'=>true),CHtml::encode($name),true);
  //					else
  //						$Option .= CHtml::tag('option',array('value'=>$value),CHtml::encode($name),true);
  //				}
  //
  //				$dataList['listPenjamin'] = $Option;
  //
  //				echo json_encode($dataList);
  //				Yii::app()->end();
  //			}
  //		}

  public function actionGetDataPendaftaranRI()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $id_pendaftaran = (isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null);
      $model = InfokunjunganriV::model()->findByAttributes(array('pendaftaran_id' => $id_pendaftaran));
      $attributes = $model->attributeNames();
      foreach ($attributes as $j => $attribute) {
        $returnVal["$attribute"] = $model->$attribute;
      }
      echo json_encode($returnVal);
      Yii::app()->end();
    }
  }

  public function actionGetListPenjamin()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      $idCaraBayar = $_POST['idCaraBayar'];
      $idPenjamin = (isset($_POST['idPenjamin'])) ? $_POST['idPenjamin'] : '';

      $penjamins = PenjaminpasienM::model()->findAllByAttributes(array('carabayar_id' => $idCaraBayar, 'penjamin_aktif' => true), array('order' => 'penjamin_nama'));
      $penjamins = CHtml::listData($penjamins, 'penjamin_id', 'penjamin_nama');
      $Option = "";
      foreach ($penjamins as $value => $name) {
        if ($value == $idPenjamin)
          $Option .= CHtml::tag('option', array('value' => $value, 'selected' => true), CHtml::encode($name), true);
        else
          $Option .= CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
      }

      $dataList['listPenjamin'] = $Option;

      echo json_encode($dataList);
      Yii::app()->end();
    }
  }

  public function actionGetRuanganPasien()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      $pendaftaran_id = (isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null);
      $ruangan_id = (isset($_POST['ruangan_id']) ? $_POST['ruangan_id'] : null);
      $instalasi_id = (isset($_POST['instalasi_id']) ? $_POST['instalasi_id'] : null);
      $pegawai_id = (isset($_POST['pegawai_id']) ? $_POST['pegawai_id'] : null);

      if (isset($_POST['jeniskasuspenyakit_id'])) {
        $jeniskasuspenyakit_id = (isset($_POST['jeniskasuspenyakit_id']) ? $_POST['jeniskasuspenyakit_id'] : null);
        $jenisKasusPenyakit = '';
        $criteria = new CDbCriteria;
        $criteria->select = 't.ruangan_id, t.jeniskasuspenyakit_id, ruangan_m.ruangan_nama, jeniskasuspenyakit_m.jeniskasuspenyakit_nama,
										jeniskasuspenyakit_aktif';
        if (!empty($ruangan_id)) {
          $criteria->addCondition("t.ruangan_id = " . $ruangan_id);
        }
        if (!empty($jeniskasuspenyakit_id)) {
          $criteria->addCondition('t.jeniskasuspenyakit_id = ' . $jeniskasuspenyakit_id);
        }
        $criteria->addCondition('jeniskasuspenyakit_m.jeniskasuspenyakit_aktif is true');
        $criteria->join = 'LEFT JOIN ruangan_m on t.ruangan_id = ruangan_m.ruangan_id
									   LEFT JOIN jeniskasuspenyakit_m on t.jeniskasuspenyakit_id = jeniskasuspenyakit_m.jeniskasuspenyakit_id
										';
        $dataJenisPenyakit = KasuspenyakitruanganM::model()->findAll($criteria);
        //                $dataJenisPenyakit =KasuspenyakitruanganM::model()->findAll('jeniskasuspenyakit_id='.$jeniskasuspenyakit_id.' AND jeniskasuspenyakit_aktif=TRUE ORDER BY jeniskasuspenyakit_nama');

        foreach ($dataJenisPenyakit as $jenisPenyakit) {
          if ($jenisPenyakit['jeniskasuspenyakit_id'] == $jeniskasuspenyakit_id) {
            $jenisKasusPenyakit .= '<option value="' . $jenisPenyakit['jeniskasuspenyakit_id'] . '" selected="selected">' . $jenisPenyakit['jeniskasuspenyakit_nama'] . '</option>';
          } else {
            $jenisKasusPenyakit .= '<option value="' . $jenisPenyakit['jeniskasuspenyakit_id'] . '">' . $jenisPenyakit['jeniskasuspenyakit_nama'] . '</option>';
          }
        }
        $data['jenisKasusPenyakit'] = $jenisKasusPenyakit;
      }


      if (isset($_POST['pegawai_id'])) {
        $pegawai_id = $_POST['pegawai_id'];
        $ruangan_id = $_POST['ruangan_id'];
        $criteria = new CDbCriteria;
        $criteria->select = 't.ruangan_id, t.pegawai_id, t.nama_pegawai';
        if (!empty($ruangan_id)) {
          $criteria->addCondition("t.ruangan_id = " . $ruangan_id);
        }
        if (!empty($jeniskasuspenyakit_id)) {
          $criteria->addCondition("t.pegawai_id = " . $pegawai_id);
        }
        $dataDokter = DokterV::model()->findAll($criteria);
        //                $dataJenisPenyakit =KasuspenyakitruanganM::model()->findAll('jeniskasuspenyakit_id='.$jeniskasuspenyakit_id.' AND jeniskasuspenyakit_aktif=TRUE ORDER BY jeniskasuspenyakit_nama');
        $dokter = '';
        foreach ($dataDokter as $dokters) {
          if ($dokters['pegawai_id'] == $pegawai_id) {
            $dokter .= '<option value="' . $dokters['pegawai_id'] . '" selected="selected">' . $dokters['nama_pegawai'] . '</option>';
          } else {
            $dokter .= '<option value="' . $dokters['pegawai_id'] . '">' . $dokters['nama_pegawai'] . '</option>';
          }
        }
        $data['dokter'] = $dokter;
      }

      $dropDown = '';
      $dataRuangan = RuanganM::model()->findAll('instalasi_id=' . $instalasi_id . ' AND ruangan_aktif=TRUE ORDER BY ruangan_nama');
      foreach ($dataRuangan as $tampilRuangan) {
        if ($tampilRuangan['ruangan_id'] == $ruangan_id) {
          $dropDown .= '<option value="' . $tampilRuangan['ruangan_id'] . '" selected="selected" onchange="getKasusPenyakit(' . $ruangan_id . ')">' . $tampilRuangan['ruangan_nama'] . '</option>';
        } else {
          $dropDown .= '<option value="' . $tampilRuangan['ruangan_id'] . '" onchange="return getKasusPenyakit(' . $ruangan_id . ')">' . $tampilRuangan['ruangan_nama'] . '</option>';
        }
      }
      $data['dropDown'] = $dropDown;
      echo json_encode($data);
      Yii::app()->end();
    }
  }

  public function actionSaveRuanganBaru()
  {
    $updatetindakan = false;
    $pendaftaran_id = $_POST['pendaftaran_id'];
    $pasien_id = $_POST['pasien_id'];
    $ruangan_id = $_POST['ruangan_id'];
    $jeniskasuspenyakit_id = (isset($_POST['jeniskasuspenyakit_id']) ? $_POST['jeniskasuspenyakit_id'] : null);
    $alasan = $_POST['alasan'];
    $ruangan_awal = $_POST['ruangan_awal'];
    $idTindakan = (isset($_POST['idTindakan']) ? $_POST['idTindakan'] : null);
    $tarifSatuan = (isset($_POST['tarifSatuan']) ? $_POST['tarifSatuan'] : null);
    $idKarcis = (isset($_POST['idKarcis']) ? $_POST['idKarcis'] : null);
    $tarifkarcis = (isset($_POST['tarifkarcis']) ? $_POST['tarifkarcis'] : null);
    $kelas = (isset($_POST['kelaspelayanan_id']) ? $_POST['kelaspelayanan_id'] : null);
    $karcisTindakan = (isset($_POST['karcisTindakan']) ? $_POST['karcisTindakan'] : null);
    $modPasien = PasienM::model()->findByPk($pasien_id);
    $model = PendaftaranT::model()->findByPk($pendaftaran_id);
    if (!empty($model->pegawai_id)) {
      $pegawai_id = (isset($_POST['pegawai_id']) ? $_POST['pegawai_id'] : null);
    } else {
      $pegawai_id = (isset($_POST['pegawai_id']) ? $_POST['pegawai_id'] : $model->pegawai_id);
    }

    //            $pegawai_id = (!isset($_POST['pegawai_id']) && ($_POST['pegawai_id'] == 'null') ? $model->pegawai_id : $_POST['pegawai_id']);
    $modRiwayat = new UbahruanganR;
    $modRiwayat->ruanganawal_id = $ruangan_awal;
    $modRiwayat->menjadiruangan_id = $ruangan_id;
    $modRiwayat->alasanperubahan = $alasan;
    $modRiwayat->pendaftaran_id = $pendaftaran_id;
    $modRiwayat->tglperubahan = date('Y-m-d');
    $modRiwayat->pasien_id = $pasien_id;

    $data = array();
    $transaction = Yii::app()->db->beginTransaction();
    try {
      $success = false;
      if ($modRiwayat->validate()) {
        if (isset($_POST['pasienadmisi_id'])) {
          if (PasienadmisiT::model()->updateByPk($_POST['pasienadmisi_id'], array('ruangan_id' => $ruangan_id))) {
            $update = true;
            $success = true;
            $data['status'] = 'OK';
          }
        }

        if ($update && $success) {
          if ($modRiwayat->save()) {
            $data['status'] = 'OK';
          } else {
            $success = false;
            $data['status'] = 'Gagal';
          }
        } else {
          $success = false;
          $data['status'] = 'Gagal';
        }
      } else {
        $data['status'] = 'Gagal';
        echo print_r($modRiwayat->errors, 1);
      }

      if ($success) {
        $transaction->commit();
      } else {
        $transaction->rollback();
      }
    } catch (Exception $exc) {
      $data['status'] = 'Gagal' . $exc;
      $transaction->rollback();
    }

    echo CJSON::encode($data);
    Yii::app()->end();
  }

  public function actionUbahJenisKelamin()
  {
    $model = new PasienM;
    if (isset($_POST['PasienM'])) {
      $model->attributes = $_POST['PasienM'];
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $attributes = array('jeniskelamin' => $_POST['PasienM']['jeniskelamin']);
        $save = PasienM::model()->updateByPk($_POST['PasienM']['pasien_id'], $attributes);
        if ($save) {
          $transaction->commit();
          echo CJSON::encode(array(
            'status' => 'proses_form',
            'div' => "<div class='flash-success'>Berhasil merubah data Jenis Kelamin Pasien.</div>",
          ));
        } else {
          echo CJSON::encode(array(
            'status' => 'proses_form',
            'div' => "<div class='flash-error'>Data gagal disimpan.</div>",
          ));
        }
        exit;
      } catch (Exception $exc) {
        $transaction->rollback();
      }
    }

    if (Yii::app()->request->isAjaxRequest) {
      echo CJSON::encode(array(
        'status' => 'create_form',
        'div' => $this->renderPartial($this->path_view . '_formUbahJenisKelamin', array('model' => $model), true)
      ));
      exit;
    }
  }

  public function actionCariPasien()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $noRM = (isset($_POST['norekammedik']) ? $_POST['norekammedik'] : null);

      $model = PasienM::model()->findByAttributes(array('no_rekam_medik' => $noRM));
      $attributes = $model->attributeNames();
      foreach ($attributes as $j => $attribute) {
        $returnVal["$attribute"] = $model->$attribute;
      }

      echo json_encode($returnVal);
      Yii::app()->end();
    }
  }

  /**
   * @author	M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
   * 
   * - digunakan untuk membuat notifikasi, jika ada perubahan cara bayar
   * @param type $model
   * @return type
   */
  public function notifUbahBayar($model)
  {

    $judul = 'Perubahan Jenis Penjamin & Penjamin';

    if (empty($model->pasienadmisi_id)) {
      $isi = $model->no_pendaftaran . ' ' . $model->pasien->no_rekam_medik . ' ' . $model->pasien->nama_pasien;
      $r = RuanganM::model()->findByPk($model->ruangan_id);

      return CustomFunction::broadcastNotif($judul, $isi, array(
        // array('instalasi_id'=>Params::INSTALASI_ID_KEUANGAN, 'ruangan_id'=> Params::RUANGAN_ID_KASIR, 'modul_id'=>Params::MODUL_ID_BILLINGKASIR ),											   
        array('instalasi_id' => $r->instalasi_id, 'ruangan_id' => $r->ruangan_id, 'modul_id' => $r->modul_id),
      ));
    } else {
      $isi = $model->pendaftaran->no_pendaftaran . ' ' . $model->pasien->no_rekam_medik . ' ' . $model->pasien->nama_pasien;
      $r = RuanganM::model()->findByPk($model->ruangan_id);

      return CustomFunction::broadcastNotif($judul, $isi, array(
        // array('instalasi_id'=>Params::INSTALASI_ID_KEUANGAN, 'ruangan_id'=> Params::RUANGAN_ID_KASIR, 'modul_id'=>Params::MODUL_ID_BILLINGKASIR ),											   
        array('instalasi_id' => $r->instalasi_id, 'ruangan_id' => $r->ruangan_id, 'modul_id' => $r->modul_id),
      ));
    }
  }
  function simpanKirimRMPindahKamar($modPasienAdmisi, $modPindahKamar)
  {

    $ok = true;
    $pendaftaran = PendaftaranT::model()->findByPk($modPasienAdmisi->pendaftaran_id);
    $kirim_lama = PengirimanrmT::model()->findByPk($pendaftaran->pengirimanrm_id);
    $ruangan = RuanganM::model()->findByPk($modPindahKamar->ruangan_id);

    if (!empty($kirim_lama)) {
      $kirim = new PengirimanrmT;
      $kirim->pasien_id = $modPasienAdmisi->pasien_id;
      $kirim->pendaftaran_id = $modPasienAdmisi->pendaftaran_id;
      $kirim->dokrekammedis_id = $kirim_lama->dokrekammedis_id;
      $kirim->tglpengirimanrm = date('Y-m-d H:i:s');
      $kirim->petugaspengirim = Yii::app()->user->name;
      $kirim->petugaspengirim_id = Yii::app()->user->getState('pegawai_id');
      $kirim->ruangan_id = $modPindahKamar->ruangan_id;
      $kirim->instalasi_id = $ruangan->instalasi_id;
      $kirim->nourut_keluar = MyGenerator::noUrutKeluarRM();
      $kirim->kelengkapandokumen = TRUE;
      $kirim->create_time = date('Y-m-d H:i:s');
      $kirim->create_loginpemakai_id = Yii::app()->user->id;
      $kirim->create_ruangan = Yii::app()->user->getState('ruangan_id');
      $kirim->ruanganpengirim_id = Yii::app()->user->getState('ruangan_id');
      $kirim->ruanganpenerima_id = $modPindahKamar->ruangan_id;

      if ($kirim->validate()) {
        $ok = $ok && $kirim->save();

        $pendaftaran->pengirimanrm_id = $kirim->pengirimanrm_id;
        $pendaftaran->statusdokrm = 'SUDAH DIKIRIM';

        $ok = $ok && $pendaftaran->save();
      } else $ok = false;
    }

    return $ok;

    //var_dump($pendaftaran->attributes, $kirim_lama->attributes, $ok, $kirim->attributes, $modPasienAdmisi->attributes, $modPindahKamar->attributes); die;


  }

  private function updateObatpasien($post, $daftar)
  {
    $ok = true;

    $instalasi = $daftar->instalasi_id;
    $oa = $post->obatalkes;

    $konfigFarmasi = KonfigfarmasiK::model()->find();
    if ($instalasi == Params::INSTALASI_ID_RI) {
      $post->ppnpersen = $konfigFarmasi->ri_persjualppn;
    }
    $post->jumlahppn = 0;

    $konfigFarmasi = KonfigfarmasiK::model()->find();
    if ($konfigFarmasi->ishargaperpenjamin == true) {
      if (!empty($daftar->penjamin_id)) {
        if ($oa->jenisobatalkes_id !== Params::JENISOBATALKES_ID_BHP && $oa->jenisobatalkes_id !== Params::JENISOBATALKES_ID_ALKES) {

          $obatalkesPenjamin = ObatalkespenjaminM::model()->findByAttributes(array('jenisobatalkes_id' => $oa->jenisobatalkes_id, 'penjamin_id' => $daftar->penjamin_id), array('select' => 'persmargin, biayaadministrasi, persdiskon'));

          if (!empty($obatalkesPenjamin)) {
            $marginRp = 0;
            if ($obatalkesPenjamin->persmargin > 0) {
              $marginRp = round((($oa->hpp * $obatalkesPenjamin->persmargin) / 100), 2);
            }
            $hargaSatuan = round(($oa->hpp + $marginRp), 2);
            $post->hargasatuan_oa = $hargaSatuan;
            $post->biayaadministrasi = $obatalkesPenjamin->biayaadministrasi;
            $post->persen_discount = $obatalkesPenjamin->persdiskon;
          }
        }
      }
    }
    $format = new MyFormatter();
    $post->tglpelayanan = $format->formatDateTimeForDb($post->tglpelayanan);
    $post->create_time = $format->formatDateTimeForDb($post->create_time);
    $post->update_time = $format->formatDateTimeForDb($post->update_time);
    $post->hargajual_oa = $post->qty_oa * $post->hargasatuan_oa;
    $post->totalbiayaadministrasi = ($post->biayaadministrasi * $post->qty_oa);
    $post->discount = 0;
    if ($post->persen_discount > 0) {
      $post->discount = (($post->hargajual_oa + $post->totalbiayaadministrasi) * $post->persen_discount) / 100;
    }

    $post->jumlahppn = 0;
    if ($post->ppnpersen > 0) {
      $post->jumlahppn = ((($post->hargajual_oa + $post->totalbiayaadministrasi) - $post->discount) * $post->ppnpersen) / 100;
    }

    // $post->ppnperobat = 0;
    // if ($post->jumlahppn > 0) {
    //   $post->ppnperobat = $post->jumlahppn / $post->qty_oa;
    // }

    $post->hargajual_oa = $post->hargajual_oa + $post->totalbiayaadministrasi - $post->discount + $post->jumlahppn;
    $post->iurbiaya = $post->hargajual_oa;

    $formula = FormulariumobatM::model()->findByAttributes([
      'obatalkes_id' => $post->obatalkes_id,
      'penjamin_id' => $daftar->penjamin_id
    ], ['select' => 'formulariumobat_id']);
    $post->formulariumobat_id = !empty($formula) ? $formula->formulariumobat_id : null;

    if ($post->update()) {
      $ok = true;
    } else {
      $ok = false;
    }


    return $ok;
  }

  public function actionAutocompleteAsuransi()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter();
      $returnVal = array();
      $nopeserta = isset($_GET['nopeserta']) ? $_GET['nopeserta'] : '';
      $penjamin_id = isset($_GET['penjamin_id']) ? $_GET['penjamin_id'] : null;
      $pasien_id = isset($_GET['pasien_id']) ? $_GET['pasien_id'] : null;
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(nopeserta)', strtolower($nopeserta), true);
      $criteria->addCondition('penjamin_id=' . $penjamin_id);
      $criteria->addCondition('asuransipasien_aktif is true');
      if ($_GET['pasien_id'] == "") {
        $criteria->addCondition('pasien_id is null');
      } else {
        $criteria->addCondition('pasien_id=' . $pasien_id);
      }
      $criteria->order = 'namapemilikasuransi';
      $criteria->limit = 5;
      $models = PPAsuransipasienM::model()->findAll($criteria);
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->nopeserta . ' - ' . $model->namapemilikasuransi;
        $returnVal[$i]['value'] = $model->nopeserta;
        $returnVal[$i]['asuransipasien_id'] = $model->asuransipasien_id;
        $returnVal[$i]['nokartuasuransi'] = $model->nokartuasuransi;
        $returnVal[$i]['namapemilikasuransi'] = $model->namapemilikasuransi;
        $returnVal[$i]['jenispeserta_id'] = $model->jenispeserta_id;
        $returnVal[$i]['nomorpokokperusahaan'] = $model->nomorpokokperusahaan;
        $returnVal[$i]['namaperusahaan'] = $model->namaperusahaan;
        $returnVal[$i]['kelastanggunganasuransi_id'] = $model->kelastanggunganasuransi_id;
      }


      echo CJSON::encode($returnVal);
    } else
      throw new CHttpException(403, 'Tidak dapat mengurai data');
    Yii::app()->end();
  }

  public function actionBpjsInterface()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      if (empty($_GET['param']) or $_GET['param'] === '') {
        die('param can\'not empty value');
      } else {
        $param = $_GET['param'];
      }

      //                if(empty( $_GET['server'] ) OR $_GET['server'] === ''){
      //                    
      //                }else{
      //                    $server = 'http://'.$_GET['server'];
      //                }

      $bpjs = new Bpjs();

      switch ($param) {
        case '1':
          $query = $_GET['query'];
          print_r($bpjs->search_kartu($query));
          break;
        case '2':
          $query = $_GET['query'];
          print_r($bpjs->search_nik($query));
          break;
        case '3':
          $query = $_GET['query'];
          print_r($bpjs->search_rujukan_no_rujukan($query));
          break;
        case '4':
          $query = $_GET['query'];
          print_r($bpjs->search_rujukan_no_bpjs($query));
          break;
        case '5':
          $query = $_GET['query'];
          $start = $_GET['start'];
          $limit = $_GET['limit'];
          print_r($bpjs->list_rujukan_tanggal($query, $start, $limit));
          break;
        case '6':
          $nokartu = $_GET['no_kartu'];
          $tglsep = $_GET['tgl_sep'];
          $tglrujukan = $_GET['tgl_rujukan'];
          $norujukan = $_GET['no_rujukan'];
          $ppkrujukan = $_GET['ppk_rujukan'];
          $ppkpelayanan = $_GET['ppk_pelayanan'];
          $jnspelayanan = $_GET['jns_pelayanan'];
          $catatan = $_GET['catatan'];
          $diagawal = $_GET['diag_awal'];
          $politujuan = $_GET['poli_tujuan'];
          $klsrawat = $_GET['kls_rawat'];
          $user = $_GET['user'];
          $nomr = $_GET['no_mr'];
          $notrans = $_GET['no_trans'];
          print_r($bpjs->create_sep($nokartu, $tglsep, $tglrujukan, $norujukan, $ppkrujukan, $ppkpelayanan, $jnspelayanan, $catatan, $diagawal, $politujuan, $klsrawat, $user, $nomr, $notrans));
          break;
        case '7':
          $nosep = $_GET['nosep'];
          $tglpulang = $_GET['tglpulang'];
          $ppkpelayanan = $_GET['ppkpelayanan'];
          print_r($bpjs->update_tanggal_pulang_sep($nosep, $tglpulang, $ppkpelayanan));
          break;
        case '8':
          $nosep = $_GET['nosep'];
          $notrans = $_GET['notrans'];
          $ppkpelayanan = $_GET['ppkpelayanan'];
          print_r($bpjs->mapping_trans($nosep, $notrans, $ppkpelayanan));
          break;
        case '9':
          $nosep = $_GET['nosep'];
          $ppkpelayanan = $_GET['ppkpelayanan'];
          print_r($bpjs->delete_transaksi($nosep, $ppkpelayanan));
          break;
        case '10':
          $nokartu = $_GET['nokartu'];
          print_r($bpjs->riwayat_terakhir($nokartu));
          break;
        case '11':
          $nosep = $_GET['nosep'];
          print_r($bpjs->detail_sep($nosep));
          break;
        case '12':
          $ppkpelayanan = $_GET['ppkrujukan'];
          $start = $_GET['start'];
          $limit = $_GET['limit'];
          print_r($bpjs->detail_ppk_rujukan($ppkpelayanan, $start, $limit));
          break;
        case '99':
          $bpjs->identity_magic();
          break;
        case '100':
          print_r($bpjs->help());
          break;
        default:
          die('error number, please check your parameter option');
          break;
      }
      Yii::app()->end();
    }
  }

  public function actionVerifikasiRencanaPulang()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $pendaftaran_id = $_POST['pendaftaran_id'];
      $status = isset($_POST['status']) ? $_POST['status'] : null;
      $data['pesan'] = '';
      $data['verifikasinull'] = '';
      $data['isalert'] = 0;
      $modRencanaTindakan = RencanatindakanT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id), array('order' => 'rencanatindakan_id DESC'));
      if (!empty($modRencanaTindakan)) {
        $data['status'] = true;
        $data['pesan'] = "";
        if (empty($modRencanaTindakan->verifrenctindakan_id)) {
          $data['verifikasinull'] = 'ya';
          $data['pesan'] = "Tindakan Pasien Belum Di-Verifikasi";
        }
      } else {
        if (empty($status)) {

          $data = $this->verifikasiTindakanRawatInap($pendaftaran_id, $data);
        } else {
          $data['status'] = true;
          $data['pesan'] = '';
        }
      }
      echo json_encode($data);
      Yii::app()->end();
    }
  }

  public function actionTindakLanjutDariPasienRI($pendaftaran_id, $melarikandiri = 0, $meninggal = 0)
  {
    $this->layout = '//layouts/iframe';

    $modelPulang = new RIPasienPulangT;
    $modRujukanKeluar = new RIPasienDirujukKeluarT;
    $modPendaftaran = RIPendaftaranT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));
    $modPasienRIV = RIInfopasienmasukkamarV::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));
    $admisi = PasienadmisiT::model()->findByPk($modPendaftaran->pasienadmisi_id);
    $modTariftindakan = TariftindakanM::model()->findByAttributes(array('kelaspelayanan_id' => $modPasienRIV->kelaspelayanan_id));
    $modMasukKamar = RIMasukKamarT::model()->findByPk($modPasienRIV->masukkamar_id);
    $modMasukKamarPertama = MasukkamarT::model()->findByAttributes(array(
      'pasienadmisi_id' => $admisi->pasienadmisi_id,
      // 'pindahkamar_id'=>null
    ), array(
      'order' => 'create_time asc',
    ));
    $modPasienKirimUnit = PasienkirimkeunitlainT::model()->findAllByAttributes(array('pendaftaran_id' => $pendaftaran_id, 'pasienmasukpenunjang_id' => null));
    $modelPulang->pendaftaran_id = $modPasienRIV->pendaftaran_id;
    $modelPulang->pasien_id = $modPasienRIV->pasien_id;
    $modelPulang->pasienadmisi_id = $modPasienRIV->pasienadmisi_id;
    $modelPulang->tglpasienpulang = empty($admisi->rencanapulang) ? date('Y-m-d H:i:s') : $admisi->rencanapulang;
    $modMasukKamar->tglkeluarkamar = date('Y-m-d', strtotime($modelPulang->tglpasienpulang));
    $modMasukKamar->jamkeluarkamar = date('H:i:s', strtotime($modelPulang->tglpasienpulang));
    $modRujukanKeluar->ruanganasal_id = Yii::app()->user->getState('ruangan_id');
    $modRujukanKeluar->tgldirujuk = date('Y-m-d H:i:s');
    $tersimpan = 'Tidak';
    $modelPulang->keterangankeluar = null;

    if ($melarikandiri == 1) {
      $modelPulang->carakeluar_id = Params::CARAKELUAR_ID_MELARIKANDIRI;
    }

    if ($meninggal == 1) {
      $modelPulang->carakeluar_id = Params::CARAKELUAR_ID_MENINGGAL;
    }

    $cekPembayaran = (PasienpulangT::model()->cekSisaPembayaran($pendaftaran_id) == false) ? 'ada' : 'tidak';


    $nama_modul = Yii::app()->controller->module->id;
    $nama_controller = Yii::app()->controller->id;
    $nama_action = Yii::app()->controller->action->id;
    $modul_id = ModulK::model()->findByAttributes(array('url_modul' => $nama_modul))->modul_id;
    $criteria = new CDbCriteria;
    $criteria->compare('modul_id', $modul_id);
    $criteria->compare('LOWER(modcontroller)', strtolower($nama_controller), true);
    $criteria->compare('LOWER(modaction)', strtolower($nama_action), true);
    if (isset($_POST['tujuansms'])) {
      $criteria->addInCondition('tujuansms', $_POST['tujuansms']);
    }
    $modSmsgateway = SmsgatewayM::model()->findAll($criteria);
    $smspasien = 1;

    $format = new MyFormatter();
    //Hitung lama rawat                
    $modMasukKamar->tglmasukkamar = $format->formatDateTimeForDb($modMasukKamar->tglmasukkamar);

    $admisi->tgladmisi = $format->formatDateTimeForDb($admisi->tgladmisi);

    // $selisihHari = CustomFunction::hitungHari(date('Y-m-d', strtotime($modMasukKamarPertama->tglmasukkamar)), $modelPulang->tglpasienpulang);
    $selisihHari = CustomFunction::hitungHari(date('Y-m-d', strtotime($admisi->tgladmisi)), $modelPulang->tglpasienpulang);

    //Hitung hari rawat
    // $selisihHariRawat = CustomFunction::hitungHariRawat(date('Y-m-d', strtotime($modMasukKamarPertama->tglmasukkamar)), $modelPulang->tglpasienpulang);
    $selisihHariRawat = CustomFunction::hitungHariRawat(date('Y-m-d', strtotime($admisi->tgladmisi)), $modelPulang->tglpasienpulang);

    $modMasukKamar->lamadirawat_kamar = $selisihHari;
    $modelPulang->hariperawatan = $selisihHariRawat;

    $pen = PendaftaranT::model()->findByPk($pendaftaran_id);
    $modUbahStatus = new PengirimanrmT;
    $modUbahStatus->tglpengirimanrm = date('d/m/Y H:i:s');
    $modUbahStatus->petugaspengirim = Yii::app()->user->name;
    $modUbahStatus->petugaspengirim_id = Yii::app()->user->getState('pegawai_id');
    $modUbahStatus->ruangan_id = Params::RUANGAN_ID_REKAM_MEDIS;
    $modUbahStatus->instalasi_id = Params::INSTALASI_ID_RM;
    //if ($_POST["RDPasienPulangT"]['carakeluar_id'] != Params::CARAKELUAR_ID_RAWATINAP){
    if (!empty($pen->pengirimanrm_id)) {
      if (Yii::app()->user->getState('ruangan_id') == $pen->pengirimanrm->ruanganpenerima_id) {
        if (empty($pen->pengirimanrm->tglterimadokrm)) {
          $modUbahStatus->statusdokrm = 'belum-diterima';
        } else {
          $modUbahStatus->statusdokrm = 'belum-dikembalikan';
        }
      }
    }
    //}else{
    //	$modUbahStatus->statusdokrm = '';
    //}		 


    //                if(empty($modPasienRIV->kamarruangan_nokamar)){ 
    ////                    echo "kamarruangan tidak  ada";
    ////                              myAlert('Silakan Isi No. Kamar Terlebih Dahulu');
    //                    echo "<script>
    //                                window.top.location.href='".Yii::app()->createUrl('rawatInap/PasienRawatInap/index')."';
    //                            </script>";
    //                }else{
    ////                    echo "kamarruangan ada";
    //                }
    $modRenKontrol = new RIRencanakontrolR;

    if (isset($_POST['RIPasienPulangT'])) {
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $modMasukKamar = RIMasukKamarT::model()->findByPk($_POST['RIMasukKamarT']['masukkamar_id']);
        $this->updateMasukKamar($modMasukKamar, $_POST['RIMasukKamarT']);
        if (!isset($modTariftindakan->harga_tariftindakan)) {
          throw new CException("Maaf, Harga Tarif Kamar Rawat Inap Belum Ada. Silakan Hubungi Bagian Administrasi");
        } else {
          $modelPulang = $this->savePasienPulang($modMasukKamar, $modelPulang, $_POST['RIPasienPulangT'], $_POST['RIPasienPulangT']['pasienadmisi_id']);
        }


        $modPendaftaran = RIPendaftaranT::model()->findByPk($modelPulang->pendaftaran_id);
        $this->updatePendaftaran($modPendaftaran, $modelPulang);

        $modPasienAdmisi = RIPasienAdmisiT::model()->findByPk($modelPulang->pasienadmisi_id);
        $this->updatePasienAdmisi($modPasienAdmisi, $modelPulang);


        // if ($this->checkBayarLunasRI($modPendaftaran) && );

        if (isset($_POST['pakeRujukan']) && $_POST['pakeRujukan'] == '1') //Jika Pake Rujukan
        {
          //var_dump($_POST['pakeRujukan']);die;
          $this->successRujukanKeluar = false;
          $modelPulang->pakeRujukan = true;
          $modRujukanKeluar = $this->saveRujukanKeluar($modRujukanKeluar, $modelPulang, $_POST['RIPasienDirujukKeluarT']);
        }


        //var_dump($modRujukanKeluar->getErrors());die;
        if ((isset($_POST['isDead']) && $_POST['isDead'] == '1') || $modelPulang->carakeluar_id == Params::CARAKELUAR_ID_MENINGGAL) //Jika Pasien Meninggal
        {
          $modelPulang->isDead;
          $this->successPaseinM = false;
          $modPasien = RIPasienM::model()->findByPk($modelPulang->pasien_id);
          $modPasien->tgl_meninggal = $format->formatDateTimeForDb($_POST['RIPasienPulangT']['tgl_meninggal']);

          if ($modPasien->save()) {
            $this->successPaseinM = true;
          } else {
            $this->successPaseinM = false;
          }
        }

        $this->updateSEPPulang($modPendaftaran, $modelPulang);
        // fungsi simpan rencana kontrol start
        if (isset($_POST['RIRencanakontrolR'])) {
          $this->saveRencanaKontrol($modRenKontrol, $modelPulang, $_POST['RIRencanakontrolR']);
        }
        // end
        if (
          $this->successUpdateMasukKamar && $this->successPasienPulang
          && $this->successUpdatePendaftaran && $this->successUpdatePasienAdmisi
          && $this->successRujukanKeluar && $this->successPaseinM
        ) {
          // SMS GATEWAY
          $modPasien = $modPendaftaran->pasien;
          $modCaraKeluar = $modelPulang->carakeluar;
          $modKondisiKeluar = $modelPulang->kondisikeluar;
          /*
					$sms = new Sms();
					foreach ($modSmsgateway as $i => $smsgateway) {
						$isiPesan = $smsgateway->templatesms;

						$attributes = $modPasien->getAttributes();
						foreach($attributes as $attributes => $value){
							$isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
						}
						$attributes = $modCaraKeluar->getAttributes();
						foreach($attributes as $attributes => $value){
							$isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
						}
						$attributes = $modKondisiKeluar->getAttributes();
						foreach($attributes as $attributes => $value){
							$isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
						}
						$attributes = $modelPulang->getAttributes();
						foreach($attributes as $attributes => $value){
							$isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
						}
						$isiPesan = str_replace("{{hari}}",MyFormatter::getDayName($modelPulang->tglpasienpulang),$isiPesan);

						if($smsgateway->tujuansms == Params::TUJUANSMS_PASIEN && $smsgateway->statussms){
							if(!empty($modPasien->no_mobile_pasien)){
								$sms->kirim($modPasien->no_mobile_pasien,$isiPesan);
							}else{
								$smspasien = 0;
							}
						}
					}
					 * 
					 */
          // END SMS GATEWAY
          // die;
          /** AWAL - Notifikasi Pasien Pulang */

          $rgizi = RuanganM::model()->findAll(" ruangan_aktif = TRUE AND instalasi_id = " . Params::INSTALASI_ID_GIZI);
          $arrgizi = [];
          if (!empty($rgizi)) {
            foreach ($rgizi as $key => $val) {
              $arrgizi[] = [
                'instalasi_id' => $val->instalasi_id,
                'ruangan_id' => $val->ruangan_id,
                'modul_id' => $val->modul_id
              ];
            }
          }
          if (!empty($_POST['RIPendaftaranT']['ruangankontrol_id'])) {
            $r = RuanganM::model()->findByPk($_POST['RIPendaftaranT']['ruangankontrol_id']);

            $judul = 'Pasien Rencana Kontrol';
            //$isi =  'Pasien '.$modPasien->nama_pasien. ' dengan nomor rekam medik '.$modPasien->no_rekam_medik.'<br/> telah membuat rencana kontrol untuk tanggal '.MyFormatter::formatDateTimeForUser($_POST['RIPendaftaranT']['tglrenkontrol']).
            //      ' ke ruangan '.$r->ruangan_nama;
            $isi = $modPasien->no_rekam_medik . ' ' . $modPasien->namadepan . ' ' . $modPasien->nama_pasien . ' '
              .  MyFormatter::formatDateTimeForUser($_POST['RIPendaftaranT']['tglrenkontrol']) . ' ' . $r->ruangan_nama . ' ';

            $ok = CustomFunction::broadcastNotif($judul, $isi, array(
              array('instalasi_id' => Params::INSTALASI_ID_RJ, 'ruangan_id' => $_POST['RIPendaftaranT']['ruangankontrol_id'], 'modul_id' => Params::MODUL_ID_RJ),
              array('instalasi_id' => Params::INSTALASI_ID_RM, 'ruangan_id' => Params::RUANGAN_ID_LOKET, 'modul_id' => Params::MODUL_ID_PENDAFTARAN),
            ));
            // var_dump(5, $ok);
          }

          if ($modelPulang->carakeluar_id == Params::CARAKELUAR_ID_MENINGGAL) {
            $this->notifPasienMeninggal($modPasien, $modelPulang, $arrgizi);
          }

          if ($modelPulang->carakeluar_id != Params::CARAKELUAR_ID_DIRUJUK) {
            if ($modelPulang->carakeluar_id == Params::CARAKELUAR_ID_DIPULANGKAN) {
              $judul = 'Pasien Pulang';
            } else {
              $judul = 'Pasien ' . $modCaraKeluar->carakeluar_nama;
            }
            $isi = $modPasien->no_rekam_medik . ' ' . $modPasien->namadepan . ' ' . $modPasien->nama_pasien . ' '
              .  'Pasien ' . strtoupper($modCaraKeluar->carakeluar_nama) . ' dengan kondisi ' . $modKondisiKeluar->kondisikeluar_nama . ' '
              . MyFormatter::formatDateTimeForUser($modelPulang->tglpasienpulang) . ' ' . $modMasukKamar->kamarruangan->kamarruangan_nokamar . ' ' . $modMasukKamar->kamarruangan->kamarruangan_nobed;
            $ok = true;
            if ($modelPulang->carakeluar_id == Params::CARAKELUAR_ID_DIPULANGKAN) {
              $ok = CustomFunction::broadcastNotif($judul, $isi, array(
                array('instalasi_id' => Params::INSTALASI_ID_FARMASI, 'ruangan_id' => Params::RUANGAN_ID_APOTEK_1, 'modul_id' => Params::MODUL_ID_APOTEK),
              ));
            }
            // var_dump(2, $ok);

            $ok = CustomFunction::broadcastNotif($judul, $isi, array(
              //array('instalasi_id'=>Params::INSTALASI_ID_KEUANGAN, 'ruangan_id'=> Params::RUANGAN_ID_KASIR, 'modul_id'=>Params::MODUL_ID_BILLINGKASIR ),							
              array('instalasi_id' => Params::INSTALASI_ID_RM, 'ruangan_id' => Params::RUANGAN_ID_LOKET, 'modul_id' => Params::MODUL_ID_PENDAFTARAN),
              array('instalasi_id' => Yii::app()->user->getState('instalasi_id'), 'ruangan_id' => Yii::app()->user->getState('ruangan_id'), 'modul_id' => Yii::app()->session['modul_id']),
            ));

            if (!empty($arrgizi)) {
              $ok = CustomFunction::broadcastNotif($judul, $isi, $arrgizi);
            }
          } else {
            $judul = 'Pasien Dirujuk';
            //var_dump($modRujukanKeluar->attributes);die;
            $isi = $modPasien->no_rekam_medik . ' ' . $modPasien->namadepan . ' ' . $modPasien->nama_pasien . ' '
              .  'Pasien ' . strtoupper($modCaraKeluar->carakeluar_nama) . ' dengan kondisi ' . $modKondisiKeluar->kondisikeluar_nama //.' ke '.$modRujukanKeluar->rujukankeluar->rumahsakitrujukan.' '
              . MyFormatter::formatDateTimeForUser($modelPulang->tglpasienpulang) . ' ' . $modMasukKamar->kamarruangan->kamarruangan_nokamar . ' ' . $modMasukKamar->kamarruangan->kamarruangan_nobed;
            $ok = CustomFunction::broadcastNotif($judul, $isi, array(
              //array('instalasi_id'=>Params::INSTALASI_ID_KEUANGAN, 'ruangan_id'=> Params::RUANGAN_ID_KASIR, 'modul_id'=>Params::MODUL_ID_BILLINGKASIR ),							
              array('instalasi_id' => Params::INSTALASI_ID_RM, 'ruangan_id' => Params::RUANGAN_ID_LOKET, 'modul_id' => Params::MODUL_ID_PENDAFTARAN),
              array('instalasi_id' => Yii::app()->user->getState('instalasi_id'), 'ruangan_id' => Yii::app()->user->getState('ruangan_id'), 'modul_id' => Yii::app()->session['modul_id']),
            ));
            // var_dump(2, $ok);
          }

          if (isset($_POST['PengirimanrmT']) && $melarikandiri != 1 && $meninggal != 1) {
            $ok = $ok && $this->simpanPengirimanDokRM($modPendaftaran, $_POST['PengirimanrmT'], $modPasien->dokrekammedis_id);
          }

          /** AKHIR - Notifikasi Pasien Pulang */

          // var_dump(3, $ok); die;

          if (isset($_POST['is_whatsapp']) && $_POST['is_whatsapp'] = "Ya") {
            $this->kirimWhatsapp($modelPulang);
            //                        echo "Kick";
          }
          //            die;

          $transaction->commit();
          Yii::app()->user->setFlash('success', "Data Berhasil disimpan");
          $tersimpan = 'Ya';
        } else {
          if ($this->successUpdateMasukKamar == false) {
            Yii::app()->user->setFlash('error', "Data Masuk Kamar gagal disimpan");
          } else if ($this->successPasienPulang == false) {
            Yii::app()->user->setFlash('error', "Data Pasien Pulang gagal disimpan");
          } else if ($this->successUpdatePendaftaran == false) {
            Yii::app()->user->setFlash('error', "Data pendaftaran gagal disimpan");
          } else if ($this->successUpdatePasienAdmisi == false) {
            Yii::app()->user->setFlash('error', "Data Pasien Admisi gagal disimpan");
          } else if ($this->successRujukanKeluar == false) {
            Yii::app()->user->setFlash('error', "Data Rujukan Keluar gagal disimpan");
          } else if ($this->successPaseinM == false) {
            Yii::app()->user->setFlash('error', "Data Pasien disimpan");
          }
        }
      } catch (CException $cexc) {
        $transaction->rollback();
        if (YII_DEBUG == true)
          Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($cexc, true, true));
        else
          Yii::app()->user->setFlash('error', "Data gagal disimpan. " . $cexc->getMessage());
      } catch (Exception $exc) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
      }
    }

    $modMasukKamar->tglmasukkamar = Yii::app()->dateFormatter->formatDateTime(
      CDateTimeParser::parse($modMasukKamar->tglmasukkamar, 'yyyy-MM-dd hh:mm:ss')
    );
    $modMasukKamar->tglkeluarkamar = Yii::app()->dateFormatter->formatDateTime(
      CDateTimeParser::parse($modMasukKamar->tglkeluarkamar, 'yyyy-MM-dd'),
      'medium',
      false
    );
    $modelPulang->tglpasienpulang = Yii::app()->dateFormatter->formatDateTime(
      CDateTimeParser::parse($modelPulang->tglpasienpulang, 'yyyy-MM-dd hh:mm:ss')
    );
    $modRujukanKeluar->tgldirujuk = Yii::app()->dateFormatter->formatDateTime(
      CDateTimeParser::parse($modRujukanKeluar->tgldirujuk, 'yyyy-MM-dd hh:mm:ss')
    );
    if (!empty($modPendaftaran->pegawai_id)) {
      $modRujukanKeluar->pegawai_id = $modPendaftaran->pegawai_id;
      $modRujukanKeluar->ruanganasal_id = $modMasukKamar->ruangan_id;
    }

    $this->render('formTindakLanjutDariPasienRI', array(
      'modelPulang' => $modelPulang,
      'modRujukanKeluar' => $modRujukanKeluar,
      'modPasienRIV' => $modPasienRIV,
      'modMasukKamar' => $modMasukKamar,
      'modTariftindakan' => $modTariftindakan,
      'tersimpan' => $tersimpan,
      'smspasien' => $smspasien,
      'modPendaftaran' => $modPendaftaran,
      'modUbahStatus' => $modUbahStatus,
      'cekPembayaran' => $cekPembayaran,
      'modRenKontrol' => $modRenKontrol
    ));
  }

  public function actionSetDropDownKondisiKeluar($encode = false, $model_nama = '', $attr = '')
  {
    if (Yii::app()->request->isAjaxRequest) {
      $model = new RIPasienPulangT;
      if ($model_nama !== '' && $attr == '') {
        $carakeluar_id = $_POST["$model_nama"]['carakeluar_id'];
      } elseif ($model_nama == '' && $attr !== '') {
        $carakeluar_id = $_POST["$attr"];
      } elseif ($model_nama !== '' && $attr !== '') {
        $carakeluar_id = $_POST["$model_nama"]["$attr"];
      }
      $kondisikeluar = null;
      if ($carakeluar_id) {
        $kondisikeluar = $model->getKondisikeluarItems($carakeluar_id);
        $kondisikeluar = CHtml::listData($kondisikeluar, 'kondisikeluar_id', 'kondisikeluar_nama');
      }
      if ($encode) {
        echo CJSON::encode($kondisikeluar);
      } else {
        if (empty($kondisikeluar)) {
          echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
        } else {
          echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
          foreach ($kondisikeluar as $value => $name) {
            echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
          }
        }
      }
    }
    Yii::app()->end();
  }

  protected function updateMasukKamar($modMasukKamar, $attrMasukKamar)
  {
    $format = new MyFormatter();
    $modMasukKamar->attributes = $attrMasukKamar;
    $modMasukKamar->tglmasukkamar = $format->formatDateTimeForDb(trim($attrMasukKamar['tglmasukkamar']));
    $modMasukKamar->tglkeluarkamar  = $format->formatDateTimeForDb(trim($attrMasukKamar['tglkeluarkamar']) . ' ' . $attrMasukKamar['jamkeluarkamar']);
    if ($modMasukKamar->save()) {
      $this->successUpdateMasukKamar = true;
    } else {
      $this->successUpdateMasukKamar = false;
    }
  }

  protected function savePasienPulang($modMasukKamar, $modPasienPulang, $attrPasienPulang, $pasienadmisi_id = '')
  {
    $format = new MyFormatter();
    $modelPulangNew = new RIPasienPulangT;
    $modelPulangNew->attributes = $attrPasienPulang;
    $modelPulangNew->carakeluar_id = $attrPasienPulang['carakeluar_id'];
    $modelPulangNew->kondisikeluar_id = $attrPasienPulang['kondisikeluar_id'];
    $modelPulangNew->tglpasienpulang = $format->formatDateTimeForDb(trim($attrPasienPulang['tglpasienpulang']));
    $modelPulangNew->tgl_meninggal = (isset($attrPasienPulang['tgl_meninggal']) ? $format->formatDateTimeForDb(trim($attrPasienPulang['tgl_meninggal'])) : null);
    $modelPulangNew->lamarawat = $modMasukKamar->lamadirawat_kamar;
    $modelPulangNew->satuanlamarawat = Params::SATUAN_LAMARAWAT_RI;
    $modelPulangNew->ruanganakhir_id = Yii::app()->user->getState('ruangan_id');
    $modelPulangNew->create_time = date('Y-m-d H:i:s');
    $modelPulangNew->update_time = date('Y-m-d H:i:s');
    $modelPulangNew->create_ruangan = Yii::app()->user->getState('ruangan_id');
    $modelPulangNew->create_loginpemakai_id = Yii::app()->user->id;
    $modelPulangNew->update_loginpemakai_id = Yii::app()->user->id;
    $modelPulangNew->pasienadmisi_id = $pasienadmisi_id;

    if (isset($attrPasienPulang['tgl_meninggal'])) {
      $modelPulangNew->ismeninggal = true;
    } else {
      $modelPulangNew->ismeninggal = false;
    }

    $masukKamar = MasukkamarT::model()->findByAttributes(
      array(
        'pasienadmisi_id' => $pasienadmisi_id,
        'pindahkamar_id' => null
      )
    );

    if (!$modelPulangNew->cekSisaPembayaranUntukPulang()) {
      throw new CException("Sisa tagihan pasien yang akan dipulangkan belum dibayarkan.");
    }

    // die;
    if ($modelPulangNew->validate()) {
      if ($modelPulangNew->save()) {
        //                   ini digunakan untuk mengupdate masukkamar ruangan_id=>menjadi null dan kamarruangan_m  status menjadi true
        $kamarruangan_status = true;
        $keterangan_kamar = Params::KETERANGANKAMAR_TERSEDIA; //'OPEN'
        $modBookingkamar = BookingkamarT::model()->findByAttributes(array('kamarruangan_id' => $masukKamar->kamarruangan_id, 'statuskonfirmasi' => 'SUDAH KONFIRMASI', 'pasienadmisi_id' => null));
        if (!empty($modBookingkamar)) {
          $kamarruangan_status = false;
          $keterangan_kamar = Params::KETERANGANKAMAR_DIPESAN; //'BOOKING'
        }
        $ukamarruangan = true;

        // var_dump($kamarruangan_status, $keterangan_kamar); die;

        if (!empty($masukKamar->kamarruangan_id)) {
          $ukamarruangan = KamarruanganM::model()->updateByPk(
            $masukKamar->kamarruangan_id,
            array(
              'kamarruangan_status' => $kamarruangan_status,
              'keterangan_kamar' => $keterangan_kamar
            )
          );
        }
        // $umasukkamar = MasukkamarT::model()->updateByPk($masukKamar->masukkamar_id, array('kamarruangan_id'=>null));
        if ($ukamarruangan || $umasukkamar) {
          $this->successPasienPulang = true;
        }
      } else {
        $this->successPasienPulang = false;
      }
    }

    return $modelPulangNew;
  }

  protected function updatePendaftaran($modPendaftaran, $modelPulang)
  {
    if (isset($_POST['RIPendaftaranT']['tglrenkontrol']) && $_POST['RIPendaftaranT']['tglrenkontrol'] != null) {
      $format = new MyFormatter();
      $tglrenkontrol = $format->formatDateTimeForDb($_POST['RIPendaftaranT']['tglrenkontrol']);
      $kontrolruangan = $_POST['RIPendaftaranT']['ruangankontrol_id'];
    } else {
      $tglrenkontrol = null;
      $kontrolruangan = null;
    }

    $daftar = PendaftaranT::model()->updateByPk(
      $modelPulang->pendaftaran_id,
      array(
        'tglselesaiperiksa' => date('Y-m-d H:i:s'),
        'pasienpulang_id' => $modelPulang->pasienpulang_id,
        //'tglrenkontrol'=>$tglrenkontrol,
        'statusperiksa' => Params::STATUSPERIKSA_SUDAH_PULANG,
        // 'ruangankontrol_id'=>$kontrolruangan,
      )
    );

    if (!empty($kontrolruangan)) {
      $this->simpanSKKontrol($modPendaftaran, $kontrolruangan);
    }

    //            $modPendaftaran->tglselesaiperiksa = date( 'Y-m-d H:i:s');
    //            $modPendaftaran->pasienpulang_id = $modelPulang->pasienpulang_id;
    if ($daftar) {
      $this->successUpdatePendaftaran = true;
      return $modPendaftaran;
    } else {
      $this->successUpdatePendaftaran = false;
    }
  }

  protected function updatePasienAdmisi($modPasienAdmisi, $modelPulang)
  {
    $modPasienAdmisi->pasienpulang_id = $modelPulang->pasienpulang_id;
    $modPasienAdmisi->tglpulang = $modelPulang->tglpasienpulang;
    $admisi = PasienadmisiT::model()->updateByPk($modPasienAdmisi->pasienadmisi_id, array("tglpulang" => $modPasienAdmisi->tglpulang, "pasienpulang_id" => $modPasienAdmisi->pasienpulang_id));
    if ($admisi) {
      $this->successUpdatePasienAdmisi = true;
    } else {
      $this->successUpdatePasienAdmisi = false;
    }

    return $modPasienAdmisi;
  }

  public function updateSEPPulang($modPendaftaran, $modelPulang)
  {
    $bpjs = new Bpjs;
    $sep = SepT::model()->findByPk($modPendaftaran->sep_id);

    if (empty($sep)) return false;

    $noSep = $sep->nosep;
    $ppk = substr($noSep, 0, 8);
    $tglPulang = $modelPulang->tglpasienpulang;

    // var_dump(json_decode($bpjs->update_tanggal_pulang_sep($noSep, $tglPulang, $ppk)));

    // var_dump($noSep, $ppk, $tglPulang, $modelPulang->attributes);
    // var_dump($modPendaftaran->attributes);
  }

  protected function saveRencanaKontrol($model, $modPulang, $post)
  {
    $model = new RIRencanakontrolR;
    $model->attributes = $post;
    $model->pasienpulang_id = $modPulang->pasienpulang_id;
    $model->pendaftaran_id = $modPulang->pendaftaran_id;
    $model->pasien_id = $modPulang->pasien_id;
    $model->instalasi_id = $modPulang->pendaftaran->instalasi_id;
    $model->ruangan_id = $modPulang->pendaftaran->ruangan_id;
    $model->rencanapulang_tgl = !empty($model->rencanapulang_tgl) ? MyFormatter::formatDateTimeForDb($model->rencanapulang_tgl) : null;
    $model->rencanakontrol_tgl = !empty($model->rencanakontrol_tgl) ? MyFormatter::formatDateTimeForDb($model->rencanakontrol_tgl) : null;
    $model->create_time = date('Y-m-d H:i:s');
    $model->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
    $model->create_ruangan = Yii::app()->user->getState('ruangan_id');

    $this->simpan_rencanakontrol = $this->simpan_rencanakontrol && $model->save();
  }

  public function simpanPengirimanDokRM($modPendaftaran, $post, $dokrekammedis_id)
  {
    $modUbahStatus = new PengirimanrmT;
    $modUbahStatus->attributes = $post;
    $modUbahStatus->pendaftaran_id = $modPendaftaran->pendaftaran_id;
    $modUbahStatus->pasien_id = $modPendaftaran->pasien_id;
    $modUbahStatus->dokrekammedis_id = $dokrekammedis_id;
    $modUbahStatus->nourut_keluar = MyGenerator::noUrutKeluarRM();
    $modUbahStatus->tglpengirimanrm = MyFormatter::formatDateTimeForDb($_POST['PengirimanrmT']['tglpengirimanrm']);
    $modUbahStatus->kelengkapandokumen = TRUE;
    $modUbahStatus->petugaspengirim_id = $_POST['PengirimanrmT']['petugaspengirim_id'];
    $modUbahStatus->create_time = date('Y-m-d H:i:s');
    $modUbahStatus->create_loginpemakai_id = Yii::app()->user->id;
    $modUbahStatus->create_ruangan = Yii::app()->user->getState('ruangan_id');
    $modUbahStatus->ruanganpengirim_id = Yii::app()->user->getState('ruangan_id');
    $modUbahStatus->ruanganpenerima_id = $_POST['PengirimanrmT']['ruangan_id'];

    // var_dump($modUbahStatus->attributes, $modUbahStatus->validate(), $modUbahStatus->errors);

    if ($modUbahStatus->save()) {


      PendaftaranT::model()->updateByPk($modPendaftaran->pendaftaran_id, array('statusdokrm' => 'SUDAH DIKIRIM', 'pengirimanrm_id' => $modUbahStatus->pengirimanrm_id));

      $judul = 'Pengiriman Berkas Rekam Medis';

      $isi = $modUbahStatus->pendaftaran->no_pendaftaran . ' - ' . $modUbahStatus->pasien->no_rekam_medik . ' - ' . $modUbahStatus->pasien->nama_pasien;

      CustomFunction::broadcastNotif($judul, $isi, array(
        array('instalasi_id' => $modUbahStatus->ruangantujuan->instalasi->instalasi_id, 'ruangan_id' => $modUbahStatus->ruangantujuan->ruangan_id, 'modul_id' => !empty($modUbahStatus->ruangantujuan->modul_id) ? $modUbahStatus->ruangantujuan->modul_id : null),
      ));

      return true;
    } else {
      return false;
    }
  }

  /**
   * digunakan untuk membatalkan pasien rawat inap
   * tabel yang digunakan 
   * pendaftaran_t; pasien_m; pasienadmisi_t; jeniskasuspenyakit_m, pasienbatalrawat_r
   * @param type $pendaftaran_id type = integer  
   */
  public function actionBatalRawatInap($pendaftaran_id)
  {
    $this->layout = '//layouts/iframe';

    $modPasienBatalRawat = new PasienbatalrawatR;

    $modPendaftaran    = RIPendaftaranT::model()->findByPk($pendaftaran_id);
    $modPasien         = PasienM::model()->findByPk($modPendaftaran->pasien_id);
    $modAdmisi         = PasienadmisiT::model()->findByAttributes(array('pendaftaran_id' => $modPendaftaran->pendaftaran_id));
    $jenisPenyakit     = JeniskasuspenyakitM::model()->findByPk($modPendaftaran->jeniskasuspenyakit_id);
    //             digunakan untuk merefresh jika data berhasil di simpan
    $tersimpan = 'Tidak';

    $modPendaftaran->jeniskasuspenyakit_nama   = $jenisPenyakit->jeniskasuspenyakit_nama;
    $modPasienBatalRawat->pasienadmisi_id      = $modAdmisi->pasienadmisi_id;
    $modPasienBatalRawat->create_time          = date('Y-m-d H:i:s');
    $modPasienBatalRawat->update_time          = date('Y-m-d H:i:s');
    $modPasienBatalRawat->create_ruangan       = Yii::app()->user->getState('ruangan_id');
    $modPasienBatalRawat->create_loginpemakai_id   = Yii::app()->user->id;
    $modPasienBatalRawat->update_loginpemakai_id   = Yii::app()->user->id;

    if (!empty($_REQUEST['PasienbatalrawatR'])) {

      $format = new MyFormatter();
      $modPasienBatalRawat->attributes = $_REQUEST['PasienbatalrawatR'];
      $modPasienBatalRawat->tglbatalrawat = $format->formatDateTimeForDb($modPasienBatalRawat->tglbatalrawat);
      $pendaftaran_id = $_POST['pendaftaran_id'];
      $cek = PasienbatalrawatR::model()->findByAttributes(array('pasienadmisi_id' => $modPasienBatalRawat->pasienadmisi_id));
      $kamarRuangan = PasienadmisiT::model()->findByPk($modPasienBatalRawat->pasienadmisi_id);

      if (!empty($cek->update_time) || !empty($cek->update_loginpemakaian_id)) {
        $modPasienBatalRawat->update_time              = date('Y-m-d H:i:s');
        $modPasienBatalRawat->update_loginpemakai_id   = date('Y-m-d H:i:s');
      }

      if ($modPasienBatalRawat->validate()) {
        $admisi_id = $modPasienBatalRawat->pasienadmisi_id;;
        $transaction = Yii::app()->db->beginTransaction();
        try {
          if ($modPasienBatalRawat->save()) {
            //                          update null terlebih dahulu kamarruangan_id di pasienadmisi                

            $modA = PasienadmisiT::model()->updateByPk($admisi_id, array('bookingkamar_id' => null, 'kamarruangan_id' => null, 'pendaftaran_id' => null));

            // TindakanpelayananT::model()->deleteAllByAttributes(array('pendaftaran_id'=>$pendaftaran_id));

            $bookingKamar = BookingkamarT::model()->findByAttributes(array('pasienadmisi_id' => $admisi_id));

            $keterangan_kamar = Params::KETERANGANKAMAR_TERSEDIA; //'OPEN'
            $kamarruangan_status = true;
            if ($bookingKamar) {
              BookingkamarT::model()->updateByPk($bookingKamar->bookingkamar_id, array('pasienadmisi_id' => null));
              $keterangan_kamar = Params::KETERANGANKAMAR_DIPESAN; //'BOOKING'
              $kamarruangan_status = false;
            }

            $ok = $this->hapusTindakanDanUpdate($modAdmisi);

            //$masukKamar = MasukkamarT::model()->findByAttributes(array('pasienadmisi_id'=>$admisi_id));
            //if($masukKamar){
            //   MasukkamarT::model()->deleteByPk($masukKamar->masukkamar_id);
            //}
            if (!empty($kamarRuangan->kamarruangan_id)) {
              KamarruanganM::model()->updateByPk($kamarRuangan->kamarruangan_id, array('kamarruangan_status' => $kamarruangan_status, 'keterangan_kamar' => $keterangan_kamar));
            }
            $pendaftaran = PendaftaranT::model()->updateByPk($pendaftaran_id, array('pasienadmisi_id' => null, 'alihstatus' => false));
            // $deleteAdmisi = PasienadmisiT::model()->deleteByPk($admisi_id); //RND-1592

            // hapus tindakan

            if ($pendaftaran && $ok) {
              $transaction->commit();
              Yii::app()->user->setFlash('success', "Data berhasil disimpan");
              $tersimpan = 'Ya';
            } else {
              $transaction->rollback();
              if (!$ok) {
                Yii::app()->user->setFlash('error', "Rawat Inap tidak bisa dibatalkan karena ada tindakan yang sudah dibayarkan!");
              } else {
                Yii::app()->user->setFlash('error', "Data gagal disimpan");
              }
            }
          } else {
            $transaction->rollback();
            Yii::app()->user->setFlash('error', "Data gagal disimpan");
          }
        } catch (Exception $exc) {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data gagal disimpan", MyExceptionMessage::getMessage($exc, false));
        }
      } else {
        Yii::app()->user->setFlash('error', "Data gagal disimpan");
      }
    }

    $this->render('formBatalRawatInap', array('modPendaftaran' => $modPendaftaran, 'modPasien' => $modPasien, 'modPasienBatalRawat' => $modPasienBatalRawat, 'tersimpan' => $tersimpan));
  }

  public function hapusTindakanDanUpdate($admisi)
  {
    $cr = new CDbCriteria();
    $cr->select = "count(*) as tindakanpelayanan_id";
    $cr->addCondition("tindakansudahbayar_id is not null and pasienadmisi_id = " . $admisi->pasienadmisi_id);
    $dat = TindakanpelayananT::model()->find($cr);
    $ok = true;
    // if ($dat->tindakanpelayanan_id > 0) {
    if ($dat->tindakanpelayanan_id == 0) {
      //echo "MK"; die;
      // return false;
      return true;
    } else {
      $ok = $ok && TindakanpelayananT::model()->deleteAllByAttributes(array(
        'pasienadmisi_id' => $admisi->pasienadmisi_id
      ));
      //var_dump($ok);
      if ($admisi->pendaftaran->instalasi_id == Params::INSTALASI_ID_RI) {
        $ok = $ok && PendaftaranT::model()->updateByPk($admisi->pendaftaran_id, array(
          //'statusperiksa'=> Params::STATUSPERIKSA_SUDAH_PULANG,
          'statusperiksa' => Params::STATUSPERIKSA_BATAL_PERIKSA,
          'pasienadmisi_id' => null,
        ));
      } else {
        $ok = $ok && PendaftaranT::model()->updateByPk($admisi->pendaftaran_id, array(
          //'statusperiksa'=> Params::STATUSPERIKSA_SUDAH_PULANG,
          'statusperiksa' => Params::STATUSPERIKSA_SUDAH_DIPERIKSA,
          'pasienadmisi_id' => null,
        ));
      }
      //var_dump($ok); 

      $pk = PindahkamarT::model()->findAllByAttributes(array(
        'pasienadmisi_id' => $admisi->pasienadmisi_id,
      ));

      if (count((array)$pk) > 0) {
        $ok = $ok && PindahkamarT::model()->updateAll(array(
          'masukkamar_id' => null,
        ), array(
          'condition' => 'pasienadmisi_id = ' . $admisi->pasienadmisi_id,
        ));
      }
      //var_dump($ok);

      $ok = $ok && MasukkamarT::model()->deleteAllByAttributes(array(
        'pasienadmisi_id' => $admisi->pasienadmisi_id,
      ));
      if (count((array)$pk) > 0) {
        $ok = $ok && PindahkamarT::model()->deleteAllByAttributes(array(
          'pasienadmisi_id' => $admisi->pasienadmisi_id,
        ));
      }

      return $ok;
    }
  }

  function actionPrintKepalaLes($pendaftaran_id = null)
  {
    $this->layout = '//layouts/printWindows';
    $format = new MyFormatter;
    $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
    $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
    $modAdmisi = PasienadmisiT::model()->findByPk($modPendaftaran->pasienadmisi_id);

    // var_dump($modAdmisi); die;


    $this->render($this->path_view . 'print/printKepalaLes', array(
      'format' => $format,
      'modPendaftaran' => $modPendaftaran,
      'modAdmisi' => $modAdmisi,
      'modPasien' => $modPasien,

    ));
  }

  public function actionValidasiSEP()
  {
    $returnVal = array();
    $pendaftaran_id = $_GET['id'];
    $sql_cek_validasi = "SELECT EXISTS(SELECT * FROM tindakanpelayanan_t WHERE pendaftaran_id = '" . $pendaftaran_id . "'  AND verifrenctindakan_id IS NOT NULL) ";
    $validate = Yii::app()->db->createCommand($sql_cek_validasi)->queryRow();
    $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
    $modSep = SepT::model()->findByPk($modPendaftaran->sep_id);
    if(!empty($modPendaftaran->pasienadmisi_id)){
      $modPasienAdmisi = PasienadmisiT::model()->findByPk($modPendaftaran->pasienadmisi_id);
      $modSep = SepT::model()->findByPk($modPasienAdmisi->sep_id);
    }

    $returnVal['is_sep'] = 0;
    if (!empty($modSep)) {
      $returnVal['is_sep'] = 1;
    }

    $returnVal['validasi'] = $validate;
    // echo "<pre>";
    // var_dump($returnVal);
    // die;

    echo CJSON::encode($returnVal);
  }
}
