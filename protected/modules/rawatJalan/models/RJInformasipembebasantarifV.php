<?php

class RJInformasipembebasantarifV extends InformasipembebasantarifV
{
        public $tgl_awal, $tgl_akhir;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InformasipembebasantarifV the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * searchInformasi digunakan di:
         * - Biling Kasir/Informasi/Pembebasan Tarif
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function searchInformasi()
	{
		$criteria = new CDbCriteria();
                $criteria->join = " JOIN pembebasantarif_t pt ON pt.pembebasantarif_id = t.pembebasantarif_id ";
                $criteria->addBetweenCondition(" t.tglpembebasan ", $this->tgl_awal.' 00:00:00', $this->tgl_akhir.' 23:59:59');
                $criteria->addCondition(" pt.create_ruangan = '".Yii::app()->user->getState('ruangan_id')."' ");
                $criteria->compare(' LOWER(t.no_rekam_medik) ', strtolower($this->no_rekam_medik),TRUE);
                $criteria->compare(' LOWER(t.nama_pasien) ', strtolower($this->nama_pasien),TRUE);
                if (!empty($this->pegawai_id)){
                    $criteria->addCondition(" t.pegawai_id = '".$this->pegawai_id."' ");
                }
                $criteria->compare(' LOWER(t.daftartindakan_nama) ', strtolower($this->daftartindakan_nama),TRUE);
                $criteria->order = " tglpembebasan DESC ";

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}