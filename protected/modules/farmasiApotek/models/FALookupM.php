<?php
class FALookupM extends LookupM
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LookupM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search($params = null)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		if(!empty($params)){
			$criteria->compare('LOWER(lookup_type)',strtolower($params),true);
		}
		$criteria->compare('lookup_id',$this->lookup_id);
		$criteria->compare('LOWER(lookup_type)',strtolower($this->lookup_type),true);
		$criteria->compare('LOWER(lookup_name)',strtolower($this->lookup_name),true);
		$criteria->compare('LOWER(lookup_value)',strtolower($this->lookup_value),true);
		$criteria->compare('lookup_urutan',$this->lookup_urutan);
		$criteria->compare('lookup_kode',$this->lookup_kode,true);

		$criteria->compare('lookup_aktif',$this->lookup_aktif);
		//$criteria->addCondition('lookup_aktif is true');
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function searchPrint($params = null)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		if(!empty($params)){
			$criteria->compare('LOWER(lookup_type)',strtolower($params),true);
		}
		$criteria->compare('lookup_id',$this->lookup_id);
		$criteria->compare('LOWER(lookup_type)',strtolower($this->lookup_type),true);
		$criteria->compare('LOWER(lookup_name)',strtolower($this->lookup_name),true);
		$criteria->compare('LOWER(lookup_value)',strtolower($this->lookup_value),true);
		$criteria->compare('lookup_urutan',$this->lookup_urutan);
		$criteria->compare('lookup_kode',$this->lookup_kode,true);
		//$criteria->compare('lookup_aktif',$this->lookup_aktif);
		$criteria->compare('lookup_aktif',isset($this->lookup_aktif)?$this->lookup_aktif:true);
		$criteria->limit = -1;

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>false,
		));
	}
        
}