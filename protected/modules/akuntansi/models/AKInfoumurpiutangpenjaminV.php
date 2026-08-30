<?php

class AKInfoumurpiutangpenjaminV extends InfoumurpiutangpenjaminV
{
        public $tgl_awal, $tgl_akhir;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return KursrpM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public function searchInformasi()
        {
            $criteria = new CDbCriteria();
            $criteria->addBetweenCondition("tglpengajuanklaimanklaim", $this->tgl_awal.' 00:00:00', $this->tgl_akhir.' 23:59:59');
            if (!empty($this->carabayar_id)){
                $criteria->addCondition("carabayar_id = '".$this->carabayar_id."' ");
            }
            
            if (!empty($this->penjamin_id)){
                $criteria->addCondition("penjamin_id = '".$this->penjamin_id."' ");
            }            
            $criteria->compare("LOWER(nopengajuanklaimanklaim)", strtolower($this->nopengajuanklaimanklaim), TRUE);
            $criteria->order = "tglpengajuanklaimanklaim DESC";
            
            return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
            ));
        }

}

?>