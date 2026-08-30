<?php

/**
 * This is the model class for table "inaktifrekammedisdet_t".
 *
 * The followings are the available columns in table 'inaktifrekammedisdet_t':
 * @property integer $inaktifrekammedisdet_id
 * @property integer $inaktifrekammedis_id
 * @property integer $pasien_id
 * @property string $tglkunjunganterakhir
 * @property integer $instalasiterakhir_id
 * @property integer $ruanganterakhir_id
 * @property string $masafungsirm
 * @property boolean $is_pemusnahan
 * @property integer $dokrekammedis_id
 *
 * The followings are the available model relations:
 * @property DokrekammedisM $dokrekammedis
 * 
 * @package application.models
 * @author          Yusuf Putra Anugrah<yusufputra@.com>
 * @version         2.0.0  
 */
class InaktifrekammedisdetT extends CActiveRecord
{
        public $pilih;
    
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InaktifrekammedisdetT the static model class
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
		return 'inaktifrekammedisdet_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('inaktifrekammedis_id, pasien_id, dokrekammedis_id', 'required'),
			array('inaktifrekammedis_id, pasien_id, instalasiterakhir_id, ruanganterakhir_id, dokrekammedis_id', 'numerical', 'integerOnly'=>true),
			array('masafungsirm', 'length', 'max'=>30),
			array('pendaftaran_id, tglkunjunganterakhir, is_pemusnahan', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('inaktifrekammedisdet_id, inaktifrekammedis_id, pasien_id, tglkunjunganterakhir, instalasiterakhir_id, ruanganterakhir_id, masafungsirm, is_pemusnahan, dokrekammedis_id', 'safe', 'on'=>'search'),
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
			'dokrekammedis' => array(self::BELONGS_TO, 'DokrekammedisM', 'dokrekammedis_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'inaktifrekammedisdet_id' => 'Inaktifrekammedisdet',
			'inaktifrekammedis_id' => 'Inaktifrekammedis',
			'pasien_id' => 'Pasien',
			'tglkunjunganterakhir' => 'Tglkunjunganterakhir',
			'instalasiterakhir_id' => 'Instalasiterakhir',
			'ruanganterakhir_id' => 'Ruanganterakhir',
			'masafungsirm' => 'Masafungsirm',
			'is_pemusnahan' => 'Is Pemusnahan',
			'dokrekammedis_id' => 'Dokrekammedis',
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

		$criteria->compare('inaktifrekammedisdet_id',$this->inaktifrekammedisdet_id);
		$criteria->compare('inaktifrekammedis_id',$this->inaktifrekammedis_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('tglkunjunganterakhir',$this->tglkunjunganterakhir,true);
		$criteria->compare('instalasiterakhir_id',$this->instalasiterakhir_id);
		$criteria->compare('ruanganterakhir_id',$this->ruanganterakhir_id);
		$criteria->compare('masafungsirm',$this->masafungsirm,true);
		$criteria->compare('is_pemusnahan',$this->is_pemusnahan);
		$criteria->compare('dokrekammedis_id',$this->dokrekammedis_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}