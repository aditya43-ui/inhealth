<?php

/**
 * This is the model class for table "penyertaetilogi_m".
 *
 * The followings are the available columns in table 'penyertaetilogi_m':
 * @property integer $penyertaetilogi_id
 * @property string $penyertaetilogi_kode
 * @property string $penyertaetilogi_nama
 * @property string $penyertaetilogi_namalain
 * @property boolean $penyertaetilogi_aktif
 */
class HDPenyertaetilogiM extends PenyertaetilogiM
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PenyertaetilogiM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}


	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('penyertaetilogi_id',$this->penyertaetilogi_id);
		$criteria->compare('LOWER(penyertaetilogi_kode)',  strtolower($this->penyertaetilogi_kode),true);
		$criteria->compare('LOWER(penyertaetilogi_nama)',strtolower($this->penyertaetilogi_nama),true);
		$criteria->compare('LOWER(penyertaetilogi_namalain)',strtolower($this->penyertaetilogi_namalain),true);
		$criteria->compare('penyertaetilogi_aktif',$this->penyertaetilogi_aktif);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
    
	public function searchPrint()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('penyertaetilogi_id',$this->penyertaetilogi_id);
		$criteria->compare('LOWER(penyertaetilogi_kode)',  strtolower($this->penyertaetilogi_kode),true);
		$criteria->compare('LOWER(penyertaetilogi_nama)',strtolower($this->penyertaetilogi_nama),true);
		$criteria->compare('LOWER(penyertaetilogi_namalain)',strtolower($this->penyertaetilogi_namalain),true);
		$criteria->compare('penyertaetilogi_aktif',$this->penyertaetilogi_aktif);
		$criteria->limit = -1;

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
            'pagination'=>false,
		));
	}
}