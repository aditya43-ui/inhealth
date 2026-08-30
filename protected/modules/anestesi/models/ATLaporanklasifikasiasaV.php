<?php

/**
 * This is the model class for table "laporanklasifikasiasa_v".
 *
 * The followings are the available columns in table 'laporanklasifikasiasa_v':
 * @property string $tgl_laporan
 * @property integer $typeanastesi_id
 * @property string $typeanastesi_nama
 * @property integer $total
 */

class ATLaporanklasifikasiasaV extends LaporanklasifikasiasaV
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
		if(isset($_GET['ATLaporanklasifikasiasaV'])){
			$tgl_awal = $format->formatDateTimeForDb($_GET['ATLaporanklasifikasiasaV']['tgl_awal']);
			$tgl_akhir = $format->formatDateTimeForDb($_GET['ATLaporanklasifikasiasaV']['tgl_akhir']);
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
		
		$criteria->compare('typeanastesi_id',$this->typeanastesi_id);
		$criteria->compare('LOWER(typeanastesi_nama)',strtolower($this->typeanastesi_nama),true);
		$criteria->compare('total',$this->total);
		
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