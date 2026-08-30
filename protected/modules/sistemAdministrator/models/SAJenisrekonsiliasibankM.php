<?php
class SAJenisrekonsiliasibankM extends JenisrekonsiliasibankM
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function getJenisRekonItems()
        {
            return JenisrekonsiliasibankM::model()->findAllByAttributes(array('jenisrekonsiliasibank_aktif'=>true),array('order'=>'jenisrekonsiliasibank_nama'));
        }
}