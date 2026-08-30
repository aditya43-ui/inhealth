<?php

/**
 * This is the model class for table "kesimpulanpenilaian_t".
 *
 * The followings are the available columns in table 'kesimpulanpenilaian_t':
 * @property integer $kesimpulanpenilaian_id
 * @property string $tglkesimpulan
 * @property integer $pegawai_pemberisaran
 * @property double $totalpenilaian
 * @property double $ratapenilaian
 * @property string $kesimpulan
 * @property string $saran
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 */
class KesimpulanpenilaianT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return KesimpulanpenilaianT the static model class
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
		return 'kesimpulanpenilaian_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tglkesimpulan, create_time, create_loginpemakai_id', 'required'),
			array('pegawai_pemberisaran', 'numerical', 'integerOnly'=>true),
			array('totalpenilaian, ratapenilaian', 'numerical'),
			array('kesimpulan, saran, update_time, update_loginpemakai_id, create_ruangan', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('kesimpulanpenilaian_id, tglkesimpulan, pegawai_pemberisaran, totalpenilaian, ratapenilaian, kesimpulan, saran, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'pegawai_pemberisaran' => array(self::BELONGS_TO, 'PegawaiM', 'pegawai_pemberisaran'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'kesimpulanpenilaian_id' => 'Kesimpulanpenilaian',
			'tglkesimpulan' => 'Tanggal Pembuatan Kesimpulan dan Saran',
			'pegawai_pemberisaran' => 'Pegawai Pembuat Kesimpulan dan Saran',
			'totalpenilaian' => 'Totalpenilaian',
			'ratapenilaian' => 'Ratapenilaian',
			'kesimpulan' => 'Kesimpulan',
			'saran' => 'Saran',
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

		if(!empty($this->kesimpulanpenilaian_id)){
			$criteria->addCondition('kesimpulanpenilaian_id = '.$this->kesimpulanpenilaian_id);
		}
		$criteria->compare('LOWER(tglkesimpulan)',strtolower($this->tglkesimpulan),true);
		if(!empty($this->pegawai_pemberisaran)){
			$criteria->addCondition('pegawai_pemberisaran = '.$this->pegawai_pemberisaran);
		}
		$criteria->compare('totalpenilaian',$this->totalpenilaian);
		$criteria->compare('ratapenilaian',$this->ratapenilaian);
		$criteria->compare('LOWER(kesimpulan)',strtolower($this->kesimpulan),true);
		$criteria->compare('LOWER(saran)',strtolower($this->saran),true);
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