<?php
class RIInformasikamarinapV  extends InformasikamarinapV
{
	public static function model($className = __CLASS__) {
            return parent::model($className);
        }
        
        public function primaryKey() {
            return 'ruangan_id';
        }
        
        public function  getTarif($kelaspelayanan_id, $ruangan_id, $jenistarif_id)
        {
            $cr = new CDbCriteria();
            $cr->addCondition(" kelaspelayanan_id = '$kelaspelayanan_id'");
            $cr->addCondition(" ruangan_id = '$ruangan_id'");            
            $cr->addCondition(" kelompoktindakan_id = '".Params::KELOMPOKTINDAKAN_ID_AKOMODASI."'");
            $cr->addCondition(" jenistarif_id = '$jenistarif_id'");
            $tarif = TariftindakanperdaruanganV::model()->findAll($cr);
            
            return $tarif;
        }
              
        
       
}

