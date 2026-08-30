<?php

/**
 * This is the model class for table "laporankartupiutang_v".
 *
 * The followings are the available columns in table 'laporankartupiutang_v':
 * @property string $ref_id
 * @property string $notransaksi
 * @property string $tgltransaksi
 * @property integer $penjamin_id
 * @property string $penjamin_nama
 * @property double $nilaitransaksi
 * @property string $debitkredit
 * @property string $tgljatuhtempo
 */
class LaporankartupiutangV extends CActiveRecord
{
	public $tgl_awal;
	public $tgl_akhir;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LaporankartupiutangV the static model class
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
		return 'laporankartupiutang_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('penjamin_id', 'numerical', 'integerOnly'=>true),
			array('nilaitransaksi', 'numerical'),
			array('notransaksi, penjamin_nama', 'length', 'max'=>50),
			array('ref_id, tgltransaksi, debitkredit, tgljatuhtempo', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('ref_id, notransaksi, tgltransaksi, penjamin_id, penjamin_nama, nilaitransaksi, debitkredit, tgljatuhtempo', 'safe', 'on'=>'search'),
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
			'ref_id' => 'Ref',
			'notransaksi' => 'Notransaksi',
			'tgltransaksi' => 'Tgltransaksi',
			'penjamin_id' => 'Penjamin',
			'penjamin_nama' => 'Penjamin Nama',
			'nilaitransaksi' => 'Nilaitransaksi',
			'debitkredit' => 'Debitkredit',
			'tgljatuhtempo' => 'Tgl. Jatuh Tempo',
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

		$criteria->compare('ref_id',$this->ref_id,true);
		$criteria->compare('notransaksi',$this->notransaksi,true);
		$criteria->compare('tgltransaksi',$this->tgltransaksi,true);
		$criteria->compare('penjamin_id',$this->penjamin_id);
		$criteria->compare('penjamin_nama',$this->penjamin_nama,true);
		$criteria->compare('nilaitransaksi',$this->nilaitransaksi);
		$criteria->compare('debitkredit',$this->debitkredit,true);
		$criteria->compare('tgljatuhtempo',$this->tgljatuhtempo,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}