<?php

/**
 * This is the model class for table "rl3_15_kegiatancarabayar_v".
 *
 * The followings are the available columns in table 'rl3_15_kegiatancarabayar_v':
 * @property string $tgl_laporan
 * @property string $propinsi
 * @property string $koders
 * @property integer $profilrs_id
 * @property string $kabupaten
 * @property string $namars
 * @property integer $carabayar_id
 * @property string $carabayar_nama
 * @property string $carapembayaran_kode
 * @property string $carapembayaran_nama
 * @property string $pasienrawatinapkeluar
 * @property string $pasienrawatinaplamadirawat
 * @property string $pasienrawatjalan
 * @property string $pasienlaboratorium
 * @property string $pasienradiologi
 * @property string $pasienrawatjalanlain
 */
class Rl315KegiatancarabayarV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Rl315KegiatancarabayarV the static model class
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
		return 'rl3_15_kegiatancarabayar_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('profilrs_id, carabayar_id', 'numerical', 'integerOnly'=>true),
			array('propinsi, koders, kabupaten, namars, carabayar_nama, carapembayaran_nama', 'length', 'max'=>50),
			array('carapembayaran_kode', 'length', 'max'=>10),
			array('tgl_laporan, pasienrawatinapkeluar, pasienrawatinaplamadirawat, pasienrawatjalan, pasienlaboratorium, pasienradiologi, pasienrawatjalanlain', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('tgl_laporan, propinsi, koders, profilrs_id, kabupaten, namars, carabayar_id, carabayar_nama, carapembayaran_kode, carapembayaran_nama, pasienrawatinapkeluar, pasienrawatinaplamadirawat, pasienrawatjalan, pasienlaboratorium, pasienradiologi, pasienrawatjalanlain', 'safe', 'on'=>'search'),
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
			'tgl_laporan' => 'Tgl. Laporan',
			'propinsi' => 'Provinsi',
			'koders' => 'Koders',
			'profilrs_id' => 'Profilrs',
			'kabupaten' => 'Kabupaten',
			'namars' => 'Namars',
			'carabayar_id' => 'Jenis Penjamin',
			'carabayar_nama' => 'Carabayar Nama',
			'carapembayaran_kode' => 'Carapembayaran Kode',
			'carapembayaran_nama' => 'Carapembayaran Nama',
			'pasienrawatinapkeluar' => 'Pasienrawatinapkeluar',
			'pasienrawatinaplamadirawat' => 'Pasienrawatinaplamadirawat',
			'pasienrawatjalan' => 'Pasienrawatjalan',
			'pasienlaboratorium' => 'Pasienlaboratorium',
			'pasienradiologi' => 'Pasienradiologi',
			'pasienrawatjalanlain' => 'Pasienrawatjalanlain',
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

		$criteria->compare('LOWER(tgl_laporan)',strtolower($this->tgl_laporan),true);
		$criteria->compare('LOWER(propinsi)',strtolower($this->propinsi),true);
		$criteria->compare('LOWER(koders)',strtolower($this->koders),true);
		if(!empty($this->profilrs_id)){
			$criteria->addCondition('profilrs_id = '.$this->profilrs_id);
		}
		$criteria->compare('LOWER(kabupaten)',strtolower($this->kabupaten),true);
		$criteria->compare('LOWER(namars)',strtolower($this->namars),true);
		if(!empty($this->carabayar_id)){
			$criteria->addCondition('carabayar_id = '.$this->carabayar_id);
		}
		$criteria->compare('LOWER(carabayar_nama)',strtolower($this->carabayar_nama),true);
		$criteria->compare('LOWER(carapembayaran_kode)',strtolower($this->carapembayaran_kode),true);
		$criteria->compare('LOWER(carapembayaran_nama)',strtolower($this->carapembayaran_nama),true);
		$criteria->compare('LOWER(pasienrawatinapkeluar)',strtolower($this->pasienrawatinapkeluar),true);
		$criteria->compare('LOWER(pasienrawatinaplamadirawat)',strtolower($this->pasienrawatinaplamadirawat),true);
		$criteria->compare('LOWER(pasienrawatjalan)',strtolower($this->pasienrawatjalan),true);
		$criteria->compare('LOWER(pasienlaboratorium)',strtolower($this->pasienlaboratorium),true);
		$criteria->compare('LOWER(pasienradiologi)',strtolower($this->pasienradiologi),true);
		$criteria->compare('LOWER(pasienrawatjalanlain)',strtolower($this->pasienrawatjalanlain),true);

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