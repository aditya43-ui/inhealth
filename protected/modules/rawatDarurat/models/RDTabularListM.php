<?php

/**
 * This is the model class for table "tabularlist_m".
 *
 * The followings are the available columns in table 'tabularlist_m':
 * @property integer $tabularlist_id
 * @property string $tabularlist_chapter
 * @property string $tabularlist_block
 * @property string $tabularlist_title
 * @property string $tabularlist_revisi
 * @property string $tabularlist_versi
 * @property boolean $tabularlist_aktif
 */
class RDTabularListM extends TabularlistM
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TabularlistM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public function searchRJ()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		if(!empty($this->tabularlist_id)){
			$criteria->addCondition("tabularlist_id = ".$this->tabularlist_id);				
		}
		$criteria->compare('LOWER(tabularlist_chapter)',strtolower($this->tabularlist_chapter),true);
		$criteria->compare('LOWER(tabularlist_block)',strtolower($this->tabularlist_block),true);
		$criteria->compare('LOWER(tabularlist_title)',strtolower($this->tabularlist_title),true);
		$criteria->compare('LOWER(tabularlist_revisi)',strtolower($this->tabularlist_revisi),true);
		$criteria->compare('LOWER(tabularlist_versi)',strtolower($this->tabularlist_versi),true);
		$criteria->compare('tabularlist_aktif',TRUE);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                         'pagination'=>array(
	            'pageSize'=>10,
	        ),
		));
	}


}