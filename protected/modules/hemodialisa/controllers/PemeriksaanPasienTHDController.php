<?php
Yii::import('rawatJalan.controllers.PemeriksaanPasienController');
Yii::import('rawatJalan.models.*');
class PemeriksaanPasienTHDController extends PemeriksaanPasienController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';
	public $defaultAction = 'index';
	public $path_view = 'rawatJalan.views.pemeriksaanPasien.';
        public $path_view_periksa = 'rawatJalan.views._kepenunjang';
    public $path_view_HD = 'hemodialisa.views.pemeriksaanPasienTHD.';
	/**
	 * Lists all models.
	 */
	
}
