<?php

class ADPermintaanPenawaranT extends PermintaanpenawaranT
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PermintaanpenawaranT the static model class
	 */
        public $tgl_awal,$tgl_akhir;
        public $pegawaimengetahui_nama;
        public $pegawaimenyetujui_nama;
        public $jns_periode;
        public $bln_awal, $bln_akhir, $thn_awal, $thn_akhir;
        public $total_harganetto;
        public $data, $jumlah;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public function searchPermintaanPembelian()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

//		$criteria->compare('date(tglpenawaran)',$this->tglpenawaran);
		$criteria->compare('LOWER(nosuratpenawaran)',strtolower($this->nosuratpenawaran),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
	public function searchInformasi()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
                           
		$criteria->with = array('supplier','permintaanpembelian');
		$criteria->addBetweenCondition('date(tglpenawaran)',$this->tgl_awal,$this->tgl_akhir);
		$criteria->compare('LOWER(nosuratpenawaran)',strtolower($this->nosuratpenawaran),true);
		if(!empty($this->supplier_id)){
			$criteria->addCondition('t.supplier_id = '.$this->supplier_id);
		}
		$criteria->addCondition("permintaanpembelian.permintaanpembelian_id is null");
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrintPermintaanPenawaran()
        {
            $criteria=new CDbCriteria;

            $criteria->select = 't.supplier_id, t.permintaanpenawaran_id, supplier_m.supplier_nama, supplier_m.supplier_alamat, t.nosuratpenawaran, t.tglpenawaran,
                                                     sum(penawarandetail_t.qty * penawarandetail_t.harganetto) as total_harganetto
                                                     ';
            $criteria->group = 't.supplier_id, t.permintaanpenawaran_id, supplier_m.supplier_nama, supplier_m.supplier_alamat, t.nosuratpenawaran, t.tglpenawaran';
            $criteria->addBetweenCondition('date(t.tglpenawaran)',$this->tgl_awal,$this->tgl_akhir);
            $criteria->compare('LOWER(t.nosuratpenawaran)',strtolower($this->nosuratpenawaran),true);
            if(!empty($this->supplier_id)){
                    $criteria->addInCondition('t.supplier_id', $this->supplier_id);
            }
            $criteria->compare('t.create_ruangan', Yii::app()->user->getState('ruangan_id'));
            // $criteria->addCondition('t.penerimaanbarang_id is null');
            $criteria->addCondition("supplier_m.supplier_jenis='Farmasi'");
            $criteria->join = 'LEFT JOIN supplier_m ON t.supplier_id = supplier_m.supplier_id
                                               LEFT JOIN penawarandetail_t ON t.permintaanpenawaran_id = penawarandetail_t.permintaanpenawaran_id
                                            ';
            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
        }
        
        public function searchPermintaanPenawaran()
        {
            $criteria=new CDbCriteria;

            $criteria->select = 't.supplier_id, t.permintaanpenawaran_id, supplier_m.supplier_nama, supplier_m.supplier_alamat, t.nosuratpenawaran, t.tglpenawaran,
                                                     sum(penawarandetail_t.qty * penawarandetail_t.harganetto) as total_harganetto
                                                     ';
            $criteria->group = 't.supplier_id, t.permintaanpenawaran_id, supplier_m.supplier_nama, supplier_m.supplier_alamat, t.nosuratpenawaran, t.tglpenawaran';
            $criteria->addBetweenCondition('date(t.tglpenawaran)',$this->tgl_awal,$this->tgl_akhir);
            $criteria->compare('LOWER(t.nosuratpenawaran)',strtolower($this->nosuratpenawaran),true);
            if(!empty($this->supplier_id)){
                    $criteria->addCondition('t.supplier_id = '.$this->supplier_id);
            }
            $criteria->compare('t.create_ruangan', Yii::app()->user->getState('ruangan_id'));
            // $criteria->addCondition('t.penerimaanbarang_id is null');
            $criteria->addCondition("supplier_m.supplier_jenis='Farmasi'");
            $criteria->join = 'LEFT JOIN supplier_m ON t.supplier_id = supplier_m.supplier_id
                                               LEFT JOIN penawarandetail_t ON t.permintaanpenawaran_id = penawarandetail_t.permintaanpenawaran_id
                                            ';
            
            $criteria->limit = -1;
            
            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
        }
        
        public function searchGrafik()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
//                $criteria->with = 'supplier';
		$criteria->select = 'COUNT(t.supplier_id) as jumlah, supplier_m.supplier_nama as data';
		$criteria->group = 't.supplier_id, supplier_m.supplier_nama';
		$criteria->addBetweenCondition('date(t.tglpenawaran)',$this->tgl_awal,$this->tgl_akhir);
				
		$criteria->compare('LOWER(t.nosuratpenawaran)',strtolower($this->nosuratpenawaran),true);
		if(!empty($this->supplier_id)){
			$criteria->addInCondition('t.supplier_id', $this->supplier_id);
		}
                /*
		if(!empty($this->syaratbayar_id)){
			$criteria->addCondition('t.syaratbayar_id = '.$this->syaratbayar_id);
		}
                 * 
                 */
		// $criteria->addCondition('t.penerimaanbarang_id is null');
		//$criteria->addCondition("supplier.supplier_jenis='Farmasi'");
		$criteria->join = 'LEFT JOIN supplier_m ON t.supplier_id = supplier_m.supplier_id';
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

}