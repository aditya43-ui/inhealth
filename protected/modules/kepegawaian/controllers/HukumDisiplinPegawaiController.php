<?php
class HukumDisiplinPegawaiController extends MyAuthController
{
  public $layout = '//layouts/iframe';
  public $defaultAction = 'index';

  public function actionIndex($pegawai_id = null)
  {
    $model = KPPegawaiM::model()->findByPk($pegawai_id);
    $modHukdisiplin = new KPHukdisiplinR;
    $transaction = Yii::app()->db->beginTransaction();
    if (isset($_POST['submitHukdisiplin'])) {
      $modHukdisiplin = new KPHukdisiplinR;
      $modHukdisiplin->pegawai_id = $pegawai_id;
      $modHukdisiplin->attributes = $_POST['KPHukdisiplinR'];
      $modHukdisiplin->hukdisiplin_tglhukuman = MyFormatter::formatDateTimeForDb($_POST['KPHukdisiplinR']['hukdisiplin_tglhukuman']);
      $modHukdisiplin->create_time = date('Ymd');
      $modHukdisiplin->create_loginpemakai_id = Yii::app()->user->id;
      $modHukdisiplin->create_ruangan = Yii::app()->user->ruangan_id;
      $modHukdisiplin->hukdisiplin_mengetahui_id = $_POST['KPHukdisiplinR']['hukdisiplin_mengetahui_id'];
      $modHukdisiplin->hukdisiplin_mengetahui_tgl = MyFormatter::formatDateTimeForDb($_POST['KPHukdisiplinR']['hukdisiplin_mengetahui_tgl']);
      $modHukdisiplin->hukdisiplin_menyetujui_id = $_POST['KPHukdisiplinR']['hukdisiplin_menyetujui_id'];
      $modHukdisiplin->hukdisiplin_menyetujui_tgl = MyFormatter::formatDateTimeForDb($_POST['KPHukdisiplinR']['hukdisiplin_menyetujui_tgl']);
      if ($modHukdisiplin->validate()) {
        if ($modHukdisiplin->save()) {
          $transaction->commit();
          Yii::app()->user->setFlash('success', '<strong>Berhasil </strong> Data berhasil disimpan');
          $modHukdisiplin->unsetAttributes();
          $sukses = 1;
          $this->redirect(array('index', 'pegawai_id' => $pegawai_id, 'sukses' => $sukses));
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', '<strong>Gagal </strong> Data gagal disimpan');
        }
      }
    }
    $this->render('index', array('model' => $model, 'modHukdisiplin' => $modHukdisiplin));
  }

  /**
   * menampilkan hukuman disiplin pegawai
   * @return rows table
   */
  public function actionGetHukdisiplin()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $pegawai_id = $_POST['pegawai_id'];
      $modHukdisiplin = HukdisiplinR::model()->findAllByAttributes(array('pegawai_id' => $pegawai_id), array('order' => 'hukdisiplin_id'));
      $i = 1;
      $tr = '';
      foreach ($modHukdisiplin as $row) {
        $ruangan = RuanganM::model()->findByPk($row->hukdisiplin_ruangan);
        $urlDelete = $this->createUrl('deleteHukdisiplin', array('hukdisiplin_id' => $row->hukdisiplin_id, 'pegawai_id' => $pegawai_id));
        $tr .= '<tr>';

        $tr .= '<td>' . $i . ' </td>';
        $tr .= '<td>' . $row->jnshukdisiplin->jnshukdisiplin_nama . '</td>';
        $tr .= '<td>' . $row->jabatan->jabatan_nama . '</td>';
        $tr .= '<td>' .  MyFormatter::formatDateTimeForUser($row->hukdisiplin_tglhukuman) . '</td>';
        $tr .= '<td>' . $ruangan->ruangan_nama . '</td>';
        $tr .= '<td>' . $row->hukdisiplin_nosk . '</td>';
        $tr .= '<td>' . (isset($row->hukdisiplin_lama) ? $row->hukdisiplin_lama . " " . $row->hukdisiplin_satuanlama : '-') . '</td>';
        $tr .= '<td>' . $row->hukdisiplin_keterangan . '</td>';

        $tr .= '<td>' . CHtml::link('<i class="icon-form-sampah"></i>', $urlDelete, array('onclick' => 'hapus(this); return false')) . '</td>';
        $tr .= '</tr>';
        $i++;
      }

      $data['tr'] = $tr;

      echo json_encode($data);
      Yii::app()->end();
    }
  }

  public function actiondeleteHukdisiplin($hukdisiplin_id, $pegawai_id)
  {
    $modHukdisiplin = new KPHukdisiplinR;
    if ($modHukdisiplin->deleteByPK($hukdisiplin_id)) {
      $this->redirect(array('index', 'pegawai_id' => $pegawai_id));
    }
  }

  public function actionAutocompletePegawaiMengetahui()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $returnVal = array();
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(nama_pegawai)', strtolower($_GET['term']), true);
      $criteria->order = 'nama_pegawai';
      $criteria->limit = 5;
      $models = KPPegawaiV::model()->findAll($criteria);
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->gelardepan . " " . $model->nama_pegawai . " " . $model->gelarbelakang_nama;
        $returnVal[$i]['value'] = $model->pegawai_id;
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  public function actionAutocompletePegawaiMenyetujui()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $returnVal = array();
      $criteria = new CDbCriteria();
      $criteria->group = 'nomorindukpegawai,nama_pegawai,gelardepan,gelarbelakang_nama,alamat_pegawai,pegawai_id';
      $criteria->select = $criteria->group;
      $criteria->compare('LOWER(nama_pegawai)', strtolower($_GET['term']), true);
      $criteria->order = 'nama_pegawai';
      $criteria->limit = 5;
      $models = KPPegawairuanganV::model()->findAll($criteria);
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->gelardepan . " " . $model->nama_pegawai . " " . $model->gelarbelakang_nama;
        $returnVal[$i]['value'] = $model->pegawai_id;
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }
}
