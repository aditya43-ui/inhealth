<?php
class BSLaporantindakankomponenV extends LaporantindakankomponenV
{
        public $tgl_awal,$tgl_akhir;
        public $jns_periode,$bln_awal,$bln_akhir,$thn_awal,$thn_akhir;
		public $data, $jumlah;
		public $totaljasa_komponen;
		public $daftartindakan_periksa;
		public $total_tarifkomp;
		public $total_qty;
        public $tglpembayaran, $nopembayaran;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        // -- REKAP JASA DOKTER -- //
        
	public function searchJasaDokter()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
                
		$criteria->group = 't.instalasi_nama, t.ruangan_nama, t.gelarbelakang_nama, t.gelardepan, t.namadepan, t.nama_pasien,t.ruangan_id,t.ruangan_nama,t.no_rekam_medik,t.no_pendaftaran,t.tgl_pendaftaran,t.tgl_keluar,t.kelaspelayanan_nama,t.nama_pegawai,t.daftartindakan_nama,t.tarif_tindakankomp';
		$criteria->select = $criteria->group;
		$criteria->addBetweenCondition('date(t.tgl_pendaftaran)',$this->tgl_awal,$this->tgl_akhir,true);
		//$criteria->compare("t.komponentarif_id", Params::KOMPONENTARIF_ID_JASA_MEDIS);   
		//$criteria->compare("p.kelompokkomponentarif_id", 1);
		$criteria->addInCondition(" t.komponentarif_id ", Params::getKomponenTarifLapJasaDokter());
		$criteria->join = "join persenkelkomponentarif_m p on p.komponentarif_id = t.komponentarif_id";
		
                if(!empty($this->pegawai_id)){
			$criteria->addInCondition('t.pegawai_id', $this->pegawai_id);
		}
                if (!empty($this->ruangan_id)){
                    $criteria->addCondition('t.ruangan_id = '.$this->ruangan_id);
                }
		$criteria->order = " tgl_pendaftaran ASC ";
				
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function searchRekapJasaDokter()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
                
        $criteria->join = 'join pembayaranpelayanan_t pp on pp.pendaftaran_id = t.pendaftaran_id '
                . 'join persenkelkomponentarif_m pk on pk.komponentarif_id = t.komponentarif_id '
                . 'join tindakanpelayanan_t tp on tp.tindakanpelayanan_id = t.tindakanpelayanan_id '
                . 'left join pasienmasukpenunjang_t mp on mp.pasienmasukpenunjang_id = tp.pasienmasukpenunjang_id '
                . 'left join pasienkirimkeunitlain_t ul on ul.pasienkirimkeunitlain_id = mp.pasienkirimkeunitlain_id '
                . 'left join rencanaoperasi_t op on op.rencanaoperasi_id = tp.rencanaoperasi_id '
                . 'left join pasienanastesi_t pa on pa.rencanaoperasi_id = op.rencanaoperasi_id ';
		$criteria->group = 't.komponentarif_nama, t.nama_pegawai, t.gelardepan, t.gelarbelakang_nama, pp.tglpembayaran';
		$criteria->select = $criteria->group.', sum(t.tarif_tindakankomp) as totaljasa_komponen';
        
        
        $criteria->condition = "pp.tglpembayaran::date between '".$this->tgl_awal."'::date and '".$this->tgl_akhir."'::date ";
        
        if(!empty($this->pegawai_id)){
        $criteria->condition .= "and ((".
                "pk.kelompokkomponentarif_id = 1 and "
                . "t.daftartindakan_id <> ".Params::DAFTARTINDAKAN_ID_ASUHAN_KEPERAWATAN." ";
        $criteria->condition .= " and t.komponentarif_id not in (".join(",", 
                array(Params::KOMPONENTARIF_ID_JASA_PENGIRIM, Params::KOMPONENTARIF_ID_JASA_PERUJUK, 
                        //21, 23, 2, 12, 13
                        Params::KOMPONENTARIF_ID_JASA_BIDAN_1,
						Params::KOMPONENTARIF_ID_JASA_BIDAN_2,
						Params::KOMPONENTARIF_ID_JASA_SOPIR,
						Params::KOMPONENTARIF_ID_JASA_LAUNDRY,
						Params::KOMPONENTARIF_ID_JASA_RADIOGRAFER,
						Params::KOMPONENTARIF_ID_JASA_KONSUL_GIZI,
						Params::KOMPONENTARIF_ID_JASA_ANASTESI,
                    )).") and op.rencanaoperasi_id is null ";
        
        $criteria->condition .= "and t.pegawai_id in (".join(", ", $this->pegawai_id).") ";
                
        $criteria->condition .= ") or (";
        //$criteria->condition .= "mp."
        $criteria->condition .= "t.komponentarif_id in (".join(",", array(
        Params::KOMPONENTARIF_ID_JASA_PENGIRIM, 
        Params::KOMPONENTARIF_ID_JASA_PERUJUK)).")";
		$criteria->condition .= "and ul.pegawai_id in (".join(", ", $this->pegawai_id).") ";
		
		$criteria->join .= 'left join pelaksanaoperasi_t po on po.rencanaoperasi_id = op.rencanaoperasi_id and po.pegawai_id in ('.join(", ", $this->pegawai_id).') and tp.dokterpemeriksa2_id <> po.pegawai_id';
        
            $criteria->condition .= ") or (";
            $con_op = "(";
                $con_op .= '(tp.dokterpemeriksa1_id in ('.join(", ", $this->pegawai_id).') and t.komponentarif_id in ('.Params::KOMPONENTARIF_ID_JASA_OPERATOR.','.Params::KOMPONENTARIF_ID_JASA_DOKTER_OPERATOR.')) ';
                $con_op .= 'or (tp.dokterpemeriksa2_id in ('.join(", ", $this->pegawai_id).') and t.komponentarif_id = '.Params::KOMPONENTARIF_ID_JASA_ASISTEN_OPERATOR.') ';
                $con_op .= 'or (pa.dokteranastesi_id in ('.join(", ", $this->pegawai_id).') and t.komponentarif_id = '.Params::KOMPONENTARIF_ID_JASA_ANASTESI.') ';
				$con_op .= "or (tp.dokterpemeriksa2_id <> po.pegawai_id and po.pegawai_id in (".join(", ", $this->pegawai_id).") and po.krubedah = '".Params::KRUBEDAH_ASISTEN_OPERATOR."' and t.komponentarif_id in (".Params::KOMPONENTARIF_ID_JASA_ASISTEN_OPERATOR_2.")) ";
            $con_op .= ")";
            $criteria->condition .= $con_op;
        $criteria->condition .= "))";
        
        } else {
            $criteria->condition .= " and pk.kelompokkomponentarif_id = 1 and "
                . "t.daftartindakan_id <> ".Params::DAFTARTINDAKAN_ID_ASUHAN_KEPERAWATAN;
        }
		
		
		$criteria->order = " nama_pegawai ASC, pp.tglpembayaran asc";
				
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function searchRekapPrintJasaDokter()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

        $prov = $this->searchRekapJasaDokter();
        $prov->pagination = false;
        $prov->criteria->limit = -1;
				
		return $prov;
	}
	
	public function searchDetailRekapJasaDokter()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

        
        $prop = $this->searchRekapJasaDokter();
        $prop->criteria->join .= ' JOIN daftartindakan_m dt ON dt.daftartindakan_id = t.daftartindakan_id';
        $prop->criteria->group = 'pp.nopembayaran, pp.tglpembayaran, dt.daftartindakan_periksa, t.no_rekam_medik,t.daftartindakan_tindakan,t.daftartindakan_konsul,t.daftartindakan_visite, '
                . 't.daftartindakan_nama, t.penjamin_nama,t.carabayar_nama,t.kelaspelayanan_nama,t.nama_pasien,t.no_pendaftaran,t.tgl_pendaftaran,'
                . 't.komponentarif_nama, t.nama_pegawai, t.gelardepan, t.gelarbelakang_nama';
		$prop->criteria->select = $prop->criteria->group.',sum(t.qty_tindakan) as total_qty,sum(t.tarif_tindakankomp) as total_tarifkomp';
        
        return $prop;
	}
	
	public function searchDetailRekapPrintJasaDokter()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$prov = $this->searchDetailRekapJasaDokter();
        $prov->pagination = false;
        $prov->criteria->limit = -1;
				
		return $prov;
	}
	
	public function searchPrintJasaDokter()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
                
		$criteria->group = 't.instalasi_nama,t.nama_pasien,t.ruangan_id,t.ruangan_nama,t.no_rekam_medik,t.no_pendaftaran,t.tgl_pendaftaran,t.tgl_keluar,t.kelaspelayanan_nama,t.nama_pegawai,t.daftartindakan_nama,t.tarif_tindakankomp';
		$criteria->select = $criteria->group;
		$criteria->addBetweenCondition('date(t.tgl_pendaftaran)',$this->tgl_awal,$this->tgl_akhir,true);
		if(!empty($this->pegawai_id)){
			$criteria->addCondition('t.pegawai_id = '.$this->pegawai_id);
		}
		// $criteria->compare("t.komponentarif_id", Params::KOMPONENTARIF_ID_JASA_MEDIS);
		
		//$criteria->compare("p.kelompokkomponentarif_id", 1);
		$criteria->addInCondition(" t.komponentarif_id ", Params::getKomponenTarifLapJasaDokter());
		$criteria->join = "join persenkelkomponentarif_m p on p.komponentarif_id = t.komponentarif_id";
		
		if (!empty($this->ruangan_id)){
			$criteria->addCondition('t.ruangan_id = '.$this->ruangan_id);
		}
		$criteria->order = " tgl_pendaftaran ASC ";
		$criteria->limit = -1;

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination'=>false,
		));
	}
        public function searchGrafik()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
                
		$criteria->group = 't.nama_pasien,t.ruangan_id,t.ruangan_nama,t.no_rekam_medik,t.no_pendaftaran,t.tgl_pendaftaran,t.tgl_keluar,t.kelaspelayanan_nama,t.nama_pegawai,t.daftartindakan_nama,t.tarif_tindakankomp';
		$criteria->select = $criteria->group;
		$criteria->addBetweenCondition('date(t.tgl_pendaftaran)',$this->tgl_awal,$this->tgl_akhir,true);
		
		$criteria->compare("p.kelompokkomponentarif_id", 1);
		$criteria->join = "join persenkelkomponentarif_m p on p.komponentarif_id = t.komponentarif_id";
		
		
		if (!empty($this->ruangan_id)){
			$criteria->addCondition('t.ruangan_id = '.$this->ruangan_id);
		}
		if(!empty($this->pegawai_id)){
			$criteria->addCondition('t.pegawai_id = '.$this->pegawai_id);
		}
		$criteria->limit = -1;

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination'=>false,
		));
	}
        // -- END REKAP JASA DOKTER -- //
        
        // -- DETAIL JASA DOKTER -- //
        public function searchDetailJasaDokter()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
                
		$criteria->select = 'pendaftaran_id, pasien_id, nama_pasien, namaperusahaan,no_pendaftaran, no_rekam_medik,tgl_pendaftaran,ruangan_nama,
							ruangan_id,gelardepan,nama_pegawai,gelarbelakang_nama,instalasi_nama,instalasi_id,
							sum(tarif_tindakan) As tarif_tindakan,
							sum(tarif_tindakan) As total,
							sum(tarif_tindakankomp) As tarif_rsakomodasi,
							qty_tindakan
							';
		$criteria->group = 'qty_tindakan,pendaftaran_id, pasien_id, nama_pasien, namaperusahaan,no_pendaftaran, 
							no_rekam_medik,tgl_pendaftaran,ruangan_nama,ruangan_id,gelardepan,nama_pegawai,gelarbelakang_nama,instalasi_nama,instalasi_id';

		$criteria->addBetweenCondition('date(tgl_pendaftaran)',$this->tgl_awal,$this->tgl_akhir);
		if(!empty($this->pegawai_id)){
			$criteria->addInCondition('pegawai_id', $this->pegawai_id);
		}
		if(!empty($this->ruangan_id)){
			$criteria->addCondition('ruangan_id = '.$this->ruangan_id);
		}
		

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        public function searchPrintDetailJasaDokter()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria = new CDbCriteria;
                
		$criteria->select = 'pendaftaran_id, pasien_id, nama_pasien, namaperusahaan,no_pendaftaran, no_rekam_medik,tgl_pendaftaran,ruangan_nama,
							ruangan_id,gelardepan,nama_pegawai,gelarbelakang_nama,instalasi_nama,instalasi_id,
							sum(tarif_tindakan) As tarif_tindakan,
							sum(tarif_tindakan) As total,
							sum(tarif_tindakankomp) As tarif_rsakomodasi,
							qty_tindakan
							';
		$criteria->group = 'qty_tindakan,pendaftaran_id, pasien_id, nama_pasien, namaperusahaan,no_pendaftaran, 
							no_rekam_medik,tgl_pendaftaran,ruangan_nama,ruangan_id,gelardepan,nama_pegawai,gelarbelakang_nama,instalasi_nama,instalasi_id';

		$criteria->addBetweenCondition('date(tgl_pendaftaran)',$this->tgl_awal,$this->tgl_akhir);
		if(!empty($this->pegawai_id)){
			$criteria->addCondition('pegawai_id = '.$this->pegawai_id);
		}
		if(!empty($this->ruangan_id)){
			$criteria->addCondition('ruangan_id = '.$this->ruangan_id);
		}		
		$criteria->limit = -1;

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination'=>false,
		));
	}
        // -- END DETAIL JASA DOKTER -- //
        
        public function getDokterItems()
        {
            return DokterV::model()->findAll();
        }
}