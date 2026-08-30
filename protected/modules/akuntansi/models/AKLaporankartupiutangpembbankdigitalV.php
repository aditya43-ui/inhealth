<?php

class AKLaporankartupiutangpembbankdigitalV extends LaporankartupiutangpembbankdigitalV
{
	public $tgl_awal, $tgl_akhir;

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return BankM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * - digunakan untuk mengenerate data di tabel  kartu hutang
	 * @return \CActiveDataProvider
	 */
	public function searchTable(){
		$criteria = $this->searchCriteria();

		$criteria->order = " tglpembayaran ASC, nourut ASC ";

		return new CActiveDataProvider($this, array(
			   'criteria'=>$criteria,
		));
	}

	/**
	 * - digunakan untuk mengenerate data di tabel  kartu hutang  pada prinout
	 * @return \CActiveDataProvider
	 */
	public function searchPrint(){
		$criteria = $this->searchCriteria();
		$criteria->order = " det.tgltransaksi ASC, det.debitkredit DESC ";
		return new CActiveDataProvider($this, array(
			   'criteria'=>$criteria,
			   'pagination' => false
		));
	}

	/**
	 * - digunakan untuk mengenerate data target bep dalam bentuk grafik
	 * @return \CActiveDataProvider
	 */
	public function searchGrafik(){
		$criteria = $this->searchCriteria();
		$criteria->select = " count(daftartindakan_id) as jumlah, instalasi_nama as data ";
		$criteria->group = " data ";
		$criteria->order = " jumlah DESC ";
		//if ($_GET['tampilGrafik'] == 'wilayah'){

		 return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
		));
	}

	/**
	 * - digunakan untuk memfilter datanya berdasarkan pencarian yang ada
	 * @return \CActiveDataProvider
	 */
	public function searchCriteria(){
		$criteria = new CDbCriteria();
		if (!empty($this->jnspembayar_id)){
			if (is_array($this->jnspembayar_id)){
				$criteria->addInCondition(" jnspembayar_id ", $this->jnspembayar_id);
			}else{
				$criteria->addCondition(" jnspembayar_id = ". $this->jnspembayar_id);
			}
		}

		if (!empty($this->bank_id)){
			if (is_array($this->bank_id)){
				$criteria->addInCondition(" jnspembayar_id ", $this->bank_id);
			}else{
				$criteria->addCondition(" jnspembayar_id = ". $this->bank_id);
			}
		}

		$criteria->addBetweenCondition('DATE(tglpembayaran)', $this->tgl_awal, $this->tgl_akhir);

		return $criteria;
	}

}

?>
