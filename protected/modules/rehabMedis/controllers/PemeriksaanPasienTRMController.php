<?php
Yii::import('rawatJalan.controllers.PemeriksaanPasienController');
Yii::import('rawatJalan.models.*');
/**
 * digunakan untuk menyimpan fung - fungsi javascript unyuk tabulasi menu asesmen awal kebidanan
 * @package application.modules.rehabMedis
 * @subpackage controllers
 * @author M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     2.0.0
 * @link    <http://piindonesia.co.id>
 */
class PemeriksaanPasienTRMController extends PemeriksaanPasienController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout = '//layouts/column1';
	public $defaultAction = 'index';
	public $path_view = 'rawatJalan.views.pemeriksaanPasien.';
	/**
	 * action ini digunakan untuk mengakses menu pemeriksaan pasien
	 * @param type $pendaftaran_id
	 */
	public function actionIndexRM($pendaftaran_id)
	{
		$modPendaftaran = PendaftaranT::model()->with('jeniskasuspenyakit')->findByPk($pendaftaran_id);
		$modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
		$this->render('rehabMedis.views.pemeriksaanPasienTRM.index', array(
			'modPendaftaran' => $modPendaftaran,
			'modPasien' => $modPasien,
		));
	}
}
