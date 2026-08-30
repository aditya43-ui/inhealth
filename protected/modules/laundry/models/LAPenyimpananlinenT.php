<?php
class LAPenyimpananlinenT extends PenyimpananlinenT
{
	public $pegmengetahui_nama;
	public $tgl_awal,$tgl_akhir,$instalasi_id,$ruangan_id;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PenyimpananlinenT the static model class
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
		
		$criteria->addBetweenCondition('DATE(tglpenyimpananlinen)',$this->tgl_awal,$this->tgl_akhir,true);
		if(!empty($this->penyimpananlinen_id)){
			$criteria->addCondition('penyimpananlinen_id = '.$this->penyimpananlinen_id);
		}
		$criteria->compare('LOWER(tglpenyimpananlinen)',strtolower($this->tglpenyimpananlinen),true);
		$criteria->compare('LOWER(nopenyimpananlinen)',strtolower($this->nopenyimpananlinen),true);
		$criteria->compare('LOWER(keterangan_penyimpanan)',strtolower($this->keterangan_penyimpanan),true);
		if(!empty($this->petugas_id)){
			$criteria->addCondition('petugas_id = '.$this->petugas_id);
		}
		if(!empty($this->pegmengetahui_id)){
			$criteria->addCondition('pegmengetahui_id = '.$this->pegmengetahui_id);
		}
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		if(!empty($this->create_loginpemakai_id)){
			$criteria->addCondition('create_loginpemakai_id = '.$this->create_loginpemakai_id);
		}
		if(!empty($this->update_loginpemakai_id)){
			$criteria->addCondition('update_loginpemakai_id = '.$this->update_loginpemakai_id);
		}
		if(!empty($this->ruangan_id)){
			$criteria->addCondition('create_ruangan = '.$this->ruangan_id);
		}
		
		$criteria->limit=10;

		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
		));
	}
}