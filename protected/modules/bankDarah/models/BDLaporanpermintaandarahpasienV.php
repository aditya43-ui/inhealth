<?php
class BDLaporanpermintaandarahpasienV extends LaporanpermintaandarahpasienV
{
    public $tgl_awal, $tgl_akhir;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AnamnesaT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public function searchTableLaporan()
        {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria = new CDbCriteria;
            $criteria->addBetweenCondition('DATE(tglpermintaan)',$this->tgl_awal,$this->tgl_akhir);
            $criteria->compare('lower(no_pendaftaran)', strtolower($this->no_pendaftaran),true);
            $criteria->compare('lower(no_permintaandarah)',strtolower($this->no_permintaandarah),true);
            $criteria->compare('lower(no_rekam_medik)',strtolower($this->no_rekam_medik),true);
            $criteria->compare('lower(nama_pasien)',strtolower($this->nama_pasien),true);
            $criteria->compare('singkatan_komp',$this->singkatan_komp,true);
            $criteria->compare('golongan_darah',$this->golongan_darah,true);
            return new CActiveDataProvider($this,
                array(
                    'criteria' => $criteria,
                )
            );
        }
        
        public function searchPrintLaporan()
        {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria = new CDbCriteria;
            $criteria->addBetweenCondition('DATE(tglpermintaan)',$this->tgl_awal,$this->tgl_akhir);
            $criteria->compare('lower(no_pendaftaran)', strtolower($this->no_pendaftaran),true);
            $criteria->compare('lower(no_permintaandarah)',strtolower($this->no_permintaandarah),true);
            $criteria->compare('lower(no_rekam_medik)',strtolower($this->no_rekam_medik),true);
            $criteria->compare('lower(nama_pasien)',strtolower($this->nama_pasien),true);
            $criteria->compare('singkatan_komp',$this->singkatan_komp,true);
            $criteria->compare('golongan_darah',$this->golongan_darah,true);
            return new CActiveDataProvider($this,
                array(
                    'criteria' => $criteria,
                    'pagination'=>false
                )
            );
        }
        
}