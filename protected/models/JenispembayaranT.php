<?php

/**
 * This is the model class for table "jenispembayaran_t".
 *
 * The followings are the available columns in table 'jenispembayaran_t':
 * @property integer $jenispembayaran_id
 * @property integer $jnspembayar_id
 * @property integer $tandabuktibayar_id
 * @property string $nokartu
 * @property string $nostruk
 * @property string $noreferensi
 * @property string $tgltransaksi
 * @property string $pemilikkartu
 * @property string $bank
 * @property integer $bankpenerima_id
 * @property double $jumlahpembayaran
 *
 * The followings are the available model relations:
 * @property TandabuktibayarT $tandabuktibayar
 * @property BankM $bankpenerima
 */
class JenispembayaranT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return JenispembayaranT the static model class
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
		return 'jenispembayaran_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('jnspembayar_id, tandabuktibayar_id', 'required'),
			array('jnspembayar_id, tandabuktibayar_id, bankpenerima_id', 'numerical', 'integerOnly'=>true),
			array('jumlahpembayaran', 'numerical'),
			array('nokartu, nostruk, noreferensi, bank', 'length', 'max'=>50),
			array('pemilikkartu', 'length', 'max'=>100),
			array('tgltransaksi, tgljatuhtempo', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('jenispembayaran_id, jnspembayar_id, tandabuktibayar_id, nokartu, nostruk, noreferensi, tgltransaksi, pemilikkartu, bank, bankpenerima_id, jumlahpembayaran, tgljatuhtempo', 'safe', 'on'=>'search'),
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
			'tandabuktibayar' => array(self::BELONGS_TO, 'TandabuktibayarT', 'tandabuktibayar_id'),
			'bankpenerima' => array(self::BELONGS_TO, 'BankM', 'bankpenerima_id'),
			'jnspembayar' => array(self::BELONGS_TO, 'JnspembayarM', 'jnspembayar_id'),

		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'jenispembayaran_id' => 'Jenispembayaran',
			'jnspembayar_id' => 'Jnspembayar',
			'tandabuktibayar_id' => 'Tandabuktibayar',
			'nokartu' => 'Nokartu',
			'nostruk' => 'Nostruk',
			'noreferensi' => 'Noreferensi',
			'tgltransaksi' => 'Tgltransaksi',
			'pemilikkartu' => 'Pemilikkartu',
			'bank' => 'Bank',
			'bankpenerima_id' => 'Bankpenerima',
			'jumlahpembayaran' => 'Jumlahpembayaran',
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

		$criteria->compare('jenispembayaran_id',$this->jenispembayaran_id);
		$criteria->compare('jnspembayar_id',$this->jnspembayar_id);
		$criteria->compare('tandabuktibayar_id',$this->tandabuktibayar_id);
		$criteria->compare('nokartu',$this->nokartu,true);
		$criteria->compare('nostruk',$this->nostruk,true);
		$criteria->compare('noreferensi',$this->noreferensi,true);
		$criteria->compare('tgltransaksi',$this->tgltransaksi,true);
		$criteria->compare('pemilikkartu',$this->pemilikkartu,true);
		$criteria->compare('bank',$this->bank,true);
		$criteria->compare('bankpenerima_id',$this->bankpenerima_id);
		$criteria->compare('jumlahpembayaran',$this->jumlahpembayaran);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
