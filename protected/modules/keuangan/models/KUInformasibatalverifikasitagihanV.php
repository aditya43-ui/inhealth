<?php

class KUInformasibatalverifikasitagihanV extends InformasibatalverifikasitagihanV
{
	public $tgl_awal, $tgl_akhir;


	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InformasibatalverifikasitagihanV the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function searchInformasi() {
		$criteria = new CDbCriteria;

		$criteria->group = $criteria->select = "tgl_pendaftaran, no_pendaftaran, "
		."namadepan, nama_pasien, no_rekam_medik, umur, alamat_pasien, "
		."gelardepan, nama_pegawai, gelarbelakang_id, gelarbelakang_nama, ruangan_nama, "
		."carabayar_nama, penjamin_nama, "
		."pendaftaran_id, petugasbatal_id, "
		."petugasbatal_nama";

		if (!empty($this->tgl_awal) && !empty($this->tgl_akhir)) {
			$criteria->addBetweenCondition('tgl_pendaftaran::date', $this->tgl_awal, $this->tgl_akhir);
		}
		$criteria->compare('lower(no_pendaftaran)', strtolower($this->no_pendaftaran), true);
		$criteria->compare('lower(no_rekam_medik)', strtolower($this->no_rekam_medik), true);
		$criteria->compare('lower(nama_pasien)', strtolower($this->nama_pasien), true);
		$criteria->compare('lower(petugasbatal_nama)', strtolower($this->petugasbatal_nama), true);

		$criteria->compare('carabayar_id', $this->carabayar_id);
		$criteria->compare('penjamin_id', $this->penjamin_id);
		$criteria->compare('instalasi_id', $this->instalasi_id);
		$criteria->compare('ruangan_id', $this->ruangan_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>array(
				'defaultOrder'=>'tgl_pendaftaran desc',
			),
		));
	}
}