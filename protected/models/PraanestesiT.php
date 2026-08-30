<?php

/**
 * This is the model class for table "praanestesi_t".
 *
 * The followings are the available columns in table 'praanestesi_t':
 * @property integer $praanestesi_id
 * @property integer $pasienanastesi_id
 * @property integer $ruangan_id
 * @property integer $kamarruangan_id
 * @property integer $anamesa_id
 * @property integer $pemeriksaanfisik_id
 * @property integer $hasilpemeriksaanlab_id
 * @property string $nopraanestesi
 * @property string $tglpraanestesi
 * @property integer $dokter_id
 * @property integer $perawat1_id
 * @property integer $perawat2_id
 * @property string $tglpuasa
 * @property string $tekniksedasi
 * @property string $ketpraanestesi
 * @property integer $instalasipasca_id
 * @property integer $ruanganpasca_id
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 * @property string $monitoring
 *
 * The followings are the available model relations:
 * @property TindakananestesiT[] $tindakananestesiTs
 * @property ObatalkesanestesiT[] $obatalkesanestesiTs
 * @property IntraanestesiT[] $intraanestesiTs
 * @property PasienanastesiT $pasienanastesi
 * @property RuanganM $ruangan
 * @property KamarruanganM $kamarruangan
 * @property AnamnesaT $anamesa
 * @property PemeriksaanfisikT $pemeriksaanfisik
 * @property HasilpemeriksaanlabT $hasilpemeriksaanlab
 * @property PegawaiM $dokter
 * @property PegawaiM $perawat1
 * @property PegawaiM $perawat2
 * @property InstalasiM $instalasipasca
 * @property RuanganM $ruanganpasca
 */
class PraanestesiT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PraanestesiT the static model class
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
		return 'praanestesi_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pasienanastesi_id, ruangan_id, nopraanestesi, tglpraanestesi, dokter_id, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('pasienanastesi_id, ruangan_id, kamarruangan_id, anamesa_id, pemeriksaanfisik_id, hasilpemeriksaanlab_id, dokter_id, perawat1_id, perawat2_id, instalasipasca_id, ruanganpasca_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('nopraanestesi, tekniksedasi', 'length', 'max'=>20),
			array('monitoring', 'length', 'max'=>500),
			array('tglpuasa, ketpraanestesi, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('praanestesi_id, pasienanastesi_id, ruangan_id, kamarruangan_id, anamesa_id, pemeriksaanfisik_id, hasilpemeriksaanlab_id, nopraanestesi, tglpraanestesi, dokter_id, perawat1_id, perawat2_id, tglpuasa, tekniksedasi, ketpraanestesi, instalasipasca_id, ruanganpasca_id, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, monitoring', 'safe', 'on'=>'search'),
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
			'tindakananestesiTs' => array(self::HAS_MANY, 'TindakananestesiT', 'praanestesi_id'),
			'obatalkesanestesiTs' => array(self::HAS_MANY, 'ObatalkesanestesiT', 'praanestesi_id'),
			'intraanestesiTs' => array(self::HAS_MANY, 'IntraanestesiT', 'praanestesi_id'),
			'pasienanastesi' => array(self::BELONGS_TO, 'PasienanastesiT', 'pasienanastesi_id'),
			'ruangan' => array(self::BELONGS_TO, 'RuanganM', 'ruangan_id'),
			'kamarruangan' => array(self::BELONGS_TO, 'KamarruanganM', 'kamarruangan_id'),
			'anamesa' => array(self::BELONGS_TO, 'AnamnesaT', 'anamesa_id'),
			'pemeriksaanfisik' => array(self::BELONGS_TO, 'PemeriksaanfisikT', 'pemeriksaanfisik_id'),
			'hasilpemeriksaanlab' => array(self::BELONGS_TO, 'HasilpemeriksaanlabT', 'hasilpemeriksaanlab_id'),
			'dokter' => array(self::BELONGS_TO, 'PegawaiM', 'dokter_id'),
			'perawat1' => array(self::BELONGS_TO, 'PegawaiM', 'perawat1_id'),
			'perawat2' => array(self::BELONGS_TO, 'PegawaiM', 'perawat2_id'),
			'instalasipasca' => array(self::BELONGS_TO, 'InstalasiM', 'instalasipasca_id'),
			'ruanganpasca' => array(self::BELONGS_TO, 'RuanganM', 'ruanganpasca_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'praanestesi_id' => 'Praanestesi',
			'pasienanastesi_id' => 'Pasienanastesi',
			'ruangan_id' => 'Ruangan',
			'kamarruangan_id' => 'Kamarruangan',
			'anamesa_id' => 'Anamesa',
			'pemeriksaanfisik_id' => 'Pemeriksaanfisik',
			'hasilpemeriksaanlab_id' => 'Hasilpemeriksaanlab',
			'nopraanestesi' => 'Nopraanestesi',
			'tglpraanestesi' => 'Tglpraanestesi',
			'dokter_id' => 'Dokter',
			'perawat1_id' => 'Perawat1',
			'perawat2_id' => 'Perawat2',
			'tglpuasa' => 'Tglpuasa',
			'tekniksedasi' => 'Tekniksedasi',
			'ketpraanestesi' => 'Ketpraanestesi',
			'instalasipasca_id' => 'Instalasipasca',
			'ruanganpasca_id' => 'Ruanganpasca',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai_id' => 'Create Loginpemakai',
			'update_loginpemakai_id' => 'Update Loginpemakai',
			'create_ruangan' => 'Create Ruangan',
			'monitoring' => 'Monitoring',
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

		if(!empty($this->praanestesi_id)){
			$criteria->addCondition('praanestesi_id = '.$this->praanestesi_id);
		}
		if(!empty($this->pasienanastesi_id)){
			$criteria->addCondition('pasienanastesi_id = '.$this->pasienanastesi_id);
		}
		if(!empty($this->ruangan_id)){
			$criteria->addCondition('ruangan_id = '.$this->ruangan_id);
		}
		if(!empty($this->kamarruangan_id)){
			$criteria->addCondition('kamarruangan_id = '.$this->kamarruangan_id);
		}
		if(!empty($this->anamesa_id)){
			$criteria->addCondition('anamesa_id = '.$this->anamesa_id);
		}
		if(!empty($this->pemeriksaanfisik_id)){
			$criteria->addCondition('pemeriksaanfisik_id = '.$this->pemeriksaanfisik_id);
		}
		if(!empty($this->hasilpemeriksaanlab_id)){
			$criteria->addCondition('hasilpemeriksaanlab_id = '.$this->hasilpemeriksaanlab_id);
		}
		$criteria->compare('LOWER(nopraanestesi)',strtolower($this->nopraanestesi),true);
		$criteria->compare('LOWER(tglpraanestesi)',strtolower($this->tglpraanestesi),true);
		if(!empty($this->dokter_id)){
			$criteria->addCondition('dokter_id = '.$this->dokter_id);
		}
		if(!empty($this->perawat1_id)){
			$criteria->addCondition('perawat1_id = '.$this->perawat1_id);
		}
		if(!empty($this->perawat2_id)){
			$criteria->addCondition('perawat2_id = '.$this->perawat2_id);
		}
		$criteria->compare('LOWER(tglpuasa)',strtolower($this->tglpuasa),true);
		$criteria->compare('LOWER(tekniksedasi)',strtolower($this->tekniksedasi),true);
		$criteria->compare('LOWER(ketpraanestesi)',strtolower($this->ketpraanestesi),true);
		if(!empty($this->instalasipasca_id)){
			$criteria->addCondition('instalasipasca_id = '.$this->instalasipasca_id);
		}
		if(!empty($this->ruanganpasca_id)){
			$criteria->addCondition('ruanganpasca_id = '.$this->ruanganpasca_id);
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