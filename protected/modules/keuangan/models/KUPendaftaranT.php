<?php

class KUPendaftaranT extends PendaftaranT
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AnamnesaT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

         public function searchPendaftaranPasienKlaim()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
                $criteria->with=array('pasien','penanggungJawab');
                $criteria->compare('LOWER(pasien.no_rekam_medik)',  strtolower($this->no_rekam_medik),true);
                $criteria->compare('LOWER(pasien.nama_pasien)',  strtolower($this->nama_pasien),true);
                $criteria->compare('LOWER(pasien.nama_bin)',  strtolower($this->nama_bin),true);
                $criteria->compare('LOWER(pasien.alamat_pasien)',  strtolower($this->alamat_pasien),true);
                $criteria->compare('pasien.propinsi_id',  strtolower($this->propinsi));
                $criteria->compare('pasien.kabupaten_id',  strtolower($this->kabupaten));
                $criteria->compare('pasien.kecamatan_id',  strtolower($this->kecamatan));
                $criteria->compare('pasien.kelurahan_id',  strtolower($this->kelurahan));
                $criteria->compare('pendaftaran_id',$this->pendaftaran_id);
                $criteria->compare('penjamin_id',$this->penjamin_id);
                $criteria->compare('caramasuk_id',$this->caramasuk_id);
                $criteria->compare('carabayar_id',$this->carabayar_id);
                $criteria->compare('pasien_id',$this->pasien_id);
                $criteria->compare('shift_id',$this->shift_id);
                $criteria->compare('golonganumur_id',$this->golonganumur_id);
                $criteria->compare('kelaspelayanan_id',$this->kelaspelayanan_id);
                $criteria->compare('rujukan_id',$this->rujukan_id);
                $criteria->compare('penanggungjawab_id',$this->penanggungjawab_id);
                $criteria->compare('ruangan_id',$this->ruangan_id);
                $criteria->compare('instalasi_id',$this->instalasi_id);
                $criteria->compare('jeniskasuspenyakit_id',$this->jeniskasuspenyakit_id);
                $criteria->compare('LOWER(no_pendaftaran)',strtolower($this->no_pendaftaran),true);
                $criteria->compare('LOWER(tgl_pendaftaran)',strtolower($this->tgl_pendaftaran),true);
                $criteria->compare('no_urutantri',$this->no_urutantri);
                $criteria->compare('LOWER(transportasi)',strtolower($this->transportasi),true);
                $criteria->compare('LOWER(keadaanmasuk)',strtolower($this->keadaanmasuk),true);
                $criteria->compare('LOWER(statusperiksa)',strtolower($this->statusperiksa),true);
                $criteria->compare('LOWER(statuspasien)',strtolower($this->statuspasien),true);
                $criteria->compare('LOWER(kunjungan)',strtolower($this->kunjungan),true);
                $criteria->compare('alihstatus',$this->alihstatus);
                $criteria->compare('byphone',$this->byphone);
                $criteria->compare('kunjunganrumah',$this->kunjunganrumah);
                $criteria->compare('LOWER(statusmasuk)',strtolower($this->statusmasuk),true);
                $criteria->compare('LOWER(umur)',strtolower($this->umur),true);
                $criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
                $criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
                $criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
                $criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
                $criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
                $criteria->compare('nopendaftaran_aktif',$this->nopendaftaran_aktif);
                $criteria->compare('status_konfirmasi',$this->status_konfirmasi);
		$criteria->compare('date(tgl_konfirmasi)',$this->tgl_konfirmasi);
                
                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                ));
        }
        public function getInstalasiUangMukaItems(){
            $criteria = new CDbCriteria();
            $criteria->addInCondition('instalasi_id',array(
                        Params::INSTALASI_ID_RJ, 
                        Params::INSTALASI_ID_RD, 
                        Params::INSTALASI_ID_RI,
                        Params::INSTALASI_ID_LAB,
                    ));
            $criteria->order = 'instalasi_nama';
            $modInstalasis = InstalasiM::model()->findAll($criteria);
            if(count((array)$modInstalasis) > 0)
                return $modInstalasis;
            else
                return null;
        }
}