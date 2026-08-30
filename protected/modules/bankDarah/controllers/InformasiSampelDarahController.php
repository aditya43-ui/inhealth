<?php

/**
 * Informasi Sampel Darah di modul bank darah
 * @author Aida Rahmawati <aidarahmawati@.com>
 * @author Elham Budianto <elhambudianto1@gmail.com>
 * @package application.modules.bankDarah
 * @subpackage controllers
 */
class InformasiSampelDarahController extends MyAuthController {

    public $layout = '//layouts/column1';
    public $defaultAction = 'admin';
    public $path_view = 'bankDarah.views.informasiSampelDarah';

    /**
     * Fungsi untuk load halaman informasi sampel darah
     */
    public function actionIndex() {
        $model = new BDInfokantongdarahV('searchSampelDarah');
        $model->unsetAttributes();  // clear any default values
        $format = new MyFormatter();
        $model->tgl_awal = date("Y-m-d");
        $model->tgl_akhir = date("Y-m-d");

        if (isset($_GET['BDInfokantongdarahV'])) {
            $model->attributes = $_GET['BDInfokantongdarahV'];
            $model->tgl_awal = MyFormatter::formatDateTimeForDb($_GET['BDInfokantongdarahV']['tgl_awal']);
            $model->tgl_akhir = MyFormatter::formatDateTimeForDb($_GET['BDInfokantongdarahV']['tgl_akhir']);
            $model->nomorbarcode_sample_imltd=isset($_GET['BDInfokantongdarahV']['nomorbarcode_sample_imltd'])?$_GET['BDInfokantongdarahV']['nomorbarcode_sample_imltd']:null;
            
        }

        $this->render($this->path_view . '/index', array(
            'model' => $model,
            'format' => $format,
        ));
    }

    /**
     * Load Data detail Skrining imltd
     * @param type $kantongdarah_id
     */
    public function actionDetail($kantongdarah_id) {
        $this->layout = '//layouts/iframe';
        $kantong = KantongdarahT::model()->findByPk($kantongdarah_id);
        $terimaKantong = TerimakantongdetT::model()->findByPk($kantong->terimakantongdarah_id);
        $model = SkriningimltdT::model()->findByPk($kantong->skriningimltd_id);
        $model->tglskrining = MyFormatter::formatDateTimeForUser($model->tglskrining);
        $model->hbsag = (empty($model->hbsag) || !$model->hbsag) ? 0 : 1;
        $model->antihiv = (empty($model->antihiv) || !$model->antihiv) ? 0 : 1;
        $model->antihvc = (empty($model->antihvc) || !$model->antihvc) ? 0 : 1;
        $model->sifilis = (empty($model->sifilis) || !$model->sifilis) ? 0 : 1;

        $this->render($this->path_view . '/_detail', array(
            'model' => $model,
            'kantong' => $kantong,
        ));
    }

    /**
     * Load Data detail Pengujian Konfirmasi Darah
     * @param type $kantongdarah_id
     */
    public function actionDetailPengujian($id) {
        $this->layout = '//layouts/iframe';
        $model = BDPengujiandarahT::model()->findByPk($id);
        $model->tglpengujian = MyFormatter::formatDateTimeForUser($model->tglpengujian);
        $model->petugaspengujian_nama = $model->petugaspengujian->namaLengkap;
        $this->render($this->path_view . '/_detailPengujianDarah', array(
            'model' => $model,
        ));
    }
        /**
         * Load Data detail Skrining imltd
         * @param type $nomorbarcode_sample
         * @param type $pengujian_ke
         */
        public function actionDetailSkrining($nomorbarcode_sample,$pengujian_ke)
	{
            $this->layout = '//layouts/iframe';
            $model = SkriningimltdT::model()->findByAttributes(array('nomorbarcode_sample'=>$nomorbarcode_sample,'pengujian_ke'=>$pengujian_ke));
            $kantong = KantongdarahT::model()->findByPk($model->kantongdarah_id);

            $model->tglskrining = MyFormatter::formatDateTimeForUser($model->tglskrining);
            $model->hbsag = (empty($model->hbsag) || !$model->hbsag) ? 0 : 1;
            $model->antihiv = (empty($model->antihiv) || !$model->antihiv) ? 0 : 1;
            $model->antihvc = (empty($model->antihvc) || !$model->antihvc) ? 0 : 1;
            $model->sifilis = (empty($model->sifilis) || !$model->sifilis) ? 0 : 1;

		$this->render($this->path_view.'/_detail',array(
			'model'=>$model,
                        'kantong'=>$kantong,
		));
	}
}
