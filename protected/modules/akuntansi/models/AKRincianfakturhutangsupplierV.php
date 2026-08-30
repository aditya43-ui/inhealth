<?php
class AKRincianfakturhutangsupplierV extends RincianfakturhutangsupplierV
{
        public $tglAwal,$tglAkhir;
        public $saldodebit,$saldokredit;
		public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        /**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
         * digunakan di:
         * - akuntansi/actionAjax/GetRekeningPiutangSupplier
         */
        public function criteriaFunction(){
            $criteria=new CDbCriteria;

            $criteria->addBetweenCondition('t.tglfaktur::date',$this->tglAwal,$this->tglAkhir);
            $criteria->compare('LOWER(t.nofaktur)',strtolower($this->nofaktur),true);
            $criteria->compare('t.supplier_id',$this->supplier_id);
            $criteria->order = 't.tglfaktur asc';

            $criteria->limit = 500; //batas maksimal data
            return $criteria;
        }
        
        public function searchInformasi()
	{
            $criteria=new $this->criteriaFunction();

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
	}
}
?>