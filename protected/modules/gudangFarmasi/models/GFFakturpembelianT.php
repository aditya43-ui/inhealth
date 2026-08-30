<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class GFFakturpembelianT extends FakturpembelianT {

    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }
    
    public $tick;
    public $data;
    public $jumlah;
    public $totaltagihan;
    public $jmldibayarkan;
    public $total_bruto,$total_discount,$total_ppn,$total_bayar,$total_tagihan,$total_sisa,$total_netto,$materai;
    public $supplier_id,$supplier_nama,$supplier_alamat;
    public $noterima,$tglterima,$nopermintaan;
    public $fakturpembelian_id;
    public $tabPrint;    
	public $total_pph;
	public $persenppn;
	public $persenpph;
    
    public $jns_periode,$tgl_awal,$tgl_akhir,$bln_awal,$bln_akhir,$thn_awal,$thn_akhir;

    public function attributeLabels()
    {
            return array(
                    'fakturpembelian_id' => 'ID Faktur Pembelian',
                    'supplier_id' => 'Supplier',
                    'syaratbayar_id' => 'Syarat Bayar',
                    'suratpesanan_id' => 'Suratpesanan',
                    'ruangan_id' => 'Ruangan',
                    'nofaktur' => 'No. Faktur',
                    'tglfaktur' => 'Tgl. Faktur',
                    'tgljatuhtempo' => 'Tgl. Jatuh Tempo',
                    'keteranganfaktur' => 'Keterangan',
                    'totharganetto' => 'Total Harga',
                    'persendiscount' => 'Persen Keringanan',
                    'jmldiscount' => 'Keringanan',
                    'biayamaterai' => 'Biaya Materai',
                    'totalpajakpph' => 'Pph (Total)',
                    'totalpajakppn' => 'Ppn (Total)',
                    'totalhargabruto' => 'Total Harga (Bruto)',
                    'create_time' => 'Waktu Create',
                    'update_time' => 'Waktu Update',
                    'create_loginpemakai_id' => 'Create Login Pemakai',
                    'update_loginpemakai_id' => 'Update Login Pemakai',
                    'create_ruangan' => 'Create Ruangan',

                                            'tgl_awal'=>'Tanggal Faktur',
                                            'tgl_akhir'=>'Sampai dengan',
            );
    }

    public function criteriaLaporan()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $format = new MyFormatter;
        $criteria=new CDbCriteria;
        $this->tgl_awal  = $format->formatDateTimeForDb($this->tgl_awal);
        $this->tgl_akhir = $format->formatDateTimeForDb($this->tgl_akhir);
		/*
        $criteria->select = 't.nofaktur,t.tglfaktur, t.tgljatuhtempo, t.keteranganfaktur, t.bayarkesupplier_id,t.fakturpembelian_id,
                             t.create_ruangan,supplier_m.supplier_id,supplier_m.supplier_nama,supplier_m.supplier_alamat,
                             sum(penerimaandetail_t.harganettoper * penerimaandetail_t.jmlterima) as total_bruto,
                             sum(bayarkesupplier_t.totaltagihan) as total_tagihan,
                             sum(bayarkesupplier_t.jmldibayarkan) as total_bayar,
                             sum(fakturdetail_t.jmldiscount) as total_discount,
                             sum(fakturdetail_t.persendiscount) as discountpersen,
                             sum(t.totalpajakppn) as total_ppn,
                             sum(t.biayamaterai) as materai,
                             sum(((penerimaandetail_t.harganettoper * penerimaandetail_t.jmlterima)-fakturdetail_t.jmldiscount)+t.totalpajakppn) as total_netto,
                             (case when (t.bayarkesupplier_id is not null) then sum(bayarkesupplier_t.totaltagihan - bayarkesupplier_t.jmldibayarkan) else sum((((penerimaandetail_t.harganettoper * penerimaandetail_t.jmlterima)-fakturdetail_t.jmldiscount)+t.totalpajakppn)-0) end) as total_sisa,
                             (case when (t.bayarkesupplier_id is not null) then sum(bayarkesupplier_t.totaltagihan) else sum(t.totalhargabruto) end) as total_tagihan
                            ';
        $criteria->join = 'LEFT JOIN bayarkesupplier_t ON t.fakturpembelian_id=bayarkesupplier_t.fakturpembelian_id 
                           LEFT JOIN supplier_m ON supplier_m.supplier_id=t.supplier_id
                           LEFT JOIN fakturdetail_t ON t.fakturpembelian_id = fakturdetail_t.fakturpembelian_id
                           LEFT JOIN penerimaanbarang_t ON t.fakturpembelian_id = penerimaanbarang_t.fakturpembelian_id
                           LEFT JOIN penerimaandetail_t ON penerimaanbarang_t.penerimaanbarang_id = penerimaandetail_t.penerimaanbarang_id';
        $criteria->group = 't.nofaktur,t.tglfaktur,t.tgljatuhtempo,t.keteranganfaktur,t.create_ruangan,t.fakturpembelian_id,
                            supplier_m.supplier_id,supplier_m.supplier_nama,supplier_alamat,t.bayarkesupplier_id,t.fakturpembelian_id';*/
		$criteria->select = "	t.fakturpembelian_id,
								s.supplier_nama,
								s.supplier_id,
								t.nofaktur,
								t.tglfaktur,
								t.tgljatuhtempo,
								SUM(fd.jmlterima * fd.hargasatuan) as total_bruto,
								SUM(fd.jmldiscount) as total_discount, 
								ceil(SUM( (fd.persenppnfaktur/100) * (fd.jmlterima * fd.hargasatuan) )) as total_ppn,
								ceil(SUM( (fd.persenpphfaktur/100) * (fd.jmlterima * fd.hargasatuan) )) as total_pph,
								t.biayamaterai as materai,
								( SUM(fd.jmlterima * fd.hargasatuan) 
									-  SUM(fd.jmldiscount)
									+ (ceil(SUM( (fd.persenppnfaktur/100) * (fd.jmlterima * fd.hargasatuan) )))
									+ (ceil(SUM( (fd.persenpphfaktur/100) * (fd.jmlterima * fd.hargasatuan) )))
								+t.biayamaterai
								) as total_netto,
								( SUM(fd.jmlterima * fd.hargasatuan) 
									-  SUM(fd.jmldiscount)
									+ (ceil(SUM( (fd.persenppnfaktur/100) * (fd.jmlterima * fd.hargasatuan) )))
									+ (ceil(SUM( (fd.persenpphfaktur/100) * (fd.jmlterima * fd.hargasatuan) )))
									+t.biayamaterai
								) as total_tagihan,
								 ( (CASE 	WHEN 
											t.bayarkesupplier_id IS NOT NULL 
										THEN 
											(
												SELECT sum(bk.jmlkaskeluar) 
												FROM bayarkesupplier_t byr 
												JOIN tandabuktikeluar_t bk ON bk.tandabuktikeluar_id = byr.tandabuktikeluar_id
												where byr.bayarkesupplier_id = t.bayarkesupplier_id 				
											) 
										ELSE 
											0 
										END
									)) as total_bayar,
								 ( 
									( SUM(fd.jmlterima * fd.hargasatuan) 
										-  SUM(fd.jmldiscount)
										+ (ceil(SUM( (fd.persenppnfaktur/100) * (fd.jmlterima * fd.hargasatuan) )))
										+ (ceil(SUM( (fd.persenpphfaktur/100) * (fd.jmlterima * fd.hargasatuan) )))
										+ t.biayamaterai
									) 
									- 
									(CASE 	WHEN 
											t.bayarkesupplier_id IS NOT NULL 
										THEN 
											(
												SELECT sum(bk.jmlkaskeluar) 
												FROM bayarkesupplier_t byr 
												JOIN tandabuktikeluar_t bk ON bk.tandabuktikeluar_id = byr.tandabuktikeluar_id
												where byr.bayarkesupplier_id = t.bayarkesupplier_id 				
											) 
										ELSE 
											0 
										END
									)
) as total_sisa 
								 ";
		$criteria->join = "	JOIN supplier_m s ON s.supplier_id = t.supplier_id 
							JOIN fakturdetail_t fd ON fd.fakturpembelian_id = t.fakturpembelian_id 	";
		$criteria->group = " t.fakturpembelian_id,
								t.biayamaterai,
								s.supplier_nama,
								s.supplier_id,
								t.nofaktur,
								t.tglfaktur,
								t.tgljatuhtempo ";
		if(!empty($this->supplier_id)){
			$criteria->addCondition('t.supplier_id = '.$this->supplier_id);
		}        
        $criteria->compare('LOWER(t.nofaktur)',strtolower($this->nofaktur),true);
        $criteria->addBetweenCondition('t.tglfaktur',$this->tgl_awal,$this->tgl_akhir);
//        $criteria->compare('t.create_ruangan',Yii::app()->user->ruangan_id);
		
        return $criteria;
    }

    public function searchLaporan()
    {

            return new CActiveDataProvider($this, array(
                    'criteria'=>$this->criteriaLaporan(),
                                            'pagination'=>array(
                                                'pageSize'=>10
                                            )
            ));
    }

    public function searchLaporanPrint()
    {

            return new CActiveDataProvider($this, array(
                    'criteria'=>$this->criteriaLaporan(),
                                            'pagination'=>false,
            ));
    }

    public function searchGrafik()
    {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=new CDbCriteria;
			
            $criteria->select = "count(fakturpembelian_id) as jumlah, fakturpembelian_id, date_part('year', tglfaktur) as data, nofaktur";
            $criteria->group = 'tglfaktur, fakturpembelian_id, nofaktur';
//                     
            $criteria->addBetweenCondition('tglfaktur',$this->tgl_awal,$this->tgl_akhir);
//            $criteria->addCondition('ruangan_id = '.Yii::app()->user->ruangan_id);
			
            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
    }

    public function getTotalharganetto()
    {
        $criteria = $this->criteriaLaporan();
        $criteria->select = 'SUM(totharganetto)';

        return $this->commandBuilder->createFindCommand($this->getTableSchema(),$criteria)->queryScalar();
    }
    
    public function searchInformasi()
    {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=new CDbCriteria;

            $criteria->with = array('supplier');
            $criteria->addBetweenCondition('date(t.tglfaktur)',$this->tgl_awal,$this->tgl_akhir,true);
            $criteria->compare('LOWER(nofaktur)',strtolower($this->nofaktur),true);
			if(!empty($this->supplier_id)){
				$criteria->addCondition('t.supplier_id = '.$this->supplier_id);
			}        
            $criteria->group = 'supplier.supplier_id, t.fakturpembelian_id, t.tglfaktur, t.nofaktur , t.tgljatuhtempo, t.supplier_id,
                                t.totharganetto, t.supplier_id,t.persendiscount,t.biayamaterai,t.biayamaterai,
                                t.totalpajakpph,t.totalpajakppn,t.totalhargabruto'; 
            $criteria->select = $criteria->group;
            $criteria->order = 't.tglfaktur';
            $criteria->join = 'LEFT JOIN returpembelian_t ON t.fakturpembelian_id = returpembelian_t.fakturpembelian_id
                               LEFT OUTER JOIN supplier_m ON t.supplier_id= supplier_m.supplier_id';
            $criteria->addCondition("supplier.supplier_jenis='Farmasi'");
            
            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
    }
    
    public function getSupplierItems()
    {
            return SupplierM::model()->findAll("supplier_aktif=TRUE AND supplier_jenis='Farmasi' ORDER BY supplier_nama");
    }
	
    public function getRuanganItems()
    {
            return RuanganM::model()->findAll("ruangan_aktif=TRUE ORDER BY ruangan_nama");
    }
}

?>
