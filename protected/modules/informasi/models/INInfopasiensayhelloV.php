<?php

class INInfopasiensayhelloV extends InfopasiensayhelloV {

    public $tgl_awal;
    public $tgl_akhir;
    public $ceklis = false;

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function searchSayHello() {
        $criteria = new CDbCriteria;
        $criteria->select = 'no_rekam_medik,ruangan_nama,no_pendaftaran,tgl_pendaftaran,nama_pasien,jeniskelamin,tanggal_lahir,alamat_pasien,statusperkawinan,agama,no_telepon_pasien,no_mobile_pasien,alamatemail,tgladmisi,tglpasienpulang,carakeluar_nama,kondisikeluar_nama,pasiensayhello_id,pendaftaran_id,pasienadmisi_id';
        $criteria->group = $criteria->select;
        if ($this->ceklis == 1) {
            $criteria->addBetweenCondition('DATE(tglpasienpulang)', $this->tgl_awal, $this->tgl_akhir, true);
        }
        $criteria->compare('LOWER(no_pendaftaran)', strtolower($this->no_pendaftaran), true);
        $criteria->compare('LOWER(nama_pasien)', strtolower($this->nama_pasien), true);
        $criteria->compare('LOWER(nama_bin)', strtolower($this->nama_bin), true);
        $criteria->compare('LOWER(no_rekam_medik)', strtolower($this->no_rekam_medik), true);
//			$criteria->addCondition('ruangan_id = '.Yii::app()->user->getState('ruangan_id'));

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

}
