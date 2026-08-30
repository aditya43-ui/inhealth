<?php
class PengalamanKerjaPegawaiController extends MyAuthController
{
  public $layout = '//layouts/iframe';
  public $defaultAction = 'index';

  public function actionIndex($pegawai_id = null)
  {
    $model = KPPegawaiM::model()->findByPk($pegawai_id);
    $modPengalamankerja = new KPPengalamankerjaR;
    $detailPengalamankerja = array();
    $transaction = Yii::app()->db->beginTransaction();
    try {
      if (isset($_POST['KPPengalamankerjaR'])) {
        $jmlhsavepengalamankerja = 0;
        $submitPengalamankerja = $this->validasiTabularPengalamanKerja($_POST['KPPengalamankerjaR'], $model);
        $jumlah = count((array)$submitPengalamankerja);
        $tersimpan = 0;
        $errorDetail = "";
        foreach ($_POST['KPPengalamankerjaR'] as $i => $row) {
          $modPengalamankerja = new KPPengalamankerjaR;
          $modPengalamankerja->attributes = $row;
          if (empty($row['tglmasuk'])) {
            $modPengalamankerja->tglmasuk = null;
          }
          if (empty($row['tglkeluar'])) {
            $modPengalamankerja->tglkeluar = null;
          }
          $modPengalamankerja->pegawai_id = $pegawai_id;
          $modPengalamankerja->create_time = date('Y-m-d');
          $modPengalamankerja->create_loginpemakai_id = Yii::app()->user->id;
          $modPengalamankerja->create_ruangan = Yii::app()->user->ruangan_id;
          $modPengalamankerja->tglmasuk = MyFormatter::formatDateTimeForDb($row['tglmasuk']);
          $modPengalamankerja->tglkeluar = MyFormatter::formatDateTimeForDb($row['tglkeluar']);

          if ($modPengalamankerja->validate()) {
            if ($modPengalamankerja->save()) {
              $tersimpan++;
            }
          } else {
            $errorDetail .= CHtml::errorSummary($modPengalamankerja);
          }
        }
        if (($tersimpan > 0) && ($tersimpan == $jumlah)) {
          $transaction->commit();
          Yii::app()->user->setFlash('success', 'Data berhasil disimpan.');
          $sukses = 1;
          $this->redirect(array('index', 'pegawai_id' => $pegawai_id, 'sukses' => $sukses));
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', 'Data gagal disimpan' . $errorDetail);
        }
      }
    } catch (Exception $e) {
      $transaction->rollback();
      Yii::app()->user->setFlash('error', "Data gagal disimpan ! " . MyExceptionMessage::getMessage($e, true));
    }
    $this->render('index', array('model' => $model, 'modPengalamankerja' => $modPengalamankerja, 'detailPengalamankerja' => $detailPengalamankerja));
  }

  /**
   * menampilkan diklat pegawai
   * @return rows table
   */
  public function actionGetPengalamankerja()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $pegawai_id = $_POST['pegawai_id'];
      $modPengalamankerja = PengalamankerjaR::model()->findAllByAttributes(array('pegawai_id' => $pegawai_id), array('order' => 'pengalamankerja_nourut'));
      $i = 1;
      $tr = '';
      foreach ($modPengalamankerja as $row) {
        $urlDelete = $this->createUrl('deletePengalamankerja', array('pengalamankerja_id' => $row->pengalamankerja_id, 'pegawai_id' => $pegawai_id));
        $tr .= '<tr>';
        $tr .= '<td>' . $i . ' </td>';
        $tr .= '<td>' . $row->namaperusahaan . '</td>';
        $tr .= '<td>' . $row->bidangperusahaan . '</td>';
        $tr .= '<td>' . $row->jabatanterahkir . '</td>';
        $tr .= '<td>' . $row->tglmasuk . '</td>';
        $tr .= '<td>' . $row->tglkeluar . '</td>';
        $tr .= '<td>' . $row->lama_tahun . ' tahun' . $row->lama_bulan . ' bulan' . '</td>';
        $tr .= '<td>' . $row->alasanberhenti . '</td>';
        $tr .= '<td>' . $row->keterangan . '</td>';

        $tr .= '<td>' . CHtml::link('<i class="icon-form-sampah"></i>', $urlDelete, array('onclick' => 'hapus(this); return false')) . '</td>';
        $tr .= '</tr>';
        $i++;
      }

      $data['tr'] = $tr;

      echo json_encode($data);
      Yii::app()->end();
    }
  }

  public function actiondeletePengalamankerja($pengalamankerja_id, $pegawai_id)
  {
    $modPengalamankerja = new KPPengalamankerjaR;
    if ($modPengalamankerja->deleteByPK($pengalamankerja_id)) {
      $this->redirect(array('index', 'pegawai_id' => $pegawai_id));
    }
  }

  protected function validasiTabularPengalamanKerja($datas, $model)
  {
    $pegawai = 0;
    $details = array();
    foreach ($datas as $i => $data) {
      $data = array_filter($data, 'strlen');
      if (is_array($data)) {
        if (!empty($data['pengalamankerja_id'])) {
          $details[$i] = KPPengalamankerjaR::model()->findByPk($data['pengalamankerja_id']);
          $details[$i]->attributes = $data;
          $pegawai = $data['pegawai_id'];
        } else {
          if (!empty($data['namaperusahaan'])) {
            $details[$i] = new KPPengalamankerjaR();
            $details[$i]->attributes = $data;
            $details[$i]->tglmasuk = MyFormatter::formatDateTimeForDb($data['tglmasuk']);
            $details[$i]->tglkeluar = MyFormatter::formatDateTimeForDb($data['tglkeluar']);
            $details[$i]->pegawai_id = $model->pegawai_id;
          }
        }
      }
    }
    $rows = array();
    foreach ($details as $i => $data) {
      $rows[$i] = $data;
      $rows[$i]->validate();
    }
    return $rows;
  }

  public function actionSetLamaKerja()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      $data['thn'] = 0;
      $data['bln'] = 0;
      try {
        if (isset($_POST['tgl_awal']) && !empty($_POST['tgl_awal']) && isset($_POST['tgl_akhir']) && !empty($_POST['tgl_akhir'])) {
          $data = $this->getLamaKerja($_POST['tgl_awal'], $_POST['tgl_akhir']);
        }
      } catch (Exception $e) {
      }
      echo json_encode($data);
      Yii::app()->end();
    }
  }

  public static function getLamaKerja($tglAwal, $tglAkhir)
  {
    $format = new MyFormatter;
    $tglAwal = $format->formatDateTimeForDb($tglAwal);
    $tglAkhir = $format->formatDateTimeForDb($tglAkhir);
    $dob = $tglAwal;
    $today = $tglAkhir;
    list($y, $m, $d) = explode('-', $dob);
    list($ty, $tm, $td) = explode('-', $today);
    if ($td - $d < 0) {
      $day = ($td + 30) - $d;
      $tm--;
    } else {
      $day = $td - $d;
    }
    if ($tm - $m < 0) {
      $month = ($tm + 12) - $m;
      $ty--;
    } else {
      $month = $tm - $m;
    }
    $year = $ty - $y;

    $umur['thn'] = str_pad($year, 2, '0', STR_PAD_LEFT);
    $umur['bln'] = str_pad($month, 2, '0', STR_PAD_LEFT);
    return $umur;
  }
}
