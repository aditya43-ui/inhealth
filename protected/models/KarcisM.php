<?php

/**
 * This is the model class for table "karcis_m".
 *
 * The followings are the available columns in table 'karcis_m':
 * @property integer $karcis_id
 * @property integer $daftartindakan_id
 * @property integer $ruangan_id
 * @property integer $asalrujukan_id
 * @property string $karcis_nama
 * @property string $karcis_namalainnya
 * @property boolean $karcis_aktif
 */
class KarcisM extends CActiveRecord
{
	public $jenistarif_id;
        public $daftartindakan_nama,$asalrujukan_id;
        public $ruangan_nama;
        public $StatusPasien;
        public $lookup_type;
        public $StatusItems;

    /**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return KarcisM the static model class
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
		return 'karcis_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('daftartindakan_id, ruangan_id, karcis_nama, , statuspasien', 'required'),
			array('daftartindakan_id, ruangan_id,asalrujukan_id', 'numerical', 'integerOnly'=>true),
			array('karcis_nama, karcis_namalainnya', 'length', 'max'=>100),
			array('karcis_aktif', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('karcis_id,daftartindakan_nama,ruangan_nama,asalrujukan_id, statuspasien, daftartindakan_id, ruangan_id, karcis_nama, karcis_namalainnya, karcis_aktif', 'safe', 'on'=>'search'),
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
                    'daftartindakan'=>array(self::BELONGS_TO, 'DaftartindakanM','daftartindakan_id'),
                    'ruangan'=>array(self::BELONGS_TO, 'RuanganM','ruangan_id'),
                    'asalrujukan'=>array(self::BELONGS_TO, 'AsalrujukanM','asalrujukan_id'),

					
                    //'lookup'=>array(self::BELONGS_TO, 'LookupM', 'lookup_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'karcis_id' => 'ID',
			'daftartindakan_id' => 'Daftar Tindakan',
			'ruangan_id' => 'Ruangan',
			'statuspasien' => 'Status Pasien',
            'daftartindakan_nama' => 'Daftar Tindakan',
			'ruangan_nama' => 'Ruangan',
			'karcis_nama' => 'Nama',
			'karcis_namalainnya' => 'Nama Lainnya',
			'karcis_aktif' => 'Aktif',
			'asalrujukan_id'=> 'Asal Rujukan'
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

		$criteria->compare('karcis_id',$this->karcis_id);
		$criteria->compare('t.daftartindakan_id',$this->daftartindakan_id);
      	$criteria->compare('LOWER(daftartindakan.daftartindakan_nama)',strtolower($this->daftartindakan_nama),true);
		$criteria->compare('t.ruangan_id',$this->ruangan_id);
   	    $criteria->compare('LOWER(ruangan.ruangan_nama)',strtolower($this->ruangan_nama),true);
		$criteria->compare('LOWER(statuspasien)',strtolower($this->statuspasien),true);
		$criteria->compare('LOWER(karcis_nama)',strtolower($this->karcis_nama),true);
		$criteria->compare('LOWER(karcis_namalainnya)',strtolower($this->karcis_namalainnya),true);
		$criteria->compare('karcis_aktif',isset($this->karcis_aktif)?$this->karcis_aktif:true);
//                $criteria->addCondition('karcis_aktif is true');
//                $criteria->order=karcis_nama;
                $criteria->with=array('daftartindakan','ruangan',
                	//'lookup'
                	);
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('karcis_id',$this->karcis_id);
		$criteria->compare('t.daftartindakan_id',$this->daftartindakan_id);
		$criteria->compare('t.ruangan_id',$this->ruangan_id);
		$criteria->compare('LOWER(karcis_nama)',strtolower($this->karcis_nama),true);
		$criteria->compare('LOWER(karcis_namalainnya)',strtolower($this->karcis_namalainnya),true);
		$criteria->compare('LOWER(statuspasien)',strtolower($this->statuspasien),true);
//		$criteria->compare('karcis_aktif',$this->karcis_aktif);
                $criteria->with=array('daftartindakan','ruangan');
//                $criteria->order=karcis_nama;
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
        
        public function getDaftarTindakanItems()
        {
            return DaftartindakanM::model()->findAll('daftartindakan_aktif=TRUE AND daftartindakan_karcis=TRUE ORDER BY daftartindakan_nama');
        }
        
        public function getRuanganItems()
        {
            return RuanganM::model()->findAll('ruangan_aktif=TRUE ORDER BY ruangan_nama ');
        }

		public function getAsalRujukan()
        {
            return AsalrujukanM::model()->findAll('asalrujukan_aktif=TRUE ORDER BY asalrujukan_nama ');
        }

        public function getLookupItems()
        {
        	return LookupM::model()->findAll("lookup_aktif=TRUE and lookup_type ILIKE '%statuspasien%' ORDER BY lookup_type ");
        }
        

}