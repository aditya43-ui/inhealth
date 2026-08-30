<?php

class GZInfokunjunganriV extends InfokunjunganriV {
    
    public $kamarruangan_nobed;
    public $kamarruangan_nokamar;
    
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function searchDialog() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('LOWER(namadepan)', strtolower($this->namadepan), true);
        $criteria->compare('LOWER(nama_pasien)', strtolower($this->nama_pasien), true);
        $criteria->compare('LOWER(nama_bin)', strtolower($this->nama_bin), true);
        $criteria->compare('LOWER(jeniskelamin)', strtolower($this->jeniskelamin), true);
        $criteria->compare('LOWER(tempat_lahir)', strtolower($this->tempat_lahir), true);
        $criteria->compare('LOWER(tanggal_lahir)', strtolower($this->tanggal_lahir), true);
        $criteria->compare('LOWER(alamat_pasien)', strtolower($this->alamat_pasien), true);
        $criteria->compare('LOWER(umur)', strtolower($this->umur), true);
		if(!empty($this->pendaftaran_id)){
			$criteria->addCondition('pendaftaran_id ='.$this->pendaftaran_id);
		}
        $criteria->compare('LOWER(no_pendaftaran)', strtolower($this->no_pendaftaran), true);
        $criteria->compare('LOWER(tgl_pendaftaran)', strtolower($this->tgl_pendaftaran), true);
		if(!empty($this->pasienadmisi_id)){
			$criteria->addCondition('pasienadmisi_id ='.$this->pasienadmisi_id);
		}
		if(!empty($this->penjamin_id)){
			$criteria->addCondition('penjamin_id ='.$this->penjamin_id);
		}
        $criteria->compare('LOWER(penjamin_nama)', strtolower($this->penjamin_nama), true);
		if(!empty($this->carabayar_id)){
			$criteria->addCondition('carabayar_id ='.$this->carabayar_id);
		}
        $criteria->compare('LOWER(carabayar_nama)', strtolower($this->carabayar_nama), true);
		if(!empty($this->caramasuk_id)){
			$criteria->addCondition('caramasuk_id ='.$this->caramasuk_id);
		}
        $criteria->compare('LOWER(caramasuk_nama)', strtolower($this->caramasuk_nama), true);
		if(!empty($this->kelaspelayanan_id)){
			$criteria->addCondition('kelaspelayanan_id ='.$this->kelaspelayanan_id);
		}
        $criteria->compare('LOWER(kelaspelayanan_nama)', strtolower($this->kelaspelayanan_nama), true);
		if(!empty($this->kamarruangan_id)){
			$criteria->addCondition('kamarruangan_id ='.$this->kamarruangan_id);
		}
        $criteria->compare('LOWER(tgladmisi)', strtolower($this->tgladmisi), true);
        $criteria->compare('LOWER(kamarruangan_nokamar)', strtolower($this->kamarruangan_nokamar), true);
		if(!empty($this->ruangan_id)){
			$criteria->addCondition('ruangan_id ='.$this->ruangan_id);
		}
        $criteria->compare('LOWER(kamarruangan_nobed)', strtolower($this->kamarruangan_nobed), true);        
        $criteria->compare('LOWER(ruangan_nama)', strtolower($this->ruangan_nama), true);
		if(!empty($this->propinsi_id)){
			$criteria->addCondition('propinsi_id ='.$this->propinsi_id);
		}
		if(!empty($this->kabupaten_id)){
			$criteria->addCondition('kabupaten_id ='.$this->kabupaten_id);
		}
		if(!empty($this->kecamatan_id)){
			$criteria->addCondition('kecamatan_id ='.$this->kecamatan_id);
		}
		if(!empty($this->kelurahan_id)){
			$criteria->addCondition('kelurahan_id ='.$this->kelurahan_id);
		}
        $criteria->compare('LOWER(no_rekam_medik)', strtolower($this->no_rekam_medik), true);
		if(!empty($this->instalasi_id)){
			$criteria->addCondition('instalasi_id ='.$this->instalasi_id);
		}
      //  $criteria->order = 'tgl_pendaftaran DESC';
        //$criteria->limit = 10;

        return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
			//'pagination'=>false,
		));
    }

    public function getNamaNoRekRuangan() {
        return $this->no_rekam_medik . ' - ' . $this->nama_pasien . ' - ' . $this->ruangan_nama;
    }
    
    public function getJenisTarif(){
        $modJenisTarif = JenistarifpenjaminM::model()->find('penjamin_id='.$this->penjamin_id);
        if(!empty($modJenisTarif->jenistarif_id)){
			$return = $modJenisTarif->jenistarif_id;
		}else{
			$return = null;
		}
        return $return;
    }

}