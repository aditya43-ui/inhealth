<?php

/**
 * This is the model class for table "pengperawatanlinen_t".
 *
 * The followings are the available columns in table 'pengperawatanlinen_t':
 * @property integer $pengperawatanlinen_id
 * @property integer $ruangan_id
 * @property string $pengperawatanlinen_no
 * @property string $tglpengperawatanlinen
 * @property string $keterangan_pengperawatanlinen
 * @property integer $mengajukan_id
 * @property integer $mengetahui_id
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 */
class PengperawatanlinenT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PengperawatanlinenT the static model class
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
		return 'pengperawatanlinen_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ruangan_id, pengperawatanlinen_no, tglpengperawatanlinen, create_time, create_loginpemakai_id', 'required'),
			array('ruangan_id, mengajukan_id, mengetahui_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('pengperawatanlinen_no', 'length', 'max'=>20),
			array('keterangan_pengperawatanlinen, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pengperawatanlinen_id, ruangan_id, pengperawatanlinen_no, tglpengperawatanlinen, keterangan_pengperawatanlinen, mengajukan_id, mengetahui_id, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
            'ruangan' => array(self::BELONGS_TO, 'RuanganM', 'ruangan_id'),
            'pegawai' => array(self::BELONGS_TO, 'PegawaiM', 'mengetahui_id'),
            'pegawaiMengajukan' => array(self::BELONGS_TO, 'PegawaiM', 'mengajukan_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pengperawatanlinen_id' => 'Pengperawatanlinen',
			'ruangan_id' => 'Ruangan',
			'pengperawatanlinen_no' => 'No. Pengajuan',
			'tglpengperawatanlinen' => 'Tanggal Pengajuan',
			'keterangan_pengperawatanlinen' => 'Keterangan Pengajuan',
			'mengajukan_id' => 'Mengajukan',
			'mengetahui_id' => 'Mengetahui',
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

		if(!empty($this->pengperawatanlinen_id)){
			$criteria->addCondition('pengperawatanlinen_id = '.$this->pengperawatanlinen_id);
		}
		if(!empty($this->ruangan_id)){
			$criteria->addCondition('ruangan_id = '.$this->ruangan_id);
		}
		$criteria->compare('LOWER(pengperawatanlinen_no)',strtolower($this->pengperawatanlinen_no),true);
		$criteria->compare('LOWER(tglpengperawatanlinen)',strtolower($this->tglpengperawatanlinen),true);
		$criteria->compare('LOWER(keterangan_pengperawatanlinen)',strtolower($this->keterangan_pengperawatanlinen),true);
		if(!empty($this->mengajukan_id)){
			$criteria->addCondition('mengajukan_id = '.$this->mengajukan_id);
		}
		if(!empty($this->mengetahui_id)){
			$criteria->addCondition('mengetahui_id = '.$this->mengetahui_id);
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