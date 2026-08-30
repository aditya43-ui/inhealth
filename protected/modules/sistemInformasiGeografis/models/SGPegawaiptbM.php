<?php

/**
 * This is the model class for table "pegawaiptb_m".
 *
 * The followings are the available columns in table 'pegawaiptb_m':
 * @property integer $employe_id
 * @property string $no_badge
 * @property string $namapegawai_ptb
 * @property string $nama_departemen
 * @property string $tempatlahir
 * @property string $tgl_lahir
 * @property string $jeniskelamin
 * @property string $agama
 * @property string $tipe_rumah
 * @property string $alamat
 * @property string $no_telepon
 * @property string $no_handphone
 * @property boolean $pegawaiptb_aktif
 */
class SGPegawaiptbM extends PegawaiptbM
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PegawaiptbM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	/**
	 * manampilkan list pegawaiptb_m
	 * @param type $jenis
	 * @return array $data[$lookup_value] = $lookup_name
	 */
	public static function getTypeRumah($typerumah=null)
	{
		$data = array();
		$criteria = new CDbCriteria();
		if(is_array($typerumah))
			$criteria->addInCondition ('typerumah', $typerumah);
		else{
			$typerumah = isset($typerumah) ? trim(strtolower($typerumah)) : null;
			$criteria->compare('typerumah',$typerumah);
		}
		$criteria->group = "tipe_rumah";
		$criteria->select = $criteria->group;
		$criteria->addCondition("pegawaiptb_aktif IS TRUE");
		$models=self::model()->findAll($criteria);
		if(count((array)$models) > 0){
			foreach($models as $model)
				$data[$model->tipe_rumah]= $model->tipe_rumah;
		}else{
			$data[""] = null;
		}

		return $data;
	}
	
}