<?php
class PerjalananDinasPegawaiController extends MyAuthController
{
  public $layout = '//layouts/iframe';
  public $defaultAction = 'index';

  public function actionIndex($pegawai_id = null)
  {
    $model = KPPegawaiM::model()->findByPk($pegawai_id);
    $modPerjalananDinas = new KPPerjalanandinasR;
    $details = array();

    if (isset($_POST['KPPerjalanandinasR'])) {
      $modPerjalananDinas->attributes = $_POST['KPPerjalanandinasR'];
      $modPerjalananDinas->pegawai_id = $pegawai_id;
      $details = $this->validasiTabular($_POST['KPPerjalanandinasR'], $model);
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $jumlah = count((array)$details);
        // echo "<pre>"; print_r($_POST['KPPerjalanandinasR']);exit();
        $tersimpan = 0;
        foreach ($details as $i => $row) {
          if ($row->save()) {

            $this->simpanPresensiDinas($row);

            $tersimpan++;
          }
        }

        if (($tersimpan > 0) && ($tersimpan == $jumlah)) {
          $transaction->commit();
          Yii::app()->user->setFlash('sukses', '<strong>Berhasil!</strong> Data berhasil disimpan.');
          $sukses = 1;
          $this->redirect(array('index', 'pegawai_id' => $pegawai_id, 'sukses' => $sukses));
        } else {
          throw new Exception('Data tidak valid');
        }
      } catch (Exception $ex) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', 'Data Gagal Disimpan ' . MyExceptionMessage::getMessage($ex, true));
      }
    }

    $this->render('index', array('model' => $model, 'modPerjalananDinas' => $modPerjalananDinas, 'details' => $details));
  }

  public function simpanPresensiDinas($model)
  {

    $peg = PegawaiM::model()->findByPk($model->pegawai_id);

    $period = new DatePeriod(
      new DateTime($model->tglmulaidinas),
      new DateInterval('P1D'),
      new DateTime(date('Y-m-d', strtotime('+1 day', strtotime($model->sampaidengan))))
    );

    foreach ($period as $item) {
      /*
            $cr = new CDbCriteria();
            $cr->compare('tglpresensi::date', $item->format('Y-m-d'));
            $cr->compare('pegawai_id', $model->pegawai_id);
            
            $presensi_ada = PresensiT::model()->find($cr);
            if (!empty($presensi_ada)) {
                continue;
            }
             * 
             */

      $presensi = new PresensiT;
      $presensi->verifikasi = true;
      $presensi->keterangan = "Perjalanan Dinas :<br>- Tujuan -> " . $model->tujuandinas . "<br/>- Tugas -> " . $model->tugasdinas;
      $presensi->pegawai_id = $model->pegawai_id;
      $presensi->tglpresensi = $item->format('Y-m-d H:i:s');
      $presensi->no_fingerprint = $peg->nofingerprint;
      $presensi->statuskehadiran_id = Params::STATUSKEHADIRAN_DINAS;
      $presensi->terlambat_mnt = $presensi->pulangawal_mnt = 0;
      $presensi->isfingerprintscan = false;

      $presensi->validate();
      $presensi->save();
    }
  }

  /**
   * menampilkan mutasi pegawai
   * @return rows table
   */
  public function actionGetPerjalananDinas()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $pegawai = $_POST['pegawai_id'];
      $model = PerjalanandinasR::model()->findAllByAttributes(array('pegawai_id' => $pegawai), array('order' => 'perjalanandinas_id'));
      $i = 1;
      $tr = '';
      foreach ($model as $row) {
        $urlDelete = $this->createUrl('deletePerjalanan', array('id' => $row->perjalanandinas_id, 'pegawai_id' => $pegawai));
        $tr .= '<tr>';
        $tr .= '<td>' . $i . ' </td>';
        $tr .= '<td>' . $row->nourutperj . '</td>';
        $tr .= '<td>' . $row->tujuandinas . '</td>';
        $tr .= '<td>' . $row->tugasdinas . '</td>';
        $tr .= '<td>' . $row->descdinas . '</td>';
        $tr .= '<td>' . $row->alamattujuan . '</td>';
        $tr .= '<td>' . $row->propinsi_nama . '</td>';
        $tr .= '<td>' . $row->kotakabupaten_nama . '</td>';
        $tr .= '<td>' . $row->tglmulaidinas . '</td>';
        $tr .= '<td>' . $row->sampaidengan . '</td>';
        $tr .= '<td>' . $row->negaratujuan . '</td>';
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
        if (!empty($data['perjalanandinas_id'])) {
          $details[$i] = KPPerjalanandinasR::model()->findByPk($data['perjalanandinas_id']);
          $details[$i]->attributes = $data;
          $pegawai = $data['pegawai_id'];
        } else {
          $details[$i] = new KPPerjalanandinasR();
          $details[$i]->attributes = $data;
          $details[$i]->tglmulaidinas = MyFormatter::formatDateTimeForDb($data['tglmulaidinas']);
          $details[$i]->sampaidengan = MyFormatter::formatDateTimeForDb($data['sampaidengan']);
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

  public function actiondeletePerjalanan($id, $pegawai_id)
  {
    $model = new KPPerjalanandinasR;
    if ($model->deleteByPK($id)) {
      $this->redirect(array('index', 'pegawai_id' => $pegawai_id));
    }
  }
}
