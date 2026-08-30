<?php

/**
 * This is the model class for table "pengisiansaldoawal_t".
 *
 * The followings are the available columns in table 'pengisiansaldoawal_t':
 * @property integer $pengisiansaldoawal_id
 * @property string $tglpengisiansaldo
 * @property integer $shift_id
 * @property double $nilaisaldoawal
 * @property integer $pegawai_id
 * @property string $create_time
 * @property string $update_time
 * @property string $loginpemakai_id
 * @property string $nama_rumahsakit
 * @property string $ruangan_nama
 * @property string $kirim_tgl
 * @property integer $kirim_pegawai_id
 * @property boolean $is_kirim
 */
class PengisiansaldoawalT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PengisiansaldoawalT the static model class
	 */
	public $kirim_pegawai_id, $carabayar_id,$carabayar_aktif,$loginpemakai_id,$saldoawal;
	public $tgl, $tgl_awal, $tgl_akhir, $format,$nama_rumahsakit,$ruangan_nama, $pegawai_nama,  $pegawaibatal_nama,$namaLengkap, $profilrs_id, $ruanganAsal, $instalasi_id,$instalasi_nama;

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'pengisiansaldoawal_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('shift_id, tglpengisiansaldo, nilaisaldoawal, pegawai_id, create_time, ruangan_id,profilrs_id', 'required'),
			array('shift_id, pegawai_id, kirim_pegawai_id,pegawaibatal_id', 'numerical', 'integerOnly'=>true),
			array('nilaisaldoawal', 'numerical'),
			// array('nama_rumahsakit, ruangan_nama', 'length', 'max'=>100),
			array('update_time, loginpemakai_id, kirim_tgl, keterangan,tglpembatalan,alasanpembatalan', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pengisiansaldoawal_id, tglpengisiansaldo, shift_id, nilaisaldoawal, pegawai_id, create_time, update_time, loginpemakai_id, kirim_tgl, kirim_pegawai_id,profilrs_id,ruangan_id, is_kirim', 'safe', 'on'=>'search'),
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
			'pegawaibatal' => array(self::BELONGS_TO, 'PegawaiM', 'pegawaibatal_id'),
			'shift' => array(self::BELONGS_TO, 'ShiftM', 'shift_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pengisiansaldoawal_id' => 'ID',
			'tglpengisiansaldo' => 'Tanggal Pengisian Saldo Awal',
			'tglpembatalan' => 'Tanggal Pembatalan',
			'shift_id' => 'Shift',
			'nilaisaldoawal' => 'Nilai Saldo Awal',
			'pegawai_id' => 'Pegawai',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'loginpemakai_id' => 'Login Pemakai',
			'nama_rumahsakit' => 'Nama Rumah Sakit',
			'ruangan_nama' => 'Ruangan Nama',
			'kirim_tgl' => 'Kirim Tgl',
			'kirim_pegawai_id' => 'Kirim Pegawai',
			'is_kirim' => 'Is Kirim',
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

		$criteria->compare('pengisiansaldoawal_id',$this->pengisiansaldoawal_id);
		$criteria->compare('tglpengisiansaldo',$this->tglpengisiansaldo,true);
		$criteria->compare('shift_id',$this->shift_id);
		$criteria->compare('nilaisaldoawal',$this->nilaisaldoawal);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('loginpemakai_id',$this->loginpemakai_id,true);
		$criteria->compare('nama_rumahsakit',$this->nama_rumahsakit,true);
		$criteria->compare('ruangan_nama',$this->ruangan_nama,true);
		$criteria->compare('kirim_tgl',$this->kirim_tgl,true);
		$criteria->compare('is_kirim',$this->is_kirim);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	public function getShiftItems(){
        $modShift = ShiftM::model()->findAllByAttributes(array('shift_aktif'=>true), array('order'=>'shift_jamawal'));
        return $modShift;
	}

	public function isClosing($pengisiansaldoawal_id=null){
		$criteria=new CDbCriteria;
		$criteria->addCondition('pengisiansaldoawal_id ='.$pengisiansaldoawal_id);
		$closing = ClosingkasirT::model()->findAll($criteria);
		if(!empty($closing)){
			return true;
		}else{
			return false;
		}
	}

	public function getRuanganNama(){
		$ruangan = RuanganM::model()->findByPk($this->ruangan_id);
		if(!empty($ruangan)){
			return $ruangan->ruangan_nama;
		}else{
			return '';
		}
	}

	public function getNamaRumasakit(){
		$rs = ProfilrumahsakitM::model()->findByPk($this->profilrs_id);
		if(!empty($rs)){
			return $rs->nama_rumahsakit;
		}else{
			return '';
		}
	}

	public function getDokter() {
        $pen = PendaftaranT::model()->findByPk($this->pendaftaran_id);

        if (!empty($pen)) {
            return $pen->pegawai->namaLengkap;
        } else {
            return '';
        }
    }
}