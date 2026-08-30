<?php

class TampilAntrianKePendaftaranNewController extends Controller {

    public $layout = '//layouts/antrian';
    public $defaultAction = 'index';
    public $path_view = 'antrian.views.tampilAntrianKePendaftaranNew.';
    
    /**
     * Menu utama tampil layar antrian Lab Mikro
     */
    /**
     * Menu utama tampil layar antrian Lab Mikro
     */
    public function actionLokasi($lokasi_karcisantrian_id=null, $layarantrian_id=null, $modelantrian_id='') {
        $this->layout = '//layouts/antrian_baru';
        
        $cri = new CDbCriteria();
        $cri->select = " t.*, model.modelantrian_singkatan, model.modelantrian_id, model.modelantrian_nama ";
        $cri->join =  " JOIN modelantrian_m model ON model.modelantrian_id = t.modelantrian_id ";
        $cri->addCondition(" loket_aktif = TRUE ");
        if (!empty($lokasi_karcisantrian_id)){
            $cri->addCondition(" model.lokasi_karcisantrian_id = ".$lokasi_karcisantrian_id."   ");
        }
        if (!empty($modelantrian_id)){
            if ($modelantrian_id != 'all'){                            
                $cri->addInCondition(" t.modelantrian_id ",explode(',',$modelantrian_id));
            }
        }
        if (!empty($modelantrian_id) && $modelantrian_id == 'all'){
            $cri->order = " modelantrian_singkatan ASC, t.loket_nourut ASC ";
        }else{
            $modelantrian_id = 'all';
            $cri->join .= " JOIN layarloket_m lk ON (lk.loket_id = t.loket_id) AND (lk.layarantrian_id = ".$layarantrian_id.") ";
            $cri->order = " t.loket_nourut ASC ";
        }
        $cri->addCondition(" model.modelantrian_aktif = TRUE ");
        $loket = LoketM::model()->findAll($cri);
        $lokasi = new LokasiKarcisantrianM;
        if (!empty($lokasi_karcisantrian_id)){
            $lokasi = LokasiKarcisantrianM::model()->findByPK($lokasi_karcisantrian_id);
        }
        $layar = LayarantrianM::model()->findByPk($layarantrian_id);
        $nomor_loket = array();
        $load_model = array();
        
        foreach($loket as $det){     
            if (!empty($modelantrian_id) && $modelantrian_id == 'all'){
                $iden = trim($det->modelantrian_id);                
                $nomor_loket[$iden]['det'][$det->loket_id]['loket_no'] = trim($det->loket_singkatan);
                $nomor_loket[$iden]['det'][$det->loket_id]['loket_nama'] = trim($det->loket_nama);                 
                $nomor_loket[$iden]['det'][$det->loket_id]['loket_id'] = $det->loket_id;                                         
                
                $load_model[$iden]['modelantrian_id'] = $det->modelantrian_id;
                $load_model[$iden]['modelantrian_singkatan'] = $det->modelantrian_singkatan;
                $load_model[$iden]['modelantrian_nama'] = $det->modelantrian_nama;
            }else{
                $iden = trim($det->loket_singkatan).trim($det->loket_nama);
                $nomor_loket[$iden]['loket_no'] = trim($det->loket_singkatan);
                $nomor_loket[$iden]['loket_id'] = trim($det->loket_singkatan);  
                $nomor_loket[$iden]['loket_nama'] = trim($det->loket_nama);  
                $nomor_loket[$iden]['det'][$det->loket_id] = $det->loket_id;  
            }
        }                                     
        
        $i = 1;
        $a = 0;
        $temp = $nomor_loket;                
        $nomor_loket = array();    
        $nomor = 0;
        if (!empty($modelantrian_id) && $modelantrian_id == 'all'){
            foreach($load_model as $m){
                $i = 0;
                $key = $m['modelantrian_id'];
                foreach($temp[$m['modelantrian_id']]['det'] as $l){
                    $nomor_loket[$i][$key]['loket_no'] = $l['loket_no'];
                    $nomor_loket[$i][$key]['loket_nama'] = $l['loket_nama'];
                    $nomor_loket[$i][$key]['loket_id'] = $l['loket_id'];                                          
                    $nomor_loket[$i][$key]['baris'] = count($temp[$m['modelantrian_id']]['det']); 
                    $i++;
                    
                    $load_model[$key]['baris'] = count($temp[$m['modelantrian_id']]['det']);
                    if (count($temp[$m['modelantrian_id']]['det']) > $nomor  ){
                        $nomor =  count($temp[$m['modelantrian_id']]['det']);
                    }
                }                                                
            }                  
        }else{
            foreach($temp as $key => $det){             
                $nomor_loket[$a][$key]['loket_no'] = $det['loket_no'];
                $nomor_loket[$a][$key]['loket_nama'] = $det['loket_nama'];
                $nomor_loket[$a][$key]['loket_id'][$det['loket_no']] = $det['loket_no'];            
                $nomor_loket[$a][$key]['det'] = $det['det'];            
                //$nomor_loket[$a][$key]['loket_id'][$det['loket_no']]['det'] = $det['det'];            
                if ($i % 4 == 0){
                    $a++;
                }  
                $i++;            
            }        
        }
        
        $format = new MyFormatter();
        $model = new ANAntrianT();
        $konfig = KonfigsystemK::model()->find();
        
        if ($modelantrian_id == 'all'){
            $render = 'lokasi/indexAll';
        }else{
            $render = 'lokasi/index';
        }
        
        $this->render($this->path_view . $render, array(
            'format' => $format,
            'model' => $model,
            'konfig' => $konfig,
            'nomor_loket' => $nomor_loket,
            'load_model' => $load_model,
            'pathview' => $this->path_view,
            'lokasi'=>$lokasi,
            'layar'=>$layar,
            'modelantrian_id' => $modelantrian_id,
            'nomor'=>$nomor
        ));
    }  
    
    public function actionIndex($layarantrian_id=null) {
        $format = new MyFormatter();
        $model = new ANAntrianT();
        $konfig = KonfigsystemK::model()->find();
        $criteria = new CdbCriteria;
        $criteria->addCondition("loket_aktif = true AND ispendaftaran = TRUE");
        $criteria->order = "loket_nourut ASC";
        $modLokets = ANLoketM::model()->findAll($criteria);
        $layar = ANLayarantrianM::model()->findByPk($layarantrian_id);
        $this->render('index', array(
            'format' => $format,
            'model' => $model,
            'modLokets' => $modLokets,
            'konfig' => $konfig,
            'layar'=>$layar
        ));
    }

    public function actionJaminanLama1() {
        
        $this->layout = '//layouts/antrian_baru';
        
        $layar = LayarantrianM::model()->findByPk(
                Params::LAYARANTRIAN_ID_PASIEN_LAMA_JAMINAN_1
        );
        $nomor_loket = array(
            array(
                'loket_no' => 1,
                'loket_id' => array(1, 9, 17),
            ),
            array(
                'loket_no' => 2,
                'loket_id' => array(2, 10, 18),
            ),
            array(
                'loket_no' => 3,
                'loket_id' => array(3, 11, 19),
            ),
            array(
                'loket_no' => 4,
                'loket_id' => array(4, 12, 20),
            )
        );

        $format = new MyFormatter();
        $model = new ANAntrianT();
        $konfig = KonfigsystemK::model()->find();
        $criteria = new CdbCriteria;
        $criteria->addCondition("loket_aktif = true AND ispendaftaran = TRUE");
        $criteria->order = "loket_nourut ASC";
        $this->render('layarAntrianJaminanLama1/index', array(
            'format' => $format,
            'model' => $model,
            'konfig' => $konfig,
            'layar' => $layar,
            'nomor_loket' => $nomor_loket,
        ));
    }
    
    public function actionJaminanLama2() {
        $this->layout = '//layouts/antrian_baru';
        $layar = LayarantrianM::model()->findByPk(
                Params::LAYARANTRIAN_ID_PASIEN_LAMA_JAMINAN_2
        );
        $nomor_loket = array(
            array(
                'loket_no' => 5,
                'loket_id' => array(5, 13, 21),
            ),
            array(
                'loket_no' => 6,
                'loket_id' => array(6, 14, 22),
            ),
            array(
                'loket_no' => 7,
                'loket_id' => array(7, 15, 23),
            ),
            array(
                'loket_no' => 8,
                'loket_id' => array(8, 16, 24),
            )
        );

        $format = new MyFormatter();
        $model = new ANAntrianT();
        $konfig = KonfigsystemK::model()->find();
        $criteria = new CdbCriteria;
        $criteria->addCondition("loket_aktif = true AND ispendaftaran = TRUE");
        $criteria->order = "loket_nourut ASC";
        $this->render('layarAntrianJaminanLama2/index', array(
            'format' => $format,
            'model' => $model,
            'konfig' => $konfig,
            'layar' => $layar,
            'nomor_loket' => $nomor_loket,
        ));
    }
    
    public function actionJaminanBaruUmum() {
        $this->layout = '//layouts/antrian_baru';
        $layar = LayarantrianM::model()->findByPk(
                Params::LAYARANTRIAN_ID_PASIEN_BARU_JAMINAN_UMUM
        );
        $nomor_loket = array(
            array(
                'loket_no' => 5,
                'loket_id' => array(25, 28, 31),
            ),
            array(
                'loket_no' => 6,
                'loket_id' => array(26, 29, 32),
            ),
            array(
                'loket_no' => 7,
                'loket_id' => array(27, 30, 33),
            ),
        );

        $format = new MyFormatter();
        $model = new ANAntrianT();
        $konfig = KonfigsystemK::model()->find();
        $criteria = new CdbCriteria;
        $criteria->addCondition("loket_aktif = true AND ispendaftaran = TRUE");
        $criteria->order = "loket_nourut ASC";
        $this->render('layarAntrianJaminanBaruUmum/index', array(
            'format' => $format,
            'model' => $model,
            'konfig' => $konfig,
            'layar' => $layar,
            'nomor_loket' => $nomor_loket,
        ));
    }

    public function actionSetAntrianAllTerakhir() {
        $jenis = isset($_POST['jenis'])?$_POST['jenis']:null;
        $lokasi_karcisantrian_id = isset($_POST['lokasi_karcisantrian_id'])?$_POST['lokasi_karcisantrian_id']:null;
        $modelantrian_id = isset($_POST['modelantrian_id'])?$_POST['modelantrian_id']:null;
        $layarantrian_id = isset($_POST['layarantrian_id'])?$_POST['layarantrian_id']:null;
        
        $loket_id = array();
        if(!empty($jenis)){
            $loket_id = Params::getLoketAntrianLayar($jenis);
        }else{
            $cri = new CDbCriteria();
            $cri->join =  " JOIN modelantrian_m model ON model.modelantrian_id = t.modelantrian_id ";
            $cri->addCondition(" t.loket_aktif = TRUE ");            
            if (!empty($lokasi_karcisantrian_id)){
                $cri->addCondition(" model.lokasi_karcisantrian_id = ".$lokasi_karcisantrian_id."    ");
            }elseif (!empty($layarantrian_id)){
                $modelantrian_id = 'all';
                $cri->join .= " JOIN layarloket_m ll ON (ll.loket_id = t.loket_id) AND (ll.layarantrian_id = ".$layarantrian_id.") ";                                
            }
            if (!empty($modelantrian_id)){
                if ($modelantrian_id != 'all'){
                    $cri->addInCondition(" t.modelantrian_id ",explode(',',$modelantrian_id));
                }
            }
            $cri->order = " t.loket_nourut ";
            $loket = LoketM::model()->findAll($cri);
            
            foreach($loket as $lok){
                $loket_id[] = $lok->loket_id;
            }            
        }       

        $criteria = new CDbCriteria();
        $criteria->compare("DATE(tglantrian)", date("Y-m-d"));
        $criteria->addCondition("panggil_flaq = TRUE");
        (!empty($loket_id))? $criteria->addInCondition('loket_id', $loket_id) : '';
        $criteria->order = "jampanggil DESC, loket_id DESC, noantrian DESC"; //panggil terakhir
        $model = ANAntrianT::model()->find($criteria);
        
        if (!empty($model)) {
            $data['model'] = $model->attributes;
            $data['model'] += array(
                'loket_nama' => strtoupper($model->loket->loket_nama),
                'modelantrian_singkatan' => strtoupper($model->modelantrian->modelantrian_singkatan),
            );
        } else {
            $data['model'] = null;
        }

        echo CJSON::encode($data);
        Yii::app()->end();
    }

    /**
     * get nilai antrian
     * @throws CHttpException
     */
    public function actionGetAntrians() {
        //if(Yii::app()->request->isAjaxRequest)
        //{
        $lokasi_karcisantrian_id = (isset($_POST['lokasi_karcisantrian_id']) && (!empty($_POST['lokasi_karcisantrian_id']))) ? $_POST['lokasi_karcisantrian_id'] : null;
        $modelantrian_id = (isset($_POST['modelantrian_id']) && (!empty($_POST['modelantrian_id']))) ? $_POST['modelantrian_id'] : null;
        $layarantrian_id = isset($_POST['layarantrian_id'])?$_POST['layarantrian_id']:null;
        $jenis = (isset($_POST['jenis']) && (!empty($_POST['jenis']))) ? $_POST['jenis'] : null;
        $format = new MyFormatter();
        $data = array();

        if(!empty($jenis)){
            $loket_id = Params::getLoketAntrianLayar($jenis);
            $condition = "AND loket_id IN (".implode(',', $loket_id).")";
        }else{
            $cri = new CDbCriteria();
            $cri->join =  " JOIN modelantrian_m model ON model.modelantrian_id = t.modelantrian_id ";
            $cri->addCondition(" t.loket_aktif = TRUE ");            
            if (!empty($lokasi_karcisantrian_id)){
                $cri->addCondition(" model.lokasi_karcisantrian_id = ".$lokasi_karcisantrian_id."  ");
            }elseif (!empty($layarantrian_id)){
                $modelantrian_id = 'all';
                $cri->join .= " JOIN layarloket_m ll ON (ll.loket_id = t.loket_id) AND (ll.layarantrian_id = ".$layarantrian_id.") ";                                                
            }
            if (!empty($modelantrian_id)){
                if ($modelantrian_id != 'all'){
                    $cri->addInCondition(" t.modelantrian_id ",explode(',',$modelantrian_id));
                }
            }
            $cri->order = " t.loket_nourut ";
            $loket = LoketM::model()->findAll($cri);
            
            foreach($loket as $lok){
                $loket_id[] = $lok->loket_id;
            }             
            $condition = " AND loket_id IN (" . implode(',', $loket_id) . ")";
        }
        
        if(empty($_POST['antrian_id'])){
            $condition = '';
        }else{
            $condition .= " AND antrian_id = ".$_POST['antrian_id'];
        }
        
//        $modLokets = ANLoketM::model()->findAll('ispendaftaran = TRUE AND loket_aktif = TRUE');
        $modLokets = AntrianT::model()->findAll("DATE(tglantrian)='" . date("Y-m-d") . "' AND loket_id IS NOT NULL AND modelantrian_id IS NOT NULL ".$condition." ORDER BY jampanggil ASC");
        
        if (count($modLokets) > 0) {
            foreach ($modLokets AS $i => $loket) {
                $modAntrian = $this->loadModelAntrian($loket->loket_id);
                $modJumlah = $this->loadDataStatistik($loket->loket_id);
                if ($modAntrian) {
                    if (isset($_POST['antrian_id']) && $_POST['antrian_id'] != '') {
                        $modAntrian = $this->loadModelAntrianById($loket->loket_id, $_POST['antrian_id']);
                        $modJumlah = $this->loadDataStatistik($loket->loket_id);
                    }
                    if (!empty($modAntrian)) {
                        $data["an_" . $i] = $modAntrian->attributes;
                        $data["an_" . $i] += $loket->attributes;
                        $data["an_" . $i] += $modJumlah;
                        $data["an_" . $i] += $modJumlah;
                        $data["an_" . $i] += array(
                            'modelantrian_singkatan' => $modAntrian->modelantrian->modelantrian_singkatan,
                            'loket_singkatan' => trim($loket->loket->loket_singkatan)
                        );
                    }
                }
            }
        }

        echo CJSON::encode($data);
        Yii::app()->end();
        //}
        //else
        //throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
    }

    public function actionUpdateStatistik() {
        $format = new MyFormatter();
        $data = array();

        if (isset($_POST['loket_id'])) {
            $modJumlah = $this->loadDataStatistik($_POST['loket_id']);
        }
        echo CJSON::encode(array('stat' => $modJumlah));
        Yii::app()->end();
    }

    protected function loadDataStatistik($loket_id) {
        $default = '000';
        $data['jmlpasien'] = 0;
        $data['jmlmenunggu'] = 0;
        $data['jmlterdaftar'] = 0;

        $criteria = new CDbCriteria();
        $criteria->compare("DATE(tglantrian)", date("Y-m-d"));
        $criteria->addCondition("loket_id = " . $loket_id);
        $criteria->order = "loket_id DESC, noantrian DESC"; //panggil terakhir
        $models = ANAntrianT::model()->findAll($criteria);

        if (count($models) > 0) {
            foreach ($models as $i => $model) {
                $data['jmlpasien'] += 1;
                if (!empty($model->pendaftaran_id)) {
                    $data['jmlterdaftar'] += 1;
                }
            }
        }

        $jmlmenunggu = $data['jmlpasien'] - $data['jmlterdaftar'];
        $data['jmlpasien'] = (isset($data['jmlpasien']) ? (str_pad($data['jmlpasien'], strlen($default), 0, STR_PAD_LEFT)) : $default);
        $data['jmlterdaftar'] = (isset($data['jmlterdaftar']) ? (str_pad($data['jmlterdaftar'], strlen($default), 0, STR_PAD_LEFT)) : $default);
        $data['jmlmenunggu'] = (isset($jmlmenunggu) ? (str_pad($jmlmenunggu, strlen($default), 0, STR_PAD_LEFT)) : $default);
        return $data;
    }

    /**
     * cari antrian berdasarkan loket_id
     * @return \ANAntrianT
     */
    protected function loadModelAntrian($loket_id) {
        $criteria = new CDbCriteria();
        $criteria->compare("DATE(tglantrian)", date("Y-m-d"));
//        $criteria->addCondition("pendaftaran_id IS NULL");
        $criteria->addCondition("panggil_flaq = TRUE");
        $criteria->addCondition("loket_id = " . $loket_id);
//        $criteria->order = "loket_id DESC, noantrian DESC"; //panggil terakhir
        $criteria->order = "jampanggil DESC"; //panggil terakhir
        $model = ANAntrianT::model()->find($criteria);
        return $model;
    }

    /**
     * cari antrian berdasarkan loket_id
     * @return \ANAntrianT
     */
    protected function loadModelAntrianById($loket_id, $antrian_id) {
        $criteria = new CDbCriteria();
        $criteria->compare("DATE(tglantrian)", date("Y-m-d"));
//        $criteria->addCondition("pendaftaran_id IS NULL");
        $criteria->compare("loket_id", $loket_id);
        $criteria->compare("antrian_id", $antrian_id);
//        $criteria->order = "loket_id DESC, noantrian DESC"; //panggil terakhir
        $criteria->order = "jampanggil DESC"; //panggil terakhir
        $model = ANAntrianT::model()->find($criteria);
        return $model;
    }

    /**
     * suara panggilan MULTI no antrian (array) dan loket (array)
     * akses dengan ajax
     */
    public function actionSuaraPanggilanPendaftaran() {
        if (Yii::app()->request->isAjaxRequest) {
            $this->layout = "//layouts/iframe";
            $noantrians = $_POST["noantrians"];
            $loket_ids = $_POST["loket_ids"];
            $modelantrian_singkatans = $_POST["modelantrian_singkatan"];
            $modLokets = array();
            if (count($loket_ids) > 0) {
                foreach ($loket_ids AS $i => $loket_id) {
                    $modLokets[$i] = ANLoketM::model()->findByPk($loket_id);
                }
            }
            $data["suarapanggilan"] = $this->renderPartial('suaraPanggilanPendaftaran', array('noantrians' => $noantrians, 'modLokets' => $modLokets, 'modelantrian_singkatans' => $modelantrian_singkatans), true);
            echo CJSON::encode($data);
        }
        Yii::app()->end();
    }
    
    /**
     * suara panggilan MULTI no antrian (array) dan loket (array)
     * akses dengan ajax
     */
    public function actionSuaraPanggilan() {
        if (Yii::app()->request->isAjaxRequest) {
            $this->layout = "//layouts/iframe";
            $noantrians = $_POST["noantrians"];
            $loket_ids = $_POST["loket_ids"];
            $modelantrian_singkatans = $_POST["modelantrian_singkatan"];
            $modLokets = array();
            if (count($loket_ids) > 0) {
                foreach ($loket_ids AS $i => $loket_id) {
                    $modLokets[$i] = ANLoketM::model()->findByPk($loket_id);
                }
            }
            $data["suarapanggilan"] = $this->renderPartial('suaraPanggilan', array('noantrians' => $noantrians, 'modLokets' => $modLokets, 'modelantrian_singkatans' => $modelantrian_singkatans), true);
            echo CJSON::encode($data);
        }
        Yii::app()->end();
    }

    /**
     * suara panggilan SATU no antrian dal loket
     * akses dengan iframe
     */
    public function actionSuaraPanggilanSingle($noantrian, $loket_id) {
        $this->layout = '//layouts/antrian';
        $modLoket = LoketM::model()->findByPk($loket_id);
        $noantrian_split = str_split($noantrian);
        $this->render("suaraPanggilan", array("noantrian" => $noantrian, "modLoket" => $modLoket, "noantrian_split" => $noantrian_split));
    }

}
