<?php
Yii::import('laboratorium.controllers.PendaftaranLaboratoriumController');
Yii::import('laboratorium.models.*');
Yii::import('laboratorium.views.pendaftaranLaboratorium');
/**
 * untuk transaksi pendaftaran lab
 * @author <rusdiyanto@.com>
 * @package    application.modules.pendaftaranPenjadwalan
 * @subpackage controllers
 */
class PendaftaranLaboratoriumMikrobiologiPPController extends PendaftaranLaboratoriumController
{
  public $path_view_pendaftaran = 'pendaftaranPenjadwalan.views.pendaftaranLaboratoriumPP.';
  public $path_view_order = 'rawatJalan.views.mikrobiologiKlinik.';
  public $path_view_lab = 'laboratorium.views.pendaftaranLaboratorium.';

  /**
   * proses simpan / ubah data pasien
   * @param type $modPasien
   * @param type $post
   * @return type
   */


  public function actionIndexMikro2($id = null, $idAntrian = null) {

    $format = new MyFormatter();
    $model = new LBPendaftaranT;
    $model->pendaftaran_id = null; //new record
    $modPasien = new LBPasienM;
    $modPenanggungJawab = new LBPenanggungJawabM;
    $modAsuransiPasien = new LBAsuransipasienM;

    $modKirimUnitLain = new LBPasienKirimKeUnitLainT;

    $modPegawai = new PPPegawaiM;
    $modPegawaiPJ = new PPPegawaiM;
    $modAsuransiPasienBadak = new PPAsuransipasienbadakM();
    $modAsuransiPasienDepartemen = new PPAsuransipasiendepartemenM();
    $modAsuransiPasienPekerja = new PPAsuransipasienpegawaiM();

    $modPasienMasukPenunjangs[0] = new LBPasienmasukpenunjangT;
    $modPasienMasukPenunjangs[0]->ruangan_id = Params::RUANGAN_ID_LAB_KLINIK;
    $modPasienMasukPenunjangs[0]->is_pilihpenunjang = 0;
    $modPasienMasukPenunjangs[0]->is_adakarcis = 0; //dibawah ada switch
    $modPasienMasukPenunjangs[0]->jeniskasuspenyakit_id = Params::JENIS_KASUSPENYAKIT_ID_LAB_KLIINIK; //default 
    $modPasienMasukPenunjangs[1] = new LBPasienmasukpenunjangT;
    $modPasienMasukPenunjangs[1]->ruangan_id = Params::RUANGAN_ID_LAB_ANATOMI;
    $modPasienMasukPenunjangs[1]->is_pilihpenunjang = 0;
    $modPasienMasukPenunjangs[1]->is_adakarcis = 0; //dibawah ada switch

    $modPenunjang2 = new LBPermintaanKePenunjangT;

    $modAntrian = new PPAntrianT;

    switch (Yii::app()->user->getState('ruangan_id')) {
      case Params::RUANGAN_ID_LAB_KLINIK:
        $modPasienMasukPenunjangs[0]->is_pilihpenunjang = 1;
        $modPasienMasukPenunjangs[0]->is_adakarcis = Yii::app()->user->getState('iskarcis'); //RND-7737
        break;
      case Params::RUANGAN_ID_LAB_ANATOMI:
        $modPasienMasukPenunjangs[1]->is_pilihpenunjang = 1;
        $modPasienMasukPenunjangs[1]->is_adakarcis = Yii::app()->user->getState('iskarcis'); //RND-7737
        break;
      default:
        $modPasienMasukPenunjangs[0]->is_pilihpenunjang = 1;
        $modPasienMasukPenunjangs[0]->is_adakarcis = Yii::app()->user->getState('iskarcis'); //RND-7737
    }

    $modPemeriksaanLab = new LBTarifpemeriksaanlabruanganV;
    $modRujukan = new LBRujukanT;
    $modTindakan = new LBTindakanPelayananT;
    $modHasilPemeriksaan = new LBHasilPemeriksaanLabT;
    $modHasilPemeriksaanPA = new LBHasilPemeriksaanPAT;
    $modDetailHasilPemeriksaan = new LBDetailHasilPemeriksaanLabT;
    $modPengambilanSample = new LBPengambilanSampleT;
    $modPengambilanSample->no_pengambilansample = "- Otomatis -";
    $dataTindakans[0] = array();
    $dataTindakans[1] = array();
    $modKarcis[0] = array();
    $modKarcis[1] = array();
    $dataSamples[0] = array();
    $dataSamples[1] = array();
    $modPasien->propinsi_id = Yii::app()->user->getState('propinsi_id');
    $modPasien->kabupaten_id = Yii::app()->user->getState('kabupaten_id');
    $modPasien->kecamatan_id = Yii::app()->user->getState('kecamatan_id');
    $modPasien->warga_negara = Params::DEFAULT_WARGANEGARA;
    $modPasien->agama = Params::DEFAULT_AGAMA;

    $nama_modul = Yii::app()->controller->module->id;
    $nama_controller = Yii::app()->controller->id;
    $nama_action = Yii::app()->controller->action->id;
    $modul_id = ModulK::model()->findByAttributes(array('url_modul' => $nama_modul))->modul_id;
    $criteria = new CDbCriteria;
    $criteria->compare('modul_id', $modul_id);
    $criteria->compare('LOWER(modcontroller)', strtolower($nama_controller), true);
    $criteria->compare('LOWER(modaction)', strtolower($nama_action), true);
    if (isset($_POST['tujuansms'])) {
      $criteria->addInCondition('tujuansms', $_POST['tujuansms']);
    }
    $modSmsgateway = SmsgatewayM::model()->findAll($criteria);

    //==load data
    if (!empty($idAntrian)) {
      $modAntrian = PPAntrianT::model()->findByPk($idAntrian, array(
        'condition' => 'pendaftaran_id is null',
      ));
      if (empty($modAntrian)) {
        $modAntrian = new PPAntrianT;
      } else {
        $model->antrian_id = $modAntrian->antrian_id;
      }
    }
    if (isset($id)) {
      $model = $this->loadModel($id);
      $modPasien = LBPasienM::model()->findByPk($model->pasien_id);
      $criteria = new CdbCriteria();
      $criteria->addCondition('pendaftaran_id = ' . $model->pendaftaran_id);
      $criteria->order = "pendaftaran_id DESC, pasienmasukpenunjang_id ASC";
      $criteria->limit = 2;
      $criteria1 = $criteria;
      $criteria1->addCondition('ispatologianatomi = false');
      $loadPasienMasukPenunjangs[0] = LBPasienmasukpenunjangT::model()->find($criteria1);
      if (isset($loadPasienMasukPenunjangs[0])) {
        $modPasienMasukPenunjangs[0] = $loadPasienMasukPenunjangs[0];
        $modPasienMasukPenunjangs[0]->is_pilihpenunjang = 1;
        $modPasienMasukPenunjangs[0]->is_adakarcis = Yii::app()->user->getState('iskarcis'); //RND-7737
      }
      $criteria2 = $criteria;
      $criteria1->addCondition('ispatologianatomi = true');
      $loadPasienMasukPenunjangs[1] = LBPasienmasukpenunjangT::model()->find($criteria2);
      if (isset($loadPasienMasukPenunjangs[1])) {
        $modPasienMasukPenunjangs[1] = $loadPasienMasukPenunjangs[1];
        $modPasienMasukPenunjangs[1]->is_pilihpenunjang = 1;
        $modPasienMasukPenunjangs[1]->is_adakarcis = Yii::app()->user->getState('iskarcis'); //RND-7737
      }
      if (!empty($model->penanggungjawab_id)) {
        $modPenanggungJawab = LBPenanggungJawabM::model()->findByPk($model->penanggungjawab_id);
        if (!empty($modPenanggungJawab->pegawai_id)) {
          $modPasien->pegawai_penanggungjawab_id = $modPenanggungJawab->pegawai_id;
          $modPegawaiPJ = LBPegawaiM::model()->findByPk($modPenanggungJawab->pegawai_id);
        }
      }
      if (!empty($model->rujukan_id)) {
        $modRujukan = LBRujukanT::model()->findByPk($model->rujukan_id);
      }
      $dataKarcis[0] = LBTindakanPelayananT::model()->findByAttributes(array('pasienmasukpenunjang_id' => $loadPasienMasukPenunjangs[0]->pasienmasukpenunjang_id ?? -1, 'pendaftaran_id' => $model->pendaftaran_id), "karcis_id is not null");
      $dataKarcis[1] = LBTindakanPelayananT::model()->findByAttributes(array('pasienmasukpenunjang_id' => $loadPasienMasukPenunjangs[1]->pasienmasukpenunjang_id ?? -1, 'pendaftaran_id' => $model->pendaftaran_id), "karcis_id is not null");
      if (isset($dataKarcis[0]->karcis_id)) {
        $modKarcis[0][0] =  LBKarcisV::model()->findByAttributes(array('karcis_id' => $dataKarcis[0]->karcis_id));
        $modKarcis[0][0]->harga_tariftindakan = $dataKarcis[0]->tarif_tindakan;
      }
      if (isset($dataKarcis[1]->karcis_id)) {
        $modKarcis[1][0] =  LBKarcisV::model()->findByAttributes(array('karcis_id' => $dataKarcis[1]->karcis_id));
        $modKarcis[1][0]->harga_tariftindakan = $dataKarcis[1]->tarif_tindakan;
      }
      $dataTindakans[0] = LBTindakanPelayananT::model()->findAllByAttributes(array('pasienmasukpenunjang_id' => $loadPasienMasukPenunjangs[0]->pasienmasukpenunjang_id ?? -1, 'pendaftaran_id' => $model->pendaftaran_id), "karcis_id is null");
      $dataTindakans[1] = LBTindakanPelayananT::model()->findAllByAttributes(array('pasienmasukpenunjang_id' => $loadPasienMasukPenunjangs[1]->pasienmasukpenunjang_id ?? -1, 'pendaftaran_id' => $model->pendaftaran_id), "karcis_id is null");
    }
    

    // if(isset)

    $ok = true;

    // var_dump('tes mikro', isset($_POST['LBPendaftaranT'])); die;


    if (isset($_POST['LBPendaftaranT'])) {

      // echo '<pre>'; var_dump($_POST); die;
      
      $transaction = Yii::app()->db->beginTransaction();
      try {

        
        $modPasien = $this->simpanPasien($modPasien, $_POST['LBPasienM']);

        if ($_POST['LBPendaftaranT']['is_adapjpasien']) {
          if (isset($_POST['LBPenanggungJawabM'])) {
            $modPenanggungJawab = $this->simpanPenanggungjawab($modPenanggungJawab, $_POST['LBPenanggungJawabM']);
          }
        } else {
          $this->penanggungjawabtersimpan = true;
        }

        if (isset($_POST['LBPasienM']['pegawai_penanggungjawab_id'])) {
          $modPenanggungJawab = $this->simpanPenanggungjawabDokter($modPenanggungJawab, $_POST['LBPasienM']['pegawai_penanggungjawab_id']);
        }

        if ($_POST['LBPendaftaranT']['is_pasienrujukan']) {
          if (isset($_POST['LBRujukanT'])) {
            $modRujukan = $this->simpanRujukan($modRujukan, $_POST['LBRujukanT']);
          }
        } else {
          $this->rujukantersimpan = true;
        }

        if (isset($_POST['LBAsuransipasienM'])) {
          if (isset($_POST['LBAsuransipasienM']['asuransipasien_id'])) {
            if (!empty($_POST['LBAsuransipasienM']['asuransipasien_id'])) {
              $modAsuransiPasien = LBAsuransipasienM::model()->findByPk($_POST['LBAsuransipasienM']['asuransipasien_id']);
            }
          }
          $modAsuransiPasien = $this->simpanAsuransiPasien($modAsuransiPasien, $_POST['LBPendaftaranT'], $modPasien, $_POST['LBAsuransipasienM']);
        } else {
          $this->asuransipasientersimpan = true;
        }

        if (isset($_POST['PPAsuransipasienbadakM'])) {
          if (isset($_POST['PPAsuransipasienbadakM']['asuransipasien_id'])) {
            if (!empty($_POST['PPAsuransipasienbadakM']['asuransipasien_id'])) {
              $modAsuransiPasienBadak = PPAsuransipasienM::model()->findByPk($_POST['PPAsuransipasienbadakM']['asuransipasien_id']);
            }
          }
          $modAsuransiPasienBadak = $this->simpanAsuransiPasien($modAsuransiPasienBadak, $_POST['LBPendaftaranT'], $modPasien, $_POST['PPAsuransipasienbadakM']);
        } else {
          $this->asuransipasientersimpan = true;
        }

        if (isset($_POST['PPAsuransipasiendepartemenM'])) {
          if (isset($_POST['PPAsuransipasiendepartemenM']['asuransipasien_id'])) {
            if (!empty($_POST['PPAsuransipasiendepartemenM']['asuransipasien_id'])) {
              $modAsuransiPasienDepartemen = PPAsuransipasienM::model()->findByPk($_POST['PPAsuransipasiendepartemenM']['asuransipasien_id']);
            }
          }
          $modAsuransiPasienDepartemen = $this->simpanAsuransiPasien($modAsuransiPasienDepartemen, $_POST['LBPendaftaranT'], $modPasien, $_POST['PPAsuransipasiendepartemenM']);
        } else {
          $this->asuransipasientersimpan = true;
        }

        if (isset($_POST['PPAsuransipasienpegawaiM'])) {
          if (isset($_POST['PPAsuransipasienpegawaiM']['asuransipasien_id'])) {
            if (!empty($_POST['PPAsuransipasienpegawaiM']['asuransipasien_id'])) {
              $modAsuransiPasienPekerja = PPAsuransipasienM::model()->findByPk($_POST['PPAsuransipasienpegawaiM']['asuransipasien_id']);
            }
          }
          $modAsuransiPasienPekerja = $this->simpanAsuransiPasien($modAsuransiPasienPekerja, $_POST['LBPendaftaranT'], $modPasien, $_POST['PPAsuransipasienpegawaiM']);
        } else {
          $this->asuransipasientersimpan = true;
        }

        $model = $this->simpanPendaftaran($model, $modPasien, $modRujukan, $modPenanggungJawab, $_POST['LBPendaftaranT'], $_POST['LBPasienM'], $_POST['LBPasienmasukpenunjangT'], $modAsuransiPasien);

        // echo '<pre>';var_dump($_POST['pemeriksaan']);die;

        if(isset($_POST['pemeriksaan'])) {

          foreach($_POST['pemeriksaan'] as $pemeriksaan) {
            $tindakan = new LBTindakanPelayananT();
            $tindakan->pendaftaran_id = $model->pendaftaran_id;
            $tindakan->pasien_id = $model->pasien_id;
            $tindakan->pemeriksaanlab_id = $pemeriksaan['pemeriksaanlab_id'];

            if(!empty($tindakan->pemeriksaanlab_id)) {
              $lab = PemeriksaanlabM::model()->findByPk($tindakan->pemeriksaanlab_id);
              // $tindakan->kelompokpemeriksaanlab_id = $lab->kelompokpemeriksaanlab_id;
            }

            $tindakan->shift_id = Yii::app()->user->getState('shift_id');

            $tindakan->daftartindakan_id = $tindakan->pemeriksaanlab->daftartindakan_id;
            $tindakan->samplelab_id = $pemeriksaan['samplelab_id'];
            $tindakan->caraambilsampel_id = $pemeriksaan['caraambilsample_id'];
            $tindakan->ruangan_id = $model->ruangan_id;
            $tindakan->instalasi_id = $model->instalasi_id;
            $tindakan->pegawai_id = $model->pegawai_id;
            $tindakan->kelaspelayanan_id = $model->kelaspelayanan_id;
            $tindakan->jeniskasuspenyakit_id = $model->jeniskasuspenyakit_id;
            $tindakan->tgl_tindakan = date('Y-m-d H:i:s');
            $tindakan->tarif_tindakan = $pemeriksaan['harga_tariftindakan'];
            $tindakan->tarif_satuan = $pemeriksaan['harga_tariftindakan'];

            $tindakan->qty_tindakan = $pemeriksaan['qty_tindakan'];
            $tindakan->satuantindakan = 'KALI';

            $tindakan->penjamin_id = $model->penjamin_id;
            $tindakan->carabayar_id = $model->carabayar_id;

            $tindakan->jumlahTarif = intval($tindakan->qty_tindakan) * intval($tindakan->tarif_satuan);
            $tindakan->subsidiasuransi_tindakan = 0;
            $tindakan->subsidipemerintah_tindakan = 0;
            $tindakan->subsisidirumahsakit_tindakan = 0;
            $tindakan->iurbiaya_tindakan = 0; //$tindakan->iurbiaya;
            $tindakan->ruangan_id = empty($tindakan->ruangan_id) ? Yii::app()->user->getState('ruangan_id') : $tindakan->ruangan_id;

            $tindakan->discount_tindakan = 0;

            $tindakan->create_time = date('Y-m-d H:i:s');
            $tindakan->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
            $tindakan->create_ruangan = Yii::app()->user->getState('ruangan_id');

            $md_noawal = TindakanpelayananT::model()->find("pendaftaran_id = $model->pendaftaran_id AND nopelayanan IS NOT NULL order by nopelayanan DESC");

            if(!empty($md_noawal)) {
              $noawal = intval($md_noawal->nopelayanan);
            } else {
              $noawal = 1;
            }

            $tindakan->nopelayanan = str_pad($noawal+1,3,"0",STR_PAD_LEFT);


            $ok &= $tindakan->save();



          }
        }

        // echo '<pre>'; var_dump($_POST); die;

        $penunjang = new LBPasienmasukpenunjangT;
        $penunjang->attributes = $_POST['LBPasienmasukpenunjangT'][1];
        $penunjang->pendaftaran_id = $model->pendaftaran_id;
        $penunjang->pasien_id = $model->pasien_id;
        $penunjang->statusperiksa = $model->statusperiksa;
        $penunjang->tglmasukpenunjang = date('Y-m-d H:i:s');

        $penunjang->shift_id = Yii::app()->user->getState('shift_id');
        $penunjang->is_mikro = true;

        $penunjang->create_time = date('Y-m-d H:i:s');
        $penunjang->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
        $penunjang->create_ruangan = Yii::app()->user->getState('ruangan_id');
        
        $instalasi_id = $penunjang->ruangan->instalasi_id;
        $kode_instalasi = InstalasiM::model()->findByPk($instalasi_id)->instalasi_singkatan;
        $penunjang->no_masukpenunjang = MyGenerator::noMasukPenunjang2($kode_instalasi);

        $penunjang->no_urutperiksa =  MyGenerator::noAntrianPenunjang($penunjang->ruangan_id);


        $penunjang->ruanganasal_id = $penunjang->ruangan_id;
        $penunjang->kunjungan = "-";

        $ok &= $penunjang->save();

        $pasienkirim = new LBPasienKirimKeUnitLainT;
        $pasienkirim->attributes = $_POST['LBPasienKirimKeUnitLainT'];
        $pasienkirim->tgl_kirimpasien = date('Y-m-d H:i:s');
        $pasienkirim->waktuambilspesimen = MyFormatter::formatDateTimeForDb($pasienkirim->waktuambilspesimen);

        $pasienkirim->pasienmasukpenunjang_id = $penunjang->pasienmasukpenunjang_id;

        $pasienkirim->is_nonprogram = $_POST['LBPasienKirimKeUnitLainT']['is_nonprogram'] !== 0;
        $pasienkirim->is_programtbc = $_POST['LBPasienKirimKeUnitLainT']['is_programtbc'] !== 0;
        $pasienkirim->is_programhiv = $_POST['LBPasienKirimKeUnitLainT']['is_programhiv'] !== 0;

        $pasienkirim->pasien_id = $model->pasien_id;
        $pasienkirim->pendaftaran_id = $model->pendaftaran_id;
        $pasienkirim->kelaspelayanan_id = $model->kelaspelayanan_id;
        $pasienkirim->ruangan_id = $model->ruangan_id;
        $pasienkirim->instalasi_id = $model->instalasi_id;

        $pasienkirim->create_time = date('Y-m-d H:i:s');
        $pasienkirim->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
        $pasienkirim->create_ruangan = Yii::app()->user->getState('ruangan_id');

        $pasienkirim->update_time = date('Y-m-d H:i:s');
        $pasienkirim->update_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');

        $pasienkirim->nourut = MyGenerator::noUrutPasienKirimKeUnitLain($pasienkirim->ruangan_id);

        $ok &= $pasienkirim->save();

        $penunjang->pasienkirimkeunitlain_id = $pasienkirim->pasienkirimkeunitlain_id;

        $ok &= $penunjang->save();
        
        // $this->savePermintaanPenunjang($_POST['pemeriksaan'], $pasienkirim);



        // echo '<pre>'; var_dump($pasienkirim->save(), $pasienkirim->getErrors()); die;



      if($ok) {
        $transaction->commit();
        Yii::app()->user->setFlash('success', "Data pendaftaran berhasil disimpan !");
        $this->redirect(array('indexMikro2', 'id' => $model->pendaftaran_id, 'sukses' => 1));
      } else {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data pendaftaran gagal disimpan !");
        //                        echo "-".$this->pasientersimpan."<br>";
        //                        echo "-".$this->pendaftarantersimpan."<br>";
        //                        echo "-".$this->penanggungjawabtersimpan."<br>";
        //                        echo "-".$this->rujukantersimpan."<br>";
        //                        echo "-".$this->karcistersimpan."<br>";
        //                        echo "-".$this->tindakanpelayanantersimpan."<br>";
        //                        echo "-".$this->komponentindakantersimpan."<br>";
        //                        echo "-".$this->hasilpemeriksaantersimpan."<br>";
        //                        echo "-".$this->pengambilansampletersimpan."<br>";
        //                        exit;
      }
    } catch (Exception $exc) {
      $transaction->rollback();
      echo '<pre>'; var_dump($exc); die;
 
   //   die;
      Yii::app()->user->setFlash('error', "Data pendaftaran gagal disimpan !" . " " . MyExceptionMessage::getMessage($exc, true));
    }
    
  }
    
  $this->render($this->path_view . 'indexMikro', array(
    'model' => $model,
    'modPasien' => $modPasien,
    'modPegawaiPJ' => $modPegawaiPJ,
    'modPenanggungJawab' => $modPenanggungJawab,
    'modAsuransiPasien' => $modAsuransiPasien,
    'modPasienMasukPenunjangs' => $modPasienMasukPenunjangs,
    'modPemeriksaanLab' => $modPemeriksaanLab,
    'modPengambilanSample' => $modPengambilanSample,
    'modRujukan' => $modRujukan,
    'modTindakan' => $modTindakan,
    'dataTindakans' => $dataTindakans,
    'modKarcis' => $modKarcis,
    'dataSamples' => $dataSamples,
    'modPegawai' => $modPegawai,
    'modAsuransiPasienBadak' => $modAsuransiPasienBadak,
    'modAsuransiPasienPekerja' => $modAsuransiPasienPekerja,
    'modAsuransiPasienDepartemen' => $modAsuransiPasienDepartemen,
    'modSmsgateway' => $modSmsgateway,
    'modAntrian' => $modAntrian,
    'modKirimUnitLain' => $modKirimUnitLain,
    'modPenunjang2' => $modPenunjang2
  ));
}


protected function savePermintaanPenunjang($permintaan, $modKirimKeUnitLain)
    {

        $pendaftaran = PendaftaranT::model()->findByPk($modKirimKeUnitLain->pendaftaran_id);

        foreach ($permintaan['kode_unik'] as $i => $value) {

            $modPermintaan = new LBPermintaanPenunjangT;


            if ($permintaan['kode_unik'][$i] == '') {
                $modPermintaan->pemeriksaanlab_id = null;
                $modPermintaan->tarif_pelayananan = 0;
            } else {
                $tarif = TarifpemeriksaanlabruanganV::model()->find("kode_unik = '" . $permintaan['kode_unik'][$i] . "' and carabayar_id = $pendaftaran->carabayar_id and kelaspelayanan_id = $pendaftaran->kelaspelayanan_id");

                if (empty($tarif)) {
                    $modPermintaan->pemeriksaanlab_id = null;
                    $modPermintaan->tarif_pelayananan = 0;
                } else {
                    $modPermintaan->pemeriksaanlab_id = $tarif->pemeriksaanlab_id;
                    $modPermintaan->tarif_pelayananan = $tarif->harga_tariftindakan;
                }

                $modPermintaan->kode_unik = $permintaan['kode_unik'][$i];
            }
            $modPermintaan->subjenis_pemeriksaanlab_id = $permintaan['subjenis_pemeriksaanlab_id'][$i] ?? null;
            $modPermintaan->is_paket = $permintaan['is_paket'][$i] ?? null;



            $modPermintaan->daftartindakan_id = isset($permintaan['idDaftarTindakan'][$i]) ? $permintaan['idDaftarTindakan'][$i] : null;
            $modPermintaan->pemeriksaanlab_id = $permintaan['pemeriksaanlab_id'][$i];
            $modPermintaan->catatan = $permintaan['catatan'][$i];
            $modPermintaan->pemeriksaanrad_id = '';
            $modPermintaan->pasienkirimkeunitlain_id = $modKirimKeUnitLain->pasienkirimkeunitlain_id;
            $modPermintaan->noperminatanpenujang = MyGenerator::noPermintaanPenunjang('PL');
            $modPermintaan->qtypermintaan = 1;
            $modPermintaan->tglpermintaankepenunjang = MyFormatter::formatDateTimeForDb($modKirimKeUnitLain->tgl_kirimpasien);
            // $modPermintaan->is_cito = $modKirimKeUnitLain->is_cito;
            $modPermintaan->samplelab_id = $modKirimKeUnitLain->samplelab_id;
            $modPermintaan->caraambilsampel_id = $modKirimKeUnitLain->caraambilsampel_id;
            $modPermintaan->is_cito = isset($permintaan['is_cito'][$i]) ? $permintaan['is_cito'][$i] : null;

            // $modPermintaan->subjenis_pemeriksaanlab_id = $modKirimKeUnitLain->subjenis_pemeriksaanlab_id;

            // insert paket pelayanan
            if (isset($permintaan['tindakanpelayanan_id'][$i])) {
                $modPermintaan->tindakanpelayanan_id = $permintaan['tindakanpelayanan_id'][$i];
            }

            $modPermintaan->no_sediaan = isset($_POST['LBPermintaanPenunjangT']['no_sediaan']) ? $_POST['LBPermintaanPenunjangT']['no_sediaan'] : null;
            $modPermintaan->jenis_pasientbc = isset($_POST['LBPermintaanPenunjangT']['jenis_pasientbc']) ? $_POST['LBPermintaanPenunjangT']['jenis_pasientbc'] : null;
            $modPermintaan->is_visual_lendirnanah1 = isset($_POST['LBPermintaanPenunjangT']['is_visual_lendirnanah1']) ? $_POST['LBPermintaanPenunjangT']['is_visual_lendirnanah1'] : null;
            $modPermintaan->is_visual_lendirnanah2 = isset($_POST['LBPermintaanPenunjangT']['is_visual_lendirnanah2']) ? $_POST['LBPermintaanPenunjangT']['is_visual_lendirnanah2'] : null;
            $modPermintaan->is_visual_bercakdarah1 = isset($_POST['LBPermintaanPenunjangT']['is_visual_bercakdarah1']) ? $_POST['LBPermintaanPenunjangT']['is_visual_bercakdarah1'] : null;
            $modPermintaan->is_visual_bercakdarah2 = isset($_POST['LBPermintaanPenunjangT']['is_visual_bercakdarah2']) ? $_POST['LBPermintaanPenunjangT']['is_visual_bercakdarah2'] : null;
            $modPermintaan->is_visual_airliur1 = isset($_POST['LBPermintaanPenunjangT']['is_visual_airliur1']) ? $_POST['LBPermintaanPenunjangT']['is_visual_airliur1'] : null;
            $modPermintaan->is_visual_airliur2 = isset($_POST['LBPermintaanPenunjangT']['is_visual_airliur2']) ? $_POST['LBPermintaanPenunjangT']['is_visual_airliur2'] : null;
            $modPermintaan->lokasianatomi = isset($_POST['LBPermintaanPenunjangT']['lokasianatomi']) ? $_POST['LBPermintaanPenunjangT']['lokasianatomi'] : null;
            $modPermintaan->alasanpemeriksaan = isset($_POST['LBPermintaanPenunjangT']['alasanpemeriksaan']) ? $_POST['LBPermintaanPenunjangT']['alasanpemeriksaan'] : null;
            $modPermintaan->pemantauan_kemajuan = isset($_POST['LBPermintaanPenunjangT']['pemantauan_kemajuan']) ? $_POST['LBPermintaanPenunjangT']['pemantauan_kemajuan'] : null;
            $modPermintaan->pemeriksaan_ulang = isset($_POST['LBPermintaanPenunjangT']['pemeriksaan_ulang']) ? $_POST['LBPermintaanPenunjangT']['pemeriksaan_ulang'] : null;
            $modPermintaan->pemeriksaan_selesai = isset($_POST['LBPermintaanPenunjangT']['pemeriksaan_selesai']) ? $_POST['LBPermintaanPenunjangT']['pemeriksaan_selesai'] : null;
            $modPermintaan->no_reg_fasyankes = isset($_POST['LBPermintaanPenunjangT']['no_reg_fasyankes']) ? $_POST['LBPermintaanPenunjangT']['no_reg_fasyankes'] : null;
            $modPermintaan->no_reg_kabkota = isset($_POST['LBPermintaanPenunjangT']['no_reg_kabkota']) ? $_POST['LBPermintaanPenunjangT']['no_reg_kabkota'] : null;
            // $modPermintaan->samplelab_id = $permintaan['samplelab_id'][$i];
            $modPermintaan->samplelab_id = isset($permintaan['samplelab_id'][$i]) ? $permintaan['samplelab_id'][$i] : null;
            $modPermintaan->samplelablain = isset($permintaan['samplelablain'][$i]) ? $permintaan['samplelablain'][$i] : null;
            $modPermintaan->caraambilsampel_id = isset($permintaan['caraambilsampel_id'][$i]) ? $permintaan['caraambilsampel_id'][$i] : null;

            $modPermintaan->caraambilsampel_id = isset($_POST['LBPasienKirimKeUnitLainT']['caraambilsampel_id']) ? $_POST['LBPasienKirimKeUnitLainT']['caraambilsampel_id'] : null;


            // echo'<pre>';
            // // var_dump($modPermintaan->save(), $modPermintaan->getErrors(), $modPermintaan->attributes);
            // var_dump($_POST['LBPermintaanPenunjangT']);
            // var_dump("--------------------------------------------------------------------");
            // var_dump($modPermintaan->save(), $modPermintaan->getErrors(), $modPermintaan->attributes);
            //  die;

            if ($modPermintaan->validate()) {
                if ($modPermintaan->save()) {
                    $this->statusSavePermintaanPenunjang = true;

                    // insert tindakan, jika bayar kasir di centang dan belum ada tindakan dari paket.
                    if ($modKirimKeUnitLain->isbayarkekasirpenunjang && empty($modPermintaan->tindakanpelayanan_id)) {
                        $modPendaftaran = $modKirimKeUnitLain->pendaftaran;
                        $modTindakan = $this->simpanTindakanPelayanan($modPendaftaran, $modKirimKeUnitLain, $modPermintaan); //AGAR BISA DI BAYAR DI KASIR
                        $modPermintaan->tindakanpelayanan_id = $modTindakan->tindakanpelayanan_id;
                        $modPermintaan->update();
                    }
                }
            }

            // var_dump($modPermintaan->attributes); die;

        }
    }
  
  public function actionLoadTabelSpesimenMikro()
  {
      if (Yii::app()->request->isAjaxRequest) {
          $pemeriksaan_id = isset($_POST['sample_id']) ? $_POST['sample_id'] : null;
          $catatan = isset($_POST['catatan']) ? $_POST['catatan'] : '';
          $samplelab_id = isset($_POST['samplelab_id']) ? $_POST['samplelab_id'] : '';
          $caraambilsampel_id = isset($_POST['caraambilsampel_id']) ? $_POST['caraambilsampel_id'] : '';
          $kode_unik = $_POST['kode_unik'] ?? null;

          $pemeriksaanlab_id = $_POST['pemeriksaanlab_id'] ?? null;
          $kelaspelayanan_id = $_POST['kelaspelayanan_id'] ?? null;

          // var_dump($caraambilsampel_id);die;
          // $criteria = new CDbCriteria();
          // $criteria->addCondition('samplelab_id = '.$samplelab_id);
          // $modSample = SamplelabM::model()->find($criteria);
          if(empty($kelaspelayanan_id)) {
              $modPemeriksaan = OrderpemeriksaanlabmikroV::model()->findByAttributes(array(
                  'kode_unik' => $kode_unik,'pemeriksaanlab_id' => $pemeriksaanlab_id,
                  // 'condition' => 'subjenis_pemeriksaanlab_id is not null',
              )
          );
          } else {
              $modPemeriksaan = OrderpemeriksaanlabmikroV::model()->findByAttributes(array(
                  'kode_unik' => $kode_unik,'pemeriksaanlab_id' => $pemeriksaanlab_id,'kelaspelayanan_id' => $kelaspelayanan_id,
              ), array(
                  // 'condition' => 'subjenis_pemeriksaanlab_id is not null',
              )
            );
          }

          $lab = PemeriksaanlabM::model()->findByPk($pemeriksaanlab_id);
          
          

          // var_dump($kode_unik); die;

          // var_dump($modPemeriksaan->attributes); die;
          $jenisPemeriksaan = JenispemeriksaanlabM::model()->findByPk($lab->jenispemeriksaanlab_id);
          $sample = SamplelabM::model()->findByPk($samplelab_id);
          $samplelab_id = '';
          $samplelab_nama = '';
          if (!empty($sample)) {
              $samplelab_id = $sample->samplelab_id;
              $samplelab_nama = $sample->samplelab_nama;
          }
          if (!empty($caraambilsampel_id)) {
              $caraAmbilSample = CaraambilsampelM::model()->findByAttributes(array('caraambilsampel_id' => $caraambilsampel_id));
              // var_dump($caraAmbilSample);die;
              $caraambilsampel_id = '';
              if (!empty($caraAmbilSample)) {
                  $caraambilsampel_id = $caraAmbilSample->caraambilsampel_id;
              }
          } else {
              $caraAmbilSample = null;
          }
          echo CJSON::encode(array(
              'status' => 'create_form',
              'caraambilsampel_id' => $caraambilsampel_id,
              'samplelab_id' => $samplelab_id,
              'form' => $this->renderPartial($this->path_view . '_formLoadSample', array(
                  'modPemeriksaan' => $modPemeriksaan,
                  'jenisPemeriksaan' => $jenisPemeriksaan,
                  'caraAmbilSample' => $caraAmbilSample,
                  'catatan' => $catatan,
                  'samplelab_id' => $samplelab_id,
                  'samplelab_nama' => $samplelab_nama,
                  'pemeriksaan_id' => $pemeriksaan_id
              ), true)
          ));
          exit;
      }
  }
}