<?php

/**
 * This is the model class for table "izintugasbelajar_r".
 *
 * The followings are the available columns in table 'izintugasbelajar_r':
 * @property integer $izintugasbelajar_id
 * @property integer $pegawai_id
 * @property string $tglmulaibelajar
 * @property string $nomorkeputusan
 * @property string $tglditetapkan
 * @property string $pejabatmemutuskan
 * @property string $keteranganizin
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 */
class IzintugasbelajarR extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return IzintugasbelajarR the static model class
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
		return 'izintugasbelajar_r';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pegawai_id, tglmulaibelajar, nomorkeputusan, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('pegawai_id', 'numerical', 'integerOnly'=>true),
			array('nomorkeputusan', 'length', 'max'=>50),
			array('pejabatmemutuskan', 'length', 'max'=>100),
			array('tglselesaibelajar,tglditetapkan, keteranganizin, update_time, update_loginpemakai_id', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('izintugasbelajar_id, pegawai_id, tglmulaibelajar, nomorkeputusan, tglditetapkan,tglselesaibelajar, pejabatmemutuskan, keteranganizin, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'izintugasbelajar_id' => 'ID',
			'pegawai_id' => 'Pegawai',
			'tglmulaibelajar' => 'Tanggal Mulai Belajar',
			'tglselesaibelajar' => 'Tanggal Selesai Belajar',
			'nomorkeputusan' => 'Nomor Keputusan',
			'tglditetapkan' => 'Tanggal Ditetapkan',
			'pejabatmemutuskan' => 'Pejabat Yang Memutuskan',
			'keteranganizin' => 'Keterangan',
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

		$criteria->compare('izintugasbelajar_id',$this->izintugasbelajar_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('LOWER(tglmulaibelajar)',strtolower($this->tglmulaibelajar),true);
		$criteria->compare('LOWER(nomorkeputusan)',strtolower($this->nomorkeputusan),true);
		$criteria->compare('LOWER(tglditetapkan)',strtolower($this->tglditetapkan),true);
		$criteria->compare('LOWER(pejabatmemutuskan)',strtolower($this->pejabatmemutuskan),true);
		$criteria->compare('LOWER(keteranganizin)',strtolower($this->keteranganizin),true);
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
		$criteria->compare('izintugasbelajar_id',$this->izintugasbelajar_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('LOWER(tglmulaibelajar)',strtolower($this->tglmulaibelajar),true);
		$criteria->compare('LOWER(nomorkeputusan)',strtolower($this->nomorkeputusan),true);
		$criteria->compare('LOWER(tglditetapkan)',strtolower($this->tglditetapkan),true);
		$criteria->compare('LOWER(pejabatmemutuskan)',strtolower($this->pejabatmemutuskan),true);
		$criteria->compare('LOWER(keteranganizin)',strtolower($this->keteranganizin),true);
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