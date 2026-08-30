<?php

/**
 * This is the model class for table "ptkp_m".
 *
 * The followings are the available columns in table 'ptkp_m':
 * @property integer $ptkp_id
 * @property string $tglberlaku
 * @property string $statusperkawinan
 * @property integer $jmltanggunan
 * @property double $wajibpajak_thn
 * @property double $wajibpajak_bln
 * @property boolean $berlaku
 */
class KPPtkpM extends PtkpM
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PtkpM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$this->tglberlaku = MyFormatter::formatDateTimeForDb($this->tglberlaku);
		$criteria->compare('ptkp_id',$this->ptkp_id);
		$criteria->compare('DATE(tglberlaku)',$this->tglberlaku);
		$criteria->compare('LOWER(statusperkawinan)',strtolower($this->statusperkawinan),true);
		$criteria->compare('jmltanggunan',$this->jmltanggunan);
		$criteria->compare('wajibpajak_thn',$this->wajibpajak_thn);
		$criteria->compare('wajibpajak_bln',$this->wajibpajak_bln);
		$criteria->compare('berlaku',$this->berlaku);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
	public function searchPrint()
	{
			// Warning: Please modify the following code to remove attributes that
			// should not be searched.

			$criteria=new CDbCriteria;
	$criteria->compare('ptkp_id',$this->ptkp_id);
	$criteria->compare('DATE(tglberlaku)',strtolower($this->tglberlaku),true);
	$criteria->compare('LOWER(statusperkawinan)',strtolower($this->statusperkawinan),true);
	$criteria->compare('jmltanggunan',$this->jmltanggunan);
	$criteria->compare('wajibpajak_thn',$this->wajibpajak_thn);
	$criteria->compare('wajibpajak_bln',$this->wajibpajak_bln);
	//$criteria->compare('berlaku',$this->berlaku);
			// Klo limit lebih kecil dari nol itu berarti ga ada limit 
			$criteria->limit=-1; 

			return new CActiveDataProvider($this, array(
					'criteria'=>$criteria,
					'pagination'=>false,
			));
	}
}