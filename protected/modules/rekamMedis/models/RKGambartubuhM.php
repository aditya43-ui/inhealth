<?php

/**
 * This is the model class for table "gambartubuh_m".
 *
 * The followings are the available columns in table 'gambartubuh_m':
 * @property integer $gambartubuh_id
 * @property string $nama_gambar
 * @property string $nama_file_gbr
 * @property string $path_gambar
 * @property double $gambar_resolusi_x
 * @property double $gambar_resolusi_y
 * @property string $gambar_create
 * @property string $gambar_update
 * @property boolean $gambartubuh_aktif
 */
class RKGambartubuhM extends GambartubuhM
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return GambartubuhM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function getFileNameGambar(){
		$model = RKGambartubuhM::model()->find('gambartubuh_aktif = true');
		return $model->nama_file_gbr;
	}
	public function getDataGambarAnatomi(){
		$model = RKGambartubuhM::model()->find('gambartubuh_aktif = true');
		return $model;
	}
}