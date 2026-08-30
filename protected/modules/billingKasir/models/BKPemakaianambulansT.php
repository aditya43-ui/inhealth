<?php

class BKPemakaianambulansT extends PemakaianambulansT
{
    public $supir_nama;
    public $pelaksana_nama;
    public $paramedis1_nama;
    public $paramedis2_nama;
    public $mobilambulans_nama;
    public $ruangan_nama;
    public $tgl_awal;
    public $tgl_akhir;
    public $tick, $data, $jumlah, $daftartindakanId, $rt, $rw;
    public $KMawalKMakhir;
    public $jns_periode,$bln_awal,$bln_akhir,$thn_awal,$thn_akhir;
        /**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AnamnesaT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
        
	public function attributeLabels()
	{
		return array(
			'pemakaianambulans_id' => 'ID Pemakaian Ambulans',
			'batalpakaiambulans_id' => 'Batal Pakai',
			'mobilambulans_id' => 'Mobil Ambulans',
			'pasien_id' => 'Pasien',
			'ruangan_id' => 'Ruangan',
			'pesanambulans_t' => 'Pesanambulans T',
			'pendaftaran_id' => 'Pendaftaran',
			'tglpemakaianambulans' => 'Tanggal Periode',
			'noidentitas' => 'No. Identitas',
			'norekammedis' => 'No. Rekam Medik',
			'namapasien' => 'Nama Pasien',
			'tempattujuan' => 'Tempat Tujuan',
			'kelurahan_nama' => 'Kelurahan',
			'alamattujuan' => 'Alamat Tujuan',
			'rt_rw' => 'Rt / Rw',
			'nomobile' => 'No. Handphone',
			'notelepon' => 'No. Telepon',
			'namapj' => 'Nama PJ',
			'hubunganpj' => 'Hubungan PJ',
			'alamatpj' => 'Alamat PJ',
			'supir_id' => 'Supir',
			'pelaksana_id' => 'Pelaksana',
			'paramedis1_id' => 'Paramedis 1',
			'paramedis2_id' => 'Paramedis 2',
			'kmawal' => 'KM Awal',
			'kmakhir' => 'KM Akhir',
			'jmlbbmliter' => 'Jml BBM Liter',
			'jumlahkm' => 'Jumlah Km',
			'tarifperkm' => 'Tarif / KM',
			'totaltarifambulans' => 'Total Tarif Ambulans',
			'tglkembaliambulans' => 'Tanggal Kembali Ambulans',
			'untukkeperluan' => 'Untuk Keperluan',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
                        'tgl_awal'=>'Tanggal Awal',
                        'tgl_akhir'=>'Tanggal Akhir',
                    'KMawalKMakhir'=>'KM Awal / KM Akhir',
		);
	}
        
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
                
        // $criteria->with = array('supir','paramedis1','ruanganpemesan','mobil');
		$criteria->addBetweenCondition('DATE(tglpemakaianambulans)', $this->tgl_awal, $this->tgl_akhir);
		$criteria->compare('LOWER(mobil.nopolisi)',strtolower($this->nopolisi),true);
		$criteria->compare('LOWER(ruanganpemesan.ruangan_nama)',$this->ruangan_nama,true);
		$criteria->compare('LOWER(noidentitas)',strtolower($this->noidentitas),true);
		$criteria->compare('LOWER(norekammedis)',strtolower($this->norekammedis),true);
		$criteria->compare('LOWER(namapasien)',strtolower($this->namapasien),true);
		$criteria->compare('LOWER(tempattujuan)',strtolower($this->tempattujuan),true);
		$criteria->compare('LOWER(kelurahan_nama)',strtolower($this->kelurahan_nama),true);
		$criteria->compare('LOWER(alamattujuan)',strtolower($this->alamattujuan),true);
		$criteria->compare('LOWER(rt_rw)',strtolower($this->rt_rw),true);
		$criteria->compare('LOWER(nomobile)',strtolower($this->nomobile),true);
		$criteria->compare('LOWER(notelepon)',strtolower($this->notelepon),true);
		$criteria->compare('LOWER(namapj)',strtolower($this->namapj),true);
		$criteria->compare('LOWER(hubunganpj)',strtolower($this->hubunganpj),true);
		$criteria->compare('LOWER(alamatpj)',strtolower($this->alamatpj),true);
		$criteria->compare('kmawal',$this->kmawal);
		$criteria->compare('kmakhir',$this->kmakhir);
		$criteria->compare('jmlbbmliter',$this->jmlbbmliter);
		$criteria->compare('jumlahkm',$this->jumlahkm);
		$criteria->compare('tarifperkm',$this->tarifperkm);
		$criteria->compare('totaltarifambulans',$this->totaltarifambulans);
		$criteria->compare('LOWER(tglkembaliambulans)',strtolower($this->tglkembaliambulans),true);
		$criteria->compare('LOWER(untukkeperluan)',strtolower($this->untukkeperluan),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
                public function criteriaLaporan()
                {
		$criteria=new CDbCriteria;
                
//                $criteria->with = array('supir','paramedis1','ruanganpemesan','mobil');
//                $criteria->order = 'mobil.jeniskendaraan, mobil.nopolisi';
                                
		$criteria->addBetweenCondition('t.tglpemakaianambulans', $this->tgl_awal, $this->tgl_akhir);
                                
                        return $criteria;
                }
        
                public function searchLaporan()
                {
		return new CActiveDataProvider($this, array(
			'criteria'=>$this->criteriaLaporan(),
		));
                }        
                
                public function searchLaporanPrint()
                {
		return new CActiveDataProvider($this, array(
			'criteria'=>$this->criteriaLaporan(),
                                                'pagination'=>false,
		));
                }
                
                public function getTotal($kolom)
                {
                    $criteria = new CDbCriteria;
                    $criteria->addBetweenCondition('tglpemakaianambulans', $this->tgl_awal, $this->tgl_akhir);
                    $criteria->select = "SUM($kolom)";
                    $total = $this->commandBuilder->createFindCommand($this->getTableSchema(),$criteria)->queryScalar();
                    return number_format($total);
                }
                
                public function searchGrafik()
                {
		$criteria=new CDbCriteria;
                
                                $criteria->join = 'JOIN mobilambulans_m ON t.mobilambulans_id=mobilambulans_m.mobilambulans_id';
                                $criteria->select = 'COUNT(norekammedis) AS jumlah, mobilambulans_m.nopolisi AS data';
                                $criteria->group = 't.mobilambulans_id, mobilambulans_m.nopolisi';
//                                $criteria->group = 'mobil.mobilambulans_id, t.pemakaianambulans_id, mobil.inventarisaset_id, mobil.mobilambulans_kode, mobil.nopolisi, mobil.jeniskendaraan, mobil.isibbmliter, mobil.kmterakhirkend, mobil.photokendaraan, mobil.hargabbmliter, mobil.formulajasars, mobil.formulajasaba, mobil.formulajasapel, mobil.mobilambulans_aktif';
                                
		$criteria->addBetweenCondition('tglpemakaianambulans', $this->tgl_awal, $this->tgl_akhir);
                
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                                                'pagination'=>false,
		));
                }
}
?>
