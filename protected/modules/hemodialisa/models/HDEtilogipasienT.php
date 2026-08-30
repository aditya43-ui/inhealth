<?php

/**
 * This is the model class for table "etilogipasien_t".
 *
 * The followings are the available columns in table 'etilogipasien_t':
 * @property integer $etilogipasien_id
 * @property integer $etilogi_id
 * @property integer $pasienmorbiditas_id
 * @property integer $penyertaetilogi_id
 * @property string $etilogipasien_tgl
 * @property string $et_createtime
 * @property string $et_updatetime
 * @property integer $et_createloginid
 * @property integer $et_updateloginid
 * @property integer $et_createruangan
 */
class HDEtilogipasienT extends EtilogipasienT
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return EtilogipasienT the static model class
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

		$criteria->compare('etilogipasien_id',$this->etilogipasien_id);
		$criteria->compare('etilogi_id',$this->etilogi_id);
		$criteria->compare('pasienmorbiditas_id',$this->pasienmorbiditas_id);
		$criteria->compare('penyertaetilogi_id',$this->penyertaetilogi_id);
		$criteria->compare('etilogipasien_tgl',$this->etilogipasien_tgl,true);
		$criteria->compare('et_createtime',$this->et_createtime,true);
		$criteria->compare('et_updatetime',$this->et_updatetime,true);
		$criteria->compare('et_createloginid',$this->et_createloginid);
		$criteria->compare('et_updateloginid',$this->et_updateloginid);
		$criteria->compare('et_createruangan',$this->et_createruangan);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}