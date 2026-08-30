<?php
class InformasiAsuhanKeperawatanController extends MyAuthController {
	public $path_view = 'asuhanKeperawatan.views.informasiAsuhanKeperawatan.';
	
	public function actionIndex()
	{
		$format = new MyFormatter();
		$model = new ASInformasiasuhankeperawatanV('searchInformasi');
		$model->tgl_awal=date("Y-m-d");
		$model->tgl_akhir=date("Y-m-d");
		$model->instalasi_id = Yii::app()->user->getState('instalasi_id');
		
		if(isset($_GET['ASInformasiasuhankeperawatanV']))
		{
			$model->attributes=$_GET['ASInformasiasuhankeperawatanV'];
			$model->tgl_awal = $format->formatDateTimeForDb($_GET['ASInformasiasuhankeperawatanV']['tgl_awal']);
			$model->tgl_akhir = $format->formatDateTimeForDb($_GET['ASInformasiasuhankeperawatanV']['tgl_akhir']);
			$model->ruangan_id = $_GET['ASInformasiasuhankeperawatanV']['ruangan_id'];
		}
		
		$this->render($this->path_view.'index',array(
			'format'=>$format,
			'model'=>$model
		));
	}
	
	
	public function actionDetail($asuhankeperawatan_id = null){
		$this->layout = 'iframe';
		
		$model = ASAsuhankeperawatanT::model()->findByPk($asuhankeperawatan_id);     
		$modPlaning = ASPlaningaskepT::model()->findAllByAttributes(array('asuhankeperawatan_id'=>$asuhankeperawatan_id));
		$modIntervensi = ASIntervensiaskepT::model()->findAllByAttributes(array('asuhankeperawatan_id'=>$asuhankeperawatan_id));
		$modImplementasi = ASImplementasiaskepT::model()->findAllByAttributes(array('asuhankeperawatan_id'=>$asuhankeperawatan_id));
        
        $this->render($this->path_view.'_detail', array(
			'model'=>$model,
			'modPlaning'=>$modPlaning,
			'modIntervensi'=>$modIntervensi,
			'modImplementasi'=>$modImplementasi,
        ));
	}
	/**
     * Mengatur dropdown ruangan
     * @param type $encode jika = true maka return array jika false maka set Dropdown 
     * @param type $model_nama
     * @param type $attr
     */
    public function actionSetDropdownRuangan($encode=false,$model_nama='',$attr='')
    {
        if(Yii::app()->request->isAjaxRequest) {
            $instalasi_id = null;
            if($model_nama !=='' && $attr == ''){
                $instalasi_id = $_POST["$model_nama"]['instalasi_id'];
            }
             else if ($model_nama == '' && $attr !== '') {
                $instalasi_id = $_POST["$attr"];
            }
             else if ($model_nama !== '' && $attr !== '') {
                $instalasi_id = $_POST["$model_nama"]["$attr"];
            }
            $models = null;
            $models = CHtml::listData(STRuanganM::getRuanganByInstalasi($instalasi_id),'ruangan_id','ruangan_nama');

            if($encode){
                echo CJSON::encode($models);
            } else {
                echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
                if(count($models) > 0){
                    foreach($models as $value=>$name){
                        echo CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
                    }
                }
            }
        }
        Yii::app()->end();
    }
	
	public function actionPrintDetail($asuhankeperawatan_id)
    {
		$format = new MyFormatter();
		$model = ASAsuhankeperawatanT::model()->findByPk($asuhankeperawatan_id);     
		$modPlaning = ASPlaningaskepT::model()->findAllByAttributes(array('asuhankeperawatan_id'=>$asuhankeperawatan_id));
		$modIntervensi = ASIntervensiaskepT::model()->findAllByAttributes(array('asuhankeperawatan_id'=>$asuhankeperawatan_id));
		$modImplementasi = ASImplementasiaskepT::model()->findAllByAttributes(array('asuhankeperawatan_id'=>$asuhankeperawatan_id));
		
        $judulLaporan = 'Asuhan Keperawatan';
		$deskripsi = $format->formatDateTimeForUser($model->tglaskep);
        $caraPrint = (isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null);
		if($caraPrint=='PRINT') {
			$this->layout='//layouts/printWindows';
			$this->render('printDetail',array('format'=>$format,'model'=>$model,'modPlaning'=>$modPlaning,'modImplementasi'=>$modImplementasi,'modIntervensi'=>$modIntervensi,'deskripsi'=>$deskripsi,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
		}
		else if($caraPrint=='EXCEL') {
			$this->layout='//layouts/printExcel';
			$this->render('printDetail',array('format'=>$format,'model'=>$model,'modPlaning'=>$modPlaning,'modImplementasi'=>$modImplementasi,'modIntervensi'=>$modIntervensi,'deskripsi'=>$deskripsi,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
		}
		else if($_REQUEST['caraPrint']=='PDF') {
			$ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas'); //Ukuran Kertas Pdf
			$posisi = Yii::app()->user->getState('posisi_kertas'); //Posisi L->Landscape,P->Portait
			$mpdf = new MyPDF('',$ukuranKertasPDF); 
			$mpdf->useOddEven = 2;  
			$stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
			$mpdf->WriteHTML($stylesheet,1);  
			$mpdf->AddPage($posisi,'','','','',15,15,15,15,15,15);
			$mpdf->WriteHTML($this->renderPartial('printDetail',array('format'=>$format,'model'=>$model,'modPlaning'=>$modPlaning,'modImplementasi'=>$modImplementasi,'modIntervensi'=>$modIntervensi,'deskripsi'=>$deskripsi,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint),true));
			$mpdf->Output();
		}
    }
}