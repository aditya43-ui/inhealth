<?php

class BKInformasipembayarantagihannontunaiV extends InformasipembayarantagihannontunaiV {

    public $tgl_awal, $tgl_akhir, $ceklis, $tgljatuhtempo_awal, $tgljatuhtempo_akhir;

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function searchInformasi() {
        $criteria = new CDbCriteria;

        $criteria->addBetweenCondition('DATE(tglpembayaran)', $this->tgl_awal, $this->tgl_akhir);

        if($this->ceklis){
            $criteria->addBetweenCondition('DATE(tgljatuhtempo)', $this->tgljatuhtempo_awal, $this->tgljatuhtempo_akhir);
        }


        $criteria->compare('lower(nopembayaran)', strtolower($this->nopembayaran), true);
        $criteria->compare('lower(no_rekam_medik)', strtolower($this->no_rekam_medik), true);
        $criteria->compare('lower(no_pendaftaran)', strtolower($this->no_pendaftaran), true);
        $criteria->compare('lower(nama_pasien)', strtolower($this->nama_pasien), true);
        $criteria->compare('lower(dengankartu)', strtolower($this->dengankartu));
        $criteria->compare('lower(bank_namapengirim)', strtolower($this->bank_namapengirim));
        $criteria->compare('lower(carabayar_nama)', strtolower($this->carabayar_nama));
        $criteria->compare('lower(penjamin_nama)', strtolower($this->penjamin_nama));
        $criteria->compare('lower(bank_namapengirim)', strtolower($this->bank_namapengirim));
        $criteria->compare('lower(bank_namapengirim)', strtolower($this->bank_namapengirim));
        $criteria->compare('lower(bank_namapengirim)', strtolower($this->bank_namapengirim));

        if (!empty($this->kelastanggungan_id)) {
            $criteria->addCondition('kelastanggungan_id = ' . $this->kelastanggungan_id);
        }
        if (!empty($this->petugasadministrasi_id)) {
            $criteria->addCondition('petugasadministrasi_id = ' . $this->petugasadministrasi_id);
        }

        if (!empty($this->instalasi_id)) {
            $criteria->addCondition('instalasi_id = ' . $this->instalasi_id);
        }

        if (!empty($this->ruangan_id)) {
            $criteria->addCondition('ruangan_id = ' . $this->ruangan_id);
        }

        if (!empty($this->kelaspelayanan_id)) {
            $criteria->addCondition('kelaspelayanan_id = ' . $this->kelaspelayanan_id);
        }

        if (!empty($this->bank_id)) {
            $criteria->addCondition('bank_id = ' . $this->bank_id);
        }

        if (!empty($this->bankpembayaran_id)) {
            $criteria->addCondition('bankpembayaran_id = ' . $this->bankpembayaran_id);
        }

        if (!empty($this->jnspembayar_id)) {
            $criteria->addCondition('jnspembayar_id = ' . $this->jnspembayar_id);
        }

        if(!empty($this->closingkasir_id)){
            if ($this->closingkasir_id == 1):
                $criteria->addCondition('t.closingkasir_id is not null ');
            elseif ($this->closingkasir_id == 2):
                $criteria->addCondition('t.closingkasir_id is null ');
            endif;
        }
        $criteria->order = 'jnspembayar_id asc';


        return new CActiveDataProvider($this, array(
            'criteria' => $criteria
        ));
    }
}
