<?php

class AKLaporanrasioR extends LaporanrasioR {

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AKLaporanrasioR the static model class
	 */
	public $tgl_awal, $tgl_akhir, $thn_awal, $thn_akhir, $tahun, $bulan, $tglperiodeposting_awal, $tglperiodeposting_akhir;

	public static function model($className = __CLASS__) {
		return parent::model($className);
	}

	public function criteriaSearch() {
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		if (empty($this->tahun)) {
			$this->tahun = date('Y');
		}
		$criteria = new CDbCriteria;
		$criteria->join = 'JOIN periodeposting_m AS periodeposting ON periodeposting.periodeposting_id = t.periodeposting_id';

		if (!empty($this->bulan)) {
			if (is_array($this->bulan)) {
				$tgl_awal = array();
				foreach ($this->bulan as $data) {
					$temp_tgl = $this->tahun . '-' . $data . '-01';
					array_push($tgl_awal, $temp_tgl);
				}
				$criteria->addInCondition('periodeposting.tglperiodeposting_awal', $tgl_awal);
			} else {
				$tgl_awal = $this->tahun . '-' . $this->bulan . '-01';
				$criteria->compare('periodeposting.tglperiodeposting_awal', $tgl_awal);
			}
		} else {
			$tgl_awal = $this->tahun . '-01-01';
			$criteria->compare('periodeposting.tglperiodeposting_awal', $tgl_awal);
		}
		return $criteria;
	}

	public function search() {
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria = $this->criteriaSearch();

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
			'pagination' => false,
		));
	}

	public function searchLaporan() {
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
		$criteria = $this->criteriaSearch();
		$criteria->group = "periodeposting.tglperiodeposting_awal,tglperiodeposting_akhir";
		$criteria->select = $criteria->group;
		$criteria->order = "tglperiodeposting_awal DESC,tglperiodeposting_akhir DESC";
		return $criteria;
	}

}

?>