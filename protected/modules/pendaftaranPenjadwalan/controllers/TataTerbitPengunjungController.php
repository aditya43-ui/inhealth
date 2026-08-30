
<?php

class TataTerbitPengunjungController extends MyAuthController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout = '//layouts/column1';
	public $defaultAction = 'admin';
    public $path_view = "pendaftaranPenjadwalan.views.tataTertibPengunjung.";
        public $tersimpan = false;

	/**
	 * Membuat dan menyimpan data baru.
	 */
	public function actionIndex($pendaftaran_id)
	{
        $this->layout='//layouts/iframe';
		$urlId = (!empty($_GET['urlId'])? $_GET['urlId'] : null);
        $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);

        if (empty($modPendaftaran)) {
            throw new CHttpException(404,'The requested page does not exist.');
        }

				$modMasterTataTertib = TatatertibpengunjungM::model()->find();

        $model = TatatertibpengunjungriT::model()->findByAttributes(array(
            'pendaftaran_id'=>$pendaftaran_id,
        ));

        if(!isset($model)){
            $model = new TatatertibpengunjungriT();
            $model->pendaftaran_id = $pendaftaran_id;
						$model->pasien_id = $modPendaftaran->pasien_id;
						$model->pihak_menyetujui = $modPendaftaran->pasien->nama_pasien;
						$model->namapasien_menyetujui = $modPendaftaran->pasien->nama_pasien;
						$modPegawai = PegawaiM::model()->findByPk(Yii::app()->user->getState("pegawai_id"));
						$model->petugas_menyetujui = (isset($modPegawai)?$modPegawai->namaLengkap:"");

						$model->namapihak_menyetujui = (isset($modPendaftaran->penanggungjawab)? $modPendaftaran->penanggungjawab->nama_pj:null);
						$model->tatatertibpengunjung_judul = (isset($modMasterTataTertib)?$modMasterTataTertib->tatatertibpengunjung_judul:null);
						$model->tatatertibpengunjung_isi = (isset($modMasterTataTertib)?$modMasterTataTertib->tatatertibpengunjung_isi:null);
        }
        $model->pasienadmisi_id = $modPendaftaran->pasienadmisi_id;

				$modPasien = PasienM::model()->findByPk($model->pasien_id);

        if(isset($_POST['TatatertibpengunjungriT'])){

            $transaction = Yii::app()->db->beginTransaction();

                try {

                    $model->attributes = $_POST['TatatertibpengunjungriT'];
										$model->tgl_menyetujui = date('Y-m-d H:i:s');
										$model->create_time = date('Y-m-d H:i:s');
										$model->create_loginpemakai = Yii::app()->user->getState("nama_pegawai");
                    $model->create_petugaspengisi_id = Yii::app()->user->getState("pegawai_id");
                    $model->create_ruangan_id = Yii::app()->user->getState("ruangan_id");

                    if($model->save()){
                        $transaction->commit();
                        Yii::app()->user->setFlash('success', "Data berhasil disimpan !");
                        $this->redirect(array('index','pendaftaran_id'=>$model->pendaftaran_id,'tatatertibpengunjungri_id'=>$model->tatatertibpengunjungri_id,'urlId'=>$urlId,'sukses'=>1));
                    }else{
                       $transaction->rollback();
                        Yii::app()->user->setFlash('error',"Data pasien gagal disimpan ! ");
                    }
                } catch (Exception $exc) {
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error',"Data pasien gagal disimpan ! ".MyExceptionMessage::getMessage($exc,true));
                }

        }
            $this->render($this->path_view.'index',array(
							'model'=>$model,
            'modPendaftaran'=>$modPendaftaran,
						'modMasterTataTertib'=>$modMasterTataTertib,
						'modPasien'=>$modPasien,
						'urlId'=>$urlId
		));


    }

	/**
	 * Mencetak data
	 */
	public function actionPrint($pendaftaran_id, $tatatertibpengunjungri_id)
	{
		$urlId = (!empty($_GET['urlId'])? $_GET['urlId'] : null);

        $model = TatatertibpengunjungriT::model()->findByPk($tatatertibpengunjungri_id);
        $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
				$modPasien = PasienM::model()->findByPk($model->pasien_id);
				$modMasterTataTertib = TatatertibpengunjungM::model()->find();

				if(!empty($model->tglawal_print)){
					$model->petugasawal_print = date('Y-m-d H:i:s');
					$model->tglawal_print = Yii::app()->user->getState("pegawai_id");
				}
				$arrayTglUpdate = array();
				$arrayPegUpdate = array();

				if(!empty($model->petugasakhir_print)){
					$pegAkhirRepl = str_replace('{','',$model->petugasakhir_print);
					$pegAkhirRepl_2 = str_replace('}','',$pegAkhirRepl);
					$explodPegAkhir = explode(',',$pegAkhirRepl_2);
					foreach ($explodPegAkhir as $valuePetugas) {
						$arrayPegUpdate[] = $valuePetugas;
					}
				}

				if(!empty($model->tglupdate_print)){
					$tglAkhirRepl = str_replace('{','',$model->tglupdate_print);
					$tglAkhirRepl_2 = str_replace('}','',$tglAkhirRepl);
					$explodTglAkhir = explode(',',$tglAkhirRepl_2);

					foreach ($explodTglAkhir as $valueTgl) {
						$arrayTglUpdate[] = $valueTgl;
					}
				}

				array_push($arrayTglUpdate,date('Y-m-d H:i:s'));
				array_push($arrayPegUpdate,Yii::app()->user->getState("pegawai_id"));

				$strPegUpdate = implode(',',$arrayPegUpdate);
				$strTglUpdate = implode(',',$arrayTglUpdate);

				$model->petugasakhir_print =  '{'.$strPegUpdate.'}';
				$model->tglupdate_print =  '{'.$strTglUpdate.'}';
				$model->save();

        $caraPrint=$_REQUEST['caraPrint'];
        if($caraPrint=='PRINT') {
            $this->layout='//layouts/printWindows';
            $this->render($this->path_view.'Print',array('model'=>$model,'modPendaftaran'=>$modPendaftaran,'modMasterTataTertib'=>$modMasterTataTertib,'modPasien'=>$modPasien,'caraPrint'=>$caraPrint, 'urlId'=>$urlId));
        }
        else if($_REQUEST['caraPrint']=='PDF') {
            $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
        $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
        $mpdf = new MyPDF60('', $ukuranKertasPDF);
        //$mpdf->useOddEven = 2;


        $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/prinout.css');
        $mpdf->WriteHTML($stylesheet,1);
        $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 55, 20, 15, 15);
            $judulLaporan = "SURAT PERSETUJUAN UMUM";
            $mpdf->WriteHTML($this->renderPartial($this->path_view.'Print',array('model'=>$model,'modPendaftaran'=>$modPendaftaran,'modMasterTataTertib'=>$modMasterTataTertib,'modPasien'=>$modPasien,'caraPrint'=>$caraPrint, 'urlId'=>$urlId),true));
            $mpdf->Output($judulLaporan.'-'.date('Y/m/d').'.pdf','I');
        }
    }
}
