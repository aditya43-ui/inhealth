<?php

/**
 * This is the model class for table "pengbonusthr_t".
 *
 * The followings are the available columns in table 'pengbonusthr_t':
 * @property integer $pengbonusthr_id
 * @property string $tglpengajuan
 * @property string $jenisgaji
 * @property string $nopengajuan
 * @property integer $mengetahuirs_id
 * @property integer $mengetahui_pt
 * @property integer $menyetujui_id
 * @property string $keteranganpengajuan
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 *
 * The followings are the available model relations:
 * @property PengbonusthrdetailT[] $pengbonusthrdetailTs
 */
class PengbonusthrT extends CActiveRecord
{
    public $mengetahuirs_nama, $mengetahui_pt_nama, $menyetujui_nama, $totalpajak, $jmldibayarkan, $jmlsisahutang, $keterangan, $checklist;


	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PengbonusthrT the static model class
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
		return 'pengbonusthr_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tglpengajuan, jenisgaji, mengetahuirs_id, mengetahui_pt, menyetujui_id, create_time, create_loginpemakai_id, create_ruangan, periodebonusthr, nopengajuan', 'required'),
			array('mengetahuirs_id, mengetahui_pt, menyetujui_id, pajak_id', 'numerical', 'integerOnly'=>true),
			array('jenisgaji', 'length', 'max'=>20),
			array('nopengajuan', 'length', 'max'=>100),
			array('keteranganpengajuan, update_time, update_loginpemakai_id, periodebonusthr, tgl_mengetahui, tgl_mengetahuipt, tgl_menyetujui', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pengbonusthr_id, tglpengajuan, jenisgaji, nopengajuan, mengetahuirs_id, mengetahui_pt, menyetujui_id, keteranganpengajuan, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, periodebonusthr, tgl_mengetahui, tgl_mengetahuipt, tgl_menyetujui, pajak_id', 'safe', 'on'=>'search'),
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
			'pengbonusthrdetailTs' => array(self::HAS_MANY, 'PengbonusthrdetailT', 'pengbonusthr_id'),
      'mengetahuirs' => array(self::BELONGS_TO, 'PegawaiM', 'mengetahuirs_id'),
      'mengetahuipts' => array(self::BELONGS_TO, 'PegawaiM', 'mengetahui_pt'),
      'menyetujui' => array(self::BELONGS_TO, 'PegawaiM', 'menyetujui_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pengbonusthr_id' => 'Pengbonusthr',
			'tglpengajuan' => 'Tanggal Pengajuan',
			'jenisgaji' => 'Jenis Gaji',
			'nopengajuan' => 'No. Pengajuan',
			'mengetahuirs_id' => 'Mengetahui (RS)',
			'mengetahui_pt' => 'Mengetahui (PT)',
			'menyetujui_id' => 'Menyetujui',
			'keteranganpengajuan' => 'Keterangan',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
                        'periodebonusthr'=>'Periode Bonus / THR'
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

		$criteria->compare('pengbonusthr_id',$this->pengbonusthr_id);
		$criteria->compare('tglpengajuan',$this->tglpengajuan,true);
		$criteria->compare('jenisgaji',$this->jenisgaji,true);
		$criteria->compare('nopengajuan',$this->nopengajuan,true);
		$criteria->compare('mengetahuirs_id',$this->mengetahuirs_id);
		$criteria->compare('mengetahui_pt',$this->mengetahui_pt);
		$criteria->compare('menyetujui_id',$this->menyetujui_id);
		$criteria->compare('keteranganpengajuan',$this->keteranganpengajuan,true);
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
