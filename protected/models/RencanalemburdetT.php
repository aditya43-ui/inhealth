<?php

/**
 * Untuk menampung pegawai pada rencana lembur.
 *
 * The followings are the available columns in table 'rencanalemburdet_t':
 * @property integer $rencanalemburdet_id
 * @property integer $pegawai_id
 * @property integer $rencanalembur_id
 * @property string $nourut
 * @property string $tglmulai
 * @property string $tglselesai
 * @property string $alasanlembur
 *
 * The followings are the available model relations:
 * @property RencanalemburT $rencanalembur
 */
class RencanalemburdetT extends CActiveRecord
{
    public $jamMulai, $jamSelesai;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return RencanalemburdetT the static model class
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
		return 'rencanalemburdet_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pegawai_id, rencanalembur_id, nourut, tglmulai', 'required'),
			array('pegawai_id, rencanalembur_id', 'numerical', 'integerOnly'=>true),
			array('nourut', 'length', 'max'=>3),
			array('alasanlembur', 'length', 'max'=>500),
			array('tglselesai, bayarlembur_id', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('rencanalemburdet_id, pegawai_id, bayarlembur_id, rencanalembur_id, nourut, tglmulai, tglselesai, alasanlembur', 'safe', 'on'=>'search'),
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
			'rencanalembur' => array(self::BELONGS_TO, 'RencanalemburT', 'rencanalembur_id'),
            'pegawai' => array(self::BELONGS_TO, 'PegawaiM', 'pegawai_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'rencanalemburdet_id' => 'Rencanalemburdet',
			'pegawai_id' => 'Pegawai',
			'rencanalembur_id' => 'Rencanalembur',
			'nourut' => 'Nourut',
			'tglmulai' => 'Tglmulai',
			'tglselesai' => 'Tglselesai',
			'alasanlembur' => 'Alasanlembur',
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

		$criteria->compare('rencanalemburdet_id',$this->rencanalemburdet_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('rencanalembur_id',$this->rencanalembur_id);
		$criteria->compare('nourut',$this->nourut,true);
		$criteria->compare('tglmulai',$this->tglmulai,true);
		$criteria->compare('tglselesai',$this->tglselesai,true);
		$criteria->compare('alasanlembur',$this->alasanlembur,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}