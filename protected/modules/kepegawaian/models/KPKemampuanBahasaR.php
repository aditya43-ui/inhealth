<?php

/**
 * This is the model class for table "kemampuanbahasa_r".
 *
 * The followings are the available columns in table 'kemampuanbahasa_r':
 * @property integer $kemampuanbahasa_id
 * @property integer $pelamar_id
 * @property string $bahasa
 * @property string $mengerti
 * @property string $berbicara
 * @property string $menulis
 *
 * The followings are the available model relations:
 * @property PelamarT $pelamar
 */
class KPKemampuanBahasaR extends KemampuanBahasaR
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return KemampuanBahasaR the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
    
    public $no_urut;
    
    public function getMengertiBahasa(){
        return LookupM::model()->findAllByAttributes(array('lookup_type'=>'mengertibahasa'));
    }
    public function getBerbicaraBahasa(){
        return LookupM::model()->findAllByAttributes(array('lookup_type'=>'berbicarabahasa'));
    }
    public function getMenulisBahasa(){
        return LookupM::model()->findAllByAttributes(array('lookup_type'=>'menulisbahasa'));
    }
}
?>
