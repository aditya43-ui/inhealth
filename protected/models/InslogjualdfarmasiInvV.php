<?php

/**
 * This is the model class for table "inslogjualdfarmasi_inv_v".
 *
 * The followings are the available columns in table 'inslogjualdfarmasi_inv_v':
 * @property string $kodebarang
 * @property double $hpp
 * @property string $satuan
 * @property integer $ststock
 * @property string $stracik
 * @property string $signa
 * @property string $frek
 * @property string $jfrek
 * @property string $peng
 * @property string $penf
 * @property string $sp
 * @property string $ss
 * @property string $ssr
 * @property string $sm
 * @property double $jumlah
 * @property double $harga
 * @property double $hargaretur
 * @property string $kode
 * @property string $kodejual
 */
class InslogjualdfarmasiInvV extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'inslogjualdfarmasi_inv_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ststock', 'numerical', 'integerOnly'=>true),
			array('hpp, jumlah, harga, hargaretur', 'numerical'),
			array('kodebarang', 'length', 'max'=>200),
			array('satuan', 'length', 'max'=>50),
			array('signa', 'length', 'max'=>30),
			array('frek', 'length', 'max'=>100),
			array('kode, kodejual', 'length', 'max'=>255),
			array('stracik, jfrek, peng, penf, sp, ss, ssr, sm', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('kodebarang, hpp, satuan, ststock, stracik, signa, frek, jfrek, peng, penf, sp, ss, ssr, sm, jumlah, harga, hargaretur, kode, kodejual', 'safe', 'on'=>'search'),
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
			'kodebarang' => 'Kodebarang',
			'hpp' => 'Hpp',
			'satuan' => 'Satuan',
			'ststock' => 'Ststock',
			'stracik' => 'Stracik',
			'signa' => 'Signa',
			'frek' => 'Frek',
			'jfrek' => 'Jfrek',
			'peng' => 'Peng',
			'penf' => 'Penf',
			'sp' => 'Sp',
			'ss' => 'Ss',
			'ssr' => 'Ssr',
			'sm' => 'Sm',
			'jumlah' => 'Jumlah',
			'harga' => 'Harga',
			'hargaretur' => 'Hargaretur',
			'kode' => 'Kode',
			'kodejual' => 'Kodejual',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('kodebarang',$this->kodebarang,true);
		$criteria->compare('hpp',$this->hpp);
		$criteria->compare('satuan',$this->satuan,true);
		$criteria->compare('ststock',$this->ststock);
		$criteria->compare('stracik',$this->stracik,true);
		$criteria->compare('signa',$this->signa,true);
		$criteria->compare('frek',$this->frek,true);
		$criteria->compare('jfrek',$this->jfrek,true);
		$criteria->compare('peng',$this->peng,true);
		$criteria->compare('penf',$this->penf,true);
		$criteria->compare('sp',$this->sp,true);
		$criteria->compare('ss',$this->ss,true);
		$criteria->compare('ssr',$this->ssr,true);
		$criteria->compare('sm',$this->sm,true);
		$criteria->compare('jumlah',$this->jumlah);
		$criteria->compare('harga',$this->harga);
		$criteria->compare('hargaretur',$this->hargaretur);
		$criteria->compare('kode',$this->kode,true);
		$criteria->compare('kodejual',$this->kodejual,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return InslogjualdfarmasiInvV the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
