<?php
class ResignPegawaiController extends MyAuthController
{
  //public $layout='//layouts/column1';
  //public $layout='//layouts/iframe';
  public $defaultAction = 'index';
  public $urlIframe = 'index';

  public function init()
  {
    if (isset($_GET['tab'])) {
      $this->layout = "//layouts/iframe";
      $this->urlIframe = 'frame';
    }
  }

  public function actionIndex($pegawai_id = null)
  {
    $this->pageTitle = Yii::app()->name . " - Resign Pegawai";
    //	if (empty($pegawai_id)) $this->layout = "//layouts/mainNeonSidebar"; //main layout
    if($pegawai_id){
      $model = KPPegawaiM::model()->findByPk($pegawai_id);
    }else{
      $model = new PegawaiM;
    }
    $modPegresign = new KPResignT;
    $transaction = Yii::app()->db->beginTransaction();

    if (isset($_POST['KPResignT'])) {

      $modPegresign = new KPResignT;
      $modPegresign->attributes = $_POST['KPResignT'];
      $modPegresign->tglresign = MyFormatter::formatDateTimeForDb($_POST['KPResignT']['tglresign']);
      $modPegresign->tglditerima = MyFormatter::formatDateTimeForDb($_POST['PegawaiM']['tglditerima']);
      $modPegresign->create_time = date('Y-m-d H:i:s');
      $modPegresign->update_time = null;
      $modPegresign->create_loginpemakai = Yii::app()->user->id;
      $modPegresign->create_ruangan = Yii::app()->user->getState('ruangan_id');
      $modPegresign->lampiran_surat = CUploadedFile::getInstance($modPegresign, 'lampiran_surat');

      $dokumen_pendukung = $modPegresign->lampiran_surat;
      if (!empty(CUploadedFile::getInstance($modPegresign, 'lampiran_surat'))) {
        $fullImgName = str_replace(' ', '_', strtolower(date('dmY_s') . $dokumen_pendukung));
        $fullImgSource = Params::pathPegawaiFileDirectory() . $fullImgName;
        $modPegresign->lampiran_surat = $fullImgName;
      }

      if (!empty($pegawai_id)) {
        $modPegresign->pegawai_id = $pegawai_id;
      } else {
        $modPegresign->pegawai_id = $_POST['PegawaiM']['pegawai_id'];
      }

      if ($modPegresign->validate()) {
        if ($modPegresign->save()) {
          if (!empty($dokumen_pendukung)) {
            $dokumen_pendukung->saveAs($fullImgSource);
          }

          $model = PegawaiM::model()->updateByPk($modPegresign->pegawai_id, array('pegawai_aktif' => false, 'tglberhenti' => $modPegresign->tglresign));
          
          $transaction->commit();
          Yii::app()->user->setFlash('success', 'Data ' . $modPegresign->pegawaiRl->nama_pegawai . ' berhasil disimpan');
          $modPegresign->unsetAttributes();
          $sukses = 1;
          if (!empty($pegawai_id)) $this->redirect(array('index', 'pegawai_id' => $pegawai_id, 'sukses' => $sukses, 'tab' => $this->urlIframe));
          else $this->redirect(array('index', 'sukses' => $sukses));
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', 'Data gagal disimpan');
        }
      } else {
        echo '<pre>';
        print_r($modPegresign->getErrors());
        exit();
        $transaction->rollback();
        Yii::app()->user->setFlash('error', '<strong>Gagal </strong> Data gagal disimpan');
      }
    }
    // if (empty($model)) $model = new PegawaiM;
    // var_dump($model);
    $this->render('index', array('model' => $model, 'modPegresign' => $modPegresign, 'pegawai_id' => $pegawai_id));
  }

  /**
   * menampilkan mutasi pegawai
   * @return rows table
   */
  public function actionGetPegmutasi()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $pegawai_id = $_POST['pegawai_id'];
      $modPegresign = ResignT::model()->findAllByAttributes(array('pegawai_id' => $pegawai_id), array('order' => 'resign_id'));
      $i = 1;
      $tr = '';
      foreach ($modPegresign as $row) {
        $urlDelete = $this->createUrl('deletePegmutasi', array('resign_id' => $row->resign_id, 'pegawai_id' => $pegawai_id));
        $tr .= '<tr>';
        $tr .= '<td>' . $i . ' </td>';
        $tr .= '<td>' . $row->noresign . '</td>';
        $tr .= '<td>' . $row->jabatan_id . '</td>';
        $tr .= '<td>' . $row->untikerja_id . '</td>';
        $tr .= '<td>' . $row->tglditerima . '</td>';
        $tr .= '<td>' . $row->lamakerja . '</td>';
        $tr .= '<td>' . $row->lampiran_surat . '</td>';
        $tr .= '<td>' . $row->alasanresign . '</td>';
        $tr .= '<td>' . $row->tglresign . '</td>';

        $tr .= '<td>' . CHtml::link('<i class="icon-form-sampah"></i>', $urlDelete, array('onclick' => 'hapus(this); return false')) . '</td>';
        $tr .= '</tr>';
        $i++;
      }

      $data['tr'] = $tr;

      echo json_encode($data);
      Yii::app()->end();
    }
  }

  public function actionSetUmur()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      $format = new MyFormatter;
      $data['umur'] = null;
      $a = isset($_POST['tanggal_lahir']) ? $_POST['tanggal_lahir'] : null;
      $b = isset($_POST['tglditerima']) ? $_POST['tglditerima'] : null;

      //				$tgl = explode('/', $a);
      //				print_r($tgl);
      //				exit();
      //				$tglLhr = $tgl[2].'-'.$tgl[1].'-'.$tgl[0];

      $tgl_lahir = MyFormatter::formatDateTimeForDb($a);
      $today = MyFormatter::formatDateTimeForDb($b);

      $date1 = new DateTime($tgl_lahir);
      $date2 = new DateTime($today);
      $interval = $date1->diff($date2);
      $umur = str_pad($interval->y, 2, '0', STR_PAD_LEFT) . ' Thn ' . str_pad($interval->m, 2, '0', STR_PAD_LEFT) . ' Bln ' . str_pad($interval->d, 2, '0', STR_PAD_LEFT) . ' Hr';
      //                print_r($umur);
      //				exit();
      echo json_encode($umur);
      Yii::app()->end();
    }
  }

  public function actiondeletePegmutasi($resign_id, $pegawai_id)
  {
    $modPegresign = new KPResignT;
    if ($modPegresign->deleteByPK($resign_id)) {
      $this->redirect(array('index', 'pegawai_id' => $pegawai_id));
    }
  }

  public function actionInformasi()
  {
    $this->pageTitle = Yii::app()->name . " - Resign Pegawai";
    //$this->layout = "//layouts/column1";
    $model = new KPResignT();
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');

    if (isset($_GET['KPResignT'])) {
      $model->attributes = $_GET['KPResignT'];
      $model->tgl_awal = MyFormatter::formatDateTimeForDb($_GET['KPResignT']['tgl_awal']);
      $model->tgl_akhir = MyFormatter::formatDateTimeForDb($_GET['KPResignT']['tgl_akhir']);
      $model->nama_pegawai = $_GET['KPResignT']['nama_pegawai'];
    }

    $this->render('informasi', array('model' => $model));
  }

  public function actionBatalResignPegawai()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $resign_id = isset($_POST['resign_id']) ? $_POST['resign_id'] : null;
        $pesan = '';
        $status = false;

        $modResignT = ResignT::model()->findByPk($resign_id);
        $pegawai_id = $modResignT->pegawai_id;


        $modDelete = $modResignT->delete();

        if ($modDelete) {
          PegawaiM::model()->updateByPk($pegawai_id, array('pegawai_aktif' => true, 'tglberhenti' => null));

          $transaction->commit();
          $status = true;
          $pesan = "Resign Pegawai berhasil dibatalkan";
        } else {
          $transaction->rollback();
          $status = false;
          $pesan = "Resign Pegawai gagal dibatalkan!";
        }
      } catch (Exception $ex) {
        $status = false;
        $pesan = "Resign Pegawai gagal dibatalkan!";
        $transaction->rollback();
      }

      $data = array(
        'pesan' => $pesan,
        'status' => $status
      );
      echo json_encode($data);
      Yii::app()->end();
    }
  }
}
