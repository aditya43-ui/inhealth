<?php

/**
 * This is the model class for table "alatfinger_m".
 *
 * The followings are the available columns in table 'alatfinger_m':
 * @property integer $alatfinger_id
 * @property string $namaalat
 * @property string $ipfinger
 * @property string $keyfinger
 * @property string $lokasifinger
 * @property string $keterangan
 * @property boolean $alat_aktif
 *
 * The followings are the available model relations:
 * @property UsrinfoalatM[] $usrinfoalatMs
 * @property NofingeralatM[] $nofingeralatMs
 */
class SAAlatfingerM extends AlatfingerM
{
	public $is_fingerprint, $is_facerecognition;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return SAAlatfingerM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}