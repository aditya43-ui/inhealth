<?php
class KUVerifikasiberkasmcuT extends VerifikasiberkasmcuT
{
	public $tgl_awal,$tgl_akhir, $petugasverifikasi_nama;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return VerifikasiberkasmcuT the static model class
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

		$criteria->addBetweenCondition('DATE(tglberkasmcumasuk)', $this->tgl_awal, $this->tgl_akhir,true);
		if(!empty($this->verifikasiberkasmcu_id)){
			$criteria->addCondition('verifikasiberkasmcu_id = '.$this->verifikasiberkasmcu_id);
		}
		if(!empty($this->ruangan_id)){
			$criteria->addCondition('ruangan_id = '.$this->ruangan_id);
		}
		if(!empty($this->pasien_id)){
			$criteria->addCondition('pasien_id = '.$this->pasien_id);
		}
		if(!empty($this->pendaftaran_id)){
			$criteria->addCondition('pendaftaran_id = '.$this->pendaftaran_id);
		}
		$criteria->compare('LOWER(noverifkasiberkasmcu)',strtolower($this->noverifkasiberkasmcu),true);
		$criteria->compare('LOWER(nosurat_rs)',strtolower($this->nosurat_rs),true);
		$criteria->compare('LOWER(tglsurat_rs)',strtolower($this->tglsurat_rs),true);
		$criteria->compare('LOWER(statusverifikasiberkas)',strtolower($this->statusverifikasiberkas),true);
		$criteria->compare('LOWER(tglberkasdikembalikan)',strtolower($this->tglberkasdikembalikan),true);
		$criteria->compare('LOWER(namarumahsakit)',strtolower($this->namarumahsakit),true);
		if(!empty($this->petugasverifikasi_id)){
			$criteria->addCondition('petugasverifikasi_id = '.$this->petugasverifikasi_id);
		}
		$criteria->compare('LOWER(tgljatuhtempo)',strtolower($this->tgljatuhtempo),true);
		$criteria->compare('totaltagihanmcu',$this->totaltagihanmcu);
		$criteria->compare('LOWER(berkas_1)',strtolower($this->berkas_1),true);
		$criteria->compare('LOWER(berkas_2)',strtolower($this->berkas_2),true);
		$criteria->compare('LOWER(berkas_3)',strtolower($this->berkas_3),true);
		$criteria->compare('LOWER(berkas_4)',strtolower($this->berkas_4),true);
		$criteria->compare('LOWER(berkas_5)',strtolower($this->berkas_5),true);
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
		
		$criteria->limit=10;

		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
		));
	}
}