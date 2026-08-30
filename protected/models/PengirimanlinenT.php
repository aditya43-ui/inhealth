<?php

/**
 * This is the model class for table "pengirimanlinen_t".
 *
 * The followings are the available columns in table 'pengirimanlinen_t':
 * @property integer $pengirimanlinen_id
 * @property string $tglpengirimanlinen
 * @property string $nopengirimanlinen
 * @property string $keterangan_pengiriman
 * @property integer $ruangantujuan_id
 * @property integer $pegpengirim_id
 * @property integer $mengetahui_id
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 * @property boolean $issudahditerima
 *
 * The followings are the available model relations:
 * @property PenlinenruanganT[] $penlinenruanganTs
 */
class PengirimanlinenT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PengirimanlinenT the static model class
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
		return 'pengirimanlinen_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tglpengirimanlinen, nopengirimanlinen, ruangantujuan_id, pegpengirim_id, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('ruangantujuan_id, pegpengirim_id, mengetahui_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('nopengirimanlinen', 'length', 'max'=>20),
			array('keterangan_pengiriman', 'length', 'max'=>200),
			array('update_time, issudahditerima, tglterimalinen', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pengirimanlinen_id, tglpengirimanlinen, nopengirimanlinen, keterangan_pengiriman, ruangantujuan_id, pegpengirim_id, mengetahui_id, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, issudahditerima, tglterimalinen', 'safe', 'on'=>'search'),
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
			'penlinenruanganTs' => array(self::HAS_MANY, 'PenlinenruanganT', 'pengirimanlinen_id'),
			'pegpengirim'=>array(self::BELONGS_TO,'PegawaiM','pegpengirim_id'),
			'pegmengetahui'=>array(self::BELONGS_TO,'PegawaiM','mengetahui_id'),
			'ruangan'=>array(self::BELONGS_TO,'RuanganM','ruangantujuan_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pengirimanlinen_id' => 'Pengirimanlinen',
			'tglpengirimanlinen' => 'Tanggal Pengiriman',
			'nopengirimanlinen' => 'No. Pengiriman',
			'keterangan_pengiriman' => 'Keterangan',
			'ruangantujuan_id' => 'Ruangan Tujuan',
			'pegpengirim_id' => 'Pegawai Pengirim',
			'mengetahui_id' => 'Pegawai Mengetahui',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
			'issudahditerima' => 'Status Sudah Diterima',
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

		if(!empty($this->pengirimanlinen_id)){
			$criteria->addCondition('pengirimanlinen_id = '.$this->pengirimanlinen_id);
		}
		$criteria->compare('LOWER(tglpengirimanlinen)',strtolower($this->tglpengirimanlinen),true);
		$criteria->compare('LOWER(nopengirimanlinen)',strtolower($this->nopengirimanlinen),true);
		$criteria->compare('LOWER(keterangan_pengiriman)',strtolower($this->keterangan_pengiriman),true);
		if(!empty($this->ruangantujuan_id)){
			$criteria->addCondition('ruangantujuan_id = '.$this->ruangantujuan_id);
		}
		if(!empty($this->pegpengirim_id)){
			$criteria->addCondition('pegpengirim_id = '.$this->pegpengirim_id);
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
		$criteria->compare('issudahditerima',$this->issudahditerima);

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