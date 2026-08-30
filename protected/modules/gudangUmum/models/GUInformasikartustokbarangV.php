<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class GUInformasikartustokbarangV extends InformasikartustokbarangV {

	public $tgl_awal, $tgl_akhir,$data,$idBarang,$namaBarang,$masuk,$keluar,$jumlah_sekarang;

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return GolonganumurM the static model class
	 */
	public static function model($className = __CLASS__) {
		return parent::model($className);
	}

	public function searchLaporan() {
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria = new CDbCriteria;

		$criteria->addBetweenCondition('date(invbarang_tgl)', $this->tgl_awal, $this->tgl_akhir);


		$criteria->limit = 10;

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}

	public function searchGrafik() {
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria = new CDbCriteria;

		$criteria->select = 'count(barang_id) as jumlah,barang_kode,barang_nama as data';
		$criteria->group = 'invbarang_tgl, barang_kode, barang_id,barang_nama';
		$criteria->addBetweenCondition('date(invbarang_tgl)', $this->tgl_awal, $this->tgl_akhir);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}

}

?>
