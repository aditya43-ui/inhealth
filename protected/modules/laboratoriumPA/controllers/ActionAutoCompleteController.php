<?php
/**
 * RND-7811 : INI SUDAH TIDAK DIGUNAKAN LAGI, FUNCTION PINDAHKAN KE CONTROLLER MASING2
 */
class ActionAutoCompleteController extends MyAuthController
{
    /**
     * actionDaftarPasien = menampilkan pasien dari noRM atau namaPasien
     */
    public function actionDaftarPasien()
    {
        if(Yii::app()->request->isAjaxRequest) {
                $criteria = new CDbCriteria();
                if(!empty($_GET['noRm']))
                    $criteria->compare('LOWER(no_rekam_medik)', strtolower($_GET['noRm']), true);
                else if (!empty($_GET['namaPasien']))
                    $criteria->compare('LOWER(nama_pasien)', strtolower($_GET['namaPasien']), true);
                $criteria->addCondition('ruangan_id = '.Yii::app()->user->getState('ruangan_id'));
                $criteria->order = 'tglmasukpenunjang ASC';
                $criteria->limit = 10;
                $models = LBPasienMasukPenunjangV::model()->findAll($criteria);
                $returnVal = array();
                foreach($models as $i=>$model)
                {
                    $attributes = $model->attributeNames();
                    foreach($attributes as $j=>$attribute) {
                        $returnVal[$i]["$attribute"] = $model->$attribute;
                    }
                    $returnVal[$i]['label'] = $model->no_rekam_medik.' - '.$model->nama_pasien.' - '.$model->jeniskelamin;
                    $returnVal[$i]['value'] = $model->no_rekam_medik;
                }

                echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }
    
    function actionGetNamaDaftarTindakan(){
        if(Yii::app()->request->isAjaxRequest) {
                $criteria = new CDbCriteria();
                $criteria->compare('LOWER(pemeriksaanlab_nama)', strtolower($_GET['term']), true);
//                $criteria->addCondition('ruangan_id = '.Params::RUANGAN_ID_LAB);
                //$criteria->order = 'tglmasukpenunjang DESC';
                //$models = PasienmasukpenunjangV::model()->findAll($criteria);
                $model = PemeriksaanlabM::model()->findAll($criteria);
                $data = array();
                foreach($model as $i=>$models)
                {
                    $attributes = $models->attributeNames();
                    foreach($attributes as $j=>$attribute) {
                        $data[$i]['label'] = $models->pemeriksaanlab_nama;
                        $data[$i]['value'] = $models->pemeriksaanlab_nama;
                        $data[$i]["$attribute"] = $models->$attribute;
                    }
                }

                echo json_encode($data);
        }
        Yii::app()->end();
    }
    
    function actionGetKodeDaftarTindakan(){
        if(Yii::app()->request->isAjaxRequest) {
                $criteria = new CDbCriteria();
                $criteria->compare('LOWER(pemeriksaanlab_kode)', strtolower($_GET['term']), true);
//                $criteria->addCondition('ruangan_id = '.Params::RUANGAN_ID_LAB);
                //$criteria->order = 'tglmasukpenunjang DESC';
                //$models = PasienmasukpenunjangV::model()->findAll($criteria);
                $modelTindakan = PemeriksaanlabM::model()->findAll($criteria);
                $returnTindakan = array();
                foreach($modelTindakan as $i=>$tindakan)
                {
                    $attributes = $tindakan->attributeNames();
                    foreach($attributes as $j=>$attribute) {
                        $returnTindakan[$i]['label'] = $tindakan->pemeriksaanlab_kode." - ".$tindakan->pemeriksaanlab_nama;
                        $returnTindakan[$i]['value'] = $tindakan->pemeriksaanlab_kode;
                        $returnTindakan[$i]["$attribute"] = $tindakan->$attribute;
                    }
                }

                echo CJSON::encode($returnTindakan);
        }
        Yii::app()->end();
    }
}
?>
