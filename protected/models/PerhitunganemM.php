<?php

/**
 * This is the model class for table "perhitunganem_m".
 *
 * The followings are the available columns in table 'perhitunganem_m':
 * @property integer $perhitunganem_id
 * @property integer $invperalatan_id
 * @property string $res_fungsi_nama
 * @property double $res_fungsi_nilai
 * @property string $res_klinis_nama
 * @property double $res_klinis_nilai
 * @property string $res_pemeliharaan_nama
 * @property double $res_pemeliharaan_nilai
 * @property string $res_insiden_nama
 * @property double $res_insiden_nilai
 * @property double $nilai_em
 * @property string $frekuensi_inspeksi
 * @property string $perhitunganem_ket
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property string $create_ruangan
 *
 * The followings are the available model relations:
 * @property InvperalatanT $invperalatan
 * @property integer $barang_id
 *
 * The followings are the available model relations:
 * @property BarangM $barang
 */
class PerhitunganemM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PerhitunganemM the static model class
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
		return 'perhitunganem_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(			
			array('res_fungsi_nama, res_fungsi_nilai, res_klinis_nama, res_klinis_nilai, res_pemeliharaan_nama, res_pemeliharaan_nilai, res_insiden_nama, res_insiden_nilai, nilai_em, frekuensi_inspeksi, create_time, create_loginpemakai_id, create_ruangan, barang_id', 'required'),
			array('create_loginpemakai_id, update_loginpemakai_id, barang_id', 'numerical', 'integerOnly'=>true),
			array('res_fungsi_nilai, res_klinis_nilai, res_pemeliharaan_nilai, res_insiden_nilai, nilai_em', 'numerical'),
			array('res_fungsi_nama, res_klinis_nama, res_pemeliharaan_nama, res_insiden_nama', 'length', 'max'=>200),
			array('frekuensi_inspeksi', 'length', 'max'=>20),
			array('perhitunganem_ket, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('perhitunganem_id, invperalatan_id, res_fungsi_nama, res_fungsi_nilai, res_klinis_nama, res_klinis_nilai, res_pemeliharaan_nama, res_pemeliharaan_nilai, res_insiden_nama, res_insiden_nilai, nilai_em, frekuensi_inspeksi, perhitunganem_ket, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),

			array('perhitunganem_id, res_fungsi_nama, res_fungsi_nilai, res_klinis_nama, res_klinis_nilai, res_pemeliharaan_nama, res_pemeliharaan_nilai, res_insiden_nama, res_insiden_nilai, nilai_em, frekuensi_inspeksi, perhitunganem_ket, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, barang_id', 'safe', 'on'=>'search'),
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
			'invperalatan' => array(self::BELONGS_TO, 'InvperalatanT', 'invperalatan_id'),
			'barang' => array(self::BELONGS_TO, 'BarangM', 'barang_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'perhitunganem_id' => 'Perhitunganem',
			'invperalatan_id' => 'Invperalatan',
			'res_fungsi_nama' => 'Res Fungsi Nama',
			'res_fungsi_nilai' => 'Res Fungsi Nilai',
			'res_klinis_nama' => 'Res Klinis Nama',
			'res_klinis_nilai' => 'Res Klinis Nilai',
			'res_pemeliharaan_nama' => 'Res Pemeliharaan Nama',
			'res_pemeliharaan_nilai' => 'Res Pemeliharaan Nilai',
			'res_insiden_nama' => 'Res Insiden Nama',
			'res_insiden_nilai' => 'Res Insiden Nilai',
			'nilai_em' => 'Nilai Em',
			'frekuensi_inspeksi' => 'Frekuensi Inspeksi',
			'perhitunganem_ket' => 'Perhitunganem Ket',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai_id' => 'Create Loginpemakai',
			'update_loginpemakai_id' => 'Update Loginpemakai',
			'create_ruangan' => 'Create Ruangan',
			'barang_id' => 'Barang',
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

		$criteria->compare('perhitunganem_id',$this->perhitunganem_id);
		$criteria->compare('invperalatan_id',$this->invperalatan_id);
		$criteria->compare('res_fungsi_nama',$this->res_fungsi_nama,true);
		$criteria->compare('res_fungsi_nilai',$this->res_fungsi_nilai);
		$criteria->compare('res_klinis_nama',$this->res_klinis_nama,true);
		$criteria->compare('res_klinis_nilai',$this->res_klinis_nilai);
		$criteria->compare('res_pemeliharaan_nama',$this->res_pemeliharaan_nama,true);
		$criteria->compare('res_pemeliharaan_nilai',$this->res_pemeliharaan_nilai);
		$criteria->compare('res_insiden_nama',$this->res_insiden_nama,true);
		$criteria->compare('res_insiden_nilai',$this->res_insiden_nilai);
		$criteria->compare('nilai_em',$this->nilai_em);
		$criteria->compare('frekuensi_inspeksi',$this->frekuensi_inspeksi,true);
		$criteria->compare('perhitunganem_ket',$this->perhitunganem_ket,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id);
		$criteria->compare('create_ruangan',$this->create_ruangan,true);
		$criteria->compare('barang_id',$this->barang_id);


		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}