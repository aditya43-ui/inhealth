<?php
class PPKamarruanganM extends KamarruanganM {

    public static function model($class=__CLASS__){
        return parent::model($class);
    }
    
    public function getKelasPelayananRuanganItems()
        {
            return PPKelaspelayananM::model()->findAll(array('order'=>'kelaspelayanan_nama'));
        }
        
        public function getKamarNoKamarItems()
        {
            return PPKamarruanganM::model()->with('ruangan')->findAll('t.ruangan_id='.Yii::app()->user->getState('ruangan_id').'');
          
        }
        
        public function getRuanganItems($instalasi = Params::INSTALASI_ID_RI)
        {
            return PPRuanganM::model()->findAll('instalasi_id='. $instalasi .' AND ruangan_aktif=TRUE ORDER BY ruangan_nama');
            
        }

}
?>
