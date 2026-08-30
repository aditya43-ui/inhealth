<?php

/**
 * This is the model class for table "jabatan_m".
 *
 * The followings are the available columns in table 'jabatan_m':
 * @property integer $jabatan_id
 * @property string $jabatan_nama
 * @property string $jabatan_lainnya
 * @property boolean $jabatan_aktif
 */
class KPJabatanM extends JabatanM
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return JabatanM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	
	/**
	 * @return array validation rules for model attributes.
	 */
	

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		//$criteria->compare('jabatan_id',$this->jabatan_id);
		if(!empty($this->jabatan_id)){
			$criteria->addCondition('jabatan_id = '.$this->jabatan_id);
		}  
		$criteria->compare('LOWER(jabatan_nama)',strtolower($this->jabatan_nama),true);
		$criteria->compare('LOWER(jabatan_lainnya)',strtolower($this->jabatan_lainnya),true);
		$criteria->compare('jabatan_aktif',isset($this->jabatan_aktif)?$this->jabatan_aktif:true);
//                $criteria->addCondition('jabatan_aktif is true');

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		//$criteria->compare('jabatan_id',$this->jabatan_id);
			if(!empty($this->jabatan_id)){
			    $criteria->addCondition('jabatan_id = '.$this->jabatan_id);
		    }  
		        $criteria->compare('LOWER(jabatan_nama)',strtolower($this->jabatan_nama),true);
		        $criteria->compare('LOWER(jabatan_lainnya)',strtolower($this->jabatan_lainnya),true);
                $criteria->compare('jabatan_aktif',isset($this->jabatan_aktif)?$this->jabatan_aktif:true);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                //$criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }

            
       
		
		public function getJabatanItems()
		{
			$criteria = new CDbCriteria();
			$criteria->addCondition('jabatan_aktif = true');
			$criteria->order = "jabatan_nama ";
			return self::model()->findAll($criteria);
		}


}