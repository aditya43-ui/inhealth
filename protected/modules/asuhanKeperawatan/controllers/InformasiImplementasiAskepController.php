<?php
class InformasiImplementasiAskepController extends MyAuthController {
	public $path_view = 'asuhanKeperawatan.views.informasiImplementasiAskep.';
	
	public function actionIndex()
	{
		$format = new MyFormatter();
		$model = new ASInfoimplementasiaskepV('search');
		$model->tgl_awal=date("Y-m-d");
		$model->tgl_akhir=date("Y-m-d");
//		$model->instalasi_id = Params::INSTALASI_ID_RI;
		
		if(isset($_GET['ASInfoimplementasiaskepV']))
		{
			$model->attributes=$_GET['ASInfoimplementasiaskepV'];
			$model->tgl_awal = $format->formatDateTimeForDb($_GET['ASInfoimplementasiaskepV']['tgl_awal']);
			$model->tgl_akhir = $format->formatDateTimeForDb($_GET['ASInfoimplementasiaskepV']['tgl_akhir']);
			$model->ruangan_id = $_GET['ASInfoimplementasiaskepV']['ruangan_id'];
		}
		
		$this->render($this->path_view.'index',array(
			'format'=>$format,
			'model'=>$model
		));
	}
	
	public function actionDetail($implementasiaskep_id = null){
		$this->layout = "//layouts/iframe";
		
		$model = ASInfoimplementasiaskepV::model()->findByAttributes(array('implementasiaskep_id'=>$implementasiaskep_id));
		$model->attributes = $model;
		$modRencana = ASInforencanaaskepV::model()->findByAttributes(array('rencanaaskep_id'=>$model->rencanaaskep_id));
		$modPasien = PasienM::model()->findByAttributes(array('pasien_id' => $model->pasien_id));
                $modPendaftaran = PendaftaranT::model()->findByAttributes(array('pendaftaran_id' => $model->pendaftaran_id));
        $this->render($this->path_view.'_detail', array(
			'model' => $model,
			'modRencana' => $modRencana,
			'modPasien' => $modPasien, 
                        'modPendaftaran' => $modPendaftaran,
        ));
	}
	
	public function actionPrintDetail() {
		$model = ASImplementasiaskepT::model()->findByPk($_REQUEST['implementasiaskep_id']);
		$model->attributes = $model;
		$modRencana = ASInforencanaaskepV::model()->findByAttributes(array('rencanaaskep_id' => $model->rencanaaskep_id));
		$modPasien = PasienM::model()->findByAttributes(array('pasien_id' => $modRencana->pasien_id));
                $modPendaftaran = PendaftaranT::model()->findByAttributes(array('pendaftaran_id' => $modRencana->pendaftaran_id));
		$modDetail = new ASImplementasiaskepdetT;
		$judulLaporan = 'Implementasi Asuhan Keperawatan';
		$caraPrint = $_REQUEST['caraPrint'];
		if ($caraPrint == 'PRINT') {
			$this->layout = '//layouts/printWindows';
			$this->render($this->path_view . 'PrintDetail', array('model' => $model, 'modPasien' => $modPasien, 'modPendaftaran' => $modPendaftaran,'modDetail' => $modDetail, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
		} else if ($caraPrint == 'EXCEL') {
			$this->layout = '//layouts/printExcel';
			$this->render($this->path_view . 'PrintDetail', array('model' => $model, 'modPasien' => $modPasien, 'modPendaftaran' => $modPendaftaran,'modDetail' => $modDetail, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
		} else if ($_REQUEST['caraPrint'] == 'PDF') {
			$ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');   //Ukuran Kertas Pdf
			$posisi = Yii::app()->user->getState('posisi_kertas');   //Posisi L->Landscape,P->Portait
			$mpdf = new MyPDF('', $ukuranKertasPDF);
			$mpdf->mirrorMargins = 2;
			$stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
			$mpdf->WriteHTML($stylesheet, 1);
			$mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
			$mpdf->WriteHTML($this->renderPartial($this->path_view . 'PrintDetail', array('model' => $model, 'modPasien' => $modPasien, 'modPendaftaran' => $modPendaftaran,'modDetail' => $modDetail, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
			$mpdf->Output();
		}
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
	
    public function actionHapusData(){
        if(Yii::app()->request->isAjaxRequest) {
            $id = $_POST['id'];
            $trans = Yii::app()->db->beginTransaction();
            try{
               
                
                $cri_del = new CDbCriteria();
                $cri_del->join = " JOIN implementasiaskepdet_t det ON det.implementasiaskepdet_id = t.implementasiaskepdet_id ";
                $cri_del->addCondition(" det.implementasiaskep_id = ".$id." ");
                $del_pilih = ASPilihimplementasiaskepT::model()->findAll($cri_del);
                
                if (!empty($del_pilih)){
                    foreach($del_pilih as $del){
                        $del->delete();
                    }
                }
                
                $cri_del = new CDbCriteria();
                $cri_del->addCondition(" implementasiaskep_id = ".$id." ");
                $del_det = ASImplementasiaskepdetT::model()->deleteAll($cri_del);

                $del_imp = ASImplementasiaskepT::model()->deleteByPk($id);
                
                $trans->commit();
                $data['sukses'] = 1;
                
            }catch(Exception $e){        
                $trans->rollback();
                $data['sukses'] = 0;
            }
            
            
            
            echo json_encode($data);
        }
        Yii::app()->end();
    }
}