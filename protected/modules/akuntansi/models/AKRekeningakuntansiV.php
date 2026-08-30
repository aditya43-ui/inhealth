<?php

class AKRekeningakuntansiV extends RekeningakuntansiV {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return AnamnesaT the static model class
     */
    public $rekening1_id;
    public $id_temp_rek;
    public $rekening;
	public $rekperiod_id;
	public $tiperekening_id;
	public $matauang_id;
	public $jmlsaldoawald;
	public $jmlsaldoawalk;
	public $saldoawal_id;
	public $periodeposting_id;
	public $kursrp_id;

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function getInfoRekening() {
        $criteria = new CDbCriteria;
        if (!empty($this->rekening5_id)) {
            $criteria->addCondition("rekeninglast_id = " . $this->rekening5_id);
        }
        if (!empty($this->rekening4_id)) {
            $criteria->addCondition("rekening4_id = " . $this->rekening4_id);
        }
        if (!empty($this->rekening3_id)) {
            $criteria->addCondition("rekening3_id = " . $this->rekening3_id);
        }
        $criteria->order = 'rekening1_id, rekening2_id, rekening3_id, rekening4_id, rekeninglast_id, nourutrek';
        $result = AKRekeningakuntansiV::model()->find($criteria);
        return $result;
    }

    public function cariRekening() {
        $criteria = new CDbCriteria;

        $criteria->compare('LOWER(nmrekening1)', strtolower($this->nmrekening5), true, 'OR');
        $criteria->compare('LOWER(nmrekening2)', strtolower($this->nmrekening5), true, 'OR');
        $criteria->compare('LOWER(nmrekening3)', strtolower($this->nmrekening5), true, 'OR');
        $criteria->compare('LOWER(nmrekening4)', strtolower($this->nmrekening5), true, 'OR');
        $criteria->compare('LOWER(nmrekening5)', strtolower($this->nmrekening5), true, 'OR');

        $criteria->compare('LOWER(kdrekening1)', strtolower($this->kdrekening5), true, 'OR');
        $criteria->compare('LOWER(kdrekening2)', strtolower($this->kdrekening5), true, 'OR');
        $criteria->compare('LOWER(kdrekening3)', strtolower($this->kdrekening5), true, 'OR');
        $criteria->compare('LOWER(kdrekening4)', strtolower($this->kdrekening5), true, 'OR');
        $criteria->compare('LOWER(kdrekening5)', strtolower($this->kdrekening5), true, 'OR');

//        $criteria->compare('LOWER(nmrincianobyek)',strtolower($this->nmrincianobyek),true);
//        $criteria->compare('LOWER(nmrincianobyeklain)',strtolower($this->nmrincianobyeklain),true);
//        $criteria->addCondition('kdrincianobyek IS NOT NULL');

        $criteria->compare('lower(rekening5_nb)', strtolower($this->rekening5_nb));
        $criteria->order = 'rekening1_id, rekening2_id, rekening3_id, rekening4_id, rekening5_id, nourutrek';

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
                )
        );
    }

    public function getKodeRekening() {
        if (isset($this->rekening5_id)) {
            $kode_rekening = $this->kdrekening1 . "-" . $this->kdrekening2 . "-" . $this->kdrekening3 . "-" . $this->kdrekening4 . "-" . $this->kdrekening5;
        } else {
            if (isset($this->rekening4_id)) {
                $kode_rekening = $this->kdrekening1 . "-" . $this->kdrekening2 . "-" . $this->kdrekening3 . "-" . $this->kdrekening4;
            } else {
                $kode_rekening = $this->kdrekening1 . "-" . $this->kdrekening2 . "-" . $this->kdrekening3;
            }
        }

        return $kode_rekening;
    }

    public function getNamaRekening() {
        if (isset($this->rekeninglast_id)) {
            $kode_rekening = $this->nmrekeninglast;
        } else {
            if (isset($this->rekening4_id)) {
                $kode_rekening = $this->nmrekening4;
            } else {
                $kode_rekening = $this->nmrekening4;
            }
        }

        return $kode_rekening;
    }

    public function getIdRekening() {
        if (isset($this->rekeninglast_id)) {
            $kode_rekening = $this->rekeninglast_id;
        } else {
            if (isset($this->rekening4_id)) {
                $kode_rekening = $this->rekening4_id;
            } else {
                $kode_rekening = $this->rekening3_id;
            }
        }
        return $kode_rekening;
    }

    public function searchByFilter() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        if (!empty($this->rekening1_id)) {
            $criteria->addCondition("rekening1_id = " . $this->rekening1_id);
        }
        $criteria->compare('LOWER(kdrekening1)', strtolower($this->kdrekening1), true);
        $criteria->compare('LOWER(nmrekening1)', strtolower($this->nmrekening1), true);
        $criteria->compare('LOWER(nmrekeninglain1)', strtolower($this->nmrekeninglain1), true);
//        $criteria->compare('LOWER(rekening1_nb)', strtolower($this->rekening1_nb), true);
        $criteria->compare('rekening1_aktif', $this->rekening1_aktif);
        if (!empty($this->rekening2_id)) {
            $criteria->addCondition("rekening2_id = " . $this->rekening2_id);
        }
        $criteria->compare('LOWER(kdrekening2)', strtolower($this->kdrekening2), true);
        $criteria->compare('LOWER(nmrekening2)', strtolower($this->nmrekening2), true);
        $criteria->compare('LOWER(nmrekeninglain2)', strtolower($this->nmrekeninglain2), true);
//        $criteria->compare('LOWER(rekening2_nb)', strtolower($this->rekening2_nb), true);
        $criteria->compare('rekening2_aktif', $this->rekening2_aktif);
        if (!empty($this->rekening3_id)) {
            $criteria->addCondition("rekening3_id = " . $this->rekening3_id);
        }
        $criteria->compare('LOWER(kdrekening3)', strtolower($this->kdrekening3), true);
        $criteria->compare('LOWER(nmrekening3)', strtolower($this->nmrekening3), true);
        $criteria->compare('LOWER(nmrekeninglain3)', strtolower($this->nmrekeninglain3), true);
//        $criteria->compare('LOWER(rekening3_nb)', strtolower($this->rekening3_nb), true);
        $criteria->compare('rekening3_aktif', $this->rekening3_aktif);
        if (!empty($this->rekening4_id)) {
            $criteria->addCondition("rekening4_id = " . $this->rekening4_id);
        }
        $criteria->compare('LOWER(kdrekening4)', strtolower($this->kdrekening4), true);
        $criteria->compare('LOWER(nmrekening4)', strtolower($this->nmrekening4), true);
        $criteria->compare('LOWER(nmrekeninglain4)', strtolower($this->nmrekeninglain4), true);
//        $criteria->compare('LOWER(rekening4_nb)', strtolower($this->rekening4_nb), true);
        $criteria->compare('rekening4_aktif', $this->rekening4_aktif);
        if (!empty($this->rekening5_id)) {
            $criteria->addCondition("rekening5_id = " . $this->rekening5_id);
        }
        $criteria->compare('LOWER(kdrekening5)', strtolower($this->kdrekening5), true);
        $criteria->compare('LOWER(nmrekening5)', strtolower($this->nmrekening5), true);
        $criteria->compare('LOWER(nmrekeninglain5)', strtolower($this->nmrekeninglain5), true);
//        $criteria->compare('LOWER(rekening5_nb)', strtolower($this->rekening5_nb), true);
        $criteria->compare('LOWER(keterangan)', strtolower($this->keterangan), true);
        $criteria->compare('nourutrek', $this->nourutrek);
        $criteria->compare('rekening5_aktif', $this->rekening5_aktif);
        $criteria->compare('LOWER(kelompokrek)', strtolower($this->kelompokrek), true);
        $criteria->compare('sak', $this->sak);
        $criteria->compare('LOWER(create_time)', strtolower($this->create_time), true);
        $criteria->compare('LOWER(update_time)', strtolower($this->update_time), true);
        $criteria->compare('LOWER(create_loginpemakai_id)', strtolower($this->create_loginpemakai_id), true);
        $criteria->compare('LOWER(update_loginpemakai_id)', strtolower($this->update_loginpemakai_id), true);
        $criteria->compare('LOWER(create_ruangan)', strtolower($this->create_ruangan), true);
//        $condition = 'rincianobyek_id IS NOT NULL';
//        $criteria->addCondition($condition);
        $criteria->order = 'rekening1_id, rekening2_id, rekening3_id, rekening4_id, nourutrek';

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function searchByFilterPrint() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        if (!empty($this->rekening1_id)) {
            $criteria->addCondition("rekening1_id = " . $this->rekening1_id);
        }
        $criteria->compare('LOWER(kdrekening1)', strtolower($this->kdrekening1), true);
        $criteria->compare('LOWER(nmrekening1)', strtolower($this->nmrekening1), true);
        $criteria->compare('LOWER(nmrekeninglain1)', strtolower($this->nmrekeninglain1), true);
//        $criteria->compare('LOWER(rekening1_nb)', strtolower($this->rekening1_nb), true);
        $criteria->compare('rekening1_aktif', $this->rekening1_aktif);
        if (!empty($this->rekening2_id)) {
            $criteria->addCondition("rekening2_id = " . $this->rekening2_id);
        }
        $criteria->compare('LOWER(kdrekening2)', strtolower($this->kdrekening2), true);
        $criteria->compare('LOWER(nmrekening2)', strtolower($this->nmrekening2), true);
        $criteria->compare('LOWER(nmrekeninglain2)', strtolower($this->nmrekeninglain2), true);
//        $criteria->compare('LOWER(rekening2_nb)', strtolower($this->rekening2_nb), true);
        $criteria->compare('rekening2_aktif', $this->rekening2_aktif);
        if (!empty($this->rekening3_id)) {
            $criteria->addCondition("rekening3_id = " . $this->rekening3_id);
        }
        $criteria->compare('LOWER(kdrekening3)', strtolower($this->kdrekening3), true);
        $criteria->compare('LOWER(nmrekening3)', strtolower($this->nmrekening3), true);
        $criteria->compare('LOWER(nmrekeninglain3)', strtolower($this->nmrekeninglain3), true);
//        $criteria->compare('LOWER(rekening3_nb)', strtolower($this->rekening3_nb), true);
        $criteria->compare('rekening3_aktif', $this->rekening3_aktif);
        if (!empty($this->rekening4_id)) {
            $criteria->addCondition("rekening4_id = " . $this->rekening4_id);
        }
        $criteria->compare('LOWER(kdrekening4)', strtolower($this->kdrekening4), true);
        $criteria->compare('LOWER(nmrekening4)', strtolower($this->nmrekening4), true);
        $criteria->compare('LOWER(nmrekeninglain4)', strtolower($this->nmrekeninglain4), true);
//        $criteria->compare('LOWER(rekening4_nb)', strtolower($this->rekening4_nb), true);
        $criteria->compare('rekening4_aktif', $this->rekening4_aktif);
        if (!empty($this->rekening5_id)) {
            $criteria->addCondition("rekening5_id = " . $this->rekening5_id);
        }
        $criteria->compare('LOWER(kdrekening5)', strtolower($this->kdrekening5), true);
        $criteria->compare('LOWER(nmrekening5)', strtolower($this->nmrekening5), true);
        $criteria->compare('LOWER(nmrekeninglain5)', strtolower($this->nmrekeninglain5), true);
//        $criteria->compare('LOWER(rekening5_nb)', strtolower($this->rekening5_nb), true);
        $criteria->compare('LOWER(keterangan)', strtolower($this->keterangan), true);
        $criteria->compare('nourutrek', $this->nourutrek);
        $criteria->compare('rekening5_aktif', $this->rekening5_aktif);
        $criteria->compare('LOWER(kelompokrek)', strtolower($this->kelompokrek), true);
        $criteria->compare('sak', $this->sak);
        $criteria->compare('LOWER(create_time)', strtolower($this->create_time), true);
        $criteria->compare('LOWER(update_time)', strtolower($this->update_time), true);
        $criteria->compare('LOWER(create_loginpemakai_id)', strtolower($this->create_loginpemakai_id), true);
        $criteria->compare('LOWER(update_loginpemakai_id)', strtolower($this->update_loginpemakai_id), true);
        $criteria->compare('LOWER(create_ruangan)', strtolower($this->create_ruangan), true);
//        $condition = 'rincianobyek_id IS NOT NULL';
//        $criteria->addCondition($condition);
        $criteria->limit = -1;
        $criteria->order = 'rekening1_id, rekening2_id, rekening3_id, rekening4_id, nourutrek';

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => false,
        ));
    }

    protected function afterFind() {
        if (isset($this->rekening5_id)) {
            $this->id_temp_rek = 'rekening5_id' . 'x' . $this->rekening5_id;
        } else {
            if (isset($this->obyek_id)) {
                $this->id_temp_rek = 'rekening4_id' . 'x' . $this->rekening4_id;
            } else {
                $this->id_temp_rek = 'rekening3_id' . 'x' . $this->rekening3_id;
            }
        }
        return true;
    }

	public function searchDebit() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = $this->criteriaSearch();
        $criteria->addCondition("rekening5_nb = 'D'");

        $criteria->limit = 10;

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function searchKredit() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = $this->criteriaSearch();
        $criteria->addCondition("rekening5_nb = 'K'");

        $criteria->limit = 10;

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

//    public function searchAccounts($account = null) {
//
//        $criteria = new CDbCriteria;
//
//        $criteria->compare('struktur_id', $this->struktur_id);
//        $criteria->compare('LOWER(kdstruktur)', strtolower($this->kdstruktur), true);
//        $criteria->compare('LOWER(nmstruktur)', strtolower($this->nmstruktur), true, 'OR');
//        $criteria->compare('LOWER(nmstrukturlain)', strtolower($this->nmstrukturlain), true, 'OR');
//        $criteria->compare('LOWER(struktur_nb)', strtolower($this->struktur_nb), true);
//        $criteria->compare('struktur_aktif', $this->struktur_aktif);
//        $criteria->compare('kelompok_id', $this->kelompok_id);
//        $criteria->compare('LOWER(kdkelompok)', strtolower($this->kdkelompok), true);
//        $criteria->compare('LOWER(nmkelompok)', strtolower($this->nmkelompok), true . 'OR');
//        $criteria->compare('LOWER(nmkelompoklain)', strtolower($this->nmkelompoklain), true, 'OR');
//        $criteria->compare('LOWER(kelompok_nb)', strtolower($this->kelompok_nb), true);
//        $criteria->compare('kelompok_aktif', $this->kelompok_aktif);
//        $criteria->compare('jenis_id', $this->jenis_id);
//        $criteria->compare('LOWER(kdjenis)', strtolower($this->kdjenis), true);
//        $criteria->compare('LOWER(nmjenis)', strtolower($this->nmjenis), true, 'OR');
//        $criteria->compare('LOWER(nmjenislain)', strtolower($this->nmjenislain), true, 'OR');
//        $criteria->compare('LOWER(jenis_nb)', strtolower($this->jenis_nb), true);
//        $criteria->compare('jenis_aktif', $this->jenis_aktif);
//        $criteria->compare('obyek_id', $this->obyek_id);
//        $criteria->compare('LOWER(kdobyek)', strtolower($this->kdobyek), true);
//        $criteria->compare('LOWER(nmobyek)', strtolower($this->nmobyek), true, 'OR');
//        $criteria->compare('LOWER(nmobyeklain)', strtolower($this->nmobyeklain), true, 'OR');
//        $criteria->compare('LOWER(obyek_nb)', strtolower($this->obyek_nb), true);
//        $criteria->compare('obyek_aktif', $this->obyek_aktif);
//        $criteria->compare('rincianobyek_id', $this->rincianobyek_id);
//        $criteria->compare('LOWER(kdrincianobyek)', strtolower($this->kdrincianobyek), true);
//        $criteria->compare('LOWER(nmrincianobyek)', strtolower($this->nmrincianobyek), true, 'OR');
//        $criteria->compare('LOWER(nmrincianobyeklain)', strtolower($this->nmrincianobyeklain), true, 'OR');
//        $criteria->compare('LOWER(rincianobyek_nb)', strtolower($account), true);
//        $criteria->compare('LOWER(keterangan)', strtolower($this->keterangan), true);
//        $criteria->compare('nourutrek', $this->nourutrek);
//        $criteria->compare('rincianobyek_aktif', $this->rincianobyek_aktif);
//        $criteria->compare('LOWER(kelompokrek)', strtolower($this->kelompokrek), true);
//        $criteria->compare('sak', $this->sak);
//        $criteria->compare('LOWER(create_time)', strtolower($this->create_time), true);
//        $criteria->compare('LOWER(update_time)', strtolower($this->update_time), true);
//        $criteria->compare('LOWER(create_loginpemakai_id)', strtolower($this->create_loginpemakai_id), true);
//        $criteria->compare('LOWER(update_loginpemakai_id)', strtolower($this->update_loginpemakai_id), true);
//        $criteria->compare('LOWER(create_ruangan)', strtolower($this->create_ruangan), true);
//
//        $criteria->select = "concat_ws('.', kdstruktur::text, kdkelompok::text, kdjenis::text ,kdobyek::text ,kdrincianobyek::text) as rekening,
//							struktur_id,kelompok_id,jenis_id,obyek_id,rincianobyek_id,
//							nourutrek,nmrincianobyek,nmobyek,nmjenis,nmkelompok,nmstruktur,nmrincianobyeklain,nmobyeklain,nmjenislain,nmkelompoklain,nmstrukturlain,rincianobyek_nb";
//        if (!empty($this->rekening)) {
//            $criteria->compare("LOWER(concat_ws('.', kdstruktur::text, kdkelompok::text, kdjenis::text ,kdobyek::text ,kdrincianobyek::text))", strtolower($this->rekening), true);
//        }
//
//        return new CActiveDataProvider($this, array(
//            'criteria' => $criteria,
//        ));
//    }

	public function searchSaldoAwal(){
		$criteria = new CDbCriteria();
		if (!empty($this->rekperiod_id)){
			//$criteria->addCondition(" sa.rekperiod_id = ".$this->rekperiod_id);



				$criteria->select = " "
					. "t.nmrekening5, "
					. "t.kdrekening5, "
					. "t.rekening5_id, "
					. "t.rekening4_id, "
					. "t.rekening3_id, "
					. "t.rekening4_id, "
					. "t.rekening2_id, "
					. "t.rekening1_id, "
					. " ".$this->rekperiod_id." as rekperiod_id, "
					. " ".$this->periodeposting_id." as periodeposting_id, "
					. "(SELECT " //saldoawal_id
					. "		sa.saldoawal_id "
					. "	FROM "
					. "		saldoawal_t sa "
					. "	WHERE sa.rekening5_id = t.rekening5_id AND sa.rekperiod_id = ".$this->rekperiod_id.") as saldoawal_id,"
					. "(SELECT " //matauang_id
					. "		sa.matauang_id "
					. "	FROM "
					. "		saldoawal_t sa "
					. "	WHERE sa.rekening5_id = t.rekening5_id AND sa.rekperiod_id = ".$this->rekperiod_id.") as matauang_id,"
					. "(SELECT " //kursrp_id
					. "		sa.kursrp_id "
					. "	FROM "
					. "		saldoawal_t sa "
					. "	WHERE sa.rekening5_id = t.rekening5_id AND sa.rekperiod_id = ".$this->rekperiod_id.") as kursrp_id,"
					. " (SELECT "  //saldoawal_awal
					. "		sa.jmlsaldoawald "
					. "	FROM "
					. "		saldoawal_t sa "
					. "	WHERE sa.rekening5_id = t.rekening5_id AND sa.rekperiod_id = ".$this->rekperiod_id.") jmlsaldoawald, "
					. " (SELECT "  //saldoawal_akhir
					. "		sa.jmlsaldoawalk "
					. "	FROM "
					. "		saldoawal_t sa "
					. "	WHERE sa.rekening5_id = t.rekening5_id AND sa.rekperiod_id = ".$this->rekperiod_id.") jmlsaldoawalk ";
		}else{
			//$criteria->addCondition(" sa.rekperiod_id = 999999");
		}
		$criteria->join = " LEFT JOIN rekening5_m r5 ON r5.rekening5_id = t.rekening5_id ";
		//				. "	LEFT JOIN saldoawal_t sa ON sa.rekening5_id =  t.rekening5_id ";

		if (!empty($this->tiperekening_id)){
			$criteria->addCondition(" r5.tiperekening_id = ".$this->tiperekening_id);
		}else{
			$criteria->addCondition(" r5.tiperekening_id = 999999");
		}

		if (!empty($this->rekperiod_id)){
			//$criteria->addCondition(" sa.rekperiod_id = ".$this->rekperiod_id);
		}else{
			//$criteria->addCondition(" sa.rekperiod_id = 999999");
		}

		$criteria->order = " t.kdrekening5 ";

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>false,
		));
	}

	public function searchSaldoAwalPrint(){
		$criteria = new CDbCriteria();
		if (!empty($this->rekperiod_id)){
			//$criteria->addCondition(" sa.rekperiod_id = ".$this->rekperiod_id);



				$criteria->select = " "
					. "t.nmrekening5, "
					. "t.kdrekening5, "
					. "t.rekening5_id, "
					. "t.rekening4_id, "
					. "t.rekening3_id, "
					. "t.rekening4_id, "
					. "t.rekening2_id, "
					. "t.rekening1_id, "
					. " ".$this->rekperiod_id." as rekperiod_id, "
					. " ".$this->periodeposting_id." as periodeposting_id, "
					. "(SELECT " //saldoawal_id
					. "		sa.saldoawal_id "
					. "	FROM "
					. "		saldoawal_t sa "
					. "	WHERE sa.rekening5_id = t.rekening5_id AND sa.rekperiod_id = ".$this->rekperiod_id.") as saldoawal_id,"
					. "(SELECT " //matauang_id
					. "		sa.matauang_id "
					. "	FROM "
					. "		saldoawal_t sa "
					. "	WHERE sa.rekening5_id = t.rekening5_id AND sa.rekperiod_id = ".$this->rekperiod_id.") as matauang_id,"
					. "(SELECT " //kursrp_id
					. "		sa.kursrp_id "
					. "	FROM "
					. "		saldoawal_t sa "
					. "	WHERE sa.rekening5_id = t.rekening5_id AND sa.rekperiod_id = ".$this->rekperiod_id.") as kursrp_id,"
					. " (SELECT "  //saldoawal_awal
					. "		sa.jmlsaldoawald "
					. "	FROM "
					. "		saldoawal_t sa "
					. "	WHERE sa.rekening5_id = t.rekening5_id AND sa.rekperiod_id = ".$this->rekperiod_id.") jmlsaldoawald, "
					. " (SELECT "  //saldoawal_akhir
					. "		sa.jmlsaldoawalk "
					. "	FROM "
					. "		saldoawal_t sa "
					. "	WHERE sa.rekening5_id = t.rekening5_id AND sa.rekperiod_id = ".$this->rekperiod_id.") jmlsaldoawalk ";
		}else{
			//$criteria->addCondition(" sa.rekperiod_id = 999999");
		}
		$criteria->join = " LEFT JOIN rekening5_m r5 ON r5.rekening5_id = t.rekening5_id ";
		//				. "	LEFT JOIN saldoawal_t sa ON sa.rekening5_id =  t.rekening5_id ";

		if (!empty($this->tiperekening_id)){
			//$criteria->addCondition(" r5.tiperekening_id = ".$this->tiperekening_id);
		}else{
			//$criteria->addCondition(" r5.tiperekening_id = 999999");
		}

		if (!empty($this->rekperiod_id)){
			//$criteria->addCondition(" sa.rekperiod_id = ".$this->rekperiod_id);
		}else{
			//$criteria->addCondition(" sa.rekperiod_id = 999999");
		}

		$criteria->order = " t.kdrekening5 ";

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>false,
		));
	}

}



?>
