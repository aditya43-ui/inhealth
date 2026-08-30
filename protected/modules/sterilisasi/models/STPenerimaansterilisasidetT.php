<?php
class STPenerimaansterilisasidetT extends PenerimaansterilisasidetT{
	public $tgl_awal,$tgl_akhir,$instalasi_id,$ruangan_id,$penerimaansterilisasi_no;
	public $barang_nama,$ruangan_nama,$bahansterilisasi_nama, $pengajuansterlilisasi_id;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function searchPenerimaanSterilisasi()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->select = 'penerimaansterilisasi_t.*,t.*';
		
		$criteria->addBetweenCondition('DATE(penerimaansterilisasi_t.penerimaansterilisasi_tgl)', $this->tgl_awal, $this->tgl_akhir,true);
		if(!empty($this->penerimaansterilisasi_no)){
			$criteria->compare('LOWER(penerimaansterilisasi_t.penerimaansterilisasi_no',strtolower($this->penerimaansterilisasi_no),true);
		}
		if(!empty($this->penerimaansterilisasidet_id)){
			$criteria->addCondition('penerimaansterilisasidet_id = '.$this->penerimaansterilisasidet_id);
		}
		if(!empty($this->linen_id)){
			$criteria->addCondition('t.linen_id = '.$this->linen_id);
		}
		if(!empty($this->penerimaansterilisasi_id)){
			$criteria->addCondition('t.penerimaansterilisasi_id = '.$this->penerimaansterilisasi_id);
		}
		if(!empty($this->barang_id)){
			$criteria->addCondition('t.barang_id = '.$this->barang_id);
		}
		if(!empty($this->penerimaansterilisasidet_jml)){
			$criteria->addCondition('t.penerimaansterilisasidet_jml = '.$this->penerimaansterilisasidet_jml);
		}
		$criteria->compare('LOWER(penerimaansterilisasidet_ket)',strtolower($this->penerimaansterilisasidet_ket),true);
		$criteria->join = 'JOIN penerimaansterilisasi_t ON penerimaansterilisasi_t.penerimaansterilisasi_id = t.penerimaansterilisasi_id';
		$criteria->limit=10;

		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
		));
	}
}

