<?php

/**
 * This is the model class for table "pengorganisasi_r".
 *
 * The followings are the available columns in table 'pengorganisasi_r':
 * @property integer $pengorganisasi_id
 * @property integer $pegawai_id
 * @property string $pengorganisasi_nama
 * @property string $pengorganisasi_kedudukan
 * @property string $pengorganisasi_lamanya
 * @property string $pengorganisasi_tahun
 * @property string $pengorganisasi_tempat
 */
class PengorganisasiR extends CActiveRecord
{
    public $nama_pegawai;
     public $lamanya;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PengorganisasiR the static model class
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
		return 'pengorganisasi_r';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pegawai_id, pengorganisasi_nama, pengorganisasi_lamanya', 'required'),
			array('pegawai_id', 'numerical', 'integerOnly'=>true),
			array('pengorganisasi_nama', 'length', 'max'=>50),
			array('pengorganisasi_kedudukan, pengorganisasi_tempat', 'length', 'max'=>30),
			array('pengorganisasi_lamanya', 'length', 'max'=>10),
			array('pengorganisasi_tahun', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pengorganisasi_id, pegawai_id, pengorganisasi_nama, pengorganisasi_kedudukan, pengorganisasi_lamanya, pengorganisasi_tahun, pengorganisasi_tempat', 'safe', 'on'=>'search'),
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
                    'pegawai'=>array(self::BELONGS_TO,'PegawaiM','pegawai_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pengorganisasi_id' => 'Pengorganisasi',
			'pegawai_id' => 'Pegawai',
			'pengorganisasi_nama' => 'Nama Pengorganisasi',
			'pengorganisasi_kedudukan' => 'Kedudukan Pengorganisasi',
			'pengorganisasi_lamanya' => 'Lama Pengorganisasi',
			'pengorganisasi_tahun' => 'Tahun Pengorganisasi',
			'pengorganisasi_tempat' => 'Tempat Pengorganisasi',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('pengorganisasi_id',$this->pengorganisasi_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('LOWER(pengorganisasi_nama)',strtolower($this->pengorganisasi_nama),true);
		$criteria->compare('LOWER(pengorganisasi_kedudukan)',strtolower($this->pengorganisasi_kedudukan),true);
		$criteria->compare('LOWER(pengorganisasi_lamanya)',strtolower($this->pengorganisasi_lamanya),true);
		$criteria->compare('LOWER(pengorganisasi_tahun)',strtolower($this->pengorganisasi_tahun),true);
		$criteria->compare('LOWER(pengorganisasi_tempat)',strtolower($this->pengorganisasi_tempat),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('pengorganisasi_id',$this->pengorganisasi_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('LOWER(pengorganisasi_nama)',strtolower($this->pengorganisasi_nama),true);
		$criteria->compare('LOWER(pengorganisasi_kedudukan)',strtolower($this->pengorganisasi_kedudukan),true);
		$criteria->compare('LOWER(pengorganisasi_lamanya)',strtolower($this->pengorganisasi_lamanya),true);
		$criteria->compare('LOWER(pengorganisasi_tahun)',strtolower($this->pengorganisasi_tahun),true);
		$criteria->compare('LOWER(pengorganisasi_tempat)',strtolower($this->pengorganisasi_tempat),true);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
        protected function beforeSave() {  
            if($this->pengorganisasi_tahun===null || trim($this->pengorganisasi_tahun)==''){
	        $this->setAttribute('pengorganisasi_tahun', null);
            }
            
            return parent::beforeSave();
        }
        
        protected function afterFind(){
            foreach($this->metadata->tableSchema->columns as $columnName => $column){
                if (!strlen($this->$columnName)) continue;
                if ($column->dbType == 'date'){
                    $this->$columnName = Yii::app()->dateFormatter->formatDateTime(
                                CDateTimeParser::parse($this->$columnName, 'yyyy-MM-dd'),'medium',null);
                }elseif ($column->dbType == 'timestamp without time zone'){
                    $this->$columnName = Yii::app()->dateFormatter->formatDateTime(
                            CDateTimeParser::parse($this->$columnName, 'yyyy-MM-dd hh:mm:ss','medium',null));
                }
            }
            return true;
        }        
}