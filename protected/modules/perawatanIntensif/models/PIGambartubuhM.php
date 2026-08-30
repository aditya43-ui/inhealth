<?php

/**
 * This is the model class for table "gambartubuh_m".
 *
 * The followings are the available columns in table 'gambartubuh_m':  
 * @package application.models 
 * @author M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     1.0.0
 * @link    <http://piindonesia.co.id> 
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
class PIGambartubuhM extends GambartubuhM
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
	
        /**
         * mengenerate nama file gambar
         * @return type
         */
	public function getFileNameGambar(){
		$model = PIGambartubuhM::model()->find('gambartubuh_aktif = true AND ispemeriksaanfisik IS TRUE ORDER BY gambartubuh_urutan ASC');
		return $model->nama_file_gbr;
	}
        
        /**
         * mengenerate gambar anatomi
         * @return type
         */
	public function getDataGambarAnatomi(){
		$model = PIGambartubuhM::model()->find('gambartubuh_aktif = true AND ispemeriksaanfisik IS TRUE ORDER BY gambartubuh_urutan ASC');
		return $model;
	}
    
        /**
         * mengenerate gambar anatomi dan hanya berlaku pada gambar anatomi
         * @return type
         */
	public function getAllDataGambarAnatomi() {
            $model = PIGambartubuhM::model()->findAll('gambartubuh_aktif = true AND ispemeriksaanfisik IS TRUE ORDER BY gambartubuh_urutan ASC');
                    return $model;
        }
}