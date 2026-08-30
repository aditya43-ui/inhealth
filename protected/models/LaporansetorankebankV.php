<?php

/**
 * This is the model class for table "laporansetorankebank_v".
 *
 * The followings are the available columns in table 'laporansetorankebank_v':
 * @property integer $setoranbdhara_id
 * @property integer $ruangan_id
 * @property string $ruangan_nama
 * @property integer $pegawai_id
 * @property string $nama_pegawai
 * @property integer $setorbank_id
 * @property string $nostruksetor
 * @property string $tgldisetor
 * @property string $namabank
 * @property string $atasnama
 * @property string $norekening
 * @property double $jumlahsetoran
 * @property integer $ygmenyetor_id
 * @property string $nama_ygmenyetor
 * @property string $nosetoranbdhara
 * @property string $tglsetoranbdhara
 * @property integer $mengetahui_id
 * @property string $nama_mengetahui
 * @property integer $rinciansetoranbdhara_id
 * @property integer $rekening5_id
 * @property double $jmlsetoranbdhara
 * @property integer $closingkasir_id
 * @property integer $shift_id
 * @property string $shift_nama
 * @property integer $pegawaiclosing_id
 * @property string $pegawaiclosing_nama
 * @property string $tglclosingkasir
 * @property string $closingdari
 * @property string $sampaidengan
 */
class LaporansetorankebankV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LaporansetorankebankV the static model class
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
		return 'laporansetorankebank_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('setoranbdhara_id, ruangan_id, pegawai_id, setorbank_id, ygmenyetor_id, mengetahui_id, rinciansetoranbdhara_id, rekening5_id, closingkasir_id, shift_id, pegawaiclosing_id', 'numerical', 'integerOnly'=>true),
			array('jumlahsetoran, jmlsetoranbdhara', 'numerical'),
			array('ruangan_nama, nama_pegawai, nama_ygmenyetor, nosetoranbdhara, nama_mengetahui, shift_nama, pegawaiclosing_nama', 'length', 'max'=>50),
			array('nostruksetor, namabank, atasnama, norekening', 'length', 'max'=>100),
			array('tgldisetor, tglsetoranbdhara, tglclosingkasir, closingdari, sampaidengan', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('setoranbdhara_id, ruangan_id, ruangan_nama, pegawai_id, nama_pegawai, setorbank_id, nostruksetor, tgldisetor, namabank, atasnama, norekening, jumlahsetoran, ygmenyetor_id, nama_ygmenyetor, nosetoranbdhara, tglsetoranbdhara, mengetahui_id, nama_mengetahui, rinciansetoranbdhara_id, rekening5_id, jmlsetoranbdhara, closingkasir_id, shift_id, shift_nama, pegawaiclosing_id, pegawaiclosing_nama, tglclosingkasir, closingdari, sampaidengan', 'safe', 'on'=>'search'),
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
			'setoranbdhara_id' => 'Setoranbdhara',
			'ruangan_id' => 'Ruangan',
			'ruangan_nama' => 'Ruangan Nama',
			'pegawai_id' => 'Pegawai',
			'nama_pegawai' => 'Nama Pegawai',
			'setorbank_id' => 'Setorbank',
			'nostruksetor' => 'Nostruksetor',
			'tgldisetor' => 'Tgldisetor',
			'namabank' => 'Namabank',
			'atasnama' => 'Atasnama',
			'norekening' => 'Norekening',
			'jumlahsetoran' => 'Jumlahsetoran',
			'ygmenyetor_id' => 'Ygmenyetor',
			'nama_ygmenyetor' => 'Nama Ygmenyetor',
			'nosetoranbdhara' => 'Nosetoranbdhara',
			'tglsetoranbdhara' => 'Tglsetoranbdhara',
			'mengetahui_id' => 'Mengetahui',
			'nama_mengetahui' => 'Nama Mengetahui',
			'rinciansetoranbdhara_id' => 'Rinciansetoranbdhara',
			'rekening5_id' => 'Rekening5',
			'jmlsetoranbdhara' => 'Jmlsetoranbdhara',
			'closingkasir_id' => 'Closingkasir',
			'shift_id' => 'Shift',
			'shift_nama' => 'Shift Nama',
			'pegawaiclosing_id' => 'Pegawaiclosing',
			'pegawaiclosing_nama' => 'Pegawaiclosing Nama',
			'tglclosingkasir' => 'Tglclosingkasir',
			'closingdari' => 'Closingdari',
			'sampaidengan' => 'Sampaidengan',
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

		$criteria->compare('setoranbdhara_id',$this->setoranbdhara_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('ruangan_nama',$this->ruangan_nama,true);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('nama_pegawai',$this->nama_pegawai,true);
		$criteria->compare('setorbank_id',$this->setorbank_id);
		$criteria->compare('nostruksetor',$this->nostruksetor,true);
		$criteria->compare('tgldisetor',$this->tgldisetor,true);
		$criteria->compare('namabank',$this->namabank,true);
		$criteria->compare('atasnama',$this->atasnama,true);
		$criteria->compare('norekening',$this->norekening,true);
		$criteria->compare('jumlahsetoran',$this->jumlahsetoran);
		$criteria->compare('ygmenyetor_id',$this->ygmenyetor_id);
		$criteria->compare('nama_ygmenyetor',$this->nama_ygmenyetor,true);
		$criteria->compare('nosetoranbdhara',$this->nosetoranbdhara,true);
		$criteria->compare('tglsetoranbdhara',$this->tglsetoranbdhara,true);
		$criteria->compare('mengetahui_id',$this->mengetahui_id);
		$criteria->compare('nama_mengetahui',$this->nama_mengetahui,true);
		$criteria->compare('rinciansetoranbdhara_id',$this->rinciansetoranbdhara_id);
		$criteria->compare('rekening5_id',$this->rekening5_id);
		$criteria->compare('jmlsetoranbdhara',$this->jmlsetoranbdhara);
		$criteria->compare('closingkasir_id',$this->closingkasir_id);
		$criteria->compare('shift_id',$this->shift_id);
		$criteria->compare('shift_nama',$this->shift_nama,true);
		$criteria->compare('pegawaiclosing_id',$this->pegawaiclosing_id);
		$criteria->compare('pegawaiclosing_nama',$this->pegawaiclosing_nama,true);
		$criteria->compare('tglclosingkasir',$this->tglclosingkasir,true);
		$criteria->compare('closingdari',$this->closingdari,true);
		$criteria->compare('sampaidengan',$this->sampaidengan,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}