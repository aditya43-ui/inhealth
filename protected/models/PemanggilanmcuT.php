<?php

/**
 * This is the model class for table "pemanggilanmcu_t".
 *
 * The followings are the available columns in table 'pemanggilanmcu_t':
 * @property integer $pemanggilanmcu_id
 * @property integer $pendaftaran_id
 * @property integer $ruangan_id
 * @property integer $pasien_id
 * @property string $no_pemanggilan
 * @property string $tglpemanggilanmcu
 * @property integer $pemanggilanke
 * @property string $tglakanperiksamcu
 * @property string $keterangan_pemanggilan
 * @property boolean $status_print
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 */
class PemanggilanmcuT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PemanggilanmcuT the static model class
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
		return 'pemanggilanmcu_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pendaftaran_id, ruangan_id, pasien_id, no_pemanggilan, tglpemanggilanmcu, pemanggilanke, tglakanperiksamcu, keterangan_pemanggilan, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('pendaftaran_id, ruangan_id, pasien_id, pemanggilanke, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('no_pemanggilan', 'length', 'max'=>20),
			array('keterangan_pemanggilan', 'length', 'max'=>200),
			array('status_print, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pemanggilanmcu_id, pendaftaran_id, ruangan_id, pasien_id, no_pemanggilan, tglpemanggilanmcu, pemanggilanke, tglakanperiksamcu, keterangan_pemanggilan, status_print, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'pendaftaran'=>array(self::BELONGS_TO,'PendaftaranT','pendaftaran_id'),
			'pasien'=>array(self::BELONGS_TO,'PasienM','pasien_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pemanggilanmcu_id' => 'Pemanggilanmcu',
			'pendaftaran_id' => 'Pendaftaran',
			'ruangan_id' => 'Ruangan',
			'pasien_id' => 'Pasien',
			'no_pemanggilan' => 'No Pemanggilan',
			'tglpemanggilanmcu' => 'Tglpemanggilanmcu',
			'pemanggilanke' => 'Pemanggilanke',
			'tglakanperiksamcu' => 'Tglakanperiksamcu',
			'keterangan_pemanggilan' => 'Keterangan Pemanggilan',
			'status_print' => 'Status Print',
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

		if(!empty($this->pemanggilanmcu_id)){
			$criteria->addCondition('pemanggilanmcu_id = '.$this->pemanggilanmcu_id);
		}
		if(!empty($this->pendaftaran_id)){
			$criteria->addCondition('pendaftaran_id = '.$this->pendaftaran_id);
		}
		if(!empty($this->ruangan_id)){
			$criteria->addCondition('ruangan_id = '.$this->ruangan_id);
		}
		if(!empty($this->pasien_id)){
			$criteria->addCondition('pasien_id = '.$this->pasien_id);
		}
		$criteria->compare('LOWER(no_pemanggilan)',strtolower($this->no_pemanggilan),true);
		$criteria->compare('LOWER(tglpemanggilanmcu)',strtolower($this->tglpemanggilanmcu),true);
		if(!empty($this->pemanggilanke)){
			$criteria->addCondition('pemanggilanke = '.$this->pemanggilanke);
		}
		$criteria->compare('LOWER(tglakanperiksamcu)',strtolower($this->tglakanperiksamcu),true);
		$criteria->compare('LOWER(keterangan_pemanggilan)',strtolower($this->keterangan_pemanggilan),true);
		$criteria->compare('status_print',$this->status_print);
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