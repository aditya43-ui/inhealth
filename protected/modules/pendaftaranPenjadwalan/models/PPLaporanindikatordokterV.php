<?php

class PPLaporanindikatordokterV extends LaporanindikatordokterV
{
	public $jns_periode,$tgl_awal,$tgl_akhir;
	public $bln_awal,$bln_akhir,$thn_awal,$thn_akhir;
	public $nama_pegawai,$data,$jumlah;
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}	
	
    protected function functionCriteria() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

		$criteria=new CDbCriteria;

        $criteria->addBetweenCondition('DATE(tglubahdokter)', $this->tgl_awal, $this->tgl_akhir);
		if(!empty($this->ubahdokter_id)){
			$criteria->addCondition('ubahdokter_id = '.$this->ubahdokter_id);
		}
		if(!empty($this->pendaftaran_id)){
			$criteria->addCondition('pendaftaran_id = '.$this->pendaftaran_id);
		}
		$criteria->compare('LOWER(tgl_pendaftaran)',strtolower($this->tgl_pendaftaran),true);
		$criteria->compare('LOWER(no_pendaftaran)',strtolower($this->no_pendaftaran),true);
		if(!empty($this->pasien_id)){
			$criteria->addCondition('pasien_id = '.$this->pasien_id);
		}
		$criteria->compare('LOWER(no_rekam_medik)',strtolower($this->no_rekam_medik),true);
		if(!empty($this->pegawai_id)){
			$criteria->addCondition('pegawai_id = '.$this->pegawai_id);
		}
		$criteria->compare('LOWER(nobadge)',strtolower($this->nobadge),true);
		$criteria->compare('LOWER(jenisidentitas)',strtolower($this->jenisidentitas),true);
		$criteria->compare('LOWER(no_identitas_pasien)',strtolower($this->no_identitas_pasien),true);
		$criteria->compare('LOWER(namadepan)',strtolower($this->namadepan),true);
		$criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);
		$criteria->compare('LOWER(jeniskelamin)',strtolower($this->jeniskelamin),true);
		$criteria->compare('LOWER(tempat_lahir)',strtolower($this->tempat_lahir),true);
		$criteria->compare('LOWER(alamat_pasien)',strtolower($this->alamat_pasien),true);
		if(!empty($this->dokterlama_id)){
			$criteria->addCondition('dokterlama_id = '.$this->dokterlama_id);
		}
		$criteria->compare('LOWER(dokterlama_nobadge)',strtolower($this->dokterlama_nobadge),true);
		$criteria->compare('LOWER(dokterlama_jenisidentitas)',strtolower($this->dokterlama_jenisidentitas),true);
		$criteria->compare('LOWER(dokterlama_noidentitas)',strtolower($this->dokterlama_noidentitas),true);
		$criteria->compare('LOWER(dokterlama_gelardepan)',strtolower($this->dokterlama_gelardepan),true);
		$criteria->compare('LOWER(dokterlama_nama)',strtolower($this->dokterlama_nama),true);
		$criteria->compare('LOWER(dokterlama_gelarbelakang)',strtolower($this->dokterlama_gelarbelakang),true);
		if(!empty($this->dokterbaru_id)){
			$criteria->addCondition('dokterbaru_id = '.$this->dokterbaru_id);
		}
		$criteria->compare('LOWER(dokterbaru_nobadge)',strtolower($this->dokterbaru_nobadge),true);
		$criteria->compare('LOWER(dokterbaru_jenisidentitas)',strtolower($this->dokterbaru_jenisidentitas),true);
		$criteria->compare('LOWER(dokterbaru_noidentitas)',strtolower($this->dokterbaru_noidentitas),true);
		$criteria->compare('LOWER(dokterbaru_gelardepan)',strtolower($this->dokterbaru_gelardepan),true);
		$criteria->compare('LOWER(dokterbaru_nama)',strtolower($this->dokterbaru_nama),true);
		$criteria->compare('LOWER(dokterbaru_gelarbelakang)',strtolower($this->dokterbaru_gelarbelakang),true);
		$criteria->compare('LOWER(alasanperubahandokter)',strtolower($this->alasanperubahandokter),true);
		$criteria->compare('LOWER(keterangan)',strtolower($this->keterangan),true);
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

		return $criteria;
    }

	public function searchTable() {
        $criteria = new CDbCriteria();
        $criteria = $this->functionCriteria();
        $criteria->order = 'tglubahdokter DESC';

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }
	
    public function searchPrint()
    {
        $criteria = new CDbCriteria();
        $criteria = $this->functionCriteria();
        $criteria->order = 'tglubahdokter DESC';

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                    'pagination' => false,
                ));
    }
	
    public function searchGrafik() {
        $criteria = new CDbCriteria();
        $criteria = $this->functionCriteria();

        $criteria->select = 'count(pendaftaran_id) as jumlah, alasanperubahandokter as data';
		$criteria->group = 'alasanperubahandokter';

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }
}

