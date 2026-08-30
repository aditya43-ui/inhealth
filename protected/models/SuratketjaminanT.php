<?php

/**
 * This is the model class for table "suratketjaminan_t".
 *
 * The followings are the available columns in table 'suratketjaminan_t':
 * @property integer $suratketjaminan_id
 * @property integer $pembayaranpelayanan_id
 * @property string $tglskj
 * @property string $no_skj
 * @property string $namapenjamin_skj
 * @property string $hubungan_skj
 * @property string $jeniskelamin_skj
 * @property string $alamat_skj
 * @property string $jenisidentitas_skj
 * @property string $no_identitas_skj
 * @property string $nomoblie_skj
 * @property string $notelepon_skj
 * @property string $keterangan_skj
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 *
 * The followings are the available model relations:
 * @property PembayaranpelayananT[] $pembayaranpelayananTs
 * @property PembayaranpelayananT $pembayaranpelayanan
 */
class SuratketjaminanT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return SuratketjaminanT the static model class
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
		return 'suratketjaminan_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tglskj, no_skj, namapenjamin_skj, hubungan_skj, jeniskelamin_skj, alamat_skj, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('pembayaranpelayanan_id', 'numerical', 'integerOnly'=>true),
			array('no_skj, hubungan_skj, jenisidentitas_skj, no_identitas_skj', 'length', 'max'=>50),
			array('namapenjamin_skj, nomoblie_skj, notelepon_skj', 'length', 'max'=>100),
			array('jeniskelamin_skj', 'length', 'max'=>30),
			array('keterangan_skj, update_time, update_loginpemakai_id', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('suratketjaminan_id, pembayaranpelayanan_id, tglskj, no_skj, namapenjamin_skj, hubungan_skj, jeniskelamin_skj, alamat_skj, jenisidentitas_skj, no_identitas_skj, nomoblie_skj, notelepon_skj, keterangan_skj, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'pembayaranpelayananTs' => array(self::HAS_MANY, 'PembayaranpelayananT', 'suratketjaminan_id'),
			'pembayaranpelayanan' => array(self::BELONGS_TO, 'PembayaranpelayananT', 'pembayaranpelayanan_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'suratketjaminan_id' => 'Suratketjaminan',
			'pembayaranpelayanan_id' => 'Pembayaranpelayanan',
			'tglskj' => 'Tglskj',
			'no_skj' => 'No. Skj',
			'namapenjamin_skj' => 'Namapenjamin Skj',
			'hubungan_skj' => 'Hubungan Skj',
			'jeniskelamin_skj' => 'Jeniskelamin Skj',
			'alamat_skj' => 'Alamat Skj',
			'jenisidentitas_skj' => 'Jenisidentitas Skj',
			'no_identitas_skj' => 'No. Identitas Skj',
			'nomoblie_skj' => 'Nomoblie Skj',
			'notelepon_skj' => 'Notelepon Skj',
			'keterangan_skj' => 'Keterangan Skj',
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

		$criteria->compare('suratketjaminan_id',$this->suratketjaminan_id);
		$criteria->compare('pembayaranpelayanan_id',$this->pembayaranpelayanan_id);
		$criteria->compare('tglskj',$this->tglskj,true);
		$criteria->compare('no_skj',$this->no_skj,true);
		$criteria->compare('namapenjamin_skj',$this->namapenjamin_skj,true);
		$criteria->compare('hubungan_skj',$this->hubungan_skj,true);
		$criteria->compare('jeniskelamin_skj',$this->jeniskelamin_skj,true);
		$criteria->compare('alamat_skj',$this->alamat_skj,true);
		$criteria->compare('jenisidentitas_skj',$this->jenisidentitas_skj,true);
		$criteria->compare('no_identitas_skj',$this->no_identitas_skj,true);
		$criteria->compare('nomoblie_skj',$this->nomoblie_skj,true);
		$criteria->compare('notelepon_skj',$this->notelepon_skj,true);
		$criteria->compare('keterangan_skj',$this->keterangan_skj,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id,true);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id,true);
		$criteria->compare('create_ruangan',$this->create_ruangan,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}