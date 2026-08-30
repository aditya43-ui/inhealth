<?php
/**
 *
 * controller transaksi asesmen fisioterapi kardiopulmonal
 *
 * @package      application.modules.rehabMedis
 * @subpackage   controllers
 * @author      M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 */
class AsesmenFisioterapiKardiopulmonalController extends MyAuthController
{
    public $defaultAction = 'index';
    public $path_view = 'rehabMedis.views.asesmenFisioterapiKardiopulmonal.';
    public $init = '';
    public $layout = '//layouts/iframe';
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

      $model = AsesmenFisioterapiKardiopulmonalT::model()->findByAttributes(array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id,'pasienmasukpenunjang_id' => $pasienmasukpenunjang_id));
      // $modAsesmenmmtT = array();
      // $oriPeriksaExtra = array();
      // $oriPeriksaSinistra = array();

      if(isset($model) && !empty($model->asesmen_fisioterapi_kardiopulmonal_id)){
        // $modAsesmenmmtT = AsesmenmmtT::model()->findAllByAttributes(array('asesmen_fisioterapi_pediatri_id'=>$model->asesmen_fisioterapi_pediatri_id));
        // $oriPeriksaExtra = PeriksagerakdasardextraasesmenT::model()->findAllByAttributes(array('asesmen_fisioterapi_pediatri_id'=>$model->asesmen_fisioterapi_pediatri_id));
        // $oriPeriksaSinistra = PeriksagerakdasarsinistraasesmenT::model()->findAllByAttributes(array('asesmen_fisioterapi_pediatri_id'=>$model->asesmen_fisioterapi_pediatri_id));

        $hasilpemeriksaan = HasilpemeriksaanrmT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));
            if(!empty($hasilpemeriksaan)){

                if (empty($model->program_fisioterapi)){
                    $model->program_fisioterapi = $hasilpemeriksaan->keteranganhasilrm;
                }

                if (empty($model->evaluasidant)){
                    $model->evaluasi_tindaklanjut = $hasilpemeriksaan->evaluasi;
                }
            }

      }else{
        $model = new AsesmenFisioterapiKardiopulmonalT();
        $model->pendaftaran_id = $modPendaftaran->pendaftaran_id;
        $model->pasien_id = $modPendaftaran->pasien_id;
        $model->pasienadmisi_id = $modPendaftaran->pasienadmisi_id;
        $model->pasienmasukpenunjang_id = $pasienmasukpenunjang_id;
        $model->tanggal_catat = date('d M Y');
        $model->test_khusus = $testPesifik;


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
            // $model->skala_wongbaker_nrs = $cekPemeriksaanFisik->skala_wongbaker_nrs;

        }

        // $umur = CustomFunction::getUmurTahun($modPasien->tanggal_lahir, $modPendaftaran->tgl_pendaftaran);
        // if ((int) $umur > Params::SKALA_NYERI_UMUR_LEBIH) {
        //     $model->skalanyeri_statusumur = Params::SKALA_NYERI_BERDASARKAN_UMUR_1;
        // } elseif ((int) $umur <= Params::SKALA_NYERI_UMUR_KURANG) {
        //     $model->skalanyeri_statusumur = Params::SKALA_NYERI_BERDASARKAN_UMUR_1;
        // }

        $hasilpemeriksaan = HasilpemeriksaanrmT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));
            if(!empty($hasilpemeriksaan)){
                // $model->kemampuan_fungsional = $hasilpemeriksaan->hasilpemeriksaanrm;
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

      if(isset($pemeriksaanFisik) && empty($model->asesmen_fisioterapi_kardiopulmonal_id)){
        $model->td_dyastolic = $pemeriksaanFisik->td_diastolic;
        $model->td_systolic = $pemeriksaanFisik->td_systolic;
      }

      if(isset($_POST['AsesmenFisioterapiKardiopulmonalT'])) {
          $transaction = Yii::app()->db->beginTransaction();

          try {
              $model->attributes = $_POST['AsesmenFisioterapiKardiopulmonalT'];
              $model->tanggal_catat = MyFormatter::formatDateTimeForDb($_POST['AsesmenFisioterapiKardiopulmonalT']['tanggal_catat']);
              $model->jam_pengisian = (!empty($_POST['AsesmenFisioterapiKardiopulmonalT']['jam_pengisian'])? $_POST['AsesmenFisioterapiKardiopulmonalT']['jam_pengisian'] : null);

              if(!empty($model->asesmen_fisioterapi_kardiopulmonal_id)){
                  $model->update_time = date('Y-m-d H:i:s');
                  $model->update_loginpemakai_id = Yii::app()->user->getState("loginpemakai_id");
              }else{
                $model->pencatat_id = Yii::app()->user->getState('pegawai_id');
                  $model->create_time = date('Y-m-d H:i:s');
                  $model->create_loginpemakai_id = Yii::app()->user->getState("loginpemakai_id");
              }
              $model->create_ruangan = Yii::app()->user->getState("ruangan_id");

              $tersimpanMMT = true;
              $tersimpanExtra = true;
              $tersimpanSinistra = true;

              if(isset($_POST['AsesmenFisioterapiKardiopulmonalT']['inspeksi_statik_bentukdada']) && count($_POST['AsesmenFisioterapiKardiopulmonalT']['inspeksi_statik_bentukdada']) > 0){


                $statik_data = array();
                foreach($_POST['AsesmenFisioterapiKardiopulmonalT']['inspeksi_statik_bentukdada'] as $statik){

                    $statik_data[] = $statik;
                }

                if(count($statik_data) > 0){
                    $model->inspeksi_statik_bentukdada = json_encode($statik_data);
                }
            }
            if(isset($_POST['AsesmenFisioterapiKardiopulmonalT']['inspeksi_dinamis']) && count($_POST['AsesmenFisioterapiKardiopulmonalT']['inspeksi_dinamis']) > 0){

                $dinamis_data = array();
                foreach($_POST['AsesmenFisioterapiKardiopulmonalT']['inspeksi_dinamis'] as $dinamis){
                    $dinamis_data[] = $dinamis;
                }

                if(count($dinamis_data) > 0){
                    $model->inspeksi_dinamis = json_encode($dinamis_data);
                }
            }

            if(isset($_POST['AsesmenFisioterapiKardiopulmonalT']['palpasi_ekspansi_thorax']) && count($_POST['AsesmenFisioterapiKardiopulmonalT']['palpasi_ekspansi_thorax']) > 0){

                $palpasi_data = array();
                foreach($_POST['AsesmenFisioterapiKardiopulmonalT']['palpasi_ekspansi_thorax'] as $palpasi){
                    $palpasi_data[] = $palpasi;
                }

                if(count($palpasi_data) > 0){
                    $model->palpasi_ekspansi_thorax = json_encode($palpasi_data);
                }
            }

              if(isset($_POST['PemendekanOtot']) && count($_POST['PemendekanOtot']) > 0){
                $arrPemedekan = array();
                foreach($_POST['PemendekanOtot'] as $pemedekan){
                  if(isset($pemedekan['ischeckotot']) && $pemedekan['ischeckotot'] == 1){
                    $arrPemedekan[] = $pemedekan['nama'];
                  }
                }

                if(count($arrPemedekan) > 0){
                  $model->pemendekan_otot = json_encode($arrPemedekan);
                }
              }

              if($model->save()){
                  $this->tersimpan = true;
              }else{
                 $this->tersimpan = false;
              }

              if($this->tersimpan == true){
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
              // 'modAsesmenmmtT'=>$modAsesmenmmtT,
              // 'oriPeriksaExtra'=>$oriPeriksaExtra,
              // 'oriPeriksaSinistra'=>$oriPeriksaSinistra
      ));


        // $model = new RMAsesmenFisioterapiKardiopulmonalT();
        // $model->pendaftaran_id = $pendaftaran_id;
        // $model->pasienadmisi_id = $pasienadmisi_id;
        // $model->pasienmasukpenunjang_id = $pasienmasukpenunjang_id;
        //
        // $modPendaftaran = RMPendaftaranT::model()->findByPk($pendaftaran_id);
        //
        // $model->pasien_id = $modPendaftaran->pasien_id;
        //
        // $cekPediatri = RMAsesmenFisioterapiKardiopulmonalT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id,'pasienmasukpenunjang_id' => $pasienmasukpenunjang_id));
        // if (!empty($cekPediatri)){
        //     $model = $cekPediatri;
        // }
        //
        // $look = array();
        //
        // $criLook = new CDbCriteria();
        // $criLook->addCondition(" lookup_aktif = TRUE ");
        // $criLook->addInCondition("lookup_type", array(
        //         Params::LOOKUPTYPE_KARDIOPULMONAL_FUNGSIONAL,
        //         Params::LOOKUPTYPE_KARDIOPULMONAL_INSPEKSI_STATIK_DADA,
        //         Params::LOOKUPTYPE_KARDIOPULMONAL_INSPEKSI_DINAMIS,
        //         Params::LOOKUPTYPE_KARDIOPULMONAL_PALPASI_THORAX,
        //         Params::LOOKUPTYPE_KARDIOPULMONAL_PALPASI_SPASME,
        //         Params::LOOKUPTYPE_KARDIOPULMONAL_KHUSUS_PERKUSI,
        //         Params::LOOKUPTYPE_KARDIOPULMONAL_KHUSUS_AUSKULTASI_SUARA,
        //     )
        // );
        // $criLook->order = " lookup_type ASC,lookup_urutan ASC ";
        // $loadLook = LookupM::model()->findAll($criLook);
        //
        // $look[Params::LOOKUPTYPE_KARDIOPULMONAL_FUNGSIONAL]['type'] = array();
        // $look[Params::LOOKUPTYPE_KARDIOPULMONAL_INSPEKSI_STATIK_DADA]['type'] = array();
        // $look[Params::LOOKUPTYPE_KARDIOPULMONAL_INSPEKSI_DINAMIS]['type'] = array();
        // $look[Params::LOOKUPTYPE_KARDIOPULMONAL_PALPASI_THORAX]['type'] = array();
        // $look[Params::LOOKUPTYPE_KARDIOPULMONAL_PALPASI_SPASME]['type'] = array();
        // $look[Params::LOOKUPTYPE_KARDIOPULMONAL_KHUSUS_PERKUSI]['type'] = array();
        // $look[Params::LOOKUPTYPE_KARDIOPULMONAL_KHUSUS_AUSKULTASI_SUARA]['type'] = array();
        //
        // foreach($loadLook as $l){
        //     $look[$l->lookup_type]['type'][$l->lookup_id]['name'] = $l->lookup_name;
        //     $look[$l->lookup_type]['type'][$l->lookup_id]['value'] = $l->lookup_value;
        // }
        //
        // if (isset($_POST['RMAsesmenFisioterapiKardiopulmonalT'])){
        //     $ok = true;
        //     $trans = Yii::app()->db->beginTransaction();
        //     try{
        //         $model->attributes = $_POST['RMAsesmenFisioterapiKardiopulmonalT'];
        //         $model->kemampuan_fungsional = isset($_POST['RMAsesmenFisioterapiKardiopulmonalT']['det_fungsional'])?$_POST['RMAsesmenFisioterapiKardiopulmonalT']['det_fungsional'][0]['kemampuan_fungsional']:'';
        //         $model->inspeksi_statik_bentukdada = isset($_POST['RMAsesmenFisioterapiKardiopulmonalT']['det_statik_bentukdada'])?$_POST['RMAsesmenFisioterapiKardiopulmonalT']['det_statik_bentukdada'][0]['inspeksi_statik_bentukdada']:'';
        //         $model->inspeksi_dinamis = isset($_POST['RMAsesmenFisioterapiKardiopulmonalT']['det_dinamis'])?$_POST['RMAsesmenFisioterapiKardiopulmonalT']['det_dinamis'][0]['inspeksi_dinamis']:'';
        //         $model->palpasi_ekspansi_thorax = isset($_POST['RMAsesmenFisioterapiKardiopulmonalT']['det_palpasi_thorax'])?$_POST['RMAsesmenFisioterapiKardiopulmonalT']['det_palpasi_thorax'][0]['palpasi_ekspansi_thorax']:'';
        //         $model->palpasi_spasme_otot = isset($_POST['RMAsesmenFisioterapiKardiopulmonalT']['det_palpasi_spasme'])?$_POST['RMAsesmenFisioterapiKardiopulmonalT']['det_palpasi_spasme'][0]['palpasi_spasme_otot']:'';
        //         $model->khusus_perkusi = isset($_POST['RMAsesmenFisioterapiKardiopulmonalT']['det_khusus_perkusi'])?$_POST['RMAsesmenFisioterapiKardiopulmonalT']['det_khusus_perkusi'][0]['khusus_perkusi']:'';
        //         $model->khusus_auskultasi_suaranafas = isset($_POST['RMAsesmenFisioterapiKardiopulmonalT']['det_khusus_auskultasi_suara'])?$_POST['RMAsesmenFisioterapiKardiopulmonalT']['det_khusus_auskultasi_suara'][0]['khusus_auskultasi_suaranafas']:'';
        //
        //         if (empty($model->asesmen_fisioterapi_kardiopulmonal_id)){
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
        //         if($ok){
        //             $trans->commit();
        //             Yii::app()->user->setFlash('success',"Data Berhasil Disimpan");
        //             $this->redirect(array('index','pendaftaran_id'=>$pendaftaran_id,'pasienmasukpenunjang_id'=>$pasienmasukpenunjang_id,'asesmen_fisioterapi_kardiopulmonal_id'=>$model->asesmen_fisioterapi_kardiopulmonal_id,'sukses'=>1));
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
        //     'look' => $look
        // ));
    }
}
