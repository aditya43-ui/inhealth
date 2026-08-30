<?php

/**
 * This is the model class for table "realisasilembur_t".
 *
 * The followings are the available columns in table 'realisasilembur_t':
 * @property integer $realisasilembur_id
 * @property integer $rencanalembur_id
 * @property integer $pegawai_id
 * @property string $tglrealisasi
 * @property string $norealisasi
 * @property string $nourut
 * @property string $alasanlembur
 * @property string $tglmulai
 * @property string $tglselesai
 * @property string $keterangan
 * @property integer $pemberitugas_id
 * @property integer $mengetahui_id
 * @property integer $menyetujui_id
 * @property string $create_time
 * @property string $create_user
 *
 * The followings are the available model relations:
 * @property RencanalemburT[] $rencanalemburTs
 * @property PegawaiM $pegawai
 * @property RencanalemburT $rencanalembur
 */
class RealisasilemburT extends CActiveRecord
{
    public $jamMulai,$jamSelesai,$nomorindukpegawai,$pilih;
	public $biayalembur_id;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return RealisasilemburT the static model class
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
		return 'realisasilembur_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pegawai_id, tglrealisasi, norealisasi, nourut, alasanlembur, tglmulai, tglselesai, pemberitugas_id, menyetujui_id, create_time, create_user, jenislembur', 'required'),
			array('rencanalembur_id, pegawai_id, pemberitugas_id, mengetahui_id, menyetujui_id', 'numerical', 'integerOnly'=>true),
			array('norealisasi', 'length', 'max'=>20),
			array('nourut', 'length', 'max'=>3),
			array('alasanlembur', 'length', 'max'=>500),
			array('create_user', 'length', 'max'=>50),
			array('keterangan', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('realisasilembur_id, rencanalembur_id, pegawai_id, tglrealisasi, norealisasi, nourut, alasanlembur, tglmulai, tglselesai, keterangan, pemberitugas_id, mengetahui_id, menyetujui_id, create_time, create_user', 'safe', 'on'=>'search'),
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
			'rencanalemburTs' => array(self::HAS_MANY, 'RencanalemburT', 'realisasilembur_id'),
			'pegawai' => array(self::BELONGS_TO, 'PegawaiM', 'pegawai_id'),
			'rencanalembur' => array(self::BELONGS_TO, 'RencanalemburT', 'rencanalembur_id'),
                    
                        'pegawaimengetahui' => array(self::BELONGS_TO, 'PegawaiM', 'mengetahui_id'),
                        'pegawaimenyetujui' => array(self::BELONGS_TO, 'PegawaiM', 'menyetujui_id'),
                        'pemberitugas' => array(self::BELONGS_TO, 'PegawaiM', 'pemberitugas_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'realisasilembur_id' => 'Realisasilembur',
			'rencanalembur_id' => 'Rencanalembur',
			'pegawai_id' => 'Pegawai',
			'tglrealisasi' => 'Tglrealisasi',
			'norealisasi' => 'Norealisasi',
			'nourut' => 'Nourut',
			'alasanlembur' => 'Alasanlembur',
			'tglmulai' => 'Tglmulai',
			'tglselesai' => 'Tglselesai',
			'keterangan' => 'Keterangan',
			'pemberitugas_id' => 'Pemberitugas',
			'mengetahui_id' => 'Mengetahui',
			'menyetujui_id' => 'Menyetujui',
			'create_time' => 'Waktu Create',
			'create_user' => 'Create User',
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

		$criteria->compare('realisasilembur_id',$this->realisasilembur_id);
		$criteria->compare('rencanalembur_id',$this->rencanalembur_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('tglrealisasi',$this->tglrealisasi,true);
		$criteria->compare('norealisasi',$this->norealisasi,true);
		$criteria->compare('nourut',$this->nourut,true);
		$criteria->compare('alasanlembur',$this->alasanlembur,true);
		$criteria->compare('tglmulai',$this->tglmulai,true);
		$criteria->compare('tglselesai',$this->tglselesai,true);
		$criteria->compare('keterangan',$this->keterangan,true);
		$criteria->compare('pemberitugas_id',$this->pemberitugas_id);
		$criteria->compare('mengetahui_id',$this->mengetahui_id);
		$criteria->compare('menyetujui_id',$this->menyetujui_id);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('create_user',$this->create_user,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}