<?php

/**
 * This is the model class for table "pemusnahanobatalkes_t".
 *
 * The followings are the available columns in table 'pemusnahanobatalkes_t':
 * @property integer $pemusnahanobatalkes_id
 * @property string $tglpemusnahan
 * @property string $nopemusnahan
 * @property string $keterangan
 * @property integer $ruanganasal_id
 * @property integer $pegawai_id
 * @property integer $pegawaimengetahui_id
 * @property integer $pegawaimenyetujui_id
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property RuanganM $gudang
 * @property PegawaiM $pegawai
 * @property PegawaiM $pegawaimengetahui
 * @property PegawaiM $pegawaimenyetujui
 * @property LoginpemakaiK $createLoginpemakai
 * @property LoginpemakaiK $updateLoginpemakai
 * @property RuanganM $createRuangan
 * @property PemusnahanoadetailT[] $pemusnahanoadetailTs
 */
class PemusnahanobatalkesT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PemusnahanobatalkesT the static model class
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
		return 'pemusnahanobatalkes_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tglpemusnahan, nopemusnahan, ruanganasal_id, pegawai_id, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('ruanganasal_id, pegawai_id, pegawaimengetahui_id, pegawaimenyetujui_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('nopemusnahan', 'length', 'max'=>200),
			array('keterangan, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pemusnahanobatalkes_id, tglpemusnahan, nopemusnahan, keterangan, ruanganasal_id, pegawai_id, pegawaimengetahui_id, pegawaimenyetujui_id, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'ruanganasal' => array(self::BELONGS_TO, 'RuanganM', 'ruanganasal_id'),
			'pegawai' => array(self::BELONGS_TO, 'PegawaiM', 'pegawai_id'),
			'pegawaimengetahui' => array(self::BELONGS_TO, 'PegawaiM', 'pegawaimengetahui_id'),
			'pegawaimenyetujui' => array(self::BELONGS_TO, 'PegawaiM', 'pegawaimenyetujui_id'),
			'createLoginpemakai' => array(self::BELONGS_TO, 'LoginpemakaiK', 'create_loginpemakai_id'),
			'updateLoginpemakai' => array(self::BELONGS_TO, 'LoginpemakaiK', 'update_loginpemakai_id'),
			'createRuangan' => array(self::BELONGS_TO, 'RuanganM', 'create_ruangan'),
			'pemusnahanoadetailTs' => array(self::HAS_MANY, 'PemusnahanoadetailT', 'pemusnahanobatalkes_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pemusnahanobatalkes_id' => 'Pemusnahan Obat Alkes',
			'tglpemusnahan' => 'Tanggal Pemusnahan',
			'nopemusnahan' => 'No. Pemusnahan',
			'keterangan' => 'Keterangan',
			'ruanganasal_id' => 'Ruangan Asal',
			'pegawai_id' => 'Pegawai',
			'pegawaimengetahui_id' => 'Pegawai Mengetahui',
			'pegawaimenyetujui_id' => 'Pegawai Menyetujui',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
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

		$criteria->compare('pemusnahanobatalkes_id',$this->pemusnahanobatalkes_id);
		$criteria->compare('tglpemusnahan',$this->tglpemusnahan,true);
		$criteria->compare('nopemusnahan',$this->nopemusnahan,true);
		$criteria->compare('keterangan',$this->keterangan,true);
		$criteria->compare('ruanganasal_id',$this->ruanganasal_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('pegawaimengetahui_id',$this->pegawaimengetahui_id);
		$criteria->compare('pegawaimenyetujui_id',$this->pegawaimenyetujui_id);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id);
		$criteria->compare('create_ruangan',$this->create_ruangan);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}