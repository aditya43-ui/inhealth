<?php

/**
 * This is the model class for table "mkategoriberita_m".
 *
 * The followings are the available columns in table 'mkategoriberita_m':
 * @property integer $mkategoriberita_id
 * @property string $kategoriberita
 * @property string $ketkategoriberita
 * @property integer $urutankategori
 * @property boolean $kategoriberita_aktif
 *
 * The followings are the available model relations:
 * @property MberitaM[] $mberitaMs
 */
class MkategoriberitaM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return MkategoriberitaM the static model class
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
		return 'mkategoriberita_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('kategoriberita, urutankategori, kategoriberita_aktif', 'required'),
			array('urutankategori', 'numerical', 'integerOnly'=>true),
			array('kategoriberita', 'length', 'max'=>100),
			array('ketkategoriberita', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('mkategoriberita_id, kategoriberita, ketkategoriberita, urutankategori, kategoriberita_aktif', 'safe', 'on'=>'search'),
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
			'mberitaMs' => array(self::HAS_MANY, 'MberitaM', 'mkategoriberita_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'mkategoriberita_id' => 'ID',
			'kategoriberita' => 'Kategori Berita',
			'ketkategoriberita' => 'Keterangan Kategori Berita',
			'urutankategori' => 'Urutan Kategori',
			'kategoriberita_aktif' => 'Aktif',
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

		$criteria->compare('mkategoriberita_id',$this->mkategoriberita_id);
		$criteria->compare('LOWER(kategoriberita)',strtolower($this->kategoriberita),true);
		$criteria->compare('LOWER(ketkategoriberita)',strtolower($this->ketkategoriberita),true);
		$criteria->compare('urutankategori',$this->urutankategori);
		$criteria->compare('kategoriberita_aktif',$this->kategoriberita_aktif);

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