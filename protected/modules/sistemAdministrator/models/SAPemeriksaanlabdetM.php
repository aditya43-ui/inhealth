<?php

class SAPemeriksaanlabdetM extends PemeriksaanlabdetM{
	public $pemeriksaanlab_nama; //untuk pencarian
	public $kelompokdet; //untuk pencarian
	public $namapemeriksaandet; //untuk pencarian
	public $nilairujukan_jeniskelamin; //untuk pencarian
	public $nilairujukan_nama; //untuk pencarian
	public $nilairujukan_min; //untuk pencarian
	public $nilairujukan_max; //untuk pencarian
	public $nilairujukan_satuan; //untuk pencarian
    public $kelkumurhasillab_id; //untuk pencarian
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PemeriksaanlabM the static model class
	 */

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CdbCriteria that can return criterias.
	 */
	public function criteriaSearch()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$criteria->with = array('pemeriksaanlab','nilairujukan');
		$criteria->compare('pemeriksaanlabdet_nourut', $this->pemeriksaanlabdet_nourut);
		$criteria->compare('LOWER(pemeriksaanlab.pemeriksaanlab_nama)', strtolower($this->pemeriksaanlab_nama), true);
		$criteria->compare('LOWER(nilairujukan.kelompokdet)', strtolower($this->kelompokdet), true);
		$criteria->compare('LOWER(nilairujukan.namapemeriksaandet)', strtolower($this->namapemeriksaandet), true);
		$criteria->compare('LOWER(nilairujukan.nilairujukan_jeniskelamin)', strtolower($this->nilairujukan_jeniskelamin), true);
		$criteria->compare('LOWER(nilairujukan.nilairujukan_nama)', strtolower($this->nilairujukan_nama), true);
		$criteria->compare('nilairujukan.nilairujukan_min', $this->nilairujukan_min);
		$criteria->compare('nilairujukan.nilairujukan_max', $this->nilairujukan_max);
		$criteria->compare('LOWER(nilairujukan.nilairujukan_satuan)', strtolower($this->nilairujukan_satuan), true);
		$criteria->compare('nilairujukan.kelkumurhasillab_id', $this->kelkumurhasillab_id);

		return $criteria;
	}
        
        
	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=$this->criteriaSearch();
		$criteria->limit=10;
		//$criteria->order = 't.pemeriksaanlab_id, kelompokdet, namapemeriksaandet, pemeriksaanlab_urutan, pemeriksaanlabdet_nourut ASC';
		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
                                'sort' => array(
                                    'attributes' => array(
                                        'pemeriksaanlab_nama' => array(
                                            'asc' => 'pemeriksaanlab.pemeriksaanlab_nama ASC',
                                            'desc' => 'pemeriksaanlab.pemeriksaanlab_nama DESC',
                                        ),//pemeriksaanlabdet_id
                                        'kelompokdet' => array(
                                            'asc' => 'kelompokdet ASC',
                                            'desc' => 'kelompokdet DESC',
                                        ),
                                        'namapemeriksaandet' => array(
                                            'asc' => 'namapemeriksaandet ASC',
                                            'desc' => 'namapemeriksaandet DESC',
                                        ),//kelompokdet
                                        'nilairujukan_jeniskelamin' => array(
                                            'asc' => 'nilairujukan.nilairujukan_jeniskelamin ASC',
                                            'desc' => 'nilairujukan.nilairujukan_jeniskelamin DESC',
                                        ),//
                                        'nilairujukan_nama' => array(
                                            'asc' => 'nilairujukan.nilairujukan_nama ASC',
                                            'desc' => 'nilairujukan.nilairujukan_nama DESC',
                                        ),
                                         'nilairujukan_min' => array(
                                            'asc' => 'nilairujukan.nilairujukan_min ASC',
                                            'desc' => 'nilairujukan.nilairujukan_min DESC',
                                        ),
                                         'nilairujukan_max' => array(
                                            'asc' => 'nilairujukan.nilairujukan_max ASC',
                                            'desc' => 'nilairujukan.nilairujukan_max DESC',
                                        ),//
                                        'nilairujukan_satuan' => array(
                                            'asc' => 'nilairujukan.nilairujukan_satuan ASC',
                                            'desc' => 'nilairujukan.nilairujukan_satuan DESC',
                                        ),
                                        '*',
                                    ),
                                ),
		));
	}


	public function searchPrint()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=$this->criteriaSearch();
		$criteria->limit=-1; 
		$criteria->order = 't.pemeriksaanlab_id, kelompokdet, namapemeriksaandet, pemeriksaanlab_urutan, pemeriksaanlabdet_nourut ASC';

		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
				'pagination'=>false,
		));
	}
	
	public function getKelompokDet($pemeriksaanlabdet_id)
	{
		$mod = PemeriksaanlabdetV::model()->findByAttributes(array('pemeriksaanlabdet_id'=>$pemeriksaanlabdet_id));
		if(!empty($mod))
			$ret = $mod['namapemeriksaandet'];
		else
			$ret = "-";
		return $ret;
	}
	public function getNamaPemeriksaanDet($pemeriksaanlabdet_id)
	{
		$mod = PemeriksaanlabdetV::model()->findByAttributes(array('pemeriksaanlabdet_id'=>$pemeriksaanlabdet_id));
		if(!empty($mod))
			$ret = $mod['namapemeriksaandet'];
		else
			$ret = "-";
		return $ret;
	}
	/**
	 * nilai yang sudah ada converting symbol
	 */
	public function getNilaiRujukan(){
		return CustomFunction::symbolsConverter($this->nilairujukan->nilairujukan_nama);
	}
               
	public function getNilaiSatuan(){
		return CustomFunction::symbolsConverter($this->nilairujukan_satuan);
	}
}
