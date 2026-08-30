<?php

/**
 * This is the model class for table "oppebimbingan_t".
 * @author Yudhit Widy Wicaksono <yudhitwicaksono@.com>
 * @package application.models
 * The followings are the available columns in table 'oppebimbingan_t':
 * @property integer $oppebimbingan_id
 * @property integer $indikatoroppekeperawatan_id
 * @property integer $ka_unitkerja_id
 * @property integer $unitkerja_id
 * @property string $bulan_bimbingan
 * @property string $nama_perawat
 * @property string $nip_perawat
 * @property integer $perawat_unitkerja_id
 * @property string $institusi
 * @property double $jml_bimbingan
 * @property double $target
 * @property double $skor
 * @property integer $create_loginpemakai_id
 * @property string $create_time
 * @property integer $update_loginpemakai_id
 * @property string $update_time
 *
 * The followings are the available model relations:
 * @property IndikatoroppekeperawatanM $indikatoroppekeperawatan
 */
class OppebimbinganT extends CActiveRecord
{
    public $namaunitkerja, $indikatoroppekeperawatan_nama, $standar_nilai; 
    public $smf_nama;
    public $capaian;
    public $jumlah;
    public $nama_indikator;    
    public $golongan_indikator;
    public $rekomendasi, $bulan_pilih_awal, $bulan_pilih_akhir;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return OppebimbinganT the static model class
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
		return 'oppebimbingan_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ka_unitkerja_id, unitkerja_id, bulan_bimbingan, pegawai_id, nama_perawat, nip_perawat, perawat_unitkerja_id, institusi, jml_bimbingan, skor, create_loginpemakai_id, create_time', 'required'),
			array('indikatoroppekeperawatan_id, ka_unitkerja_id, unitkerja_id, pegawai_id, perawat_unitkerja_id, create_loginpemakai_id, update_loginpemakai_id', 'numerical', 'integerOnly'=>true),
			array('jml_bimbingan, target, skor', 'numerical'),
			array('nama_perawat, nip_perawat, institusi', 'length', 'max'=>255),
			array('update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('oppebimbingan_id, indikatoroppekeperawatan_id, ka_unitkerja_id, unitkerja_id, bulan_bimbingan, pegawai_id, nama_perawat, nip_perawat, perawat_unitkerja_id, institusi, jml_bimbingan, target, skor, create_loginpemakai_id, create_time, update_loginpemakai_id, update_time', 'safe', 'on'=>'search'),
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
			'indikatoroppekeperawatan' => array(self::BELONGS_TO, 'IndikatoroppekeperawatanM', 'indikatoroppekeperawatan_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'oppebimbingan_id' => 'Oppebimbingan',
			'indikatoroppekeperawatan_id' => 'Indikatoroppekeperawatan',
			'ka_unitkerja_id' => 'Ka Unit Kerja',
			'unitkerja_id' => 'Unit Kerja',
			'bulan_bimbingan' => 'Bulan Bimbingan',
			'nama_perawat' => 'Nama Perawat',
			'nip_perawat' => 'Nip Perawat',
			'perawat_unitkerja_id' => 'Perawat Unit Kerja',
			'institusi' => 'Institusi',
			'jml_bimbingan' => 'Jumlah Bimbingan',
			'target' => 'Target',
			'skor' => 'Skor',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'create_time' => 'Waktu Create',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'update_time' => 'Waktu Update',
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

		$criteria->compare('oppebimbingan_id',$this->oppebimbingan_id);
		$criteria->compare('indikatoroppekeperawatan_id',$this->indikatoroppekeperawatan_id);
                $criteria->compare('pegawai_id', $this->pegawai_id);
		$criteria->compare('ka_unitkerja_id',$this->ka_unitkerja_id);
		$criteria->compare('unitkerja_id',$this->unitkerja_id);
                if(!empty($this->bulan_bimbingan)){
                    $criteria->addBetweenCondition('DATE(bulan_bimbingan)', $this->bulan_pilih_awal, $this->bulan_pilih_akhir);
                }
		$criteria->compare('nama_perawat',$this->nama_perawat,true);
		$criteria->compare('nip_perawat',$this->nip_perawat,true);
		$criteria->compare('perawat_unitkerja_id',$this->perawat_unitkerja_id);
		$criteria->compare('institusi',$this->institusi,true);
		$criteria->compare('jml_bimbingan',$this->jml_bimbingan);
		$criteria->compare('target',$this->target);
		$criteria->compare('skor',$this->skor);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id);
		$criteria->compare('update_time',$this->update_time,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}