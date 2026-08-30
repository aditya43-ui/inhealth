<?php
class KPPenggajianpegawaiV extends PenggajianpegawaiV
{
	public $tgl_awal,$tgl_akhir;
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
		
		
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

}