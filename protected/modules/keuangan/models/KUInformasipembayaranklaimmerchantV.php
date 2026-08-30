<?php
class KUInformasipembayaranklaimmerchantV extends InformasipembayaranklaimmerchantV
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InformasipembayaranklaimmerchantV the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function searchInformasi()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=$this->criteriaSearch();
		$criteria->addBetweenCondition('date(tglpembayaranklaim)',$this->tgl_awal,$this->tgl_akhir,true);
		$criteria->limit=10;

		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
		));
	}
	
}