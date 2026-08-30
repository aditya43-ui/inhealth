<?php

/**
 * This is the model class for table "alatmedis_m".
 *
 * The followings are the available columns in table 'alatmedis_m':
 * @property integer $mikroorganisme_id
 * @property string $nama_mikroorganisme
 * @property string $kelompok_mikroorganisme
 * @property boolean $mikroorganisme_aktif
 *
 */
class SAMikroorganismeM extends MikroorganismeM
{
    public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('kelompok_mikroorganisme', 'required'),
			array('hasilpemeriksaanmikro_id', 'numerical', 'integerOnly'=>true),
			array('kelompok_mikroorganisme, hasilpemeriksaan', 'length', 'max'=>100),
			array('hasilpemeriksaan_aktif', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('hasilpemeriksaanmikro_id, kelompok_mikroorganisme, hasilpemeriksaan, hasilpemeriksaan_aktif', 'safe', 'on'=>'search'),
		);
	}
}

?>