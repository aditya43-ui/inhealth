<?php

Yii::import('application.modules.rawatInap.controllers.PasienRawatInapController');
Yii::import('application.modules.rawatInap.models.*');
Yii::import('application.controllers.*');

class AkomodasiCommand extends CConsoleCommand {
    
    public function actionIndex() {
        $konfig = KonfigsystemK::model()->find();
        
        if ($konfig->akomodasiotomatis == true) {
            
            $trans = Yii::app()->db->beginTransaction();
            
            try {
                $cr_admisi = new CDbCriteria;
                $cr_admisi->join = "join pendaftaran_t p on p.pasienadmisi_id = t.pasienadmisi_id";
                $cr_admisi->addCondition('t.pasienpulang_id is null');



                foreach ($admisi as $item) {

                    $bayar = PembayaranpelayananT::model()->countByAttributes(array(
                        'pasienadmisi_id'=>$item->pasienadmisi_id
                    ));

                    if (empty($bayar)) {
                        continue;
                    }

                    PasienRawatInapController::saveAkomodasi($item->pendaftaran, $item);
                    echo $item->pasienadmisi_id." : DONE\n";
                }

                $trans->commit();
                
            } catch (Exception $ex) {
                
                $trans->rollback();
                echo "\n\n";
                echo "ERROR : ".$ex->getMessage()."\n";
                var_dump($ex->getTraceAsString());
            }
            
        }
    }
    
}
