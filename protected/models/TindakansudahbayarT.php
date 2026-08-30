<?php

/**
 * This is the model class for table "tindakansudahbayar_t".
 *
 * The followings are the available columns in table 'tindakansudahbayar_t':
 * @property integer $tindakansudahbayar_id
 * @property integer $ruangan_id
 * @property integer $tindakanpelayanan_id
 * @property integer $pembayaranpelayanan_id
 * @property integer $daftartindakan_id
 * @property integer $qty_tindakan
 * @property double $jmlbiaya_tindakan
 * @property double $jmlsubsidi_asuransi
 * @property double $jmlsubsidi_pemerintah
 * @property double $jmlsubsidi_rs
 * @property double $jmliurbiaya
 * @property double $jmlpembebasan
 * @property double $jmlbayar_tindakan
 * @property double $jmlsisabayar_tindakan
 */
class TindakansudahbayarT extends CActiveRecord
{
	public $harga;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TindakansudahbayarT the static model class
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
		return 'tindakansudahbayar_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ruangan_id, pembayaranpelayanan_id, daftartindakan_id, jmlbiaya_tindakan, jmlsubsidi_asuransi, jmlsubsidi_pemerintah, jmlsubsidi_rs, jmliurbiaya, jmlpembebasan, jmlbayar_tindakan, jmlsisabayar_tindakan', 'required'),
			array('ruangan_id, tindakanpelayanan_id, pembayaranpelayanan_id, daftartindakan_id', 'numerical', 'integerOnly'=>true),
			array('jmlbiaya_tindakan, jmlsubsidi_asuransi, jmlsubsidi_pemerintah, jmlsubsidi_rs, jmliurbiaya, jmlpembebasan, jmlbayar_tindakan, jmlsisabayar_tindakan, jmlselisihbpjs', 'numerical'),
			array('qty_tindakan', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('tindakansudahbayar_id, ruangan_id, tindakanpelayanan_id, pembayaranpelayanan_id, daftartindakan_id, qty_tindakan, jmlbiaya_tindakan, jmlsubsidi_asuransi, jmlsubsidi_pemerintah, jmlsubsidi_rs, jmliurbiaya, jmlpembebasan, jmlbayar_tindakan, jmlsisabayar_tindakan, jmlselisihbpjs', 'safe', 'on'=>'search'),
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
                    'daftartindakan'=>array(self::BELONGS_TO, 'DaftartindakanM','daftartindakan_id'),
                    'tindakanpelayanan'=>array(self::BELONGS_TO, 'TindakanpelayananT', 'tindakanpelayanan_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'tindakansudahbayar_id' => 'Tindakansudahbayar',
			'ruangan_id' => 'Ruangan',
			'tindakanpelayanan_id' => 'Tindakanpelayanan',
			'pembayaranpelayanan_id' => 'Pembayaranpelayanan',
			'daftartindakan_id' => 'Daftartindakan',
			'qty_tindakan' => 'Jumlah Tindakan',
			'jmlbiaya_tindakan' => 'Jmlbiaya Tindakan',
			'jmlsubsidi_asuransi' => 'Jmlsubsidi Asuransi',
			'jmlsubsidi_pemerintah' => 'Jmlsubsidi Pemerintah',
			'jmlsubsidi_rs' => 'Jmlsubsidi Rs',
			'jmliurbiaya' => 'Jmliurbiaya',
			'jmlpembebasan' => 'Jmlpembebasan',
			'jmlbayar_tindakan' => 'Jmlbayar Tindakan',
			'jmlsisabayar_tindakan' => 'Jmlsisabayar Tindakan',
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

		$criteria->compare('tindakansudahbayar_id',$this->tindakansudahbayar_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('tindakanpelayanan_id',$this->tindakanpelayanan_id);
		$criteria->compare('pembayaranpelayanan_id',$this->pembayaranpelayanan_id);
		$criteria->compare('daftartindakan_id',$this->daftartindakan_id);
		$criteria->compare('qty_tindakan',$this->qty_tindakan);
		$criteria->compare('jmlbiaya_tindakan',$this->jmlbiaya_tindakan);
		$criteria->compare('jmlsubsidi_asuransi',$this->jmlsubsidi_asuransi);
		$criteria->compare('jmlsubsidi_pemerintah',$this->jmlsubsidi_pemerintah);
		$criteria->compare('jmlsubsidi_rs',$this->jmlsubsidi_rs);
		$criteria->compare('jmliurbiaya',$this->jmliurbiaya);
		$criteria->compare('jmlpembebasan',$this->jmlpembebasan);
		$criteria->compare('jmlbayar_tindakan',$this->jmlbayar_tindakan);
		$criteria->compare('jmlsisabayar_tindakan',$this->jmlsisabayar_tindakan);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}


        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('tindakansudahbayar_id',$this->tindakansudahbayar_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('tindakanpelayanan_id',$this->tindakanpelayanan_id);
		$criteria->compare('pembayaranpelayanan_id',$this->pembayaranpelayanan_id);
		$criteria->compare('daftartindakan_id',$this->daftartindakan_id);
		$criteria->compare('qty_tindakan',$this->qty_tindakan);
		$criteria->compare('jmlbiaya_tindakan',$this->jmlbiaya_tindakan);
		$criteria->compare('jmlsubsidi_asuransi',$this->jmlsubsidi_asuransi);
		$criteria->compare('jmlsubsidi_pemerintah',$this->jmlsubsidi_pemerintah);
		$criteria->compare('jmlsubsidi_rs',$this->jmlsubsidi_rs);
		$criteria->compare('jmliurbiaya',$this->jmliurbiaya);
		$criteria->compare('jmlpembebasan',$this->jmlpembebasan);
		$criteria->compare('jmlbayar_tindakan',$this->jmlbayar_tindakan);
		$criteria->compare('jmlsisabayar_tindakan',$this->jmlsisabayar_tindakan);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit
                $criteria->limit=-1;

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
}
