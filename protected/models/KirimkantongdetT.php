<?php

/**
 * This is the model class for table "kirimkantongdet_t".
 * @author Aida Rahmawati <aidarahmawati@.com>
 * @package application.models
 * @category model
 * The followings are the available columns in table 'kirimkantongdet_t':
 * @property integer $kirimkantongdet_id
 * @property integer $kirimkantongdarah_id
 * @property string $nomorbarcode
 * @property integer $jeniskantongdarah_id
 * @property integer $komponendarah_id
 * @property integer $jmlkirim
 * @property integer $terimakantongdarah_id
 *
 * The followings are the available model relations:
 * @property TerimakantongdarahT $terimakantongdarah
 * @property KirimkantongdarahT $kirimkantongdarah
 */
class KirimkantongdetT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return KirimkantongdetT the static model class
	 */
        public $no_urut;
        public $coolboxdarah_nama, $nomorbarcode_sample_imltd;
        public $count_sampel, $no_identitas, $nomorbarcode_utama, $nomorbarcode_sample, $gol_darah, $rhesus, $nama_jenis, $nomor;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'kirimkantongdet_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('kirimkantongdarah_id, nomorbarcode, jeniskantongdarah_id, komponendarah_id, jmlkirim', 'required'),
			array('kirimkantongdarah_id, jeniskantongdarah_id, komponendarah_id, jmlkirim, terimakantongdarah_id', 'numerical', 'integerOnly'=>true),
			array('nomorbarcode', 'length', 'max'=>100),
                        array('no_penggunaan_coolbox, kantongdarah_id,', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('kantongdarah_id,kirimkantongdet_id, kirimkantongdarah_id, nomorbarcode, jeniskantongdarah_id, komponendarah_id, jmlkirim, terimakantongdarah_id', 'safe', 'on'=>'search'),
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
			'terimakantongdarah' => array(self::BELONGS_TO, 'TerimakantongdarahT', 'terimakantongdarah_id'),
			'kirimkantongdarah' => array(self::BELONGS_TO, 'KirimkantongdarahT', 'kirimkantongdarah_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'kirimkantongdet_id' => 'Kirimkantongdet',
			'kirimkantongdarah_id' => 'Kirimkantongdarah',
			'nomorbarcode' => 'Nomorbarcode',
			'jeniskantongdarah_id' => 'Jeniskantongdarah',
			'komponendarah_id' => 'Komponendarah',
			'jmlkirim' => 'Jmlkirim',
			'terimakantongdarah_id' => 'Terimakantongdarah',
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

		$criteria->compare('kirimkantongdet_id',$this->kirimkantongdet_id);
		$criteria->compare('kirimkantongdarah_id',$this->kirimkantongdarah_id);
		$criteria->compare('nomorbarcode',$this->nomorbarcode,true);
		$criteria->compare('jeniskantongdarah_id',$this->jeniskantongdarah_id);
		$criteria->compare('komponendarah_id',$this->komponendarah_id);
		$criteria->compare('jmlkirim',$this->jmlkirim);
		$criteria->compare('terimakantongdarah_id',$this->terimakantongdarah_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
}