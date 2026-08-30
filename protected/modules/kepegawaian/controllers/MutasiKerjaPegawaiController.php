<?php
class MutasiKerjaPegawaiController extends MyAuthController
{
  //public $layout='//layouts/column1';
  //public $layout='//layouts/iframe';
  public $defaultAction = 'index';
  public $urlIframe = '';

  public function init()
  {
    if (isset($_GET['tab'])) {
      $this->layout = "//layouts/iframe";
      $this->urlIframe = 'frame';
    }
  }

  public function actionIndex($pegawai_id = null)
  {
    $this->pageTitle = Yii::app()->name . " - Mutasi Pegawai";
    //	if (empty($pegawai_id)) $this->layout = "//layouts/mainNeonSidebar"; //main layout

    $model = KPPegawaiM::model()->findByPk($pegawai_id);
    $modPegmutasi = new KPPegmutasiR;
    $transaction = Yii::app()->db->beginTransaction();
    if (isset($_POST['submitPegmutasi'])) {
      $modPegmutasi = new KPPegmutasiR;
      $modPegmutasi->attributes = $_POST['KPPegmutasiR'];
      $modPegmutasi->tglsk = MyFormatter::formatDateTimeForDb($_POST['KPPegmutasiR']['tglsk']);
      $modPegmutasi->tmtsk = MyFormatter::formatDateTimeForDb($_POST['KPPegmutasiR']['tmtsk']);

      if (empty($_POST['KPPegmutasiR']['tglsk'])) {
        $modPegmutasi->tglsk = null;
      }
      if (empty($_POST['KPPegmutasiR']['tmtsk'])) {
        $modPegmutasi->tmtsk = null;
      }
      if (!empty($pegawai_id)) $modPegmutasi->pegawai_id = $pegawai_id;
      else $modPegmutasi->pegawai_id = $_POST['PegawaiM']['pegawai_id'];
      $modPegmutasi->jenispromosi_mutasi = $_POST['KPPegmutasiR']['jenispromosi_mutasi'];
      $modPegmutasi->lokasikerja_baru = $_POST['KPPegmutasiR']['lokasikerja_baru'];

      // var_dump($_POST, $modPegmutasi->attributes, $modPegmutasi->validate(), $modPegmutasi->errors); die;

      $modPegmutasi->dokumen = CUploadedFile::getInstance($modPegmutasi, 'dokumen');
      $dokumenUpload = $modPegmutasi->dokumen;
      $locationDok = "";
      if(!empty($modPegmutasi->dokumen)){
        $random = rand(000000, 999999);
        $modPegmutasi->dokumen = $random . $modPegmutasi->dokumen;
        $locationDok = Params::pathDokumenMutasiPegDirectory() . $modPegmutasi->dokumen;
      }

      if ($modPegmutasi->validate()) {
        if ($modPegmutasi->save()) {
          if (!empty($locationDok)) {
            $dokumenUpload->saveAs($locationDok);
          }

          $transaction->commit();
          Yii::app()->user->setFlash('success', 'Data ' . $modPegmutasi->pegawai->nama_pegawai . ' berhasil disimpan');
          $modPegmutasi->unsetAttributes();
          $sukses = 1;
          if(!empty($_GET['tab'])){
            $this->redirect(array('index', 'pegawai_id' => $pegawai_id, 'sukses' => $sukses, 'tab' => $this->urlIframe));
          }else{
            $this->redirect(array('index', 'pegawai_id' => $pegawai_id, 'sukses' => $sukses));
          }
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', 'Data gagal disimpan');
        }
      }
    }
    if (empty($model)) $model = new PegawaiM;
    $this->render('index', array('model' => $model, 'modPegmutasi' => $modPegmutasi, 'pegawai_id' => $pegawai_id));
  }

  /**
   * menampilkan mutasi pegawai
   * @return rows table
   */
  public function actionGetPegmutasi()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $pegawai_id = $_POST['pegawai_id'];
      $modPegmutasi = PegmutasiR::model()->findAllByAttributes(array('pegawai_id' => $pegawai_id), array('order' => 'pegmutasi_id'));
      $i = 1;
      $tr = '';
      foreach ($modPegmutasi as $row) {
        $urlDelete = $this->createUrl('deletePegmutasi', array('pegmutasi_id' => $row->pegmutasi_id, 'pegawai_id' => $pegawai_id));
        $tr .= '<tr>';
        $tr .= '<td>' . $i . ' </td>';
        $tr .= '<td>' . $row->nomorsurat . '</td>';
        $tr .= '<td>' . $row->jabatan_nama . '</td>';
        //                    $tr .= '<td>'.$row->pangkat_nama.'</td>';
        $tr .= '<td>' . $row->nosk . '</td>';
        $tr .= '<td>' . $row->tglsk . '</td>';
        $tr .= '<td>' . $row->tmtsk . '</td>';
        $tr .= '<td>' . $row->jabatan_baru . '</td>';
        //                    $tr .= '<td>'.$row->pangkat_baru.'</td>';
        $tr .= '<td>' . $row->mengetahui_nama . '</td>';
        $tr .= '<td>' . $row->pimpinan_nama . '</td>';

        $tr .= '<td>' . CHtml::link('<i class="icon-form-sampah"></i>', $urlDelete, array('onclick' => 'hapus(this); return false')) . '</td>';
        $tr .= '</tr>';
        $i++;
      }

      $data['tr'] = $tr;

      echo json_encode($data);
      Yii::app()->end();
    }
  }

  public function actiondeletePegmutasi($pegmutasi_id, $pegawai_id)
  {
    $modPegmutasi = new KPPegmutasiR;
    if ($modPegmutasi->deleteByPK($pegmutasi_id)) {
      $this->redirect(array('index', 'pegawai_id' => $pegawai_id));
    }
  }

  public function actionInformasi()
  {
    $this->pageTitle = Yii::app()->name . " - Mutasi Pegawai";
    //$this->layout = "//layouts/column1";
    $model = new KPPegmutasiR();
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');

    if (isset($_GET['KPPegmutasiR'])) {
      $model->attributes = $_GET['KPPegmutasiR'];
      $model->tgl_awal = MyFormatter::formatDateTimeForDb($_GET['KPPegmutasiR']['tgl_awal']);
      $model->tgl_akhir = MyFormatter::formatDateTimeForDb($_GET['KPPegmutasiR']['tgl_akhir']);
      $model->nama_pegawai = $_GET['KPPegmutasiR']['nama_pegawai'];
    }

    $this->render('informasi', array('model' => $model));
  }

  public function actionDetail($pegmutasi_id)
  {
    $this->layout = "//layouts/iframe";
    $modPegmutasi = PegmutasiR::model()->findByAttributes(array('pegmutasi_id'=>$pegmutasi_id));
    $model = KPPegawaiM::model()->findByPk($modPegmutasi->pegawai_id);
    $model->jabatan_nama = (!empty($model->jabatan)? $model->jabatan->jabatan_nama:"");

    $this->render('detail', array('model' => $model, 'modPegmutasi'=>$modPegmutasi));
  }

  public function actionDownload($pegmutasi_id) {
    $modPegmutasi = PegmutasiR::model()->findByAttributes(array('pegmutasi_id'=>$pegmutasi_id));
    
    $file = Params::pathDokumenMutasiPegDirectory().$modPegmutasi->dokumen;
    
    if (file_exists($file)) {
  
        header('Content-Description: File Transfer');
        header('Content-Type: '.mime_content_type($file));
        header('Content-Disposition: attachment; filename="'.basename($file).'"');
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file));
        ob_clean();
        flush();
        readfile($file);
        exit;
    }
}

}
