<?php

/**
 * This is the model class for table "infoinaktifrekammedis_v".
 *
 * The followings are the available columns in table 'infoinaktifrekammedis_v':
 * @property string $tglinaktifrekammedis
 * @property string $noretensiinaktif
 * @property integer $pasien_id
 * @property string $nama_pasien
 * @property string $tanggal_lahir
 * @property string $jeniskelamin
 * @property string $alamat_pasien
 * @property string $tglkunjunganterakhir
 * @property string $masafungsirm
 */
class InfoinaktifrekammedisV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InfoinaktifrekammedisV the static model class
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
		return 'infoinaktifrekammedis_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pasien_id', 'numerical', 'integerOnly'=>true),
			array('noretensiinaktif, jeniskelamin, masafungsirm', 'length', 'max'=>20),
			array('nama_pasien', 'length', 'max'=>50),
			array('no_rekam_medik,tglinaktifrekammedis, tanggal_lahir, alamat_pasien, tglkunjunganterakhir', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('no_rekam_medik,tglinaktifrekammedis, noretensiinaktif, pasien_id, nama_pasien, tanggal_lahir, jeniskelamin, alamat_pasien, tglkunjunganterakhir, masafungsirm', 'safe', 'on'=>'search'),
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
			'tglinaktifrekammedis' => 'Tglinaktifrekammedis',
			'noretensiinaktif' => 'Noretensiinaktif',
			'pasien_id' => 'Pasien',
			'nama_pasien' => 'Nama Pasien',
			'tanggal_lahir' => 'Tanggal Lahir',
			'jeniskelamin' => 'Jenis Kelamin',
			'alamat_pasien' => 'Alamat Pasien',
			'tglkunjunganterakhir' => 'Tglkunjunganterakhir',
			'masafungsirm' => 'Masafungsirm',
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

		$criteria->compare('tglinaktifrekammedis',$this->tglinaktifrekammedis,true);
		$criteria->compare('noretensiinaktif',$this->noretensiinaktif,true);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('nama_pasien',$this->nama_pasien,true);
		$criteria->compare('tanggal_lahir',$this->tanggal_lahir,true);
		$criteria->compare('jeniskelamin',$this->jeniskelamin,true);
		$criteria->compare('alamat_pasien',$this->alamat_pasien,true);
		$criteria->compare('tglkunjunganterakhir',$this->tglkunjunganterakhir,true);
		$criteria->compare('masafungsirm',$this->masafungsirm,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}