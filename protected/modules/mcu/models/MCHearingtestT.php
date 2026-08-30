<?php
class MCHearingtestT extends HearingtestT
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return HearingtestT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function searchDetailHearingtest($pendaftaran_id)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		if(!empty($this->hearingtest_id)){
			$criteria->addCondition('hearingtest_id = '.$this->hearingtest_id);
		}
		if(!empty($this->pasien_id)){
			$criteria->addCondition('pasien_id = '.$this->pasien_id);
		}
		if(!empty($this->pegawai_id)){
			$criteria->addCondition('pegawai_id = '.$this->pegawai_id);
		}
		if(!empty($this->permintaanmcu_id)){
			$criteria->addCondition('permintaanmcu_id = '.$this->permintaanmcu_id);
		}
		if(!empty($this->ruangan_id)){
			$criteria->addCondition('ruangan_id = '.$this->ruangan_id);
		}
		$criteria->compare('LOWER(tglhearingtest)',strtolower($this->tglhearingtest),true);
		$criteria->compare('LOWER(nmperusahaan_rwt)',strtolower($this->nmperusahaan_rwt),true);
		$criteria->compare('LOWER(jnspekerjaan_rwt)',strtolower($this->jnspekerjaan_rwt),true);
		if(!empty($this->lamabekerja)){
			$criteria->addCondition('lamabekerja = '.$this->lamabekerja);
		}
		$criteria->compare('LOWER(satuan_lamakrj)',strtolower($this->satuan_lamakrj),true);
		$criteria->compare('LOWER(kontakdgnbising)',strtolower($this->kontakdgnbising),true);
		$criteria->compare('LOWER(ket_kerja_lingkungan)',strtolower($this->ket_kerja_lingkungan),true);
		$criteria->compare('LOWER(hobtembak_musik)',strtolower($this->hobtembak_musik),true);
		$criteria->compare('LOWER(bahankimia_lk)',strtolower($this->bahankimia_lk),true);
		$criteria->compare('LOWER(kelainanpend_kal_kel)',strtolower($this->kelainanpend_kal_kel),true);
		$criteria->compare('LOWER(altproteksi_telinga)',strtolower($this->altproteksi_telinga),true);
		$criteria->compare('LOWER(gangguan_antarperorangan)',strtolower($this->gangguan_antarperorangan),true);
		$criteria->compare('LOWER(gangguan_lingkgaduh)',strtolower($this->gangguan_lingkgaduh),true);
		$criteria->compare('LOWER(telinga_mendenging)',strtolower($this->telinga_mendenging),true);
		$criteria->compare('LOWER(tkn_membrantympani)',strtolower($this->tkn_membrantympani),true);
		$criteria->compare('LOWER(tkn_influbtelinga)',strtolower($this->tkn_influbtelinga),true);
		$criteria->compare('LOWER(tkn_serumen)',strtolower($this->tkn_serumen),true);
		$criteria->compare('LOWER(tkr_membrantympani)',strtolower($this->tkr_membrantympani),true);
		$criteria->compare('LOWER(tkr_influbtelinga)',strtolower($this->tkr_influbtelinga),true);
		$criteria->compare('LOWER(tkr_serumen)',strtolower($this->tkr_serumen),true);
		$criteria->compare('LOWER(penuruankempendengaran)',strtolower($this->penuruankempendengaran),true);
		$criteria->compare('LOWER(hasil_pendengaran)',strtolower($this->hasil_pendengaran),true);
		$criteria->compare('LOWER(tkn_500)',strtolower($this->tkn_500),true);
		$criteria->compare('LOWER(tkn_1k)',strtolower($this->tkn_1k),true);
		$criteria->compare('LOWER(tkn_2k)',strtolower($this->tkn_2k),true);
		$criteria->compare('LOWER(tkn_3k)',strtolower($this->tkn_3k),true);
		$criteria->compare('LOWER(tkn_4k)',strtolower($this->tkn_4k),true);
		$criteria->compare('LOWER(tkn_6k)',strtolower($this->tkn_6k),true);
		$criteria->compare('LOWER(tkn_8k)',strtolower($this->tkn_8k),true);
		$criteria->compare('LOWER(tkr_500)',strtolower($this->tkr_500),true);
		$criteria->compare('LOWER(tkr_1k)',strtolower($this->tkr_1k),true);
		$criteria->compare('LOWER(tkr_2k)',strtolower($this->tkr_2k),true);
		$criteria->compare('LOWER(tkr_3k)',strtolower($this->tkr_3k),true);
		$criteria->compare('LOWER(tkr_4k)',strtolower($this->tkr_4k),true);
		$criteria->compare('LOWER(tkr_6k)',strtolower($this->tkr_6k),true);
		$criteria->compare('LOWER(tkr_8k)',strtolower($this->tkr_8k),true);
		$criteria->compare('LOWER(penurunan_presbyacusis)',strtolower($this->penurunan_presbyacusis),true);
		$criteria->compare('LOWER(penurunan_infdanlain)',strtolower($this->penurunan_infdanlain),true);
		$criteria->compare('LOWER(catatan_hearingtest)',strtolower($this->catatan_hearingtest),true);
		$criteria->compare('LOWER(keterangan_hearingtest)',strtolower($this->keterangan_hearingtest),true);
		$criteria->compare('LOWER(namapemeriksa_hearingtest)',strtolower($this->namapemeriksa_hearingtest),true);
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
		
        $criteria->addCondition('pendaftaran_id = '.$pendaftaran_id);
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}