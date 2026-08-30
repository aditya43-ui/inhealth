<?php

class PCInfopasienmasukkamarV extends InfopasienmasukkamarV
{
    public $ceklis = false;
    public $no_pemberian_resep;
	public $nama_pasien;
	public $no_pemberianobat;
	
        /**
        * Returns the static model of the specified AR class.
        * @param string $className active record class name.
        * @return InfopasienmasukkamarV the static model class
        */
        public static function model($className=__CLASS__)
        {
                return parent::model($className);
        }
		
		public function searchRI()
		{
			// Warning: Please modify the following code to remove attributes that
			// should not be searched.

			$criteria=new CDbCriteria;

			$criteria->addCondition('ruangan_id = '.Yii::app()->user->getState('ruangan_id'));
			if(!empty($this->penjamin_id)){
				$criteria->addCondition("penjamin_id = ".$this->penjamin_id); 	
			}
			if(!empty($this->carabayar_id)){
				$criteria->addCondition("carabayar_id = ".$this->carabayar_id); 	
			}
			if(!empty($this->caramasuk_id)){
				$criteria->addCondition("caramasuk_id = ".$this->caramasuk_id); 	
			}
			$criteria->compare('LOWER(no_rekam_medik)',strtolower($this->no_rekam_medik),true);
			$criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);
			$criteria->compare('LOWER(no_pendaftaran)',strtolower($this->no_pendaftaran),true);
			$criteria->compare('LOWER(nama_pegawai)',strtolower($this->nama_pegawai),true);
			if($this->ceklis == 1)
			{
				$criteria->addBetweenCondition('tgladmisi',$this->tgl_awal,$this->tgl_akhir);
			}

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
		
        public function getNoRmNamaPasien()
        {
                return $this->no_rekam_medik.' / '. (($this->namadepan)?$this->namadepan.$this->nama_pasien:$this->nama_pasien);
        }
		
        public function getInstalasiRuangan()
        {
                return $this->instalasi_nama.' / '. $this->ruangan_nama;
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