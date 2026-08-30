<?php
//Yii::import('rawatJalan.controllers.PemeriksaanPasienController');
//Yii::import('rawatJalan.models.*');
class TransfusiDarahHDController extends MyAuthController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';
	public $defaultAction = 'index';
//	public $path_view = 'rawatJalan.views.pemeriksaanPasien.'; 
//    public $path_view_HD = 'hemodialisa.views.pemeriksaanPasienTHD.';
	/**
	 * Lists all models.
	 */
	public function actionIndex($pendaftaran_id)
	{
            if (isset($_GET['frame'])){
                $this->layout = '//layouts/iframe';
            }
            
            $modPendaftaran = PendaftaranT::model()->with('jeniskasuspenyakit')->findByPk($pendaftaran_id);
            $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
            
            $this->render('index',array(
                'modPendaftaran'=>$modPendaftaran,
                'modPasien'=>$modPasien,
            ));
	}
}
