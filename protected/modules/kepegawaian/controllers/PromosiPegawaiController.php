<?php

/**
 *       - digunakan sebagai url utama untuk mengelola informasi dan tambah promosi pegawai
 *       @author		M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 *       @website	<piindonesia.co.id>
 */
class PromosiPegawaiController extends MyAuthController
{
  public $defaultAction = 'index';
  public $urlIframe = '';
  public $path_view = 'kepegawaian.views.promosiPegawai.';

  public function init()
  {
    if (isset($_GET['tab'])) {
      $this->layout = "//layouts/iframe";
      $this->urlIframe = 'frame';
    }
  }

  public function actionIndex($pegawai_id = null)
  {
    $this->pageTitle = Yii::app()->name . " - Promosi Pegawai";
    if (!empty($pegawai_id)) {
      $model = KPPegawaiM::model()->findByPk($pegawai_id);
    } else {
      $model = new KPPegawaiM;
    }
    $modPromosi = new KPPegpromosiR();


    if (isset($_POST['KPPegpromosiR'])) {
      $transaction = Yii::app()->db->beginTransaction();
      $ok = true;
      try {
        $modPromosi->attributes = $_POST['KPPegpromosiR'];
        $modPromosi->prom_tglsk = isset($modPromosi->prom_tglsk) ? MyFormatter::formatDateTimeForDb($modPromosi->prom_tglsk) : null;
        $modPromosi->prom_tmtsk = isset($modPromosi->prom_tmtsk) ? MyFormatter::formatDateTimeForDb($modPromosi->prom_tmtsk) : null;
        $modPromosi->prom_file_sk = CUploadedFile::getInstance($modPromosi, 'prom_file_sk');
        $file  = $modPromosi->prom_file_sk;
        //var_dump($file);die;


        if (!empty($modPromosi->prom_file_sk)) //Klo User Memasukan Logo
        {
          $random = $modPromosi->pegawai_id . date('ymd') . '.' . $modPromosi->prom_file_sk->getExtensionName();

          $modPromosi->prom_file_sk = $random; //.$model->photopegawai

          $fullImgName = $modPromosi->prom_file_sk;
          $fullImgSource = Params::pathPegPromosiFileDirectory() . $fullImgName;
        }

        $ok = $ok && $modPromosi->save();
        if ($ok) {
          if (!empty($modPromosi->prom_file_sk)) {
            $file->saveAs($fullImgSource);
          }

          $transaction->commit();
          Yii::app()->user->setFlash('success', 'Data ' . $modPromosi->pegawai->nama_pegawai . ' berhasil disimpan');
          $modPromosi->unsetAttributes();
          $sukses = 1;
          // if (!empty($pegawai_id)) $this->redirect(array('index','pegawai_id'=>$pegawai_id, 'sukses'=>$sukses, 'tab'=>$this->urlIframe));
          //                   else $this->redirect(array('index', 'sukses'=>$sukses, 'tab'=>$this->urlIframe));
          $this->redirect(array('index', 'sukses' => $sukses));
        } else {
          //var_dump($modPromosi->getErrors());die;
          $transaction->rollback();
          Yii::app()->user->setFlash('error', 'Data gagal disimpan');
        }
      } catch (Exception $ex) {

        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($ex, true));
      }
    }

    $this->render('index', array('model' => $model, 'modPegmutasi' => $modPromosi, 'pegawai_id' => $pegawai_id));
  }

  /**
   * menampilkan mutasi pegawai
   * @return rows table
   */
  public function actionGetPegmutasi()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $pegawai_id = $_POST['pegawai_id'];
      $modPromosi = PegmutasiR::model()->findAllByAttributes(array('pegawai_id' => $pegawai_id), array('order' => 'pegmutasi_id'));
      $i = 1;
      $tr = '';
      foreach ($modPromosi as $row) {
        $urlDelete = $this->createUrl('deletePegmutasi', array('pegmutasi_id' => $row->pegmutasi_id, 'pegawai_id' => $pegawai_id));
        $tr .= '<tr>';
        $tr .= '<td>' . $i . ' </td>';
        $tr .= '<td>' . $row->nomorsurat . '</td>';
        $tr .= '<td>' . $row->jabatan_nama . '</td>';
        //                    $tr .= '<td>'.$row->pangkat_nama.'</td>';
        $tr .= '<td>' . $row->nosk . '</td>';
        $tr .= '<td>' . $row->tglsk . '</td>';
        $tr .= '<td>' . $row->tmtsk . '</td>';
        $tr .= '<td>' . $row->jabatan_baru . '</td>';
        //                    $tr .= '<td>'.$row->pangkat_baru.'</td>';
        $tr .= '<td>' . $row->mengetahui_nama . '</td>';
        $tr .= '<td>' . $row->pimpinan_nama . '</td>';

        $tr .= '<td>' . CHtml::link('<i class="icon-form-sampah"></i>', $urlDelete, array('onclick' => 'hapus(this); return false')) . '</td>';
        $tr .= '</tr>';
        $i++;
      }

      $data['tr'] = $tr;

      echo json_encode($data);
      Yii::app()->end();
    }
  }

  public function actiondeletePegmutasi($pegmutasi_id, $pegawai_id)
  {
    $modPromosi = new KPPegmutasiR;
    if ($modPromosi->deleteByPK($pegmutasi_id)) {
      $this->redirect(array('index', 'pegawai_id' => $pegawai_id));
    }
  }

  public function actionInformasi()
  {
    $this->pageTitle = Yii::app()->name . " - Promosi Pegawai";
    //$this->layout = "//layouts/column1";
    $model = new KPPegpromosiR();
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');

    if (isset($_GET['KPPegpromosiR'])) {
      $model->attributes = $_GET['KPPegpromosiR'];
      $model->tgl_awal = MyFormatter::formatDateTimeForDb($_GET['KPPegpromosiR']['tgl_awal']);
      $model->tgl_akhir = MyFormatter::formatDateTimeForDb($_GET['KPPegpromosiR']['tgl_akhir']);
      $model->nama_pegawai = $_GET['KPPegpromosiR']['nama_pegawai'];
    }

    $this->render('informasi', array('model' => $model));
  }

  public function actionGetDataPegawai()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $data = PegawaiM::model()->findByAttributes(array('pegawai_id' => $_POST['idPegawai']));
      $post = array(
        'nomorindukpegawai' => $data->nomorindukpegawai,
        'pegawai_id' => $data->pegawai_id,
        'nama_pegawai' => $data->nama_pegawai,
        'tempatlahir_pegawai' => $data->tempatlahir_pegawai,
        'tgl_lahirpegawai' => MyFormatter::formatDateTimeForUser($data->tgl_lahirpegawai),
        'jabatan_nama' => (isset($data->jabatan->jabatan_nama) ? $data->jabatan->jabatan_nama : ''),
        'pangkat_nama' => (isset($data->pangkat->pangkat_nama) ? $data->pangkat->pangkat_nama : ''),
        'golonganpegawai_nama' => (isset($data->golonganpegawai->golonganpegawai_nama) ? $data->golonganpegawai->golonganpegawai_nama : ''),
        'kategoripegawai' => $data->kategoripegawai,
        'kategoripegawaiasal' => $data->kategoripegawaiasal,
        'kelompokpegawai_nama' => (isset($data->kelompokpegawai->kelompokpegawai_nama) ? $data->kelompokpegawai->kelompokpegawai_nama : ''),
        'pendidikan_nama' => (isset($data->pendidikan->pendidikan_nama) ? $data->pendidikan->pendidikan_nama : ''),
        'jeniskelamin' => $data->jeniskelamin,
        'statusperkawinan' => $data->statusperkawinan,
        'alamat_pegawai' => $data->alamat_pegawai,
        'photopegawai' => (!is_null($data->photopegawai) ? $data->photopegawai : ''),
      );
      echo CJSON::encode($post);
      Yii::app()->end();
    }
  }

  public function actionPegawairiwayat()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(nama_pegawai)', strtolower($_GET['term']), true);
      $criteria->order = 'nama_pegawai';
      $criteria->limit = 5;
      $models = PegawaiM::model()->findAll($criteria);

      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->nomorindukpegawai . ' - ' . $model->nama_pegawai . ' - ' . $model->jeniskelamin;
        $returnVal[$i]['nama_pegawai'] = $model->nama_pegawai;
        $returnVal[$i]['value'] = $model->pegawai_id;
        $returnVal[$i]['jabatan_nama'] = (isset($model->jabatan->jabatan_nama) ? $model->jabatan->jabatan_nama : '-');
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  public function actionPegawairiwayatNip()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(nomorindukpegawai)', strtolower($_GET['term']), true);
      $criteria->order = 'nomorindukpegawai';
      $criteria->limit = 5;
      $models = PegawaiM::model()->findAll($criteria);

      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->nomorindukpegawai . ' - ' . $model->nama_pegawai . ' - ' . $model->jeniskelamin;
        $returnVal[$i]['nama_pegawai'] = $model->nama_pegawai;
        $returnVal[$i]['value'] = $model->pegawai_id;
        $returnVal[$i]['jabatan_nama'] = (isset($model->jabatan->jabatan_nama) ? $model->jabatan->jabatan_nama : '-');
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }


  public function actionGetApproved()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $pimpinan = isset($_POST['pim']) ? $_POST['pim'] : null;
      $pegpromosi_id = isset($_POST['pegpro_id']) ? $_POST['pegpro_id'] : null;
      $dialog = isset($_POST['dialog']) ? $_POST['dialog'] : null;
      $status = isset($_POST['status']) ? $_POST['status'] : null;
      $alasan = isset($_POST['alasan']) ? $_POST['alasan'] : null;

      $data = array();
      $data['sukses'] = 0;
      $ok = true;


      $cekPeg = KPPegawaiM::model()->findByAttributes(array('nama_pegawai' => $pimpinan));

      $getPro = PegpromosiR::model()->findByPk($pegpromosi_id);

      // if ( ($cekPeg->nama_pegawai == $getPro->prom_pimpinan_nama) && ($cekPeg->jabatan_id == Params::JABATAN_ID_DIREKTUR)){
      if (empty($dialog)) {

        $getPro->prom_approval = date('Y-m-d H:i:s');
        $getPro->prom_pegapproval = Yii::app()->user->getState('pegawai_id');
        $getPro->prom_status = $status;
        $getPro->prom_alasan = $alasan;
        $ok = true && $getPro->save();

        if ($ok) {
          if ($getPro->prom_status = 'DISETUJUI') {
            $jb = JabatanM::model()->findByAttributes(array('jabatan_nama' => $getPro->prom_jabatan_baru));
            $pangkat = PangkatM::model()->findByAttributes(array('pangkat_nama' => $getPro->prom_pangkat_baru));
            $gol = GolonganpegawaiM::model()->findByAttributes(array('golonganpegawai_nama' => $getPro->prom_golongan_baru));

            $upPeg = KPPegawaiM::model()->findByPk($getPro->pegawai_id);
            $upPeg->golonganpegawai_id = (!empty($gol)) ? $gol->golonganpegawai_id : $upPeg->golonganpegawai_id;
            $upPeg->jabatan_id = (!empty($jb)) ? $jb->jabatan_id : $upPeg->jabatan_id;
            $upPeg->pangkat_id = (!empty($pangkat)) ? $pangkat->pangkat_id : $upPeg->pangkat_id;
            $ok = $ok && $upPeg->save();
          }



          $data['sukses'] = 1;
        }
      } else {
        $data['sukses'] = 1;

        $data['tr'] = $this->renderPartial('form/_getPegPromosi', array('model' => $getPro), true);
      }
      // }else{
      //   $data['pesan'] = 'Maaf, Hanya User dengan Jabatan <b>Direktur</b>';
      // }


      echo CJSON::encode($data);
    }
  }

  /**
   * - digunakan untuk menampilkan detail data poin pegawai, untuk melihat jumlah poin per nilai poin
   * @param type $id
   */
  public function actionDetail($id)
  {
    $this->layout = '//layouts/iframe';
    $model = KPPegpromosiR::model()->findByPk($id);
    $model->prom_tglsk = MyFormatter::formatDateTimeForUser($model->prom_tglsk);
    $model->prom_tmtsk = !empty($model->prom_tmtsk) ? MyFormatter::formatDateTimeForUser($model->prom_tmtsk) : '-';

    $this->render($this->path_view . 'detail/_detailInfo', array(
      'model' => $model,
      'judulLaporan' => '<b>Promosi Pegawai<br/><br/>' . 'Nomor Surat<br/></b>' . $model->prom_nomorsurat
    ));
  }
}
