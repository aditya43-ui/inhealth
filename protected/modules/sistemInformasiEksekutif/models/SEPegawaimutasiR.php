<?php

    class SEPegawaimutasiR extends PegmutasiR
    {
        public $jns_periode;
        public $periode, $jumlah;
        public $tgl_awal, $tgl_akhir, $bln_awal, $bln_akhir, $thn_awal, $thn_akhir;
        public $data, $data_2;
        public $unitkerja_id;
        /**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InformasipegawaimutasiR the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('jumlah', 'numerical', 'integerOnly'=>true),
			array('tanggal', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('tgl_awal, tgl_akhir, unitkerja_id', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations() {
            return array(
                'pegawai' => array(self::BELONGS_TO, 'PegawaiM', 'pegawai_id'),
            );
        }

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'informasipegawaimutasi_id' => 'Informasipegawaimutasi',
			'tanggal' => 'Tanggal',
			'jumlah' => 'Jumlah',
		);
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

		if(!empty($this->informasipegawaimutasi_id)){
			$criteria->addCondition('informasipegawaimutasi_id = '.$this->informasipegawaimutasi_id);
		}
		$criteria->compare('LOWER(tanggal)',strtolower($this->tanggal),true);
		if(!empty($this->jumlah)){
			$criteria->addCondition('jumlah = '.$this->jumlah);
		}

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

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
        }
        
        public function getData()
        {
            if(!empty($this->unitkerja_id)){
                $unit   = "'" . implode("', '", $this->unitkerja_id) . "'";
                $criteria->addCondition("t.unitkerja IN(".$unit.")");
            }
            
            $criteria   = New CDbCriteria;
            $criteria->addCondition('t.tglsk BETWEEN \''.$this->tgl_awal.'\' and \''.$this->tgl_akhir.'\'');
            $data       = PegmutasiR::model()->findAll($criteria);
            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
                    'pagination'=>false,
            ));
        }

        public function searchPrint()
        {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=$this->getData();
            //$criteria->limit=-1; 

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
                    'pagination'=>false,
            ));
        }
    }