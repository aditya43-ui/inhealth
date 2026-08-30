<?php
class INPasienPenunjang extends PasienmasukpenunjangT
{
	public $tgl_awal,$tgl_akhir;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function searchPenunjang()
    {
        $criteria=new CDbCriteria;
		$criteria->with = array('pasien','pendaftaran');
		$criteria->compare('LOWER(pendaftaran.no_pendaftaran)',strtolower($this->no_pendaftaran),true);
		$criteria->compare('LOWER(pasien.nama_pasien)',strtolower($this->nama_pasien),true);
        $criteria->compare('LOWER(pasien.no_rekam_medik)',strtolower($this->no_rekam_medik),true);
        $criteria->addBetweenCondition('DATE(t.tglmasukpenunjang)', $this->tgl_awal, $this->tgl_akhir);
//            $criteria->order = 'tglmasukpenunjang DESC';
        

        return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
        ));
    }
}
