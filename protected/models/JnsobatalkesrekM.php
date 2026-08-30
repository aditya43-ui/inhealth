<?php

/**
 * This is the model class for table "jnsobatalkesrek_m".
 * @author Elham Budianto <elhambudianto@.com>
 * @package application.models
 * @category model
 *
 * The followings are the available columns in table 'jnsobatalkesrek_m':
 * @property integer $jnsobatalkesrek_id
 * @property integer $rekening5_id
 * @property string $debitkredit
 * @property integer $jenisobatalkes_id
 * @property boolean $isreturoa
 * @property boolean $ispenerimaanoa
 * @property boolean $isstokopnameoa
 * @property boolean $isreturpembelian
 * @property boolean $ispenjualanresep
 * @property boolean $ispemakaianruangan
 * @property boolean $ispemusnahan
 * @property boolean $isbahanproduksi
 * @property boolean $ishasilproduksi
 * @property boolean $isstokopnameoaberkurang
 * @property boolean $isstokberkurangoa
 * @property integer $ruangan_id
 * @property boolean $ismutasioa
 *
 * The followings are the available model relations:
 * @property JenisobatalkesM $jenisobatalkes
 * @property Rekening5M $rekening5
 */
class JnsobatalkesrekM extends CActiveRecord
{
    public $pilihan, $nmrekening5, $jenistransaksi;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return JnsobatalkesrekM the static model class
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
		return 'jnsobatalkesrek_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('rekening5_id, debitkredit', 'required'),
			array('rekening5_id, jenisobatalkes_id, ruangan_id', 'numerical', 'integerOnly'=>true),
			array('debitkredit', 'length', 'max'=>1),
			array('isreturoa, ispenerimaanoa, isstokopnameoa, isreturpembelian, ispenjualanresep, ispemakaianruangan, ispemusnahan, isbahanproduksi, ishasilproduksi, isstokopnameoaberkurang, isstokberkurangoa, ismutasioa, isstokopnameoabertambah, ispemakaianbhppasien', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('jnsobatalkesrek_id, rekening5_id, debitkredit, jenisobatalkes_id, isreturoa, ispenerimaanoa, isstokopnameoa, isreturpembelian, ispenjualanresep, ispemakaianruangan, ispemusnahan, isbahanproduksi, ishasilproduksi, isstokopnameoaberkurang, isstokberkurangoa, ruangan_id, ismutasioa, isstokopnameoabertambah, ispemakaianbhppasien', 'safe', 'on'=>'search'),
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
			'jenisobatalkes' => array(self::BELONGS_TO, 'JenisobatalkesM', 'jenisobatalkes_id'),
			'rekening5' => array(self::BELONGS_TO, 'Rekening5M', 'rekening5_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'jnsobatalkesrek_id' => 'Jnsobatalkesrek',
			'rekening5_id' => 'Rekening5',
			'debitkredit' => 'Debitkredit',
			'jenisobatalkes_id' => 'Jenisobatalkes',
			'isreturoa' => 'Isreturoa',
			'ispenerimaanoa' => 'Ispenerimaanoa',
			'isstokopnameoa' => 'Isstokopnameoa',
			'isreturpembelian' => 'Isreturpembelian',
			'ispenjualanresep' => 'Ispenjualanresep',
			'ispemakaianruangan' => 'Ispemakaianruangan',
			'ispemusnahan' => 'Ispemusnahan',
			'isbahanproduksi' => 'Isbahanproduksi',
			'ishasilproduksi' => 'Ishasilproduksi',
			'isstokopnameoaberkurang' => 'Isstokopnameoaberkurang',
			'isstokberkurangoa' => 'Isstokberkurangoa',
			'ruangan_id' => 'Ruangan',
			'ismutasioa' => 'Ismutasioa',
      'isstokopnameoabertambah'=>'Stok Opname Penyesuaian Bertambah'
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

		$criteria->compare('jnsobatalkesrek_id',$this->jnsobatalkesrek_id);
		$criteria->compare('rekening5_id',$this->rekening5_id);
		$criteria->compare('debitkredit',$this->debitkredit,true);
		$criteria->compare('jenisobatalkes_id',$this->jenisobatalkes_id);
		$criteria->compare('isreturoa',$this->isreturoa);
		$criteria->compare('ispenerimaanoa',$this->ispenerimaanoa);
		$criteria->compare('isstokopnameoa',$this->isstokopnameoa);
		$criteria->compare('isreturpembelian',$this->isreturpembelian);
		$criteria->compare('ispenjualanresep',$this->ispenjualanresep);
		$criteria->compare('ispemakaianruangan',$this->ispemakaianruangan);
		$criteria->compare('ispemusnahan',$this->ispemusnahan);
		$criteria->compare('isbahanproduksi',$this->isbahanproduksi);
		$criteria->compare('ishasilproduksi',$this->ishasilproduksi);
		$criteria->compare('isstokopnameoaberkurang',$this->isstokopnameoaberkurang);
		$criteria->compare('isstokberkurangoa',$this->isstokberkurangoa);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('ismutasioa',$this->ismutasioa);

		if (!empty($this->jenistransaksi)){
			if($this->jenistransaksi == "isreturoa") {
				$criteria->addCondition("isreturoa = TRUE");
			} elseif ($this->jenistransaksi == "ispenerimaanoa") {
				$criteria->addCondition("ispenerimaanoa = TRUE");
			} elseif ($this->jenistransaksi == "isstokopnameoa") {
				$criteria->addCondition("isstokopnameoa = TRUE");
			} elseif ($this->jenistransaksi == "isreturpembelian") {
				$criteria->addCondition("isreturpembelian = TRUE");
			} elseif ($this->jenistransaksi == "ispenjualanresep") {
				$criteria->addCondition("ispenjualanresep = TRUE");
			} elseif ($this->jenistransaksi == "ispemakaianruangan") {
				$criteria->addCondition("ispemakaianruangan = TRUE");
			} elseif ($this->jenistransaksi == "ispemusnahan") {
				$criteria->addCondition("ispemusnahan = TRUE");
			} elseif ($this->jenistransaksi == "isbahanproduksi") {
				$criteria->addCondition("isbahanproduksi = TRUE");
			} elseif ($this->jenistransaksi == "ishasilproduksi") {
				$criteria->addCondition("ishasilproduksi = TRUE");
			} elseif ($this->jenistransaksi == "isstokopnameoaberkurang") {
				$criteria->addCondition("isstokopnameoaberkurang = TRUE");
			} elseif ($this->jenistransaksi == "isstokberkurangoa") {
				$criteria->addCondition("isstokberkurangoa = TRUE");
			} elseif ($this->jenistransaksi == "ismutasioa") {
				$criteria->addCondition("ismutasioa = TRUE");
			} elseif ($this->jenistransaksi == "isstokopnameoabertambah") {
				$criteria->addCondition("isstokopnameoabertambah = TRUE");
			}
		}

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

        /**
         * Untuk mencari rekening obat alkes
         * @return \CActiveDataProvider
         */
    public function searchRekeningObatalkes()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('jnsobatalkesrek_id',$this->jnsobatalkesrek_id);
		$criteria->compare('rekening5_id',$this->rekening5_id);
		$criteria->compare('debitkredit',$this->debitkredit,true);
		$criteria->compare('jenisobatalkes_id',$this->jenisobatalkes_id);
		$criteria->compare('isreturoa',$this->isreturoa);
		$criteria->compare('ispenerimaanoa',$this->ispenerimaanoa);
		$criteria->compare('isstokopnameoa',$this->isstokopnameoa);
		$criteria->compare('isreturpembelian',$this->isreturpembelian);
		$criteria->compare('ispenjualanresep',$this->ispenjualanresep);
		$criteria->compare('ispemakaianruangan',$this->ispemakaianruangan);
		$criteria->compare('ispemusnahan',$this->ispemusnahan);
		$criteria->compare('isbahanproduksi',$this->isbahanproduksi);
		$criteria->compare('ishasilproduksi',$this->ishasilproduksi);
		$criteria->compare('isstokopnameoaberkurang',$this->isstokopnameoaberkurang);
		$criteria->compare('isstokberkurangoa',$this->isstokberkurangoa);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('ismutasioa',$this->ismutasioa);
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

  public function searchPrint()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('jnsobatalkesrek_id',$this->jnsobatalkesrek_id);
		$criteria->compare('rekening5_id',$this->rekening5_id);
		$criteria->compare('debitkredit',$this->debitkredit,true);
		$criteria->compare('jenisobatalkes_id',$this->jenisobatalkes_id);
		$criteria->compare('isreturoa',$this->isreturoa);
		$criteria->compare('ispenerimaanoa',$this->ispenerimaanoa);
		$criteria->compare('isstokopnameoa',$this->isstokopnameoa);
		$criteria->compare('isreturpembelian',$this->isreturpembelian);
		$criteria->compare('ispenjualanresep',$this->ispenjualanresep);
		$criteria->compare('ispemakaianruangan',$this->ispemakaianruangan);
		$criteria->compare('ispemusnahan',$this->ispemusnahan);
		$criteria->compare('isbahanproduksi',$this->isbahanproduksi);
		$criteria->compare('ishasilproduksi',$this->ishasilproduksi);
		$criteria->compare('isstokopnameoaberkurang',$this->isstokopnameoaberkurang);
		$criteria->compare('isstokberkurangoa',$this->isstokberkurangoa);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('ismutasioa',$this->ismutasioa);

		if (!empty($this->jenistransaksi)){
			if($this->jenistransaksi == "isreturoa") {
				$criteria->addCondition("isreturoa = TRUE");
			} elseif ($this->jenistransaksi == "ispenerimaanoa") {
				$criteria->addCondition("ispenerimaanoa = TRUE");
			} elseif ($this->jenistransaksi == "isstokopnameoa") {
				$criteria->addCondition("isstokopnameoa = TRUE");
			} elseif ($this->jenistransaksi == "isreturpembelian") {
				$criteria->addCondition("isreturpembelian = TRUE");
			} elseif ($this->jenistransaksi == "ispenjualanresep") {
				$criteria->addCondition("ispenjualanresep = TRUE");
			} elseif ($this->jenistransaksi == "ispemakaianruangan") {
				$criteria->addCondition("ispemakaianruangan = TRUE");
			} elseif ($this->jenistransaksi == "ispemusnahan") {
				$criteria->addCondition("ispemusnahan = TRUE");
			} elseif ($this->jenistransaksi == "isbahanproduksi") {
				$criteria->addCondition("isbahanproduksi = TRUE");
			} elseif ($this->jenistransaksi == "ishasilproduksi") {
				$criteria->addCondition("ishasilproduksi = TRUE");
			} elseif ($this->jenistransaksi == "isstokopnameoaberkurang") {
				$criteria->addCondition("isstokopnameoaberkurang = TRUE");
			} elseif ($this->jenistransaksi == "isstokberkurangoa") {
				$criteria->addCondition("isstokberkurangoa = TRUE");
			} elseif ($this->jenistransaksi == "ismutasioa") {
				$criteria->addCondition("ismutasioa = TRUE");
			} elseif ($this->jenistransaksi == "isstokopnameoabertambah") {
				$criteria->addCondition("isstokopnameoabertambah = TRUE");
			}
		}

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
      'pagination'=>false
		));
	}
}
