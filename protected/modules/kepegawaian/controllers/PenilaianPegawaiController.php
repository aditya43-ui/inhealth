<?php

class PenilaianPegawaiController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/column1';
  public $defaultAction = 'index';
  protected $path_view = 'kepegawaian.views.penilaianPegawai.';
  public $saveDetail = true;
  /**
   * Lists all models.
   */
  public function actionIndex($id = null)
  {
    $this->pageTitle = Yii::app()->name . " - Penilaian Pegawai";
    $format = new MyFormatter;
    $model = new KPPenilaianpegawaiT();
    $modPegawai = new KPPegawaiM;
    $modPenilaianPegawaiDet = new KPPenilaianpegawaidetT();
    $tabelPenilaian = null;
    $model->tglpenilaian = date('d-m-Y'); // format seperti ini karena buat ngisi date mask
    $model->periodepenilaian = date('d F Y');
    $model->sampaidengan = date('d F Y');
    if (isset($_POST['KPPenilaianpegawaiT'])) {
      $ok = true;

    
       
      // var_dump($ok, $this->saveDetail); die;

      $transaction = Yii::app()->db->beginTransaction();
      try {


        $model = new KPPenilaianpegawaiT();
        $model->attributes = $_POST['KPPenilaianpegawaiT'];
        // $model->tglpenilaian =  MyFormatter::formatDateTimeForDb($_POST['KPPenilaianpegawaiT']['tglpenilaian']);
        $model->tanggal_keberatanpegawai = isset($_POST['KPPenilaianpegawaiT']['tanggal_keberatanpegawai']) ? date('Y-m-d', strtotime($_POST['KPPenilaianpegawaiT']['tanggal_keberatanpegawai'])) : null;
        $model->tglpenilaian = isset($_POST['KPPenilaianpegawaiT']['tglpenilaian']) ? date('Y-m-d', strtotime($_POST['KPPenilaianpegawaiT']['tglpenilaian'])) : null;
        $model->tanggal_tanggapanpejabat = isset($_POST['KPPenilaianpegawaiT']['tanggal_tanggapanpejabat']) ? date('Y-m-d', strtotime($_POST['KPPenilaianpegawaiT']['tanggal_tanggapanpejabat'])) : null;
        $model->tanggal_keputusanatasan = isset($_POST['KPPenilaianpegawaiT']['tanggal_keputusanatasan']) ? date('Y-m-d', strtotime($_POST['KPPenilaianpegawaiT']['tanggal_keputusanatasan'])) : null;
        $model->diterimatanggalpegawai = isset($_POST['KPPenilaianpegawaiT']['diterimatanggalpegawai']) ? date('Y-m-d', strtotime($_POST['KPPenilaianpegawaiT']['diterimatanggalpegawai'])) : null;
        $model->diterimatanggalatasan = isset($_POST['KPPenilaianpegawaiT']['diterimatanggalatasan']) ? date('Y-m-d', strtotime($_POST['KPPenilaianpegawaiT']['diterimatanggalatasan'])) : null;
       
        
        $model->penilainama = isset($_POST['penilainama']) ? $_POST['penilainama'] : null;
        $model->pimpinannama = isset($_POST['pimpinannama']) ? $_POST['pimpinannama'] : null;
        $model->jumlahpenilaian = isset($_POST['jumlahpenilaian']) ? $_POST['jumlahpenilaian'] : 1;
        $model->nilairatapenilaian = isset($_POST['nilairatapenilaian']) ? $_POST['nilairatapenilaian'] : 1;
        $model->jumlahpenilaian = isset($_POST['jumlahpenilaian']) ? $_POST['jumlahpenilaian'] : 1;
  
  
        $model->create_loginpemakai_id = Yii::app()->user->id;
        $model->create_ruangan = Yii::app()->user->ruangan_id;
        $model->create_time = date('Y-m-d H:i:s');
        if (is_array($model->penilaianpegawai_keterangan)) {
          $getKet = $model->penilaianpegawai_keterangan;
          $model->penilaianpegawai_keterangan = '';
          $i = 1;
          foreach ((array)$getKet as $ket) {
            if ($i == count((array)$getKet)) {
              $model->penilaianpegawai_keterangan .= $ket;
            } else {
              $model->penilaianpegawai_keterangan .= $ket . ' {{aspek}} ';
            }
          }
        }
  
        // var_dump($model->attributes);die;
        //$model->validate();
       
  
        if ($model->validate()) {
          $ok = $ok && $model->save();
          if (isset($_POST['KPPenilaianpegawaidetT'])) {
            foreach ($_POST['KPPenilaianpegawaidetT'] as $i => $postDetail) {
              $modPenilaianPegawaiDet = new KPPenilaianpegawaidetT();
              $modPenilaianPegawaiDet->attributes = $postDetail;
              $modPenilaianPegawaiDet->penilaianpegawai_id = $model->penilaianpegawai_id;
              $modPenilaianPegawaiDet->kolomrating_id = $postDetail['kolomrating_id'];
              $modPenilaianPegawaiDet->create_loginpemakai_id = Yii::app()->user->id;
              $modPenilaianPegawaiDet->create_ruangan = Yii::app()->user->ruangan_id;
              $modPenilaianPegawaiDet->create_time = date('Y-m-d H:i:s');
              if ($modPenilaianPegawaiDet->save()) {
                $this->saveDetail &= true;
              } else {
                $this->saveDetail &= false;
              }
            }
          }
       
        } else {
          // var_dump($model->getErrors());die;
          $ok = false;
        }
  
  

        if ($ok && $this->saveDetail) {
          $transaction->commit();
          Yii::app()->user->setFlash('success', 'Data ' . $model->pegawai->nama_pegawai . ' berhasil disimpan.');
          $this->redirect(array('index', 'id' => $model->pegawai_id, 'penilaianpegawai_id' => $model->penilaianpegawai_id, 'sukses' => 1));
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data Gagal Disimpan.");
        }
      } catch (Exception $e) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data Penilaiaan gagal disimpan ! " . MyExceptionMessage::getMessage($e, true));
      }
    }

    if (!empty($id)) {
      $modPegawai = KPPegawaiM::model()->findByPk($id);
      $modPegawai->jabatan_id = (isset($modPegawai->jabatan_id) ? $modPegawai->jabatan_id : null);
      $modPegawai->jabatan_nama = (isset($modPegawai->jabatan_id) ? $modPegawai->jabatan->jabatan_nama : "-");
      $modPegawai->pangkat_id = (isset($modPegawai->pangkat_id) ? $modPegawai->pangkat_id : null);
      $modPegawai->pangkat_nama = (isset($modPegawai->pangkat_id) ? $modPegawai->pangkat->pangkat_nama : "-");
      $modPegawai->kelompokpegawai_id = (isset($modPegawai->kelompokpegawai_id) ? $modPegawai->kelompokpegawai_id : null);
      $modPegawai->kelompokpegawai_nama = (isset($modPegawai->kelompokpegawai_id) ? $modPegawai->kelompokpegawai->kelompokpegawai_nama : "-");
      $modPegawai->pendidikan_id = (isset($modPegawai->pendidikan_id) ? $modPegawai->pendidikan_id : null);
      $modPegawai->pendidikan_nama = (isset($modPegawai->pendidikan_id) ? $modPegawai->pendidikan->pendidikan_nama : "-");
      $modPegawai->tgl_lahirpegawai = (isset($modPegawai->tgl_lahirpegawai) ? $format->formatDateTimeForUser($modPegawai->tgl_lahirpegawai) : "-");

      $tabelPenilaian = KPPenilaianpegawaiT::model()->findAllByAttributes(array('pegawai_id' => $modPegawai->pegawai_id));
      $model->pegawai_id = $id;
    }

    $this->render('index', array(
      'format' => $format,
      'model' => $model,
      'modPegawai' => $modPegawai,
      'modPenilaianPegawaiDet' => $modPenilaianPegawaiDet,
      'tabelPenilaian' => $tabelPenilaian
    ));
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
        'tgl_lahirpegawai' => $data->tgl_lahirpegawai,
        'jabatan_nama' => (isset($data->jabatan->jabatan_nama) ? $data->jabatan->jabatan_nama : ''),
        'pangkat_nama' => (isset($data->pangkat->pangkat_nama) ? $data->pangkat->pangkat_nama : ''),
        'kategoripegawai' => $data->kategoripegawai,
        'kategoripegawaiasal' => $data->kategoripegawaiasal,
        'kelompokpegawai_nama' => (isset($data->kelompokpegawai->kelompokpegawai_nama) ? $data->kelompokpegawai->kelompokpegawai_nama : ''),
        'pendidikan_nama' => (isset($data->pendidikan->pendidikan_nama) ? $data->pendidikan->pendidikan_nama : ''),
        'jeniskelamin' => $data->jeniskelamin,
        'statusperkawinan' => $data->statusperkawinan,
        'alamat_pegawai' => $data->alamat_pegawai,
        'jabatan_id' => $data->jabatan_id,
        'photopegawai' => (!is_null($data->photopegawai) ? $data->photopegawai : ''),
        'nama_lengkap' => $data->namaLengkap
      );
      echo CJSON::encode($post);
      Yii::app()->end();
    }
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

  public function actionCekScore()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $nilai = $_POST['nilai'];
      $indikator = $_POST['indikator'];
      $pesan = '';
      $pesanSkor = '';
      $rating_id = null;
      $point = 0;
      if ((!empty($nilai)) && (!empty($indikator))) {
        //$modKolomRating = KPKolomratingM::model()->findByPk($kolomrating_id);
        $cr = new CDbCriteria;
        // $cr->compare('indikatorperilaku_id',$indikator);
        $cr->addCondition($nilai . " between kolomrating_nilaiawal and kolomrating_nilaiakhir");
        $modKolomRating = KPKolomratingM::model()->find($cr);

        if (!empty($modKolomRating)) {
          $pesanSkor = $modKolomRating->kolomrating_namalevel;
          $rating_id = $modKolomRating->kolomrating_id;
          $point = $modKolomRating->kolomrating_point;
        } else {
          $pesan = 'Rating diluar jangkauan';
        }
      }
      echo CJSON::encode(array('pesan' => $pesan, 'pesanSkor' => $pesanSkor, 'rating_id' => $rating_id, 'point' => $point));
    }
    Yii::app()->end();
  }

  function actionLoadDataAfterSave()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $penilaianpegawai_id = $_POST['penilaianpegawai_id'];
      $modPenilaianPegawai = KPPenilaianpegawaiT::model()->findByPk($penilaianpegawai_id);
      $modPenilaianPegawaiDet = KPPenilaianpegawaidetT::model()->findAllByAttributes(array('penilaianpegawai_id' => $penilaianpegawai_id));
      $penilai = KPPegawaiM::model()->findByAttributes(array('nomorindukpegawai' => $modPenilaianPegawai->penilainip));
      $pimpinan = KPPegawaiM::model()->findByAttributes(array('nomorindukpegawai' => $modPenilaianPegawai->pimpinannip));
      echo CJSON::encode(array('modPenilaianPegawai' => $modPenilaianPegawai, 'modPenilaianPegawaiDet' => $modPenilaianPegawaiDet, 'penilai' => $penilai, 'pimpinan' => $pimpinan));
    }
    Yii::app()->end();
  }

  public function actionPrint($penilaianpegawai_id, $caraPrint = null)
  {
    $this->layout = '//layouts/printWindows';
    $penilaianpegawai_id = $_GET['penilaianpegawai_id'];
    $modPenilaianPegawai = KPPenilaianpegawaiT::model()->findByPk($penilaianpegawai_id);
    $modPenilaianPegawaiDet = KPPenilaianpegawaidetT::model()->findAllByAttributes(array('penilaianpegawai_id' => $penilaianpegawai_id));
    $judul_print = 'Form Penilaian Pegawai';
    $caraPrint = isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null;


    $evaluasi = $modPenilaianPegawaiDet;

    $criNl = new CDbCriteria();
    $criNl->addCondition(" kolomrating_aktif = TRUE ");
    $criNl->addInCondition(" kolomrating_point ", array(5, 4, 3, 2, 1));
    $criNl->order = " indikatorperilaku_id ASC,kolomrating_point DESC ";
    $criNl->limit = 5;

    $ketNilai = KPKolomratingM::model()->findAll($criNl);

    $data = array();

    $modPenilaianPegawaiDet = new KPPenilaianpegawaidetT;
    $model = new KPPenilaianpegawaiT;

    foreach ($evaluasi as $dt) {
      $data["$dt->jenispenilaian_id"]["jenispenilaian"] = $dt->jenispenilaian->jenispenilaian_nama;
      $data["$dt->jenispenilaian_id"]["jenispenilaian_id"] = $dt->jenispenilaian_id;
      $data["$dt->jenispenilaian_id"]["kompetensi"]["$dt->kompetensi_id"]["kompetensi_nama"] = $dt->kompetensi->kompetensi_nama;
      $data["$dt->jenispenilaian_id"]["kompetensi"]["$dt->kompetensi_id"]["kompetensi_id"] = $dt->kompetensi_id;
      $data["$dt->jenispenilaian_id"]["kompetensi"]["$dt->kompetensi_id"]["indikator"]["$dt->indikatorperilaku_id"]['indikatorperilaku_id'] = $dt->indikatorperilaku_id;
      $data["$dt->jenispenilaian_id"]["kompetensi"]["$dt->kompetensi_id"]["indikator"]["$dt->indikatorperilaku_id"]['indikatorperilaku_nama'] = $dt->indikatorperilaku->indikatorperilaku_nama;
      $data["$dt->jenispenilaian_id"]["kompetensi"]["$dt->kompetensi_id"]["indikator"]["$dt->indikatorperilaku_id"]['jenispenilaian_id'] = $dt->jenispenilaian_id;
      $data["$dt->jenispenilaian_id"]["kompetensi"]["$dt->kompetensi_id"]["indikator"]["$dt->indikatorperilaku_id"]['jenispenilaian_nama'] = $dt->jenispenilaian->jenispenilaian_nama;
      $data["$dt->jenispenilaian_id"]["kompetensi"]["$dt->kompetensi_id"]["indikator"]["$dt->indikatorperilaku_id"]['kompetensi_id'] = $dt->kompetensi->kompetensi_id;
      $data["$dt->jenispenilaian_id"]["kompetensi"]["$dt->kompetensi_id"]["indikator"]["$dt->indikatorperilaku_id"]['kompetensi_nama'] = $dt->kompetensi->kompetensi_nama;
      $data["$dt->jenispenilaian_id"]["kompetensi"]["$dt->kompetensi_id"]["indikator"]["$dt->indikatorperilaku_id"]['nilai'] = $dt->penilaianpegdet_socre;
      $data["$dt->jenispenilaian_id"]["kompetensi"]["$dt->kompetensi_id"]["indikator"]["$dt->indikatorperilaku_id"]['keterangan'] = $dt->keterangan;
      $data["$dt->jenispenilaian_id"]["kompetensi"]["$dt->kompetensi_id"]["indikator"]["$dt->indikatorperilaku_id"]['namanilai'] = $dt->kolomrating->kolomrating_namalevel;
    }

    $this->render('Print', array(
      'judul_print' => $judul_print,
      'modPenilaianPegawai' => $modPenilaianPegawai,
      'modPenilaianPegawaiDet' => $modPenilaianPegawaiDet,
      'generateTable' => $data,
      'ketNilai' => $ketNilai
    ));
  }


  public function actionGenerateFormulir()
  {

    if (Yii::app()->request->isAjaxRequest) {
      $jabatan_id = isset($_POST['jabatan_id']) ? $_POST['jabatan_id'] : 'null';
      $awal = isset($_POST['awal']) ? MyFormatter::formatDateTimeForDb($_POST['awal']) : 'null';
      $akhir = isset($_POST['akhir']) ? MyFormatter::formatDateTimeForDb($_POST['akhir']) : 'null';
      $pegawai = isset($_POST['pegawai_id']) ? $_POST['pegawai_id'] : 'null';
      $tingkatpenilaian = isset($_POST['tingkatpenilaian']) ? $_POST['tingkatpenilaian'] : null;

      $criCek = new CDbCriteria();
      $criCek->addCondition(" ('" . $awal . "' BETWEEN periodepenilaian AND sampaidengan) OR ('" . $akhir . "' BETWEEN periodepenilaian AND sampaidengan)");
      $criCek->addCondition(" pegawai_id = '" . $pegawai . "' ");
      $cekPeg = PenilaianpegawaiT::model()->find($criCek);

      if ($awal >= date('Y-m-d')) {
        if (empty($cekPeg)) {
          $cri = new CDbCriteria();
          $cri->join =  " JOIN jenispenilaian_m jp ON jp.jenispenilaian_id = t.jenispenilaian_id "
            . " JOIN kompetensi_m k ON k.kompetensi_id = t.kompetensi_id ";
          $cri->addCondition(" indikatorperilaku_aktif = TRUE  ");
          $cri->addCondition(" jabatan_id IS NULL OR jabatan_id = " . $jabatan_id . " ");
          if (!empty($tingkatpenilaian)) {
            $cri->addCondition(" jp.tingkatpenilaian = '" . $tingkatpenilaian . "'");
          }
          $cri->order = " jp.jenispenilaian_urutan ASC, k.kompetensi_urutan ASC, t.indikatorperilaku_urutan ";
          $evaluasi = KPIndikatorperilakuM::model()->findAll($cri);

          $criNl = new CDbCriteria();
          $criNl->addCondition(" kolomrating_aktif = TRUE ");
          $criNl->addInCondition(" kolomrating_point ", array(5, 4, 3, 2, 1));
          $criNl->order = " indikatorperilaku_id ASC,kolomrating_point DESC ";
          $criNl->limit = 5;

          $ketNilai = KPKolomratingM::model()->findAll($criNl);

          $data = array();

          $modPenilaianPegawaiDet = new KPPenilaianpegawaidetT;
          $model = new KPPenilaianpegawaiT;

          foreach ($evaluasi as $dt) {
            $data["$dt->jenispenilaian_id"]["jenispenilaian"] = $dt->jenispenilaian->jenispenilaian_nama;
            $data["$dt->jenispenilaian_id"]["jenispenilaian_id"] = $dt->jenispenilaian_id;
            $data["$dt->jenispenilaian_id"]["bobot_penilaian"] = !empty($dt->jenispenilaian_id) ? $dt->jenispenilaian->bobot_penilaian : 0;
            $data["$dt->jenispenilaian_id"]["kompetensi"]["$dt->kompetensi_id"]["kompetensi_nama"] = $dt->kompetensi->kompetensi_nama;
            $data["$dt->jenispenilaian_id"]["kompetensi"]["$dt->kompetensi_id"]["kompetensi_id"] = $dt->kompetensi_id;
            $data["$dt->jenispenilaian_id"]["kompetensi"]["$dt->kompetensi_id"]["indikator"]["$dt->indikatorperilaku_id"]['indikatorperilaku_id'] = $dt->indikatorperilaku_id;
            $data["$dt->jenispenilaian_id"]["kompetensi"]["$dt->kompetensi_id"]["indikator"]["$dt->indikatorperilaku_id"]['indikatorperilaku_nama'] = $dt->indikatorperilaku_nama;
            $data["$dt->jenispenilaian_id"]["kompetensi"]["$dt->kompetensi_id"]["indikator"]["$dt->indikatorperilaku_id"]['bobotnilai_indikator'] = !empty($dt->bobotnilai_indikator) ? $dt->bobotnilai_indikator : 0;
            $data["$dt->jenispenilaian_id"]["kompetensi"]["$dt->kompetensi_id"]["indikator"]["$dt->indikatorperilaku_id"]['jenispenilaian_id'] = $dt->jenispenilaian_id;
            $data["$dt->jenispenilaian_id"]["kompetensi"]["$dt->kompetensi_id"]["indikator"]["$dt->indikatorperilaku_id"]['jenispenilaian_nama'] = $dt->jenispenilaian->jenispenilaian_nama;
            $data["$dt->jenispenilaian_id"]["kompetensi"]["$dt->kompetensi_id"]["indikator"]["$dt->indikatorperilaku_id"]['kompetensi_id'] = $dt->kompetensi->kompetensi_id;
            $data["$dt->jenispenilaian_id"]["kompetensi"]["$dt->kompetensi_id"]["indikator"]["$dt->indikatorperilaku_id"]['kompetensi_nama'] = $dt->kompetensi->kompetensi_nama;
          }
          $sukses = 1;
          $pesan = 'sukses';
          $tr = $this->renderPartial($this->path_view . 'form._rowEvaluasiKinerja', array('generateTable' => $data, 'modPenilaianPegawaiDet' => $modPenilaianPegawaiDet, 'ketNilai' => $ketNilai, 'model' => $model), true);
        } else {
          $tr = '';
          $sukses = 0;
          $pesan = 'Maaf, Pegawai ' . $cekPeg->pegawai->namaLengkap . ' sudah dinilai pada periode ' . MyFormatter::formatDateTimeForUser($cekPeg->periodepenilaian) . ' s/d ' . MyFormatter::formatDateTimeForUser($cekPeg->sampaidengan);
        }
      } else {
        $tr = '';
        $sukses = 0;
        $pesan = 'Maaf, Periode yang Anda pilih, tidak boleh kurang dari hari ini ' . date('d F Y');
      }

      echo CJSON::encode(array('tr' => $tr, 'pesan' => $pesan, 'sukses' => $sukses));
    }
    Yii::app()->end();
  }

  /**
   * - digunakan untuk menampilkan informasi cuti pegawai
   */
  public function actionInformasi()
  {
    $this->pageTitle = Yii::app()->name . " - Penilaian Pegawai";
    $model  = new KPInfopenilaianpegawaiV();
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');

    if (isset($_GET['KPInfopenilaianpegawaiV'])) {
      $model->attributes = $_GET['KPInfopenilaianpegawaiV'];
      $model->tgl_awal = MyFormatter::formatDateTimeForDb($_GET['KPInfopenilaianpegawaiV']['tgl_awal']);
      $model->tgl_akhir = MyFormatter::formatDateTimeForDb($_GET['KPInfopenilaianpegawaiV']['tgl_akhir']);
    }

    $this->render($this->path_view . 'informasi', array('model' => $model));
  }

  /**
   * - digunakan untuk menampilkan detail data cuti pegawai
   * @param type $id
   */
  public function actionDetail($id)
  {
    $this->layout = '//layouts/iframe';

    $modPenilaianPegawai = KPPenilaianpegawaiT::model()->findByPk($id);
    $modPenilaianPegawaiDet = KPPenilaianpegawaidetT::model()->findAllByAttributes(array('penilaianpegawai_id' => $id));
    $judul_print = 'Form Penilaian Pegawai';
    $caraPrint = isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null;


    $evaluasi = $modPenilaianPegawaiDet;

    $criNl = new CDbCriteria();
    $criNl->addCondition(" kolomrating_aktif = TRUE ");
    $criNl->addInCondition(" kolomrating_point ", array(5, 4, 3, 2, 1));
    $criNl->order = " indikatorperilaku_id ASC,kolomrating_point DESC ";
    $criNl->limit = 5;

    $ketNilai = KPKolomratingM::model()->findAll($criNl);

    $data = array();

    $modPenilaianPegawaiDet = new KPPenilaianpegawaidetT;
    $model = new KPPenilaianpegawaiT;

    foreach ($evaluasi as $dt) {
      $data["$dt->jenispenilaian_id"]["jenispenilaian"] = $dt->jenispenilaian->jenispenilaian_nama;
      $data["$dt->jenispenilaian_id"]["jenispenilaian_id"] = $dt->jenispenilaian_id;
      $data["$dt->jenispenilaian_id"]["bobot_penilaian"] = !empty($dt->jenispenilaian_id) ? $dt->jenispenilaian->bobot_penilaian : 0;
      $data["$dt->jenispenilaian_id"]["kompetensi"]["$dt->kompetensi_id"]["kompetensi_nama"] = $dt->kompetensi->kompetensi_nama;
      $data["$dt->jenispenilaian_id"]["kompetensi"]["$dt->kompetensi_id"]["kompetensi_id"] = $dt->kompetensi_id;
      $data["$dt->jenispenilaian_id"]["kompetensi"]["$dt->kompetensi_id"]["indikator"]["$dt->indikatorperilaku_id"]['indikatorperilaku_id'] = $dt->indikatorperilaku_id;
      $data["$dt->jenispenilaian_id"]["kompetensi"]["$dt->kompetensi_id"]["indikator"]["$dt->indikatorperilaku_id"]['indikatorperilaku_nama'] = $dt->indikatorperilaku->indikatorperilaku_nama;
      $data["$dt->jenispenilaian_id"]["kompetensi"]["$dt->kompetensi_id"]["indikator"]["$dt->indikatorperilaku_id"]['bobotnilai_indikator'] = !empty($dt->indikatorperilaku->indikatorperilaku_id) ? $dt->indikatorperilaku->bobotnilai_indikator : 0;
      $data["$dt->jenispenilaian_id"]["kompetensi"]["$dt->kompetensi_id"]["indikator"]["$dt->indikatorperilaku_id"]['jenispenilaian_id'] = $dt->jenispenilaian_id;
      $data["$dt->jenispenilaian_id"]["kompetensi"]["$dt->kompetensi_id"]["indikator"]["$dt->indikatorperilaku_id"]['jenispenilaian_nama'] = $dt->jenispenilaian->jenispenilaian_nama;
      $data["$dt->jenispenilaian_id"]["kompetensi"]["$dt->kompetensi_id"]["indikator"]["$dt->indikatorperilaku_id"]['kompetensi_id'] = $dt->kompetensi->kompetensi_id;
      $data["$dt->jenispenilaian_id"]["kompetensi"]["$dt->kompetensi_id"]["indikator"]["$dt->indikatorperilaku_id"]['kompetensi_nama'] = $dt->kompetensi->kompetensi_nama;
      $data["$dt->jenispenilaian_id"]["kompetensi"]["$dt->kompetensi_id"]["indikator"]["$dt->indikatorperilaku_id"]['nilai'] = $dt->penilaianpegdet_socre;
      $data["$dt->jenispenilaian_id"]["kompetensi"]["$dt->kompetensi_id"]["indikator"]["$dt->indikatorperilaku_id"]['keterangan'] = $dt->keterangan;
      $data["$dt->jenispenilaian_id"]["kompetensi"]["$dt->kompetensi_id"]["indikator"]["$dt->indikatorperilaku_id"]['namanilai'] = $dt->kolomrating->kolomrating_namalevel;
    }

    $this->render('Print', array(
      'judul_print' => $judul_print,
      'modPenilaianPegawai' => $modPenilaianPegawai,
      'modPenilaianPegawaiDet' => $modPenilaianPegawaiDet,
      'generateTable' => $data,
      'ketNilai' => $ketNilai
    ));
  }

  public function actionApprovePenilai($penilaianpegawai_id, $approve = false)
  {
    $this->layout = '//layouts/iframe';
    $format = new MyFormatter();

    $modPenilaianPegawai = KPPenilaianpegawaiT::model()->findByPk($penilaianpegawai_id);
    $modPenilaianPegawaiDet = KPPenilaianpegawaidetT::model()->findAllByAttributes(array('penilaianpegawai_id' => $penilaianpegawai_id));
    $evaluasi = $modPenilaianPegawaiDet;

    $criNl = new CDbCriteria();
    $criNl->addCondition(" kolomrating_aktif = TRUE ");
    $criNl->addInCondition(" kolomrating_point ", array(5, 4, 3, 2, 1));
    $criNl->order = " indikatorperilaku_id ASC,kolomrating_point DESC ";
    $criNl->limit = 5;

    $ketNilai = KPKolomratingM::model()->findAll($criNl);

    $data = array();

    //		$modPenilaianPegawaiDet = new KPPenilaianpegawaidetT;
    //		$model = new KPPenilaianpegawaiT;

    foreach ($evaluasi as $dt) {
      $data["$dt->jenispenilaian_id"]["jenispenilaian"] = $dt->jenispenilaian->jenispenilaian_nama;
      $data["$dt->jenispenilaian_id"]["jenispenilaian_id"] = $dt->jenispenilaian_id;
      $data["$dt->jenispenilaian_id"]["bobot_penilaian"] = !empty($dt->jenispenilaian_id) ? $dt->jenispenilaian->bobot_penilaian : 0;
      $data["$dt->jenispenilaian_id"]["kompetensi"]["$dt->kompetensi_id"]["kompetensi_nama"] = $dt->kompetensi->kompetensi_nama;
      $data["$dt->jenispenilaian_id"]["kompetensi"]["$dt->kompetensi_id"]["kompetensi_id"] = $dt->kompetensi_id;
      $data["$dt->jenispenilaian_id"]["kompetensi"]["$dt->kompetensi_id"]["indikator"]["$dt->indikatorperilaku_id"]['indikatorperilaku_id'] = $dt->indikatorperilaku_id;
      $data["$dt->jenispenilaian_id"]["kompetensi"]["$dt->kompetensi_id"]["indikator"]["$dt->indikatorperilaku_id"]['indikatorperilaku_nama'] = $dt->indikatorperilaku->indikatorperilaku_nama;
      $data["$dt->jenispenilaian_id"]["kompetensi"]["$dt->kompetensi_id"]["indikator"]["$dt->indikatorperilaku_id"]['bobotnilai_indikator'] = !empty($dt->indikatorperilaku->indikatorperilaku_id) ? $dt->indikatorperilaku->bobotnilai_indikator : 0;
      $data["$dt->jenispenilaian_id"]["kompetensi"]["$dt->kompetensi_id"]["indikator"]["$dt->indikatorperilaku_id"]['jenispenilaian_id'] = $dt->jenispenilaian_id;
      $data["$dt->jenispenilaian_id"]["kompetensi"]["$dt->kompetensi_id"]["indikator"]["$dt->indikatorperilaku_id"]['jenispenilaian_nama'] = $dt->jenispenilaian->jenispenilaian_nama;
      $data["$dt->jenispenilaian_id"]["kompetensi"]["$dt->kompetensi_id"]["indikator"]["$dt->indikatorperilaku_id"]['kompetensi_id'] = $dt->kompetensi->kompetensi_id;
      $data["$dt->jenispenilaian_id"]["kompetensi"]["$dt->kompetensi_id"]["indikator"]["$dt->indikatorperilaku_id"]['kompetensi_nama'] = $dt->kompetensi->kompetensi_nama;
      $data["$dt->jenispenilaian_id"]["kompetensi"]["$dt->kompetensi_id"]["indikator"]["$dt->indikatorperilaku_id"]['nilai'] = $dt->penilaianpegdet_socre;
      $data["$dt->jenispenilaian_id"]["kompetensi"]["$dt->kompetensi_id"]["indikator"]["$dt->indikatorperilaku_id"]['keterangan'] = $dt->keterangan;
      $data["$dt->jenispenilaian_id"]["kompetensi"]["$dt->kompetensi_id"]["indikator"]["$dt->indikatorperilaku_id"]['namanilai'] = $dt->kolomrating->kolomrating_namalevel;
    }

    if ($approve) {
      $update = KPPenilaianpegawaiT::model()->updateByPk($penilaianpegawai_id, array('tanggal_approvepenilai' => date("Y-m-d H:i:s")));
      if ($update) {
        Yii::app()->user->setFlash('success', "Data berhasil disimpan");
        $this->redirect(array('approvePenilai', 'penilaianpegawai_id' => $penilaianpegawai_id, 'sukses' => 1));
      } else {
        Yii::app()->user->setFlash('error', "Data Gagal Disimpan");
      }
    }
    $judulLaporan = 'Penilaian Pegawai';
    $deskripsi = 'Tanggal ' . MyFormatter::formatDateTimeId(date('Y-m-d', strtotime($modPenilaianPegawai->tglpenilaian)));
    $this->render($this->path_view . '_penilai', array(
      'format' => $format,
      'judulLaporan' => $judulLaporan,
      'deskripsi' => $deskripsi,
      'modPenilaianPegawai' => $modPenilaianPegawai,
      'modPenilaianPegawaiDet' => $modPenilaianPegawaiDet,
      'generateTable' => $data,
      'ketNilai' => $ketNilai
    ));
  }

  public function actionPrintApprovePenilai($penilaianpegawai_id)
  {
    $format = new MyFormatter();

    $modPenilaianPegawai = KPPenilaianpegawaiT::model()->findByPk($penilaianpegawai_id);
    $modPenilaianPegawaiDet = KPPenilaianpegawaidetT::model()->findAllByAttributes(array('penilaianpegawai_id' => $penilaianpegawai_id));

    $evaluasi = $modPenilaianPegawaiDet;

    $criNl = new CDbCriteria();
    $criNl->addCondition(" kolomrating_aktif = TRUE ");
    $criNl->addInCondition(" kolomrating_point ", array(5, 4, 3, 2, 1));
    $criNl->order = " indikatorperilaku_id ASC,kolomrating_point DESC ";
    $criNl->limit = 5;

    $ketNilai = KPKolomratingM::model()->findAll($criNl);

    $data = array();

    $modPenilaianPegawaiDet = new KPPenilaianpegawaidetT;
    $model = new KPPenilaianpegawaiT;

    foreach ($evaluasi as $dt) {
      $data["$dt->jenispenilaian_id"]["jenispenilaian"] = $dt->jenispenilaian->jenispenilaian_nama;
      $data["$dt->jenispenilaian_id"]["jenispenilaian_id"] = $dt->jenispenilaian_id;
      $data["$dt->jenispenilaian_id"]["bobot_penilaian"] = !empty($dt->jenispenilaian_id) ? $dt->jenispenilaian->bobot_penilaian : 0;
      $data["$dt->jenispenilaian_id"]["kompetensi"]["$dt->kompetensi_id"]["kompetensi_nama"] = $dt->kompetensi->kompetensi_nama;
      $data["$dt->jenispenilaian_id"]["kompetensi"]["$dt->kompetensi_id"]["kompetensi_id"] = $dt->kompetensi_id;
      $data["$dt->jenispenilaian_id"]["kompetensi"]["$dt->kompetensi_id"]["indikator"]["$dt->indikatorperilaku_id"]['indikatorperilaku_id'] = $dt->indikatorperilaku_id;
      $data["$dt->jenispenilaian_id"]["kompetensi"]["$dt->kompetensi_id"]["indikator"]["$dt->indikatorperilaku_id"]['indikatorperilaku_nama'] = $dt->indikatorperilaku->indikatorperilaku_nama;
      $data["$dt->jenispenilaian_id"]["kompetensi"]["$dt->kompetensi_id"]["indikator"]["$dt->indikatorperilaku_id"]['bobotnilai_indikator'] = !empty($dt->indikatorperilaku->indikatorperilaku_id) ? $dt->indikatorperilaku->bobotnilai_indikator : 0;
      $data["$dt->jenispenilaian_id"]["kompetensi"]["$dt->kompetensi_id"]["indikator"]["$dt->indikatorperilaku_id"]['jenispenilaian_id'] = $dt->jenispenilaian_id;
      $data["$dt->jenispenilaian_id"]["kompetensi"]["$dt->kompetensi_id"]["indikator"]["$dt->indikatorperilaku_id"]['jenispenilaian_nama'] = $dt->jenispenilaian->jenispenilaian_nama;
      $data["$dt->jenispenilaian_id"]["kompetensi"]["$dt->kompetensi_id"]["indikator"]["$dt->indikatorperilaku_id"]['kompetensi_id'] = $dt->kompetensi->kompetensi_id;
      $data["$dt->jenispenilaian_id"]["kompetensi"]["$dt->kompetensi_id"]["indikator"]["$dt->indikatorperilaku_id"]['kompetensi_nama'] = $dt->kompetensi->kompetensi_nama;
      $data["$dt->jenispenilaian_id"]["kompetensi"]["$dt->kompetensi_id"]["indikator"]["$dt->indikatorperilaku_id"]['nilai'] = $dt->penilaianpegdet_socre;
      $data["$dt->jenispenilaian_id"]["kompetensi"]["$dt->kompetensi_id"]["indikator"]["$dt->indikatorperilaku_id"]['keterangan'] = $dt->keterangan;
      $data["$dt->jenispenilaian_id"]["kompetensi"]["$dt->kompetensi_id"]["indikator"]["$dt->indikatorperilaku_id"]['namanilai'] = $dt->kolomrating->kolomrating_namalevel;
    }
    $judulLaporan = 'Penilaian Pegawai';
    $caraPrint = (isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null);
    $modelUrl = array(
      'format' => $format,
      'judulLaporan' => $judulLaporan,
      //				'deskripsi'=>$deskripsi,
      'modPenilaianPegawai' => $modPenilaianPegawai,
      'modPenilaianPegawaiDet' => $modPenilaianPegawaiDet,
      'generateTable' => $data,
      'ketNilai' => $ketNilai,
      'caraPrint' => $caraPrint
    );
    //		$deskripsi = 'Tanggal '.MyFormatter::formatDateTimeId($model->tglrencana);

    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render($this->path_view . 'printPenilai', $modelUrl);
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render($this->path_view . 'printPenilai', $modelUrl);
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas'); //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas'); //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      //$mpdf->useOddEven = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML($this->renderPartial($this->path_view . 'printPenilai', $modelUrl, true));
      $mpdf->Output();
    }
  }

  public function actionApprovePemimpin($penilaianpegawai_id, $approve = false)
  {
    $this->layout = '//layouts/iframe';
    $format = new MyFormatter();

    $modPenilaianPegawai = KPPenilaianpegawaiT::model()->findByPk($penilaianpegawai_id);
    $modPenilaianPegawaiDet = KPPenilaianpegawaidetT::model()->findAllByAttributes(array('penilaianpegawai_id' => $penilaianpegawai_id));

    $evaluasi = $modPenilaianPegawaiDet;

    $criNl = new CDbCriteria();
    $criNl->addCondition(" kolomrating_aktif = TRUE ");
    $criNl->addInCondition(" kolomrating_point ", array(5, 4, 3, 2, 1));
    $criNl->order = " indikatorperilaku_id ASC,kolomrating_point DESC ";
    $criNl->limit = 5;

    $ketNilai = KPKolomratingM::model()->findAll($criNl);

    $data = array();

    //		$modPenilaianPegawaiDet = new KPPenilaianpegawaidetT;
    //		$model = new KPPenilaianpegawaiT;

    foreach ($evaluasi as $dt) {
      $data["$dt->jenispenilaian_id"]["jenispenilaian"] = $dt->jenispenilaian->jenispenilaian_nama;
      $data["$dt->jenispenilaian_id"]["jenispenilaian_id"] = $dt->jenispenilaian_id;
      $data["$dt->jenispenilaian_id"]["bobot_penilaian"] = !empty($dt->jenispenilaian_id) ? $dt->jenispenilaian->bobot_penilaian : 0;
      $data["$dt->jenispenilaian_id"]["kompetensi"]["$dt->kompetensi_id"]["kompetensi_nama"] = $dt->kompetensi->kompetensi_nama;
      $data["$dt->jenispenilaian_id"]["kompetensi"]["$dt->kompetensi_id"]["kompetensi_id"] = $dt->kompetensi_id;
      $data["$dt->jenispenilaian_id"]["kompetensi"]["$dt->kompetensi_id"]["indikator"]["$dt->indikatorperilaku_id"]['indikatorperilaku_id'] = $dt->indikatorperilaku_id;
      $data["$dt->jenispenilaian_id"]["kompetensi"]["$dt->kompetensi_id"]["indikator"]["$dt->indikatorperilaku_id"]['indikatorperilaku_nama'] = $dt->indikatorperilaku->indikatorperilaku_nama;
      $data["$dt->jenispenilaian_id"]["kompetensi"]["$dt->kompetensi_id"]["indikator"]["$dt->indikatorperilaku_id"]['bobotnilai_indikator'] = !empty($dt->indikatorperilaku->indikatorperilaku_id) ? $dt->indikatorperilaku->bobotnilai_indikator : 0;
      $data["$dt->jenispenilaian_id"]["kompetensi"]["$dt->kompetensi_id"]["indikator"]["$dt->indikatorperilaku_id"]['jenispenilaian_id'] = $dt->jenispenilaian_id;
      $data["$dt->jenispenilaian_id"]["kompetensi"]["$dt->kompetensi_id"]["indikator"]["$dt->indikatorperilaku_id"]['jenispenilaian_nama'] = $dt->jenispenilaian->jenispenilaian_nama;
      $data["$dt->jenispenilaian_id"]["kompetensi"]["$dt->kompetensi_id"]["indikator"]["$dt->indikatorperilaku_id"]['kompetensi_id'] = $dt->kompetensi->kompetensi_id;
      $data["$dt->jenispenilaian_id"]["kompetensi"]["$dt->kompetensi_id"]["indikator"]["$dt->indikatorperilaku_id"]['kompetensi_nama'] = $dt->kompetensi->kompetensi_nama;
      $data["$dt->jenispenilaian_id"]["kompetensi"]["$dt->kompetensi_id"]["indikator"]["$dt->indikatorperilaku_id"]['nilai'] = $dt->penilaianpegdet_socre;
      $data["$dt->jenispenilaian_id"]["kompetensi"]["$dt->kompetensi_id"]["indikator"]["$dt->indikatorperilaku_id"]['keterangan'] = $dt->keterangan;
      $data["$dt->jenispenilaian_id"]["kompetensi"]["$dt->kompetensi_id"]["indikator"]["$dt->indikatorperilaku_id"]['namanilai'] = $dt->kolomrating->kolomrating_namalevel;
    }

    if ($approve) {
      $update = KPPenilaianpegawaiT::model()->updateByPk($penilaianpegawai_id, array('tanggal_approvepemimpin' => date("Y-m-d H:i:s")));
      if ($update) {
        Yii::app()->user->setFlash('success', "Data berhasil disimpan");
        $this->redirect(array('approvePemimpin', 'penilaianpegawai_id' => $penilaianpegawai_id, 'sukses' => 1));
      } else {
        Yii::app()->user->setFlash('error', "Data Gagal Disimpan");
      }
    }
    $judulLaporan = 'Penilaian Pegawai';
    $deskripsi = 'Tanggal ' . MyFormatter::formatDateTimeId(date('Y-m-d', strtotime($modPenilaianPegawai->tglpenilaian)));
    $this->render($this->path_view . '_pemimpin', array(
      'format' => $format,
      'judulLaporan' => $judulLaporan,
      'deskripsi' => $deskripsi,
      'modPenilaianPegawai' => $modPenilaianPegawai,
      'modPenilaianPegawaiDet' => $modPenilaianPegawaiDet,
      'generateTable' => $data,
      'ketNilai' => $ketNilai
    ));
  }

  public function actionPrintApprovePemimpin($penilaianpegawai_id)
  {
    $format = new MyFormatter();

    $modPenilaianPegawai = KPPenilaianpegawaiT::model()->findByPk($penilaianpegawai_id);
    $modPenilaianPegawaiDet = KPPenilaianpegawaidetT::model()->findAllByAttributes(array('penilaianpegawai_id' => $penilaianpegawai_id));
    $evaluasi = $modPenilaianPegawaiDet;

    $criNl = new CDbCriteria();
    $criNl->addCondition(" kolomrating_aktif = TRUE ");
    $criNl->addInCondition(" kolomrating_point ", array(5, 4, 3, 2, 1));
    $criNl->order = " indikatorperilaku_id ASC,kolomrating_point DESC ";
    $criNl->limit = 5;

    $ketNilai = KPKolomratingM::model()->findAll($criNl);

    $data = array();

    //		$modPenilaianPegawaiDet = new KPPenilaianpegawaidetT;
    //		$model = new KPPenilaianpegawaiT;

    foreach ($evaluasi as $dt) {
      $data["$dt->jenispenilaian_id"]["jenispenilaian"] = $dt->jenispenilaian->jenispenilaian_nama;
      $data["$dt->jenispenilaian_id"]["jenispenilaian_id"] = $dt->jenispenilaian_id;
      $data["$dt->jenispenilaian_id"]["bobot_penilaian"] = !empty($dt->jenispenilaian_id) ? $dt->jenispenilaian->bobot_penilaian : 0;
      $data["$dt->jenispenilaian_id"]["kompetensi"]["$dt->kompetensi_id"]["kompetensi_nama"] = $dt->kompetensi->kompetensi_nama;
      $data["$dt->jenispenilaian_id"]["kompetensi"]["$dt->kompetensi_id"]["kompetensi_id"] = $dt->kompetensi_id;
      $data["$dt->jenispenilaian_id"]["kompetensi"]["$dt->kompetensi_id"]["indikator"]["$dt->indikatorperilaku_id"]['indikatorperilaku_id'] = $dt->indikatorperilaku_id;
      $data["$dt->jenispenilaian_id"]["kompetensi"]["$dt->kompetensi_id"]["indikator"]["$dt->indikatorperilaku_id"]['indikatorperilaku_nama'] = $dt->indikatorperilaku->indikatorperilaku_nama;
      $data["$dt->jenispenilaian_id"]["kompetensi"]["$dt->kompetensi_id"]["indikator"]["$dt->indikatorperilaku_id"]['bobotnilai_indikator'] = !empty($dt->indikatorperilaku->indikatorperilaku_id) ? $dt->indikatorperilaku->bobotnilai_indikator : 0;
      $data["$dt->jenispenilaian_id"]["kompetensi"]["$dt->kompetensi_id"]["indikator"]["$dt->indikatorperilaku_id"]['jenispenilaian_id'] = $dt->jenispenilaian_id;
      $data["$dt->jenispenilaian_id"]["kompetensi"]["$dt->kompetensi_id"]["indikator"]["$dt->indikatorperilaku_id"]['jenispenilaian_nama'] = $dt->jenispenilaian->jenispenilaian_nama;
      $data["$dt->jenispenilaian_id"]["kompetensi"]["$dt->kompetensi_id"]["indikator"]["$dt->indikatorperilaku_id"]['kompetensi_id'] = $dt->kompetensi->kompetensi_id;
      $data["$dt->jenispenilaian_id"]["kompetensi"]["$dt->kompetensi_id"]["indikator"]["$dt->indikatorperilaku_id"]['kompetensi_nama'] = $dt->kompetensi->kompetensi_nama;
      $data["$dt->jenispenilaian_id"]["kompetensi"]["$dt->kompetensi_id"]["indikator"]["$dt->indikatorperilaku_id"]['nilai'] = $dt->penilaianpegdet_socre;
      $data["$dt->jenispenilaian_id"]["kompetensi"]["$dt->kompetensi_id"]["indikator"]["$dt->indikatorperilaku_id"]['keterangan'] = $dt->keterangan;
      $data["$dt->jenispenilaian_id"]["kompetensi"]["$dt->kompetensi_id"]["indikator"]["$dt->indikatorperilaku_id"]['namanilai'] = $dt->kolomrating->kolomrating_namalevel;
    }
    $judulLaporan = 'Penilaian Pegawai';
    $caraPrint = (isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null);
    $modelUrl = array(
      'format' => $format,
      'judulLaporan' => $judulLaporan,
      //				'deskripsi'=>$deskripsi,
      'modPenilaianPegawai' => $modPenilaianPegawai,
      'modPenilaianPegawaiDet' => $modPenilaianPegawaiDet,
      'generateTable' => $data,
      'ketNilai' => $ketNilai,
      'caraPrint' => $caraPrint
    );
    //		$deskripsi = 'Tanggal '.MyFormatter::formatDateTimeId($model->tglrencana);

    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render($this->path_view . 'printPemimpin', $modelUrl);
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render($this->path_view . 'printPemimpin', $modelUrl);
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas'); //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas'); //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      //$mpdf->useOddEven = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML($this->renderPartial($this->path_view . 'printPemimpin', $modelUrl, true));
      $mpdf->Output();
    }
  }
}
