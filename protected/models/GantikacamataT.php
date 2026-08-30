<?php

/**
 * This is the model class for table "gantikacamata_t".
 *
 * The followings are the available columns in table 'gantikacamata_t':
 * @property integer $gantikacamata_id
 * @property integer $pengajuangantikm_id
 * @property integer $pegawai_id
 * @property string $tglgantikacamata
 * @property string $tglpenyerahan
 * @property string $departement_peg
 * @property string $statushubungan
 * @property string $namapasien_hub
 * @property string $duedata_kacamata
 * @property string $vod_spheris
 * @property string $vod_cylindrys
 * @property string $vos_spheris
 * @property string $vos_cylindrys
 * @property string $add_kacamata
 * @property double $jumlahharga_km
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 */
class GantikacamataT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return GantikacamataT the static model class
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
		return 'gantikacamata_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pegawai_id, tglgantikacamata, tglpenyerahan, statushubungan, namapasien_hub, jumlahharga_km, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('pengajuangantikm_id, pegawai_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('jumlahharga_km', 'numerical'),
			array('departement_peg, statushubungan', 'length', 'max'=>50),
			array('namapasien_hub', 'length', 'max'=>100),
			array('duedata_kacamata, vod_spheris, vod_cylindrys, vos_spheris, vos_cylindrys, add_kacamata, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('gantikacamata_id, pengajuangantikm_id, pegawai_id, tglgantikacamata, tglpenyerahan, departement_peg, statushubungan, namapasien_hub, duedata_kacamata, vod_spheris, vod_cylindrys, vos_spheris, vos_cylindrys, add_kacamata, jumlahharga_km, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, jnstransaksi_km', 'safe', 'on'=>'search'),
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
			'pegawai'=>array(self::BELONGS_TO,'PegawaiM','pegawai_id'),
			'pengajuangantikm'=>array(self::BELONGS_TO,'PengajuangantikmT','pengajuangantikm_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'gantikacamata_id' => 'Ganti Kacamata',
			'pengajuangantikm_id' => 'Pengajuan Ganti Kacamata',
			'pegawai_id' => 'Pegawai',
			'tglgantikacamata' => 'Tanggal Ganti Kacamata Berikutnya',
			'tglpenyerahan' => 'Tanggal Penyerahan',
			'departement_peg' => 'Departement',
			'statushubungan' => 'Status Hubungan',
			'namapasien_hub' => 'Nama Pasien',
			'duedata_kacamata' => 'Due Date',
			'vod_spheris' => 'Vod Spheris',
			'vod_cylindrys' => 'Vod Cylindrys',
			'vos_spheris' => 'Vos Spheris',
			'vos_cylindrys' => 'Vos Cylindrys',
			'add_kacamata' => 'Add Kacamata',
			'jumlahharga_km' => 'Jumlah Harga',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
			'jnstransaksi_km' => 'Pergantian',
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

		if(!empty($this->gantikacamata_id)){
			$criteria->addCondition('gantikacamata_id = '.$this->gantikacamata_id);
		}
		if(!empty($this->pengajuangantikm_id)){
			$criteria->addCondition('pengajuangantikm_id = '.$this->pengajuangantikm_id);
		}
		if(!empty($this->pegawai_id)){
			$criteria->addCondition('pegawai_id = '.$this->pegawai_id);
		}
		$criteria->compare('LOWER(tglgantikacamata)',strtolower($this->tglgantikacamata),true);
		$criteria->compare('LOWER(tglpenyerahan)',strtolower($this->tglpenyerahan),true);
		$criteria->compare('LOWER(departement_peg)',strtolower($this->departement_peg),true);
		$criteria->compare('LOWER(statushubungan)',strtolower($this->statushubungan),true);
		$criteria->compare('LOWER(namapasien_hub)',strtolower($this->namapasien_hub),true);
		$criteria->compare('LOWER(duedata_kacamata)',strtolower($this->duedata_kacamata),true);
		$criteria->compare('LOWER(vod_spheris)',strtolower($this->vod_spheris),true);
		$criteria->compare('LOWER(vod_cylindrys)',strtolower($this->vod_cylindrys),true);
		$criteria->compare('LOWER(vos_spheris)',strtolower($this->vos_spheris),true);
		$criteria->compare('LOWER(vos_cylindrys)',strtolower($this->vos_cylindrys),true);
		$criteria->compare('LOWER(add_kacamata)',strtolower($this->add_kacamata),true);
		$criteria->compare('jumlahharga_km',$this->jumlahharga_km);
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