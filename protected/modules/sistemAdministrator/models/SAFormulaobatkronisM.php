<?php

class SAFormulaobatkronisM extends FormulaobatkronisM {
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public function search() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;
        $criteria->compare('formulaobatkronis_id', $this->formulaobatkronis_id);
        $criteria->compare('jumlahobat', $this->jumlahobat);
        $criteria->compare('jumlahobat_minimal', $this->jumlahobat_minimal);
        $criteria->compare('jumlahobat_maksimal', $this->jumlahobat_maksimal);
        // $criteria->compare('is_aktif', $this->is_aktif);
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
}
