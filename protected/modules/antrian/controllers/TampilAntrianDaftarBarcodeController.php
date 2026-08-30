<?php

class TampilAntrianDaftarBarcodeController extends Controller {

    public $layout = '//layouts/kiosAntrian';
    public $defaultAction = 'index';

    public function actionIndex($start = 0,$end = 6) {
        $this->pageTitle = Yii::app()->name . " - Tampil Antrian Ke Lantai 2";

        $loket = LoketpendaftaranpoliM::listLoket($start, $end);

        $this->render('indexNew', array(
            'loket' => $loket,
            'start' => $start
        ));
    }

    public function actionRefreshLoket(){
        if (!Yii::app()->request->isAjaxRequest){
            exit;
        }
        
        $loketId = isset($_GET['loket'])?$_GET['loket']:null;
        $nomor = isset($_GET['nomor'])?$_GET['nomor']:null;
        
        $loket = LoketM::model()->findByPk($loketId);
        
        $cri = new CDbCriteria;
        $cri->select = [
            'lpad(t.noantrian, 5, \'0\') as noantrian_pad',
            't.noantrian',
            't.modelantrian_id',
            'r.ruangan_singkatan',
            'l.loket_nama',
            'l.loket_singkatan',
            'l.loket_nourut',
            'ma.modelantrian_singkatan'
        ];
        $cri->join = "JOIN ruangan_m r ON r.ruangan_id = t.ruangan_id 
            JOIN loket_m l ON l.loket_id = t.loket_id 
            JOIN modelantrian_m ma ON ma.modelantrian_id = t.modelantrian_id
        ";
        $cri->addCondition(" t.jam_panggil IS NOT NULL AND (t.status_barcode is null OR t.status_barcode = '' OR t.status_barcode = '".ParamsConst::STATUSBARCODE_ANTRIAN_BELUMBARCODE."' ) ");
        $cri->addCondition("t.loket_id = ".$loketId." AND DATE(tglantrian) = '".date('Y-m-d')."' ");
        $cri->order = "1, l.loket_nourut DESC,ma.modelantrian_singkatan ASC,r.ruangan_singkatan ASC,t.noantrian ASC";

        $list1 = AntrianT::model()->count($cri);

        $cri1 = clone $cri;
        $cri1->limit = 18;
        $cri1->offset = $list1 - 18;

        // echo '<pre>'; var_dump($cri); die;
        $list = AntrianT::model()->findAll($cri1);
        
        $html = $this->renderPartial('antrian/_list',['i'=>$nomor,'loket'=>$loket->loket_singkatan,'model'=>$list,'loketId'=>$loketId], true);                
        
        echo json_encode([
            'html' => $html
        ]);
    }
}
