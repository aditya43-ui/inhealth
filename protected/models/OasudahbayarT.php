<?php

/**
 * This is the model class for table "oasudahbayar_t".
 *
 * The followings are the available columns in table 'oasudahbayar_t':
 * @property integer $oasudahbayar_id
 * @property integer $obatalkes_id
 * @property integer $ruangan_id
 * @property integer $pembayaranpelayanan_id
 * @property integer $obatalkespasien_id
 * @property double $qty_oa
 * @property double $hargasatuan
 * @property double $jmlsubsidi_asuransi
 * @property double $jmlsubsidi_pemerintah
 * @property double $jmlsubsidi_rs
 * @property double $jmliurbiaya
 * @property double $jmlbayar_oa
 * @property double $jmlsisabayar_oa
 */
class OasudahbayarT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return OasudahbayarT the static model class
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
		return 'oasudahbayar_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('obatalkes_id, ruangan_id, pembayaranpelayanan_id, qty_oa, hargasatuan, jmlsubsidi_asuransi, jmlsubsidi_pemerintah, jmlsubsidi_rs, jmliurbiaya, jmlbayar_oa, jmlsisabayar_oa', 'required'),
			array('obatalkes_id, ruangan_id, pembayaranpelayanan_id, obatalkespasien_id', 'numerical', 'integerOnly'=>true),
			array('qty_oa, hargasatuan, jmlsubsidi_asuransi, jmlsubsidi_pemerintah, jmlsubsidi_rs, jmliurbiaya, jmlbayar_oa, jmlsisabayar_oa, jmlselisihbpjs', 'numerical'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('oasudahbayar_id, obatalkes_id, ruangan_id, pembayaranpelayanan_id, obatalkespasien_id, qty_oa, hargasatuan, jmlsubsidi_asuransi, jmlsubsidi_pemerintah, jmlsubsidi_rs, jmliurbiaya, jmlbayar_oa, jmlsisabayar_oa, jmlselisihbpjs', 'safe', 'on'=>'search'),
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
                    'pembayaranpelayanan'=>array(self::BELONGS_TO, 'PembayaranpelayananT', 'pembayaranpelayanan_id'), //handling relasi dengan pembayaran pelayanan t
                    'obatalkes'=>array(self::BELONGS_TO, 'ObatalkesM', 'obatalkes_id'),
                    'obatalkespasien'=>array(self::BELONGS_TO, 'ObatalkespasienT', 'obatalkespasien_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'oasudahbayar_id' => 'Oasudahbayar',
			'obatalkes_id' => 'Obatalkes',
			'ruangan_id' => 'Ruangan',
			'pembayaranpelayanan_id' => 'Pembayaranpelayanan',
			'obatalkespasien_id' => 'Obatalkespasien',
			'qty_oa' => 'Jumlah Oa',
			'hargasatuan' => 'Hargasatuan',
			'jmlsubsidi_asuransi' => 'Jmlsubsidi Asuransi',
			'jmlsubsidi_pemerintah' => 'Jmlsubsidi Pemerintah',
			'jmlsubsidi_rs' => 'Jmlsubsidi Rs',
			'jmliurbiaya' => 'Jmliurbiaya',
			'jmlbayar_oa' => 'Jmlbayar Oa',
			'jmlsisabayar_oa' => 'Jmlsisabayar Oa',
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

		$criteria->compare('oasudahbayar_id',$this->oasudahbayar_id);
		$criteria->compare('obatalkes_id',$this->obatalkes_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('pembayaranpelayanan_id',$this->pembayaranpelayanan_id);
		$criteria->compare('obatalkespasien_id',$this->obatalkespasien_id);
		$criteria->compare('qty_oa',$this->qty_oa);
		$criteria->compare('hargasatuan',$this->hargasatuan);
		$criteria->compare('jmlsubsidi_asuransi',$this->jmlsubsidi_asuransi);
		$criteria->compare('jmlsubsidi_pemerintah',$this->jmlsubsidi_pemerintah);
		$criteria->compare('jmlsubsidi_rs',$this->jmlsubsidi_rs);
		$criteria->compare('jmliurbiaya',$this->jmliurbiaya);
		$criteria->compare('jmlbayar_oa',$this->jmlbayar_oa);
		$criteria->compare('jmlsisabayar_oa',$this->jmlsisabayar_oa);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}


        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('oasudahbayar_id',$this->oasudahbayar_id);
		$criteria->compare('obatalkes_id',$this->obatalkes_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('pembayaranpelayanan_id',$this->pembayaranpelayanan_id);
		$criteria->compare('obatalkespasien_id',$this->obatalkespasien_id);
		$criteria->compare('qty_oa',$this->qty_oa);
		$criteria->compare('hargasatuan',$this->hargasatuan);
		$criteria->compare('jmlsubsidi_asuransi',$this->jmlsubsidi_asuransi);
		$criteria->compare('jmlsubsidi_pemerintah',$this->jmlsubsidi_pemerintah);
		$criteria->compare('jmlsubsidi_rs',$this->jmlsubsidi_rs);
		$criteria->compare('jmliurbiaya',$this->jmliurbiaya);
		$criteria->compare('jmlbayar_oa',$this->jmlbayar_oa);
		$criteria->compare('jmlsisabayar_oa',$this->jmlsisabayar_oa);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit
                $criteria->limit=-1;

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
}
