<?php
class ASDatapenunjangT extends DatapenunjangT
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function searchPrint($pengkajianaskep_id)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('datapenunjang_id',$this->datapenunjang_id);
		$criteria->addCondition('pengkajianaskep_id ='.$pengkajianaskep_id);
		$criteria->compare('datapenunjang_tgl',$this->datapenunjang_tgl,true);
		$criteria->compare('datapenunjang_nama',$this->datapenunjang_nama,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}