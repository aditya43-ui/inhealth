<?php

class PPPasientindaklanjutkeriV extends PasientindaklanjutkeriV
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PasientindaklanjutkeriV the static model class
	 */
    
        public $kecamatan_id, $kelurahan_id;
    
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        /**
         * menampilkan data kunjungan pasien untuk transaksi pendaftaran rawat inap (dari RJ / RD)
         * model & criteria hampir sama dengan PendaftaranRawatInapDariRJRDController/AutocompletePasienRJRD
         * @return \CActiveDataProvider
         */
        public function searchDialogUntukPendaftaranRI(){
            $format = new MyFormatter();
            $criteria = new CDbCriteria();

            $criteria->join = "left join suratperintahranap_t s on s.pendaftaran_id = t.pendaftaran_id";
			
			if(!empty($this->carabayar_id)){
				$criteria->addCondition("t.carabayar_id = ".$this->carabayar_id);				
			}
			if(!empty($this->penjamin_id)){
				$criteria->addCondition("t.penjamin_id = ".$this->penjamin_id);				
			}
			if(!empty($this->instalasi_id)){
				$criteria->addCondition("t.instalasi_id = ".$this->instalasi_id);				
			}
			if(!empty($this->ruangan_id)){
				$criteria->addCondition("t.ruangan_id = ".$this->ruangan_id);				
			}
            $criteria->compare('t.pendaftaran_id', $this->pendaftaran_id);
            $criteria->compare('DATE(t.tanggal_lahir)',$format->formatDateTimeForDb($this->tanggal_lahir));
            $criteria->compare('LOWER(t.no_pendaftaran)', strtolower($this->no_pendaftaran), true);
            $criteria->compare('LOWER(t.no_rekam_medik)', strtolower($this->no_rekam_medik), true);
            $criteria->compare('LOWER(t.nama_pasien)', strtolower($this->nama_pasien), true);
            $criteria->compare('LOWER(t.ruangan_nama)', strtolower($this->ruangan_nama), true);
            $criteria->compare('LOWER(t.jeniskelamin)', strtolower($this->jeniskelamin), true);
            $criteria->compare('LOWER(t.carabayar_nama)', strtolower($this->carabayar_nama), true);
            $criteria->compare('LOWER(t.penjamin_nama)', strtolower($this->penjamin_nama), true);
            $criteria->compare('LOWER(t.kabupaten_nama)', strtolower($this->kabupaten_nama), true);
            $criteria->compare('LOWER(t.kecamatan_nama)', strtolower($this->kecamatan_nama), true);
            $criteria->compare('LOWER(t.kelurahan_nama)', strtolower($this->kelurahan_nama), true);
            $criteria->compare('t.kecamatan_id', $this->kecamatan_id);
            $criteria->compare('t.kelurahan_id', $this->kelurahan_id);
            $criteria->compare('LOWER(t.statusperiksa)', strtolower($this->statusperiksa), true);
            $criteria->addCondition('t.pasienpulang_id is not null');
            $criteria->addCondition("t.statusperiksa <> 'SUDAH PULANG'");
            $criteria->addCondition("
            (t.carabayar_id <> ".Params::CARABAYAR_ID_BPJS.") or
            (t.carabayar_id = ".Params::CARABAYAR_ID_BPJS." and s.suratperintahranap_id is not null)
            ");
            $criteria->order = 't.tgl_pendaftaran DESC';
            // $criteria->limit = 5;
            
            return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        //'pagination'=>false,
                ));
        }
}
?>
