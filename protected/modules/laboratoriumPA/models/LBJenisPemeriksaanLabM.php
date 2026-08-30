<?php

class LBJenisPemeriksaanLabM extends JenispemeriksaanlabM
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AnamnesaT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('jenispemeriksaanlab_kode, jenispemeriksaanlab_nama,jenispemeriksaanlab_kelompok', 'required'),
			array('jenispemeriksaanlab_urutan', 'numerical', 'integerOnly'=>true),
			array('jenispemeriksaanlab_kode', 'length', 'max'=>10),
			array('jenispemeriksaanlab_nama, jenispemeriksaanlab_namalainnya', 'length', 'max'=>30),
			array('jenispemeriksaanlab_kelompok', 'length', 'max'=>100),
			array('jenispemeriksaanlab_aktif', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('jenispemeriksaanlab_id, jenispemeriksaanlab_kode, jenispemeriksaanlab_urutan, jenispemeriksaanlab_nama, jenispemeriksaanlab_namalainnya, jenispemeriksaanlab_kelompok, jenispemeriksaanlab_aktif', 'safe', 'on'=>'search'),
		);
	}

}