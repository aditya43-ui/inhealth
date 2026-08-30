<?php
class PCObatalkesdetailM extends ObatalkesdetailM {
	public $obatalkes_nama;
	public $obatalkes_aktif;
	public $keluhan;
	public $hasilevaluasi;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ObatalkesdetailM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function search(){
		$criteria=new CDbCriteria;

		$criteria->compare('obatalkesdetail_id',$this->obatalkesdetail_id);
		$criteria->compare('obatalkes_id',$this->obatalkes_id);
		$criteria->compare('LOWER(indikasi)',strtolower($this->indikasi),true);
		$criteria->compare('LOWER(kontraindikasi)',strtolower($this->kontraindikasi),true);
		$criteria->compare('LOWER(komposisi)',strtolower($this->komposisi),true);
		$criteria->compare('LOWER(efeksamping)',strtolower($this->efeksamping),true);
		$criteria->compare('LOWER(interaksiobat)',strtolower($this->interaksiobat),true);
		$criteria->compare('LOWER(carapenyimpanan)',strtolower($this->carapenyimpanan),true);
		$criteria->compare('LOWER(peringatan)',strtolower($this->peringatan),true);
		$criteria->limit = 10;
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
}