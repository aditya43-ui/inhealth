<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class SADetailnapzaM extends DetailnapzaM
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return JeniskasuspenyakitM the static model class
     */
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }
    
    public function getNamaNavza()
    {
        $model = NapzaM::model()->findByPk($this->napza_id);
        return $model['napza_nama'];
    }
}
?>
