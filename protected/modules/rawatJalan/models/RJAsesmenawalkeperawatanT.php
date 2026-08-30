<?php

class RJAsesmenawalkeperawatanT extends AsesmenawalkeperawatanT {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return AnamnesaT the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function getParamedisItems() {
        $criteria = new CDbCriteria;
        $ruangan_id = Yii::app()->user->getState('ruangan_id');
        $criteria->addCondition('ruangan_id=' . $ruangan_id);
        $criteria->addCondition('kelompokpegawai_id = ' . Params::KELOMPOKPEGAWAI_ID_TENAGA_KEPERAWATAN);
        $criteria->order = "nama_pegawai ASC";
        return PegawairuanganV::model()->findAll($criteria);
    }

    public function getDokterItems() {
        $criteria = new CDbCriteria();
//            $criteria->addCondition('ruangan_id='.$ruangan_id);
        $criteria->addCondition('kelompokpegawai_id = ' . Params::KELOMPOKPEGAWAI_ID_TENAGA_MEDIK);
        $criteria->order = 'nama_pegawai ASC';
        return PegawairuanganV::model()->findAll($criteria);
    }

    public function searchRiwayat() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        if (!empty($this->pendaftaran_id)) {
            $criteria->addCondition('pendaftaran_id = ' . $this->pendaftaran_id);
        }

        if (!empty($this->pasienadmisi_id)) {
            $criteria->addCondition('pasienadmisi_id = ' . $this->pasienadmisi_id);
        }

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

}
