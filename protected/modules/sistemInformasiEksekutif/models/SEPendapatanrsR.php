<?php

/**
 * This is the model class for table "pendapatanrs_r".
 *
 * The followings are the available columns in table 'pendapatanrs_r':
 * @property integer $pendapatanrs_id
 * @property string $tanggal
 * @property integer $rekening_id
 * @property string $rekening_nama
 * @property string $jumlah
 */
class SEPendapatanrsR extends PendapatanrsR
{
    public $jns_periode;
    public $periode, $id, $jumlah, $jenis;
    public $tgl_awal, $tgl_akhir, $bln_awal, $bln_akhir, $thn_awal, $thn_akhir;
    public $data, $data_2;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PendapatanrsR the static model class
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
		return 'pendapatanrs_r';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('rekening_id', 'numerical', 'integerOnly'=>true),
			array('rekening_nama', 'length', 'max'=>100),
			array('tanggal, jumlah', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pendapatanrs_id, tanggal, rekening_id, rekening_nama, jumlah', 'safe', 'on'=>'search'),
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
			'pendapatanrs_id' => 'Pendapatanrs',
			'tanggal' => 'Tanggal',
			'rekening_id' => 'Rekening',
			'rekening_nama' => 'Rekening Nama',
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

		if(!empty($this->pendapatanrs_id)){
			$criteria->addCondition('pendapatanrs_id = '.$this->pendapatanrs_id);
		}
		$criteria->compare('LOWER(tanggal)',strtolower($this->tanggal),true);
		if(!empty($this->rekening_id)){
			$criteria->addCondition('rekening_id = '.$this->rekening_id);
		}
		$criteria->compare('LOWER(rekening_nama)',strtolower($this->rekening_nama),true);
		$criteria->compare('LOWER(jumlah)',strtolower($this->jumlah),true);

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