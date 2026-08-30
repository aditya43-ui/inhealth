<?php

class ATPascaanestesiT extends PascaanestesiT
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PascaanestesiT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pascaanestesi_id' => 'Pasca Anestesi',
			'pasienanastesi_id' => 'Pasien Anestesi',
			'intraanestesi_id' => 'Intra Anestesi',
			'kamarruangan_id' => 'Kamar Ruangan',
			'ruangan_id' => 'Ruangan',
			'nopascaanestesi' => 'No. Pasca Anestesi',
			'tglpascaanestesi' => 'Tgl. Pasca Anestesi',
			'instalasipasca_id' => 'Instalasi',
			'ruanganpasca_id' => 'Ruangan',
			'perawatruangan_id' => 'Perawat',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
			'komplikasi' => 'Komplikasi',
		);
	}
}