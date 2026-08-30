<?php

/**
 * This is the model class for table "kesejahteraanibuoksitosin_t".
 *
 * The followings are the available columns in table 'kesejahteraanibuoksitosin_t':
 * @property integer $kesejahteraanibuplano_id
 * @property integer $kesejahteraanibu_id
 * @property string $hasilpemeriksaan_nama
 *
 * The followings are the available model relations:
 * @property KesejahteraanibuT $kesejahteraanibu
 */
class KesejahteraanibuplanoT extends CActiveRecord
{
    public $is_plano;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return KesejahteraanibuplanoT the static model class
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
		return 'kesejahteraanibuplano_t';
	}
    	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('kesejahteraanibu_id', 'required'),
			array('kesejahteraanibu_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('kesejahteraanibuplano_id, kesejahteraanibu_id, hasilpemeriksaan_nama', 'safe', 'on'=>'search'),
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
			'kesejahteraanibu' => array(self::BELONGS_TO, 'KesejahteraanibuT', 'kesejahteraanibu_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'kesejahteraanibuplano_id' => 'kesejahteraanibuplano_id',
			'kesejahteraanibu_id' => 'Kesejahteraanibu',
			'hasilpemeriksaan_nama' => 'Hasil Pemeriksaan',
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

		$criteria->compare('kesejahteraanibuplano_id',$this->kesejahteraanibusuhu_id);
		$criteria->compare('kesejahteraanibu_id',$this->kesejahteraanibu_id);
		$criteria->compare('hasilpemeriksaan_nama',$this->hasilpemeriksaan);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

}