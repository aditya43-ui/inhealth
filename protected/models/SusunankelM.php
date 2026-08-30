<?php

/**
 * This is the model class for table "susunankel_m".
 *
 * The followings are the available columns in table 'susunankel_m':
 * @property integer $susunankel_id
 * @property integer $pegawai_id
 * @property integer $nourutkel
 * @property string $hubkeluarga
 * @property string $susunankel_nama
 * @property string $susunankel_jk
 * @property string $susunankel_tempatlahir
 * @property string $susunankel_tanggallahir
 * @property string $pekerjaan_nama
 * @property string $pendidikan_nama
 * @property string $susunankel_tanggalpernikahan
 * @property string $susunankel_tempatpernikahan
 * @property string $susunankeluarga_nip
 */
class SusunankelM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return SusunankelM the static model class
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
		return 'susunankel_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pegawai_id, hubkeluarga, susunankel_nama', 'required'),
			array('pegawai_id, nourutkel', 'numerical', 'integerOnly'=>true),
			array('hubkeluarga, susunankel_nama, susunankel_jk, pekerjaan_nama, pendidikan_nama', 'length', 'max'=>50),
			array('susunankel_tempatlahir, susunankeluarga_nip', 'length', 'max'=>30),
			array('nopesertabpjs', 'length', 'max'=>50),
			array('susunankel_tempatpernikahan', 'length', 'max'=>100),
			array('susunankel_tanggalpernikahan, no_kartu_keluarga', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('no_kartu_keluarga, susunankel_id, pegawai_id, nourutkel, hubkeluarga, susunankel_nama, susunankel_jk, susunankel_tempatlahir, susunankel_tanggallahir, pekerjaan_nama, pendidikan_nama, susunankel_tanggalpernikahan, susunankel_tempatpernikahan, susunankeluarga_nip, nopesertabpjs', 'safe', 'on'=>'search'),
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
			'susunankel_id' => 'Susunankel',
			'pegawai_id' => 'Pegawai',
			'nourutkel' => 'Nourutkel',
			'hubkeluarga' => 'Hubkeluarga',
			'susunankel_nama' => 'Susunankel Nama',
			'susunankel_jk' => 'Susunankel Jk',
			'susunankel_tempatlahir' => 'Susunankel Tempatlahir',
			'susunankel_tanggallahir' => 'Susunankel Tanggallahir',
			'pekerjaan_nama' => 'Pekerjaan Nama',
			'pendidikan_nama' => 'Pendidikan Nama',
			'susunankel_tanggalpernikahan' => 'Susunankel Tanggalpernikahan',
			'susunankel_tempatpernikahan' => 'Susunankel Tempatpernikahan',
			'susunankeluarga_nip' => 'Susunankeluarga Nip',
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

		$criteria->compare('susunankel_id',$this->susunankel_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('nourutkel',$this->nourutkel);
		$criteria->compare('LOWER(hubkeluarga)',strtolower($this->hubkeluarga),true);
		$criteria->compare('LOWER(susunankel_nama)',strtolower($this->susunankel_nama),true);
		$criteria->compare('LOWER(susunankel_jk)',strtolower($this->susunankel_jk),true);
		$criteria->compare('LOWER(susunankel_tempatlahir)',strtolower($this->susunankel_tempatlahir),true);
		$criteria->compare('LOWER(susunankel_tanggallahir)',strtolower($this->susunankel_tanggallahir),true);
		$criteria->compare('LOWER(pekerjaan_nama)',strtolower($this->pekerjaan_nama),true);
		$criteria->compare('LOWER(pendidikan_nama)',strtolower($this->pendidikan_nama),true);
		$criteria->compare('LOWER(susunankel_tanggalpernikahan)',strtolower($this->susunankel_tanggalpernikahan),true);
		$criteria->compare('LOWER(susunankel_tempatpernikahan)',strtolower($this->susunankel_tempatpernikahan),true);
		$criteria->compare('LOWER(susunankeluarga_nip)',strtolower($this->susunankeluarga_nip),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('susunankel_id',$this->susunankel_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('nourutkel',$this->nourutkel);
		$criteria->compare('LOWER(hubkeluarga)',strtolower($this->hubkeluarga),true);
		$criteria->compare('LOWER(susunankel_nama)',strtolower($this->susunankel_nama),true);
		$criteria->compare('LOWER(susunankel_jk)',strtolower($this->susunankel_jk),true);
		$criteria->compare('LOWER(susunankel_tempatlahir)',strtolower($this->susunankel_tempatlahir),true);
		$criteria->compare('LOWER(susunankel_tanggallahir)',strtolower($this->susunankel_tanggallahir),true);
		$criteria->compare('LOWER(pekerjaan_nama)',strtolower($this->pekerjaan_nama),true);
		$criteria->compare('LOWER(pendidikan_nama)',strtolower($this->pendidikan_nama),true);
		$criteria->compare('LOWER(susunankel_tanggalpernikahan)',strtolower($this->susunankel_tanggalpernikahan),true);
		$criteria->compare('LOWER(susunankel_tempatpernikahan)',strtolower($this->susunankel_tempatpernikahan),true);
		$criteria->compare('LOWER(susunankeluarga_nip)',strtolower($this->susunankeluarga_nip),true);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
        
        protected function beforeSave() {  
            if($this->susunankel_tanggallahir===null || trim($this->susunankel_tanggallahir)==''){
	        $this->setAttribute('susunankel_tanggallahir', null);
            }
            if($this->susunankel_tanggalpernikahan===null || trim($this->susunankel_tanggalpernikahan)==''){
	        $this->setAttribute('susunankel_tanggalpernikahan', null);
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