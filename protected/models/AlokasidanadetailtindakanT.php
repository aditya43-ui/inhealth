<?php

/**
 * This is the model class for table "alokasidanadetailtindakan_t".
 *
 * The followings are the available columns in table 'alokasidanadetailtindakan_t':
 * @property integer $alokasidanadetailtindakan_id
 * @property integer $tindakanpelayanan_id
 * @property integer $daftartindakan_id
 * @property integer $ruangan_id
 * @property integer $qty_tindakan
 * @property double $jmlbiaya_tindakan
 * @property string $diskon
 * @property double $pembebasan
 * @property double $jmlsubsidi_asuransi
 * @property double $jmlsubsidi_rs
 * @property double $jmliurbiaya
 * @property double $jmlbayar_tindakan
 * @property integer $alokasidana_id
 * @property double $jmlsisabayar_tindakan
 * @property double $jmlselisih_bpjs
 * @property integer $pembebasantarif_id
 */
class AlokasidanadetailtindakanT extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'alokasidanadetailtindakan_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('daftartindakan_id, ruangan_id, qty_tindakan, jmlbiaya_tindakan, jmlsubsidi_asuransi, jmlsubsidi_rs, jmliurbiaya, jmlbayar_tindakan, jmlsisabayar_tindakan', 'required'),
			array('alokasidanadetailtindakan_id, tindakanpelayanan_id, daftartindakan_id, ruangan_id, alokasidana_id, pembebasantarif_id', 'numerical', 'integerOnly'=>true),
			array('jmlbiaya_tindakan, pembebasan, jmlsubsidi_asuransi, jmlsubsidi_rs, jmliurbiaya, jmlbayar_tindakan, jmlsisabayar_tindakan, jmlselisih_bpjs', 'numerical'),
			array('diskon', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('alokasidanadetailtindakan_id, tindakanpelayanan_id, daftartindakan_id, ruangan_id, qty_tindakan, jmlbiaya_tindakan, diskon, pembebasan, jmlsubsidi_asuransi, jmlsubsidi_rs, jmliurbiaya, jmlbayar_tindakan, alokasidana_id, jmlsisabayar_tindakan, jmlselisih_bpjs, pembebasantarif_id', 'safe', 'on'=>'search'),
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
			'daftartindakan' => array(self::BELONGS_TO, 'DaftartindakanM', 'daftartindakan_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'alokasidanadetailtindakan_id' => 'Alokasidanadetailtindakan',
			'tindakanpelayanan_id' => 'Tindakanpelayanan',
			'daftartindakan_id' => 'Daftartindakan',
			'ruangan_id' => 'Ruangan',
			'qty_tindakan' => 'Qty Tindakan',
			'jmlbiaya_tindakan' => 'Jmlbiaya Tindakan',
			'diskon' => 'Keringanan',
			'pembebasan' => 'Pembebasan',
			'jmlsubsidi_asuransi' => 'Jmlsubsidi Asuransi',
			'jmlsubsidi_rs' => 'Jmlsubsidi Rs',
			'jmliurbiaya' => 'Jmliurbiaya',
			'jmlbayar_tindakan' => 'Jmlbayar Tindakan',
			'alokasidana_id' => 'Alokasidana',
			'jmlsisabayar_tindakan' => 'Jmlsisabayar Tindakan',
			'jmlselisih_bpjs' => 'Jmlselisih Bpjs',
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

		$criteria->compare('alokasidanadetailtindakan_id',$this->alokasidanadetailtindakan_id);
		$criteria->compare('tindakanpelayanan_id',$this->tindakanpelayanan_id);
		$criteria->compare('daftartindakan_id',$this->daftartindakan_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('qty_tindakan',$this->qty_tindakan);
		$criteria->compare('jmlbiaya_tindakan',$this->jmlbiaya_tindakan);
		$criteria->compare('diskon',$this->diskon,true);
		$criteria->compare('pembebasan',$this->pembebasan);
		$criteria->compare('jmlsubsidi_asuransi',$this->jmlsubsidi_asuransi);
		$criteria->compare('jmlsubsidi_rs',$this->jmlsubsidi_rs);
		$criteria->compare('jmliurbiaya',$this->jmliurbiaya);
		$criteria->compare('jmlbayar_tindakan',$this->jmlbayar_tindakan);
		$criteria->compare('alokasidana_id',$this->alokasidana_id);
		$criteria->compare('jmlsisabayar_tindakan',$this->jmlsisabayar_tindakan);
		$criteria->compare('jmlselisih_bpjs',$this->jmlselisih_bpjs);
		$criteria->compare('pembebasantarif_id',$this->pembebasantarif_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return AlokasidanadetailtindakanT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
