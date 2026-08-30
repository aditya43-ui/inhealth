<?php


class ASLappengkajiankepV extends LappengkajiankepV
{
	public $jns_periode,$tgl_awal,$tgl_akhir,$bln_awal,$bln_akhir,$thn_awal,$thn_akhir;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LappengkajiankepV the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pengkajianaskep_id' => 'Pengkajianaskep',
			'pendaftaran_id' => 'Pendaftaran',
			'ruangan_id' => 'Ruangan',
			'pengkajianaskep_tgl' => 'Pengkajianaskep Tgl',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
			'no_pengkajian' => 'No Pengkajian',
			'anamesa_id' => 'Anamesa',
			'pemeriksaanfisik_id' => 'Pemeriksaanfisik',
			'no_pendaftaran' => 'No. Pendaftaran',
			'nama_pasien' => 'Nama Pasien',
			'jeniskelamin' => 'Jenis Kelamin',
			'ruangan_nama' => 'Ruangan Nama',
			'kelaspelayanan_id' => 'Kelaspelayanan',
			'kelaspelayanan_nama' => 'Kelaspelayanan Nama',
			'kamarruangan_nokamar' => 'Kamarruangan Nokamar',
			'kamarruangan_nobed' => 'Kamarruangan Nobed',
			'kamarruangan_id' => 'Kamarruangan',
			'pegawai_id' => 'Pegawai',
			'nama_pegawai' => 'Nama Pegawai',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function criteriaSearch()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		
		$format = new MyFormatter();
		$bln_awal = explode('-',$this->bln_awal);
		$bln_akhir = explode('-',$this->bln_akhir);
		$tgl_awal = '';
		$tgl_akhir = '';
		if(isset($_GET['ASLappengkajiankepV'])){
			$tgl_awal = $format->formatDateTimeForDb($_GET['ASLappengkajiankepV']['tgl_awal']);
			$tgl_akhir = $format->formatDateTimeForDb($_GET['ASLappengkajiankepV']['tgl_akhir']);
			$tgl_awal = $tgl_awal." 00:00:00";
			$tgl_akhir = $tgl_akhir." 23:59:59";
		}
		if($this->jns_periode == "hari"){
			$criteria->addBetweenCondition('DATE(pengkajianaskep_tgl)',$this->tgl_awal,$this->tgl_akhir);
		}
		if($this->jns_periode == "bulan"){
			$criteria->addBetweenCondition("date_part('month',pengkajianaskep_tgl)",$bln_awal[1],$bln_akhir[1]);
			$criteria->addBetweenCondition("date_part('year',pengkajianaskep_tgl)",$this->thn_awal,$this->thn_akhir);
		}
		if($this->jns_periode == "tahun"){
			$criteria->addBetweenCondition("date_part('year',pengkajianaskep_tgl)",$this->thn_awal,$this->thn_akhir);
		}
		
		$criteria->compare('pengkajianaskep_id',$this->pengkajianaskep_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
//		$criteria->compare('pengkajianaskep_tgl',$this->pengkajianaskep_tgl,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id,true);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id,true);
		$criteria->compare('create_ruangan',$this->create_ruangan,true);
		$criteria->compare('no_pengkajian',$this->no_pengkajian,true);
		$criteria->compare('anamesa_id',$this->anamesa_id);
		$criteria->compare('pemeriksaanfisik_id',$this->pemeriksaanfisik_id);
		$criteria->compare('no_pendaftaran',$this->no_pendaftaran,true);
		$criteria->compare('nama_pasien',$this->nama_pasien,true);
		$criteria->compare('jeniskelamin',$this->jeniskelamin,true);
		$criteria->compare('ruangan_nama',$this->ruangan_nama,true);
		$criteria->compare('kelaspelayanan_id',$this->kelaspelayanan_id);
		$criteria->compare('kelaspelayanan_nama',$this->kelaspelayanan_nama,true);
		$criteria->compare('kamarruangan_nokamar',$this->kamarruangan_nokamar,true);
		$criteria->compare('kamarruangan_nobed',$this->kamarruangan_nobed,true);
		$criteria->compare('kamarruangan_id',$this->kamarruangan_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('nama_pegawai',$this->nama_pegawai,true);

		return $criteria;
	}
	
	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function searchLaporan()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=$this->criteriaSearch();
		$criteria->limit=10;

		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
		));
	}
	
	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function searchLaporanPrint()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=$this->criteriaSearch();
		$criteria->limit=-1;

		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
				'pagination'=>false,
		));
	}
}