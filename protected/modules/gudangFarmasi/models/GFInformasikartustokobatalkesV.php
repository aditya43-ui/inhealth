<?php


class GFInformasikartustokobatalkesV extends InformasikartustokobatalkesV
{
        public $tgl_awal, $tgl_akhir, $transaksi;
		public $satuanbesar_nama;
		public $isikemasan;
		public $retpendetail_id;
		public $returpenerimaan_id;
		public $noreturterima;
		public $pilihTgl;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InformasikartustokobatalkesV the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        /**
         * Retrieves a list of models based on the current search/filter conditions.
         * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
         */
        public function searchInformasi()
        {
            $criteria=new CDbCriteria;

            $criteria->addBetweenCondition('DATE(t.create_time)',$this->tgl_awal,$this->tgl_akhir);
			if(!empty($this->instalasi_id)){
				$criteria->addCondition('t.instalasi_id = '.$this->instalasi_id);
			}
			if(!empty($this->ruangan_id)){
				$criteria->addCondition('t.ruangan_id = '.$this->ruangan_id);
			}
			if(!empty($this->penerimaandetail_id)){
				$criteria->addCondition('t.penerimaandetail_id = '.$this->penerimaandetail_id);
			}
			if(!empty($this->penerimaanbarang_id)){
				$criteria->addCondition('t.penerimaanbarang_id = '.$this->penerimaanbarang_id);
			}
			if(!empty($this->fakturpembelian_id)){
				$criteria->addCondition('t.fakturpembelian_id = '.$this->fakturpembelian_id);
			}
			if(!empty($this->returpembelian_id)){
				$criteria->addCondition('t.returpembelian_id = '.$this->returpembelian_id);
			}
			if(!empty($this->terimamutasidetail_id)){
				$criteria->addCondition('t.terimamutasidetail_id = '.$this->terimamutasidetail_id);
			}
			if(!empty($this->returdetail_id)){
				$criteria->addCondition('t.returdetail_id = '.$this->returdetail_id);
			}
			if(!empty($this->mutasioadetail_id)){
				$criteria->addCondition('t.mutasioadetail_id = '.$this->mutasioadetail_id);
			}
			if(!empty($this->obatalkespasien_id)){
				$criteria->addCondition('t.obatalkespasien_id = '.$this->obatalkespasien_id);
			}
			if(!empty($this->terimamutasi_id)){
				$criteria->addCondition('t.terimamutasi_id = '.$this->terimamutasi_id);
			}
			if(!empty($this->penjualanresep_id)){
				$criteria->addCondition('t.penjualanresep_id = '.$this->penjualanresep_id);
			}
			if(!empty($this->pemusnahanoadetail_id)){
				$criteria->addCondition('t.pemusnahanoadetail_id = '.$this->pemusnahanoadetail_id);
			}
			if(!empty($this->pemusnahanobatalkes_id)){
				$criteria->addCondition('t.pemusnahanobatalkes_id = '.$this->pemusnahanobatalkes_id);
			}
			if(!empty($this->formstokopname_id)){
				$criteria->addCondition('t.formstokopname_id = '.$this->formstokopname_id);
			}
            $criteria->compare('LOWER(t.noterimabarang)',strtolower($this->noterimabarang),true);
            $criteria->compare('LOWER(t.nosuratjalan)',strtolower($this->nosuratjalan),true);
            $criteria->compare('LOWER(t.nofaktur)',strtolower($this->nofaktur),true);
            $criteria->compare('LOWER(t.noretur)',strtolower($this->noretur),true);
            $criteria->compare('LOWER(t.noterimamutasi)',strtolower($this->noterimamutasi),true);
            $criteria->compare('LOWER(t.noreturresep)',strtolower($this->noreturresep),true);
			if(!empty($this->returpenerimaan_id)){
				$criteria->addCondition('t.returpenerimaan_id = '.$this->returpenerimaan_id);
			}
			if(!empty($this->mutasioaruangan_id)){
				$criteria->addCondition('t.mutasioaruangan_id = '.$this->mutasioaruangan_id);
			}
            $criteria->compare('LOWER(t.nomutasioa)',strtolower($this->nomutasioa),true);
            $criteria->compare('LOWER(t.noresep)',strtolower($this->noresep),true);
            $criteria->compare('LOWER(t.nopemusnahan)',strtolower($this->nopemusnahan),true);
			if(!empty($this->formuliropname_id)){
				$criteria->addCondition('t.formuliropname_id = '.$this->formuliropname_id);
			}
            $criteria->compare('LOWER(t.noformulir)',strtolower($this->noformulir),true);
			if(!empty($this->stokopnamedet_id)){
				$criteria->addCondition('t.stokopnamedet_id = '.$this->stokopnamedet_id);
			}
			if(!empty($this->stokopname_id)){
				$criteria->addCondition('t.stokopname_id = '.$this->stokopname_id);
			}
            $criteria->compare('LOWER(nostokopname)',strtolower($this->nostokopname),true);
			if(!empty($this->jenisobatalkes_id)){
				$criteria->addCondition('t.jenisobatalkes_id = '.$this->jenisobatalkes_id);
			}
			if(!empty($this->obatalkes_id)){
				$criteria->addCondition('t.obatalkes_id = '.$this->obatalkes_id);
			}
            $criteria->compare('LOWER(t.obatalkes_barcode)',strtolower($this->obatalkes_barcode),true);
            $criteria->compare('LOWER(t.obatalkes_kode)',strtolower($this->obatalkes_kode),true);
            $criteria->compare('LOWER(t.obatalkes_nama)',strtolower($this->obatalkes_nama),true);
            $criteria->compare('LOWER(t.obatalkes_namalain)',strtolower($this->obatalkes_namalain),true);
            $criteria->compare('LOWER(t.obatalkes_golongan)',strtolower($this->obatalkes_golongan),true);
            $criteria->compare('LOWER(t.obatalkes_kategori)',strtolower($this->obatalkes_kategori),true);
			if(!empty($this->asalbarang_id)){
				$criteria->addCondition('t.asalbarang_id = '.$this->asalbarang_id);
			}
			if(!empty($this->satuankecil_id)){
				$criteria->addCondition('t.satuankecil_id = '.$this->satuankecil_id);
			}
            $criteria->compare('LOWER(t.satuankecil_nama)',strtolower($this->satuankecil_nama),true);
            $criteria->compare('LOWER(t.nobatch)',strtolower($this->nobatch),true);
            $criteria->compare('t.stokoa_aktif',$this->stokoa_aktif);
			if(!empty($this->tglkadaluarsa)){
				$criteria->compare('DATE(t.tglkadaluarsa)',  MyFormatter::formatDateTimeForDb($this->tglkadaluarsa));
			}
            if($this->transaksi){
                if ($this->transaksi == "stokopname_id_1") {
                    $criteria->join = "join stokopname_t o on o.stokopname_id = t.stokopname_id";
                    $criteria->addCondition("o.isstokawal = true");
                } else if ($this->transaksi == "stokopname_id_2") {
                    $criteria->join = "join stokopname_t o on o.stokopname_id = t.stokopname_id";
                    $criteria->addCondition("o.isstokawal = false");
                } else $criteria->addCondition($this->transaksi.' > 0'); 
            }
            
            $criteria->order="create_time DESC";
            $criteria->limit=10;

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
        }
        
        /**
         * Retrieves a list of models based on the current search/filter conditions.
         * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
         */
        public function searchInformasiPrint()
        {
            $criteria=new CDbCriteria;

            $criteria->addBetweenCondition('DATE(t.create_time)',$this->tgl_awal,$this->tgl_akhir);
			if(!empty($this->instalasi_id)){
				$criteria->addCondition('t.instalasi_id = '.$this->instalasi_id);
			}
			if(!empty($this->ruangan_id)){
				$criteria->addCondition('t.ruangan_id = '.$this->ruangan_id);
			}
			if(!empty($this->penerimaandetail_id)){
				$criteria->addCondition('t.penerimaandetail_id = '.$this->penerimaandetail_id);
			}
			if(!empty($this->penerimaanbarang_id)){
				$criteria->addCondition('t.penerimaanbarang_id = '.$this->penerimaanbarang_id);
			}
			if(!empty($this->fakturpembelian_id)){
				$criteria->addCondition('t.fakturpembelian_id = '.$this->fakturpembelian_id);
			}
			if(!empty($this->returpembelian_id)){
				$criteria->addCondition('t.returpembelian_id = '.$this->returpembelian_id);
			}
			if(!empty($this->terimamutasidetail_id)){
				$criteria->addCondition('t.terimamutasidetail_id = '.$this->terimamutasidetail_id);
			}
			if(!empty($this->returdetail_id)){
				$criteria->addCondition('t.returdetail_id = '.$this->returdetail_id);
			}
			if(!empty($this->mutasioadetail_id)){
				$criteria->addCondition('t.mutasioadetail_id = '.$this->mutasioadetail_id);
			}
			if(!empty($this->obatalkespasien_id)){
				$criteria->addCondition('t.obatalkespasien_id = '.$this->obatalkespasien_id);
			}
			if(!empty($this->terimamutasi_id)){
				$criteria->addCondition('t.terimamutasi_id = '.$this->terimamutasi_id);
			}
			if(!empty($this->penjualanresep_id)){
				$criteria->addCondition('t.penjualanresep_id = '.$this->penjualanresep_id);
			}
			if(!empty($this->pemusnahanoadetail_id)){
				$criteria->addCondition('t.pemusnahanoadetail_id = '.$this->pemusnahanoadetail_id);
			}
			if(!empty($this->pemusnahanobatalkes_id)){
				$criteria->addCondition('t.pemusnahanobatalkes_id = '.$this->pemusnahanobatalkes_id);
			}
			if(!empty($this->formstokopname_id)){
				$criteria->addCondition('t.formstokopname_id = '.$this->formstokopname_id);
			}
            $criteria->compare('LOWER(t.noterimabarang)',strtolower($this->noterimabarang),true);
            $criteria->compare('LOWER(t.nosuratjalan)',strtolower($this->nosuratjalan),true);
            $criteria->compare('LOWER(t.nofaktur)',strtolower($this->nofaktur),true);
            $criteria->compare('LOWER(t.noretur)',strtolower($this->noretur),true);
            $criteria->compare('LOWER(t.noterimamutasi)',strtolower($this->noterimamutasi),true);
            $criteria->compare('LOWER(t.noreturresep)',strtolower($this->noreturresep),true);
			if(!empty($this->returpenerimaan_id)){
				$criteria->addCondition('t.returpenerimaan_id = '.$this->returpenerimaan_id);
			}
			if(!empty($this->mutasioaruangan_id)){
				$criteria->addCondition('t.mutasioaruangan_id = '.$this->mutasioaruangan_id);
			}
            $criteria->compare('LOWER(t.nomutasioa)',strtolower($this->nomutasioa),true);
            $criteria->compare('LOWER(t.noresep)',strtolower($this->noresep),true);
            $criteria->compare('LOWER(t.nopemusnahan)',strtolower($this->nopemusnahan),true);
			if(!empty($this->formuliropname_id)){
				$criteria->addCondition('t.formuliropname_id = '.$this->formuliropname_id);
			}
            $criteria->compare('LOWER(t.noformulir)',strtolower($this->noformulir),true);
			if(!empty($this->stokopnamedet_id)){
				$criteria->addCondition('t.stokopnamedet_id = '.$this->stokopnamedet_id);
			}
			if(!empty($this->stokopname_id)){
				$criteria->addCondition('t.stokopname_id = '.$this->stokopname_id);
			}
            $criteria->compare('LOWER(nostokopname)',strtolower($this->nostokopname),true);
			if(!empty($this->jenisobatalkes_id)){
				$criteria->addCondition('t.jenisobatalkes_id = '.$this->jenisobatalkes_id);
			}
			if(!empty($this->obatalkes_id)){
				$criteria->addCondition('t.obatalkes_id = '.$this->obatalkes_id);
			}
            $criteria->compare('LOWER(t.obatalkes_barcode)',strtolower($this->obatalkes_barcode),true);
            $criteria->compare('LOWER(t.obatalkes_kode)',strtolower($this->obatalkes_kode),true);
            $criteria->compare('LOWER(t.obatalkes_nama)',strtolower($this->obatalkes_nama),true);
            $criteria->compare('LOWER(t.obatalkes_namalain)',strtolower($this->obatalkes_namalain),true);
            $criteria->compare('LOWER(t.obatalkes_golongan)',strtolower($this->obatalkes_golongan),true);
            $criteria->compare('LOWER(t.obatalkes_kategori)',strtolower($this->obatalkes_kategori),true);
			if(!empty($this->asalbarang_id)){
				$criteria->addCondition('t.asalbarang_id = '.$this->asalbarang_id);
			}
			if(!empty($this->satuankecil_id)){
				$criteria->addCondition('t.satuankecil_id = '.$this->satuankecil_id);
			}
            $criteria->compare('LOWER(t.satuankecil_nama)',strtolower($this->satuankecil_nama),true);
            $criteria->compare('LOWER(t.nobatch)',strtolower($this->nobatch),true);
            $criteria->compare('t.stokoa_aktif',$this->stokoa_aktif);
			if(!empty($this->tglkadaluarsa)){
				$criteria->compare('DATE(t.tglkadaluarsa)',  MyFormatter::formatDateTimeForDb($this->tglkadaluarsa));
			}
            if($this->transaksi){
                if ($this->transaksi == "stokopname_id_1") {
                    $criteria->join = "join stokopname_t o on o.stokopname_id = t.stokopname_id";
                    $criteria->addCondition("o.isstokawal = true");
                } else if ($this->transaksi == "stokopname_id_2") {
                    $criteria->join = "join stokopname_t o on o.stokopname_id = t.stokopname_id";
                    $criteria->addCondition("o.isstokawal = false");
                } else $criteria->addCondition($this->transaksi.' > 0'); 
            }
            
            $criteria->order="create_time DESC";
            $criteria->limit=-1;

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
                    'pagination'=>false
            ));
        }
        
        
        
        /**
         * menampilkan nama transaksi
         */
        public function getNamaTransaksi(){
			if(!empty($this->penerimaanbarang_id)){
                return 'Penerimaan Barang dari  '.$this->NamaSupplier;
            }else if(!empty($this->returpembelian_id)){
                return $this->getAttributeLabel("returpembelian_id");
            }else if(!empty($this->terimamutasi_id)){
                return "Mutasi Masuk"; //$this->getAttributeLabel("terimamutasi_id");
            }else if(!empty($this->returresep_id)){
                return $this->getAttributeLabel("returresep_id");
            }else if(!empty($this->returpembelian_id)){
                return "Retur Faktur"; //$this->getAttributeLabel("returpembelian_id");
            }else if(!empty($this->mutasioaruangan_id)){
                return "Mutasi Keluar"; //$this->getAttributeLabel("mutasioaruangan_id");
            }else if(!empty($this->penjualanresep_id)){
                return $this->getAttributeLabel("penjualanresep_id");
            }else if(!empty($this->pemusnahanobatalkes_id)){
                return $this->getAttributeLabel("pemusnahanobatalkes_id");
            }else if(!empty($this->stokopname_id)){
                $op = StokopnameT::model()->findByPk($this->stokopname_id);
                return $this->getAttributeLabel("stokopname_id")." ".(
                        (trim(strtolower($op->jenisstokopname)) == "penyesuaian")?"Penyesuaian":"Awal");
            }else if(!empty($this->pemakaianobat_id)){
                return 'Pemakaian di Ruangan '.$this->ruangan_nama;
            }else if(!empty($this->obatalkespasien_id)){
				$oap = ObatalkespasienT::model()->findByAttributes(array('obatalkespasien_id'=>$this->obatalkespasien_id,'oa'=>Params::OBATALKESPASIEN_BMHP));

				if(!empty($oap)){
					return 'Pemakaian Bahan Pasien';
				}
                
            }
        }
		
        public function getNamaSupplier(){
			$modPenerimaanBarang = PenerimaanbarangT::model()->findByPk($this->penerimaanbarang_id);
			$return = !empty($modPenerimaanBarang)?'  <u>Supplier'.$modPenerimaanBarang->supplier->supplier_nama.'</u>':null;
			return $return;
        }
		
		public function getNamaTransaksiKartuStok(){
			$transaksi = array(
                                'mutasioaruangan_id'=>"Mutasi Keluar",//$this->getAttributeLabel("mutasioaruangan_id"),
                                'terimamutasi_id'=>"Mutasi Masuk",//$this->getAttributeLabel("terimamutasi_id"),    
				'penerimaanbarang_id'=>$this->getAttributeLabel("penerimaanbarang_id"),  	
				'returpembelian_id'=>"Retur Faktur",//$this->getAttributeLabel("returpembelian_id"),
                                'pemakaianobat_id'=>'Pemakaian di Ruangan',
                                'pemusnahanobatalkes_id'=>$this->getAttributeLabel("pemusnahanobatalkes_id"),                          
                                'penjualanresep_id'=>$this->getAttributeLabel("penjualanresep_id"),			
                                //'returpenerimaan_id'=>$this->getAttributeLabel("returpenerimaan_id"),
                                'returresep_id'=>$this->getAttributeLabel("returresep_id"),
                                'stokopname_id_1'=>"Stok Opname Awal",//$this->getAttributeLabel("stokopname_id"),								
                                'stokopname_id_2'=>"Stok Opname Penyesuaian",//$this->getAttributeLabel("stokopname_id"),	
								'obatalkespasien_id'=>"Pemakaian Bahan Pasien"							
			);
			return $transaksi;
		}
		
		public function getTransaksiMasukItems(){
			$transaksi = array(
				'penerimaanbarang_id'=>$this->getAttributeLabel("penerimaanbarang_id"),
				'terimamutasi_id'=>$this->getAttributeLabel("terimamutasi_id"),
				'returresep_id'=>$this->getAttributeLabel("returresep_id"),
				'stokopname_id'=>$this->getAttributeLabel("stokopname_id"),
			);
			return $transaksi;
		}
        /**
		 * untuk transaksi pemusnahan obat
		 * @return \CActiveDataProvider
		 */
        public function searchDialogPemusnahan()
        {
			$format = new MyFormatter();
            $criteria=new CDbCriteria;
			if(!empty($this->ruangan_id)){
				$criteria->addCondition('ruangan_id = '.$this->ruangan_id);
			}else{
				$criteria->addCondition('ruangan_id = '.Yii::app()->user->getState('ruangan_id'));
			}
			if(!empty($this->jenisobatalkes_id)){
				$criteria->addCondition('jenisobatalkes_id = '.$this->jenisobatalkes_id);
			}
            $criteria->compare('LOWER(obatalkes_kode)',strtolower($this->obatalkes_kode),true);
            $criteria->compare('LOWER(obatalkes_barcode)',strtolower($this->obatalkes_kode),true,'OR');
            $criteria->compare('LOWER(obatalkes_nama)',strtolower($this->obatalkes_nama),true);
            $criteria->compare('LOWER(obatalkes_namalain)',strtolower($this->obatalkes_nama),true,'OR');
			$criteria->compare('LOWER(satuankecil_nama)',strtolower($this->satuankecil_nama),true);			
            $criteria->compare('LOWER(nobatch)',strtolower($this->nobatch),true);
            $criteria->compare('DATE(tglkadaluarsa)',$format->formatDateTimeForDb($this->tglkadaluarsa));
            if($this->transaksi){
				$criteria->addCondition($this->transaksi.' > 0'); 
			}
            $criteria->addCondition('stokoa_aktif = TRUE'); 
            $criteria->addCondition('qtystok_in > 0'); 
            
            $criteria->limit=5;

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
        }
		/**
		 * menampilkan stok berdasarkan group batch (stokobatalkes_id dan stokobatalkesasal_id
		 * @return type
		 */
		public function getStokObatBatch(){ // menampilkan stok obat per ruangan login
            return StokobatalkesT::getJumlahStokBatch($this->stokobatalkes_id);
        }
		
		public function searchByObatalkes()
        {
			$criteria = new CDbCriteria();
			
            //$criteria->addBetweenCondition('DATE(t.create_time)',$this->tgl_awal,$this->tgl_akhir);
			if(!empty($this->obatalkes_id)){
				$criteria->addCondition('t.obatalkes_id = '.$this->obatalkes_id);
			}
			if(!empty($this->instalasi_id)){
				$criteria->addCondition('t.instalasi_id = '.$this->instalasi_id);
			}
			if(!empty($this->ruangan_id)){
				$criteria->addCondition('t.ruangan_id = '.$this->ruangan_id);
			}
			if(!empty($this->penerimaandetail_id)){
				$criteria->addCondition('t.penerimaandetail_id = '.$this->penerimaandetail_id);
			}
			if(!empty($this->penerimaanbarang_id)){
				$criteria->addCondition('t.penerimaanbarang_id = '.$this->penerimaanbarang_id);
			}
			if(!empty($this->fakturpembelian_id)){
				$criteria->addCondition('t.fakturpembelian_id = '.$this->fakturpembelian_id);
			}
			if(!empty($this->returpembelian_id)){
				$criteria->addCondition('t.returpembelian_id = '.$this->returpembelian_id);
			}
			if(!empty($this->terimamutasidetail_id)){
				$criteria->addCondition('t.terimamutasidetail_id = '.$this->terimamutasidetail_id);
			}
			if(!empty($this->returdetail_id)){
				$criteria->addCondition('t.returdetail_id = '.$this->returdetail_id);
			}
			if(!empty($this->mutasioadetail_id)){
				$criteria->addCondition('t.mutasioadetail_id = '.$this->mutasioadetail_id);
			}
			if(!empty($this->obatalkespasien_id)){
				$criteria->addCondition('t.obatalkespasien_id = '.$this->obatalkespasien_id);
			}
			if(!empty($this->terimamutasi_id)){
				$criteria->addCondition('t.terimamutasi_id = '.$this->terimamutasi_id);
			}
			if(!empty($this->penjualanresep_id)){
				$criteria->addCondition('t.penjualanresep_id = '.$this->penjualanresep_id);
			}
			if(!empty($this->pemusnahanoadetail_id)){
				$criteria->addCondition('t.pemusnahanoadetail_id = '.$this->pemusnahanoadetail_id);
			}
			if(!empty($this->pemusnahanobatalkes_id)){
				$criteria->addCondition('t.pemusnahanobatalkes_id = '.$this->pemusnahanobatalkes_id);
			}
			if(!empty($this->formstokopname_id)){
				$criteria->addCondition('t.formstokopname_id = '.$this->formstokopname_id);
			}
            $criteria->compare('LOWER(t.noterimabarang)',strtolower($this->noterimabarang),true);
            $criteria->compare('LOWER(t.nosuratjalan)',strtolower($this->nosuratjalan),true);
            $criteria->compare('LOWER(t.nofaktur)',strtolower($this->nofaktur),true);
            $criteria->compare('LOWER(t.noretur)',strtolower($this->noretur),true);
            $criteria->compare('LOWER(t.noterimamutasi)',strtolower($this->noterimamutasi),true);
            $criteria->compare('LOWER(t.noreturresep)',strtolower($this->noreturresep),true);
			if(!empty($this->returpenerimaan_id)){
				$criteria->addCondition('t.returpenerimaan_id = '.$this->returpenerimaan_id);
			}
			if(!empty($this->mutasioaruangan_id)){
				$criteria->addCondition('t.mutasioaruangan_id = '.$this->mutasioaruangan_id);
			}
            $criteria->compare('LOWER(t.nomutasioa)',strtolower($this->nomutasioa),true);
            $criteria->compare('LOWER(t.noresep)',strtolower($this->noresep),true);
            $criteria->compare('LOWER(t.nopemusnahan)',strtolower($this->nopemusnahan),true);
			if(!empty($this->formuliropname_id)){
				$criteria->addCondition('t.formuliropname_id = '.$this->formuliropname_id);
			}
            $criteria->compare('LOWER(t.noformulir)',strtolower($this->noformulir),true);
			if(!empty($this->stokopnamedet_id)){
				$criteria->addCondition('t.stokopnamedet_id = '.$this->stokopnamedet_id);
			}
			if(!empty($this->stokopname_id)){
				$criteria->addCondition('t.stokopname_id = '.$this->stokopname_id);
			}
            $criteria->compare('LOWER(nostokopname)',strtolower($this->nostokopname),true);
			if(!empty($this->jenisobatalkes_id)){
				$criteria->addCondition('t.jenisobatalkes_id = '.$this->jenisobatalkes_id);
			}
			
            $criteria->compare('LOWER(t.obatalkes_barcode)',strtolower($this->obatalkes_barcode),true);
            $criteria->compare('LOWER(t.obatalkes_kode)',strtolower($this->obatalkes_kode),true);
            $criteria->compare('LOWER(t.obatalkes_nama)',strtolower($this->obatalkes_nama),true);
            $criteria->compare('LOWER(t.obatalkes_namalain)',strtolower($this->obatalkes_namalain),true);
            $criteria->compare('LOWER(t.obatalkes_golongan)',strtolower($this->obatalkes_golongan),true);
            $criteria->compare('LOWER(t.obatalkes_kategori)',strtolower($this->obatalkes_kategori),true);
			if(!empty($this->asalbarang_id)){
				$criteria->addCondition('t.asalbarang_id = '.$this->asalbarang_id);
			}
			if(!empty($this->satuankecil_id)){
				$criteria->addCondition('t.satuankecil_id = '.$this->satuankecil_id);
			}
            $criteria->compare('LOWER(t.satuankecil_nama)',strtolower($this->satuankecil_nama),true);
            $criteria->compare('LOWER(t.nobatch)',strtolower($this->nobatch),true);
            $criteria->compare('t.stokoa_aktif',$this->stokoa_aktif);
			if(!empty($this->tglkadaluarsa)){
				$criteria->compare('DATE(t.tglkadaluarsa)',  MyFormatter::formatDateTimeForDb($this->tglkadaluarsa));
			}
            if($this->transaksi){
                if ($this->transaksi == "stokopname_id_1") {
                    $criteria->join = "join stokopname_t o on o.stokopname_id = t.stokopname_id";
                    $criteria->addCondition("o.isstokawal = true");
                } else if ($this->transaksi == "stokopname_id_2") {
                    $criteria->join = "join stokopname_t o on o.stokopname_id = t.stokopname_id";
                    $criteria->addCondition("o.isstokawal = false");
                } else $criteria->addCondition($this->transaksi.' > 0'); 
            }
            
            $criteria->addCondition('(qtystok_in <> 0 or qtystok_out <> 0)');
            
			$criteria->order = " t.create_time ASC ";
            //$criteria->limit=10;

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
        }
		
		 public function getNoTransaksi(){
			 if(!empty($this->penerimaanbarang_id)){
                return $this->noterimabarang;
            }else if(!empty($this->returpembelian_id)){
                return $this->noretur;
            }else if(!empty($this->terimamutasi_id)){
                return $this->noterimamutasi;
            }else if(!empty($this->returresep_id)){
                return $this->noreturresep;
            }else if(!empty($this->returpembelian_id)){
                return $this->noretur;
            }else if(!empty($this->mutasioaruangan_id)){
                return $this->nomutasioa;
            }else if(!empty($this->penjualanresep_id)){
                return $this->noresep;
            }else if(!empty($this->pemusnahanobatalkes_id)){
                return $this->nopemusnahan;
            }else if(!empty($this->stokopname_id)){
                return $this->nostokopname;
            }else if(!empty($this->pemakaianobat_id)){
                return $this->nopemakaian_obat;
            }else if(!empty($this->obatalkespasien_id)){
				$oap = ObatalkespasienT::model()->findByAttributes(array('obatalkespasien_id'=>$this->obatalkespasien_id,'oa'=>Params::OBATALKESPASIEN_BMHP));

				if(!empty($oap)){
					return (!empty($oap->pendaftaran)?$oap->pendaftaran->no_pendaftaran:"");
				}
                
            }
        }
        
        
        
        
}