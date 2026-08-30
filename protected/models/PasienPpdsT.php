<?php

/**
 * This is the model class for table "pasien_ppds_t".
 *
 * The followings are the available columns in table 'pasien_ppds_t':
 * @property integer $pasien_ppds_id
 * @property integer $pendaftaran_id
 * @property integer $pasienadmisi_id
 * @property integer $pasienmasukpenunjang_id
 * @property integer $urutan_ppds
 * @property integer $ppds_id
 */


 class PasienPpdsT extends CActiveRecord
{

	public $urutan_ppds,$pasienadmisi_id, $pendaftaran_id, $ppds_nama;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'pasien_ppds_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pendaftaran_id, urutan_ppds, ppds_id', 'required'),
			array('pasien_ppds_id, pendaftaran_id, pasienadmisi_id, pasienmasukpenunjang_id, urutan_ppds, ppds_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('pasien_ppds_id, pendaftaran_id, pasienadmisi_id, pasienmasukpenunjang_id, urutan_ppds, ppds_id', 'safe', 'on'=>'search'),
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
			'ppds' => array(self::BELONGS_TO, 'PpdsM', 'ppds_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pasien_ppds_id' => 'Pasien Ppds',
			'pendaftaran_id' => 'Nomor Pendaftaran',
			'pasienadmisi_id' => 'Nama Pasien',
			'pasienmasukpenunjang_id' => 'Pasienmasuk Penunjang',
			'urutan_ppds' => 'Urutan Ppds',
			'ppds_id' => 'Ppds',
			'ppds_nama' => 'Nama PPDS',
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

		$criteria->compare('t.pasien_ppds_id',$this->pasien_ppds_id);
		$criteria->compare('t.pasien_ppds_id',$this->pasien_ppds_id);
		$criteria->compare('t.pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('t.pasienadmisi_id',$this->pasienadmisi_id);
		$criteria->compare('t.pasienmasukpenunjang_id',$this->pasienmasukpenunjang_id);
		$criteria->compare('t.urutan_ppds',$this->urutan_ppds);
		$criteria->compare('t.ppds_id',$this->ppds_id);

		$criteria->select = "p.ppds_nama as ppds_nama, t.*";
		$criteria->join = " JOIN ppds_m p on p.ppds_id = t.ppds_id ";

		$criteria->compare('LOWER(p.ppds_nama)',strtolower($this->ppds_nama), true);


		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function searchPPDS()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->select = " t.ppds_id, p.ppds_nama ";
		$criteria->group = $criteria->select;

		$criteria->compare('t.pasien_ppds_id',$this->pasien_ppds_id);
		$criteria->compare('t.pasien_ppds_id',$this->pasien_ppds_id);
		$criteria->compare('t.pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('t.pasienadmisi_id',$this->pasienadmisi_id);
		$criteria->compare('t.pasienmasukpenunjang_id',$this->pasienmasukpenunjang_id);
		$criteria->compare('t.urutan_ppds',$this->urutan_ppds);
		$criteria->compare('t.ppds_id',$this->ppds_id);

		$criteria->join = " JOIN ppds_m p on p.ppds_id = t.ppds_id ";

		$criteria->compare('LOWER(p.ppds_nama)',strtolower($this->ppds_nama), true);


		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return PasienPpdsT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
