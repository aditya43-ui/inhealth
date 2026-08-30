<?php

class AGRekeninganggaranV extends RekeninganggaranV {
	public $programkerja_namalain;
	public $nilairencpengeluaran,$tglrencanapengdet,$no_urut,$rencanggaranpengdet_id,$approve,$i,$apprrencanggaran_id;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function searchByFilter()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		if(!empty($this->programkerja_id)){
			$criteria->addCondition('programkerja_id = '.$this->programkerja_id);
		}
		$criteria->compare('LOWER(programkerja_kode)',strtolower($this->programkerja_kode),true);
		$criteria->compare('LOWER(programkerja_nama)',strtolower($this->programkerja_nama),true);
		$criteria->compare('LOWER(programkerja_ket)',strtolower($this->programkerja_ket),true);
		if(!empty($this->programkerja_nourut)){
			$criteria->addCondition('programkerja_nourut = '.$this->programkerja_nourut);
		}
		if(!empty($this->subprogramkerja_id)){
			$criteria->addCondition('subprogramkerja_id = '.$this->subprogramkerja_id);
		}
		$criteria->compare('LOWER(subprogramkerja_kode)',strtolower($this->subprogramkerja_kode),true);
		$criteria->compare('LOWER(subprogramkerja_nama)',strtolower($this->subprogramkerja_nama),true);
		$criteria->compare('LOWER(subprogramkerja_ket)',strtolower($this->subprogramkerja_ket),true);
		if(!empty($this->subprogramkerja_nourut)){
			$criteria->addCondition('subprogramkerja_nourut = '.$this->subprogramkerja_nourut);
		}
		if(!empty($this->kegiatanprogram_id)){
			$criteria->addCondition('kegiatanprogram_id = '.$this->kegiatanprogram_id);
		}
		$criteria->compare('LOWER(kegiatanprogram_kode)',strtolower($this->kegiatanprogram_kode),true);
		$criteria->compare('LOWER(kegiatanprogram_nama)',strtolower($this->kegiatanprogram_nama),true);
		$criteria->compare('LOWER(kegiatanprogram_ket)',strtolower($this->kegiatanprogram_ket),true);
		if(!empty($this->kegiatanprogram_nourut)){
			$criteria->addCondition('kegiatanprogram_nourut = '.$this->kegiatanprogram_nourut);
		}
		if(!empty($this->subkegiatanprogram_id)){
			$criteria->addCondition('subkegiatanprogram_id = '.$this->subkegiatanprogram_id);
		}
		$criteria->compare('LOWER(subkegiatanprogram_kode)',strtolower($this->subkegiatanprogram_kode),true);
		$criteria->compare('LOWER(subkegiatanprogram_nama)',strtolower($this->subkegiatanprogram_nama),true);
		$criteria->compare('LOWER(subkegiatanprogram_ket)',strtolower($this->subkegiatanprogram_ket),true);
		if(!empty($this->subkegiatanprogram_nourut)){
			$criteria->addCondition('subkegiatanprogram_nourut = '.$this->subkegiatanprogram_nourut);
		}
		if(!empty($this->rekening1debit_id)){
			$criteria->addCondition('rekening1debit_id = '.$this->rekening1debit_id);
		}
		$criteria->compare('LOWER(rekening1debit_kode)',strtolower($this->rekening1debit_kode),true);
		$criteria->compare('LOWER(rekening1debit_nama)',strtolower($this->rekening1debit_nama),true);
		if(!empty($this->rekening2debit_id)){
			$criteria->addCondition('rekening2debit_id = '.$this->rekening2debit_id);
		}
		$criteria->compare('LOWER(rekening2debit_kode)',strtolower($this->rekening2debit_kode),true);
		$criteria->compare('LOWER(rekening2debit_nama)',strtolower($this->rekening2debit_nama),true);
		if(!empty($this->rekening3debit_id)){
			$criteria->addCondition('rekening3debit_id = '.$this->rekening3debit_id);
		}
		$criteria->compare('LOWER(rekening3debit_kode)',strtolower($this->rekening3debit_kode),true);
		$criteria->compare('LOWER(rekening3debit_nama)',strtolower($this->rekening3debit_nama),true);
		if(!empty($this->rekening4debit_id)){
			$criteria->addCondition('rekening4debit_id = '.$this->rekening4debit_id);
		}
		$criteria->compare('LOWER(rekening4debit_kode)',strtolower($this->rekening4debit_kode),true);
		$criteria->compare('LOWER(rekening4debit_nama)',strtolower($this->rekening4debit_nama),true);
		if(!empty($this->rekening5debit_id)){
			$criteria->addCondition('rekening5debit_id = '.$this->rekening5debit_id);
		}
		$criteria->compare('LOWER(rekening5debit_kode)',strtolower($this->rekening5debit_kode),true);
		$criteria->compare('LOWER(rekening5debit_nama)',strtolower($this->rekening5debit_nama),true);
		if(!empty($this->rekening1kredit_id)){
			$criteria->addCondition('rekening1kredit_id = '.$this->rekening1kredit_id);
		}
		$criteria->compare('LOWER(rekening1kredit_kode)',strtolower($this->rekening1kredit_kode),true);
		$criteria->compare('LOWER(rekening1kredit_nama)',strtolower($this->rekening1kredit_nama),true);
		if(!empty($this->rekening2kredit_id)){
			$criteria->addCondition('rekening2kredit_id = '.$this->rekening2kredit_id);
		}
		$criteria->compare('LOWER(rekening2kredit_kode)',strtolower($this->rekening2kredit_kode),true);
		$criteria->compare('LOWER(rekening2kredit_nama)',strtolower($this->rekening2kredit_nama),true);
		if(!empty($this->rekening3kredit_id)){
			$criteria->addCondition('rekening3kredit_id = '.$this->rekening3kredit_id);
		}
		$criteria->compare('LOWER(rekening3kredit_kode)',strtolower($this->rekening3kredit_kode),true);
		$criteria->compare('LOWER(rekening3kredit_nama)',strtolower($this->rekening3kredit_nama),true);
		if(!empty($this->rekening4kredit_id)){
			$criteria->addCondition('rekening4kredit_id = '.$this->rekening4kredit_id);
		}
		$criteria->compare('LOWER(rekening4kredit_kode)',strtolower($this->rekening4kredit_kode),true);
		$criteria->compare('LOWER(rekening4kredit_nama)',strtolower($this->rekening4kredit_nama),true);
		if(!empty($this->rekening5kredit_id)){
			$criteria->addCondition('rekening5kredit_id = '.$this->rekening5kredit_id);
		}
		$criteria->compare('LOWER(rekening5kredit_kode)',strtolower($this->rekening5kredit_kode),true);
		$criteria->compare('LOWER(rekening5kredit_nama)',strtolower($this->rekening5kredit_nama),true);
		$criteria->order = 'programkerja_id,subprogramkerja_id,kegiatanprogram_id,subkegiatanprogram_id';
		
        return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
        ));
	}
	public function searchProgramKerja()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		if(!empty($this->programkerja_id)){
			$criteria->addCondition('programkerja_id = '.$this->programkerja_id);
		}
		$criteria->compare('LOWER(programkerja_kode)',strtolower($this->programkerja_kode),true);
		$criteria->compare('LOWER(programkerja_nama)',strtolower($this->programkerja_nama),true);
		$criteria->compare('LOWER(programkerja_ket)',strtolower($this->programkerja_ket),true);
		if(!empty($this->programkerja_nourut)){
			$criteria->addCondition('programkerja_nourut = '.$this->programkerja_nourut);
		}
		if(!empty($this->subprogramkerja_id)){
			$criteria->addCondition('subprogramkerja_id = '.$this->subprogramkerja_id);
		}
		$criteria->compare('LOWER(subprogramkerja_kode)',strtolower($this->subprogramkerja_kode),true);
		$criteria->compare('LOWER(subprogramkerja_nama)',strtolower($this->subprogramkerja_nama),true);
		$criteria->compare('LOWER(subprogramkerja_ket)',strtolower($this->subprogramkerja_ket),true);
		if(!empty($this->subprogramkerja_nourut)){
			$criteria->addCondition('subprogramkerja_nourut = '.$this->subprogramkerja_nourut);
		}
		if(!empty($this->kegiatanprogram_id)){
			$criteria->addCondition('kegiatanprogram_id = '.$this->kegiatanprogram_id);
		}
		$criteria->compare('LOWER(kegiatanprogram_kode)',strtolower($this->kegiatanprogram_kode),true);
		$criteria->compare('LOWER(kegiatanprogram_nama)',strtolower($this->kegiatanprogram_nama),true);
		$criteria->compare('LOWER(kegiatanprogram_ket)',strtolower($this->kegiatanprogram_ket),true);
		if(!empty($this->kegiatanprogram_nourut)){
			$criteria->addCondition('kegiatanprogram_nourut = '.$this->kegiatanprogram_nourut);
		}
		if(!empty($this->subkegiatanprogram_id)){
			$criteria->addCondition('subkegiatanprogram_id = '.$this->subkegiatanprogram_id);
		}
		$criteria->compare('LOWER(subkegiatanprogram_kode)',strtolower($this->subkegiatanprogram_kode),true);
		$criteria->compare('LOWER(subkegiatanprogram_nama)',strtolower($this->subkegiatanprogram_nama),true);
		$criteria->compare('LOWER(subkegiatanprogram_ket)',strtolower($this->subkegiatanprogram_ket),true);
		if(!empty($this->subkegiatanprogram_nourut)){
			$criteria->addCondition('subkegiatanprogram_nourut = '.$this->subkegiatanprogram_nourut);
		}
		if(!empty($this->rekening1debit_id)){
			$criteria->addCondition('rekening1debit_id = '.$this->rekening1debit_id);
		}
		$criteria->compare('LOWER(rekening1debit_kode)',strtolower($this->rekening1debit_kode),true);
		$criteria->compare('LOWER(rekening1debit_nama)',strtolower($this->rekening1debit_nama),true);
		if(!empty($this->rekening2debit_id)){
			$criteria->addCondition('rekening2debit_id = '.$this->rekening2debit_id);
		}
		$criteria->compare('LOWER(rekening2debit_kode)',strtolower($this->rekening2debit_kode),true);
		$criteria->compare('LOWER(rekening2debit_nama)',strtolower($this->rekening2debit_nama),true);
		if(!empty($this->rekening3debit_id)){
			$criteria->addCondition('rekening3debit_id = '.$this->rekening3debit_id);
		}
		$criteria->compare('LOWER(rekening3debit_kode)',strtolower($this->rekening3debit_kode),true);
		$criteria->compare('LOWER(rekening3debit_nama)',strtolower($this->rekening3debit_nama),true);
		if(!empty($this->rekening4debit_id)){
			$criteria->addCondition('rekening4debit_id = '.$this->rekening4debit_id);
		}
		$criteria->compare('LOWER(rekening4debit_kode)',strtolower($this->rekening4debit_kode),true);
		$criteria->compare('LOWER(rekening4debit_nama)',strtolower($this->rekening4debit_nama),true);
		if(!empty($this->rekening5debit_id)){
			$criteria->addCondition('rekening5debit_id = '.$this->rekening5debit_id);
		}
		$criteria->compare('LOWER(rekening5debit_kode)',strtolower($this->rekening5debit_kode),true);
		$criteria->compare('LOWER(rekening5debit_nama)',strtolower($this->rekening5debit_nama),true);
		if(!empty($this->rekening1kredit_id)){
			$criteria->addCondition('rekening1kredit_id = '.$this->rekening1kredit_id);
		}
		$criteria->compare('LOWER(rekening1kredit_kode)',strtolower($this->rekening1kredit_kode),true);
		$criteria->compare('LOWER(rekening1kredit_nama)',strtolower($this->rekening1kredit_nama),true);
		if(!empty($this->rekening2kredit_id)){
			$criteria->addCondition('rekening2kredit_id = '.$this->rekening2kredit_id);
		}
		$criteria->compare('LOWER(rekening2kredit_kode)',strtolower($this->rekening2kredit_kode),true);
		$criteria->compare('LOWER(rekening2kredit_nama)',strtolower($this->rekening2kredit_nama),true);
		if(!empty($this->rekening3kredit_id)){
			$criteria->addCondition('rekening3kredit_id = '.$this->rekening3kredit_id);
		}
		$criteria->compare('LOWER(rekening3kredit_kode)',strtolower($this->rekening3kredit_kode),true);
		$criteria->compare('LOWER(rekening3kredit_nama)',strtolower($this->rekening3kredit_nama),true);
		if(!empty($this->rekening4kredit_id)){
			$criteria->addCondition('rekening4kredit_id = '.$this->rekening4kredit_id);
		}
		$criteria->compare('LOWER(rekening4kredit_kode)',strtolower($this->rekening4kredit_kode),true);
		$criteria->compare('LOWER(rekening4kredit_nama)',strtolower($this->rekening4kredit_nama),true);
		if(!empty($this->rekening5kredit_id)){
			$criteria->addCondition('rekening5kredit_id = '.$this->rekening5kredit_id);
		}
		$criteria->compare('LOWER(rekening5kredit_kode)',strtolower($this->rekening5kredit_kode),true);
		$criteria->compare('LOWER(rekening5kredit_nama)',strtolower($this->rekening5kredit_nama),true);
		$criteria->order='subkegiatanprogram_nourut';
                $criteria->compare('subkegiatanprogram_aktif', $this->subkegiatanprogram_aktif);
        
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array('pageSize'=>5),
		));
	}
	
}

