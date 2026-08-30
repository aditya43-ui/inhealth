<?php
class PendidikanPegawaiController extends MyAuthController
{
  public $layout = '//layouts/iframe';
  public $defaultAction = 'index';

  public function actionIndex($pegawai_id = null)
  {
    $model = KPPegawaiM::model()->findByPk($pegawai_id);
    $modPendidikanpegawai = new KPPendidikanpegawaiR;
    $satuan = array(
      'bulan' => 1,
      'tahun' => 12,
    );
    $transaction = Yii::app()->db->beginTransaction();
    try {
      if (isset($_POST['KPPendidikanpegawaiR'])) {
        $jmlhsavependidikan = 0;
        $errorDetail = "";
        foreach ($_POST['KPPendidikanpegawaiR'] as $i => $row) {
          $modPendidikanpegawai = new KPPendidikanpegawaiR;
          $modPendidikanpegawai->pegawai_id = $pegawai_id;
          $modPendidikanpegawai->attributes = $row;
          $modPendidikanpegawai->tglmasuk = MyFormatter::formatDateTimeForDb($row['tglmasuk']);
          $modPendidikanpegawai->tgl_ijazah_sert = MyFormatter::formatDateTimeForDb($row['tgl_ijazah_sert']);
          if (empty($row['tglmasuk'])) {
            $modPendidikanpegawai->tglmasuk = null;
          }
          if (empty($row['tgl_ijazah_sert'])) {
            $modPendidikanpegawai->tgl_ijazah_sert = null;
          }
          $modPendidikanpegawai->create_time = date('Y-m-d');
          $modPendidikanpegawai->jenispendidikan = $_POST['KPPegawaiM']['jenispendidikan'];
          $modPendidikanpegawai->create_loginpemakai_id = Yii::app()->user->id;
          $modPendidikanpegawai->create_ruangan = Yii::app()->user->ruangan_id;
          $modPendidikanpegawai->lamapendidikan_bln *= $satuan[$row['satuan']];
          if ($modPendidikanpegawai->validate()) {
            if ($modPendidikanpegawai->save()) {
              $jmlhsavependidikan++;
            }
          } else {
            $errorDetail .= CHtml::errorSummary($modPendidikanpegawai);
          }
        }
        if ($jmlhsavependidikan == count((array)$_POST['KPPendidikanpegawaiR'])) {
          $transaction->commit();
          Yii::app()->user->setFlash('success', 'Data berhasil disimpan');
          $modPendidikanpegawai->unsetAttributes();
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

    $this->render('index', array('model' => $model, 'modPendidikanpegawai' => $modPendidikanpegawai));
  }

  /**
   * menampilkan pendidikan pegawai
   * @return rows table
   */
  public function actionGetPendidikanpegawai()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $pegawai_id = $_POST['pegawai_id'];
      $modPendidikanpegawai = PendidikanpegawaiR::model()->findAllByAttributes(array('pegawai_id' => $pegawai_id), array('order' => 'tglmasuk'));
      $i = 1;
      $tr = '';
      foreach ($modPendidikanpegawai as $row) {
        $lama = $row->lamapendidikan_bln;
        $lama_str = "";
        if ($lama >= 12) $lama_str .= floor($lama / 12) . " Tahun ";
        if ($lama % 12 != 0) $lama_str .= ($lama % 12) . " Bulan";
        $urlDelete = $this->createUrl('deletePendidikanpegawai', array('pendidikanpegawai_id' => $row->pendidikanpegawai_id, 'pegawai_id' => $row->pegawai_id));
        $tr .= '<tr>';
        $tr .= '<td>' . $i . ' </td>';
        $tr .= '<td>' . $row->pendidikan->pendidikan_nama . '</td>';
        $tr .= '<td>' . $row->namasek_univ . '</td>';
        $tr .= '<td>' . $row->almtsek_univ . '</td>';
        $tr .= '<td>' . $row->tglmasuk . '</td>';
        $tr .= '<td>' . $lama_str . '</td>';
        $tr .= '<td>' . $row->no_ijazah_sert . '</td>';
        $tr .= '<td>' . $row->tgl_ijazah_sert . '</td>';
        $tr .= '<td>' . $row->ttd_ijazah_sert . '</td>';
        $tr .= '<td>' . $row->nilailulus . ' / ' . $row->gradelulus . '</td>';
        $tr .= '<td>' . $row->keteranganpend . '</td>';

        $tr .= '<td>' . CHtml::link('<i class="icon-form-sampah"></i>', $urlDelete, array('onclick' => 'hapus(this); return false')) . '</td>';
        $tr .= '</tr>';
        $i++;
      }

      $data['tr'] = $tr;

      echo json_encode($data);
      Yii::app()->end();
    }
  }

  public function actiondeletePendidikanpegawai($pendidikanpegawai_id, $pegawai_id)
  {
    $modPendidikanpegawai = new KPPendidikanpegawaiR;
    if ($modPendidikanpegawai->deleteByPK($pendidikanpegawai_id)) {
      $this->redirect(array('index', 'pegawai_id' => $pegawai_id));
    }
  }
}
