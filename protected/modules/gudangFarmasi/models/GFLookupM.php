<?php
class GFLookupM extends LookupM
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public function attributeLabels()
	{
		return array(
			'lookup_id' => 'ID',
			'lookup_type' => 'Lookup Type',
			'lookup_name' => 'Nama',
			'lookup_value' => 'Nama Lain',
			'lookup_urutan' => 'Kode',
			'lookup_kode' => 'Dosis',
			'lookup_aktif' => 'Aktif',
		);
	}

	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		if(!empty($this->lookup_id)){
			$criteria->addCondition('lookup_id  = '.$this->lookup_id);
		}
		$criteria->compare('LOWER(lookup_type)',strtolower($this->lookup_type),true);
		$criteria->compare('LOWER(lookup_name)',strtolower($this->lookup_name),true);
		$criteria->compare('LOWER(lookup_value)',strtolower($this->lookup_value),true);
		$criteria->compare('LOWER(lookup_urutan)',strtolower($this->lookup_urutan),true);
		$criteria->compare('LOWER(lookup_kode)',strtolower($this->lookup_kode),true);
		$criteria->compare('lookup_aktif',$this->lookup_aktif);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function searchunitatc()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		if(!empty($this->lookup_id)){
			$criteria->addCondition('lookup_id  = '.$this->lookup_id);
		}
		$criteria->compare('lookup_aktif',$this->lookup_aktif);
		$criteria->compare('LOWER(lookup_type)','unitatc',true);
		$criteria->compare('LOWER(lookup_name)',strtolower($this->lookup_name),true);
		$criteria->compare('LOWER(lookup_value)',strtolower($this->lookup_value),true);
		$criteria->compare('LOWER(lookup_urutan)',strtolower($this->lookup_urutan),true);
		$criteria->compare('LOWER(lookup_kode)',strtolower($this->lookup_kode),true);
		

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	public function searchatcroa()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		if(!empty($this->lookup_id)){
			$criteria->addCondition('lookup_id  = '.$this->lookup_id);
		}
		$criteria->compare('lookup_aktif',$this->lookup_aktif);
		$criteria->compare('LOWER(lookup_type)','routeofadmatc',true);
		$criteria->compare('LOWER(lookup_name)',strtolower($this->lookup_name),true);
		$criteria->compare('LOWER(lookup_value)',strtolower($this->lookup_value),true);
		$criteria->compare('LOWER(lookup_urutan)',strtolower($this->lookup_urutan),true);
		$criteria->compare('LOWER(lookup_kode)',strtolower($this->lookup_kode),true);
		

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
	public function searchPrint()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		if(!empty($this->lookup_id)){
			$criteria->addCondition('lookup_id  = '.$this->lookup_id);
		}
		$criteria->compare('LOWER(lookup_type)',strtolower($this->lookup_type),true);
		$criteria->compare('LOWER(lookup_name)',strtolower($this->lookup_name),true);
		$criteria->compare('LOWER(lookup_value)',strtolower($this->lookup_value),true);
		$criteria->compare('LOWER(lookup_urutan)',strtolower($this->lookup_urutan),true);
		$criteria->compare('LOWER(lookup_kode)',strtolower($this->lookup_kode),true);
		$criteria->compare('lookup_aktif',$this->lookup_aktif);
		$criteria->limit = -1;

		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
				'pagination'=>false,
		));
	}
}