<?php
class FAInformasipermohonanobatalkesV extends InformasipermohonanobatalkesV
{
        public $tgl_awal,$tgl_akhir;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InformasipermohonanobatalkesV the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public function searchInformasi()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->addBetweenCondition('DATE(permohonanoa_tgl)',$this->tgl_awal,$this->tgl_akhir,true);
                
		if(!empty($this->permohonanoa_id)){
			$criteria->addCondition("permohonanoa_id = ".$this->permohonanoa_id);						
		}
		$criteria->compare('permohonanoa_nomor',$this->permohonanoa_nomor,true);
		$criteria->compare('pemohon_jenisidentitas',$this->pemohon_jenisidentitas,true);
		$criteria->compare('pemohon_noidentitas',$this->pemohon_noidentitas,true);
		$criteria->compare('LOWER(pemohon_nama)',strtolower($this->pemohon_nama),true);
		$criteria->compare('pemohon_jeniskelamin',$this->pemohon_jeniskelamin,true);
		$criteria->compare('LOWER(pemohon_alamat)',strtolower($this->pemohon_alamat),true);
		$criteria->compare('rt',$this->rt);
		$criteria->compare('rw',$this->rw);
		if(!empty($this->kelurahan_id)){
			$criteria->addCondition("kelurahan_id = ".$this->kelurahan_id);						
		}
		$criteria->compare('LOWER(kelurahan_nama)',strtolower($this->kelurahan_nama),true);
		if(!empty($this->kecamatan_id)){
			$criteria->addCondition("kecamatan_id = ".$this->kecamatan_id);						
		}
		$criteria->compare('LOWER(kecamatan_nama)',strtolower($this->kecamatan_nama),true);
		if(!empty($this->kabupaten_id)){
			$criteria->addCondition("kabupaten_id = ".$this->kabupaten_id);						
		}
		$criteria->compare('LOWER(kabupaten_nama)',strtolower($this->kabupaten_nama),true);
		if(!empty($this->propinsi_id)){
			$criteria->addCondition("propinsi_id = ".$this->propinsi_id);						
		}
		$criteria->compare('LOWER(propinsi_nama)',strtolower($this->propinsi_nama),true);
		$criteria->compare('pemohon_notelp',$this->pemohon_notelp,true);
		$criteria->compare('pemohon_nomobile',$this->pemohon_nomobile,true);
		$criteria->compare('LOWER(pemohon_alamatemail)',strtolower($this->pemohon_alamatemail),true);
		$criteria->compare('LOWER(permohonan_alasan)',strtolower($this->permohonan_alasan),true);
		$criteria->compare('LOWER(permohonan_keterangan)',strtolower($this->permohonan_keterangan),true);
		$criteria->compare('permohonanoa_tglapproved',$this->permohonanoa_tglapproved,true);
		$criteria->compare('permohonanoa_isapproved',$this->permohonanoa_isapproved);
		if(!empty($this->profilrs_id)){
			$criteria->addCondition("profilrs_id = ".$this->profilrs_id);						
		}
		$criteria->compare('nokode_rumahsakit',$this->nokode_rumahsakit,true);
		$criteria->compare('nama_rumahsakit',$this->nama_rumahsakit,true);
		if(!empty($this->pegawaimengetahui_id)){
			$criteria->addCondition("pegawaimengetahui_id = ".$this->pegawaimengetahui_id);						
		}
		$criteria->compare('LOWER(pegawaimengetahui_gelardepan)',strtolower($this->pegawaimengetahui_gelardepan),true);
		$criteria->compare('LOWER(pegawaimengetahui_nama)',strtolower($this->pegawaimengetahui_nama),true);
		$criteria->compare('LOWER(pegawaimengetahui_gelarbelakang)',strtolower($this->pegawaimengetahui_gelarbelakang),true);
		if(!empty($this->pegawaimenyetujui_id)){
			$criteria->addCondition("pegawaimenyetujui_id = ".$this->pegawaimenyetujui_id);						
		}
		$criteria->compare('LOWER(pegawaimenyetujui_gelardepan)',strtolower($this->pegawaimenyetujui_gelardepan),true);
		$criteria->compare('LOWER(pegawaimenyetujui_nama)',strtolower($this->pegawaimenyetujui_nama),true);
		$criteria->compare('LOWER(pegawaimenyetujui_gelarbelakang)',strtolower($this->pegawaimenyetujui_gelarbelakang),true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		if(!empty($this->create_loginpemakai_id)){
			$criteria->addCondition("create_loginpemakai_id = ".$this->create_loginpemakai_id);						
		}
		if(!empty($this->update_loginpemakai_id)){
			$criteria->addCondition("update_loginpemakai_id = ".$this->update_loginpemakai_id);						
		}
		$criteria->compare('create_ruangan',$this->create_ruangan);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public function getPegawaimengetahuiLengkap()
        {
            return (isset($this->pegawaimengetahui_gelardepan) ? $this->pegawaimengetahui_gelardepan : "").' '.$this->pegawaimengetahui_nama.(isset($this->pegawaimengetahui_gelarbelakang) ? ', '.$this->pegawaimengetahui_gelardepan : "");
        }

        public function getPegawaimenyetujuiLengkap()
        {
            return (isset($this->pegawaimenyetujui_gelardepan) ? $this->pegawaimenyetujui_gelardepan : "").' '.$this->pegawaimenyetujui_nama.(isset($this->pegawaimenyetujui_gelarbelakang) ? ', '.$this->pegawaimenyetujui_gelardepan : "");
        }

}