<?php

/**
 * This is the model class for table "pegawaijabatan_r".
 *
 * The followings are the available columns in table 'pegawaijabatan_r':
 * @property integer $pegawaijabatan_id
 * @property integer $pegawai_id
 * @property string $tmtjabatan
 * @property string $tglakhirjabatan
 * @property string $nomorkeputusanjabatan
 * @property string $tglditetapkanjabatan
 * @property string $pejabatygmemjabatan
 * @property string $keterangan
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 */
class PegawaijabatanR extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PegawaijabatanR the static model class
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
		return 'pegawaijabatan_r';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pegawai_id, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('pegawai_id', 'numerical', 'integerOnly'=>true),
			array('nomorkeputusanjabatan', 'length', 'max'=>50),
			array('pejabatygmemjabatan', 'length', 'max'=>100),
			array('tmtjabatan, tglakhirjabatan, tglditetapkanjabatan, keterangan, update_time, update_loginpemakai_id', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pegawaijabatan_id, pegawai_id, tmtjabatan, tglakhirjabatan, nomorkeputusanjabatan, tglditetapkanjabatan, pejabatygmemjabatan, keterangan, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'pegawaijabatan_id' => 'ID',
			'pegawai_id' => 'Pegawai',
			'tmtjabatan' => 'TMT Jabatan',
			'tglakhirjabatan' => 'Tanggal akhir jabatan',
			'nomorkeputusanjabatan' => 'No. SK',
			'tglditetapkanjabatan' => 'Tanggal ditetapkan',
			'pejabatygmemjabatan' => 'Pejabat yang menetapkan',
			'keterangan' => 'Keterangan',
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

		$criteria->compare('pegawaijabatan_id',$this->pegawaijabatan_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('LOWER(tmtjabatan)',strtolower($this->tmtjabatan),true);
		$criteria->compare('LOWER(tglakhirjabatan)',strtolower($this->tglakhirjabatan),true);
		$criteria->compare('LOWER(nomorkeputusanjabatan)',strtolower($this->nomorkeputusanjabatan),true);
		$criteria->compare('LOWER(tglditetapkanjabatan)',strtolower($this->tglditetapkanjabatan),true);
		$criteria->compare('LOWER(pejabatygmemjabatan)',strtolower($this->pejabatygmemjabatan),true);
		$criteria->compare('LOWER(keterangan)',strtolower($this->keterangan),true);
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
		$criteria->compare('pegawaijabatan_id',$this->pegawaijabatan_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('LOWER(tmtjabatan)',strtolower($this->tmtjabatan),true);
		$criteria->compare('LOWER(tglakhirjabatan)',strtolower($this->tglakhirjabatan),true);
		$criteria->compare('LOWER(nomorkeputusanjabatan)',strtolower($this->nomorkeputusanjabatan),true);
		$criteria->compare('LOWER(tglditetapkanjabatan)',strtolower($this->tglditetapkanjabatan),true);
		$criteria->compare('LOWER(pejabatygmemjabatan)',strtolower($this->pejabatygmemjabatan),true);
		$criteria->compare('LOWER(keterangan)',strtolower($this->keterangan),true);
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
        
        public function getPegawaiItems() {
            return PegawaiM::model()->findAll('pegawai_aktif=TRUE ORDER BY nama_pegawai');
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