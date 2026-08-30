<?php

/**
 * This is the model class for table "laporankartupiutangpembbankdigital_v".
 *
 * The followings are the available columns in table 'laporankartupiutangpembbankdigital_v':
 * @property string $tglpembayaran
 * @property string $nopembayaran
 * @property string $notransaksi
 * @property string $tgljatuhtempo
 * @property string $jnspembayar_nama
 * @property double $saldodebit
 * @property double $saldokredit
 * @property string $jenistransaksi
 * @property integer $nourut
 */
class LaporankartupiutangpembbankdigitalV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LaporankartupiutangpembbankdigitalV the static model class
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
		return 'laporankartupiutangpembbankdigital_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nourut, jnspembayar_id', 'numerical', 'integerOnly'=>true),
			array('saldodebit, saldokredit', 'numerical'),
			array('nopembayaran, notransaksi', 'length', 'max'=>50),
			array('jnspembayar_nama, namabank', 'length', 'max'=>100),
			array('tglpembayaran, tgljatuhtempo, jenistransaksi', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('tglpembayaran, nopembayaran, notransaksi, tgljatuhtempo, jnspembayar_nama, saldodebit, saldokredit, jenistransaksi, nourut, namabank, jnspembayar_id', 'safe', 'on'=>'search'),
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
			'tglpembayaran' => 'Tgl. Pembayaran',
			'nopembayaran' => 'No. Pembayaran',
			'notransaksi' => 'Notransaksi',
			'tgljatuhtempo' => 'Tgl. Jatuh Tempo',
			'jnspembayar_nama' => 'Jnspembayar Nama',
			'saldodebit' => 'Saldodebit',
			'saldokredit' => 'Saldokredit',
			'jenistransaksi' => 'Jenistransaksi',
			'nourut' => 'Nourut',
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

		$criteria->compare('tglpembayaran',$this->tglpembayaran,true);
		$criteria->compare('nopembayaran',$this->nopembayaran,true);
		$criteria->compare('notransaksi',$this->notransaksi,true);
		$criteria->compare('tgljatuhtempo',$this->tgljatuhtempo,true);
		$criteria->compare('jnspembayar_nama',$this->jnspembayar_nama,true);
		$criteria->compare('saldodebit',$this->saldodebit);
		$criteria->compare('saldokredit',$this->saldokredit);
		$criteria->compare('jenistransaksi',$this->jenistransaksi,true);
		$criteria->compare('nourut',$this->nourut);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
