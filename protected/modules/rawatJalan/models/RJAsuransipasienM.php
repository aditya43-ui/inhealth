<?php

class RJAsuransipasienM extends AsuransipasienM
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AsuransipasienM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function getJenisPesertaItems(){
		return JenisPesertaM::model()->findAllByAttributes(array('jenispeserta_aktif'=>true));
	}

}