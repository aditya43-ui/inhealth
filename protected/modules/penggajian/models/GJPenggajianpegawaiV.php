<?php
class GJPenggajianpegawaiV extends PenggajianpegawaiV
{
	public $tgl_awal,
			$tgl_akhir,
			$bln_awal,
			$bln_akhir,
			$thn_awal,
			$thn_akhir,
			$jns_periode;
	public $nomorindukpegawai;
	public $keterangan;
	public $mengetahui;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PenggajianpegawaiV the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	/**
	 * untuk Informasi Penggajian Pegawai - Kepegawaian
	 */
	public function searchInformasiPenggajian($pegawai = null)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
		$criteria=new CDbCriteria;

		$criteria->addBetweenCondition('DATE(tglpenggajian)', $this->tgl_awal, $this->tgl_akhir,true);
		if (!empty($pegawai)){
			$criteria->addCondition('pegawai_id = '.$pegawai);
		}
		$criteria->compare('penggajianpeg_id',$this->penggajianpeg_id);
		$criteria->compare('LOWER(periodegaji)',strtolower($this->periodegaji),true);
		$criteria->compare('LOWER(gelardepan)',strtolower($this->gelardepan),true);
		$criteria->compare('LOWER(nama_pegawai)',strtolower($this->nama_pegawai),true);
		$criteria->compare('LOWER(nama_keluarga)',strtolower($this->nama_keluarga),true);
		$criteria->compare('LOWER(tglpenggajian)',strtolower($this->tglpenggajian),true);
		$criteria->compare('LOWER(nopenggajian)',strtolower($this->nopenggajian),true);
		$criteria->compare('penerimaanbersih',$this->penerimaanbersih);
		$criteria->compare('totalpajak',$this->totalpajak);
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

}