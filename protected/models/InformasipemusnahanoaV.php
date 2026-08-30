<?php

/**
 * This is the model class for table "informasipemusnahanoa_v".
 *
 * The followings are the available columns in table 'informasipemusnahanoa_v':
 * @property integer $pemusnahanobatalkes_id
 * @property string $tglpemusnahan
 * @property string $nopemusnahan
 * @property string $keterangan
 * @property integer $instalasi_id
 * @property string $instalasi_nama
 * @property integer $ruangan_id
 * @property string $ruangan_nama
 * @property integer $pegawaipelaksana_id
 * @property string $pegawaipelaksana_nip
 * @property string $pegawaipelaksana_jenisidentitas
 * @property string $pegawaipelaksana_noidentitas
 * @property string $pegawaipelaksana_gelardepan
 * @property string $pegawaipelaksana_nama
 * @property string $pegawaipelaksana_gelarbelakang
 * @property integer $pegawaimengetahui_id
 * @property string $pegawaimengetahui_nip
 * @property string $pegawaimengetahui_jenisidentitas
 * @property string $pegawaimengetahui_noidentitas
 * @property string $pegawaimengetahui_gelardepan
 * @property string $pegawaimengetahui_namapegawai
 * @property string $pegawaimengetahui_gelarbelakang
 * @property integer $pegawaimenyetujui_id
 * @property string $pegawaimenyetujui_nip
 * @property string $pegawaimenyetujui_jenisdentitas
 * @property string $pegawaimenyetujui_noidentitas
 * @property string $pegawaimenyetujui_gelardepan
 * @property string $pegawaimenyetujui_nama
 * @property string $pegawaimenyetujui_gelarbelakang
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 */
class InformasipemusnahanoaV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InformasipemusnahanoaV the static model class
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
		return 'informasipemusnahanoa_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pemusnahanobatalkes_id, instalasi_id, ruangan_id, pegawaipelaksana_id, pegawaimengetahui_id, pegawaimenyetujui_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('nopemusnahan', 'length', 'max'=>200),
			array('instalasi_nama, ruangan_nama, pegawaipelaksana_nama, pegawaimengetahui_nama, pegawaimenyetujui_nama', 'length', 'max'=>50),
			array('pegawaipelaksana_nip, pegawaimengetahui_nip, pegawaimenyetujui_nip', 'length', 'max'=>30),
			array('pegawaipelaksana_jenisidentitas, pegawaimengetahui_jenisidentitas, pegawaimenyetujui_jenisdentitas', 'length', 'max'=>20),
			array('pegawaipelaksana_noidentitas, pegawaimengetahui_noidentitas, pegawaimenyetujui_noidentitas', 'length', 'max'=>100),
			array('pegawaipelaksana_gelardepan, pegawaimengetahui_gelardepan, pegawaimenyetujui_gelardepan', 'length', 'max'=>10),
			array('pegawaipelaksana_gelarbelakang, pegawaimengetahui_gelarbelakang, pegawaimenyetujui_gelarbelakang', 'length', 'max'=>15),
			array('tglpemusnahan, keterangan, create_time, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pemusnahanobatalkes_id, tglpemusnahan, nopemusnahan, keterangan, instalasi_id, instalasi_nama, ruangan_id, ruangan_nama, pegawaipelaksana_id, pegawaipelaksana_nip, pegawaipelaksana_jenisidentitas, pegawaipelaksana_noidentitas, pegawaipelaksana_gelardepan, pegawaipelaksana_nama, pegawaipelaksana_gelarbelakang, pegawaimengetahui_id, pegawaimengetahui_nip, pegawaimengetahui_jenisidentitas, pegawaimengetahui_noidentitas, pegawaimengetahui_gelardepan, pegawaimengetahui_namapegawai, pegawaimengetahui_gelarbelakang, pegawaimenyetujui_id, pegawaimenyetujui_nip, pegawaimenyetujui_jenisdentitas, pegawaimenyetujui_noidentitas, pegawaimenyetujui_gelardepan, pegawaimenyetujui_nama, pegawaimenyetujui_gelarbelakang, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'pemusnahanobatalkes_id' => 'Pemusnahanobatalkes',
			'tglpemusnahan' => 'Tanggal Pemusnahan',
			'nopemusnahan' => 'No. Pemusnahan',
			'keterangan' => 'Keterangan',
			'instalasi_id' => 'Instalasi Tujuan',
			'instalasi_nama' => 'Instalasi Tujuan',
			'ruangan_id' => 'Ruangan Asal',
			'ruangan_nama' => 'Ruangan Asal',
			'pegawaipelaksana_id' => 'Pegawaipelaksana',
			'pegawaipelaksana_nip' => 'Pegawaipelaksana Nip',
			'pegawaipelaksana_jenisidentitas' => 'Pegawaipelaksana Jenisidentitas',
			'pegawaipelaksana_noidentitas' => 'Pegawaipelaksana Noidentitas',
			'pegawaipelaksana_gelardepan' => 'Pegawaipelaksana Gelardepan',
			'pegawaipelaksana_nama' => 'Pegawaipelaksana Nama',
			'pegawaipelaksana_gelarbelakang' => 'Pegawaipelaksana Gelarbelakang',
			'pegawaimengetahui_id' => 'Pegawai Mengetahui',
			'pegawaimengetahui_nip' => 'Pegawaimengetahui Nip',
			'pegawaimengetahui_jenisidentitas' => 'Pegawaimengetahui Jenisidentitas',
			'pegawaimengetahui_noidentitas' => 'Pegawaimengetahui Noidentitas',
			'pegawaimengetahui_gelardepan' => 'Pegawaimengetahui Gelardepan',
			'pegawaimengetahui_nama' => 'Pegawai Mengetahui',
			'pegawaimengetahui_gelarbelakang' => 'Pegawaimengetahui Gelarbelakang',
			'pegawaimenyetujui_id' => 'Pegawai Menyetujui',
			'pegawaimenyetujui_nip' => 'Pegawaimenyetujui Nip',
			'pegawaimenyetujui_jenisdentitas' => 'Pegawaimenyetujui Jenisdentitas',
			'pegawaimenyetujui_noidentitas' => 'Pegawaimenyetujui Noidentitas',
			'pegawaimenyetujui_gelardepan' => 'Pegawaimenyetujui Gelardepan',
			'pegawaimenyetujui_nama' => 'Pegawai Menyetujui',
			'pegawaimenyetujui_gelarbelakang' => 'Pegawaimenyetujui Gelarbelakang',
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

		if(!empty($this->pemusnahanobatalkes_id)){
			$criteria->addCondition('pemusnahanobatalkes_id = '.$this->pemusnahanobatalkes_id);
		}
		$criteria->compare('LOWER(tglpemusnahan)',strtolower($this->tglpemusnahan),true);
		$criteria->compare('LOWER(nopemusnahan)',strtolower($this->nopemusnahan),true);
		$criteria->compare('LOWER(keterangan)',strtolower($this->keterangan),true);
		if(!empty($this->instalasi_id)){
			$criteria->addCondition('instalasi_id = '.$this->instalasi_id);
		}
		$criteria->compare('LOWER(instalasi_nama)',strtolower($this->instalasi_nama),true);
		if(!empty($this->ruangan_id)){
			$criteria->addCondition('ruangan_id = '.$this->ruangan_id);
		}
		$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
		if(!empty($this->pegawaipelaksana_id)){
			$criteria->addCondition('pegawaipelaksana_id = '.$this->pegawaipelaksana_id);
		}
		$criteria->compare('LOWER(pegawaipelaksana_nip)',strtolower($this->pegawaipelaksana_nip),true);
		$criteria->compare('LOWER(pegawaipelaksana_jenisidentitas)',strtolower($this->pegawaipelaksana_jenisidentitas),true);
		$criteria->compare('LOWER(pegawaipelaksana_noidentitas)',strtolower($this->pegawaipelaksana_noidentitas),true);
		$criteria->compare('LOWER(pegawaipelaksana_gelardepan)',strtolower($this->pegawaipelaksana_gelardepan),true);
		$criteria->compare('LOWER(pegawaipelaksana_nama)',strtolower($this->pegawaipelaksana_nama),true);
		$criteria->compare('LOWER(pegawaipelaksana_gelarbelakang)',strtolower($this->pegawaipelaksana_gelarbelakang),true);
		if(!empty($this->pegawaimengetahui_id)){
			$criteria->addCondition('pegawaimengetahui_id = '.$this->pegawaimengetahui_id);
		}
		$criteria->compare('LOWER(pegawaimengetahui_nip)',strtolower($this->pegawaimengetahui_nip),true);
		$criteria->compare('LOWER(pegawaimengetahui_jenisidentitas)',strtolower($this->pegawaimengetahui_jenisidentitas),true);
		$criteria->compare('LOWER(pegawaimengetahui_noidentitas)',strtolower($this->pegawaimengetahui_noidentitas),true);
		$criteria->compare('LOWER(pegawaimengetahui_gelardepan)',strtolower($this->pegawaimengetahui_gelardepan),true);
		$criteria->compare('LOWER(pegawaimengetahui_nama)',strtolower($this->pegawaimengetahui_nama),true);
		$criteria->compare('LOWER(pegawaimengetahui_gelarbelakang)',strtolower($this->pegawaimengetahui_gelarbelakang),true);
		if(!empty($this->pegawaimenyetujui_id)){
			$criteria->addCondition('pegawaimenyetujui_id = '.$this->pegawaimenyetujui_id);
		}
		$criteria->compare('LOWER(pegawaimenyetujui_nip)',strtolower($this->pegawaimenyetujui_nip),true);
		$criteria->compare('LOWER(pegawaimenyetujui_jenisdentitas)',strtolower($this->pegawaimenyetujui_jenisdentitas),true);
		$criteria->compare('LOWER(pegawaimenyetujui_noidentitas)',strtolower($this->pegawaimenyetujui_noidentitas),true);
		$criteria->compare('LOWER(pegawaimenyetujui_gelardepan)',strtolower($this->pegawaimenyetujui_gelardepan),true);
		$criteria->compare('LOWER(pegawaimenyetujui_nama)',strtolower($this->pegawaimenyetujui_nama),true);
		$criteria->compare('LOWER(pegawaimenyetujui_gelarbelakang)',strtolower($this->pegawaimenyetujui_gelarbelakang),true);
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