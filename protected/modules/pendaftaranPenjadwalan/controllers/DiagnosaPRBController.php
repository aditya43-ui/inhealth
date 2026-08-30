<?php

class DiagnosaPRBController extends MyAuthController {

    public function actionIndex() {

        // load data PRB
        $res_data = array();
        $bpjs = new BpjsVklaim();

        $res = $bpjs->list_diagnosa_prb();

        $res2 = CJSON::decode($res);
        
        if (isset($res2['metaData']['code']) && $res2['metaData']['code'] = 200) {
            $res_data = $res2['response']['list'];
        }


        // var_dump($res_data); die;

        $prov = new CArrayDataProvider($res_data, array(
            'id'=>'data_prb',
            'keyField'=>'kode'
        ));

        $this->render('index', array(
            'prov'=>$prov,
        ));


    }


    public function actionPrintData() {
		$this->layout='//layouts/printWindows';

        // load data PRB
        $res_data = array();
        $bpjs = new BpjsVklaim();

        $res = $bpjs->list_diagnosa_prb();

        $res2 = CJSON::decode($res);
        
        if (isset($res2['metaData']['code']) && $res2['metaData']['code'] = 200) {
            $res_data = $res2['response']['list'];
        }


        // var_dump($res_data); die;

        $prov = new CArrayDataProvider($res_data, array(
            'id'=>'data_prb',
            'keyField'=>'kode'
        ));

        $this->render('print', array(
            'prov'=>$prov,
        ));


    }

}