<?php
/**
 * Cotnroller untuk Informasi Daftar Spesimen
 * @author  Yusuf Putra Anugrah <yusufputra@.com>
 * @package application.modules.mikrobiologiKlinik
 * @subpackage controllers
 * @category controller
 */
class InformasiHasilPemeriksaanController extends MyAuthController{
    
    /**
     * Load data informasi pengiriman spesimen
     */
    public $layout = '//layouts/column1';
    public $defaultAction = 'index';
    public $path_view = 'mikrobiologiKlinik.views.informasihasilpemeriksaan.';

    public function actionIndex(){
        $model = new MKkelompokpemeriksaanmikroV();
        $model->tgl_awal= date("Y-m-d");
        $model->tgl_akhir= date("Y-m-d");        
        if (isset($_GET['MKkelompokpemeriksaanmikroV'])){
            $model->attributes = $_GET['MKkelompokpemeriksaanmikroV'];
            $model->samplelab_nama = $_GET['MKkelompokpemeriksaanmikroV']['samplelab_nama'];
            $model->no_lab = $_GET['MKkelompokpemeriksaanmikroV']['no_lab'];
            $model->nama_pasien = $_GET['MKkelompokpemeriksaanmikroV']['nama_pasien'];
            $model->no_rekam_medik = $_GET['MKkelompokpemeriksaanmikroV']['no_rekam_medik'];
            $model->daftartindakan_nama = $_GET['MKkelompokpemeriksaanmikroV']['daftartindakan_nama'];
            $model->nama_pegawai = $_GET['MKkelompokpemeriksaanmikroV']['nama_pegawai'];
            $model->status_kirim = $_GET['MKkelompokpemeriksaanmikroV']['status_kirim'];
            $model->carabayar_nama = $_GET['MKkelompokpemeriksaanmikroV']['carabayar_nama'];
            $model->tgl_awal = MyFormatter::formatDateTimeForDb($_GET['MKkelompokpemeriksaanmikroV']['tgl_awal']);
            $model->tgl_akhir = MyFormatter::formatDateTimeForDb($_GET['MKkelompokpemeriksaanmikroV']['tgl_akhir']);
        }
        $this->render($this->path_view.'index', array('model' => $model));
    }
    
 

    /**
     * Get data pasien pengambil hasil->
     */
    public function actionGeneratePasien() {
        if (Yii::app()->request->isAjaxRequest) {
            $returnVal = array();
            $returnVal['pesan'] = "";

            $pasien_id = isset($_POST['pasien_id']) ? $_POST['pasien_id'] : null;

            $modPasien = PasienM::model()->findByPk($pasien_id);
            $attributes = $modPasien->attributeNames();
            foreach ($attributes as $j => $attribute) {
                $returnVal["$attribute"] = $modPasien->$attribute;
            }

            $returnVal["nama_pengambil"] = $modPasien->nama_pasien;
            $returnVal["noidentitas_pengambil"] = $modPasien->no_identitas_pasien;
            $returnVal["alamat_pengambil"] = $modPasien->alamat_pasien;
            $returnVal["nomobile_pengambil"] = $modPasien->no_mobile_pasien;
            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }

}

