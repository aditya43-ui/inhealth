<?php

/**
 * This is the model class for table "inforencanaaskep_v".
 *
 */
class RKInfopasienblacklistV extends InfopasienblacklistV
{
	public $tgl_awal,$tgl_akhir,$instalasi_id,$no_rekam_medik;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InforencanaaskepV the static model class
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
			'pasienblacklist_id' => 'Pasienblacklist',
			'pasienblacklist_no' => 'Pasienblacklist No',
			'pasienblacklist_tgl' => 'Pasienblacklist Tgl',
			'pasienblacklist_karenakasus' => 'Pasienblacklist Karenakasus',
			'pasienblacklist_ket' => 'Pasienblacklist Ket',
			'isblacklist' => 'Isblacklist',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
			'pendaftaran_id' => 'Pendaftaran',
			'no_pendaftaran' => 'No. Pendaftaran',
			'tgl_pendaftaran' => 'Tgl. Pendaftaran',
			'pasien_id' => 'Pasien',
			'nama_pasien' => 'Nama Pasien',
			'pembayaranpelayanan_id' => 'Pembayaranpelayanan',
			'totalsisatagihan' => 'Totalsisatagihan',
			'pegawai_id' => 'Pegawai',
			'nama_pegawai' => 'Nama Pegawai',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('pasienblacklist_id',$this->pasienblacklist_id);
		$criteria->compare('pasienblacklist_no',$this->pasienblacklist_no,true);
		$criteria->addBetweenCondition('DATE(pasienblacklist_tgl)', $this->tgl_awal, $this->tgl_akhir);
		$criteria->compare('pasienblacklist_karenakasus',$this->pasienblacklist_karenakasus,true);
		$criteria->compare('pasienblacklist_ket',$this->pasienblacklist_ket,true);
		$criteria->compare('isblacklist',$this->isblacklist);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id,true);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id,true);
		$criteria->compare('create_ruangan',$this->create_ruangan,true);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('no_pendaftaran',$this->no_pendaftaran,true);
		$criteria->compare('tgl_pendaftaran',$this->tgl_pendaftaran,true);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('no_rekam_medik',$this->no_rekam_medik,true);
		$criteria->compare('nama_pasien',$this->nama_pasien,true);
		$criteria->compare('pembayaranpelayanan_id',$this->pembayaranpelayanan_id);
		$criteria->compare('totalsisatagihan',$this->totalsisatagihan);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('nama_pegawai',$this->nama_pegawai,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}