<?php
class STPenerimaansterilisasiT extends PenerimaansterilisasiT{
	public $tgl_awal, $tgl_akhir;
	public $pegawaipenerima_nama, $pegawaimengetahui_nama, $instalasi_id;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function searchInformasi()
	{
		$criteria=new CDbCriteria;
                $criteria->join = " left JOIN (select t.penerimaansterilisasi_id, t.keadaanperalatan from penerimaansterilisasidet_t t "
                        . "where t.keadaanperalatan = '".".Params::JENISPERAWATAN_KEHILANGAN."."' "
                        . "group by t.penerimaansterilisasi_id, t.keadaanperalatan) AS d ON d.penerimaansterilisasi_id = t.penerimaansterilisasi_id";
		$criteria->addBetweenCondition('DATE(t.penerimaansterilisasi_tgl)', $this->tgl_awal, $this->tgl_akhir);
		$criteria->compare('LOWER(t.penerimaansterilisasi_no)',strtolower($this->penerimaansterilisasi_no),true);
		if(!empty($this->ruangan_id)){
			$criteria->addCondition('t.ruangan_id = '.$this->ruangan_id);
		}
        $criteria->addCondition(" d.keadaanperalatan is null");
		$criteria->limit=10;

		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
		));
	}
        
        public function searchInformasiKehilangan()
	{
		$criteria=new CDbCriteria;
                $criteria->join = " left JOIN (select t.penerimaansterilisasi_id, t.keadaanperalatan from penerimaansterilisasidet_t t "
                        . "where t.keadaanperalatan = '".Params::JENISPERAWATAN_KEHILANGAN."' "
                        . "group by t.penerimaansterilisasi_id, t.keadaanperalatan) AS d ON d.penerimaansterilisasi_id = t.penerimaansterilisasi_id";
		$criteria->addBetweenCondition('DATE(t.penerimaansterilisasi_tgl)', $this->tgl_awal, $this->tgl_akhir);
		$criteria->compare('LOWER(t.penerimaansterilisasi_no)',strtolower($this->penerimaansterilisasi_no),true);
		if(!empty($this->ruangan_id)){
			$criteria->addCondition('t.ruangan_id = '.$this->ruangan_id);
		}
            $criteria->addCondition(" d.keadaanperalatan is not null");
		$criteria->limit=10;
        
		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
		));
	}
}

