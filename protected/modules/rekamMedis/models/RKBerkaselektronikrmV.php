<?php


class RKBerkaselektronikrmV extends BerkaselektronikrmV
{	
        public $tgl_awal, $tgl_akhir;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        
        public function searchInformasi(){          	
            $criteria=new CDbCriteria;
            $criteria->select ='pasien_id,nama_pasien,no_rekam_medik';
            $criteria->addBetweenCondition('DATE(dokfilerm_tgl)', $this->tgl_awal, $this->tgl_akhir);
            $criteria->group ='pasien_id,nama_pasien,no_rekam_medik';
            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
	
        }
}