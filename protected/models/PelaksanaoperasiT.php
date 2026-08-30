<?php

/**
 * This is the model class for table "pelaksanaoperasi_t".
 *
 * The followings are the available columns in table 'pelaksanaoperasi_t':
 * @property integer $pelaksanaoperasi_id
 * @property integer $rencanaoperasi_id
 * @property string $krubedah
 * @property integer $pegawai_id
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property RencanaoperasiT $rencanaoperasi
 * @property PegawaiM $pegawai
 */
class PelaksanaoperasiT extends CActiveRecord
{
	public $pegawai_nama;
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PelaksanaoperasiT the static model class
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
		return 'pelaksanaoperasi_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('rencanaoperasi_id, krubedah, pegawai_id, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('rencanaoperasi_id, pegawai_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('krubedah', 'length', 'max'=>200),
			array('batalpelaksanaoperasi_id, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pelaksanaoperasi_id, rencanaoperasi_id, krubedah, pegawai_id, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'rencanaoperasi' => array(self::BELONGS_TO, 'RencanaoperasiT', 'rencanaoperasi_id'),
			'pegawai' => array(self::BELONGS_TO, 'PegawaiM', 'pegawai_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pelaksanaoperasi_id' => 'Pelaksanaoperasi',
			'rencanaoperasi_id' => 'Rencanaoperasi',
			'krubedah' => 'Krubedah',
			'pegawai_id' => 'Pegawai',
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

		$criteria->compare('pelaksanaoperasi_id',$this->pelaksanaoperasi_id);
		$criteria->compare('rencanaoperasi_id',$this->rencanaoperasi_id);
		$criteria->compare('krubedah',$this->krubedah,true);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id);
		$criteria->compare('create_ruangan',$this->create_ruangan);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function loadKruBedah(){
		$mod = get_called_class();
		$load = [];
		if (!empty($this->rencanaoperasi_id)){
			$cri = new CDbCriteria;
			$cri->select = [
				't.*',
				'peg.gelardepan',
				'peg.nama_pegawai as pegawai_nama',
				'glr.gelarbelakang_nama'
			];
			$cri->join = "  JOIN pegawai_m peg ON peg.pegawai_id = t.pegawai_id 
							LEFT JOIN gelarbelakang_m glr ON glr.gelarbelakang_id = peg.gelarbelakang_id 
							";
			$cri->addCondition(" rencanaoperasi_id = ".$this->rencanaoperasi_id);
			$model = $mod::model()->findAll($cri);
			
			foreach($model as $key => $val){
				$init = $val->krubedah;
				$load[$init]['det'][$key] = $val;
				$load[$init]['det'][$key]['pegawai_nama'] = (!empty($val->gelardepan)?$val->gelardepan:$val->gelardepan.' ').$val->pegawai_nama.(!empty($val->gelarbelakang_nama)?', '.$val->gelarbelakang_nama:'');
			}
							
		}
		return $load;
	}
}