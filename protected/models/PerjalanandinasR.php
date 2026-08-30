<?php

/**
 * This is the model class for table "perjalanandinas_r".
 *
 * The followings are the available columns in table 'perjalanandinas_r':
 * @property integer $perjalanandinas_id
 * @property integer $pegawai_id
 * @property integer $nourutperj
 * @property string $tujuandinas
 * @property string $tugasdinas
 * @property string $descdinas
 * @property string $alamattujuan
 * @property string $propinsi_nama
 * @property string $kotakabupaten_nama
 * @property string $tglmulaidinas
 * @property string $sampaidengan
 * @property string $negaratujuan
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 */
class PerjalanandinasR extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PerjalanandinasR the static model class
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
		return 'perjalanandinas_r';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pegawai_id, nourutperj, tujuandinas, tglmulaidinas', 'required'),
			array('pegawai_id, nourutperj', 'numerical', 'integerOnly'=>true),
			array('tujuandinas', 'length', 'max'=>200),
			array('propinsi_nama', 'length', 'max'=>50),
			array('kotakabupaten_nama, negaratujuan', 'length', 'max'=>100),
			array('tugasdinas,descdinas,alamattujuan,sampaidengan,create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
                        array('create_time,update_time','default','value'=>date( 'Y-m-d H:i:s'),'setOnEmpty'=>false,'on'=>'insert'),
                        array('update_time','default','value'=>date( 'Y-m-d H:i:s'),'setOnEmpty'=>false,'on'=>'update'),
                        array('create_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'insert'),
                        array('update_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'update,insert'),
                        array('create_ruangan','default','value'=>Yii::app()->user->getState('ruangan_id'),'on'=>'insert'),
			array('perjalanandinas_id, pegawai_id, nourutperj, tujuandinas, tugasdinas, descdinas, alamattujuan, propinsi_nama, kotakabupaten_nama, tglmulaidinas, sampaidengan, negaratujuan, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'perjalanandinas_id' => 'Perjalanandinas',
			'pegawai_id' => 'Pegawai',
			'nourutperj' => 'Nourutperj',
			'tujuandinas' => 'Tujuandinas',
			'tugasdinas' => 'Tugasdinas',
			'descdinas' => 'Descdinas',
			'alamattujuan' => 'Alamattujuan',
			'propinsi_nama' => 'Propinsi Nama',
			'kotakabupaten_nama' => 'Kotakabupaten Nama',
			'tglmulaidinas' => 'Tglmulaidinas',
			'sampaidengan' => 'Sampaidengan',
			'negaratujuan' => 'Negaratujuan',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
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

		$criteria->compare('perjalanandinas_id',$this->perjalanandinas_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('nourutperj',$this->nourutperj);
		$criteria->compare('LOWER(tujuandinas)',strtolower($this->tujuandinas),true);
		$criteria->compare('LOWER(tugasdinas)',strtolower($this->tugasdinas),true);
		$criteria->compare('LOWER(descdinas)',strtolower($this->descdinas),true);
		$criteria->compare('LOWER(alamattujuan)',strtolower($this->alamattujuan),true);
		$criteria->compare('LOWER(propinsi_nama)',strtolower($this->propinsi_nama),true);
		$criteria->compare('LOWER(kotakabupaten_nama)',strtolower($this->kotakabupaten_nama),true);
		$criteria->compare('LOWER(tglmulaidinas)',strtolower($this->tglmulaidinas),true);
		$criteria->compare('LOWER(sampaidengan)',strtolower($this->sampaidengan),true);
		$criteria->compare('LOWER(negaratujuan)',strtolower($this->negaratujuan),true);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('perjalanandinas_id',$this->perjalanandinas_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('nourutperj',$this->nourutperj);
		$criteria->compare('LOWER(tujuandinas)',strtolower($this->tujuandinas),true);
		$criteria->compare('LOWER(tugasdinas)',strtolower($this->tugasdinas),true);
		$criteria->compare('LOWER(descdinas)',strtolower($this->descdinas),true);
		$criteria->compare('LOWER(alamattujuan)',strtolower($this->alamattujuan),true);
		$criteria->compare('LOWER(propinsi_nama)',strtolower($this->propinsi_nama),true);
		$criteria->compare('LOWER(kotakabupaten_nama)',strtolower($this->kotakabupaten_nama),true);
		$criteria->compare('LOWER(tglmulaidinas)',strtolower($this->tglmulaidinas),true);
		$criteria->compare('LOWER(sampaidengan)',strtolower($this->sampaidengan),true);
		$criteria->compare('LOWER(negaratujuan)',strtolower($this->negaratujuan),true);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
        protected function beforeSave() {  
            if($this->tglmulaidinas===null || trim($this->tglmulaidinas)==''){
	        $this->setAttribute('tglmulaidinas', null);
            }
            if($this->sampaidengan===null || trim($this->sampaidengan)==''){
	        $this->setAttribute('sampaidengan', null);
            }
            
            return parent::beforeSave();
        }
        protected function beforeValidate ()
        {
            // convert to storage format
            //$this->tglrevisimodul = date ('Y-m-d', strtotime($this->tglrevisimodul));
            $format = new MyFormatter();
            foreach($this->metadata->tableSchema->columns as $columnName => $column){
                    if ($column->dbType == 'date'){
                            $this->$columnName = $format->formatDateTimeForDb($this->$columnName);
                    }elseif ($column->dbType == 'timestamp without time zone'){
                            //$this->$columnName = date('Y-m-d H:i:s', CDateTimeParser::parse($this->$columnName, Yii::app()->locale->dateFormat));
                            $this->$columnName = $format->formatDateTimeForDb($this->$columnName);
                    }
            }

            return parent::beforeValidate ();
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