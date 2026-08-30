<?php

/**
 * This is the model class for table "infokunjunganrd_v".
 *
 * The followings are the available columns in table 'infokunjunganrd_v':
 * @property integer $pendaftaran_id
 * @property string $tgl_pendaftaran
 * @property string $no_pendaftaran
 * @property string $statusperiksa
 * @property string $statusmasuk
 * @property string $no_rekam_medik
 * @property string $nama_pasien
 * @property string $alamat_pasien
 * @property integer $propinsi_id
 * @property string $propinsi_nama
 * @property integer $kabupaten_id
 * @property string $kabupaten_nama
 * @property integer $kecamatan_id
 * @property string $kecamatan_nama
 * @property integer $kelurahan_id
 * @property string $kelurahan_nama
 * @property integer $instalasi_id
 * @property string $ruangan_nama
 * @property integer $carabayar_id
 * @property string $carabayar_nama
 * @property integer $penjamin_id
 * @property string $penjamin_nama
 * @property integer $rujukan_id
 */
class FAInfoKunjunganRDV extends InfokunjunganrdV
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InfokunjunganrdV the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public function searchRD()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
                
		$criteria->addBetweenCondition('DATE(tgl_pendaftaran)',$this->tgl_awal,$this->tgl_akhir);
		$criteria->compare('LOWER(no_pendaftaran)',strtolower($this->no_pendaftaran),true);
		$criteria->compare('LOWER(statusperiksa)',strtolower($this->statusperiksa),true);
		$criteria->compare('LOWER(statusmasuk)',strtolower($this->statusmasuk),true);
		$criteria->compare('LOWER(no_rekam_medik)',strtolower($this->no_rekam_medik),true);
		$criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);
		$criteria->compare('LOWER(nama_bin)',strtolower($this->nama_bin),true);
		$criteria->compare('LOWER(alamat_pasien)',strtolower($this->alamat_pasien),true);
		if(!empty($this->propinsi_id)){
			$criteria->addCondition("propinsi_id = ".$this->propinsi_id);						
		}
		$criteria->compare('LOWER(propinsi_nama)',strtolower($this->propinsi_nama),true);
		if(!empty($this->kabupaten_id)){
			$criteria->addCondition("kabupaten_id = ".$this->kabupaten_id);						
		}
		$criteria->compare('LOWER(kabupaten_nama)',strtolower($this->kabupaten_nama),true);
		if(!empty($this->kecamatan_id)){
			$criteria->addCondition("kecamatan_id = ".$this->kecamatan_id);						
		}
		$criteria->compare('LOWER(kecamatan_nama)',strtolower($this->kecamatan_nama),true);
		if(!empty($this->kelurahan_id)){
			$criteria->addCondition("kelurahan_id = ".$this->kelurahan_id);						
		}
		$criteria->compare('LOWER(kelurahan_nama)',strtolower($this->kelurahan_nama),true);
		$criteria->addCondition('instalasi_id = '.Params::INSTALASI_ID_RD);
		$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
		if(!empty($this->carabayar_id)){
			$criteria->addCondition("carabayar_id = ".$this->carabayar_id);						
		}
		$criteria->compare('LOWER(carabayar_nama)',strtolower($this->carabayar_nama),true);
		if(!empty($this->penjamin_id)){
			$criteria->addCondition("penjamin_id = ".$this->penjamin_id);						
		}
		$criteria->compare('LOWER(penjamin_nama)',strtolower($this->penjamin_nama),true);
		$criteria->compare('LOWER(nama_pegawai)',strtolower($this->nama_pegawai),true);
		$criteria->compare('LOWER(jeniskasuspenyakit_nama)',strtolower($this->jeniskasuspenyakit_nama),true);
		if(!empty($this->rujukan_id)){
			$criteria->addCondition("rujukan_id = ".$this->rujukan_id);						
		}
//                $criteria->compare('statusperiksa','BELUM BAYAR');
		$criteria->addCondition('pembayaranpelayanan_id is null');

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	//=== Start functions untuk dialogPasien ===
        
        public function getTanggungan(){
            $val = array();
            if(!empty($this->penjamin_id) && !empty($this->kelaspelayanan_id) && !empty($this->carabayar_id)){
                $criteria = new CDbCriteria();
				if(!empty($this->penjamin_id)){
					$criteria->addCondition("penjamin_id = ".$this->penjamin_id);						
				}
				if(!empty($this->kelaspelayanan_id)){
					$criteria->addCondition("kelaspelayanan_id = ".$this->kelaspelayanan_id);						
				}
				if(!empty($this->carabayar_id)){
					$criteria->addCondition("carabayar_id = ".$this->carabayar_id);						
				}
                $tanggungan = TanggunganpenjaminM::model()->find($criteria);
             $val['makstanggpel'] = isset($tanggungan->makstanggpel)?$tanggungan->makstanggpel:null;
                $val['subsidirumahsakitoa'] = isset($tanggungan->subsidirumahsakitoa)?$tanggungan->subsidirumahsakitoa:null;
                $val['subsidipemerintahoa'] = isset($tanggungan->subsidipemerintahoa)?$tanggungan->subsidipemerintahoa:null;
                $val['subsidiasuransioa'] = isset($tanggungan->subsidiasuransioa)?$tanggungan->subsidiasuransioa:null;
                $val['iurbiayaoa'] = isset($tanggungan->iurbiayaoa)?$tanggungan->iurbiayaoa:null;
            }
            return $val;
        }
        //Harus dipecah karena di CGridview tidak bisa menampilkan array dan class model hanya bisa string
        public function getMakstanggpel(){
            $value = $this->Tanggungan['makstanggpel'];
            return empty($value) ? 0 : $value;
        }
        public function getSubsidirumahsakitoa(){
            $value = $this->Tanggungan['subsidirumahsakitoa'];
            return empty($value) ? 0 : $value;
        }
        public function getSubsidipemerintahoa(){
            $value = $this->Tanggungan['subsidipemerintahoa'];
            return empty($value) ? 0 : $value;
        }
        public function getSubsidiasuransioa(){
            $value = $this->Tanggungan['subsidiasuransioa'];
            return empty($value) ? 0 : $value;
        }
        public function getIurbiayaoa(){
            $value = $this->Tanggungan['iurbiayaoa'];
            return empty($value) ? 0 : $value;
        }
        
        //=== End functions ===
}