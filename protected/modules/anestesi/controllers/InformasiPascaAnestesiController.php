<?php

class InformasiPascaAnestesiController extends MyAuthController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';
	public $defaultAction = 'index';
	public $path_view='anestesi.views.informasiPascaAnestesi.';
	public $path_tips='anestesi.views.tips.';


	public function actionIndex()
	{
		$model = new ATInformasipascaanestesiV('searchInformasiPasien');
		$model->unsetAttributes();
		$model->tgl_awal = date('d M Y H:i:s');
		$model->tgl_akhir = date('d M Y H:i:s');
		
		if(isset($_GET['ATInformasipascaanestesiV'])){
			$model->attributes = $_GET['ATInformasipascaanestesiV'];
			$format = new MyFormatter();
			$model->tgl_awal  = $format->formatDateTimeForDb($_GET['ATInformasipascaanestesiV']['tgl_awal']);
			$model->tgl_akhir = $format->formatDateTimeForDb($_GET['ATInformasipascaanestesiV']['tgl_akhir']);
		}

		if (Yii::app()->request->isAjaxRequest) {
			echo $this->renderPartial('_tablePasien', array('model'=>$model));
		}else{
			$this->render('index',array('model'=>$model));
		}
	}
	
	 public function actionBatalPemeriksaan(){
		if(Yii::app()->request->isAjaxRequest)
		{ 
			$pesan = '';
			$status = '';
			$status_obatalkes = '';
			
			$pasienanastesi_id = isset($_POST['pasienanastesi_id']) ? $_POST['pasienanastesi_id'] : null;
			$pascaanestesi_id = isset($_POST['pascaanestesi_id']) ? $_POST['pascaanestesi_id'] : null;
							
			$transaction = Yii::app()->db->beginTransaction();
			try{
				$modPasienAnestesi = ATPasienanastesiT::model()->findByPk($pasienanastesi_id);
				$pascaanestesi_id = ATPraanestesiT::model()->findByPk($pascaanestesi_id);
				$modPasienMasukPenunjang = ATPasienmasukpenunjangT::model()->findByPk($modPasienAnestesi->pasienmasukpenunjang_id);				
				$modPendaftaran = PendaftaranT::model()->findByPk($modPasienAnestesi->pendaftaran_id);
				$modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);

				$criteria = new CDbCriteria();
				$criteria->addCondition('pasienmasukpenunjang_id = '.$modPasienAnestesi->pasienmasukpenunjang_id);
				$criteria->addCondition('tindakansudahbayar_id is not null');
				$modTindakan = ATTindakanpelayananT::model()->findAll($criteria);

				$criteriaObat = new CDbCriteria();
				$criteriaObat->addCondition('pasienmasukpenunjang_id = '.$modPasienAnestesi->pasienmasukpenunjang_id);
				$criteriaObat->addCondition('oasudahbayar_id is not null');
				$modObat = ATObatalkespasienT::model()->findAll($criteriaObat);
				
				if(count($modTindakan) > 0 || count($modObat) > 0){
					$pesan = "Pemeriksaan Anestesi tidak bisa dibatalkan karena ada tindakan yang sudah dibayarkan!";
				}else{
					$modPasienAnestesi->statusanestesi = '';
					$update_pasienanestesi = $modPasienAnestesi->update();
					
					if($update_pasienanestesi){
						$status = true;
					}else{
						$status = false;
					}
					
					$delete_tindakananestesi = ATTindakananestesiT::model()->deleteAllByAttributes(array('pascaanestesi_id'=>$pascaanestesi_id));
					if($delete_tindakananestesi){
						$status = true;
					}else{
						$status = false;
					}
					
					$delete_obatanestesi = ATObatalkesanestesiT::model()->deleteAllByAttributes(array('pascaanestesi_id'=>$pascaanestesi_id));
					if($delete_obatanestesi){
						$status = true;
					}else{
						$status = false;
					}					
					
					foreach($modTindakan as $tindakan){
						$update_obatalkes = ATObatalkespasienT::model()->updateAll(array('tindakanpelayanan_id'=>null),'pasienmasukpenunjang_id="'.$tindakan->tindakanpelayanan_id.'"');					
						if($update_obatalkes){
							$status_obatalkes = true;
						}else{
							$status_obatalkes = false;
						}
					}
					
					if($status_obatalkes == true){
						$delete_tindakan = ATTindakanpelayananT::model()->deleteAllByAttributes(array('pasienmasukpenunjang_id'=>$modPasienAnestesi->pasienmasukpenunjang_id));
						if($delete_tindakan){
							$status = true;
						}else{
							$status = false;

						}

						$delete_obat = ATObatalkespasienT::model()->deleteAllByAttributes(array('pasienmasukpenunjang_id'=>$modPasienAnestesi->pasienmasukpenunjang_id));
						if($delete_obat){
							$status = true;
						}else{
							$status = false;

						}
					}
					
					$select_intraanestesi = ATIntraanestesiT::model()->findByAttributes(array('pasienanastesi_id'=>$pasienanastesi_id));
					if(count($select_intraanestesi) > 0){
						$select_kondisipasien = ATKondisipasienanestesiT::model()->findByAttributes(array('intraanestesi_id'=>$select_intraanestesi->intraanestesi_id));
						if(count($select_kondisipasien) > 0){
							$delete_kondisipasien = ATKondisipasienanestesiT::model()->deleteAllByAttributes(array('intraanestesi_id'=>$select_intraanestesi->intraanestesi_id));
							if($delete_kondisipasien){
								$status = true;
							}else{
								$status = false;
							}	
						}
						$delete_intraanestesi = ATIntraanestesiT::model()->deleteAllByAttributes(array('pasienanastesi_id'=>$pasienanastesi_id));
						if($delete_intraanestesi){
							$status = true;
						}else{
							$status = false;
						}					
					}
					
					$delete_pascaanestesi = ATPascaanestesiT::model()->deleteByPk($pascaanestesi_id);
					if($delete_pascaanestesi){
						$status = true;
					}else{
						$status = false;
					}

					$delete_praanestesi = ATPraanestesiT::model()->deleteAllByAttributes(array('pasienanastesi_id'=>$pasienanastesi_id));
					if($delete_praanestesi){
						$delete_pasienanastesi = ATPasienanastesiT::model()->deleteByPk($pasienanastesi_id);
						if($delete_pasienanastesi){
							$status = true;
						}else{
							$status = false;
						}
					}else{
						$status = false;
					}
					
					if($status = true){		
						$pesan = 'Pasien Rencana Pemeriksaan Anastesi berhasil di batalkan';
						$transaction->commit();
					}else{
						$transaction->rollback();
					}
				}
			} catch (Exception $ex) {
				$status = false;
				$pesan = "exist";
				$transaction->rollback();
			}	
			
			$data = array(
			  'pesan'=>$pesan,
			  'status'=>$status,
			);
			echo json_encode($data);
			Yii::app()->end();
		}			
	}
	
	/**
     * untuk rincian Pra Anestesi
     */
    public function actionView($pasienanastesi_id,$pascaanestesi_id) 
    {
		$this->layout = '//layouts/iframe';
        $format = new MyFormatter;    
		$modPascaAnestesi = ATPascaanestesiT::model()->findByPk($pascaanestesi_id);     
        $modPasienAnestesi = ATPasienanastesiT::model()->findByPk($pasienanastesi_id);             
        $modTindakanAnestesi = ATTindakananestesiT::model()->findAllByAttributes(array('intraanestesi_id'=>$modPascaAnestesi->intraanestesi_id));
        $modObatAlkesAnestesi = ATObatalkesanestesiT::model()->findAllByAttributes(array('intraanestesi_id'=>$modPascaAnestesi->intraanestesi_id));
		$modPendaftaran = ATPendaftaranT::model()->findByPk($modPasienAnestesi->pendaftaran_id);
		$modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id); 
        $modKondisiPasien = ATKondisipasienanestesiT::model()->findAllByAttributes(array('pascaanestesi_id'=>$modPascaAnestesi->pascaanestesi_id));
		if(!empty($modPascaAnestesi->intraanestesi_id)){
			$modPraAnestesi = ATPraanestesiT::model()->findByAttributes(array('praanestesi_id'=>$modPascaAnestesi->intraanestesi->praanestesi_id));
		}else{
			$modPraAnestesi = new ATPraanestesiT();
		}
		
        $this->render($this->path_view.'_rincianPascaAnestesi', array(
                'format'=>$format,
                'modPasienAnestesi'=>$modPasienAnestesi,
                'modPascaAnestesi'=>$modPascaAnestesi,
                'modTindakanAnestesi'=>$modTindakanAnestesi,
                'modObatAlkesAnestesi'=>$modObatAlkesAnestesi,
				'modPendaftaran'=>$modPendaftaran,
				'modPasien'=>$modPasien,
				'modKondisiPasien'=>$modKondisiPasien,
				'modPraAnestesi'=>$modPraAnestesi
        ));
    } 
}
