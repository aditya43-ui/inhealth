<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class RDUbahCaraBayarR extends UbahcarabayarR
{
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
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
            // NOTE: you should only define rules for those attributes that
            // will receive user inputs.
            return array(
                    array('tglubahcarabayar, alasanperubahan', 'required'),
                    array('carabayar_id, penjamin_id, pendaftaran_id', 'numerical', 'integerOnly'=>true),
                    array('alasanperubahan', 'length', 'max'=>100),
                    array('update_time, update_loginpemakai_id', 'safe'),
                
                    array('create_time','default','value'=>date( 'Y-m-d H:i:s'),'setOnEmpty'=>false,'on'=>'insert'),
                    array('update_time','default','value'=>date( 'Y-m-d H:i:s'),'setOnEmpty'=>false,'on'=>'update,insert'),
                    array('create_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'insert'),
                    array('update_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'update,insert'),
                    array('create_ruangan','default','value'=>Yii::app()->user->getState('ruangan_id'),'on'=>'insert'),
                
                    // The following rule is used by search().
                    // Please remove those attributes that should not be searched.
                    array('ubahacarabayar_id, carabayar_id, penjamin_id, pendaftaran_id, tglubahcarabayar, alasanperubahan, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
            );
    }
}
?>
