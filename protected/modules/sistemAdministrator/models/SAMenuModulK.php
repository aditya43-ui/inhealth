<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class SAMenuModulK extends MenumodulK
{
    public $kelompokMenu;
    public $modul;
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return KelompokmenuK the static model class
     */
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=new CDbCriteria;
			
			if (!empty($this->menu_id)){
				$criteria->addCondition('menu_id ='.$this->menu_id);
			}
			if (!empty($this->kelmenu_id)){
				$criteria->addCondition('t.kelmenu_id ='.$this->kelmenu_id);
			}
			if (!empty($this->modul_id)){
				$criteria->addCondition('t.modul_id ='.$this->modul_id);
			}
                        if($this->menu_icon == 1){
                                $criteria->addCondition("(t.menu_icon = '') IS NOT FALSE"
                        );
                        }
            $criteria->compare('LOWER(kelompokmenu.kelmenu_nama)',strtolower($this->kelompokMenu),true);
            $criteria->compare('LOWER(modulk.modul_nama)',strtolower($this->modul),true);
            $criteria->compare('LOWER(menu_nama)',strtolower($this->menu_nama),true);
            $criteria->compare('LOWER(menu_namalainnya)',strtolower($this->menu_namalainnya),true);
            $criteria->compare('LOWER(menu_key)',strtolower($this->menu_key),true);
            $criteria->compare('LOWER(menu_url)',strtolower($this->menu_url),true);
            $criteria->compare('LOWER(menu_fungsi)',strtolower($this->menu_fungsi),true);
            $criteria->compare('menu_urutan',$this->menu_urutan);
            $criteria->compare('menu_aktif',isset($this->menu_aktif)?$this->menu_aktif:true);
            $criteria->order = 'kelompokmenu.kelmenu_nama, menu_urutan';
            $criteria->join = 'left join kelompokmenu_k kelompokmenu on kelompokmenu.kelmenu_id = t.kelmenu_id 
            left join modul_k modulk on t.modul_id = modulk.modul_id';

            // $criteria->with = array('kelompokmenu','modulk');

            // var_dump($criteria); die;

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
    }
}
?>
