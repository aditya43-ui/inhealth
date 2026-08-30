<?php
class INInformasikamarinapV  extends InformasikamarinapV
{
	public static function model($className = __CLASS__) {
            return parent::model($className);
        }
        
        public function primaryKey() {
            return 'ruangan_id';
        }
}

