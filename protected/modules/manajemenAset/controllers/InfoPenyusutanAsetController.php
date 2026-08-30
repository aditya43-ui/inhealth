<?php

class InfoPenyusutanAsetController extends MyAuthController{
	public $layout='//layouts/column1';
	public $path_view = "manajemenAset.views.infoPenyusutanAset.";
	
	public function actionIndex()
	{
		$format = new MyFormatter; 
		$model	= new MAPenyusutanasetV('search');
		$model->unsetAttributes();  // clear any default values
        $model->tgl_awal = date('Y-m-d');
        $model->tgl_akhir = date('Y-m-d');
		if(isset($_GET['MAPenyusutanasetV'])){
			$model->attributes=$_GET['MAPenyusutanasetV'];
            $model->tgl_awal = $format->formatDateTimeForDb($model->tgl_awal);
            $model->tgl_akhir = $format->formatDateTimeForDb($model->tgl_akhir);
		}
		$this->render($this->path_view.'index',array(
				'model'=>$model, 'format'=>$format
		));
	}
	
    public function actionBatalPenyusutanAset($id){
		if(Yii::app()->request->isAjaxRequest)
		{
			$data['sukses']=0;
			$deleteDetail = PenyusutanasetdetailT::model()->deleteAllByAttributes(array('penyusutanaset_id'=>$id));
			$deletePenyusutanAset = PenyusutanasetT::model()->deleteByPk($id);			
			 if($deleteDetail && $deletePenyusutanAset){
				$data['sukses'] = 1;
			 }
			echo CJSON::encode($data); 
		}
    }
	public function actionDetail($id)
	{
		$this->layout = '//layouts/frameDialog';
        $modPenyusutanAset = MAPenyusutanasetT::model()->findByPk($id);
		if(count($modPenyusutanAset)>0){
			$modDetailPenyusutan = MAPenyusutanasetdetailT::model()->findAllByAttributes(array('penyusutanaset_id'=>$id));
			$this->render($this->path_view.'detailInformasi', array(
                'modPenyusutanAset' => $modPenyusutanAset,
                'modDetailPenyusutan' => $modDetailPenyusutan,
            ));
		}
	}
	
	/**
     * untuk print data pemakaian barang
     */
    public function actionPrint($penyusutanaset_id = null,$caraPrint = null) 
    {
        $format = new MyFormatter;   
        $penyusutanaset_id = isset($_GET['pemakaianbarang_id'])?$_GET['pemakaianbarang_id']:null;
        $modPenyusutanAset = MAPenyusutanasetT::model()->findByPk($penyusutanaset_id);     
        $modPenyusutanAsetDetail = MAPenyusutanasetdetailT::model()->findAllByAttributes(array('penyusutanaset_id'=>$penyusutanaset_id));

        $judul_print = 'PENYUSUTAN ASET';
        $caraPrint = isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null;
        if (isset($_GET['frame'])){
            $this->layout='//layouts/iframe';
        }
        if($caraPrint=='PRINT') {
            $this->layout='//layouts/printWindows';
        }
        else if($caraPrint=='EXCEL') {
            $this->layout='//layouts/printExcel';
        }
        
        $this->render($this->path_view.'Print', array(
			'format'=>$format,
			'judul_print'=>$judul_print,
			'modPenyusutanAset'=>$modPenyusutanAset,
			'modPenyusutanAsetDetail'=>$modPenyusutanAsetDetail,
			'caraPrint'=>$caraPrint
        ));
    } 
    
}
