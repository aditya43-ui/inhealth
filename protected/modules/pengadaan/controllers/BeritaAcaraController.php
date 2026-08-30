<?php

/**
 * Transaksi berita acara
 * 
 * @author Tantowi J <tantowijaya@.com>
 * @package application.modules.pengadaan
 * @subpackage controllers
 * @category controller
 */
class BeritaAcaraController extends MyAuthController {

    /**
     * Defaulr menu transaksi
     * @param integer $id
     */
    public function actionIndex($id = null) {
        $model = new SuratperjanjiankerjaT;

        $this->render('index', array('model' => $model));
    }

    /**
     * Auto complete SPK
     */
    public function actionAutocompleSPK() {
        if (Yii::app()->request->isAjaxRequest) {
            $criteria = new CDbCriteria();
            $criteria->compare('LOWER(nosuratperjanjiankerja)', strtolower($_GET['term']), true);
            $criteria->order = 'nosuratperjanjiankerja';
            $criteria->addCondition('isbatal is false');
            $criteria->limit = 5;
            $models = SuratperjanjiankerjaT::model()->findAll($criteria);
            
            $returnVal = array();

            foreach ($models as $i => $model) {
                $attributes = $model->attributeNames();
                foreach ($attributes as $j => $attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = $model->nosuratperjanjiankerja . ' - ' . MyFormatter::formatDateTimeForUser($model->tglsuratperjanjian);
                $returnVal[$i]['value'] = $model->suratperjanjiankerja_id;
                if(!empty($model->supplier_id)){
                    $modSupplier = SupplierM::model()->findByPk($model->supplier_id);
                    $attribute2 = $modSupplier->attributeNames();
                    foreach ($attribute2 as $j => $attribute2) {
                        $returnVal[$i]["$attribute2"] = $modSupplier->$attribute2;
                    }
                }
                if($model->istermin == true){
                    $cekTermin = SuratperjanjiankerjaterminT::model()->findAllByAttributes(array('suratperjanjiankerja_id'=>$model->suratperjanjiankerja_id));
                    if(!empty($cekTermin)){
                        $termin = array();
                        foreach ($cekTermin as $value){
                            $termin[] = $value->jumlah_persen;
                        }
                        $returnVal[$i]["termin"] = implode( ' - ', $termin );
                    }else{
                        $returnVal[$i]['termin'] = 'Non Termin';
                    }
                }else{
                    $returnVal[$i]['termin'] = 'Non Termin';
                }
            }

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }

}
