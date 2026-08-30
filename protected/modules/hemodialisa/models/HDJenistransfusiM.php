<?php

/**
 * This is the model class for table "jenistransfusi_m".
 *
 * The followings are the available columns in table 'jenistransfusi_m':
 * @property integer $jenistransfusi_id
 * @property string $jenistransfusi_nama
 * @property string $jenistransfusi_namalain
 * @property string $jenistransfusi_desc
 */
class HDJenistransfusiM extends JenistransfusiM
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return JenistransfusiM the static model class
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

		$criteria->compare('jenistransfusi_id',$this->jenistransfusi_id);
		$criteria->compare('jenistransfusi_nama',$this->jenistransfusi_nama,true);
		$criteria->compare('jenistransfusi_namalain',$this->jenistransfusi_namalain,true);
		$criteria->compare('jenistransfusi_desc',$this->jenistransfusi_desc,true);
		$criteria->limit = -1;

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>false,
		));
	}
}