<?php

/**
 * This is the model class for table "kesimpulanpenilaiandet_t".
 *
 * The followings are the available columns in table 'kesimpulanpenilaiandet_t':
 * @property integer $kesimpulanpenilaiandet_id
 * @property integer $kesimpulanpenilaian_id
 * @property integer $penilaianpegawai_id
 * @property string $penilainip
 * @property string $penilainama
 * @property string $penilaianpegawai_keterangan
 * @property integer $jumlahpenilaian
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 */
class KesimpulanpenilaiandetT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return KesimpulanpenilaiandetT the static model class
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
		return 'kesimpulanpenilaiandet_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('penilaianpegawai_id, create_time, create_loginpemakai_id', 'required'),
			array('kesimpulanpenilaian_id, penilaianpegawai_id, jumlahpenilaian', 'numerical', 'integerOnly'=>true),
			array('penilainip', 'length', 'max'=>50),
			array('penilainama', 'length', 'max'=>100),
			array('penilaianpegawai_keterangan, update_time, update_loginpemakai_id, create_ruangan', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('kesimpulanpenilaiandet_id, kesimpulanpenilaian_id, penilaianpegawai_id, penilainip, penilainama, penilaianpegawai_keterangan, jumlahpenilaian, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'penilaianpegawai_id' => array(self::BELONGS_TO, 'PegawaiM', 'penilaianpegawai_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'kesimpulanpenilaiandet_id' => 'Kesimpulanpenilaiandet',
			'kesimpulanpenilaian_id' => 'Kesimpulanpenilaian',
			'penilaianpegawai_id' => 'Penilaianpegawai',
			'penilainip' => 'Penilainip',
			'penilainama' => 'Penilainama',
			'penilaianpegawai_keterangan' => 'Penilaianpegawai Keterangan',
			'jumlahpenilaian' => 'Jumlahpenilaian',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
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

		if(!empty($this->kesimpulanpenilaiandet_id)){
			$criteria->addCondition('kesimpulanpenilaiandet_id = '.$this->kesimpulanpenilaiandet_id);
		}
		if(!empty($this->kesimpulanpenilaian_id)){
			$criteria->addCondition('kesimpulanpenilaian_id = '.$this->kesimpulanpenilaian_id);
		}
		if(!empty($this->penilaianpegawai_id)){
			$criteria->addCondition('penilaianpegawai_id = '.$this->penilaianpegawai_id);
		}
		$criteria->compare('LOWER(penilainip)',strtolower($this->penilainip),true);
		$criteria->compare('LOWER(penilainama)',strtolower($this->penilainama),true);
		$criteria->compare('LOWER(penilaianpegawai_keterangan)',strtolower($this->penilaianpegawai_keterangan),true);
		if(!empty($this->jumlahpenilaian)){
			$criteria->addCondition('jumlahpenilaian = '.$this->jumlahpenilaian);
		}
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);

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