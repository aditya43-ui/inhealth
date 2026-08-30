<?php

class AKRincianpiutangrekeningpasienV extends RincianpiutangrekeningpasienV
{
        public $tglAwal, $tglAkhir;
        public $daftartindakan_id, $obatalkes_id, $saldodebit, $saldokredit;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return RincianpiutangrekeningpasienV the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
         * digunakan di:
         * - akuntansi/actionAjax/GetRekeningPiutangPasien
         */
        public function criteriaFunction(){
            $criteria=new CDbCriteria;

            $criteria->addBetweenCondition('DATE(tgl_pendaftaran)',$this->tglAwal,$this->tglAkhir);
            $criteria->compare('LOWER(no_rekam_medik)',strtolower($this->no_rekam_medik),true);
            $criteria->compare('LOWER(no_pendaftaran)',strtolower($this->no_pendaftaran),true);
            if(empty($this->ruangan_id)) $criteria->compare('instalasi_id',$this->instalasi_id);
            $criteria->compare('ruangan_id',$this->ruangan_id);
            $criteria->compare('carabayar_id',$this->carabayar_id);
            $criteria->compare('penjamin_id',$this->penjamin_id);

            $criteria->limit = 500; //batas maksimal data
            return $criteria;
        }
	public function searchInformasi()
	{
            $criteria=new $this->criteriaFunction();

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
	}
}