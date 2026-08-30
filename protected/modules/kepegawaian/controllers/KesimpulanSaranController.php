<?php

class KesimpulanSaranController extends MyAuthController
{
  public $layout = '//layouts/column1';
  public $path_view = 'kepegawaian.views.kesimpulanSaran.';
  public $defaultAction = 'index';
  public $kesimpulantersimpan = false;
  public $kesimpulandetailtersimpan = true;

  public function actionIndex($kesimpulanpenilaian_id = null)
  {
    $format = new MyFormatter();
    $modKesimpulan = new KPKesimpulanpenilaianT;
    $modPenilaianPegawai = new KPPenilaianpegawaiT('search');
    $modKesimpulan->tglkesimpulan = date('Y-m-d H:i:s');
    $modPenyimpananKesimpulanDetail = array();

    if (isset($_POST['KPKesimpulanpenilaianT'])) {
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $modKesimpulan->attributes = $_POST['KPKesimpulanpenilaianT'];
        $modKesimpulan->tglkesimpulan = $format->formatDateTimeForDb($_POST['KPKesimpulanpenilaianT']['tglkesimpulan']);
        $modKesimpulan->pegawai_pemberisaran = $_POST['KPKesimpulanpenilaianT']['pegawai_pemberisaran'];
        $modKesimpulan->totalpenilaian = $_POST['KPKesimpulanpenilaianT']['totalpenilaian'];
        $modKesimpulan->ratapenilaian = $_POST['KPKesimpulanpenilaianT']['ratapenilaian'];
        $modKesimpulan->kesimpulan = $_POST['KPKesimpulanpenilaianT']['kesimpulan'];
        $modKesimpulan->saran = $_POST['KPKesimpulanpenilaianT']['saran'];
        $modKesimpulan->create_time = date('Y-m-d H:i:s');
        $modKesimpulan->update_time = date('Y-m-d H:i:s');
        $modKesimpulan->create_loginpemakai_id = Yii::app()->user->id;
        $modKesimpulan->update_loginpemakai_id = Yii::app()->user->id;
        $modKesimpulan->create_ruangan = Yii::app()->user->ruangan_id;
        if ($modKesimpulan->save()) {
          $this->kesimpulantersimpan = true;
          if (isset($_POST['KPPenilaianpegawaiT'])) {
            if (count((array)$_POST['KPPenilaianpegawaiT']) > 0) {
              foreach ($_POST['KPPenilaianpegawaiT'] as $i => $detail) {
                $modPenyimpananKesimpulanDetail = new KPKesimpulanpenilaiandetT;
                $modPenyimpananKesimpulanDetail->attributes = $detail;
                $modPenyimpananKesimpulanDetail->penilaianpegawai_id = $_POST['KPPenilaianpegawaiT'][$i]['pegawai_id'];
                $modPenyimpananKesimpulanDetail->penilainip = $_POST['KPPenilaianpegawaiT'][$i]['penilainip'];
                $modPenyimpananKesimpulanDetail->penilainama = $_POST['KPPenilaianpegawaiT'][$i]['penilainama'];
                $modPenyimpananKesimpulanDetail->penilaianpegawai_keterangan = $_POST['KPPenilaianpegawaiT'][$i]['keterangan_score'];
                $modPenyimpananKesimpulanDetail->jumlahpenilaian = $_POST['KPPenilaianpegawaiT'][$i]['jumlahpenilaian'];
                $modPenyimpananKesimpulanDetail->kesimpulanpenilaian_id = $modKesimpulan->kesimpulanpenilaian_id;
                $modPenyimpananKesimpulanDetail->create_time = date('Y-m-d H:i:s');
                $modPenyimpananKesimpulanDetail->update_time = date('Y-m-d H:i:s');
                $modPenyimpananKesimpulanDetail->create_loginpemakai_id = Yii::app()->user->id;
                $modPenyimpananKesimpulanDetail->update_loginpemakai_id = Yii::app()->user->id;
                $modPenyimpananKesimpulanDetail->create_ruangan = Yii::app()->user->ruangan_id;
                if ($modPenyimpananKesimpulanDetail->save()) {
                  $this->kesimpulandetailtersimpan &= true;
                }
              }
            }
          }
        } else {
          $this->kesimpulantersimpan = false;
        }
        if ($this->kesimpulantersimpan && $this->kesimpulandetailtersimpan) {
          $transaction->commit();
          $modKesimpulan->isNewRecord = FALSE;
          $this->redirect(array('index', 'kesimpulanpenilaian_id' => $modKesimpulan->kesimpulanpenilaian_id, 'sukses' => 1));
        } else {
          $transaction->rollback();
          //Yii::app()->user->setFlash('error',"Data Penyimpanan Pemeliharaan Aset gagal disimpan !");
        }
      } catch (Exception $e) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data Penyimpanan Pemeliharaan Aset gagal disimpan ! " . MyExceptionMessage::getMessage($e, true));
      }
    }

    $this->render($this->path_view . 'index', array(
      'format' => $format,
      'modKesimpulan' => $modKesimpulan,
      'modPenilaianPegawai' => $modPenilaianPegawai,
    ));
  }
  //search data penilaian pegawai
  public function actionPencarian()
  {
    if (Yii::app()->request->isAjaxRequest) {
      parse_str($_REQUEST['data'], $data_parsing);
      $form = "";
      $pesan = "";
      $modPenilaian = '';
      $format = new MyFormatter();
      if (isset($data_parsing['KPPenilaianpegawaiT'])) {
        $pegawai_id = isset($data_parsing['KPPenilaianpegawaiT']['pegawai_id']) ? $data_parsing['KPPenilaianpegawaiT']['pegawai_id'] : null;
        $tgl_penilaian = isset($data_parsing['KPPenilaianpegawaiT']['tglpenilaian']) ? $format->formatDateTimeForDb($data_parsing['KPPenilaianpegawaiT']['tglpenilaian']) : null;
        $sampaidengan = isset($data_parsing['KPPenilaianpegawaiT']['sampaidengan']) ? $format->formatDateTimeForDb($data_parsing['KPPenilaianpegawaiT']['sampaidengan']) : "";

        $criteria = new CDbCriteria();
        $criteria->select = "t.*";
        if (!empty($pegawai_id)) {
          $criteria->addCondition('t.pegawai_id = ' . $pegawai_id);
        }
        if (!empty($tgl_penilaian) || $sampaidengan) {
          $criteria->addBetweenCondition('DATE(t.tglpenilaian)', $tgl_penilaian, $sampaidengan);
        }

        $modPeg = KPPenilaianpegawaiT::model()->findAll($criteria);

        if (count((array)$modPeg) == 0) {
          $pesan = "Data Tidak Ada!";
        }
      }

      echo CJSON::encode(array(
        'form' => $form, 'pesan' => $pesan,
        'form' => $this->renderPartial(
          '_rowPenilaian',
          array(
            'format' => $format,
            'penilaianpegawai' => $modPeg,
          ),
          true
        )
      ));
      Yii::app()->end();
    }
  }

  /**
   * Mencetak data
   */
  public function actionPrint($kesimpulanpenilaian_id, $caraprint = null)
  {
    $this->layout = '//layouts/printWindows';
    if (isset($_GET['frame'])) {
      $this->layout = '//layouts/iframe';
    } else if ($caraprint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
    }
    $format = new MyFormatter;
    $modKesimpulan = KPKesimpulanpenilaianT::model()->findByPk($kesimpulanpenilaian_id);
    $criteria = new CDbCriteria();
    $criteria->addCondition('kesimpulanpenilaian_id = ' . $kesimpulanpenilaian_id);
    $modKesimpulanDetail = KPKesimpulanpenilaiandetT::model()->findAll($criteria);

    $judul_print = 'Kesimpulan dan Saran Penilaian';

    $this->render($this->path_view . 'Print', array(
      'format' => $format,
      'judul_print' => $judul_print,
      'modKesimpulan' => $modKesimpulan,
      'modKesimpulanDetail' => $modKesimpulanDetail,
      'caraprint' => $caraprint
    ));
  }
}
