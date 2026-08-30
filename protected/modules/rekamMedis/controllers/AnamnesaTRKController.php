<?php
class AnamnesaTRKController extends MyAuthController
{
  public $layout = '//layouts/iframe';
  public $defaultAction = 'index';
  public $path_view = 'rekamMedis.views.anamnesaRK.';

  public function actionIndex($pendaftaran_id)
  {
    if (isset($_GET['noIframe'])) {
      $this->layout = '//layouts/mainNeonSidebar';
    }
    $format = new MyFormatter();
    //            $this->layout='//layouts/iframe';
    $modPendaftaran = RKPendaftaranT::model()->findByPk($pendaftaran_id);

    $modPasien = RKPasienM::model()->findByPk($modPendaftaran->pasien_id);

    $dataPendaftaran = RKPendaftaranT::model()->findAllByAttributes(array('pasien_id' => $modPasien->pasien_id), array('order' => 'tgl_pendaftaran DESC'));
    $konsul = ($modPendaftaran->ruangan_id == Yii::app()->user->getState('ruangan_id')) ? null : KonsulpoliT::model()->findByAttributes(array(
      'pendaftaran_id' => $modPendaftaran->pendaftaran_id,
      'ruangan_id' => Yii::app()->user->getState('ruangan_id'),
    ), array(
      'order' => 'tglkonsulpoli desc',
    ));

    $i = 1;
    if (count((array)$dataPendaftaran) > 1) {
      foreach ($dataPendaftaran as $row) {
        if ($i == 2) {
          $lastPendaftaran = $row->pendaftaran_id;
        }
        $i++;
      }
    } else {
      $lastPendaftaran = $pendaftaran_id;
    }


    $cekAnamnesa = RKAnamnesaT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));
    $modDiagnosa = new RKDiagnosaM;

    if (!empty($cekAnamnesa)) {  //Jika Pasien Sudah Melakukan Anamnesa Sebelumnya				
      $modAnamnesa = new RKAnamnesaT;

      $detTriase = (isset($_POST['RJTriase']) ? $_POST['RJTriase'] : null);
      if (isset($detTriase)) {
        if (count((array)$detTriase) > 0) {
          foreach ($detTriase as $i => $triase) {
            $modAnamnesa->triase_id = $triase['triase_id'];
          }
        }
      }

      $modAnamnesa = $cekAnamnesa;

      $lama = explode(" ", $modAnamnesa->lamasakit);
      $modAnamnesa->lamasakit = $lama[0];
      if (!empty($lama[1])) $modAnamnesa->satuanWaktu = $lama[1];

      //if ($modAnamnesa->paramedis_nama) $pegawai = PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));
      //$modAnamnesa->paramedis_nama = empty($pegawai)?null:$pegawai->nama_pegawai;

      //$modAnamnesa->riwayatimunisasi = $modPendaftaran->statuspasien;
    } else {
      ////Jika Pasien Belum Pernah melakukan Anamnesa
      $modAnamnesa = new RKAnamnesaT;
      $modAnamnesa->pegawai_id = $modPendaftaran->pegawai_id;
      //                $modAnamnesa->paramedis_nama = "Rina Trianasari, AMd. AK";
      $pegawai = PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));
      $modAnamnesa->paramedis_nama = empty($pegawai) ? null : $pegawai->nama_pegawai;
      $modAnamnesa->pendaftaran_id = $modPendaftaran->pendaftaran_id;
      $modAnamnesa->pasien_id = $modPendaftaran->pasien_id;
      $modAnamnesa->tglanamnesis = date('Y-m-d H:i:s');
      $modAnamnesa->update_loginpemakai_id = Yii::app()->user->id;
      $modAnamnesa->create_time = date('Y-m-d H:i:s');
      $modAnamnesa->statusmerokok = 0;
      //$isPasien = RJPendaftaranT::model()->findByPk($pendaftaran_id)->statuspasien;
      //                $sql = "SELECT c(diagnosa_id) FROM pasienimunisasi_t WHERE pendaftaran_id = $pendaftaran_id";
      //                $stoks = Yii::app()->db->createCommand($sql)->queryAll();
      if (!empty($konsul)) {
        $modPendaftaran->pegawai_id = $konsul->pegawai_id;
        $modPendaftaran->ruangan_id = $konsul->ruangan_id;
        $modAnamnesa->pegawai_id = $konsul->pegawai_id;
      }
    }



    if ($modPendaftaran->statuspasien == "PENGUNJUNG LAMA") {
      $modDiagnosaTerdahulu = RKPasienMorbiditasT::model()->with('diagnosa')->findAllByAttributes(array('pasien_id' => $modPasien->pasien_id, 'pendaftaran_id' => $lastPendaftaran));

      $hasilImunisasi = array();
      $hasilDiagnosaDahulu = array();
      foreach ($modDiagnosaTerdahulu as $row) {
        if ($row->diagnosa->diagnosa_imunisasi == true)
          $hasilImunisasi[] = (isset($row->diagnosa->diagnosa_nama) ? $row->diagnosa->diagnosa_nama : "");
        else
          $hasilDiagnosaDahulu[] = (isset($row->diagnosa->diagnosa_nama) ? $row->diagnosa->diagnosa_nama : "");
      }
      if (empty($modAnamnesa->riwayatimunisais)) {
        $modAnamnesa->riwayatimunisasi = implode(', ', $hasilImunisasi);
      }
      if (empty($modAnamnesa->riwayatpenyakitterdahulu)) {
        $modAnamnesa->riwayatpenyakitterdahulu = implode(', ', $hasilDiagnosaDahulu);
      }
    }

    //echo $modAnamnesa->riwayatpenyakitterdahulu;exit();
    if (isset($_POST['RKAnamnesaT'])) {
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $detTriase = (isset($_POST['RKTriase']) ? $_POST['RJTriase'] : null);
        $modAnamnesa->attributes = $_POST['RKAnamnesaT'];
        $modAnamnesa->lamasakit .= " " . $_POST['RKAnamnesaT']['satuanWaktu'];

        if (empty($modAnamnesa->hpht)) $modAnamnesa->hpht = null;
        if (empty($modAnamnesa->tgl_persalinan)) $modAnamnesa->tgl_persalinan = null;
        if (isset($detTriase)) {
          if (count((array)$detTriase) > 0) {
            foreach ($detTriase as $i => $triase) {
              $modAnamnesa->triase_id = $triase['triase_id'];
            }
          }
        }
        $modAnamnesa->tglanamnesis = $format->formatDateTimeForDb($modAnamnesa->tglanamnesis);
        // var_dump($_POST['RKAnamnesaT']['keluhanutama']);die;
        $modAnamnesa->keluhanutama = isset($_POST['RKAnamnesaT']['keluhanutama']) ? ((count((array)$_POST['RKAnamnesaT']['keluhanutama']) > 0) ? implode(', ', $_POST['RKAnamnesaT']['keluhanutama']) : '') : '';
        $modAnamnesa->riwayatkelahiran = isset($_POST['RKAnamnesaT']['riwayatkelahiran']) ? ((count((array)$_POST['RKAnamnesaT']['riwayatkelahiran']) > 0) ? implode(', ', $_POST['RKAnamnesaT']['riwayatkelahiran']) : '') : '';
        $modAnamnesa->keluhantambahan = isset($_POST['RKAnamnesaT']['keluhantambahan']) ? ((count((array)$_POST['RKAnamnesaT']['keluhantambahan']) > 0) ? implode(', ', $_POST['RKAnamnesaT']['keluhantambahan']) : '') : '';
        $modAnamnesa->riwayatperjalananpasien = isset($_POST['RKAnamnesaT']['riwayatperjalananpasien']) ? $_POST['RKAnamnesaT']['riwayatperjalananpasien'] : null;
        $modAnamnesa->tglanamnesis = $format->formatDateTimeForDb($_POST['RKAnamnesaT']['tglanamnesis']);
        $modAnamnesa->petugas_triase_id = isset($_POST['RKAnamnesaT']['petugas_triase_id']) ? $_POST['RKAnamnesaT']['petugas_triase_id'] : null;

        if (!empty($modAnamnesa->hpht)) $modAnamnesa->hpht = MyFormatter::formatDateTimeForDb($modAnamnesa->hpht);
        if (!empty($modAnamnesa->tgl_persalinan)) $modAnamnesa->tgl_persalinan = MyFormatter::formatDateTimeForDb($modAnamnesa->tgl_persalinan);

        $dat = PasienpulangT::model()->findByAttributes(array(
          // 'carakeluar_id'=>Params::CARAKELUAR_ID_RAWATINAP,
          'pendaftaran_id' => $pendaftaran_id
        ));
        //  if (empty($dat)) $updateStatusPeriksa=PendaftaranT::model()->updateByPk($pendaftaran_id,array('statusperiksa'=>Params::STATUSPERIKSA_SEDANG_PERIKSA));

        /* ================================================ */
        /* Proses update status periksa KonsulPoli EHS-179  */
        /* ================================================ */
        $ruangan_id = isset($_GET['ruangan_id']) ? $_GET['ruangan_id'] : Yii::app()->user->getState('ruangan_id');
        $konsulPoli = KonsulpoliT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id, 'ruangan_id' => $ruangan_id));
        if (!empty($konsulPoli)) {
          //  $updateStatusPeriksa=KonsulpoliT::model()->updateByPk($konsulPoli->konsulpoli_id,array('statusperiksa'=>Params::STATUSPERIKSA_SEDANG_PERIKSA));
        }
        $modAnamnesa->create_time = date("Y-m-d H:i:s");
        $modAnamnesa->create_loginpemakai_id = Yii::app()->user->id;
        $modAnamnesa->create_ruangan = isset($_GET['ruangan_id']) ? $_GET['ruangan_id'] : Yii::app()->user->getState('ruangan_id');
        //					echo print_r($modAnamnesa->attributes);exit;
        /* ================================================ */

        // var_dump($modAnamnesa->attributes); die;

        if ($modAnamnesa->save()) {
          $transaction->commit();
          if (isset($_GET['noIframe'])) {
            $this->redirect(array('index', 'pendaftaran_id' => $pendaftaran_id, 'noIframe' => 1, 'sukses' => 1));
          } else {
            $this->redirect(array('index', 'pendaftaran_id' => $pendaftaran_id, 'sukses' => 1));
          }
        } else {
          Yii::app()->user->setFlash('error', "Data anamnesa gagal disimpan " . CHtml::errorSummary($modAnamnesa));
        }
      } catch (Exception $exc) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
      }
    }

    $modAnamnesa->tglanamnesis = $format->formatDateTimeForUser($modAnamnesa->tglanamnesis);

    $modDiagnosa = new RKDiagnosaM('searchDiagnosaAnamnesa');
    $modDiagnosa->unsetAttributes();
    if (isset($_GET['RKDiagnosaM']))
      $modDiagnosa->attributes = $_GET['RKDiagnosaM'];

    $this->render($this->path_view . 'index', array(
      'modPendaftaran' => $modPendaftaran, 'modPasien' => $modPasien,
      'modAnamnesa' => $modAnamnesa, 'modDiagnosa' => $modDiagnosa,
    ));
  }

  /**
   * @param type $pendaftaran_id
   */
  public function actionPrintAnamnesa($pendaftaran_id)
  {
    $this->layout = '//layouts/printWindows';
    $format = new MyFormatter;
    $modPendaftaran = RKPendaftaranT::model()->findByPk($pendaftaran_id);
    $modPasien = RKPasienM::model()->findByPk($modPendaftaran->pasien_id);
    $modAnamnesa = RKAnamnesaT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));

    $judul_print = 'ANAMNESIS';
    $this->render($this->path_view . 'printAnamnesa', array(
      'format' => $format,
      'modPendaftaran' => $modPendaftaran,
      'judul_print' => $judul_print,
      'modPasien' => $modPasien,
      'modAnamnesa' => $modAnamnesa,
    ));
  }

  public function actionMasterKeluhan()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $criteria = new CDbCriteria;
      $criteria->compare('LOWER(keluhananamnesis_nama)', strtolower($_GET['tag']), true);
      $criteria->order = "keluhananamnesis_nama ASC";
      $keluhans = KeluhananamnesisM::model()->findAll($criteria);
      $data = array();
      foreach ($keluhans as $i => $keluhan) {
        $data[$i] = array(
          'key' => $keluhan->keluhananamnesis_nama,
          'value' => $keluhan->keluhananamnesis_nama
        );
      }

      echo CJSON::encode($data);
    }
    Yii::app()->end();
  }

  /* */


  /**
   * actionGetTriasePasien untuk Triase Tabulasi Anamnesa:
   * issue		: RND-6415
   */
  public function actionGetTriasePasien()
  {

    if (Yii::app()->request->isAjaxRequest) {
      $triase_id = $_POST['triase_id'];

      $modDetail = new RKTriase;
      $modTriase = RKTriase::model()->findByPk($triase_id);
      $warna = RKTriase::model()->getKodeWarnaId($triase_id);
      $tr = "<tr>
                            <td> " . CHtml::hiddenField('noUrut', '', array('class' => 'span1 noUrut', 'readonly' => TRUE)) .
        CHtml::activeHiddenField($modDetail, '[' . $triase_id . ']triase_id', array('value' => $modTriase->triase_id, 'class' => 'triase_id'))
        . "<div class='colorPicker-picker' style='background-color:#" . $warna . ";'> </div>" .
        "</td>
                            <td>" . $modTriase->triase_nama . "</td>
                            <td>" . $modTriase->keterangan_triase . "</td>
                            <td>" . CHtml::link(
          "<span class='icon-remove'>&nbsp;</span>",
          '',
          array('href' => '#', 'onClick' => 'batalTriase();return false;', 'style' => 'text-decoration:none;')
        ) . "</td>
                         </tr>   
                        ";
      $data['tr'] = $tr;
      echo json_encode($data);
      Yii::app()->end();
    }
  }

  public function actionHapusTriase()
  {
    if (Yii::app()->request->isPostRequest) {
      $anamesa_id = $_POST['anamesa_id'];
      $triase_id = $_POST['triase_id'];
      $modAnamnesa = AnamnesaT::model()->findByPk($anamesa_id);
      if (!empty($modAnamnesa->triase_id)) {
        $update = AnamnesaT::model()->updateByPk($anamesa_id, array('triase_id' => null));
      }

      if ($update) {
        if (Yii::app()->request->isAjaxRequest) {
          echo CJSON::encode(array(
            'status' => 'proses_form',
            'div' => "<div class='flash-success'>Data berhasil dihapus.</div>",
          ));
          exit;
        }
      }

      // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
      if (!isset($_GET['ajax']))
        $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    } else
      throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
  }

  public function actionGetPegawaiTriase()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(nama_pegawai)', strtolower($_GET['term']), true);
      $criteria->order = 'nama_pegawai ASC';
      $models = RKPegawaiM::model()->findAll($criteria);
      $returnVal = array();
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]['label'] = $model->NamaLengkap;
          $returnVal[$i]['value'] = $model->NamaLengkap;
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }
}
