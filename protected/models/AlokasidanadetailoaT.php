<?php

/**
 * This is the model class for table "alokasidanadetailoa_t".
 *
 * The followings are the available columns in table 'alokasidanadetailoa_t':
 * @property integer $alokasidanadetailoa_id
 * @property integer $ruangan_id
 * @property integer $alokasidana_id
 * @property integer $obatalkes_id
 * @property integer $obatalkespasien_id
 * @property double $qty_oa
 * @property double $hargasatuan
 * @property double $jmlsubsidi_asuransi
 * @property double $jmlsubsidi_rs
 * @property double $jmliurbiaya
 * @property double $jmlbayar_oa
 * @property double $jmlsisabayar_oa
 * @property double $jmlselisihbpjs
 */
class AlokasidanadetailoaT extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'alokasidanadetailoa_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ruangan_id, obatalkes_id, qty_oa, hargasatuan, jmlsubsidi_asuransi, jmlsubsidi_rs, jmliurbiaya, jmlbayar_oa, jmlsisabayar_oa', 'required'),
			array('alokasidanadetailoa_id, ruangan_id, alokasidana_id, obatalkes_id, obatalkespasien_id', 'numerical', 'integerOnly'=>true),
			array('qty_oa, hargasatuan, jmlsubsidi_asuransi, jmlsubsidi_rs, jmliurbiaya, jmlbayar_oa, jmlsisabayar_oa, jmlselisihbpjs', 'numerical'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('alokasidanadetailoa_id, ruangan_id, alokasidana_id, obatalkes_id, obatalkespasien_id, qty_oa, hargasatuan, jmlsubsidi_asuransi, jmlsubsidi_rs, jmliurbiaya, jmlbayar_oa, jmlsisabayar_oa, jmlselisihbpjs', 'safe', 'on'=>'search'),
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
			'alokasidanadetailoa_id' => 'Alokasidanadetailoa',
			'ruangan_id' => 'Ruangan',
			'alokasidana_id' => 'Alokasidana',
			'obatalkes_id' => 'Obatalkes',
			'obatalkespasien_id' => 'Obatalkespasien',
			'qty_oa' => 'Qty Oa',
			'hargasatuan' => 'Hargasatuan',
			'jmlsubsidi_asuransi' => 'Jmlsubsidi Asuransi',
			'jmlsubsidi_rs' => 'Jmlsubsidi Rs',
			'jmliurbiaya' => 'Jmliurbiaya',
			'jmlbayar_oa' => 'Jmlbayar Oa',
			'jmlsisabayar_oa' => 'Jmlsisabayar Oa',
			'jmlselisihbpjs' => 'Jmlselisihbpjs',
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

		$criteria->compare('alokasidanadetailoa_id',$this->alokasidanadetailoa_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('alokasidana_id',$this->alokasidana_id);
		$criteria->compare('obatalkes_id',$this->obatalkes_id);
		$criteria->compare('obatalkespasien_id',$this->obatalkespasien_id);
		$criteria->compare('qty_oa',$this->qty_oa);
		$criteria->compare('hargasatuan',$this->hargasatuan);
		$criteria->compare('jmlsubsidi_asuransi',$this->jmlsubsidi_asuransi);
		$criteria->compare('jmlsubsidi_rs',$this->jmlsubsidi_rs);
		$criteria->compare('jmliurbiaya',$this->jmliurbiaya);
		$criteria->compare('jmlbayar_oa',$this->jmlbayar_oa);
		$criteria->compare('jmlsisabayar_oa',$this->jmlsisabayar_oa);
		$criteria->compare('jmlselisihbpjs',$this->jmlselisihbpjs);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return AlokasidanadetailoaT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
