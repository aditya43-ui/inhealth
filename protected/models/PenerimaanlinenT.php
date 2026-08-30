<?php

/**
 * This is the model class for table "penerimaanlinen_t".
 *
 * The followings are the available columns in table 'penerimaanlinen_t':
 * @property integer $penerimaanlinen_id
 * @property integer $ruangan_id
 * @property integer $pengperawatanlinen_id
 * @property string $nopenerimaanlinen
 * @property string $tglpenerimaanlinen
 * @property string $keterangan_penerimaanlinen
 * @property integer $pegmenerima_id
 * @property integer $pegmengetahui_id
 * @property integer $beratlinen
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 */
class PenerimaanlinenT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PenerimaanlinenT the static model class
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
		return 'penerimaanlinen_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ruangan_id, nopenerimaanlinen, tglpenerimaanlinen, pegmenerima_id, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('ruangan_id, pengperawatanlinen_id, pegmenerima_id, pegmengetahui_id, beratlinen, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('nopenerimaanlinen', 'length', 'max'=>20),
			array('keterangan_penerimaanlinen, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('penerimaanlinen_id, ruangan_id, pengperawatanlinen_id, nopenerimaanlinen, tglpenerimaanlinen, keterangan_penerimaanlinen, pegmenerima_id, pegmengetahui_id, beratlinen, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
                    'pengPerawatan' => array(self::BELONGS_TO, 'PengperawatanlinenT', 'pengperawatanlinen_id'),
                    'pegawaiMenerima' => array(self::BELONGS_TO, 'PegawaiM', 'pegmenerima_id'),
                    'pegawaiMengetahui' => array(self::BELONGS_TO, 'PegawaiM', 'pegmengetahui_id'),                    
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'penerimaanlinen_id' => 'Penerimaan Linen',
			'ruangan_id' => 'Ruangan',
			'pengperawatanlinen_id' => 'Pengajuan Perawatan Linen',
			'nopenerimaanlinen' => 'No. Penerimaan',
			'tglpenerimaanlinen' => 'Tanggal Penerimaan',
			'keterangan_penerimaanlinen' => 'Keterangan',
			'pegmenerima_id' => 'Pegawai Menerima',
			'pegmengetahui_id' => 'Pegawai Mengetahui',
			'beratlinen' => 'Berat',
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

		if(!empty($this->penerimaanlinen_id)){
			$criteria->addCondition('penerimaanlinen_id = '.$this->penerimaanlinen_id);
		}
		if(!empty($this->ruangan_id)){
			$criteria->addCondition('ruangan_id = '.$this->ruangan_id);
		}
		if(!empty($this->pengperawatanlinen_id)){
			$criteria->addCondition('pengperawatanlinen_id = '.$this->pengperawatanlinen_id);
		}
		$criteria->compare('LOWER(nopenerimaanlinen)',strtolower($this->nopenerimaanlinen),true);
		$criteria->compare('LOWER(tglpenerimaanlinen)',strtolower($this->tglpenerimaanlinen),true);
		$criteria->compare('LOWER(keterangan_penerimaanlinen)',strtolower($this->keterangan_penerimaanlinen),true);
		if(!empty($this->pegmenerima_id)){
			$criteria->addCondition('pegmenerima_id = '.$this->pegmenerima_id);
		}
		if(!empty($this->pegmengetahui_id)){
			$criteria->addCondition('pegmengetahui_id = '.$this->pegmengetahui_id);
		}
		if(!empty($this->beratlinen)){
			$criteria->addCondition('beratlinen = '.$this->beratlinen);
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