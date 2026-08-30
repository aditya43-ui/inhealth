<?php

class HDLaporantindaklanjutrd extends LaporantindaklanjutrdV {

	public $jumlah;
	public $data;
	public $tick;
	public $tgl_awal, $tgl_akhir, $bln_awal, $bln_akhir,$thn_awal, $thn_akhir;
        public $jns_periode;

	public static function model($className = __CLASS__) {
		return parent::model($className);
	}

	public function getTindakLanjut() {

		return array(
			'PULANG'		 => 'Pulang',
			'RAWAT INAP'	 => 'Rawat Inap',
			'RAWAT JALAN'	 => 'Rawat Jalan',
		);
	}

	public function searchTable() {
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria = new CDbCriteria;

		if (!empty($this->carakeluar_id)) {
			$criteria->addInCondition('carakeluar_id',$this->carakeluar_id, 'AND');
		}else{
			$criteria->addCondition('carakeluar_id IS NULL');
		}
		
		$criteria->addBetweenCondition('date(tgl_pendaftaran)', $this->tgl_awal, $this->tgl_akhir);
		$criteria->compare('LOWER(nama_pasien)', strtolower($this->nama_pasien), true);
		$criteria->compare('LOWER(jeniskelamin)', strtolower($this->jeniskelamin), true);
		$criteria->compare('LOWER(no_rekam_medik)', strtolower($this->no_rekam_medik), true);
		$criteria->compare('LOWER(no_pendaftaran)', strtolower($this->no_pendaftaran), true);
		$criteria->compare('LOWER(umur)', strtolower($this->umur), true);
		$criteria->addCondition('ruangan_id = ' . Yii::app()->user->getState('ruangan_id'));
		$criteria->compare('LOWER(diagnosa_nama)', strtolower($this->diagnosa_nama), true);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}

	public function searchGrafik() {
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria = new CDbCriteria;

		if (!empty($this->carakeluar_id)) {
			$criteria->addInCondition('carakeluar_id',$this->carakeluar_id, 'AND');
		}else{
			$criteria->addCondition('carakeluar_id IS NULL');
		}

		$criteria->select = "count(pendaftaran_id) as jumlah, coalesce(carakeluar,'PULANG') as data";
		$criteria->group = 'carakeluar';

		$criteria->addBetweenCondition('date(tgl_pendaftaran)', $this->tgl_awal, $this->tgl_akhir);
		$criteria->compare('LOWER(nama_pasien)', strtolower($this->nama_pasien), true);
		$criteria->compare('LOWER(jeniskelamin)', strtolower($this->jeniskelamin), true);
		$criteria->compare('LOWER(no_rekam_medik)', strtolower($this->no_rekam_medik), true);
		$criteria->compare('LOWER(no_pendaftaran)', strtolower($this->no_pendaftaran), true);
		$criteria->compare('LOWER(umur)', strtolower($this->umur), true);
		$criteria->addCondition('ruangan_id = ' . Yii::app()->user->getState('ruangan_id'));
		$criteria->compare('LOWER(diagnosa_nama)', strtolower($this->diagnosa_nama), true);
		$criteria->compare('LOWER(nama_pasien)', strtolower($this->nama_pasien), true);
		$criteria->compare('LOWER(jeniskelamin)', strtolower($this->jeniskelamin), true);
		$criteria->compare('LOWER(no_rekam_medik)', strtolower($this->no_rekam_medik), true);
		$criteria->compare('LOWER(no_pendaftaran)', strtolower($this->no_pendaftaran), true);
		$criteria->compare('LOWER(umur)', strtolower($this->umur), true);
		$criteria->compare('LOWER(ruangan_nama)', strtolower($this->ruangan_nama), true);
		$criteria->compare('LOWER(diagnosa_nama)', strtolower($this->diagnosa_nama), true);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}

	public function searchPrint() {
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria = new CDbCriteria;

		if (!empty($this->carakeluar_id)) {
			$criteria->addInCondition('carakeluar_id',$this->carakeluar_id, 'AND');
		}else{
			$criteria->addCondition('carakeluar_id IS NULL');
		}
		
		$criteria->addBetweenCondition('date(tgl_pendaftaran)', $this->tgl_awal, $this->tgl_akhir);
		$criteria->compare('LOWER(nama_pasien)', strtolower($this->nama_pasien), true);
		$criteria->compare('LOWER(jeniskelamin)', strtolower($this->jeniskelamin), true);
		$criteria->compare('LOWER(no_rekam_medik)', strtolower($this->no_rekam_medik), true);
		$criteria->compare('LOWER(no_pendaftaran)', strtolower($this->no_pendaftaran), true);
		$criteria->compare('LOWER(umur)', strtolower($this->umur), true);
		$criteria->addCondition('ruangan_id = ' . Yii::app()->user->getState('ruangan_id'));
		$criteria->compare('LOWER(diagnosa_nama)', strtolower($this->diagnosa_nama), true);

		return new CActiveDataProvider($this, array(
			'criteria'	 => $criteria,
			'pagination' => false,
		));
	}
	
	public function getCaraKeluar() {
		$model = CarakeluarM::model()->findAll('carakeluar_id IN(1,4,6,7) AND carakeluar_aktif = true');
		$result = array();
		foreach ($model as $i => $v) {
			$result[$v->carakeluar_id] = ucwords(strtolower($v->carakeluar_nama));
		}

		return $result;
	}

}
