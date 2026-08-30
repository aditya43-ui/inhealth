<?php

class InformasiRencanaAnggaranPengeluaranController extends MyAuthController
{
	public $layout='//layouts/column1';
	public $defaultAction = 'index';
	public $rencanaAnggPeng = false;
	public $rencanaAnggPengDet = true;
	public $approveUpdate = true;
	public $approveBaru = true;
	public $revisi = true;
	public $revisiUpdate = true;
	
	public function actionIndex()
	{
		$model = new AGRencanggaranpengT;
		$modDetail = new AGRencanggaranpengdetailT;
		
		if(isset($_GET['AGRencanggaranpengT'])){
			$model->attributes = $_GET['AGRencanggaranpengT'];
			$model->rencanggaranpeng_no  = isset($_REQUEST['AGRencanggaranpengT']['rencanggaranpeng_no'])?$_REQUEST['AGRencanggaranpengT']['rencanggaranpeng_no']:null;
			$model->konfiganggaran_id = isset($_REQUEST['konfiganggaran_id'])?$_REQUEST['konfiganggaran_id']:null;
			$model->unitkerja_id = isset($_REQUEST['AGRencanggaranpengT']['unitkerja_id'])?$_REQUEST['AGRencanggaranpengT']['unitkerja_id']:null;
		}
		$this->render('index',array(
									'model'=>$model,
									'modDetail'=>$modDetail,
							));
	}
	
	/**
	 * Ajax untuk menyetujui
	 */
	public function actionMenyetujui($rencanggaranpeng_id,$menyetujui_id =null)
	{
		$this->layout='//layouts/iframe';
		$detail = array();
        $modPrograms = array();
		$format = new MyFormatter();
		$model = AGRencanggaranpengT::model()->findByPk($rencanggaranpeng_id);  
		$modDetails = AGRencanggaranpengdetailT::model()->findAllByAttributes(array('rencanggaranpeng_id'=>$model->rencanggaranpeng_id));
		foreach ($modDetails as $i => $modDetail){
			$detail['tglrencanapengdet'][] = $modDetail->tglrencanapengdet;
			$detail['nilairencpengeluaran'][] = $modDetail->nilairencpengeluaran;
			$modSubKegiatans[$i] = AGRekeninganggaranV::model()->findAllByAttributes(array('subkegiatanprogram_id'=>$modDetail->subkegiatanprogram_id));
			foreach ($modSubKegiatans[$i] as $ii => $modSubKegiatan){
				$modPrograms['programkerja_kode'][] = $modSubKegiatan->programkerja_kode;
				$modPrograms['subprogramkerja_kode'][] = $modSubKegiatan->subprogramkerja_kode;
				$modPrograms['kegiatanprogram_kode'][] = $modSubKegiatan->kegiatanprogram_kode;
				$modPrograms['subkegiatanprogram_kode'][] = $modSubKegiatan->subkegiatanprogram_kode;
				$modPrograms['subkegiatanprogram_nama'][] = $modSubKegiatan->subkegiatanprogram_nama;
			}
		}
		if(!empty($menyetujui_id)){
			$update = AGRencanggaranpengT::model()->updateByPk($rencanggaranpeng_id,array('tglmenyetujui'=>date("Y-m-d")));
				if($update){
					Yii::app()->user->setFlash('success',"Data berhasil disimpan");
					$this->redirect(array('menyetujui','rencanggaranpeng_id'=>$rencanggaranpeng_id,'sukses'=>1));
				}else{
					Yii::app()->user->setFlash('error',"Data Gagal Disimpan");
				}
		}
		
        $judulLaporan = 'Rencana Anggaran Pengeluaran';
		$deskripsi = $model->konfiganggaran->deskripsiperiode;
        $this->render('_menyetujui', array(
				'format'=>$format,
				'model'=>$model,
				'judulLaporan'=>$judulLaporan,
				'deskripsi'=>$deskripsi,
				'modPrograms'=>$modPrograms,
				'detail'=>$detail,
		));
		
	}
	
    public function actionPrintMenyetujui($rencanggaranpeng_id)
    {
		$detail = array();
        $modPrograms = array();
		$format = new MyFormatter();
		$model = AGRencanggaranpengT::model()->findByPk($rencanggaranpeng_id);  
		$modDetails = AGRencanggaranpengdetailT::model()->findAllByAttributes(array('rencanggaranpeng_id'=>$model->rencanggaranpeng_id));
		foreach ($modDetails as $i => $modDetail){
			$detail['tglrencanapengdet'][] = $modDetail->tglrencanapengdet;
			$detail['nilairencpengeluaran'][] = $modDetail->nilairencpengeluaran;
			$modSubKegiatans[$i] = AGRekeninganggaranV::model()->findAllByAttributes(array('subkegiatanprogram_id'=>$modDetail->subkegiatanprogram_id));
			foreach ($modSubKegiatans[$i] as $ii => $modSubKegiatan){
				$modPrograms['programkerja_kode'][] = $modSubKegiatan->programkerja_kode;
				$modPrograms['subprogramkerja_kode'][] = $modSubKegiatan->subprogramkerja_kode;
				$modPrograms['kegiatanprogram_kode'][] = $modSubKegiatan->kegiatanprogram_kode;
				$modPrograms['subkegiatanprogram_kode'][] = $modSubKegiatan->subkegiatanprogram_kode;
				$modPrograms['subkegiatanprogram_nama'][] = $modSubKegiatan->subkegiatanprogram_nama;
			}
		}
        $judulLaporan = 'Rencana Anggaran Pengeluaran';
		$deskripsi = $model->konfiganggaran->deskripsiperiode;
        $caraPrint = (isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null);
		if($caraPrint=='PRINT') {
			$this->layout='//layouts/printWindows';
			$this->render('printMenyetujui',array('format'=>$format,'model'=>$model,'modPrograms'=>$modPrograms,'detail'=>$detail,'deskripsi'=>$deskripsi,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
		}
		else if($caraPrint=='EXCEL') {
			$this->layout='//layouts/printExcel';
			$this->render('printMenyetujui',array('format'=>$format,'model'=>$model,'modPrograms'=>$modPrograms,'detail'=>$detail,'deskripsi'=>$deskripsi,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
		}
		else if($_REQUEST['caraPrint']=='PDF') {
			$ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas'); //Ukuran Kertas Pdf
			$posisi = Yii::app()->user->getState('posisi_kertas'); //Posisi L->Landscape,P->Portait
			$mpdf = new MyPDF60('',$ukuranKertasPDF); 
			////$mpdf->useOddEven = 2;  
			$stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
			$mpdf->WriteHTML($stylesheet,1);  
			$mpdf->AddPage($posisi,'','','','',15,15,15,15,15,15);
			$mpdf->WriteHTML($this->renderPartial('printMenyetujui',array('format'=>$format,'model'=>$model,'modPrograms'=>$modPrograms,'detail'=>$detail,'deskripsi'=>$deskripsi,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint),true));
			$mpdf->Output();
		}
    }
	
	/**
	 * Ajax untuk mengetahui
	 */
	public function actionMengetahui($rencanggaranpeng_id,$mengetahui_id =null)
	{
		$this->layout='//layouts/iframe';
		$detail = array();
        $modPrograms = array();
		$format = new MyFormatter();
		$model = AGRencanggaranpengT::model()->findByPk($rencanggaranpeng_id);  
		$modDetails = AGRencanggaranpengdetailT::model()->findAllByAttributes(array('rencanggaranpeng_id'=>$model->rencanggaranpeng_id));
		foreach ($modDetails as $i => $modDetail){
			$detail['tglrencanapengdet'][] = $modDetail->tglrencanapengdet;
			$detail['nilairencpengeluaran'][] = $modDetail->nilairencpengeluaran;
			$modSubKegiatans[$i] = AGRekeninganggaranV::model()->findAllByAttributes(array('subkegiatanprogram_id'=>$modDetail->subkegiatanprogram_id));
			foreach ($modSubKegiatans[$i] as $ii => $modSubKegiatan){
				$modPrograms['programkerja_kode'][] = $modSubKegiatan->programkerja_kode;
				$modPrograms['subprogramkerja_kode'][] = $modSubKegiatan->subprogramkerja_kode;
				$modPrograms['kegiatanprogram_kode'][] = $modSubKegiatan->kegiatanprogram_kode;
				$modPrograms['subkegiatanprogram_kode'][] = $modSubKegiatan->subkegiatanprogram_kode;
				$modPrograms['subkegiatanprogram_nama'][] = $modSubKegiatan->subkegiatanprogram_nama;
			}
		}
		if(!empty($mengetahui_id)){
			$update = AGRencanggaranpengT::model()->updateByPk($rencanggaranpeng_id,array('tglmengetahui'=>date("Y-m-d")));
				if($update){
					Yii::app()->user->setFlash('success',"Data berhasil disimpan");
					$this->redirect(array('mengetahui','rencanggaranpeng_id'=>$rencanggaranpeng_id,'sukses'=>1));
				}else{
					Yii::app()->user->setFlash('error',"Data Gagal Disimpan");
				}
		}
		
        $judulLaporan = 'Rencana Anggaran Pengeluaran';
		$deskripsi = $model->konfiganggaran->deskripsiperiode;
        $this->render('_mengetahui', array(
				'format'=>$format,
				'model'=>$model,
				'judulLaporan'=>$judulLaporan,
				'deskripsi'=>$deskripsi,
				'modPrograms'=>$modPrograms,
				'detail'=>$detail,
		));
		
	}
	
    public function actionPrintMengetahui($rencanggaranpeng_id)
    {
		$detail = array();
        $modPrograms = array();
		$format = new MyFormatter();
		$model = AGRencanggaranpengT::model()->findByPk($rencanggaranpeng_id);  
		$modDetails = AGRencanggaranpengdetailT::model()->findAllByAttributes(array('rencanggaranpeng_id'=>$model->rencanggaranpeng_id));
		foreach ($modDetails as $i => $modDetail){
			$detail['tglrencanapengdet'][] = $modDetail->tglrencanapengdet;
			$detail['nilairencpengeluaran'][] = $modDetail->nilairencpengeluaran;
			$modSubKegiatans[$i] = AGRekeninganggaranV::model()->findAllByAttributes(array('subkegiatanprogram_id'=>$modDetail->subkegiatanprogram_id));
			foreach ($modSubKegiatans[$i] as $ii => $modSubKegiatan){
				$modPrograms['programkerja_kode'][] = $modSubKegiatan->programkerja_kode;
				$modPrograms['subprogramkerja_kode'][] = $modSubKegiatan->subprogramkerja_kode;
				$modPrograms['kegiatanprogram_kode'][] = $modSubKegiatan->kegiatanprogram_kode;
				$modPrograms['subkegiatanprogram_kode'][] = $modSubKegiatan->subkegiatanprogram_kode;
				$modPrograms['subkegiatanprogram_nama'][] = $modSubKegiatan->subkegiatanprogram_nama;
			}
		}
        $judulLaporan = 'Rencana Anggaran Pengeluaran';
		$deskripsi = $model->konfiganggaran->deskripsiperiode;
        $caraPrint = (isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null);
		if($caraPrint=='PRINT') {
			$this->layout='//layouts/printWindows';
			$this->render('printMengetahui',array('format'=>$format,'model'=>$model,'modPrograms'=>$modPrograms,'detail'=>$detail,'deskripsi'=>$deskripsi,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
		}
		else if($caraPrint=='EXCEL') {
			$this->layout='//layouts/printExcel';
			$this->render('printMengetahui',array('format'=>$format,'model'=>$model,'modPrograms'=>$modPrograms,'detail'=>$detail,'deskripsi'=>$deskripsi,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
		}
		else if($_REQUEST['caraPrint']=='PDF') {
			$ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas'); //Ukuran Kertas Pdf
			$posisi = Yii::app()->user->getState('posisi_kertas'); //Posisi L->Landscape,P->Portait
			$mpdf = new MyPDF60('',$ukuranKertasPDF); 
			////$mpdf->useOddEven = 2;  
			$stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
			$mpdf->WriteHTML($stylesheet,1);  
			$mpdf->AddPage($posisi,'','','','',15,15,15,15,15,15);
			$mpdf->WriteHTML($this->renderPartial('printMengetahui',array('format'=>$format,'model'=>$model,'modPrograms'=>$modPrograms,'detail'=>$detail,'deskripsi'=>$deskripsi,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint),true));
			$mpdf->Output();
		}
    }
	
	/**
	 * Ajax untuk rincian
	 */
	public function actionRincian($rencanggaranpeng_id)
	{
		$this->layout='//layouts/iframe';
		$detail = array();
        $modPrograms = array();
		$format = new MyFormatter();
		$model = AGRencanggaranpengT::model()->findByPk($rencanggaranpeng_id);  
		$modDetails = AGRencanggaranpengdetailT::model()->findAllByAttributes(array('rencanggaranpeng_id'=>$model->rencanggaranpeng_id));
		foreach ($modDetails as $i => $modDetail){
			$detail['tglrencanapengdet'][] = $modDetail->tglrencanapengdet;
			$detail['nilairencpengeluaran'][] = $modDetail->nilairencpengeluaran;
			$modSubKegiatans[$i] = AGRekeninganggaranV::model()->findAllByAttributes(array('subkegiatanprogram_id'=>$modDetail->subkegiatanprogram_id));
			foreach ($modSubKegiatans[$i] as $ii => $modSubKegiatan){
				$modPrograms['programkerja_kode'][] = $modSubKegiatan->programkerja_kode;
				$modPrograms['subprogramkerja_kode'][] = $modSubKegiatan->subprogramkerja_kode;
				$modPrograms['kegiatanprogram_kode'][] = $modSubKegiatan->kegiatanprogram_kode;
				$modPrograms['subkegiatanprogram_kode'][] = $modSubKegiatan->subkegiatanprogram_kode;
				$modPrograms['subkegiatanprogram_nama'][] = $modSubKegiatan->subkegiatanprogram_nama;
			}
		}
		
        $judulLaporan = 'Rencana Anggaran Pengeluaran';
		$deskripsi = $model->konfiganggaran->deskripsiperiode;
        $this->render('_rincian', array(
				'format'=>$format,
				'model'=>$model,
				'judulLaporan'=>$judulLaporan,
				'deskripsi'=>$deskripsi,
				'modPrograms'=>$modPrograms,
				'detail'=>$detail,
		));
		
	}
	
    public function actionPrintRincian($rencanggaranpeng_id)
    {
		$detail = array();
        $modPrograms = array();
		$format = new MyFormatter();
		$model = AGRencanggaranpengT::model()->findByPk($rencanggaranpeng_id);  
		$modDetails = AGRencanggaranpengdetailT::model()->findAllByAttributes(array('rencanggaranpeng_id'=>$model->rencanggaranpeng_id));
		foreach ($modDetails as $i => $modDetail){
			$detail['tglrencanapengdet'][] = $modDetail->tglrencanapengdet;
			$detail['nilairencpengeluaran'][] = $modDetail->nilairencpengeluaran;
			$modSubKegiatans[$i] = AGRekeninganggaranV::model()->findAllByAttributes(array('subkegiatanprogram_id'=>$modDetail->subkegiatanprogram_id));
			foreach ($modSubKegiatans[$i] as $ii => $modSubKegiatan){
				$modPrograms['programkerja_kode'][] = $modSubKegiatan->programkerja_kode;
				$modPrograms['subprogramkerja_kode'][] = $modSubKegiatan->subprogramkerja_kode;
				$modPrograms['kegiatanprogram_kode'][] = $modSubKegiatan->kegiatanprogram_kode;
				$modPrograms['subkegiatanprogram_kode'][] = $modSubKegiatan->subkegiatanprogram_kode;
				$modPrograms['subkegiatanprogram_nama'][] = $modSubKegiatan->subkegiatanprogram_nama;
			}
		}
        $judulLaporan = 'Rencana Anggaran Pengeluaran';
		$deskripsi = $model->konfiganggaran->deskripsiperiode;
        $caraPrint = (isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null);
		if($caraPrint=='PRINT') {
			$this->layout='//layouts/printWindows';
			$this->render('printRincian',array('format'=>$format,'model'=>$model,'modPrograms'=>$modPrograms,'detail'=>$detail,'deskripsi'=>$deskripsi,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
		}
		else if($caraPrint=='EXCEL') {
			$this->layout='//layouts/printExcel';
			$this->render('printRincian',array('format'=>$format,'model'=>$model,'modPrograms'=>$modPrograms,'detail'=>$detail,'deskripsi'=>$deskripsi,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
		}
		else if($_REQUEST['caraPrint']=='PDF') {
			$ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas'); //Ukuran Kertas Pdf
			$posisi = Yii::app()->user->getState('posisi_kertas'); //Posisi L->Landscape,P->Portait
			$mpdf = new MyPDF60('',$ukuranKertasPDF); 
			////$mpdf->useOddEven = 2;  
			$stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
			$mpdf->WriteHTML($stylesheet,1);  
			$mpdf->AddPage($posisi,'','','','',15,15,15,15,15,15);
			$mpdf->WriteHTML($this->renderPartial('printRincian',array('format'=>$format,'model'=>$model,'modPrograms'=>$modPrograms,'detail'=>$detail,'deskripsi'=>$deskripsi,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint),true));
			$mpdf->Output();
		}
    }
	
	
	public function actionUbahAnggaran($rencanggaranpeng_id){
		$format = new MyFormatter();
		$modDetail = array();
		$detailAnggaran = array(); 
		$model = AGRencanggaranpengT::model()->findByPk($rencanggaranpeng_id);
		$model->namaunitkerja = AGUnitkerjaM::model()->findByPk($model->unitkerja_id)->namaunitkerja;
		$model->deskripsiperiode = AGKonfiganggaranK::model()->findByPk($model->konfiganggaran_id)->deskripsiperiode;
		$model->rencanggaranpeng_tgl = $format->formatDateTimeForUser($model->rencanggaranpeng_tgl);
		$digit = AGKonfiganggaranK::model()->findByPk($model->konfiganggaran_id)->digitnilaianggaran;
		$digit_str = "1".$digit;
		$model->digitnilai = "/ ".$digit;
		$model->pegawaimengetahui_nama = isset($model->mengetahui_id) ? AGPegawaiV::model()->findByAttributes(array('pegawai_id'=>$model->mengetahui_id))->nama_pegawai : "";
		$model->pegawaimenyetujui_nama = isset($model->menyetujui_id) ? AGPegawaiV::model()->findByAttributes(array('pegawai_id'=>$model->menyetujui_id))->nama_pegawai : "";
		$model->total_nilairencpeng = $format->formatNumberForPrint($model->total_nilairencpeng/ (int)$digit_str);
		$model->tglrencana = date("Y-m-d");
		$modDetails = AGRencanggaranpengdetailT::model()->findAllByAttributes(array('rencanggaranpeng_id'=>$rencanggaranpeng_id));
			foreach ($modDetails as $i => $detail){
				$modDetail[$i] = AGRekeninganggaranV::model()->findByAttributes(array('subkegiatanprogram_id'=>$detail->subkegiatanprogram_id));
				$modDetail[$i]->tglrencanapengdet = $detail->tglrencanapengdet;
				$modDetail[$i]->nilairencpengeluaran = $format->formatNumberForPrint($detail->nilairencpengeluaran / (int)$digit_str);
				$modDetail[$i]->no_urut = $i+1;
				$modDetail[$i]->rencanggaranpengdet_id = $detail->rencanggaranpengdet_id;
			}          
		if (isset($_POST['AGRekeninganggaranV'])){
			$transaction = Yii::app()->db->beginTransaction();
            try {
				$model->attributes = $_POST['AGRencanggaranpengT'];
				$model->menyetujui_id = isset($_POST['AGRencanggaranpengT']['menyetujui_id']) ? $_POST['AGRencanggaranpengT']['menyetujui_id'] : "";
				$model->mengetahui_id = isset($_POST['AGRencanggaranpengT']['mengetahui_id']) ? $_POST['AGRencanggaranpengT']['mengetahui_id'] : "";
				$model->rencanggaranpeng_tgl = $format->formatDateTimeForDb($model->rencanggaranpeng_tgl);
				$model->total_nilairencpeng = $model->total_nilairencpeng.$digit;
					if ($model->save()){
						$this->rencanaAnggPeng = true;
						if(count((array)$_POST['AGRekeninganggaranV']) > 0){
							foreach($_POST['AGRekeninganggaranV'] AS $i => $postRencanaDet){
								if (empty($_POST['AGRekeninganggaranV'][$i]['rencanggaranpengdet_id'])){
									$modRencanaDetail = new AGRencanggaranpengdetailT;
									$modRencanaDetail->attributes = $_POST['AGRekeninganggaranV'];
									$modRencanaDetail->subkegiatanprogram_id =$_POST['AGRekeninganggaranV'][$i]['subkegiatanprogram_id'];
									$modRencanaDetail->rencanggaranpeng_id =$model->rencanggaranpeng_id;
									$modRencanaDetail->tglrencanapengdet =$_POST['AGRekeninganggaranV'][$i]['tglrencanapengdet'];
									$modRencanaDetail->nilairencpengeluaran =$_POST['AGRekeninganggaranV'][$i]['nilairencpengeluaran'].$digit;
									$modRencanaDetail->save();
									$this->rencanaAnggPengDet &= true;
								}else{
									$nilai = $_POST['AGRekeninganggaranV'][$i]['nilairencpengeluaran'].$digit;
									$updateDetail = AGRencanggaranpengdetailT::model()->updateByPk($_POST['AGRekeninganggaranV'][$i]['rencanggaranpengdet_id'], array('nilairencpengeluaran'=>$nilai));
									$this->rencanaAnggPengDet &= true;
								}
							}
						}
					}
						if($this->rencanaAnggPeng && $this->rencanaAnggPengDet){
							$transaction->commit();
							$this->redirect(array('index','rencanggaranpeng_id'=>$model->rencanggaranpeng_id,'frame'=>1,'sukses'=>1));
						}else{
							$transaction->rollback();
							Yii::app()->user->setFlash('error',"Update Data Rencana Anggaran Pengeluaran gagal disimpan !");
						}
			} catch (Exception $ex) {
				$transaction->rollback();
                Yii::app()->user->setFlash('error',"Data Rencana Anggaran Pengeluaran gagal disimpan ! ".MyExceptionMessage::getMessage($e,true));
			}
		}
		$this->render('_ubahAnggaran',array(
			'format'=>$format,
			'model'=>$model,
			'modDetail'=>$modDetail,
		));
	}
	
	public function actionApproval($rencanggaranpeng_id){
		$format = new MyFormatter();
		$modDetail = array();
		$model = AGRencanggaranpengT::model()->findByPk($rencanggaranpeng_id);
		$model->namaunitkerja = AGUnitkerjaM::model()->findByPk($model->unitkerja_id)->namaunitkerja;
		$model->rencanggaranpeng_tgl = $format->formatDateTimeForUser($model->rencanggaranpeng_tgl);
		$model->deskripsiperiode = AGKonfiganggaranK::model()->findByPk($model->konfiganggaran_id)->deskripsiperiode;
		$model->pegawaimengetahui_nama = isset($model->mengetahui_id) ? AGPegawaiV::model()->findByAttributes(array('pegawai_id'=>$model->mengetahui_id))->nama_pegawai : "";
		$model->pegawaimenyetujui_nama = isset($model->menyetujui_id) ? AGPegawaiV::model()->findByAttributes(array('pegawai_id'=>$model->menyetujui_id))->nama_pegawai : "";
		$digit = AGKonfiganggaranK::model()->findByPk($model->konfiganggaran_id)->digitnilaianggaran;
		$digit_str = "1".$digit;
		$model->digitnilai = "/ ".$digit;
		$model->total_nilairencpeng = $format->formatNumberForPrint($model->total_nilairencpeng/ (int)$digit_str);
		
		$modDetails = AGRencanggaranpengdetailT::model()->findAllByAttributes(array('rencanggaranpeng_id'=>$rencanggaranpeng_id));
			foreach ($modDetails as $i => $detail){
				$modDetail[$i] = AGRekeninganggaranV::model()->findByAttributes(array('subkegiatanprogram_id'=>$detail->subkegiatanprogram_id));
				$modDetail[$i]->tglrencanapengdet = $detail->tglrencanapengdet;
				$modDetail[$i]->nilairencpengeluaran = $format->formatNumberForPrint($detail->nilairencpengeluaran / (int)$digit_str);
				$modDetail[$i]->no_urut = $i+1;
				$modDetail[$i]->rencanggaranpengdet_id = $detail->rencanggaranpengdet_id;
			} 
		if (isset($_POST['AGRekeninganggaranV'])){
			$transaction = Yii::app()->db->beginTransaction();
			try {
				if(count((array)$_POST['AGRekeninganggaranV']) > 0){
					foreach($_POST['AGRekeninganggaranV'] AS $i => $postRencanaDet){
						if($_POST['AGRekeninganggaranV'][$i]['approve']){
							$modApprove =  new AGApprrencanggaranT;
							$modApprove->attributes = $_POST['AGRekeninganggaranV'];
							$modApprove->subkegiatanprogram_id = $_POST['AGRekeninganggaranV'][$i]['subkegiatanprogram_id'];
							$modApprove->konfiganggaran_id = $_POST['AGRencanggaranpengT']['konfiganggaran_id'];
							$modApprove->rencanggaranpengdet_id = $_POST['AGRekeninganggaranV'][$i]['rencanggaranpengdet_id'];
							$modApprove->unitkerja_id = $_POST['AGRencanggaranpengT']['unitkerja_id'];
							$modApprove->tglapprrencanggaran = date("Y-m-d");
							$modApprove->menyetujui_id = $_POST['AGRencanggaranpengT']['mengetahui_id'];
							$modApprove->mengetahui_id = $_POST['AGRencanggaranpengT']['menyetujui_id'];
							$modApprove->tglrencanggpeng = $format->formatDateTimeForDb($_POST['AGRencanggaranpengT']['rencanggaranpeng_tgl']);
							$modApprove->nilaiygdisetujui = $_POST['AGRekeninganggaranV'][$i]['nilairencpengeluaran']; //.$digit;
							$modApprove->create_time = date("Y-m-d H:i:s");
							$modApprove->create_loginpemakai_id = Yii::app()->user->id;
							$modApprove->create_ruangan = Yii::app()->user->ruangan_id;
                                                        
                                                        //var_dump($modApprove->attributes, $modApprove->validate(), $modApprove->errors); die;
                                                        
							$this->approveBaru &= true;
								if ($modApprove->save()){
									$updateDetail = AGRencanggaranpengdetailT::model()->updateByPk($_POST['AGRekeninganggaranV'][$i]['rencanggaranpengdet_id'], array('apprrencanggaran_id'=>$modApprove->apprrencanggaran_id));
									$this->approveUpdate &= true;
								}
						}
					}
				}
                                                //var_dump($this->approveBaru); die;
						if($this->approveBaru){
							$transaction->commit();
							$this->redirect(array('index','rencanggaranpeng_id'=>$model->rencanggaranpeng_id,'frame'=>1,'sukses'=>1));
						}else{
							$transaction->rollback();
							Yii::app()->user->setFlash('error',"Update Data Approve gagal disimpan !");
						}
			} catch (Exception $ex) {
                                echo "Kick"; die;
				$transaction->rollback();
                                Yii::app()->user->setFlash('error',"Data Approve gagal disimpan ! ".MyExceptionMessage::getMessage($e,true));
			}
		}
		
		$this->render('_approval',array(
			'format'=>$format,
			'model'=>$model,
			'modDetail'=>$modDetail,
		));
	}
	
	public function actionUbahApproval($rencanggaranpeng_id){
		$format = new MyFormatter();
		$modDetail = array();
		$model = AGRencanggaranpengT::model()->findByPk($rencanggaranpeng_id);
		$model->namaunitkerja = AGUnitkerjaM::model()->findByPk($model->unitkerja_id)->namaunitkerja;
		$model->rencanggaranpeng_tgl = $format->formatDateTimeForUser($model->rencanggaranpeng_tgl);
		$model->deskripsiperiode = AGKonfiganggaranK::model()->findByPk($model->konfiganggaran_id)->deskripsiperiode;
		$model->pegawaimengetahui_nama = isset($model->mengetahui_id) ? AGPegawaiV::model()->findByAttributes(array('pegawai_id'=>$model->mengetahui_id))->nama_pegawai : "";
		$model->pegawaimenyetujui_nama = isset($model->menyetujui_id) ? AGPegawaiV::model()->findByAttributes(array('pegawai_id'=>$model->menyetujui_id))->nama_pegawai : "";
		$digit = AGKonfiganggaranK::model()->findByPk($model->konfiganggaran_id)->digitnilaianggaran;
		$digit_str = "1".$digit;
		$model->digitnilai = "/ ".$digit;
		$model->total_nilairencpeng = $format->formatNumberForPrint($model->total_nilairencpeng/ (int)$digit_str);
		
		$modDetails = AGRencanggaranpengdetailT::model()->findAllByAttributes(array('rencanggaranpeng_id'=>$rencanggaranpeng_id));
			foreach ($modDetails as $i => $detail){
				$modDetail[$i] = AGRekeninganggaranV::model()->findByAttributes(array('subkegiatanprogram_id'=>$detail->subkegiatanprogram_id));
				$modDetail[$i]->tglrencanapengdet = $detail->tglrencanapengdet;
				$modDetail[$i]->nilairencpengeluaran = $format->formatNumberForPrint($detail->nilairencpengeluaran / (int)$digit_str);
				$modDetail[$i]->no_urut = $i+1;
				$modDetail[$i]->rencanggaranpengdet_id = $detail->rencanggaranpengdet_id;
				$modDetail[$i]->approve = (isset($detail->apprrencanggaran_id)? true : false);
				$modDetail[$i]->apprrencanggaran_id = (isset($detail->apprrencanggaran_id)? $detail->apprrencanggaran_id : null);
			} 
			
		if (isset($_POST['AGRekeninganggaranV'])){
			$transaction = Yii::app()->db->beginTransaction();
			try {
				if(count((array)$_POST['AGRekeninganggaranV']) > 0){
					foreach($_POST['AGRekeninganggaranV'] AS $i => $postRencanaDet){
						if($_POST['AGRekeninganggaranV'][$i]['approve'] && empty($_POST['AGRekeninganggaranV'][$i]['apprrencanggaran_id'])){
							$modApprove =  new AGApprrencanggaranT;
							$modApprove->attributes = $_POST['AGRekeninganggaranV'];
							$modApprove->subkegiatanprogram_id = $_POST['AGRekeninganggaranV'][$i]['subkegiatanprogram_id'];
							$modApprove->konfiganggaran_id = $_POST['AGRencanggaranpengT']['konfiganggaran_id'];
							$modApprove->rencanggaranpengdet_id = $_POST['AGRekeninganggaranV'][$i]['rencanggaranpengdet_id'];
							$modApprove->unitkerja_id = $_POST['AGRencanggaranpengT']['unitkerja_id'];
							$modApprove->tglapprrencanggaran = date("Y-m-d");
							$modApprove->menyetujui_id = $_POST['AGRencanggaranpengT']['mengetahui_id'];
							$modApprove->mengetahui_id = $_POST['AGRencanggaranpengT']['menyetujui_id'];
							$modApprove->tglrencanggpeng = $format->formatDateTimeForDb($_POST['AGRencanggaranpengT']['rencanggaranpeng_tgl']);
							$modApprove->nilaiygdisetujui = $_POST['AGRekeninganggaranV'][$i]['nilairencpengeluaran'].$digit;
							$modApprove->create_time = date("Y-m-d H:i:s");
							$modApprove->create_loginpemakai_id = Yii::app()->user->id;
							$modApprove->create_ruangan = Yii::app()->user->ruangan_id;
							$this->approveBaru &= true;
								if ($modApprove->save()){
									$updateDetail = AGRencanggaranpengdetailT::model()->updateByPk($_POST['AGRekeninganggaranV'][$i]['rencanggaranpengdet_id'], array('apprrencanggaran_id'=>$modApprove->apprrencanggaran_id));
									$this->approveUpdate &= true;
								}
						}else if (($_POST['AGRekeninganggaranV'][$i]['approve'])){
							$updateTglApprove = AGApprrencanggaranT::model()->findByAttributes(array('rencanggaranpengdet_id'=>$_POST['AGRekeninganggaranV'][$i]['rencanggaranpengdet_id']));
							$updateTglApprove->tglapprrencanggaran = date("Y-m-d");
							$updateTglApprove->update();
							$this->approveUpdate &= true;
						}
					}
				}
						if($this->approveBaru && $this->approveUpdate){
							$transaction->commit();
							$this->redirect(array('index','rencanggaranpeng_id'=>$model->rencanggaranpeng_id,'frame'=>1,'sukses'=>1));
						}else{
							$transaction->rollback();
							Yii::app()->user->setFlash('error',"Update Data Approve gagal disimpan !");
						}
			} catch (Exception $ex) {
				$transaction->rollback();
                Yii::app()->user->setFlash('error',"Update Data Approve gagal disimpan ! ".MyExceptionMessage::getMessage($e,true));
			}
		}
		
		$this->render('_ubahApproval',array(
			'format'=>$format,
			'model'=>$model,
			'modDetail'=>$modDetail,
		));
	}
	
	public function actionRevisi($rencanggaranpeng_id){
		$format = new MyFormatter();
		$modDetail = array();
		$total = 0;
		$date = date("d");
		$modRevisi = new AGRevisirencanggpengT;
		$model = AGRencanggaranpengT::model()->findByPk($rencanggaranpeng_id);
		$model->namaunitkerja = AGUnitkerjaM::model()->findByPk($model->unitkerja_id)->namaunitkerja;
		$model->rencanggaranpeng_tgl = $format->formatDateTimeForUser($model->rencanggaranpeng_tgl);
		$model->deskripsiperiode = AGKonfiganggaranK::model()->findByPk($model->konfiganggaran_id)->deskripsiperiode;
		$model->pegawaimengetahui_nama = isset($model->mengetahui_id) ? AGPegawaiV::model()->findByAttributes(array('pegawai_id'=>$model->mengetahui_id))->nama_pegawai : "";
		$model->pegawaimenyetujui_nama = isset($model->menyetujui_id) ? AGPegawaiV::model()->findByAttributes(array('pegawai_id'=>$model->menyetujui_id))->nama_pegawai : "";
		$digit = AGKonfiganggaranK::model()->findByPk($model->konfiganggaran_id)->digitnilaianggaran;
		$digit_str = "1".$digit;
		$model->digitnilai = "/ ".$digit;
		$model->total_nilairencpeng = $format->formatNumberForPrint($model->total_nilairencpeng/ (int)$digit_str);
		
		// load tgl approval
		$criteria = new CDbCriteria();
		if(!empty($this->rencanggaranpeng_id)){
			$criteria->addCondition('rencanggaranpeng_id = '.$rencanggaranpeng_id);
		}
		$criteria->addCondition("apprrencanggaran_id IS NOT NULL");
        $modDet = AGRencanggaranpengdetailT::model()->find($criteria);
		$modApprove = AGApprrencanggaranT::model()->findByAttributes(array('rencanggaranpengdet_id'=>$modDet->rencanggaranpengdet_id));
		$model->tglapprrencanggaran = $format->formatDateTimeForUser($modApprove->tglapprrencanggaran);
		
		// load detail
		$criteriaDetail = new CDbCriteria();
		$criteriaDetail->addCondition('rencanggaranpeng_id = '.$rencanggaranpeng_id);
		$criteriaDetail->addCondition("apprrencanggaran_id IS NOT NULL");
        $modDetails = AGRencanggaranpengdetailT::model()->findAll($criteriaDetail);
			foreach ($modDetails as $i => $detail){
				$modDetail[$i] = AGApprrencanggaranT::model()->findByAttributes(array('rencanggaranpengdet_id'=>$detail->rencanggaranpengdet_id));
				$modDetail[$i]->no_urut = $i+1;
				$modDetail[$i]->programkerja_kode = AGRekeninganggaranV::model()->findByAttributes(array('subkegiatanprogram_id'=>$modDetail[$i]->subkegiatanprogram_id))->programkerja_kode;
				$modDetail[$i]->subprogramkerja_kode = AGRekeninganggaranV::model()->findByAttributes(array('subkegiatanprogram_id'=>$modDetail[$i]->subkegiatanprogram_id))->subprogramkerja_kode;
				$modDetail[$i]->kegiatanprogram_kode = AGRekeninganggaranV::model()->findByAttributes(array('subkegiatanprogram_id'=>$modDetail[$i]->subkegiatanprogram_id))->kegiatanprogram_kode;
				$modDetail[$i]->subkegiatanprogram_kode = AGRekeninganggaranV::model()->findByAttributes(array('subkegiatanprogram_id'=>$modDetail[$i]->subkegiatanprogram_id))->subkegiatanprogram_kode;
				$modDetail[$i]->subkegiatanprogram_nama = AGRekeninganggaranV::model()->findByAttributes(array('subkegiatanprogram_id'=>$modDetail[$i]->subkegiatanprogram_id))->subkegiatanprogram_nama;
				$modDetail[$i]->bulanrencana =$modDetail[$i]->tglrencanggpeng;
				$total += $modDetail[$i]->nilaiygdisetujui;
				$modDetail[$i]->nilaiygdisetujui = $format->formatNumberForPrint($detail->nilairencpengeluaran / (int)$digit_str);
				$modDetail[$i]->nilaiapprove = $detail->nilairencpengeluaran / (int)$digit_str;
				$model->total_nilairencpeng = $format->formatNumberForPrint($total / (int)$digit_str);
			} 
			
		if (isset($_POST['AGApprrencanggaranT'])){
			$transaction = Yii::app()->db->beginTransaction();
			try {
				if(count((array)$_POST['AGApprrencanggaranT']) > 0){
					foreach($_POST['AGApprrencanggaranT'] AS $i => $approveDet){
						$modRevisi = new AGRevisirencanggpengT;
						$modRevisi->attributes = $_POST['AGApprrencanggaranT'];
						$modRevisi->subkegiatanprogram_id = $_POST['AGApprrencanggaranT'][$i]['subkegiatanprogram_id'];
						$modRevisi->tglrevisianggpeng = date("Y-m-d");
						$modRevisi->ygmerevisi_id = $_POST['AGRencanggaranpengT']['ygmerevisi_id'];
						$modRevisi->nilaisblrevisi = $_POST['AGApprrencanggaranT'][$i]['nilaiapprove'].$digit;
						$modRevisi->nilairevisi = $_POST['AGApprrencanggaranT'][$i]['nilaiygdisetujui'].$digit;
						$modRevisi->create_time = date("Y-m-d");
						$modRevisi->create_loginpemakai_id = Yii::app()->user->id;
						$modRevisi->create_ruangan = Yii::app()->user->ruangan_id;
                                                
                                                $this->revisi &= true;
								if ($modRevisi->save()){
									$tglrencanadetail = $format->formatMonthForDb($_POST['AGApprrencanggaranT'][$i]['bulanrencana']);
									$tglrencana = $tglrencanadetail."-".$date;
									$updateApprove = AGApprrencanggaranT::model()->updateByPk($_POST['AGApprrencanggaranT'][$i]['apprrencanggaran_id'], array('revisirencanggpeng_id'=>$modRevisi->revisirencanggpeng_id,'tglrencanggpeng'=>$tglrencana));
									$this->revisiUpdate &= true;
								}
					}
				}
						if($this->revisi && $this->revisiUpdate){
							$transaction->commit();
							$this->redirect(array('index','rencanggaranpeng_id'=>$model->rencanggaranpeng_id,'frame'=>1,'sukses'=>1));
						}else{
							$transaction->rollback();
							Yii::app()->user->setFlash('error',"Revisi Data Approve gagal disimpan !");
						}
			} catch (Exception $ex) {
				$transaction->rollback();
                Yii::app()->user->setFlash('error',"Revisi Data Approve gagal disimpan ! ".MyExceptionMessage::getMessage($e,true));
			}
		}
		$this->render('_revisi',array(
			'format'=>$format,
			'model'=>$model,
			'modApprove'=>$modApprove,
			'modDetail'=>$modDetail,
			'modRevisi'=>$modRevisi,
		));
	}
	
    public function actionAutocompletePegawaiMengetahui()
    {
        if(Yii::app()->request->isAjaxRequest) {
			$returnVal = array();
            $criteria = new CDbCriteria();
            $criteria->compare('LOWER(nama_pegawai)', strtolower($_GET['term']), true);
            $criteria->order = 'nama_pegawai';
            $criteria->limit = 5;
            $models = AGPegawaiV::model()->findAll($criteria);
            foreach($models as $i=>$model)
            {
                $attributes = $model->attributeNames();
                foreach($attributes as $j=>$attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = $model->gelardepan." ".$model->nama_pegawai." ".$model->gelarbelakang_nama;
                $returnVal[$i]['value'] = $model->pegawai_id;
            }

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }
	
    public function actionAutocompletePegawaiMerevisi()
    {
        if(Yii::app()->request->isAjaxRequest) {
			$returnVal = array();
            $criteria = new CDbCriteria();
            $criteria->compare('LOWER(nama_pegawai)', strtolower($_GET['term']), true);
            $criteria->order = 'nama_pegawai';
            $criteria->limit = 5;
            $models = AGPegawaiV::model()->findAll($criteria);
            foreach($models as $i=>$model)
            {
                $attributes = $model->attributeNames();
                foreach($attributes as $j=>$attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = $model->gelardepan." ".$model->nama_pegawai." ".$model->gelarbelakang_nama;
                $returnVal[$i]['value'] = $model->pegawai_id;
            }

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }
    public function actionAutocompletePegawaiMenyetujui()
    {
        if(Yii::app()->request->isAjaxRequest) {
            $criteria = new CDbCriteria();
			$criteria->group = 'nomorindukpegawai,nama_pegawai,gelardepan,gelarbelakang_nama,alamat_pegawai,pegawai_id';
			$criteria->select = $criteria->group;
            $criteria->compare('LOWER(nama_pegawai)', strtolower($_GET['term']), true);
            $criteria->order = 'nama_pegawai';
            $criteria->limit = 5;
            $models = AGPegawairuanganV::model()->findAll($criteria);
            foreach($models as $i=>$model)
            {
                $attributes = $model->attributeNames();
                foreach($attributes as $j=>$attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = $model->gelardepan." ".$model->nama_pegawai." ".$model->gelarbelakang_nama;
                $returnVal[$i]['value'] = $model->pegawai_id;
            }

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }
	
    public function actionAutocompleteProgramKerja()
    {
        if(Yii::app()->request->isAjaxRequest) {
            $criteria = new CDbCriteria();
            $criteria->compare('LOWER(subkegiatanprogram_nama)', strtolower($_GET['term']), true);
            $criteria->order = 'subkegiatanprogram_nama';
            $criteria->limit = 5;
            $models = AGRekeninganggaranV::model()->findAll($criteria);
            foreach($models as $i=>$model)
            {
                $attributes = $model->attributeNames();
                foreach($attributes as $j=>$attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = $model->subkegiatanprogram_nama;
                $returnVal[$i]['value'] = $model->subkegiatanprogram_id;
            }

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }
    	
    /**
    * menampilkan rencana anggaran pengeluaran detail
    * @return row table 
    */
    public function actionLoadFormTambahRencana()
    {
        if(Yii::app()->request->isAjaxRequest) {
			$i = "i";
			$date = date("d");
            $subkegiatanprogram_id = $_POST['subkegiatanprogram_id'];
            $nilairencpengeluaran = $_POST['nilairencpengeluaran'];
            $tglrencana = $_POST['tglrencana'];
            $format = new MyFormatter();
            $modRencanaDetail = AGRekeninganggaranV::model()->findByAttributes(array('subkegiatanprogram_id'=>$subkegiatanprogram_id));
            $modRencanaDetail->nilairencpengeluaran = $nilairencpengeluaran;
			$modRencanaDetail->subkegiatanprogram_id = $modRencanaDetail->subkegiatanprogram_id;
            $modRencanaDetail->tglrencanapengdet = $format->formatMonthForDb($tglrencana);
            $modRencanaDetail->tglrencanapengdet = $modRencanaDetail->tglrencanapengdet."-".$date;
            echo CJSON::encode(array(
                'status'=>'create_form', 
                'form'=>$this->renderPartial('_rowRencanaAnggaranPengeluaran', array(
                        'format'=>$format,
                        'modRencanaDetail'=>$modRencanaDetail,
						'i'=>$i,
                    ), 
                true))
            );
            exit;  
        }
    }  
	
    /**
    * menghapus rencana anggaran pengeluaran detail
    */
    public function actionBatalRencana()
    {
        if(Yii::app()->request->isAjaxRequest) {
            $rencanggaranpengdet_id = $_POST['rencanggaranpengdet_id'];
			$deletePemakaian = AGRencanggaranpengdetailT::model()->deleteByPk($rencanggaranpengdet_id);
        }
    }  
	
    /**
    * menghapus rencana anggaran pengeluaran detail
    */
    public function actionBatalApprove()
    {
        if(Yii::app()->request->isAjaxRequest) {
            $rencanggaranpengdet_id = $_POST['rencanggaranpengdet_id'];
            $apprrencanggaran_id = $_POST['apprrencanggaran_id'];
			$updateRencDetail = AGRencanggaranpengdetailT::model()->updateByPk($rencanggaranpengdet_id,array('apprrencanggaran_id'=>null));
			$deleteApprove = AGApprrencanggaranT::model()->deleteByPk($apprrencanggaran_id);
			$data['pesan'] = "sukses";
            echo CJSON::encode($data);
        }
        Yii::app()->end();
    }
	
    /**
    * menghapus rencana anggaran pengeluaran detail
    */
    public function actionBatalRevisi()
    {
        if(Yii::app()->request->isAjaxRequest) {
            $rencanggaranpengdet_id = $_POST['rencanggaranpengdet_id'];
            $apprrencanggaran_id = $_POST['apprrencanggaran_id'];
			
			$revisi_id = AGApprrencanggaranT::model()->findByPk($apprrencanggaran_id)->revisirencanggpeng_id;
			$updateRencDetail = AGRencanggaranpengdetailT::model()->updateByPk($rencanggaranpengdet_id,array('apprrencanggaran_id'=>null));
			$deleteApprove = AGApprrencanggaranT::model()->deleteByPk($apprrencanggaran_id);
			$deleteRevisi = AGRevisirencanggpengT::model()->deleteByPk($revisi_id);
			$data['pesan'] = "sukses";
            echo CJSON::encode($data);
        }
        Yii::app()->end();
    } 
	
    /**
    * membatalkan approve
	* update rencanggaranpengdet_id di tabel rencanggaranpengdetail_t menjadi null
	* hapus apprrencanggaran_id di tabel apprrencanggaran_t
	* @param rencanggaranpengdet_id dan apprrencanggaran_id
    */
	public function actionHapusRencanaDetail(){
        if(Yii::app()->request->isAjaxRequest) {
            $data['pesan'] = "";
            $data['sukses'] = 0;
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $updateRencanaDetail = RencanggaranpengdetailT::model()->findByPk($_POST['rencanggaranpengdet_id']);
                $updateRencanaDetail->apprrencanggaran_id = null;
                $updateRencanaDetail->update();
                $hapusApprrove = ApprrencanggaranT::model()->deleteByPk($_POST['apprrencanggaran_id']);
				if($hapusApprrove){
                    $transaction->commit();
                    $data['pesan'] = "Rencana Anggaran berhasil dihapus!";
                    $data['sukses'] = 1;
                }    
            }catch (Exception $exc) {
                $transaction->rollback();
                $data['pesan'] = "Rencana Anggaran gagal dihapus! :".MyExceptionMessage::getMessage($exc,true);
            }
            echo CJSON::encode($data);
        }
        Yii::app()->end();
    }   
}