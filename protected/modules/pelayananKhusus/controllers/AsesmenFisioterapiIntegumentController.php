<?php
/**
 *
 * controller transaksi asesmen fisioterapi integument
 *
 * @package      application.modules.rehabMedis
 * @subpackage   controllers
 * @author      M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 */
class AsesmenFisioterapiIntegumentController extends MyAuthController
{
    public $defaultAction = 'index';
    public $path_view = 'rehabMedis.views.asesmenFisioterapiIntegument.';
    public $init = '';
    public $layout = '//layouts/iframe';
    public $simpan_gambar = true;
    public $tersimpan = false;

    /**
     * action ini digunakan sebagai halaman utama transaksi keseimbangan cairan
     * parameter yang digunakan dan wajib ada yaitu pendaftaran_id, untuk parameter pasienadmisi_id bersifat optional
     * @param type $publikasi_id
     */
    public function actionIndex($pendaftaran_id,$pasienadmisi_id=null,$pasienmasukpenunjang_id)
    {
      $modPendaftaran= RMPendaftaranT::model()->findByPk($pendaftaran_id);
      $modPasien = RMPasienM::model()->findByPk($modPendaftaran->pasien_id);
      $ruanganid = Yii::app()->user->getState("ruangan_id");

      $periksaTesSpesifik = PemeriksaantesspesifikT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id,'create_ruangan'=>$ruanganid),array('order'=>'create_time DESC'));
      $testPesifik = "";

      if(isset($periksaTesSpesifik) && !empty($periksaTesSpesifik)){
        $periksaTesSpesifikDet = PemeriksaantesspesifikdetT::model()->findAllByAttributes(array('pemeriksaantesspesifik_id'=>$periksaTesSpesifik->pemeriksaantesspesifik_id));

        if(count($periksaTesSpesifikDet) > 0){
          foreach($periksaTesSpesifikDet as $i=> $detailTestSpesifik){
            if($i > 0){
              $testPesifik .= ", ";
            }
            $testPesifik .= $detailTestSpesifik->nama;
          }
        }
      }

      $cekAnamnesa = AnamnesaT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));
      $cekPemeriksaanFisik = PemeriksaanfisikT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));

      $model = AsesmenFisioterapiIntegumentT::model()->findByAttributes(array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id,'pasienmasukpenunjang_id' => $pasienmasukpenunjang_id));
      $modAsesmenmmtT = array();
      $oriPeriksaExtra = array();
      $oriPeriksaSinistra = array();
      $oriPeriksaDextra = array();

      $modBagianTubuh = new BagiantubuhM();
      $modGambarTubuh = new GambartubuhM();
      $modPemeriksaanGambar = null;

      if(isset($model) && !empty($model->asesmen_fisioterapi_integument_id)){
        $modAsesmenmmtT = AsesmenmmtT::model()->findAllByAttributes(array('asesmen_fisioterapi_integument_id'=>$model->asesmen_fisioterapi_integument_id));
        $oriPeriksaExtra = PeriksagerakdasardextraasesmenT::model()->findAllByAttributes(array('asesmen_fisioterapi_integument_id'=>$model->asesmen_fisioterapi_integument_id), array(
            'select' =>'distinct on (periksafungsigerakdasar_id) *', 'order'=>'periksafungsigerakdasar_id, periksagerakdasardextra_id'
        ));
        $oriPeriksaExtraSinistra = PeriksagerakdasarsinistraasesmenT::model()->findAllByAttributes(array('asesmen_fisioterapi_integument_id'=>$model->asesmen_fisioterapi_integument_id), array(
            'select' =>'distinct on (periksafungsigerakdasar_id) *', 'order'=>'periksafungsigerakdasar_id, periksagerakdasarsinistra_id'
        ));

        $oriPeriksaExtraMix = array_merge($oriPeriksaExtra, $oriPeriksaExtraSinistra);
        $oriPeriksaExtra = array();

        foreach ($oriPeriksaExtraMix as $item) {
            if (!empty($oriPeriksaExtra[$item->periksafungsigerakdasar_id])) {
                continue;
            }

            $oriPeriksaExtra[$item->periksafungsigerakdasar_id] = $item;
        }

        $oriPeriksaExtra = array_values($oriPeriksaExtra);
        $oriPeriksaDextra = PeriksagerakdasardextraasesmenT::model()->findAllByAttributes(array('asesmen_fisioterapi_integument_id'=>$model->asesmen_fisioterapi_integument_id));
        $oriPeriksaSinistra = PeriksagerakdasarsinistraasesmenT::model()->findAllByAttributes(array('asesmen_fisioterapi_integument_id'=>$model->asesmen_fisioterapi_integument_id));

        $cekGambar = RMPemeriksaangambarintegumentT::model()->findAllByAttributes(array('asesmen_fisioterapi_integument_id' => $model->asesmen_fisioterapi_integument_id));
         if (!empty($cekGambar)){
             $modPemeriksaanGambar = $cekGambar;
         }

         if (empty($oriPeriksaExtra)){
            if (!empty($cekPemeriksaanFisik)){
                $oriPeriksaExtra = PeriksagerakdasardextraT::model()->findAllByAttributes(array('pemeriksaanfisik_id'=>$cekPemeriksaanFisik->pemeriksaanfisik_id), array(
                    'select' =>'distinct on (periksafungsigerakdasar_id) *', 'order'=>'periksafungsigerakdasar_id, periksagerakdasardextra_id'
                ));
                $oriPeriksaExtraSinistra = PeriksagerakdasarsinistraT::model()->findAllByAttributes(array('pemeriksaanfisik_id'=>$cekPemeriksaanFisik->pemeriksaanfisik_id), array(
                    'select' =>'distinct on (periksafungsigerakdasar_id) *', 'order'=>'periksafungsigerakdasar_id, periksagerakdasarsinistra_id'
                ));

                $oriPeriksaExtraMix = array_merge($oriPeriksaExtra, $oriPeriksaExtraSinistra);
                $oriPeriksaExtra = array();

                foreach ($oriPeriksaExtraMix as $item) {
                    if (!empty($oriPeriksaExtra[$item->periksafungsigerakdasar_id])) {
                        continue;
                    }

                    $oriPeriksaExtra[$item->periksafungsigerakdasar_id] = $item;
                }
                $oriPeriksaExtra = array_values($oriPeriksaExtra);
            }
        }
        if (empty($oriPeriksaDextra)){
            if (!empty($cekPemeriksaanFisik)){
                $oriPeriksaDextra = PeriksagerakdasardextraT::model()->findAllByAttributes(array('pemeriksaanfisik_id'=>$cekPemeriksaanFisik->pemeriksaanfisik_id));
            }
        }
        if (empty($oriPeriksaSinistra)){
            if (!empty($cekPemeriksaanFisik)){
                $oriPeriksaSinistra = PeriksagerakdasarsinistraT::model()->findAllByAttributes(array('pemeriksaanfisik_id'=>$cekPemeriksaanFisik->pemeriksaanfisik_id));
            }
        }

        $hasilpemeriksaan = HasilpemeriksaanrmT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));
            if(!empty($hasilpemeriksaan)){
                if (empty($model->kemampuan_fungsional)){
                    $model->kemampuan_fungsional = $hasilpemeriksaan->hasilpemeriksaanrm;
                }

                if (empty($model->program_fisioterapi)){
                    $model->program_fisioterapi = $hasilpemeriksaan->keteranganhasilrm;
                }

                if (empty($model->evaluasidant)){
                    $model->evaluasi_tindaklanjut = $hasilpemeriksaan->evaluasi;
                }

            }

      }else{
        $model = new AsesmenFisioterapiIntegumentT();
        $model->pendaftaran_id = $modPendaftaran->pendaftaran_id;
        $model->pasien_id = $modPendaftaran->pasien_id;
        $model->pasienadmisi_id = $modPendaftaran->pasienadmisi_id;
        $model->pasienmasukpenunjang_id = $pasienmasukpenunjang_id;
        $model->tanggal_catat = date('d M Y');
        $model->test_khusus = $testPesifik;

        $umur = CustomFunction::getUmurTahun($modPasien->tanggal_lahir, $modPendaftaran->tgl_pendaftaran);
        if ((int) $umur > Params::SKALA_NYERI_UMUR_LEBIH) {
            $model->skalanyeri_statusumur = Params::SKALA_NYERI_BERDASARKAN_UMUR_1;
        } elseif ((int) $umur <= Params::SKALA_NYERI_UMUR_KURANG) {
            $model->skalanyeri_statusumur = Params::SKALA_NYERI_BERDASARKAN_UMUR_1;
        }

        if (!empty($cekAnamnesa)) {
            // var_dump($model->attributes, $cekAnamnesa->attributes); die;
            $model->keluhanutama = $cekAnamnesa->keluhanutama;
            // $model->keluhantambahan = $cekAnamnesa->keluhantambahan;
            $model->riwayatpenyakit = $cekAnamnesa->riwayatpenyakitterdahulu;
            // $model->riwayat_keluarga = $cekAnamnesa->riwayatpenyakitkeluarga;
        }
        if (!empty($cekPemeriksaanFisik)) {
            $model->td_systolic = $cekPemeriksaanFisik->td_systolic;
            $model->td_dyastolic = $cekPemeriksaanFisik->td_diastolic;
            $model->nadi = $cekPemeriksaanFisik->detaknadi;
            $model->pernapasan = $cekPemeriksaanFisik->pernapasan;
            $model->suhutubuh = str_replace(",", ".", $cekPemeriksaanFisik->suhutubuh);
            $model->skala_wongbaker_nrs = $cekPemeriksaanFisik->skala_wongbaker_nrs;

            $oriPeriksaExtra = PeriksagerakdasardextraT::model()->findAllByAttributes(array('pemeriksaanfisik_id'=>$cekPemeriksaanFisik->pemeriksaanfisik_id), array(
                'select' =>'distinct on (periksafungsigerakdasar_id) *', 'order'=>'periksafungsigerakdasar_id, periksagerakdasardextra_id'
            ));
            $oriPeriksaExtraSinistra = PeriksagerakdasarsinistraT::model()->findAllByAttributes(array('pemeriksaanfisik_id'=>$cekPemeriksaanFisik->pemeriksaanfisik_id), array(
                'select' =>'distinct on (periksafungsigerakdasar_id) *', 'order'=>'periksafungsigerakdasar_id, periksagerakdasarsinistra_id'
            ));

            $oriPeriksaExtraMix = array_merge($oriPeriksaExtra, $oriPeriksaExtraSinistra);
            $oriPeriksaExtra = array();

            foreach ($oriPeriksaExtraMix as $item) {
                if (!empty($oriPeriksaExtra[$item->periksafungsigerakdasar_id])) {
                    continue;
                }

                $oriPeriksaExtra[$item->periksafungsigerakdasar_id] = $item;
            }

            $oriPeriksaExtra = array_values($oriPeriksaExtra);
            $oriPeriksaDextra = PeriksagerakdasardextraT::model()->findAllByAttributes(array('pemeriksaanfisik_id'=>$cekPemeriksaanFisik->pemeriksaanfisik_id));
            $oriPeriksaSinistra = PeriksagerakdasarsinistraT::model()->findAllByAttributes(array('pemeriksaanfisik_id'=>$cekPemeriksaanFisik->pemeriksaanfisik_id));
            $modAsesmenmmtT = PemeriksaanfisikmmtT::model()->findAllByAttributes(array('pemeriksaanfisik_id'=>$cekPemeriksaanFisik->pemeriksaanfisik_id));
        }
        $hasilpemeriksaan = HasilpemeriksaanrmT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));
            if(!empty($hasilpemeriksaan)){
                $model->kemampuan_fungsional = $hasilpemeriksaan->hasilpemeriksaanrm;
                $model->program_fisioterapi = $hasilpemeriksaan->keteranganhasilrm;
                $model->evaluasi_tindaklanjut = $hasilpemeriksaan->evaluasi;
            }
      }

      $pasienMorbid = PasienmorbiditasT::model()->findAllByAttributes(array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id,'ruangan_id'=>$ruanganid));
      $diagnosaUtama = "";
      $diagnosaTambahan = "";
      $diagnosa_id = null;

      if(count($pasienMorbid) >0){
          $indexKel2=0;
          $indexKel3=0;

          foreach ($pasienMorbid as $datamorbid){
            $diagnosa_id = $datamorbid->diagnosa_id;
              if($datamorbid->kelompokdiagnosa_id == 2){
                  if($indexKel2 > 0){
                      $diagnosaUtama .= ", ";
                  }
                  $diagnosaUtama .= $datamorbid->diagnosa->diagnosa_nama;
                  $indexKel2++;
              }

              if($datamorbid->kelompokdiagnosa_id == 3){
                  if($indexKel3 > 0){
                      $diagnosaTambahan .= ", ";
                  }
                  $diagnosaTambahan .= $datamorbid->diagnosa->diagnosa_nama;
                  $indexKel3++;
              }
          }
      }
      $model->diagnosa_id = $diagnosa_id;
      $model->diagnosa_nama = "Diagnosa Utama: ".$diagnosaUtama." \n\n Diagnosa Tambahan: ".$diagnosaTambahan;
      $model->diagnosis_fisioterapi = "Diagnosa Utama: ".$diagnosaUtama." \n\n Diagnosa Tambahan: ".$diagnosaTambahan;

      $pemeriksaanFisik = PemeriksaanfisikT::model()->findByAttributes(array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id,'create_ruangan'=>$ruanganid));

      if(isset($pemeriksaanFisik) && empty($model->asesmen_fisioterapi_integument_id)){
        $model->td_dyastolic = $pemeriksaanFisik->td_diastolic;
        $model->td_systolic = $pemeriksaanFisik->td_systolic;
      }

      if (!empty($model->skala_wongbaker_nrs)) {
          $model->keluhan_nyeri = 1;
      }

      if(isset($_POST['AsesmenFisioterapiIntegumentT'])) {
          $transaction = Yii::app()->db->beginTransaction();

          try {
              $model->attributes = $_POST['AsesmenFisioterapiIntegumentT'];
              $model->tanggal_catat = MyFormatter::formatDateTimeForDb($_POST['AsesmenFisioterapiIntegumentT']['tanggal_catat']);
              $model->jam_pengisian = (!empty($_POST['AsesmenFisioterapiIntegumentT']['jam_pengisian'])? $_POST['AsesmenFisioterapiIntegumentT']['jam_pengisian'] : null);

              if(!empty($model->asesmen_fisioterapi_integument_id)){
                  $model->update_time = date('Y-m-d H:i:s');
                  $model->update_loginpemakai_id = Yii::app()->user->getState("loginpemakai_id");
              }else{
                  $model->create_time = date('Y-m-d H:i:s');
                  $model->create_loginpemakai_id = Yii::app()->user->getState("loginpemakai_id");
                  $model->pencatat_id = Yii::app()->user->getState("pegawai_id");
              }
              $model->create_ruangan = Yii::app()->user->getState("ruangan_id");


              $tersimpanMMT = true;
              $tersimpanExtra = true;
              $tersimpanSinistra = true;
              $tersimpanGambar = true;

              if(isset($_POST['AsesmenFisioterapiIntegumentT']['statik']) && count($_POST['AsesmenFisioterapiIntegumentT']['statik']) > 0){


                $statik_data = array();
                foreach($_POST['AsesmenFisioterapiIntegumentT']['statik'] as $statik){

                    $statik_data[] = $statik;
                }

                if(count($statik_data) > 0){
                    $model->statik = json_encode($statik_data);
                }
            }

            if(isset($_POST['AsesmenFisioterapiIntegumentT']['dinamis']) && count($_POST['AsesmenFisioterapiIntegumentT']['dinamis']) > 0){

                $dinamis_data = array();
                foreach($_POST['AsesmenFisioterapiIntegumentT']['dinamis'] as $dinamis){
                    $dinamis_data[] = $dinamis;
                }

                if(count($dinamis_data) > 0){
                    $model->dinamis = json_encode($dinamis_data);
                }
            }

            if(isset($_POST['AsesmenFisioterapiIntegumentT']['palpasi']) && count($_POST['AsesmenFisioterapiIntegumentT']['palpasi']) > 0){

                $palpasi_data = array();
                foreach($_POST['AsesmenFisioterapiIntegumentT']['palpasi'] as $palpasi){
                    $palpasi_data[] = $palpasi;
                }

                if(count($palpasi_data) > 0){
                    $model->palpasi = json_encode($palpasi_data);
                }
            }

              if($model->save()){
                    $this->tersimpan = true;

                    PeriksagerakdasardextraasesmenT::model()->deleteAllByAttributes(array('asesmen_fisioterapi_integument_id'=>$model->asesmen_fisioterapi_integument_id));
                    PeriksagerakdasarsinistraasesmenT::model()->deleteAllByAttributes(array('asesmen_fisioterapi_integument_id'=>$model->asesmen_fisioterapi_integument_id));

                    if (isset($_POST['PeriksagerakdasardextraT']) && is_array($_POST['PeriksagerakdasardextraT'])) {

                        foreach ($_POST['PeriksagerakdasardextraT'] as $idx => $item) {
                            $periksafungsigerakdasar_id = $item['periksafungsigerakdasar_id'];

                            foreach ($item as $idx2 => $detail) {
                                if (!is_array($detail)) {
                                    continue;
                                }

                                $modPeriksaExt = new PeriksagerakdasardextraasesmenT();
                                $modPeriksaExt->periksafungsigerakdasar_id = $periksafungsigerakdasar_id;
                                $modPeriksaExt->attributes = $detail;
                                $modPeriksaExt->asesmen_fisioterapi_integument_id = $model->asesmen_fisioterapi_integument_id;
                                $modPeriksaExt->create_time = date('Y-m-d H:i:s');
                    			$modPeriksaExt->create_ruangan_id = Yii::app()->user->getState('ruangan_id');
                    			$modPeriksaExt->create_loginpemakai_id = Yii::app()->user->id;
                                // $modPeriksaExt->fungsigerakdasarsinistra_id =

                                if ($modPeriksaExt->validate()) {
                                    $tersimpanSinistra = $tersimpanSinistra && $modPeriksaExt->save();
                                } else {
                                    $tersimpanSinistra = false;
                                }

//                                var_dump($modPeriksaExt->attributes, $detail);
                            }

                            if (isset($_POST['PeriksagerakdasarsinistraT'][$idx]) && is_array($_POST['PeriksagerakdasarsinistraT'][$idx])) {

                                foreach ($_POST['PeriksagerakdasarsinistraT'][$idx] as $idx2 => $detail) {

                                    $modDetSinistra = new PeriksagerakdasarsinistraasesmenT();
                                    $modDetSinistra->periksafungsigerakdasar_id = $periksafungsigerakdasar_id;
                                    $modDetSinistra->attributes = $detail;
                                    $modDetSinistra->asesmen_fisioterapi_integument_id = $model->asesmen_fisioterapi_integument_id;
                                    $modDetSinistra->create_time = date('Y-m-d H:i:s');
                                    $modDetSinistra->create_ruangan_id = Yii::app()->user->getState('ruangan_id');
                                    $modDetSinistra->create_loginpemakai_id = Yii::app()->user->id;

                                    if ($modDetSinistra->validate()) {
                                        $tersimpanSinistra = $tersimpanSinistra && $modDetSinistra->save();
                                    } else {
                                        $tersimpanSinistra = false;
                                    }

//                                     var_dump($modDetSinistra->attributes, $detail);
                                }

                            }

                        }

                    }

//                    die;

                  if (isset($_POST['PemeriksaanFisikMMT']) && count($_POST['PemeriksaanFisikMMT']) > 0) {
                    AsesmenmmtT::model()->deleteAllByAttributes(array(
                        'asesmen_fisioterapi_integument_id' => $model->asesmen_fisioterapi_integument_id
                    ));
                    foreach ($_POST['PemeriksaanFisikMMT'] as $fisikMMt) {
                      if(!empty($fisikMMt['kiri']) || !empty($fisikMMt['kanan'])){
                        $modDetFisik = new AsesmenmmtT();
                        $modDetFisik->attributes = $fisikMMt;
                        $modDetFisik->pendaftaran_id = $modPendaftaran->pendaftaran_id;
                        $modDetFisik->asesmen_fisioterapi_integument_id = $model->asesmen_fisioterapi_integument_id;
                        $modDetFisik->create_time = date('Y-m-d H:i:s');
                        $modDetFisik->create_ruangan = Yii::app()->user->getState('ruangan_id');
                        $modDetFisik->create_loginpemakai_id = Yii::app()->user->id;
                        if(!$modDetFisik->save()){
                          $tersimpanMMT = false;
                        }
                      }
                    }
                  }

                  if (isset($_POST['RMPemeriksaangambarintegumentT'])){
                      foreach($_POST['RMPemeriksaangambarintegumentT'] as $det){
                          $modDetGambar = new RMPemeriksaangambarintegumentT;
                          $cekGambar = RMPemeriksaangambarintegumentT::model()->findByPk($det['pemeriksaangambarintegument_id']);
                          if (!empty($cekGambar)){
                              $modDetGambar = $cekGambar;
                          }
                          $modDetGambar->attributes = $det;
                          if (empty($cekGambar)){
                              $modDetGambar->tglpemeriksaan = date('Y-m-d H:i:s');
                              $modDetGambar->asesmen_fisioterapi_integument_id = $model->asesmen_fisioterapi_integument_id;
                              $modDetGambar->create_time = date('Y-m-d H:i:s');
                              $modDetGambar->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
                              $modDetGambar->create_ruangan = Yii::app()->user->getState('ruangan_id');
                          }else{
                              $modDetGambar->update_time = date('Y-m-d H:i:s');
                              $modDetGambar->update_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
                          }

                          $tersimpanGambar = $tersimpanGambar && $modDetGambar->save();
                      }
                  }

                  if (isset($_POST['deletegambar'])){
                      $criDel = new CDbCriteria();
                      $criDel->addInCondition("pemeriksaangambarintegument_id", $_POST['deletegambar']);
                      $tersimpanGambar = $tersimpanGambar && RMPemeriksaangambarintegumentT::model()->deleteAll($criDel);
                  }
              }else{
                 $this->tersimpan = false;
              }

              if($this->tersimpan == true && $tersimpanSinistra == true && $tersimpanExtra == true && $tersimpanMMT == true && $tersimpanGambar == true){
                  $transaction->commit();
                  Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                  $this->redirect(array('index','pendaftaran_id'=>$model->pendaftaran_id,'pasienmasukpenunjang_id'=>$pasienmasukpenunjang_id,'sukses'=>1));
              }else{
                  Yii::app()->user->setFlash('error',"Data gagal disimpan!");
              }
          } catch (Exception $exc) {
              $transaction->rollback();
              Yii::app()->user->setFlash('error',"Data gagal disimpan ".MyExceptionMessage::getMessage($exc,true));
          }
      }

      $this->render($this->path_view.'index',
          array('modPendaftaran'=>$modPendaftaran,
              'modPasien'=>$modPasien,
              'model'=>$model,
              'modAsesmenmmtT'=>$modAsesmenmmtT,
              'oriPeriksaExtra'=>$oriPeriksaExtra,
              'oriPeriksaSinistra'=>$oriPeriksaSinistra,
              'oriPeriksaDextra' => $oriPeriksaDextra,
              'modBagianTubuh' => $modBagianTubuh,
              'modGambarTubuh' => $modGambarTubuh,
              'modPemeriksaanGambar' => $modPemeriksaanGambar,
      ));




        // $model = new RMAsesmenFisioterapiIntegumentT();
        // $model->pendaftaran_id = $pendaftaran_id;
        // $model->pasienadmisi_id = $pasienadmisi_id;
        // $model->pasienmasukpenunjang_id = $pasienmasukpenunjang_id;
        //
        // $modPendaftaran = RMPendaftaranT::model()->findByPk($pendaftaran_id);
        //
        // $model->pasien_id = $modPendaftaran->pasien_id;
        //
        // $modBagianTubuh = new BagiantubuhM();
        // $modGambarTubuh = new GambartubuhM();
        // $modPemeriksaanGambar = null;
        //
        // $cekIntegument = RMAsesmenFisioterapiIntegumentT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id, 'pasienmasukpenunjang_id' => $pasienmasukpenunjang_id));
        // if (!empty($cekIntegument)){
        //     $model = $cekIntegument;
        //
        //     $cekGambar = RMPemeriksaangambarintegumentT::model()->findAllByAttributes(array('asesmen_fisioterapi_integument_id' => $model->asesmen_fisioterapi_integument_id));
        //     if (!empty($cekGambar)){
        //         $modPemeriksaanGambar = $cekGambar;
        //     }
        // }
        //
        // if (isset($_POST['RMAsesmenFisioterapiIntegumentT'])){
        //     $ok = true;
        //     $trans = Yii::app()->db->beginTransaction();
        //     try{
        //         $model->attributes = $_POST['RMAsesmenFisioterapiIntegumentT'];
        //
        //         if (empty($model->asesmen_fisioterapi_integument_id)){
        //             $model->pencatat_id = Yii::app()->user->getState('pegawai_id');
        //             $model->tanggal_catat = date('Y-m-d H:i:s');
        //             $model->create_time = date('Y-m-d H:i:s');
        //             $model->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
        //             $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
        //         }else{
        //             $model->update_time = date('Y-m-d H:i:s');
        //             $model->update_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
        //         }
        //         $ok = $ok && $model->save();
        //
        //         if (isset($_POST['RMPemeriksaangambarintegumentT'])){
        //             foreach($_POST['RMPemeriksaangambarintegumentT'] as $det){
        //                 $modDetGambar = new RMPemeriksaangambarintegumentT;
        //                 $cekGambar = RMPemeriksaangambarintegumentT::model()->findByPk($det['pemeriksaangambarintegument_id']);
        //                 if (!empty($cekGambar)){
        //                     $modDetGambar = $cekGambar;
        //                 }
        //                 $modDetGambar->attributes = $det;
        //                 if (empty($cekGambar)){
        //                     $modDetGambar->tglpemeriksaan = date('Y-m-d H:i:s');
        //                     $modDetGambar->asesmen_fisioterapi_integument_id = $model->asesmen_fisioterapi_integument_id;
        //                     $modDetGambar->create_time = date('Y-m-d H:i:s');
        //                     $modDetGambar->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
        //                     $modDetGambar->create_ruangan = Yii::app()->user->getState('ruangan_id');
        //                 }else{
        //                     $modDetGambar->update_time = date('Y-m-d H:i:s');
        //                     $modDetGambar->update_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
        //                 }
        //
        //                 $ok = $ok && $modDetGambar->save();
        //             }
        //         }
        //
        //         if (isset($_POST['deletegambar'])){
        //             $criDel = new CDbCriteria();
        //             $criDel->addInCondition("pemeriksaangambarintegument_id", $_POST['deletegambar']);
        //             $ok = $ok && RMPemeriksaangambarintegumentT::model()->deleteAll($criDel);
        //         }
        //
        //
        //         if($ok){
        //             $trans->commit();
        //             Yii::app()->user->setFlash('success',"Data Berhasil Disimpan");
        //             $this->redirect(array('index','pendaftaran_id'=>$pendaftaran_id,'pasienmasukpenunjang_id'=>$pasienmasukpenunjang_id,'asesmen_fisioterapi_integument_id'=>$model->asesmen_fisioterapi_integument_id,'sukses'=>1));
        //         }else{
        //             $trans->rollback();
        //             Yii::app()->user->setFlash('error',"Data gagal disimpan ".CHtml::errorSummary($model));
        //         }
        //     } catch (Exception $exc) {
        //         $trans->rollback();
        //         Yii::app()->user->setFlash('error',"Data gagal disimpan ".MyExceptionMessage::getMessage($exc,true));
        //     }
        //
        // }
        //
        // $this->render($this->path_view.'index',array(
        //     'model' => $model,
        //     'modBagianTubuh' => $modBagianTubuh,
        //     'modGambarTubuh' => $modGambarTubuh,
        //     'modPemeriksaanGambar' => $modPemeriksaanGambar
        // ));
    }

    /**
     * Hapus bagian tubuh
     */
    public function actionHapusBagianTubuh() {
        if (Yii::app()->request->isAjaxRequest) {
            $pesan = '';
            $ok = 0;
            $del = true;

            $ok = RJPemeriksaangambarT::model()->findByAttributes(
                    array(
                        'pemeriksaangambar_id' => $_POST['pemeriksaangambar_id'],
                        'gambartubuh_id' => $_POST['gambartubuh_id'],
                        'bagiantubuh_id' => $_POST['bagiantubuh_id'],
                        'keterangan_periksa_gbr' => $_POST['keterangan_periksa_gbr'],
                    )
            );

            if (!empty($ok)) {
                $del = $del && $ok->delete();
            }

            if ($del) {
                $pesan = 'Data Berhasil Dihapus dari database';
                $ok = 1;
                echo CJSON::encode(array('pesan' => $pesan, 'ok' => $ok));
            } else {
                $ok = 0;
                $pesan = "Bagian Tubuh gagal dihapus!";
                echo CJSON::encode(array('pesan' => $pesan, 'ok' => $ok));
            }
        }
        Yii::app()->end();
    }

    /**
     * Tambah bagan tubuh
     */
    public function actionTambahBagianTubuh() {
        if (Yii::app()->request->isAjaxRequest) {
            $pesan = '';
            $form = '';
            if (!empty($_POST['bagiantubuh_id'])) {
                $modPemeriksaanGbr = new RMPemeriksaangambarintegumentT();
                $modPemeriksaanGbr->bagiantubuh_id = $_POST['bagiantubuh_id'];
                $modPemeriksaanGbr->namabagtubuh = $modPemeriksaanGbr->bagiantubuh->namabagtubuh;
                $modPemeriksaanGbr->keterangan_periksa_gbr = $_POST['keterangan'];
                $modPemeriksaanGbr->kordinat_tubuh_x = $_POST['pic_x'];
                $modPemeriksaanGbr->kordinat_tubuh_y = $_POST['pic_y'];
                $modPemeriksaanGbr->gambartubuh_id = $_POST['gambartubuh_id'];
                $form = $this->renderPartial($this->path_view . 'row/_rowDetail', array('modPemeriksaanGbr' => $modPemeriksaanGbr), true);
                $axis['x'] = $modPemeriksaanGbr->kordinat_tubuh_x;
                $axis['y'] = $modPemeriksaanGbr->kordinat_tubuh_y;
                echo CJSON::encode(array('pesan' => $pesan, 'form' => $form, 'axis' => $axis, 'bagiantubuh_id' => $modPemeriksaanGbr->bagiantubuh_id));
            } else {
                $pesan = 'Bagian tubuh tidak boleh kosong!';
                echo CJSON::encode(array('pesan' => $pesan));
            }
        }
        Yii::app()->end();
    }

    /**
     *
     * @param type $postperiksagbr
     * @param type $model
     * @return type
     */
    public function simpanPemeriksaanGambar($postperiksagbr, $model) {
        $modPemeriksaanGambar = new RMPemeriksaangambarintegumentT;
        $cekPeriksaGambar = RMPemeriksaangambarintegumentT::model()->findByPk($postperiksagbr['pemeriksaangambarintegument_id']);
        if (!empty($cekPeriksaGambar)){
            $modPemeriksaanGambar = $cekPeriksaGambar;
        }
        $modPemeriksaanGambar->attributes = $postperiksagbr;
        $modPemeriksaanGambar->asesmen_fisioterapi_integument_id = $model->asesmen_fisioterapi_integument_id;
        $modPemeriksaanGambar->tglpemeriksaan = date('Y-m-d H:i:s');
        if (empty($cekPeriksaGambar)){
            $modPemeriksaanGambar->create_time = date('Y-m-d H:i:s');
            $modPemeriksaanGambar->create_loginpemakai_id = Yii::app()->user->id;
            $modPemeriksaanGambar->create_ruangan = Yii::app()->user->getState('ruangan_id');
        }else{
            $modPemeriksaanGambar->update_time = date('Y-m-d H:i:s');
            $modPemeriksaanGambar->update_loginpemakai_id = Yii::app()->user->id;
        }

        $this->simpan_gambar = $this->simpan_gambar && $modPemeriksaanGambar->save();


        return $this->simpan_gambar;
    }

    public function actionTambahPeriksaFungsiGerakDasar()
    {
        if(Yii::app()->request->isAjaxRequest) {
          $pemeriksaangerak_id = $_POST['pemeriksaangerak_id'];
          $periksaFungsi = PeriksafungsigerakdasarM::model()->findByPk($pemeriksaangerak_id);
          $namaPemeriksaan = "";
          $pemeriksaan_id = "";

          if(isset($periksaFungsi)){
            $namaPemeriksaan = $periksaFungsi->periksafungsigerakdasar_nama;
            $pemeriksaan_id = $periksaFungsi->periksafungsigerakdasar_id;
          }

            echo CJSON::encode(array(
                'form'=>$this->renderPartial($this->path_view.'_rowPeriksaFungsiGerakDasar', array(
                    'namaPemeriksaan'=>$namaPemeriksaan,
                    'pemeriksaan_id'=>$pemeriksaan_id,
                ),
                true))
            );
            exit;
        }
    }

    public function actionTambahSinistra()
    {
        if(Yii::app()->request->isAjaxRequest) {
          $pemeriksaangerak_id = $_POST['periksafungsigerakdasar_id'];
          $periksaFungsi = PeriksafungsigerakdasarM::model()->findByPk($pemeriksaangerak_id);
          $namaPemeriksaan = "";
          $pemeriksaan_id = "";

          if(isset($periksaFungsi)){
            $pemeriksaan_id = $periksaFungsi->periksafungsigerakdasar_id;
          }

            echo CJSON::encode(array(
                'form'=>$this->renderPartial($this->path_view.'_rowSinistrasi', array(
                    'pemeriksaan_id'=>$pemeriksaan_id,
                ),
                true))
            );
            exit;
        }
    }

    public function actionTambahDextra()
    {
        if(Yii::app()->request->isAjaxRequest) {
            $pemeriksaangerak_id = $_POST['periksafungsigerakdasar_id'];
            $periksaFungsi = PeriksafungsigerakdasarM::model()->findByPk($pemeriksaangerak_id);
            $namaPemeriksaan = "";
            $pemeriksaan_id = "";

            if(isset($periksaFungsi)){
                $pemeriksaan_id = $periksaFungsi->periksafungsigerakdasar_id;
            }

            echo CJSON::encode(array(
                'form'=>$this->renderPartial($this->path_view.'_rowDextra', array(
                    'pemeriksaan_id'=>$pemeriksaan_id,
                ),
                true))
            );
            exit;
        }
    }

    public function actionPrint($pendaftaran_id, $pasienmasukpenunjang_id) {
      $modPendaftaran= RMPendaftaranT::model()->findByPk($pendaftaran_id);
      $modPasien = RMPasienM::model()->findByPk($modPendaftaran->pasien_id);
      $ruanganid = Yii::app()->user->getState("ruangan_id");

      $model = AsesmenFisioterapiIntegumentT::model()->findByAttributes(array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id,'pasienmasukpenunjang_id' => $pasienmasukpenunjang_id));
      $modAsesmenmmtT = array();
      $oriPeriksaExtra = array();
      $oriPeriksaSinistra = array();

      $modBagianTubuh = new BagiantubuhM();
      $modGambarTubuh = new GambartubuhM();
      $modPemeriksaanGambar = null;


      if(isset($model) && !empty($model->asesmen_fisioterapi_integument_id)){
        $modAsesmenmmtT = AsesmenmmtT::model()->findAllByAttributes(array('asesmen_fisioterapi_integument_id'=>$model->asesmen_fisioterapi_integument_id));
        $oriPeriksaExtra = PeriksagerakdasardextraasesmenT::model()->findAllByAttributes(array('asesmen_fisioterapi_integument_id'=>$model->asesmen_fisioterapi_integument_id), array(
            'select' =>'distinct on (periksafungsigerakdasar_id) *', 'order'=>'periksafungsigerakdasar_id, periksagerakdasardextra_id'
        ));
        $oriPeriksaExtraSinistra = PeriksagerakdasarsinistraasesmenT::model()->findAllByAttributes(array('asesmen_fisioterapi_integument_id'=>$model->asesmen_fisioterapi_integument_id), array(
            'select' =>'distinct on (periksafungsigerakdasar_id) *', 'order'=>'periksafungsigerakdasar_id, periksagerakdasarsinistra_id'
        ));

        $oriPeriksaExtraMix = array_merge($oriPeriksaExtra, $oriPeriksaExtraSinistra);
        $oriPeriksaExtra = array();

        foreach ($oriPeriksaExtraMix as $item) {
            if (!empty($oriPeriksaExtra[$item->periksafungsigerakdasar_id])) {
                continue;
            }

            $oriPeriksaExtra[$item->periksafungsigerakdasar_id] = $item;
        }

        $oriPeriksaExtra = array_values($oriPeriksaExtra);
        $oriPeriksaDextra = PeriksagerakdasardextraasesmenT::model()->findAllByAttributes(array('asesmen_fisioterapi_integument_id'=>$model->asesmen_fisioterapi_integument_id));
        $oriPeriksaSinistra = PeriksagerakdasarsinistraasesmenT::model()->findAllByAttributes(array('asesmen_fisioterapi_integument_id'=>$model->asesmen_fisioterapi_integument_id));

        $cekGambar = RMPemeriksaangambarintegumentT::model()->findAllByAttributes(array('asesmen_fisioterapi_integument_id' => $model->asesmen_fisioterapi_integument_id));
         if (!empty($cekGambar)){
             $modPemeriksaanGambar = $cekGambar;
         }
      }else{
        $model = new AsesmenFisioterapiIntegumentT();
      }

      $pasienMorbid = PasienmorbiditasT::model()->findAllByAttributes(array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id,'ruangan_id'=>$ruanganid));
      $diagnosaUtama = "";
      $diagnosaTambahan = "";
      $diagnosa_id = null;

      if(count($pasienMorbid) >0){
          $indexKel2=0;
          $indexKel3=0;

          foreach ($pasienMorbid as $datamorbid){
            $diagnosa_id = $datamorbid->diagnosa_id;
              if($datamorbid->kelompokdiagnosa_id == 2){
                  if($indexKel2 > 0){
                      $diagnosaUtama .= ", ";
                  }
                  $diagnosaUtama .= $datamorbid->diagnosa->diagnosa_nama;
                  $indexKel2++;
              }

              if($datamorbid->kelompokdiagnosa_id == 3){
                  if($indexKel3 > 0){
                      $diagnosaTambahan .= ", ";
                  }
                  $diagnosaTambahan .= $datamorbid->diagnosa->diagnosa_nama;
                  $indexKel3++;
              }
          }
      }
      $model->diagnosa_nama = "Diagnosa Utama: ".$diagnosaUtama;
      $model->diagnosatambahan = "Diagnosa Tambahan: ".$diagnosaTambahan;

        $this->layout = '//layouts/printWindows';
        $this->render($this->path_view . 'Print', array(
          'model' => $model,
          'modPasien' => $modPasien,
          'modPendaftaran' => $modPendaftaran,
          'oriPeriksaExtra'=>$oriPeriksaExtra,
          'oriPeriksaSinistra'=>$oriPeriksaSinistra,
          'oriPeriksaDextra'=>$oriPeriksaDextra,
          'modAsesmenmmtT'=>$modAsesmenmmtT,
          'modBagianTubuh' => $modBagianTubuh,
          'modGambarTubuh' => $modGambarTubuh,
          'modPemeriksaanGambar' => $modPemeriksaanGambar));
    }
}
