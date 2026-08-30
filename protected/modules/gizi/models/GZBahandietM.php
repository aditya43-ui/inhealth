<?php

class GZBahandietM  extends BahandietM{
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
    public function searchBahanDiet()
    {
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		if(!empty($this->bahandiet_id)){
			$criteria->addCondition('bahandiet_id ='.$this->bahandiet_id);
		}
		$criteria->compare('LOWER(bahandiet_nama)',strtolower($this->bahandiet_nama),true);
		$criteria->compare('LOWER(bahandiet_namalain)',strtolower($this->bahandiet_namalain),true);
		$criteria->compare('bahandiet_aktif',isset($this->bahandiet_aktif)?$this->bahandiet_aktif:true);
		//$criteria->addCondition('bahandiet_aktif is true');
		$criteria->limit = 10;

		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
		));
    }
}

?>
