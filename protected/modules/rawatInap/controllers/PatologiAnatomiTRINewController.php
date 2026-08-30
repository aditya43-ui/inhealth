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
class PatologiAnatomiTRINewController extends MyAuthController
{
    public $layout='//layouts/iframe';
    public $defaultAction = 'index';
    protected $statusSaveKirimkeUnitLain = false;
    protected $statusSavePermintaanPenunjang = false;
    protected $tindakanpelayanantersimpan = true;
    protected $komponentindakantersimpan = true;
    protected $path_view = 'rawatInap.views.patologiAnatomiTRINew.';

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
            if ($pasienadmisi_id != null) {
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

                    $modKirimKeUnitLain = $this->savePasienKirimKeUnitLainNew($modKirimKeUnitLain, $modPendaftaran, $_POST['RIPasienKirimKeUnitLainT']);
                                       
                    $judul = 'Pasien Rujuk ke Patologi Anatomi';
                    
                    $isi = $modPasien->no_rekam_medik.' - '.$modPasien->nama_pasien;
                    
                    if($this->statusSaveKirimkeUnitLain){
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
            
            $modRiwayatKirimKeUnitLain = RIPasienKirimKeUnitLainT::model()->findAll($criRiwayat);
            
            //$modRiwayatKirimKeUnitLain = RJPasienKirimKeUnitLainT::model()->findAllByAttributes(array('pendaftaran_id'=>$pendaftaran_id),
              //  'pasienmasukpenunjang_id IS NULL AND ruangan_id IN('.Params::RUANGAN_ID_LAB_KLINIK.','.Params::RUANGAN_ID_LAB_ANATOMI.')');
            
            $this->render($this->path_view.'index',array('modPendaftaran'=>$modPendaftaran,
              'modPasien'=>$modPasien,
              'modKirimKeUnitLain'=>$modKirimKeUnitLain,
              'modRiwayatKirimKeUnitLain'=>$modRiwayatKirimKeUnitLain,
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
        protected function savePasienKirimKeUnitLain($modAdmisi, $ruangan_lab)
        {
            $modKirimKeUnitLain = new RIPasienKirimKeUnitLainT;
            $modKirimKeUnitLain->attributes = $_POST['RIPasienKirimKeUnitLainT'];
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

        protected function savePasienKirimKeUnitLainNew($model, $daftar, $post)
        {
           
            $model->attributes = $post;
            $model->pendaftaran_id = $daftar->pendaftaran_id;
            $model->pasien_id = $daftar->pasien_id;
            $model->instalasi_id = Params::INSTALASI_ID_LAB;
            $model->ruangan_id = Params::RUANGAN_ID_LAB_ANATOMI;     

            $model->create_loginpemakai_id = Yii::app()->user->id;
            $model->update_loginpemakai_id = Yii::app()->user->id;
            $model->create_ruangan = isset($_GET['ruangan_id']) ? $_GET['ruangan_id'] : Yii::app()->user->getState('ruangan_id');
            $model->create_time = date( 'Y-m-d H:i:s');
            $model->update_time = date( 'Y-m-d H:i:s');

            $model->isbiopsi = $post['biopsi'];
            $model->isoperasi = $post['operasi'];
            $model->iskerokan = $post['kerokan'];
            $model->issitologi = $post['sitologi'];
            $model->isfnab = $post['fnab'];
            $model->ispaformmaline = $post['paformmaline'];
            $model->issputumalkohol = $post['sputumalkohol'];
            $model->isurinealkohol = $post['urinealkohol'];
            $model->isvaginasmear = $post['vaginasmear'];
            $model->lokalisasi = $post['lokalisasi'];
            $model->diagnosaklinik = $post['diagnosaklinik'];
            $model->stadiumt = $post['stadiumt'];
            $model->stadiumn = $post['stadiumn'];
            $model->stadiumm = $post['stadiumm'];
            $model->ketklinik = $post['ketklinik'];
            $model->riwayatdulu = $post['riwayatdulu'];
            $model->ispasebelumnyaya = $post['ispasebelumnyaya'];
            $model->ispasebelumnyatidak = $post['ispasebelumnyatidak'];
            $model->iscaraklinik = $post['iscaraklinik'];
            $model->iscararo = $post['iscararo'];
            $model->iscarapk = $post['iscarapk'];
            $model->iscaraop = $post['iscaraop'];
            $model->iscaranekrosi = $post['iscaraekrosi'];
            $model->ketpasebelumnya = $post['ketpasebelumnya'];
            $model->riwayatsebelumnya = $post['riwayatsebelumnya'];
            $model->pemeriksaanpenunjang = $post['pemeriksaanpenunjang'];

            $model->nourut = MyGenerator::noUrutPasienKirimKeUnitLain($model->ruangan_id);
            
            if($model->validate()){
                if ($model->save()){
                    $this->statusSaveKirimkeUnitLain = true;
				        }
            }
            
            return $model;
        }


        /**
     * Autocomplete pegawai ruangan
     */
    public function actionAutoCompletePegawai() {
        if (Yii::app()->request->isAjaxRequest) {
            $returnVal = array();
            $nama_pegawai = isset($_GET['term']) ? $_GET['term'] : null;
            $criteria = new CDbCriteria();
            $criteria->compare('LOWER(nama_pegawai)', strtolower($nama_pegawai), true);
            $criteria->addCondition('ruangan_id = ' . Yii::app()->user->getState('ruangan_id'));
            if (isset($_GET['kelompokpegawai_id'])) {
                if (!empty($_GET['kelompokpegawai_id'])) {
                    $criteria->addCondition('kelompokpegawai_id = ' . $_GET['kelompokpegawai_id']);
                }
            }
            $criteria->limit = 5;
            $models = PegawairuanganV::model()->findAll($criteria);
            foreach ($models as $i => $model) {
                $attributes = $model->attributeNames();
                foreach ($attributes as $j => $attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = $model->namaLengkap;
                $returnVal[$i]['value'] = $model->pegawai_id;
            }

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }

    /**
     * Autocomplete pegawai ruangan
     */
    public function actionAutoCompletePpds() {
        if (Yii::app()->request->isAjaxRequest) {
            $returnVal = array();
            $nama_pegawai = isset($_GET['term']) ? $_GET['term'] : null;
            $criteria = new CDbCriteria();
            $criteria->compare('LOWER(ppds_nama)', strtolower($nama_pegawai), true);          
            $criteria->limit = 5;
            $models = PpdsM::model()->findAll($criteria);
            foreach ($models as $i => $model) {
                $attributes = $model->attributeNames();
                foreach ($attributes as $j => $attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = $model->ppds_nama;
                $returnVal[$i]['value'] = $model->ppds_id;
            }

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
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

    public function actionAjaxDetailOrder()
    {  
        if(Yii::app()->request->isAjaxRequest) {
            $id = $_POST['pasienkirimkeunitlain_id'];

            $modKirimKeUnitLain = RIPasienKirimKeUnitLainT::model()->findByPk($id);
            $modPendaftaran = RIPendaftaranT::model()->findByPk($modKirimKeUnitLain->pendaftaran_id);
            $modPasien = RIPasienM::model()->findByPk($modPendaftaran->pasien_id);
            
            $data['result'] = $this->renderPartial($this->path_view.'_viewDetailOrder', array(
                'model'=>$modKirimKeUnitLain,
                'modPendaftaran' => $modPendaftaran,
                'modPasien' => $modPasien
            ), true);

            echo json_encode($data);
            Yii::app()->end();
        }
    }
}