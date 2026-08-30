<?php

/**
 * This is the model class for table "laporanpelaksanaanestesi_v".
 *
 * The followings are the available columns in table 'laporanpelaksanaanestesi_v':
 * @property string $tgl_laporan
 * @property integer $dokter_id
 * @property string $nama_dokter
 * @property integer $perawat1_id
 * @property string $nama_perawat1
 * @property integer $perawat2_id
 * @property string $nama_perawat2
 * @property integer $totalpasien
 */

class ATLaporanpelaksanaanestesiV extends LaporanpelaksanaanestesiV
{
	public $jns_periode,$tgl_awal,$tgl_akhir,$bln_awal,$bln_akhir,$thn_awal,$thn_akhir;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return KondisipasienanestesiT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function criteriaSearch()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		
		$format = new MyFormatter();
		$bln_awal = explode('-',$this->bln_awal);
		$bln_akhir = explode('-',$this->bln_akhir);
		$tgl_awal = '';
		$tgl_akhir = '';
		if(isset($_GET['ATLaporanpelaksanaanestesiV'])){
			$tgl_awal = $format->formatDateTimeForDb($_GET['ATLaporanpelaksanaanestesiV']['tgl_awal']);
			$tgl_akhir = $format->formatDateTimeForDb($_GET['ATLaporanpelaksanaanestesiV']['tgl_akhir']);
			$tgl_awal = $tgl_awal." 00:00:00";
			$tgl_akhir = $tgl_akhir." 23:59:59";
		}
		if($this->jns_periode == "hari"){
			$criteria->addBetweenCondition('DATE(tgl_laporan)',$this->tgl_awal,$this->tgl_akhir);
		}
		if($this->jns_periode == "bulan"){
			$criteria->addBetweenCondition("date_part('month',tgl_laporan)",$bln_awal[1],$bln_akhir[1]);
		}
		if($this->jns_periode == "tahun"){
			$criteria->addBetweenCondition("date_part('year',tgl_laporan)",$this->thn_awal,$this->thn_akhir);
		}
		
		$criteria->compare('tgl_laporan',$this->tgl_laporan,true);
		$criteria->compare('dokter_id',$this->dokter_id);
		$criteria->compare('LOWER(nama_dokter)',strtolower($this->nama_dokter),true);
		$criteria->compare('perawat1_id',$this->perawat1_id);
		$criteria->compare('LOWER(nama_perawat1)',strtolower($this->nama_perawat1),true);
		$criteria->compare('perawat2_id',$this->perawat2_id);
		$criteria->compare('LOWER(nama_perawat2)',strtolower($this->nama_perawat2),true);
		$criteria->compare('totalpasien',$this->totalpasien);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
		
		return $criteria;
	}
	
	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function searchLaporan()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=$this->criteriaSearch();
		$criteria->limit=10;

		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
		));
	}
	
	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function searchLaporanPrint()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=$this->criteriaSearch();
		$criteria->limit=-1;

		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
				'pagination'=>false,
		));
	}

}