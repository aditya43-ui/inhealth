<?php
class GFInformasiformuliropnameV extends InformasiformuliropnameV
{
        public $tgl_awal,$tgl_akhir;
        public $bln_awal, $bln_akhir;
        public $thn_awal, $thn_akhir;
        public $jns_periode;
        public $jumlah, $data, $tick;
        public $status;
        
        
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InformasiformuliropnameV the static model class
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

		$criteria->addBetweenCondition('DATE(tglformulir)', $this->tgl_awal, $this->tgl_akhir);
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
		$criteria->compare('tglstokopname',$this->tglstokopname,true);
		$criteria->compare('nostokopname',$this->nostokopname,true);
		$criteria->compare('isstokawal',$this->isstokawal);
		$criteria->compare('jenisstokopname',$this->jenisstokopname,true);
		$criteria->compare('keterangan_opname',$this->keterangan_opname,true);
		$criteria->compare('totalharga',$this->totalharga);
		$criteria->compare('totalvolume',$this->totalvolume);
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
        
        public function searchLaporanFormulir() {
            $criteria = new CDbCriteria();
            $criteria = $this->functionLaporanFormulirCriteria();
            $criteria->order = 'tglformulir DESC';

            return new CActiveDataProvider($this, array(
                        'criteria' => $criteria,
                    ));
        }

        public function searchLaporanFormulirPrint() {
            $criteria = new CDbCriteria();
            $criteria = $this->functionLaporanFormulirCriteria();
            $criteria->order = 'tglformulir DESC';
            $criteria->limit = -1;

            return new CActiveDataProvider($this, array(
                        'criteria' => $criteria,
                        'pagination' => false,
                    ));
        }

        protected function functionLaporanFormulirCriteria() {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria = new CDbCriteria;
            
            $criteria->addBetweenCondition('tglformulir',$this->tgl_awal,$this->tgl_akhir,true);                       
            $criteria->compare("LOWER(noformulir)", strtolower($this->noformulir));
            
            if (!empty($this->status)){                                
                if ($this->status=='1'){
                    $criteria->addCondition(" stokopname_id IS NOT NULL ");
                }elseif ($this->status=='2'){
                    $criteria->addCondition(" stokopname_id IS NULL ");
                }
            }

            


            return $criteria;
        }

         public function searchGrafik()
         {
                    // Warning: Please modify the following code to remove attributes that
                    // should not be searched.

                $criteria=new CDbCriteria;

                $criteria->select = "count(formuliropname_id) as jumlah, (CASE WHEN stokopname_id IS NOT NULL THEN 'Sudah Stok Opname' ELSE 'Belum Stok Opname' END) as data";
                $criteria->group = 'stokopname_id';
                $criteria->addBetweenCondition('tglformulir',$this->tgl_awal,$this->tgl_akhir,true);                       
                $criteria->compare("LOWER(noformulir)", strtolower($this->noformulir));
            if (!empty($this->status)){
                if ($this->status=='1'){
                    $criteria->addCondition(" stokopname_id IS NOT NULL ");
                }elseif ($this->status=='0'){
                    $criteria->addCondition(" stokopname_id IS NULL ");
                }
            }


                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                ));
        }     
		
		public function getRakByFormulir($formuliropname_id) {
			$modCari = FormstokopnameR::model()->findAllByAttributes(['formuliropname_id' => $formuliropname_id]);
	
			$data = "";
			$rak = [];
			if (!empty($modCari)) {
				foreach ($modCari as $key => $det) {
					if (!empty($det->rakobat_id)) {
						$modRak = RakobatM::model()->findByPk($det->rakobat_id);
						$rak[$det->rakobat_id] = $modRak->rakobat_nama;
					}
				}
			}
	
			if (!empty($rak)) {
				$data = implode(", ", $rak);
			}
	
			return $data;
		}

}