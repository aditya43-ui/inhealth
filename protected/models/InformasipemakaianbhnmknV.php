<?php

/**
 * This is the model class for table "informasipemakaianbhnmkn_v".
 *
 * The followings are the available columns in table 'informasipemakaianbhnmkn_v':
 * @property integer $pemakaianbhnmkn_id
 * @property string $ruanganpemakaibhnmkn
 * @property string $ruangan_nama
 * @property integer $instalasi_id
 * @property string $instalasi_nama
 * @property integer $pegmengetahui_id
 * @property string $gelardepan
 * @property string $nama_pegawai
 * @property string $gelarbelakang_nama
 * @property string $tglpemakaianbhnmkn
 * @property string $no_pemakaianbhnmkn
 * @property string $untukkeperluan
 * @property string $ketpemakaian
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai
 * @property string $create_ruangan
 */
class InformasipemakaianbhnmknV extends CActiveRecord
{
    public $tgl_awal, $tgl_akhir;
    
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InformasipemakaianbhnmknV the static model class
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
		return 'informasipemakaianbhnmkn_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pemakaianbhnmkn_id, instalasi_id, pegmengetahui_id', 'numerical', 'integerOnly'=>true),
			array('ruangan_nama, instalasi_nama, nama_pegawai', 'length', 'max'=>50),
			array('gelardepan', 'length', 'max'=>10),
			array('gelarbelakang_nama', 'length', 'max'=>15),
			array('no_pemakaianbhnmkn', 'length', 'max'=>20),
			array('untukkeperluan', 'length', 'max'=>500),
			array('ketpemakaian', 'length', 'max'=>255),
			array('ruanganpemakaibhnmkn, tglpemakaianbhnmkn, create_time, update_time, create_loginpemakai, create_ruangan', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pemakaianbhnmkn_id, ruanganpemakaibhnmkn, ruangan_nama, instalasi_id, instalasi_nama, pegmengetahui_id, gelardepan, nama_pegawai, gelarbelakang_nama, tglpemakaianbhnmkn, no_pemakaianbhnmkn, untukkeperluan, ketpemakaian, create_time, update_time, create_loginpemakai, create_ruangan', 'safe', 'on'=>'search'),
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
			'pemakaianbhnmkn_id' => 'Pemakaianbhnmkn',
			'ruanganpemakaibhnmkn' => 'Ruanganpemakaibhnmkn',
			'ruangan_nama' => 'Ruangan Nama',
			'instalasi_id' => 'Instalasi',
			'instalasi_nama' => 'Instalasi Nama',
			'pegmengetahui_id' => 'Pegmengetahui',
			'gelardepan' => 'Gelardepan',
			'nama_pegawai' => 'Nama Pegawai',
			'gelarbelakang_nama' => 'Gelarbelakang Nama',
			'tglpemakaianbhnmkn' => 'Tglpemakaianbhnmkn',
			'no_pemakaianbhnmkn' => 'No Pemakaianbhnmkn',
			'untukkeperluan' => 'Untukkeperluan',
			'ketpemakaian' => 'Keterangan Pemakaian',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai' => 'Create Loginpemakai',
			'create_ruangan' => 'Create Ruangan',
		);
	}

        public function criteriaSearch()
	{
            $criteria=new CDbCriteria;
            $criteria->addBetweenCondition("DATE(tglpemakaianbhnmkn)", $this->tgl_awal, $this->tgl_akhir);
            
            if(!empty($this->pemakaianbhnmkn_id)){
                $criteria->addCondition('pemakaianbhnmkn_id = '.$this->pemakaianbhnmkn_id);
            }
            
            if(!empty($this->ruanganpemakaibhnmkn)){
                $criteria->addCondition('ruanganpemakaibhnmkn = '.$this->ruanganpemakaibhnmkn);
            }
            $criteria->compare('lower(ruangan_nama)', strtolower($this->ruangan_nama),true);
            if(!empty($this->instalasi_id)){
                $criteria->addCondition('instalasi_id = '.$this->instalasi_id);
            }
            $criteria->compare('lower(instalasi_nama)', strtolower($this->instalasi_nama),true);
            if(!empty($this->pegmengetahui_id)){
                $criteria->addCondition('pegmengetahui_id = '.$this->pegmengetahui_id);
            }
            $criteria->compare('lower(gelardepan)', strtolower($this->gelardepan),true);
            $criteria->compare('lower(nama_pegawai)', strtolower($this->nama_pegawai),true);
            $criteria->compare('lower(gelarbelakang_nama)', strtolower($this->gelarbelakang_nama),true);
            $criteria->compare('lower(no_pemakaianbhnmkn)', strtolower($this->no_pemakaianbhnmkn),true);
            $criteria->compare('lower(untukkeperluan)', strtolower($this->untukkeperluan),true);
            $criteria->compare('lower(ketpemakaian)', strtolower($this->ketpemakaian),true);
            $criteria->compare('lower(no_pemakaianbhnmkn)', strtolower($this->no_pemakaianbhnmkn),true);
            $criteria->compare('lower(no_pemakaianbhnmkn)', strtolower($this->no_pemakaianbhnmkn),true);
            $criteria->compare('create_time',$this->create_time,true);
            $criteria->compare('update_time',$this->update_time,true);
            if(!empty($this->create_loginpemakai)){
                $criteria->addCondition('create_loginpemakai = '.$this->create_loginpemakai);
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
            $criteria=$this->criteriaSearch();
            $criteria->limit=10;

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
	}
        
        public function searchPrint()
        {
            $criteria=$this->criteriaSearch();
            $criteria->limit=-1; 

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
                    'pagination'=>false,
            ));
        }
}