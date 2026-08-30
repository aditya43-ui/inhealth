<?php
Yii::import('rawatDarurat.contollers.DaftarPasienController');
Yii::import('rawatDarurat.models.RDPendaftaranT');
Yii::import('rawatDarurat.views.daftarPasien.*');

class DaftarPasienController extends MyAuthController
{

  public $path_view = 'persalinan.views.daftarPasien.';
  
  public $validRujukan = true;
  public $validPulang = false;

  public function actionIndex()
  {
    $format = new MyFormatter();
    $this->pageTitle = Yii::app()->name . " - Daftar Pasien";
    $model = new PSInfokunjunganpersalinanV;
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    $model->tgl_awall = date('Y-m-d');
    $model->tgl_akhirl = date('Y-m-d');
    $model->ceklis = false;

    if (isset($_REQUEST['PSInfokunjunganpersalinanV'])) {
      $model->attributes = $_REQUEST['PSInfokunjunganpersalinanV'];
      $model->ceklis = $_REQUEST['PSInfokunjunganpersalinanV']['ceklis'];
      //  $model->kamarruangan_id = $_REQUEST['PSInfokunjunganpersalinanV']['kamarruangan_id'];
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['PSInfokunjunganpersalinanV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['PSInfokunjunganpersalinanV']['tgl_akhir']);
      $model->tgl_awall = $format->formatDateTimeForDb($_REQUEST['PSInfokunjunganpersalinanV']['tgl_awall']);
      $model->tgl_akhirl = $format->formatDateTimeForDb($_REQUEST['PSInfokunjunganpersalinanV']['tgl_akhirl']);
      // $model->ceklis = $_REQUEST['PSInfokunjunganpersalinanV']['ceklis'];
    }
    $this->render('index', array('model' => $model, 'format' => $format));
  }

  protected function updatePendaftaran($modPendaftaran, $modelPulang)
  {
    $daftar = PendaftaranT::model()->updateByPk($modelPulang->pendaftaran_id, array('tglselesaiperiksa' => date('Y-m-d H:i:s'), 'pasienpulang_id' => $modelPulang->pasienpulang_id, 'statusperiksa' => 'SUDAH PULANG'));
    if ($daftar) {
      return $modPendaftaran;
    } else {
      throw new Exception('Data Pasien Pulang Gagal Diupdate');
    }
  }

  protected function updatePasienAdmisi($modPasienAdmisi, $modelPulang)
  {

    $modPasienAdmisi->pasienpulang_id = $modelPulang->pasienpulang_id;
    $modPasienAdmisi->tglpulang = $modelPulang->tglpasienpulang;
    //        $modPasienAdmisi->statuskeluar = 1;
    $modPasienAdmisi->save();
    return $modPasienAdmisi;
  }

  protected function updateMasukKamar($modMasukKamar, $attrMasukKamar)
  {
    $modMasukKamar->attributes = $attrMasukKamar;
    $modMasukKamar->save();
  }

  protected function hitungLamaDirawat($date)
  {
    echo $date;
    $today = date("Y-m-d");
    list($y, $m, $d) = explode('-', $date);
    list($ty, $tm, $td) = explode('-', $today);
    if ($td - $d < 0) {
      $day = ($td + 30) - $d;
      $tm--;
    } else {
      $day = $td - $d;
    }
    return $day;
  }

  public function actionAddPasienPulang()
  {
    $validRujukan = true;
    $validPasienPulang = false;

    $pendaftaran_id = Yii::app()->session['pendaftaran_id'];
    $pasien_id = Yii::app()->session['pasien_id'];
    $modelPulang = new PSPasienPulangT;
    $modRujukanKeluar = new PasiendirujukkeluarT;

    $modMasukKamar = '';

    $modelPulang->tglpasienpulang = date('Y-m-d H:i:s');
    $modelPulang->pendaftaran_id = $pendaftaran_id;
    $modelPulang->pasien_id = $pasien_id;

    if (Yii::app()->user->getState('instalasi_id') == Params::INSTALASI_ID_RD) {
      $modRD = InfokunjunganrdV::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id, 'pasien_id' => $pasien_id));
    } else {
      $modRD = PasienrawatinapV::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id, 'pasien_id' => $pasien_id));
    }
    $modRujukanKeluar->pegawai_id = PendaftaranT::model()->findByPk($pendaftaran_id)->pegawai_id;
    $modRujukanKeluar->ruanganasal_id = Yii::app()->user->getState('ruangan_id'); //ruangan asal itu diasumsikan ruangan terakhir dia dari mana

    $format = new MyFormatter();
    $date1 = $format->formatDateTimeForDb($modRD->tgl_pendaftaran);
    $date2 = date('Y-m-d H:i:s');
    $diff = abs(strtotime($date2) - strtotime($date1));
    $hours   = floor(($diff) / 3600);

    $modelPulang->lamarawat = $hours;

    if (Yii::app()->user->getState('instalasi_id') == Params::INSTALASI_ID_RI) //kondisi apabila dari rawat inap, maka akan update ke masukkamar_t
    {
      $idMasukKamar = Yii::app()->session['idMasukKamar'];
      $modMasukKamar = MasukkamarT::model()->findByPk($idMasukKamar);
      $pasienadmisi_id = $modMasukKamar->pasienadmisi_id;
      $modMasukKamar->tglkeluarkamar = date('Y-m-d H:i:s');
      $modMasukKamar->jamkeluarkamar = date('H:i:s');
      $sql = "select date(tglmasukkamar) as tglmasukkamar from masukkamar_t where masukkamar_id = $idMasukKamar";

      //menghitung lama rawat
      $tglMasukKamar = Yii::app()->db->createCommand($sql)->queryRow();
      $date1 = $tglMasukKamar['tglmasukkamar'];
      $modMasukKamar->lamadirawat_kamar = $this->hitungLamaDirawat($date1);

      $modRujukanKeluar->ruanganasal_id = Yii::app()->user->getState('ruangan_id');

      $modelPulang->lamarawat = $modMasukKamar->lamadirawat_kamar;
    }


    if (isset($_POST['PSPasienPulangT'])) {
      $transaction = Yii::app()->db->beginTransaction();
      try {
        if (Yii::app()->user->getState('instalasi_id') == Params::INSTALASI_ID_RI) //kondisi apabila dari rawat inap, maka akan update ke masukkamar_t
        {
          $modelPulang = $this->savePasienPulang($modelPulang, $_POST['PSPasienPulangT'], $pasienadmisi_id);
        } else {
          $modelPulang = $this->savePasienPulang($modelPulang, $_POST['PSPasienPulangT']);
        }

        if (isset($_POST['pakeRujukan'])) {
          $modelPulang->pakeRujukan = true;
          $modRujukanKeluar = $this->saveRujukanKeluar($modRujukanKeluar, $modelPulang, $_POST['PasiendirujukkeluarT']);
        }

        if (isset($_POST['isDead'])) {
          $modPasien = PasienM::model()->findByPk(Yii::app()->session['pasien_id']);
          $modPasien->tgl_meninggal = $_POST['PSPasienPulangT']['tgl_meninggal'];
          $modPasien->save();
        }
        if ($this->validPulang && $this->validRujukan) {
          $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
          $this->updatePendaftaran($modPendaftaran, $modelPulang);

          if (Yii::app()->user->getState('instalasi_id') == Params::INSTALASI_ID_RI) //kondisi apabila dari rawat inap, maka akan update ke masukkamar_t
          {
            $idMasukKamar = Yii::app()->session['idMasukKamar'];

            $modMasukKamar = MasukkamarT::model()->findByPk($idMasukKamar);

            $this->updateMasukKamar($modMasukKamar, $_POST['MasukkamarT']);

            $modPasienAdmisi = PasienadmisiT::model()->findByPk($pasienadmisi_id);

            $this->updatePasienAdmisi($modPasienAdmisi, $modelPulang);
          }

          $transaction->commit();

          if (Yii::app()->request->isAjaxRequest) {
            echo CJSON::encode(array(
              'status' => 'proses_form',
              'div' => "<div class='flash-success'>Data Pasien <b></b> berhasil disimpan </div>",
            ));
            exit;
          }
        }
      } catch (Exception $exc) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
      }
    }

    if (Yii::app()->request->isAjaxRequest) {
      echo CJSON::encode(array(
        'status' => 'create_form',
        'div' => $this->renderPartial(
          '_formPasienPulang',
          array(
            'modelPulang' => $modelPulang,
            'modRujukanKeluar' => $modRujukanKeluar,
            'modMasukKamar' => $modMasukKamar,
            'modRD' => $modRD
          ),
          true
        )
      ));
      exit;
    }
  }

  protected function savePasienPulang($modPasienPulang, $attrPasienPulang, $pasienadmisi_id = '')
  {
    $modelPulangNew = new PSPasienPulangT;
    $modelPulangNew->attributes = $attrPasienPulang;
    $modelPulangNew->satuanlamarawat = (Yii::app()->user->getState('instalasi_id') == Params::INSTALASI_ID_RD) ? Params::SATUAN_LAMARAWAT_RD : Params::SATUAN_LAMARAWAT_RI;
    $modelPulangNew->ruanganakhir_id = Yii::app()->user->getState('ruangan_id');
    $modelPulangNew->create_time = date('Y-m-d H:i:s');
    $modelPulangNew->create_ruangan = Yii::app()->user->getState('ruangan_id');
    $modelPulangNew->create_loginpemakai_id = Yii::app()->user->id;
    $modelPulangNew->pasienadmisi_id = (Yii::app()->user->getState('instalasi_id') == Params::INSTALASI_ID_RD) ? null : $pasienadmisi_id;

    if ($modelPulangNew->save()) {
      $this->validPulang = true;
    }

    return $modelPulangNew;
  }



  public function actionCreate($pendaftaran_id = null, $pasienadmisi_id = null, $ppds_id = null, $urutan_ppds = null)
  {

    $modPendaftaran = PSPendaftaranT::model()->findByPk($pendaftaran_id);
    $modPasien = PSPasienM::model()->findByPk($modPendaftaran->pasien_id);
    $modRuangan = RuanganM::model()->findByPk($modPendaftaran->ruangan_id);
    $model2 = new PpdsM();
    $modPpds = new PpdsM();
    $modDetail = new PasienPpdsT;    
    $model = new PasienPpdsT;
    
    if (isset($_POST['PasienPpdsT'])) {  
     $transaction = Yii::app()->db->beginTransaction();
     $ok = true;

      $i = 1;
        foreach ($_POST['PasienPpdsT'] as $idx=>$item) {
          $modDetail = new PasienPpdsT;
          $modDetail->ppds_id = $item['ppds_id'];
          $modDetail->urutan_ppds = $i;
          $modDetail->pendaftaran_id = $pendaftaran_id;
          $modDetail->pasienadmisi_id = $pasienadmisi_id;

          $ok = $ok && $modDetail->save();
          $i++;
        }

        if ($ok && !empty(Yii::app()->user->getState('pegawai_id'))) {
          $transaction->commit();
         Yii::app()->user->setFlash('success', '<strong>Sukses!</strong> Data berhasil disimpan!');
        } else {
          $transaction->rollback();
         Yii::app()->user->setFlash('error', '<strong>Perhatian!</strong> Nama PPDS Tidak Sesuai login Anda!');
          
        }
      }

    $this->render($this->path_view . 'create', array(
      'model' => $model,
      'model2' => $model2,
      'modPpds'=>$modPpds,
      'modPendaftaran' => $modPendaftaran,
      'modPasien' => $modPasien,
      'modRuangan'=> $modRuangan,
      'modDetail' => $modDetail
    ));
  }

  public function actionAutoPPDS()
	{
            if(Yii::app()->request->isAjaxRequest) {
                $criteria = new CDbCriteria();
                $criteria->compare('LOWER(ppds_nama)', strtolower($_GET['term']), true);
                $criteria->order = 'ppds_nama';
                $criteria->limit = 10;
                $models = PpdsM::model()->findAll($criteria);
                foreach($models as $i=>$model)
                {
                    $attributes = $model->attributeNames();
                    foreach($attributes as $j=>$attribute) {
                        $returnVal[$i]["$attribute"] = $model->$attribute;
                    }
                    $returnVal[$i]['label'] = $model->ppds_nama;
                    $returnVal[$i]['value'] = $model->ppds_id;
                }

                echo CJSON::encode($returnVal);
            }
            Yii::app()->end();
	}

  public function actionPPDSRJ($pendaftaran_id = null)
  {
    $this->layout = '//layouts/iframe';
    $format = new MyFormatter();
    //$pendaftaran_id = $_GET['pendaftaran_id'];

    $modPendaftaran = RJPendaftaranT::model()->findByPk($pendaftaran_id);
    $modPasien = RJPasienM::model()->findByPk($modPendaftaran->pasien_id);
    $modRuangan = RuanganM::model()->findByPk($modPendaftaran->ruangan_id);
    $model2 = new PpdsM();
    $modPpds = new PpdsM();
    $modDetail = new PasienPpdsT;
    
    $model2->ppds_nama;
    
    $this->render('_formPPDSRJ', array(
      'modPendaftaran' => $modPendaftaran,
      'modPasien' => $modPasien,
      'modRuangan'=> $modRuangan,
      'model2' => $model2,
      'modPpds'=>$modPpds,
      'modDetail' => $modDetail
   //   'datatable' => $datatable
    ));
  }




  protected function saveRujukanKeluar($modRujukanKeluar, $modelPulang, $attrRujukanKeluar)
  {
    $modRujukanKeluarNew = new PasiendirujukkeluarT;
    $modRujukanKeluarNew->attributes = $attrRujukanKeluar;
    $modRujukanKeluarNew->pendaftaran_id = $modelPulang->pendaftaran_id;
    $modRujukanKeluarNew->pasien_id = $modelPulang->pasien_id;
    $modRujukanKeluarNew->create_time = date('Y-m-d H:i:s');
    //        $modRujukanKeluarNew->create_ruangan = Yii::app()->user->getState('ruangan_id');
    $modRujukanKeluarNew->create_loginpemakai_id = Yii::app()->user->id;
    if ($modRujukanKeluarNew->save()) {
      'benar';
    } else {
      $this->validRujukan = false;
    }
    return $modRujukanKeluarNew;
  }

  public function actionRincian($id)
  {
    $this->layout = '//layouts/iframe';
    $data['judulLaporan'] = 'Rincian Tagihan Pasien';
    $modPendaftaran = PSPendaftaranT::model()->findByPk($id);
    $modRincian = PSRinciantagihanpasienV::model()->findAllByAttributes(array('pendaftaran_id' => $id), array('order' => 'ruangan_id'));
    $data['nama_pegawai'] = LoginpemakaiK::model()->findByPK(Yii::app()->user->id)->pegawai->nama_pegawai;
    //            $modRincian->pendaftaran_id = $id;
    $this->render('/rinciantagihanpasienV/rincian', array('modPendaftaran' => $modPendaftaran, 'modRincian' => $modRincian, 'data' => $data));
  }

  public function actionAjaxJumlahPersalinan()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $pendaftaran_id = $_POST['pendaftaran_id'];
    }
  }

  public function actionGetRiwayatPasien($id)
  {
    $this->layout = '//layouts/iframe';
    $criteria = new CDbCriteria(array(
      //'condition' => 't.pasien_id = '.$id.' and t.ruangan_id ='.Yii::app()->user->getState('ruangan_id'),
      'condition' => 't.pasien_id = ' . $id,
      'order' => 'tgl_pendaftaran DESC',
    ));

    $pages = new CPagination(PSPendaftaranT::model()->count($criteria));
    $pages->pageSize = Params::JUMLAH_PERHALAMAN; //Yii::app()->params['postsPerPage'];
    $pages->applyLimit($criteria);

    $modKunjungan = PSPendaftaranT::model()->with('hasilpemeriksaanlab', 'anamnesa', 'pemeriksaanfisik', 'pasienmasukpenunjang', 'diagnosa')->findAll($criteria);


    $this->render('/_periksaDataPasien/_riwayatPasien', array(
      'pages' => $pages,
      'modKunjungan' => $modKunjungan,
    ));
  }



  public function actionDetailTindakan($id)
  {
    $this->layout = '//layouts/iframe';
    $modPendaftaran = PSPendaftaranT::model()->with('carabayar', 'penjamin')->findByPk($id);
    $modTindakan = PSTindakanPelayananT::model()->with('daftartindakan')->findAllByAttributes(array('pendaftaran_id' => $id));
    $format = new MyFormatter;
    $modTindakanSearch = new PSTindakanPelayananT('search');
    $modPasien = PSPasienM::model()->findByPK($modPendaftaran->pasien_id);
    $this->render(
      '/_periksaDataPasien/_tindakan',
      array(
        'modPendaftaran' => $modPendaftaran,
        'modTindakan' => $modTindakan,
        'modTindakanSearch' => $modTindakanSearch,
        'modPasien' => $modPasien
      )
    );
  }

  public function actionDetailTerapi($id)
  {
    $this->layout = '//layouts/iframe';
    $modPendaftaran = PSPendaftaranT::model()->with('carabayar', 'penjamin')->findByPk($id);
    $modTerapi = PSPenjualanresepT::model()->with('reseptur')->findAllByAttributes(array('pendaftaran_id' => $id));
    $format = new MyFormatter;
    $modDetailTerapi = new PSPenjualanresepT();
    $modPasien = PSPasienM::model()->findByPK($modPendaftaran->pasien_id);
    $this->render(
      '/_periksaDataPasien/_terapi',
      array(
        'modPendaftaran' => $modPendaftaran,
        'modTerapi' => $modTerapi,
        'modDetailTerapi' => $modDetailTerapi,
        'modPasien' => $modPasien
      )
    );
  }

  public function actionDetailPemakaianBahan($id)
  {
    $this->layout = '//layouts/iframe';
    $modPendaftaran = PSPendaftaranT::model()->with('carabayar', 'penjamin')->findByPk($id);
    $modBahan = PSObatalkesPasienT::model()->with('obatalkes')->findAllByAttributes(array('pendaftaran_id' => $id));
    $format = new MyFormatter;
    $modPemakaianBahan = new PSObatalkesPasienT;
    $modPasien = PSPasienM::model()->findByPK($modPendaftaran->pasien_id);
    $this->render(
      '/_periksaDataPasien/_pemakaianBahan',
      array(
        'modPendaftaran' => $modPendaftaran,
        'modBahan' => $modBahan,
        'modPemakaianBahan' => $modPemakaianBahan,
        'modPasien' => $modPasien
      )
    );
  }
  /**
   * Pasien RI rujuk / pulang
   */
  public function actionPasienRujukRI()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $pendaftaran_id = $_POST['pendaftaran_id'];
      $pasien_id =  PendaftaranT::model()->find('pendaftaran_id=' . $pendaftaran_id . '')->pasien_id;
      $modPasienPulang = new PSPasienPulangT;
      $modPasienPulang->pendaftaran_id = $pendaftaran_id;
      $modPasienPulang->pasien_id = $pasien_id;
      $modPasienPulang->tglpasienpulang = date('Y-m-d H:i:s');
      $modPasienPulang->carakeluar_id = Params::CARAKELUAR_ID_RAWATINAP;
      $modPasienPulang->kondisikeluar_id = Params::KONDISIKELUAR_ID_RAWATINAP;
      $modPasienPulang->ruanganakhir_id = Yii::app()->user->getState('ruangan_id');
      $modPasienPulang->lamarawat = 0;
      $modPasienPulang->satuanlamarawat = 'lamarawat';
      //                echo $modPasienPulang->ruanganakhir_id;exit;
      if ($modPasienPulang->save()) {
        PendaftaranT::model()->updateByPk($pendaftaran_id, array('pasienpulang_id' => $modPasienPulang->pasienpulang_id, 'statusperiksa' => 'SEDANG DIRAWAT INAP'));
        $data['pesan'] = 'Berhasil';
      } else {
        $data['pesan'] = 'Gagal';
      }
      echo json_encode($data);
      Yii::app()->end();
    }
  }

  /**
   * Mengatur dropdown kabupaten
   * @param type $encode jika = true maka return array jika false maka set Dropdown 
   * @param type $model_nama
   * @param type $attr
   */
  public function actionSetDropDownKondisiKeluar($encode = false, $model_nama = '', $attr = '')
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      $model = new PSPasienPulangT();
      $option = CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
      if (!empty($_POST['carakeluar_id'])) {
        $data = $model->getKondisikeluarItems($_POST['carakeluar_id']);
        $data = CHtml::listData($data, 'kondisikeluar_id', 'kondisikeluar_nama');
        foreach ($data as $value => $name) {
          $option .= CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
        }
      }
      $dataList['kondisikeluar'] = $option;
      echo json_encode($dataList);
      Yii::app()->end();
    }
  }

  public function actionBuatSessionPendaftaranPasien()
  {
    $pendaftaran_id = $_POST['pendaftaran_id'];
    $pasien_id = $_POST['pasien_id'];

    Yii::app()->session['pendaftaran_id'] =  $pendaftaran_id;
    Yii::app()->session['pasien_id'] = $pasien_id;

    echo CJSON::encode(array(
      'pendaftaran_id' => Yii::app()->session['pendaftaran_id'],
      'pasien_id' => Yii::app()->session['pasien_id']
    ));
  }

  public function actionUbahDokterPeriksa()
  {
    $model = new PSPendaftaranT();
    $modAdmisi = new PSPasienAdmisiT();
    $modUbahDokter = new PSUbahdokterR;
    $menu = (isset($_REQUEST['menu']) ? $_REQUEST['menu'] : "");
    if (isset($_POST['PSPendaftaranT'])) {
      if ($_POST['PSPendaftaranT']['pegawai_id'] != "") {

        $model->attributes = $_POST['PSPendaftaranT'];
        $modUbahDokter->attributes = $_POST['PSUbahdokterR'];
        $modUbahDokter->pendaftaran_id = $_POST['PSPendaftaranT']['pendaftaran_id'];
        $modUbahDokter->dokterbaru_id = $_POST['PSPendaftaranT']['pegawai_id'];
        $modUbahDokter->tglubahdokter = date('Y-m-d H:i:s');
        $modUbahDokter->create_time = date('Y-m-d H:i:s');
        $modUbahDokter->create_loginpemakai_id = Yii::app()->user->id;
        $modUbahDokter->create_ruangan = Yii::app()->user->getState('ruangan_id');
        $transaction = Yii::app()->db->beginTransaction();
        try {
          $attributes = array('pegawai_id' => $_POST['PSPendaftaranT']['pegawai_id']);
          $cekPersalinan = PSPersalinanT::model()->find(" pendaftaran_id = '" . $_POST['PSPendaftaranT']['pendaftaran_id'] . "' ");

          if (!empty($cekPersalinan)) {
            $save = PSPendaftaranT::model()->updateByPk($_POST['PSPendaftaranT']['pendaftaran_id'], $attributes);
            $savePersalinan = PSPersalinanT::model()->updateByPk($cekPersalinan->persalinan_id, $attributes);
          } else {
            $save = PSPendaftaranT::model()->updateByPk($_POST['PSPendaftaranT']['pendaftaran_id'], $attributes);
          }

          if ($save) {
            $modUbahDokter->save();
            $transaction->commit();
            echo CJSON::encode(array(
              'status' => 'proses_form',
              'div' => "<div class='flash-success'>Berhasil merubah Dokter Periksa.</div>",
            ));
          } else {
            echo CJSON::encode(array(
              'status' => 'proses_form',
              'div' => "<div class='flash-error'>Data gagal disimpan.</div>",
            ));
          }
          exit;
        } catch (Exception $exc) {
          $transaction->rollback();
        }
      } else {
        echo CJSON::encode(
          array(
            'status' => 'proses_form',
            'div' => "<div class='flash-error'>Data gagal disimpan, dokter baru belum dipilih.</div>",
          )
        );
        exit;
      }
    }

    if (Yii::app()->request->isAjaxRequest) {
      echo CJSON::encode(array(
        'status' => 'create_form',
        'div' => $this->renderPartial('_formUbahDokterPeriksa', array('model' => $model, 'modAdmisi' => $modAdmisi, 'modUbahDokter' => $modUbahDokter, 'menu' => $menu), true)
      ));
      exit;
    }
  }

  public function actionGetDataPendaftaranPS()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $id_pendaftaran = $_POST['pendaftaran_id'];
      $persalinan_id = PersalinanT::model()->find(" pendaftaran_id = '" . $id_pendaftaran . "' ");
      $pasienadmisi_id = !empty($_POST['pasienadmisi_id']) ? $_POST['pasienadmisi_id'] : null;

      if (!empty($persalinan_id)) {
        $modPasienAdmisi = PendaftaranT::model()->findByPk($id_pendaftaran);
      } else {
        $modPasienAdmisi = PendaftaranT::model()->findByPk($id_pendaftaran);
      }

      /*if (!empty($pasienadmisi_id)){
                        $model = InfopasienmasukkamarV::model()->findByAttributes(array('pendaftaran_id'=>$id_pendaftaran,'pasienadmisi_id'=>$pasienadmisi_id));
                        $modPasienAdmisi = PasienadmisiT::model()->findByPk($pasienadmisi_id);
                   }else{                       
                        $model = InfopasienmasukkamarV::model()->findByAttributes(array('pendaftaran_id'=>$id_pendaftaran));
                        $modPasienAdmisi = PendaftaranT::model()->findByPk($id_pendaftaran);                        
                   }*/
      //  var_dump($modPasienAdmisi->pegawai_id);
      $attributes = $modPasienAdmisi->attributeNames();
      foreach ($attributes as $j => $attribute) {
        $returnVal["$attribute"] = $modPasienAdmisi->$attribute;
        $returnVal["gelarbelakang_nama"] = isset($modPasienAdmisi->pegawai->gelarbelakang->gelarbelakang_nama) ? $modPasienAdmisi->pegawai->gelarbelakang->gelarbelakang_nama : "";
        $returnVal["gelardepan"] = isset($modPasienAdmisi->pegawai->gelardepan) ? $modPasienAdmisi->pegawai->gelardepan : "";
        $returnVal["pegawai_id"] = isset($modPasienAdmisi->pegawai_id) ? $modPasienAdmisi->pegawai_id : null;
        $returnVal["nama_pasien"] = $modPasienAdmisi->pasien->namadepan . ' ' . $modPasienAdmisi->pasien->nama_pasien;
        $returnVal["nama_pegawai"] = $modPasienAdmisi->pegawai->nama_pegawai;
      }
      $returnVal['pesan'] = 0;
      echo json_encode($returnVal);
      Yii::app()->end();
    }
  }

  public function actionListDokterRuangan()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      if (!empty($_POST['idRuangan'])) {
        $idRuangan = $_POST['idRuangan'];
        $data = DokterV::model()->findAllByAttributes(array('ruangan_id' => $idRuangan), array('order' => 'nama_pegawai'));
        $data = CHtml::listData($data, 'pegawai_id', 'namaLengkap');

        if (empty($data)) {
          $option = CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
        } else {
          $option = CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
          foreach ($data as $value => $name) {
            $option .= CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
          }
        }

        $dataList['listDokter'] = $option;
      } else {
        $dataList['listDokter'] = $option = CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
      }
      $dataList['pesan'] = 0;
      echo json_encode($dataList);
      Yii::app()->end();
    }
  }

  /**
   * Membatalkan Pasien Periksa untuk Modul Persalinan.
   * NOTE : Di Copypaste dari rawatDarurat/daftarPasien
   */
  public function actionBatalPeriksa()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $pendaftaran_id = isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null;
        $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
        $keterangan_batal = isset($_POST['keterangan_batal']) ? $_POST['keterangan_batal'] : null;

        $tindakan = TindakanpelayananT::model()->findByAttributes(array(
          'pendaftaran_id' => $pendaftaran_id,
        ), array(
          'condition' => 'tindakansudahbayar_id is not null'
        ));
        $oa = ObatalkespasienT::model()->findByAttributes(array(
          'pendaftaran_id' => $pendaftaran_id,
        ), array(
          'condition' => 'oasudahbayar_id is not null'
        ));

        $ada = false;

        if (!empty($tindakan) || !empty($oa)) {
          $ada = true;
          $pesan = "Pasien sudah melakukan pembayaran. "
            . "Mohon pembayaran sebelumnya dibatalkan terlebih dahulu sebelum melakukan pembatalan pemeriksaan.";
          $status = false;
          goto onco; // loncat ke label 'onco'
        }

        /*
                 * cek data pendaftaran pasien masuk penunjang
                 */
        $criteria = new CDbCriteria();
        if (!empty($pendaftaran_id)) {
          $criteria->addCondition("pendaftaran_id = " . $pendaftaran_id);
        }

        $pasienMasukPenunjang = PasienmasukpenunjangT::model()->find($criteria);

        $pesan = '';
        $status = false;
        $model = new PasienbatalperiksaR();
        $model->pendaftaran_id = $pendaftaran_id;
        $model->pasien_id = $modPendaftaran->pasien_id;
        $model->tglbatal = date('Y-m-d');
        $model->keterangan_batal = $keterangan_batal;
        $model->create_ruangan = Yii::app()->user->getState('ruangan_id');

        if ($model->save()) {
          $status = true;
          $pesan = "Pemeriksaan pasien berhasil dibatalkan!";
        } else {
          $status = false;
          $pesan = "Pemeriksaan gagal dibatalkan! " . CHtml::errorSummary($model);
        }

        $attributes = array(
          'pasienbatalperiksa_id' => $model->pasienbatalperiksa_id,
          'update_time' => date('Y-m-d H:i:s'),
          'update_loginpemakai_id' => Yii::app()->user->id,
          'statusperiksa' => Params::STATUSPERIKSA_BATAL_PERIKSA
        );
        $pendaftaran = PendaftaranT::model()->updateByPk($pendaftaran_id, $attributes);



        onco:

        /*
                 * kondisi_commit
                 */
        if ($status == true && $ada == false) {
          $transaction->commit();
          $this->hapusSepBatal($modPendaftaran);
        } else {
          $transaction->rollback();
        }
      } catch (Exception $ex) {
        //var_dump($ex); die;
        //					print_r($ex);
        $status = false;
        $pesan = "exist";
        $transaction->rollback();
      }

      $data = array(
        'pesan' => $pesan,
        'status' => $status
      );
      echo json_encode($data);
      Yii::app()->end();
    }
  }

  public function hapusSepBatal($modPendaftaran) {
    $sep = SepT::model()->findByPk($modPendaftaran->sep_id);
    if (empty($sep)) {
        return false;
    }

    $no_sep = $sep->nosep;
    if (empty($no_sep)) {
        return false;
    }

    $bpjs = new Bpjs_Vklaim;
    $bpjs->delete_transaksi_sep($no_sep, Yii::app()->user->getState('nama_pemakai'));

    PendaftaranT::model()->updateAll(array('sep_id' => null), 'sep_id = ' . $sep->sep_id);
    PasiendirujukkeluarT::model()->deleteAllByAttributes(array('sep_id' => $sep->sep_id));

    $sep->delete();
  }

  public function actionTerimaDokumen()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $pendaftaran = $_POST['pendaftaran_id'];
      $pengirimanrm_id = $_POST['pengirimanrm_id'];

      $model = PendaftaranT::model()->findByPk($pendaftaran);
      if (!empty($pengirimanrm_id)) {
        $modPenerimaanRm = PengirimanrmT::model()->findByPk($pengirimanrm_id);
        $modPenerimaanRm->tglterimadokrm = date('Y-m-d H:i:s');
        $modPenerimaanRm->petugaspenerima_id = Yii::app()->user->id;
        $modPenerimaanRm->ruanganpenerima_id = Yii::app()->user->getState('ruangan_id');

        // print_r($modPenerimaanRm->attributes); die;

        if ($modPenerimaanRm->save()) {
          $model->statusdokrm = 'SUDAH DITERIMA';
          $model->save();

          $judul = 'Penerimaan Berkas Rekam Medis';

          $isi = $modPenerimaanRm->pasien->no_rekam_medik . ' - ' . $modPenerimaanRm->pasien->nama_pasien;


          CustomFunction::broadcastNotif($judul, $isi, array(
            array('instalasi_id' => $modPenerimaanRm->ruanganpengirim->instalasi->instalasi_id, 'ruangan_id' => $modPenerimaanRm->ruanganpengirim->ruangan_id, 'modul_id' => !empty($modPenerimaanRm->ruanganpengirim->modul_id) ? $modPenerimaanRm->ruanganpengirim->modul_id : null),
          ));

          $update = true;
        } else {
          $update = false;
        }
      }

      if ($update == true) {
        $status = 'proses_form';
        $div = "<div class='flash-success'>Data Dokumen Pasien <b></b> berhasil diterima </div>";
      } else {
        $status = 'proses_form';
        $div = "<div class='flash-error'>Data Dokumen Pasien <b></b> gagal diterima </div>";
      }

      echo CJSON::encode(array(
        'status' => $status,
        'div' => $div,
      ));
      exit;
    }
  }

  public function actionStatusDokumenKirim($pengirimanrm_id, $pendaftaran_id)
  {
    $this->layout = '//layouts/iframe';
    $format = new MyFormatter();
    $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
    $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
    $modAdmisi = null;
    $status = false;
    if (!empty($pengirimanrm_id)) {
      $modPengirimanRm = PengirimanrmT::model()->findByPk($pengirimanrm_id);
    } else {
      $modPengirimanRm = new PengirimanrmT();
    }



    $pegawai_id = LoginpemakaiK::model()->findByPk(Yii::app()->user->id)->pegawai_id;
    $modUbahStatus = new PengirimanrmT;
    $modUbahStatus->tglpengirimanrm = date('d/m/Y H:i:s');
    $modUbahStatus->petugaspengirim = Yii::app()->user->name;
    $modUbahStatus->petugaspengirim_id = $pegawai_id;


    if (!empty($modPendaftaran->pasienadmisi_id)) {
      $modAdmisi = PasienadmisiT::model()->findByPk($modPendaftaran->pasienadmisi_id);
      $modUbahStatus->instalasi_id = Params::INSTALASI_ID_RI;
      $modUbahStatus->ruangan_id = $modAdmisi->ruangan_id;

      // var_dump($modUbahStatus->attributes); die;
    }

    if (isset($_POST['PengirimanrmT'])) {
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $modUbahStatus->attributes = $_POST['PengirimanrmT'];
        //var_dump($_POST);die;
        $modUbahStatus->pendaftaran_id = $modPendaftaran->pendaftaran_id;
        $modUbahStatus->pasien_id = $modPendaftaran->pasien_id;
        $modUbahStatus->dokrekammedis_id = isset($modPengirimanRm) ? $modPengirimanRm->dokrekammedis_id : null;
        $modUbahStatus->nourut_keluar = MyGenerator::noUrutKeluarRM();
        $modUbahStatus->tglpengirimanrm = $format->formatDateTimeForDb($_POST['PengirimanrmT']['tglpengirimanrm']);
        $modUbahStatus->kelengkapandokumen = TRUE;
        $modUbahStatus->petugaspengirim_id = $_POST['PengirimanrmT']['petugaspengirim_id'];
        $modUbahStatus->create_time = date('Y-m-d H:i:s');
        $modUbahStatus->create_loginpemakai_id = Yii::app()->user->id;
        $modUbahStatus->create_ruangan = Yii::app()->user->getState('ruangan_id');
        $modUbahStatus->ruanganpengirim_id = Yii::app()->user->getState('ruangan_id');
        $modUbahStatus->ruanganpenerima_id = $_POST['PengirimanrmT']['ruangan_id'];

        if ($modUbahStatus->save()) {
          $modPendaftaran->statusdokrm = 'SUDAH DIKIRIM';
          $modPendaftaran->pengirimanrm_id = $modUbahStatus->pengirimanrm_id;
          $modPendaftaran->save();

          $judul = 'Pengiriman Berkas Rekam Medis';

          $isi = $modUbahStatus->pendaftaran->no_pendaftaran . ' - ' . $modUbahStatus->pasien->no_rekam_medik . ' - ' . $modUbahStatus->pasien->nama_pasien;

          CustomFunction::broadcastNotif($judul, $isi, array(
            array('instalasi_id' => $modUbahStatus->ruangantujuan->instalasi->instalasi_id, 'ruangan_id' => $modUbahStatus->ruangantujuan->ruangan_id, 'modul_id' => !empty($modUbahStatus->ruangantujuan->modul_id) ? $modUbahStatus->ruangantujuan->modul_id : null),
          ));

          $transaction->commit();
          $status = true;
          Yii::app()->user->setFlash('success', "Data pengiriman dokumen pasien berhasil disimpan !");
        } else {
          $status = false;
          Yii::app()->user->setFlash('error', '<strong>Gagal</strong> Data pengiriman dokumen pasien gagal disimpan');
        }
      } catch (Exception $exc) {
        $transaction->rollback();
        $status = false;
        Yii::app()->user->setFlash('error', '<strong>Gagal</strong> Data Gagal disimpan' . MyExceptionMessage::getMessage($exc));
      }
    }

    $this->render('_formStatusDokumen', array(
      'modPendaftaran' => $modPendaftaran,
      'modPasien' => $modPasien,
      'modPengirimanRm' => $modPengirimanRm,
      'modUbahStatus' => $modUbahStatus,
      'modAdmisi' => $modAdmisi,
      'status' => $status
    ));
  }

  /*
	 * Ubah Status Periksa Pasien Baru -- Yang Pake Button
	 */
  public function actionUbahStatusPeriksaPasien()
  {
    $pendaftaran_id = isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null;
    $status = isset($_POST['status']) ? $_POST['status'] : null;
    $model = PendaftaranT::model()->findByPk($pendaftaran_id);
    $modBatalPeriksa = new PasienbatalperiksaR;
    $model->tglselesaiperiksa = date('Y-m-d H:i:s');
    if (isset($_POST['status'])) {
      $update = true;
      if ($status == "ANTRIAN") {
        $p = PendaftaranT::model()->findByPk($pendaftaran_id);
        $update = $p->setStatusPeriksa(Params::STATUSPERIKSA_SEDANG_PERIKSA);
        // if (empty($model->pasienadmisi_id)) $update = PendaftaranT::model()->updateByPk($pendaftaran_id,array('statusperiksa'=>Params::STATUSPERIKSA_SEDANG_PERIKSA));
        $this->updateStatusKonsul($pendaftaran_id, Params::STATUSPERIKSA_SEDANG_PERIKSA);
      } else {
        if ($status == "SEDANG PERIKSA") {
          $update = true;
          $p = PendaftaranT::model()->findByPk($pendaftaran_id);
          if ($p->statusperiksa != Params::STATUSPERIKSA_SUDAH_DIPERIKSA) {
            $update = $p->setStatusPeriksa(Params::STATUSPERIKSA_SUDAH_DIPERIKSA);
            PendaftaranT::model()->broadcastNotifSudahPeriksa($pendaftaran_id);
          }


          if (empty($p->pasienadmisi_id)) $update = PendaftaranT::model()->updateByPk($pendaftaran_id, array('tglselesaiperiksa' => date('Y-m-d H:i:s')));
          $this->updateStatusKonsul($pendaftaran_id, Params::STATUSPERIKSA_SUDAH_DIPERIKSA);
        }
      }
      if ($update) {
        if (Yii::app()->request->isAjaxRequest) {
          echo CJSON::encode(array(
            'status' => 'proses_form',
            'div' => "<div class='flash-success'>Data Pasien <b></b> berhasil disimpan </div>",
          ));
          exit;
        }
      } else {
        if (Yii::app()->request->isAjaxRequest) {
          echo CJSON::encode(array(
            'status' => 'proses_form',
            'div' => "<div class='flash-error'>Data Pasien <b></b> gagal disimpan </div>",
          ));
          exit;
        }
      }
    }
  }
  /*
     * end Ubah Status Periksa Pasien Baru -- Yang Pake Button
     */

  function updateStatusKonsul($pendaftaran_id, $status)
  {
    $p = PendaftaranT::model()->findByPk($pendaftaran_id);
    $konsul = KonsulpoliT::model()->findAllByAttributes(array(
      'ruangan_id' => Yii::app()->user->getState('ruangan_id'),
      'pendaftaran_id' => $pendaftaran_id,
    ));
    foreach ($konsul as $item) {
      KonsulpoliT::model()->updateByPk($item->konsulpoli_id, array(
        'statusperiksa' => $status,
      ));
    }
  }


  /**
   * @author      M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
   * @version     2.0.0
   * @digunakan   - untuk melihat detail data persalinan
   * RSST-1672
   */
  public function actionDetailPersalinan($persalinan_id)
  {
    $this->layout = '//layouts/iframe';
    $modPersalinan = PersalinanT::model()->findByPk($persalinan_id);
    $modPendaftaran = PSPendaftaranT::model()->with('carabayar', 'penjamin')->findByPk($modPersalinan->pendaftaran_id);

    $modPemeriksaan = PemeriksaanfisikT::model()->findAllByAttributes(array('pendaftaran_id' => $modPersalinan->pendaftaran_id, 'create_ruangan' => Params::RUANGAN_ID_VK), array(
      'order' => 'pemeriksaanfisik_id asc',
    ));

    $systolic = null;
    $diastolic = null;
    foreach ($modPemeriksaan as $cari) {
      $systolic = isset($cari->kala4_systolic) ? $cari->kala4_systolic : null;
      $diastolic = isset($cari->kala4_diastolic) ? $cari->kala4_diastolic : null;
    }

    $criteria2 = new CDbCriteria();
    $criteria2->select = 'max(systolic_min) as sys_max';
    $modSys = SysdiaM::model()->find($criteria2);
    $criteria3 = new CDbCriteria();
    $criteria3->select = 'max(diastolic_min) as dias_max';
    $modDia = SysdiaM::model()->find($criteria3);

    $criteria = new CDbCriteria();
    $tekanandarah_text = '';
    if (($systolic == null) && ($diastolic == null)) {
      $tekanandarah_text = null;
    } else {
      if ($systolic > $modSys->sys_max) {
        $criteria->condition = 'systolic_min <= ' . $systolic . ' and systolic_max = 0';
      } else {
        $criteria->addCondition($systolic . ' >= systolic_min');
        $criteria->addCondition($systolic . ' <= systolic_max');
      }

      if ($diastolic > $modDia->dias_max) {
        $criteria->condition = 'diastolic_min <= ' . $diastolic . ' and diastolic_max = 0';
      } else {
        $criteria->addCondition($diastolic . ' >= diastolic_min');
        $criteria->addCondition($diastolic . ' <= diastolic_max');
      }

      $modSysDia = SysdiaM::model()->find($criteria);

      if (!empty($modSysDia)) {
        $tekanandarah_text = $modSysDia->sysdia_nama;
      }
    }



    $format = new MyFormatter;
    $modPersalinanSearch = new PersalinanT('search');
    $modPasien = PSPasienM::model()->findByPK($modPendaftaran->pasien_id);
    $this->render(
      'rawatJalan.views._periksaDataPasien/_persalinan',
      array(
        'modPendaftaran' => $modPendaftaran,
        'modPersalinan' => $modPersalinan,
        'modPemeriksaan' => $modPemeriksaan,
        'tekananDarahText' => $tekanandarah_text,
        'modPersalinanSearch' => $modPersalinanSearch,
        'modPasien' => $modPasien
      )
    );
  }

  public function actionDetailKelahiranBayiMain($persalinan_id)
  {
    $this->layout = '//layouts/iframe';
    $modKelahiran = KelahiranbayiT::model()->findAllByAttributes(array(
      'persalinan_id' => $persalinan_id,
    ), array(
      'order' => 'nourutbayi asc'
    ));

    $this->render(
      'persalinan.views._periksaDataPasien/_detailKelahiran',
      array(
        'modKelahiran' => $modKelahiran,
      )
    );
  }

  /**
   * @author      M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
   * @version     2.0.0
   * @digunakan   - untuk melihat detail data kelahiran bayi
   * RSST-1672
   */
  public function actionDetailKelahiranBayi($kelahiranbayi_id)
  {
    $this->layout = '//layouts/iframe';
    $modKelahiran = PSKelahiranbayiT::model()->findByPk($kelahiranbayi_id);

    $criAp = new CDbCriteria();
    $criAp->select = " t.*, ma.kriteria, ma.kriteria, ma.nilai_1, ma.nilai_2, ma.nilai_0 ";
    $criAp->join =    "   JOIN metodeapgar_m ma ON ma.metodeapgar_id = t.metodeapgar_id ";
    $criAp->addCondition(" kelahiranbayi_id = '" . $kelahiranbayi_id . "' ");
    $criAp->order = "t.menitke, ma.metodeapgar_id ASC ";
    $modApghar = PSApgarscoreT::model()->findAll($criAp);

    $genAphgar = array();
    $genAphgarp = array();

    foreach ($modApghar as $det) {
      $genAphgarp[$det->menitke]['menitke'] = $det->menitke;
      $genAphgarp[$det->menitke]['det'][$det->apgarscore_id]['apgarscore_id'] = $det->apgarscore_id;
      $genAphgarp[$det->menitke]['det'][$det->apgarscore_id]['metodeapgar_id'] = $det->metodeapgar_id;
      $genAphgarp[$det->menitke]['det'][$det->apgarscore_id]['kriteria'] = $det->kriteria;
      $genAphgarp[$det->menitke]['det'][$det->apgarscore_id]['nilai_0'] = $det->nilai_0;
      $genAphgarp[$det->menitke]['det'][$det->apgarscore_id]['nilai_1'] = $det->nilai_1;
      $genAphgarp[$det->menitke]['det'][$det->apgarscore_id]['nilai_2'] = $det->nilai_2;
      $genAphgarp[$det->menitke]['det'][$det->apgarscore_id]['nilai_apgar'] = $det->nilai_apgar;
    }



    $this->render(
      'persalinan.views._periksaDataPasien/_kelahiranBayi',
      array(
        'modKelahiran' => $modKelahiran,
        'modApghar' => $genAphgarp,
      )
    );
  }
  /**
   * untuk surat kelahiran
   * @param integer $kelahiranbayi_id
   */
  public function actionCetakSuratKelarihan($kelahiranbayi_id)
  {
    $this->layout = '//layouts/iframe';


    $format = new MyFormatter();
    $model = new SuratketeranganR;
    $modPekerjaan = '';
    $modPropinsi = '';
    $modKelurahan = '';
    $modKecamatan = '';
    $modKelahiran = '';
    $modPendaftaranData = '';
    $modPasienData = '';
    $modKabupaten = '';
    $modKelahiran = KelahiranbayiT::model()->findByPk($kelahiranbayi_id);
    $modPersalinan = PersalinanT::model()->findByPk($modKelahiran->persalinan_id);
    if (isset($modPersalinan)) {
      $modPendaftaranData = PendaftaranT::model()->findByPk($modPersalinan->pendaftaran_id);
      $modPasienData = PasienM::model()->findByPk($modPendaftaranData->pasien_id);
      if (isset($modPasienData)) {
        $modPekerjaan = PekerjaanM::model()->findByPk($modPasienData->pekerjaan_id);
        $modKelurahan = KelurahanM::model()->findByPk($modPasienData->kelurahan_id);
        $modPropinsi = PropinsiM::model()->findByPk($modPasienData->propinsi_id);
        $modKecamatan = KecamatanM::model()->findByPk($modPasienData->kecamatan_id);
        $modKabupaten = KabupatenM::model()->findByPk($modPasienData->kabupaten_id);
      }
      if (isset($modKelahiran)) {
        $model->lahir_beratbadan_gram = $modKelahiran->bb_gram;
        $model->lahir_panjangbadan_cm = $modKelahiran->tb_cm;
        $model->lahir_namaibu = $modPasienData->nama_pasien;
        $model->lahir_ibu_umur = $modPendaftaranData->umur;
        $model->lahir_pekerjaan_ibu = isset($modPekerjaan) ? $modPekerjaan->pekerjaan_nama : '';
        $model->lahir_ktp_ibu = $modPasienData->no_identitas_pasien;
        $model->lahir_alamat = $modPasienData->alamat_pasien;
        $model->lahir_propinsi = $modPropinsi->propinsi_id;
        $model->lahir_kabupaten = $modKabupaten->kabupaten_id;
        $model->lahir_kecamatan = $modKecamatan->kecamatan_id;
      }
    }
    $modPasien = new PasienM;
    $modPendaftaran = new PendaftaranT;
    $model->nomorsurat = MyGenerator::noSurat(1);

    if (isset($_POST['SuratketeranganR'])) {
      $pendaftaran_id = $_GET['pendaftaran_id'];
      $modPendaftaran = PendaftaranT::model()->findByPk($modPersalinan->pendaftaran_id);
      $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $model->attributes = $_POST['SuratketeranganR'];
        $model->tglsurat = date('Y-m-d');
        $model->jenissurat_id = 1;
        $model->nourutsurat = 1;
        $model->pendaftaran_id = $pendaftaran_id;
        $model->pasien_id = $modPasien->pasien_id;
        $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
        $model->jmlprint_surat = 1;
        $model->mengetahui_surat = isset($_POST['SuratketeranganR']['mengetahui_surat']) ? $_POST['SuratketeranganR']['mengetahui_surat'] : null;
        $model->profilrs_id = 1;
        $model->judulsurat = "SURAT KETERANGAN LAHIR";
        $model->lahir_panjangbadan_cm = $_POST['SuratketeranganR']['lahir_panjangbadan_cm'];
        $model->lahir_beratbadan_gram = $_POST['SuratketeranganR']['lahir_beratbadan_gram'];
        $model->lahir_namaibu = $_POST['SuratketeranganR']['lahir_namaibu'];
        $model->lahir_namaayah = $_POST['SuratketeranganR']['lahir_namaayah'];
        $model->lahir_pekerjaan_ayah = $_POST['SuratketeranganR']['lahir_pekerjaan_ayah'];
        $model->no_pekerja_badge = isset($_POST['SuratketeranganR']['no_pekerja_badge']) ? $_POST['SuratketeranganR']['no_pekerja_badge'] : null;
        $model->no_ktp_ayah = $_POST['SuratketeranganR']['no_ktp_ayah'];
        $model->lahir_alamat = $_POST['SuratketeranganR']['lahir_alamat'];
        $model->dokter_persalinan_id = $_POST['SuratketeranganR']['dokter_persalinan_id'];
        $model->lahir_tgllahir = $format->formatDateTimeForDb($_POST['lahir_tgllahir']);
        $model->lahir_kabupaten = !empty($model->lahir_kabupaten) ? KabupatenM::model()->findByPk($model->lahir_kabupaten)->kabupaten_nama : null;
        $model->lahir_kecamatan = !empty($model->lahir_kecamatan) ? KecamatanM::model()->findByPk($model->lahir_kecamatan)->kecamatan_nama : null;
        $model->lahir_propinsi = !empty($model->lahir_propinsi) ? PropinsiM::model()->findByPk($model->lahir_propinsi)->propinsi_nama : null;

        $model->create_time = date('Y-m-d');
        $model->update_time = date('Y-m-d');
        $model->create_loginpemakai_id = Yii::app()->user->id;
        $model->update_loginpemakai_id = Yii::app()->user->id;
        $model->create_ruangan = Yii::app()->user->getState('ruangan_id');

        if ($model->validate()) {
          if ($model->save()) {
            $transaction->commit();
            $model->isNewRecord = FALSE;
            if (!empty($_GET['pendaftaran_id'])) {
              $model->suratketerangan_id = $model->suratketerangan_id;
            }
          } else {
            echo "gagal Simpan";
            exit;
          }

          Yii::app()->user->setFlash('success', "Surat Keterangan Lahir berhasil disimpan");
          $this->redirect(array(
            'CetakSuratKelarihan', 'kelahiranbayi_id' => $kelahiranbayi_id, 'pendaftaran_id' => $pendaftaran_id,
            'suratketerangan_id' => $model->suratketerangan_id
          ));
        }
      } catch (Exception $exc) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Surat Keterangan Lahir gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
      }
    }

    $this->render(
      $this->path_view_surat . 'lahir/index',
      array(
        'model' => $model,
        'modPasien' => $modPasien,
        'modPendaftaran' => $modPendaftaran
      )
    );
  }

  public function actionFormuliIdentitasBayiCapJari($kelahiranbayi_id)
  {
    $this->layout = '//layouts/printWindows';
    $modKelahiran = PSKelahiranbayiT::model()->findByPk($kelahiranbayi_id);
    $modPersalinan = PersalinanT::model()->findByPk($modKelahiran->persalinan_id);
    $modPasien = PasienM::model()->findByPk($modPersalinan->pasien_id);
    $this->render(
      'printFormulirBayi',
      array(
        'model' => $modKelahiran,
        'modPersalinan' => $modPersalinan,
        'modPasien' => $modPasien,
      )
    );
  }

  public function actionVerifikasiTindakLanjut()
  {
    if (!Yii::app()->request->isAjaxRequest) {
      Yii::app()->end();
    }


    $ok = 1;
    $msg = "";
    $id = $_POST['id'];

    $is_confirm = 0;

    $reseptur = ResepturT::model()->findByAttributes(array(
      'pendaftaran_id' => $id,
    ), array(
      'condition' => 'penjualanresep_id is null'
    ));

    $p = PendaftaranT::model()->findByPk($id);
    if ($p->statusperiksa != Params::STATUSPERIKSA_SUDAH_DIPERIKSA) {
      $ok = 0;
      $msg = "Pasien masih dalam status " . $p->statusperiksa . ".";

      goto outs;
    }

    // ============= Reseptur belum di verifikasi =====================
    if (!empty($reseptur)) {
      $ok = 0;
      $msg = "Pasien memiliki reseptur yang belum diverifikasi.";

      goto outs;
    }

    // ============= Pemeriksaan belum diapprove di lab/rad ===========
    $kirim = PasienkirimkeunitlainV::model()->findByAttributes(array(
      'pendaftaran_id' => $id,
      'ruangan_id' => array(Params::RUANGAN_ID_LAB_KLINIK, Params::RUANGAN_ID_RAD),

    ), array(
      'condition' => 'pasienmasukpenunjang_id is null',
    ));

    if (!empty($kirim)) {
      $ok = 0;
      $msg = "Pemeriksaan Laboratorium/Radiologi belum dilakukan verifikasi, akan Anda melanjutkan ?";
      $is_confirm = 1;

      goto outs;
    }


    // ============= Pemeriksaan belum muncul di modul lab/rad ========
    $penunjang = PasienmasukpenunjangT::model()->findAllByAttributes(array(
      'pendaftaran_id' => $id,
      'ruangan_id' => array(Params::RUANGAN_ID_LAB_KLINIK, Params::RUANGAN_ID_RAD),
    ));


    $is_lab = false;
    $is_rad = false;

    foreach ($penunjang as $item) {
      if ($item->ruangan_id == Params::RUANGAN_ID_RAD) {
        $criRad = new CDbCriteria();
        $criRad->addCondition(" pendaftaran_id = '" . $item->pendaftaran_id . "' AND pasienmasukpenunjang_id = '" . $item->pasienmasukpenunjang_id . "' ");
        $criRad->addCondition(" (statusperiksahasil = '" . Params::STATUSPERIKSAHASIL_BELUM . "') OR (statusperiksahasil IS NULL)  ");
        $rad = HasilpemeriksaanradT::model()->findAll($criRad);

        if (!empty($rad)) {
          $ok = 0;
          $is_rad = true;
        }
      } else if ($item->ruangan_id == Params::RUANGAN_ID_LAB_KLINIK) {
        $hasil = HasilpemeriksaanlabT::model()->findByAttributes(array(
          'pasienmasukpenunjang_id' => $item->pasienmasukpenunjang_id
        ));

        if (empty($hasil)) {
          $ok = 0;
          $is_lab = true;
        }
      }
    }

    if ($is_lab || $is_rad) {
      $ruangan = array();
      if ($is_lab) {
        $ruangan[] = "Laboratorium";
      }
      if ($is_rad) {
        $ruangan[] = "Radiologi";
      }

      $ok = 0;
      $msg = "Belum ada hasil pemeriksaan pada " . (implode(" dan ", $ruangan)) . ". Anda yakin untuk melanjutkan ?";
      $is_confirm = 1;

      goto outs;
    }

    outs:
    echo CJSON::encode(array('ok' => $ok, 'msg' => $msg, 'is_confirm' => $is_confirm));
  }

  public function actionRiwayatDokfilerm($pendaftaran_id)
  {
    $this->layout = '//layouts/iframe';
    $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
    $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
    $crit = new CDbCriteria();
    $crit->addCondition('pasien_id ='. $modPasien->pasien_id);
    $modDokfilerm = DokfilermR::model()->findAll($crit);
    $modDokfilerms =[];
    foreach ($modDokfilerm as $dok) {
        if (in_array( Yii::app()->user->getState('instalasi_id'), (array)$dok->instalasi_ids)) {
            $modDokfilerms[]=$dok; 
        }
    }
    $this->render('_listDokfilerm', array('modDokfilerm' => $modDokfilerms));
  }

  public function actionDetailScanRM($dokfilerm_id) {
    $this->layout = '//layouts/iframe';
        
        $file = DokfilermR::model()->findByPk($dokfilerm_id);
            
        $this->render("detail_scandokumen", array(
        'file'=>$file,
    ));
  }

}
