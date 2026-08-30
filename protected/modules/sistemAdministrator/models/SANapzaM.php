<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class SANapzaM extends NapzaM
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
    public function getJenisNavza()
    {
        $model = JenisnapzaM::model()->findByPk($this->jenisnapza_id);
        return $model['jenisnapza_nama'];
    }
}
?>
