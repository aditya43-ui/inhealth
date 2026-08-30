<?php

/**
 * This is the model class for table "organigram_m".
 *
 * The followings are the available columns in table 'organigram_m':
 * @property integer $organigram_id
 * @property string $organigram_kode
 * @property string $organigram_unitkerja
 * @property integer $organigram_formasi
 * @property string $organigram_pelaksanakerja
 * @property string $organigram_keterangan
 * @property string $organigram_periode
 * @property string $organigram_sampaidengan
 * @property integer $organigramasal_id
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 * @property boolean $organigram_aktif
 * @property integer $organigram_urutan
 * @property integer $pegawai_id
 *
 * The followings are the available model relations:
 * @property PegawaiM $pegawai
 */
class OrganigramM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return OrganigramM the static model class
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
		return 'organigram_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
            array('organigram_kode, organigram_unitkerja, organigram_formasi, create_loginpemakai_id, create_ruangan, pegawai_id', 'required'),
            array('organigram_formasi, organigramasal_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, organigram_urutan, pegawai_id, jabatan_id', 'numerical', 'integerOnly'=>true),
            array('organigram_kode', 'length', 'max'=>20),
            array('organigram_unitkerja, organigram_pelaksanakerja', 'length', 'max'=>50),
            array('organigram_keterangan', 'length', 'max'=>500),
            array('organigram_periode, organigram_sampaidengan, create_time, update_time, organigram_aktif', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('organigram_id, organigram_kode, organigram_unitkerja, organigram_formasi, organigram_pelaksanakerja, organigram_keterangan, organigram_periode, organigram_sampaidengan, organigramasal_id, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, organigram_aktif, organigram_urutan, pegawai_id, jabatan_id', 'safe', 'on'=>'search'),
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
            'pegawai' => array(self::BELONGS_TO, 'PegawaiM', 'pegawai_id'),
            'jabatan' => array(self::BELONGS_TO, 'JabatanM', 'jabatan_id'),
            'organigramasal' => array(self::BELONGS_TO, 'OrganigramM', 'organigramasal_id'),
        );
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'organigram_id' => 'ID',
			'organigram_kode' => 'Nomor SK',
			'organigram_unitkerja' => 'Unit Kerja Organigram',
			'organigram_formasi' => 'Formasi',
			'organigram_pelaksanakerja' => 'Pelaksana Kerja',
			'organigram_keterangan' => 'Keterangan',
			'organigram_periode' => 'Periode',
			'organigram_sampaidengan' => 'Sampai Dengan',
			'organigramasal_id' => 'Bertanggung Jawab Kepada',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
			'organigram_aktif' => 'Status',
			'organigram_urutan' => 'Urutan',
                        'pegawai_id' => 'Pegawai',
			'jabatan_id' => 'Jabatan',
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

		if(!empty($this->organigram_id)){
			$criteria->addCondition('organigram_id = '.$this->organigram_id);
		}
		$criteria->compare('LOWER(organigram_kode)',strtolower($this->organigram_kode),true);
		$criteria->compare('LOWER(organigram_unitkerja)',strtolower($this->organigram_unitkerja),true);
		if(!empty($this->organigram_formasi)){
			$criteria->addCondition('organigram_formasi = '.$this->organigram_formasi);
		}
		$criteria->compare('LOWER(organigram_pelaksanakerja)',strtolower($this->organigram_pelaksanakerja),true);
		$criteria->compare('LOWER(organigram_keterangan)',strtolower($this->organigram_keterangan),true);
		$criteria->compare('LOWER(organigram_periode)',strtolower($this->organigram_periode),true);
		$criteria->compare('LOWER(organigram_sampaidengan)',strtolower($this->organigram_sampaidengan),true);
                
		if(!empty($this->organigramasal_id)){
			$criteria->addCondition('organigramasal_id = '.$this->organigramasal_id);
		}
                if(!empty($this->jabatan_id)){
			$criteria->addCondition('jabatan_id = '.$this->jabatan_id);
		}
		//$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		//$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		if(!empty($this->create_loginpemakai_id)){
			$criteria->addCondition('create_loginpemakai_id = '.$this->create_loginpemakai_id);
		}
		if(!empty($this->update_loginpemakai_id)){
			$criteria->addCondition('update_loginpemakai_id = '.$this->update_loginpemakai_id);
		}
		if(!empty($this->create_ruangan)){
			$criteria->addCondition('create_ruangan = '.$this->create_ruangan);
		}
               
		$criteria->compare('organigram_aktif',$this->organigram_aktif);

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