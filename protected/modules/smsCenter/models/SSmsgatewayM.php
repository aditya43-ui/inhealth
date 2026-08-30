<?php

/**
 * This is the model class for table "smsgateway_m".
 *
 * The followings are the available columns in table 'smsgateway_m':
 * @property integer $smsgateway_id
 * @property integer $modul_id
 * @property string $tujuansms
 * @property string $jenissms
 * @property string $formatsms
 * @property integer $jmlkaraktersms
 * @property string $katawalsms
 * @property string $kataakhirsms
 * @property boolean $ishurufkapital
 * @property string $modcontroller
 * @property string $modaction
 * @property string $templatesms
 * @property boolean $statussms
 */
class SSmsgatewayM extends SmsgatewayM
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return SmsgatewayM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CdbCriteria that can return criterias.
	 */
	public function criteriaSearch()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		if(!empty($this->smsgateway_id)){
			$criteria->addCondition('smsgateway_id = '.$this->smsgateway_id);
		}
		if(!empty($this->modul_id)){
			$criteria->addCondition('modul_id = '.$this->modul_id);
		}
		$criteria->compare('LOWER(tujuansms)',strtolower($this->tujuansms),true);
		$criteria->compare('LOWER(jenissms)',strtolower($this->jenissms),true);
		$criteria->compare('LOWER(formatsms)',strtolower($this->formatsms),true);
		if(!empty($this->jmlkaraktersms)){
			$criteria->addCondition('jmlkaraktersms = '.$this->jmlkaraktersms);
		}
		$criteria->compare('LOWER(katawalsms)',strtolower($this->katawalsms),true);
		$criteria->compare('LOWER(kataakhirsms)',strtolower($this->kataakhirsms),true);
		$criteria->compare('ishurufkapital',$this->ishurufkapital);
		$criteria->compare('LOWER(modcontroller)',strtolower($this->modcontroller),true);
		$criteria->compare('LOWER(modaction)',strtolower($this->modaction),true);
		$criteria->compare('LOWER(templatesms)',strtolower($this->templatesms),true);
		$criteria->compare('statussms',$this->statussms);

		return $criteria;
	}
        
        
        /**
         * Retrieves a list of models based on the current search/filter conditions.
         * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
         */
        public function searchDialog()
        {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=$this->criteriaSearch();
            $criteria->limit=10;

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
        }
        
        /**
         * Retrieves a list of models based on the current search/filter conditions.
         * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
         */
        public function search()
        {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=$this->criteriaSearch();
            $criteria->limit=10;

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
        }


        public function searchPrint()
        {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=$this->criteriaSearch();
            $criteria->limit=-1; 

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
                    'pagination'=>false,
            ));
        }
}