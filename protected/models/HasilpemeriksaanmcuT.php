<?php

/**
 * This is the model class for table "hasilpemeriksaanmcu_t".
 *
 * The followings are the available columns in table 'hasilpemeriksaanmcu_t':
 * @property integer $hasilpemeriksaanmcu_id
 * @property integer $pendaftaran_id
 * @property integer $ruangan_id
 * @property integer $pegawai_id
 * @property string $tglhasilpemeriksaanmcu
 * @property string $nohasilmcu
 * @property string $kesimpulanmcu
 * @property string $saranmcu
 * @property string $keteranganmcu
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 */
class HasilpemeriksaanmcuT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return HasilpemeriksaanmcuT the static model class
	 */
        public $is_sendiri;
        public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'hasilpemeriksaanmcu_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pendaftaran_id, ruangan_id, pegawai_id, tglhasilpemeriksaanmcu, nohasilmcu, kesimpulanmcu, create_time, create_loginpemakai_id', 'required'),
			array('pendaftaran_id, ruangan_id, pegawai_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('nohasilmcu', 'length', 'max'=>20),
			array('kesimpulanmcu', 'length', 'max'=>30),
			array('saranmcu, keteranganmcu, update_time, tglpengambilanhasil, namapenerimahasil, notelppenerimahasil, namaygmenyerahkan, ketpenyerahan, jenisidentitas, no_identitas, alamat', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('hasilpemeriksaanmcu_id, pendaftaran_id, ruangan_id, pegawai_id, tglhasilpemeriksaanmcu, nohasilmcu, kesimpulanmcu, saranmcu, keteranganmcu, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, tglpengambilanhasil, namapenerimahasil, notelppenerimahasil, namaygmenyerahkan, ketpenyerahan, jenisidentitas, no_identitas, alamat', 'safe', 'on'=>'search'),
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
			'pegawai'=>array(self::BELONGS_TO,'PegawaiM','pegawai_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'hasilpemeriksaanmcu_id' => 'Hasilpemeriksaanmcu',
			'pendaftaran_id' => 'Pendaftaran',
			'ruangan_id' => 'Ruangan',
			'pegawai_id' => 'Pegawai',
			'tglhasilpemeriksaanmcu' => 'Tglhasilpemeriksaanmcu',
			'nohasilmcu' => 'Nohasilmcu',
			'kesimpulanmcu' => 'Kesimpulan',
			'saranmcu' => 'Saranmcu',
			'keteranganmcu' => 'Keteranganmcu',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
                        'tglpengambilanhasil' => 'Tgl. Penyerahan',
                    'namapenerimahasil' => 'Nama Pengambil Hasil',
                    'notelppenerimahasil' => 'No. Telp Pengambil Hasil',
                    'namaygmenyerahkan' => 'Nama yang menyerahkan',
                    'ketpenyerahan' => 'Keterangan Pengambilan',
                    'alamat' => 'Alamat',
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

		$criteria->compare('hasilpemeriksaanmcu_id',$this->hasilpemeriksaanmcu_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('tglhasilpemeriksaanmcu',$this->tglhasilpemeriksaanmcu,true);
		$criteria->compare('nohasilmcu',$this->nohasilmcu,true);
		$criteria->compare('kesimpulanmcu',$this->kesimpulanmcu,true);
		$criteria->compare('saranmcu',$this->saranmcu,true);
		$criteria->compare('keteranganmcu',$this->keteranganmcu,true);
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