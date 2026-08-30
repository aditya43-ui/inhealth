<?php

/**
 * controller utama untuk mengakses menu pembayaran jasa
 *
 * @package application.modules.penggajian
 * @subpackage controllers
 * @author M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     2.0.0
 * @link    <http://piindonesia.co.id>
 */
class PembayaranJasaController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/column1';
  public $defaultAction = 'create';
  public $suksesSimpanDetail = false;
  public $path_view = 'penggajian.views.pembayaranJasa.';
  public $pesan = "succes";

  /**
   * Creates a new model.
   * If creation is successful, the browser will be redirected to the 'view' page.
   */
  public function actionCreate($id = null, $linkHalaman = null)
  {
    //  if(!Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
    $format = new MyFormatter;
    $model = new GJPembayaranjasaT;
    $modTandabukti = new GJTandabuktikeluarT;
    $model->tglbayarjasa = date('d M Y H:i:s');
    $model->nobayarjasa = "-- Otomatis --"; //MyGenerator::noBayarJasa();
    $modDetails = new GJPembjasadetailT;
    $dataDetails = array();
    $modPajakDokter = new PajakdokterT();

    $model->pilihDokter = Params::BAYAR_JASA_DOKTER_RS;
    $modApprovalotorisasiM = ApprovalotorisasiM::model()->find();
    $model->pajak_id = 1; //Pajak PPh 21

    if (isset($modApprovalotorisasiM)) {
      $model->mengetahui_id = $modApprovalotorisasiM->direkturrs_id;
      $model->mengetahui_pt_id = $modApprovalotorisasiM->kasipersonalia_id;
      $model->menyetujui_id = $modApprovalotorisasiM->direkturpt_id;

      $modPajakDokter->mengetahui_id = $modApprovalotorisasiM->direkturrs_id;
      $modPajakDokter->mengetahui_pt_id = $modApprovalotorisasiM->kasipersonalia_id;
      $modPajakDokter->menyetujui_id = $modApprovalotorisasiM->direkturpt_id;

      if (!empty($model->mengetahui_id)) {
        $model->mengetahui = $modApprovalotorisasiM->direkturrs->namaLengkap;
      }
      if (!empty($model->mengetahui_pt_id)) {
        $model->mengetahui_pt = $modApprovalotorisasiM->kasipersonalia->namaLengkap;
      }
      if (!empty($model->menyetujui_id)) {
        $model->menyetujui = $modApprovalotorisasiM->direkturpt->namaLengkap;
      }

      if (!empty($modPajakDokter->mengetahui_id)) {
        $modPajakDokter->mengetahui = $modApprovalotorisasiM->direkturrs->namaLengkap;
      }
      if (!empty($modPajakDokter->mengetahui_pt_id)) {
        $modPajakDokter->mengetahui_pt = $modApprovalotorisasiM->kasipersonalia->namaLengkap;
      }
      if (!empty($modPajakDokter->menyetujui_id)) {
        $modPajakDokter->menyetujui = $modApprovalotorisasiM->direkturpt->namaLengkap;
      }
    }

    // rujukan
    $model->tgl_awalPenunjang = MyFormatter::formatMonthForUser(date('M Y'));
    $model->tgl_akhirPenunjang = MyFormatter::formatMonthForUser(date('M Y'));

    // rs
    $model->tgl_awalPendaftaran = MyFormatter::formatMonthForUser(date('M Y'));
    $model->tgl_akhirPendaftaran = MyFormatter::formatMonthForUser(date('M Y'));

    if (!empty($id)) {

      $model = GJPembayaranjasaT::model()->findByPk($id);
      if (!empty($model->rujukandari_id)) {
        $model->pilihDokter = 'rujukan';
        $model->rujukandariNama = $model->rujukandari->namaperujuk;
        $model->tgl_awalPenunjang = date('d M Y', strtotime($model->periodejasa));
        $model->tgl_akhirPenunjang = date('d M Y', strtotime($model->sampaidgn));
      } else if (!empty($model->pegawai_id)) {
        $model->pilihDokter = 'rs';
        $model->pegawaiNama = $model->pegawai->NamaLengkap;
        $model->tgl_awalPendaftaran = date('d M Y', strtotime($model->periodejasa));
        $model->tgl_akhirPendaftaran = date('d M Y', strtotime($model->sampaidgn));
      } else {
        $model->pilihDokter = 'askep';
        // $model->pegawaiNama = $model->pegawai->NamaLengkap;
        $model->tgl_awalPendaftaran = date('d M Y', strtotime($model->periodejasa));
        $model->tgl_akhirPendaftaran = date('d M Y', strtotime($model->sampaidgn));
      }

      $modDetailsLoad = GJPembjasadetailT::model()->findAllByAttributes(array('pembayaranjasa_id' => $model->pembayaranjasa_id));
      foreach ($modDetailsLoad as $i => $data) {
        $attributes = $data->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $dataDetails[$i]["$attribute"] = $data->$attribute;
          $dataDetails[$i]["penjaminId"] = $data->pendaftaran->penjamin_id;
        }
      }
      if (!empty($model->mengetahui_id)) {
        $modPegawai = PegawaiM::model()->findByPk($model->mengetahui_id);
        $model->mengetahui = $modPegawai->namaLengkap;
      }
      if (!empty($model->mengetahui_pt_id)) {
        $modPegawai = PegawaiM::model()->findByPk($model->mengetahui_pt_id);
        $model->mengetahui_pt = $modPegawai->namaLengkap;
      }
      if (!empty($model->menyetujui_id)) {
        $modPegawai = PegawaiM::model()->findByPk($model->menyetujui_id);
        $model->menyetujui = $modPegawai->namaLengkap;
      }

      $modPajakDokter = PajakdokterT::model()->findByPk($model->pajakdokter_id);
      if (isset($modPajakDokter)) {
        if (!empty($modPajakDokter->mengetahui_id)) {
          $modPegawai = PegawaiM::model()->findByPk($modPajakDokter->mengetahui_id);
          $modPajakDokter->mengetahui = $modPegawai->namaLengkap;
        }
        if (!empty($modPajakDokter->mengetahui_pt_id)) {
          $modPegawai = PegawaiM::model()->findByPk($modPajakDokter->mengetahui_pt_id);
          $modPajakDokter->mengetahui_pt = $modPegawai->namaLengkap;
        }
        if (!empty($modPajakDokter->menyetujui_id)) {
          $modPegawai = PegawaiM::model()->findByPk($modPajakDokter->menyetujui_id);
          $modPajakDokter->menyetujui = $modPegawai->namaLengkap;
        }
      }
    }

    if (isset($_POST['GJPembayaranjasaT']) && isset($_POST['GJPembjasadetailT'])) {
      $transaction = Yii::app()->db->beginTransaction();

      // die;
      // var_dump($_POST);

      try {
        $model->attributes = $_POST['GJPembayaranjasaT'];
        //$model->pilihDokter=$_POST['GJPembayaranjasaT']['pilihDokter'];
        $model->pegawaiNama = $_POST['GJPembayaranjasaT']['pegawaiNama'];
        //$model->rujukandariNama=$_POST['GJPembayaranjasaT']['rujukandariNama'];
        $model->tglbayarjasa = date('Y-m-d H:i:s');
        $model->nobayarjasa = MyGenerator::noBayarJasa();

        $tgl_awal = MyFormatter::formatMonthForDb($_POST['GJPembayaranjasaT']['tgl_awalPendaftaran']) . "-01";
        $tgl_akhir = date('Y-m-t', strtotime($tgl_awal));

        /*
                $tgl_awal_penunjang = MyFormatter::formatMonthForDb($_POST['GJPembayaranjasaT']['tgl_awalPenunjang'])."-01";
                $tgl_akhir_penunjang = date('Y-m-t', strtotime($tgl_awal_penunjang));
                 *
                 */


        /*
                if($model->pilihDokter == "rujukan"){
                    $model->tgl_awalPenunjang = $tgl_awal_penunjang;
                    $model->tgl_akhirPenunjang = $tgl_akhir_penunjang;
                    $model->periodejasa = $tgl_awal_penunjang;
                    $model->sampaidgn = $tgl_akhir_penunjang;
                } else if (in_array($model->pilihDokter, array("rs", "askep", "farmasi", "sopir", "laundry", "radio", "paramedis"))){
                 *
                 */
        $model->tgl_awalPendaftaran = $tgl_awal;
        $model->tgl_akhirPendaftaran = $tgl_akhir;
        $model->periodejasa = $tgl_awal;
        $model->sampaidgn = $tgl_akhir;
        //}

        $model->create_time = date('Y-m-d H:i:s');
        $model->create_loginpemakai_id = Yii::app()->user->id;
        $model->create_ruangan = Yii::app()->user->getState('ruangan_id');

        if ($model->pegawai_id == '') $model->pegawai_id = null;
        if (is_array($model->carabayar_id)) $model->carabayar_id = $_POST['GJPembayaranjasaT']['carabayar_id'][0];
        if (is_array($model->penjamin_id)) $model->penjamin_id = $_POST['GJPembayaranjasaT']['penjamin_id'][0];
        if (is_array($model->instalasi_id)) $model->instalasi_id = $_POST['GJPembayaranjasaT']['instalasi_id'][0];

        // var_dump($model->attributes, $model->validate(), $model->errors); die;

        foreach ($_POST['GJPembjasadetailT'] as $i => $post) {
          $dataDetails[$i] = new $modDetails;
          $dataDetails[$i] = $post;
        }


        // var_dump($_POST); die;
        if ($model->validate()) {
          $penjaminId = '';
          // $model->tandabuktikeluar_id = $modTandabukti->tandabuktikeluar_id;
          $model->save();

          // simpan pajak dokter
          if (isset($_POST['PajakdokterT'])) {
            $modPajakDokter->attributes = $_POST['PajakdokterT'];
            $modPajakDokter->pegawai_id = $model->pegawai_id;
            $modPajakDokter->petugashitung_id = Yii::app()->user->getState('pegawai_id');
            $modPajakDokter->create_time = date('Y-m-d H:i:s');
            $modPajakDokter->tgl_perhitungan = $model->tglbayarjasa;
            $modPajakDokter->no_perhitungan = MyGenerator::noHitunganPajak();

            $modPajakDokter->create_loginpemakai_id = Yii::app()->user->id;
            $modPajakDokter->create_ruangan = Yii::app()->user->getState('ruangan_id');
            $modPajakDokter->periodebulanpajak = $model->periodejasa;
            if ($modPajakDokter->save()) {
              $model->pajakdokter_id = $modPajakDokter->pajakdokter_id;
              $model->save();
            }
          }

          // var_dump($model->attributes, $modPajakDokter->attributes); die;

          /*
                    if (in_array($model->pilihDokter, array("askep", "farmasi", "sopir", "laundry", "paramedis")) && isset($_POST['pegawai_askep']) && isset($_POST['total_terima_perawat'])) {
                        $perawatJasa = $this->simpanPerawatAskep($model, $_POST['pegawai_askep'], $_POST['total_terima_perawat']);
                    } else if (in_array($model->pilihDokter, array("radio")) && isset($_POST['total_terima_perawat'])) {
                        if (isset($_POST['pegawai_askep'])) {
                            $radiografer = $_POST['pegawai_askep'];
                        } else {
                            $radiografer = array(78);
                        }

                        //var_dump($radiografer); die;

                        $perawatJasa = $this->simpanPerawatAskep($model, $radiografer, $_POST['total_terima_perawat']);
                    }
                     *
                     */

          // die;

          //var_dump($model->attributes);
          $dataDetails = $this->simpanDetail($model, $modDetails, $_POST['GJPembjasadetailT']);
          $updateKomponen = $this->updateTindakankomponen($model, $dataDetails);

          //var_dump($this->suksesSimpanDetail);
          //die;

          //                    if(Yii::app()->user->getState('isjurnalotomatis') == true){
          //                        $modJurnalRekening = $this->saveJurnalRekening($model);
          //                        $rekColumns = array(Params::REKENINGCOLUMN_ID_PEMBAYARANJASAMEDIS_LAINLAIN, Params::REKENINGCOLUMN_ID_PEMBAYARANJASAMEDIS_STP, Params::REKENINGCOLUMN_ID_PEMBAYARANJASAMEDIS_YMH, Params::REKENINGCOLUMN_ID_PEMBAYARANJASAMEDIS_PPH21);
          //                        $criteria = new CDbCriteria();
          //                        $criteria->addInCondition('rekeningcolumn_id', $rekColumns);
          //                        $rekeningcolumn = RekeningcolumnM::model()->findAll($criteria);
          //                        $this->saveJurnalDetail($model, $rekeningcolumn, $modJurnalRekening);
          //                    }


          if ($this->suksesSimpanDetail == true) { // && $updateKomponen == true BELUM TERUJI
            $transaction->commit();
            Yii::app()->user->setFlash('success', 'Data nomor bayar jasa' . $model->nobayarjasa . ' berhasil disimpan.');
            $this->redirect(array('create', 'id' => $model->pembayaranjasa_id, 'sukses' => 1));
          } else {
            $transaction->rollback();
            Yii::app()->user->setFlash('error', 'Data gagal disimpan. Silakan cek kembali tabel detail.');
          }
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', 'Data gagal disimpan!');
        }
      } catch (Exception $exc) {
        Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
        $transaction->rollback();
      }
    }
    $this->render($this->path_view . 'create', array(
      'model' => $model,
      'modDetails' => $modDetails,
      'dataDetails' => $dataDetails,
      'modPajakDokter' => $modPajakDokter,
      'linkHalaman' => $linkHalaman
    ));
  }

  /**
   * fungsi simpan pembayaran jasa perawat
   * @param type $model
   * @param type $post
   * @param type $total
   */
  protected function simpanPerawatAskep($model, $post, $total)
  {
    foreach ($post as $item) {
      $modAskep = new PembjasaperawatT;
      $modAskep->pegawai_id = $item;
      $modAskep->pembayaranjasa_id = $model->pembayaranjasa_id;
      $modAskep->total_terima = $total;
      $modAskep->pilihjasa = $model->pilihDokter;
      $modAskep->save();

      // var_dump($modAskep->attributes);
    }
    // die;
  }

  /**
   * simpan detail pembayaran jasa
   * @param type $model
   * @param type $modDetails
   * @param type $posts
   * @return \modDetails
   */
  protected function simpanDetail($model, $modDetails, $posts)
  {

    if (count((array)$posts) > 0) {
      $saveDetails = array();
      $this->suksesSimpanDetail = true;

      foreach ($posts as $i => $post) {
        if ($post['pilihDetail'] == true) {

          $saveDetails[$i] = new $modDetails;
          $saveDetails[$i]->attributes = $post;
          $saveDetails[$i]->pembayaranjasa_id = $model->pembayaranjasa_id;
          $saveDetails[$i]->penjaminId = (isset($post['penjaminId']) ? $saveDetails[$i]->penjaminId : null);
          $saveDetails[$i]->instalasi_id = $post['instalasi_id'];
          $saveDetails[$i]->ruangan_id = $post['ruangan_id'];

          // var_dump($saveDetails[$i]->attributes);

          if ($saveDetails[$i]->save()) {
            $this->suksesSimpanDetail = $this->suksesSimpanDetail && true;
          } else {
            $this->suksesSimpanDetail = false;
          }
          // var_dump($saveDetails[$i]->attributes);

          // die;
        }
      }
    }
    return $saveDetails;
  }

  /**
   * update data tindakan komponen
   * @param type $model
   * @param type $dataDetails
   * @return boolean
   */
  protected function updateTindakankomponen($model, $dataDetails)
  {
    $sukses = true;
    if (count((array)$dataDetails) > 0) {
      if ($model->rujukandari_id) { //jika rujukan
        foreach ($dataDetails as $i => $data) {
          $criteria = new CDbCriteria();
          $criteria->addCondition('tindakanpelayanan_id = ' . $data->tindakanpelayanan_id);
          $criteria->addCondition('komponentarif_id = ' . $data->komponentarif_id);

          $modKomponens = TindakankomponenT::model()->findAll($criteria);

          if (count((array)$modKomponens) > 0) {
            foreach ($modKomponens as $i => $komponen) {
              $komponen->pembayaranjasa_id = $model->pembayaranjasa_id;
              if ($komponen->save())
                $sukses = $sukses && true;
              else
                $sukses = false;
            }
          }
        }
      } else {
        foreach ($dataDetails as $i => $data) {
          // var_dump($data->attributes);

          if (!empty($data->obatalkespasien_id)) {
            ObatalkespasienT::model()->updateByPk($data->obatalkespasien_id, array(
              'pembayaranjasa_id' => $model->pembayaranjasa_id,
            ));
          } else {
            $criteria = new CDbCriteria();
            $criteria->addCondition('tindakanpelayanan_id = ' . $data->tindakanpelayanan_id);
            $criteria->addCondition('komponentarif_id = ' . $data->komponentarif_id);

            $modKomponens = TindakankomponenT::model()->findAll($criteria);

            // var_dump(count((array)$modKomponens));
            if (count((array)$modKomponens) > 0) {
              foreach ($modKomponens as $i => $komponen) {
                $komponen->pembayaranjasa_id = $model->pembayaranjasa_id;
                if ($komponen->save())
                  $sukses = $sukses && true;
                else
                  $sukses = false;
              }
            }
          }
        }
      }
    }
    return $sukses;
  }

  /**
   * Lists all models.
   */
  public function actionIndex($linkHalaman = null)
  {
    $this->pageTitle = Yii::app()->name . " - Pembayaran Jasa Medis";
    $this->redirect(array('create'));
  }

  /**
   * Manages all models.
   */
  public function actionInformasi($linkHalaman = null)
  {
    $this->pageTitle = Yii::app()->name . " - Pembayaran Jasa Medis";
    //                if(!Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
    $format = new MyFormatter();
    $model = new GJPembayaranjasaT('searchInformasi');
    $model->unsetAttributes();  // clear any default values
    $model->tgl_awal = date('d M Y');
    $model->tgl_akhir = date('d M Y');
    $model->tgl_awaljasa = date('d M Y');
    $model->tgl_akhirjasa = date('d M Y');
    $model->cari_period = date('Y-m');
    if (isset($_GET['GJPembayaranjasaT'])) {
      $model->attributes = $_GET['GJPembayaranjasaT'];
      // $model->noKasKeluar=$_GET['GJPembayaranjasaT']['noKasKeluar'];
      // $model->namaPerujuk=$_GET['GJPembayaranjasaT']['namaPerujuk'];
      $model->namaDokter = $_GET['GJPembayaranjasaT']['namaDokter'];
      $model->kelompokpegawai_id = isset($_GET['GJPembayaranjasaT']['kelompokpegawai_id']) ? $_GET['GJPembayaranjasaT']['kelompokpegawai_id'] : null;
      $model->jabatan_id = isset($_GET['GJPembayaranjasaT']['jabatan_id']) ? $_GET['GJPembayaranjasaT']['jabatan_id'] : null;
      $model->jenisjasa = isset($_GET['GJPembayaranjasaT']['jenisjasa']) ? $_GET['GJPembayaranjasaT']['jenisjasa'] : null;
      $model->status_gaji = isset($_GET['GJPembayaranjasaT']['status_gaji']) ? $_GET['GJPembayaranjasaT']['status_gaji'] : null;
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['GJPembayaranjasaT']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['GJPembayaranjasaT']['tgl_akhir']);
      $model->cekPeriode = isset($_GET['GJPembayaranjasaT']['cekPeriode']) ? $_GET['GJPembayaranjasaT']['cekPeriode'] : null;
      if (!empty($model->cekPeriode)) {
        $model->cari_period = MyFormatter::formatMonthForDB($_GET['GJPembayaranjasaT']['cari_period']) . '-01';
      } else {
        $model->cari_period = null;
      }

      //var_dump($model->cari_period);

    }

    $this->render($this->path_view . 'informasiBaru', array(
      'model' => $model, 'linkHalaman' => $linkHalaman
    ));
  }

  /**
   * Returns the data model based on the primary key given in the GET variable.
   * If the data model is not found, an HTTP exception will be raised.
   * @param integer the ID of the model to be loaded
   */
  public function loadModel($id)
  {
    $model = GJPembayaranjasaT::model()->findByPk($id);
    if ($model === null)
      throw new CHttpException(404, 'The requested page does not exist.');
    return $model;
  }

  /**
   * Performs the AJAX validation.
   * @param CModel the model to be validated
   */
  protected function performAjaxValidation($model)
  {
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'kupembayaranjasa-t-form') {
      echo CActiveForm::validate($model);
      Yii::app()->end();
    }
  }

  /**
   *Mengubah status aktif
   * @param type $id
   */
  public function actionRemoveTemporary($id)
  {
    if (!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)) {
      throw new CHttpException(401, Yii::t('mds', 'You are prohibited to access this page. Contact Super Administrator'));
    }
    //                SAKabupatenM::model()->updateByPk($id, array('kabupaten_aktif'=>false));
    //                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
  }

  /**
   * add detail pembayaran jasa farmasi
   */
  public function actionAddDetailPembayaranJasaFarmasi()
  {
    if (!Yii::app()->request->isAjaxRequest) {
      Yii::app()->exit();
    }

    $format = new MyFormatter;

    $tr = "";

    $tgl_awal = $format->formatDateTimeForDb($_POST['tgl_awal']) . " 00:00:00";
    $tgl_akhir = $format->formatDateTimeForDb($_POST['tgl_akhir']) . " 23:59:59";
    $carabayar_id = isset($_POST['carabayar_id']) ? $_POST['carabayar_id'] : null;
    $penjamin_id = isset($_POST['penjamin_id']) ? $_POST['penjamin_id'] : null;

    $cr = new CDbCriteria();
    if (!empty($carabayar_id)) {
      if (is_array($carabayar_id)) {
        $cr->addInCondition(" carabayar_id ", $carabayar_id);
      } else {
        $cr->addCondition(" carabayar_id =" . $carabayar_id);
      }
    }

    if (!empty($penjamin_id)) {
      if (is_array($penjamin_id)) {
        $cr->addInCondition(" penjamin_id ", $penjamin_id);
      } else {
        $cr->addCondition(" penjamin_id =" . $penjamin_id);
      }
    }
    //$cr->join = 'join pembayaranpelayanan_t p on p.pendaftaran_id = t.pendaftaran_id';
    $cr->addBetweenCondition('t.tglpembayaran::date', $tgl_awal, $tgl_akhir);
    $cr->addInCondition('t.obatalkes_id', array(1938, 1939));
    $cr->order = ('t.tglpembayaran desc');

    $dataDetails = InformasipenjualanaresepV::model()->findAll($cr);


    if (count((array)$dataDetails) > 0) {
      $i = 0;
      foreach ($dataDetails as $detail) {

        $oa = ObatalkespasienT::model()->findByPk($detail->obatalkespasien_id);
        if (!empty($oa->pembayaranjasa_id)) continue;

        $modDetails = new GJPembjasadetailT;
        $modDetails->attributes = $detail->attributes;
        $modDetails->obatalkespasien_id = $detail->obatalkespasien_id;
        if ($detail->hargajual_oa != 0)
          $modDetails->jumahtarif = $detail->hargajual_oa;
        else
          $modDetails->jumahtarif = 0;
        $modDetails->jumlahjasa = $detail->hargajual_oa;
        $modDetails->jumlahbayar = $modDetails->jumlahjasa;
        $modDetails->sisajasa = 0;
        $modDetails->pilihDetail = true;





        $tr .= "<tr>";
        $tr .= "<td>" . CHtml::activeCheckBox($modDetails, '[' . $i . ']pilihDetail', array('onclick' => 'checkIni(this);')) . "</td>";
        $tr .= "<td>" . ($i + 1) .
          CHtml::activeHiddenField($modDetails, '[' . $i . ']pendaftaran_id', array('value' => $detail->pendaftaran_id)) .
          CHtml::activeHiddenField($modDetails, '[' . $i . ']pembayaranjasa_id', array('value' => null)) .
          CHtml::activeHiddenField($modDetails, '[' . $i . ']pasien_id', array('value' => $detail->pasien_id)) .
          CHtml::activeHiddenField($modDetails, '[' . $i . ']penjaminId', array('value' => $detail->penjamin_id)) .
          CHtml::activeHiddenField($modDetails, '[' . $i . ']instalasi_id', array('value' => $detail->instalasi_id)) .
          CHtml::activeHiddenField($modDetails, '[' . $i . ']ruangan_id', array('value' => $detail->ruangan_id));
        $tr .= CHtml::activeHiddenField($modDetails, '[' . $i . ']tindakanpelayanan_id', array('value' => $detail->penjamin_id));
        $tr .= CHtml::activeHiddenField($modDetails, '[' . $i . ']daftartindakan_id', array('value' => $detail->penjamin_id));
        $tr .= CHtml::activeHiddenField($modDetails, '[' . $i . ']obatalkespasien_id', array('value' => $detail->obatalkespasien_id));
        //tidak ada pasienadmisi_id >> CHtml::activeHiddenField($modDetails,'['.$i.']pasienadmisi_id',array('value'=>$detail->pasienadmisi_id));
        if (!empty($rujukandariId)) {
          $tr .= CHtml::activeHiddenField($modDetails, '[' . $i . ']pasienmasukpenunjang_id', array('value' => $detail->pasienmasukpenunjang_id));
        }
        $tr .= "</td>";
        $tr .= "<td>" . MyFormatter::formatDateTimeForUser($detail->tglpembayaran) . "<br>" . $detail->nopembayaran . "</td>";
        $tr .= "<td>" . MyFormatter::formatDateTimeForUser($detail->tgl_pendaftaran) . "<br>" . $detail->no_pendaftaran . "</td>";
        $tr .= "<td>" . $detail->carabayar_nama . "/<br/>" . $detail->penjamin_nama . "</td>";
        $tr .= "<td>" . $detail->instalasi_nama . "</td>";
        $tr .= "<td>" . $detail->no_rekam_medik . "</td>";
        $tr .= "<td>" . $detail->nama_pasien . "</td>";
        $tr .= "<td>" . date('d M Y H:i:s', strtotime($detail->tglresep)) . "</td>";
        $tr .= "<td>" . $detail->jenispenjualan . "</td>";
        $tr .= "<td>" . $detail->obatalkes_nama . "</td>";
        $tr .= "<td>" . CHtml::activeTextField($modDetails, '[' . $i . ']jumahtarif', array('readonly' => true, 'class' => 'inputFormTabel integer2', 'style' => 'width: 100px;', 'onkeypress' => "return $(this).focusNextInputField(event);")) . "</td>";
        $tr .= "<td>" . CHtml::activeTextField($modDetails, '[' . $i . ']jumlahjasa', array('readonly' => true, 'class' => 'inputFormTabel integer2', 'style' => 'width: 100px;', 'onkeypress' => "return $(this).focusNextInputField(event);", 'onkeyup' => 'hitungSemua();')) . "</td>";
        $tr .= "<td>" . CHtml::activeTextField($modDetails, '[' . $i . ']jumlahbayar', array('readonly' => false, 'class' => 'inputFormTabel integer2', 'style' => 'width: 100px;', 'onkeypress' => "return $(this).focusNextInputField(event);", 'onkeyup' => 'hitungSemua();')) . "</td>";
        $tr .= "<td>" . CHtml::activeTextField($modDetails, '[' . $i . ']sisajasa', array('readonly' => true, 'class' => 'inputFormTabel integer2', 'style' => 'width: 100px;', 'onkeypress' => "return $(this).focusNextInputField(event);")) . "</td>";
        $tr .= "</tr>";

        $i++;
      }
    }
    $data['tr'] = $tr;
    echo json_encode($data);
  }

  /**
   * untuk :
   * - Transaksi Pembayaran Jasa
   */
  public function actionAddDetailPembayaranJasa()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter();
      $komponentarifIds = null;
      $instalasi_id = null;

      $pegawaiId = (isset($_POST['pegawai_id']) ? $_POST['pegawai_id'] : null);
      $jasa = (isset($_POST['jasa']) ? $_POST['jasa'] : null);
      $rujukandariId = (isset($_POST['rujukandari_id']) ? $_POST['rujukandari_id'] : null);
      $komponentarifIds = (isset($_POST['komponentarifId']) ? $_POST['komponentarifId'] : null);
      $instalasi_id = (isset($_POST['instalasi_id']) ? $_POST['instalasi_id'] : null);
      $data =  array();
      $tr =  "";
      $jasaPerujuk[] = 0;
      $jasaDokter[] = 0;

      $tgl_input = MyFormatter::formatMonthForDb($_POST['tgl_awal']) . "-01";

      $tgl_awal = date('Y-m-01 00:00:00', strtotime($tgl_input));
      $tgl_akhir = date('Y-m-t 00:00:00', strtotime($tgl_input));
      $carabayar_id = isset($_POST['carabayar_id']) ? $_POST['carabayar_id'] : null;
      $penjamin_id = isset($_POST['penjamin_id']) ? $_POST['penjamin_id'] : null;

      $dataDetails = array();
      if (!empty($rujukandariId)) {
        $criteria = new CdbCriteria();
        $criteria->addBetweenCondition('tglmasukpenunjang', $tgl_awal, $tgl_akhir);
        $criteria->addCondition('rujukandari_id = ' . $rujukandariId);
        $criteria->group = "daftartindakan_id, komponentarif_id, tindakanpelayanan_id, tgl_tindakan, daftartindakan_id, daftartindakan_nama, komponentarif_id, komponentarif_nama, pasienmasukpenunjang_id, tglmasukpenunjang, rujukandari_id, pendaftaran_id, no_pendaftaran, no_rekam_medik, no_masukpenunjang, pasien_id, nama_pasien, jeniskelamin, alamat_pasien, penjamin_nama";
        $criteria->select = $criteria->group . ', sum(tarif_tindakankomp) as tarif_tindakankomp';
        $criteria->order = 'tglmasukpenunjang';
        $criteria->compare('t.komponentarif_id', $komponentarifIds);
        $criteria->compare('t.instalasi_id', $instalasi_id);
        if (!empty($carabayar_id)) {
          if (is_array($carabayar_id)) {
            $criteria->addInCondition(" cb.carabayar_id ", $carabayar_id);
          } else {
            $criteria->addCondition(" cb.carabayar_id =" . $carabayar_id);
          }
        }

        if (!empty($penjamin_id)) {
          if (is_array($penjamin_id)) {
            $criteria->addInCondition(" t.penjamin_id ", $penjamin_id);
          } else {
            $criteria->addCondition(" t.penjamin_id =" . $penjamin_id);
          }
        }
      } else if (!empty($pegawaiId)) {
        /**
         * criteria 1 : tindakan jasa non rujuk internal
         * criteria 2 : tindakan jasa rujuk internal
         */
        $modPegawai = PegawaiM::model()->findByPk($pegawaiId);
        $ptkp = null;


        $criteria = new CdbCriteria();
        $criteria->addBetweenCondition('pb.tglpembayaran::date', $tgl_awal, $tgl_akhir);
        $criteria->addCondition('t.tarif_tindakan > 0');
        if (!empty($carabayar_id)) {
          if (is_array($carabayar_id)) {
            $criteria->addInCondition(" cb.carabayar_id ", $carabayar_id);
          } else {
            $criteria->addCondition(" cb.carabayar_id =" . $carabayar_id);
          }
        }

        if (!empty($penjamin_id)) {
          if (is_array($penjamin_id)) {
            $criteria->addInCondition(" t.penjamin_id ", $penjamin_id);
          } else {
            $criteria->addCondition(" t.penjamin_id =" . $penjamin_id);
          }
        }

        $criteria->group = "cb.carabayar_nama, pb.nopembayaran, pb.tglpembayaran, t.daftartindakan_id, t.komponentarif_id, "
          . "t.tindakanpelayanan_id, t.tgl_tindakan, t.daftartindakan_id, "
          . "t.daftartindakan_nama, t.komponentarif_id, t.komponentarif_nama, t.pendaftaran_id, "
          . "t.tgl_pendaftaran, t.dokter1_id, t.no_pendaftaran, t.no_rekam_medik, "
          . "t.pasien_id, t.nama_pasien, t.jeniskelamin, "
          . "t.alamat_pasien, t.penjamin_nama, t.tarif_tindakan, "
          . "t.instalasi_id, t.instalasi_nama, t.ruangan_id, tp.discount_tindakan, bebas.jmlpembebasan";
        $criteria->select = $criteria->group . ', sum(t.tarif_tindakankomp) as tarif_tindakankomp,
                    (case when bebas.jmlpembebasan is null then 0 else bebas.jmlpembebasan end) as jmlpembebasan';
        $criteria->order = 't.tgl_pendaftaran, t.pendaftaran_id';
        $criteria->compare('t.komponentarif_id', $komponentarifIds);
        $criteria->compare('t.instalasi_id', $instalasi_id);
        $criteria->addCondition('kmt.ispembayaranjasa = true');
        $criteria->join = 'left join tindakanpelayanan_t tp on tp.tindakanpelayanan_id = t.tindakanpelayanan_id '
          . 'join tindakansudahbayar_t tsb on tsb.tindakanpelayanan_id = tp.tindakanpelayanan_id '
          . 'join pembayaranpelayanan_t pb on pb.pembayaranpelayanan_id = tsb.pembayaranpelayanan_id '
          . 'join carabayar_m cb on cb.carabayar_id = tp.carabayar_id '
          . 'left join persenkelkomponentarif_m kel on kel.komponentarif_id = t.komponentarif_id '
          . 'JOIN komponentarif_m kmt on kmt.komponentarif_id = t.komponentarif_id '
          . 'left join (select a.tindakanpelayanan_id, a.komponentarif_id, sum(a.jmlpembebasan) as jmlpembebasan from pembebasantarif_t a group by a.tindakanpelayanan_id, a.komponentarif_id) bebas on bebas.tindakanpelayanan_id = t.tindakanpelayanan_id and bebas.komponentarif_id = t.komponentarif_id';


        $data['ptkp'] = 0;
        $data['pajak_akumulasi'] = 0;
        $data['pelapisan_bulan_lalu'] = 0;
        $ptkp = PtkpM::model()->findByPk($modPegawai->ptkp_id);

        if (date('m', strtotime($tgl_awal)) != 1) {
          $pajakDokterSebelumnya = PajakdokterT::model()->findByAttributes(array(
            'pegawai_id' => $pegawaiId,
            'periodebulanpajak' => date('Y-m-d', strtotime('-1 month', strtotime($tgl_awal))),
          ));
          if (!empty($pajakDokterSebelumnya)) {
            $data['pajak_akumulasi'] += $pajakDokterSebelumnya->pkpkumulatif;
            $data['pelapisan_bulan_lalu'] = $pajakDokterSebelumnya->pelapisanpph;
          }
        }

        if (!empty($ptkp)) {
          $data['ptkp'] = $ptkp->wajibpajak_bln;
        }
        $data['is_dokter'] = 1;
        $criteria->addCondition('t.dokter1_id = ' . $pegawaiId);
        $criteria->addCondition('kel.kelompokkomponentarif_id = 1');

        $dataDetailsMeta = PasienpelayananmedisrsV::model()->findAll($criteria);

        $dataDetails = array();

        foreach ($dataDetailsMeta as $item) {
          $dataDetails[$item->tglpembayaran . "_" . $item->tindakanpelayanan_id . "_" . $item->komponentarif_id] = $item;
        }

        ksort($dataDetails);
      }

      if (count((array)$dataDetails) > 0) {
        $i = 0;
        foreach ($dataDetails as $detail) {
          $modDetails = new GJPembjasadetailT;
          $modDetails->attributes = $detail->attributes;
          if ($detail->tarif_tindakankomp != 0)
            $modDetails->jumahtarif = $detail->tarif_tindakan;
          else
            $modDetails->jumahtarif = 0;

          $modDetails->jumlahjasa = $detail->tarif_tindakankomp - $detail->jmlpembebasan;

          if (!empty($detail->discount_tindakan)) {
            $diskon = ($detail->discount_tindakan * $modDetails->jumlahjasa) / $modDetails->jumahtarif;
            $modDetails->jumlahjasa -= $diskon;
          }

          $modDetails->jumlahjasa = number_format($modDetails->jumlahjasa, 2, ",", "");

          $modDetails->jumlahbayar = $modDetails->jumlahjasa;
          $modDetails->sisajasa = 0;
          $modDetails->pilihDetail = true;

          $tr .= "<tr>";
          $tr .= "<td hidden>" . CHtml::activeCheckBox($modDetails, '[' . $i . ']pilihDetail', array('onclick' => 'checkIni(this);')) . "</td>";
          $tr .= "<td>" . ($i + 1) .
            CHtml::activeHiddenField($modDetails, '[' . $i . ']pendaftaran_id', array('value' => $detail->pendaftaran_id)) .
            CHtml::activeHiddenField($modDetails, '[' . $i . ']pembayaranjasa_id', array('value' => null)) .
            CHtml::activeHiddenField($modDetails, '[' . $i . ']pasien_id', array('value' => $detail->pasien_id)) .
            CHtml::activeHiddenField($modDetails, '[' . $i . ']penjaminId', array('value' => $detail->penjamin_id)) .
            CHtml::activeHiddenField($modDetails, '[' . $i . ']instalasi_id', array('value' => $detail->instalasi_id)) .
            CHtml::activeHiddenField($modDetails, '[' . $i . ']ruangan_id', array('value' => $detail->ruangan_id));
          $tr .= CHtml::activeHiddenField($modDetails, '[' . $i . ']tindakanpelayanan_id', array('value' => $detail->penjamin_id));
          $tr .= CHtml::activeHiddenField($modDetails, '[' . $i . ']daftartindakan_id', array('value' => $detail->penjamin_id));
          $tr .= CHtml::activeHiddenField($modDetails, '[' . $i . ']komponentarif_id', array('value' => $detail->penjamin_id));
          //tidak ada pasienadmisi_id >> CHtml::activeHiddenField($modDetails,'['.$i.']pasienadmisi_id',array('value'=>$detail->pasienadmisi_id));
          if (!empty($rujukandariId)) {
            $tr .= CHtml::activeHiddenField($modDetails, '[' . $i . ']pasienmasukpenunjang_id', array('value' => $detail->pasienmasukpenunjang_id));
          }
          $tr .= "</td>";
          $tr .= "<td>" . MyFormatter::formatDateTimeForUser($detail->tglpembayaran) . "<br>" . $detail->nopembayaran . "</td>";
          $tr .= "<td>" . MyFormatter::formatDateTimeForUser($detail->tgl_pendaftaran) . "<br>" . $detail->no_pendaftaran . "</td>";
          $tr .= "<td>" . $detail->carabayar_nama . "/<br/>" . $detail->penjamin_nama . "</td>";
          $tr .= "<td>" . $detail->instalasi_nama . "</td>";
          $tr .= "<td>" . $detail->no_rekam_medik . "</td>";
          $tr .= "<td>" . $detail->nama_pasien . "</td>";
          $tr .= "<td>" . date('d M Y H:i:s', strtotime($detail->tgl_tindakan)) . "</td>";
          $tr .= "<td>" . $detail->daftartindakan_nama . "</td>";
          $tr .= "<td>" . $detail->komponentarif_nama . "</td>";
          $tr .= "<td>" . CHtml::activeTextField($modDetails, '[' . $i . ']jumahtarif', array('readonly' => true, 'class' => 'inputFormTabel integer2', 'style' => 'width: 100px;', 'onkeypress' => "return $(this).focusNextInputField(event);")) . "</td>";
          $tr .= "<td>" . CHtml::activeTextField($modDetails, '[' . $i . ']jumlahjasa', array('readonly' => true, 'class' => 'inputFormTabel integer2', 'style' => 'width: 100px;', 'onkeypress' => "return $(this).focusNextInputField(event);", 'onkeyup' => 'hitungSemua();')) . "</td>";
          $tr .= "<td>" . CHtml::activeTextField($modDetails, '[' . $i . ']jumlahpajak', array('readonly' => true, 'class' => 'inputFormTabel integer2', 'style' => 'width: 100px;', 'onkeypress' => "return $(this).focusNextInputField(event);", 'onkeyup' => 'hitungSemua();')) . "</td>";
          $tr .= "<td>" . CHtml::activeTextField($modDetails, '[' . $i . ']jumlahbayar', array('readonly' => true, 'class' => 'inputFormTabel integer2', 'style' => 'width: 100px;', 'onkeypress' => "return $(this).focusNextInputField(event);", 'onkeyup' => 'hitungSemua();')) . "</td>";
          //$tr .= "<td>".CHtml::activeTextField($modDetails,'['.$i.']sisajasa', array('readonly'=>true, 'class'=>'inputFormTabel integer2', 'style'=>'width: 100px;', 'onkeypress'=>"return $(this).focusNextInputField(event);"))."</td>";
          $tr .= "</tr>";

          $i++;
        }
      }
      $data['tr'] = $tr;
      echo json_encode($data);
      Yii::app()->end();
    }
  }

  /**
   * untuk melihar detail pembayaran jasa dan detailnya
   * @param type $id
   */
  public function actionLihatDetail($id)
  {
    $this->layout = '//layouts/iframe';
    $model = GJPembayaranjasaT::model()->findByPk($id);
    $modDetail = new GJPembjasadetailT;
    $modDetail->unsetAttributes();
    $modDetail->pembayaranjasa_id = $model->pembayaranjasa_id;
    $judulLaporan = null;
    $this->render($this->path_view . 'PrintBaru', array('model' => $model, 'modDetail' => $modDetail, 'judulLaporan' => $judulLaporan, 'frame' => true));
  }

  /**
   * fungsi untuk mencetak prinout
   * @param type $id
   * @param type $caraPrint
   * @param type $det
   */
  public function actionPrint($id, $caraPrint = null, $det = null)
  {
    $model = GJPembayaranjasaT::model()->findByPk($id);
    $modDetail = new GJPembjasadetailT;
    $modDetail->unsetAttributes();
    $modDetail->pembayaranjasa_id = $model->pembayaranjasa_id;
    $judulLaporan = 'Bukti Pembayaran Jasa Dokter';
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      if ($det != null) {
        $this->render($this->path_view . 'PrintBaru', array('model' => $model, 'modDetail' => $modDetail, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
      } else {
        $this->render($this->path_view . 'Print', array('model' => $model, 'modDetail' => $modDetail, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
      }
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      if ($det != null) {
        $this->render($this->path_view . 'PrintBaru', array('model' => $model, 'modDetail' => $modDetail, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
      } else {
        $this->render($this->path_view . 'Print', array('model' => $model, 'modDetail' => $modDetail, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
      }
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      //$mpdf->useOddEven = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      if ($det != null) {
        $mpdf->WriteHTML($this->renderPartial($this->path_view . 'PrintBaru', array('model' => $model, 'modDetail' => $modDetail, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      } else {
        $mpdf->WriteHTML($this->renderPartial($this->path_view . 'Print', array('model' => $model, 'modDetail' => $modDetail, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      }
      $mpdf->Output();
    }
  }

  /* digunakan pada:
         * - Pembayaran Jasa dokter
         * Description  : untuk mencari dokter rujukan dari luar
         */
  public function actionRujukanDari()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $criteria = new CDbCriteria();
      $asalRujukanId = ((!empty($_GET['asalRujukanId'])) ? $_GET['asalRujukanId'] : 1);
      if (!empty($asalRujukanId)) {
        $criteria->addCondition("asalrujukan_id = " . $asalRujukanId);
      }
      $criteria->compare('LOWER(namaperujuk)', strtolower($_GET['term']), true);
      $criteria->order = 'namaperujuk';
      $criteria->limit = 10;
      $returnVal = array();
      $models = RujukandariM::model()->findAll($criteria);
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->namaperujuk . ' - ' . $model->spesialis;
        $returnVal[$i]['value'] = $model->namaperujuk;
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  /**
   * untuk mencari data dokter RS
   */
  public function actionGetDokter()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $criteria = new CDbCriteria();
      if (isset($_GET['term'])) {
        $criteria->compare('LOWER(nama_pegawai)', strtolower($_GET['term']), true);
      }
      $criteria->order = 'nama_pegawai';
      if (isset($_GET['idPegawai'])) {
        if (!empty($_GET['idPegawai'])) {
          $criteria->addCondition("pegawai_id = " . $_GET['idPegawai']);
        }
      }
      $models = DokterpegawaiV::model()->findAll($criteria);
      $returnVal = array();
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->gelardepan . " " . $model->nama_pegawai . ", " . $model->gelarbelakang_nama;
        $returnVal[$i]['value'] = $model->pegawai_id;
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  /**
   * untuk mencari data dokter Spesialis RS
   */
  public function actionGetDokterSpesialis()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $criteria = new CDbCriteria();
      if (isset($_GET['term'])) {
        $criteria->compare('LOWER(nama_pegawai)', strtolower($_GET['term']), true);
      }
      $criteria->order = 'nama_pegawai';
      if (isset($_GET['idPegawai'])) {
        if (!empty($_GET['idPegawai'])) {
          $criteria->addCondition("pegawai_id = " . $_GET['idPegawai']);
        }
      }
      $criteria->group = $criteria->select = 'pegawai_id, nomorindukpegawai, gelardepan, nama_pegawai, gelarbelakang_nama';
      $models = DokterspesialisV::model()->findAll($criteria);
      $returnVal = array();
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->gelardepan . " " . $model->nama_pegawai . ", " . $model->gelarbelakang_nama;
        $returnVal[$i]['value'] = $model->pegawai_id;
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  /**
   * - digunakan untuk mencari data pada master potongan pph 21
   */
  public function actionAmbilPph()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      $pkp = $_POST['pkp'];

      // $sql = "SELECT persentarifpenghsl FROM potonganpph21_m WHERE penghasilandari >= $pkp AND sampaidgn_thn <=$pkp ";
      // $persen_pph = Yii::app()->db->createCommand($sql)->queryAll();

      $conditions = "penghasilandari <= " . $pkp . " AND sampaidgn_thn >=" . $pkp . " ";
      $criteria = new CDbCriteria;
      $criteria->addCondition($conditions);
      $modpph = Potonganpph21M::model()->findAll($criteria);

      foreach ($modpph as $key => $pph) {
        $data['percent'] = $pph->persentarifpenghsl;
      }

      echo json_encode($data);
      Yii::app()->end();
    }
  }

  public function actionMengetahui($pembayaranjasa_id, $approve = false)
  {
    $this->layout = '//layouts/iframe';
    $format = new MyFormatter();
    $model = GJPembayaranjasaT::model()->findByPk($pembayaranjasa_id);
    $modDetail = new GJPembjasadetailT;
    $modDetail->unsetAttributes();
    $modDetail->pembayaranjasa_id = $model->pembayaranjasa_id;

    if ($approve) {
      $update = GJPembayaranjasaT::model()->updateByPk($pembayaranjasa_id, array('tgl_mengetahui' => date("Y-m-d")));
      if ($update) {
        Yii::app()->user->setFlash('success', "Data berhasil disimpan");
        $this->redirect(array('mengetahui', 'pembayaranjasa_id' => $pembayaranjasa_id, 'sukses' => 1));
      } else {
        Yii::app()->user->setFlash('error', "Data Gagal Disimpan");
      }
    }
    $this->render($this->path_view . '_mengetahui', array(
      'format' => $format,
      'model' => $model,
      'modDetail' => $modDetail
    ));
  }

  public function actionPrintMengetahui($pembayaranjasa_id)
  {
    $format = new MyFormatter();
    $model = GJPembayaranjasaT::model()->findByPk($pembayaranjasa_id);
    $modDetail = new GJPembjasadetailT;
    $modDetail->unsetAttributes();
    $modDetail->pembayaranjasa_id = $model->pembayaranjasa_id;

    $caraPrint = (isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null);
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render($this->path_view . 'printMengetahui', array('format' => $format, 'model' => $model, 'modDetail' => $modDetail, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render($this->path_view . 'printMengetahui', array('format' => $format, 'model' => $model, 'modDetail' => $modDetail, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas'); //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas'); //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      //$mpdf->useOddEven = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML($this->renderPartial($this->path_view . 'printMengetahui', array('format' => $format, 'model' => $model, 'modDetail' => $modDetail, 'caraPrint' => $caraPrint), true));
      $mpdf->Output("PengajuanJasa_" . date('Y-m-d') . '.pdf', 'I');
    }
  }
  public function actionMengetahuiPT($pembayaranjasa_id, $approve = false)
  {
    $this->layout = '//layouts/iframe';
    $format = new MyFormatter();
    $model = GJPembayaranjasaT::model()->findByPk($pembayaranjasa_id);
    $modDetail = new GJPembjasadetailT;
    $modDetail->unsetAttributes();
    $modDetail->pembayaranjasa_id = $model->pembayaranjasa_id;

    if ($approve) {
      $update = GJPembayaranjasaT::model()->updateByPk($pembayaranjasa_id, array('tgl_mengetahuipt' => date("Y-m-d")));
      if ($update) {
        Yii::app()->user->setFlash('success', "Data berhasil disimpan");
        $this->redirect(array('mengetahuiPT', 'pembayaranjasa_id' => $pembayaranjasa_id, 'sukses' => 1));
      } else {
        Yii::app()->user->setFlash('error', "Data Gagal Disimpan");
      }
    }
    $this->render($this->path_view . '_mengetahuipt', array(
      'format' => $format,
      'model' => $model,
      'modDetail' => $modDetail
    ));
  }

  public function actionPrintMengetahuiPT($pembayaranjasa_id)
  {
    $format = new MyFormatter();
    $model = GJPembayaranjasaT::model()->findByPk($pembayaranjasa_id);
    $modDetail = new GJPembjasadetailT;
    $modDetail->unsetAttributes();
    $modDetail->pembayaranjasa_id = $model->pembayaranjasa_id;

    $caraPrint = (isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null);
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render($this->path_view . 'printMengetahuipt', array('format' => $format, 'model' => $model, 'modDetail' => $modDetail, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render($this->path_view . 'printMengetahuipt', array('format' => $format, 'model' => $model, 'modDetail' => $modDetail, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas'); //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas'); //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      //$mpdf->useOddEven = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML($this->renderPartial($this->path_view . 'printMengetahuipt', array('format' => $format, 'model' => $model, 'modDetail' => $modDetail, 'caraPrint' => $caraPrint), true));
      $mpdf->Output("PengajuanJasa_" . date('Y-m-d') . '.pdf', 'I');
    }
  }
  public function actionMenyetujui($pembayaranjasa_id, $approve = false)
  {
    $this->layout = '//layouts/iframe';
    $format = new MyFormatter();
    $model = GJPembayaranjasaT::model()->findByPk($pembayaranjasa_id);
    $modDetail = new GJPembjasadetailT;
    $modDetail->unsetAttributes();
    $modDetail->pembayaranjasa_id = $model->pembayaranjasa_id;

    if ($approve) {
      $update = GJPembayaranjasaT::model()->updateByPk($pembayaranjasa_id, array('tgl_menyetujui' => date("Y-m-d")));
      if ($update) {
        Yii::app()->user->setFlash('success', "Data berhasil disimpan");
        $this->redirect(array('menyetujui', 'pembayaranjasa_id' => $pembayaranjasa_id, 'sukses' => 1));
      } else {
        Yii::app()->user->setFlash('error', "Data Gagal Disimpan");
      }
    }
    $this->render($this->path_view . '_menyetujui', array(
      'format' => $format,
      'model' => $model,
      'modDetail' => $modDetail
    ));
  }

  public function actionPrintMenyetujui($pembayaranjasa_id)
  {
    $format = new MyFormatter();
    $model = GJPembayaranjasaT::model()->findByPk($pembayaranjasa_id);
    $modDetail = new GJPembjasadetailT;
    $modDetail->unsetAttributes();
    $modDetail->pembayaranjasa_id = $model->pembayaranjasa_id;

    $caraPrint = (isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null);
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render($this->path_view . 'printMenyetujui', array('format' => $format, 'model' => $model, 'modDetail' => $modDetail, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render($this->path_view . 'printMenyetujui', array('format' => $format, 'model' => $model, 'modDetail' => $modDetail, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas'); //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas'); //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      //$mpdf->useOddEven = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML($this->renderPartial($this->path_view . 'printMenyetujui', array('format' => $format, 'model' => $model, 'modDetail' => $modDetail, 'caraPrint' => $caraPrint), true));
      $mpdf->Output("PengajuanJasa_" . date('Y-m-d') . '.pdf', 'I');
    }
  }

  protected function saveJurnalRekening($modPengajuan)
  {
    $period = Yii::app()->user->getState('periode_ids');
    if (is_array($period)) {
      $period = $period[0];
    }

    $format = new MyFormatter();
    $modJurnalRekening = new JurnalrekeningT;
    $modJurnalRekening->tglbuktijurnal = $format->formatDateTimeForDB($modPengajuan->tglbayarjasa);
    $modJurnalRekening->nobuktijurnal = MyGenerator::noBuktiJurnalRek();
    $modJurnalRekening->kodejurnal = MyGenerator::kodeJurnalRek();
    $modJurnalRekening->noreferensi = 0;
    $modJurnalRekening->tglreferensi = $format->formatDateTimeForDB($modPengajuan->tglbayarjasa);
    $modJurnalRekening->nobku = "";
    $nama_peg = PegawaiM::model()->findByPk($modPengajuan->pegawai_id);
    $modJurnalRekening->urianjurnal = 'Pengajuan Jasa Dokter - ' . date('M Y', strtotime($modPengajuan->periodejasa)) . " - " . (isset($nama_peg) ? $nama_peg->namaLengkap : ""); //$postPenUmum['jenisKodeNama'];

    $modJurnalRekening->jenisjurnal_id = Params::JENISJURNAL_ID_JURNALUMUM_TRANSAKSINONKAS;
    $periodeID = $period;
    $modJurnalRekening->rekperiod_id = $periodeID;
    $modJurnalRekening->create_time = $format->formatDateTimeForDB($modPengajuan->tglbayarjasa);
    $modJurnalRekening->create_loginpemakai_id = Yii::app()->user->id;
    $modJurnalRekening->create_ruangan = Yii::app()->user->getState('ruangan_id');
    $modJurnalRekening->ruangan_id = Yii::app()->user->getState('ruangan_id');
    $modJurnalRekening->pembayaranjasa_id = $modPengajuan->pembayaranjasa_id;

    if ($modJurnalRekening->validate()) {
      $modJurnalRekening->save();
      $this->suksesSimpanDetail = true;
    } else {
      $this->suksesSimpanDetail = false;
      $this->pesan = $modJurnalRekening->getErrors();
    }
    return $modJurnalRekening;
  }

  public function saveJurnalDetail($modPengajuan, $postRekenings, $modJurnalRekening)
  {
    $valid = true;
    //            $modJurnalPosting = null;
    //            if(Yii::app()->user->getState('ispostingotomatis') == true)
    //            {
    //                $modJurnalPosting = new JurnalpostingT;
    //                $modJurnalPosting->tgljurnalpost = date('Y-m-d H:i:s');
    //                $modJurnalPosting->keterangan = "Posting automatis";
    //                $modJurnalPosting->create_time = date('Y-m-d H:i:s');
    //                $modJurnalPosting->create_loginpemekai_id = Yii::app()->user->id;
    //                $modJurnalPosting->create_ruangan = Yii::app()->user->getState('ruangan_id');
    //                if($modJurnalPosting->validate()){
    //                    $modJurnalPosting->save();
    //                }
    //            }

    foreach ($postRekenings as $i => $rekening) {
      // $rekening4_id = Rekening5M::model()->findByPk($rekening->rekening5_id)->rekening4_id;
      // $rekening3_id = Rekening4M::model()->findByPk($rekening4_id)->rekening3_id;
      // $rekening2_id = Rekening3M::model()->findByPk($rekening3_id)->rekening2_id;
      // $rekening1_id = Rekening2M::model()->findByPk($rekening2_id)->rekening1_id;

      $model[$i] = new JurnaldetailT();
      //                $model[$i]->jurnalposting_id = ($modJurnalPosting == null ? null : $modJurnalPosting->jurnalposting_id);
      $model[$i]->rekperiod_id = $modJurnalRekening->rekperiod_id;
      $model[$i]->jurnalrekening_id = $modJurnalRekening->jurnalrekening_id;
      $model[$i]->uraiantransaksi = Rekening5M::model()->findByPk($rekening->rekening5_id)->nmrekening5;
      $nilaiRekening = 0;
      if ($rekening->rekeningcolumn_id == Params::REKENINGCOLUMN_ID_PEMBAYARANJASAMEDIS_PPH21 || $rekening->rekeningcolumn_id == Params::REKENINGCOLUMN_ID_PEMBAYARANJASAMEDIS_STP) {
        $nilaiRekening = $modPengajuan->total_pajak;
      }

      if ($rekening->rekeningcolumn_id == Params::REKENINGCOLUMN_ID_PEMBAYARANJASAMEDIS_LAINLAIN  || $rekening->rekeningcolumn_id == Params::REKENINGCOLUMN_ID_PEMBAYARANJASAMEDIS_YMH) {
        $nilaiRekening = $modPengajuan->totalbayarjasa;
      }

      $model[$i]->saldodebit = ($rekening->debitkredit == "D") ? $nilaiRekening : 0;
      $model[$i]->saldokredit = ($rekening->debitkredit == "K") ? $nilaiRekening : 0;
      $model[$i]->nourut = $i + 1;
      // $model[$i]->rekening1_id = $rekening1_id;
      // $model[$i]->rekening2_id = $rekening2_id;
      // $model[$i]->rekening3_id = $rekening3_id;
      // $model[$i]->rekening4_id = $rekening4_id;
      $model[$i]->rekening5_id = $rekening->rekening5_id;
      $model[$i]->catatan = "";
      if ($model[$i]->validate()) {
        $model[$i]->save();
      } else {
        //                      KARENA TIDAK DI SEMUA CONTROLLER DI DEKLARASIKAN >>  $this->pesan = $model[$i]->getErrors();
        $valid = false;
        break;
      }
    }

    return $valid;
  }

  public function actionFormulir($pembayaranjasa_id)
  {
    $this->layout = '//layouts/iframe';
    $format = new MyFormatter();
    $model = PembayaranjasaT::model()->findByPk($pembayaranjasa_id);
    $modelPajak = PajakdokterT::model()->findByPk($model->pajakdokter_id);
    $modelPegawai = PegawaiM::model()->findByPk($modelPajak->pegawai_id);
    $profil = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());

    $caraPrint = (isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null);
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render($this->path_view . 'formulir', array(
        'format' => $format,
        'modelPajak' => $modelPajak,
        'model' => $model,
        'modelPegawai' => $modelPegawai,
        'profil' => $profil,
        'caraPrint' => $caraPrint,
      ));
    } else {
      $this->render($this->path_view . 'formulir', array(
        'format' => $format,
        'modelPajak' => $modelPajak,
        'model' => $model,
        'modelPegawai' => $modelPegawai,
        'profil' => $profil,
      ));
    }
  }

  public function actionPrintBuktiPotong()
  {
    $format = new MyFormatter();
    $model = array();

    if (isset($_GET['GJPembayaranjasaT'])) {
      $modelJasa = new GJPembayaranjasaT();
      $modelJasa->unsetAttributes();  // clear any default values
      $modelJasa->attributes = $_GET['GJPembayaranjasaT'];
      $modelJasa->namaDokter = $_GET['GJPembayaranjasaT']['namaDokter'];
      $modelJasa->kelompokpegawai_id = isset($_GET['GJPembayaranjasaT']['kelompokpegawai_id']) ? $_GET['GJPembayaranjasaT']['kelompokpegawai_id'] : null;
      $modelJasa->jabatan_id = isset($_GET['GJPembayaranjasaT']['jabatan_id']) ? $_GET['GJPembayaranjasaT']['jabatan_id'] : null;
      $modelJasa->jenisjasa = isset($_GET['GJPembayaranjasaT']['jenisjasa']) ? $_GET['GJPembayaranjasaT']['jenisjasa'] : null;
      $modelJasa->status_gaji = isset($_GET['GJPembayaranjasaT']['status_gaji']) ? $_GET['GJPembayaranjasaT']['status_gaji'] : null;
      $modelJasa->tgl_awal = $format->formatDateTimeForDb($_GET['GJPembayaranjasaT']['tgl_awal']);
      $modelJasa->tgl_akhir = $format->formatDateTimeForDb($_GET['GJPembayaranjasaT']['tgl_akhir']);
      $modelJasa->cekPeriode = isset($_GET['GJPembayaranjasaT']['cekPeriode']) ? $_GET['GJPembayaranjasaT']['cekPeriode'] : null;

      if (!empty($modelJasa->cekPeriode)) {
        $modelJasa->cari_period = MyFormatter::formatMonthForDB($_GET['GJPembayaranjasaT']['cari_period']) . '-01';
      } else {
        $modelJasa->cari_period = null;
      }

      $prov = $modelJasa->searchInformasiBaru();
      $prov->criteria->order = 'nama_pegawai asc';
      $prov->pagination = false;
      $model = $prov->data;
    }

    $judulLaporan = 'Bukti Potong';
    $caraPrint = (isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null);
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render($this->path_view . 'printBuktiPotong', array('format' => $format, 'model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render($this->path_view . 'printBuktiPotong', array('format' => $format, 'model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas'); //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas'); //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      //$mpdf->useOddEven = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML($this->renderPartial($this->path_view . 'printBuktiPotong', array('format' => $format, 'model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output();
    }
  }

  public function actionPrintSlipDokter($pembayaranjasa_id)
  {
    $model = GJPembayaranjasaT::model()->findByPk($pembayaranjasa_id);

    $caraPrint = $_REQUEST['caraPrint'];
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render($this->path_view . 'PrintSlipDokter', array('model' => $model, 'caraPrint' => $caraPrint));
    }
  }
}
