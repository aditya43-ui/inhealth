<?php
class RJHasilPemeriksaanLabT extends HasilpemeriksaanlabT
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return HasilpemeriksaanlabT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function getJenis(){
		$criteria=new CDbCriteria;
		
		$criteria->join = " JOIN pemeriksaanlab_m ON pemeriksaanlab_m.pemeriksaanlab_id = t.pemeriksaanlab_id
							JOIN jenispemeriksaanlab_m ON jenispemeriksaanlab_m.jenispemeriksaanlab_id = pemeriksaanlab_m.jenispemeriksaanlab_id";
		$criteria->group = 'jenispemeriksaanlab_m.jenispemeriksaanlab_id, jenispemeriksaanlab_m.jenispemeriksaanlab_nama, t.hasilpemeriksaanlab_id';
		$criteria->select = 'jenispemeriksaanlab_m.jenispemeriksaanlab_id as jenispemeriksaanlab_id, jenispemeriksaanlab_m.jenispemeriksaanlab_nama as jenispemeriksaanlab_nama, t.hasilpemeriksaanlab_id as hasilpemeriksaanlab_id';
		$criteria->order = 'jenispemeriksaanlab_m.jenispemeriksaanlab_nama ASC';
		$criteria->addCondition("t.hasilpemeriksaanlab_id = ".$this->hasilpemeriksaanlab_id);
		$ret = DetailhasilpemeriksaanlabT::model()->findAll($criteria);
		return $ret;
	}
	
	public function getKesimpulan(){
		$ret = MCHasilPemeriksaanLabT::model()->findByPk($this->hasilpemeriksaanlab_id);
		return $ret->kesimpulan;
	}

}