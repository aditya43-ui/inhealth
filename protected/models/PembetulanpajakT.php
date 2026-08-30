<?php

/**
 * This is the model class for table "pembetulanpajak_t".
 *
 * The followings are the available columns in table 'pembetulanpajak_t':
 * @property string $pembetulanpajak_id
 * @property string $tglpembetulan
 * @property integer $pegawai_id
 * @property string $tglpajak
 * @property double $jml_bruto
 * @property double $jml_pph
 * @property string $pembetulanke
 * @property double $jmlpembetulan
 * @property string $keterangan
 * @property string $create_time
 * @property string $update_time
 * @property string $create_user
 * @property string $update_user
 * @property integer $create_ruanganid
 */
class PembetulanpajakT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PembetulanpajakT the static model class
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
		return 'pembetulanpajak_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tglpembetulan, pegawai_id, tglpajak, jml_bruto, jml_pph, pembetulanke, jmlpembetulan, keterangan, create_time, create_user, create_ruanganid', 'required'),
			array('pegawai_id, create_ruanganid', 'numerical', 'integerOnly'=>true),
			array('jml_bruto, jml_pph, jmlpembetulan', 'numerical'),
			array('keterangan, create_user', 'length', 'max'=>255),
			array('update_time, update_user', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pembetulanpajak_id, tglpembetulan, pegawai_id, tglpajak, jml_bruto, jml_pph, pembetulanke, jmlpembetulan, keterangan, create_time, update_time, create_user, update_user, create_ruanganid', 'safe', 'on'=>'search'),
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
			'pembetulanpajak_id' => 'Pembetulanpajak',
			'tglpembetulan' => 'Tanggal Pembetulan',
			'pegawai_id' => 'Pegawai',
			'tglpajak' => 'Tanggal Pajak',
			'jml_bruto' => 'Jumlah Bruto',
			'jml_pph' => 'Jumlah Pph',
			'pembetulanke' => 'Pembetulan ke',
			'jmlpembetulan' => 'Jumlah Pembetulan',
			'keterangan' => 'Keterangan',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_user' => 'Create User',
			'update_user' => 'Update User',
			'create_ruanganid' => 'Create Ruanganid',
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

		$criteria->compare('pembetulanpajak_id',$this->pembetulanpajak_id,true);
		$criteria->compare('tglpembetulan',$this->tglpembetulan,true);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('tglpajak',$this->tglpajak,true);
		$criteria->compare('jml_bruto',$this->jml_bruto);
		$criteria->compare('jml_pph',$this->jml_pph);
		$criteria->compare('pembetulanke',$this->pembetulanke,true);
		$criteria->compare('jmlpembetulan',$this->jmlpembetulan);
		$criteria->compare('keterangan',$this->keterangan,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_user',$this->create_user,true);
		$criteria->compare('update_user',$this->update_user,true);
		$criteria->compare('create_ruanganid',$this->create_ruanganid);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}