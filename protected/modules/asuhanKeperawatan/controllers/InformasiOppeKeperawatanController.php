<?php

/**
 * Controller untuk Informasi OPPE Keperawatan
 * @author Yudhit Widy Wicaksono <yudhitwicaksono@.com>
 * @author Andyka Putra <andykaputra@.com>
 * @package application.modules.asuhanKeperawatan
 * @subpackage controllers
 * @category controller
 */
class InformasiOppeKeperawatanController extends MyAuthController {

    public $path_view = 'asuhanKeperawatan.views.informasiOppeKeperawatan.';

    /**
     * Halaman utama Informasi OPPE Keperawatan
     */
    public function actionIndex() {
        $model = new LaporanoppekeperawatanV;
        $modPerilaku = new OppeperilakuT('search');
        $modPelatihan = new OppepelatihanT('search');
        $modClinical = new OppeclinicalcareT('search');
        $modKehadiran = new OppekehadiranT('search');
        $modCaring = new OppecaringT('search');
        $modAsesmen = new OppeasesmenT('search');
        $modBimbingan = new OppebimbinganT('search');
        $model->bulan_pilih=date("Y-m");
        $model->bulan_pilih_awal=date("Y",strtotime("-1 year")).date("-m");
        $model->bulan_pilih_akhir=date("Y-m");
                
        if (isset($_GET['LaporanoppekeperawatanV'])) {
            $model->attributes = $_GET['LaporanoppekeperawatanV'];
            $model->bulan_pilih_awal = MyFormatter::formatDateTimeForDb('01 ' . $_GET['LaporanoppekeperawatanV']['bulan_pilih_awal']);
            $model->bulan_pilih_akhir = MyFormatter::formatDateTimeForDb('01 ' . $_GET['LaporanoppekeperawatanV']['bulan_pilih_akhir']);
            $model->pegawai_id = isset($_GET['LaporanoppekeperawatanV']['pegawai_id']) ? $_GET['LaporanoppekeperawatanV']['pegawai_id'] : null;
            $model->indikatoroppekeperawatan_id =isset($_GET['LaporanoppekeperawatanV']['indikatoroppekeperawatan_id']) ? $_GET['LaporanoppekeperawatanV']['indikatoroppekeperawatan_id'] : null;
        }
        
        $this->render($this->path_view . 'index', array(
            'model' => $model,
            'modPerilaku' => $modPerilaku,
            'modPelatihan' => $modPelatihan,
            'modClinical' => $modClinical,
            'modKehadiran' => $modKehadiran,
            'modCaring' => $modCaring,
            'modAsesmen' => $modAsesmen,
            'modBimbingan' => $modBimbingan,
            'modDefault' => $model
        ));
    }

    /**
     * Digunakan untuk load data OPPE
     */
    public function actionGetData() {
        if (Yii::app()->request->isAjaxRequest) {
            //get data post
            
            $bulan_pilih = !empty($_POST['bulan_pilih']) ? $_POST['bulan_pilih'] : null;
            $bulan_pilih_awal = !empty($_POST['bulan_pilih_awal']) ? $_POST['bulan_pilih_awal'] : null;
            $bulan_pilih_akhir = !empty($_POST['bulan_pilih_akhir']) ? $_POST['bulan_pilih_akhir'] : null;
            $pegawai_id = !empty($_POST['pegawai_id']) ? $_POST['pegawai_id'] : null;
            $indikator = !empty($_POST['indikator']) ? $_POST['indikator'] : null;
            /*
            if($indikator == 1){
                $model = new OppeperilakuT;
                $model->indikatoroppekeperawatan_id = $indikator;
                if(!empty($pegawai_id)){
                    $model->pegawai_id = $pegawai_id;
                }
//                if(!empty($bulan_pilih)){
//                    $model->bulan_pencatatan = MyFormatter::formatDateTimeForDb('01 ' . $bulan_pilih);
                if((!empty($bulan_pilih_awal))&&(!empty($bulan_pilih_akhir))){
                    $model->bulan_pencatatan = MyFormatter::formatDateTimeForDb('01 ' . $bulan_pilih_awal. $bulan_pilih_akhir);
                }
                $return = $this->renderPartial($this->path_view . "/table/_tablePerilaku", array('modPerilaku' => $model), true);
                
            }else if($indikator == 2){
                $model = new OppepelatihanT;
                $model->indikatoroppekeperawatan_id = $indikator;
                if(!empty($pegawai_id)){
                    $model->pegawai_id = $pegawai_id;
                }
//                if(!empty($bulan_pilih)){
//                    $model->bulan_pelatihan = MyFormatter::formatDateTimeForDb('01 ' . $bulan_pilih);
//                }
                if((!empty($bulan_pilih_awal))&&(!empty($bulan_pilih_akhir))){
                    $model->bulan_pelatihan = MyFormatter::formatDateTimeForDb('01 ' . $bulan_pilih_awal. $bulan_pilih_akhir);
                }
                $return = $this->renderPartial($this->path_view . "/table/_tablePelatihan", array('modPelatihan' => $model), true);
                
            }else if($indikator == 3){
                $model = new OppeclinicalcareT;
                $model->indikatoroppekeperawatan_id = $indikator;
                if(!empty($pegawai_id)){
                    $model->pegawai_id = $pegawai_id;
                }
                if(!empty($bulan_pilih)){
                    $model->bulan_clinicalcare = MyFormatter::formatDateTimeForDb('01 ' . $bulan_pilih);
                }
                $return = $this->renderPartial($this->path_view . "/table/_tableClinicalCare", array('modClinical' => $model), true);
                
            }else if($indikator == 4){
                $model = new OppekehadiranT;
                $model->indikatoroppekeperawatan_id = $indikator;
                if(!empty($pegawai_id)){
                    $model->pegawai_id = $pegawai_id;
                }
                if(!empty($bulan_pilih)){
                    $model->bulan_kehadiran = MyFormatter::formatDateTimeForDb('01 ' . $bulan_pilih);
                }
                $return = $this->renderPartial($this->path_view . "/table/_tableKehadiran", array('modKehadiran' => $model), true);
                
            }else if($indikator == 5){
                $model = new OppecaringT;
                $model->indikatoroppekeperawatan_id = $indikator;
                if(!empty($pegawai_id)){
                    $model->pegawai_id = $pegawai_id;
                }
//                if(!empty($bulan_pilih)){
//                    $model->bulan_caring = MyFormatter::formatDateTimeForDb('01 ' . $bulan_pilih);
//                }
                if((!empty($bulan_pilih_awal))&&(!empty($bulan_pilih_akhir))){
                    $model->bulan_caring = MyFormatter::formatDateTimeForDb('01 ' . $bulan_pilih_awal. $bulan_pilih_akhir);
                }
                $return = $this->renderPartial($this->path_view . "/table/_tableCaring", array('modCaring' => $model), true);
                
            }else if($indikator == 6){
                $model = new OppeasesmenT;
                $model->indikatoroppekeperawatan_id = $indikator;
                if(!empty($pegawai_id)){
                    $model->pegawai_id = $pegawai_id;
                }
                if(!empty($bulan_pilih)){
                    $model->bulan_asesmen = MyFormatter::formatDateTimeForDb('01 ' . $bulan_pilih);
                }
                $return = $this->renderPartial($this->path_view . "/table/_tableAsesmen", array('modAsesmen' => $model), true);
                
            }else if($indikator == 7){
                $model = new OppebimbinganT;
                $model->indikatoroppekeperawatan_id = $indikator;
                if(!empty($pegawai_id)){
                    $model->pegawai_id = $pegawai_id;
                }
//                if(!empty($bulan_pilih)){
//                    $model->bulan_bimbingan = MyFormatter::formatDateTimeForDb('01 ' . $bulan_pilih);
//                }
                if((!empty($bulan_pilih_awal))&&(!empty($bulan_pilih_akhir))){
                    $model->bulan_bimbingan = MyFormatter::formatDateTimeForDb('01 ' . $bulan_pilih_awal. $bulan_pilih_akhir);
                }
                $return = $this->renderPartial($this->path_view . "/table/_tableBimbingan", array('modBimbingan' => $model), true);
            }else{
            */   
            
                $model = new LaporanoppekeperawatanV;
                if(!empty($indikator)){
                    $model->indikatoroppekeperawatan_id = $indikator;
                }
                if(!empty($pegawai_id)){
                    $model->pegawai_id = $pegawai_id;
                }
                if((!empty($bulan_pilih_awal))&&(!empty($bulan_pilih_akhir))){
                    $model->bulan_pilih_awal = MyFormatter::formatDateTimeForDb('01 ' . $bulan_pilih_awal);
                    $model->bulan_pilih_akhir = MyFormatter::formatDateTimeForDb('01 ' . $bulan_pilih_akhir);
                }
                $return = $this->renderPartial($this->path_view . "/_tableDefault", array('modDefault' => $model), true);
//            }
            
            $data['return'] = $return;
            echo json_encode($data);
            Yii::app()->end();
        }
    }
    
    /**
     * Autocomplete Perawat
     */
    public function actionAutoCompleteGetPerawat() {
        if (Yii::app()->request->isAjaxRequest) {
            $kelompokpegawai = [Params::KELOMPOKPEGAWAI_ID_TENAGA_KEPERAWATAN, Params::KELOMPOKPEGAWAI_ID_BIDAN];

            $criteria = new CDbCriteria;
            $criteria->select = 't.*, jabatan_m.jabatan_nama, unitkerja_m.namaunitkerja';
            $criteria->join = 'LEFT JOIN jabatan_m ON jabatan_m.jabatan_id = t.jabatan_id '
                            . 'LEFT JOIN unitkerja_m ON unitkerja_m.unitkerja_id = t.unitkerja_id';

            $criteria->addInCondition('t.kelompokpegawai_id', $kelompokpegawai);
            $criteria->compare('LOWER(t.nama_pegawai)', strtolower($_GET['term']), true);
            $criteria->addCondition('pegawai_aktif IS TRUE');
            $criteria->order = 'nama_pegawai ASC';
            $criteria->limit = 10;
            $modPegawai = ASPegawaiM::model()->findAll($criteria);

            foreach ($modPegawai as $i => $model) {
                $attributes = $model->attributeNames();
                foreach ($attributes as $j => $attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['pegawai_id'] = $model['pegawai_id'];
                $returnVal[$i]['nama_pegawai'] = $model['nama_pegawai'];
                $returnVal[$i]['nomorindukpegawai'] = $model['nomorindukpegawai'];
                $returnVal[$i]['unitkerja_id'] = $model['unitkerja_id'];
                $returnVal[$i]['namaunitkerja'] = $model['namaunitkerja'];
                $returnVal[$i]['label'] = $model['nama_pegawai'];
                $returnVal[$i]['value'] = $model['pegawai_id'];
            }

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }
    
    /**
     * Detail Oppe Asesmen
     * @param type $oppeasesmen_id
     */
    public function actionDetailAsesmen($oppeasesmen_id) {
        $this->layout = '//layouts/iframe';
        $model = OppeasesmenT::model()->findByPk($oppeasesmen_id);
        return $this->render($this->path_view . '/detail/detailAsesmen', array(
            'model' => $model
        ));
    }
    /**
     * Detail Oppe Kehadiran
     * @param type $oppekehadiran_id
     */
    public function actionDetailKehadiran($oppekehadiran_id) {
        $this->layout = '//layouts/iframe';
        $model = OppekehadiranT::model()->findByPk($oppekehadiran_id);
        return $this->render($this->path_view . '/detail/detailKehadiran', array(
            'model' => $model
        ));
    }
    /**
     * Detail Bimbingan
     * @param type $oppebimbingan_id
     */
    public function actionDetailBimbingan($oppebimbingan_id) {
        $this->layout = '//layouts/iframe';
        $model = OppebimbinganT::model()->findByPk($oppebimbingan_id);
        return $this->render($this->path_view . '/detail/detailBimbingan', array(
            'model' => $model
        ));
    }
    /**
     * Detail Oppe Caring
     * @param type $oppecaring_id
     */
    public function actionDetailCaring($oppecaring_id) {
        $this->layout = '//layouts/iframe';
        $model = OppecaringT::model()->findByPk($oppecaring_id);
        return $this->render($this->path_view . '/detail/detailCaring', array(
            'model' => $model
        ));
    }
    /**
     * Detail Oppe Clinical Care
     * @param type $oppeclinicalcare_id
     */
    public function actionDetailClinical($oppeclinicalcare_id) {
        $this->layout = '//layouts/iframe';
        $model = OppeclinicalcareT::model()->findByPk($oppeclinicalcare_id);
        return $this->render($this->path_view . '/detail/detailClinical', array(
            'model' => $model
        ));
    }
    /**
     * Detail Oppe pelatihan
     * @param type $oppepelatihan_id
     */
    public function actionDetailPelatihan($oppepelatihan_id) {
        $this->layout = '//layouts/iframe';
        $model = OppepelatihanT::model()->findByPk($oppepelatihan_id);
        return $this->render($this->path_view . '/detail/detailPelatihan', array(
            'model' => $model
        ));
    }
    /**
     * Detail Oppe Perilaku
     * @param type $oppeperilaku_id
     */
    public function actionDetailPerilaku($oppeperilaku_id) {
        $this->layout = '//layouts/iframe';
        $model = OppeperilakuT::model()->findByPk($oppeperilaku_id);
        return $this->render($this->path_view . '/detail/detailPerilaku', array(
            'model' => $model
        ));
    }
}
