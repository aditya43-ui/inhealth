<?php

/**
 * This is the model class for table "jenispenerimaan_m".
 *
 * The followings are the available columns in table 'jenispenerimaan_m':
 * @property integer $jenispenerimaan_id
 * @property string $jenispenerimaan_kode
 * @property string $jenispenerimaan_nama
 * @property string $jenispenerimaan_namalain
 * @property string $jenispenerimaan_aktif
 */
class KUJenispenerimaanM extends JenispenerimaanM
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return JenispenerimaanM the static model class
	 */
        public $rekDebit, $rekKredit;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function searchPrint()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$criteria->compare('jenispenerimaan_id',$this->jenispenerimaan_id);
		$criteria->compare('LOWER(jenispenerimaan_kode)',strtolower($this->jenispenerimaan_kode),true);
		$criteria->compare('LOWER(jenispenerimaan_nama)',strtolower($this->jenispenerimaan_nama),true);
		$criteria->compare('LOWER(jenispenerimaan_namalain)',strtolower($this->jenispenerimaan_namalain),true);
		//$criteria->compare('jenispenerimaan_aktif',$this->jenispenerimaan_aktif);
		$criteria->compare('jenispenerimaan_aktif',isset($this->jenispenerimaan_aktif)?$this->jenispenerimaan_aktif:true);
		// Klo limit lebih kecil dari nol itu berarti ga ada limit 
		$criteria->limit=-1; 

		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
				'pagination'=>false,
		));
	}
	
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('jenispenerimaan_id',$this->jenispenerimaan_id);
		$criteria->compare('LOWER(jenispenerimaan_kode)',strtolower($this->jenispenerimaan_kode),true);
		$criteria->compare('LOWER(jenispenerimaan_nama)',strtolower($this->jenispenerimaan_nama),true);
		$criteria->compare('LOWER(jenispenerimaan_namalain)',strtolower($this->jenispenerimaan_namalain),true);
		//$criteria->compare('jenispenerimaan_aktif',$this->jenispenerimaan_aktif);
		$criteria->compare('jenispenerimaan_aktif',isset($this->jenispenerimaan_aktif)?$this->jenispenerimaan_aktif:true);
//                $criteria->addCondition('jenispenerimaan_aktif is true');

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

}