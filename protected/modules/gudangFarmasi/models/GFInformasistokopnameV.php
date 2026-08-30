<?php
class GFInformasistokopnameV extends InformasistokopnameV
{
        public $tgl_awal,$tgl_akhir;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InformasistokopnameV the static model class
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

		$criteria->addBetweenCondition('DATE(tglstokopname)',$this->tgl_awal,$this->tgl_akhir,true);
		if(!empty($this->instalasi_id)){
			$criteria->addCondition('instalasi_id = '.$this->instalasi_id);
		}
		$criteria->compare('instalasi_nama',$this->instalasi_nama,true);
		if(!empty($this->ruangan_id)){
			$criteria->addCondition('ruangan_id = '.$this->ruangan_id);
		}
		$criteria->compare('ruangan_nama',$this->ruangan_nama,true);
		if(!empty($this->formuliropname_id)){
			$criteria->addCondition('formuliropname_id = '.$this->formuliropname_id);
		}
		$criteria->compare('tglformulir',$this->tglformulir,true);
		$criteria->compare('noformulir',$this->noformulir,true);
		if(!empty($this->stokopname_id)){
			$criteria->addCondition('stokopname_id = '.$this->stokopname_id);
		}	
		$criteria->compare('nostokopname',$this->nostokopname,true);
		$criteria->compare('isstokawal',$this->isstokawal);
		$criteria->compare('jenisstokopname',$this->jenisstokopname,true);
		$criteria->compare('keterangan_opname',$this->keterangan_opname,true);
		$criteria->compare('totalharga',$this->totalharga);
		$criteria->compare('totalnetto',$this->totalnetto);
		if(!empty($this->petugas1_id)){
			$criteria->addCondition('petugas1_id = '.$this->petugas1_id);
		}
		$criteria->compare('petugas1_nip',$this->petugas1_nip,true);
		$criteria->compare('petugas1_noidentitas',$this->petugas1_noidentitas,true);
		$criteria->compare('petugas1_gelardepan',$this->petugas1_gelardepan,true);
		$criteria->compare('petugas1_nama',$this->petugas1_nama,true);
		$criteria->compare('petugas1_gelarbelakang',$this->petugas1_gelarbelakang,true);
		if(!empty($this->petugas2_id)){
			$criteria->addCondition('petugas2_id = '.$this->petugas2_id);
		}
		$criteria->compare('petugas2_nip',$this->petugas2_nip,true);
		$criteria->compare('petugas2_noidentitas',$this->petugas2_noidentitas,true);
		$criteria->compare('petugas2_gelardepan',$this->petugas2_gelardepan,true);
		$criteria->compare('petugas2_nama',$this->petugas2_nama,true);
		$criteria->compare('petugas2_gelarbelakang',$this->petugas2_gelarbelakang,true);
		if(!empty($this->pegawaimengetahui_id)){
			$criteria->addCondition('pegawaimengetahui_id = '.$this->pegawaimengetahui_id);
		}
		$criteria->compare('pegawaimengetahui_nip',$this->pegawaimengetahui_nip,true);
		$criteria->compare('pegawaimengetahui_noidentitas',$this->pegawaimengetahui_noidentitas,true);
		$criteria->compare('pegawaimengetahui_gelardepan',$this->pegawaimengetahui_gelardepan,true);
		$criteria->compare('pegawaimengetahui_nama',$this->pegawaimengetahui_nama,true);
		$criteria->compare('pegawaimengetahui_gelarbelakang',$this->pegawaimengetahui_gelarbelakang,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		if(!empty($this->create_loginpemakai_id)){
			$criteria->addCondition('create_loginpemakai_id = '.$this->create_loginpemakai_id);
		}
		if(!empty($this->update_loginpemakai_id)){
			$criteria->addCondition('update_loginpemakai_id = '.$this->update_loginpemakai_id);
		}
		if(!empty($this->create_ruangan)){
			$criteria->addCondition('create_ruangan = '.$this->create_ruangan);
		}

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public function getMengetahui()
        {
            return (isset($this->pegawaimengetahui_gelardepan) ? $this->pegawaimengetahui_gelardepan : "").' '.$this->pegawaimengetahui_nama.(isset($this->pegawaimengetahui_gelarbelakang) ? ', '.$this->pegawaimengetahui_gelarbelakang : "");
        }
        
        public function getPetugas1()
        {
            return (isset($this->petugas1_gelardepan) ? $this->petugas1_gelardepan : "").' '.$this->petugas1_nama.(isset($this->petugas1_gelarbelakang) ? ', '.$this->petugas1_gelarbelakang : "");
        }
        
        public function getPetugas2()
        {
            return (isset($this->petugas2_gelardepan) ? $this->petugas2_gelardepan : "").' '.$this->petugas2_nama.(isset($this->petugas2_gelarbelakang) ? ', '.$this->petugas2_gelarbelakang : "");
        }
}