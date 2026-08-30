<?php

class TampilAntrianKeLantai2Controller extends Controller {

    public $layout = '//layouts/antrian';
    public $defaultAction = 'index';

    public function actionIndex() {


          if (Yii::app()->request->isAjaxRequest){
            if (isset($_GET['ajax'])){
                $ajax = $_GET['ajax'];
                if ($ajax == 'form-list-antrian'){
                    $path = $this->pathView_umum_asuransi.'antrian/_list';

                    $this->renderPartial($path,[]);
                    exit;
                }
            }
        }

        $this->pageTitle = Yii::app()->name . " - Tampil Antrian Ke Lantai 2";
        $this->render('index', array(
            
        ));
    }

    public function actionListAntrianDipanggil(){
        if (!Yii::app()->request->isAjaxRequest){
            
            exit;
        }
        
        $antrianId = isset($_GET['antrianId'])?$_GET['antrianId']:null;
        
        $cri = new CDbCriteria;
        $cri->select = [
            'j.modelantrian_id',
            't.noantrian',
            'r.ruangan_singkatan',
            'l.loket_nama',
            'l.loket_singkatan',
            'j.modelantrian_singkatan',
            't.jenis_kunjungan',
            't.antrian_id',
        ];
        $cri->join = "JOIN ruangan_m r ON r.ruangan_id = t.ruangan_id 
            JOIN loket_m l ON l.loket_id = t.loket_id 
            JOIN modelantrian_m j ON j.modelantrian_id = t.modelantrian_id 
        ";
//        $cri->addCondition(" jam_panggil IS NOT NULL ");
        $cri->addInCondition("antrian_id",$antrianId);
        $cri->order = " t.jenis_kunjungan, t.noantrian::integer ASC ";
        // $cri->order = " jam_panggil ASC, noantrian::integer ASC ";
        $list = AntrianT::model()->findAll($cri);

        $html = '';
        $listantrian = [];
       
        foreach($list as $key => $val){
            $is_fasttrack = false;
            if ($val->jenis_kunjungan == ParamsConst::JENIS_KUNJUNGAN_ANTRIAN_FASTTRACK){
                $is_fasttrack = true;
            }
            $html .= $this->renderPartial('antrian/_list',['model'=>$val,'i'=>$key, 'is_fasttrack'=>$is_fasttrack], true);
            
            if (is_numeric(($val->loket_singkatan))){
                $suaraLoketSingkatan = MyFormatter::formatNumberTerbilang((int)$val->loket_singkatan);
            }else{
                $suaraLoketSingkatan = implode(' ',str_split($val->loket_singkatan));
            }

            if($val->noantrian >= 12) {
                $suaraAntrian = MyFormatter::formatNumberTerbilang((int)$val->noantrian);
            } else {
                $suaraAntrian = $val->noantrian;
            }
            
            $listantrian[$val->antrian_id] = [
                'ruangan_singkatan' => ($val->modelantrian_id == 1) ? $val->modelantrian_singkatan : $val->ruangan_singkatan,
                'noantrian' => $suaraAntrian,
                'loket_singkatan' => $suaraLoketSingkatan,
                'antrianId' => $val->antrian_id
            ];
        }         
        
        echo json_encode([
            'html' => $html,
            'listantrian' => $listantrian
        ]);
    }
}
