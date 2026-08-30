<?php

/**
 * This is the model class for table "rencanalembur_t".
 *
 * The followings are the available columns in table 'rencanalembur_t':
 * @property integer $rencanalembur_id
 * @property integer $pegawai_id
 * @property integer $realisasilembur_id
 * @property string $tglrencana
 * @property string $norencana
 * @property string $nourut
 * @property string $alasanlembur
 * @property string $tglmulai
 * @property string $tglselesai
 * @property string $keterangan
 * @property integer $pemberitugas_id
 * @property integer $mengetahui_id
 * @property integer $menyetujui_id
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 * @property string $statusrencana
 * @property string $alasan_tolakbatal
 *
 * The followings are the available model relations:
 * @property PegawaiM $pegawai
 * @property RealisasilemburT $realisasilembur
 * @property RencanalemburdetT[] $rencanalemburdetTs
 * @property RealisasilemburT[] $realisasilemburTs
 */
class RencanalemburT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return RencanalemburT the static model class
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
		return 'rencanalembur_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tglrencana, norencana, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('pegawai_id, realisasilembur_id, pemberitugas_id, mengetahui_id, menyetujui_id', 'numerical', 'integerOnly'=>true),
			array('norencana, statusrencana', 'length', 'max'=>20),
			array('nourut', 'length', 'max'=>3),
			array('alasanlembur', 'length', 'max'=>500),
			array('tglmulai, tglselesai, keterangan, update_time, update_loginpemakai_id, alasan_tolakbatal', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('rencanalembur_id, pegawai_id, realisasilembur_id, tglrencana, norencana, nourut, alasanlembur, tglmulai, tglselesai, keterangan, pemberitugas_id, mengetahui_id, menyetujui_id, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, statusrencana, alasan_tolakbatal', 'safe', 'on'=>'search'),
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
			'pegawai' => array(self::BELONGS_TO, 'PegawaiM', 'pegawai_id'),
			'realisasilembur' => array(self::BELONGS_TO, 'RealisasilemburT', 'realisasilembur_id'),
			'rencanalemburdetTs' => array(self::HAS_MANY, 'RencanalemburdetT', 'rencanalembur_id'),
			'realisasilemburTs' => array(self::HAS_MANY, 'RealisasilemburT', 'rencanalembur_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'rencanalembur_id' => 'Rencanalembur',
			'pegawai_id' => 'Pegawai',
			'realisasilembur_id' => 'Realisasilembur',
			'tglrencana' => 'Tglrencana',
			'norencana' => 'Norencana',
			'nourut' => 'Nourut',
			'alasanlembur' => 'Alasanlembur',
			'tglmulai' => 'Tglmulai',
			'tglselesai' => 'Tglselesai',
			'keterangan' => 'Keterangan',
			'pemberitugas_id' => 'Pemberitugas',
			'mengetahui_id' => 'Mengetahui',
			'menyetujui_id' => 'Menyetujui',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
			'statusrencana' => 'Statusrencana',
			'alasan_tolakbatal' => 'Alasan Tolakbatal',
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

		$criteria->compare('rencanalembur_id',$this->rencanalembur_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('realisasilembur_id',$this->realisasilembur_id);
		$criteria->compare('tglrencana',$this->tglrencana,true);
		$criteria->compare('norencana',$this->norencana,true);
		$criteria->compare('nourut',$this->nourut,true);
		$criteria->compare('alasanlembur',$this->alasanlembur,true);
		$criteria->compare('tglmulai',$this->tglmulai,true);
		$criteria->compare('tglselesai',$this->tglselesai,true);
		$criteria->compare('keterangan',$this->keterangan,true);
		$criteria->compare('pemberitugas_id',$this->pemberitugas_id);
		$criteria->compare('mengetahui_id',$this->mengetahui_id);
		$criteria->compare('menyetujui_id',$this->menyetujui_id);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id,true);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id,true);
		$criteria->compare('create_ruangan',$this->create_ruangan,true);
		$criteria->compare('statusrencana',$this->statusrencana,true);
		$criteria->compare('alasan_tolakbatal',$this->alasan_tolakbatal,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}