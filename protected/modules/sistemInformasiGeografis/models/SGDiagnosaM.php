<?php

/**
 * This is the model class for table "diagnosa_m".
 *
 * The followings are the available columns in table 'diagnosa_m':
 * @property integer $diagnosa_id
 * @property string $diagnosa_kode
 * @property string $diagnosa_nama
 * @property string $diagnosa_namalainnya
 * @property string $diagnosa_katakunci
 * @property integer $diagnosa_nourut
 * @property boolean $diagnosa_imunisasi
 * @property boolean $diagnosa_aktif
 * @property integer $klasifikasidiagnosa_id
 */
class SGDiagnosaM extends DiagnosaM
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return DiagnosaM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function searchDialog()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		
		$criteria->compare('LOWER(t.diagnosa_kode)',strtolower($this->diagnosa_kode),true);
		$criteria->compare('LOWER(t.diagnosa_nama)',strtolower($this->diagnosa_nama),true);
		$criteria->compare('LOWER(t.diagnosa_namalainnya)',strtolower($this->diagnosa_namalainnya),true);
		$criteria->compare('LOWER(t.diagnosa_katakunci)',strtolower($this->diagnosa_katakunci),true);
		
		$criteria->join = "JOIN pasienmorbiditas_t ON pasienmorbiditas_t.diagnosa_id = t.diagnosa_id";
		$criteria->group = "t.diagnosa_id,t.diagnosa_nama,t.diagnosa_kode,t.diagnosa_namalainnya,t.diagnosa_katakunci";
		$criteria->select = $criteria->group;
		$criteria->order = "t.diagnosa_nama";
		
		if(!empty($this->dtd_id)){
			$criteria->addCondition("t.dtd_id = ".$this->dtd_id);				
		}
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
}