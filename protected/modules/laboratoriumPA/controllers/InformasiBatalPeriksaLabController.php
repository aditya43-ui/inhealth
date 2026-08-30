<?php
class InformasiBatalPeriksaLabController extends MyAuthController
{
	
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $path_view = 'laboratoriumPA.views.informasiBatalPeriksaLab.';
	
	
	public function actionInformasiBatalPeriksa()
	{
		$model=new LBPasienbatalperiksaR;
		$format = new MyFormatter;
		$model->tgl_awal = date('Y-m-d');
		$model->tgl_akhir = date('Y-m-d');
		$model->create_ruangan = Yii::app()->user->getState('ruangan_id');
		 if (isset($_GET['LBPasienbatalperiksaR'])) {                    
			$model->attributes = $_GET['LBPasienbatalperiksaR'];
			$model->tgl_awal = $format->formatDateTimeForDb($_GET['LBPasienbatalperiksaR']['tgl_awal']);
			$model->tgl_akhir = $format->formatDateTimeForDb($_GET['LBPasienbatalperiksaR']['tgl_akhir']);
			$model->no_pendaftaran = $_GET['LBPasienbatalperiksaR']['no_pendaftaran'];
			$model->no_rekam_medik = $_GET['LBPasienbatalperiksaR']['no_rekam_medik'];
			$model->nama_pasien = $_GET['LBPasienbatalperiksaR']['nama_pasien'];
			$model->no_masukpenunjang = $_GET['LBPasienbatalperiksaR']['no_masukpenunjang'];
		}
			$this->render($this->path_view.'index',array(
				'model'=>$model,'format'=>$format
			));
	}
}
?>
