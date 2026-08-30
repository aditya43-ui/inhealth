<?php

class GUInfoinventarisasiruanganV extends InfoinventarisasiruanganV {

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InfoinventarisasibarangV the static model class
	 */

	public $checklist, $invbarang_jenis, $tgl_awal, $tgl_akhir, $qtystok, $invbarangdet_id, $barang_harganetto, $inventarisasi;
    public $jenisbarang_id, $barang_type;

	public static function model($className = __CLASS__) {
		return parent::model($className);
	}


	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'inventarisasi_id' => 'Inventarisasi',
			'tgltransaksi' => 'Tgl. Transaksi',
			'inventarisasi_kode' => 'Inventarisasi Kode',
			'inventarisasi_hargabeli' => 'Harga Beli',
			'inventarisasi_hargasatuan' => 'Harga Satuan',
			'inventarisasi_qty_in' => 'Qty In',
			'inventarisasi_qty_out' => 'Qty Out',
			'inventarisasi_qty_skrg' => 'Qty Skrg',
			'inventarisasi_jmlmin' => 'Jml Min',
			'inventarisasi_keadaan' => 'Keadaan',
			'inventarisasi_keterangan' => 'Keterangan',
			'barang_id' => 'Barang',
			'barang_nama' => 'Nama Barang',
			'barang_namalainnya' => 'Nama Barang Lainnya',
			'barang_merk' => 'Merk',
			'barang_noseri' => 'No Seri',
			'barang_ukuran' => 'Ukuran',
			'barang_bahan' => 'Bahan',
			'barang_kode' => 'Kode',
			'barang_type' => 'Type',
			'barang_ppn' => 'PPN',
			'barang_hpp' => 'Hpp',
			'ruangan_id' => 'Ruangan',
			'ruangan_nama' => 'Nama Ruangan',
			'ruangan_namalainnya' => 'Ruangan Nama lainnya',
			'barang_thnbeli' => 'Tahun Beli',
			'barang_warna' => 'Warna',
			'barang_ekonomis_thn' => 'Tahun Ekonomis',
			'barang_statusregister' => 'Status Register',
			'barang_satuan' => 'Satuan',
			'barang_jmldlmkemasan' => 'Jml dalam kemasan',
                        'subsubkelompok_id' => 'Sub Sub Kelompok',
                        'subsubkelompok_nama' => 'Sub Sub Kelompok',
                        'subkelompok_id' => 'Sub Kelompok',
                        'subkelompok_nama' => 'Sub Kelompok',
                        'kelompok_id' => 'Kelompok',
                        'kelompok_nama' => 'Kelompok',
                        'bidang_id' => 'Bidang',
                        'bidang_nama' => 'Bidang',
                        'golongan_id' => 'Golongan',
                        'golongan_nama' => 'Golongan',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function searchBarangInventarisasi() {
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria = new CDbCriteria;
		$criteria->limit = 1000;
        $criteria->order = 'barang_nama asc';
//        $criteria->select = 't.invbarangdet_id, t.inventarisasi_id, t.barang_id, t.barang_kode, t.barang_nama, t.barang_merk, t.barang_noseri, t.inventarisasi_hargasatuan, t.inventarisasi_hargasatuan'
		if (!Yii::app()->request->isAjaxRequest) {//data hanya muncul setelah melakukan pencarian
			$criteria->limit = 0;
		}
		if (!empty($this->invbarang_id)) {
			$criteria->addCondition('invbarang_id = ' . $this->invbarang_id);
		}


		if (isset($_GET['invbarang_id'])) {
			$model = new GUInvbarangdetT;
            $criteria->join .= " join barang_m b on b.barang_id = t.barang_id"
                    . " left join inventarisasiruangan_t inventarisasi on inventarisasi.inventarisasi_id = t.inventarisasi_id";
			//$criteria->with = array('inventarisasi');
			$criteria->addCondition('t.invbarang_id = ' . $_GET['invbarang_id']);
			$criteria->limit = -1;
		} else {
			$abrg = null;
			if (isset($_GET['formulirinvbarang_id'])) {
				$fr = GUForminvbarangdetR::model()->findAllByAttributes(array(
					'formulirinvbarang_id'=>$_GET['formulirinvbarang_id']
				));
				$abrg = array();
				foreach ($fr as $item) {
					array_push($abrg, $item->barang_id);
				}

				$this->invbarang_jenis = Params::DEFAULT_JENISINVENTARISASI;
				$criteria->compare('t.ruangan_id', Yii::app()->user->getState('ruangan_id'));
				$criteria->addCondition('(t.inventarisasi_qty_in - t.inventarisasi_qty_out) > 0');
				$criteria->limit = -1;
				//$model = new GUForminvbarangdetR;
				//$criteria->addCondition('formulirinvbarang_id = ' . $_GET['formulirinvbarang_id']);
				//$criteria->addCondition('invbarangdet_id IS NULL');
				//$criteria->limit = -1;
			} //else

			$this->barang_id = $abrg;
			if (!empty($this->barang_id)) {
				$criteria->compare('t.barang_id', $this->barang_id);
			}

            $criteria->join = 'join barang_m b on b.barang_id = t.barang_id';
			$criteria->compare('LOWER(t.barang_kode)', strtolower($this->barang_kode), true);
			$criteria->compare('LOWER(t.barang_nama)', strtolower($this->barang_nama), true);
			$criteria->compare('LOWER(t.barang_noseri)', strtolower($this->barang_noseri), true);
			$criteria->compare('LOWER(t.barang_merk)', strtolower($this->barang_merk), true);
			$criteria->compare('LOWER(t.barang_satuan)', strtolower($this->barang_satuan), true);
			$criteria->compare('b.jenisbarang_id', $this->jenisbarang_id);
			$criteria->compare('LOWER(b.barang_type)', strtolower($this->barang_type), true);

                        $criteria->compare('t.golongan_id', $this->golongan_id);
                        $criteria->compare('t.bidang_id', $this->bidang_id);
                        $criteria->compare('t.kelompok_id', $this->kelompok_id);
                        $criteria->compare('t.subkelompok_id', $this->subkelompok_id);
                        $criteria->compare('t.subsubkelompok_id', $this->subsubkelompok_id);

			if ($this->invbarang_jenis == Params::DEFAULT_JENISINVENTARISASI) {
                $criteria->join .= ' left join (select inventarisasiruanganasal_id as inventarisasi_id, sum(inventarisasi_qty_out - inventarisasi_qty_in) as inventarisasi_qty_out from inventarisasiruangan_t'
                        . ' where inventarisasiruanganasal_id is not null group by inventarisasiruanganasal_id) a on a.inventarisasi_id = t.inventarisasi_id ';

                $criteria->select = 't.*, t.inventarisasi_qty_in - (case when a.inventarisasi_qty_out is null then 0 else a.inventarisasi_qty_out end) as inventarisasi_qty_skrg';

                $criteria->compare('LOWER(t.inventarisasi_kode)', strtolower($this->inventarisasi_kode), true);
				$criteria->compare('t.ruangan_id', strtolower(Yii::app()->user->getState('ruangan_id')));
                $criteria->addCondition('t.inventarisasiruanganasal_id is null');
                $criteria->addCondition('t.inventarisasiruangan_aktif = true');
                // $criteria->addCondition('(t.inventarisasi_qty_in - (t.inventarisasi_qty_out + a.inventarisasi_qty_out)) <> 0');
				$model = $this;
			} else {
				$model = new GUBarangV();
        $criteria->join = "  LEFT JOIN infoinventarisasiruangan_v info ON info.barang_id = t.barang_id AND info.ruangan_id = '".Yii::app()->user->getState('ruangan_id')."' "
                        . "  JOIN barang_m b ON b.barang_id = t.barang_id ";
        $criteria->addCondition(" info.barang_id is null  ");
//                             if ($this->invbarang_jenis == Params::DEFAULT_JENISINVENTARISASI_STOKAWAL) {
// //                                $criteria->select = 't.invbarangdet_id, t.inventarisasi_id, t.barang_id, t.barang_kode, t.barang_nama, t.barang_merk, t.barang_noseri, t.inventarisasi_hargasatuan, t.inventarisasi_hargasatuan, t.volume_sistem, t.inventarisasi_qty_skrg, t.barang_satuan, inventarisasi.volume_fisik, ';
// //                                $criteria->group = $criteria->select;
// $criteria->join = "  LEFT JOIN infoinventarisasiruangan_v info ON info.barang_id = t.barang_id AND info.ruangan_id = '".Yii::app()->user->getState('ruangan_id')."' "
// 								. "  JOIN barang_m b ON b.barang_id = t.barang_id ";
//                                 $criteria->addCondition("invb.invbarang_jenis IS NULL");
//                             }
// 				$model = new GUBarangV();
			}
		}
		
		return new CActiveDataProvider($model, array(
			'criteria' => $criteria,
			'pagination' => false,
		));
	}

}
