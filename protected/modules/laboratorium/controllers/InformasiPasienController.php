<?php
Yii::import('pendaftaranPenjadwalan.models.*');
class InformasiPasienController extends MyAuthController
{
    public $path_view = 'laboratorium.views.informasiPasien.';
    function actionListPasienRawatJalan() {
        $this->pageTitle = Yii::app()->name . " - Rawat Jalan";
        $format = new MyFormatter();
        $modRujukan = new RujukanT;
        $modInfoVerifikasiKunjuganRJ = new InfoverifikasirmkunjunganrjV('searchRJ');
        $modInfoVerifikasiKunjuganRJ->tgl_awal  = date('Y-m-d');
        $modInfoVerifikasiKunjuganRJ->tgl_akhir = date('Y-m-d');
        $modInfoVerifikasiKunjuganRJ->tgl_awall = date('Y-m-d');
        $modInfoVerifikasiKunjuganRJ->tgl_akhirl = date('Y-m-d');
        $modInfoVerifikasiKunjuganRJ->ceklis = false;
        if (isset($_REQUEST['InfoverifikasirmkunjunganrjV'])) {
        
            $modInfoVerifikasiKunjuganRJ->attributes = $_REQUEST['InfoverifikasirmkunjunganrjV'];
            $modInfoVerifikasiKunjuganRJ->ceklis = $_REQUEST['InfoverifikasirmkunjunganrjV']['ceklis'];
            $modInfoVerifikasiKunjuganRJ->carakeluar_id = $_REQUEST['InfoverifikasirmkunjunganrjV']['carakeluar_id'];
            $modInfoVerifikasiKunjuganRJ->kondisikeluar_id = $_REQUEST['InfoverifikasirmkunjunganrjV']['kondisikeluar_id'];
            $modInfoVerifikasiKunjuganRJ->tgl_awal = $format->formatDateTimeForDb($_REQUEST['InfoverifikasirmkunjunganrjV']['tgl_awal']);
            $modInfoVerifikasiKunjuganRJ->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['InfoverifikasirmkunjunganrjV']['tgl_akhir']);
            $modInfoVerifikasiKunjuganRJ->tgl_awall = $format->formatDateTimeForDb($_REQUEST['InfoverifikasirmkunjunganrjV']['tgl_awall']);
            $modInfoVerifikasiKunjuganRJ->tgl_akhirl = $format->formatDateTimeForDb($_REQUEST['InfoverifikasirmkunjunganrjV']['tgl_akhirl']);
            $modInfoVerifikasiKunjuganRJ->pegawai_id = $_GET['InfoverifikasirmkunjunganrjV']['pegawai_id'];
            $modInfoVerifikasiKunjuganRJ->is_verifikasidiagnosa = $_GET['InfoverifikasirmkunjunganrjV']['is_verifikasidiagnosa'];

            if (Yii::app()->request->isAjaxRequest){
                if(isset($_GET['ajax']) && $_GET['ajax'] == 'rawatJalan-grid') {
                $this->renderPartial($this->path_view . 'rawatJalan/_table', [
                    'modInfoVerifikasiKunjuganRJ' => $modInfoVerifikasiKunjuganRJ
                ]);
                Yii::app()->end();
                }
            }
        
        }
        $this->render($this->path_view . 'rawatJalan/index', array('format' => $format, 'modInfoVerifikasiKunjuganRJ' => $modInfoVerifikasiKunjuganRJ, 'modRujukan' => $modRujukan));
    }

    function actionListPasienRawatInap() {
        $this->pageTitle = Yii::app()->name . " - Rawat Inap";
        $format = new MyFormatter();
        $modPPInfoKunjunganRIV = new PPInfoKunjunganRIV;
        $modPPInfoKunjunganRIV->tgl_awal = date('Y-m-d');
        $modPPInfoKunjunganRIV->tgl_akhir = date('Y-m-d');
        $modPPInfoKunjunganRIV->tgl_awall = date('Y-m-d');
        $modPPInfoKunjunganRIV->tgl_akhirl = date('Y-m-d');
        $modPPInfoKunjunganRIV->ceklis = false;
        if (isset($_REQUEST['PPInfoKunjunganRIV'])) {
            $modPPInfoKunjunganRIV->attributes = $_REQUEST['PPInfoKunjunganRIV'];
            $modPPInfoKunjunganRIV->ceklis = $_REQUEST['PPInfoKunjunganRIV']['ceklis'];
            $modPPInfoKunjunganRIV->carakeluar_id = $_REQUEST['PPInfoKunjunganRIV']['carakeluar_id'];
            $modPPInfoKunjunganRIV->kondisikeluar_id = $_REQUEST['PPInfoKunjunganRIV']['kondisikeluar_id'];
            $modPPInfoKunjunganRIV->is_verifikasidiagnosa = $_REQUEST['PPInfoKunjunganRIV']['is_verifikasidiagnosa'];
            $modPPInfoKunjunganRIV->rujukandari_id = $_REQUEST['PPInfoKunjunganRIV']['rujukandari_id'];
            $modPPInfoKunjunganRIV->kamarruangan_id = $_REQUEST['PPInfoKunjunganRIV']['kamarruangan_id'];
            $modPPInfoKunjunganRIV->create_loginpemakai_id = $_REQUEST['PPInfoKunjunganRIV']['create_loginpemakai_id'];
            $modPPInfoKunjunganRIV->tgl_awal = isset($_REQUEST['PPInfoKunjunganRIV']['tgl_awal']) ? $format->formatDateTimeForDb($_REQUEST['PPInfoKunjunganRIV']['tgl_awal']) : null;
            $modPPInfoKunjunganRIV->tgl_akhir = isset($_REQUEST['PPInfoKunjunganRIV']['tgl_akhir']) ? $format->formatDateTimeForDb($_REQUEST['PPInfoKunjunganRIV']['tgl_akhir']) : null;
            $modPPInfoKunjunganRIV->tgl_awall = $format->formatDateTimeForDb($_REQUEST['PPInfoKunjunganRIV']['tgl_awall']);
            $modPPInfoKunjunganRIV->tgl_akhirl = $format->formatDateTimeForDb($_REQUEST['PPInfoKunjunganRIV']['tgl_akhirl']);
        }
        if(Yii::app()->request->isAjaxRequest) {
            if(isset($_GET['ajax']) && $_GET['ajax'] == 'rawatInap-grid') {
                $this->renderPartial($this->path_view . 'rawatInap/_table', ['modPPInfoKunjunganRIV' => $modPPInfoKunjunganRIV]);
                Yii::app()->end();
            }
        }
       
        $this->render($this->path_view . 'rawatInap/index', array('format' => $format, 'modPPInfoKunjunganRIV' => $modPPInfoKunjunganRIV));
    }

    function actionListPasienRawatDarurat() {
        $this->pageTitle = Yii::app()->name . " - Rawat Darurat";
        $format = new MyFormatter();
        $modInfoKunjunganRDV = new PPInfoKunjunganRDV;
        $modInfoKunjunganRDV->tgl_awal = date("Y-m-d");
        $modInfoKunjunganRDV->tgl_akhir = date("Y-m-d");
        $modInfoKunjunganRDV->tgl_awall = date('Y-m-d');
        $modInfoKunjunganRDV->tgl_akhirl = date('Y-m-d');
        $modInfoKunjunganRDV->ceklis = false;
        if (isset($_REQUEST['PPInfoKunjunganRDV'])) {
            $modInfoKunjunganRDV->attributes = $_REQUEST['PPInfoKunjunganRDV'];
            $modInfoKunjunganRDV->ceklis = $_REQUEST['PPInfoKunjunganRDV']['ceklis'];
            $modInfoKunjunganRDV->carakeluar_id = $_REQUEST['PPInfoKunjunganRDV']['carakeluar_id'];
            $modInfoKunjunganRDV->kondisikeluar_id = $_REQUEST['PPInfoKunjunganRDV']['kondisikeluar_id'];
            $modInfoKunjunganRDV->is_verifikasidiagnosa = $_REQUEST['PPInfoKunjunganRDV']['is_verifikasidiagnosa'];
            $modInfoKunjunganRDV->rujukandari_id = $_REQUEST['PPInfoKunjunganRDV']['rujukandari_id'];
            $modInfoKunjunganRDV->tgl_awal = $format->formatDateTimeForDb($_REQUEST['PPInfoKunjunganRDV']['tgl_awal']);
            $modInfoKunjunganRDV->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['PPInfoKunjunganRDV']['tgl_akhir']);
            $modInfoKunjunganRDV->tgl_awall = $format->formatDateTimeForDb($_REQUEST['PPInfoKunjunganRDV']['tgl_awall']);
            $modInfoKunjunganRDV->tgl_akhirl = $format->formatDateTimeForDb($_REQUEST['PPInfoKunjunganRDV']['tgl_akhirl']);
        }

        if(Yii::app()->request->isAjaxRequest) {
        if(isset($_GET['ajax']) && $_GET['ajax'] == 'rawatDarurat-grid') {
            $this->renderPartial($this->path_view . 'rawatDarurat/_table', ['modInfoKunjunganRDV' => $modInfoKunjunganRDV]);
            Yii::app()->end();
        }
        }
        $this->render($this->path_view . 'rawatDarurat/index', array(
            'format' => $format,
            'modInfoKunjunganRDV' => $modInfoKunjunganRDV,
            'model' => $modInfoKunjunganRDV
        ));
    }
}