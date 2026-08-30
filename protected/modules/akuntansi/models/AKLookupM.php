<?php
class AKLookupM extends LookupM
{
        
        public $rekening_debit, $rekening_kredit, $rekDebit, $rekKredit;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LookupM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function searchCaraPembayaran()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('lookup_id',$this->lookup_id);
		$criteria->compare('LOWER(lookup_name)',strtolower($this->lookup_name),true);
		$criteria->compare('LOWER(lookup_value)',strtolower($this->lookup_value),true);
		$criteria->compare('LOWER(lookup_type)',strtolower($this->lookup_type),true);
		$criteria->compare('lookup_urutan',$this->lookup_urutan);
		$criteria->compare('LOWER(lookup_kode)',strtolower($this->lookup_kode),true);
		$criteria->compare('lookup_aktif',isset($this->lookup_aktif)?$this->lookup_aktif:true);
		$criteria->addCondition("lookup_type='carapembayaran' ");
		$criteria->order = 'lookup_type, lookup_urutan';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public function searchCaraPembayaranPrint()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('lookup_id',$this->lookup_id);
		$criteria->compare('LOWER(lookup_name)',strtolower($this->lookup_name),true);
		$criteria->compare('LOWER(lookup_value)',strtolower($this->lookup_value),true);
		$criteria->compare('LOWER(lookup_type)',strtolower($this->lookup_type),true);
		$criteria->compare('lookup_urutan',$this->lookup_urutan);
		$criteria->compare('LOWER(lookup_kode)',strtolower($this->lookup_kode),true);
		$criteria->compare('lookup_aktif',isset($this->lookup_aktif)?$this->lookup_aktif:true);
		$criteria->addCondition("lookup_type='carapembayaran' ");
                $criteria->limit = -1;
		$criteria->order = 'lookup_type, lookup_urutan';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination' => false
		));
	}
}