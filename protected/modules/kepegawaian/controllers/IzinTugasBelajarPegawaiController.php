<?php
class IzinTugasBelajarPegawaiController extends MyAuthController
{
  public $layout = '//layouts/iframe';
  public $defaultAction = 'index';

  public function actionIndex($pegawai_id = null)
  {
    $model = KPPegawaiM::model()->findByPk($pegawai_id);
    $modIzintugasbelajar = new KPIzintugasbelajarR;
    $transaction = Yii::app()->db->beginTransaction();
    if (isset($_POST['submitIzintugasbelajar'])) {
      $modIzintugasbelajar = new KPIzintugasbelajarR;
      $modIzintugasbelajar->pegawai_id = $pegawai_id;
      $modIzintugasbelajar->attributes = $_POST['KPIzintugasbelajarR'];
      $modIzintugasbelajar->tglmulaibelajar = MyFormatter::formatDateTimeForDb($_POST['KPIzintugasbelajarR']['tglmulaibelajar']);
      $modIzintugasbelajar->tglselesaibelajar = MyFormatter::formatDateTimeForDb($_POST['KPIzintugasbelajarR']['tglselesaibelajar']);
      $modIzintugasbelajar->tglditetapkan = MyFormatter::formatDateTimeForDb($_POST['KPIzintugasbelajarR']['tglditetapkan']);

      if (empty($_POST['KPIzintugasbelajarR']['tglditetapkan'])) {
        $modIzintugasbelajar->tglditetapkan = null;
      }
      $modIzintugasbelajar->create_time = date('Ymd');
      $modIzintugasbelajar->create_loginpemakai_id = Yii::app()->user->id;
      $modIzintugasbelajar->create_ruangan = Yii::app()->user->ruangan_id;
      if ($modIzintugasbelajar->validate()) {
        if ($modIzintugasbelajar->save()) {
          $transaction->commit();
          Yii::app()->user->setFlash('success', '<strong>Berhasil </strong> Data berhasil disimpan');
          $modIzintugasbelajar->unsetAttributes();
          $sukses = 1;
          $this->redirect(array('index', 'pegawai_id' => $pegawai_id, 'sukses' => $sukses));
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', '<strong>Gagal </strong> Data gagal disimpan');
        }
      }
    }
    $this->render('index', array('model' => $model, 'modIzintugasbelajar' => $modIzintugasbelajar));
  }

  /**
   * menampilkan izin tugas belajar pegawai
   * @return rows table
   */
  public function actionGetIzintugasbelajar()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $pegawai_id = $_POST['pegawai_id'];
      $modIzintugasbelajar = IzintugasbelajarR::model()->findAllByAttributes(array('pegawai_id' => $pegawai_id), array('order' => 'izintugasbelajar_id'));
      $i = 1;
      $tr = '';
      foreach ($modIzintugasbelajar as $row) {
        $urlDelete = $this->createUrl('deleteIzintugasbelajar', array('izintugasbelajar_id' => $row->izintugasbelajar_id, 'pegawai_id' => $pegawai_id));
        $tr .= '<tr>';
        $tr .= '<td>' . $i . ' </td>';
        $tr .= '<td>' . $row->tglmulaibelajar . '</td>';
        $tr .= '<td>' . $row->nomorkeputusan . '</td>';
        $tr .= '<td>' . $row->tglditetapkan . '</td>';
        $tr .= '<td>' . $row->keteranganizin . '</td>';
        $tr .= '<td>' . $row->pejabatmemutuskan . '</td>';
        $tr .= '<td>' . CHtml::link('<i class="icon-form-sampah"></i>', $urlDelete, array('onclick' => 'hapus(this); return false')) . '</td>';
        $tr .= '</tr>';
        $i++;
      }

      $data['tr'] = $tr;

      echo json_encode($data);
      Yii::app()->end();
    }
  }

  public function actiondeleteIzintugasbelajar($izintugasbelajar_id, $pegawai_id)
  {
    $modIzintugasbelajar = new KPIzintugasbelajarR;
    if ($modIzintugasbelajar->deleteByPK($izintugasbelajar_id)) {
      $this->redirect(array('index', 'pegawai_id' => $pegawai_id));
    }
  }
}
