<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class SAInstalasiM extends InstalasiM
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return GolonganumurM the static model class
     */
    public static function model($className=__CLASS__)
    {
		return parent::model($className);
    }
	
	public static function getItems(){
		$criteria = new CDbCriteria();
		$criteria->addCondition("instalasi_aktif = TRUE");
		$criteria->order = 'instalasi_nama ASC';
		return self::model()->findAll($criteria);
	}
	
	public function searchDialog()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('instalasi_id',$this->instalasi_id);
		$criteria->compare('LOWER(instalasi_nama)',strtolower($this->instalasi_nama),true);
		$criteria->compare('LOWER(instalasi_namalainnya)',strtolower($this->instalasi_namalainnya),true);
		$criteria->compare('LOWER(instalasi_singkatan)',strtolower($this->instalasi_singkatan),true);
		$criteria->compare('LOWER(instalasi_lokasi)',strtolower($this->instalasi_lokasi),true);
		$criteria->compare('instalasi_aktif',isset($this->instalasi_aktif)?$this->instalasi_aktif:true);
                $criteria->compare('instalasirujukaninternal',$this->instalasirujukaninternal);
                $criteria->compare('riwayatruangan_id',$this->riwayatruangan_id);
                $criteria->compare('instalasi_adakamar',$this->instalasi_adakamar);
//                $criteria->addCondition('instalasi_aktif is true');

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public static function getInstalasiItems($id=null){
		$criteria = new CDbCriteria();
                if (!empty($id)){
                    $criteria->addCondition("instalasi_id = ".$id);
                }
		$criteria->addCondition('instalasi_aktif = TRUE');
		$criteria->order = "instalasi_nama";
		return self::model()->findAll($criteria);
	}
}
?>
