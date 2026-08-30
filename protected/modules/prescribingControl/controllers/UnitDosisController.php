<?php
class UnitDosisController extends MyAuthController
{       
	
	public function actionIndex($pendaftaran_id = null,$pasienadmisi_id = null)
	{
		$modInfoRI = new PCInfopasienmasukkamarV;
		$modUnitDosis = new PCUnitDosisT;
		$modPendaftaran= new PCPendaftaranT;
		    
		
		$instalasi_id = Yii::app()->user->getState('instalasi_id');
		$modReseptur = new PCResepturT;
		$instalasi_id = Yii::app()->user->getState('instalasi_id');
		$modReseptur->noresep = MyGenerator::noResepReseptur($instalasi_id);
		$modReseptur->noresep_depan = $modReseptur->noresep.'/';
		$modReseptur->pegawai_id = $modPendaftaran->pegawai_id;
		$modReseptur->ruanganreseptur_id = Yii::app()->user->getState('ruangan_id');
		$modRiwayatResep = PCResepturT::model()->findAllByAttributes(array('pendaftaran_id'=>$pendaftaran_id,'pasienadmisi_id'=>$pasienadmisi_id,'ruanganreseptur_id'=>Yii::app()->user->getState('ruangan_id')),array('order'=>'t.create_time DESC'));
		
		
		$modAdmisi = (!empty($idAdmisi)) ? PasienadmisiT::model()->findByAttributes(array('pendaftaran_id'=>$pendaftaran_id,'pasienadmisi_id'=>$idAdmisi)) : array();
		$modPasien = PCPasienM::model()->findByPk($modPendaftaran->pasien_id);
		$diagnosaPasien = PasienmorbiditasT::model()->findAllByAttributes(array('pendaftaran_id'=>$pendaftaran_id));
		$dietPasien = DietpasienT::model()->findAllByAttributes(array('pendaftaran_id'=>$pendaftaran_id));
		$fisikPasien = PemeriksaanfisikT::model()->findAllByAttributes(array('pendaftaran_id'=>$pendaftaran_id),array('order'=>'pemeriksaanfisik_id desc','limit'=>1));
		$idDiagnosa = array();
		$idJenisDiet = array();
		$idAlergi = array();
		
		if (!empty($pendaftaran_id)){
			foreach($diagnosaPasien as $key=>$diagnosas){
				$idDiagnosa[] = $diagnosas->diagnosa_id;
				if(empty($diagnosas->diagnosa_id)){
					$idDiagnosa[] = null;
				}
				$criteria = new CDbCriteria();
				$criteria->addInCondition('diagnosa_id',$idDiagnosa);
				$diagnosa = DiagnosaM::model()->findAll($criteria);
			}

			foreach($dietPasien as $i=>$diet){
				$idJenisDiet[] = $diet->jenisdiet_id;
				if(empty($diet->jenisdiet_id)){
					$idJenisDiet[] = null;
				}
				$criteriaDiet = new CDbCriteria();
				$criteriaDiet->addInCondition('jenisdiet_id',$idJenisDiet);
				$jenisdiet = JenisdietM::model()->findAll($criteriaDiet);
			}
		}else{
				$diagnosa = new DiagnosaM;
				$jenisdiet = new JenisdietM;
		}

		$instalasi_id = Yii::app()->user->getState('instalasi_id');
		$modUnitDosis = new PCUnitdosisT;
		$modUnitDosisDetail = new PCUnitdosisdetailT;
		$modUnitDosis->tgluntidosis = date('d M Y h:i:s');
//		$modUnitDosis->beratbadan_kg = $fisikPasien[0]->beratbadan_kg;
//		$modUnitDosis->tinggibadan_cm = $fisikPasien[0]->tinggibadan_cm;
		
		
		
		
		
		
		
		
		
		
		$this->render('index',array('modPendaftaran'=>$modPendaftaran,
									'modPasien'=>$modPasien,
									'modReseptur'=>$modReseptur,
									'modAdmisi'=>$modAdmisi,
									'modRiwayatResep'=>$modRiwayatResep,
									'modInfoRI'=>$modInfoRI,
									'modUnitDosis'=>$modUnitDosis,
									'modUnitDosisDetail'=>$modUnitDosisDetail,
									'diagnosa'=>$diagnosa,
									'jenisdiet'=>$jenisdiet,
									));
	}
	
	public function actionPrint()
	{
		$pendaftaran_id = $_GET['id'];
		$criteria=new CDbCriteria;
		$criteria->addCondition("create_time=(select max(create_time) from reseptur_t)");
		$maxtime = PCResepturT::model()->find($criteria);
		$modDetailResep = ResepturdetailT::model()->findAllByAttributes(array('reseptur_id'=>$maxtime->reseptur_id));
		$modPendaftaran = PCPendaftaranT::model()->with('jeniskasuspenyakit')->findByPk($pendaftaran_id);
		$judulLaporan='Reseptur';
		$caraPrint=$_REQUEST['caraPrint'];
		If(isset($_GET['idReseptur'])){
			$modDetailResep = ResepturdetailT::model()->findAllByAttributes(array('reseptur_id'=>$_GET['idReseptur']));
			if($caraPrint=='PRINT') {
				$this->layout='//layouts/printWindows';
				$this->render('_viewDetailResep',array('modPendaftaran'=>$modPendaftaran,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint,'modDetailResep'=>$modDetailResep));
			}
		}else{
			if($caraPrint=='PRINT') {
				$this->layout='//layouts/printWindows';
				$this->render('Print',array('modPendaftaran'=>$modPendaftaran,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint,"modDetailResep"=>$modDetailResep));
			}
		}
	}
		
    /**
     * Mengurai data pasien berdasarkan:
     * - instalasi_id
     * - pendaftaran_id
     * - pasienadmisi_id
     * - no_pendaftaran
     * - no_rekam_medik
     * @throws CHttpException
     */
    public function actionGetDataInfoPasien()
    {
        if(Yii::app()->request->isAjaxRequest) {
            $format = new MyFormatter();
            $instalasi_id = isset($_POST['instalasi_id']) ? $_POST['instalasi_id'] : null;
            $pendaftaran_id = isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null;
            $pasienadmisi_id = isset($_POST['pasienadmisi_id']) ? $_POST['pasienadmisi_id'] : null;
            $no_pendaftaran = isset($_POST['no_pendaftaran']) ? $_POST['no_pendaftaran'] : null;
            $no_rekam_medik = isset($_POST['no_rekam_medik']) ? $_POST['no_rekam_medik'] : null;
            $returnVal = array();
            $criteria = new CDbCriteria();
			if(!empty($pendaftaran_id)){
				$criteria->addCondition("pendaftaran_id = ".$pendaftaran_id);						
			}
			if(!empty($pasienadmisi_id)){
				$criteria->addCondition("pasienadmisi_id = ".$pasienadmisi_id);						
			}
			if(!empty($instalasi_id)){
				$criteria->addCondition("instalasi_id = ".$instalasi_id);						
			}
            $criteria->compare('LOWER(no_pendaftaran)',strtolower(trim($no_pendaftaran)));
            $criteria->compare('LOWER(no_rekam_medik)',strtolower(trim($no_rekam_medik)));
            if($instalasi_id == Params::INSTALASI_ID_RD){
                $model = PCInfoKunjunganRDV::model()->find($criteria);
            }else if($instalasi_id == Params::INSTALASI_ID_RJ){
                $model = PCInfoKunjunganRJV::model()->find($criteria);
            }else if($instalasi_id == Params::INSTALASI_ID_RI){
                $model = PCInfopasienmasukkamarV::model()->find($criteria);
            }
            $attributes = $model->attributeNames();
            foreach($attributes as $j=>$attribute) {
                $returnVal["$attribute"] = $model->$attribute;
            }
            $returnVal["tanggal_lahir"] = $format->formatDateTimeForUser($model->tanggal_lahir);
            $returnVal["tgl_pendaftaran"] = $format->formatDateTimeForUser($model->tgl_pendaftaran);
            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }
}