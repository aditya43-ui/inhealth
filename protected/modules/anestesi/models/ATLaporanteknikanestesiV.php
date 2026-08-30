<?php

/**
 * This is the model class for table "laporanteknikanestesi_v".
 *
 * The followings are the available columns in table 'laporanteknikanestesi_v':
 * @property string $tgl_tindakananestesi
 * @property integer $anastesi_id
 * @property string $anastesi_nama
 * @property integer $jenisanastesi_id
 * @property string $jenisanastesi_nama
 * @property integer $total
 */

class ATLaporanteknikanestesiV extends LaporanteknikanestesiV
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
		if(isset($_GET['ATLaporanteknikanestesiV'])){
			$tgl_awal = $format->formatDateTimeForDb($_GET['ATLaporanteknikanestesiV']['tgl_awal']);
			$tgl_akhir = $format->formatDateTimeForDb($_GET['ATLaporanteknikanestesiV']['tgl_akhir']);
			$tgl_awal = $tgl_awal." 00:00:00";
			$tgl_akhir = $tgl_akhir." 23:59:59";
		}
		if($this->jns_periode == "hari"){
			$criteria->addBetweenCondition('DATE(tgl_tindakananestesi)',$this->tgl_awal,$this->tgl_akhir);
		}
		if($this->jns_periode == "bulan"){
			$criteria->addBetweenCondition("date_part('month',tgl_tindakananestesi)",$bln_awal[1],$bln_akhir[1]);
		}
		if($this->jns_periode == "tahun"){
			$criteria->addBetweenCondition("date_part('year',tgl_tindakananestesi)",$this->thn_awal,$this->thn_akhir);
		}
		
//		$criteria->compare('tgl_tindakananestesi',$this->tgl_tindakananestesi,true);
		$criteria->compare('anastesi_id',$this->anastesi_id);
		$criteria->compare('LOWER(anastesi_nama)', strtolower($this->anastesi_nama),true);
		$criteria->compare('jenisanastesi_id',$this->jenisanastesi_id);
		$criteria->compare('LOWER(jenisanastesi_nama)',strtolower($this->jenisanastesi_nama),true);
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