<?php

class ASPasienM extends PasienM {

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AnamnesaT the static model class
	 */
	public $idInstalasi, $ruangan_nama, $carabayar_nama, $tgl_pendaftaran_cari, $instalasi_nama, $no_pendaftaran, $tgl_pendaftaran;
	public $cari_no_rekam_medik, $cari_nama_pasien, $pekerjaan_nama, $umur, $instalasi_id, $ruangan_id, $carabayar_id, $kamarruangan_nobed;

	public static function model($className = __CLASS__) {
		return parent::model($className);
	}

	/**
	 * menampilkan data kunjungan pasien RJ / RD / RI untuk dialog box
	 * @return \CActiveDataProvider
	 */
	public function searchDialogKunjungan() {
        
		$format = new MyFormatter;
		$model = null;
		$criteria = new CDbCriteria();
                // $tgl_pendaftaran = $this->getKonverviDateRange($this->tgl_pendaftaran);
		$criteria->compare('LOWER(no_pendaftaran)', strtolower($this->no_pendaftaran), true);
//		$this->tgl_pendaftaran = !empty($this->tgl_pendaftaran) ? $format->formatDateTimeForDb($this->tgl_pendaftaran) : date("Y-m-d");
		$criteria->compare('LOWER(no_rekam_medik)', strtolower($this->no_rekam_medik), true);
		$criteria->compare('LOWER(nama_pasien)', strtolower($this->nama_pasien), true);
		$criteria->compare("instalasi_id", $this->instalasi_id);
		if (!empty($this->ruangan_id)) {
			$criteria->addCondition("ruangan_id = " . $this->ruangan_id);
		}
		if (!empty($this->carabayar_id)) {
			$criteria->addCondition("carabayar_id = " . $this->carabayar_id);
		}
		if (!empty($this->pendaftaran_id)) {
			$criteria->addCondition("pendaftaran_id = " . $this->pendaftaran_id);
		}
		$criteria->compare('LOWER(jeniskelamin)', strtolower($this->jeniskelamin), true);
		$criteria->compare('LOWER(ruangan_nama)', strtolower($this->ruangan_nama), true);
		$criteria->compare('LOWER(carabayar_nama)', strtolower($this->carabayar_nama), true);
		//$criteria->limit = 5;
                $sort_default = 't.tgl_pendaftaran DESC';
		if ($this->instalasi_id == Params::INSTALASI_ID_RD) {
//			$criteria->addBetweenCondition("DATE(tgl_pendaftaran)",$this->tgl_pendaftaran." 00:00:00",$this->tgl_pendaftaran." 23:59:59");
                        // $criteria->addBetweenCondition('DATE(tgl_pendaftaran)', $tgl_pendaftaran[0]." 00:00:00", $tgl_pendaftaran[1]." 23:59:59");
			$model = new InfokunjunganrdV;
		} else if ($this->instalasi_id == Params::INSTALASI_ID_RJ) {
//                      $criteria->addBetweenCondition("DATE(tgl_pendaftaran)",$this->tgl_pendaftaran." 00:00:00",$this->tgl_pendaftaran." 23:59:59");
                        // $criteria->addBetweenCondition('DATE(tgl_pendaftaran)', $tgl_pendaftaran[0]." 00:00:00", $tgl_pendaftaran[1]." 23:59:59");
			$model = new InfokunjunganrjV;
		} else if ($this->instalasi_id == Params::INSTALASI_ID_HD) {
            $model = new InfokunjunganhdV;
        } else {
//                      $criteria->addBetweenCondition("DATE(tglmasukkamar)",$this->tgl_pendaftaran." 00:00:00",$this->tgl_pendaftaran." 23:59:59");
                        // $criteria->addBetweenCondition('DATE(tglmasukkamar)', $tgl_pendaftaran[0]." 00:00:00", $tgl_pendaftaran[1]." 23:59:59");
			$model = new ASInfopasienmasukkamarV; //default
                        $sort_default = 't.tgladmisi DESC';
		}
//		$this->tgl_pendaftaran = $format->formatDateTimeForUser($this->tgl_pendaftaran);
		return new CActiveDataProvider($model, array(
			'criteria' => $criteria,
			'pagination' => array(
                            'pageSize'=>5
                        ),
                        'sort'=>[
                            'defaultOrder'=>$sort_default
                        ]
		));
	}
        
        public function getKonverviDateRange($tgl){
            $Tgl = (explode(" - ",$tgl));

            //harus di format date dulu karena hasil dri widget tidak sama seperti format DB
            $Tgl[0] = DateTime::createFromFormat('m/d/Y', $Tgl[0]);
            $Tgl[0] = $Tgl[0]->format('Y-m-d');
            $Tgl[1] = DateTime::createFromFormat('m/d/Y', $Tgl[1]);
            $Tgl[1] = $Tgl[1]->format('Y-m-d');
            return array($Tgl[0],$Tgl[1]);
        }

}
