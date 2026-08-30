<?php

class SAObatalkesM extends ObatalkesM
{
    public $nama_pegawai;
    public $sumberdana_nama;
    public $jenisobatalkes_nama;
    public $satuankecil_nama, $persdiskon;
    public $carabayar_id, $penjamin_id, $carabayar_nama, $penjamin_nama, $persmargin, $biayaadministrasi;
    
    public static function model($className = __CLASS__) 
    {
        return parent::model($className);
    }
	
	public function searchGudangFarmasiPrint()
    {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=new CDbCriteria;

            $criteria->with = array('sumberdana','satuankecil','satuanbesar','lokasigudang');

            if(!empty($this->obatalkes_id)){
                    $criteria->addCondition('obatalkes_id = '.$this->obatalkes_id);
            }
            if(!empty($this->jenisobatalkes_id)){
                    $criteria->addCondition('jenisobatalkes_id = '.$this->jenisobatalkes_id);
            }
            if(!empty($this->sumberdana_id)){
                    $criteria->addCondition('t.sumberdana_id = '.$this->sumberdana_id);
            }
            if(!empty($this->lokasigudang_id)){
                    $criteria->addCondition('t.lokasigudang_id = '.$this->lokasigudang_id);
            }
            if(!empty($this->satuankecil_id)){
                    $criteria->addCondition('t.satuankecil_id = '.$this->satuankecil_id);
            }
            if(!empty($this->satuanbesar_id)){
                    $criteria->addCondition('t.satuanbesar_id = '.$this->satuanbesar_id);
            }
            if(!empty($this->subjenis_id)){
                    $criteria->addCondition('subjenis_id = '.$this->subjenis_id);
            }
            if(!empty($this->generik_id)){
                    $criteria->addCondition('generik_id = '.$this->generik_id);
            }
            $criteria->compare('LOWER(obatalkes_barcode)',strtolower($this->obatalkes_barcode),true);
            $criteria->compare('LOWER(obatalkes_kode)',strtolower($this->obatalkes_kode),true);
            $criteria->compare('LOWER(obatalkes_nama)',strtolower($this->obatalkes_nama),true);
            $criteria->compare('LOWER(obatalkes_namalain)',strtolower($this->obatalkes_namalain),true);
            $criteria->compare('LOWER(obatalkes_golongan)',strtolower($this->obatalkes_golongan),true);
            $criteria->compare('LOWER(obatalkes_kategori)',strtolower($this->obatalkes_kategori),true);
            $criteria->compare('LOWER(obatalkes_kadarobat)',strtolower($this->obatalkes_kadarobat),true);
            if(!empty($this->kemasanbesar)){
                    $criteria->addCondition('kemasanbesar = '.$this->kemasanbesar);
            }
            if(!empty($this->kekuatan)){
                    $criteria->addCondition('kekuatan = '.$this->kekuatan);
            }
            $criteria->compare('LOWER(satuankekuatan)',strtolower($this->satuankekuatan),true);
            $criteria->compare('ppn_persen',$this->ppn_persen);
            $criteria->compare('harganetto',$this->harganetto);
            $criteria->compare('hargajual',$this->hargajual);
            $criteria->compare('hargamaksimum',$this->hargamaksimum);
            $criteria->compare('hargaminimum',$this->hargaminimum);
            $criteria->compare('hargaaverage',$this->hargaaverage);
            $criteria->compare('margin',$this->margin);
            $criteria->compare('gp_persen',$this->gp_persen);
            $criteria->compare('discount',$this->discount);
            $criteria->compare('LOWER(tglkadaluarsa)',strtolower($this->tglkadaluarsa),true);
            if(!empty($this->minimalstok)){
                    $criteria->addCondition('minimalstok = '.$this->minimalstok);
            }
            $criteria->compare('LOWER(formularium)',strtolower($this->formularium),true);
            $criteria->compare('discountinue',$this->discountinue);
            $criteria->compare('LOWER(image_obat)',strtolower($this->image_obat),true);
            $criteria->compare('LOWER(activedate)',strtolower($this->activedate),true);
            $criteria->compare('mintransaksi',$this->mintransaksi);
            $criteria->compare('obatalkes_aktif',isset($this->obatalkes_aktif)?$this->obatalkes_aktif:true);
            $criteria->compare('obatalkes_farmasi',$this->obatalkes_farmasi);
            $criteria->compare('LOWER(noregister)',strtolower($this->noregister),true);
            $criteria->compare('LOWER(nobatch)',strtolower($this->nobatch),true);
            $criteria->compare('marginresep',$this->marginresep);
            $criteria->compare('jasadokter',$this->jasadokter);
            $criteria->compare('hjaresep',$this->hjaresep);
            $criteria->compare('marginnonresep',$this->marginnonresep);
            $criteria->compare('hjanonresep',$this->hjanonresep);
            $criteria->compare('hpp',$this->hpp);
            $criteria->compare('LOWER(jnskelompok)',strtolower($this->jnskelompok),true);
            $criteria->compare('LOWER(ven)',strtolower($this->ven),true);
            $criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
            $criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
            if(!empty($this->create_loginpemakai_id)){
                    $criteria->addCondition('create_loginpemakai_id = '.$this->create_loginpemakai_id);
            }
            if(!empty($this->update_loginpemakai_id)){
                    $criteria->addCondition('update_loginpemakai_id = '.$this->update_loginpemakai_id);
            }
            if(!empty($this->create_ruangan)){
                    $criteria->addCondition('create_ruangan = '.$this->create_ruangan);
            }
            if(!empty($this->pabrik_id)){
                    $criteria->addCondition('pabrik_id = '.$this->pabrik_id);
            }
            if(!empty($this->atc_id)){
                    $criteria->addCondition('atc_id = '.$this->atc_id);
            }
            if(!empty($this->maksimalstok)){
                    $criteria->addCondition('maksimalstok = '.$this->maksimalstok);
            }
            if(!empty($this->urutan_ven)){
                    $criteria->addCondition('urutan_ven = '.$this->urutan_ven);
            }
            $criteria->compare('LOWER(satuankecil.satuankecil_nama)',strtolower($this->satuankecilNama),true);
            $criteria->compare('LOWER(satuanbesar.satuanbesar_nama)',strtolower($this->satuanbesarNama),true);
            $criteria->compare('LOWER(sumberdana.sumberdana_nama)',strtolower($this->sumberdanaNama),true);
            $criteria->compare('LOWER(lokasigudang.lokasigudang_nama)',strtolower($this->lokasigudangNama),true);
            $criteria->compare('t.obatalkes_farmasi',$this->obatalkes_farmasi);
            $criteria->order='obatalkes_nama ASC';
            $criteria->limit = -1;

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
                    'pagination'=>false,
            ));
    }
	
    public function criteriaDataObat()
    {
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		if(is_array($this->obatalkes_id)){ //jika menampilkan banyak obatalkes_id
			$pilihObat = array();
			$i = 0;
			foreach($this->obatalkes_id as $idObat){
				$pilihObat[$i] = "obatalkes_id = '".$idObat."' "; //multiple conditions
				$i++;
			}
			$criteria->condition = implode(' OR ',$pilihObat);
		}else{
			if(!empty($this->obatalkes_id)){
				$criteria->addCondition('obatalkes_id = '.$this->obatalkes_id);
			}
			if(!empty($this->obatalkes_id)){
				$criteria->addCondition('obatalkes_id = '.$this->obatalkes_id);
			}
			if(!empty($this->sumberdana_id)){
				$criteria->addCondition('sumberdana_id = '.$this->sumberdana_id);
			}
			if(!empty($this->satuankecil_id)){
				$criteria->addCondition('satuankecil_id = '.$this->satuankecil_id);
			}
			if(!empty($this->jenisobatalkes_id)){
				$criteria->addCondition('jenisobatalkes_id = '.$this->jenisobatalkes_id);
			}
			$criteria->compare('LOWER(obatalkes_kode)',strtolower($this->obatalkes_kode),true);
			$criteria->compare('LOWER(obatalkes_nama)',strtolower($this->obatalkes_nama),true);
			$criteria->compare('LOWER(obatalkes_golongan)',strtolower($this->obatalkes_golongan),true);
			$criteria->compare('LOWER(obatalkes_kategori)',strtolower($this->obatalkes_kategori),true);
			$criteria->compare('LOWER(obatalkes_kadarobat)',strtolower($this->obatalkes_kadarobat),true);
			$criteria->compare('kemasanbesar',$this->kemasanbesar);
			$criteria->compare('kekuatan',$this->kekuatan);
			$criteria->compare('LOWER(satuankekuatan)',strtolower($this->satuankekuatan),true);
			$criteria->compare('harganetto',$this->harganetto);
			$criteria->compare('hargajual',$this->hargajual);
			$criteria->compare('discount',$this->discount);
		}
		if ($this->tglkadaluarsa == 1){
			$criteria->addBetweenCondition('date(tglkadaluarsa)',$this->tglkadaluarsa_awal, $this->tglkadaluarsa_akhir);
		}
		$criteria->compare('obatalkes_aktif',TRUE);
		if(!isset($_GET['SAObatalkesM'])){
			$criteria->limit = 0;
		}
		return $criteria;
    }
    
    public function searchDataObat()
	{
		return new CActiveDataProvider($this, array(
			'criteria'=>$this->criteriaDataObat(),
                        'pagination'=>false,
		));
	}
        
    public function searchDataObatAfter()
	{
            $criteria=new CDbCriteria;
            if(is_array($this->obatalkes_id)){ //jika menampilkan banyak obatalkes_id
                $pilihObat = array();
                $i = 0;
                foreach($this->obatalkes_id as $idObat){
                    $pilihObat[$i] = "obatalkes_id = '".$idObat."' "; //multiple conditions
                    $i++;
                }
                $criteria->condition = implode(' OR ',$pilihObat);
            }else{
                if(!empty($this->obatalkes_id)){
                    $criteria->addCondition('obatalkes_id = '.$this->obatalkes_id);
                }
				if(!empty($this->sumberdana_id)){
                    $criteria->addCondition('sumberdana_id = '.$this->sumberdana_id);
                }
				if(!empty($this->satuankecil_id)){
                    $criteria->addCondition('satuankecil_id = '.$this->satuankecil_id);
                }
				if(!empty($this->jenisobatalkes_id)){
                    $criteria->addCondition('jenisobatalkes_id = '.$this->jenisobatalkes_id);
                }
                $criteria->compare('LOWER(obatalkes_kode)',strtolower($this->obatalkes_kode),true);
                $criteria->compare('LOWER(obatalkes_nama)',strtolower($this->obatalkes_nama),true);
                $criteria->compare('LOWER(obatalkes_golongan)',strtolower($this->obatalkes_golongan),true);
                $criteria->compare('LOWER(obatalkes_kategori)',strtolower($this->obatalkes_kategori),true);
                $criteria->compare('LOWER(obatalkes_kadarobat)',strtolower($this->obatalkes_kadarobat),true);
                $criteria->compare('kemasanbesar',$this->kemasanbesar);
                $criteria->compare('kekuatan',$this->kekuatan);
                $criteria->compare('LOWER(satuankekuatan)',strtolower($this->satuankekuatan),true);
                $criteria->compare('harganetto',$this->harganetto);
                $criteria->compare('hargajual',$this->hargajual);
                $criteria->compare('discount',$this->discount);
            }
            if ($this->tglkadaluarsa == 1){
                $criteria->addBetweenCondition('date(tglkadaluarsa)',$this->tglkadaluarsa_awal, $this->tglkadaluarsa_akhir);
            }
            $criteria->compare('obatalkes_aktif',TRUE);
                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
            ));
	}
        
    public function searchDialog()
    {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=new CDbCriteria;
            $criteria->join = "JOIN sumberdana_m ON sumberdana_m.sumberdana_id = t.sumberdana_id 
                            JOIN satuankecil_m ON satuankecil_m.satuankecil_id = t.satuankecil_id
                            LEFT JOIN jenisobatalkes_m ON jenisobatalkes_m.jenisobatalkes_id = t.jenisobatalkes_id
                            ";
			if(!empty($this->obatalkes_id)){
				$criteria->addCondition('obatalkes_id = '.$this->obatalkes_id);
			}
			if(!empty($this->sumberdana_id)){
				$criteria->addCondition('t.sumberdana_id = '.$this->sumberdana_id);
			}
			if(!empty($this->satuankecil_id)){
				$criteria->addCondition('t.satuankecil_id = '.$this->satuankecil_id);
			}
			if(!empty($this->jenisobatalkes_id)){
				$criteria->addCondition('t.jenisobatalkes_id = '.$this->jenisobatalkes_id);
			}
            $criteria->compare('LOWER(t.obatalkes_kode)',strtolower($this->obatalkes_kode),true);
            $criteria->compare('LOWER(t.obatalkes_nama)',strtolower($this->obatalkes_nama),true);
            $criteria->compare('LOWER(t.obatalkes_golongan)',strtolower($this->obatalkes_golongan),true);
            $criteria->compare('LOWER(t.obatalkes_kategori)',strtolower($this->obatalkes_kategori),true);
            $criteria->compare('LOWER(t.tglkadaluarsa)',strtolower($this->tglkadaluarsa),true);
            $criteria->compare('LOWER(satuankecil_m.satuankecil_nama)',strtolower($this->satuankecil_nama),true);
            $criteria->compare('LOWER(sumberdana_m.sumberdana_nama)',strtolower($this->sumberdana_nama),true);
            $criteria->compare('LOWER(jenisobatalkes_m.jenisobatalkes_nama)',strtolower($this->jenisobatalkes_nama),true);
            $criteria->addCondition('obatalkes_aktif = TRUE');
            $criteria->order='obatalkes_nama ASC';
			$criteria->limit = 10;
            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
					'pagination'=>false,
            ));
    }
    /**
     * untuk dialog pilih obat alkes
     * @return type
     */
    public function getSatuanKecilNama(){
        return $this->satuankecil->satuankecil_nama;
    }
	
	public function getStokObatRuanganPemesan(){ // menampilkan stok obat berdasarkan ruangan pemesan
		if(isset($_GET['pesanobatalkes_id'])){
			$modInfoOa = GFInformasipesanobatalkesV::model()->findByAttributes(array('pesanobatalkes_id'=>$_GET['pesanobatalkes_id']));
			return StokobatalkesT::getJumlahStok($this->obatalkes_id,$modInfoOa->ruanganpemesan_id);
		}else{
			return StokobatalkesT::getJumlahStok($this->obatalkes_id,Yii::app()->user->getState('ruangan_id'));
		}
	}
    
	
	public function searchPilih()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$criteria->with = array('jenisobatalkes');
		
		if(!empty($this->obatalkes_id)){
			$criteria->addCondition('obatalkes_id = '.$this->obatalkes_id);
		}
		if(!empty($this->jenisobatalkes_id)){
			$criteria->addCondition('jenisobatalkes_id = '.$this->jenisobatalkes_id);
		}
		
		$criteria->compare('LOWER(obatalkes_kode)',strtolower($this->obatalkes_kode),true);
		$criteria->compare('LOWER(obatalkes_nama)',strtolower($this->obatalkes_nama),true);
		$criteria->compare('LOWER(jenisobatalkes.jenisobatalkes_nama)',strtolower($this->jenisobatalkes_nama),true);
		$criteria->addCondition("obatalkes_aktif = TRUE");
		$criteria->order='obatalkes_nama ASC';
		$criteria->limit=10;
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	public function getPabrikItems()
	{
		return PabrikM::model()->findAll('pabrik_aktif=true ORDER BY pabrik_nama');
	}
        
	public function getAtcItems()
	{
		return SAAtcM::model()->findAll('atc_aktif=true ORDER BY atc_nama');
	}
        
        public function getNameLookup($data=null){
            $jns = LookupM::model()->findAll(" lookup_type = 'jnskelompok' AND lookup_aktif = TRUE ");
            $arr = array();                
            foreach($jns as $jns){
                $arr[$jns->lookup_value] = $jns->lookup_name;
            }
            
            if (isset($arr[$data])){
                return $arr[$data];
            }else{
                return '-';
            }
        }

        public function searchInformasiHargaObatPenjamin()
        {

                $criteria=new CDbCriteria;
                $criteria->join = "JOIN jenisobatalkes_m ON jenisobatalkes_m.jenisobatalkes_id = t.jenisobatalkes_id 
                                JOIN obatalkespenjamin_m ON obatalkespenjamin_m.jenisobatalkes_id = t.jenisobatalkes_id  
                                JOIN penjaminpasien_m on penjaminpasien_m.penjamin_id = obatalkespenjamin_m.penjamin_id 
                                JOIN carabayar_m on carabayar_m.carabayar_id = obatalkespenjamin_m.carabayar_id ";
                $criteria->select = "t.obatalkes_id, t.obatalkes_nama, jenisobatalkes_m.jenisobatalkes_id, jenisobatalkes_m.jenisobatalkes_nama, carabayar_m.carabayar_id, carabayar_m.carabayar_nama, penjaminpasien_m.penjamin_id, penjaminpasien_m.penjamin_nama, t.harganetto, t.discount, t.ppn_persen, t.hpp, obatalkespenjamin_m.persmargin, obatalkespenjamin_m.biayaadministrasi, obatalkespenjamin_m.persdiskon";

                if(!empty($this->carabayar_id)){
                        $criteria->addCondition('carabayar_m.carabayar_id = '.$this->carabayar_id);
                }
                if(!empty($this->penjamin_id)){
                        $criteria->addCondition('penjaminpasien_m.penjamin_id = '.$this->penjamin_id);
                }
                if(!empty($this->obatalkes_id)){
                        $criteria->addCondition('t.obatalkes_id = '.$this->obatalkes_id);     
                }
                if(!empty($this->jenisobatalkes_id)){
                        $criteria->addCondition('t.jenisobatalkes_id = '.$this->jenisobatalkes_id);     
                }
                        
                $criteria->order='t.obatalkes_id ASC, t.jenisobatalkes_id ASC, carabayar_m.carabayar_id ASC, penjaminpasien_m.penjamin_id';
                
                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria
                ));
        }

        public function searchInformasiHargaObatPenjaminPrint()
        {

                $criteria=new CDbCriteria;
                $criteria->join = "JOIN jenisobatalkes_m ON jenisobatalkes_m.jenisobatalkes_id = t.jenisobatalkes_id 
                                JOIN obatalkespenjamin_m ON obatalkespenjamin_m.jenisobatalkes_id = t.jenisobatalkes_id  
                                JOIN penjaminpasien_m on penjaminpasien_m.penjamin_id = obatalkespenjamin_m.penjamin_id 
                                JOIN carabayar_m on carabayar_m.carabayar_id = obatalkespenjamin_m.carabayar_id ";
                                $criteria->select = "t.obatalkes_id, t.obatalkes_nama, jenisobatalkes_m.jenisobatalkes_id, jenisobatalkes_m.jenisobatalkes_nama, carabayar_m.carabayar_id, carabayar_m.carabayar_nama, penjaminpasien_m.penjamin_id, penjaminpasien_m.penjamin_nama, t.harganetto, t.discount, t.ppn_persen, t.hpp, obatalkespenjamin_m.persmargin, obatalkespenjamin_m.biayaadministrasi, obatalkespenjamin_m.persdiskon";

                if(!empty($this->carabayar_id)){
                        $criteria->addCondition('carabayar_m.carabayar_id = '.$this->carabayar_id);
                }
                if(!empty($this->penjamin_id)){
                        $criteria->addCondition('penjaminpasien_m.penjamin_id = '.$this->penjamin_id);
                }
                if(!empty($this->obatalkes_id)){
                        $criteria->addCondition('t.obatalkes_id = '.$this->obatalkes_id);     
                }
                if(!empty($this->jenisobatalkes_id)){
                        $criteria->addCondition('t.jenisobatalkes_id = '.$this->jenisobatalkes_id);     
                }
                        
                $criteria->order='t.obatalkes_id ASC, t.jenisobatalkes_id ASC, carabayar_m.carabayar_id ASC, penjaminpasien_m.penjamin_id';
                
                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false
                ));
        }
        
}

?>
