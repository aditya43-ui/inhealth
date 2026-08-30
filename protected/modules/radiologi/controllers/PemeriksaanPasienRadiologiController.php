<?php
Yii::import('radiologi.controllers.PendaftaranRadiologiController');
class PemeriksaanPasienRadiologiController extends PendaftaranRadiologiController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/column1';
  public $defaultAction = 'index';
  //    public $path_view = "radiologi.views.pemeriksaanPasienRadiologi."; << TIDAK DIGUNAKAN / INI AKAN BENTROK DENGAN YANG ADA DI PendaftaranRadiologiController
  public $path_view_pendaftaran = "radiologi.views.pendaftaranRadiologi.";
  public $simpanubahtarif = true;
  // public $simpanpemeriksaankeluar = true;

  /**
   * Tambah / Ubah Pemeriksaan Radiologi.
   */

  public function actionIndex($pasienmasukpenunjang_id = null)
  {
    $format = new MyFormatter();
    $modKunjungan = new ROPasienMasukPenunjangV;
    $modKunjungan->ruangan_id = Yii::app()->user->getState("ruangan_id");
    $modPasienMasukPenunjang = new ROPasienmasukpenunjangT;
    $modPemeriksaanRad = new ROTarifpemeriksaanradruanganV;
    $modTindakan = new ROTindakanpelayananT;
    $dataTindakans = array();

    $modRujukKeluar = new PemeriksaankeluarT();

    if (!empty($pasienmasukpenunjang_id)) {
      $loadModKunjungan = ROPasienMasukPenunjangV::model()->findByAttributes(array('pasienmasukpenunjang_id' => $pasienmasukpenunjang_id));
      if (isset($loadModKunjungan)) {
        $modKunjungan = $loadModKunjungan;
        $modPasienMasukPenunjang->attributes = $loadModKunjungan->attributes;
        $modPasienMasukPenunjang->pasienmasukpenunjang_id = $pasienmasukpenunjang_id;
        $modPasienMasukPenunjang->perawat_id = $modPasienMasukPenunjang->getPerawatId();
      }
    }

    if (isset($_POST['pasienmasukpenunjang_id'])) {
      $modKunjungan = ROPasienMasukPenunjangV::model()->findByAttributes(array('pasienmasukpenunjang_id' => $_POST['pasienmasukpenunjang_id']));
      $modPasienMasukPenunjang = ROPasienmasukpenunjangT::model()->findByPk($_POST['pasienmasukpenunjang_id']);
      $modPendaftaran = $modPasienMasukPenunjang->pendaftaran;
      $transaction = Yii::app()->db->beginTransaction();
      try {
        if (isset($_POST['ROPasienmasukpenunjangT'])) {
          $modPasienMasukPenunjang->pegawai_id = $_POST['ROPasienmasukpenunjangT']['pegawai_id'];
          $modPasienMasukPenunjang->perawat_id = $_POST['ROPasienmasukpenunjangT']['perawat_id'];
          $modPasienMasukPenunjang->dokterluar = !empty($_POST['ROPasienmasukpenunjangT']['dokterluar']) ? $_POST['ROPasienmasukpenunjangT']['dokterluar'] : null;
          $modPasienMasukPenunjang->ppds_id = !empty($_POST['ROPasienmasukpenunjangT']['ppds_id']) ? $_POST['ROPasienmasukpenunjangT']['ppds_id'] : null;
          $modPasienMasukPenunjang->save();
        }


        $md_noawal = TindakanpelayananT::model()->find("pendaftaran_id = $modPendaftaran->pendaftaran_id AND nopelayanan IS NOT NULL order by nopelayanan DESC");

        if(!empty($md_noawal)) {
          $noawal = intval($md_noawal->nopelayanan);
        } else {
          $noawal = 1;
        }

        $nopelayanan = str_pad($noawal+1,3,"0",STR_PAD_LEFT);

        //  var_dump($_POST['PemeriksaankeluarT']);die;
        if (isset($_POST['ROTindakanpelayananT'])) {
          if (count((array)$_POST['ROTindakanpelayananT']) > 0) {
            foreach ($_POST['ROTindakanpelayananT'] as $ii => $tindakan) {
              if (!empty($tindakan['tindakanpelayanan_id'])) {
                $dataTindakans[$ii] = ROTindakanpelayananT::model()->findByPk($tindakan['tindakanpelayanan_id']);
                $dataTindakans[$ii]->jeniskasuspenyakit_id = $modPasienMasukPenunjang->jeniskasuspenyakit_id;
                $dataTindakans[$ii]->qty_tindakan = $tindakan['qty_tindakan'];
                $dataTindakans[$ii]->tarif_tindakan = $dataTindakans[$ii]->qty_tindakan * $dataTindakans[$ii]->tarif_satuan;
                $dataTindakans[$ii]->perawat_id = (!empty($modPasienMasukPenunjang->perawat_id) ? $modPasienMasukPenunjang->perawat_id : null);
                $dataTindakans[$ii]->nopelayanan = !empty($dataTindakans[$ii]->nopelayanan) ? $dataTindakans[$ii]->nopelayanan : str_pad(1,3,"0",STR_PAD_LEFT);

                // var_dump($dataTindakans[$ii]->attributes); die;

                $dataTindakans[$ii]->update();
              } else {
                $dataTindakans[$ii] = $this->simpanTindakanPelayanan($modPendaftaran, $modPasienMasukPenunjang, $tindakan, $nopelayanan);
                $this->simpanHasilPemeriksaanRad($modPasienMasukPenunjang, $dataTindakans[$ii], $tindakan);
              }
              $dataTindakans[$ii]->pemeriksaanrad_id = $tindakan['pemeriksaanrad_id'];
              $dataTindakans[$ii]->jenistarif_id = $tindakan['jenistarif_id'];
              $dataTindakans[$ii]->tarif_tindakan = $format->formatNumberForUser($tindakan['tarif_tindakan']);

              /*
                            //var_dump($_POST['PemeriksaankeluarT']);die;
                           if (isset($_POST['PemeriksaankeluarT'])){
							   //var_dump($_POST['PemeriksaankeluarT']);die;
							   
							   foreach ($_POST['PemeriksaankeluarT'] as $iii => $val){
									if ($_POST['PemeriksaankeluarT'][$iii]){
									
										$cek = PemeriksaankeluarT::model()->findByPk($val['pemeriksaankeluar_id']);
										
										$konsys = KonfigsystemK::model()->find();
										
										if (count((array)$cek)>0){
											$tindakanpelayanan_id = $cek->tindakanpelayanan_id;
											$daftartindakan_id = $cek->daftartindakan_id;
										
											$cek->attributes = $_POST['PemeriksaankeluarT'][$iii];
											$pecah = explode('-',$cek->daftartindakan_id);
											$cek->tindakanpelayanan_id = $tindakanpelayanan_id;
											$cek->daftartindakan_id = $daftartindakan_id;
											//$cek->daftartindakan_id = $pecah[0];
											
											//if ($dataTindakans[$ii]->daftartindakan_id == $cek->daftartindakan_id){
												//$cek->tindakanpelayanan_id = $dataTindakans[$ii]->tindakanpelayanan_id;
											//} 
											$cek->pemeriksaankeluar_tgl = MyFormatter::formatDateTimeForDb($cek->pemeriksaankeluar_tgl);
											$cek->update_time = date("Y-m-d H:i:s");
											$cek->update_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
											$cek->labklinikrujukan_id = trim($cek->labklinikrujukan_id);
											
											if (empty($dataTindakans[$ii]->tindakansudahbayar_id)){
												$cek->persentasirujout = $konsys->persentasirujout;
											}
											
											$cek->save();
											
											$this->simpanpemeriksaankeluar = $this->simpanpemeriksaankeluar && $cek->save();
											
											if (!empty($cek->tindakanpelayanan_id)){
												$this->simpanUbahTarifRujukan($cek, $konsys->persentasirujout, $dataTindakans[$ii]);
											}
										}else{
											$rujuk = new PemeriksaankeluarT;
											$rujuk->attributes = $_POST['PemeriksaankeluarT'][$iii];                                        
											$pecah = explode('-',$rujuk->daftartindakan_id);
											
											$rujuk->daftartindakan_id = $pecah[0];
											//var_dump($rujuk->daftartindakan_id);
											if ($dataTindakans[$ii]->daftartindakan_id == $rujuk->daftartindakan_id){												
												$rujuk->tindakanpelayanan_id = $dataTindakans[$ii]->tindakanpelayanan_id;
											} 											
											$rujuk->pasienmasukpenunjang_id = $dataTindakans[$ii]->pasienmasukpenunjang_id;
											$rujuk->ruanganpengirim_id = Yii::app()->user->getState('ruangan_id');
											$rujuk->pemeriksaankeluar_tgl = MyFormatter::formatDateTimeForDb($rujuk->pemeriksaankeluar_tgl);
											$rujuk->create_time = date('Y-m-d H:i:s');
											$rujuk->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
											$rujuk->create_ruangan = Yii::app()->user->getState('ruangan_id');
											$rujuk->labklinikrujukan_id = trim($rujuk->labklinikrujukan_id);
											
											if (empty($dataTindakans[$ii]->tindakansudahbayar_id)){
												$rujuk->persentasirujout = $konsys->persentasirujout;
											}
											$this->simpanpemeriksaankeluar = $this->simpanpemeriksaankeluar && $rujuk->save();
											
											var_dump($rujuk->getErrors());
											
											if (!empty($cek->tindakanpelayanan_id)){
												$this->simpanUbahTarifRujukan($cek, $konsys->persentasirujout, $dataTindakans[$ii]);
											}
										}
									}
							   }
                               //var_dump($_POST['PemeriksaankeluarT']);die;
								/*if (isset($_POST['PemeriksaankeluarT']['daftartindakan_id'])){
                               foreach($_POST['PemeriksaankeluarT']['daftartindakan_id'] as $dt){                                   
                                    $rujuk = PemeriksaankeluarT::model()->findByAttributes(array('tindakanpelayanan_id'=>$dataTindakans[$ii]->tindakanpelayanan_id,'daftartindakan_id'=>$dt,'pasienmasukpenunjang_id'=>$dataTindakans[$ii]->pasienmasukpenunjang_id));
                                    if (!empty($rujuk)){                                   
                                        $rujuk->attributes = $_POST['PemeriksaankeluarT'];                                                                                
                                        if ($dataTindakans[$ii]->daftartindakan_id == $dt){
                                            $rujuk->tindakanpelayanan_id = $dataTindakans[$ii]->tindakanpelayanan_id;
                                        } 
                                        $rujuk->daftartindakan_id = $dt;
                                        $rujuk->pemeriksaankeluar_tgl = MyFormatter::formatDateTimeForDb($rujuk->pemeriksaankeluar_tgl);
                                        $rujuk->update_time = date('Y-m-d H:i:s');
                                        $rujuk->update_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');                                   
                                        $rujuk->save();
                                    }else{
                                        $rujuk = new PemeriksaankeluarT;
                                        $rujuk->attributes = $_POST['PemeriksaankeluarT'];                                        
                                        if ($dataTindakans[$ii]->daftartindakan_id == $dt){
                                            $rujuk->tindakanpelayanan_id = $dataTindakans[$ii]->tindakanpelayanan_id;
                                        } 
                                        $rujuk->daftartindakan_id = $dt;
                                        $rujuk->pasienmasukpenunjang_id = $dataTindakans[$ii]->pasienmasukpenunjang_id;
                                        $rujuk->ruanganpengirim_id = Yii::app()->user->getState('ruangan_id');
                                        $rujuk->pemeriksaankeluar_tgl = MyFormatter::formatDateTimeForDb($rujuk->pemeriksaankeluar_tgl);
                                        $rujuk->create_time = date('Y-m-d H:i:s');
                                        $rujuk->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
                                        $rujuk->create_ruangan = Yii::app()->user->getState('ruangan_id');
                                        $rujuk->save();
                                    }
                               }
                                 //   echo $dt.'<br/>';
                               }*/
              //die;

              //}
            }
          }
        }


        if ($this->tindakanpelayanantersimpan && $this->komponentindakantersimpan && $this->hasilpemeriksaantersimpan && $this->simpanubahtarif) {
          $transaction->commit();
          Yii::app()->user->setFlash('success', "Data pemeriksaan radiologi berhasil disimpan !");
          $this->redirect(array('index', 'pasienmasukpenunjang_id' => $modKunjungan->pasienmasukpenunjang_id, 'sukses' => 1));
        } else {

          $transaction->rollback();
          // echo "Kick"; die;
          Yii::app()->user->setFlash('error', "Data pemeriksaan radiologi gagal disimpan !");
          //                        echo "-".$this->tindakanpelayanantersimpan."<br>";
          //                        echo "-".$this->komponentindakantersimpan."<br>";
          //                        echo "-".$this->hasilpemeriksaantersimpan."<br>";
          //                        exit;
        }
      } catch (Exception $exc) {
        // var_dump($exc->getTraceAsString()); die;
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data pemeriksaan radiologi gagal disimpan !" . " " . MyExceptionMessage::getMessage($exc, true));
      }
    }

    $modKunjungan->tgl_pendaftaran = $format->formatDateTimeForUser($modKunjungan->tgl_pendaftaran);
    $modKunjungan->tanggal_lahir = $format->formatDateTimeForUser($modKunjungan->tanggal_lahir);

    $this->render('index', array(
      'modKunjungan' => $modKunjungan,
      'modPasienMasukPenunjang' => $modPasienMasukPenunjang,
      'modPemeriksaanRad' => $modPemeriksaanRad,
      'modTindakan' => $modTindakan,
      'dataTindakans' => $dataTindakans,
      'modRujukKeluar' => $modRujukKeluar
    ));
  }

  /**
   * untuk menampilkan data kunjungan dari autocomplete
   * - no_masukpenunjang
   * - no_pendaftaran
   * - no_rekam_medik
   * - nama_pasien
   */
  public function actionAutocompleteKunjungan()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter();
      $returnVal = array();
      $ruangan_id = isset($_GET['ruangan_id']) ? $_GET['ruangan_id'] : null;
      $no_masukpenunjang = isset($_GET['no_masukpenunjang']) ? $_GET['no_masukpenunjang'] : null;
      $no_pendaftaran = isset($_GET['no_pendaftaran']) ? $_GET['no_pendaftaran'] : null;
      $no_rekam_medik = isset($_GET['no_rekam_medik']) ? $_GET['no_rekam_medik'] : null;
      $nama_pasien = isset($_GET['nama_pasien']) ? $_GET['nama_pasien'] : null;
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(no_masukpenunjang)', strtolower($no_masukpenunjang), true);
      $criteria->compare('LOWER(no_pendaftaran)', strtolower($no_pendaftaran), true);
      $criteria->compare('LOWER(no_rekam_medik)', strtolower($no_rekam_medik), true);
      $criteria->compare('LOWER(nama_pasien)', strtolower($nama_pasien), true);
      $criteria->addCondition('ruangan_id = ' . $ruangan_id);
      $criteria->order = 'no_pendaftaran, no_masukpenunjang, no_rekam_medik, nama_pasien';
      $criteria->limit = 5;
      $models = ROPasienMasukPenunjangV::model()->findAll($criteria);

      $status = '';

      foreach ($models as $i => $model) {
        $criRad = new CDbCriteria();
        $criRad->addCondition(" pendaftaran_id = '" . $model->pendaftaran_id . "' AND pasienmasukpenunjang_id = '" . $model->pasienmasukpenunjang_id . "' ");
        $criRad->addCondition(" (statusperiksahasil = '" . Params::STATUSPERIKSAHASIL_BELUM . "') OR (statusperiksahasil IS NULL)  ");
        $rad = ROHasilpemeriksaanradT::model()->findAll($criRad);

        if (count((array)$rad) > 0) {
          $status =  "'" . Params::STATUSPERIKSAHASIL_BELUM . "'";
        } else {
          $status =  "'" . Params::STATUSPERIKSAHASIL_SUDAH . "'";
        }

        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = ($model->no_pendaftaran . "-" . $model->no_masukpenunjang . '-' . $model->no_rekam_medik . '-' . $model->nama_pasien . (!empty($model->nama_bin) ? "(" . $model->nama_bin . ")" : "")) . ' - ' . $status;
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  /**
   * Mengurai data kunjungan berdasarkan:
   * - pasienmasukpenunjang_id
   * @throws CHttpException
   */
  public function actionGetDataKunjungan()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter();
      $returnVal = array();
      $criteria = new CDbCriteria();
      $criteria->addCondition('pasienmasukpenunjang_id = ' . $_POST['pasienmasukpenunjang_id']);
      $criteria->addCondition('ruangan_id = ' . $_POST['ruangan_id']);
      $model = ROPasienMasukPenunjangV::model()->find($criteria);
      //  $returnVal["rujuk"]["labklinikrujukan_id"] = '';

      //  $rujukKeluar = PemeriksaankeluarT::model()->findAllByAttributes(array('pasienmasukpenunjang_id'=>$_POST['pasienmasukpenunjang_id']));

      $attributes = $model->attributeNames();
      foreach ($attributes as $j => $attribute) {
        $returnVal["$attribute"] = $model->$attribute;
      }
      $returnVal["tanggal_lahir"] = $format->formatDateTimeForUser($model->tanggal_lahir);
      $returnVal["tgl_pendaftaran"] = $format->formatDateTimeForUser($model->tgl_pendaftaran);
      $returnVal["perawat_id"] = $model->getPerawatId();
      $returnVal["statusperiksa"] = $model->StatusPeriksaDaftar;

      //  if (count((array)$rujukKeluar)>0){                
      //     foreach($rujukKeluar as $rujuk => $val){
      //        $returnVal["rujuk"]["labklinikrujukan_id"] = trim($val->labklinikrujukan_id);
      //        $returnVal["rujuk"]["pemeriksaankeluar_tgl"] = $val->pemeriksaankeluar_tgl;
      //        $returnVal["rujuk"]["pemeriksaankeluar_alasan"] = $val->pemeriksaankeluar_alasan;
      //        $returnVal["rujuk"]["pemeriksaankeluar_ket"] = $val->pemeriksaankeluar_ket;
      //        $returnVal["rujuk"]["dokterpengirim_id"] = $val->dokterpengirim_id;
      //        $returnVal["rujuk"]["daftartindakan_id"][] = $val->daftartindakan_id;
      //    }
      // }

      $rujukKeluar = PemeriksaankeluarT::model()->findAllByAttributes(array('pasienmasukpenunjang_id' => $_POST['pasienmasukpenunjang_id']));
      $tr = '';
      if (count((array)$rujukKeluar) > 0) {
        $i = 0;
        foreach ($rujukKeluar as $det) {
          $tr .= $this->renderPartial("_formGetRujukan", array('modRujukKeluar' => $det, 'i' => $i, 'modPasienMasukPenunjang' => $model), true);
          $i++;
        }
        $returnVal["rsrujukkeluar"] = 1;
        $returnVal["rujuk"] = $tr;
      } else {
        $returnVal["rsrujukkeluar"] = 0;
        $returnVal["rujuk"] = $tr;
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }
  /**
   * set ROTindakanpelayananT yang sudah ada di database
   * @params pasienmasukpenunjang_id
   */
  public function actionSetTindakanPelayanan()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter();
      $rows = "";
      $drop = '<option value="">-- Pilih --</option>';

      $returnVal["labklinikrujukan_id"] = '';
      $rujukKeluar = PemeriksaankeluarT::model()->findAllByAttributes(array('pasienmasukpenunjang_id' => $_POST['pasienmasukpenunjang_id']), array('order' => 'tindakanpelayanan_id ASC'));

      //$modTindakans = ROTindakanpelayananT::model()->findAllByAttributes(array('pasienmasukpenunjang_id'=>$_POST['pasienmasukpenunjang_id']), 'karcis_id IS NULL');
      $modTindakans = ROTindakanpelayananT::model()->findAll(" pasienmasukpenunjang_id = " . $_POST['pasienmasukpenunjang_id'] . " AND karcis_id IS NULL ORDER BY tindakanpelayanan_id ASC");
      if (count((array)$modTindakans) > 0) {
        foreach ($modTindakans as $i => $modTindakan) {

          $rujuk = PemeriksaankeluarT::model()->findByAttributes(array(
            'tindakanpelayanan_id' => $modTindakan->tindakanpelayanan_id,
          ));

          $pemeriksaanrad = PemeriksaanradM::model()->findByAttributes(array('daftartindakan_id' => $modTindakan->daftartindakan_id));

          if (!empty($pemeriksaanrad)) {
            $modTindakan->pemeriksaanrad_id = PemeriksaanradM::model()->findByAttributes(array('daftartindakan_id' => $modTindakan->daftartindakan_id))->pemeriksaanrad_id;
            $modTindakan->jenistarif_id = JenistarifpenjaminM::model()->findByAttributes(array('penjamin_id' => $modTindakan->pendaftaran->penjamin_id))->jenistarif_id;
            $modTindakan->tarif_tindakan = $format->formatNumberForUser($modTindakan->tarif_tindakan);
            $rows .= $this->renderPartial("_rowTindakanPemeriksaan", array('i' => 0, 'modTindakan' => $modTindakan, 'rujuk' => $rujuk), true);
          }
          if (empty($rujuk))
            $drop .= CHtml::tag('option', array('value' => $modTindakan->daftartindakan_id), CHtml::encode($modTindakan->daftartindakan->daftartindakan_nama), true);
        }
      }

      if (count((array)$rujukKeluar) > 0) {
        foreach ($rujukKeluar as $rujuk => $val) {
          $returnVal["labklinikrujukan_id"] = trim($val->labklinikrujukan_id);
          $returnVal["pemeriksaankeluar_tgl"] = MyFormatter::formatDateTimeForUser($val->pemeriksaankeluar_tgl);
          $returnVal["pemeriksaankeluar_alasan"] = $val->pemeriksaankeluar_alasan;
          $returnVal["pemeriksaankeluar_ket"] = $val->pemeriksaankeluar_ket;
          $returnVal["dokterpengirim_id"] = $val->dokterpengirim_id;
          $returnVal["daftartindakan_id"][] = $val->daftartindakan_id;
        }
      }


      echo CJSON::encode(array(
        'rows' => $rows,
        'drop' => $drop,
        'rujuk' => $returnVal
      ));
    }
    Yii::app()->end();
  }

  // Tabel untuk registrasi
  public function actionSetTindakanRegistrasi()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter();
      $rows = "";
      $drop = '<option value="">-- Pilih --</option>';

      $modTindakans = ROTindakanpelayananT::model()->findAllByAttributes(array('pasienmasukpenunjang_id' => $_POST['pasienmasukpenunjang_id']), 'karcis_id IS NOT NULL');
      if (count((array)$modTindakans) > 0) {
        foreach ($modTindakans as $i => $modTindakan) {

          $rujuk = PemeriksaankeluarT::model()->findByAttributes(array(
            'tindakanpelayanan_id' => $modTindakan->tindakanpelayanan_id,
          ));

          $pemeriksaan = KarcisM::model()->findByAttributes(array('daftartindakan_id' => $modTindakan->daftartindakan_id));
          // var_dump($pemeriksaan);die;

          if (!empty($pemeriksaan)) {
            // $modTindakan->pemeriksaanlab_id = KarcisM::model()->findByAttributes(array('daftartindakan_id' => $modTindakan->daftartindakan_id));
            // $modTindakan->jenistarif_id = JenistarifpenjaminM::model()->findByAttributes(array('penjamin_id' => $modTindakan->pendaftaran->penjamin_id))->jenistarif_id;
            $modTindakan->tarif_tindakan = $format->formatNumberForUser($modTindakan->tarif_tindakan);
            $modTindakan->tarif_satuan = $format->formatNumberForUser($modTindakan->tarif_satuan);

            $rows .= $this->renderPartial("_rowTindakanRegistrasi", array('i' => 0, 'modTindakan' => $modTindakan,'pemeriksaan'=>$pemeriksaan, 'rujuk' => $rujuk), true);
          }

          if (empty($rujuk))
            $drop .= CHtml::tag('option', array('value' => $modTindakan->daftartindakan_id), CHtml::encode($modTindakan->daftartindakan->daftartindakan_nama), true);
        }
      }
      echo CJSON::encode(array(
        'rows' => $rows,
        'drop' => $drop,
      ));
    }
    Yii::app()->end();
  }
  /**
   * hapus ROTindakanpelayananT yang sudah ada di database
   * @params pasienmasukpenunjang_id
   * @params daftartindakan_id
   */
  public function actionHapusTindakanPelayanan()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $data['pesan'] = "";
      $data['sukses'] = 0;
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $modTindakan = ROTindakanpelayananT::model()->findByAttributes(array('pasienmasukpenunjang_id' => $_POST['pasienmasukpenunjang_id'], 'daftartindakan_id' => $_POST['daftartindakan_id']));
        $modTindakan->hasilpemeriksaanrad_id = null;
        $modTindakan->update();
        $hapusTindakanKomponen = TindakankomponenT::model()->deleteAllByAttributes(array('tindakanpelayanan_id' => $modTindakan->tindakanpelayanan_id));
        $modHasilPemeriksaans = HasilpemeriksaanradT::model()->findAllByAttributes(array('tindakanpelayanan_id' => $modTindakan->tindakanpelayanan_id));
        $hapusDetailHasilPemeriksaan = false;
        if (count((array)$modHasilPemeriksaans) > 0) {
          $hapusDetailHasilPemeriksaan = true;
          foreach ($modHasilPemeriksaans as $i => $hasil) {
            //RND-8272
            $dataBroker = $hasil->getDataBroker();
            if (!empty($dataBroker)) {
              CustomFunction::postHL7Broker("DEL", $dataBroker);
            }
            $hapusDetailHasilPemeriksaan &= $hasil->delete();
          }
        }
        $cekTindakan = TindakanpelayananT::model()->findByPk($modTindakan->tindakanpelayanan_id);
        if ($cekTindakan->tindakansudahbayar_id) {
          $hapusTindakan = false;
        } else {
          $hapusTindakan = TindakanpelayananT::model()->deleteByPk($modTindakan->tindakanpelayanan_id);
        }
        if ($hapusTindakan) {
          $transaction->commit();
          $data['pesan'] = "Tindakan berhasil dihapus!";
          $data['sukses'] = 1;
        } else {
          $transaction->rollback();
          if (!$hapusDetailHasilPemeriksaan)
            $data['pesan'] = "Detail Hasil Pemeriksaan gagal dihapus!";
          if (!$hapusTindakanKomponen)
            $data['pesan'] = "Tindakan komponen gagal dihapus!";
          if (!$hapusTindakan)
            $data['pesan'] = "Tindakan pelayanan gagal dihapus karena sudah dibayarkan!";
          $data['sukses'] = 0;
        }
      } catch (Exception $exc) {
        $transaction->rollback();
        $data['pesan'] = "Tindakan gagal dihapus! :" . MyExceptionMessage::getMessage($exc, true);
      }
      echo CJSON::encode($data);
    }
    Yii::app()->end();
  }

  /**
   * - digunakan untuk mencetak data
   * @param type $pasienmasukpenunjang_id
   */
  public function actionPrintPermintaan($pasienmasukpenunjang_id)
  {
    $this->layout = '//layouts/printWindows';

    $judulLaporan = "";

    $modKunjungan = ROPasienMasukPenunjangV::model()->findByAttributes(array('pasienmasukpenunjang_id' => $pasienmasukpenunjang_id));
    $modPeriksa = ROTindakanpelayananT::model()->findAllByAttributes(array('pasienmasukpenunjang_id' => $pasienmasukpenunjang_id));
    $modKeluar = PemeriksaankeluarT::model()->findAllByAttributes(array('pasienmasukpenunjang_id' => $pasienmasukpenunjang_id));
    $modPemeriksaan = ROPermintaanKePenunjangT::model()->with('daftartindakan', 'pemeriksaanrad')->findAllByAttributes(array('pasienkirimkeunitlain_id' => $modKunjungan->pasienkirimkeunitlain_id));

    $this->render('printPemeriksaan', array(
      'modKunjungan' => $modKunjungan,
      'modPeriksa' => $modPeriksa,
      'modKeluar' => $modKeluar,
      'judulLaporan' => $judulLaporan,
      'modPemeriksaan' => $modPemeriksaan,
    ));
  }

  /**
   * - digunakan untuk menghapus data  rujukan keluar
   */
  public function actionAjaxDeleteRujukanKeluar()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $pengambilansample_id = $_POST['id'];
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $modKirimSample = LBKirimSampleLabT::model()->findByAttributes(
          array(
            'pengambilansample_id' => $pengambilansample_id
          )
        );
        $data['success'] = true;
        if (!empty($modKirimSample)) {
          LBPengambilanSampleT::model()->updateByPk($pengambilansample_id, array('kirimsamplelab_id' => null));
          $deleteKirimSample = LBKirimSampleLabT::model()->deleteAllByAttributes(
            array(
              'pengambilansample_id' => $pengambilansample_id
            )
          );

          $deletePengambilanSample = LBPengambilanSampleT::model()->deleteByPk($pengambilansample_id);
          if (!$deleteKirimSample) {
            $data['success'] = false;
          }
        } else {
          $deletePengambilanSample = LBPengambilanSampleT::model()->deleteByPk($pengambilansample_id);
        }

        if ($deletePengambilanSample && $data['success']) {
          $data['success'] = true;
          $transaction->commit();
        } else {
          $data['success'] = false;
          $transaction->rollback();
        }
      } catch (Exception $exc) {
        $transaction->rollback();
        echo MyExceptionMessage::getMessage($exc, true);
        $data['success'] = false;
      }

      echo json_encode($data);
      Yii::app()->end();
    }
  }

  /**
   * - digunakan untuk menambahkan data dari dialog box pencarian tindakan ke tabel
   * @author M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
   * @website <piindonesia.co.id>
   */
  public function actionAddTindakanPilihan()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $id = isset($_POST['id']) ? $_POST['id'] : null;
      $pemeriksaanrad_id = isset($_POST['pemeriksaanrad_id']) ? $_POST['pemeriksaanrad_id'] : null;
      $ruangan_id = isset($_POST['ruangan_id']) ? $_POST['ruangan_id'] : null;
      $penjamin_id = isset($_POST['penjamin_id']) ? $_POST['penjamin_id'] : null;
      $kelaspelayanan_id = Params::KELASPELAYANAN_ID_TANPA_KELAS;; //isset($_POST['kelaspelayanan_id'])?$_POST['kelaspelayanan_id']:null;
      $pasienmasukpenunjang_id = isset($_POST['pasienmasukpenunjang_id']) ? $_POST['pasienmasukpenunjang_id'] : null;
      $ada = '';
      $data['pesan'] = '';

      $pemeriksaan = ROTarifpemeriksaanradruanganV::model()->findAllByAttributes(array(
        'pemeriksaanrad_id' => $pemeriksaanrad_id,
        'ruangan_id' => $ruangan_id,
        'penjamin_id' => $penjamin_id,
        'kelaspelayanan_id' => $kelaspelayanan_id,
      ));

      $cekAda = ROTindakanpelayananT::model()->findAllByAttributes(array(
        'pemeriksaanrad_id' => $pemeriksaanrad_id,
        'ruangan_id' => $ruangan_id,
        'penjamin_id' => $penjamin_id,
        'kelaspelayanan_id' => $kelaspelayanan_id,
        'pasienmasukpenunjang_id' => $pasienmasukpenunjang_id
      ));

      if (count((array)$cekAda) > 0) {
        $data['sukses'] = 1;
        foreach ($cekAda as $dt) {
          $pemeriksaanrad = PemeriksaanradM::model()->findByPk($dt->pemeriksaanrad_id);
          $ada .= $pemeriksaanrad->pemeriksaanrad_nama . ', ';
        }
      }

      $str = "";
      $tindakan = new ROTindakanpelayananT;
      $drop = '';
      foreach ($pemeriksaan as $item) {
        $tindakan->daftartindakan_id = $item->daftartindakan_id;
        $tindakan->pemeriksaanrad_id = $item->pemeriksaanrad_id;
        $tindakan->jenistarif_id = $item->jenistarif_id;
        $tindakan->qty_tindakan = 1;
        $tindakan->satuantindakan = Params::SATUAN_TINDAKAN_LABORATORIUM;
        $tindakan->tarif_satuan = $item->harga_tariftindakan;
        $tindakan->tarif_tindakan = number_format($item->harga_tariftindakan * $tindakan->qty_tindakan, 0, "", ",");

        $str .= $this->renderPartial("_rowTindakanPemeriksaanV2", array('i' => 0, 'modTindakan' => $tindakan, 'item' => $item), true);
        $drop .= CHtml::tag('option', array('value' => $item->daftartindakan_id), CHtml::encode($item->pemeriksaanrad_nama), true);
      }

      $data['row'] = $str;
      $data['ada'] = $ada;
      $data['drop'] = $drop;

      echo json_encode($data);
    }
    Yii::app()->end();
  }


  public function simpanUbahTarifRujukan($modPeriksaKeluar, $persen, $modTindakanPelayanan)
  {


    $tinPel  = ROTindakanpelayananT::model()->findByPk($modPeriksaKeluar->tindakanpelayanan_id);

    $pemeriksaan = ROTarifpemeriksaanradruanganV::model()->findByAttributes(array(
      'daftartindakan_id' => $modTindakanPelayanan->daftartindakan_id,
      'ruangan_id' => $modTindakanPelayanan->ruangan_id,
      'penjamin_id' => $modTindakanPelayanan->penjamin_id,
      'kelaspelayanan_id' => $modTindakanPelayanan->kelaspelayanan_id,
    ));

    $persenRuj = $persen;
    $tambahan = $pemeriksaan->harga_tariftindakan * ($persenRuj / 100);

    $tinPel->tarif_satuan = $pemeriksaan->harga_tariftindakan  + $tambahan;
    $tinPel->tarif_tindakan = $tinPel->tarif_satuan  * $tinPel->qty_tindakan;
    $tinPel->update_time = date('Y-m-d H:i:s');
    $tinPel->update_loginpemakai_id = Yii::app()->user->getState('ruangan_id');
    //$tinPel->cyto_tindakan = false;

    $this->simpanubahtarif = $this->simpanubahtarif && $tinPel->update();


    $tinkomponen = TindakankomponenT::model()->findByAttributes(array('tindakanpelayanan_id' => $tinPel->tindakanpelayanan_id, 'komponentarif_id' => Params::KOMPONENTARIF_ID_JASA_RUMAH_SAKIT));


    $tarifKomp = TariftindakanruangandetailV::model()->findByAttributes(array(
      'daftartindakan_id' => $modTindakanPelayanan->daftartindakan_id,
      'ruangan_id' => $modTindakanPelayanan->ruangan_id,
      'jenistarif_id' => $modTindakanPelayanan->jenistarif_id,
      'kelaspelayanan_id' => $modTindakanPelayanan->kelaspelayanan_id,
      'komponentarif_id' => Params::KOMPONENTARIF_ID_JASA_RUMAH_SAKIT
    ));

    $tinkomponen->tarif_kompsatuan = $tarifKomp->harga_tariftindakan + $tambahan;
    $tinkomponen->tarif_tindakankomp = $tinkomponen->tarif_kompsatuan * $tinPel->qty_tindakan;
    if ($modTindakanPelayanan->carabayar->issubsidiasuransi == true) {
      $tinkomponen->subsidiasuransikomp = $tinkomponen->tarif_kompsatuan * $tinPel->qty_tindakan;
    } elseif ($modTindakanPelayanan->carabayar->issubsidipemerintah == true) {
      $tinkomponen->subsidipemerintahkomp = $tinkomponen->tarif_kompsatuan * $tinPel->qty_tindakan;
    } elseif ($modTindakanPelayanan->carabayar->issubsidirs == true) {
      $tinkomponen->subsidirumahsakitkomp = $tinkomponen->tarif_kompsatuan * $tinPel->qty_tindakan;
    }

    //var_dump($tinkomponen->getErrors());die;
    //var_dump($tinkomponen->subsidirumahsakitkomp);die;

    $this->simpanubahtarif = $this->simpanubahtarif && $tinkomponen->save();
  }

  public function actionDetailRujukan($id)
  {
    $this->layout = '//layouts/iframeNeon';

    $model = PemeriksaankeluarT::model()->findByPk($id);
    $penunjang = PasienmasukpenunjangV::model()->findByAttributes(array(
      'pasienmasukpenunjang_id' => $model->pasienmasukpenunjang_id
    ));
    $tindakan = TindakanpelayananT::model()->findByPk($model->tindakanpelayanan_id);

    $this->render('_detailRujukPenunjang', array(
      'model' => $model,
      'penunjang' => $penunjang,
      'tindakan' => $tindakan,
    ));
  }

  public function actionBatalRujukKeluar()
  {
    if (!Yii::app()->request->isAjaxRequest) {
      Yii::app()->end();
    }

    $data = array(
      'ok' => 1,
      'msg' => '',
    );

    $this->tindakanpelayanantersimpan = true;
    $trans = Yii::app()->db->beginTransaction();


    try {
      $model = PemeriksaankeluarT::model()->findByPk($_POST['id']);
      $tindakan = TindakanpelayananT::model()->findByPk($model->tindakanpelayanan_id);

      TindakankomponenT::model()->deleteAllByAttributes(array(
        'tindakanpelayanan_id' => $tindakan->tindakanpelayanan_id,
        'komponentarif_id' => array(Params::KOMPONENTARIF_ID_JASA_SOPIR, Params::KOMPONENTARIF_ID_JASA_PARAMEDIS),
      ));

      $tindakan->perawat_id = $tindakan->supir_id = null;
      $tindakan->update(array('perawat_id', 'supir_id'));

      $tindakan = $this->updateTotalTarifTindakan($tindakan);


      PemeriksaankeluarT::model()->deleteByPk($model->pemeriksaankeluar_id);

      if ($this->tindakanpelayanantersimpan) {
        $trans->commit();
      } else {
        $trans->rollback();
        $data['ok'] = 0;
        $data['msg'] = "";
      }
    } catch (CException $e) {
      $trans->rollback();
      $data['ok'] = 0;
      $data['msg'] = $e->message;
    }


    echo CJSON::encode($data);
  }

  public function actionSetFormRujukan()
  {
    if (!Yii::app()->request->isAjaxRequest) {
      Yii::app()->end();
    }

    $tindakan = TindakanpelayananT::model()->findByPk($_POST['id']);
    $daftar = DaftartindakanM::model()->findByPk($tindakan->daftartindakan_id);
    $penunjang = PasienmasukpenunjangV::model()->findByAttributes(array(
      'pasienmasukpenunjang_id' => $tindakan->pasienmasukpenunjang_id,
    ));

    $res = $penunjang->attributes;
    $res['daftartindakan'] = $daftar->attributes;
    $res['tindakanpelayanan_id'] = $tindakan->tindakanpelayanan_id;
    $res['daftartindakan_id'] = $tindakan->daftartindakan_id;
    $res['daftartindakan_nama'] = $daftar->daftartindakan_nama;

    echo CJSON::encode($res);
  }


  public function actionSimpanRujukanKeluar()
  {
    if (!Yii::app()->request->isAjaxRequest) {
      Yii::app()->end();
    }

    $modPasienMasukPenunjang = PasienmasukpenunjangT::model()->findByPk($_POST['PemeriksaankeluarT'][0]['pasienmasukpenunjang_id']);
    $dataTindakan = TindakanpelayananT::model()->findByPk($_POST['PemeriksaankeluarT'][0]['tindakanpelayanan_id']);
    $trans = Yii::app()->db->beginTransaction();
    $this->tindakanpelayanantersimpan = true;

    $data = array(
      'ok' => 1,
      'msg' => '',
    );

    try {

      $this->simpanPemeriksaanKeluar($_POST['PemeriksaankeluarT'], $modPasienMasukPenunjang, $dataTindakan);

      if ($this->tindakanpelayanantersimpan) {
        $trans->commit();
      } else {
        $trans->rollback();
        $data['ok'] = 0;
        $data['msg'] = "";
      }
    } catch (CException $e) {
      $trans->rollback();
      $data['ok'] = 0;
      $data['msg'] = $e->getMessage();
    }



    echo CJSON::encode($data);
  }


  public function simpanPemeriksaanKeluar($post, $modPasienMasukPenunjang, $modTindakan)
  {

    // var_dump($this->tindakanpelayanantersimpan);

    foreach ($post as $item) {
      // $model = PemeriksaankeluarT::model()->findByPk($item['pemeriksaankeluar_id']);
      // if (empty($model)) {
      $model = new PemeriksaankeluarT;
      // }

      // $modTindakan = null;


      $model->attributes = $item;
      $model->pemeriksaankeluar_tgl = MyFormatter::formatDateTimeForDb($model->pemeriksaankeluar_tgl);
      $model->ruanganpengirim_id = $modPasienMasukPenunjang->ruangan_id;
      $model->pasienmasukpenunjang_id = $modPasienMasukPenunjang->pasienmasukpenunjang_id;
      $model->daftartindakan_id = $modTindakan->daftartindakan_id;

      if (trim($model->pemeriksaankeluar_ket) == "") {
        $model->pemeriksaankeluar_ket = "-";
      }


      $supir_id = $model->supir_id;
      $perawat_id = $model->perawat_id;

      /*
            foreach($dataTindakans as $tindakan) {
                if ($tindakan->daftartindakan_id == $item['daftartindakan_id']) {
                    $modTindakan = $tindakan; 
                    $model->tindakanpelayanan_id = $tindakan->tindakanpelayanan_id;
                    break;
                }
            }
             * 
             */

      if ($model->validate() || $model->validate()) {
        $this->tindakanpelayanantersimpan = $this->tindakanpelayanantersimpan && $model->save();

        // var_dump($supir_id, $perawat_id); die;

        $modTindakan->supir_id = $supir_id;
        $modTindakan->perawat_id = $perawat_id;
        $modTindakan->tarif_tindakan = $modTindakan->tarif_satuan * $modTindakan->qty_tindakan;
        $modTindakan->update(array('supir_id', 'perawat_id', 'tarif_tindakan'));
      } else {
        $this->tindakanpelayanantersimpan = false;
        // var_dump($model->errors); die;
      }

      $this->simpankomponensupirperawat($modTindakan, Params::KOMPONENTARIF_ID_JASA_SOPIR, 4830);
      $this->simpankomponensupirperawat($modTindakan, Params::KOMPONENTARIF_ID_JASA_PARAMEDIS, 4025);

      // var_dump($this->tindakanpelayanantersimpan);

      $modTindakan = $this->updateTotalTarifTindakan($modTindakan);

      // var_dump($this->tindakanpelayanantersimpan);
      // var_dump($modTindakan->attributes, $this->tindakanpelayanantersimpan, $model->attributes, $item);

      // die;
    }
  }

  protected function simpankomponensupirperawat($tindakan, $komponentarif_id, $tarif)
  {
    $kom = TindakankomponenT::model()->findByAttributes(array(
      'tindakanpelayanan_id' => $tindakan->tindakanpelayanan_id,
      'komponentarif_id' => $komponentarif_id,
    ));

    $ok = true;

    if (!empty($kom)) {
      $base_tarif = $kom->tarif_kompsatuan * $tindakan->qty_tindakan;
      $selisih = $tarif - $kom->tarif_kompsatuan;
      $kom->tarif_kompsatuan += $selisih;
      $kom->tarif_tindakankomp += $selisih * $tindakan->qty_tindakan;
      $kom->subsidiasuransikomp += ($selisih * $tindakan->qty_tindakan) * $kom->subsidiasuransikomp / $base_tarif;
      $kom->subsidipemerintahkomp += ($selisih * $tindakan->qty_tindakan) * $kom->subsidipemerintahkomp / $base_tarif;
      $kom->subsidirumahsakitkomp += ($selisih * $tindakan->qty_tindakan) * $kom->subsidirumahsakitkomp / $base_tarif;
      $kom->iurbiayakomp += ($selisih * $tindakan->qty_tindakan) * $kom->iurbiayakomp / $base_tarif;
      $ok = $ok && $kom->save();
    } else {
      $kom = new TindakankomponenT;
      $kom->tindakanpelayanan_id = $tindakan->tindakanpelayanan_id;
      $kom->komponentarif_id = $komponentarif_id;
      $kom->tarif_kompsatuan = $tarif;
      $kom->tarif_tindakankomp = $tarif * $tindakan->qty_tindakan;
      $kom->tarifcyto_tindakankomp = 0;
      $kom->subsidiasuransikomp = 0;
      $kom->subsidipemerintahkomp = 0;
      $kom->subsidirumahsakitkomp = 0;
      $kom->iurbiayakomp = $kom->tarif_tindakankomp;
      $ok = $ok && $kom->save();
    }

    $this->tindakanpelayanantersimpan = $this->tindakanpelayanantersimpan && $ok;

    // var_dump($ok, $kom->attributes);


    // die;
  }

  protected function updateTotalTarifTindakan($tindakan)
  {
    $kom = TindakankomponenT::model()->findAllByAttributes(array(
      'tindakanpelayanan_id' => $tindakan->tindakanpelayanan_id,
    ), array(
      'condition' => 'komponentarif_id <> 6',
    ));

    $total_satuan = 0;
    $total_tarif = 0;
    $total_medis = 0;
    $total_paramedis = 0;
    $total_akomodasi = 0;
    $total_bhp = 0;

    foreach ($kom as $item) {
      $gr = PersenkelkomponentarifM::model()->findByAttributes(array(
        'komponentarif_id' => $item->komponentarif_id,
      ));

      $total_satuan += $item->tarif_kompsatuan;
      $total_tarif += $item->tarif_tindakankomp;

      if ($gr->kelompokkomponentarif_id == Params::KELOMPOKKOMPONENTARIF_ID_MEDIS)
        $total_medis += $item->tarif_tindakankomp;
      else if ($gr->kelompokkomponentarif_id == Params::KELOMPOKKOMPONENTARIF_ID_PARAMEDIS)
        $total_paramedis += $item->tarif_tindakankomp;
      else if ($gr->kelompokkomponentarif_id == Params::KELOMPOKKOMPONENTARIF_ID_BHP)
        $total_bhp += $item->tarif_tindakankomp;
      else $total_akomodasi += $item->tarif_tindakankomp;


      // var_dump($item->attributes);
    }

    $base_satuan = $tindakan->tarif_tindakan;

    $tindakan->tarif_satuan = $total_satuan;
    $tindakan->tarif_tindakan = $tindakan->tarif_satuan * $tindakan->qty_tindakan;

    $tindakan->tarif_medis = $total_medis;
    $tindakan->tarif_paramedis = $total_paramedis;
    $tindakan->tarif_rsakomodasi = $total_akomodasi;
    $tindakan->tarif_bhp = $total_bhp;

    $tindakan->subsidiasuransi_tindakan = $tindakan->tarif_tindakan * $tindakan->subsidiasuransi_tindakan / $base_satuan;
    $tindakan->subsidipemerintah_tindakan = $tindakan->tarif_tindakan * $tindakan->subsidipemerintah_tindakan / $base_satuan;
    $tindakan->subsisidirumahsakit_tindakan = $tindakan->tarif_tindakan * $tindakan->subsisidirumahsakit_tindakan / $base_satuan;
    $tindakan->iurbiaya_tindakan = $tindakan->tarif_tindakan * $tindakan->iurbiaya_tindakan / $base_satuan;

    $this->tindakanpelayanantersimpan = $this->tindakanpelayanantersimpan && $tindakan->update(array(
      "tarif_satuan", "tarif_tindakan", "tarif_medis", "tarif_paramedis", "tarif_rsakomodasi", "tarif_bhp",
      "subsidiasuransi_tindakan", "subsidipemerintah_tindakan", "subsisidirumahsakit_tindakan", "iurbiaya_tindakan"
    ));

    // var_dump($this->tindakanpelayanantersimpan, $tindakan->attributes); die;

    return $tindakan;
  }

  public function actionLoadReturTindakan()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $tindakanpelayanan_id = $_GET['tindakanpelayanan_id'];
      $tindakansudahbayar_id = $_GET['tindakansudahbayar_id'];
      $form = "";
      $pesan = "";
      $issudahretur = false;

      $crt_tindakan = new CDbCriteria();
      $crt_tindakan->addCondition('t.tindakanpelayanan_id = ' . $tindakanpelayanan_id);
      $crt_tindakan->addCondition('t.tindakansudahbayar_id = ' . $tindakansudahbayar_id);
      $crt_tindakan->addCondition('pembebasantarif_t.tindakanpelayanan_id IS NOT NULL');
      $crt_tindakan->join = 'LEFT JOIN pembebasantarif_t on pembebasantarif_t.tindakanpelayanan_id = t.tindakanpelayanan_id';
      $modTindakanPembebasan = TindakanpelayananT::model()->findAll($crt_tindakan);

      if(empty($modTindakanPembebasan)){
        $cekpembebasan = 0;
        $komponentarif_id = array(Params::KOMPONENTARIF_ID_TOTAL);

        $criteria = new CDbCriteria();
        $criteria->addCondition('tindakanpelayanan_id = ' . $tindakanpelayanan_id);
        $criteria->addNotInCondition('komponentarif_id', $komponentarif_id);
        $komponens = TindakankomponenT::model()->findAll($criteria);

        if(!empty($komponens)){
          foreach ($komponens as $j => $komponen) {
            $tindKomponenId = $komponen->tindakankomponen_id;
            $jmlpembebasan = 0;
            $pembebasantarif_id = null;

            $pembebasan = PembebasantarifT::model()->findByAttributes(array('tindakansudahbayar_id'=>$tindakansudahbayar_id, 'komponentarif_id'=>$komponen->komponentarif_id));
            
            if(!empty($pembebasan)){
              $jmlpembebasan = $pembebasan->jmlpembebasan;
              $pembebasantarif_id = $pembebasan->pembebasantarif_id;
              $cekpembebasan += 1;
            }else{
              if($cekpembebasan > 0){
                $cekpembebasan -= 1;
              }
            }
              
            $returnVal[$tindKomponenId]['tindakankomponen_id'] = $tindKomponenId;
            $returnVal[$tindKomponenId]['tindakanpelayanan_id'] = $komponen->tindakanpelayanan_id;
            $returnVal[$tindKomponenId]['tindakansudahbayar_id'] = $tindakansudahbayar_id;
            $returnVal[$tindKomponenId]['komponentarif_id'] = $komponen->komponentarif_id;
            $returnVal[$tindKomponenId]['komponentarif_nama'] = $komponen->komponentarif->komponentarif_nama;
            $returnVal[$tindKomponenId]['tarif_kompsatuan'] = $komponen->tarif_kompsatuan;
            $returnVal[$tindKomponenId]['tarif_tindakankomp'] = $komponen->tarif_tindakankomp;
            $returnVal[$tindKomponenId]['tarifcyto_tindakankomp'] = $komponen->tarifcyto_tindakankomp;
            $returnVal[$tindKomponenId]['subsidiasuransikomp'] = $komponen->subsidiasuransikomp;
            $returnVal[$tindKomponenId]['subsidipemerintahkomp'] = $komponen->subsidipemerintahkomp;
            $returnVal[$tindKomponenId]['subsidirumahsakitkomp'] = $komponen->subsidirumahsakitkomp;
            $returnVal[$tindKomponenId]['iurbiayakomp'] = $komponen->iurbiayakomp;
            // $returnVal[$tindKomponenId]['jmlpembebasan'] = $jmlpembebasan;
            $returnVal[$tindKomponenId]['jmlpembebasan'] = $komponen->tarif_tindakankomp;
            $returnVal[$tindKomponenId]['pembebasantarif_id'] = $pembebasantarif_id;
          }

          if(!empty($returnVal)){
            $form = $this->renderPartial('_rowRefundBiaya', array('data' => $returnVal), true);
          }
        }

        if($cekpembebasan == count((array) $komponens)){
          $pesan = "Tindakan Sudah Melakukan Refund Biaya!";
          $issudahretur = true;
        }
      }else{
        $pesan = "Tindakan Sudah Melakukan Pembebasan Tarif!";
      }

      echo CJSON::encode(array('form'=>$form,'pesan'=>$pesan, 'issudahretur' =>$issudahretur));
    }
  }

  public function actionSaveReturTindakan(){
    if (Yii::app()->request->isAjaxRequest) {
      $data = array();
      $sukses = 0;
      $pesan = "Data Refund Biaya Gagal Disimpan!!";

      if (isset($_POST['Returtagihan'])) {
        $transaction = Yii::app()->db->beginTransaction();
        
        try {
            $tersimpanpembebas = true;
            $terupdatetindakan = false;

            $sumjumlah = 0;
            $tindakanpelayanan_id = $_POST['tindakanpelayanan_id_retur'];
            $tindakansudahbayar_id = $_POST['tindakansudahbayar_id_retur'];
            $model = TindakanpelayananT::model()->findByPk($tindakanpelayanan_id);

            $modReturAll = PembebasantarifT::model()->findAllByAttributes(array('tindakansudahbayar_id'=>$tindakansudahbayar_id));

            if(!empty($modReturAll)){
              foreach($modReturAll as $dataReturOri){
                $cekdata = 0;

                foreach ($_POST['Returtagihan'] as $tindkomponen_id => $dataRetur) {
                  if($dataReturOri->pembebasantarif_id == $dataRetur['pembebasantarif_id']){
                    $cekdata = 1;
                  }
                }

                if($cekdata == 0){
                  PembebasantarifT::model()->deleteByPk($dataReturOri->pembebasantarif_id);
                }
              }
            }

            foreach ($_POST['Returtagihan'] as $tindkomponen_id => $dataPembebasan) {
              if(!empty($dataPembebasan['pembebasantarif_id'])){
                $modPembebasan = PembebasantarifT::model()->findByPk($dataPembebasan['pembebasantarif_id']);
              }

              if(empty($modPembebasan)){
                $modPembebasan = new PembebasantarifT;
              }
              
              $modPembebasan->attributes = $model->attributes;
              $modPembebasan->pegawai_id = $model->dokterpemeriksa1_id;
              $modPembebasan->tglpembebasan = date('Y-m-d H:i:s');
              $modPembebasan->tindakansudahbayar_id = $dataPembebasan['tindakansudahbayar_id'];
              $modPembebasan->tindakanpelayanan_id = null;
              $modPembebasan->komponentarif_id = $dataPembebasan['komponentarif_id'];
              $modPembebasan->jmlpembebasan = $dataPembebasan['hargaretur'];
              $modPembebasan->loginpemakai_id = Yii::app()->user->id;
              $modPembebasan->tindakanpelayanan_id = $model->tindakanpelayanan_id;
              
              $sumjumlah += $modPembebasan->jmlpembebasan;
             
              
              if(!$modPembebasan->save()){
                $tersimpanpembebas &= false;
              }

            //  var_dump($modPembebasan->attributes);
            }

            // die;
            
            $terupdatetindakan = TindakanpelayananT::model()->updateByPk($tindakanpelayanan_id, array('pembebasan_tindakan'=> $sumjumlah));

            if($tersimpanpembebas && $terupdatetindakan){
              $transaction->commit();
              $sukses = 1;
              $pesan = "Data Refund Biaya Berhasil disimpan!!";
            }else{
              $transaction->rollback();
                 $sukses = 0;
                 $pesan = "Data Refund Biaya Gagal Disimpan!!";
            }
           } catch (Exception $ex) {
               $transaction->rollback();
               $sukses = 0;
               $pesan = "Data Refund Biaya Gagal Disimpan!! ".MyExceptionMessage::getMessage($ex,true);
           }
      }

      
      $data['sukses'] = $sukses;
      $data['pesan'] = $pesan;
      echo json_encode($data);
      Yii::app()->end();
    }
  }
}
