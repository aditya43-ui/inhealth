<?php

class AKInformasiumurpiutangpenjaminV extends InformasiumurpiutangpenjaminV
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
            $criteria->select = "tglpengajuanklaimanklaim, nopengajuanklaimanklaim, totalpiutang, lama_piutang, penjamin_nama, sum(totalbayar) as totalbayar";
            $criteria->group = "tglpengajuanklaimanklaim, nopengajuanklaimanklaim, totalpiutang, lama_piutang, penjamin_nama";
            $criteria->addBetweenCondition("date(tglpengajuanklaimanklaim)", $this->tgl_awal, $this->tgl_akhir);
            $criteria->compare("LOWER(nopengajuanklaimanklaim)", strtolower($this->nopengajuanklaimanklaim), TRUE);
//            $criteria->compare("LOWER(nama_pasien)", strtolower($this->nama_pasien), TRUE);
            
            if(!empty($this->penjamin_id)){
                $criteria->addCondition('penjamin_id = '.$this->penjamin_id);
            }
            $criteria->addCondition('pembayarklaim_id IS NULL');
            $criteria->order = "tglpengajuanklaimanklaim DESC";
            
            
            return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
            ));
        }

}

?>