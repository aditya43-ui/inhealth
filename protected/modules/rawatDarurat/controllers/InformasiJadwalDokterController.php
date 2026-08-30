<?php

class InformasiJadwalDokterController extends MyAuthController
{
  public $_lastHari = null;
  public $path_view = 'rawatDarurat.views.informasiJadwalDokter.';
  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - Informasi Jadwal Dokter";
    $model = new RDJadwaldokterM;
    $listHari = array(
      'Senin' => 'Senin',
      'Selasa' => 'Selasa',
      'Rabu' => 'Rabu',
      'Kamis' => 'Kamis',
      'Jumat' => 'Jumat',
      'Sabtu' => 'Sabtu',
      'Minggu' => 'Minggu',
    );
    if (isset($_REQUEST['RDJadwaldokterM'])) {
      $model->attributes = $_REQUEST['RDJadwaldokterM'];
    }

    if (Yii::app()->request->isAjaxRequest) {
      echo $this->renderPartial($this->path_view . '_tableJadwalDokter', array('model' => $model));
    } else {
      $this->render(
        $this->path_view . 'index',
        array('model' => $model, 'listHari' => $listHari)
      );
    }
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
    return (isset($data->pegawai) && !empty($data->pegawai) ? $data->pegawai->nama_pegawai : "");
  }
}
