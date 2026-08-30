<?php

/**
 * This is the model class for table "renkebbahanmakanan_t".
 *
 * The followings are the available columns in table 'renkebbahanmakanan_t':
 * @property integer $renkebbahanmakanan_id
 * @property integer $ruangan_id
 * @property integer $pegawai_id
 * @property string $renkebbahanmakanan_tgl
 * @property string $renkebbahanmakanan_no
 * @property integer $pegmengetahui_id
 * @property integer $pegmenyetujui_id
 * @property integer $ro_bahanmakanan_bulan
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemekai_id
 * @property integer $update_loginpemekai_id
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property RenkebbahanmakanandetT[] $renkebbahanmakanandetTs
 */
class RenkebbahanmakananT extends CActiveRecord
{
    public $pegmengetahui_nama;
    public $pegmenyetujui_nama;
    public $leadtime_lt, $sumberdana_id;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return RenkebbahanmakananT the static model class
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
		return 'renkebbahanmakanan_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ruangan_id, pegawai_id, renkebbahanmakanan_tgl, renkebbahanmakanan_no, ro_bahanmakanan_bulan, create_time, create_loginpemekai_id, create_ruangan', 'required'),
			array('ruangan_id, pegawai_id, pegmengetahui_id, pegmenyetujui_id, ro_bahanmakanan_bulan, create_loginpemekai_id, update_loginpemekai_id, create_ruangan, sumberdana_id', 'numerical', 'integerOnly'=>true),
			array('renkebbahanmakanan_no', 'length', 'max'=>50),
			array('update_time, renkebbahanmakanan_tgl, create_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('renkebbahanmakanan_id, ruangan_id, pegawai_id, renkebbahanmakanan_tgl, renkebbahanmakanan_no, pegmengetahui_id, pegmenyetujui_id, ro_bahanmakanan_bulan, create_time, update_time, create_loginpemekai_id, update_loginpemekai_id, create_ruangan, sumberdana_id', 'safe', 'on'=>'search'),
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
			'renkebbahanmakanandetTs' => array(self::HAS_MANY, 'RenkebbahanmakanandetT', 'renkebbahanmakanan_id'),
            'pegawaimengetahui' => array(self::BELONGS_TO, 'PegawaiM', 'pegmengetahui_id'),
            'pegawaimenyetujui' => array(self::BELONGS_TO, 'PegawaiM', 'pegmenyetujui_id'),
            'pegawai' => array(self::BELONGS_TO, 'PegawaiM', 'pegawai_id'),
                    'sumberdana' => array(self::BELONGS_TO, 'SumberdanaM', 'sumberdana_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'renkebbahanmakanan_id' => 'Renkebbahanmakanan',
			'ruangan_id' => 'Ruangan',
			'pegawai_id' => 'Pegawai',
			'renkebbahanmakanan_tgl' => 'Tanggal Rencana',
			'renkebbahanmakanan_no' => 'No Rencana',
			'pegmengetahui_id' => 'Pegawai Gizi',
			'pegmenyetujui_id' => 'Kepala Instalasi Gizi',
			'ro_bahanmakanan_bulan' => 'Ro Bahanmakanan Bulan',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemekai_id' => 'Create Loginpemekai',
			'update_loginpemekai_id' => 'Update Loginpemekai',
			'create_ruangan' => 'Create Ruangan',
                        'sumberdana_id'=>'Sumber Dana'
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

		$criteria->compare('renkebbahanmakanan_id',$this->renkebbahanmakanan_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('renkebbahanmakanan_tgl',$this->renkebbahanmakanan_tgl,true);
		$criteria->compare('renkebbahanmakanan_no',$this->renkebbahanmakanan_no,true);
		$criteria->compare('pegmengetahui_id',$this->pegmengetahui_id);
		$criteria->compare('pegmenyetujui_id',$this->pegmenyetujui_id);
		$criteria->compare('ro_bahanmakanan_bulan',$this->ro_bahanmakanan_bulan);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemekai_id',$this->create_loginpemekai_id);
		$criteria->compare('update_loginpemekai_id',$this->update_loginpemekai_id);
		$criteria->compare('create_ruangan',$this->create_ruangan);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}