<?php
class PPUbahdokterR extends UbahdokterR
{
	public $jns_periode,$tgl_awal,$tgl_akhir;
	public $bln_awal,$bln_akhir,$thn_awal,$thn_akhir;
	public $data,$jumlah,$tick,$nama_pegawai;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return UbahdokterR the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function searchTable() {
        $criteria = new CDbCriteria();
        $criteria = $this->functionCriteria();
        $criteria->order = 'tglubahdokter DESC';

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
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

    protected function functionCriteria() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;
        
        $criteria->addBetweenCondition('DATE(tglubahdokter)', $this->tgl_awal, $this->tgl_akhir);
		if(!empty($this->ubahdokter_id)){
			$criteria->addCondition('ubahdokter_id = '.$this->ubahdokter_id);
		}
		if(!empty($this->dokterlama_id)){
			$criteria->addCondition('dokterlama_id = '.$this->dokterlama_id);
		}
		if(!empty($this->dokterbaru_id)){
			$criteria->addCondition('dokterbaru_id = '.$this->dokterbaru_id);
		}
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
		if(!empty($this->pendaftaran_id)){
			$criteria->addCondition('pendaftaran_id = '.$this->pendaftaran_id);
		}

        return $criteria;
    }

}