<?php

/**
 * This is the model class for table "ruanganlabpa_v".
 *
 * The followings are the available columns in table 'ruanganlabpa_v':
 * @property integer $instalasi_id
 * @property string $instalasi_nama
 * @property integer $ruangan_id
 * @property string $ruangan_nama
 * @property string $ruangan_namalainnya
 * @property string $ruangan_singkatan
 * @property boolean $ruangan_aktif
 * @property integer $riwayatruangan_id
 * @property string $ruangan_jenispelayanan
 * @property string $ruangan_fasilitas
 * @property string $ruangan_lokasi
 * @property string $ruangan_image
 */
class RuanganlabpaV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return RuanganlabpaV the static model class
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
		return 'ruanganlabpa_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('instalasi_id, ruangan_id, riwayatruangan_id', 'numerical', 'integerOnly'=>true),
			array('instalasi_nama, ruangan_nama, ruangan_namalainnya, ruangan_jenispelayanan, ruangan_lokasi', 'length', 'max'=>50),
			array('ruangan_singkatan', 'length', 'max'=>3),
			array('ruangan_image', 'length', 'max'=>100),
			array('ruangan_aktif, ruangan_fasilitas', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('instalasi_id, instalasi_nama, ruangan_id, ruangan_nama, ruangan_namalainnya, ruangan_singkatan, ruangan_aktif, riwayatruangan_id, ruangan_jenispelayanan, ruangan_fasilitas, ruangan_lokasi, ruangan_image', 'safe', 'on'=>'search'),
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
			'instalasi_id' => 'Instalasi',
			'instalasi_nama' => 'Instalasi Nama',
			'ruangan_id' => 'Ruangan',
			'ruangan_nama' => 'Ruangan Nama',
			'ruangan_namalainnya' => 'Ruangan Namalainnya',
			'ruangan_singkatan' => 'Ruangan Singkatan',
			'ruangan_aktif' => 'Ruangan Aktif',
			'riwayatruangan_id' => 'Riwayatruangan',
			'ruangan_jenispelayanan' => 'Ruangan Jenispelayanan',
			'ruangan_fasilitas' => 'Ruangan Fasilitas',
			'ruangan_lokasi' => 'Ruangan Lokasi',
			'ruangan_image' => 'Ruangan Image',
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

		if(!empty($this->instalasi_id)){
			$criteria->addCondition('instalasi_id = '.$this->instalasi_id);
		}
		$criteria->compare('LOWER(instalasi_nama)',strtolower($this->instalasi_nama),true);
		if(!empty($this->ruangan_id)){
			$criteria->addCondition('ruangan_id = '.$this->ruangan_id);
		}
		$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
		$criteria->compare('LOWER(ruangan_namalainnya)',strtolower($this->ruangan_namalainnya),true);
		$criteria->compare('LOWER(ruangan_singkatan)',strtolower($this->ruangan_singkatan),true);
		$criteria->compare('ruangan_aktif',$this->ruangan_aktif);
		if(!empty($this->riwayatruangan_id)){
			$criteria->addCondition('riwayatruangan_id = '.$this->riwayatruangan_id);
		}
		$criteria->compare('LOWER(ruangan_jenispelayanan)',strtolower($this->ruangan_jenispelayanan),true);
		$criteria->compare('LOWER(ruangan_fasilitas)',strtolower($this->ruangan_fasilitas),true);
		$criteria->compare('LOWER(ruangan_lokasi)',strtolower($this->ruangan_lokasi),true);
		$criteria->compare('LOWER(ruangan_image)',strtolower($this->ruangan_image),true);

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
        
        public static function loadInstalasi(){
            $cri = new CDbCriteria();
            $cri->group = " instalasi_id, instalasi_nama ";
            $cri->select = $cri->group;
            $cri->order = " instalasi_nama ASC ";
            $model = self::model()->findAll($cri);
            
            $arr = array();
            foreach($model as $d){
                $arr[] = $d->instalasi_id;
            }
            
            return $arr;
        }
}