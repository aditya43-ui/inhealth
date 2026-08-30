<?php
class DiklatPegawaiController extends MyAuthController
{
  public $layout = '//layouts/iframe';
  public $defaultAction = 'index';

  public function actionIndex($pegawai_id = null)
  {
    $model = KPPegawaiM::model()->findByPk($pegawai_id);
    $modPegawaidiklat = new KPPegawaidiklatT;
    $detailPegawaidiklat = array();
    $transaction = Yii::app()->db->beginTransaction();
    try {
      if (isset($_POST['KPPegawaidiklatT'])) {
        $details = $this->validasiTabularDiklat($_POST['KPPegawaidiklatT'], $model);
        $jumlah = count((array)$details);
        $tersimpan = 0;
        $errorDetail = "";
        foreach ($_POST['KPPegawaidiklatT'] as $i => $row) {
          $modPegawaidiklat = new KPPegawaidiklatT;
          $modPegawaidiklat->attributes = $row;
          $modPegawaidiklat->pegawai_id = $pegawai_id;
          $modPegawaidiklat->pegawaidiklat_lamanya = $row['pegawaidiklat_lamanya'] . ' ' . $row['pegawaidiklat_lamanyasatuan'];
          $modPegawaidiklat->create_loginpemakai_id = Yii::app()->user->id;
          $modPegawaidiklat->create_ruangan = Yii::app()->user->ruangan_id;
          $modPegawaidiklat->create_time = date('Y-m-d H:i:s');
          $modPegawaidiklat->pegawaidiklat_tahun = MyFormatter::formatDateTimeForDb($row['pegawaidiklat_tahun']);
          $modPegawaidiklat->tglditetapkandiklat = MyFormatter::formatDateTimeForDb($row['tglditetapkandiklat']);
          if ($modPegawaidiklat->validate()) {
            if ($modPegawaidiklat->save()) {
              $tersimpan++;
            }
          } else {
            $errorDetail .= CHtml::errorSummary($modPegawaidiklat);
          }
        }
        if ($tersimpan == count((array)$_POST['KPPegawaidiklatT'])) {
          $transaction->commit();
          Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
          $sukses = 1;
          $this->redirect(array('index', 'pegawai_id' => $pegawai_id, 'sukses' => $sukses));
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', '<strong>Gagal</strong> Data gagal disimpan' . $errorDetail);
        }
      }
    } catch (Exception $e) {
      $transaction->rollback();
      Yii::app()->user->setFlash('error', "Data gagal disimpan ! " . MyExceptionMessage::getMessage($e, true));
    }

    $this->render('index', array('model' => $model, 'modPegawaidiklat' => $modPegawaidiklat, 'detailPegawaidiklat' => $detailPegawaidiklat));
  }

  /**
   * menampilkan diklat pegawai
   * @return rows table
   */
  public function actionGetPegawaidiklat()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $pegawai_id = $_POST['pegawai_id'];
      $modPegawaidiklat = PegawaidiklatT::model()->findAllByAttributes(array('pegawai_id' => $pegawai_id), array('order' => 'tglditetapkandiklat'));
      $i = 1;
      $tr = '';
      foreach ($modPegawaidiklat as $row) {
        $dt = MyFormatter::formatDateTimeForUser(date('Y-m-d', strtotime(MyFormatter::formatDateTimeForDb($row->pegawaidiklat_tahun))));
        $ds = MyFormatter::formatDateTimeForUser(date('Y-m-d', strtotime(MyFormatter::formatDateTimeForDb($row->tglditetapkandiklat))));
        $urlDelete = $this->createUrl('deletePegawaidiklat', array('pegawaidiklat_id' => $row->pegawaidiklat_id, 'pegawai_id' => $pegawai_id));
        $tr .= '<tr>';
        $tr .= '<td>' . $i . ' </td>';
        $tr .= '<td>' . $row->jenisdiklat->jenisdiklat_nama . '</td>';
        $tr .= '<td>' . $row->pegawaidiklat_nama . '</td>';
        $tr .= '<td>' . $dt . '</td>';
        $tr .= '<td>' . $row->pegawaidiklat_lamanya . '</td>';
        $tr .= '<td>' . $row->pegawaidiklat_tempat . '</td>';
        $tr .= '<td>' . $row->nomorkeputusandiklat . '</td>';
        $tr .= '<td>' . $ds . '</td>';
        $tr .= '<td>' . $row->pejabatygmemdiklat . '</td>';
        $tr .= '<td>' . $row->pegawaidiklat_keterangan . '</td>';
        $tr .= '<td>' . CHtml::link('<i class="icon-form-sampah"></i>', $urlDelete, array('onclick' => 'hapus(this); return false')) . '</td>';
        $tr .= '</tr>';
        $i++;
      }

      $data['tr'] = $tr;

      echo json_encode($data);
      Yii::app()->end();
    }
  }

  public function actionDeletePegawaidiklat($pegawaidiklat_id, $pegawai_id)
  {
    $modPegawaidiklat = new KPPegawaidiklatT;
    if ($modPegawaidiklat->deleteByPK($pegawaidiklat_id)) {
      $this->redirect(array('index', 'pegawai_id' => $pegawai_id));
    }
  }

  protected function validasiTabularDiklat($datas, $model)
  {
    $pegawai = 0;
    $details = array();
    foreach ($datas as $i => $data) {
      $data = array_filter($data, 'strlen');
      if (is_array($data)) {
        if (!empty($data['pegawaidiklat_id'])) {
          $details[$i] = KPPegawaidiklatT::model()->findByPk($data['pegawaidiklat_id']);
          $details[$i]->attributes = $data;
          $details[$i]->pegawaidiklat_tahun = MyFormatter::formatDateTimeForDb($data['pegawaidiklat_tahun']);
          $details[$i]->tglditetapkandiklat = MyFormatter::formatDateTimeForDb($data['tglditetapkandiklat']);
          $pegawai = $data['pegawai_id'];
        } else {
          if (!empty($data['pegawaidiklat_nama'])) {
            $details[$i] = new KPPegawaidiklatT();
            $details[$i]->attributes = $data;
            $details[$i]->pegawaidiklat_tahun = MyFormatter::formatDateTimeForDb($data['pegawaidiklat_tahun']);
            $details[$i]->tglditetapkandiklat = MyFormatter::formatDateTimeForDb($data['tglditetapkandiklat']);
            $details[$i]->pegawai_id = $model->pegawai_id;
          }
        }
      } else {
        if (empty($data)) {
        } else {
          $pegawai = $data;
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
}
