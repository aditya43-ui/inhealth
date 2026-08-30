<?php

/**
 * This is the model class for table "riwayatstatuscm_v".
 *
 * The followings are the available columns in table 'riwayatstatuscm_v':
 * @property integer $korektifmainten_id
 * @property string $tanggal
 * @property integer $pegawai_id
 * @property string $status
 * @property string $keterangan
 */
class RiwayatstatuscmV extends CActiveRecord
{
        public $nama_lengkap;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return RiwayatstatuscmV the static model class
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
		return 'riwayatstatuscm_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('korektifmainten_id, pegawai_id', 'numerical', 'integerOnly'=>true),
			array('tanggal, status, keterangan', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('korektifmainten_id, tanggal, pegawai_id, status, keterangan', 'safe', 'on'=>'search'),
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
			'korektifmainten_id' => 'Korektifmainten',
			'tanggal' => 'Tanggal',
			'pegawai_id' => 'Pegawai',
			'status' => 'Status',
			'keterangan' => 'Keterangan',
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
                    "CONCAT(peg.gelardepan,' ',peg.nama_pegawai,', ',gelar.gelarbelakang_nama) as nama_lengkap"
                ];
                $criteria->join = " JOIN pegawai_m peg ON peg.pegawai_id = t.pegawai_id "
                                . " LEFT JOIN gelarbelakang_m gelar ON gelar.gelarbelakang_id = peg.gelarbelakang_id ";
		$criteria->compare('t.korektifmainten_id',$this->korektifmainten_id);
		$criteria->compare('t.tanggal',$this->tanggal,true);
		$criteria->compare('t.pegawai_id',$this->pegawai_id);
		$criteria->compare('t.status',$this->status,true);
		$criteria->compare('t.keterangan',$this->keterangan,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}