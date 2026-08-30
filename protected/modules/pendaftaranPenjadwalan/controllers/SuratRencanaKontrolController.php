<?php

Yii::import('rawatJalan.models.*');
Yii::import('rawatJalan.controllers.DaftarPasienController');

class SuratRencanaKontrolController extends MyAuthController {

    public $pathView = 'pendaftaranPenjadwalan.views.suratRencanaKontrol.';
    public function actionIndex() {        
      
        if (Yii::app()->request->isAjaxRequest){
            if (isset($_GET['ajax'])){
                $ajax = $_GET['ajax'];
                                
                if ($ajax == 'datakunjungan-grid')
                    $path = $this->pathView.'grid/_daftar_pasien_rjrdri';                                
                
                $this->renderPartial($path);
            }else{
                if (isset($_GET['jenis'])){
                    $this->getDataInfoPasien();
                }else{
                    $format = new MyFormatter();
                    $returnVal = array();
                    $no_rekam_medik = isset($_GET['no_rekam_medik']) ? $_GET['no_rekam_medik'] : null;
                    $nama_pasien = isset($_GET['nama_pasien']) ? $_GET['nama_pasien'] : null;
                    $insId = $_GET['instalasi_id'];

                    $load = new InfokunjunganrdV('searchDialogKunjungan');
                    $load->unsetAttributes();
                    $load->instalasi_id = $insId;
                    $load->no_rekam_medik = $no_rekam_medik;
                    $load->nama_pasien = $nama_pasien;            

                    $models = $load->searchDialogKunjunganForSRK();            

                    foreach ($models->getData() as $i => $model) {

                        $daftar = PendaftaranT::model()->findByPk($model->pendaftaran_id);
                        $asuransi = AsuransipasienM::model()->findByPk($daftar->asuransipasien_id);

                        $attributes = $model->attributeNames();
                        foreach ($attributes as $j => $attribute) {
                            $returnVal[$i]["$attribute"] = $model->$attribute;
                        }
                        $returnVal[$i]['label'] = $model->no_pendaftaran.' '.$model->nama_pasien;
                        $returnVal[$i]['value'] = $model->pendaftaran_id;
                        $returnVal[$i]['nokartuasuransi'] = empty($asuransi) ? "-" : $asuransi->nokartuasuransi;
                    }
                    echo CJSON::encode($returnVal);
                }
            }
            exit;
        }
                
        $modInfoKunjungan = new InfokunjunganrdV;        
                  
        $this->render($this->pathView.'buat', array(            
            'model' => $modInfoKunjungan,
        ));
    }    
    
    /**
     * Mengurai data pasien berdasarkan:
     * - instalasi_id
     * - pendaftaran_id
     * - pasienadmisi_id
     * - no_pendaftaran
     * - no_rekam_medik
     * @throws CHttpException
     */
    public function getDataInfoPasien() {
        $format = new MyFormatter();
        $modelSep = new ARSepT;
        $instalasi_id = isset($_POST['instalasi_id']) ? $_POST['instalasi_id'] : null;
        $pendaftaran_id = isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null;
        $pasienadmisi_id = isset($_POST['pasienadmisi_id']) ? $_POST['pasienadmisi_id'] : null;
        $no_pendaftaran = isset($_POST['no_pendaftaran']) ? $_POST['no_pendaftaran'] : null;
        $no_rekam_medik = isset($_POST['no_rekam_medik']) ? $_POST['no_rekam_medik'] : null;
        $returnVal = array();
        $criteria = new CDbCriteria();
        if (!empty($pendaftaran_id)) {
            $criteria->addCondition("pendaftaran_id = " . $pendaftaran_id);
        }
        if (!empty($pasienadmisi_id) && $pasienadmisi_id !== 'null') {
            $criteria->addCondition("pasienadmisi_id = " . $pasienadmisi_id);
        }
        $criteria->compare('LOWER(no_pendaftaran)', strtolower(trim($no_pendaftaran)));
        $criteria->compare('LOWER(no_rekam_medik)', strtolower(trim($no_rekam_medik)));
        if ($instalasi_id == Params::INSTALASI_ID_RD) {
            $model = InfokunjunganrdV::model()->find($criteria);
        }elseif ($instalasi_id == Params::INSTALASI_ID_RJ) {
            $model = InfokunjunganrjV::model()->find($criteria);
        } else if ($instalasi_id == Params::INSTALASI_ID_HD) {
            $model = InfokunjunganhdV::model()->find($criteria);
        } else if ($instalasi_id == Params::INSTALASI_ID_FISIOTERAPI) {
            $model = PasienmasukpenunjangV::model()->find($criteria);
        } else {
            $model = InfokunjunganriV::model()->find($criteria);
        }

        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
            $returnVal["$attribute"] = $model->$attribute;
        }
        $returnVal["tanggal_lahir"] = $format->formatDateTimeForUser($model->tanggal_lahir);
        $returnVal["tgl_pendaftaran"] = $format->formatDateTimeForUser($model->tgl_pendaftaran);
        $modpend = PendaftaranT::model()->findByPk($pendaftaran_id);
        $returnVal["instalasiasal_id"] = $modpend->instalasi_id;                        

        $modpasien = PasienM::model()->findByPk($modpend->pasien_id);
        $returnVal["no_mobile_pasien"] = $modpasien->no_mobile_pasien;
        
        echo CJSON::encode($returnVal);
    }

    public function actionSuratRJ($pendaftaran_id, $noSEP){
        $con = new DaftarPasienController('SuratRencanaKontrol', Yii::app()->getModule('pendaftaranPenjadwalan'));
        
        return $con->actionRencanaKontrolPasienRJ($pendaftaran_id, $noSEP);
    }
    
    public function actionVclaimCekRuangan(){
        $con = new DaftarPasienController('SuratRencanaKontrol', Yii::app()->getModule('pendaftaranPenjadwalan'));
        
        return $con->actionVclaimCekRuangan();
    }
    
    public function actionPrintRencanaKontrol($pendaftaran_id){
        $con = new DaftarPasienController('SuratRencanaKontrol', Yii::app()->getModule('pendaftaranPenjadwalan'));
        
        return $con->actionPrintRencanaKontrol($pendaftaran_id);
    }

    public function actionPrintRencanaKontrolBpjs($pendaftaran_id){
        $con = new DaftarPasienController('SuratRencanaKontrol', Yii::app()->getModule('pendaftaranPenjadwalan'));
        
        return $con->actionPrintRencanaKontrolBpjs();
    }

    public function actionGetLoadRiwayatSEP() {
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }

        $ok = 1;
        $msg = "";

        $nokartu = $_POST['nokartu'];
        $id = $_POST['id'];

        $bpjs = new BpjsVklaim;

        $konfig = KonfigsystemK::model()->find();
        $hari_riwayat = $konfig->bpjs_riwayatsep_hari ?? 90;
        $period = new DatePeriod(
            new DateTime(date('Y-m-d', strtotime('-'.$hari_riwayat.' days'))),
            new DateInterval('P30D'),
            new DateTime(date('Y-m-d'))
        );

        $res_histori = array();
        $tgl_histori = array();

        $terakhir = null;
        foreach ($period as $item) {
            $tgl_histori[] = $item->format('Y-m-d');
            $terakhir = $item->format('Y-m-d');
        }

        if (!empty($tgl_histori[count($tgl_histori) - 1]) && $tgl_histori[count($tgl_histori) - 1] != date('Y-m-d')) {
            $tgl_histori[] = date('Y-m-d');
        }
        $tgl_histori = array_reverse($tgl_histori);

        foreach ($tgl_histori as $idx => $item) {
            if (empty($tgl_histori[$idx + 1])) {
                continue;
            }

            $res_temp = CJSON::decode($bpjs->search_monitoring_historipelayanan($nokartu, $tgl_histori[$idx + 1], $tgl_histori[$idx]));
            if (!empty($res_temp['response']['histori'])) {
                $res_histori = array_merge($res_histori, $res_temp['response']['histori']);
            }
        }

        /*
        $res = CJSON::decode($bpjs->search_monitoring_historipelayanan($nokartu, '2015-01-01', date('Y-m-d')));

        if (empty($res) || empty($res['metaData']['code'])) {
            echo CJSON::encode(array(
                'ok'=>0,
                'msg'=>'Terjadi Kesalahan ketika melihat Riwayat SEP.',
                'html'=>'',
            ));
            Yii::app()->end();
        }

        if ($res['metaData']['code'] != 200) {
            echo CJSON::encode(array(
                'ok'=>0,
                'msg'=>'Error BPJS '.$res['metaData']['code']." - ".$res['metaData']['message'],
                'html'=>'',
            ));
            Yii::app()->end();
        }
        */

        $list = $res_histori; // $res['response']['histori'];
        $html = "";

        $cnt = 0;
        foreach ($list as $item) {
            $html .= $this->renderPartial($this->pathView."grid._rowSEP", array(
                'detail'=>$item, 'id'=>$id,
            ), true);
            $cnt++;
            if ($cnt >= 15) {
                break;
            }
        }

        echo CJSON::encode(array(
            'ok'=>1,
            'msg'=>'',
            'html'=>$html,
        ));


        // var_dump($res); die;
    }
}
