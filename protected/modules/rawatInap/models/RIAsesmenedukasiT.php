<?php
/**
 * 
 * - digunakan untuk mengenerate data pada tabel AsesmenRencanaKeperawatan_t, hanya untuk modul rawat inap saja
 * RSST-1459
 */
class RIAsesmenedukasiT extends AsesmenedukasiT
{
    public $pasien_penerima_edukasi;
    public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function searchRiwayat() {
		$criteria = new CDbCriteria;
		$criteria->compare('pendaftaran_id', $this->pendaftaran_id);
		$criteria->compare('ppa_jenis', $this->ppa_jenis);
		$criteria->compare('create_ruangan', $this->create_ruangan);



		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>array(
				'defaultOrder'=>'asesmenedukasi_id desc',
			)
		));
	}
}