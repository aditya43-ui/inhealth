<?php

class GFRencanaKebFarmasiT extends RencanakebfarmasiT
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return RencanakebfarmasiT the static model class
	 */
	public $obatalkes_id;
	public $obatalkes_nama;
	public $jmlpermintaan;
	public $hargatotalrenc;
	public $tgl_awal,$tgl_akhir;
	public $jns_periode,$bln_awal,$bln_akhir,$thn_awal,$thn_akhir;
	public $data;
	public $jumlah;
	public $pegawaimengetahui_nama;
	public $pegawaimenyetujui_nama;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
	public function searchPermintaanPembelian()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		if(trim($this->tglperencanaan)!='')
			$criteria->compare('date(tglperencanaan)',$this->tglperencanaan);
//		$criteria->compare('date(tglperencanaan)',$this->tglperencanaan,TRUE);
		$criteria->compare('LOWER(noperencnaan)',strtolower($this->noperencnaan),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
	public function searchInformasi()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->addBetweenCondition('DATE(tglperencanaan)',$this->tgl_awal,$this->tgl_akhir);
		$criteria->compare('LOWER(noperencnaan)',strtolower($this->noperencnaan),true);
		if(!empty($this->ruangan_id)){
			$criteria->addCondition('ruangan_id = '.$this->ruangan_id);
		}

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	public function searchGrafik()
	{
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;

                $criteria->select = 'count(t.rencanakebfarmasi_id) as jumlah, t.rencanakebfarmasi_id, t.noperencnaan, obatalkes_m.obatalkes_nama as data';
                $criteria->group = 't.tglperencanaan, t.noperencnaan, t.rencanakebfarmasi_id,obatalkes_m.obatalkes_nama';
                $criteria->join = 'LEFT JOIN rencdetailkeb_t ON rencdetailkeb_t.rencanakebfarmasi_id = t.rencanakebfarmasi_id LEFT JOIN obatalkes_m ON obatalkes_m.obatalkes_id=rencdetailkeb_t.obatalkes_id';
                $criteria->addBetweenCondition('date(t.tglperencanaan)',$this->tgl_awal,$this->tgl_akhir);
                $criteria->addCondition('t.ruangan_id = '.Yii::app()->user->ruangan_id);
                $criteria->compare('t.noperencnaan',$this->noperencnaan);

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                ));
        }
	public function searchRencanaKebutuhan()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
                
		$criteria->select='t.tglperencanaan, t.noperencnaan, t.ruangan_id, obatalkes_m.obatalkes_nama,rencdetailkeb_t.jmlpermintaan,rencdetailkeb_t.hargatotalrenc';
		$criteria->group = 't.tglperencanaan, t.noperencnaan, obatalkes_m.obatalkes_nama, t.ruangan_id,rencdetailkeb_t.jmlpermintaan,rencdetailkeb_t.hargatotalrenc';
		$criteria->join = 'LEFT JOIN rencdetailkeb_t ON rencdetailkeb_t.rencanakebfarmasi_id = t.rencanakebfarmasi_id LEFT JOIN obatalkes_m ON obatalkes_m.obatalkes_id=rencdetailkeb_t.obatalkes_id';
		$criteria->addBetweenCondition('date(t.tglperencanaan)',$this->tgl_awal,$this->tgl_akhir);
		$criteria->compare('LOWER(t.noperencnaan)',strtolower($this->noperencnaan),true);
		if(!empty($this->ruangan_id)){
			$criteria->addCondition('t.ruangan_id = '.$this->ruangan_id);
		}

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        public function searchRencanaKebutuhanPrint()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$criteria->select='t.tglperencanaan, t.noperencnaan, t.ruangan_id, obatalkes_m.obatalkes_nama, rencdetailkeb_t.jmlpermintaan,rencdetailkeb_t.hargatotalrenc';
		$criteria->group = 't.tglperencanaan, t.noperencnaan, obatalkes_m.obatalkes_nama, t.ruangan_id,rencdetailkeb_t.jmlpermintaan,rencdetailkeb_t.hargatotalrenc';
		$criteria->join = 'LEFT JOIN rencdetailkeb_t ON rencdetailkeb_t.rencanakebfarmasi_id = t.rencanakebfarmasi_id LEFT JOIN obatalkes_m ON obatalkes_m.obatalkes_id=rencdetailkeb_t.obatalkes_id';
		$criteria->addBetweenCondition('date(t.tglperencanaan)',$this->tgl_awal,$this->tgl_akhir);
		$criteria->compare('LOWER(t.noperencnaan)',strtolower($this->noperencnaan),true);
		if(!empty($this->ruangan_id)){
			$criteria->addCondition('t.ruangan_id = '.$this->ruangan_id);
		}
		$criteria->limit = -1;

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination'=>false,
		));
	}
                

}