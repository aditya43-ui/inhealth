<?php

class SAPeriodepostingM extends PeriodepostingM {

	public $deskripsiperiode;

	public static function model($className = __CLASS__) {
		return parent::model($className);
	}

	public function getTglPeriode() {
		$next_year = date('Y-m-d', mktime(0, 0, 0, date("m"), date("d"), date("Y") + 1));
		$criteria = new CDbCriteria();
		$criteria->addCondition('DATE(tglanggaran) <=\'' . $next_year . '\'');
		$criteria->addCondition('DATE(sd_tglanggaran) >= \'' . $next_year . '\'');
		if (!empty($this->konfiganggaran_id)) {
			$criteria->addCondition('konfiganggaran_id = ' . $this->konfiganggaran_id);
		}
		$criteria->compare('LOWER(deskripsiperiode)', strtolower($this->deskripsiperiode), true);
		$criteria->order = "sd_tglanggaran";
		$criteria->addCondition("isclosing_anggaran IS FALSE");
		$periodes = KonfiganggaranK::model()->findAll($criteria);
		foreach ($periodes as $i => $periode) {
			$periodes[$i]->deskripsiperiode = $periode->deskripsiperiode;
		}
		return $periodes;
	}

	public function criteriaSearch() {
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria = new CDbCriteria;

		if (!empty($this->periodeposting_id)) {
			$criteria->addCondition('periodeposting_id = ' . $this->periodeposting_id);
		}
		if (!empty($this->konfiganggaran_id)) {
			$criteria->addCondition('konfiganggaran_id = ' . $this->konfiganggaran_id);
		}
		$criteria->compare('LOWER(periodeposting_nama)', strtolower($this->periodeposting_nama), true);
		$criteria->compare('LOWER(tglperiodeposting_awal)', strtolower($this->tglperiodeposting_awal), true);
		$criteria->compare('LOWER(tglperiodeposting_akhir)', strtolower($this->tglperiodeposting_akhir), true);
		$criteria->compare('LOWER(deskripsiperiodeposting)', strtolower($this->deskripsiperiodeposting), true);
		$criteria->compare('LOWER(create_time)', strtolower($this->create_time), true);
		$criteria->compare('LOWER(update_time)', strtolower($this->update_time), true);
		if (!empty($this->create_loginpemakai_id)) {
			$criteria->addCondition('create_loginpemakai_id = ' . $this->create_loginpemakai_id);
		}
		if (!empty($this->update_loginpemakai_id)) {
			$criteria->addCondition('update_loginpemakai_id = ' . $this->update_loginpemakai_id);
		}
		if (!empty($this->create_ruangan)) {
			$criteria->addCondition('create_ruangan = ' . $this->create_ruangan);
		}
		//$criteria->compare('periodeposting_aktif',$this->periodeposting_aktif);
		if (!empty($this->rekperiode_id)) {
			$criteria->addCondition('rekperiode_id = ' . $this->rekperiode_id);
		}
		$criteria->compare('periodeposting_aktif', isset($this->periodeposting_aktif) ? $this->periodeposting_aktif : true);

		return $criteria;
	}

	public function checkPeriodePosting($start_date, $end_date) {
		$sql = "
		SELECT 
		count(periodeposting_id) as periodeposting_id
		FROM periodeposting_m
		WHERE '" . $start_date . "' < DATE(tglperiodeposting_akhir) 
			AND '" . $end_date . "' > DATE(tglperiodeposting_awal)
		";
        return $result = Yii::app()->db->createCommand($sql)->queryRow();
	}

}
