<?php
class InformasiVerifikasiAskepController extends MyAuthController {
	public $path_view = 'asuhanKeperawatan.views.informasiVerifikasiAskep.';
	
	public function actionIndex()
	{
		$format = new MyFormatter();
		$model = new ASInfoverifikasiaskepV('search');
		$model->tgl_awal=date("Y-m-d");
		$model->tgl_akhir=date("Y-m-d");
//		$model->instalasi_id = Params::INSTALASI_ID_RI;
		
		if(isset($_GET['ASInfoverifikasiaskepV']))
		{
			$model->attributes=$_GET['ASInfoverifikasiaskepV'];
			$model->tgl_awal = $format->formatDateTimeForDb($_GET['ASInfoverifikasiaskepV']['tgl_awal']);
			$model->tgl_akhir = $format->formatDateTimeForDb($_GET['ASInfoverifikasiaskepV']['tgl_akhir']);
			$model->ruangan_id = $_GET['ASInfoverifikasiaskepV']['ruangan_id'];
		}
		
		$this->render($this->path_view.'index',array(
			'format'=>$format,
			'model'=>$model
		));
	}
	
//	public function actionDetail($rencanaaskep_id = null){
//		$this->layout = "//layouts/iframe";
//		
//		$model = ASInforencanaaskepV::model()->findByAttributes(array('rencanaaskep_id'=>$rencanaaskep_id));
//		$model->attributes = $model;
//
//		$modPasien = ASInfopengkajianaskepV::model()->findByAttributes(array('pengkajianaskep_id' => $model->pengkajianaskep_id));
//		
//        $this->render($this->path_view.'_detail', array(
//			'model' => $model, 
//			'modPasien' => $modPasien, 
//        ));
//	}
//	
//	public function actionPrintDetail() {
//		$model = ASRencanaaskepT::model()->findByPk($_REQUEST['rencanaaskep_id']);
//		$model->attributes = $model;
////		$modPengkajian = ASPengkajianaskepT::model()->findByPk($model->pengkajianaskep_id);
//		$modPasien = ASInfopengkajianaskepV::model()->findByAttributes(array('pengkajianaskep_id'=>$model->pengkajianaskep_id));
//
//		$modDetail = new ASRencanaaskepdetT;
//		$judulLaporan = 'Rencana Keperawatan';
//		$caraPrint = $_REQUEST['caraPrint'];
//		if ($caraPrint == 'PRINT') {
//			$this->layout = '//layouts/printWindows';
//			$this->render($this->path_view . 'PrintDetail', array('model' => $model, 'modPasien' => $modPasien, 'modDetail' => $modDetail, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
//		} else if ($caraPrint == 'EXCEL') {
//			$this->layout = '//layouts/printExcel';
//			$this->render($this->path_view . 'PrintDetail', array('model' => $model, 'modPasien' => $modPasien, 'modDetail' => $modDetail, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
//		} else if ($_REQUEST['caraPrint'] == 'PDF') {
//			$ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');   //Ukuran Kertas Pdf
//			$posisi = Yii::app()->user->getState('posisi_kertas');   //Posisi L->Landscape,P->Portait
//			$mpdf = new MyPDF('', $ukuranKertasPDF);
//			$mpdf->mirrorMargins = 2;
//			$stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
//			$mpdf->WriteHTML($stylesheet, 1);
//			$mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
//			$mpdf->WriteHTML($this->renderPartial($this->path_view . 'PrintDetail', array('model' => $model, 'modPasien' => $modPasien, 'modDetail' => $modDetail, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
//			$mpdf->Output();
//		}
//	}
	
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
            $models = CHtml::listData(ASRuanganM::getRuanganByInstalasi($instalasi_id),'ruangan_id','ruangan_nama');

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
	
	
}