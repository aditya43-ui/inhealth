<?php

class RDPesanambulansT extends PesanambulansT
{
        public $rt,$rw;
        public $tgl_awal,$tgl_akhir;
        public $inisial_modul;
        public $nama_pemakai;
        /**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AnamnesaT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */


	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

        $criteria->with = array('ruanganpemesan');
        $criteria->with = array('userpemesan');
		$criteria->addBetweenCondition('DATE(tglpemesananambulans)', $this->tgl_awal, $this->tgl_akhir);
		$criteria->compare('pesanambulans_t',$this->pesanambulans_t);
		$criteria->addCondition('t.create_ruangan = '.Yii::app()->user->getState('ruangan_id'));
        if (!empty($this->ruangan_id)){
            $criteria->addCondition(" t.ruangan_id = '".$this->ruangan_id."' ");
        }
        $criteria->compare("LOWER(userpemesan.nama_pemakai)",  strtolower($this->nama_pemakai), TRUE);
		$criteria->compare('LOWER(ruanganpemesan.ruangan_nama)',$this->ruangan_nama,true);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('mobilambulans_id',$this->mobilambulans_id);
		$criteria->compare('pemakaianambulans_id',$this->pemakaianambulans_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('LOWER(pesanambulans_no)',strtolower($this->pesanambulans_no),true);
		$criteria->compare('LOWER(norekammedis)',strtolower($this->norekammedis),true);
		$criteria->compare('LOWER(namapasien)',strtolower($this->namapasien),true);
		$criteria->compare('LOWER(tempattujuan)',strtolower($this->tempattujuan),true);
		$criteria->compare('LOWER(kelurahan_nama)',strtolower($this->kelurahan_nama),true);
		$criteria->compare('LOWER(alamattujuan)',strtolower($this->alamattujuan),true);
		$criteria->compare('LOWER(rt_rw)',strtolower($this->rt_rw),true);
		$criteria->compare('LOWER(nomobile)',strtolower($this->nomobile),true);
		$criteria->compare('LOWER(notelepon)',strtolower($this->notelepon),true);
		$criteria->compare('LOWER(tglpemakaianambulans)',strtolower($this->tglpemakaianambulans),true);
		$criteria->compare('LOWER(untukkeperluan)',strtolower($this->untukkeperluan),true);
		$criteria->compare('LOWER(keteranganpesan)',strtolower($this->keteranganpesan),true);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		//$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function searchPemesananAmbulans()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$criteria->order = 'tglpemesananambulans DESC';
		$criteria->limit = 10;

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>false
		));
	}

  	public function searchPrint()
	{
		$criteria=new CDbCriteria;

		if(!empty($this->pesanambulans_t)){
			$criteria->addCondition("pesanambulans_t = ".$this->pesanambulans_t);				
		}
		$criteria->addCondition('tglpemesananambulans BETWEEN \''.$this->tgl_awal.'\' AND \''.$this->tgl_akhir.'\'');

    	// $criteria->compare('pesanambulans_t',$this->pesanambulans_t);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('mobilambulans_id',$this->mobilambulans_id);
		$criteria->compare('pemakaianambulans_id',$this->pemakaianambulans_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('LOWER(pesanambulans_no)',strtolower($this->pesanambulans_no),true);
		//$criteria->compare('LOWER(tglpemesananambulans)',strtolower($this->tglpemesananambulans),true);
		$criteria->compare('LOWER(norekammedis)',strtolower($this->norekammedis),true);
		$criteria->compare('LOWER(namapasien)',strtolower($this->namapasien),true);
		$criteria->compare('LOWER(tempattujuan)',strtolower($this->tempattujuan),true);
		$criteria->compare('LOWER(kelurahan_nama)',strtolower($this->kelurahan_nama),true);
		$criteria->compare('LOWER(alamattujuan)',strtolower($this->alamattujuan),true);
		$criteria->compare('LOWER(rt_rw)',strtolower($this->rt_rw),true);
		$criteria->compare('LOWER(nomobile)',strtolower($this->nomobile),true);
		$criteria->compare('LOWER(notelepon)',strtolower($this->notelepon),true);
		$criteria->compare('LOWER(tglpemakaianambulans)',strtolower($this->tglpemakaianambulans),true);
		$criteria->compare('LOWER(untukkeperluan)',strtolower($this->untukkeperluan),true);
		$criteria->compare('LOWER(keteranganpesan)',strtolower($this->keteranganpesan),true);

		$criteria->order='pesanambulans_t';
        $criteria->limit=-1;

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
?>
