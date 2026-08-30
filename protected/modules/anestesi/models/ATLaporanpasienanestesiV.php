<?php

/**
 * This is the model class for table "laporanpasienanestesi_v".
 *
 * The followings are the available columns in table 'laporanpasienanestesi_v':
 * @property integer $pasienanastesi_id
 * @property string $tglanastesi
 * @property string $noanestesi
 * @property integer $pasien_id
 * @property string $no_rekam_medik
 * @property string $nama_pasien
 * @property string $jeniskelamin
 * @property string $alamat_pasien
 * @property integer $pendaftaran_id
 * @property string $no_pendaftaran
 * @property string $umur
 * @property integer $typeanastesi_id
 * @property string $typeanastesi_nama
 * @property string $statusanestesi
 */

class ATLaporanpasienanestesiV extends LaporanpasienanestesiV
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
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pasienanastesi_id' => 'Pasienanastesi',
			'tglanastesi' => 'Tgl. Anastesi',
			'noanestesi' => 'No. Anestesi',
			'pasien_id' => 'Pasien',
			'no_rekam_medik' => 'No Rekam Medik',
			'nama_pasien' => 'Nama Pasien',
			'jeniskelamin' => 'Jenis Kelamin',
			'alamat_pasien' => 'Alamat Pasien',
			'pendaftaran_id' => 'Pendaftaran',
			'no_pendaftaran' => 'No Pendaftaran',
			'umur' => 'Umur',
			'typeanastesi_id' => 'Tipe Anastesi',
			'typeanastesi_nama' => 'Tipe Anastesi',
			'statusanestesi' => 'Status Anestesi',
		);
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
		if(isset($_GET['ATLaporanpasienanestesiV'])){
			$tgl_awal = $format->formatDateTimeForDb($_GET['ATLaporanpasienanestesiV']['tgl_awal']);
			$tgl_akhir = $format->formatDateTimeForDb($_GET['ATLaporanpasienanestesiV']['tgl_akhir']);
			$tgl_awal = $tgl_awal." 00:00:00";
			$tgl_akhir = $tgl_akhir." 23:59:59";
		}
		if($this->jns_periode == "hari"){
			$criteria->addBetweenCondition('DATE(tglanastesi)',$this->tgl_awal,$this->tgl_akhir);
		}
		if($this->jns_periode == "bulan"){
			$criteria->addBetweenCondition("date_part('month',tglanastesi)",$bln_awal[1],$bln_akhir[1]);
		}
		if($this->jns_periode == "tahun"){
			$criteria->addBetweenCondition("date_part('year',tglanastesi)",$this->thn_awal,$this->thn_akhir);
		}
		
		$criteria->compare('pasienanastesi_id',$this->pasienanastesi_id);
		$criteria->compare('LOWER(noanestesi)',strtolower($this->noanestesi),true);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('LOWER(no_rekam_medik)',  strtolower($this->no_rekam_medik),true);
		$criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);
		$criteria->compare('LOWER(jeniskelamin)',strtolower($this->jeniskelamin),true);
		$criteria->compare('LOWER(alamat_pasien)',strtolower($this->alamat_pasien),true);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('LOWER(no_pendaftaran)',strtolower($this->no_pendaftaran),true);
		$criteria->compare('umur',$this->umur,true);
		$criteria->compare('typeanastesi_id',$this->typeanastesi_id);
		$criteria->compare('LOWER(typeanastesi_nama)',strtolower($this->typeanastesi_nama),true);
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