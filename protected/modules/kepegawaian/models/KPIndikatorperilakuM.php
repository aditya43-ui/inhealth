<?php

class KPIndikatorperilakuM extends IndikatorperilakuM
{
    public $bobot_penilaian;
    /**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return IndikatorperilakuM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function criteriaSearch()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		if(!empty($this->indikatorperilaku_id)){
			$criteria->addCondition('indikatorperilaku_id = '.$this->indikatorperilaku_id);
		}
		if(!empty($this->jabatan_id)){
			$criteria->addCondition('jabatan_id = '.$this->jabatan_id);
		}
		if(!empty($this->kompetensi_id)){
			$criteria->addCondition('kompetensi_id = '.$this->kompetensi_id);
		}
		if(!empty($this->jenispenilaian_id)){
			$criteria->addCondition('jenispenilaian_id = '.$this->jenispenilaian_id);
		}
		$criteria->compare('LOWER(indikatorperilaku_nama)',strtolower($this->indikatorperilaku_nama),true);
		$criteria->compare('LOWER(indikatorperilaku_namalain)',strtolower($this->indikatorperilaku_namalain),true);
		//$criteria->compare('indikatorperilaku_aktif',$this->indikatorperilaku_aktif);
		$criteria->compare('indikatorperilaku_aktif',isset($this->indikatorperilaku_aktif)?$this->indikatorperilaku_aktif:true);
                $criteria->compare('bobotnilai_indikator',$this->bobotnilai_indikator);
		return $criteria;
	}
}