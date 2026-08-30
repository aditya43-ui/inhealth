<?php

/**
 * This is the model class for table "tindakansudahbayardetail_t".
 *
 * The followings are the available columns in table 'tindakansudahbayardetail_t':
 * @property integer $tindakansudahbayardetail_id
 * @property integer $pendaftaran_id
 * @property integer $pembayaranpelayanan_id
 * @property integer $tindakansudahbayar_id
 * @property integer $daftartindakan_id
 * @property integer $ruangan_id
 * @property integer $qty_tindakan
 * @property double $jmlbiaya_tindakan
 * @property double $jmlsubsidi_asuransi
 * @property double $jmlsubsidi_pemerintah
 * @property double $jmlsubsidi_rs
 * @property double $jmliurbiaya
 * @property double $jmlpembebasan
 * @property double $jmlbayar_tindakan
 * @property double $jmlsisabayar_tindakan
 * @property double $jmlselisihbpjs
 * @property integer $pembebasantarif_id
 */
class TindakansudahbayardetailT extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tindakansudahbayardetail_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pendaftaran_id, pembayaranpelayanan_id, daftartindakan_id, ruangan_id, jmlbiaya_tindakan, jmlsubsidi_asuransi, jmlsubsidi_pemerintah, jmlsubsidi_rs, jmliurbiaya, jmlpembebasan, jmlbayar_tindakan, jmlsisabayar_tindakan', 'required'),
			array('pendaftaran_id, pembayaranpelayanan_id, tindakansudahbayar_id, daftartindakan_id, ruangan_id, pembebasantarif_id', 'numerical', 'integerOnly'=>true),
			array('jmlbiaya_tindakan, jmlsubsidi_asuransi, jmlsubsidi_pemerintah, jmlsubsidi_rs, jmliurbiaya, jmlpembebasan, jmlbayar_tindakan, jmlsisabayar_tindakan, jmlselisihbpjs', 'numerical'),
			array('qty_tindakan', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('tindakansudahbayardetail_id, pendaftaran_id, pembayaranpelayanan_id, tindakansudahbayar_id, daftartindakan_id, ruangan_id, qty_tindakan, jmlbiaya_tindakan, jmlsubsidi_asuransi, jmlsubsidi_pemerintah, jmlsubsidi_rs, jmliurbiaya, jmlpembebasan, jmlbayar_tindakan, jmlsisabayar_tindakan, jmlselisihbpjs, pembebasantarif_id', 'safe', 'on'=>'search'),
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
			'tindakansudahbayardetail_id' => 'Tindakansudahbayardetail',
			'pendaftaran_id' => 'Pendaftaran',
			'pembayaranpelayanan_id' => 'Pembayaranpelayanan',
			'tindakansudahbayar_id' => 'Tindakansudahbayar',
			'daftartindakan_id' => 'Daftartindakan',
			'ruangan_id' => 'Ruangan',
			'qty_tindakan' => 'Qty Tindakan',
			'jmlbiaya_tindakan' => 'Jmlbiaya Tindakan',
			'jmlsubsidi_asuransi' => 'Jmlsubsidi Asuransi',
			'jmlsubsidi_pemerintah' => 'Jmlsubsidi Pemerintah',
			'jmlsubsidi_rs' => 'Jmlsubsidi Rs',
			'jmliurbiaya' => 'Jmliurbiaya',
			'jmlpembebasan' => 'Jmlpembebasan',
			'jmlbayar_tindakan' => 'Jmlbayar Tindakan',
			'jmlsisabayar_tindakan' => 'Jmlsisabayar Tindakan',
			'jmlselisihbpjs' => 'Jmlselisihbpjs',
			'pembebasantarif_id' => 'Pembebasantarif',
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

		$criteria->compare('tindakansudahbayardetail_id',$this->tindakansudahbayardetail_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('pembayaranpelayanan_id',$this->pembayaranpelayanan_id);
		$criteria->compare('tindakansudahbayar_id',$this->tindakansudahbayar_id);
		$criteria->compare('daftartindakan_id',$this->daftartindakan_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('qty_tindakan',$this->qty_tindakan);
		$criteria->compare('jmlbiaya_tindakan',$this->jmlbiaya_tindakan);
		$criteria->compare('jmlsubsidi_asuransi',$this->jmlsubsidi_asuransi);
		$criteria->compare('jmlsubsidi_pemerintah',$this->jmlsubsidi_pemerintah);
		$criteria->compare('jmlsubsidi_rs',$this->jmlsubsidi_rs);
		$criteria->compare('jmliurbiaya',$this->jmliurbiaya);
		$criteria->compare('jmlpembebasan',$this->jmlpembebasan);
		$criteria->compare('jmlbayar_tindakan',$this->jmlbayar_tindakan);
		$criteria->compare('jmlsisabayar_tindakan',$this->jmlsisabayar_tindakan);
		$criteria->compare('jmlselisihbpjs',$this->jmlselisihbpjs);
		$criteria->compare('pembebasantarif_id',$this->pembebasantarif_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return TindakansudahbayardetailT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
