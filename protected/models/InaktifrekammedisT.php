<?php

/**
 * This is the model class for table "inaktifrekammedis_t".
 *
 * The followings are the available columns in table 'inaktifrekammedis_t':
 * @property integer $inaktifrekammedis_id
 * @property string $tglinaktifrekammedis
 * @property integer $ruangan_id
 * @property integer $pegawai_pelaksana_id
 * @property integer $pegawai_penanggungjawab_id
 * @property string $keterangan
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 * @property string $noretensiinaktif
 * 
 * @package application.models 
 * @author M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     2.0.0
 * @link    <http://172.9.1.15/simpp/docs/>
 * @link    <http://piindonesia.co.id> 
 */
class InaktifrekammedisT extends CActiveRecord
{
        public $pegawai_pelaksana_nama;
        public $pegawai_penanggungjawab_nama;
    
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InaktifrekammedisT the static model class
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
		return 'inaktifrekammedis_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tglinaktifrekammedis, ruangan_id, pegawai_pelaksana_id, pegawai_penanggungjawab_id, create_time, create_loginpemakai_id, create_ruangan, noretensiinaktif', 'required'),
			array('ruangan_id, pegawai_pelaksana_id, pegawai_penanggungjawab_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('noretensiinaktif', 'length', 'max'=>20),
			array('keterangan, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('inaktifrekammedis_id, tglinaktifrekammedis, ruangan_id, pegawai_pelaksana_id, pegawai_penanggungjawab_id, keterangan, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, noretensiinaktif', 'safe', 'on'=>'search'),
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
                    'pegpelaksana' => array(self::BELONGS_TO,'PegawaiM','pegawai_pelaksana_id'),
                    'pegtaggungjawab' => array(self::BELONGS_TO,'PegawaiM','pegawai_penanggungjawab_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'inaktifrekammedis_id' => 'Inaktifrekammedis',
			'tglinaktifrekammedis' => 'Tglinaktifrekammedis',
			'ruangan_id' => 'Ruangan',
			'pegawai_pelaksana_id' => 'Pegawai Pelaksana',
			'pegawai_penanggungjawab_id' => 'Pegawai Penanggungjawab',
			'keterangan' => 'Keterangan',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
			'noretensiinaktif' => 'Noretensiinaktif',
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

		$criteria->compare('inaktifrekammedis_id',$this->inaktifrekammedis_id);
		$criteria->compare('tglinaktifrekammedis',$this->tglinaktifrekammedis,true);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('pegawai_pelaksana_id',$this->pegawai_pelaksana_id);
		$criteria->compare('pegawai_penanggungjawab_id',$this->pegawai_penanggungjawab_id);
		$criteria->compare('keterangan',$this->keterangan,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id);
		$criteria->compare('create_ruangan',$this->create_ruangan);
		$criteria->compare('noretensiinaktif',$this->noretensiinaktif,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}