<?php

/**
 * This is the model class for table "luluskomponendarah_t".
 * @author Aida Rahmawati <aidarahmawati@.com>
 * @author Elham Budianto <elhambudianto@.com>
 * @package application.models
 * 
 * The followings are the available columns in table 'luluskomponendarah_t':
 * @property integer $luluskomponendarah_id
 * @property integer $kantongdarah_id
 * @property string $tglpelulusan
 * @property string $statuspelulusan
 * @property integer $koordinatormutu_id
 * @property integer $kepalainstalasi_id
 * @property string $keteranganpelulusan
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property KantongdarahT $kantongdarah
 */
class LuluskomponendarahT extends CActiveRecord
{
        public $tgl_awal, $tgl_akhir; 
        public $nomorbarcode; 
        public $jeniskantongdarah_id; 
        public $komponendarah_id, $koordinatormutu_nama, $kepalainstalasi_nama;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LuluskomponendarahT the static model class
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
		return 'luluskomponendarah_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('kantongdarah_id, tglpelulusan, statuspelulusan, koordinatormutu_id, kepalainstalasi_id, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('kantongdarah_id, koordinatormutu_id, kepalainstalasi_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('statuspelulusan', 'length', 'max'=>25),
			array('update_time,is_lipemik,is_hemolisis,is_icetrik,is_plasmahijau,is_bekuan,is_pelabelan,is_identitas,is_kebocoran', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('luluskomponendarah_id, kantongdarah_id, tglpelulusan, statuspelulusan, koordinatormutu_id, kepalainstalasi_id, keteranganpelulusan, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'kantongdarah' => array(self::BELONGS_TO, 'KantongdarahT', 'kantongdarah_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'luluskomponendarah_id' => 'Luluskomponendarah',
			'kantongdarah_id' => 'Kantongdarah_id',
			'tglpelulusan' => 'Tglpelulusan',
			'statuspelulusan' => 'Statuspelulusan',
			'koordinatormutu_id' => 'Koordinatormutu',
			'kepalainstalasi_id' => 'Kepalainstalasi',
			'keteranganpelulusan' => 'Keteranganpelulusan',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'alasantidaklulus' => 'Alasan Tidak Lulus',
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

		$criteria->compare('luluskomponendarah_id',$this->luluskomponendarah_id);
		$criteria->compare('kantongdarah_id',$this->kantongdarah_id);
		$criteria->compare('tglpelulusan',$this->tglpelulusan,true);
		$criteria->compare('statuspelulusan',$this->statuspelulusan,true);
		$criteria->compare('koordinatormutu_id',$this->koordinatormutu_id);
		$criteria->compare('kepalainstalasi_id',$this->kepalainstalasi_id);
		$criteria->compare('keteranganpelulusan',$this->keteranganpelulusan,true);
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