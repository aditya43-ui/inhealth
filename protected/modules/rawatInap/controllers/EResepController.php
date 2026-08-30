<?php

Yii::import('rawatJalan.models.RJInfokunjunganrjV');
Yii::import('rawatDarurat.models.RDInfokunjunganrdV');
Yii::import('persalinan.models.PSInfokunjunganpersalinanV');
Yii::import('hemodialisa.models.HDInfoKunjunganRDV');
class EResepController extends Controller
{
  public $path_view = 'application.modules.rawatInap.views.eResep.';
  public $init_modul = 'RI';

  public function actionIndex($reseptur_id = null)
  {
    $modKunjungan = new InfokunjunganriV;
    $modReseptur = new ResepturT;
    $modRiwayatResep = array();

    $modReseptur->noresep = "-- Otomatis --";
    $modReseptur->ruanganreseptur_id = Yii::app()->user->getState('ruangan_id');


    $modRiwayatResep = array();

    if (!empty($reseptur_id)) {
      $modReseptur = ResepturT::model()->findByPk($reseptur_id);

      if ($this->init_modul == 'RI') {
        $modKunjungan = InfokunjunganriV::model()->findByAttributes(array(
          'pendaftaran_id' => $modReseptur->pendaftaran_id,
        ));

        $modKunjungan->kamarruangan_nokamar .= " / " . $modKunjungan->kamarruangan_nobed;
      } elseif ($this->init_modul == 'RJ') {
        $modKunjungan = InfokunjunganrjV::model()->findByAttributes(array(
          'pendaftaran_id' => $modReseptur->pendaftaran_id,
        ));
      } elseif ($this->init_modul == 'RD') {
        $modKunjungan = InfokunjunganrdV::model()->findByAttributes(array(
          'pendaftaran_id' => $modReseptur->pendaftaran_id,
        ));
      } elseif ($this->init_modul == 'PS') {
        $modKunjungan = InfokunjunganpersalinanV::model()->findByAttributes(array(
          'pendaftaran_id' => $modReseptur->pendaftaran_id,
        ));
      } elseif ($this->init_modul == 'HD') {
        $modKunjungan = InfokunjunganhdV::model()->findByAttributes(array(
          'pendaftaran_id' => $modReseptur->pendaftaran_id,
        ));
      } else if ($this->init_modul == 'FA') {
        $modKunjungan = InfopasienpengunjungV::model()->findByAttributes(array(
          'pendaftaran_id' => $modReseptur->pendaftaran_id
        ));
      }

      $modKunjungan->tgl_pendaftaran = MyFormatter::formatDateTimeForUser($modKunjungan->tgl_pendaftaran);
      $modKunjungan->nama_pasien = $modKunjungan->namadepan . $modKunjungan->nama_pasien;

      $criRiwayat = new CDbCriteria();
      $criRiwayat->select = "t.tglreseptur, t.noresep, pegawai_id, t.reseptur_id, t.pendaftaran_id";
      $criRiwayat->join = " JOIN eresep_t e ON e.reseptur_id = t.reseptur_id ";
      $criRiwayat->addCondition(" pendaftaran_id = '" . $modKunjungan->pendaftaran_id . "' AND ruanganreseptur_id = '" . Yii::app()->user->getState('ruangan_id') . "' ");
      $criRiwayat->group = $criRiwayat->select;
      $criRiwayat->order = " t.create_time DESC ";

      $modRiwayatResep = ResepturT::model()->findAll($criRiwayat);
    }


    if (isset($_POST['ResepturT'])) {

      $trans = Yii::app()->db->beginTransaction();

      $ok = true;

      try {

        $modReseptur->attributes = $_POST['ResepturT'];
        $modReseptur->pendaftaran_id = $_POST['InfokunjunganriV']['pendaftaran_id'];
        $modReseptur->tglreseptur = MyFormatter::formatDateTimeForDB($modReseptur->tglreseptur);

        $admisi = PasienadmisiT::model()->findByAttributes(array(
          'pendaftaran_id' => $modReseptur->pendaftaran_id,
        ));

        if (!empty($admisi->pasienadmisi_id)) {
          $modReseptur->pasienadmisi_id = $admisi->pasienadmisi_id;
        }
        $modReseptur->pasien_id = $_POST['InfokunjunganriV']['pasien_id'];
        $modReseptur->noresep = MyGenerator::noResepReseptur();



        if ($modReseptur->validate()) {
          $ok = $ok && $modReseptur->save();

          $img_arr = array();

          if (isset($_POST['RIEresepT'])) {
            foreach ($_POST['RIEresepT'] as $ii => $val) {
              $modEresep = new RIEresepT();
              $modEresep->attributes = $_POST['RIEresepT'][$ii];
              $modEresep->reseptur_id = $modReseptur->reseptur_id;
              $modEresep->create_time = date('Y-m-d H:i:s');
              $modEresep->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
              $modEresep->create_ruangan = Yii::app()->user->getState('ruangan_id');
              $modEresep->create_iphost = Yii::app()->request->userHostAddress;

              $ok = $ok && $modEresep->save();

              if ($ok) {
                $img_arr[$ii]['text'] = $val['eresep_text'];
                $img_arr[$ii]['name'] = $val['eresep_image'];
              }
              //var_dump($modEresep->getErrors());

              //$image_text = str_replace('data:image/png;base64,', '', $image_text);
              //$image_text = str_replace(' ', '+', $image_text);
              //$image_text = base64_decode($image_text);                        
              //$file = Params::pathAnatomiTubuhDirectory().rand() . '.png';
              //$success = file_put_contents($file, $image_text);            
              //$source_img = imagecreatefromstring($image_text);
              //var_dump($source_img);die;

              //imagedestroy($source_img);
            }


            foreach ($img_arr as $img) {
              $image_text = str_replace('data:image/png;base64,', '', $img['text']);
              $image_text = str_replace(' ', '+', $image_text);
              $image_text = base64_decode($image_text);
              $file = Params::pathResepturDirectory() . $img['name'] . '.png';
              $success = file_put_contents($file, $image_text);
              $source_img = imagecreatefromstring($image_text);

              imagedestroy($source_img);
            }
          }
        } else {
          $ok = false;
        }




        //var_dump($ok);die;

        if ($ok) {
          $trans->commit();
          Yii::app()->user->setFlash('success', "Data Resep " . $modReseptur->noresep . " berhasil disimpan");
          $this->redirect(array('index', 'reseptur_id' => $modReseptur->reseptur_id));
        } else {
          $trans->rollback();
          Yii::app()->user->setFlash('error', "Data gagal disimpan ");
          $this->redirect(array('index'));
        }
      } catch (CException $exc) {
        $trans->rollback();
        Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
      }


      // var_dump($modReseptur->attributes, $_POST); die;



    }

    $this->render($this->path_view . 'index', array(
      'modKunjungan' => $modKunjungan,
      'modReseptur' => $modReseptur,
      'modRiwayatResep' => $modRiwayatResep,
    ));
  }

  public function actionScanFile($reseptur_id = null)
  {
    $modKunjungan = new InfokunjunganriV;
    $modReseptur = new ResepturT;
    $modRiwayatResep = array();

    $modReseptur->noresep = "-- Otomatis --";
    $modReseptur->ruanganreseptur_id = Yii::app()->user->getState('ruangan_id');


    if (!empty($reseptur_id)) {
      $modReseptur = ResepturT::model()->findByPk($reseptur_id);

      if ($this->init_modul == 'RI') {
        $modKunjungan = InfokunjunganriV::model()->findByAttributes(array(
          'pendaftaran_id' => $modReseptur->pendaftaran_id,
        ));

        $modKunjungan->kamarruangan_nokamar .= " / " . $modKunjungan->kamarruangan_nobed;
      } elseif ($this->init_modul == 'RJ') {
        $modKunjungan = InfokunjunganrjV::model()->findByAttributes(array(
          'pendaftaran_id' => $modReseptur->pendaftaran_id,
        ));
      } elseif ($this->init_modul == 'RD') {
        $modKunjungan = InfokunjunganrdV::model()->findByAttributes(array(
          'pendaftaran_id' => $modReseptur->pendaftaran_id,
        ));
      } else if ($this->init_modul == 'FA') {
        $modKunjungan = InfopasienpengunjungV::model()->findByAttributes(array(
          'pendaftaran_id' => $modReseptur->pendaftaran_id
        ));
      }

      $modKunjungan->tgl_pendaftaran = MyFormatter::formatDateTimeForUser($modKunjungan->tgl_pendaftaran);
      $modKunjungan->nama_pasien = $modKunjungan->namadepan . $modKunjungan->nama_pasien;
    }


    if (isset($_POST['ResepturT'])) {

      $trans = Yii::app()->db->beginTransaction();

      $ok = true;

      try {

        $modReseptur->attributes = $_POST['ResepturT'];
        $modReseptur->pendaftaran_id = $_POST['InfokunjunganriV']['pendaftaran_id'];
        $modReseptur->tglreseptur = MyFormatter::formatDateTimeForDB($modReseptur->tglreseptur);

        $admisi = PasienadmisiT::model()->findByAttributes(array(
          'pendaftaran_id' => $modReseptur->pendaftaran_id,
        ));

        if (!empty($admisi->pasienadmisi_id)) {
          $modReseptur->pasienadmisi_id = $admisi->pasienadmisi_id;
        }
        $modReseptur->pasien_id = $_POST['InfokunjunganriV']['pasien_id'];
        $modReseptur->noresep = MyGenerator::noResepReseptur();



        if ($modReseptur->validate()) {
          $ok = $ok && $modReseptur->save();

          if (isset($_POST['eresep'])) {
            foreach ($_POST['eresep'] as $idx => $v) {
              if ($v != "1") continue;

              $ok = $ok && EresepT::model()->updateByPk($idx, array(
                'reseptur_id' => $modReseptur->reseptur_id,
              ));
            }
          }
        } else {
          $ok = false;
        }




        // var_dump($ok);die;

        if ($ok) {
          $trans->commit();
          Yii::app()->user->setFlash('success', "Data Resep " . $modReseptur->noresep . " berhasil disimpan");
          $this->redirect(array('scanFile', 'reseptur_id' => $modReseptur->reseptur_id));
        } else {
          $trans->rollback();
          Yii::app()->user->setFlash('error', "Data gagal disimpan ");
          $this->redirect(array('scanFile'));
        }
      } catch (CException $exc) {
        $trans->rollback();
        Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
      }


      // var_dump($modReseptur->attributes, $_POST); die;



    }

    $this->render($this->path_view . 'scanFile', array(
      'modKunjungan' => $modKunjungan,
      'modReseptur' => $modReseptur,
      'modRiwayatResep' => $modRiwayatResep,
    ));
  }

  public function actionPrint()
  {
    $this->render('print');
  }


  /**
   * untuk load data pasien setelah di pilih no rekam medik
   */
  public function actionLoadDataPasien()
  {
    if (Yii::app()->request->isAjaxRequest) {

      $admisi = new PasienadmisiT;

      $instalasi_id = isset($_POST['instalasi_id']) ? $_POST['instalasi_id'] : null;

      if ($instalasi_id == Params::INSTALASI_ID_RI) {
        $data = InfokunjunganriV::model()->findByAttributes(array('pendaftaran_id' => $_POST['pendaftaran_id']));
        $admisi = PasienadmisiT::model()->findByPk($data->pasienadmisi_id);
        $diagnosa = PasienmorbiditasT::model()->find("pendaftaran_id = '" . $_POST['pendaftaran_id'] . "' AND pasienadmisi_id = '" . $admisi->pasienadmisi_id . "' AND kelompokdiagnosa_id = '" . Params::KELOMPOKDIAGNOSA_UTAMA . "' ");
      } else if ($instalasi_id == Params::INSTALASI_ID_RJ) {
        $data = InfokunjunganrjV::model()->findByAttributes(array('pendaftaran_id' => $_POST['pendaftaran_id']));
        $diagnosa = PasienmorbiditasT::model()->find("pendaftaran_id = '" . $_POST['pendaftaran_id'] . "' AND pasienadmisi_id is null AND kelompokdiagnosa_id = '" . Params::KELOMPOKDIAGNOSA_UTAMA . "' ");
      } else if ($instalasi_id == Params::INSTALASI_ID_RD) {
        $data = InfokunjunganrdV::model()->findByAttributes(array('pendaftaran_id' => $_POST['pendaftaran_id']));
        if (empty($data)) {
          $data = InfokunjunganpersalinanV::model()->findByAttributes(array('pendaftaran_id' => $_POST['pendaftaran_id']));
        }
        $diagnosa = PasienmorbiditasT::model()->find("pendaftaran_id = '" . $_POST['pendaftaran_id'] . "' AND pasienadmisi_id is null AND kelompokdiagnosa_id = '" . Params::KELOMPOKDIAGNOSA_UTAMA . "' ");
      } elseif ($instalasi_id == Params::INSTALASI_ID_HD) {
        $data = InfokunjunganhdV::model()->findByAttributes(array('pendaftaran_id' => $_POST['pendaftaran_id']));
        $diagnosa = PasienmorbiditasT::model()->find("pendaftaran_id = '" . $_POST['pendaftaran_id'] . "' AND pasienadmisi_id is null AND kelompokdiagnosa_id = '" . Params::KELOMPOKDIAGNOSA_UTAMA . "' ");
      } else {
        $data = InfopasienpengunjungV::model()->findByAttributes(array('pendaftaran_id' => $_POST['pendaftaran_id']));
        $diagnosa = PasienmorbiditasT::model()->find("pendaftaran_id = '" . $_POST['pendaftaran_id'] . "' AND pasienadmisi_id is null AND kelompokdiagnosa_id = '" . Params::KELOMPOKDIAGNOSA_UTAMA . "' ");
      }
      //$modRiwayatResep = RIResepturT::model()->findAllByAttributes(array('pendaftaran_id'=>$data->pendaftaran_id,'pasienadmisi_id'=>$admisi->pasienadmisi_id,'ruanganreseptur_id'=>Yii::app()->user->getState('ruangan_id')),array('order'=>'t.create_time DESC'));
      $criRiwayat = new CDbCriteria();
      $criRiwayat->select = "t.tglreseptur, t.noresep, pegawai_id, t.reseptur_id, t.pendaftaran_id";
      $criRiwayat->join = " JOIN eresep_t e ON e.reseptur_id = t.reseptur_id ";
      $criRiwayat->addCondition("pendaftaran_id = '" . $data->pendaftaran_id . "'");

      if (!empty($admisi->pasienadmisi_id)) {
        $criRiwayat->compare("pasienadmisi_id", $admisi->pasienadmisi_id);
      }

      $criRiwayat->group = $criRiwayat->select;
      $criRiwayat->order = " t.create_time DESC ";

      $modRiwayatResep = ResepturT::model()->findAll($criRiwayat);


      $post = array(
        'tgl_pendaftaran' => MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran),
        'no_pendaftaran' => $data->no_pendaftaran,
        'umur' => $data->umur,
        'jeniskasuspenyakit_nama' => $data->jeniskasuspenyakit_nama,
        'instalasi_nama' => $data->instalasi_nama,
        'ruangan_nama' => $data->ruangan_nama,
        'pendaftaran_id' => $data->pendaftaran_id,
        'pasien_id' => $data->pasien_id,
        'jeniskelamin' => $data->jeniskelamin,
        'statusperkawinan' => $data->statusperkawinan,
        'nama_pasien' => $data->namadepan . $data->nama_pasien,
        'nama_bin' => $data->nama_bin,
        'kamarruangan_nokamar' => empty($admisi->pasienadmisi_id) ? null : $data->kamarruangan_nokamar,
        'kamarruangan_nobed' => empty($admisi->pasienadmisi_id) ? null : $data->kamarruangan_nobed,
        'kelaspelayanan_nama' => $data->kelaspelayanan_nama,
        'carabayar_nama' => $data->carabayar_nama,
        'penjamin_nama' => $data->penjamin_nama,
        'no_rekam_medik' => $data->no_rekam_medik,
        'pendaftaran_id' => $data->pendaftaran_id,
        'diagnosa' => !(empty($diagnosa)) ? $diagnosa->diagnosa->diagnosa_nama : ''
      );


      if (!empty($admisi->dokterpenerima_id)) {
        $peg = PegawaiM::model()->findByPk($admisi->dokterpenerima_id);
        $post['dokterpenerima'] = $peg->namaLengkap;
      }

      if (!empty($data->pegawai_id)) {
        $peg = PegawaiM::model()->findByPk($data->pegawai_id);
        $post['dpjp1'] = $peg->namaLengkap;
      }

      if (!empty($data->dpjp2_id)) {
        $peg = PegawaiM::model()->findByPk($data->dpjp2_id);
        $post['dpjp2'] = $peg->namaLengkap;
      }

      if (!empty($data->dpjp3_id)) {
        $peg = PegawaiM::model()->findByPk($data->dpjp3_id);
        $post['dpjp3'] = $peg->namaLengkap;
      }

      $post['riwayat'] = $this->renderPartial($this->path_view . '_listResep', array(
        'modRiwayatResep' => $modRiwayatResep,
      ), true);




      echo CJSON::encode($post);
      Yii::app()->end();
    }
  }

  public function actionDaftarPasienRawatInap($term = '', $tipe = 1)
  {
    if (!Yii::app()->request->isAjaxRequest) {
      Yii::app()->end();
    }

    $model = new RIInfokunjunganriV;
    $model->ruangan_id = Yii::app()->user->getState('ruangan_id');

    switch ($tipe) {
      case 1:
        $model->no_pendaftaran = $term;
        break;
      case 2:
        $model->no_rekam_medik = $term;
        break;
      case 3:
        $model->nama_pasien = $term;
        break;
    }

    $returnVal = array();

    foreach ($model->searchTable()->data as $idx => $item) {
      // $sub = $item->attributes;
      $sub = array();
      $sub['label'] = $item->no_pendaftaran . " - " . $item->no_rekam_medik . " - " . $item->namadepan . $item->nama_pasien;
      $sub['value'] = $item->pendaftaran_id;
      $sub['no_pendaftaran'] = $item->no_pendaftaran;
      $sub['no_rekam_medik'] = $item->no_rekam_medik;
      $sub['nama_pasien'] = $item->namadepan . $item->nama_pasien;

      $returnVal[$idx] = $sub;
    }

    echo CJSON::encode($returnVal);
  }

  public function actionSimpanImage()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $image_text = isset($_POST['image_text']) ? $_POST['image_text'] : null;
      $no_pendaftaran = isset($_POST['no_pendaftaran']) ? $_POST['no_pendaftaran'] : null;
      $no_rekam_medik = isset($_POST['no_rekam_medik']) ? $_POST['no_rekam_medik'] : null;

      //$image_text = str_replace('data:image/png;base64,', '', $image_text);
      //$image_text = str_replace(' ', '+', $image_text);
      //$image_text = base64_decode($image_text);                        
      //$file = Params::pathAnatomiTubuhDirectory().rand() . '.png';
      //$success = file_put_contents($file, $image_text);            
      //$source_img = imagecreatefromstring($image_text);
      //var_dump($source_img);die;

      //imagedestroy($source_img);

      $eresep = new RIEresepT();
      $eresep->eresep_text = $image_text;
      $eresep->eresep_image = $no_rekam_medik . '_' . $no_pendaftaran . '_R1_' . date('YmdHis');

      $row = $this->renderPartial($this->path_view . '_rowImage', array('modEresep' => $eresep), true);


      $data['pesan'] = '';
      $data['html'] = $row;

      echo json_encode($data);


      Yii::app()->end();
    }
  }


  public function actionLoadFileScan()
  {
    if (!Yii::app()->request->isAjaxRequest) {
      Yii::app()->end();
    }

    $no_rm = $_POST['no_rm'];
    $no_pendaftaran = $_POST['no_pendaftaran'];

    $cr = new CDbCriteria();
    $cr->compare('eresep_image', $no_rm . "_" . $no_pendaftaran, true);
    $cr->addCondition('reseptur_id is null');
    $cr->order = 'create_time';

    $eresep = EresepT::model()->findAll($cr);

    $str = "";

    foreach ($eresep as $item) {
      $str .= $this->renderPartial($this->path_view . '_itemEresep', array(
        'item' => $item
      ), true);
    }

    echo CJSON::encode(array(
      'html' => $str,
    ));
  }

  public function actionDetailGambar($reseptur_id)
  {
    $this->layout = '//layouts/iframe';

    $eResep = EresepT::model()->findAllByAttributes(array('reseptur_id' => $reseptur_id));

    $this->render($this->path_view . '_detailGallery', array('eResep' => $eResep));
  }
}
