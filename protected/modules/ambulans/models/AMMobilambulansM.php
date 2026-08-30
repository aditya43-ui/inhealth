<?php

class AMMobilambulansM extends MobilambulansM
{
        /**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AnamnesaT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function searchDialog()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('mobilambulans_id',$this->mobilambulans_id);
		$criteria->compare('inventarisaset_id',$this->inventarisaset_id);
		$criteria->compare('LOWER(mobilambulans_kode)',strtolower($this->mobilambulans_kode),true);
		$criteria->compare('LOWER(nopolisi)',strtolower($this->nopolisi),true);
		$criteria->compare('LOWER(jeniskendaraan)',strtolower($this->jeniskendaraan),true);
		$criteria->compare('isibbmliter',$this->isibbmliter);
		$criteria->compare('LOWER(kmterakhirkend)',strtolower($this->kmterakhirkend),true);
		$criteria->compare('LOWER(photokendaraan)',strtolower($this->photokendaraan),true);
		$criteria->compare('hargabbmliter',$this->hargabbmliter);
		$criteria->compare('LOWER(formulajasars)',strtolower($this->formulajasars),true);
		$criteria->compare('LOWER(formulajasaba)',strtolower($this->formulajasaba),true);
		$criteria->compare('LOWER(formulajasapel)',strtolower($this->formulajasapel),true);
		//$criteria->compare('mobilambulans_aktif',$this->mobilambulans_aktif);
		$criteria->compare('mobilambulans_aktif',isset($this->mobilambulans_aktif)?$this->mobilambulans_aktif:true);
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
    
    public function searchDialogAmbulansBelumTerpakai() {
        $prov = $this->searchDialog();
        $prov->criteria->addCondition('isterpakai = false');
        
        return $prov;
    }
}
?>
