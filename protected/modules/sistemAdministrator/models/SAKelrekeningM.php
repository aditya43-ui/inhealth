<?php

/**
 * This is the model class for table "kelrekening_m".
 *
 * The followings are the available columns in table 'kelrekening_m':
 * @property integer $kelrekening_id
 * @property string $koderekeningkel
 * @property string $namakelrekening
 * @property boolean $kelrekening_aktif
 *
 * The followings are the available model relations:
 * @property Rekening1M[] $rekening1Ms
 */
class SAKelrekeningM extends KelrekeningM
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return KelrekeningM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function searchRekening()
	{

		$criteria=new CDbCriteria;

		if(!empty($this->kelrekening_id)){
			$criteria->addCondition('kelrekening_id = '.$this->kelrekening_id);
		}
		$criteria->compare('LOWER(koderekeningkel)',strtolower($this->koderekeningkel),true);
		$criteria->compare('LOWER(namakelrekening)',strtolower($this->namakelrekening),true);
		$criteria->compare('kelrekening_aktif',$this->kelrekening_aktif);
		$criteria->compare('levelterakhir',$this->levelterakhir);
		$criteria->addCondition('kelrekening_aktif is true');
		$criteria->limit=10;

		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
		));
	}
	
	public function searchPrint()
        {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=new CDbCriteria;

			if(!empty($this->kelrekening_id)){
				$criteria->addCondition('kelrekening_id = '.$this->kelrekening_id);
			}
			$criteria->compare('LOWER(koderekeningkel)',strtolower($this->koderekeningkel),true);
			$criteria->compare('LOWER(namakelrekening)',strtolower($this->namakelrekening),true);
			$criteria->compare('levelterakhir',$this->levelterakhir);
			$criteria->addCondition('kelrekening_aktif is true');
            $criteria->limit=-1; 

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
                    'pagination'=>false,
            ));
        }
}