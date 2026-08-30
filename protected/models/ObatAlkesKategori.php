<?php

class ObatAlkesKategori extends LookupM
{
    private static $_items=array();
    private static $_type = 'obatalkes_kategori';
    /**
     * Returns the items for the specified type.
     * @param string item type (e.g. 'PostStatus').
     * @return array item names indexed by item code. The items are order by their lookup_urutan values.
     * An empty array is returned if the item type does not exist.
     */
    public static function items($type=null)
    {
        $type = self::$_type;
            if(!isset(self::$_items[$type]))
                    self::loadItems($type);
            return self::$_items[$type];
    }

    /**
     * Returns the item name for the specified type and code.
     * @param string the item type (e.g. 'PostStatus').
     * @param integer the item code (corresponding to the 'code' column value)
     * @return string the item name for the specified the code. False is returned if the item type or code does not exist.
     */
    public static function item($type,$code)
    {
            if(!isset(self::$_items[$type]))
                    self::loadItems($type);
            return isset(self::$_items[$type][$code]) ? self::$_items[$type][$code] : false;
    }

    /**
     * Loads the lookup items for the specified type from the database.
     * @param string the item type
     */
    private static function loadItems($type)
    {
            self::$_items[$type]=array();
            $models=self::model()->findAll(array(
                    'condition'=>'lookup_type=:type AND lookup_aktif=:aktif',
                    'params'=>array(':type'=>$type,':aktif'=>true),
                    'order'=>'lookup_urutan',
            ));
            foreach($models as $model)
                    self::$_items[$type][$model->lookup_value]=$model->lookup_name;
    }
    public static function namaType(){
        return self::$_type;
    }
     public function searchKategoriObat()
    {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $this->lookup_type = self::$_type;
            $criteria=new CDbCriteria;

            $criteria->compare('lookup_id',$this->lookup_id);
            $criteria->compare('LOWER(lookup_name)',strtolower($this->lookup_name),true);
            $criteria->compare('LOWER(lookup_value)',strtolower($this->lookup_value),true);
            $criteria->compare('LOWER(lookup_type)',strtolower($this->lookup_type),true);
            $criteria->compare('lookup_urutan',$this->lookup_urutan);
            $criteria->compare('LOWER(lookup_kode)',strtolower($this->lookup_kode),true);
            $criteria->compare('lookup_aktif',$this->lookup_aktif);
            $criteria->order = 'lookup_type, lookup_urutan';

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
    }
     public function searchPrint()
    {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $this->lookup_type = self::$_type;
            $criteria=new CDbCriteria;

            $criteria->compare('lookup_id',$this->lookup_id);
            $criteria->compare('LOWER(lookup_name)',strtolower($this->lookup_name),true);
            $criteria->compare('LOWER(lookup_value)',strtolower($this->lookup_value),true);
            $criteria->compare('LOWER(lookup_type)',strtolower($this->lookup_type),true);
            $criteria->compare('lookup_urutan',$this->lookup_urutan);
            $criteria->compare('LOWER(lookup_kode)',strtolower($this->lookup_kode),true);
            $criteria->compare('lookup_aktif',$this->lookup_aktif);
            $criteria->order = 'lookup_type, lookup_urutan';
            $criteria->limit = -1;

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
                    'pagination'=>false,
            ));
    }
}
?>
