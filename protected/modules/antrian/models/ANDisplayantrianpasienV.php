<?php

class ANDisplayantrianpasienV extends DisplayantrianpasienV {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
    public function searchTable()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

                                $year = date('Y');
                                $month = date('m');
                                $date = date('d');
		$criteria=new CDbCriteria;
                                $criteria->order = 'tgl_pendaftaran DESC';
                                $criteria->condition = "EXTRACT(DAY FROM tgl_pendaftaran)=$date AND
                                                                    EXTRACT(MONTH FROM tgl_pendaftaran)=$month AND
                                                                    EXTRACT(YEAR FROM tgl_pendaftaran)=$year
                                                                    ";
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('LOWER(no_urutantri)',strtolower($this->no_urutantri),true);
		$criteria->compare('LOWER(tgl_pendaftaran)',strtolower($this->tgl_pendaftaran),true);
		$criteria->compare('LOWER(no_pendaftaran)',strtolower($this->no_pendaftaran),true);
		$criteria->compare('LOWER(no_rekam_medik)',strtolower($this->no_rekam_medik),true);
		$criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);
		$criteria->compare('LOWER(jeniskelamin)',strtolower($this->jeniskelamin),true);
		$criteria->compare('LOWER(statusperiksa)',strtolower($this->statusperiksa),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination' => array('pageSize' => 5,),
                        'totalItemCount' => 5,
		));
	}

}