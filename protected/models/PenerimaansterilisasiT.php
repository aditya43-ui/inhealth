<?php

/**
 * This is the model class for table "penerimaansterilisasi_t".
 *
 * The followings are the available columns in table 'penerimaansterilisasi_t':
 * @property integer $penerimaansterilisasi_id
 * @property integer $ruangan_id
 * @property integer $pengajuansterlilisasi_id
 * @property string $penerimaansterilisasi_no
 * @property string $penerimaansterilisasi_tgl
 * @property string $penerimaansterilisasi_ket
 * @property integer $pegmengetahui_id
 * @property integer $pegmenerima_id
 * @property boolean $isdekontaminasi
 * @property boolean $issterilisasi
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 */
class PenerimaansterilisasiT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PenerimaansterilisasiT the static model class
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
		return 'penerimaansterilisasi_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ruangan_id, penerimaansterilisasi_no, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('ruangan_id, pegmengetahui_id, pegmenerima_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('penerimaansterilisasi_no', 'length', 'max'=>20),
			array('penerimaansterilisasi_tgl, penerimaansterilisasi_ket, isdekontaminasi, issterilisasi, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('penerimaansterilisasi_id, ruangan_id, pengajuansterlilisasi_id, penerimaansterilisasi_no, penerimaansterilisasi_tgl, penerimaansterilisasi_ket, pegmengetahui_id, pegmenerima_id, isdekontaminasi, issterilisasi, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
            'linen' => array(self::BELONGS_TO, 'LinenM', 'linen_id'),
			'pegawaiMenerima'=>array(self::BELONGS_TO,'PegawaiM','pegmenerima_id'),
			'pegawaiMengetahui'=>array(self::BELONGS_TO,'PegawaiM','pegmengetahui_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'penerimaansterilisasi_id' => 'Penerimaansterilisasi',
			'ruangan_id' => 'Ruangan',
			'pengajuansterlilisasi_id' => 'Pengajuansterlilisasi',
			'penerimaansterilisasi_no' => 'No. Penerimaan',
			'penerimaansterilisasi_tgl' => 'Tanggal Penerimaan',
			'penerimaansterilisasi_ket' => 'Keterangan',
			'pegmengetahui_id' => 'Pegawai Mengetahui',
			'pegmenerima_id' => 'Pegawai Penerima',
			'isdekontaminasi' => 'Isdekontaminasi',
			'issterilisasi' => 'Issterilisasi',
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

		if(!empty($this->penerimaansterilisasi_id)){
			$criteria->addCondition('penerimaansterilisasi_id = '.$this->penerimaansterilisasi_id);
		}
		if(!empty($this->ruangan_id)){
			$criteria->addCondition('ruangan_id = '.$this->ruangan_id);
		}
		if(!empty($this->pengajuansterlilisasi_id)){
			$criteria->addCondition('pengajuansterlilisasi_id = '.$this->pengajuansterlilisasi_id);
		}
		$criteria->compare('LOWER(penerimaansterilisasi_no)',strtolower($this->penerimaansterilisasi_no),true);
		$criteria->compare('LOWER(penerimaansterilisasi_tgl)',strtolower($this->penerimaansterilisasi_tgl),true);
		$criteria->compare('LOWER(penerimaansterilisasi_ket)',strtolower($this->penerimaansterilisasi_ket),true);
		if(!empty($this->pegmengetahui_id)){
			$criteria->addCondition('pegmengetahui_id = '.$this->pegmengetahui_id);
		}
		if(!empty($this->pegmenerima_id)){
			$criteria->addCondition('pegmenerima_id = '.$this->pegmenerima_id);
		}
		$criteria->compare('isdekontaminasi',$this->isdekontaminasi);
		$criteria->compare('issterilisasi',$this->issterilisasi);
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