<?php

/**
 * This is the model class for table "intervensicegahjatuhpasiendet_t".
 *
 * The followings are the available columns in table 'intervensicegahjatuhpasiendet_t':
 * @property integer $intervensicegahjatuhpasiendet_id
 * @property integer $intervensicegahjatuhpasien_id
 * @property string $intervensicegahjatuh_nama
 * @property string $intervensicegahjatuh_tingkat
 * @property boolean $isdilakukan
 * @property integer $intervensicegahjatuh_urutan
 *
 * The followings are the available model relations:
 * @property IntervensicegahjatuhpasienT $intervensicegahjatuhpasien
 */
class IntervensicegahjatuhpasiendetT extends CActiveRecord
{
    public $isdilakukan_r, $intervensicegahjatuh_nama_r, $intervensicegahjatuh_urutan_r, $intervensicegahjatuh_tingkat_r;
    public $isdilakukan_s, $intervensicegahjatuh_nama_s, $intervensicegahjatuh_urutan_s, $intervensicegahjatuh_tingkat_s;
    public $isdilakukan_t, $intervensicegahjatuh_nama_t, $intervensicegahjatuh_urutan_t, $intervensicegahjatuh_tingkat_t;

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return IntervensicegahjatuhpasiendetT the static model class
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
		return 'intervensicegahjatuhpasiendet_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('intervensicegahjatuhpasien_id, intervensicegahjatuh_nama, intervensicegahjatuh_tingkat, isdilakukan', 'required'),
			array('intervensicegahjatuhpasien_id, intervensicegahjatuh_urutan', 'numerical', 'integerOnly'=>true),
			array('intervensicegahjatuh_tingkat, kelompok_pasien', 'length', 'max'=>50),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('intervensicegahjatuhpasiendet_id, intervensicegahjatuhpasien_id, intervensicegahjatuh_nama, intervensicegahjatuh_tingkat, isdilakukan, intervensicegahjatuh_urutan, kelompok_pasien', 'safe', 'on'=>'search'),
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
			'intervensicegahjatuhpasien' => array(self::BELONGS_TO, 'IntervensicegahjatuhpasienT', 'intervensicegahjatuhpasien_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'intervensicegahjatuhpasiendet_id' => 'Intervensicegahjatuhpasiendet',
			'intervensicegahjatuhpasien_id' => 'Intervensicegahjatuhpasien',
			'intervensicegahjatuh_nama' => 'Intervensicegahjatuh Nama',
			'intervensicegahjatuh_tingkat' => 'Intervensicegahjatuh Tingkat',
			'isdilakukan' => 'Isdilakukan',
			'intervensicegahjatuh_urutan' => 'Intervensicegahjatuh Urutan',
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

		$criteria->compare('intervensicegahjatuhpasiendet_id',$this->intervensicegahjatuhpasiendet_id);
		$criteria->compare('intervensicegahjatuhpasien_id',$this->intervensicegahjatuhpasien_id);
		$criteria->compare('intervensicegahjatuh_nama',$this->intervensicegahjatuh_nama,true);
		$criteria->compare('intervensicegahjatuh_tingkat',$this->intervensicegahjatuh_tingkat,true);
		$criteria->compare('isdilakukan',$this->isdilakukan);
		$criteria->compare('intervensicegahjatuh_urutan',$this->intervensicegahjatuh_urutan);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
