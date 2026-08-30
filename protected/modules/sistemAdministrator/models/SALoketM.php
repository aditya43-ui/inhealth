<?php

/**
 * This is the model class for table "loket_m".
 *
 * The followings are the available columns in table 'loket_m':
 * @property integer $loket_id
 * @property integer $carabayar_id
 * @property string $loket_nama
 * @property string $loket_namalain
 * @property string $loket_fungsi
 * @property string $loket_singkatan
 * @property integer $loket_nourut
 * @property string $loket_formatnomor
 * @property boolean $loket_aktif
 */
class SALoketM extends LoketM
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LoketM the static model class
	 */
	public $carabayar_nama;
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function getCarabayarItems()
	{
		 return CarabayarM::model()->findAll('carabayar_aktif=TRUE ORDER BY carabayar_nama');
	}
	
	public function searchDialog()
    {
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

        $criteria=$this->criteriaSearch();
        $criteria->limit=10;

        return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
         ));
        }
}