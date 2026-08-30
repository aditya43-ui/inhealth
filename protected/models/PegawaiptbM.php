<?php

/**
 * This is the model class for table "pegawaiptb_m".
 *
 * The followings are the available columns in table 'pegawaiptb_m':
 * @property integer $employe_id
 * @property string $no_badge
 * @property string $namapegawai_ptb
 * @property string $nama_departemen
 * @property string $tempatlahir
 * @property string $tgl_lahir
 * @property string $jeniskelamin
 * @property string $agama
 * @property string $tipe_rumah
 * @property string $alamat
 * @property string $no_telepon
 * @property string $no_handphone
 * @property boolean $pegawaiptb_aktif
 */
class PegawaiptbM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PegawaiptbM the static model class
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
		return 'pegawaiptb_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('no_badge, namapegawai_ptb, tgl_lahir', 'required'),
			array('no_badge', 'length', 'max'=>15),
			array('namapegawai_ptb', 'length', 'max'=>100),
			array('nama_departemen', 'length', 'max'=>150),
			array('tempatlahir', 'length', 'max'=>50),
			array('jeniskelamin, agama, tipe_rumah', 'length', 'max'=>10),
			array('alamat', 'length', 'max'=>200),
			array('no_telepon, no_handphone', 'length', 'max'=>25),
			array('pegawaiptb_aktif', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('employe_id, no_badge, namapegawai_ptb, nama_departemen, tempatlahir, tgl_lahir, jeniskelamin, agama, tipe_rumah, alamat, no_telepon, no_handphone, pegawaiptb_aktif', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'employe_id' => 'Employe',
			'no_badge' => 'No. Badge',
			'namapegawai_ptb' => 'Namapegawai Ptb',
			'nama_departemen' => 'Nama Departemen',
			'tempatlahir' => 'Tempatlahir',
			'tgl_lahir' => 'Tgl. Lahir',
			'jeniskelamin' => 'Jenis Kelamin',
			'agama' => 'Agama',
			'tipe_rumah' => 'Tipe Rumah',
			'alamat' => 'Alamat',
			'no_telepon' => 'No Telepon',
			'no_handphone' => 'No Handphone',
			'pegawaiptb_aktif' => 'Pegawaiptb Aktif',
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

		if(!empty($this->employe_id)){
			$criteria->addCondition('employe_id = '.$this->employe_id);
		}
		$criteria->compare('LOWER(no_badge)',strtolower($this->no_badge),true);
		$criteria->compare('LOWER(namapegawai_ptb)',strtolower($this->namapegawai_ptb),true);
		$criteria->compare('LOWER(nama_departemen)',strtolower($this->nama_departemen),true);
		$criteria->compare('LOWER(tempatlahir)',strtolower($this->tempatlahir),true);
		$criteria->compare('LOWER(tgl_lahir)',strtolower($this->tgl_lahir),true);
		$criteria->compare('LOWER(jeniskelamin)',strtolower($this->jeniskelamin),true);
		$criteria->compare('LOWER(agama)',strtolower($this->agama),true);
		$criteria->compare('LOWER(tipe_rumah)',strtolower($this->tipe_rumah),true);
		$criteria->compare('LOWER(alamat)',strtolower($this->alamat),true);
		$criteria->compare('LOWER(no_telepon)',strtolower($this->no_telepon),true);
		$criteria->compare('LOWER(no_handphone)',strtolower($this->no_handphone),true);
		$criteria->compare('pegawaiptb_aktif',$this->pegawaiptb_aktif);

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