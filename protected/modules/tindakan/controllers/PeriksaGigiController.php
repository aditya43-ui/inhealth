<?php

class PeriksaGigiController extends Controller
{
  public $isNewRecord;
  public $path_view = 'rawatJalan.views.periksaGigi.';

  public function actions()
  {
    return array(
      'myOdontogram' => array(
        'class' => 'MyOdontogramAction',
      ),
    );
  }

  public function actionIndex($id = null, $status = '', $pendaftaran_id = null, $frame = null)
  {
    if (!empty($frame) && $frame == 1) {
      $this->layout = '//layouts/iframe';
    }

    if ($status == 1) :
      Yii::app()->user->setFlash('success', "Data berhasil disimpan");
    endif;

    $this->pageTitle = Yii::app()->name . " - Odontogram";
    $kunjunganPasien = new RJInfokunjunganrjV('searchKunjunganPasien');
    $kunjunganPasien->unsetAttributes();
    $kunjunganPasien->ruangan_id = Yii::app()->user->getState('ruangan_id');
    if (isset($_GET['RJInfokunjunganrjV'])) {
      $kunjunganPasien->attributes = $_GET['RJInfokunjunganrjV'];
      $format = new MyFormatter();
      if (isset($_GET['RJInfokunjunganrjV']['tgl_pendaftaran']))
        $kunjunganPasien->tgl_pendaftaran = $format->formatDateTimeForDb($_REQUEST['RJInfokunjunganrjV']['tgl_pendaftaran']);
      $kunjunganPasien->statusperiksa = $_REQUEST['RJInfokunjunganrjV']['statusperiksa'];
      //$kunjunganPasien->ruangan_id = Yii::app()->user->getState('ruangan_id');
    }



    $gigi = array(); //OdontogrampasienR::model()->polaGigi(2);                    
    $odontogramPasien = array();
    if (!empty($id)) {
      $modOdontogramDetail = OdontogramdetailT::model()->findByPk($id);
      $modOdontogramDetail->isNewRecord = false;
      if (!empty($pendaftaran_id)) {
        $pendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
        $modOdontogramDetail->pegawai_id = $pendaftaran->pegawai_id;
      }
    } else {
      $gigi = array(); //OdontogrampasienR::model()->polaGigi(2);                    
      $odontogramPasien = array();
      $modOdontogramDetail = new OdontogramdetailT;
      $modOdontogramDetail->tglperiksa = date('d M Y H:i:s');
      $modOdontogramDetail->ruangan_id = Yii::app()->user->getState('ruangan_id');
      //                    $modOdontogramDetail->pendaftaran_id = 12012012;
      //                    $modOdontogramDetail->pasien_id = 12012012;
      if (!empty($pendaftaran_id)) {
        $pendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
        $modOdontogramDetail->pegawai_id = $pendaftaran->pegawai_id;
      }
    }
    $peg = PegawaiM::model()->findByPk($modOdontogramDetail->pegawai_id);
    if (!empty($peg)) {
      $modOdontogramDetail->nama_pegawai = $peg->namaLengkap;
    }


    if (isset($_GET['OdontogramdetailT'])) {
      $modOdontogramDetail->pendaftaran_id = $_GET['OdontogramdetailT']['pendaftaran_id'];
      $modOdontogramDetail->pasien_id = $_GET['OdontogramdetailT']['pasien_id'];
    }

    if (isset($_POST['codeOdon']) && isset($_POST['OdontogramdetailT'])) {
      $modOdontogramDetail = $this->setOdontogram($modOdontogramDetail, $_POST['codeOdon']);
      $modOdontogramDetail->attributes = $_POST['OdontogramdetailT'];
      $modOdontogramDetail->tglperiksa = MyFormatter::formatDateTimeForDb($modOdontogramDetail->tglperiksa);
      if (!empty($modOdontogramDetail->pasien_id))
        $odontogramPasien = OdontogrampasienR::model()->findByAttributes(array('pasien_id' => $modOdontogramDetail->pasien_id));
      if (!empty($odontogramPasien)) {
        $modOdontogramDetail->odontogrampasien_id = $odontogramPasien->odontogrampasien_id;
        $odontogramPasien = $this->setOdontogram($odontogramPasien, $_POST['codeOdon']);
        $odontogramPasien->update();
      } else {
        $odontogramPasien = $this->createOdontogramPasien($modOdontogramDetail->pasien_id, $_POST['codeOdon']);
        $modOdontogramDetail->odontogrampasien_id = $odontogramPasien->odontogrampasien_id;
      }

      $transaction = Yii::app()->db->beginTransaction();
      try {

        if ($modOdontogramDetail->validate()) {
          $modOdontogramDetail->save();

          if (empty($pendaftaran_id)) {
            $pendaftaran_id = $modOdontogramDetail->pendaftaran_id;
          }

          $transaction->commit();
          // $modOdontogramDetail->isNewRecord = false;
          Yii::app()->user->setFlash('success', "Data berhasil disimpan");
          $this->redirect(array(
            'index',
            'id' => $modOdontogramDetail->odontogramdetail_id,
            'status' => 1,
            'pendaftaran_id' => $pendaftaran_id,
            'frame' => $frame,
          ));
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data gagal disimpan ");
        }
      } catch (Exception $exc) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
      }

      $gigi = (isset($_POST['codeOdon']) ? $_POST['codeOdon'] : null);
    }
    $this->render($this->path_view . 'index', array(
      'kunjunganPasien' => $kunjunganPasien,
      'gigi' => $gigi,
      'modOdontogramDetail' => $modOdontogramDetail,
      'odontogramPasien' => $odontogramPasien,
      'pendaftaran_id' => $pendaftaran_id
    ));
  }

  protected function setOdontogram($odontogram, $codeOdon)
  {
    // dewasa ==============================
    $i = 18;
    for ($i = 18; $i > 10; $i--) {
      $urutan = 'no_' . $i;
      $odontogram->$urutan = $codeOdon[$i];
    }
    for ($j = 21; $j < 29; $j++) {
      $urutan = 'no_' . $j;
      $odontogram->$urutan = $codeOdon[$j];
    }
    for ($i = 48; $i > 40; $i--) {
      $urutan = 'no_' . $i;
      $odontogram->$urutan = $codeOdon[$i];
    }
    for ($j = 31; $j < 39; $j++) {
      $urutan = 'no_' . $j;
      $odontogram->$urutan = $codeOdon[$j];
    }
    // =====================================
    // anak ================================
    for ($i = 55; $i > 50; $i--) {
      $urutan = 'no_' . $i;
      $odontogram->$urutan = $codeOdon[$i];
    }
    for ($j = 61; $j < 66; $j++) {
      $urutan = 'no_' . $j;
      $odontogram->$urutan = $codeOdon[$j];
    }
    for ($i = 85; $i > 80; $i--) {
      $urutan = 'no_' . $i;
      $odontogram->$urutan = $codeOdon[$i];
    }
    for ($j = 71; $j < 76; $j++) {
      $urutan = 'no_' . $j;
      $odontogram->$urutan = $codeOdon[$j];
    }
    // =====================================

    return $odontogram;
  }

  protected function createOdontogramPasien($pasien_id, $codeOdon)
  {
    $odontogram = new OdontogrampasienR;
    $odontogram = $this->setOdontogram($odontogram, $codeOdon);
    $odontogram->pasien_id = $pasien_id;
    if ($odontogram->validate())
      $odontogram->save();

    return $odontogram;
  }

  public function actionAjaxOdontogram()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $pasien_id = isset($_POST['pasien_id']) ? $_POST['pasien_id'] : null;
      $gigi = array();
      $gigiPasien = array();

      $gigiPasien = OdontogrampasienR::model()->findByAttributes(array('pasien_id' => $pasien_id));
      $odontogrampasien_id = (isset($gigiPasien->odontogrampasien_id) ? $gigiPasien->odontogrampasien_id : null);
      $gigi = OdontogrampasienR::model()->polaGigi($odontogrampasien_id);

      echo json_encode($gigi);
      Yii::app()->end();
      //$this->widget('Odontogram',array('gigis'=>$gigi));
    }
  }

  public function actionCetakOdontogram($pasien_id, $pendaftaran_id)
  {
    $this->layout = '//layouts/iframe';
    if (!empty($pasien_id) && !empty($pendaftaran_id)) {
      $gigiPasien = OdontogrampasienR::model()->findByAttributes(array('pasien_id' => $pasien_id));
      if (empty($gigiPasien)) :
        $gigi = array();
      else :
        $gigi = OdontogrampasienR::model()->polaGigi($gigiPasien->odontogrampasien_id);
      endif;
      $pasien = PasienM::model()->findByPk($pasien_id);
      $pendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
    } else {
      $gigi = array();
      $pasien = new PasienM;
      $pendaftaran = new PendaftaranT;
    }

    $this->render($this->path_view . 'odontogram', array(
      'gigi' => $gigi,
      'pasien' => $pasien,
      'pendaftaran' => $pendaftaran
    ));
  }

  // Uncomment the following methods and override them if needed
  /*
      public function filters()
      {
      // return the filter configuration for this controller, e.g.:
      return array(
      'inlineFilterName',
      array(
      'class'=>'path.to.FilterClass',
      'propertyName'=>'propertyValue',
      ),
      );
      }

      public function actions()
      {
      // return external action classes, e.g.:
      return array(
      'action1'=>'path.to.ActionClass',
      'action2'=>array(
      'class'=>'path.to.AnotherActionClass',
      'propertyName'=>'propertyValue',
      ),
      );
      }
     */
}
