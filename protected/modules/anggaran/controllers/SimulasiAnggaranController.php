<?php

class SimulasiAnggaranController extends MyAuthController{
	public $layout='//layouts/column1';
	public $defaultAction = 'index';
	public $savesimulasi = true; // true karena var ini dilooping ala cak lontong
	public function actionIndex($nosimulasianggaran=null){
		$model = new AGSimulasianggaranT;
		if(!empty($nosimulasianggaran)){
			$model = AGSimulasianggaranT::model()->findAllByAttributes(array('nosimulasianggaran'=>$nosimulasianggaran));
		}
		if(isset($_POST['AGSimulasianggaranT'])){
            $transaction = Yii::app()->db->beginTransaction();
            try {
				foreach($_POST['AGSimulasianggaranT'] as $i =>$postsimulasianggaran){
					$model = new AGSimulasianggaranT;
					$model->attributes = $postsimulasianggaran;
					$model->kenaikan_persen = str_replace(",", ".", str_replace(".", "", $model->kenaikan_persen));
					$model->kenaikan_rupiah = str_replace(",", ".", str_replace(".", "", $model->kenaikan_rupiah));
					$model->total_nilaianggaran = str_replace(",", ".", str_replace(".", "", $model->total_nilaianggaran));
					// var_dump($model->attributes); die;
					$model->create_ruangan = Yii::app()->user->getState('ruangan_id');
					$model->create_loginpemakai_id = Yii::app()->user->id;
					$model->create_time = date('Y-m-d H:i:s');
					if($model->validate()){
						if($model->save()){
							$this->savesimulasi &= true;
						}
					}
				}
				// die;
				if($this->savesimulasi){
					$transaction->commit();
					$this->redirect(array('index','nosimulasianggaran'=>$model->nosimulasianggaran,'sukses'=>1));
				}else{
					$transaction->rollback();
					Yii::app()->user->setFlash('error',"Data Simulasi Anggaran gagal disimpan !");
				}
            } catch (Exception $e) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error',"Data Simulasi Anggaran gagal disimpan ! ".MyExceptionMessage::getMessage($e,true));
            }
		}
		
		$this->render('index',array(
			'model'=>$model,
		));
	}
	
    public function actionLoadRowDetail(){
		if(Yii::app()->request->isAjaxRequest) {
		$periode = $_POST['periode'];
		$unitkerja = $_POST['unitkerja'];
		$anggaran = $_POST['anggaran'];
		$form = '';
		$modSimulasiAnggaran = new AGSimulasianggaranT();
		if($anggaran == 0){
			$model = RencanggaranpengT::model()->findByAttributes(array('konfiganggaran_id'=>$periode,'unitkerja_id'=>$unitkerja),array('order'=>'create_time DESC'));
			if(!empty($model)){
				$modelDetails = RencanggaranpengdetailT::model()->findAllByAttributes(array('rencanggaranpeng_id'=>$model->rencanggaranpeng_id));
				foreach($modelDetails as $i => $modelDetail){
					$modSimulasiAnggaran->konfiganggaran_id = $model->konfiganggaran_id;
					$modSimulasiAnggaran->unitkerja_id = $model->unitkerja_id;
					$modSimulasiAnggaran->subkegiatanprogram_id = $modelDetail->subkegiatanprogram_id;
					$modSimulasiAnggaran->nosimulasianggaran = MyGenerator::noSimulasiAnggaran();
					$modSimulasiAnggaran->tglsimulasianggaran = date('Y-m-d');
					$modSimulasiAnggaran->nilai_anggaran = $modelDetail->nilairencpengeluaran;
					$modSimulasiAnggaran->kenaikan_persen = 0;
					$modSimulasiAnggaran->kenaikan_rupiah = 0;
					$modSimulasiAnggaran->total_nilaianggaran = MyFormatter::formatNumberForPrint($modSimulasiAnggaran->nilai_anggaran+$modSimulasiAnggaran->kenaikan_rupiah);
					$form .= $this->renderPartial('_rowDetail',array('modSimulasiAnggaran'=>$modSimulasiAnggaran,'model'=>$model,'modelDetail'=>$modelDetail,'i'=>$i),true);
				}
			}
		}else{
			$modelDetails = AGApprrencanggaranT::model()->findAllByAttributes(array('konfiganggaran_id'=>$periode,'unitkerja_id'=>$unitkerja),array('order'=>'create_time ASC'));
			if(count((array)$modelDetails)>0){
				foreach($modelDetails as $i => $modelDetail){
					$modSimulasiAnggaran->konfiganggaran_id = $modelDetail->konfiganggaran_id;
					$modSimulasiAnggaran->unitkerja_id = $modelDetail->unitkerja_id;
					$modSimulasiAnggaran->subkegiatanprogram_id = $modelDetail->subkegiatanprogram_id;
					$modSimulasiAnggaran->nosimulasianggaran = MyGenerator::noSimulasiAnggaran();
					$modSimulasiAnggaran->tglsimulasianggaran = date('Y-m-d');
					$modSimulasiAnggaran->nilai_anggaran = $modelDetail->nilaiygdisetujui;
					$modSimulasiAnggaran->kenaikan_persen = 0;
					$modSimulasiAnggaran->kenaikan_rupiah = 0;
					$modelDetail->nilairencpengeluaran = $modelDetail->nilaiygdisetujui;
					$modSimulasiAnggaran->total_nilaianggaran = MyFormatter::formatNumberForPrint($modSimulasiAnggaran->nilai_anggaran+$modSimulasiAnggaran->kenaikan_rupiah);
					$form .= $this->renderPartial('_rowDetail',array('modSimulasiAnggaran'=>$modSimulasiAnggaran,'modelDetail'=>$modelDetail,'i'=>$i),true);
				}
			}
		}
		$data['form']=$form;
		echo json_encode($data);
            Yii::app()->end();
        }
	}
	
	public function actionPrint($nosimulasianggaran) 
    {
		$this->layout='//layouts/printWindows';
        $model = AGSimulasianggaranT::model()->findAllByAttributes(array('nosimulasianggaran'=>$nosimulasianggaran));
        $judul_print = 'Simulasi Anggaran';
        
        
        $this->render('Print', array(
                'model'=>$model,
                'judul_print'=>$judul_print
        ));
    }
	
}

