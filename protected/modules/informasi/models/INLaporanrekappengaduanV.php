<?php
class INLaporanrekappengaduanV extends LaporanrekappengaduanV
{
	public $tgl_awal, $tgl_akhir, $jmljenispel, $jmlinstalasi;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function searchPengaduanTable()
    {
        $criteria=new CDbCriteria;
		$criteria->addBetweenCondition('DATE(t.tgl_pengaduan)', $this->tgl_awal, $this->tgl_akhir);
        $criteria->order = 'tgl_pengaduan DESC';

        return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
        ));
    }
	
	public function JumlahDataJenis($jenis_pelayanan, $tgl_awal, $tgl_akhir) {
		$criteria=new CDbCriteria;
		$criteria->addBetweenCondition('DATE(tgl_pengaduan)', $tgl_awal, $tgl_akhir);
		$criteria->addCondition("jenis_pelayanan = '".$jenis_pelayanan."'");
		$criteria->select = 'tgl_pengaduan, pasien_id, nama, alamat, jenis_pelayanan, instalasi_tujuan, uraian_keluhan, tindakan_awal, tindakan_lanjut, mediapengaduan, warnakategoripengaduan, estimasipenyelesaian, namakategori';
		$criteria->group = 'tgl_pengaduan, pasien_id, nama, alamat, jenis_pelayanan, instalasi_tujuan, uraian_keluhan, tindakan_awal, tindakan_lanjut, mediapengaduan, warnakategoripengaduan, estimasipenyelesaian, namakategori';
		$criteria->order = 'tgl_pengaduan DESC';

		$JenisPel = INLaporanrekappengaduanV::model()->findAll($criteria);
		echo count((array)$JenisPel);
	}
	
	public function JumlahDataIns($instalasi_tujuan, $tgl_awal, $tgl_akhir) {
		$criteria=new CDbCriteria;
		$criteria->addBetweenCondition('DATE(tgl_pengaduan)', $tgl_awal, $tgl_akhir);
		$criteria->addCondition("instalasi_tujuan = '".$instalasi_tujuan."'");
		$criteria->select = 'tgl_pengaduan, pasien_id, nama, alamat, jenis_pelayanan, instalasi_tujuan, uraian_keluhan, tindakan_awal, tindakan_lanjut, mediapengaduan, warnakategoripengaduan, estimasipenyelesaian, namakategori';
		$criteria->group = 'tgl_pengaduan, pasien_id, nama, alamat, jenis_pelayanan, instalasi_tujuan, uraian_keluhan, tindakan_awal, tindakan_lanjut, mediapengaduan, warnakategoripengaduan, estimasipenyelesaian, namakategori';
		$criteria->order = 'tgl_pengaduan DESC';

		$JenisPel = INLaporanrekappengaduanV::model()->findAll($criteria);
		echo count((array)$JenisPel);
	}
}

