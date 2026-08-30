<?php
class PrestasiKerjaPegawaiController extends MyAuthController
{
  public $layout = '//layouts/iframe';
  public $defaultAction = 'index';

  public function actionIndex($pegawai_id = null)
  {
    $model = KPPegawaiM::model()->findByPk($pegawai_id);
    $modPrestasiKerja = new KPPrestasikerjaR;
    $details = array();

    if (isset($_POST['KPPrestasikerjaR'])) {
      $details = $this->validasiTabular($_POST['KPPrestasikerjaR'], $model);
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $jumlah = count((array)$details);
        $tersimpan = 0;
        $errorDetail = "";
        foreach ($_POST['KPPrestasikerjaR'] as $i => $row) {
          $modPrestasiKerja = new KPPrestasikerjaR;
          $modPrestasiKerja->attributes = $row;
          $modPrestasiKerja->pegawai_id = $pegawai_id;
          if (empty($row['tglprestasidiperoleh'])) {
            $modPrestasiKerja->tglprestasidiperoleh = null;
          }
          $modPrestasiKerja->tglprestasidiperoleh = MyFormatter::formatDateTimeForDb($row['tglprestasidiperoleh']);

          if ($modPrestasiKerja->validate()) {
            if ($modPrestasiKerja->save()) {
              $tersimpan++;
            }
          } else {
            $errorDetail .= CHtml::errorSummary($modPrestasiKerja);
          }
        }

        if ($tersimpan == count((array)$_POST['KPPrestasikerjaR'])) {
          $transaction->commit();
          Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
          $sukses = 1;
          $this->redirect(array('index', 'pegawai_id' => $modPrestasiKerja->pegawai_id, 'sukses' => $sukses));
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', '<strong>Gagal</strong> Data gagal disimpan' . $errorDetail);
        }
      } catch (Exception $ex) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', 'Data Gagal Disimpan ' . MyExceptionMessage::getMessage($ex, true));
      }
    }

    $this->render('index', array('model' => $model, 'modPrestasiKerja' => $modPrestasiKerja, 'details' => $details));
  }

  /**
   * menampilkan prestasi kerja pegawai
   * @return rows table
   */
  public function actionGetPrestasiKerja()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $pegawai = $_POST['pegawai_id'];
      $model = PrestasikerjaR::model()->findAllByAttributes(array('pegawai_id' => $pegawai), array('order' => 'tglprestasidiperoleh'));
      $i = 1;
      $tr = '';
      foreach ($model as $row) {
        $urlDelete = $this->createUrl('deletePrestasi', array('id' => $row->prestasikerja_id, 'pegawai_id' => $pegawai));
        $tr .= '<tr>';
        $tr .= '<td hidden>' . $i . ' </td>';
        $tr .= '<td>' . $row->nourutprestasi . '</td>';
        $tr .= '<td>' .  MyFormatter::formatDateTimeForUser($row->tglprestasidiperoleh) . '</td>';
        $tr .= '<td>' . $row->instansipemberi . '</td>';
        $tr .= '<td>' . $row->pejabatpemberi . '</td>';
        $tr .= '<td>' . $row->namapenghargaan . '</td>';
        $tr .= '<td>' . $row->keteranganprestasi . '</td>';
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
    foreach ($datas as $i => $data) {
      if (is_array($data)) {
        if (!empty($data['prestasikerja_id'])) {
          $details[$i] = KPPrestasikerjaR::model()->findByPk($data['prestasikerja_id']);
          $details[$i]->attributes = $data;
          $pegawai = $data['pegawai_id'];
        } else {
          $details[$i] = new KPPrestasikerjaR();
          $details[$i]->attributes = $data;
          $details[$i]->tglprestasidiperoleh = MyFormatter::formatDateTimeForDb($data['tglprestasidiperoleh']);
          $details[$i]->pegawai_id = $model->pegawai_id;
        }
        $details[$i]->validate();
      } else {
        if (empty($data)) {
        } else {
          $pegawai = $data;
        }
      }
    }
    return $details;
  }

  public function actiondeletePrestasi($id, $pegawai_id)
  {
    $model = new KPPrestasikerjaR;
    if ($model->deleteByPK($id)) {
      $this->redirect(array('index', 'pegawai_id' => $pegawai_id));
    }
  }
}
