<?php
class AKPajakM extends PajakM
{
    public $rekening5_nama;
    
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return BankM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function searchMaster()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
                $criteria->join = "JOIN rekening5_m ON rekening5_m.rekening5_id = t.rekening5_id";
		$criteria->compare('LOWER(t.pajak_nama)', strtolower($this->pajak_nama),true);
		$criteria->compare('LOWER(t.pajak_namalain)', strtolower($this->pajak_namalain),true);
		$criteria->compare('t.pajak_aktif',$this->pajak_aktif);
		$criteria->compare('LOWER(t.keterangan)',strtolower($this->keterangan),true);
		$criteria->compare('rekening5_m.nmrekening5',$this->rekening5_nama);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public function searchPrint()
	{

            $criteria=new CDbCriteria;
            $criteria->join = "JOIN rekening5_m ON rekening5_m.rekening5_id = t.rekening5_id";
            $criteria->compare('LOWER(t.pajak_nama)', strtolower($this->pajak_nama),true);
            $criteria->compare('LOWER(t.pajak_namalain)', strtolower($this->pajak_namalain),true);
            $criteria->compare('t.pajak_aktif',$this->pajak_aktif);
            $criteria->compare('LOWER(t.keterangan)',strtolower($this->keterangan),true);
            $criteria->compare('rekening5_m.nmrekening5',$this->rekening5_nama);

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
                'pagination'=>false
            ));
	}
        
}

?>