<?php

/**
 * This is the model class for table "kelompokkomponentarif_m".
 *
 * The followings are the available columns in table 'kelompokkomponentarif_m':
 * @property integer $kelompokkomponentarif_id
 * @property string $kelompokkomponentarif_nama
 * @property string $kelompokkomponentarif_namalain
 * @property boolean $kelompokkomponentarif_aktif
 */
class SAKelompokkomponentarifM extends KelompokkomponentarifM
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return KelompokkomponentarifM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public function searchPrint()
        {
                $criteria=new CDbCriteria;

		$criteria->compare('kelompokkomponentarif_id',$this->kelompokkomponentarif_id);
		$criteria->compare('kelompokkomponentarif_nama',$this->kelompokkomponentarif_nama,true);
		$criteria->compare('kelompokkomponentarif_namalain',$this->kelompokkomponentarif_namalain,true);
		// $criteria->compare('kelompokkomponentarif_aktif',$this->kelompokkomponentarif_aktif);
                $criteria->limit = -1;
                
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination'=>false,
		));
        }
}