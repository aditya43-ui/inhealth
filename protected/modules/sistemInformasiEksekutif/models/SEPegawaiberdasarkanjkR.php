<?php

/**
 * This is the model class for table "pegawaiberdasarkanjk_r".
 *
 * The followings are the available columns in table 'pegawaiberdasarkanjk_r':
 * @property integer $pegawaiberdasarkanjk_id
 * @property string $tanggal
 * @property integer $lakilaki
 * @property integer $perempuan
 */
class SEPegawaiberdasarkanjkR extends PegawaiberdasarkanjkR
{
    public $jns_periode;
    public $periode, $jumlah_lakilaki, $jumlah_perempuan;
    public $tgl_awal, $tgl_akhir, $bln_awal, $bln_akhir, $thn_awal, $thn_akhir;
    public $data, $data_2;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PegawaiberdasarkanjkR the static model class
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
		return 'pegawaiberdasarkanjk_r';
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
			array('tanggal', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pegawaiberdasarkanjk_id, tanggal, lakilaki, perempuan', 'safe', 'on'=>'search'),
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
			'pegawaiberdasarkanjk_id' => 'Pegawaiberdasarkanjk',
			'tanggal' => 'Tanggal',
			'lakilaki' => 'Lakilaki',
			'perempuan' => 'Perempuan',
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

		if(!empty($this->pegawaiberdasarkanjk_id)){
			$criteria->addCondition('pegawaiberdasarkanjk_id = '.$this->pegawaiberdasarkanjk_id);
		}
		$criteria->compare('LOWER(tanggal)',strtolower($this->tanggal),true);
		if(!empty($this->lakilaki)){
			$criteria->addCondition('lakilaki = '.$this->lakilaki);
		}
		if(!empty($this->perempuan)){
			$criteria->addCondition('perempuan = '.$this->perempuan);
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