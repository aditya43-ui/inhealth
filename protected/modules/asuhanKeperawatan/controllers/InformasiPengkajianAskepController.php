<?php
class InformasiPengkajianAskepController extends MyAuthController {
	public $path_view = 'asuhanKeperawatan.views.informasiPengkajianAskep.';
	
	public function actionIndex()
	{
		$format = new MyFormatter();
		$model = new ASInfopengkajianaskepV('search');
		$model->tgl_awal=date("Y-m-d");
		$model->tgl_akhir=date("Y-m-d");
//		$model->instalasi_id = Params::INSTALASI_ID_RI;
		
		if(isset($_GET['ASInfopengkajianaskepV']))
		{
			$model->attributes=$_GET['ASInfopengkajianaskepV'];
			$model->tgl_awal = $format->formatDateTimeForDb($_GET['ASInfopengkajianaskepV']['tgl_awal']);
			$model->tgl_akhir = $format->formatDateTimeForDb($_GET['ASInfopengkajianaskepV']['tgl_akhir']);
			$model->ruangan_id = $_GET['ASInfopengkajianaskepV']['ruangan_id'];
		}
		
                if (Yii::app()->request->isAjaxRequest){
                    $this->renderPartial($this->path_view.'index',array(
                            'format'=>$format,
                            'model'=>$model
                    ));
                }else{
                    $this->render($this->path_view.'index',array(
                            'format'=>$format,
                            'model'=>$model
                    ));
                }
	}
	
	public function actionDetail($pengkajianaskep_id = null){
		$this->layout = "//layouts/iframe";
		
		$modPengkajian = ASInfopengkajianaskepV::model()->findByAttributes(array('pengkajianaskep_id'=>$pengkajianaskep_id));
		$modPengkajian->attributes = $modPengkajian;

		$anamnesa = new ASAnamnesaT;
		$criteria = new CDbCriteria();
		$criteria->addCondition('anamesa_id ='.$modPengkajian->anamesa_id);
		$modAnamnesa = ASAnamnesaT::model()->find($criteria);

		$periksafisik = new ASPemeriksaanfisikT;
		$criteria = new CDbCriteria();
		$criteria->addCondition('pemeriksaanfisik_id ='.$modPengkajian->pemeriksaanfisik_id);
		$modPemeriksaanFisik = ASPemeriksaanfisikT::model()->find($criteria);
		$modPemeriksaanGambar = ASPemeriksaangambarT::model()->findAllByAttributes(array('pendaftaran_id' => $modPemeriksaanFisik->pendaftaran_id));
		$modGambarTubuh = new ASGambartubuhM();
		$modBagianTubuh = new ASBagiantubuhM();
		
		$penunjang = new ASDatapenunjangT;
		$criteria = new CDbCriteria();
		$criteria->addCondition('pengkajianaskep_id ='.$modPengkajian->pengkajianaskep_id);
		$modPenunjang = new CActiveDataProvider($penunjang, array(
			'criteria' => $criteria,
		));

        if ((!empty($modPemeriksaanFisik->gcs_eye)) && (!empty($modPemeriksaanFisik->gcs_verbal)) && (!empty($modPemeriksaanFisik->gcs_motorik))) {
			$modPemeriksaanFisik->namaGCS = $modPemeriksaanFisik->gcs_eye + $modPemeriksaanFisik->gcs_verbal + $modPemeriksaanFisik->gcs_motorik;
		}
		
        $this->render($this->path_view.'_detail', array(
			'modPengkajian' => $modPengkajian, 
			'modAnamnesa' => $modAnamnesa, 
			'modPemeriksaanFisik' => $modPemeriksaanFisik,
			'modPemeriksaanGambar' => $modPemeriksaanGambar,
			'modGambarTubuh' => $modGambarTubuh,
			'modBagianTubuh' => $modBagianTubuh,
			'modPenunjang' => $modPenunjang
        ));
	}
	
	public function actionPrintDetail() {
		$modPengkajian = ASInfopengkajianaskepV::model()->findByAttributes(array('pengkajianaskep_id'=>$_REQUEST['pengkajianaskep_id']));
		$modPengkajian->attributes = $modPengkajian;

		$anamnesa = new ASAnamnesaT;
		$criteria = new CDbCriteria();
		$criteria->addCondition('anamesa_id ='.$modPengkajian->anamesa_id);
		$modAnamnesa = ASAnamnesaT::model()->find($criteria);
		
		$periksafisik = new ASPemeriksaanfisikT;
		$criteria = new CDbCriteria();
		$criteria->addCondition('pemeriksaanfisik_id ='.$modPengkajian->pemeriksaanfisik_id);
		$modPemeriksaanFisik = ASPemeriksaanfisikT::model()->find($criteria);
		$modPemeriksaanGambar = ASPemeriksaangambarT::model()->findAllByAttributes(array('pendaftaran_id' => $modPemeriksaanFisik->pendaftaran_id));
		$modGambarTubuh = new ASGambartubuhM();
		$modBagianTubuh = new ASBagiantubuhM();
		
		$penunjang = new ASDatapenunjangT;
		$criteria = new CDbCriteria();
		$criteria->addCondition('pengkajianaskep_id ='.$modPengkajian->pengkajianaskep_id);
		$modPenunjang = new CActiveDataProvider($penunjang, array(
			'criteria' => $criteria,
		));
		
		if ((!empty($modPemeriksaanFisik->gcs_eye)) && (!empty($modPemeriksaanFisik->gcs_verbal)) && (!empty($modPemeriksaanFisik->gcs_motorik))) {
			$modPemeriksaanFisik->namaGCS = $modPemeriksaanFisik->gcs_eye + $modPemeriksaanFisik->gcs_verbal + $modPemeriksaanFisik->gcs_motorik;
		}
		
		$judulLaporan = 'Pengkajian Keperawatan';
		$caraPrint = $_REQUEST['caraPrint'];
		if ($_REQUEST['caraPrint'] == 'PRINT') {
			$this->layout = '//layouts/printWindows';
			$this->render($this->path_view . 'PrintDetail', array('modPengkajian' => $modPengkajian, 'modAnamnesa' => $modAnamnesa, 'modPemeriksaanFisik' => $modPemeriksaanFisik, 'modPemeriksaanGambar' => $modPemeriksaanGambar, 'modGambarTubuh' => $modGambarTubuh, 'modBagianTubuh' => $modBagianTubuh, 'modPenunjang' => $modPenunjang, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
		} else if ($_REQUEST['caraPrint'] == 'EXCEL') {
			$this->layout = '//layouts/printExcel';
			$this->render($this->path_view . 'PrintDetail', array('modPengkajian' => $modPengkajian, 'modAnamnesa' => $modAnamnesa, 'modPemeriksaanFisik' => $modPemeriksaanFisik, 'modPemeriksaanGambar' => $modPemeriksaanGambar, 'modGambarTubuh' => $modGambarTubuh, 'modBagianTubuh' => $modBagianTubuh, 'modPenunjang' => $modPenunjang, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
		} else if ($_REQUEST['caraPrint'] == 'PDF') {
			$ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');   //Ukuran Kertas Pdf
			$posisi = Yii::app()->user->getState('posisi_kertas');   //Posisi L->Landscape,P->Portait
			$mpdf = new MyPDF60('', $ukuranKertasPDF);
			$mpdf->mirrorMargins = 2;
			$stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
			$mpdf->WriteHTML($stylesheet, 1);
			$mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
			$mpdf->WriteHTML($this->renderPartial($this->path_view . 'PrintDetail', array('modPengkajian' => $modPengkajian, 'modAnamnesa' => $modAnamnesa, 'modPemeriksaanFisik' => $modPemeriksaanFisik, 'modPemeriksaanGambar' => $modPemeriksaanGambar, 'modGambarTubuh' => $modGambarTubuh, 'modBagianTubuh' => $modBagianTubuh, 'modPenunjang' => $modPenunjang, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
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
            
            $cri_del = new CDbCriteria();
            $cri_del->addCondition(" pengkajianaskep_id = ".$id." ");
            $del_penunjang = DatapenunjangT::model()->deleteAll($cri_del);
            
            $del_kajian = ASPengkajianaskepT::model()->deleteByPk($id);
            
            $data['sukses'] = 1;
            
            echo json_encode($data);
        }
        Yii::app()->end();
    }
}