<?php

class SAMkategoriberitaM extends MkategoriberitaM
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function getKategoriBerita(){
		return $this->findAllByAttributes(array('kategoriberita_aktif'=>true));
	}
}