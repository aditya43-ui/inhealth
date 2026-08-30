<?php
class AGInformasialokasianggaranV extends InformasialokasianggaranV
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InformasialokasianggaranV the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function searchProgramKerja()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		if(!empty($this->programkerja_id)){
			$criteria->addCondition('t.programkerja_id = '.$this->programkerja_id);
		}
		$criteria->compare('LOWER(t.programkerja_nama)',strtolower($this->programkerja_nama),true);
		$criteria->compare('LOWER(t.programkerja_kode)',strtolower($this->programkerja_kode),true);
		if(!empty($this->subprogramkerja_id)){
			$criteria->addCondition('t.subprogramkerja_id = '.$this->subprogramkerja_id);
		}
		$criteria->compare('LOWER(t.subprogramkerja_nama)',strtolower($this->subprogramkerja_nama),true);
		$criteria->compare('LOWER(t.subprogramkerja_kode)',strtolower($this->subprogramkerja_kode),true);
		if(!empty($this->kegiatanprogram_id)){
			$criteria->addCondition('t.kegiatanprogram_id = '.$this->kegiatanprogram_id);
		}
		$criteria->compare('LOWER(t.kegiatanprogram_nama)',strtolower($this->kegiatanprogram_nama),true);
		$criteria->compare('LOWER(t.kegiatanprogram_kode)',strtolower($this->kegiatanprogram_kode),true);
		if(!empty($this->subkegiatanprogram_id)){
			$criteria->addCondition('t.subkegiatanprogram_id = '.$this->subkegiatanprogram_id);
		}
		$criteria->compare('LOWER(t.subkegiatanprogram_nama)',strtolower($this->subkegiatanprogram_nama),true);
		$criteria->compare('LOWER(t.subkegiatanprogram_kode)',strtolower($this->subkegiatanprogram_kode),true);
		$criteria->compare('t.nilaiygdisetujui',$this->nilaiygdisetujui);
		if(!empty($this->unitkerja_id)){
			$criteria->addCondition('t.unitkerja_id = '.$this->unitkerja_id);
		}		
		$criteria->compare('LOWER(t.namaunitkerja)',strtolower($this->namaunitkerja),true);
		$criteria->compare('LOWER(t.tglapprrencanggaran)',strtolower($this->tglapprrencanggaran),true);
//		if(!empty($this->statusalokasi)){
		//	$criteria->addCondition('statusalokasi is false or statusalokasi is null');
//		}
			
		//$criteria->limit=10;

		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
		));
	}
        
        public function searchProgramKerjaAlokasi() {
            $provider = $this->searchProgramKerja();
            $provider->criteria->addCondition('t.statusalokasi = false or statusalokasi is null');
        
            return $provider;
        }
        
        public function searchProgramKerjaRealisasi() {
            $provider = $this->searchProgramKerja();
            $provider->criteria->addCondition('t.statusalokasi = true');
			$provider->criteria->addCondition("p.realisasianggpeng_id is null");
			$provider->criteria->join = "left join realisasianggpeng_t p on p.alokasianggaran_id = t.alokasianggaran_id";
        
            return $provider;
        }

}