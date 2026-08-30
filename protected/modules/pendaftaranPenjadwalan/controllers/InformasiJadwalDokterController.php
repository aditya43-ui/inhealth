<?php

class InformasiJadwalDokterController extends MyAuthController
{
  /**
   * @return array action filters
   */
  public $_lastHari = null;
  public $path_view = 'pendaftaranPenjadwalan.views.informasiJadwalDokter.';

  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - Informasi Jadwal Dokter";
    $model = new PPJadwaldokterM;
    $model->instalasi_id = Params::INSTALASI_ID_RD;
    $listHari = array(
      'Senin' => 'Senin',
      'Selasa' => 'Selasa',
      'Rabu' => 'Rabu',
      'Kamis' => 'Kamis',
      'Jumat' => 'Jumat',
      'Sabtu' => 'Sabtu',
      'Minggu' => 'Minggu',
    );
    /**
     * handling ajax request dari form search 
     */
    if (Yii::app()->request->isAjaxRequest) {
      if (isset($_GET['PPJadwaldokterM'])) {
        $mulai = (!empty($_GET['PPJadwaldokterM']['jadwaldokter_mulai'])) ? date('Y-m-d', strtotime('01 ' . $_GET['PPJadwaldokterM']['jadwaldokter_mulai'])) : date('Y-m-d');
        $tgl = explode('-', $mulai);
        $day = cal_days_in_month(CAL_GREGORIAN, $tgl[1], $tgl[0]);
        $grid = $this->createGrid($day, $tgl[1], $tgl[0], $_GET['PPJadwaldokterM']);
        echo json_encode($grid);
      }

      if (isset($_POST['data'])) {

        $id = $_POST['data'];
        $modJadwal = JadwaldokterM::model()->findByPk($id);

        if (isset($_POST['JadwaldokterM'])) {
          $id = $_POST['JadwaldokterM']['jadwaldokter_id'];
          $modJadwal = JadwaldokterM::model()->findByPk($id);
          $modJadwal->attributes = $_POST['JadwaldokterM'];
          if ($modJadwal->save()) {
            Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
          }
        }
        $pegawai = (!empty($modJadwal->ruangan_id)) ? CHtml::listData(DokterV::model()->findAllByAttributes(array('ruangan_id' => $modJadwal->ruangan_id)), 'pegawai_id', 'nama_pegawai') : array();
        $ruangan = (!empty($modJadwal->instalasi_id)) ? CHtml::listData(RuanganM::model()->findAll('instalasi_id = ?', array($modJadwal->instalasi_id)), 'ruangan_id', 'ruangan_nama') : array();
        $return = $this->renderPartial('_createForm', array('pegawai' => $pegawai, 'model' => $modJadwal, 'ruangan' => $ruangan, 'listHari' => $listHari), true);
        echo json_encode($return);
      }

      if (isset($_GET['JadwaldokterM'])) {
      }
      Yii::app()->end();
    }

    $tgl = explode('-', date('Y-m-d'));
    $day = cal_days_in_month(CAL_GREGORIAN, $tgl[1], $tgl[0]);
    $grid = $this->createGrid($day, $tgl[1], $tgl[0]);

    if (isset($_REQUEST['PPJadwaldokterM'])) {
      $model->attributes = $_REQUEST['PPJadwaldokterM'];
    }
    $this->render(
      $this->path_view . 'index',
      array('model' => $model, 'listHari' => $listHari, 'grid' => $grid)
    );
  }

  protected function gridHari($data, $row)
  {
    if ($this->_lastHari != $data->jadwaldokter_hari) {
      return $data->jadwaldokter_hari;
    } else {
      return '';
    }
  }

  protected function gridDokter($data, $row)
  {
    $this->_lastHari = $data->jadwaldokter_hari;
    return $data->pegawai->nama_pegawai;
  }

  public function actionUbahDokterJadwal()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $idJadwal = $_POST['idJadwal'];
      $idDokter = $_POST['idDokter'];
      $dokterSebelumnya = $_POST['dokterSebelumnya'];

      $criteria = new CDbCriteria;
      if (!empty($dokterSebelumnya)) {
        $criteria->addCondition("pegawai_id = " . $dokterSebelumnya);
      }

      if (JadwaldokterM::model()->updateAll(array(
        'pegawai_id' => $idDokter,
        'update_loginpemakai_id' => Yii::app()->user->id,
        'update_time' => date('Y-m-d H:i:s')
      ), $criteria)) {
        $data['status'] = 'OK';
      } else {
        $data['status'] = 'gagal';
      }
      echo json_encode($data);
      Yii::app()->end();
    }
  }

  public function actionUbahJamBukaDokter()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $idJadwal = $_POST['idJadwal'];
      $jamMulai = $_POST['jamMulai'];
      $jamTutup = $_POST['jamTutup'];
      $jamBuka = $jamMulai . ' s/d ' . $jamTutup;

      if (JadwaldokterM::model()->updateByPk(
        $idJadwal,
        array(
          'jadwaldokter_buka' => $jamBuka,
          'jadwaldokter_mulai' => $jamMulai,
          'jadwaldokter_tutup' => $jamTutup,
          'update_loginpemakai_id' => Yii::app()->user->id,
          'update_time' => date('Y-m-d H:i:s')
        )
      )) {
        $data['status'] = 'OK';
      } else {
        $data['status'] = 'gagal';
      }
      echo json_encode($data);
      Yii::app()->end();
    }
  }

  /**
   * method untuk membuat calendar jadwal dokter
   * @param sting $jumlahhari
   * @param string $bulan
   * @param string $tahun
   * @param array $variable
   * @return string berupa grid calender dengan jadwal dokter
   */
  protected function createGrid($jumlahhari, $bulan, $tahun, $variable = null)
  {
    $tglMulai = strtotime($tahun . '-' . $bulan . '-' . '01');
    return $this->renderPartial($this->path_view . "createGrid", array('tglMulai' => $tglMulai, 'bulan' => $bulan, 'tahun' => $tahun, 'jumlahHari' => $jumlahhari, 'variable' => $variable), true);
  }
}
