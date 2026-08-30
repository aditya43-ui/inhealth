<?php

class BKInfokunjunganrjV extends InfokunjunganrjV
{
    public $data;
    public $jumlah;
    public $tick;
    public $ceklis = false;
    public $tglselesaiperiksa;
    public $tglpembayaran;
    public $nopembayaran;
    public $pembayaran_id, $nobuktibayar;
        public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public function searchDialogKunjungan(){
            $format = new MyFormatter();
            $criteria = new CDbCriteria();
            $criteria->compare('LOWER(no_pendaftaran)', strtolower($this->no_pendaftaran), true);
            $criteria->compare('LOWER(no_rekam_medik)', strtolower($this->no_rekam_medik), true);
            $criteria->compare('LOWER(nama_pasien)', strtolower($this->nama_pasien), true);
            $criteria->compare('LOWER(ruangan_nama)', strtolower($this->ruangan_nama), true);
            $criteria->compare('LOWER(jeniskelamin)', strtolower($this->jeniskelamin), true);
			if(!empty($this->carabayar_id)){
				$criteria->addCondition('carabayar_id = '.$this->carabayar_id);
			}
            $criteria->order = 'tgl_pendaftaran DESC';
            $criteria->limit = 5;
            if($this->instalasi_id == Params::INSTALASI_ID_RJ){
                $model = new BKInfokunjunganrjV;
            }else if($this->instalasi_id == Params::INSTALASI_ID_RD){
                $model = new BKInfokunjunganrdV;
            }else if($this->instalasi_id == Params::INSTALASI_ID_RI){
                $model = new BKPasienrawatinapV;
            }

            return new CActiveDataProvider($model, array(
                        'criteria'=>$criteria,
                        'pagination'=>array('pageSize'=>5),
                ));
    }
}