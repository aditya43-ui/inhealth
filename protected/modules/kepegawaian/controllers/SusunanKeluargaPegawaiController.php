<?php
class SusunanKeluargaPegawaiController extends MyAuthController
{
  public $layout = '//layouts/iframe';
  public $defaultAction = 'index';

  public function actionIndex($pegawai_id = null)
  {
    $model = KPPegawaiM::model()->findByPk($pegawai_id);
    $modSusunanKeluarga = new KPSusunankelM;
    $details = array();

    if (isset($_POST['KPSusunankelM'])) {
     
      $details = $this->validasiTabular($_POST['KPSusunankelM'], $model);
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $jumlah = count((array)$details);
        $tersimpan = 0;
        $errorDetail = "";
        foreach ($_POST['KPSusunankelM'] as $i => $row) {
          $modSusunanKeluarga = new KPSusunankelM;
          $modSusunanKeluarga->attributes = $row;
          $modSusunanKeluarga->pegawai_id = $pegawai_id;
          $modSusunanKeluarga->susunankel_tanggallahir = MyFormatter::formatDateTimeForDb($row['susunankel_tanggallahir']);
          if (isset($_POST['KPSusunankelM']['susunankel_tanggalpernikahan'])) {
            $modSusunanKeluarga->susunankel_tanggalpernikahan = MyFormatter::formatDateTimeForDb(date('Y-m-d', strtotime($row['susunankel_tanggalpernikahan'])));
          }
          $modSusunanKeluarga->istanggungan = ($row['istanggungan'] == 0 ? false: $row['istanggungan']);
          if ($modSusunanKeluarga->validate()) {
            if ($modSusunanKeluarga->save()) {
              $tersimpan++;
            }
          } else {
            $errorDetail .= CHtml::errorSummary($modSusunanKeluarga);
          }
        }

        if ($tersimpan == count((array)$_POST['KPSusunankelM'])) {
          $transaction->commit();
          Yii::app()->user->setFlash('success', 'Data berhasil disimpan.');
          $sukses = 1;
          $this->redirect(array('index', 'pegawai_id' => $modSusunanKeluarga->pegawai_id, 'sukses' => $sukses));
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', 'Data gagal disimpan' . $errorDetail);
        }
      } catch (Exception $ex) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', 'Data Gagal Disimpan ' . MyExceptionMessage::getMessage($ex, true));
      }
    }
    $this->render('index', array('model' => $model, 'modSusunanKeluarga' => $modSusunanKeluarga, 'details' => $details));
  }

  /**
   * menampilkan keluarga pegawai
   * @return rows table
   */
  public function actionGetSusunanKeluarga()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $pegawai = $_POST['pegawai_id'];
      $model = SusunankelM::model()->findAllByAttributes(array('pegawai_id' => $pegawai), array('order' => 'susunankel_id'));
      $i = 1;
      $tr = '';
      foreach ($model as $row) {
        $urlDelete = $this->createUrl('deleteKeluarga', array('id' => $row->susunankel_id, 'pegawai_id' => $pegawai));
        $tr .= '<tr>';
        $tr .= '<td>' . $i . ' </td>';
        $tr .= '<td>' . $row->nourutkel . '</td>';
        $tr .= '<td>' . $row->no_kartu_keluarga . '</td>';
        $tr .= '<td>' . $row->hubkeluarga . '</td>';
        $tr .= '<td>' . $row->susunankel_nama . '</td>';
        $tr .= '<td>' . $row->susunankel_jk . '</td>';
        $tr .= '<td>' . $row->susunankel_tempatlahir . '</td>';
        $tr .= '<td>' . $row->susunankel_tanggallahir . '</td>';
        $tr .= '<td>' . $row->pekerjaan_nama . '</td>';
        $tr .= '<td>' . $row->pendidikan_nama . '</td>';
        $tr .= '<td>' . $row->susunankel_tanggalpernikahan . '</td>';
        $tr .= '<td>' . $row->susunankel_tempatpernikahan . '</td>';
        $tr .= '<td>' . $row->susunankeluarga_nip . '</td>';
        if ($model) {
          $tr .= '<td>' . CHtml::link('<i class="icon-form-sampah"></i>', $urlDelete, array('onclick' => 'hapus(this); return false')) . '</td>';
        }
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
        if (!empty($data['susunankel_id'])) {
          $details[$i] = KPSusunankelM::model()->findByPk($data['susunankel_id']);
          $details[$i]->susunankel_tanggallahir = MyFormatter::formatDateTimeForDb($data['susunankel_tanggallahir']);
          $details[$i]->susunankel_tanggalpernikahan = MyFormatter::formatDateTimeForDb($data['susunankel_tanggalpernikahan']);
          $details[$i]->attributes = $data;
          $pegawai = $data['pegawai_id'];
        } else {
          $details[$i] = new KPSusunankelM();
          $details[$i]->attributes = $data;
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

  public function actiondeleteKeluarga($id, $pegawai_id)
  {
    $model = new KPSusunankelM;
    if ($model->deleteByPK($id)) {
      $this->redirect(array('index', 'pegawai_id' => $pegawai_id));
    }
  }
}
