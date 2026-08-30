<?php

/**
 *   - digunakan sebagai url utama untuk mengelola transaksi asesmen nyeri
 *   @author	M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 *   @website	<piindonesia.co.id>
 */

class AsesmenNyeriController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/iframe';
  public $defaultAction = 'index';
  public $path_view = 'rawatInap.views.asesmenNyeri.';
  public $init = '';

  public function actionIndex($pendaftaran_id = '', $asesmentnyeri_id = '')
  {
    $format = new MyFormatter();
    $edit = false;
    $idedit = '';
    $model = new RIAsesmentnyeriT();
    $modriwayat = new RIAsesmentnyeriT();
    $modriwayat->pendaftaran_id = $pendaftaran_id;

    $model->tglpemeriksaannyeri = MyFormatter::formatDateTimeForUser(date('d M Y H:i:s'));


    $modNyeriAnakDet = new RIAsesmentnyerianakdetT;

    $modPendaftaran = RIPendaftaranT::model()->findByPk($pendaftaran_id);


    $modPasien = RIPasienM::model()->findByPk($modPendaftaran->pasien_id);
    $umur = CustomFunction::getUmurTahun($modPasien->tanggal_lahir, $modPendaftaran->tgl_pendaftaran);
    $cekAsesNyeri = array();

    if (Yii::app()->user->getState('is_nicu')) { // bayi
      $model->is_keluhannyeribayi = true;
      $model->is_keluhannyeri_dewasa = 0;
    } else {
      $model->is_keluhannyeribayi = false;
      $model->is_keluhannyeri_dewasa = 1;
    }

    //kondisi jika update
    if (!empty($asesmentnyeri_id)) {
      $edit = true;
      $idedit = $pendaftaran_id;
      $cekAsesNyeri = RIAsesmentnyeriT::model()->findByAttributes(array('asesmentnyeri_id' => $asesmentnyeri_id));
    }
    //$cekAsesNyeri = RIAsesmentnyeriT::model()->findByAttributes(array('pendaftaran_id'=>$pendaftaran_id));

    $criFla = new CDbCriteria();
    $criFla->select = " t.*,  ksn.kat_skalanyeri_nama ";
    $criFla->join = " JOIN kategoriskalanyeri_m ksn ON ksn.kat_skalanyeri_id = t.kat_skalanyeri_id ";
    $criFla->addCondition(" skalanyeriflaccs_aktif = TRUE ");
    $modNyeriFlaCcs = RISkalanyeriflaccsM::model()->findAll($criFla);

    $getFlaCcs = null;

    $dataFlaCcs = array();
    $cekFlaCcs = array();

    $modFlaCcs = new RIAsesmentnyerianakdetT;

    $modGambarTubuh = new RIGambartubuhM();

    $modBagianTubuh = new RIBagiantubuhM();



    if (!empty($cekAsesNyeri)) {
      $getFlaCcs = RIAsesmentnyerianakdetT::model()->findAllByAttributes(array('asesmentnyeri_id' => $cekAsesNyeri->asesmentnyeri_id));

      if (count((array)$getFlaCcs) > 0)
        foreach ($getFlaCcs as $det) {
          $cekFlaCcs["$det->kat_skalanyeri_id"]['id'] = $det->asesmentnyerianakdet_id;
          $cekFlaCcs["$det->kat_skalanyeri_id"]['kat_id'] = $det->kat_skalanyeri_id;
          $cekFlaCcs["$det->kat_skalanyeri_id"]['nilai'] = $det->skalanyeriflaccs_nilai;
          $cekFlaCcs["$det->kat_skalanyeri_id"]['params'] = $det->skalanyeriflaccs_param;
          $cekFlaCcs["$det->kat_skalanyeri_id"]["$det->skalanyeriflaccs_param"]['id'] = $det->asesmentnyerianakdet_id;
        }

      $model = $cekAsesNyeri;

      if ($model->is_keluhannyeri_dewasa) {
        $model->is_keluhannyeri_dewasa = 1;
      } else {
        if ($model->keluhannyeri) {
          $model->is_keluhannyeri_dewasa = 0;

          $model->scoreanak = $model->score_skalanyeri;
          $model->keterangananak = $model->keteranganskala_nyeri;

          $model->score_skalanyeri = '';
          $model->keteranganskala_nyeri = '';
        } else {
          $model->is_keluhannyeri_dewasa = 0;
        }
      }

      $modPemeriksaanGambar = RIPemeriksaangambarnyeriT::model()->findAllByAttributes(array('pendaftaran_id' => $pendaftaran_id, 'asesmentnyeri_id' => $cekAsesNyeri->asesmentnyeri_id));
    } else {
      $model->is_keluhannyeri_dewasa = 1;
      $modPemeriksaanGambar = RIPemeriksaangambarnyeriT::model()->findAll("pendaftaran_id is null");
    }

    foreach ($modNyeriFlaCcs as $dtF) {
      $dataFlaCcs["$dtF->kat_skalanyeri_id"]["kategori"] = $dtF->kat_skalanyeri_nama;
      $dataFlaCcs["$dtF->kat_skalanyeri_id"]["kategori_id"] = $dtF->kat_skalanyeri_id;
      $dataFlaCcs["$dtF->kat_skalanyeri_id"]["val_anak_id"] = isset($cekFlaCcs["$dtF->kat_skalanyeri_id"]['id']) ? $cekFlaCcs["$dtF->kat_skalanyeri_id"]['id'] : null;
      $dataFlaCcs["$dtF->kat_skalanyeri_id"]["val_kat_id"] = isset($cekFlaCcs["$dtF->kat_skalanyeri_id"]['kat_id']) ? $cekFlaCcs["$dtF->kat_skalanyeri_id"]['kat_id'] : null;
      $dataFlaCcs["$dtF->kat_skalanyeri_id"]["val_params"] = isset($cekFlaCcs["$dtF->kat_skalanyeri_id"]['params']) ? $cekFlaCcs["$dtF->kat_skalanyeri_id"]['params'] : null;
      $dataFlaCcs["$dtF->kat_skalanyeri_id"]["val_nilai"] = isset($cekFlaCcs["$dtF->kat_skalanyeri_id"]['nilai']) ? $cekFlaCcs["$dtF->kat_skalanyeri_id"]['nilai'] : null;
      $dataFlaCcs["$dtF->kat_skalanyeri_id"]["$dtF->skalanyeriflaccs_param"][] = array(
        'id' => isset($cekFlaCcs["$dtF->kat_skalanyeri_id"]['id']) ? $cekFlaCcs["$dtF->kat_skalanyeri_id"]['id'] : null,
        'keterangan' => $dtF->skalanyeriflaccs_desc
      );
      $dataFlaCcs["$dtF->kat_skalanyeri_id"]["$dtF->skalanyeriflaccs_param"]['id'] = isset($cekFlaCcs["$dtF->kat_skalanyeri_id"]["$dtF->skalanyeriflaccs_param"]['id']) ? $cekFlaCcs["$dtF->kat_skalanyeri_id"]["$dtF->skalanyeriflaccs_param"]['id'] : null;
    }


    if (isset($_POST['RIAsesmentnyeriT'])) {
      $ok = true;

      $transaction = Yii::app()->db->beginTransaction();
      try {

        $model->attributes = $_POST['RIAsesmentnyeriT'];
        $model->tglpemeriksaannyeri = MyFormatter::formatDateTimeForDb($_POST['RIAsesmentnyeriT']['tglpemeriksaannyeri']);

        $model->pegawaipemeriksa_id = Yii::app()->user->getState('pegawai_id');
        $model->pendaftaran_id = $modPendaftaran->pendaftaran_id;
        $model->pasien_id = $modPendaftaran->pasien_id;
        $model->create_time = date("Y-m-d H:i:s");
        $model->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
        $model->create_ruangan_id = Yii::app()->user->getState('ruangan_id');

        /*
                    
                    
                    if ($model->is_keluhannyeri_dewasa == 'anak'){
                        $model->is_keluhannyeri_dewasa = false;
                        $model->score_skalanyeri = !empty($_POST['RIAsesmentnyeriT']['scoreanak'])?$_POST['RIAsesmentnyeriT']['scoreanak']:0;
                        $model->keteranganskala_nyeri = !empty($_POST['RIAsesmentnyeriT']['keterangananak'])?$_POST['RIAsesmentnyeriT']['keterangananak']:null;
                    }elseif ($model->is_keluhannyeri_dewasa == 'dewasa'){
                        $model->is_keluhannyeri_dewasa = true;
                    }else{
                        $model->is_keluhannyeri_dewasa = null;
                    }
                     * 
                     */

        //die;



        $ok = $ok && $model->save();
        // var_dump($model->attributes, $_POST);

        AsesmentnyeribayidetT::model()->deleteAllByAttributes(array(
          'asesmentnyeri_id' => $model->asesmentnyeri_id,
        ));

        RIAsesmentnyerianakdetT::model()->deleteAllByAttributes(array(
          'asesmentnyeri_id' => $model->asesmentnyeri_id,
        ));



        if (isset($_POST['AsesmentnyeribayidetT'])) {
          foreach ($_POST['AsesmentnyeribayidetT'] as $penilaian => $nilai) {
            $det = new AsesmentnyeribayidetT;
            $det->attributes = $nilai;
            $det->parameter = $penilaian;
            $det->asesmentnyeri_id = $model->asesmentnyeri_id;

            $ok = $ok && $det->save();
          }
        }

        if ($model->is_keluhannyeri_dewasa != 1) {

          if (isset($_POST['RIAsesmentnyerianakdetT'])) {

            foreach ($_POST['RIAsesmentnyerianakdetT'] as $cA => $detAnak) {
              $skalanyeri = 0;
              if (!empty($detAnak['kat_skalanyeri_id'])) {
                $modNyeriAnakDet = new RIAsesmentnyerianakdetT;
                $modNyeriAnakDet->attributes = $_POST['RIAsesmentnyerianakdetT'][$cA];
                $modNyeriAnakDet->asesmentnyeri_id = $model->asesmentnyeri_id;
                $modNyeriAnakDet->tgl_asesmentnyerianakdet = date('Y-m-d H:i:s');
                $modNyeriAnakDet->create_time = date('Y-m-d H:i:s');
                $modNyeriAnakDet->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
                $modNyeriAnakDet->create_ruangan_id = Yii::app()->user->getState('ruangan_id');
                $skalanyeri += $modNyeriAnakDet['skalanyeriflaccs_nilai'];
                $ok = $ok && $modNyeriAnakDet->save();
              }
            }

            $model->score_skalanyeri = $_POST['RIAsesmentnyeriT']['scoreanak'];
            $model->keteranganskala_nyeri = $_POST['RIAsesmentnyeriT']['keterangananak'];
            $model->save();
          }
        }

        /*
                    
                    if (isset($_POST['RIPemeriksaangambarnyeriT'])){
                        foreach($_POST['RIPemeriksaangambarnyeriT'] as $gbr => $dtGbr){
                            $skalanyeri = 0;
                           
                            if (empty($dtGbr['pemeriksaangambarnyeri_id'])){
                                $modLokasiNyeri = new RIPemeriksaangambarnyeriT;
                                $modLokasiNyeri->attributes = $_POST['RIPemeriksaangambarnyeriT'][$gbr];
                                $modLokasiNyeri->asesmentnyeri_id = $model->asesmentnyeri_id;
                                $modLokasiNyeri->pendaftaran_id = $modPendaftaran->pendaftaran_id; 
                                $modLokasiNyeri->pasien_id = $modPendaftaran->pasien_id; 
                                $modLokasiNyeri->tglpemeriksaan = date('Y-m-d H:i:s');
                                $modLokasiNyeri->create_time = date('Y-m-d H:i:s');
                                $modLokasiNyeri->create_loginpemakai_id = Yii::app()->user->id;
                                $modLokasiNyeri->create_ruangan = Yii::app()->user->getState('ruangan_id');
                                
                               $ok = $ok &&  $modLokasiNyeri->save();       
                            }
                            
                        }
                                                
                    }
                     * 
                     */

        // var_dump($model->attributes); die;

        // var_dump($ok); die;
        if ($ok) {
          $p = PendaftaranT::model()->findByPk($model->pendaftaran_id);
          $p->setStatusPeriksa(Params::STATUSPERIKSA_SEDANG_PERIKSA);

          $transaction->commit();
          if (!empty($_GET['update'])) {
            Yii::app()->user->setFlash('success', "Data Berhasil Diubah");
          } else {
            Yii::app()->user->setFlash('success', "Data Berhasil Disimpan");
          }


          $this->redirect(array('index', 'pendaftaran_id' => $pendaftaran_id, 'sukses' => 1));
        } else {
          //var_dump($modFisik->getErrors());die;
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data gagal disimpan " . CHtml::errorSummary($model));
        }
      } catch (Exception $exc) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
      }
    }
    


    $model->tglpemeriksaannyeri = MyFormatter::formatDateTimeForUser(date('Y-m-d H:i:s'));
    $this->render($this->path_view . 'index', array(
      'modPendaftaran' => $modPendaftaran,
      'modPasien' => $modPasien,
      'dataFlaCcs' => $dataFlaCcs,
      'modFlaCcs' => $modFlaCcs,
      'getFlaCcs' => $getFlaCcs,
      'model' => $model,
      'modriwayat' => $modriwayat,
      'format' => $format,
      'modGambarTubuh' => $modGambarTubuh,
      'modPemeriksaanGambar' => $modPemeriksaanGambar,
      'modNyeriAnakDet' => $modNyeriAnakDet,
      'modBagianTubuh' => $modBagianTubuh,
      'edit' => $edit,
      'idedit' => $idedit
    ));
  }

  public function actionGetBagianTubuhId()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $pesan = '';
      $data = array();
      $kordinat_x = $_POST['kordinat_x'];
      $kordinat_y = $_POST['kordinat_y'];
      //				$loadPemeriskaanGamabr = RJPemeriksaangambarT::model()->findByPk($_POST['pemeriksaangambar_id']);
      $sql = "select bagiantubuh_id, namabagtubuh from bagiantubuh_m where (" . $kordinat_x . " >= kordinat_x2 AND " . $kordinat_x . " <= kordinat_x) AND (" . $kordinat_y . " >= kordinat_y AND " . $kordinat_y . " <= kordinat_y2) ORDER BY bagiantubuh_urutan ASC LIMIT 1";
      $result = Yii::app()->db->createCommand($sql)->queryRow();
      if ($result) {
        $data['pesan'] = '';
        $data['namabagtubuh'] = $result['namabagtubuh'];
        $data['bagiantubuh_id'] = $result['bagiantubuh_id'];
        echo json_encode($data);

        //					$pesan = '';
        //					$namabagtubuh = $result['namabagtubuh'];
        //					echo CJSON::encode(array('pesan'=>$pesan, 'namabagtubuh'=>$namabagtubuh));
      } else {
        $pesan = "Bagian tubuh belum disetting!";
        echo CJSON::encode(array('pesan' => $pesan));
      }
    }
    Yii::app()->end();
  }

  public function actionTambahBagianTubuh()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $pesan = '';
      $form = '';
      if (!empty($_POST['bagiantubuh_id'])) {
        $modPemeriksaanGbr = new RIPemeriksaangambarnyeriT();
        $modPemeriksaanGbr->bagiantubuh_id      = $_POST['bagiantubuh_id'];
        $modPemeriksaanGbr->namabagtubuh      = $modPemeriksaanGbr->bagiantubuh->namabagtubuh;
        $modPemeriksaanGbr->keterangan_periksa_gbr    = $_POST['keterangan'];
        $modPemeriksaanGbr->kordinat_tubuh_x    = $_POST['pic_x'];
        $modPemeriksaanGbr->kordinat_tubuh_y    = $_POST['pic_y'];
        $modPemeriksaanGbr->gambartubuh_id          = $_POST['gambartubuh_id'];
        $form = $this->renderPartial($this->path_view . 'form/_rowDetail', array('modPemeriksaanGbr' => $modPemeriksaanGbr), true);
        $axis['x'] = $modPemeriksaanGbr->kordinat_tubuh_x;
        $axis['y'] = $modPemeriksaanGbr->kordinat_tubuh_y;
        echo CJSON::encode(array('pesan' => $pesan, 'form' => $form, 'axis' => $axis, 'bagiantubuh_id' => $modPemeriksaanGbr->bagiantubuh_id));
      } else {
        $pesan = 'Bagian tubuh tidak boleh kosong!';
        echo CJSON::encode(array('pesan' => $pesan));
      }
    }
    Yii::app()->end();
  }

  public function actionHapusBagianTubuh()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $pesan = '';
      $ok = 0;
      $del = true;




      $ok = RIPemeriksaangambarnyeriT::model()->findByAttributes(
        array(
          'pemeriksaangambarnyeri_id' => $_POST['pemeriksaangambarnyeri_id'],
          'gambartubuh_id' => $_POST['gambartubuh_id'],
          'bagiantubuh_id' => $_POST['bagiantubuh_id'],
          'keterangan_periksa_gbr' => $_POST['keterangan_periksa_gbr'],
        )
      );

      if (!empty($ok)) {
        $del = $del && $ok->delete();
      }



      if ($del) {
        $pesan = 'Data Berhasil Dihapus dari database';
        $ok = 1;
        echo CJSON::encode(array('pesan' => $pesan, 'ok' => $ok));
      } else {
        $ok = 0;
        $pesan = "Bagian Tubuh gagal dihapus!";
        echo CJSON::encode(array('pesan' => $pesan, 'ok' => $ok));
      }
    }
    Yii::app()->end();
  }
  public function actionDeleteriwayat()
  {
    if (Yii::app()->request->isAjaxRequest) {


      //RIAsesmentnyeriT
      $model = RIAsesmentnyeriT::model()->findByPk($_POST['id']);
      $modases = $model->asesmentnyeri_id;



      $cri = new CDbCriteria();
      $cri->addCondition("asesmentnyeri_id = '" . $modases . "' ");
      $up1 = RIPemeriksaangambarnyeriT::model()->deleteAll($cri);
      $up = RIPemeriksaangambarnyeriT::model()->deleteAll($cri);


      if ($model->delete()) {
        $data['status'] = 'sukses';
      } else {
        $data['status'] = 'gagal';
      }


      echo CJSON::encode($data);
    }
    Yii::app()->end();
  }

  public function actionLihatDetail($asesmentnyeri_id)
  {
    $this->layout = "//layouts/iframe";


    $format = new MyFormatter();

    $model = new RIAsesmentnyeriT();
    $modriwayat = new RIAsesmentnyeriT();
    $modriwayat->asesmentnyeri_id = $asesmentnyeri_id;

    //$model->tglpemeriksaannyeri = date('d M Y H:i:s');

    $modNyeriAnakDet = new RIAsesmentnyerianakdetT;

    //$umur = CustomFunction::getUmurTahun($modPasien->tanggal_lahir, $modPendaftaran->tgl_pendaftaran);

    $cekAsesNyeri = RIAsesmentnyeriT::model()->findByAttributes(array('asesmentnyeri_id' => $asesmentnyeri_id));

    $criFla = new CDbCriteria();
    $criFla->select = " t.*,  ksn.kat_skalanyeri_nama ";
    $criFla->join = " JOIN kategoriskalanyeri_m ksn ON ksn.kat_skalanyeri_id = t.kat_skalanyeri_id ";
    $criFla->addCondition(" skalanyeriflaccs_aktif = TRUE ");
    $modNyeriFlaCcs = RISkalanyeriflaccsM::model()->findAll($criFla);

    $getFlaCcs = null;

    $dataFlaCcs = array();
    $cekFlaCcs = array();

    $modFlaCcs = new RIAsesmentnyerianakdetT;

    $modGambarTubuh = new RIGambartubuhM();

    $modBagianTubuh = new RIBagiantubuhM();


    if (!empty($cekAsesNyeri)) {
      $getFlaCcs = RIAsesmentnyerianakdetT::model()->findAllByAttributes(array('asesmentnyeri_id' => $cekAsesNyeri->asesmentnyeri_id));

      if (count((array)$getFlaCcs) > 0)
        foreach ($getFlaCcs as $det) {
          $cekFlaCcs["$det->kat_skalanyeri_id"]['id'] = $det->asesmentnyerianakdet_id;
          $cekFlaCcs["$det->kat_skalanyeri_id"]['kat_id'] = $det->kat_skalanyeri_id;
          $cekFlaCcs["$det->kat_skalanyeri_id"]['nilai'] = $det->skalanyeriflaccs_nilai;
          $cekFlaCcs["$det->kat_skalanyeri_id"]['params'] = $det->skalanyeriflaccs_param;
          $cekFlaCcs["$det->kat_skalanyeri_id"]["$det->skalanyeriflaccs_param"]['id'] = $det->asesmentnyerianakdet_id;
        }

      $model = $cekAsesNyeri;

      if ($model->is_keluhannyeri_dewasa) {
        $model->is_keluhannyeri_dewasa = '1';
      } else {
        if ($model->keluhannyeri) {
          $model->is_keluhannyeri_dewasa = '0';

          $model->scoreanak = $model->score_skalanyeri;
          $model->keterangananak = $model->keteranganskala_nyeri;

          $model->score_skalanyeri = '';
          $model->keteranganskala_nyeri = '';
        } else {
          $model->is_keluhannyeri_dewasa = '0';
        }
      }

      $modPemeriksaanGambar = RIPemeriksaangambarnyeriT::model()->findAllByAttributes(array('asesmentnyeri_id' => $asesmentnyeri_id, 'asesmentnyeri_id' => $cekAsesNyeri->asesmentnyeri_id));
    } else {
      $model->is_keluhannyeri_dewasa = '0';
      $modPemeriksaanGambar = RIPemeriksaangambarnyeriT::model()->findAll("pendaftaran_id is null");
    }

    foreach ($modNyeriFlaCcs as $dtF) {
      $dataFlaCcs["$dtF->kat_skalanyeri_id"]["kategori"] = $dtF->kat_skalanyeri_nama;
      $dataFlaCcs["$dtF->kat_skalanyeri_id"]["kategori_id"] = $dtF->kat_skalanyeri_id;
      $dataFlaCcs["$dtF->kat_skalanyeri_id"]["val_anak_id"] = isset($cekFlaCcs["$dtF->kat_skalanyeri_id"]['id']) ? $cekFlaCcs["$dtF->kat_skalanyeri_id"]['id'] : null;
      $dataFlaCcs["$dtF->kat_skalanyeri_id"]["val_kat_id"] = isset($cekFlaCcs["$dtF->kat_skalanyeri_id"]['kat_id']) ? $cekFlaCcs["$dtF->kat_skalanyeri_id"]['kat_id'] : null;
      $dataFlaCcs["$dtF->kat_skalanyeri_id"]["val_params"] = isset($cekFlaCcs["$dtF->kat_skalanyeri_id"]['params']) ? $cekFlaCcs["$dtF->kat_skalanyeri_id"]['params'] : null;
      $dataFlaCcs["$dtF->kat_skalanyeri_id"]["val_nilai"] = isset($cekFlaCcs["$dtF->kat_skalanyeri_id"]['nilai']) ? $cekFlaCcs["$dtF->kat_skalanyeri_id"]['nilai'] : null;
      $dataFlaCcs["$dtF->kat_skalanyeri_id"]["$dtF->skalanyeriflaccs_param"][] = array(
        'id' => isset($cekFlaCcs["$dtF->kat_skalanyeri_id"]['id']) ? $cekFlaCcs["$dtF->kat_skalanyeri_id"]['id'] : null,
        'keterangan' => $dtF->skalanyeriflaccs_desc
      );
      $dataFlaCcs["$dtF->kat_skalanyeri_id"]["$dtF->skalanyeriflaccs_param"]['id'] = isset($cekFlaCcs["$dtF->kat_skalanyeri_id"]["$dtF->skalanyeriflaccs_param"]['id']) ? $cekFlaCcs["$dtF->kat_skalanyeri_id"]["$dtF->skalanyeriflaccs_param"]['id'] : null;
    }



    $model->tglpemeriksaannyeri = MyFormatter::formatDateTimeForUser($model->tglpemeriksaannyeri);

    $this->render($this->path_view . 'detail', array(


      'dataFlaCcs' => $dataFlaCcs,
      'modFlaCcs' => $modFlaCcs,
      'getFlaCcs' => $getFlaCcs,
      'model' => $model,
      'modriwayat' => $modriwayat,
      'format' => $format,
      'modGambarTubuh' => $modGambarTubuh,
      'modPemeriksaanGambar' => $modPemeriksaanGambar,
      'modNyeriAnakDet' => $modNyeriAnakDet,
      'modBagianTubuh' => $modBagianTubuh
    ));
  }
}
