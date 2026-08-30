<?php

/**
 * This is the model class for table "peminjamanbrg_t".
 *
 * The followings are the available columns in table 'peminjamanbrg_t':  
 *
 * @package      application.models 
 * @author      M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     2.0.0
 * @link      <http://piindonesia.co.id>
 * @link      <http://172.9.1.15/simpp/docs/> 
 * @property integer $peminjamanbrg_id
 * @property string $peminjamanbrg_nomor
 * @property string $peminjamanbrg_tanggal
 * @property integer $pegpeminjam_id
 * @property integer $invperalatan_id
 * @property integer $ruangan_id
 * @property string $tanggal_awal
 * @property string $tanggal_akhir
 * @property string $peminjamanbrg_keperluan
 * @property integer $pegpengembali_id
 * @property string $pengembalian_catatan
 * @property string $pengembalian_tanggal
 * @property string $status_pengembalian
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property RuanganM $ruangan
 * @property InvperalatanT $invperalatan
 * @property PegawaiM $pegpeminjam
 * @property PegawaiM $pegpengembali
 */
class PeminjamanbrgT extends CActiveRecord
{
        public $pegpeminjam_nama;
        public $ruangan_nama;
        public $nip;
        public $jabatan_nama;
        public $namaunitkerja;
        public $invperalatan_namabrg;
        public $invperalatan_kode;
        public $invperalatan_ukuran;
        public $invperalatan_keadaan;
        public $invperalatan_merk;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PeminjamanbrgT the static model class
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
		return 'peminjamanbrg_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('peminjamanbrg_nomor, peminjamanbrg_tanggal, pegpeminjam_id, invperalatan_id, ruangan_id, tanggal_awal, tanggal_akhir, peminjamanbrg_keperluan, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('pegpeminjam_id, invperalatan_id, ruangan_id, pegpengembali_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('peminjamanbrg_nomor', 'length', 'max'=>15),
			array('status_pengembalian', 'length', 'max'=>20),
			array('pengembalian_catatan, pengembalian_tanggal, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('peminjamanbrg_id, peminjamanbrg_nomor, peminjamanbrg_tanggal, pegpeminjam_id, invperalatan_id, ruangan_id, tanggal_awal, tanggal_akhir, peminjamanbrg_keperluan, pegpengembali_id, pengembalian_catatan, pengembalian_tanggal, status_pengembalian, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'invperalatan' => array(self::BELONGS_TO, 'InvperalatanT', 'invperalatan_id'),
			'pegpeminjam' => array(self::BELONGS_TO, 'PegawaiM', 'pegpeminjam_id'),
			'pegpengembali' => array(self::BELONGS_TO, 'PegawaiM', 'pegpengembali_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'peminjamanbrg_id' => 'Peminjamanbrg',
			'peminjamanbrg_nomor' => 'Peminjamanbrg Nomor',
			'peminjamanbrg_tanggal' => 'Peminjamanbrg Tanggal',
			'pegpeminjam_id' => 'Pegpeminjam',
			'invperalatan_id' => 'Invperalatan',
			'ruangan_id' => 'Ruangan',
			'tanggal_awal' => 'Tanggal Awal',
			'tanggal_akhir' => 'Tanggal Akhir',
			'peminjamanbrg_keperluan' => 'Peminjamanbrg Keperluan',
			'pegpengembali_id' => 'Pegpengembali',
			'pengembalian_catatan' => 'Pengembalian Catatan',
			'pengembalian_tanggal' => 'Pengembalian Tanggal',
			'status_pengembalian' => 'Status Pengembalian',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai_id' => 'Create Loginpemakai',
			'update_loginpemakai_id' => 'Update Loginpemakai',
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

		$criteria->compare('peminjamanbrg_id',$this->peminjamanbrg_id);
		$criteria->compare('peminjamanbrg_nomor',$this->peminjamanbrg_nomor,true);
		$criteria->compare('peminjamanbrg_tanggal',$this->peminjamanbrg_tanggal,true);
		$criteria->compare('pegpeminjam_id',$this->pegpeminjam_id);
		$criteria->compare('invperalatan_id',$this->invperalatan_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('tanggal_awal',$this->tanggal_awal,true);
		$criteria->compare('tanggal_akhir',$this->tanggal_akhir,true);
		$criteria->compare('peminjamanbrg_keperluan',$this->peminjamanbrg_keperluan,true);
		$criteria->compare('pegpengembali_id',$this->pegpengembali_id);
		$criteria->compare('pengembalian_catatan',$this->pengembalian_catatan,true);
		$criteria->compare('pengembalian_tanggal',$this->pengembalian_tanggal,true);
		$criteria->compare('status_pengembalian',$this->status_pengembalian,true);
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