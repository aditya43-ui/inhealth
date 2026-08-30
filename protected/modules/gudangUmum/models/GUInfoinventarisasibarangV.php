<?php
class GUInfoinventarisasibarangV extends InfoinventarisasibarangV
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InfoinventarisasibarangV the static model class
	 */
	public $checklist,$invbarang_jenis,$tgl_awal,$tgl_akhir,$qtystok,$lookup_type,$lookup_name,$lookup_value;
        public $bln_awal, $bln_akhir;
        public $thn_awal, $thn_akhir;
        public $jns_periode;
        public $data;
        public $jumlah;
        public $tick;


        public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'invbarang_id' => 'Inv barang ID',
			'invbarang_no' => 'No. Inventarisasi',
			'invbarang_tgl' => 'Tgl. Inventarisasi',
			'invbarang_ket' => 'Keterangan',
			'invbarang_totalnetto' => 'Total Netto',
			'mengetahui_id' => 'Mengetahui',
			'petugas1_id' => 'Petugas1',
			'petugas2_id' => 'Petugas2',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
			'inventarisasi_id' => 'Inventarisasi',
			'inventarisasi_qty_in' => 'Inventarisasi Qty In',
			'inventarisasi_qty_out' => 'Inventarisasi Qty Out',
			'inventarisasi_qty_skrg' => 'Inventarisasi Qty Skrg',
			'invbarangdet_id' => 'Invbarangdet ID',
			'volume_fisik' => 'Volume Fisik',
			'harga_satuan' => 'Harga Satuan',
			'jumlah_harga' => 'Jumlah Harga',
			'harga_netto' => 'Harga Netto',
			'jumlah_netto' => 'Jumlah Netto',
			'kondisi_barang' => 'Kondisi Barang',
			'barang_id' => 'Barang',
			'barang_kode' => 'Kode Barang',
			'barang_nama' => 'Nama Barang',
			'barang_merk' => 'Merk Barang',
			'barang_noseri' => 'No Seri Barang',
			'barang_satuan' => 'Satuan Barang',
			'barang_harganetto' => 'Harga Netto Barang',
			'barang_hpp' => 'Hpp Barang',
			'formulirinvbarang_id' => 'Formulirinvbarang',
			'forminvbarang_no' => 'No Form inv barang ',
			'forminvbarang_tgl' => 'Tgl. Form inv barang ',
			'forminvbarang_totalvolume' => 'Total volume Form inv barang ',
			'forminvbarang_totalharga' => 'Total harga Form inv barang ',
			'forminvbarangdet_id' => 'Forminvbarangdet ID',
			'volume_inventaris' => 'Volume Inventaris',
		);
	}

	/**
	* Retrieves a list of models based on the current search/filter conditions.
	* @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	*/
	public function searchBarangInventarisasi()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$criteria->limit=1000;
		if(!Yii::app()->request->isAjaxRequest){//data hanya muncul setelah melakukan pencarian
			 $criteria->limit = 0;
		 }
		 if(!empty($this->invbarang_id)){
			 $criteria->addCondition('invbarang_id = '.$this->invbarang_id);
		 }
		 if(isset($_GET['formulirinvbarang_id'])){
			$model = new GUForminvbarangdetR;
			$criteria->addCondition('formulirinvbarang_id = '.$_GET['formulirinvbarang_id']);
			$criteria->addCondition('invbarangdet_id IS NULL');
			$criteria->limit = -1;
		}else if(isset($_GET['invbarang_id'])){
			$model = new GUInvbarangdetT;
			$criteria->addCondition('invbarang_id = '.$_GET['invbarang_id']);
			$criteria->limit = -1;
		}else{
			if(!empty($this->barang_id)){
				$criteria->addCondition('barang_id = '.$this->barang_id);
			}
			$criteria->compare('LOWER(barang_kode)',strtolower($this->barang_kode));
			$criteria->compare('LOWER(barang_nama)',strtolower($this->barang_nama),true);
			$criteria->compare('LOWER(barang_noseri)',strtolower($this->barang_noseri),true);
			$criteria->compare('LOWER(barang_merk)',strtolower($this->barang_merk),true);
			$criteria->compare('LOWER(barang_satuan)',strtolower($this->barang_satuan),true);
			if($this->invbarang_jenis == Params::DEFAULT_JENISINVENTARISASI){
				$model = $this;
			}else{
				$model = new GUBarangV();
			}

		}

		return new CActiveDataProvider($model, array(
			'criteria'=>$criteria,
			'pagination'=>false,
		));
	}

	/**
	* Retrieves a list of models based on the current search/filter conditions.
	* @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	*/
	public function searchInformasi()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->group = 'invbarang_ket, invbarang_id, invbarang_totalnetto, invbarang_no, invbarang_tgl,formulirinvbarang_id,forminvbarang_tgl,forminvbarang_no, barang_hpp, mengetahui_id, petugas1_id, petugas2_id';
		$criteria->select = $criteria->group.', sum(totalnilaipersediaan) as totalnilaipersediaan';
		$criteria->addBetweenCondition('DATE(invbarang_tgl)',$this->tgl_awal,$this->tgl_akhir);

		if(!empty($this->invbarang_id)){
			$criteria->addCondition('invbarang_id = '.$this->invbarang_id);
		}
		$criteria->compare('LOWER(invbarang_no)',strtolower($this->invbarang_no),true);
		$criteria->compare('LOWER(invbarang_tgl)',strtolower($this->invbarang_tgl),true);
		$criteria->compare('LOWER(invbarang_ket)',strtolower($this->invbarang_ket),true);
		$criteria->compare('invbarang_totalnetto',$this->invbarang_totalnetto);
		if(!empty($this->mengetahui_id)){
			$criteria->addCondition('mengetahui_id = '.$this->mengetahui_id);
		}
		if(!empty($this->petugas1_id)){
			$criteria->addCondition('petugas1_id = '.$this->petugas1_id);
		}
		if(!empty($this->petugas2_id)){
			$criteria->addCondition('petugas2_id = '.$this->petugas2_id);
		}
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
		if(!empty($this->inventarisasi_id)){
			$criteria->addCondition('inventarisasi_id = '.$this->inventarisasi_id);
		}
		$criteria->compare('inventarisasi_qty_in',$this->inventarisasi_qty_in);
		$criteria->compare('inventarisasi_qty_out',$this->inventarisasi_qty_out);
		$criteria->compare('inventarisasi_qty_skrg',$this->inventarisasi_qty_skrg);
		if(!empty($this->invbarangdet_id)){
			$criteria->addCondition('invbarangdet_id = '.$this->invbarangdet_id);
		}
		$criteria->compare('volume_fisik',$this->volume_fisik);
		$criteria->compare('harga_satuan',$this->harga_satuan);
		$criteria->compare('jumlah_harga',$this->jumlah_harga);
		$criteria->compare('harga_netto',$this->harga_netto);
		$criteria->compare('jumlah_netto',$this->jumlah_netto);
		$criteria->compare('LOWER(kondisi_barang)',strtolower($this->kondisi_barang),true);
		$criteria->compare('LOWER(barang_kode)',strtolower($this->barang_kode),true);
		$criteria->compare('LOWER(barang_nama)',strtolower($this->barang_nama),true);
		$criteria->compare('LOWER(barang_merk)',strtolower($this->barang_merk),true);
		$criteria->compare('LOWER(barang_noseri)',strtolower($this->barang_noseri),true);
		$criteria->compare('LOWER(barang_satuan)',strtolower($this->barang_satuan),true);
		$criteria->compare('barang_harganetto',$this->barang_harganetto);
		$criteria->compare('barang_hpp',$this->barang_hpp);
		if(!empty($this->lookup_id)){
			$criteria->addCondition('lookup_id = '.$this->lookup_id);
		}
		$criteria->compare('LOWER(lookup_type)',strtolower($this->lookup_type),true);
		$criteria->compare('LOWER(lookup_name)',strtolower($this->lookup_name),true);
		$criteria->compare('LOWER(lookup_value)',strtolower($this->lookup_value),true);
		if(!empty($this->formulirinvbarang_id)){
			$criteria->addCondition('formulirinvbarang_id = '.$this->formulirinvbarang_id);
		}
		$criteria->compare('LOWER(forminvbarang_no)',strtolower($this->forminvbarang_no),true);
		$criteria->compare('LOWER(forminvbarang_tgl)',strtolower($this->forminvbarang_tgl),true);
		$criteria->compare('forminvbarang_totalvolume',$this->forminvbarang_totalvolume);
		$criteria->compare('forminvbarang_totalharga',$this->forminvbarang_totalharga);
		if(!empty($this->forminvbarangdet_id)){
			$criteria->addCondition('forminvbarangdet_id = '.$this->forminvbarangdet_id);
		}
		$criteria->compare('volume_inventaris',$this->volume_inventaris);

		$criteria->limit=10;

		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
		));
	}


        public function searchMaterialRusakTable() {
            $criteria = new CDbCriteria();
            $criteria = $this->functionMaterialRusakCriteria();
            $criteria->order = 'invbarang_tgl DESC';
			$criteria->limit = 10;

            return new CActiveDataProvider($this, array(
                        'criteria' => $criteria,
                    ));
        }

        public function searchMaterialRusakPrint() {
            $criteria = new CDbCriteria();
            $criteria = $this->functionMaterialRusakCriteria();
            $criteria->order = 'invbarang_tgl DESC';
            $criteria->limit = -1;

            return new CActiveDataProvider($this, array(
                        'criteria' => $criteria,
                        'pagination' => false,
                    ));
        }

        protected function functionMaterialRusakCriteria() {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria = new CDbCriteria;

            $criteria->addBetweenCondition('invbarang_tgl',$this->tgl_awal,$this->tgl_akhir,true);
            $criteria->addCondition(" kondisi_barang <> 'Baik' ");

            if (!empty($this->kondisi_barang))
            {
                $criteria->addInCondition('kondisi_barang', $this->kondisi_barang);
            }


            return $criteria;
        }

         public function searchMaterialRusakGrafik()
         {
                    // Warning: Please modify the following code to remove attributes that
                    // should not be searched.

                $criteria=new CDbCriteria;

                $criteria->select = 'count(invbarang_id) as jumlah, kondisi_barang as data';
                $criteria->group = 'invbarang_id, kondisi_barang';
                $criteria->addBetweenCondition('invbarang_tgl',$this->tgl_awal,$this->tgl_akhir,true);
                $criteria->addCondition(" kondisi_barang <> 'Baik' ");

                if (!empty($this->kondisi_barang))
                {
                    $criteria->addInCondition('kondisi_barang', $this->kondisi_barang);
                }



                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                ));
        }

        public function namaBarang($invbarangdet_id) {
            $nama = "";
            if(!empty($invbarangdet_id)){
                $modInvDet = InvbarangdetT::model()->findByPk($invbarangdet_id);
                if(!empty($modInvDet)){
                    $nama = !empty($modInvDet->barang_id) ? $modInvDet->barang->barang_nama : "";
                }
            }
            return $nama;
        }

}
