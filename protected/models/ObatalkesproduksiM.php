<?php

/**
 * This is the model class for table "obatalkesproduksi_m".
 *
 * The followings are the available columns in table 'obatalkesproduksi_m':
 * @property integer $obatalkesproduksi_id
 * @property integer $pegawai_id
 * @property integer $obatalkes_id
 * @property string $aturanpakai
 * @property string $keteranganprd
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 *
 * The followings are the available model relations:
 * @property BahanobatM[] $bahanobatMs
 * @property ObatalkesM $obatalkes
 * @property PegawaiM $pegawai
 * @property ProduksiobatdetT[] $produksiobatdetTs
 */
class ObatalkesproduksiM extends CActiveRecord
{
        public $nama_pegawai,$obatalkes_kode, $obatalkes_nama; //untuk pencarian
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ObatalkesproduksiM the static model class
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
		return 'obatalkesproduksi_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pegawai_id, obatalkes_id', 'numerical', 'integerOnly'=>true),
			array('aturanpakai', 'length', 'max'=>50),
			array('keteranganprd, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('obatalkesproduksi_id, pegawai_id, obatalkes_id, aturanpakai, keteranganprd, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'bahanobatMs' => array(self::HAS_MANY, 'BahanobatM', 'obatalkesproduksi_id'),
			'obatalkes' => array(self::BELONGS_TO, 'ObatalkesM', 'obatalkes_id'),
			'pegawai' => array(self::BELONGS_TO, 'PegawaiM', 'pegawai_id'),
			'produksiobatdetTs' => array(self::HAS_MANY, 'ProduksiobatdetT', 'obatalkesproduksi_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'obatalkesproduksi_id' => 'Obatalkesproduksi',
			'pegawai_id' => 'Pegawai',
			'obatalkes_id' => 'Obatalkes',
			'aturanpakai' => 'Aturanpakai',
			'keteranganprd' => 'Keteranganprd',
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

		$criteria->compare('obatalkesproduksi_id',$this->obatalkesproduksi_id);
		$criteria->compare('pegawai.pegawai_id',$this->pegawai_id);
		$criteria->compare('obatalkes_id',$this->obatalkes_id);
		$criteria->compare('LOWER(aturanpakai)',strtolower($this->aturanpakai),true);
		$criteria->compare('LOWER(keteranganprd)',strtolower($this->keteranganprd),true);
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
		$criteria->compare('obatalkesproduksi_id',$this->obatalkesproduksi_id);
		$criteria->compare('pegawai.pegawai_id',$this->pegawai_id);
		$criteria->compare('obatalkes_id',$this->obatalkes_id);
		$criteria->compare('LOWER(aturanpakai)',strtolower($this->aturanpakai),true);
		$criteria->compare('LOWER(keteranganprd)',strtolower($this->keteranganprd),true);
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
        
        public function searchDialog()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
                $criteria->with = array('obatalkes','pegawai');
		$criteria->compare('obatalkesproduksi_id',$this->obatalkesproduksi_id);
		$criteria->compare('pegawai.pegawai_id',$this->pegawai_id);
		$criteria->compare('obatalkes_id',$this->obatalkes_id);
		$criteria->compare('LOWER(aturanpakai)',strtolower($this->aturanpakai),true);
		$criteria->compare('LOWER(keteranganprd)',strtolower($this->keteranganprd),true);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
                $criteria->order = 'obatalkes.obatalkes_nama';
		$criteria->limit = 10;
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>false,
		));
	}
        
        public function getItems(){
            $criteria = new CDbCriteria();
            $criteria->with = array('obatalkes','pegawai');
            $criteria->order = 'obatalkes.obatalkes_nama';
            $models = $this->model->findAll($criteria);
            return $models;
        }
}