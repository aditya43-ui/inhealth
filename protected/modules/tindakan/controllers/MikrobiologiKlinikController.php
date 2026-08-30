<?php
/**
 * controller utama rujukan mikobiologi klinik
 * 
 * @package application.modules.rawatJalan
 * @subpackage controllers
 * @author M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     2.0.0
 * @link    <http://172.9.1.15/simpp/docs/>
 * @link    <http://piindonesia.co.id>
 */
class MikrobiologiKlinikController extends MyAuthController
{
    public $layout='//layouts/iframe';
    public $defaultAction = 'index';
    protected $statusSaveKirimkeUnitLain = false;
    protected $statusSavePermintaanPenunjang = false;
    protected $tindakanpelayanantersimpan = true;
    protected $komponentindakantersimpan = true;
    protected $kirimSpesimen = true;
    protected $path_view = 'rawatJalan.views.mikrobiologiKlinik.';

    /**
     * method untuk mengirimkan pasien ke unit lain
     * digunakan di :
     * 1. rawatJalan/laboratorium/index
     * @param int $pendaftaran_id pendaftaran_id
     */
    public function actionIndex($pendaftaran_id,$idPasienKirimKeUnitLain=null)
	{
            $params = array();
            $modKirim = new KirimspesimenlabT();
            $modPendaftaran = RJPendaftaranT::model()->with('jeniskasuspenyakit')->findByPk($pendaftaran_id);
            $modPasien = RJPasienM::model()->findByPk($modPendaftaran->pasien_id);
            $modKirimKeUnitLain = new RJPasienKirimKeUnitLainT;
            $modKirimKeUnitLain->tgl_kirimpasien = date('Y-m-d H:i:s');
            $modKirimKeUnitLain->pegawai_id = $modPendaftaran->pegawai_id;
            $pegawai = PegawaiM::model()->findByPk($modKirimKeUnitLain->pegawai_id);
            $modKirimKeUnitLain->dpjp_nama = $pegawai->namaLengkap;
            $modKirimKeUnitLain->kelaspelayanan_id = Params::KELASPELAYANAN_ID_TANPA_KELAS; 
            $modPenunjang = PasienmasukpenunjangT::model()->findByAttributes(array('pendaftaran_id'=>$pendaftaran_id));
            // var_dump($modPenunjang);die;
            $ruangan_asal = Yii::app()->user->getState('ruangan_id');
            $modKirimKeUnitLain->no_permintaan = MyGenerator::generateNomorPermintaan($ruangan_asal);
            $criR = new CDbCriteria();
            $criR->addInCondition(" instalasi_id ", Params::getInsMikrobiologiKlinik());
            $criR->addCondition(" ruangan_aktif = TRUE ");
            $criR->order = " ruangan_nama ASC ";
            $r = RuanganM::model()->find($criR);
            
            $modMorbiditas = RJPasienMorbiditasT::model()->findByAttributes(array('kelompokdiagnosa_id' => 2, 'pendaftaran_id' => $modPendaftaran->pendaftaran_id, 'pasien_id' => $modPasien->pasien_id), array('order' => 'create_time DESC'));
            if (!empty($modMorbiditas->diagnosa_id)) {
                $modDiagnosa = DiagnosaM::model()->findByPk($modMorbiditas->diagnosa_id);
                $modKirimKeUnitLain->diagnosis = !empty($modMorbiditas->diagnosa_id) ? $modDiagnosa->diagnosa_nama : "";
            }
            
            if ($modPendaftaran->carabayar_id == Params::CARABAYAR_ID_MEMBAYAR && $modPendaftaran->penjamin_id == Params::PENJAMIN_ID_UMUM) $modKirimKeUnitLain->isbayarkekasirpenunjang = Yii::app()->user->getState('isbayarkekasirpenunjang');
            else $modKirimKeUnitLain->isbayarkekasirpenunjang = false;
            $modJenisPeriksaLab = RJJenisPemeriksaanLabM::model()->findAllByAttributes(array('jenispemeriksaanlab_aktif'=>true),array('order'=>'jenispemeriksaanlab_urutan')); 
            $modPeriksaLab = RJPemeriksaanLabM::model()->findAllByAttributes(array('pemeriksaanlab_aktif'=>true),array('order'=>'jenispemeriksaanlab_id, pemeriksaanlab_urutan'));
            
                                               
            $modJenisTarif = JenistarifpenjaminM::model()->find('penjamin_id ='.$modPendaftaran->penjamin_id);
            
            $criLab = new CDbCriteria();
            $criLab->select = " j.jenispemeriksaanlab_kelompok, t.* ";
            $criLab->join = " JOIN jenispemeriksaanlab_m j ON  j.jenispemeriksaanlab_id = t.jenispemeriksaanlab_id ";
            $criLab->addCondition(" kelaspelayanan_id = '".$modPendaftaran->kelaspelayanan_id."' ");
            $criLab->addCondition(" jenistarif_id = '".$modJenisTarif->jenistarif_id."' ");

            $criLab->addCondition(" penjamin_id = '".$modPendaftaran->penjamin_id."' ");
            $criLab->addCondition(" ruangan_id = '".Params::RUANGAN_ID_LAB_MIKROBIOLOGI."' ");
            $criLab->addInCondition(" instalasi_id ", Params::getInsMikrobiologiKlinik());
            $criLab->addCondition(" j.jenispemeriksaanlab_kelompok = '".Params::JENISPEMERIKSAANLAB_KELOMPOK_MIKROBIOLOGI."' ");
            $genLabTarif = RJTariftindakanlaboratoriumV::model()->findAll($criLab);
            
            $tarif_gen = array();
            foreach($genLabTarif as $lb){
                $tarif_gen[$lb->jenispemeriksaanlab_id]['jenispemeriksaanlab_nama'] = $lb->jenispemeriksaanlab_nama;
                $tarif_gen[$lb->jenispemeriksaanlab_id]['jenispemeriksaanlab_id'] = $lb->jenispemeriksaanlab_id;
                $tarif_gen[$lb->jenispemeriksaanlab_id]['jenispemeriksaanlab_kelompok'] = $lb->jenispemeriksaanlab_kelompok;
                $tarif_gen[$lb->jenispemeriksaanlab_id]['det'][$lb->pemeriksaanlab_id]['pemeriksaanlab_nama'] = $lb->pemeriksaanlab_nama;
                $tarif_gen[$lb->jenispemeriksaanlab_id]['det'][$lb->pemeriksaanlab_id]['pemeriksaanlab_id'] = $lb->pemeriksaanlab_id;                
                $tarif_gen[$lb->jenispemeriksaanlab_id]['det'][$lb->pemeriksaanlab_id]['ruangan_id'] = $lb->ruangan_id;
            }
            
            
            $nama_modul = Yii::app()->controller->module->id;
            $nama_controller = Yii::app()->controller->id;
            $nama_action = Yii::app()->controller->action->id;
            $modul_id = ModulK::model()->findByAttributes(array('url_modul'=>$nama_modul))->modul_id;
            $criteria = new CDbCriteria;
            $criteria->compare('modul_id',$modul_id);
            $criteria->compare('LOWER(modcontroller)',strtolower($nama_controller),true);
            $criteria->compare('LOWER(modaction)',strtolower($nama_action),true);
            if(isset($_POST['tujuansms'])){
                $criteria->addInCondition('tujuansms',$_POST['tujuansms']);
            }
            $modSmsgateway = SmsgatewayM::model()->findAll($criteria);

            $konsul = ($modPendaftaran->ruangan_id == Yii::app()->user->getState('ruangan_id'))?null:KonsulpoliT::model()->findByAttributes(array(
                'pendaftaran_id'=>$modPendaftaran->pendaftaran_id,
                'ruangan_id'=>Yii::app()->user->getState('ruangan_id'),
            ), array(
                'order'=>'tglkonsulpoli desc',
            ));
            
            if (!empty($konsul)) {
                $modKirimKeUnitLain->pegawai_id = $konsul->pegawai_id;
            }
            
            if(isset($idPasienKirimKeUnitLain)){
                $modKirimKeUnitLain = RJPasienKirimKeUnitLainT::model()->findByPk($idPasienKirimKeUnitLain);				
                $modPasien = $modKirimKeUnitLain->pasien;
            }
            
            
            if(isset($_POST['RJPasienKirimKeUnitLainT'])) {
                $transaction = Yii::app()->db->beginTransaction();
                try {
                    // echo'<pre>';
                    // var_dump($_POST);die;
                    if(isset($_POST['pemeriksaan'])){
                        $modKirimKeUnitLain = $this->savePasienKirimKeUnitLain($modPendaftaran, Params::RUANGAN_ID_LAB_KLINIK, Params::INSTALASI_ID_LAB);
                    }
                    // if(isset($_POST['permintaanPenunjangAnatomi'])){
                    //     //$modKirimKeUnitLainAnatomi = $this->savePasienKirimKeUnitLain($modPendaftaran, Params::RUANGAN_ID_LAB_ANATOMI);                       
                    //     $modKirimKeUnitLainAnatomi = $this->savePasienKirimKeUnitLain($modPendaftaran, Params::RUANGAN_ID_LAB_KLINIK, Params::INSTALASI_ID_LAB_PA);    // ruangan "Patologi Anatomi"                   
                    // var_dump('2');die;
                    // }

                    if(isset($_POST['permintaanPenunjang']) || isset($_POST['permintaanPenunjangAnatomi'])){
                        if(isset($_POST['permintaanPenunjang'])){
                            $this->savePermintaanPenunjang($_POST['permintaanPenunjang'],$modKirimKeUnitLain);
                        }
                        if(isset($_POST['permintaanPenunjangAnatomi'])){
                            $this->savePermintaanPenunjang($_POST['permintaanPenunjangAnatomi'],$modKirimKeUnitLainAnatomi);
                        }

                        $p = PendaftaranT::model()->findByPk($pendaftaran_id);
                        $updateStatusPeriksa = $p->setStatusPeriksa(Params::STATUSPERIKSA_SEDANG_PERIKSA);
                        
                        
                        $waktumulaiperiksa_now = date('Y-m-d H:i:s');
                        if (empty($p->waktumulaiperiksa)){
                            $updateWaktuPeriksa=PendaftaranT::model()->updateByPk($modPendaftaran->pendaftaran_id,array('waktumulaiperiksa'=>$waktumulaiperiksa_now)); 
                        }
                        
                        /* ================================================ */
                        /* Proses update status periksa KonsulPoli EHS-179  */
                        /* ================================================ */
                        $ruangan_id = isset($_GET['ruangan_id']) ? $_GET['ruangan_id'] : Yii::app()->user->getState('ruangan_id');
                        $konsulPoli = KonsulpoliT::model()->findByAttributes(array('pendaftaran_id'=>$pendaftaran_id, 'ruangan_id'=>$ruangan_id));
                        if(!empty($konsulPoli)){
                            $updateStatusPeriksa=KonsulpoliT::model()->updateByPk($konsulPoli->konsulpoli_id,array('statusperiksa'=>Params::STATUSPERIKSA_SEDANG_PERIKSA));
                        }
                        /* ================================================ */
                        PendaftaranT::model()->updateByPk($pendaftaran_id, array('pembayaranpelayanan_id'=>null));
                    } else {
                        $this->statusSavePermintaanPenunjang = true;
                    }
                    
                    $judul = 'Pasien Rujuk ke Laboratorium';
                    
                    $isi = $modPasien->no_rekam_medik.' - '.$modPasien->nama_pasien;
                    
                    // if (!empty($modKirimKeUnitLain->pendaftaran_id)){
                    //         $mr = RuanganM::model()->findByPk($modKirimKeUnitLain->ruangan_id);
                            
                    //         $link = $this->createUrl('/laboratorium/RujukanPenunjang/Index',array(
                    //                 'LBPasienKirimKeUnitLainV[tgl_awal]'=>date('Y-m-d', strtotime($modKirimKeUnitLain->tgl_kirimpasien)),
                    //                 'LBPasienKirimKeUnitLainV[tgl_akhir]'=>date('Y-m-d', strtotime($modKirimKeUnitLain->tgl_kirimpasien)),
                    //                 'LBPasienKirimKeUnitLainV[no_pendaftaran]'=>substr($modKirimKeUnitLain->pendaftaran->no_pendaftaran,2),			
                    //                 'LBPasienKirimKeUnitLainV[prefix_pendaftaran]'=>substr($modKirimKeUnitLain->pendaftaran->no_pendaftaran,0,2),			
                    //                 'LBPasienKirimKeUnitLainV[no_rekam_medik]'=>$modPasien->no_rekam_medik,
                    //                 'LBPasienKirimKeUnitLainV[nama_pasien]'=>$modPasien->nama_pasien
                    //         ));

                    //         $ok = CustomFunction::broadcastNotif($judul, $isi, array(
                    //                 array('instalasi_id'=>$mr->instalasi_id, 'ruangan_id'=>$mr->ruangan_id, 'modul_id'=>$mr->modul_id, 'link_proses' => $link),
                    //                 // array('instalasi_id'=>Params::INSTALASI_ID_FARMASI, 'ruangan_id'=>Params::RUANGAN_ID_APOTEK_RJ, 'modul_id'=>10),
                    //                 array('instalasi_id'=>Params::INSTALASI_ID_KASIR, 'ruangan_id'=>Params::RUANGAN_ID_KASIR, 'modul_id'=>19),
                    //         ));
                    // }else{
                    //         $mr = RuanganM::model()->findByPk($modKirimKeUnitLainAnatomi->ruangan_id);
                    //         $link = $this->createUrl('/laboratorium/RujukanPenunjang/Index',array(
                    //                 'LBPasienKirimKeUnitLainV[tgl_awal]'=>date('Y-m-d', strtotime($modKirimKeUnitLainAnatomi->tgl_kirimpasien)),
                    //                 'LBPasienKirimKeUnitLainV[tgl_akhir]'=>date('Y-m-d', strtotime($modKirimKeUnitLainAnatomi->tgl_kirimpasien)),
                    //                 'LBPasienKirimKeUnitLainV[no_pendaftaran]'=>substr($modKirimKeUnitLainAnatomi->pendaftaran->no_pendaftaran,2),			
                    //                 'LBPasienKirimKeUnitLainV[prefix_pendaftaran]'=>substr($modKirimKeUnitLainAnatomi->pendaftaran->no_pendaftaran,0,2),			
                    //                 'LBPasienKirimKeUnitLainV[no_rekam_medik]'=>$modPasien->no_rekam_medik,
                    //                 'LBPasienKirimKeUnitLainV[nama_pasien]'=>$modPasien->nama_pasien
                    //         ));

                    //         $ok = CustomFunction::broadcastNotif($judul, $isi, array(
                    //                 array('instalasi_id'=>$mr->instalasi_id, 'ruangan_id'=>$mr->ruangan_id, 'modul_id'=>$mr->modul_id, 'link_proses' => $link),
                    //                 // array('instalasi_id'=>Params::INSTALASI_ID_FARMASI, 'ruangan_id'=>Params::RUANGAN_ID_APOTEK_RJ, 'modul_id'=>10),
                    //                 array('instalasi_id'=>Params::INSTALASI_ID_KASIR, 'ruangan_id'=>Params::RUANGAN_ID_KASIR, 'modul_id'=>19),
                    //         ));
                    // }
                    if(isset($_POST['samplelab'])){
                        $this->saveKirimSpesimenLab($_POST['samplelab'], $modKirimKeUnitLain->pasienkirimkeunitlain_id);
                    }
                    // var_dump($this->statusSaveKirimkeUnitLain, $this->statusSavePermintaanPenunjang , $this->tindakanpelayanantersimpan , $this->kirimSpesimen);die;
                    if($this->statusSaveKirimkeUnitLain && $this->statusSavePermintaanPenunjang && $this->tindakanpelayanantersimpan && $this->kirimSpesimen){
                        // SMS GATEWAY
                        $modPegawai = $modPendaftaran->pegawai;
                        $sms = new Sms();
                        $smspasien = 1;
                        foreach ($modSmsgateway as $i => $smsgateway) {
                            $isiPesan = $smsgateway->templatesms;

                            $attributes = $modPasien->getAttributes();
                            foreach($attributes as $attributes => $value){
                                $isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
                            }
                            $attributes = $modPendaftaran->getAttributes();
                            foreach($attributes as $attributes => $value){
                                $isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
                            }
                            $attributes = $modPegawai->getAttributes();
                            foreach($attributes as $attributes => $value){
                                $isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
                            }
                            $attributes = $modKirimKeUnitLain->getAttributes();
                            foreach($attributes as $attributes => $value){
                                $isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
                            }
                            $isiPesan = str_replace("{{hari}}",MyFormatter::getDayName($modKirimKeUnitLain->tgl_kirimpasien),$isiPesan);
    
                            if($smsgateway->tujuansms == Params::TUJUANSMS_PASIEN && $smsgateway->statussms){
                                if(!empty($modPasien->no_mobile_pasien)){
                                    $sms->kirim($modPasien->no_mobile_pasien,$isiPesan);
                                }else{
                                    $smspasien = 0;
                                }
                            }
                        }
                        // END SMS GATEWAY
                        $transaction->commit();
                        Yii::app()->user->setFlash('success',"Data Berhasil disimpan");
						if (!empty($modKirimKeUnitLain->pendaftaran_id)){
							$this->redirect(array('index','pendaftaran_id'=>$pendaftaran_id, 'idPasienKirimKeUnitLain'=>$modKirimKeUnitLain->pasienkirimkeunitlain_id,'sukses'=>1,'smspasien'=>$smspasien));
						}else{
							$this->redirect(array('index','pendaftaran_id'=>$pendaftaran_id, 'idPasienKirimKeUnitLain'=>$modKirimKeUnitLainAnatomi->pasienkirimkeunitlain_id,'sukses'=>1,'smspasien'=>$smspasien));
						}
                    } else {
                        $transaction->rollback();
                        Yii::app()->user->setFlash('error',"Data gagal disimpan! ");
                    }
                } catch (Exception $exc) {
                    // echo'<pre>';
                    // var_dump($exc);die;
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error',"Data Gagal disimpan. ".MyExceptionMessage::getMessage($exc,true));
                }
            }
            
            $criRiwayat = new CDbCriteria();
            $criRiwayat->join = " JOIN ruangan_m r ON r.ruangan_id = t.ruangan_id "
                    . "JOIN instalasi_m i ON i.instalasi_id = r.instalasi_id ";
            $criRiwayat->addCondition(" pendaftaran_id =".$pendaftaran_id);
            $criRiwayat->addCondition(" pasienmasukpenunjang_id IS NULL ");
            // $criRiwayat->addInCondition(" i.instalasi_id ",Params::getInsMikrobiologiKlinik());
            $modRiwayatKirimKeUnitLain = RJPasienKirimKeUnitLainT::model()->findAll($criRiwayat);
            // echo'<pre>';
            // var_dump($modRiwayatKirimKeUnitLain);die;
           // $modRiwayatKirimKeUnitLain = RJPasienKirimKeUnitLainT::model()->findAllByAttributes(array('pendaftaran_id'=>$pendaftaran_id),
             //   'pasienmasukpenunjang_id IS NULL AND ruangan_id IN('.Params::RUANGAN_ID_LAB_KLINIK.','.Params::RUANGAN_ID_LAB_ANATOMI.')');
		
            $this->render($this->path_view.'index',array('modPendaftaran'=>$modPendaftaran,
                                        'modPasien'=>$modPasien,
                                        'modKirimKeUnitLain'=>$modKirimKeUnitLain,
                                        'modJenisPeriksaLab'=>$modJenisPeriksaLab,
                                        'modPeriksaLab'=>$modPeriksaLab,
                                        'modRiwayatKirimKeUnitLain'=>$modRiwayatKirimKeUnitLain,
                                        'modJenisTarif'=>$modJenisTarif,
                                        'genLabTarif'=>$genLabTarif,
                                        'tarif_gen'=>$tarif_gen,
                                        'modKirim' => $modKirim,
                                        'modPenunjang' =>$modPenunjang,
                                        ));
	}
        
        protected function saveKirimSpesimenLab($sample,$modKirimKeUnitLain)
        {
            foreach ($sample['samplelab_id'] as $i => $value) {
                $modKirim = new KirimspesimenlabT();
                $modKirim->samplelab_id = isset($sample['samplelab_id'][$i]) ? $sample['samplelab_id'][$i] : null;
                $modKirim->pasienkirimkeunitlain_id = $modKirimKeUnitLain;
                $modKirim->lokasi = !empty($sample['lokasi'][$i]) ? $sample['lokasi'][$i]: null;

                if($modKirim->validate()){
                    if ($modKirim->save()){
                        $this->kirimSpesimen = true;
                    }
                }
            }
            
        }

        /**
         * method untuk menyimpan data pasien ke unit lain RJPasienKirimkeUnitLainT
         * digunakan di :
         * 1. rawatJalan/laboratorium/index
         * @param object $modPendaftaran model PendaftaranT
         * @return \RJPasienKirimKeUnitLainT 
         */
        protected function savePasienKirimKeUnitLain($modPendaftaran, $ruangan_lab, $instalasi_lab)
        {
            $modKirimKeUnitLain = new RJPasienKirimKeUnitLainT;
            $modKirimKeUnitLain->attributes = $_POST['RJPasienKirimKeUnitLainT'];
            $modKirimKeUnitLain->pasien_id = $modPendaftaran->pasien_id;
            $modKirimKeUnitLain->pendaftaran_id = $modPendaftaran->pendaftaran_id;
            //$modKirimKeUnitLain->instalasi_id = $instalasi_lab;
            //$modKirimKeUnitLain->ruangan_id = $ruangan_lab;
            $modKirimKeUnitLain->kelaspelayanan_id = $modPendaftaran->kelaspelayanan_id;
            $modKirimKeUnitLain->instalasi_id = $modKirimKeUnitLain->ruangan->instalasi_id;
            $modKirimKeUnitLain->tgl_kirimpasien = MyFormatter::formatDateTimeForDb($modKirimKeUnitLain->tgl_kirimpasien);
            $modKirimKeUnitLain->create_loginpemakai_id = Yii::app()->user->id;
            $modKirimKeUnitLain->update_loginpemakai_id = Yii::app()->user->id;
            $modKirimKeUnitLain->create_ruangan = isset($_GET['ruangan_id']) ? $_GET['ruangan_id'] : Yii::app()->user->getState('ruangan_id');
            $modKirimKeUnitLain->waktuambilspesimen = MyFormatter::formatDateTimeForDb($modKirimKeUnitLain->waktuambilspesimen);
            $modKirimKeUnitLain->create_time = date( 'Y-m-d H:i:s');
            $modKirimKeUnitLain->update_time = date( 'Y-m-d H:i:s');
            $modKirimKeUnitLain->isbayarkekasirpenunjang = isset($_POST['RJPasienKirimKeUnitLainT']['isbayarkekasirpenunjang']) ? $_POST['RJPasienKirimKeUnitLainT']['isbayarkekasirpenunjang'] : 0;
            $modKirimKeUnitLain->nourut = MyGenerator::noUrutPasienKirimKeUnitLain($modKirimKeUnitLain->ruangan_id);
            // echo'<pre>';
            // var_dump($modKirimKeUnitLain);die;
            
            if($modKirimKeUnitLain->validate()){
                if ($modKirimKeUnitLain->save()){
                    $this->statusSaveKirimkeUnitLain = true;
				}
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
        protected function savePermintaanPenunjang($permintaan,$modKirimKeUnitLain)
        {
            foreach ($permintaan['inputpemeriksaanlab'] as $i => $value) {
                
                $modPermintaan = new RJPermintaanPenunjangT;
                $modPermintaan->daftartindakan_id = isset($permintaan['idDaftarTindakan'][$i]) ? $permintaan['idDaftarTindakan'][$i] : null;
                $modPermintaan->pemeriksaanlab_id = $permintaan['inputpemeriksaanlab'][$i];
                $modPermintaan->pemeriksaanrad_id = '';
                $modPermintaan->pasienkirimkeunitlain_id = $modKirimKeUnitLain->pasienkirimkeunitlain_id;
                $modPermintaan->noperminatanpenujang = MyGenerator::noPermintaanPenunjang('PL');
                $modPermintaan->qtypermintaan = $permintaan['inputqty'][$i];
                $modPermintaan->tarif_pelayananan = $permintaan['inputtarifpemeriksaanlab'][$i];
                $modPermintaan->tglpermintaankepenunjang = MyFormatter::formatDateTimeForDb($modKirimKeUnitLain->tgl_kirimpasien);
                
                // insert paket pelayanan
                if (isset($permintaan['tindakanpelayanan_id'][$i])) {
                    $modPermintaan->tindakanpelayanan_id = $permintaan['tindakanpelayanan_id'][$i];
                }
                if($modPermintaan->validate()){
                    if ($modPermintaan->save()){
                        $this->statusSavePermintaanPenunjang = true;
                        
                        // insert tindakan, jika bayar kasir di centang dan belum ada tindakan dari paket.
                        if($modKirimKeUnitLain->isbayarkekasirpenunjang && empty($modPermintaan->tindakanpelayanan_id)){ 
                            $modPendaftaran = $modKirimKeUnitLain->pendaftaran;
                            $modTindakan = $this->simpanTindakanPelayanan($modPendaftaran,$modKirimKeUnitLain,$modPermintaan); //AGAR BISA DI BAYAR DI KASIR
                            $modPermintaan->tindakanpelayanan_id = $modTindakan->tindakanpelayanan_id;
                            $modPermintaan->update();
                        }
                    }
                }
                
            }
            
        }
		
		/**
         * proses simpan TindakanPelayananT dan TindakanKomponenT
		 * khusus untuk permintaan penunjang
         */
        public function simpanTindakanPelayanan($modPendaftaran, $modKirimKeUnitLain, $modPermintaan){
            $modTindakan = new RJTindakanPelayananT;
            
            $modTindakan->attributes = $modPendaftaran->attributes;
            $modTindakan->ruangan_id = $modKirimKeUnitLain->ruangan_id;
            $modTindakan->instalasi_id = $modTindakan->ruangan->instalasi_id;
            $modTindakan->pendaftaran_id = $modPendaftaran->pendaftaran_id;
            $modTindakan->daftartindakan_id = $modPermintaan->daftartindakan_id;
            $modTindakan->tarif_satuan = $modPermintaan->tarif_pelayananan;
            $modTindakan->qty_tindakan = $modPermintaan->qtypermintaan;
            $modTindakan->satuantindakan = Params::SATUAN_TINDAKAN_LABORATORIUM;
            $modTindakan->create_time = date("Y-m-d H:i:s");
            $modTindakan->create_loginpemakai_id = Yii::app()->user->id;
            $modTindakan->create_ruangan = Yii::app()->user->getState('ruangan_id');
            $modTindakan->shift_id =Yii::app()->user->getState('shift_id');
            $modTindakan->dokterpemeriksa1_id=$modKirimKeUnitLain->pegawai_id;
            $modTindakan->perawat_id = (!empty($modKirimKeUnitLain->perawat_id) ? $modKirimKeUnitLain->perawat_id : null);
            $modTindakan->tgl_tindakan=$modPermintaan->tglpermintaankepenunjang;
            $modTindakan->instalasi_id = $modTindakan->ruangan->instalasi_id;
            $modTindakan->tarif_satuan = $modTindakan->getTarifSatuan(); //RND-7248
            $modTindakan->tarif_tindakan=$modTindakan->tarif_satuan * $modTindakan->qty_tindakan;
            $modTindakan->cyto_tindakan=0;
            $modTindakan->tarifcyto_tindakan=0;
            $modTindakan->discount_tindakan=0;
            $modTindakan->subsidiasuransi_tindakan=0;
            $modTindakan->subsidipemerintah_tindakan=0;
            $modTindakan->subsisidirumahsakit_tindakan=0;
            $modTindakan->iurbiaya_tindakan=0;
            $modTindakan->tarif_rsakomodasi=0;
            $modTindakan->tarif_medis=0;
            $modTindakan->tarif_paramedis=0;
            $modTindakan->tarif_bhp=0;
            
            if($modTindakan->validate()){
                if($modTindakan->save()){
					$this->komponentindakantersimpan &= $modTindakan->saveTindakanKomponen();
				}
            }else{
                $this->tindakanpelayanantersimpan &= false;
            }
                
            return $modTindakan;
        }
        
        public function actionAjaxBatalKirim()
        {
            if(Yii::app()->request->isAjaxRequest) {
				$pasienkirimkeunitlain_id = $_POST['pasienkirimkeunitlain_id'];
				$pendaftaran_id = $_POST['pendaftaran_id'];
				$data['pesan'] = "Pasien kirim ke laboratorium gagal dibatalkan!";
				$data['sukses'] = 0;
				$kirimUnit = array();
				
				$status = 'ok';
                                
				$transaction = Yii::app()->db->beginTransaction();
				try {
					$criteria = new CDbCriteria();
					$criteria->select = "count(t.permintaankepenunjang_id) as permintaankepenunjang_id";
					$criteria->join = "join tindakanpelayanan_t tp on tp.tindakanpelayanan_id = t.tindakanpelayanan_id ";
					$criteria->addCondition("t.pasienkirimkeunitlain_id = ".$pasienkirimkeunitlain_id." and tp.tindakansudahbayar_id is not null");
					$permintaan = PermintaankepenunjangT::model()->find($criteria);

					if ($permintaan->permintaankepenunjang_id > 0) {
						$data['pesan'] = "Pasien kirim ke laboratorium tidak bisa dibatalkan karena tindakan sudah dibayarkan!";
						$data['sukses'] = 0;
					} else {
						$ok = true;
						$kirim = PasienkirimkeunitlainT::model()->findByPk($pasienkirimkeunitlain_id);

						if (!empty($kirim)){
							$kirimUnit = array(
								'instalasi_id' => $kirim->instalasi_id,
								'ruangan_id' => $kirim->ruangan_id,
								'pasien_id' => $kirim->pasien_id,
								'no_pendaftaran' => $kirim->pendaftaran->no_pendaftaran
							);
						}


						$permintaan = PermintaankepenunjangT::model()->findAllByAttributes(array(
							'pasienkirimkeunitlain_id'=>$pasienkirimkeunitlain_id
						));
						foreach ($permintaan as $item) {
							if (!empty($item->tindakanpelayanan_id)) {
								$ok = $ok && TindakanpelayananT::model()->deleteByPk($item->tindakanpelayanan_id);
							}
						}
						$ok = $ok && PermintaankepenunjangT::model()->deleteAllByAttributes(array('pasienkirimkeunitlain_id'=>$pasienkirimkeunitlain_id));
						$ok = $ok && PasienkirimkeunitlainT::model()->deleteByPk($pasienkirimkeunitlain_id);
						$keterangan = "Pasien berhasil dibatalkan";

						if($status == 'ok' && $ok) {

								$this->notifBatalRujuk($kirimUnit);

								$data['pesan'] = "Pasien kirim ke laboratorium berhasil dibatalkan!";
								$data['sukses'] = 1;
								$transaction->commit();
						} else {
								$transaction->rollback();
								$data['pesan'] = "Pasien kirim ke laboratorium tidak bisa dibatalkan karena tindakan sudah dibayarkan!";
								$data['sukses'] = 0;
						}
					}
				}catch (Exception $exc) {
					$transaction->rollback();
					$data['pesan'] = "Pasien kirim ke laboratorium gagal dibatalkan karena tindakan sudah dibayarkan!";
					$data['sukses'] = 0;
				}
				$modRiwayatKirimKeUnitLain = RJPasienKirimKeUnitLainT::model()->findAllByAttributes(array('pendaftaran_id'=>$pendaftaran_id),
						'pasienmasukpenunjang_id IS NULL AND ruangan_id IN('.Params::RUANGAN_ID_LAB_KLINIK.','.Params::RUANGAN_ID_LAB_ANATOMI.')');
				$data['result'] = $this->renderPartial($this->path_view.'_listKirimKeUnitLain', array('modRiwayatKirimKeUnitLain'=>$modRiwayatKirimKeUnitLain), true);

				echo json_encode($data);
				 Yii::app()->end();
            }
        }
        
        public function actionPrint()
        {
             $pendaftaran_id = $_GET['id'];
             $idPasienKirimKeUnitLain = $_GET['idPasienKirimKeUnitLain'];
             $modPendaftaran= PendaftaranT::model()->findByPk($pendaftaran_id);
             $modRiwayatKirimKeUnitLain = RJPasienKirimKeUnitLainT::model()->findAllByAttributes(array('pendaftaran_id'=>$pendaftaran_id,
                'pasienkirimkeunitlain_id'=>$idPasienKirimKeUnitLain),
                'pasienmasukpenunjang_id IS NULL');

            $judulLaporan='Permintaan Pemeriksaan Mikrobiologi Klinik';
            $caraPrint=$_REQUEST['caraPrint'];
            if($caraPrint=='PRINT') {
                $this->layout='//layouts/printWindows';
                $this->render($this->path_view.'Print',array('modPendaftaran'=>$modPendaftaran,'modRiwayatKirimKeUnitLain'=>$modRiwayatKirimKeUnitLain,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
            }
            else if($caraPrint=='EXCEL') {
                $this->layout='//layouts/printExcel';
                $this->render($this->path_view.'Print',array('modPendaftaran'=>$modPendaftaran,'modRiwayatKirimKeUnitLain'=>$modRiwayatKirimKeUnitLain,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
            }
            else if($_REQUEST['caraPrint']=='PDF') {
                $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
                $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
                $mpdf = new MyPDF('',$ukuranKertasPDF); 
                $mpdf->useOddEven = 2;  
                $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
                $mpdf->WriteHTML($stylesheet,1);  
                $mpdf->AddPage($posisi,'','','','',15,15,15,15,15,15);
                $mpdf->WriteHTML($this->renderPartial($this->path_view.'Print',array('modPendaftaran'=>$modPendaftaran,'modRiwayatKirimKeUnitLain'=>$modRiwayatKirimKeUnitLain,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint),true));
                $mpdf->Output();
            }                       
        }

        public function actionPrintRiwayat()
        {
             $pendaftaran_id = $_GET['id'];
             $modPendaftaran= PendaftaranT::model()->findByPk($pendaftaran_id);
             $modKirimKeUnitLain = RJPasienKirimKeUnitLainT::model()->findAll('pendaftaran_id='.$pendaftaran_id);
             $modRiwayatKirimKeUnitLain = RJPasienKirimKeUnitLainT::model()->findAllByAttributes(array('pendaftaran_id'=>$pendaftaran_id,'instalasi_id'=>Params::INSTALASI_ID_LAB),
                'pasienmasukpenunjang_id IS NULL');
            
            $judulLaporan='Permintaan Pemeriksaan Laboratorium';
            $caraPrint=$_REQUEST['caraPrint'];
            if($caraPrint=='PRINT') {
                $this->layout='//layouts/printWindows';
                $this->render($this->path_view.'printRiwayat',array('modKirimKeUnitLain'=> $modKirimKeUnitLain,'modPendaftaran'=>$modPendaftaran,'modRiwayatKirimKeUnitLain'=>$modRiwayatKirimKeUnitLain,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
            }
            else if($caraPrint=='EXCEL') {
                $this->layout='//layouts/printExcel';
                $this->render($this->path_view.'printRiwayat',array('modKirimKeUnitLain'=> $modKirimKeUnitLain,'modPendaftaran'=>$modPendaftaran,'modRiwayatKirimKeUnitLain'=>$modRiwayatKirimKeUnitLain,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
            }
            else if($_REQUEST['caraPrint']=='PDF') {
                $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
                $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
                $mpdf = new MyPDF('',$ukuranKertasPDF); 
                $mpdf->useOddEven = 2;  
                $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
                $mpdf->WriteHTML($stylesheet,1);  
                $mpdf->AddPage($posisi,'','','','',15,15,15,15,15,15);
                $mpdf->WriteHTML($this->renderPartial($this->path_view.'printRiwayat',array('modKirimKeUnitLain'=> $modKirimKeUnitLain,'modPendaftaran'=>$modPendaftaran,'modRiwayatKirimKeUnitLain'=>$modRiwayatKirimKeUnitLain,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint),true));
                $mpdf->Output();
            }                       
        }

        /**
         * @author Deni Hamdani <denihamdani@piindonesia.co.id>
         * 
         * Ajax untuk load pemeriksaan lab ketika di cekllist
         * 
         * - Jika terdapat tindakan lab yang merupakan bagian dari Paket Tindakan selain
         * NON PAKET, maka akan dicari tindakan-nya yang belum dipakai rujuk. Kemudian,
         * dipasang ke view Row Pemeriksaan Lab untuk Rujukan.
         * - Pada baris pemeriksaan yang termasuk Paket Tindakan selain NON PAKET
         * ditampilkan dengan qty di-set readonly. 
         *
         */
        public function actionLoadFormPemeriksaanLab()
        {
            if (Yii::app()->request->isAjaxRequest)
            {
                $pemeriksaanlab_id = (isset($_POST['pemeriksaanlab_id']) ? $_POST['pemeriksaanlab_id'] : null);
                $kelaspelayanan_id = (isset($_POST['kelaspelayanan_id']) ? $_POST['kelaspelayanan_id'] : null);
                $pendaftaran_id = (isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null);
                $ruangan_id = (isset($_POST['ruangan_id']) ? $_POST['ruangan_id'] : Params::RUANGAN_ID_LAB_KLINIK);
                $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);        
                
                $criteria = new CDbCriteria();
                $criteria->addCondition('pemeriksaanlab_id = '.$pemeriksaanlab_id);
//                $criteria->addCondition('kelaspelayanan_id = '.$kelaspelayanan_id); 
                $criteria->addCondition('kelaspelayanan_id = 4'); // default kelas pelayanan kelas 3 kelaspelayanan_id= 4
                $criteria->addCondition('penjamin_id = '.$modPendaftaran->penjamin_id);
                $criteria->addCondition('ruangan_id = '.$ruangan_id);
                $modTarif = TarifpemeriksaanlabruanganV::model()->find($criteria);
                
                $id_tindakan = null;
                $paket = null;
                
                if (!empty($modTarif)) {
                    $crPaket = new CDbCriteria();
                    $crPaket->compare('t.daftartindakan_id', $modTarif->daftartindakan_id);
                    $crPaket->addCondition('t.tipepaket_id <> '.Params::TIPEPAKET_ID_NONPAKET);
                    $crPaket->join = 'left join permintaankepenunjang_t p on t.tindakanpelayanan_id = p.tindakanpelayanan_id';
                    $crPaket->addCondition('p.tindakanpelayanan_id is null');
                    $crPaket->order = 'p.tindakanpelayanan_id asc';
                    
                    $tindakanPaket = TindakanpelayananT::model()->find($crPaket);
                    
                    if (!empty($tindakanPaket)) {
                        $id_tindakan = $tindakanPaket->tindakanpelayanan_id;
                        $paket = TipepaketM::model()->findByPk($tindakanPaket->tipepaket_id);
                    }
                }
                
                
                echo CJSON::encode(array(
                    'status'=>'create_form', 
                    'form'=>$this->renderPartial($this->path_view.'_formLoadPemeriksaanLab', array('modTarif'=>$modTarif, 'id_tindakan'=>$id_tindakan, 'paket'=>$paket), true)));
                exit;               
            }
        }
		
        /**
         * - digunakan untuk mengenerate notif batal rujukan
         * @param type $modKirimKeunitlain
         */
        protected function notifBatalRujuk($modKirimKeunitlain) {
            
            $modRuangan = RuanganM::model()->findByPk($modKirimKeunitlain['ruangan_id']);
            $pasien_id = $modKirimKeunitlain['pasien_id'];
            $modPasien = PasienM::model()->findByPk($pasien_id);
            $judul = 'Pasien Batal Rujuk Laboratorium';

            $isi = $modKirimKeunitlain['no_pendaftaran'].' '.$modPasien->no_rekam_medik.' '.$modPasien->nama_pasien;                    
                        
            
            $ok = CustomFunction::broadcastNotif($judul, $isi, array(
                array('instalasi_id'=>$modKirimKeunitlain['instalasi_id'], 'ruangan_id'=>$modRuangan->ruangan_id, 'modul_id'=>$modRuangan->modul_id),				
            )); 
        }
    
        /**
         * Load tarif Lab
         */
        public function actionLoadTarifLab(){
            if (Yii::app()->request->isAjaxRequest){
                $pendaftaran_id = isset($_POST['pendaftaran_id'])? $_POST['pendaftaran_id'] : null;
                $kelaspelayanan_id = isset($_POST['kelaspelayanan_id'])? $_POST['kelaspelayanan_id'] : null;
                $penjamin_id = isset($_POST['penjamin_id'])? $_POST['penjamin_id'] : null;
                $ruangan_id = isset($_POST['ruangan_id'])? $_POST['ruangan_id'] : null;
                $jenistarif_id = isset($_POST['jenistarif_id'])? $_POST['jenistarif_id'] : null;
                $periksalab = isset($_POST['periksalab'])? $_POST['periksalab'] : null;

                $criLab = new CDbCriteria();
                $criLab->select = " j.jenispemeriksaanlab_kelompok, t.* ";
                $criLab->join = " JOIN jenispemeriksaanlab_m j ON  j.jenispemeriksaanlab_id = t.jenispemeriksaanlab_id ";
                $criLab->addCondition(" kelaspelayanan_id = '".$kelaspelayanan_id."' ");
                $criLab->addCondition(" jenistarif_id = '".$jenistarif_id."' ");
                $criLab->addCondition(" ruangan_id = '".$ruangan_id."' ");
                $criLab->addCondition(" penjamin_id = '".$penjamin_id."' ");
                //$criLab->addInCondition(" instalasi_id ", Params::getInsPatologiKlinik());
                $criLab->addCondition(" j.jenispemeriksaanlab_kelompok = '".Params::JENISPEMERIKSAANLAB_KELOMPOK_MIKROBIOLOGI."' ");
                $criLab->compare(" LOWER(t.pemeriksaanlab_nama) ", strtolower($periksalab),true);
                $genLabTarif = TariftindakanlaboratoriumV::model()->findAll($criLab);

                $tarif_gen = array();
                if (!empty($genLabTarif)){
                    foreach($genLabTarif as $lb){
                        $tarif_gen[$lb->jenispemeriksaanlab_id]['jenispemeriksaanlab_nama'] = $lb->jenispemeriksaanlab_nama;
                        $tarif_gen[$lb->jenispemeriksaanlab_id]['jenispemeriksaanlab_id'] = $lb->jenispemeriksaanlab_id;
                        $tarif_gen[$lb->jenispemeriksaanlab_id]['jenispemeriksaanlab_kelompok'] = $lb->jenispemeriksaanlab_kelompok;
                        $tarif_gen[$lb->jenispemeriksaanlab_id]['det'][$lb->pemeriksaanlab_id]['pemeriksaanlab_nama'] = $lb->pemeriksaanlab_nama;
                        $tarif_gen[$lb->jenispemeriksaanlab_id]['det'][$lb->pemeriksaanlab_id]['pemeriksaanlab_id'] = $lb->pemeriksaanlab_id;                
                        $tarif_gen[$lb->jenispemeriksaanlab_id]['det'][$lb->pemeriksaanlab_id]['ruangan_id'] = $lb->ruangan_id;
                    }
                }
                $tr = $this->renderPartial($this->path_view."_listPemeriksaan",array('tarif_gen'=>$tarif_gen),true);

                $data['sukses'] = 1;
                $data['status'] = 1;
                $data['pesan'] = '';
                $data['html'] = $tr;

                echo json_encode($data);
                Yii::app()->end();
            }
        }

        /**
         * Load data tarif bahan spesimen
         */
        public function actionLoadBahanSpesimen()
        {
            if (Yii::app()->request->isAjaxRequest) {
                $periksabahan = $_POST['periksabahan'] ?? null;
                $lokasi = $_POST['lokasi'] ?? null;
                $subjenis_pemeriksaanlab_id = $_POST['subjenis_pemeriksaanlab_id'] ?? null;
    
                $bahan_gen = array();
                // $cri = new CDbCriteria();
                // $cri->order = "t.samplelab_nama ASC";
                // $cri->compare(" LOWER(t.samplelab_nama) ", strtolower($periksabahan),true);
                // $bahan = SamplelabM::model()->findAll($cri);
    
    
                $cri = new CDbCriteria;
                $cri->addCondition("jenispemeriksaanlab_kelompok = '" . Params::JENISPEMERIKSAANLAB_KELOMPOK_MIKROBIOLOGI . "' ");
    
                $is_paket = 0;
                if (!empty($subjenis_pemeriksaanlab_id)) {
                    $cri->compare('subjenis_pemeriksaanlab_id', $subjenis_pemeriksaanlab_id);
                    $cri->addCondition('is_paket = true');
                    $is_paket = 1;
                } else {
                    $cri->addCondition('is_paket = false');
                }
    
                // $cri->order = "samplelab_nama ASC";
                $cri->compare('lower(pemeriksaanlab_nama)', strtolower($periksabahan), true);
    
    
                $pemeriksaan = OrderpemeriksaanlabV::model()->findAll($cri);    
                $jenispemerisaan_id = [];
                $pemeriksaan_id = [];
                $pemeriksaan_data = [];
    
                if (!empty($pemeriksaan)) {
                    foreach ($pemeriksaan as $val) {
                        $jenispemerisaan_id[] = $val->jenispemeriksaanlab_id;
                        $pemeriksaan_id[] = $val->pemeriksaanlab_id;
                        $pemeriksaan_data[$val->jenispemeriksaanlab_id][] = $val;
                    }
                }
    
    
                if (count($pemeriksaan_id) > 0) {
                    $cri = new CDbCriteria();
                    $cri->addInCondition('t.jenispemeriksaanlab_id', $jenispemerisaan_id);
                    $cri->addInCondition('o.pemeriksaanlab_id', $pemeriksaan_id);
                    $cri->addCondition('t.jenispemeriksaanlab_aktif = true');
                    $cri->addCondition("t.jenispemeriksaanlab_kelompok ='" . Params::JENISPEMERIKSAANLAB_KELOMPOK_MIKROBIOLOGI . "'");
                    $cri->addCondition('o.is_paket = ' . (($is_paket == 1) ? "true" : "false"));
                    $cri->join = 'JOIN orderpemeriksaanlab_v o ON o.jenispemeriksaanlab_id = t.jenispemeriksaanlab_id ';
                    $bahan = JenispemeriksaanlabM::model()->findAll($cri);
    
                    //vaR_dump($cri, count($bahan)); die;
                } else {
                    $cri = new CDbCriteria();
                    $cri->addCondition('t.jenispemeriksaanlab_aktif = true');
                    $cri->addCondition("t.jenispemeriksaanlab_kelompok ='" . Params::JENISPEMERIKSAANLAB_KELOMPOK_MIKROBIOLOGI . "'");
                    //$cri->addCondition('o.is_paket = ' . (($is_paket == 1) ? "true" : "false"));
                    //$cri->join = 'JOIN orderpemeriksaanlab_v o ON o.jenispemeriksaanlab_id = t.jenispemeriksaanlab_id ';
                    $bahan = JenispemeriksaanlabM::model()->findAll($cri);
                }
    
                // var_dump($jenispemerisaan_id);die;
    
                foreach ($bahan as $bhn) {
                    $bahan_gen[$bhn->jenispemeriksaanlab_id]['jenispemeriksaanlab_nama'] = $bhn->jenispemeriksaanlab_nama;
                    $bahan_gen[$bhn->jenispemeriksaanlab_id]['jenispemeriksaanlab_id'] = $bhn->jenispemeriksaanlab_id;
    
                    // $bahan_gen[$bhn->jenispemeriksaanlab_id]['det'][$bhn->jenispemeriksaanlab_id]['lokasi'] = $lokasi;
                }
        
    
                $tr = $this->renderPartial($this->path_view . "_listBahanSpesimen", array('bahan_gen' => $bahan_gen, 'periksabahan' => $periksabahan, 'pemeriksaan_data' => $pemeriksaan_data), true);
    
                $data['sukses'] = 1;
                $data['status'] = 1;
                $data['pesan'] = '';
                $data['html'] = $tr;
    
                echo json_encode($data);
                Yii::app()->end();
            }
        }
    
        /**
         * untuk ajax action load tindakan operasi
         */
        public function actionLoadTabelSpesimen()
        {
            if (Yii::app()->request->isAjaxRequest) {
                $pemeriksaan_id = isset($_POST['sample_id']) ? $_POST['sample_id'] : null;
                $catatan = isset($_POST['catatan']) ? $_POST['catatan'] : '';
                $samplelab_id = isset($_POST['samplelab_id']) ? $_POST['samplelab_id'] : '';
                $caraambilsampel_id = isset($_POST['caraambilsampel_id']) ? $_POST['caraambilsampel_id'] : '';
                $kode_unik = $_POST['kode_unik'] ?? null;
    
                // var_dump($caraambilsampel_id);die;
                // $criteria = new CDbCriteria();
                // $criteria->addCondition('samplelab_id = '.$samplelab_id);
                // $modSample = SamplelabM::model()->find($criteria);
                $modPemeriksaan = OrderpemeriksaanlabV::model()->findByAttributes(array(
                    'kode_unik' => $kode_unik
                ));
    
                // var_dump($modPemeriksaan->attributes); die;
                $jenisPemeriksaan = JenispemeriksaanlabM::model()->findByPk($modPemeriksaan->jenispemeriksaanlab_id);
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
        public function actionBahanSpesimen()
        {
            if (Yii::app()->request->isAjaxRequest) {
    
                $cri = new CDbCriteria();
                $cri->compare(" LOWER(t.pemeriksaanlab_nama) ", strtolower($_GET['term']), true);
                $cri->limit = 5;
                // $cri->addCondition("jenispemeriksaanlab_id=". $gen['jenispemeriksaanlab_id']);
                $models = PemeriksaanlabM::model()->findAll($cri);
    
                if (count((array)$models) > 0) {
                    foreach ($models as $i => $model) {
                        $attributes = $model->attributeNames();
                        foreach ($attributes as $j => $attribute) {
                            $returnVal[$i]["$attribute"] = $model->$attribute;
                        }
                        $returnVal[$i]['label'] = $model->pemeriksaanlab_nama;
                        $returnVal[$i]['value'] = $model->pemeriksaanlab_id;
                    }
                } else {
                    $returnVal = '';
                }
    
    
                echo CJSON::encode($returnVal);
            }
            Yii::app()->end();
        }
       
        /**
         * untuk ajax action load tindakan operasi
         */
        // public function actionLoadTabelSpesimen() {
        //     if (Yii::app()->request->isAjaxRequest) {
        //         $samplelab_id = isset($_POST['sample_id']) ? $_POST['sample_id'] : null;

        //         $criteria = new CDbCriteria();
        //         $criteria->addCondition('samplelab_id = '.$samplelab_id);
        //         $modSample = SamplelabM::model()->find($criteria);

        //         echo CJSON::encode(array(
        //             'status' => 'create_form',
        //             'form' => $this->renderPartial($this->path_view . '_formLoadSample', array(
        //                 'modSample' => $modSample,
        //                 'samplelab_id' => $samplelab_id), true)));
        //         exit;
        //     }
        // }

    /**
         * Load PPDS
         */
        public function actionGeneratePpds() {
            if (!Yii::app()->request->isAjaxRequest) {
                Yii::app()->end();
            }
            echo CJSON::encode($this->loadData($_POST['id']));
        }

        /**
         * Load data dropdown dokter pemeriksa dipilih
         * @param type $id
         * @return type
         */
        public function loadData($id){
            $ok = 1; 
            $msg = " ";
            $model = PpdsM::model()->findByAttributes(array('ppds_id' => $id));
            $data = $model->attributes; 
            $modAlamat = PpdsalamatM::model()->findByAttributes(array('ppds_id' => $id, 'ppdsalamat_tipe' => Params::TIPE_ALAMAT_PPDS_IDENTITAS));    
            $data['nomor_hp'] = !empty($modAlamat->no_mobile) ? $modAlamat->no_mobile : "-";
            $data['programstudi_nama'] = $model->programstudi->programstudi_nama; 
            return array('ok'=>$ok, 'msg'=>$msg, 'data'=>$data);
        }
}