<?php
class PersetujuanTindakanController extends MyAuthController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';
	public $defaultAction = 'index';
	public $path_view = 'anestesi.views.persetujuanTindakan.';
	/**
	 * Lists all models.
	 */
	public function actionIndex($pasienanastesi_id = null, $pendaftaran_id = null)
	{	
                if(!empty($pendaftaran_id)){
                    $this->layout = '//layouts';
                }
                $format = new MyFormatter();
                if(!empty(@$_GET['suratpersetujuantm_id'])){
                    $modSuratPersetujuan = ATSuratpersetujuantmT::model()->findByPk($_GET['suratpersetujuantm_id']);     
                }
                else{
                    $modSuratPersetujuan = new ATSuratpersetujuantmT();
                }
		$data=ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());
		
		if(!empty($pasienanastesi_id)) {
			$criteria = new CDbCriteria();
			$criteria->addCondition('pasienanastesi_id = '.$pasienanastesi_id);
			$modKunjungan = ATInformasipasienanestesiV::model()->find($criteria);
                        $modPasienAnestesi = ATPasienanastesiT::model()->findByPk($pasienanastesi_id);     
                        $modPraAnestesi = ATPraanestesiT::model()->findByAttributes(array('pasienanastesi_id'=>$pasienanastesi_id),array('order'=>'praanestesi_id DESC'));     
                        if(!empty($modPraAnestesi)){
                                $modTindakanAnestesi = ATTindakananestesiT::model()->findAllByAttributes(array('praanestesi_id'=>$modPraAnestesi->praanestesi_id));
                                $modObatAlkesAnestesi = ATObatalkesanestesiT::model()->findAllByAttributes(array('praanestesi_id'=>$modPraAnestesi->praanestesi_id));
                        }else{
                                $modTindakanAnestesi = array();
                                $modObatAlkesAnestesi = array();
                        }
                        $modPendaftaran = PendaftaranT::model()->findByPk($modPasienAnestesi->pendaftaran_id);
		}
                else if(!empty($pendaftaran_id)){
                        $modTindakanAnestesi = array();
                        $modObatAlkesAnestesi = array();
                        $modPasienAnestesi = array();
                        $modPraAnestesi = array();
                        $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
                        $modKunjungan = new ATInformasipasienanestesiV();
                }
                else{
			$modKunjungan = new ATInformasipasienanestesiV();
		}
		
		$modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
		
	if(isset($_POST['ATSuratpersetujuantmT']))
        {
            $pasienanastesi_id = isset($_GET['pasienanastesi_id']) ? $_GET['pasienanastesi_id'] : null;
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $modSuratPersetujuan->attributes=$_POST['ATSuratpersetujuantmT'];  
                $modSuratPersetujuan->pasienanastesi_id= $pasienanastesi_id;
                $modSuratPersetujuan->ruangan_id= Yii::app()->user->getState('ruangan_id');				
                $modSuratPersetujuan->tglpersetujuan = date('Y-m-d H:i:s');
                $modSuratPersetujuan->nopersetujuan = MyGenerator::noPersetujuan();
                $modSuratPersetujuan->create_time = date('Y-m-d');
                $modSuratPersetujuan->update_time = date('Y-m-d');
                $modSuratPersetujuan->create_loginpemakai_id = Yii::app()->user->id;
                $modSuratPersetujuan->update_loginpemakai_id = Yii::app()->user->id;
                $modSuratPersetujuan->create_ruangan = Yii::app()->user->getState('ruangan_id');

                if($modSuratPersetujuan->validate()){
                   if($modSuratPersetujuan->save()){
                      $transaction->commit();
                      $modSuratPersetujuan->isNewRecord = FALSE;
                      if(!empty(@$_GET['pasienanastesi_id'])){
                          $modSuratPersetujuan->suratpersetujuantm_id = $modSuratPersetujuan->suratpersetujuantm_id;
                          $modSuratPersetujuan->pasienanastesi_id = $modPasienAnestesi->pasienanastesi_id;
                      }
                   }else{
                       echo "gagal Simpan";exit;
                   } 

                    Yii::app()->user->setFlash('success',"Surat Persetujuan Tindakan Medis berhasil disimpan");
                    if(!empty(@$_GET['pasienanastesi_id'])){
                        $this->redirect(array('Index','pasienanastesi_id'=>$pasienanastesi_id,
                                            'suratpersetujuantm_id'=>$modSuratPersetujuan->suratpersetujuantm_id)); 
                    }
                    else{
                        $this->redirect(array('Index', 'pendaftaran_id'=>$modPendaftaran->pendaftaran_id,
                                            'suratpersetujuantm_id'=>$modSuratPersetujuan->suratpersetujuantm_id)); 
                    }
                    
                }  
            }
            catch (Exception $exc) 
            {
                $transaction->rollback();
                Yii::app()->user->setFlash('error',"Surat Surat Persetujuan Tindakan Medis gagal disimpan ");
            }
        } 
		
		$this->render($this->path_view.'index',array(
			'modKunjungan'=>$modKunjungan,
			'modSuratPersetujuan'=>$modSuratPersetujuan,
			'modPasienAnestesi'=>$modPasienAnestesi,
			'modPraAnestesi'=>$modPraAnestesi,
			'modTindakanAnestesi'=>$modTindakanAnestesi,
			'modObatAlkesAnestesi'=>$modObatAlkesAnestesi,
			'modPendaftaran'=>$modPendaftaran,
			'modPasien'=>$modPasien,
			'format'=>$format,
			'data'=>$data
		));
	}
	
	public function actionPrint($pasienanastesi_id = null,$suratpersetujuantm_id = null, $pendaftaran_id = null){
        $this->layout = '//layouts/iframe';
		
	$data=ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());
	$format = new MyFormatter();
        if(!empty($pasienanastesi_id)) {
		$criteria = new CDbCriteria();
		$criteria->addCondition('pasienanastesi_id = '.$pasienanastesi_id);
		$modKunjungan = ATInformasipasienanestesiV::model()->find($criteria);
                $modPasienAnestesi = ATPasienanastesiT::model()->findByPk($pasienanastesi_id);     
                $modPraAnestesi = ATPraanestesiT::model()->findByAttributes(array('pasienanastesi_id'=>$pasienanastesi_id),array('order'=>'praanestesi_id DESC'));     
		if(!empty($modPraAnestesi)){
			$modTindakanAnestesi = ATTindakananestesiT::model()->findAllByAttributes(array('praanestesi_id'=>$modPraAnestesi->praanestesi_id));
			$modObatAlkesAnestesi = ATObatalkesanestesiT::model()->findAllByAttributes(array('praanestesi_id'=>$modPraAnestesi->praanestesi_id));
		}else{
			$modTindakanAnestesi = array();
			$modObatAlkesAnestesi = array();
		}
		$modPendaftaran = PendaftaranT::model()->findByPk($modPasienAnestesi->pendaftaran_id);
		
	}else{
                $modTindakanAnestesi = array();
		$modObatAlkesAnestesi = array();
                $modPasienAnestesi = array();
                $modPraAnestesi = array();
		$modKunjungan = new ATInformasipasienanestesiV();
                $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
	}
		
		$modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);         
		$modSuratPersetujuan = ATSuratpersetujuantmT::model()->findByPk($suratpersetujuantm_id);         
		
        $judulLaporan = '';

        $caraPrint=$_REQUEST['caraprint'];
        if($caraPrint=='PRINT') {
            $this->layout='//layouts/printWindows';
        }
        $this->render($this->path_view.'print',array(
                'modKunjungan'=>$modKunjungan,
				'modSuratPersetujuan'=>$modSuratPersetujuan,
				'modPasienAnestesi'=>$modPasienAnestesi,
				'modPraAnestesi'=>$modPraAnestesi,
				'modTindakanAnestesi'=>$modTindakanAnestesi,
				'modObatAlkesAnestesi'=>$modObatAlkesAnestesi,
				'modPendaftaran'=>$modPendaftaran,
				'modPasien'=>$modPasien,
				'format'=>$format,
				'data'=>$data));
    }
}
