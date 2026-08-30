<?php

/**
 * This is the model class for table "penyerahandarah_t".
 *
 * The followings are the available columns in table 'penyerahandarah_t':
 * @property integer $penyerahandarah_id
 * @property integer $pendaftaran_id
 * @property integer $permintaandarah_id
 * @property integer $penyiapandarah_id
 * @property string $tglpenyerahan
 * @property integer $peg_ygmenyerahkan_id
 * @property integer $peg_vetifikator_id
 * @property string $tglverifikasi
 * @property integer $peg_ygmenerima_id
 * @property integer $peg_transporter_id
 * @property string $ket_penyerahan
 * @property string $create_time
 * @property string $udpate_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 */
class PenyerahandarahT extends CActiveRecord
{
    public $peg_ygmenyerahkan_nama;
    public $peg_vetifikator_nama;
    public $peg_transporter_nama;
    public $peg_transporter_id;
    public $penyerahan_id;
    
    public $ceklis;
        
    public $no_permintaandarah;    
    
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PenyerahandarahT the static model class
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
		return 'penyerahandarah_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pendaftaran_id, permintaandarah_id, penyiapandarah_id, tglpenyerahan, peg_ygmenyerahkan_id, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('pendaftaran_id, permintaandarah_id, penyiapandarah_id, peg_ygmenyerahkan_id, peg_vetifikator_id, peg_ygmenerima_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('penyerahandarah_ke, peg_transporter, tglverifikasi, ket_penyerahan, udpate_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('penyerahandarah_id, pendaftaran_id, permintaandarah_id, penyiapandarah_id, tglpenyerahan, peg_ygmenyerahkan_id, peg_vetifikator_id, tglverifikasi, peg_ygmenerima_id, ket_penyerahan, create_time, udpate_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'penyerahandarah_id' => 'Penyerahandarah',
			'pendaftaran_id' => 'Pendaftaran',
			'permintaandarah_id' => 'Permintaandarah',
			'penyiapandarah_id' => 'Penyiapandarah',
			'tglpenyerahan' => 'Tglpenyerahan',
			'peg_ygmenyerahkan_id' => 'Peg Ygmenyerahkan',
			'peg_vetifikator_id' => 'Peg Vetifikator',
			'tglverifikasi' => 'Tglverifikasi',
			'peg_ygmenerima_id' => 'Peg Ygmenerima',
			'peg_transporter' => 'Peg Transporter',
			'ket_penyerahan' => 'Ket Penyerahan',
			'create_time' => 'Waktu Create',
			'udpate_time' => 'Udpate Time',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
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

		$criteria->compare('penyerahandarah_id',$this->penyerahandarah_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('permintaandarah_id',$this->permintaandarah_id);
		$criteria->compare('penyiapandarah_id',$this->penyiapandarah_id);
		$criteria->compare('tglpenyerahan',$this->tglpenyerahan,true);
		$criteria->compare('peg_ygmenyerahkan_id',$this->peg_ygmenyerahkan_id);
		$criteria->compare('peg_vetifikator_id',$this->peg_vetifikator_id);
		$criteria->compare('tglverifikasi',$this->tglverifikasi,true);
		$criteria->compare('peg_ygmenerima_id',$this->peg_ygmenerima_id);		
		$criteria->compare('ket_penyerahan',$this->ket_penyerahan,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('udpate_time',$this->udpate_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id);
		$criteria->compare('create_ruangan',$this->create_ruangan);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}