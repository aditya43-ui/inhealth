<?php

class GJPembayaranjasaT extends PembayaranjasaT
{
        public $pilihDokter, $tgl_awalPenunjang, $tgl_akhirPenunjang, $tgl_awalPendaftaran, $tgl_akhirPendaftaran, $rujukandariNama, $pegawaiNama; 
        //untuk pencarian
        public $noKasKeluar, $namaPerujuk, $tgl_awal, $tgl_akhir, $komponentarifId, $instalasi_id;
        
        public $total_terima_perawat;
		public $jabatan_id;
        public $tgl_awaljasa, $tgl_akhirjasa;
        public $cari_period;
        public $cekPeriode;
        public $penggajianpeg_id;
        public $status_gaji;
        public $komponentarif_id;
                
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PembayaranjasaT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function criteriaSearch()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
                
		$criteria=new CDbCriteria;
		$criteria->with = array('rujukandari', 'pegawai', 'tandabuktikeluar');		
		
		if(!empty($this->pembayaranjasa_id)){
			$criteria->addCondition("pembayaranjasa_id = ".$this->pembayaranjasa_id);					
		}
		if(!empty($this->tandabuktikeluar_id)){
			$criteria->addCondition("tandabuktikeluar_id = ".$this->tandabuktikeluar_id);					
		}
		if(!empty($this->rujukandari_id)){
			$criteria->addCondition("rujukandari_id = ".$this->rujukandari_id);					
		}
		if(!empty($this->pegawai_id)){
			$criteria->addCondition("pegawai_id = ".$this->pegawai_id);					
		}
		$criteria->compare('LOWER(nobayarjasa)',strtolower($this->nobayarjasa),true);
		$criteria->compare('LOWER(periodejasa)',strtolower($this->periodejasa),true);
		$criteria->compare('LOWER(sampaidgn)',strtolower($this->sampaidgn),true);
		
		$criteria->compare('LOWER(tandabuktikeluar.nokaskeluar)',strtolower($this->noKasKeluar),true);
		$criteria->compare('LOWER(rujukandari.namaperujuk)',strtolower($this->namaPerujuk),true);
		$criteria->compare('LOWER(pegawai.nama_pegawai)',strtolower($this->namaDokter),true);
		
		if (!empty($this->kelompokpegawai_id)){
			$criteria->addCondition(" pegawai.kelompokpegawai_id = '".$this->kelompokpegawai_id."' ");
		}
		
		if (!empty($this->jabatan_id)){
			$criteria->addCondition(" pegawai.jabatan_id = '".$this->jabatan_id."' ");
		}
                
                
		return $criteria;
	}			
	
	public function searchInformasiBaru()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
                
		$criteria=new CDbCriteria;
		$criteria->select = " kol.penggajianpeg_id, t.* , (CASE WHEN (t.pegawai_id is NULL AND t.rujukandari_id is NULL) THEN kol.pilihjasa ELSE 'rs' END) as pilihjasa,  (CASE WHEN kol.total_terima IS NULL THEN t.totalbayarjasa ELSE kol.total_terima END) as total_terima,"
			. "					(CASE WHEN "
			. "						(t.pegawai_id is NULL AND t.rujukandari_id is NULL)"
			. "					THEN "
			. "						kolkel.kelompokpegawai_nama "
			. "					WHEN "
			. "						(t.rujukandari_id is NOT NULL) "
			. "					THEN "
			. "						'' "
			. "					WHEN "
			. "						(t.pegawai_id is NOT NULL) "
			. "					THEN "
			. "						mankel.kelompokpegawai_nama  "
			. "					ELSE ''	"			
			. "					END) as kelompokpegawai_nama,"
			
			. "					(CASE WHEN "
			. "						(t.pegawai_id is NULL AND t.rujukandari_id is NULL)"
			. "					THEN "
			. "						koljab.jabatan_nama "
			. "					WHEN "
			. "						(t.rujukandari_id is NOT NULL) "
			. "					THEN "
			. "						rujuk.spesialis "
			. "					WHEN "
			. "						(t.pegawai_id is NOT NULL) "
			. "					THEN "
			. "						manjab.jabatan_nama  "
			. "					ELSE ''	"			
			. "					END) as jabatan_nama,"
			
			. "					(CASE WHEN "
			. "						(t.pegawai_id is NULL AND t.rujukandari_id is NULL)"
			. "					THEN "
			. "						CONCAT(kolpeg.gelardepan,' ',kolpeg.nama_pegawai,', ',kolgelar.gelarbelakang_nama) "
			. "					WHEN "
			. "						(t.rujukandari_id is NOT NULL) "
			. "					THEN "
			. "						rujuk.namaperujuk "
			. "					WHEN "
			. "						(t.pegawai_id is NOT NULL) "
			. "					THEN "
			. "						CONCAT(man.gelardepan,' ',man.nama_pegawai,', ',mangelar.gelarbelakang_nama) "
			. "					ELSE ''	"			
			. "					END) as nama_pegawai";
		$criteria->join = " LEFT JOIN Pembjasaperawat_t kol ON kol.pembayaranjasa_id = t.pembayaranjasa_id "
						. "	LEFT JOIN pegawai_m kolpeg ON kolpeg.pegawai_id = kol.pegawai_id "
						. "	LEFT JOIN kelompokpegawai_m kolkel ON kolkel.kelompokpegawai_id = kolpeg.kelompokpegawai_id "
						. "	LEFT JOIN jabatan_m koljab ON koljab.jabatan_id = kolpeg.jabatan_id "
						. "	LEFT JOIN gelarbelakang_m kolgelar ON kolgelar.gelarbelakang_id = kolpeg.gelarbelakang_id "
						. "	LEFT JOIN pegawai_m man ON man.pegawai_id = t.pegawai_id "
						. "	LEFT JOIN kelompokpegawai_m mankel ON mankel.kelompokpegawai_id = man.kelompokpegawai_id "
						. "	LEFT JOIN jabatan_m manjab ON manjab.jabatan_id = man.jabatan_id "
						. "	LEFT JOIN gelarbelakang_m mangelar ON mangelar.gelarbelakang_id = man.gelarbelakang_id "
						. "	LEFT JOIN rujukandari_m rujuk ON rujuk.rujukandari_id = t.rujukandari_id";
                
                if (!empty($this->cari_period)){
                    $criteria->addBetweenCondition('periodejasa', date('Y-m-01', strtotime($this->cari_period)), date('Y-m-t', strtotime($this->cari_period)), 'OR');
                    $criteria->addBetweenCondition('sampaidgn', date('Y-m-01', strtotime($this->cari_period)), date('Y-m-t', strtotime($this->cari_period)), 'OR');
                }else{
                    $criteria->addBetweenCondition('tglbayarjasa', $this->tgl_awal, $this->tgl_akhir);                    
                }
                
                if (!empty($this->status_gaji)){
                    $cri = new CDbCriteria();                    
                    $cri->join = " JOIN pembayaranjasa_t pj ON pj.pembayaranjasa_id = t.pembayaranjasa_id ";
                    if (!empty($this->cari_period)){
                        $cri->addBetweenCondition('periodejasa', date('Y-m-01', strtotime($this->cari_period)), date('Y-m-t', strtotime($this->cari_period)), 'OR');
                        $cri->addBetweenCondition('sampaidgn', date('Y-m-01', strtotime($this->cari_period)), date('Y-m-t', strtotime($this->cari_period)), 'OR');
                    }else{
                        $cri->addBetweenCondition('tglbayarjasa', $this->tgl_awal, $this->tgl_akhir);                    
                    }
                    if ($this->status_gaji == 'SUDAH'){
                        $cri->addCondition(" is_penggajian = TRUE AND pj.pegawai_id IS NOT NULL ");
                    }elseif ($this->status_gaji == 'BELUM'){
                        $cri->addCondition(" is_penggajian = FALSE AND pj.pegawai_id IS NOT NULL ");
                    }                    
                    $peg = PengajuanjasapenggajianMetaV::model()->findAll($cri);
                    
//                    var_dump(count((array)$peg));
                    
                    $id = ' OR ( t.pegawai_id IN (';
                    
                    if (count((array)$peg)>0){
                        $i = 1;
                        foreach($peg as $val){
                            if ($i == count((array)$peg)){
                                $id .= $val->pegawai_id.') ) ';
                            }else{
                                $id .= $val->pegawai_id.',';
                            }
                            $i++;
                        }
                    }else{
                        $id = '';
                    }
                    
                    if ($this->status_gaji == 'SUDAH'){
                        $criteria->addCondition(" kol.penggajianpeg_id IS NOT NULL ".$id." ");
                        //$criteria->addCondition(" kol.penggajianpeg_id IS NOT NULL");
                    }else{
                        $criteria->addCondition(" (kol.penggajianpeg_id IS NULL AND t.pegawai_id IS NULL) ".$id." ");
                        //$criteria->addCondition(" kol.penggajianpeg_id IS NULL");
                    }
                }
		
		if (!empty($this->kelompokpegawai_id)){
			$criteria->addCondition(" kolpeg.kelompokpegawai_id = '".$this->kelompokpegawai_id."' OR  man.kelompokpegawai_id = '".$this->kelompokpegawai_id."' ");			
		}
		
		if (!empty($this->jabatan_id)){
			$criteria->addCondition(" kolpeg.jabatan_id = '".$this->jabatan_id."' OR  man.jabatan_id = '".$this->jabatan_id."' ");			
		}
		
		if (!empty($this->namaDokter)){
			$criteria->addCondition(" kolpeg.nama_pegawai ilike '%".$this->namaDokter."%' OR  man.nama_pegawai ilike '%".$this->namaDokter."%' ");			
		}
		
		if (!empty($this->jenisjasa)){
			if ($this->jenisjasa == 'rs'){
				$criteria->addCondition(" kol.pilihjasa = '".$this->jenisjasa."' OR (t.pegawai_id IS NOT NULL OR t.rujukandari_id IS NOT NULL)   ");			
			}else{
				$criteria->addCondition(" kol.pilihjasa = '".$this->jenisjasa."'   ");			
			}
		}
		
		if (!empty($this->create_loginpemakai_id)){
			$criteria->addCondition(" t.create_loginpemakai_id = '".$this->create_loginpemakai_id."'  ");			
		}
		
		$criteria->compare("LOWER(nobayarjasa)",strtolower($this->nobayarjasa),true);
				
		$criteria->order = "tglbayarjasa DESC";
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
	public function searchInformasi()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
                
		$criteria=$this->criteriaSearch();		
		$criteria->addBetweenCondition('tglbayarjasa', $this->tgl_awal, $this->tgl_akhir);
		$criteria->order = "tglbayarjasa";
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public function searchTableLaporan()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
                
		$criteria=$this->criteriaSearch();
                $criteria->addBetweenCondition('tglbayarjasa', $this->tgl_awal, $this->tgl_akhir);
                $criteria->order = "tglbayarjasa";
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	public function searchPrint()
	{
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

		$criteria=new CDbCriteria;
		
		if(!empty($this->pembayaranjasa_id)){
			$criteria->addCondition("pembayaranjasa_id = ".$this->pembayaranjasa_id);					
		}
		if(!empty($this->tandabuktikeluar_id)){
			$criteria->addCondition("tandabuktikeluar_id = ".$this->tandabuktikeluar_id);					
		}
		if(!empty($this->rujukandari_id)){
			$criteria->addCondition("rujukandari_id = ".$this->rujukandari_id);					
		}
		if(!empty($this->pegawai_id)){
			$criteria->addCondition("pegawai_id = ".$this->pegawai_id);					
		}
		$criteria->compare('LOWER(tglbayarjasa)',strtolower($this->tglbayarjasa),true);
		$criteria->compare('LOWER(nobayarjasa)',strtolower($this->nobayarjasa),true);
		$criteria->compare('LOWER(periodejasa)',strtolower($this->periodejasa),true);
		$criteria->compare('LOWER(sampaidgn)',strtolower($this->sampaidgn),true);
		$criteria->compare('totaltarif',$this->totaltarif);
		$criteria->compare('totaljasa',$this->totaljasa);
		$criteria->compare('totalbayarjasa',$this->totalbayarjasa);
		$criteria->compare('totalsisajasa',$this->totalsisajasa);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
}