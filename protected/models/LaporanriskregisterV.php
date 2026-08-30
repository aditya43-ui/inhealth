<?php

/**
 * This is the model class for table "laporanriskregister_v".
 *
 * @author  Andyka Putra <andykaputra@.com>
 * @package application.models
 * 
 * The followings are the available columns in table 'laporanriskregister_v':
 * @property integer $identifikasiresiko_id
 * @property integer $ruangan_id
 * @property integer $perioderiskregister_id
 * @property string $nama_perioderiskregister
 * @property string $sumber_resiko
 * @property string $deskripsiresiko
 * @property string $penyebabresiko
 * @property integer $tiperesiko_id
 * @property integer $subtiperesiko_id
 * @property string $kategoriresiko
 * @property integer $konsekuensi_id
 * @property integer $konsekuensi_bobot
 * @property integer $peluang_id
 * @property integer $peluang_bobotdescriptor
 * @property integer $detectability_id
 * @property integer $detectability_bobot
 * @property integer $rpn_score
 * @property integer $tingkatrisiko_id
 * @property string $tingkatrisiko_nama
 * @property integer $evaluasiidentifikasirisiko_id
 * @property string $evaluasi_risiko
 * @property string $riskrespon
 * @property string $tgl_tinjauan
 * @property integer $pegawai_id
 * @property string $nama_pegawai
 * @property integer $progressmonevindentifikasirisiko_id
 * @property integer $rpn_sisa
 * @property string $laporansingkat
 * @property string $status_riskregister
 */
class LaporanriskregisterV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LaporanriskregisterV the static model class
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
		return 'laporanriskregister_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('identifikasiresiko_id, ruangan_id, perioderiskregister_id, tiperesiko_id, subtiperesiko_id, konsekuensi_id, konsekuensi_bobot, peluang_id, peluang_bobotdescriptor, detectability_id, detectability_bobot, rpn_score, tingkatrisiko_id, evaluasiidentifikasirisiko_id, pegawai_id, progressmonevindentifikasirisiko_id, rpn_sisa', 'numerical', 'integerOnly'=>true),
			array('nama_perioderiskregister, tingkatrisiko_nama', 'length', 'max'=>150),
			array('sumber_resiko, evaluasi_risiko', 'length', 'max'=>100),
			array('nama_pegawai, status_riskregister', 'length', 'max'=>50),
			array('deskripsiresiko, penyebabresiko, kategoriresiko, riskrespon, tgl_tinjauan, laporansingkat', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('identifikasiresiko_id, ruangan_id, instalasi_id, perioderiskregister_id, nama_perioderiskregister, sumber_resiko, deskripsiresiko, penyebabresiko, tiperesiko_id, subtiperesiko_id, kategoriresiko, konsekuensi_id, konsekuensi_bobot, peluang_id, peluang_bobotdescriptor, detectability_id, detectability_bobot, rpn_score, tingkatrisiko_id, tingkatrisiko_nama, evaluasiidentifikasirisiko_id, evaluasi_risiko, riskrespon, tgl_tinjauan, pegawai_id, nama_pegawai, progressmonevindentifikasirisiko_id, rpn_sisa, laporansingkat, status_riskregister', 'safe', 'on'=>'search'),
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
			'identifikasiresiko_id' => 'Identifikasiresiko',
			'ruangan_id' => 'Ruangan',
			'perioderiskregister_id' => 'Perioderiskregister',
			'nama_perioderiskregister' => 'Nama Perioderiskregister',
			'sumber_resiko' => 'Sumber Resiko',
			'deskripsiresiko' => 'Deskripsiresiko',
			'penyebabresiko' => 'Penyebabresiko',
			'tiperesiko_id' => 'Tiperesiko',
			'subtiperesiko_id' => 'Subtiperesiko',
			'kategoriresiko' => 'Kategoriresiko',
			'konsekuensi_id' => 'Konsekuensi',
			'konsekuensi_bobot' => 'Konsekuensi Bobot',
			'peluang_id' => 'Peluang',
			'peluang_bobotdescriptor' => 'Peluang Bobotdescriptor',
			'detectability_id' => 'Detectability',
			'detectability_bobot' => 'Detectability Bobot',
			'rpn_score' => 'Rpn Score',
			'tingkatrisiko_id' => 'Tingkatrisiko',
			'tingkatrisiko_nama' => 'Tingkatrisiko Nama',
			'evaluasiidentifikasirisiko_id' => 'Evaluasiidentifikasirisiko',
			'evaluasi_risiko' => 'Evaluasi Risiko',
			'riskrespon' => 'Riskrespon',
			'tgl_tinjauan' => 'Tgl Tinjauan',
			'pegawai_id' => 'Pegawai',
			'nama_pegawai' => 'Nama Pegawai',
			'progressmonevindentifikasirisiko_id' => 'Progressmonevindentifikasirisiko',
			'rpn_sisa' => 'Rpn Sisa',
			'laporansingkat' => 'Laporansingkat',
			'status_riskregister' => 'Status Riskregister',
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

		$criteria->compare('identifikasiresiko_id',$this->identifikasiresiko_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('perioderiskregister_id',$this->perioderiskregister_id);
		$criteria->compare('nama_perioderiskregister',$this->nama_perioderiskregister,true);
		$criteria->compare('sumber_resiko',$this->sumber_resiko,true);
		$criteria->compare('deskripsiresiko',$this->deskripsiresiko,true);
		$criteria->compare('penyebabresiko',$this->penyebabresiko,true);
		$criteria->compare('tiperesiko_id',$this->tiperesiko_id);
		$criteria->compare('subtiperesiko_id',$this->subtiperesiko_id);
		$criteria->compare('kategoriresiko',$this->kategoriresiko,true);
		$criteria->compare('konsekuensi_id',$this->konsekuensi_id);
		$criteria->compare('konsekuensi_bobot',$this->konsekuensi_bobot);
		$criteria->compare('peluang_id',$this->peluang_id);
		$criteria->compare('peluang_bobotdescriptor',$this->peluang_bobotdescriptor);
		$criteria->compare('detectability_id',$this->detectability_id);
		$criteria->compare('detectability_bobot',$this->detectability_bobot);
		$criteria->compare('rpn_score',$this->rpn_score);
		$criteria->compare('tingkatrisiko_id',$this->tingkatrisiko_id);
		$criteria->compare('tingkatrisiko_nama',$this->tingkatrisiko_nama,true);
		$criteria->compare('evaluasiidentifikasirisiko_id',$this->evaluasiidentifikasirisiko_id);
		$criteria->compare('evaluasi_risiko',$this->evaluasi_risiko,true);
		$criteria->compare('riskrespon',$this->riskrespon,true);
		$criteria->compare('tgl_tinjauan',$this->tgl_tinjauan,true);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('nama_pegawai',$this->nama_pegawai,true);
		$criteria->compare('progressmonevindentifikasirisiko_id',$this->progressmonevindentifikasirisiko_id);
		$criteria->compare('rpn_sisa',$this->rpn_sisa);
		$criteria->compare('laporansingkat',$this->laporansingkat,true);
		$criteria->compare('status_riskregister',$this->status_riskregister,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
    /**
     * Load data periode risk
     * @return \PerioderiskregisterM
     */
    public function getPeriodeResikoItems()
    {
        return PerioderiskregisterM::model()->findAll('perioderiskregister_aktif=TRUE order by nama_perioderiskregister');
    }
    
    public function getTingkatResikoItems()
    {
        return TingkatrisikoRiskregisterM::model()->findAll('tingkatrisiko_aktif=TRUE order by tingkatrisiko_nama asc');
    }
}