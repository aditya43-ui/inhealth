<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class MAPemakaianbrgdetailT extends PemakaianbrgdetailT {

//    public $barang_nama;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return KabupatenM the static model class
	 */
	public static function model($className = __CLASS__) {
		return parent::model($className);
	}

	/**
	 * kriteria pencarian untuk dashboard
	 * @return \CActiveDataProvider
	 */
	public function searchDashboard() {
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria = new CDbCriteria;
		$criteria->together = true;
		$criteria->with = array('pemakaianbarang', 'barang');
		$criteria->compare('DATE(pemakaianbarang.tglpemakaianbrg)', date("Y-m-d"));
		$criteria->order = 'pemakaianbarang.tglpemakaianbrg ASC';
		$criteria->limit = 10;
		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
			'pagination' => false
		));
	}

}

?>
