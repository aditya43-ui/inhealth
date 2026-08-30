<?php

class InformasiReEvaluasiAssetController extends MyAuthController {
	public $layout='//layouts/column1';
	
	public function actionIndex()
	{
		$format = new MyFormatter; 
		$model	= new MAReevaluasiasetV('searchInformasi');
		$model->unsetAttributes();  // clear any default values
                $model->reevaluasiaset_tgl = date('Y-m-d');
                $model->tgl_awal = date('Y-m-d');
                $model->tgl_akhir = date('Y-m-d');
		if(isset($_GET['MAReevaluasiasetV'])){
			$model->attributes=$_GET['MAReevaluasiasetV'];
            $model->reevaluasiaset_tgl = $format->formatDateTimeForDb($model->reevaluasiaset_tgl);
            $model->reevaluasiaset_no = $model->reevaluasiaset_no;
                    $model->tgl_awal = $format->formatDateTimeForDb($model->tgl_awal);
                    $model->tgl_akhir = $format->formatDateTimeForDb($model->tgl_akhir);
		}
		$this->render('index',array(
				'model'=>$model, 'format'=>$format
		));
	}
}

