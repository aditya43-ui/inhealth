<?php

class BKInfopasienpengunjungV extends InfopasienpengunjungV
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InfopasienpengunjungV the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        /**
        * menampilkan data kunjungan pasien
        * model & criteria harus sama dengan PelayananPasienController/AutocompleteKunjungan
        * @return \CActiveDataProvider
        */
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
            $criteria->addInCondition('instalasi_id',array(Params::INSTALASI_ID_RJ,Params::INSTALASI_ID_RD,Params::INSTALASI_ID_RI));
            $criteria->order = 'tgl_pendaftaran DESC';
            $criteria->limit = 5;
            
            return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }

}