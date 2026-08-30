<?php

/**
 * This is the model class for table "mberita_m".
 *
 * The followings are the available columns in table 'mberita_m':
 * @property integer $mberita_id
 * @property integer $mkategoriberita_id
 * @property string $judulberita
 * @property string $ringkasanberita
 * @property string $isiberita
 * @property string $gambarberita_path
 * @property string $gambarberita_text
 * @property string $keteranganberita
 * @property string $beritaterkait
 * @property string $waktutampilberita
 * @property string $waktuselesaitampil
 * @property string $tglbuatberita
 * @property string $create_user
 *
 * The followings are the available model relations:
 * @property MkategoriberitaM $mkategoriberita
 */
class MberitaM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return MberitaM the static model class
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
		return 'mberita_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('mkategoriberita_id, judulberita, ringkasanberita, isiberita, waktutampilberita, tglbuatberita, create_user', 'required'),
			array('mkategoriberita_id', 'numerical', 'integerOnly'=>true),
			array('judulberita', 'length', 'max'=>200),
			array('ringkasanberita', 'length', 'max'=>500),
			array('gambarberita_path', 'length', 'max'=>300),
			array('gambarberita_text, create_user', 'length', 'max'=>100),
			array('keteranganberita, beritaterkait, waktuselesaitampil', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('mberita_id, mkategoriberita_id, judulberita, ringkasanberita, isiberita, gambarberita_path, gambarberita_text, keteranganberita, beritaterkait, waktutampilberita, waktuselesaitampil, tglbuatberita, create_user', 'safe', 'on'=>'search'),
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
			'mkategoriberita' => array(self::BELONGS_TO, 'MkategoriberitaM', 'mkategoriberita_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'mberita_id' => 'ID',
			'mkategoriberita_id' => 'Kategori',
			'judulberita' => 'Judul Berita',
			'ringkasanberita' => 'Ringkasan Berita',
			'isiberita' => 'Isi Berita',
			'gambarberita_path' => 'Gambar Berita Path',
			'gambarberita_text' => 'Gambar Berita Text',
			'keteranganberita' => 'Keterangan Berita',
			'beritaterkait' => 'Berita Terkait',
			'waktutampilberita' => 'Waktu Tampil',
			'waktuselesaitampil' => 'Waktu Selesai Tampil',
			'tglbuatberita' => 'Tgl. Buat Berita',
			'create_user' => 'Create User',
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

		$criteria->compare('mberita_id',$this->mberita_id);
		$criteria->compare('mkategoriberita_id',$this->mkategoriberita_id);
		$criteria->compare('LOWER(judulberita)',strtolower($this->judulberita),true);
		$criteria->compare('LOWER(ringkasanberita)',strtolower($this->ringkasanberita),true);
		$criteria->compare('LOWER(isiberita)',strtolower($this->isiberita),true);
		$criteria->compare('LOWER(gambarberita_path)',strtolower($this->gambarberita_path),true);
		$criteria->compare('LOWER(gambarberita_text)',strtolower($this->gambarberita_text),true);
		$criteria->compare('LOWER(keteranganberita)',strtolower($this->keteranganberita),true);
		$criteria->compare('LOWER(beritaterkait)',strtolower($this->beritaterkait),true);
		$criteria->compare('LOWER(waktutampilberita)',strtolower($this->waktutampilberita),true);
		$criteria->compare('LOWER(waktuselesaitampil)',strtolower($this->waktuselesaitampil),true);
		$criteria->compare('LOWER(tglbuatberita)',strtolower($this->tglbuatberita),true);
		$criteria->compare('LOWER(create_user)',strtolower($this->create_user),true);

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