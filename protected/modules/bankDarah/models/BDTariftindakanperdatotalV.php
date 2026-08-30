<?php

/**
 * digunakan untuk view tindakan pada modul Bank Darah
 * @author Deni Hamdani <denihamdani@piindonesia.co.id>
 * @package application.modules.bankDarah
 * @subpackage models
 */
class BDTariftindakanperdatotalV extends TariftindakanperdatotalV {
    
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return TerimadistribusidarahT the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * Pencarian tindakan untuk Bank Darah
     * 
     * @return \CActiveDataProvider
     */
    public function searchDialogTindakanBankDarah() {
        $criteria = new CDbCriteria;
        
        $criteria->compare('penjamin_id', Params::PENJAMIN_ID_UMUM);
        $criteria->compare('kelompoktindakan_id', $this->kelompoktindakan_id);
        $criteria->compare('lower(daftartindakan_nama)', strtolower($this->daftartindakan_nama), true);
        
        return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
    }

}
