<?php
//Yii::import('sistemAdministrator.controllers.NotifikasiRController'); RND-6398
/**
 * controller utama rujukan patologi anatomi
 * 
 * @package application.modules.rawatInap
 * @subpackage controllers
 * @author M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @author Yusuf Putra Anugrah <yusufputra@.com>
 * @version     2.0.0
 * @link    <http://172.9.1.15/simpp/docs/>
 * @link    <http://piindonesia.co.id>
 */
class PatologiAnatomiTRIController extends MyAuthController
{
    public $layout='//layouts/iframe';
    public $defaultAction = 'index';
    protected $statusSaveKirimkeUnitLain = false;
    protected $statusSavePermintaanPenunjang = false;
    protected $tindakanpelayanantersimpan = true;
    protected $komponentindakantersimpan = true;
    protected $path_view = 'rawatInap.views.patologiAnatomiTRI.';

    /**
     * method untuk mengirimkan pasien ke unit lain
     * digunakan di :
     * 1. rawatJalan/laboratorium/index
     * @param int $pendaftaran_id pendaftaran_id
     */
    public function actionIndex($pendaftaran_id,$pasienadmisi_id = null)
	{
            $this->layout='//layouts/iframe';

            $params = array();
            $modPendaftaran = RIPendaftaranT::model()->with('jeniskasuspenyakit')->findByPk($pendaftaran_id);
            if($pasienadmisi_id != null ) {
                $modAdmisi = (!empty($pasienadmisi_id)) ? PasienadmisiT::model()->findByAttributes(array('pendaftaran_id'=>$pendaftaran_id,'pasienadmisi_id'=>$pasienadmisi_id)) : array();
            } else {
                $modAdmisi = $modPendaftaran;
            }
            $modPasien = RIPasienM::model()->findByPk($modPendaftaran->pasien_id);
            $modKirimKeUnitLain = new RIPasienKirimKeUnitLainT;
            $modKirimKeUnitLain->tgl_kirimpasien = date('Y-m-d H:i:s');
            if (empty($pasienadmisi_id)) {
                $modKirimKeUnitLain->pegawai_id = $modPendaftaran->pegawai_id;
                $modKirimKeUnitLain->pegawai_nama = $modPendaftaran->dokter->namaLengkap;
                $modKirimKeUnitLain->kelaspelayanan_id = $modPendaftaran->kelaspelayanan_id; //RND-8117
            } else {
                $modKirimKeUnitLain->pegawai_id = $modAdmisi->pegawai_id;
                $modKirimKeUnitLain->pegawai_nama = $modAdmisi->dokter->namaLengkap;
                $modKirimKeUnitLain->kelaspelayanan_id = $modAdmisi->kelaspelayanan_id; //RND-8117
            }
            $modKirimKeUnitLain->isbayarkekasirpenunjang = ($modPendaftaran->carabayar_id == 1)?Yii::app()->user->getState('isbayarkekasirpenunjang'):false;
            $ruangan_asal = Yii::app()->user->getState('ruangan_id');
            $modKirimKeUnitLain->no_permintaan = MyGenerator::generateNomorPermintaan($ruangan_asal); 
            $modMordibitas =  PasienmorbiditasT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id, 'kelompokdiagnosa_id' => Params::KELOMPOKDIAGNOSA_UTAMA), array('order' => 'create_time DESC'));
            if (!empty($modMordibitas->diagnosa_id)) {
                $modKirimKeUnitLain->diagnosa_id = $modMordibitas->diagnosa_id;
                $modKirimKeUnitLain->pasienmorbiditas_id = $modMordibitas->pasienmorbiditas_id;
                $modKirimKeUnitLain->diagnosis = $modMordibitas->diagnosa->diagnosa_nama;
            }
            $criR = new CDbCriteria();
            $criR->addInCondition(" ruangan_id ", [25]);
            $criR->addCondition(" ruangan_aktif = TRUE ");
            $criR->order = " ruangan_nama ASC ";
            $r = RuanganM::model()->find($criR);
           
            $modJenisPeriksaLab = RIJenisPemeriksaanLabM::model()->findAllByAttributes(array('jenispemeriksaanlab_aktif'=>true),array('order'=>'jenispemeriksaanlab_urutan')); 

            $critpl = new CDbCriteria;
            $critpl->select = 't.pemeriksaanlab_id, t.pemeriksaanlab_nama, j.jenispemeriksaanlab_id,
                                j.jenispemeriksaanlab_nama, d.daftartindakan_id, k.kelaspelayanan_id';
            $critpl->join = ' JOIN jenispemeriksaanlab_m j ON t.jenispemeriksaanlab_id = j.jenispemeriksaanlab_id
                              JOIN daftartindakan_m d ON t.daftartindakan_id = d.daftartindakan_id
                              JOIN tariftindakan_m tt ON tt.daftartindakan_id = d.daftartindakan_id
                              JOIN kelaspelayanan_m k ON tt.kelaspelayanan_id = k.kelaspelayanan_id ';
            $critpl->group = $critpl->select;
        
            if(!empty($modPendaftaran->kelaspelayanan_id)) {
              $critpl->addCondition('k.kelaspelayanan_id = ' . $modPendaftaran->kelaspelayanan_id);
            }

            $critpl->addCondition('t.pemeriksaanlab_aktif = true');

            $modPeriksaLab = RIPemeriksaanLabM::model()->findAll($critpl);            
                                               
            $modJenisTarif = JenistarifpenjaminM::model()->find('penjamin_id ='.$modPendaftaran->penjamin_id);
            
            $criLab = new CDbCriteria();
            $criLab->select = " j.jenispemeriksaanlab_kelompok, t.* ";
            $criLab->join = " JOIN jenispemeriksaanlab_m j ON  j.jenispemeriksaanlab_id = t.jenispemeriksaanlab_id ";
            
            /*if (!empty($r)){
                $criLab->addCondition(" ruangan_id = '".$r->ruangan_id."' ");
            }else{
                $criLab->addCondition(" ruangan_id = NULL ");
            }*/
            $criLab->addCondition(" penjamin_id = '".$modPendaftaran->penjamin_id."' ");
            $criLab->addCondition(" j.jenispemeriksaanlab_kelompok = '".Params::PATOLOGI_ANATOMI."' ");
            $genLabTarif = TarifpemeriksaanlabruanganV::model()->findAll($criLab);
            
            
            
            $tarif_gen = array();
            foreach($genLabTarif as $lb){
                $tarif_gen[$lb->jenispemeriksaanlab_id]['jenispemeriksaanlab_nama'] = $lb->jenispemeriksaanlab_nama;
                $tarif_gen[$lb->jenispemeriksaanlab_id]['jenispemeriksaanlab_id'] = $lb->jenispemeriksaanlab_id;
                $tarif_gen[$lb->jenispemeriksaanlab_id]['jenispemeriksaanlab_kelompok'] = $lb->jenispemeriksaanlab_kelompok;
                $tarif_gen[$lb->jenispemeriksaanlab_id]['det'][$lb->pemeriksaanlab_id]['pemeriksaanlab_nama'] = $lb->pemeriksaanlab_nama;
                $tarif_gen[$lb->jenispemeriksaanlab_id]['det'][$lb->pemeriksaanlab_id]['pemeriksaanlab_kode'] = $lb->pemeriksaanlab_kode;
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
                $modKirimKeUnitLain = RIPasienKirimKeUnitLainT::model()->findByPk($idPasienKirimKeUnitLain);				
                $modPasien = $modKirimKeUnitLain->pasien;
            }
            
            
            if(isset($_POST['RIPasienKirimKeUnitLainT'])) {
                $transaction = Yii::app()->db->beginTransaction();
                try {
                    if(isset($_POST['permintaanPenunjangAnatomi'])){
                        //$modKirimKeUnitLainAnatomi = $this->savePasienKirimKeUnitLain($modPendaftaran, Params::RUANGAN_ID_LAB_ANATOMI);                       
						$modKirimKeUnitLainAnatomi = $this->savePasienKirimKeUnitLain($modAdmisi, Params::RUANGAN_ID_LAB_ANATOMI);    // ruangan "Patologi Anatomi"                   
                    }

                    if(isset($_POST['permintaanPenunjang']) || isset($_POST['permintaanPenunjangAnatomi'])){
                        
                        if(isset($_POST['permintaanPenunjang'])){
                            $this->savePermintaanPenunjang($_POST['permintaanPenunjang'],$modKirimKeUnitLain);
                        }
                        if(isset($_POST['permintaanPenunjangAnatomi'])){
                            $this->savePermintaanPenunjang($_POST['permintaanPenunjangAnatomi'],$modKirimKeUnitLainAnatomi);
                        }

                        $p = PendaftaranT::model()->findByPk($pendaftaran_id);
                        $updateStatusPeriksa = $p->setStatusPeriksa(Params::STATUSPERIKSA_SEDANG_PERIKSA);
                        
                        /* ================================================ */
                        /* Proses update status periksa KonsulPoli EHS-179  */
                        /* ================================================ */
						$ruangan_id = isset($_GET['ruangan_id']) ? $_GET['ruangan_id'] : Yii::app()->user->getState('ruangan_id');
                        $konsulPoli = KonsulpoliT::model()->findByAttributes(array('pendaftaran_id'=>$pendaftaran_id, 'ruangan_id'=>$ruangan_id));
                        if(!empty($konsulPoli)){
                            $updateStatusPeriksa=KonsulpoliT::model()->updateByPk($konsulPoli->konsulpoli_id,array('statusperiksa'=>Params::STATUSPERIKSA_SEDANG_PERIKSA));
                        }
                        /* ================================================ */
                        
                        PendaftaranT::model()->updateByPk($pendaftaran_id,
                            array(
                                'pembayaranpelayanan_id'=>null
                            )
                        );
//                        $ruangan = RuanganM::model()->findByPk(Yii::app()->user->getState('ruangan_id'));
//                        $params['tglnotifikasi'] = date( 'Y-m-d H:i:s');
//                        $params['create_time'] = date( 'Y-m-d H:i:s');
//                        $params['create_loginpemakai_id'] = Yii::app()->user->id;
//                        $params['instalasi_id'] = $ruangan->instalasi_id;
//                        $params['modul_id'] = 8;
//                        $params['isinotifikasi'] = $modPasien->no_rekam_medik . '-' . $modPendaftaran->no_pendaftaran . '-' . $modPasien->nama_pasien . '-' . $ruangan->ruangan_nama;
//                        $params['create_ruangan'] = $ruangan->ruangan_id;
//                        $params['judulnotifikasi'] = 'Rujukan Rawat Jalan';                        
//                        $nofitikasi = NotifikasiRController::insertNotifikasi($params);
			//sudah di ganti menggunakan node js seperti di Farmasi Apotek - transaksi penjualan resep RS.
                    } else {
                        $this->statusSavePermintaanPenunjang = true;
                    }
                    
                    $judul = 'Pasien Rujuk ke Patologi Anatomi';
                    
                    $isi = $modPasien->no_rekam_medik.' - '.$modPasien->nama_pasien;
                    
                    					
					
                    // var_dump($mr->attributes); die;
					
					if (!empty($modKirimKeUnitLain->pendaftaran_id)){
						$mr = RuanganM::model()->findByPk($modKirimKeUnitLain->ruangan_id);
						
						$link = $this->createUrl('/laboratorium/RujukanPenunjang/Index',array(
							'LBPasienKirimKeUnitLainV[tgl_awal]'=>date('Y-m-d', strtotime($modKirimKeUnitLain->tgl_kirimpasien)),
							'LBPasienKirimKeUnitLainV[tgl_akhir]'=>date('Y-m-d', strtotime($modKirimKeUnitLain->tgl_kirimpasien)),
							'LBPasienKirimKeUnitLainV[no_pendaftaran]'=>substr($modKirimKeUnitLain->pendaftaran->no_pendaftaran,2),			
							'LBPasienKirimKeUnitLainV[prefix_pendaftaran]'=>substr($modKirimKeUnitLain->pendaftaran->no_pendaftaran,0,2),			
							'LBPasienKirimKeUnitLainV[no_rekam_medik]'=>$modPasien->no_rekam_medik,
							'LBPasienKirimKeUnitLainV[nama_pasien]'=>$modPasien->nama_pasien
						));
						
					
					}else{
						$mr = RuanganM::model()->findByPk($modKirimKeUnitLainAnatomi->ruangan_id);
						
						$link = $this->createUrl('/laboratorium/RujukanPenunjang/Index',array(
							'LBPasienKirimKeUnitLainV[tgl_awal]'=>date('Y-m-d', strtotime($modKirimKeUnitLainAnatomi->tgl_kirimpasien)),
							'LBPasienKirimKeUnitLainV[tgl_akhir]'=>date('Y-m-d', strtotime($modKirimKeUnitLainAnatomi->tgl_kirimpasien)),
							'LBPasienKirimKeUnitLainV[no_pendaftaran]'=>substr($modKirimKeUnitLainAnatomi->pendaftaran->no_pendaftaran,2),			
							'LBPasienKirimKeUnitLainV[prefix_pendaftaran]'=>substr($modKirimKeUnitLainAnatomi->pendaftaran->no_pendaftaran,0,2),			
							'LBPasienKirimKeUnitLainV[no_rekam_medik]'=>$modPasien->no_rekam_medik,
							'LBPasienKirimKeUnitLainV[nama_pasien]'=>$modPasien->nama_pasien
						));
                        
						$ok = CustomFunction::broadcastNotif($judul, $isi, array(
                            array('instalasi_id' => $mr->instalasi_id, 'ruangan_id' => $mr->ruangan_id, 'modul_id' => $mr->modul_id, 'link_proses' => $link),
                            // array('instalasi_id'=>Params::INSTALASI_ID_FARMASI, 'ruangan_id'=>Params::RUANGAN_ID_APOTEK_RJ, 'modul_id'=>10),
                            // array('instalasi_id'=>Params::INSTALASI_ID_KASIR, 'ruangan_id'=>Params::RUANGAN_ID_KASIR, 'modul_id'=>19),
                        ));
						
					}
                    
                     
                //    var_dump($this->statusSaveKirimkeUnitLain);
                //    var_dump($this->statusSavePermintaanPenunjang);
                //    var_dump($this->tindakanpelayanantersimpan);die;
                    if($this->statusSaveKirimkeUnitLain && $this->statusSavePermintaanPenunjang && $this->tindakanpelayanantersimpan){
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
							$this->redirect(array('index','pendaftaran_id'=>$pendaftaran_id,'pasienadmisi_id'=>$pasienadmisi_id,'idPasienKirimKeUnitLain'=>$modKirimKeUnitLain->pasienkirimkeunitlain_id,'sukses'=>1,'smspasien'=>$smspasien));
						}else{
							$this->redirect(array('index','pendaftaran_id'=>$pendaftaran_id,'pasienadmisi_id'=>$pasienadmisi_id,'idPasienKirimKeUnitLain'=>$modKirimKeUnitLainAnatomi->pasienkirimkeunitlain_id,'sukses'=>1,'smspasien'=>$smspasien));
						}
                    } else {
                        $transaction->rollback();
                        Yii::app()->user->setFlash('error',"Data gagal disimpan! ");
                    }
                } catch (Exception $exc) {
                    $transaction->rollback();
                    echo '<pre>'; var_dump($exc); die;
                    Yii::app()->user->setFlash('error',"Data Gagal disimpan. ".MyExceptionMessage::getMessage($exc,true));
                }
            }
            
            
            

            $criRiwayat = new CDbCriteria();
            $criRiwayat->join = " JOIN ruangan_m r ON r.ruangan_id = t.ruangan_id "
                    . "JOIN instalasi_m i ON i.instalasi_id = r.instalasi_id ";
            $criRiwayat->addCondition(" pendaftaran_id =".$pendaftaran_id);
            $criRiwayat->addCondition(" pasienmasukpenunjang_id IS NULL ");
            // $criRiwayat->addInCondition(" i.instalasi_id ",Params::INSTALASI_ID_LAB);
            
            //$modRiwayatKirimKeUnitLain = RIPasienKirimKeUnitLainT::model()->findAll($criRiwayat);
            
            $modRiwayatKirimKeUnitLain = RIPasienKirimKeUnitLainT::model()->findAllByAttributes(array('pendaftaran_id'=>$pendaftaran_id),
                'pasienmasukpenunjang_id IS NULL AND ruangan_id IN('.Params::RUANGAN_ID_LAB_ANATOMI.')');
        if (Yii::app()->user->getState('modul_id') == Params::MODUL_ID_REKAMMEDIS || isset($_GET['lihat'])) {
            $this->render($this->path_view.'indexRekamMedis',array('modPendaftaran'=>$modPendaftaran,
              'modPasien'=>$modPasien,
              'modKirimKeUnitLain'=>$modKirimKeUnitLain,
              'modJenisPeriksaLab'=>$modJenisPeriksaLab,
              'modPeriksaLab'=>$modPeriksaLab,
              'modRiwayatKirimKeUnitLain'=>$modRiwayatKirimKeUnitLain,
              'modJenisTarif'=>$modJenisTarif,
              'genLabTarif'=>$genLabTarif,
              'tarif_gen'=>$tarif_gen,
              'modAdmisi'=>$modAdmisi,
              ));
	      }else{
            $this->render($this->path_view . 'index', array(
                'modPendaftaran' => $modPendaftaran,
                'modPasien' => $modPasien,
                'modKirimKeUnitLain' => $modKirimKeUnitLain,
                'modJenisPeriksaLab' => $modJenisPeriksaLab,
                'modPeriksaLab' => $modPeriksaLab,
                'modRiwayatKirimKeUnitLain' => $modRiwayatKirimKeUnitLain,
                'modJenisTarif' => $modJenisTarif,
                'genLabTarif' => $genLabTarif,
                'tarif_gen' => $tarif_gen,
                'modAdmisi' => $modAdmisi,
            ));
          }
        }

        /**
     * method untuk mengirimkan pasien ke unit lain
     * digunakan di :
     * 1. rawatJalan/laboratorium/index
     * @param int $pendaftaran_id pendaftaran_id
     */
    public function actionUpdate($pendaftaran_id,$pasienadmisi_id = null,$pasienkirimkeunitlain_id = null)
	{
            $this->layout='//layouts/iframe';

            $params = array();
            $modPendaftaran = RIPendaftaranT::model()->with('jeniskasuspenyakit')->findByPk($pendaftaran_id);
            if($pasienadmisi_id != null ) {
                $modAdmisi = (!empty($pasienadmisi_id)) ? PasienadmisiT::model()->findByAttributes(array('pendaftaran_id'=>$pendaftaran_id,'pasienadmisi_id'=>$pasienadmisi_id)) : array();
            } else {
                $modAdmisi = $modPendaftaran;
            }
            $modPasien = RIPasienM::model()->findByPk($modPendaftaran->pasien_id);
            $modKirimKeUnitLain = RIPasienKirimKeUnitLainT::model()->findByPK($pasienkirimkeunitlain_id);
            $ruangan_asal = Yii::app()->user->getState('ruangan_id');
            

            
            $criR = new CDbCriteria();
            $criR->addInCondition(" ruangan_id ", [25]);
            $criR->addCondition(" ruangan_aktif = TRUE ");
            $criR->order = " ruangan_nama ASC ";
            $r = RuanganM::model()->find($criR);
           
            $modJenisPeriksaLab = RIJenisPemeriksaanLabM::model()->findAllByAttributes(array('jenispemeriksaanlab_aktif'=>true),array('order'=>'jenispemeriksaanlab_urutan')); 

            $critpl = new CDbCriteria;
            $critpl->select = 't.pemeriksaanlab_id, t.pemeriksaanlab_nama, j.jenispemeriksaanlab_id,
                                j.jenispemeriksaanlab_nama, d.daftartindakan_id, k.kelaspelayanan_id';
            $critpl->join = ' JOIN jenispemeriksaanlab_m j ON t.jenispemeriksaanlab_id = j.jenispemeriksaanlab_id
                              JOIN daftartindakan_m d ON t.daftartindakan_id = d.daftartindakan_id
                              JOIN tariftindakan_m tt ON tt.daftartindakan_id = d.daftartindakan_id
                              JOIN kelaspelayanan_m k ON tt.kelaspelayanan_id = k.kelaspelayanan_id ';
            $critpl->group = $critpl->select;
        
            if(!empty($modPendaftaran->kelaspelayanan_id)) {
              $critpl->addCondition('k.kelaspelayanan_id = ' . $modPendaftaran->kelaspelayanan_id);
            }

            $critpl->addCondition('t.pemeriksaanlab_aktif = true');

            $modPeriksaLab = RIPemeriksaanLabM::model()->findAll($critpl);            
                                               
            $modJenisTarif = JenistarifpenjaminM::model()->find('penjamin_id ='.$modPendaftaran->penjamin_id);
            
            $criLab = new CDbCriteria();
            $criLab->select = " j.jenispemeriksaanlab_kelompok, t.* ";
            $criLab->join = " JOIN jenispemeriksaanlab_m j ON  j.jenispemeriksaanlab_id = t.jenispemeriksaanlab_id ";
            
            /*if (!empty($r)){
                $criLab->addCondition(" ruangan_id = '".$r->ruangan_id."' ");
            }else{
                $criLab->addCondition(" ruangan_id = NULL ");
            }*/
            $criLab->addCondition(" penjamin_id = '".$modPendaftaran->penjamin_id."' ");
            $criLab->addCondition(" j.jenispemeriksaanlab_kelompok = '".Params::PATOLOGI_ANATOMI."' ");
            $genLabTarif = TarifpemeriksaanlabruanganV::model()->findAll($criLab);
            
            
            
            $tarif_gen = array();
            foreach($genLabTarif as $lb){
                $tarif_gen[$lb->jenispemeriksaanlab_id]['jenispemeriksaanlab_nama'] = $lb->jenispemeriksaanlab_nama;
                $tarif_gen[$lb->jenispemeriksaanlab_id]['jenispemeriksaanlab_id'] = $lb->jenispemeriksaanlab_id;
                $tarif_gen[$lb->jenispemeriksaanlab_id]['jenispemeriksaanlab_kelompok'] = $lb->jenispemeriksaanlab_kelompok;
                $tarif_gen[$lb->jenispemeriksaanlab_id]['det'][$lb->pemeriksaanlab_id]['pemeriksaanlab_nama'] = $lb->pemeriksaanlab_nama;
                $tarif_gen[$lb->jenispemeriksaanlab_id]['det'][$lb->pemeriksaanlab_id]['pemeriksaanlab_kode'] = $lb->pemeriksaanlab_kode;
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
                $modKirimKeUnitLain = RIPasienKirimKeUnitLainT::model()->findByPk($idPasienKirimKeUnitLain);				
                $modPasien = $modKirimKeUnitLain->pasien;
            }
            
            
            if(isset($_POST['RIPasienKirimKeUnitLainT'])) {
                $transaction = Yii::app()->db->beginTransaction();
                try {
                    if(isset($_POST['permintaanPenunjangAnatomi'])){
                        //$modKirimKeUnitLainAnatomi = $this->savePasienKirimKeUnitLain($modPendaftaran, Params::RUANGAN_ID_LAB_ANATOMI);                       
						$modKirimKeUnitLainAnatomi = $this->savePasienKirimKeUnitLain($modAdmisi, Params::RUANGAN_ID_LAB_ANATOMI, $modKirimKeUnitLain);    // ruangan "Patologi Anatomi"                   
                    }

                    if(isset($_POST['permintaanPenunjang']) || isset($_POST['permintaanPenunjangAnatomi'])){
                        
                        RIPermintaanPenunjangT::model()->deleteAllByAttributes(array(
                            'pasienkirimkeunitlain_id'=>$modKirimKeUnitLain->pasienkirimkeunitlain_id
                        ));

                        if(isset($_POST['permintaanPenunjang']['idDaftarTindakan'])){
                            $this->savePermintaanPenunjang($_POST['permintaanPenunjang'],$modKirimKeUnitLain);
                        }
                        if(isset($_POST['permintaanPenunjangAnatomi'])){
                            $this->savePermintaanPenunjang($_POST['permintaanPenunjangAnatomi'],$modKirimKeUnitLainAnatomi);
                        }

                        $p = PendaftaranT::model()->findByPk($pendaftaran_id);
                        $updateStatusPeriksa = $p->setStatusPeriksa(Params::STATUSPERIKSA_SEDANG_PERIKSA);
                        
                        /* ================================================ */
                        /* Proses update status periksa KonsulPoli EHS-179  */
                        /* ================================================ */
						$ruangan_id = isset($_GET['ruangan_id']) ? $_GET['ruangan_id'] : Yii::app()->user->getState('ruangan_id');
                        $konsulPoli = KonsulpoliT::model()->findByAttributes(array('pendaftaran_id'=>$pendaftaran_id, 'ruangan_id'=>$ruangan_id));
                        if(!empty($konsulPoli)){
                            $updateStatusPeriksa=KonsulpoliT::model()->updateByPk($konsulPoli->konsulpoli_id,array('statusperiksa'=>Params::STATUSPERIKSA_SEDANG_PERIKSA));
                        }
                        /* ================================================ */
                        
                        PendaftaranT::model()->updateByPk($pendaftaran_id,
                            array(
                                'pembayaranpelayanan_id'=>null
                            )
                        );
                    } else {
                        $this->statusSavePermintaanPenunjang = true;
                    }
                    
                    $judul = 'Pasien Rujuk ke Patologi Anatomi';
                    
                    $isi = $modPasien->no_rekam_medik.' - '.$modPasien->nama_pasien;
                    
                    					
					
                    // var_dump($mr->attributes); die;
					
					if (!empty($modKirimKeUnitLain->pendaftaran_id)){
						$mr = RuanganM::model()->findByPk($modKirimKeUnitLain->ruangan_id);
						
						$link = $this->createUrl('/laboratorium/RujukanPenunjang/Index',array(
							'LBPasienKirimKeUnitLainV[tgl_awal]'=>date('Y-m-d', strtotime($modKirimKeUnitLain->tgl_kirimpasien)),
							'LBPasienKirimKeUnitLainV[tgl_akhir]'=>date('Y-m-d', strtotime($modKirimKeUnitLain->tgl_kirimpasien)),
							'LBPasienKirimKeUnitLainV[no_pendaftaran]'=>substr($modKirimKeUnitLain->pendaftaran->no_pendaftaran,2),			
							'LBPasienKirimKeUnitLainV[prefix_pendaftaran]'=>substr($modKirimKeUnitLain->pendaftaran->no_pendaftaran,0,2),			
							'LBPasienKirimKeUnitLainV[no_rekam_medik]'=>$modPasien->no_rekam_medik,
							'LBPasienKirimKeUnitLainV[nama_pasien]'=>$modPasien->nama_pasien
						));
						
					
					}else{
						$mr = RuanganM::model()->findByPk($modKirimKeUnitLainAnatomi->ruangan_id);
						
						$link = $this->createUrl('/laboratorium/RujukanPenunjang/Index',array(
							'LBPasienKirimKeUnitLainV[tgl_awal]'=>date('Y-m-d', strtotime($modKirimKeUnitLainAnatomi->tgl_kirimpasien)),
							'LBPasienKirimKeUnitLainV[tgl_akhir]'=>date('Y-m-d', strtotime($modKirimKeUnitLainAnatomi->tgl_kirimpasien)),
							'LBPasienKirimKeUnitLainV[no_pendaftaran]'=>substr($modKirimKeUnitLainAnatomi->pendaftaran->no_pendaftaran,2),			
							'LBPasienKirimKeUnitLainV[prefix_pendaftaran]'=>substr($modKirimKeUnitLainAnatomi->pendaftaran->no_pendaftaran,0,2),			
							'LBPasienKirimKeUnitLainV[no_rekam_medik]'=>$modPasien->no_rekam_medik,
							'LBPasienKirimKeUnitLainV[nama_pasien]'=>$modPasien->nama_pasien
						));
						
						
					}
                    
                     
                //    var_dump($this->statusSaveKirimkeUnitLain);
                //    var_dump($this->statusSavePermintaanPenunjang);
                //    var_dump($this->tindakanpelayanantersimpan);die;
                    if($this->statusSaveKirimkeUnitLain && $this->statusSavePermintaanPenunjang && $this->tindakanpelayanantersimpan){
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
							$this->redirect(array('index','pendaftaran_id'=>$pendaftaran_id,'pasienadmisi_id'=>$pasienadmisi_id,'idPasienKirimKeUnitLain'=>$modKirimKeUnitLain->pasienkirimkeunitlain_id,'sukses'=>1,'smspasien'=>$smspasien));
						}else{
							$this->redirect(array('index','pendaftaran_id'=>$pendaftaran_id,'pasienadmisi_id'=>$pasienadmisi_id,'idPasienKirimKeUnitLain'=>$modKirimKeUnitLainAnatomi->pasienkirimkeunitlain_id,'sukses'=>1,'smspasien'=>$smspasien));
						}
                    } else {
                        $transaction->rollback();
                        Yii::app()->user->setFlash('error',"Data gagal disimpan! ");
                    }
                } catch (Exception $exc) {
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error',"Data Gagal disimpan. ".MyExceptionMessage::getMessage($exc,true));
                }
            }
            
            
            

            $criRiwayat = new CDbCriteria();
            $criRiwayat->join = " JOIN ruangan_m r ON r.ruangan_id = t.ruangan_id "
                    . "JOIN instalasi_m i ON i.instalasi_id = r.instalasi_id ";
            $criRiwayat->addCondition(" pendaftaran_id =".$pendaftaran_id);
            $criRiwayat->addCondition(" pasienmasukpenunjang_id IS NULL ");
            // $criRiwayat->addInCondition(" i.instalasi_id ",Params::INSTALASI_ID_LAB);
            
            //$modRiwayatKirimKeUnitLain = RIPasienKirimKeUnitLainT::model()->findAll($criRiwayat);
            
            $modRiwayatKirimKeUnitLain = RIPasienKirimKeUnitLainT::model()->findAllByAttributes(array('pendaftaran_id'=>$pendaftaran_id),
                'pasienmasukpenunjang_id IS NULL AND ruangan_id IN('.Params::RUANGAN_ID_LAB_ANATOMI.')');
            
            $this->render($this->path_view.'index',array('modPendaftaran'=>$modPendaftaran,
              'modPasien'=>$modPasien,
              'modKirimKeUnitLain'=>$modKirimKeUnitLain,
              'modJenisPeriksaLab'=>$modJenisPeriksaLab,
              'modPeriksaLab'=>$modPeriksaLab,
              'modRiwayatKirimKeUnitLain'=>$modRiwayatKirimKeUnitLain,
              'modJenisTarif'=>$modJenisTarif,
              'genLabTarif'=>$genLabTarif,
              'tarif_gen'=>$tarif_gen,
              'modAdmisi'=>$modAdmisi,
            ));
	    }

        /**
         * method untuk menyimpan data pasien ke unit lain RJPasienKirimkeUnitLainT
         * digunakan di :
         * 1. rawatJalan/patologianatomi/index
         * @param object $modPendaftaran model PendaftaranT
         * @return \RJPasienKirimKeUnitLainT 
         */
        protected function savePasienKirimKeUnitLain($modAdmisi, $ruangan_lab, $modKirimKeUnitLain = null)
        {
            if (empty($modKirimKeUnitLain)) {
                $modKirimKeUnitLain = new RIPasienKirimKeUnitLainT;
            }
            $modKirimKeUnitLain->attributes = $_POST['RIPasienKirimKeUnitLainT'];
            $modKirimKeUnitLain->samplelab_id = $_POST['RIPasienKirimKeUnitLainT']['samplelab_id'];
            $modKirimKeUnitLain->pasien_id = $modAdmisi->pasien_id;
            $modKirimKeUnitLain->pendaftaran_id = $modAdmisi->pendaftaran_id; 
            $modKirimKeUnitLain->instalasi_id = Params::INSTALASI_ID_LAB;

            //$modKirimKeUnitLain->instalasi_id = $instalasi_lab;
            $modKirimKeUnitLain->ruangan_id = $ruangan_lab;
            // $modKirimKeUnitLain->instalasi_id = $modKirimKeUnitLain->ruangan->instalasi_id;
            $modKirimKeUnitLain->kelaspelayanan_id = $modAdmisi->kelaspelayanan_id; // kelaspelayanan_id di ambil dari pasienadmisi_t
            $modKirimKeUnitLain->tgl_kirimpasien = MyFormatter::formatDateTimeForDb($modKirimKeUnitLain->tgl_kirimpasien);
            $modKirimKeUnitLain->create_loginpemakai_id = Yii::app()->user->id;
            $modKirimKeUnitLain->update_loginpemakai_id = Yii::app()->user->id;
            $modKirimKeUnitLain->create_ruangan = isset($_GET['ruangan_id']) ? $_GET['ruangan_id'] : Yii::app()->user->getState('ruangan_id');
            $modKirimKeUnitLain->create_time = date( 'Y-m-d H:i:s');
            $modKirimKeUnitLain->update_time = date( 'Y-m-d H:i:s');
            $modKirimKeUnitLain->isbayarkekasirpenunjang = isset($_POST['RIPasienKirimKeUnitLainT']['isbayarkekasirpenunjang']) ? $_POST['RIPasienKirimKeUnitLainT']['isbayarkekasirpenunjang'] : 0;
            $modKirimKeUnitLain->nourut = MyGenerator::noUrutPasienKirimKeUnitLain($modKirimKeUnitLain->ruangan_id);
		
          //  var_dump($modKirimKeUnitLain->attributes);die;
            
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

            // var_dump($permintaan, $_POST); die;
            foreach ($permintaan['inputpemeriksaanlab'] as $i => $value) {
                // var_dump($value);
                
                $modPermintaan = new RIPermintaanPenunjangT;
				$modPermintaan->daftartindakan_id = isset($permintaan['idDaftarTindakan'][$i]) ? $permintaan['idDaftarTindakan'][$i] : null;
                $modPermintaan->pemeriksaanlab_id = $permintaan['inputpemeriksaanlab'][$i];
                $modPermintaan->pemeriksaanrad_id = '';
                $modPermintaan->pasienkirimkeunitlain_id = $modKirimKeUnitLain->pasienkirimkeunitlain_id;
                $modPermintaan->noperminatanpenujang = MyGenerator::noPermintaanPenunjang('PL');
                $modPermintaan->qtypermintaan = $permintaan['inputqty'][$i];
                $modPermintaan->tarif_pelayananan = $permintaan['inputtarifpemeriksaanlab'][$i] ?? 0;
                $modPermintaan->tglpermintaankepenunjang = MyFormatter::formatDateTimeForDb($modKirimKeUnitLain->tgl_kirimpasien);
                $modPermintaan->samplelab_id = isset($permintaan['samplelab_id'][$i]) ? $permintaan['samplelab_id'][$i] : null;
                
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
							$modTindakan = $this->simpanTindakanPelayanan($modPendaftaran,$modKirimKeUnitLain,$modPermintaan, $permintaan['samplelab_id'][$i]); //AGAR BISA DI BAYAR DI KASIR
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
        public function simpanTindakanPelayanan($modPendaftaran, $modKirimKeUnitLain, $modPermintaan, $samplelab_id = null){
            $modTindakan = new RITindakanPelayananT;
            
            $modTindakan->attributes = $modPendaftaran->attributes;
            $modTindakan->ruangan_id = $modKirimKeUnitLain->ruangan_id;
            $modTindakan->instalasi_id = $modTindakan->ruangan->instalasi_id;
            $modTindakan->pendaftaran_id = $modPendaftaran->pendaftaran_id;
            $modTindakan->pasienadmisi_id = $modPendaftaran->pasienadmisi_id;
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

            $modTindakan->samplelab_id = $samplelab_id;
            
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
				$data['pesan'] = "Pasien kirim ke Patologi Anatomi gagal dibatalkan!";
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
						$data['pesan'] = "Pasien kirim ke Patologi Anatomi tidak bisa dibatalkan karena tindakan sudah dibayarkan!";
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

								$data['pesan'] = "Pasien kirim ke Patologi Anatomi berhasil dibatalkan!";
								$data['sukses'] = 1;
								$transaction->commit();
						} else {
								$transaction->rollback();
								$data['pesan'] = "Pasien kirim ke Patologi Anatomi tidak bisa dibatalkan karena tindakan sudah dibayarkan!";
								$data['sukses'] = 0;
						}
					}
				}catch (Exception $exc) {
					$transaction->rollback();
					$data['pesan'] = "Pasien kirim ke Patologi Anatomi gagal dibatalkan karena tindakan sudah dibayarkan!";
					$data['sukses'] = 0;
				}
				$modRiwayatKirimKeUnitLain = RIPasienKirimKeUnitLainT::model()->findAllByAttributes(array('pendaftaran_id'=>$pendaftaran_id),
						'pasienmasukpenunjang_id IS NULL AND ruangan_id IN('.Params::RUANGAN_ID_LAB_ANATOMI.')');
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
             $modRiwayatKirimKeUnitLain = RIPasienKirimKeUnitLainT::model()->findAllByAttributes(array('pendaftaran_id'=>$pendaftaran_id,
                'pasienkirimkeunitlain_id'=>$idPasienKirimKeUnitLain),
                'pasienmasukpenunjang_id IS NULL');

            $judulLaporan='Permintaan Pemeriksaan Patologi Anatomi';
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
                $mpdf = new MyPDF60('',$ukuranKertasPDF); 
                // $mpdf->useOddEven = 2;  
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
             $modKirimKeUnitLain = RIPasienKirimKeUnitLainT::model()->findAll('pendaftaran_id='.$pendaftaran_id);
             $modRiwayatKirimKeUnitLain = RIPasienKirimKeUnitLainT::model()->findAllByAttributes(array('pendaftaran_id'=>$pendaftaran_id,'instalasi_id'=>Params::INSTALASI_ID_LAB),
                'pasienmasukpenunjang_id IS NULL');
            
            $judulLaporan='Permintaan Pemeriksaan Patologi Anatomi';
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
                $mpdf = new MyPDF60('',$ukuranKertasPDF); 
                // $mpdf->useOddEven = 2;  
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
                $ruangan_id = (isset($_POST['ruangan_id']) ? $_POST['ruangan_id'] : Params::RUANGAN_ID_LAB_ANATOMI);
                $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);  
                $samplelab_id = (isset($_POST['samplelab_id']) ? $_POST['samplelab_id'] : null);

                $sample = new SamplelabM;

                if(!empty($samplelab_id)) {
                    $sample = SamplelabM::model()->findByPk($samplelab_id);
                }
      
                
                $criteria = new CDbCriteria();
                $criteria->addCondition('pemeriksaanlab_id = '.$pemeriksaanlab_id);
                $criteria->addCondition('kelaspelayanan_id = '.$kelaspelayanan_id);
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
                    'form'=>$this->renderPartial($this->path_view.'_formLoadPemeriksaanLab', array('modTarif'=>$modTarif, 'id_tindakan'=>$id_tindakan, 'paket'=>$paket, 'sample'=>$sample), true)));
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
            $judul = 'Pasien Batal Rujuk Patologi Anatomi';

            $isi = $modKirimKeunitlain['no_pendaftaran'].' '.$modPasien->no_rekam_medik.' '.$modPasien->nama_pasien;                    
                        
            
            $ok = CustomFunction::broadcastNotif($judul, $isi, array(
                array('instalasi_id'=>$modKirimKeunitlain['instalasi_id'], 'ruangan_id'=>$modRuangan->ruangan_id, 'modul_id'=>$modRuangan->modul_id),				
            )); 
        }

        // Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
        
    public function actionLoadTarifLab(){
        if (Yii::app()->request->isAjaxRequest){
            $pendaftaran_id = isset($_POST['pendaftaran_id'])? $_POST['pendaftaran_id'] : null;
            $kelaspelayanan_id = isset($_POST['kelaspelayanan_id'])? $_POST['kelaspelayanan_id'] : null;
            $penjamin_id = isset($_POST['penjamin_id'])? $_POST['penjamin_id'] : null;
            // $ruangan_id = isset($_POST['ruangan_id'])? $_POST['ruangan_id'] : null;
            $ruangan_id = (isset($_POST['ruangan_id']) ? $_POST['ruangan_id'] : Params::RUANGAN_ID_LAB_ANATOMI);
            $jenistarif_id = isset($_POST['jenistarif_id'])? $_POST['jenistarif_id'] : null;
            $periksalab = isset($_POST['periksalab'])? $_POST['periksalab'] : null;
            $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);        
            
            $criLab = new CDbCriteria();
            $criLab->select = "j.jenispemeriksaanlab_kelompok, t.*";
            $criLab->join = "JOIN jenispemeriksaanlab_m j ON  j.jenispemeriksaanlab_id = t.jenispemeriksaanlab_id";
            $criLab->addCondition("kelaspelayanan_id = '".$kelaspelayanan_id."'");
            // $criLab->addCondition("jenistarif_id = '".$jenistarif_id."'");
            // $criLab->addCondition("ruangan_id = '".$ruangan_id."'");
            $criLab->addCondition("penjamin_id = '".$penjamin_id."'");
            // $criLab->addInCondition("instalasi_id ", Params::getInsPatologiAnatomi());
            $criLab->addCondition("j.jenispemeriksaanlab_kelompok = '".Params::PATOLOGI_ANATOMI."'");
            $criLab->compare("LOWER(t.pemeriksaanlab_nama)", strtolower($periksalab),true);

            $genLabTarif = TarifpemeriksaanlabruanganV::model()->findAll($criLab);
            
            $tarif_gen = array();
            if (!empty($genLabTarif)){
                foreach($genLabTarif as $lb){
                    $tarif_gen[$lb->jenispemeriksaanlab_id]['jenispemeriksaanlab_nama'] = $lb->jenispemeriksaanlab_nama;
                    $tarif_gen[$lb->jenispemeriksaanlab_id]['jenispemeriksaanlab_id'] = $lb->jenispemeriksaanlab_id;
                    $tarif_gen[$lb->jenispemeriksaanlab_id]['jenispemeriksaanlab_kelompok'] = $lb->jenispemeriksaanlab_kelompok;
                    $tarif_gen[$lb->jenispemeriksaanlab_id]['det'][$lb->pemeriksaanlab_id]['pemeriksaanlab_nama'] = $lb->pemeriksaanlab_nama;
                    $tarif_gen[$lb->jenispemeriksaanlab_id]['det'][$lb->pemeriksaanlab_id]['pemeriksaanlab_id'] = $lb->pemeriksaanlab_id;                
                    $tarif_gen[$lb->jenispemeriksaanlab_id]['det'][$lb->pemeriksaanlab_id]['ruangan_id'] = $lb->ruangan_id;
                    $tarif_gen[$lb->jenispemeriksaanlab_id]['det'][$lb->pemeriksaanlab_id]['pemeriksaanlab_kode'] = $lb->pemeriksaanlab_kode ?? '-';
                }
            }

            $tr = $this->renderPartial($this->path_view."_listPemeriksaan",array('tarif_gen'=>$tarif_gen),true);
            
            $data['sukses'] = 1;
            $data['pesan'] = '';
            $data['html'] = $tr;
            
            echo json_encode($data);
            Yii::app()->end();
        }
    }
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