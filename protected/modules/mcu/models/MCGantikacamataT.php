<?php
class MCGantikacamataT extends GantikacamataT
{
	public $tgl_awal,$tgl_akhir;
	public $jabatan_nama,$nama_pegawai;
	public $no_pengajuan,$status,$tglpengajuan_km;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return GantikacamataT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function searchGantiKacamata()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->limit=100;

		if(!Yii::app()->request->isAjaxRequest){//data hanya muncul setelah melakukan pencarian
			$criteria->limit = 0;
		}
		$this->tgl_awal = MyFormatter::formatDateTimeForDb($this->tgl_awal);
		$this->tgl_akhir = MyFormatter::formatDateTimeForDb($this->tgl_akhir);
		$criteria->addBetweenCondition('DATE(tglgantikacamata)',$this->tgl_awal,$this->tgl_akhir,true);
		if(!empty($this->gantikacamata_id)){
			$criteria->addCondition('gantikacamata_id = '.$this->gantikacamata_id);
		}
		if(!empty($this->pengajuangantikm_id)){
			$criteria->addCondition('pengajuangantikm_id = '.$this->pengajuangantikm_id);
		}
		if(!empty($this->pegawai_id)){
			$criteria->addCondition('pegawai_id = '.$this->pegawai_id);
		}

		$criteria->compare('LOWER(tglpenyerahan)',strtolower($this->tglpenyerahan),true);
		$criteria->compare('LOWER(departement_peg)',strtolower($this->departement_peg),true);
		$criteria->compare('LOWER(statushubungan)',strtolower($this->statushubungan),true);
		$criteria->compare('LOWER(namapasien_hub)',strtolower($this->namapasien_hub),true);
		$criteria->compare('LOWER(duedata_kacamata)',strtolower($this->duedata_kacamata),true);
		$criteria->compare('LOWER(vod_spheris)',strtolower($this->vod_spheris),true);
		$criteria->compare('LOWER(vod_cylindrys)',strtolower($this->vod_cylindrys),true);
		$criteria->compare('LOWER(vos_spheris)',strtolower($this->vos_spheris),true);
		$criteria->compare('LOWER(vos_cylindrys)',strtolower($this->vos_cylindrys),true);
		$criteria->compare('LOWER(add_kacamata)',strtolower($this->add_kacamata),true);
		$criteria->compare('jumlahharga_km',$this->jumlahharga_km);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		if(!empty($this->create_loginpemakai_id)){
			$criteria->addCondition('create_loginpemakai_id = '.$this->create_loginpemakai_id);
		}
		if(!empty($this->update_loginpemakai_id)){
			$criteria->addCondition('update_loginpemakai_id = '.$this->update_loginpemakai_id);
		}
		if(!empty($this->create_ruangan)){
			$criteria->addCondition('create_ruangan = '.$this->create_ruangan);
		}

		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
				'pagination'=>false,
		));
	}
	
	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function searchInformasi()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

//		$criteria->with = array('pengajuangantikm');
		$criteria->addBetweenCondition('DATE(t.tglgantikacamata)',$this->tgl_awal,$this->tgl_akhir);		
//		$criteria->compare('LOWER(pengajuangantikm_t.no_pengajuan)',strtolower($this->no_pengajuan),true);
//		if(isset($this->status) && (!empty($this->status))){
//			if($this->status == 'sudah'){
//				$criteria->addCondition('t.pengajuangantikm_id is not null');
//			}else{
//				$criteria->addCondition('t.pengajuangantikm_id is null');
//			}
//		}
		$criteria->join = 'LEFT JOIN pengajuangantikm_t ON pengajuangantikm_t.pengajuangantikm_id = t.pengajuangantikm_id';

		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
				'pagination'=>false,
		));
	}

	public function StatusGanti(){
		$status = array('sudah'=>'Sudah Diganti','belum'=>'Belum Diganti');
		
		return $status;
	}
}