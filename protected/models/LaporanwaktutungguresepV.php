<?php

/**
 * This is the model class for table "laporanwaktutungguresep_v".
 *
 * The followings are the available columns in table 'laporanwaktutungguresep_v':
 * @property integer $penjualanresep_id
 * @property string $noresep
 * @property string $no_pendaftaran
 * @property string $nama_pasien
 * @property string $no_rekam_medik
 * @property string $wakturesep_masuk
 * @property string $wakturesep_keluar
 * @property integer $selisih_waktu
 */
class LaporanwaktutungguresepV extends CActiveRecord
{
	public $tgl_awal, $tgl_akhir, $bln_awal, $bln_akhir, $thn_awal, $thn_akhir, $jns_periode;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'laporanwaktutungguresep_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('penjualanresep_id, selisih_waktu', 'numerical', 'integerOnly'=>true),
			array('noresep, nama_pasien', 'length', 'max'=>50),
			array('no_pendaftaran', 'length', 'max'=>20),
			array('no_rekam_medik', 'length', 'max'=>10),
			array('wakturesep_masuk, wakturesep_keluar', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('penjualanresep_id, noresep, no_pendaftaran, nama_pasien, no_rekam_medik, wakturesep_masuk, wakturesep_keluar, selisih_waktu', 'safe', 'on'=>'search'),
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
			'penjualanresep_id' => 'ID Penjualan Resep',
			'noresep' => 'No. Resep',
			'no_pendaftaran' => 'No. Pendaftaran',
			'nama_pasien' => 'Nama Pasien',
			'no_rekam_medik' => 'No. Rekam Medik',
			'wakturesep_masuk' => 'Waktu Resep Masuk',
			'wakturesep_keluar' => 'Waktu Resep Keluar',
			'selisih_waktu' => 'Selisih Waktu',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;
		$criteria->compare('penjualanresep_id',$this->penjualanresep_id);
		$criteria->compare('noresep',$this->noresep,true);
		$criteria->compare('no_pendaftaran',$this->no_pendaftaran,true);
		$criteria->compare('nama_pasien',$this->nama_pasien,true);
		$criteria->compare('no_rekam_medik',$this->no_rekam_medik,true);
		$criteria->addBetweenCondition('date(wakturesep_masuk)', $this->tgl_awal, $this->tgl_akhir);
		// $criteria->compare('wakturesep_masuk',$this->wakturesep_masuk,true);
		$criteria->compare('wakturesep_keluar',$this->wakturesep_keluar,true);
		$criteria->compare('selisih_waktu',$this->selisih_waktu);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return LaporanwaktutungguresepV the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
