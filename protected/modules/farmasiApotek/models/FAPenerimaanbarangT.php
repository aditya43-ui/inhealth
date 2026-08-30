<?php
class FAPenerimaanbarangT extends PenerimaanbarangT
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PenerimaanbarangT the static model class
	 */
        public $tgl_awal,$tgl_akhir;
        public $tick;
        public $data;
        public $jumlah;
        public $supplier_nama;
        public $nama_obat;
        public $obatalkes_kode;
        public $satuanbesar_nama;
        public $harganettoper;
        public $jumlahterima;
        public $persendiscount;
        public $nofaktur;
        public $tglfaktur;
        public $totalbruto;
        public $persenppn;
        public $hargadiskon;
        public $hargappn;
        public $hargabruto;
        public $sumberdana_nama, $jenisobatalkes_id, $sumberdana_id;
        public $jmlterima; public $disc; public $ppn; public $total_harga;
        public $jns_periode,$bln_awal,$bln_akhir,$thn_awal,$thn_akhir;
        
        public $pegawaimengetahui_nama;
        public $pegawaimenyetujui_nama;
        public $is_uangmuka=0;
        public $is_langsungfaktur=0;
        
        public $tglkadaluarsa;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public function searchFakturPembelian()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('LOWER(noterima)',strtolower($this->noterima),true);
		$criteria->compare('date(tglterima)',$this->tglterima);
                $criteria->addCondition('fakturpembelian_id is null');

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
	public function searchInformasi()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->with = 'supplier';
		$criteria->compare('LOWER(noterima)',strtolower($this->noterima),true);
		$criteria->addBetweenCondition('date(tglterima)',$this->tgl_awal,$this->tgl_akhir);
		if(!empty($this->supplier_id)){
			$criteria->addCondition('supplier_id = '.$this->supplier_id);
		}
		$criteria->addCondition("supplier.supplier_jenis='Farmasi'");

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
	public function searchLaporan()
	{
		$criteria=new CDbCriteria;
                
		$criteria->join = 'JOIN supplier_m s ON s.supplier_id=t.supplier_id JOIN penerimaandetail_t pd ON pd.penerimaanbarang_id=t.penerimaanbarang_id LEFT JOIN obatalkes_m o ON pd.obatalkes_id=o.obatalkes_id';
		$criteria->select = 't.noterima, t.tglterima, t.totalharga as totalharga, pd.harganettoper as harganetto, pd.jmlterima as jumlahterima, o.obatalkes_nama as nama_obat, s.supplier_nama as supplier_nama';
//                $criteria->group = 't.noterima, t.tglterima, t.totalharga, t.harganetto, o.obatalkes_nama, s.supplier_nama, pd.harganettoper, pd.jmlterima';
		if(!empty($this->supplier_id)){
			$criteria->addCondition('t.supplier_id = '.$this->supplier_id);
		}
		$criteria->compare('LOWER(t.noterima)',strtolower($this->noterima),true);
		$criteria->addBetweenCondition('date(tglterima)',$this->tgl_awal,$this->tgl_akhir);
		$criteria->addCondition("s.supplier_jenis='Farmasi'");
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public function searchLaporanPrint(){
                
		$criteria=new CDbCriteria;

		$criteria->join = 'JOIN supplier_m s ON s.supplier_id=t.supplier_id JOIN penerimaandetail_t pd ON pd.penerimaanbarang_id=t.penerimaanbarang_id LEFT JOIN obatalkes_m o ON pd.obatalkes_id=o.obatalkes_id';
		$criteria->select = 't.noterima, t.tglterima, t.totalharga as totalharga, pd.harganettoper as harganetto, pd.jmlterima as jumlahterima, o.obatalkes_nama as nama_obat, s.supplier_nama as supplier_nama';
//                $criteria->group = 't.noterima, t.tglterima, t.totalharga, t.harganetto, o.obatalkes_nama, s.supplier_nama, pd.harganettoper, pd.jmlterima';
		if(!empty($this->supplier_id)){
			$criteria->addCondition('t.supplier_id = '.$this->supplier_id);
		}
		$criteria->compare('LOWER(t.noterima)',strtolower($this->noterima),true);
		$criteria->addBetweenCondition('date(tglterima)',$this->tgl_awal,$this->tgl_akhir);
		$criteria->addCondition("s.supplier_jenis='Farmasi'");
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria, 'pagination'=>false,
		)); 
        }
        /**
         * searchLaporanPenerimaanObatAlkes digunakan pada:
         * 1. Laporan Penerimaan Obat Alkes
         * @return \CActiveDataProvider
         */
        public function searchLaporanPenerimaanObatAlkes(){
			$format = new MyFormatter;
			$criteria=new CDbCriteria;
			$this->tgl_awal = $format->formatDateTimeForDb($this->tgl_awal);
			$this->tgl_akhir = $format->formatDateTimeForDb($this->tgl_akhir);
			$criteria->join = 'JOIN supplier_m s ON s.supplier_id=t.supplier_id 
				JOIN penerimaandetail_t pd ON pd.penerimaanbarang_id=t.penerimaanbarang_id 
				LEFT JOIN satuanbesar_m sb ON sb.satuanbesar_id=pd.satuanbesar_id 
				LEFT JOIN fakturpembelian_t fp ON fp.fakturpembelian_id=t.fakturpembelian_id 
				LEFT JOIN obatalkes_m o ON pd.obatalkes_id=o.obatalkes_id';
			$criteria->select = 't.noterima, t.tglterima, t.totalharga as totalharga, 
				fp.nofaktur as nofaktur, fp.tglfaktur as tglfaktur,
				pd.harganettoper as harganettoper, pd.persenppn as persenppn, pd.jmlterima as jumlahterima, ((pd.harganettoper*(pd.persenppn/100))*pd.jmlterima) as hargappn, ((pd.harganettoper*(pd.persendiscount/100))*pd.jmlterima) as hargadiskon, pd.persendiscount as persendiscount,
				o.obatalkes_kode as obatalkes_kode,o.obatalkes_nama as nama_obat, 
				sb.satuanbesar_nama as satuanbesar_nama, 
				s.supplier_nama as supplier_nama';
			if(!empty($this->supplier_id)){
				$criteria->addCondition('t.supplier_id = '.$this->supplier_id);
			}
			$criteria->compare('LOWER(t.noterima)',strtolower($this->noterima),true);
			$criteria->addBetweenCondition('date(tglterima)',$this->tgl_awal,$this->tgl_akhir);
			$criteria->addCondition("s.supplier_jenis='Farmasi'");
			$criteria->order='t.noterima ASC';
			return new CActiveDataProvider($this, array(
				'criteria'=>$criteria, 'pagination'=>false,
			)); 
        }
        
       
       public function searchGrafik(){
                
                $criteria=new CDbCriteria;
                
                $criteria->join = "JOIN supplier_m s on s.supplier_id=t.supplier_id AND s.supplier_jenis='Farmasi'";
                $criteria->select = 's.supplier_nama as data, count(t.noterima) as jumlah, t.supplier_id';
                $criteria->group = 't.noterima, t.supplier_id, s.supplier_nama';
                $criteria->addBetweenCondition('date(tglterima)',$this->tgl_awal,$this->tgl_akhir);
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		)); 
        }
        
        /**
         * searchPenerimaanJenisItems digunakan pada:
         * 1. Laporan Penerimaan Items Berdasarkan Jenis
         * @return \CActiveDataProvider
         */
            public function searchPenerimaanItems(){
                    $format = new MyFormatter;
                    $criteria=new CDbCriteria;
                    $this->tgl_awal  = $format->formatDateTimeForDb($this->tgl_awal);
                    $this->tgl_akhir = $format->formatDateTimeForDb($this->tgl_akhir);
                    $criteria->join = 'JOIN supplier_m s ON s.supplier_id=t.supplier_id 
                        JOIN penerimaandetail_t pd ON pd.penerimaanbarang_id=t.penerimaanbarang_id 
                        LEFT JOIN satuanbesar_m sb ON sb.satuanbesar_id=pd.satuanbesar_id 
                        LEFT JOIN fakturpembelian_t fp ON fp.fakturpembelian_id=t.fakturpembelian_id 
                        LEFT JOIN obatalkes_m o ON pd.obatalkes_id=o.obatalkes_id
                        LEFT JOIN sumberdana_m sd ON pd.sumberdana_id=sd.sumberdana_id';
                    $criteria->select = 't.noterima, t.tglterima, sum(t.totalharga) as totalharga, t.penerimaanbarang_id,
                        fp.nofaktur as nofaktur, fp.tglfaktur as tglfaktur,o.sumberdana_id,
                        sum(pd.harganettoper) as harganettoper, sum(pd.jmlterima) as jumlahterima, 
                        sum((pd.harganettoper *pd.jmlterima)*(o.ppn_persen/100)) as persenppn, sum((pd.harganettoper * pd.jmlterima)*(o.discount/100)) as persendiscount, sd.sumberdana_nama,pd.sumberdana_id,o.jenisobatalkes_id,
                        o.obatalkes_kode as obatalkes_kode,o.obatalkes_nama as nama_obat, 
                        sb.satuanbesar_nama as satuanbesar_nama, 
                        s.supplier_nama as supplier_nama,
                        sum(((pd.harganettoper  * pd.jmlterima) - ((pd.harganettoper * pd.jmlterima) * (o.discount / 100))) + ((pd.harganettoper * pd.jmlterima)*(o.ppn_persen / 100))) as total_harga,
                        sum(pd.harganettoper * pd.jmlterima) as hargabruto
                        ';
                    $criteria->group = 'pd.sumberdana_id, o.jenisobatalkes_id, t.noterima,t.tglterima,fp.nofaktur,fp.tglfaktur,sb.satuanbesar_nama, o.obatalkes_kode,o.obatalkes_nama,
                                        s.supplier_nama,sd.sumberdana_nama,o.sumberdana_id,t.penerimaanbarang_id
                                        ';
                    $jenisobatalkes_id = (isset($_GET['FAPenerimaanbarangT']['jenisobatalkes_id']) ? $_GET['FAPenerimaanbarangT']['jenisobatalkes_id'] : null);
                    $sumberdana_id = (isset($_GET['FAPenerimaanbarangT']['sumberdana_id']) ? $_GET['FAPenerimaanbarangT']['sumberdana_id'] : null);
					if(!empty($this->supplier_id)){
						$criteria->addCondition('t.supplier_id = '.$this->supplier_id);
					}
                    $criteria->compare('LOWER(t.noterima)',strtolower($this->noterima),true);
					if(!empty($jenisobatalkes_id)){
						$criteria->addCondition('o.jenisobatalkes_id = '.$jenisobatalkes_id);
					}
					if(!empty($sumberdana_id)){
						$criteria->addCondition('o.sumberdana_id = '.$sumberdana_id);
					}
                    $criteria->addBetweenCondition('tglterima',$this->tgl_awal,$this->tgl_akhir);
                    $criteria->addCondition("s.supplier_jenis='Farmasi'");
                    return new CActiveDataProvider($this, array(
                            'criteria'=>$criteria,
                    )); 
            }
            public function searchPrintPenerimaanItems(){
                    $format = new MyFormatter;
                    $criteria=new CDbCriteria;
                    $this->tgl_awal  = $format->formatDateTimeForDb($this->tgl_awal);
                    $this->tgl_akhir = $format->formatDateTimeForDb($this->tgl_akhir);
                    $criteria->join = 'JOIN supplier_m s ON s.supplier_id=t.supplier_id 
                        JOIN penerimaandetail_t pd ON pd.penerimaanbarang_id=t.penerimaanbarang_id 
                        LEFT JOIN satuanbesar_m sb ON sb.satuanbesar_id=pd.satuanbesar_id 
                        LEFT JOIN fakturpembelian_t fp ON fp.fakturpembelian_id=t.fakturpembelian_id 
                        LEFT JOIN obatalkes_m o ON pd.obatalkes_id=o.obatalkes_id
                        LEFT JOIN sumberdana_m sd ON pd.sumberdana_id=sd.sumberdana_id';
                    $criteria->select = 't.noterima, t.tglterima, sum(t.totalharga) as totalharga, t.penerimaanbarang_id,
                        fp.nofaktur as nofaktur, fp.tglfaktur as tglfaktur,o.sumberdana_id,
                        sum(pd.harganettoper) as harganettoper, sum(pd.jmlterima) as jumlahterima, 
                        sum((pd.harganettoper *pd.jmlterima)*(o.ppn_persen/100)) as persenppn, sum((pd.harganettoper * pd.jmlterima)*(o.discount/100)) as persendiscount, sd.sumberdana_nama,pd.sumberdana_id,o.jenisobatalkes_id,
                        o.obatalkes_kode as obatalkes_kode,o.obatalkes_nama as nama_obat, 
                        sb.satuanbesar_nama as satuanbesar_nama, 
                        s.supplier_nama as supplier_nama,
                        sum(((pd.harganettoper  * pd.jmlterima) - ((pd.harganettoper * pd.jmlterima) * (o.discount / 100))) + ((pd.harganettoper * pd.jmlterima)*(o.ppn_persen / 100))) as total_harga,
                        sum(pd.harganettoper * pd.jmlterima) as hargabruto
                        ';
                    $criteria->group = 'pd.sumberdana_id, o.jenisobatalkes_id, t.noterima,t.tglterima,fp.nofaktur,fp.tglfaktur,sb.satuanbesar_nama, o.obatalkes_kode,o.obatalkes_nama,
                                        s.supplier_nama,sd.sumberdana_nama,o.sumberdana_id,t.penerimaanbarang_id
                                        ';
                    $jenisobatalkes_id = (isset($_GET['FAPenerimaanbarangT']['jenisobatalkes_id']) ? $_GET['FAPenerimaanbarangT']['jenisobatalkes_id'] : null);
                    $sumberdana_id = (isset($_GET['FAPenerimaanbarangT']['sumberdana_id']) ? $_GET['FAPenerimaanbarangT']['sumberdana_id'] : null);
					if(!empty($this->supplier_id)){
						$criteria->addCondition('t.supplier_id = '.$this->supplier_id);
					}
                    $criteria->compare('LOWER(t.noterima)',strtolower($this->noterima),true);
					if(!empty($jenisobatalkes_id)){
						$criteria->addCondition('o.jenisobatalkes_id = '.$jenisobatalkes_id);
					}
					if(!empty($sumberdana_id)){
						$criteria->addCondition('o.sumberdana_id = '.$sumberdana_id);
					}
                    $criteria->addBetweenCondition('tglterima',$this->tgl_awal,$this->tgl_akhir);
                    $criteria->addCondition("s.supplier_jenis='Farmasi'");
                    return new CActiveDataProvider($this, array(
                            'criteria'=>$criteria,
                            'pagination'=>false,
                    )); 
            }

           public function searchGrafikPenerimaanJenisItems(){

                    $criteria=new CDbCriteria;

                    $criteria->join = "JOIN supplier_m s on s.supplier_id=t.supplier_id AND s.supplier_jenis='Farmasi'";
                    $criteria->select = 's.supplier_nama as data, count(t.noterima) as jumlah, t.supplier_id';
                    $criteria->group = 't.noterima, t.supplier_id, s.supplier_nama';
                    $criteria->addBetweenCondition('date(tglterima)',$this->tgl_awal,$this->tgl_akhir);
                    return new CActiveDataProvider($this, array(
                            'criteria'=>$criteria,
                    )); 
            }
        /**
         * persenppnToPersen konversi dari rupiah Ppn ke persen Ppn
         * @return int
         */
        public function getHargappnToPersen(){
            $persen = 10;
            if(!empty($this->persenppn))
                $persen = 10;
            else
                $persen = 0;
            return $persen;
        }
        /**
         * getTotal menampilkan total dari penerimaandetail_t
         * @param type $pilih
         * @return type
         */
        public function getTotal($pilih = ""){
            $modDetail = FAPenerimaandetailT::model()->findAllByAttributes(array('penerimaanbarang_id'=>$this->penerimaanbarang_id));
            $totalBruto = 0;
            $totalDiskon = 0;
            $totalPPN = 0;
            $totalNetto = 0;
            foreach($modDetail as $mod){
                $totalBruto += ($mod->harganettoper * $mod->jmlterima);
                $hargaDiskon = $mod->harganettoper * $mod->persendiscount / 100;
                $hargaPPN = ($mod->harganettoper - $hargaDiskon) * $mod->HargappnToPersen / 100;
                $totalDiskon += ($hargaDiskon * $mod->jmlterima);
                $totalPPN += ($hargaPPN * $mod->jmlterima);
                $totalNetto += (($mod->harganettoper - $hargaDiskon + $hargaPPN) * $mod->jmlterima);
            }
            if($pilih == 'bruto')
                return $totalBruto;
            else if($pilih == 'diskon')
                return $totalDiskon;
            else if($pilih == 'ppn')
                return $totalPPN;
            else if($pilih == 'netto')
//              HITUNGANNYA ADA SELISIH >>  return $totalNetto + $this->fakturpembelian->biayamaterai;
                return $this->totalharga + (isset($this->fakturpembelian)?$this->fakturpembelian->biayamaterai:0);
            else
                return 0.00;
        }
        
        public function getSupplierItems()
        {
            return SupplierM::model()->findAll("supplier_aktif=TRUE AND supplier_jenis='Farmasi' ORDER BY supplier_nama");
        }

}