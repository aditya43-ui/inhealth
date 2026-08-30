<?php

/**
 * This is the model class for table "penilaianpegawaidet_t".
 *
 * The followings are the available columns in table 'penilaianpegawaidet_t':
 * @property integer $penilaianpegawaidet_id
 * @property integer $kompetensi_id
 * @property integer $indikatorperilaku_id
 * @property integer $jenispenilaian_id
 * @property integer $penilaianpegawai_id
 * @property integer $penilaianpegdet_socre
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 */
class PenilaianpegawaidetT extends CActiveRecord
{
	public $jenispenilaian_nama;
	public $jumlah;
	public $nilai;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PenilaianpegawaidetT the static model class
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
		return 'penilaianpegawaidet_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('kompetensi_id, indikatorperilaku_id, jenispenilaian_id, penilaianpegawai_id, penilaianpegdet_socre, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('kompetensi_id, indikatorperilaku_id, jenispenilaian_id, penilaianpegawai_id, penilaianpegdet_socre, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('keterangan, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('penilaianpegawaidet_id, kompetensi_id, indikatorperilaku_id, jenispenilaian_id, penilaianpegawai_id, penilaianpegdet_socre, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'jenispenilaian'=>array(self::BELONGS_TO,'JenispenilaianM','jenispenilaian_id'),
			'kompetensi'=>array(self::BELONGS_TO,'KompetensiM','kompetensi_id'),
			'indikatorperilaku'=>array(self::BELONGS_TO,'IndikatorperilakuM','indikatorperilaku_id'),
			'kolomrating'=>array(self::BELONGS_TO,'KolomratingM','kolomrating_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'penilaianpegawaidet_id' => 'Penilaianpegawaidet',
			'kompetensi_id' => 'Kompetensi',
			'indikatorperilaku_id' => 'Indikatorperilaku',
			'jenispenilaian_id' => 'Jenispenilaian',
			'penilaianpegawai_id' => 'Penilaianpegawai',
			'penilaianpegdet_socre' => 'Penilaianpegdet Socre',
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

		if(!empty($this->penilaianpegawaidet_id)){
			$criteria->addCondition('penilaianpegawaidet_id = '.$this->penilaianpegawaidet_id);
		}
		if(!empty($this->kompetensi_id)){
			$criteria->addCondition('kompetensi_id = '.$this->kompetensi_id);
		}
		if(!empty($this->indikatorperilaku_id)){
			$criteria->addCondition('indikatorperilaku_id = '.$this->indikatorperilaku_id);
		}
		if(!empty($this->jenispenilaian_id)){
			$criteria->addCondition('jenispenilaian_id = '.$this->jenispenilaian_id);
		}
		if(!empty($this->penilaianpegawai_id)){
			$criteria->addCondition('penilaianpegawai_id = '.$this->penilaianpegawai_id);
		}
		if(!empty($this->penilaianpegdet_socre)){
			$criteria->addCondition('penilaianpegdet_socre = '.$this->penilaianpegdet_socre);
		}
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		if(!empty($this->create_loginpemakai_id)){
			$criteria->addCondition('create_loginpemakai_id = '.$this->create_loginpemakai_id);
		}
		if(!empty($this->update_loginpemakai_id)){
			$criteria->addCondition('update_loginpemakai_id = '.$this->update_loginpemakai_id);
		}
		if(!empty($this->create_ruangan)){
			$criteria->addCondition('create_ruangan = '.$this->create_ruangan);
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