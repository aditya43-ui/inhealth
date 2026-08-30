<?php

/**
 * This is the model class for table "penyiapandarah_t".
 *
 * The followings are the available columns in table 'penyiapandarah_t':
 * @property integer $penyiapandarah_id
 * @property integer $pendaftaran_id
 * @property integer $permintaandarah_id
 * @property string $tglpenyiapandarah
 * @property double $lamapenyiapan_detik
 * @property string $tglpelabelan
 * @property integer $peg_pelabelan
 * @property integer $peg_referal_id
 * @property string $tgl_referal
 * @property string $ket_penyiapan
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 * @property integer $pemeriksaangoldar_id
 */
class PenyiapandarahT extends CActiveRecord
{
    public $peg_referal_nama;
    public $peg_pelabelan_nama;
    public $peg_penerimapermintaan_nama, $hasilujicocokserasi_id, $nomorbarcode, $stokkantongdarah_id;
    
    public $ujidarahtube_id;
    
    public $waktu_penyiapan;
    
    public $no_permintaandarah;
    
    public $ceklis, $gejala_reaksitransfusi1, $gejala_reaksitransfusi2, $gejala_reaksitransfusi3;
    
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PenyiapandarahT the static model class
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
		return 'penyiapandarah_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pendaftaran_id, tglpenyiapandarah, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('pendaftaran_id, permintaandarah_id, peg_pelabelan, peg_referal_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('lamapenyiapan_detik', 'numerical'),
			array('penyiapandarah_ke, satuan_waktu, peg_penerimapermintaan_id, tglpelabelan, tgl_referal, ket_penyiapan, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('penyiapandarah_id, pendaftaran_id, permintaandarah_id, tglpenyiapandarah, lamapenyiapan_detik, tglpelabelan, peg_pelabelan, peg_referal_id, tgl_referal, ket_penyiapan, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
                    'penerimapermintaan' => array(self::BELONGS_TO,'PegawaiM','peg_penerimapermintaan_id'),
                    'pendaftaran' => array(self::BELONGS_TO,'PendaftaranT','pendaftaran_id'),
                    'pemeriksaangoldar' => array(self::BELONGS_TO,'PemeriksaangoldarT','pemeriksaangoldar_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'penyiapandarah_id' => 'Penyiapandarah',
			'pendaftaran_id' => 'Pendaftaran',
			'permintaandarah_id' => 'Permintaandarah',
			'tglpenyiapandarah' => 'Tgl. Pengiriman Darah',
			'lamapenyiapan_detik' => 'Lama Penyiapan',
			'tglpelabelan' => 'Tgl. Pelabelan',
			'peg_pelabelan' => 'Petugas Pelabelan',
			'peg_referal_id' => 'Petugas Referal',
			'tgl_referal' => 'Tgl. Referal',
			'ket_penyiapan' => 'Ket Pengiriman',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
            'peg_penerimapermintaan_id' => 'Penerima Formulir Permintaan Darah',
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

		$criteria->compare('penyiapandarah_id',$this->penyiapandarah_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('permintaandarah_id',$this->permintaandarah_id);
		$criteria->compare('tglpenyiapandarah',$this->tglpenyiapandarah,true);
		$criteria->compare('lamapenyiapan_detik',$this->lamapenyiapan_detik);
		$criteria->compare('tglpelabelan',$this->tglpelabelan,true);
		$criteria->compare('peg_pelabelan',$this->peg_pelabelan);
		$criteria->compare('peg_referal_id',$this->peg_referal_id);
		$criteria->compare('tgl_referal',$this->tgl_referal,true);
		$criteria->compare('ket_penyiapan',$this->ket_penyiapan,true);
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