<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 * 
 * 
 */
class SACarabayarkeluarrekM extends CarabayarkeluarrekM
{
	public $rekening,$nmrekening5,$debkre;
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return KabupatenM the static model class
     */
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }
	
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'carabayarkeluarrek_id' => 'ID',
			'carabayarkeluar' => 'Jenis Penjamin Keluar',
			'rekening5_id' => 'Rekening',
			'debitkredit' => 'Debit / Kredit',
		);
	}

    /**
     * Pencarian untuk Admin Master Cara Pembayaran Keluar
     * 
     * @return \CActiveDataProvider
     */
	public function search() {
		$criteria = new CDbCriteria;
		$criteria->with = array('rekening5');
		$criteria->compare('LOWER(carabayarkeluar)', strtolower($this->carabayarkeluar), true);
		$criteria->compare('rekening5.rekening5_id', $this->rekening5_id);
		$criteria->compare('LOWER(rekening5.nmrekening5)', strtolower($this->nmrekening5), true);
		$criteria->compare('LOWER(debitkredit)', strtolower($this->debitkredit), true);
		if (!empty($this->rekening)) {
			$criteria->compare('LOWER(nmrekening5)', strtolower($this->rekening), true);
		}
		if (!empty($this->nmrekening5)) {
			$criteria->compare('LOWER(nmrekening5)', strtolower($this->nmrekening5), true);
		}
		if (!empty($this->debkre)) {
			$criteria->compare('LOWER(debitkredit)', strtolower($this->debkre), true);
		}
		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
    /**
     * Printout Master Cara Pembayaran Keluar.
     * 
     * @return \CActiveDataProvider
     */
	public function searchPrint() {
		$criteria = new CDbCriteria;
		$criteria->with = array('rekening5');
		$criteria->compare('LOWER(carabayarkeluar)', strtolower($this->carabayarkeluar), true);
		$criteria->compare('rekening5.rekening5_id', $this->rekening5_id);
		$criteria->compare('LOWER(rekening5.nmrekening5)', strtolower($this->nmrekening5), true);
		$criteria->compare('LOWER(debitkredit)', strtolower($this->debitkredit), true);
		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}
?>
