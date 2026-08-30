<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class MAPemakaianbarangT extends PemakaianbarangT {

    public $barang_nama,$jmlpakai;
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
	public function searchDashboardMA() {
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria = new CDbCriteria;
		$criteria->select = 't.nopemakaianbrg,t.tglpemakaianbrg,barang_m.barang_nama,pemakaianbrgdetail_t.jmlpakai,t.keteranganpakai';
		$criteria->join = 'JOIN pemakaianbrgdetail_t ON pemakaianbrgdetail_t.pemakaianbarang_id=t.pemakaianbarang_id
							JOIN barang_m ON barang_m.barang_id=pemakaianbrgdetail_t.barang_id';
		$criteria->order = 't.tglpemakaianbrg DESC';
		$criteria->limit = 10;
		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
			'pagination' => false
		));
	}

}

?>
