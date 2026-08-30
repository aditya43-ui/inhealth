<?php
Yii::import('rawatJalan.models.*');
class LaboratoriumController extends MyAuthController
{
  public $layout = '//layouts/iframe';
  public $defaultAction = 'index';
  protected $updateDetailHasilPemeriksaan = false;
  protected $path_view_mcu = 'mcu.views.laboratorium.';
  public $hasilpemeriksaantersimpan = false;
  public $path_view_pk = 'rawatJalan.views.laboratorium.';
  public $path_view_pa = 'rawatJalan.views.laboratorium';
  public $path_view_mk = 'rawatJalan.views.laboratorium';

  /**
   * method untuk mengirimkan pasien mcu ke unit lain
   * digunakan di :
   * 1. mcu/laboratorium/index
   * @param int $pendaftaran_id pendaftaran_id
   */
  public function actionIndex($pendaftaran_id)
  {
    $params = array();
    $modPendaftaran = RJPendaftaranT::model()->with('jeniskasuspenyakit')->findByPk($pendaftaran_id);
    $modPasien = RJPasienM::model()->findByPk($modPendaftaran->pasien_id);
    $modKirimKeUnitLain = new RJPasienKirimKeUnitLainT;
    $modDetailHasilPemeriksaanLab = new MCDetailHasilPemeriksaanLabT();
    $modHasilPemeriksaan = new MCHasilPemeriksaanLabT();
    $modKirimKeUnitLain->tgl_kirimpasien = date('Y-m-d H:i:s');
    $modKirimKeUnitLain->pegawai_id = $modPendaftaran->pegawai_id;
    $modJenisPeriksaLab = RJJenisPemeriksaanLabM::model()->findAllByAttributes(array('jenispemeriksaanlab_aktif' => true), array('order' => 'jenispemeriksaanlab_urutan'));
    $modPeriksaLab = RJPemeriksaanLabM::model()->findAllByAttributes(array('pemeriksaanlab_aktif' => true), array('order' => 'pemeriksaanlab_id, pemeriksaanlab_urutan'));
    $modPermintaanMcu = MCPermintaanmcuT::model()->findAllByAttributes(array('pendaftaran_id' => $pendaftaran_id, 'ruangantujuan_id' => Params::RUANGAN_ID_LAB));

    if (isset($_GET['idPasienKirimKeUnitLain'])) {
      $modKirimKeUnitLain = RJPasienKirimKeUnitLainT::model()->findByPk($_GET['idPasienKirimKeUnitLain']);
    }

    if (!empty($pendaftaran_id)) {
      $loadModKunjungan = $this->loadModPasienMasukPenunjang($pendaftaran_id);
      if (isset($loadModKunjungan)) {
        $modKunjungan = $loadModKunjungan;
        $loadHasilPemeriksaan = MCHasilPemeriksaanLabT::model()->findByAttributes(array('pendaftaran_id' => $loadModKunjungan->pendaftaran_id));
        if (!empty($loadHasilPemeriksaan)) {
          //						if(strtolower(trim($loadHasilPemeriksaan->statusperiksahasil)) == strtolower(Params::STATUSPERIKSAHASIL_SUDAH)){
          //							Yii::app()->user->setFlash('warning', "Pasien dengan status sudah diperiksa tidak bisa merubah tindakan pemeriksaan !");
          //						}else{
          $modHasilPemeriksaan = $loadHasilPemeriksaan;
          $modDetailHasilPemeriksaanLab = MCDetailHasilPemeriksaanLabT::model()->findAllByAttributes(array('hasilpemeriksaanlab_id' => $loadHasilPemeriksaan->hasilpemeriksaanlab_id));
          //						}
        } else {
          Yii::app()->user->setFlash('warning', "Data Pemeriksaan Lab tidak ditemukan !");
        }
      } else {
        Yii::app()->user->setFlash('warning', "Data Kunjungan pasien ke Lab tidak ditemukan !");
      }
    }


    $modJenisTarif = JenistarifpenjaminM::model()->find('penjamin_id =' . $modPendaftaran->penjamin_id);
    //		LNG-990
    //		if(isset($_POST['MCDetailHasilPemeriksaanLabT'])) {
    //			$transaction = Yii::app()->db->beginTransaction();
    //			try {
    //				if(count((array)$_POST['MCDetailHasilPemeriksaanLabT']) > 0){
    //					foreach($_POST['MCDetailHasilPemeriksaanLabT'] as $i=>$detail){
    //						$modDetailHasilPemeriksaanLabs[$i] =  MCDetailHasilPemeriksaanLabT::model()->findByPk($detail['detailhasilpemeriksaanlab_id']);
    //						$modDetailHasilPemeriksaanLabs[$i]->hasil_laboratorium = $detail['hasil_laboratorium'];
    //						$modDetailHasilPemeriksaanLabs[$i]->hasilpemeriksaan = $detail['hasilpemeriksaan'];
    //						if($modDetailHasilPemeriksaanLabs[$i]->save()){
    //							$this->updateDetailHasilPemeriksaan = true;
    //						}
    //					}
    //				}
    //				
    //				if($this->updateDetailHasilPemeriksaan){
    //					$transaction->commit();
    //					Yii::app()->user->setFlash('success',"Data Berhasil disimpan");
    //					$this->redirect(array('index','pendaftaran_id'=>$pendaftaran_id,'sukses'=>1));
    //				} else {
    //					$transaction->rollback();
    //					Yii::app()->user->setFlash('error',"Data tidak valid ");
    //				}
    //			} catch (Exception $exc) {
    //				$transaction->rollback();
    //				Yii::app()->user->setFlash('error',"Data Gagal disimpan. ".MyExceptionMessage::getMessage($exc,true));
    //			}
    //		}

    if (!empty($pendaftaran_id) && (isset($_POST['MCHasilPemeriksaanLabT']))) {
      $transaction = Yii::app()->db->beginTransaction();
      try {
        if (!empty($modHasilPemeriksaan->hasilpemeriksaanlab_id)) {
          $modHasilPemeriksaan->attributes = $_POST['MCHasilPemeriksaanLabT'];
          $modHasilPemeriksaan->statusperiksahasil = Params::STATUSPERIKSAHASIL_SUDAH;
          $modHasilPemeriksaan->tglhasilpemeriksaanlab = MyFormatter::formatDateTimeForDb($_POST['MCHasilPemeriksaanLabT']['tglhasilpemeriksaanlab']);
          $modHasilPemeriksaan->tglpengambilanhasil = MyFormatter::formatDateTimeForDb($_POST['MCHasilPemeriksaanLabT']['tglpengambilanhasil']);
          $modHasilPemeriksaan->catatanlabklinik = (isset($_POST['MCHasilPemeriksaanLabT']['catatanlabklinik']) ? $_POST['MCHasilPemeriksaanLabT']['catatanlabklinik'] : null);
          $modHasilPemeriksaan->kesimpulan = (isset($_POST['MCHasilPemeriksaanLabT']['kesimpulan']) ? $_POST['MCHasilPemeriksaanLabT']['kesimpulan'] : null);
          $modHasilPemeriksaan->update_time = date('Y-m-d H:i:s');
          $modHasilPemeriksaan->update_loginpemakai_id = Yii::app()->user->id;
          if ($modHasilPemeriksaan->update()) {
            $this->hasilpemeriksaantersimpan = true;
          } else {
            $this->hasilpemeriksaantersimpan = false;
          }
        }
        if (isset($_POST['MCDetailHasilPemeriksaanLabT'])) {
          if (count((array)$_POST['MCDetailHasilPemeriksaanLabT']) > 0) {
            foreach ($_POST['MCDetailHasilPemeriksaanLabT'] as $i => $postDetail) {
              $dataDetails[$i] = $this->ubahDetailHasilPemeriksaanLab($postDetail);
            }
          }
        }

        // var_dump($this->hasilpemeriksaantersimpan); die;

        if ($this->hasilpemeriksaantersimpan) {
          $transaction->commit();
          $this->redirect(array('index', 'pendaftaran_id' => $modKunjungan->pendaftaran_id, 'sukses' => 1));
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data hasil pemeriksaan laboratorium gagal disimpan !");
        }
      } catch (Exception $exc) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data hasil pemeriksaan laboratorium gagal disimpan !" . " " . MyExceptionMessage::getMessage($exc, true));
      }
    }
    /**
     * Kriteria Pencarian Pasien Pemeriksaan Patologi Klinik 
     */
    $criRiwayatPK = new CDbCriteria();
    $criRiwayatPK->join = " JOIN ruangan_m r ON r.ruangan_id = t.ruangan_id "
      . "JOIN instalasi_m i ON i.instalasi_id = r.instalasi_id ";
    $criRiwayatPK->addCondition(" pendaftaran_id =" . $pendaftaran_id);
    $criRiwayatPK->addInCondition(" i.instalasi_id ", array(Params::INSTALASI_ID_LAB));
    $criRiwayatPK->addCondition(" r.ruangan_id = ". Params::INSTALASI_ID_LABPK);

    $modRiwayatKirimKeUnitLainPK = RJPasienKirimKeUnitLainT::model()->findAll($criRiwayatPK);

    /**
     * Kriteria Pencarian Pasien Pemeriksaan Patologi Anatomi
     */
    /*
            
            $criRiwayatPA = new CDbCriteria();
            $criRiwayatPA->join = " JOIN ruangan_m r ON r.ruangan_id = t.ruangan_id "
                    . "JOIN instalasi_m i ON i.instalasi_id = r.instalasi_id ";
            $criRiwayatPA->addCondition(" pendaftaran_id =".$pendaftaran_id);
            $criRiwayatPA->addCondition(" pasienmasukpenunjang_id IS NULL ");
            $criRiwayatPA->addInCondition(" i.instalasi_id ",Params::getInsPatologiAnatomi());
            $modRiwayatKirimKeUnitLainPA = RJPasienKirimKeUnitLainT::model()->findAll($criRiwayatPA);
            
            // Kriteria Pencarian Pasien Pemeriksaan Mikrobiologi Klinik 
            $criRiwayatMK = new CDbCriteria();
            $criRiwayatMK->join = " JOIN ruangan_m r ON r.ruangan_id = t.ruangan_id "
                    . "JOIN instalasi_m i ON i.instalasi_id = r.instalasi_id ";
            $criRiwayatMK->addCondition(" pendaftaran_id =".$pendaftaran_id);
            $criRiwayatMK->addCondition(" pasienmasukpenunjang_id IS NULL ");
            $criRiwayatMK->addInCondition(" i.instalasi_id ",Params::getInsMikrobiologiKlinik());
            $modRiwayatKirimKeUnitLainMK = RJPasienKirimKeUnitLainT::model()->findAll($criRiwayatMK);
             * 
             */

    $this->render($this->path_view_mcu . 'index', array(
      'modPendaftaran' => $modPendaftaran,
      'modPasien' => $modPasien,
      'modKirimKeUnitLain' => $modKirimKeUnitLain,
      'modJenisPeriksaLab' => $modJenisPeriksaLab,
      'modPeriksaLab' => $modPeriksaLab,
      'modJenisTarif' => $modJenisTarif,
      'modRiwayatKirimKeUnitLainPK' => $modRiwayatKirimKeUnitLainPK,
      //'modRiwayatKirimKeUnitLainPA'=>$modRiwayatKirimKeUnitLainPA,
      //'modRiwayatKirimKeUnitLainMK'=>$modRiwayatKirimKeUnitLainMK,
      'modPermintaanMcu' => $modPermintaanMcu,
      'modDetailHasilPemeriksaanLab' => $modDetailHasilPemeriksaanLab,
      'modHasilPemeriksaan' => $modHasilPemeriksaan
    ));
  }

  /**
   * @param type $pasienmasukpenunjang_id
   * @return LBPasienMasukPenunjangV
   */
  public function loadModPasienMasukPenunjang($pendaftaran_id)
  {
    $criteria = new CDbCriteria;
    $criteria->addCondition("pendaftaran_id = " . $pendaftaran_id);
    $model = MCPasienMasukPenunjangV::model()->find($criteria);
    return $model;
  }

  /**
   * method untuk menyimpan data pasien ke unit lain RJPasienKirimkeUnitLainT
   * digunakan di :
   * 1. rawatJalan/laboratorium/index
   * @param object $modPendaftaran model PendaftaranT
   * @return \RJPasienKirimKeUnitLainT 
   */
  protected function savePasienKirimKeUnitLain($modPendaftaran, $modPermintaanMcu, $ruangan_lab)
  {
    $modKirimKeUnitLain = new RJPasienKirimKeUnitLainT;
    $modKirimKeUnitLain->pasien_id = $modPendaftaran->pasien_id;
    $modKirimKeUnitLain->pendaftaran_id = $modPendaftaran->pendaftaran_id;
    $modKirimKeUnitLain->kelaspelayanan_id = $modPendaftaran->kelaspelayanan_id;

    $modKirimKeUnitLain->instalasi_id = Params::INSTALASI_ID_LAB;
    $modKirimKeUnitLain->ruangan_id = $ruangan_lab;
    $modKirimKeUnitLain->pegawai_id = $modPendaftaran->pegawai_id;
    $modKirimKeUnitLain->tgl_kirimpasien = date('Y-m-d H:i:s');
    $modKirimKeUnitLain->nourut = MyGenerator::noUrutPasienKirimKeUnitLain($modKirimKeUnitLain->ruangan_id);

    $modKirimKeUnitLain->create_loginpemakai_id = Yii::app()->user->id;
    $modKirimKeUnitLain->update_loginpemakai_id = Yii::app()->user->id;
    $modKirimKeUnitLain->create_ruangan = isset($_GET['ruangan_id']) ? $_GET['ruangan_id'] : Yii::app()->user->getState('ruangan_id');
    $modKirimKeUnitLain->create_time = date('Y-m-d H:i:s');
    $modKirimKeUnitLain->update_time = date('Y-m-d H:i:s');

    if ($modKirimKeUnitLain->validate()) {
      if ($modKirimKeUnitLain->save())
        $this->statusSaveKirimkeUnitLain = true;
    }
    return $modKirimKeUnitLain;
  }

  /**
   * method untuk menyimpan dan validasi permintaan penunjang
   * digunakan di :
   * 1. rawatJalan/laboratorium/index
   * @param array $permintaan berupa post request berisi data permintaan penunjang
   * @param object $modKirimKeUnitLain model PasienkirimkeunitlainT
   */
  protected function savePermintaanPenunjang($permintaan, $modKirimKeUnitLain)
  {
    foreach ($permintaan['inputpemeriksaanlab'] as $i => $value) {
      $modPermintaan = new RJPermintaanPenunjangT;
      $modPermintaan->daftartindakan_id = $value['daftartindakan_id'];
      $modPermintaan->pemeriksaanlab_id = $value['pemeriksaanlab_id'];
      $modPermintaan->pemeriksaanrad_id = '';
      $modPermintaan->pasienkirimkeunitlain_id = $modKirimKeUnitLain->pasienkirimkeunitlain_id;
      $modPermintaan->noperminatanpenujang = MyGenerator::noPermintaanPenunjang('PL');
      $modPermintaan->qtypermintaan = 1;
      $modPermintaan->tarif_pelayananan = $value['tarifpaketpel'];
      $modPermintaan->tglpermintaankepenunjang = MyFormatter::formatDateTimeForDb($modKirimKeUnitLain->tgl_kirimpasien);
      if ($modPermintaan->validate()) {
        if ($modPermintaan->save())
          $this->statusSavePermintaanPenunjang = true;
      }
    }
  }

  /**
   * simpan LBDetailHasilPemeriksaanLabT
   * @param type $post
   * @return type
   */
  public function ubahDetailHasilPemeriksaanLab($post)
  {
    $modDetailHasilPemeriksaans = MCDetailHasilPemeriksaanLabT::model()->findByPk($post['detailhasilpemeriksaanlab_id']);
    $modDetailHasilPemeriksaans->hasilpemeriksaan = $post['hasilpemeriksaan'];
    $modDetailHasilPemeriksaans->update_time = date("Y-m-d H:i:s");
    $modDetailHasilPemeriksaans->update_loginpemakai_id = Yii::app()->user->id;
    $modDetailHasilPemeriksaans->create_ruangan = Yii::app()->user->getState('ruangan_id');
    if ($modDetailHasilPemeriksaans->validate()) {
      $modDetailHasilPemeriksaans->update();
    } else {
      $this->hasilpemeriksaantersimpan &= false;
    }
    return $modDetailHasilPemeriksaans;
  }

  /**
   * set MCPermintaanmcuT yang sudah ada di database
   * @params pendaftaran_id
   */
  //	LNG-990
  //    public function actionSetPermintaanKeMcu(){
  //        if(Yii::app()->request->isAjaxRequest) {
  //            $format = new MyFormatter();
  //            $rows = "";
  //			$readonly = false;
  //			$pasienkirimkeunitlain_id = isset($_POST['pasienkirimkeunitlain_id']) ? $_POST['pasienkirimkeunitlain_id'] : null;
  //			if(!empty($pasienkirimkeunitlain_id)){
  //				$modKirimKeUnitLain = RJPasienKirimKeUnitLainT::model()->findByPk($pasienkirimkeunitlain_id);
  //			}else{
  //				$modKirimKeUnitLain = new RJPasienKirimKeUnitLainT();
  //			}
  //			$criteria = new CDbCriteria();
  //			$criteria->addCondition('pendaftaran_id = '.$_POST['pendaftaran_id']);
  //			$criteria->addInCondition('ruangantujuan_id',array(Params::RUANGAN_ID_LAB_KLINIK,  Params::RUANGAN_ID_LAB, Params::RUANGAN_ID_LAB_ANATOMI));
  //            $modPermintaans = MCPermintaanmcuT::model()->findAll($criteria);
  //			$modTindakanPelayanan = MCTindakanPelayananT::model()->findAllByAttributes(array('pendaftaran_id'=>$_POST['pendaftaran_id'],'create_ruangan'=>Params::RUANGAN_ID_KLINIK_MCU));
  //			$modDetailHasilPemeriksaan = new MCDetailHasilPemeriksaanLabT;
  //			$modPasienDirujukKeluar = MCPasiendirujukkeluarT::model()->findByAttributes(array('pendaftaran_id'=>$_POST['pendaftaran_id']));
  //			if(count((array)$modPasienDirujukKeluar) > 0){
  //				$readonly = true;
  //			}
  //            if(count((array)$modTindakanPelayanan) > 0){
  //                foreach($modTindakanPelayanan AS $i => $pemeriksaan){
  //					if($pemeriksaan->ruangan_id == Params::RUANGAN_ID_LAB_KLINIK || $pemeriksaan->ruangan_id == Params::RUANGAN_ID_LAB_ANATOMI || $pemeriksaan->ruangan_id == Params::RUANGAN_ID_LAB){
  //						$modDaftarTindakan = DaftartindakanM::model()->findByAttributes(array('daftartindakan_id'=>$pemeriksaan->daftartindakan_id));
  //						$modPemeriksaanLab = PemeriksaanlabM::model()->findByAttributes(array('daftartindakan_id'=>$pemeriksaan->daftartindakan_id));
  //						$criteria = new CDbCriteria();
  //						$criteria->join = "
  //										JOIN pemeriksaanlab_m ON pemeriksaanlab_m.pemeriksaanlab_id = t.pemeriksaanlab_id 
  //										JOIN pemeriksaanlabdet_m ON pemeriksaanlabdet_m.pemeriksaanlabdet_id = t.pemeriksaanlabdet_id 
  //										JOIN nilairujukan_m ON nilairujukan_m.nilairujukan_id = pemeriksaanlabdet_m.nilairujukan_id";
  //						$criteria->addCondition('t.tindakanpelayanan_id = '.$pemeriksaan->tindakanpelayanan_id);
  //						$criteria->order = "pemeriksaanlab_m.pemeriksaanlab_urutan ASC, pemeriksaanlabdet_m.pemeriksaanlabdet_nourut ASC";
  //						$modDetailHasilPemeriksaans = MCDetailHasilPemeriksaanLabT::model()->find($criteria);
  //						if(isset($modPemeriksaanLab)){
  //							$modJenisPemeriksaan = JenispemeriksaanlabM::model()->findByPk($modPemeriksaanLab->jenispemeriksaanlab_id);
  //							$modDetailHasilPemeriksaan->jenispemeriksaanlab_nama = $modJenisPemeriksaan->jenispemeriksaanlab_nama;
  //						}
  //						if(count((array)$modDetailHasilPemeriksaans) > 0){
  //							$modDetailHasilPemeriksaan->pemeriksaanlab_nama = $modDetailHasilPemeriksaans->pemeriksaanlab->pemeriksaanlab_nama;
  //							$modDetailHasilPemeriksaan->nilairujukan = $modDetailHasilPemeriksaans->nilairujukan;
  //							$modDetailHasilPemeriksaan->hasilpemeriksaan = $modDetailHasilPemeriksaans->hasilpemeriksaan;
  //							$modDetailHasilPemeriksaan->hasilpemeriksaan_satuan = $modDetailHasilPemeriksaans->hasilpemeriksaan_satuan;
  //							$modDetailHasilPemeriksaan->hasilpemeriksaan_metode = $modDetailHasilPemeriksaans->hasilpemeriksaan_metode;
  //							$modDetailHasilPemeriksaan->detailhasilpemeriksaanlab_id = $modDetailHasilPemeriksaans->detailhasilpemeriksaanlab_id;
  //							$modDetailHasilPemeriksaan->tindakanpelayanan_id = $modDetailHasilPemeriksaans->tindakanpelayanan_id;
  //							$modDetailHasilPemeriksaan->pemeriksaanlabdet_id = $modDetailHasilPemeriksaans->pemeriksaanlabdet_id;
  //							$modDetailHasilPemeriksaan->pemeriksaanlab_id = $modDetailHasilPemeriksaans->pemeriksaanlab_id;
  //							$modDetailHasilPemeriksaan->hasilpemeriksaanlab_id = $modDetailHasilPemeriksaans->hasilpemeriksaanlab_id;
  //							$modDetailHasilPemeriksaan->hasil_laboratorium = isset($modDetailHasilPemeriksaans->hasil_laboratorium) ? $modDetailHasilPemeriksaans->hasil_laboratorium : "";
  //							$rows .= $this->renderPartial($this->path_view_mcu."_rowLaboratorium",array('i'=>0,'modDetailHasilPemeriksaan'=>$modDetailHasilPemeriksaan,'modKirimKeUnitLain'=>$modKirimKeUnitLain,'modTindakanPelayanan'=>$modTindakanPelayanan,'readonly'=>$readonly), true);
  //						}						
  //					}
  //                }
  //            }
  //            echo CJSON::encode(array(
  //                    'rows'=>$rows));
  //        }
  //        Yii::app()->end();
  //    }

  /**
   * set form hasil pemeriksaan
   */
  public function actionSetFormHasilPemeriksaan()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $rows = "";
      //asumsi hasilpemeriksaanlab_t 1-1 pasienmasukpenunjang_t
      $modHasilPemeriksaan = MCHasilPemeriksaanLabT::model()->findByAttributes(array('pendaftaran_id' => $_POST['pendaftaran_id']));
      $hasilPemeriksaan = array();
      $attributes = $modHasilPemeriksaan->attributeNames();
      foreach ($attributes as $j => $attribute) {
        $hasilPemeriksaan["$attribute"] = $modHasilPemeriksaan->$attribute;
      }
      $hasilPemeriksaan['tglhasilpemeriksaanlab'] = date('d/m/Y H:i:s', strtotime($modHasilPemeriksaan->tglhasilpemeriksaanlab));
      $hasilPemeriksaan['tglpengambilanhasil'] = date('d/m/Y H:i:s', strtotime($modHasilPemeriksaan->tglpengambilanhasil));

      $modDetailHasilPemeriksaans = $this->loadDetailHasilPemeriksaans($modHasilPemeriksaan);
      $rows = $this->renderPartial($this->path_view_mcu . "_rowLaboratorium", array('modDetailHasilPemeriksaans' => $modDetailHasilPemeriksaans), true);
      echo CJSON::encode(array(
        'hasilPemeriksaan' => $hasilPemeriksaan,
        'rows' => $rows
      ));
    }
    Yii::app()->end();
  }

  /**
   * load LBDetailHasilPemeriksaanLabT
   * @param type $modHasilPemeriksaan
   */
  public function loadDetailHasilPemeriksaans($modHasilPemeriksaan)
  {
    $criteria = new CDbCriteria();
    $criteria->join = "
                        JOIN pemeriksaanlab_m ON pemeriksaanlab_m.pemeriksaanlab_id = t.pemeriksaanlab_id 
                        JOIN pemeriksaanlabdet_m ON pemeriksaanlabdet_m.pemeriksaanlabdet_id = t.pemeriksaanlabdet_id 
                        JOIN nilairujukan_m ON nilairujukan_m.nilairujukan_id = pemeriksaanlabdet_m.nilairujukan_id";
    $criteria->addCondition('t.hasilpemeriksaanlab_id = ' . $modHasilPemeriksaan->hasilpemeriksaanlab_id);
    $criteria->order = "pemeriksaanlab_m.pemeriksaanlab_urutan ASC, pemeriksaanlabdet_m.pemeriksaanlabdet_nourut ASC";
    $modDetailHasilPemeriksaans = MCDetailHasilPemeriksaanLabT::model()->findAll($criteria);
    return $modDetailHasilPemeriksaans;
  }

  public function actionMasterKeadaanUmum()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $criteria = new CDbCriteria;
      $criteria->compare('LOWER(keadaanumum_nama)', strtolower($_GET['tag']), true);
      $keluhans = KeadaanumumM::model()->findAll($criteria);
      $data = array();
      foreach ($keluhans as $i => $keluhan) {
        $data[$i] = array(
          'key' => $keluhan->keadaanumum_nama,
          'value' => $keluhan->keadaanumum_nama
        );
      }

      echo CJSON::encode($data);
    }
    Yii::app()->end();
  }

  /**
   * set form hasil pemeriksaan
   */
  public function actionPrint($pendaftaran_id, $caraPrint = null)
  {
    $this->layout = '//layouts/printWindows';
    $format = new MyFormatter();
    $judulLaporan = "Hasil Pemeriksaan Laboratorium";

    $modKunjungan = MCPasienMasukPenunjangV::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));
    $modHasilPemeriksaan = MCHasilPemeriksaanLabT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));
    $modDetailHasilPemeriksaans = $this->loadDetailHasilPemeriksaans($modHasilPemeriksaan);

    $this->render('printHasilPemeriksaan', array(
      'format' => $format,
      'modKunjungan' => $modKunjungan,
      'modHasilPemeriksaan' => $modHasilPemeriksaan,
      'modDetailHasilPemeriksaans' => $modDetailHasilPemeriksaans,
      'judulLaporan' => $judulLaporan,
      'caraPrint' => $caraPrint,
    ));
  }
}
