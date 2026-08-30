<?php
class RJTriase extends Triase
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function getKodeWarna(){
		$model = $this->findAllByAttributes(array('triase_aktif'=>true));
		$data = array();
		foreach($model as $row){
			$data[] = $row->kode_warnatriase;
		}
		return $data;
	}

	public function getKodeWarnaId($id){
		$model = $this->findByPK($id)->kode_warnatriase;
		return $model;
	}
}