<?php
class KUInformasifakturumumV extends InformasifakturumumV
{
	public $tgl_awal,$tgl_akhir;
	public $bln_awal, $bln_akhir;
	public $thn_awal, $thn_akhir;
	public $jns_periode;
	public $tick, $data, $jumlah, $filter;
	public $tgl_awalJatuhTempo, $tgl_akhirJatuhTempo;
	public $umurHutang;
	public $grandtotal;
	public $statusBayar;
	public $totalhargabruto, $totalkeseluruhan;
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InformasifakturumumV the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function criteriaSearch()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;		
		$criteria->join = " JOIN terimapersediaan_t tp ON tp.terimapersediaan_id = t.terimapersediaan_id ";

		if(!empty($this->instalasi_id)){
			$criteria->addCondition('t.instalasi_id = '.$this->instalasi_id);
		}
		$criteria->compare('LOWER(t.instalasi_nama)',strtolower($this->instalasi_nama),true);
		if(!empty($this->ruangan_id)){
			$criteria->addCondition('t.ruangan_id = '.$this->ruangan_id);
		}
		$criteria->compare('LOWER(t.ruangan_nama)',strtolower($this->ruangan_nama),true);
		if(!empty($this->terimapersediaan_id)){
			$criteria->addCondition('t.terimapersediaan_id = '.$this->terimapersediaan_id);
		}
		if(!empty($this->pembelianbarang_id)){
			$criteria->addCondition('t.pembelianbarang_id = '.$this->pembelianbarang_id);
		}
		// if ($this->filter == 'supplier'){
                    if(!empty($this->supplier_id)){
//                            $criteria->addInCondition('supplier_id',$this->supplier_id);
                            $criteria->addCondition('t.supplier_id = '.$this->supplier_id);
                    }//else{
                   //     $criteria->addCondition('supplier_id IS NULL');
                  //  }                    
               // }
		$criteria->compare('LOWER(t.supplier_kode)',strtolower($this->supplier_kode),true);
		$criteria->compare('LOWER(t.supplier_nama)',strtolower($this->supplier_nama),true);
		$criteria->compare('LOWER(t.supplier_alamat)',strtolower($this->supplier_alamat),true);
		$criteria->compare('LOWER(t.supplier_propinsi)',strtolower($this->supplier_propinsi),true);
		$criteria->compare('LOWER(t.supplier_kabupaten)',strtolower($this->supplier_kabupaten),true);
		$criteria->compare('LOWER(t.supplier_telp)',strtolower($this->supplier_telp),true);
		$criteria->compare('LOWER(t.supplier_fax)',strtolower($this->supplier_fax),true);
		$criteria->compare('LOWER(t.supplier_kodepos)',strtolower($this->supplier_kodepos),true);
		$criteria->compare('LOWER(t.supplier_npwp)',strtolower($this->supplier_npwp),true);
		$criteria->compare('LOWER(t.supplier_norekening)',strtolower($this->supplier_norekening),true);
		$criteria->compare('LOWER(t.supplier_namabank)',strtolower($this->supplier_namabank),true);
		$criteria->compare('LOWER(t.supplier_rekatasnama)',strtolower($this->supplier_rekatasnama),true);
		$criteria->compare('LOWER(t.supplier_matauang)',strtolower($this->supplier_matauang),true);
		$criteria->compare('LOWER(t.supplier_website)',strtolower($this->supplier_website),true);
		$criteria->compare('LOWER(t.supplier_email)',strtolower($this->supplier_email),true);
		$criteria->compare('LOWER(t.supplier_cp)',strtolower($this->supplier_cp),true);
		$criteria->compare('LOWER(t.supplier_cp_hp)',strtolower($this->supplier_cp_hp),true);
		$criteria->compare('LOWER(t.supplier_cp_email)',strtolower($this->supplier_cp_email),true);
		$criteria->compare('LOWER(t.supplier_cp2)',strtolower($this->supplier_cp2),true);
		$criteria->compare('LOWER(t.supplier_cp2_hp)',strtolower($this->supplier_cp2_hp),true);
		$criteria->compare('LOWER(t.supplier_cp2_email)',strtolower($this->supplier_cp2_email),true);
		$criteria->compare('LOWER(t.supplier_jenis)',strtolower($this->supplier_jenis),true);
		if(!empty($this->supplier_termin)){
			$criteria->addCondition('t.supplier_termin = '.$this->supplier_termin);
		}
		$criteria->compare('LOWER(t.longitude)',strtolower($this->longitude),true);
		$criteria->compare('LOWER(t.latitude)',strtolower($this->latitude),true);
		if(!empty($this->asalbarang_id)){
			$criteria->addCondition('t.asalbarang_id = '.$this->asalbarang_id);
		}
		$criteria->compare('LOWER(t.asalbarang_nama)',strtolower($this->asalbarang_nama),true);
		if(!empty($this->rekeningsupplier_id)){
			$criteria->addCondition('t.rekeningsupplier_id = '.$this->rekeningsupplier_id);
		}
		if(!empty($this->bank_id)){
			$criteria->addCondition('t.bank_id = '.$this->bank_id);
		}
		$criteria->compare('LOWER(t.namabank)',strtolower($this->namabank),true);
		$criteria->compare('LOWER(t.alamatbank)',strtolower($this->alamatbank),true);
		$criteria->compare('LOWER(t.no_rekening)',strtolower($this->no_rekening),true);
		//$criteria->compare('LOWER(tglpembelian)',strtolower($this->tglpembelian),true);
		$criteria->compare('LOWER(t.nopembelian)',strtolower($this->nopembelian),true);
		//$criteria->compare('LOWER(tgldikirim)',strtolower($this->tgldikirim),true);
		if(!empty($this->pegawaipenerima_id)){
			$criteria->addCondition('t.pegawaipenerima_id = '.$this->pegawaipenerima_id);
		}
		$criteria->compare('LOWER(t.pegawaipenerima_nip)',strtolower($this->pegawaipenerima_nip),true);
		$criteria->compare('LOWER(t.pegawaipenerima_jenisidentitas)',strtolower($this->pegawaipenerima_jenisidentitas),true);
		$criteria->compare('LOWER(t.pegawaipenerima_noidentitas)',strtolower($this->pegawaipenerima_noidentitas),true);
		$criteria->compare('LOWER(t.pegawaipenerima_gelardepan)',strtolower($this->pegawaipenerima_gelardepan),true);
		$criteria->compare('LOWER(t.pegawaipenerima_nama)',strtolower($this->pegawaipenerima_nama),true);
		$criteria->compare('LOWER(t.pegawaipenerima_gelarbelakang)',strtolower($this->pegawaipenerima_gelarbelakang),true);
		if(!empty($this->pegawaimengetahui_id)){
			$criteria->addCondition('t.pegawaimengetahui_id = '.$this->pegawaimengetahui_id);
		}
		$criteria->compare('LOWER(t.pegawaimengetahui_nip)',strtolower($this->pegawaimengetahui_nip),true);
		$criteria->compare('LOWER(t.pegawaimengetahui_jenisidentitas)',strtolower($this->pegawaimengetahui_jenisidentitas),true);
		$criteria->compare('LOWER(t.pegawaimengetahui_noidentitas)',strtolower($this->pegawaimengetahui_noidentitas),true);
		$criteria->compare('LOWER(t.pegawaimengetahui_gelardepan)',strtolower($this->pegawaimengetahui_gelardepan),true);
		$criteria->compare('LOWER(t.pegawaimengetahui_nama)',strtolower($this->pegawaimengetahui_nama),true);
		$criteria->compare('LOWER(t.pegawaimengetahui_gelarbelakang)',strtolower($this->pegawaimengetahui_gelarbelakang),true);
		$criteria->compare('LOWER(t.nopenerimaan)',strtolower($this->nopenerimaan),true);
		//$criteria->compare('LOWER(tglsuratjalan)',strtolower($this->tglsuratjalan),true);
		$criteria->compare('LOWER(t.nosuratjalan)',strtolower($this->nosuratjalan),true);
		//$criteria->compare('LOWER(tgljatuhtempo)',strtolower($this->tgljatuhtempo),true);
		//$criteria->compare('LOWER(tglfaktur)',strtolower($this->tglfaktur),true);
		$criteria->compare('LOWER(t.nofaktur)',strtolower($this->nofaktur),true);
		$criteria->compare('LOWER(t.keterangan_persediaan)',strtolower($this->keterangan_persediaan),true);
		$criteria->compare('t.totalharga',$this->totalharga);
		$criteria->compare('t.discount',$this->discount);
		$criteria->compare('t.biayaadministrasi',$this->biayaadministrasi);
		$criteria->compare('t.pajakpph',$this->pajakpph);
		$criteria->compare('t.pajakppn',$this->pajakppn);
		$criteria->compare('LOWER(t.nofakturpajak)',strtolower($this->nofakturpajak),true);
		$criteria->addBetweenCondition('DATE(t.tglfaktur)', $this->tgl_awal, $this->tgl_akhir);
		if(isset($_GET['berdasarkanJatuhTempo'])){
                if($_GET['berdasarkanJatuhTempo']>0){
				$criteria->addBetweenCondition('DATE(t.tgljatuhtempo)', $this->tgl_awalJatuhTempo, $this->tgl_akhirJatuhTempo);
			}
		}
                
                if(!empty($this->syaratbayar_id)){
                    $criteria->addCondition('t.syaratbayar_id = '.$this->syaratbayar_id);
                }
                    
		return $criteria;
	}
        
        
	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=$this->criteriaSearch();
		$criteria->select = "t.nopembelian, t.nofaktur, t.supplier_nama, t.terimapersediaan_id, t.nopenerimaan, t.pegawaimenyetujuikeuangan_id, t.tgl_menyetujuikeuangan, t.tglfaktur, t.tglterima, t.nopembelian, t.tgljatuhtempo, t.keteranganfaktur, t.syaratbayar_nama, t.totalharga, t.discount, tp.pajakppn, tp.pajakpph, tp.totalkeseluruhan, t.jlmuangmukabeli, t.totalhutangusaha";
		$criteria->group = "t.nopembelian, t.nofaktur, t.supplier_nama, t.nopenerimaan, t.terimapersediaan_id, t.pegawaimenyetujuikeuangan_id, t.tgl_menyetujuikeuangan, t.tglfaktur, t.tglterima, t.nopembelian, t.tgljatuhtempo, t.keteranganfaktur, t.syaratbayar_nama, t.totalharga, t.discount, tp.pajakppn, tp.pajakpph, tp.totalkeseluruhan, t.jlmuangmukabeli, t.totalhutangusaha";
                $criteria->addCondition("t.nofaktur <> ''");
                $criteria->order = "t.tglterima ASC";
		$criteria->limit=10;
		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
		));
	}

        public function searchPrint()
	{
            $criteria=$this->criteriaSearch();
		$criteria->select = "t.nopembelian, t.nofaktur, t.supplier_nama, t.terimapersediaan_id, t.nopenerimaan, t.pegawaimenyetujuikeuangan_id, t.tgl_menyetujuikeuangan, t.tglfaktur, t.tglterima, t.nopembelian, t.tgljatuhtempo, t.keteranganfaktur, t.syaratbayar_nama, t.totalharga, t.discount, tp.pajakppn, tp.pajakpph, tp.totalkeseluruhan, t.jlmuangmukabeli, t.totalhutangusaha";
		$criteria->group = "t.nopembelian, t.nofaktur, t.supplier_nama, t.nopenerimaan, t.terimapersediaan_id, t.pegawaimenyetujuikeuangan_id, t.tgl_menyetujuikeuangan, t.tglfaktur, t.tglterima, t.nopembelian, t.tgljatuhtempo, t.keteranganfaktur, t.syaratbayar_nama, t.totalharga, t.discount, tp.pajakppn, tp.pajakpph, tp.totalkeseluruhan, t.jlmuangmukabeli, t.totalhutangusaha";
		$criteria->addCondition("t.nofaktur <> ''");
                $criteria->order = "t.tglterima ASC";
                $criteria->limit = -1 ;

		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
//				'pagination'=>false,
		));
        }

	public function searchPrintOld()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;		
		$criteria->join = " JOIN terimapersediaan_t tp ON tp.terimapersediaan_id = t.terimapersediaan_id ";

		if(!empty($this->instalasi_id)){
			$criteria->addCondition('t.instalasi_id = '.$this->instalasi_id);
		}
		$criteria->compare('LOWER(t.instalasi_nama)',strtolower($this->instalasi_nama),true);
		if(!empty($this->ruangan_id)){
			$criteria->addCondition('t.ruangan_id = '.$this->ruangan_id);
		}
		$criteria->compare('LOWER(t.ruangan_nama)',strtolower($this->ruangan_nama),true);
		if(!empty($this->terimapersediaan_id)){
			$criteria->addCondition('t.terimapersediaan_id = '.$this->terimapersediaan_id);
		}
		if(!empty($this->pembelianbarang_id)){
			$criteria->addCondition('t.pembelianbarang_id = '.$this->pembelianbarang_id);
		}
		// if ($this->filter == 'supplier'){
                    if(!empty($this->supplier_id)){
//                            $criteria->addInCondition('supplier_id',$this->supplier_id);
                            $criteria->addCondition('t.supplier_id = '.$this->supplier_id);
                    }//else{
                   //     $criteria->addCondition('supplier_id IS NULL');
                  //  }                    
               // }
		$criteria->compare('LOWER(t.supplier_kode)',strtolower($this->supplier_kode),true);
		$criteria->compare('LOWER(t.supplier_nama)',strtolower($this->supplier_nama),true);
		$criteria->compare('LOWER(t.supplier_alamat)',strtolower($this->supplier_alamat),true);
		$criteria->compare('LOWER(t.supplier_propinsi)',strtolower($this->supplier_propinsi),true);
		$criteria->compare('LOWER(t.supplier_kabupaten)',strtolower($this->supplier_kabupaten),true);
		$criteria->compare('LOWER(t.supplier_telp)',strtolower($this->supplier_telp),true);
		$criteria->compare('LOWER(t.supplier_fax)',strtolower($this->supplier_fax),true);
		$criteria->compare('LOWER(t.supplier_kodepos)',strtolower($this->supplier_kodepos),true);
		$criteria->compare('LOWER(t.supplier_npwp)',strtolower($this->supplier_npwp),true);
		$criteria->compare('LOWER(t.supplier_norekening)',strtolower($this->supplier_norekening),true);
		$criteria->compare('LOWER(t.supplier_namabank)',strtolower($this->supplier_namabank),true);
		$criteria->compare('LOWER(t.supplier_rekatasnama)',strtolower($this->supplier_rekatasnama),true);
		$criteria->compare('LOWER(t.supplier_matauang)',strtolower($this->supplier_matauang),true);
		$criteria->compare('LOWER(t.supplier_website)',strtolower($this->supplier_website),true);
		$criteria->compare('LOWER(t.supplier_email)',strtolower($this->supplier_email),true);
		$criteria->compare('LOWER(t.supplier_cp)',strtolower($this->supplier_cp),true);
		$criteria->compare('LOWER(t.supplier_cp_hp)',strtolower($this->supplier_cp_hp),true);
		$criteria->compare('LOWER(t.supplier_cp_email)',strtolower($this->supplier_cp_email),true);
		$criteria->compare('LOWER(t.supplier_cp2)',strtolower($this->supplier_cp2),true);
		$criteria->compare('LOWER(t.supplier_cp2_hp)',strtolower($this->supplier_cp2_hp),true);
		$criteria->compare('LOWER(t.supplier_cp2_email)',strtolower($this->supplier_cp2_email),true);
		$criteria->compare('LOWER(t.supplier_jenis)',strtolower($this->supplier_jenis),true);
		if(!empty($this->supplier_termin)){
			$criteria->addCondition('t.supplier_termin = '.$this->supplier_termin);
		}
		$criteria->compare('LOWER(t.longitude)',strtolower($this->longitude),true);
		$criteria->compare('LOWER(t.latitude)',strtolower($this->latitude),true);
		if(!empty($this->asalbarang_id)){
			$criteria->addCondition('t.asalbarang_id = '.$this->asalbarang_id);
		}
		$criteria->compare('LOWER(t.asalbarang_nama)',strtolower($this->asalbarang_nama),true);
		if(!empty($this->rekeningsupplier_id)){
			$criteria->addCondition('t.rekeningsupplier_id = '.$this->rekeningsupplier_id);
		}
		if(!empty($this->bank_id)){
			$criteria->addCondition('t.bank_id = '.$this->bank_id);
		}
		$criteria->compare('LOWER(t.namabank)',strtolower($this->namabank),true);
		$criteria->compare('LOWER(t.alamatbank)',strtolower($this->alamatbank),true);
		$criteria->compare('LOWER(t.no_rekening)',strtolower($this->no_rekening),true);
		//$criteria->compare('LOWER(tglpembelian)',strtolower($this->tglpembelian),true);
		$criteria->compare('LOWER(t.nopembelian)',strtolower($this->nopembelian),true);
		//$criteria->compare('LOWER(tgldikirim)',strtolower($this->tgldikirim),true);
		if(!empty($this->pegawaipenerima_id)){
			$criteria->addCondition('t.pegawaipenerima_id = '.$this->pegawaipenerima_id);
		}
		$criteria->compare('LOWER(t.pegawaipenerima_nip)',strtolower($this->pegawaipenerima_nip),true);
		$criteria->compare('LOWER(t.pegawaipenerima_jenisidentitas)',strtolower($this->pegawaipenerima_jenisidentitas),true);
		$criteria->compare('LOWER(t.pegawaipenerima_noidentitas)',strtolower($this->pegawaipenerima_noidentitas),true);
		$criteria->compare('LOWER(t.pegawaipenerima_gelardepan)',strtolower($this->pegawaipenerima_gelardepan),true);
		$criteria->compare('LOWER(t.pegawaipenerima_nama)',strtolower($this->pegawaipenerima_nama),true);
		$criteria->compare('LOWER(t.pegawaipenerima_gelarbelakang)',strtolower($this->pegawaipenerima_gelarbelakang),true);
		if(!empty($this->pegawaimengetahui_id)){
			$criteria->addCondition('t.pegawaimengetahui_id = '.$this->pegawaimengetahui_id);
		}
		$criteria->compare('LOWER(t.pegawaimengetahui_nip)',strtolower($this->pegawaimengetahui_nip),true);
		$criteria->compare('LOWER(t.pegawaimengetahui_jenisidentitas)',strtolower($this->pegawaimengetahui_jenisidentitas),true);
		$criteria->compare('LOWER(t.pegawaimengetahui_noidentitas)',strtolower($this->pegawaimengetahui_noidentitas),true);
		$criteria->compare('LOWER(t.pegawaimengetahui_gelardepan)',strtolower($this->pegawaimengetahui_gelardepan),true);
		$criteria->compare('LOWER(t.pegawaimengetahui_nama)',strtolower($this->pegawaimengetahui_nama),true);
		$criteria->compare('LOWER(t.pegawaimengetahui_gelarbelakang)',strtolower($this->pegawaimengetahui_gelarbelakang),true);
		$criteria->compare('LOWER(t.nopenerimaan)',strtolower($this->nopenerimaan),true);
		//$criteria->compare('LOWER(tglsuratjalan)',strtolower($this->tglsuratjalan),true);
		$criteria->compare('LOWER(t.nosuratjalan)',strtolower($this->nosuratjalan),true);
		//$criteria->compare('LOWER(tgljatuhtempo)',strtolower($this->tgljatuhtempo),true);
		//$criteria->compare('LOWER(tglfaktur)',strtolower($this->tglfaktur),true);
		$criteria->compare('LOWER(t.nofaktur)',strtolower($this->nofaktur),true);
		$criteria->compare('LOWER(t.keterangan_persediaan)',strtolower($this->keterangan_persediaan),true);
		$criteria->compare('t.totalharga',$this->totalharga);
		$criteria->compare('t.discount',$this->discount);
		$criteria->compare('t.biayaadministrasi',$this->biayaadministrasi);
		$criteria->compare('t.pajakpph',$this->pajakpph);
		$criteria->compare('t.pajakppn',$this->pajakppn);
		$criteria->compare('LOWER(t.nofakturpajak)',strtolower($this->nofakturpajak),true);
		$criteria->addBetweenCondition('DATE(t.tglterima)', $this->tgl_awal, $this->tgl_akhir);
		if(isset($_GET['berdasarkanJatuhTempo'])){
                if($_GET['berdasarkanJatuhTempo']>0){
				$criteria->addBetweenCondition('DATE(t.tgljatuhtempo)', $this->tgl_awalJatuhTempo, $this->tgl_akhirJatuhTempo);
			}
		}
		$criteria->limit = -1 ;

		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
//				'pagination'=>false,
		));
	}
		
	public function getUmurHutang($tgljatuhtempo, $tglfaktur){
            $tglfaktur = date('Y-m-d', strtotime($tglfaktur));
//			$tglfaktur = $this->tglfaktur;	
//			$tgljatuhtempo = $this->tgljatuhtempo;
            $tgljatuhtempo = (!empty($tgljatuhtempo)?date('Y-m-d', strtotime($tgljatuhtempo)):date('Y-m-d H:i:s'));
			$dob=$tglfaktur; 
			$jatuhtempo=$tgljatuhtempo;
			list($y,$m,$d)=explode('-',$dob);
			list($ty,$tm,$td)=explode('-',$jatuhtempo);
			if($td-$d<0){
				$day=($td+30)-$d;
				$tm--;
			}
			else{
				$day=$td-$d;
			}
			if($tm-$m<0){
				$month=($tm+12)-$m;
				$ty--;
			}
			else{
				$month=$tm-$m;
			}
			$year=$ty-$y;

			$umurHutang = str_pad($year, 2, '0', STR_PAD_LEFT).' Thn '. str_pad($month, 2, '0', STR_PAD_LEFT) .' Bln '. str_pad($day, 2, '0', STR_PAD_LEFT).' Hr';
			
			return $umurHutang;
		}
		
		        
	public function getNamaLengkapPenerima($pegawaipenerima_id)
	{
		$penerima = self::model()->findByAttributes(array('pegawaipenerima_id'=>$pegawaipenerima_id));
		if(!empty($penerima->pegawaipenerima_nama)){
			return (isset($penerima->pegawaipenerima_gelardepan) ? $penerima->pegawaipenerima_gelardepan." " : "").$penerima->pegawaipenerima_nama.", ".(isset($penerima->pegawaipenerima_gelarbelakang) ? $penerima->pegawaipenerima_gelarbelakang : "");
		}else{
			return "-";
		}
	} 
	
	public function getAlamatLengkap($supplier_id)
	{
		$supplier = self::model()->findByAttributes(array('supplier_id'=>$supplier_id));
		if(!empty($supplier->supplier_alamat)){
			return (isset($supplier->supplier_alamat) ? $supplier->supplier_alamat." " : "").(isset($supplier->kabupaten) ? $supplier->kabupaten : "").(isset($supplier->propinsi) ? $supplier->propinsi : "");
		}else{
			return "-";
		}
	}
	
	public function searchLaporan()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
		$criteria=new CDbCriteria;
		$criteria->select = " t.*, (totalharga-discount+pajakppn+pajakpph) as totalhargabruto ";
		$criteria->compare('pembelianbarang_id',$this->pembelianbarang_id);
		$criteria->compare('LOWER(tglpembelian)',strtolower($this->tglpembelian),true);
		$criteria->compare('LOWER(nopembelian)',strtolower($this->nopembelian),true);
		$criteria->compare('LOWER(tgldikirim)',strtolower($this->tgldikirim),true);
//		$criteria->compare('sumberdana_id',$this->sumberdana_id);
//		$criteria->compare('LOWER(sumberdana_nama)',strtolower($this->sumberdana_nama),true);
		$criteria->compare('terimapersediaan_id',$this->terimapersediaan_id);
		 $criteria->compare('LOWER(tglterima)',strtolower($this->tglterima),true);
		$criteria->addBetweenCondition('date(tglfaktur)', $this->tgl_awal, $this->tgl_akhir);
		$criteria->compare('LOWER(nopenerimaan)',strtolower($this->nopenerimaan),true);
		$criteria->compare('LOWER(keterangan_persediaan)',strtolower($this->keterangan_persediaan),true);
//		$criteria->compare('fakturpembelian_id',$this->fakturpembelian_id);
//		$criteria->compare('LOWER(tglfaktur)',strtolower($this->tglfaktur),true);
		$criteria->compare('LOWER(nofaktur)',strtolower($this->nofaktur),true);
		$criteria->compare('LOWER(tgljatuhtempo)',strtolower($this->tgljatuhtempo),true);
//		$criteria->compare('LOWER(keteranganfaktur)',strtolower($this->keteranganfaktur),true);
//		$criteria->compare('totharganetto',$this->totharganetto);
//		$criteria->compare('persendiscount',$this->persendiscount);
//		$criteria->compare('jmldiscount',$this->jmldiscount);
//		$criteria->compare('biayamaterai',$this->biayamaterai);
//		$criteria->compare('totalpajakpph',$this->totalpajakpph);
//		$criteria->compare('totalpajakppn',$this->totalpajakppn);
//		$criteria->compare('totalhargabruto',$this->totalhargabruto);
		$criteria->compare('LOWER(nofakturpajak)',strtolower($this->nofakturpajak),true);
		$criteria->compare('instalasi_id',$this->instalasi_id);
		$criteria->compare('LOWER(instalasi_nama)',strtolower($this->instalasi_nama),true);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
//		$criteria->compare('syaratbayar_id',$this->syaratbayar_id);
//		$criteria->compare('LOWER(syaratbayar_nama)',strtolower($this->syaratbayar_nama),true);
//		$criteria->compare('terimapersdetail_id',$this->terimapersdetail_id);
//		$criteria->compare('barang_id',$this->barang_id);
//		$criteria->compare('LOWER(barang_kode)',strtolower($this->barang_kode),true);
//		$criteria->compare('LOWER(barang_nama)',strtolower($this->barang_nama),true);
//		$criteria->compare('LOWER(barang_type)',strtolower($this->barang_type),true);
//		$criteria->compare('LOWER(barang_merk)',strtolower($this->barang_merk),true);
//		$criteria->compare('hargabeli',$this->hargabeli);
//		$criteria->compare('hargasatuan',$this->hargasatuan);
//		$criteria->compare('jmlterima',$this->jmlterima);
//		$criteria->compare('LOWER(satuanbeli)',strtolower($this->satuanbeli),true);
//		$criteria->compare('LOWER(kondisibarang)',strtolower($this->kondisibarang),true);
		//if ($this->filter == 'supplier'){
                    if(!empty($this->supplier_id)){
                            $criteria->addInCondition('supplier_id',$this->supplier_id);
                    }else{
            //            $criteria->addCondition('supplier_id IS NULL');
                    }                    
          //      }
		$criteria->compare('LOWER(supplier_kode)',strtolower($this->supplier_kode),true);
		$criteria->compare('LOWER(supplier_nama)',strtolower($this->supplier_nama),true);
		$criteria->compare('bayarkesupplier_id',$this->bayarkesupplier_id);
//		$criteria->compare('jurnalrekening_id',$this->jurnalrekening_id);
		if(isset($_GET['berdasarkanJatuhTempo'])){
            if($_GET['berdasarkanJatuhTempo']>0){
				$criteria->addBetweenCondition('tgljatuhtempo', $this->tglAwalJatuhTempo, $this->tglAkhirJatuhTempo);
			}
		}
		
		if (!empty($this->statusBayar)){
			if ($this->statusBayar == 1){
				$criteria->addCondition(" bayarkesupplier_id IS NOT NULL ");
			}elseif ($this->statusBayar == 2){
				$criteria->addCondition(" bayarkesupplier_id IS NULL ");
			}
		}

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public function searchLaporanPrint()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
		$criteria=new CDbCriteria;
		$criteria->select = " t.*, (totalharga-discount+pajakppn+pajakpph) as totalhargabruto ";
		$criteria->compare('pembelianbarang_id',$this->pembelianbarang_id);
		$criteria->compare('LOWER(tglpembelian)',strtolower($this->tglpembelian),true);
		$criteria->compare('LOWER(nopembelian)',strtolower($this->nopembelian),true);
		$criteria->compare('LOWER(tgldikirim)',strtolower($this->tgldikirim),true);
//		$criteria->compare('sumberdana_id',$this->sumberdana_id);
//		$criteria->compare('LOWER(sumberdana_nama)',strtolower($this->sumberdana_nama),true);
		$criteria->compare('terimapersediaan_id',$this->terimapersediaan_id);
		 $criteria->compare('LOWER(tglterima)',strtolower($this->tglterima),true);
		$criteria->addBetweenCondition('date(tglfaktur)', $this->tgl_awal, $this->tgl_akhir);
		$criteria->compare('LOWER(nopenerimaan)',strtolower($this->nopenerimaan),true);
		$criteria->compare('LOWER(keterangan_persediaan)',strtolower($this->keterangan_persediaan),true);
//		$criteria->compare('fakturpembelian_id',$this->fakturpembelian_id);
//		$criteria->compare('LOWER(tglfaktur)',strtolower($this->tglfaktur),true);
		$criteria->compare('LOWER(nofaktur)',strtolower($this->nofaktur),true);
		$criteria->compare('LOWER(tgljatuhtempo)',strtolower($this->tgljatuhtempo),true);
//		$criteria->compare('LOWER(keteranganfaktur)',strtolower($this->keteranganfaktur),true);
//		$criteria->compare('totharganetto',$this->totharganetto);
//		$criteria->compare('persendiscount',$this->persendiscount);
//		$criteria->compare('jmldiscount',$this->jmldiscount);
//		$criteria->compare('biayamaterai',$this->biayamaterai);
//		$criteria->compare('totalpajakpph',$this->totalpajakpph);
//		$criteria->compare('totalpajakppn',$this->totalpajakppn);
//		$criteria->compare('totalhargabruto',$this->totalhargabruto);
		$criteria->compare('LOWER(nofakturpajak)',strtolower($this->nofakturpajak),true);
		$criteria->compare('instalasi_id',$this->instalasi_id);
		$criteria->compare('LOWER(instalasi_nama)',strtolower($this->instalasi_nama),true);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
//		$criteria->compare('syaratbayar_id',$this->syaratbayar_id);
//		$criteria->compare('LOWER(syaratbayar_nama)',strtolower($this->syaratbayar_nama),true);
//		$criteria->compare('terimapersdetail_id',$this->terimapersdetail_id);
//		$criteria->compare('barang_id',$this->barang_id);
//		$criteria->compare('LOWER(barang_kode)',strtolower($this->barang_kode),true);
//		$criteria->compare('LOWER(barang_nama)',strtolower($this->barang_nama),true);
//		$criteria->compare('LOWER(barang_type)',strtolower($this->barang_type),true);
//		$criteria->compare('LOWER(barang_merk)',strtolower($this->barang_merk),true);
//		$criteria->compare('hargabeli',$this->hargabeli);
//		$criteria->compare('hargasatuan',$this->hargasatuan);
//		$criteria->compare('jmlterima',$this->jmlterima);
//		$criteria->compare('LOWER(satuanbeli)',strtolower($this->satuanbeli),true);
//		$criteria->compare('LOWER(kondisibarang)',strtolower($this->kondisibarang),true);
		//if ($this->filter == 'supplier'){
                    if(!empty($this->supplier_id)){
                            $criteria->addInCondition('supplier_id',$this->supplier_id);
                    }else{
            //            $criteria->addCondition('supplier_id IS NULL');
                    }                    
          //      }
		$criteria->compare('LOWER(supplier_kode)',strtolower($this->supplier_kode),true);
		$criteria->compare('LOWER(supplier_nama)',strtolower($this->supplier_nama),true);
		$criteria->compare('bayarkesupplier_id',$this->bayarkesupplier_id);
//		$criteria->compare('jurnalrekening_id',$this->jurnalrekening_id);
		if(isset($_GET['berdasarkanJatuhTempo'])){
            if($_GET['berdasarkanJatuhTempo']>0){
				$criteria->addBetweenCondition('tgljatuhtempo', $this->tglAwalJatuhTempo, $this->tglAkhirJatuhTempo);
			}
		}
		
		if (!empty($this->statusBayar)){
			if ($this->statusBayar == 1){
				$criteria->addCondition(" bayarkesupplier_id IS NOT NULL ");
			}elseif ($this->statusBayar == 2){
				$criteria->addCondition(" bayarkesupplier_id IS NULL ");
			}
		}
		$criteria->limit = -1;

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
				'pagination'=>false,
		));
	}
        
        public function searchGrafik() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.
        $criteria = new CDbCriteria;
        $criteria->join = " JOIN supplier_m s ON t.supplier_id = s.supplier_id ";
        $criteria->select = 'sum((totalharga-discount+pajakppn+pajakpph)) as jumlah';
        $filter = isset($this->filter)?$this->filter:null;
        if ( $filter == 'supplier') {           
            //$criteria->select .= ', s.supplier_nama as data';
            //$criteria->group .= 's.supplier_nama';            
        }else{
            //$criteria->select .= ', s.supplier_nama as data';
            //$/criteria->group .= 's.supplier_nama';   
        }      
                       
		$criteria->select .= ", (CASE WHEN bayarkesupplier_id is null THEN 'BELUM LUNAS' ELSE 'LUNAS' END) as data";
        $criteria->group .= 'data';   

        if(!empty($this->fakturpembelian_id)){
                $criteria->addCondition('t.fakturpembelian_id = '.$this->fakturpembelian_id);
        }
       //if ($this->filter == 'supplier'){
                    if(!empty($this->supplier_id)){
                            $criteria->addInCondition('t.supplier_id',$this->supplier_id);
                    }else{
           //             $criteria->addCondition('t.supplier_id IS NULL');
                    }                    
         //       }
        if(!empty($this->syaratbayar_id)){
                $criteria->addCondition('t.syaratbayar_id = '.$this->syaratbayar_id);
        }
        if(!empty($this->ruangan_id)){
                $criteria->addCondition('t.ruangan_id = '.$this->ruangan_id);
        }
        $criteria->compare('LOWER(t.nofaktur)',strtolower($this->nofaktur),true);
        $criteria->addBetweenCondition('t.tglfaktur', $this->tgl_awal, $this->tgl_akhir);
        $criteria->order = "jumlah DESC";
        if (!empty($this->statusBayar)){
			if ($this->statusBayar == 1){
				$criteria->addCondition(" bayarkesupplier_id IS NOT NULL ");
			}elseif ($this->statusBayar == 2){
				$criteria->addCondition(" bayarkesupplier_id IS NULL ");
			}
		}

        return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
    }
    
    public function getTotalharga()
    {
        $criteria=new CDbCriteria;
        $criteria->addBetweenCondition('t.tglfaktur', $this->tgl_awal, $this->tgl_akhir);
        if ($this->filter == 'supplier'){
            if(!empty($this->supplier_id)){
                    $criteria->addInCondition('supplier_id',$this->supplier_id);
            }else{
                $criteria->addCondition('supplier_id IS NULL');
            }                    
        }
        $criteria->compare('LOWER(supplier_kode)',strtolower($this->supplier_kode),true);
        $criteria->compare('LOWER(supplier_nama)',strtolower($this->supplier_nama),true);
        $criteria->compare('bayarkesupplier_id',$this->bayarkesupplier_id);
//		$criteria->compare('jurnalrekening_id',$this->jurnalrekening_id);
        if(isset($_GET['berdasarkanJatuhTempo'])){
            if($_GET['berdasarkanJatuhTempo']>0){
                                $criteria->addBetweenCondition('tgljatuhtempo', $this->tglAwalJatuhTempo, $this->tglAkhirJatuhTempo);
                        }
                }
        $criteria->select = 'SUM(totalharga)';
        return $this->commandBuilder->createFindCommand($this->getTableSchema(),$criteria)->queryScalar();
    }
	
	public function searchDialog(){
		
		$criteria=new CDbCriteria();
		$criteria->addCondition(" bayarkesupplier_id IS NULL ");
		$criteria->compare("LOWER(nopenerimaan)", strtolower($this->nopenerimaan),true);
		if (!empty($this->supplier_id)){
			$criteria->addCondition("supplier_id = ".$this->supplier_id." ");
		}
		$criteria->limit=10;

		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
		));
	}
        
        
        public function checkStatusPembayaran($valueID){
            $cekStatus = false;
            
            $model = BayarkesupplierT::model()->findAllByAttributes(array('terimapersediaan_id'=>$valueID));
            $modTerima = TerimapersediaanT::model()->findByPk($valueID);
            
            if(count((array)$model) > 0){
                $jmlbayar = 0;
                
                foreach ($model as $det){
                    $jmlbayar += $det->jmldibayarkan;
                }
                
                if($modTerima->totalkeseluruhan == $jmlbayar){
                    $cekStatus = true;
                }else{
                    $cekStatus = false;
                }
            }
            
            return $cekStatus;
        }
       
	
}