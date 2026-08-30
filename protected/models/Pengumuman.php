<?php

/**
 * This is the model class for table "pengumuman".
 *
 * The followings are the available columns in table 'pengumuman':
 * @property integer $pengumuman_id
 * @property string $judul
 * @property string $isi
 * @property integer $status_publish
 * @property integer $create_loginpemakai_id
 * @property string $create_time
 * @property integer $update_loginpemakai_id
 * @property string $update_time
 * @property integer $publish_loginpemakai_id
 */
class Pengumuman extends CActiveRecord
{
        const STATUS_DRAFT=0;
	const STATUS_PUBLISH=1;
	const STATUS_ARSIP=2;
        public $status = array(0 =>'Draft',1 =>'Publish',2 =>'Arsip');
        
        public function daftarStatus()
        {
            return $this->status;
        }
        
        public function getStatusPublish()
        {
            return $this->status[$this->status_publish];
        }
        
        public function scopes() {
            return array(
                'published'=>array(
                      'condition'=>'status_publish='.self::STATUS_PUBLISH,
                ),
                'recently'=>array(
                      'order'=>'create_time DESC',
                      'limit'=>5,
                ),
            );
        }

        /**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Pengumuman the static model class
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
		return 'pengumuman';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('isi, status_publish, judul', 'required'),
			array('status_publish, create_loginpemakai_id, update_loginpemakai_id, publish_loginpemakai_id', 'numerical', 'integerOnly'=>true),
			array('judul', 'length', 'max'=>150),
			array('create_time, update_time, dokumen', 'safe'),
                    
                        array('create_time,update_time','default','value'=>date('Y-m-d H:i:s'),'setOnEmpty'=>false,'on'=>'insert'),
                        array('update_time','default','value'=>date('Y-m-d H:i:s'),'setOnEmpty'=>false,'on'=>'update'),
                        array('create_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'insert'),
                        array('update_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'update,insert'),
                    
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pengumuman_id, judul, isi, status_publish, create_loginpemakai_id, create_time, update_loginpemakai_id, update_time, publish_loginpemakai_id, dokumen', 'safe', 'on'=>'search'),
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
                    'userCreate'=>array(self::BELONGS_TO,  'LoginpemakaiK','create_loginpemakai_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pengumuman_id' => 'Pengumuman',
			'judul' => 'Judul',
			'isi' => 'Isi',
			'status_publish' => 'Status Publish',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'create_time' => 'Waktu Create',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'update_time' => 'Waktu Update',
			'publish_loginpemakai_id' => 'Publish Loginpemakai',
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

		$criteria->compare('pengumuman_id',$this->pengumuman_id);
		$criteria->compare('LOWER(judul)',strtolower($this->judul),true);
		$criteria->compare('LOWER(isi)',strtolower($this->isi),true);
		$criteria->compare('status_publish',$this->status_publish);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('publish_loginpemakai_id',$this->publish_loginpemakai_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('pengumuman_id',$this->pengumuman_id);
		$criteria->compare('LOWER(judul)',strtolower($this->judul),true);
		$criteria->compare('LOWER(isi)',strtolower($this->isi),true);
		$criteria->compare('status_publish',$this->status_publish);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('publish_loginpemakai_id',$this->publish_loginpemakai_id);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }

        protected function afterFind(){
            foreach($this->metadata->tableSchema->columns as $columnName => $column){

                if (!strlen($this->$columnName)) continue;

                if ($column->dbType == 'date'){                         
                        $this->$columnName = Yii::app()->dateFormatter->formatDateTime(
                                        CDateTimeParser::parse($this->$columnName, 'yyyy-MM-dd'),'medium',null);
                        }elseif ($column->dbType == 'timestamp without time zone'){
                                $this->$columnName = Yii::app()->dateFormatter->formatDateTime(
                                        CDateTimeParser::parse($this->$columnName, 'yyyy-MM-dd hh:mm:ss'));
                        }
            }
            return true;
        }
}