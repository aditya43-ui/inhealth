<?php

/**
 * This is the model class for table "lapanestesikomplikasiintra_v".
 *
 * The followings are the available columns in table 'lapanestesikomplikasiintra_v':
 * @property integer $pasienanastesi_id
 * @property string $noanestesi
 * @property string $tglanastesi
 * @property integer $intraanestesi_id
 * @property string $nointraanestesi
 * @property string $tglintraanestesi
 * @property string $komplikasiintra
 * @property integer $pasien_id
 * @property string $no_rekam_medik
 * @property string $nama_pasien
 * @property integer $ruangan_id
 * @property string $ruangan_nama
 * @property string $statusanestesi
 */

class ATLapanestesikomplikasiintraV extends LapanestesikomplikasiintraV
{
	public $jns_periode,$tgl_awal,$tgl_akhir,$bln_awal,$bln_akhir,$thn_awal,$thn_akhir,$pascaanestesi_id,$nopascaanestesi,$komplikasipasca;
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
		if(isset($_GET['ATLapanestesikomplikasiintraV'])){
			$tgl_awal = $format->formatDateTimeForDb($_GET['ATLapanestesikomplikasiintraV']['tgl_awal']);
			$tgl_akhir = $format->formatDateTimeForDb($_GET['ATLapanestesikomplikasiintraV']['tgl_akhir']);
			$tgl_awal = $tgl_awal." 00:00:00";
			$tgl_akhir = $tgl_akhir." 23:59:59";
		}
		if($this->jns_periode == "hari"){
			$criteria->addBetweenCondition('DATE(tglintraanestesi)',$this->tgl_awal,$this->tgl_akhir);
		}
		if($this->jns_periode == "bulan"){
			$criteria->addBetweenCondition("date_part('month',tglintraanestesi)",$bln_awal[1],$bln_akhir[1]);
		}
		if($this->jns_periode == "tahun"){
			$criteria->addBetweenCondition("date_part('year',tglintraanestesi)",$this->thn_awal,$this->thn_akhir);
		}
		
		$criteria->compare('pasienanastesi_id',$this->pasienanastesi_id);
		$criteria->compare('LOWER(noanestesi)',strtolower($this->noanestesi),true);
		$criteria->compare('intraanestesi_id',$this->intraanestesi_id);
		$criteria->compare('LOWER(nointraanestesi)',strtolower($this->nointraanestesi),true);
		$criteria->compare('komplikasiintra',$this->komplikasiintra,true);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('LOWER(no_rekam_medik)',strtolower($this->no_rekam_medik),true);
		$criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
		$criteria->compare('LOWER(statusanestesi)',strtolower($this->statusanestesi),true);

		return $criteria;
	}
	
	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function criteriaSearchPasca()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		
		$format = new MyFormatter();
		$bln_awal = explode('-',$this->bln_awal);
		$bln_akhir = explode('-',$this->bln_akhir);
		$tgl_awal = '';
		$tgl_akhir = '';
		if(isset($_GET['ATLapanestesikomplikasiintraV'])){
			$tgl_awal = $format->formatDateTimeForDb($_GET['ATLapanestesikomplikasiintraV']['tgl_awal']);
			$tgl_akhir = $format->formatDateTimeForDb($_GET['ATLapanestesikomplikasiintraV']['tgl_akhir']);
			$tgl_awal = $tgl_awal." 00:00:00";
			$tgl_akhir = $tgl_akhir." 23:59:59";
		}
		if($this->jns_periode == "hari"){
			$criteria->addBetweenCondition('DATE(tglpascaanestesi)',$this->tgl_awal,$this->tgl_akhir);
		}
		if($this->jns_periode == "bulan"){
			$criteria->addBetweenCondition("date_part('month',tglpascaanestesi)",$bln_awal[1],$bln_akhir[1]);
		}
		if($this->jns_periode == "tahun"){
			$criteria->addBetweenCondition("date_part('year',tglpascaanestesi)",$this->thn_awal,$this->thn_akhir);
		}
		
		$criteria->compare('pasienanastesi_id',$this->pasienanastesi_id);
		$criteria->compare('LOWER(noanestesi)',strtolower($this->noanestesi),true);
		$criteria->compare('pascaanestesi_id',$this->pascaanestesi_id);
		$criteria->compare('LOWER(nopascaanestesi)',strtolower($this->nopascaanestesi),true);
		$criteria->compare('komplikasipasca',$this->komplikasipasca,true);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('LOWER(no_rekam_medik)',strtolower($this->no_rekam_medik),true);
		$criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
		$criteria->compare('LOWER(statusanestesi)',strtolower($this->statusanestesi),true);

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
	public function searchLaporanPascaPrint()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
		$modPasca = new ATLapanestesikomplikasipascaV();
		$criteria=$this->criteriaSearchPasca();
		$criteria->limit=-1;

		return new CActiveDataProvider($modPasca, array(
				'criteria'=>$criteria,
				'pagination'=>false,
		));
	}
	
	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function searchLaporanPasca()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
		$modPasca = new ATLapanestesikomplikasipascaV();
		$criteria=$this->criteriaSearchPasca();
		$criteria->limit=10;

		return new CActiveDataProvider($modPasca, array(
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