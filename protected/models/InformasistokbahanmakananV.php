<?php

/**
 * This is the model class for table "informasistokbahanmakanan_v".
 *
 * The followings are the available columns in table 'informasistokbahanmakanan_v':
 * @property string $jenisbahanmakanan
 * @property integer $bahanmakanan_id
 * @property string $namabahanmakanan
 * @property integer $golbahanmakanan_id
 * @property string $golbahanmakanan_nama
 * @property string $satuanbahan
 * @property double $qtystok
 * @property string $tglkadaluarsabahan
 */
class InformasistokbahanmakananV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InformasistokbahanmakananV the static model class
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
		return 'informasistokbahanmakanan_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('bahanmakanan_id, golbahanmakanan_id, jmlminimal', 'numerical', 'integerOnly'=>true),
			array('qtystok, qtystok_masuk,qtystok_keluar,jmlpersediaan, qtystok_rusak, qtystok_baik', 'numerical'),
			array('jenisbahanmakanan, satuanbahan, kelbahanmakanan', 'length', 'max'=>50),
			array('namabahanmakanan, golbahanmakanan_nama', 'length', 'max'=>100),
			array('tglkadaluarsabahan', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('jenisbahanmakanan, bahanmakanan_id, namabahanmakanan, golbahanmakanan_id, golbahanmakanan_nama, satuanbahan, qtystok, tglkadaluarsabahan, kelbahanmakanan, qtystok_masuk,qtystok_keluar,jmlpersediaan, jmlminimal, qtystok_rusak, qtystok_baik', 'safe', 'on'=>'search'),
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
			'jenisbahanmakanan' => 'Jenisbahanmakanan',
			'bahanmakanan_id' => 'Bahanmakanan',
			'namabahanmakanan' => 'Namabahanmakanan',
			'golbahanmakanan_id' => 'Golbahanmakanan',
			'golbahanmakanan_nama' => 'Golbahanmakanan Nama',
			'satuanbahan' => 'Satuanbahan',
			'qtystok' => 'Qtystok',
			'tglkadaluarsabahan' => 'Tglkadaluarsabahan',
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

		$criteria->compare('jenisbahanmakanan',$this->jenisbahanmakanan,true);
		$criteria->compare('bahanmakanan_id',$this->bahanmakanan_id);
		$criteria->compare('namabahanmakanan',$this->namabahanmakanan,true);
		$criteria->compare('golbahanmakanan_id',$this->golbahanmakanan_id);
		$criteria->compare('golbahanmakanan_nama',$this->golbahanmakanan_nama,true);
		$criteria->compare('satuanbahan',$this->satuanbahan,true);
		$criteria->compare('qtystok',$this->qtystok);
		$criteria->compare('tglkadaluarsabahan',$this->tglkadaluarsabahan,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}