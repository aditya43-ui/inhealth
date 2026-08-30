<?php

/**
 * This is the model class for table "dtd_m".
 *
 * The followings are the available columns in table 'dtd_m':
 * @property integer $dtd_id
 * @property integer $tabularlist_id
 * @property string $dtd_kode
 * @property string $dtd_noterperinci
 * @property string $dtd_nama
 * @property string $dtd_namalainnya
 * @property string $dtd_katakunci
 * @property integer $dtd_nourut
 * @property boolean $dtd_menular
 * @property boolean $dtd_aktif
 */
class RJDtdM extends DtdM
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return DtdM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function searchRJ()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
				
				if(!empty($this->dtd_id)){
					$criteria->addCondition("dtd_id = ".$this->dtd_id);		
				}
				if(!empty($this->tabularlist_id)){
					$criteria->addCondition("tabularlist_id = ".$this->tabularlist_id);		
				}
				$criteria->compare('LOWER(dtd_kode)',strtolower($this->dtd_kode),true);
				$criteria->compare('LOWER(dtd_noterperinci)',strtolower($this->dtd_noterperinci),true);
				$criteria->compare('LOWER(dtd_nama)',strtolower($this->dtd_nama),true);
				$criteria->compare('LOWER(dtd_namalainnya)',strtolower($this->dtd_namalainnya),true);
				$criteria->compare('LOWER(dtd_katakunci)',strtolower($this->dtd_katakunci),true);
				$criteria->compare('dtd_nourut',$this->dtd_nourut);
				$criteria->compare('dtd_menular',$this->dtd_menular);
				$criteria->compare('dtd_aktif',TRUE);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
  

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                ));
        }
        
}