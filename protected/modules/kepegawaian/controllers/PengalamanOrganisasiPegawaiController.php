<?php
class PengalamanOrganisasiPegawaiController extends MyAuthController
{
  public $layout = '//layouts/iframe';
  public $defaultAction = 'index';

  public function actionIndex($pegawai_id = null)
  {
    $model = KPPegawaiM::model()->findByPk($pegawai_id);
    $modPengorganisasi = new KPPengorganisasiR;
    $detailPengorganisasiPegawai = array();
    $transaction = Yii::app()->db->beginTransaction();
    try {
      if (isset($_POST['KPPengorganisasiR'])) {
        $details = $this->validasiTabular($_POST['KPPengorganisasiR'], $model);
        $jumlah = count((array)$details);
        $tersimpan = 0;
        $errorDetail = "";
        foreach ($_POST['KPPengorganisasiR'] as $i => $row) {
          $modPengorganisasi = new KPPengorganisasiR;
          $modPengorganisasi->attributes = $row;
          $modPengorganisasi->pegawai_id = $pegawai_id;
          $modPengorganisasi->pengorganisasi_nama = $row['pengorganisasi_nama'];
          $modPengorganisasi->pengorganisasi_kedudukan = $row['pengorganisasi_kedudukan'];
          $modPengorganisasi->pengorganisasi_lamanya = $row['pengorganisasi_lamanya'] . ' ' . $row['lamanya'];
          $modPengorganisasi->pengorganisasi_tahun = MyFormatter::formatDateTimeForDb($row['pengorganisasi_tahun']);
          $modPengorganisasi->pengorganisasi_tempat = $row['pengorganisasi_tempat'];
          if ($modPengorganisasi->validate()) {
            if ($modPengorganisasi->save()) {
              $tersimpan++;
            }
          } else {
            $errorDetail .= CHtml::errorSummary($modPengorganisasi);
          }
        }
        if ($tersimpan == count((array)$_POST['KPPengorganisasiR'])) {
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

    $this->render('index', array('model' => $model, 'modPengorganisasi' => $modPengorganisasi, 'detailPengorganisasiPegawai' => $detailPengorganisasiPegawai));
  }

  /**
   * menampilkan pengalaman organisasi
   * @return rows table
   */
  public function actionGetPengOrganisasi()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $pegawai = $_POST['pegawai_id'];
      $model = PengorganisasiR::model()->findAllByAttributes(array('pegawai_id' => $pegawai), array('order' => 'pengorganisasi_tahun'));
      $i = 1;
      $tr = '';
      foreach ($model as $row) {
        $urlDelete = $this->createUrl('deletePengOrganisasi', array('id' => $row->pengorganisasi_id, 'pegawai_id' => $pegawai));

        $tr .= '<tr>';
        // $tr .= '<td>'.$i.' </td>';
        $tr .= '<td>' . $row->pengorganisasi_nama . '</td>';
        $tr .= '<td>' . $row->pengorganisasi_kedudukan . '</td>';
        $tr .= '<td>' . $row->pengorganisasi_tahun . '</td>';
        $tr .= '<td>' . $row->pengorganisasi_lamanya . '</td>';
        $tr .= '<td>' . $row->pengorganisasi_tempat . '</td>';
        $tr .= '<td>' . CHtml::link('<i class="icon-form-sampah"></i>', $urlDelete, array('onclick' => 'hapus(this); return false')) . '</td>';
        $tr .= '</tr>';
        $i++;
      }

      $data['tr'] = $tr;

      echo json_encode($data);
      Yii::app()->end();
    }
  }

  protected function validasiTabular($datas, $model)
  {
    $pegawai = 0;
    $details = array();
    foreach ($datas as $i => $data) {
      if (is_array($data)) {
        if (!empty($data['pengorganisasi_id'])) {
          $details[$i] = KPPengorganisasiR::model()->findByPk($data['pengorganisasi_id']);
          $details[$i]->attributes = $data;
          $pegawai = $data['pegawai_id'];
        } else {
          if (!empty($data['pengorganisasi_nama']) && !empty($data['pengorganisasi_lamanya'])) {
            $details[$i] = new KPPengorganisasiR();
            $details[$i]->attributes = $data;
            $details[$i]->pengorganisasi_tahun = MyFormatter::formatDateTimeForDb($data['pengorganisasi_tahun']);
            $details[$i]->pegawai_id = $pegawai;
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

  public function actiondeletePengOrganisasi($id, $pegawai_id)
  {
    $model = new KPPengorganisasiR;
    if ($model->deleteByPK($id)) {
      $this->redirect(array('index', 'pegawai_id' => $pegawai_id));
    }
  }
}
