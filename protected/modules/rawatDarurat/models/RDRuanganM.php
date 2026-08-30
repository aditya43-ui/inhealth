<?php

class RDRuanganM extends TindakanruanganM
{
    public $daftartindakan_id,$instalasi_nama,$ruangan_nama,$ruangan_aktif;

    /**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TabularlistM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
	public function searchPrint()
	{
			// Warning: Please modify the following code to remove attributes that
			// should not be searched.

			$criteria=new CDbCriteria;
			if(!empty($this->ruangan_id)){
				$criteria->addCondition("ruangan_id = ".$this->ruangan_id);				
			}
			if(!empty($this->daftartindakan_id)){
				$criteria->addCondition("daftartindakan_id = ".$this->daftartindakan_id);				
			}
			// Klo limit lebih kecil dari nol itu berarti ga ada limit 
			$criteria->limit=-1; 

			return new CActiveDataProvider($this, array(
					'criteria'=>$criteria,
					'pagination'=>false,
			));
	}
                

}