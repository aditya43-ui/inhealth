<?php

/**
 * This is the model class for table "rekeningpelayanan_v".
 *
 * The followings are the available columns in table 'rekeningpelayanan_v':
 * @property integer $pelayananrek_id
 * @property integer $rekening5_id
 * @property integer $ruangan_id
 * @property integer $daftartindakan_id
 * @property string $jnspelayanan
 * @property integer $komponentarif_id
 * @property string $debitkredit
 * @property boolean $ispelayanan
 * @property boolean $isretur
 * @property string $saldonormal
 * @property integer $rekening1_id
 * @property integer $rekening2_id
 * @property integer $rekening3_id
 * @property integer $rekening4_id
 * @property integer $rekening
 * @property string $kdrekening5
 * @property string $nmrekening5
 * @property string $daftartindakan_nama
 * @property string $daftartindakan_kode
 * @property integer $tindakanruangan
 * @property integer $ruangan
 * @property integer $koderuangan
 * @property string $ruangan_nama
 */
class RekeningpelayananV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return RekeningpelayananV the static model class
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
		return 'rekeningpelayanan_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pelayananrek_id, rekening5_id, ruangan_id, daftartindakan_id, komponentarif_id, rekening1_id, rekening2_id, rekening3_id, rekening4_id, rekening, tindakanruangan, ruangan, koderuangan', 'numerical', 'integerOnly'=>true),
			array('jnspelayanan, kdrekening5, daftartindakan_kode', 'length', 'max'=>20),
			array('debitkredit', 'length', 'max'=>1),
                    array('komponentarif_nama', 'length', 'max'=>25),
			array('saldonormal', 'length', 'max'=>10),
			array('nmrekening5', 'length', 'max'=>500),
			array('daftartindakan_nama', 'length', 'max'=>200),
			array('ruangan_nama', 'length', 'max'=>50),
			array('ispelayanan, isretur, ispembayaran, ishutang', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pelayananrek_id, rekening5_id, ruangan_id, daftartindakan_id, jnspelayanan, komponentarif_id, debitkredit, ispelayanan, isretur, ispembayaran, ishutang, saldonormal, rekening1_id, rekening2_id, rekening3_id, rekening4_id, rekening, kdrekening5, nmrekening5, daftartindakan_nama, daftartindakan_kode, tindakanruangan, ruangan, koderuangan, ruangan_nama, komponentarif_nama', 'safe', 'on'=>'search'),
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
			'pelayananrek_id' => 'Pelayananrek',
			'rekening5_id' => 'Rekening5',
			'ruangan_id' => 'Ruangan',
			'daftartindakan_id' => 'Daftartindakan',
			'jnspelayanan' => 'Jnspelayanan',
			'komponentarif_id' => 'Komponentarif',
			'debitkredit' => 'Debitkredit',
			'ispelayanan' => 'Ispelayanan',
			'isretur' => 'Isretur',
			'saldonormal' => 'Saldo Normal',
			'rekening1_id' => 'Rekening1',
			'rekening2_id' => 'Rekening2',
			'rekening3_id' => 'Rekening3',
			'rekening4_id' => 'Rekening4',
			'rekening' => 'Rekening',
			'kdrekening5' => 'Kdrekening5',
			'nmrekening5' => 'Nmrekening5',
			'daftartindakan_nama' => 'Nama Daftar Tindakan',
			'daftartindakan_kode' => 'Daftartindakan Kode',
			'tindakanruangan' => 'Tindakanruangan',
			'ruangan' => 'Ruangan',
			'koderuangan' => 'Koderuangan',
			'ruangan_nama' => 'Ruangan Nama',
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

		$criteria->compare('pelayananrek_id',$this->pelayananrek_id);
		$criteria->compare('rekening5_id',$this->rekening5_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('daftartindakan_id',$this->daftartindakan_id);
		$criteria->compare('jnspelayanan',$this->jnspelayanan,true);
		$criteria->compare('komponentarif_id',$this->komponentarif_id);
		$criteria->compare('debitkredit',$this->debitkredit,true);
		$criteria->compare('ispelayanan',$this->ispelayanan);
		$criteria->compare('isretur',$this->isretur);
		$criteria->compare('saldonormal',$this->saldonormal,true);
		$criteria->compare('rekening1_id',$this->rekening1_id);
		$criteria->compare('rekening2_id',$this->rekening2_id);
		$criteria->compare('rekening3_id',$this->rekening3_id);
		$criteria->compare('rekening4_id',$this->rekening4_id);
		$criteria->compare('rekening',$this->rekening);
		$criteria->compare('kdrekening5',$this->kdrekening5,true);
		$criteria->compare('nmrekening5',$this->nmrekening5,true);
		$criteria->compare('daftartindakan_nama',$this->daftartindakan_nama,true);
		$criteria->compare('daftartindakan_kode',$this->daftartindakan_kode,true);
		$criteria->compare('tindakanruangan',$this->tindakanruangan);
		$criteria->compare('ruangan',$this->ruangan);
		$criteria->compare('koderuangan',$this->koderuangan);
		$criteria->compare('ruangan_nama',$this->ruangan_nama,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}