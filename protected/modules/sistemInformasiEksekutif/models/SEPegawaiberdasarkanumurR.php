<?php

/**
 * This is the model class for table "pegawaiberdasarkanumur_r".
 *
 * The followings are the available columns in table 'pegawaiberdasarkanumur_r':
 * @property integer $pegawaiberdasarkanumur_id
 * @property string $umur
 * @property integer $lakilaki
 * @property integer $perempuan
 * @property string $create_time
 * @property string $update_time
 */
class SEPegawaiberdasarkanumurR extends PegawaiberdasarkanumurR
{
    public $jns_periode;
    public $periode, $jumlah_l, $jumlah_p, $jenis;
    public $dataPieChartPdk;
    public $tgl_awal, $tgl_akhir, $bln_awal, $bln_akhir, $thn_awal, $thn_akhir;
    public $data, $data_2;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PegawaiberdasarkanumurR the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'pegawaiberdasarkanumur_r';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('lakilaki, perempuan', 'numerical', 'integerOnly'=>true),
			array('umur', 'length', 'max'=>5),
			array('create_time, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pegawaiberdasarkanumur_id, umur, lakilaki, perempuan, create_time, update_time', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pegawaiberdasarkanumur_id' => 'Pegawaiberdasarkanumur',
			'umur' => 'Umur',
			'lakilaki' => 'Lakilaki',
			'perempuan' => 'Perempuan',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
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

		if(!empty($this->pegawaiberdasarkanumur_id)){
			$criteria->addCondition('pegawaiberdasarkanumur_id = '.$this->pegawaiberdasarkanumur_id);
		}
		$criteria->compare('LOWER(umur)',strtolower($this->umur),true);
		if(!empty($this->lakilaki)){
			$criteria->addCondition('lakilaki = '.$this->lakilaki);
		}
		if(!empty($this->perempuan)){
			$criteria->addCondition('perempuan = '.$this->perempuan);
		}
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);

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


        public function searchPrint()
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