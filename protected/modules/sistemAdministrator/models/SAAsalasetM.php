<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class SAAsalasetM extends AsalasetM
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return KabupatenM the static model class
     */
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }
	
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('asalaset_id',$this->asalaset_id);
		$criteria->compare('LOWER(asalaset_nama)',strtolower($this->asalaset_nama),true);
		$criteria->compare('LOWER(asalaset_singkatan)',strtolower($this->asalaset_singkatan),true);
		$criteria->compare('asalaset_aktif',isset($this->asalaset_aktif)?$this->asalaset_aktif:true);
//                $criteria->addCondition('asalaset_aktif is true');

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('asalaset_id',$this->asalaset_id);
		$criteria->compare('LOWER(asalaset_nama)',strtolower($this->asalaset_nama),true);
		$criteria->compare('LOWER(asalaset_singkatan)',strtolower($this->asalaset_singkatan),true);
		$criteria->compare('asalaset_aktif',isset($this->asalaset_aktif)?$this->asalaset_aktif:true);
		//$criteria->compare('asalaset_aktif',$this->asalaset_aktif);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
}
?>
