<?php
class JabatanPegawaiController extends MyAuthController
{
  public $layout = '//layouts/iframe';
  public $defaultAction = 'index';

  public function actionIndex($pegawai_id = null)
  {
    $model = KPPegawaiM::model()->findByPk($pegawai_id);
    $modPegawaijabatan = new KPPegawaijabatanR;
    $transaction = Yii::app()->db->beginTransaction();
    if (isset($_POST['submitPegawaijabatan'])) {
      $modPegawaijabatan = new KPPegawaijabatanR;
      $modPegawaijabatan->pegawai_id = $pegawai_id;
      $modPegawaijabatan->attributes = $_POST['KPPegawaijabatanR'];
      $modPegawaijabatan->tglditetapkanjabatan = MyFormatter::formatDateTimeForDb($_POST['KPPegawaijabatanR']['tglditetapkanjabatan']);
      $modPegawaijabatan->tmtjabatan = MyFormatter::formatDateTimeForDb($_POST['KPPegawaijabatanR']['tmtjabatan']);
      $modPegawaijabatan->tglakhirjabatan = MyFormatter::formatDateTimeForDb($_POST['KPPegawaijabatanR']['tglakhirjabatan']);

      if (empty($_POST['KPPegawaijabatanR']['tglditetapkanjabatan'])) {
        $modPegawaijabatan->tglditetapkanjabatan = null;
      }
      if (empty($_POST['KPPegawaijabatanR']['tmtjabatan'])) {
        $modPegawaijabatan->tmtjabatan = null;
      }
      if (empty($_POST['KPPegawaijabatanR']['tglakhirjabatan'])) {
        $modPegawaijabatan->tglakhirjabatan = null;
      }
      $modPegawaijabatan->create_time = date('Ymd');
      $modPegawaijabatan->create_loginpemakai_id = Yii::app()->user->id;
      $modPegawaijabatan->create_ruangan = Yii::app()->user->ruangan_id;
      if ($modPegawaijabatan->validate()) {
        if ($modPegawaijabatan->save()) {
          $transaction->commit();
          Yii::app()->user->setFlash('success', '<strong>Berhasil </strong> Data berhasil disimpan');
          $modPegawaijabatan->unsetAttributes();
          $sukses = 1;
          $this->redirect(array('index', 'pegawai_id' => $pegawai_id, 'sukses' => $sukses));
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', '<strong>Gagal </strong> Data gagal disimpan');
        }
      }
    }
    $this->render('index', array('model' => $model, 'modPegawaijabatan' => $modPegawaijabatan));
  }

  /**
   * menampilkan jabatan pegawai
   * @return rows table
   */
  public function actionGetPegawaijabatan()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $pegawai_id = $_POST['pegawai_id'];
      $modPegawaijabatan = PegawaijabatanR::model()->findAllByAttributes(array('pegawai_id' => $pegawai_id), array('order' => 'tglditetapkanjabatan'));
      $i = 1;
      $tr = '';
      foreach ($modPegawaijabatan as $row) {
        $urlDelete = $this->createUrl('deletePegawaijabatan', array('pegawaijabatan_id' => $row->pegawaijabatan_id, 'pegawai_id' => $pegawai_id));
        $tr .= '<tr>';
        $tr .= '<td>' . $i . ' </td>';
        $tr .= '<td>' . $row->nomorkeputusanjabatan . '</td>';
        $tr .= '<td>' . $row->tglditetapkanjabatan . '</td>';
        $tr .= '<td>' . $row->tmtjabatan . '</td>';
        $tr .= '<td>' . $row->tglakhirjabatan . '</td>';
        $tr .= '<td>' . $row->keterangan . '</td>';
        $tr .= '<td>' . $row->pejabatygmemjabatan . '</td>';
        // $tr .= '<td>'.CHtml::link('<i class="icon-trash"></i>',$urlDelete,array('onclick'=>'return (!confirm("Anda yakin akan menghapus item ini ?")) ? false : true')).'</td>';
        $tr .= '<td>' . CHtml::link('<i class="icon-form-sampah"></i>', $urlDelete, array('onclick' => 'hapus(this); return false')) . '</td>';
        $tr .= '</tr>';
        $i++;
      }

      $data['tr'] = $tr;

      echo json_encode($data);
      Yii::app()->end();
    }
  }

  public function actiondeletePegawaijabatan($pegawaijabatan_id, $pegawai_id)
  {
    $modPegawaijabatan = new KPPegawaijabatanR;
    if ($modPegawaijabatan->deleteByPK($pegawaijabatan_id)) {
      $this->redirect(array('index', 'pegawai_id' => $pegawai_id));
    }
  }
}
