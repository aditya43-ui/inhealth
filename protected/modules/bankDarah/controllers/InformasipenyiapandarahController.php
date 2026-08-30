<?php

/**
 * Digunakan untuk menampilkan Informasi Penyerahan Darah
 * @author Soleh Mulyana <solehmulyana.@gmail.com>
 * @package application.modules.bankDarah
 * @subpackage controllers
 */
class InformasipenyiapandarahController extends MyAuthController
{
    function actionIndex() {
        $format = new MyFormatter();
        $model = new InformasipenyiapandarahV('searchInfromasi');
        $model->tgl_awal = date('Y-m-d');
        $model->tgl_akhir = date('Y-m-d');

        if(isset($_GET['InformasipenyiapandarahV'])) {
            $model->attributes = $_GET['InformasipenyiapandarahV'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['InformasipenyiapandarahV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['InformasipenyiapandarahV']['tgl_akhir']);
        }

        if(Yii::app()->request->isAjaxRequest) {
            if(isset($_GET['ajax']) && $_GET['ajax'] == 'permintaandarah-r-grid') {
                $this->renderPartial('_table', ['model' => $model]);
                Yii::app()->end();
            }
        }
        $this->render('index', ['model' => $model]);
    }

    function actionSetRuangan() {
        $instalasi_id = $_POST['instalasi_id'];
        $models = CHtml::listData(RuanganM::getRuanganByInstalasi($instalasi_id),'ruangan_id','ruangan_nama');

            
       
        $option = CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
        
        
        if(count((array)$models) > 0){
            foreach($models as $value=>$name){
                $option .= CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
            }
        }

        echo json_encode(['option' => $option]);
    }
}