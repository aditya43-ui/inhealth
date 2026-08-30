
<?php

class TandaVitalBalanceCairanController extends MyAuthController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout = '//layouts/iframe';
	public $defaultAction = 'inde';
	public $path_view = 'rawatInap.views.tandaVitalBalanceCairan.';

	public function actionIndex($pendaftaran_id)
	{

    $kunjungan = InfokunjunganriV::model()->findByAttributes(array(
            'pendaftaran_id'=>$pendaftaran_id,
		));

		$this->render($this->path_view .'index',array(
			'kunjungan'=>$kunjungan,
		));
	}

	public function getUrlTandaVital() {
			return $this->module->id . '/grafikTandaVital/create';
	}

	public function getUrlBalanceCairan() {
			return $this->module->id . '/BalanceCairan/index';
	}


}
