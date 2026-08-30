<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of LupaPasswordForm
 *
 * @author root
 */
class LupaPasswordForm extends CFormModel {
    public $no_hp;
    public $loginpemakai_id;
    
    public function rules()
    {
        return array(
            array('no_hp', 'required'),
            array('no_hp', 'numerical'),
            array('no_hp', 'validasiNoHP'),
            array('loginpemakai_id', 'safe'),
        );
    }
    
    public function validasiNoHp($attribute,$params)
    {
        $no_hp = $this->$attribute;
        $no_hp1 = substr($no_hp, 1);
        $no_hp2 = substr($no_hp, 2);
        $no_hp3 = substr($no_hp, 3);
        
        $cr = new CDbCriteria();
        $cr->compare('nomobile_pegawai', $no_hp1, true);
        $p = PegawaiM::model()->find($cr);
        
        if (empty($p)) {
            $cr = new CDbCriteria();
            $cr->compare('nomobile_pegawai', $no_hp2, true);
            $p = PegawaiM::model()->find($cr);
        }
        
        if (empty($p)) {
            $cr = new CDbCriteria();
            $cr->compare('nomobile_pegawai', $no_hp3, true);
            $p = PegawaiM::model()->find($cr);
        }
        
        if (empty($p)) {
            $this->addError($attribute, "No. HP tidak ditemukan di database");
            return false;
        }
        
        $lp = LoginpemakaiK::model()->findByAttributes(array(
            'pegawai_id' => $p->pegawai_id
        ));
        
        if (empty($lp)) {
            $this->addError($attribute, "Login Pemakai tidak ditemukan di database");
            return false;
        }
        
        $this->loginpemakai_id = $lp->loginpemakai_id;
    }
}
