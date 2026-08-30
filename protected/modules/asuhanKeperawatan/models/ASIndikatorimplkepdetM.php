<?php

/**
 * This is the model class for table "indikatorimplkepdet_m".
 *
 * The followings are the available columns in table 'indikatorimplkepdet_m':
 * @property integer $indikatorimplkepdet_id
 * @property integer $implementasikep_id
 * @property string $indikatorimplkepdet_indikator
 * @property boolean $indikatorimplkepdet_aktif
 *
 * The followings are the available model relations:
 * @property ImplementasikepM $implementasikep
 * @property PilihimplementasiaskepT[] $pilihimplementasiaskepTs
 */
class ASIndikatorimplkepdetM extends IndikatorimplkepdetM
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return IndikatorimplkepdetM the static model class
	 */
	public $diagnosakep_nama,$diagnosakep_id;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function searchDialog()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$criteria->select = 't.*,diagnosakep.*';
		$criteria->join = 'JOIN implementasikep_m AS implementasikep ON implementasikep.implementasikep_id = t.implementasikep_id
						   JOIN diagnosakep_m AS diagnosakep ON diagnosakep.diagnosakep_id = implementasikep.diagnosakep_id';
		$criteria->compare('LOWER(t.indikatorimplkepdet_indikator)', strtolower($this->indikatorimplkepdet_indikator), true);
		$criteria->compare('LOWER(diagnosakep.diagnosakep_nama)', strtolower($this->diagnosakep_nama), true);
		$criteria->compare('t.indikatorimplkepdet_aktif',$this->indikatorimplkepdet_aktif);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}