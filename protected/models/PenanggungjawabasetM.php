<?php

/**
 * This is the model class for table "penanggungjawabaset_m".
 *
 * The followings are the available columns in table 'penanggungjawabaset_m':
 * @property integer $penanggungjawabaset_id
 * @property integer $pegawai_id
 * @property integer $lokasi_id
 * @property integer $ruangan_id
 * @property boolean $penanggungjawabaset_aktif
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property RuanganM $ruangan
 * @property PegawaiM $pegawai
 * @property LokasiasetM $lokasi
 */
class PenanggungjawabasetM extends CActiveRecord
{
        public $lokasiaset_namalokasi;
        public $nama_pegawai;
        public $ruangan_nama;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return penanggungjawabasetM the static model class
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
		return 'penanggungjawabaset_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pegawai_id, ruangan_id, lokasi_id, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('pegawai_id, lokasi_id, ruangan_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('penanggungjawabaset_aktif, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('penanggungjawabaset_id, pegawai_id, lokasi_id, ruangan_id, penanggungjawabaset_aktif, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'ruangan' => array(self::BELONGS_TO, 'RuanganM', 'ruangan_id'),
			'pegawai' => array(self::BELONGS_TO, 'PegawaiM', 'pegawai_id'),
			'lokasi' => array(self::BELONGS_TO, 'LokasiasetM', 'lokasi_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'penanggungjawabaset_id' => 'ID',
			'pegawai_id' => 'Pegawai',                        
			'lokasi_id' => 'Lokasi Aset',
			'ruangan_id' => 'Ruangan Aset',
			'penanggungjawabaset_aktif' => 'Status',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai_id' => 'Create Loginpemakai',
			'update_loginpemakai_id' => 'Update Loginpemakai',
			'create_ruangan' => 'Create Ruangan',
                    
                        'ruangan_nama' => 'Ruangan',
                        'nama_pegawai'=> 'Nama Pegawai',
                        'lokasiaset_namalokasi'=> 'Lokasi Aset',
                        'ruangan_nama'=> 'Ruangan Aset'
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
                $criteria->select = [
                    't.*',
                    "CONCAT(peg.gelardepan,' ',peg.nama_pegawai,', ',gelar.gelarbelakang_nama) as nama_pegawai",
                    'lok.lokasiaset_namalokasi',
                    'r.ruangan_nama'
                ];
                $criteria->join = " JOIN pegawai_m peg ON peg.pegawai_id = t.pegawai_id 
                                    LEFT JOIN gelarbelakang_m gelar ON gelar.gelarbelakang_id = peg.gelarbelakang_id 
                                    JOIN lokasiaset_m lok ON lok.lokasi_id = t.lokasi_id 
                                    JOIN ruangan_m r ON r.ruangan_id = t.ruangan_id 
                                    ";
//                $criteria->compare('LOWER(peg.nama_pegawai)', strtolower($this->nama_pegawai), true);
//                $criteria->compare('LOWER(r.ruangan_nama)', strtolower($this->ruangan_nama), true);
//                $criteria->compare('LOWER(lok.lokasiaset_namalokasi)', strtolower($this->lokasiaset_namalokasi), true);
		$criteria->compare('t.penanggungjawabaset_id',$this->penanggungjawabaset_id);
		$criteria->compare('t.pegawai_id',$this->pegawai_id);
		$criteria->compare('t.lokasi_id',$this->lokasi_id);
		$criteria->compare('t.ruangan_id',$this->ruangan_id);
		$criteria->compare('t.penanggungjawabaset_aktif',isset($this->penanggungjawabaset_aktif)?$this->penanggungjawabaset_aktif:true);
		$criteria->compare('t.create_time',$this->create_time,true);
		$criteria->compare('t.update_time',$this->update_time,true);
		$criteria->compare('t.create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('t.update_loginpemakai_id',$this->update_loginpemakai_id);
		$criteria->compare('t.create_ruangan',$this->create_ruangan);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public static function getDropIdByPegawai($id){
            $load = self::model()->findAll(" pegawai_id = ".$id." AND penanggungjawabaset_aktif = TRUE ");
            $dt = [];
            foreach($load as $det){
                $dt[$det->lokasi_id] = $det->lokasi_id;
            }
            
            return $dt;
        }
}