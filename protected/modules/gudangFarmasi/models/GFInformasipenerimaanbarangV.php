<?php
class GFInformasipenerimaanbarangV extends InformasipenerimaanbarangV
{
        public $tgl_awal;
        public $tgl_akhir;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InformasipenerimaanbarangV the static model class
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
		$criteria->join = " LEFT JOIN penerimaanbarang_t pb ON pb.penerimaanbarang_id = t.penerimaanbarang_id "
						. "	LEFT JOIN fakturpembelian_t fp ON fp.fakturpembelian_id = t.fakturpembelian_id "
						. " LEFT JOIN permintaanpembelian_t pe ON pe.permintaanpembelian_id = t.permintaanpembelian_id";
                
		$criteria->addBetweenCondition('DATE(t.tglterima)',$this->tgl_awal,$this->tgl_akhir,true);
		if(!empty($this->penerimaanbarang_id)){
			$criteria->addCondition('t.penerimaanbarang_id = '.$this->penerimaanbarang_id);
		}
		$criteria->compare('LOWER(t.noterima)',strtolower($this->noterima),true);		
		$criteria->compare('t.tglterimafaktur',$this->tglterimafaktur,true);
		$criteria->compare('LOWER(t.nofaktur)',strtolower($this->nofaktur),true);
		$criteria->compare('t.tglfaktur',$this->tglfaktur,true);
		$criteria->compare('t.tgljatuhtempo',$this->tgljatuhtempo,true);
		$criteria->compare('t.keteranganfaktur',$this->keteranganfaktur,true);
		$criteria->compare('LOWER(t.nosuratjalan)',strtolower($this->nosuratjalan),true);
		$criteria->compare('t.tglsuratjalan',$this->tglsuratjalan,true);
		
		if(!empty($this->supplier_id)){
			$criteria->addCondition('t.supplier_id = '.$this->supplier_id);
		}
		if(!empty($this->gudangpenerima_id)){
			$criteria->addCondition('t.gudangpenerima_id = '.$this->gudangpenerima_id);
		}
                if(!empty($this->pegawaimengetahui_id)){
			$criteria->addCondition('t.pegawaimengetahui_id = '.$this->pegawaimengetahui_id);
		}
		if(!empty($this->pegawaimenyetujui_id)){
			$criteria->addCondition('t.pegawaimenyetujui_id = '.$this->pegawaimenyetujui_id);
		}
		
		if(!empty($this->pegawaipenerima_id)){
			$criteria->addCondition('pb.pegawai_id = '.$this->pegawaipenerima_id);
		}
		
		$criteria->compare('LOWER(t.statuspenerimaan)',strtolower($this->statuspenerimaan),true);
		
		if (!empty($this->statusFaktur)){
			if ($this->statusFaktur == 1){
				$criteria->addCondition(" t.fakturpembelian_id IS NOT NULL ");
			}elseif ($this->statusFaktur == 2){
				$criteria->addCondition(" t.fakturpembelian_id IS NULL ");
			}
		}
		
		if (!empty($this->statusBayar)){
			if ($this->statusBayar == 1){
				$criteria->addCondition(" fp.bayarkesupplier_id IS NOT NULL ");
			}elseif ($this->statusBayar == 2){
				$criteria->addCondition(" fp.bayarkesupplier_id IS NULL ");
			}
		}
		
		$criteria->order = " tglterima DESC ";  
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        public function searchDialog()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		
		if(!empty($this->penerimaanbarang_id)){
			$criteria->addCondition('t.penerimaanbarang_id = '.$this->penerimaanbarang_id);
		}
		$criteria->compare('LOWER(t.noterima)',strtolower($this->noterima),true);		
		$criteria->compare('t.tglterimafaktur',$this->tglterimafaktur,true);
		$criteria->compare('LOWER(t.nofaktur)',strtolower($this->nofaktur),true);
		$criteria->compare('t.tglfaktur',$this->tglfaktur,true);
		$criteria->compare('t.tgljatuhtempo',$this->tgljatuhtempo,true);
		$criteria->compare('t.keteranganfaktur',$this->keteranganfaktur,true);
		$criteria->compare('LOWER(t.nosuratjalan)',strtolower($this->nosuratjalan),true);
		$criteria->compare('t.tglsuratjalan',$this->tglsuratjalan,true);
		// $criteria->addCondition("t.statuspenerimaan = 'DISETUJUI'",'OR');

		$criteria2 = new CDbCriteria();
		$criteria2->addCondition("t.statuspenerimaan = 'DISETUJUI'");
		$criteria2->addCondition("t.statuspenerimaan = 'PENERIMAAN LANGSUNG'",'OR');
		$criteria->mergeWith($criteria2);

		if(!empty($this->supplier_id)){
			$criteria->addCondition('t.supplier_id = '.$this->supplier_id);
		}
		if(!empty($this->gudangpenerima_id)){
			$criteria->addCondition('t.gudangpenerima_id = '.$this->gudangpenerima_id);
		}
                
		$criteria->addCondition('t.fakturpembelian_id is null');
		$criteria->compare('LOWER(t.statuspenerimaan)',strtolower($this->statuspenerimaan),true);
		$criteria->join = " LEFT JOIN penerimaanbarang_t pb ON pb.penerimaanbarang_id = t.penerimaanbarang_id "
						. " LEFT JOIN pegawai_m p ON p.pegawai_id = pb.pegawai_id ";
		if(!empty($this->pegawaipenerima_nama)){
			$criteria->addCondition("p.nama_pegawai ilike '%".$this->pegawaipenerima_nama."%' ");
		}
		
		$criteria->order = " t.tglterima DESC ";
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public function getPegawaimengetahuiLengkap()
        {
            return (isset($this->pegawaimengetahui_gelardepan) ? $this->pegawaimengetahui_gelardepan : "").' '.$this->pegawaimengetahui_nama.(isset($this->pegawaimengetahui_gelarbelakang) ? ', '.$this->pegawaimengetahui_gelardepan : "");
        }

        public function getPegawaimenyetujuiLengkap()
        {
            return (isset($this->pegawaimenyetujui_gelardepan) ? $this->pegawaimenyetujui_gelardepan : "").' '.$this->pegawaimenyetujui_nama.(isset($this->pegawaimenyetujui_gelarbelakang) ? ', '.$this->pegawaimenyetujui_gelardepan : "");
        }
		
        public function getJmlTerima()
        {
			$return = 0;
			$modPenerimaanDetails = GFPenerimaanDetailT::model()->findAllByAttributes(array('penerimaanbarang_id'=>$this->penerimaanbarang_id));
			if(count((array)$modPenerimaanDetails)>0){
				foreach($modPenerimaanDetails as $i => $modPenerimaanDetail){
					$return += $modPenerimaanDetail->jmlterima;
				}
			}
            return $return;
        }
}