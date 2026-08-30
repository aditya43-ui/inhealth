<?php

/**
 * This is the model class for table "jenisdialisat_m".
 *
 * The followings are the available columns in table 'jenisdialisat_m':
 * @property integer $jenisdialisat_id
 * @property string $jenisdialisat_nama
 * @property string $jenisdialisat_namalain
 * @property string $jenisdialisat_deskripsi
 * @property boolean $jenisdialisat_aktif
 */
class HDJenisdialisatM extends JenisdialisatM
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return JenisdialisatM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function searchPrint()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('jenisdialisat_id',$this->jenisdialisat_id);
		$criteria->compare('jenisdialisat_nama',$this->jenisdialisat_nama,true);
		$criteria->compare('jenisdialisat_namalain',$this->jenisdialisat_namalain,true);
		$criteria->compare('jenisdialisat_deskripsi',$this->jenisdialisat_deskripsi,true);
		$criteria->compare('jenisdialisat_aktif',$this->jenisdialisat_aktif);
		$criteria->limit = -1;

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>false,
		));
	}
}