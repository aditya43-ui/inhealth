<?php

/**
 * This is the model class for table "mberitakomentar_t".
 *
 * The followings are the available columns in table 'mberitakomentar_t':
 * @property integer $mberitakomentar_id
 * @property integer $mberita_id
 * @property string $tglkomentar
 * @property string $namakomentar
 * @property string $emailkomentar
 * @property string $isikomentar
 * @property boolean $tampilkankomentar
 *
 * The followings are the available model relations:
 * @property MberitaM $mberita
 */
class MberitakomentarT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return MberitakomentarT the static model class
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
		return 'mberitakomentar_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('mberita_id, tglkomentar, namakomentar, emailkomentar, isikomentar, tampilkankomentar', 'required'),
			array('mberita_id', 'numerical', 'integerOnly'=>true),
			array('namakomentar, emailkomentar', 'length', 'max'=>100),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('mberitakomentar_id, mberita_id, tglkomentar, namakomentar, emailkomentar, isikomentar, tampilkankomentar', 'safe', 'on'=>'search'),
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
			'mberita' => array(self::BELONGS_TO, 'MberitaM', 'mberita_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'mberitakomentar_id' => 'ID',
			'mberita_id' => 'Berita',
			'tglkomentar' => 'Tanggal Komentar',
			'namakomentar' => 'Nama Komentar',
			'emailkomentar' => 'Email Komentar',
			'isikomentar' => 'Isi Komentar',
			'tampilkankomentar' => 'Tampilkan Komentar',
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

		$criteria->compare('mberitakomentar_id',$this->mberitakomentar_id);
		$criteria->compare('mberita_id',$this->mberita_id);
		$criteria->compare('LOWER(tglkomentar)',strtolower($this->tglkomentar),true);
		$criteria->compare('LOWER(namakomentar)',strtolower($this->namakomentar),true);
		$criteria->compare('LOWER(emailkomentar)',strtolower($this->emailkomentar),true);
		$criteria->compare('LOWER(isikomentar)',strtolower($this->isikomentar),true);
		$criteria->compare('tampilkankomentar',$this->tampilkankomentar);

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