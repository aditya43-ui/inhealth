<?php

class ADInformasirenkebbarangV extends InformasirenkebbarangV
{
	public $tgl_awal,$tgl_akhir;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function searchInformasi()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
                
		if (!empty($this->tgl_awal) && !empty($this->tgl_akhir)) {
			$criteria->addBetweenCondition('DATE(t.renkebbarang_tgl)',$this->tgl_awal,$this->tgl_akhir,true);
		}
                
                if (!empty($this->renkebbarang_tgl)){
                    $criteria->addBetweenCondition('t.renkebbarang_tgl',$this->renkebbarang_tgl,$this->renkebbarang_tgl);
                }
                
		$criteria->compare('LOWER(t.renkebbarang_no)',strtolower($this->renkebbarang_no),true);
		//$criteria->distinct="renkebbarang_no,renkebbarang_tgl,renkebbarang_id";
		if(!empty($this->pegmengetahui_id)){
			$criteria->addCondition('t.pegmengetahui_id = '.$this->pegmengetahui_id);
		}
		if(!empty($this->pegmenyetujui_id)){
			$criteria->addCondition('t.pegmenyetujui_id = '.$this->pegmenyetujui_id);
		}
		if(!empty($this->sumberdana_id)){
			$criteria->addCondition('t.sumberdana_id = '.$this->sumberdana_id);
		}
                
		$criteria->group="t.renkebbarang_no,t.renkebbarang_tgl,t.ro_barang_bulan,t.pegmengetahui_id,t.pegmenyetujui_id,t.renkebbarang_id, t.tglmenyetujui, t.sumberdana_nama";
		$criteria->select = $criteria->group;
		$criteria->order = "t.renkebbarang_tgl desc";
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function searchInformasiDialog()
	{
		$pr = $this->searchInformasi();
		
		$pr->criteria->join = "left join pembelianbarang_t p on p.renkebbarang_id = t.renkebbarang_id";
		$pr->criteria->addCondition("p.pembelianbarang_id is null");
		
		return $pr;
	}
	
	public static function pegawaimengetahui($pegmengetahui_id){
		$pegawaimengetahui = ADPegawaiM::model()->findBypk($pegmengetahui_id);
		return isset($pegawaimengetahui->nama_pegawai) ? $pegawaimengetahui->gelardepan.' '.$pegawaimengetahui->nama_pegawai : "";
	}

	public static function pegawaimenyetujui($pegmenyetujui_id){
		$pegawaimenyetujui = ADPegawaiM::model()->findBypk($pegmenyetujui_id);
		return isset($pegawaimenyetujui->nama_pegawai) ? $pegawaimenyetujui->gelardepan.' '.$pegawaimenyetujui->nama_pegawai : "";
	}
	
}