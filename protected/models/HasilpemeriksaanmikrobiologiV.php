<?php

/**
 * This is the model class for table "hasilpemeriksaanmikrobiologi_v".
 *
 * The followings are the available columns in table 'hasilpemeriksaanmikrobiologi_v':
 * @property integer $pendaftaran_id
 * @property string $tgl_pemeriksaan
 * @property string $no_lab
 * @property string $nama_pasien
 * @property string $no_rekam_medik
 * @property string $gelardepan
 * @property integer $dpjp_id
 * @property string $nama_dpjp
 * @property integer $gelarbelakang_id
 * @property string $gelarbelakang_nama
 * @property integer $daftartindakan_id
 * @property string $daftartindakan_nama
 * @property integer $samplelab_id
 * @property string $samplelab_nama
 * @property integer $carabayar_id
 * @property string $carabayar_nama
 * @property boolean $is_pemeriksaankultur
 * @property boolean $is_pemeriksaanpewarnaan
 * @property boolean $is_pemeriksaancci
 * @property boolean $is_pemeriksaanpcr
 * @property boolean $is_pemeriksaanviralload
 * @property boolean $is_pemeriksaantbc
 * @property string $pemeriksaan
 * @property boolean $is_kirimhasil
 */
class HasilpemeriksaanmikrobiologiV extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */

	public $tgl_awal, $tgl_akhir;

	public function tableName()
	{
		return 'hasilpemeriksaanmikrobiologi_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pendaftaran_id, dpjp_id, gelarbelakang_id, daftartindakan_id, samplelab_id, carabayar_id', 'numerical', 'integerOnly'=>true),
			array('no_lab, nama_pasien', 'length', 'max'=>100),
			array('no_rekam_medik', 'length', 'max'=>10),
			array('gelardepan', 'length', 'max'=>16),
			array('nama_dpjp, samplelab_nama, carabayar_nama', 'length', 'max'=>50),
			array('gelarbelakang_nama', 'length', 'max'=>20),
			array('daftartindakan_nama', 'length', 'max'=>400),
			array('tgl_pemeriksaan, is_pemeriksaankultur, is_pemeriksaanpewarnaan, is_pemeriksaancci, is_pemeriksaanpcr, is_pemeriksaanviralload, is_pemeriksaantbc, pemeriksaan, is_kirimhasil', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('pendaftaran_id, tgl_pemeriksaan, no_lab, nama_pasien, no_rekam_medik, gelardepan, dpjp_id, nama_dpjp, gelarbelakang_id, gelarbelakang_nama, daftartindakan_id, daftartindakan_nama, samplelab_id, samplelab_nama, carabayar_id, carabayar_nama, is_pemeriksaankultur, is_pemeriksaanpewarnaan, is_pemeriksaancci, is_pemeriksaanpcr, is_pemeriksaanviralload, is_pemeriksaantbc, pemeriksaan, is_kirimhasil', 'safe', 'on'=>'search'),
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
			'pendaftaran_id' => 'Pendaftaran',
			'tgl_pemeriksaan' => 'Tgl Pemeriksaan',
			'no_lab' => 'No Lab',
			'nama_pasien' => 'Nama Pasien',
			'no_rekam_medik' => 'No Rekam Medik',
			'gelardepan' => 'Gelardepan',
			'dpjp_id' => 'Dpjp',
			'nama_dpjp' => 'Nama Dpjp',
			'gelarbelakang_id' => 'Gelarbelakang',
			'gelarbelakang_nama' => 'Gelarbelakang Nama',
			'daftartindakan_id' => 'Daftartindakan',
			'daftartindakan_nama' => 'Daftartindakan Nama',
			'samplelab_id' => 'Samplelab',
			'samplelab_nama' => 'Samplelab Nama',
			'carabayar_id' => 'Carabayar',
			'carabayar_nama' => 'Carabayar Nama',
			'is_pemeriksaankultur' => 'Is Pemeriksaankultur',
			'is_pemeriksaanpewarnaan' => 'Is Pemeriksaanpewarnaan',
			'is_pemeriksaancci' => 'Is Pemeriksaancci',
			'is_pemeriksaanpcr' => 'Is Pemeriksaanpcr',
			'is_pemeriksaanviralload' => 'Is Pemeriksaanviralload',
			'is_pemeriksaantbc' => 'Is Pemeriksaantbc',
			'pemeriksaan' => 'Pemeriksaan',
			'is_kirimhasil' => 'Is Kirimhasil',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('tgl_pemeriksaan',$this->tgl_pemeriksaan,true);
		$criteria->compare('no_lab',$this->no_lab,true);
		$criteria->compare('nama_pasien',$this->nama_pasien,true);
		$criteria->compare('no_rekam_medik',$this->no_rekam_medik,true);
		$criteria->compare('gelardepan',$this->gelardepan,true);
		$criteria->compare('dpjp_id',$this->dpjp_id);
		$criteria->compare('nama_dpjp',$this->nama_dpjp,true);
		$criteria->compare('gelarbelakang_id',$this->gelarbelakang_id);
		$criteria->compare('gelarbelakang_nama',$this->gelarbelakang_nama,true);
		$criteria->compare('daftartindakan_id',$this->daftartindakan_id);
		$criteria->compare('daftartindakan_nama',$this->daftartindakan_nama,true);
		$criteria->compare('samplelab_id',$this->samplelab_id);
		$criteria->compare('samplelab_nama',$this->samplelab_nama,true);
		$criteria->compare('carabayar_id',$this->carabayar_id);
		$criteria->compare('carabayar_nama',$this->carabayar_nama,true);
		$criteria->compare('is_pemeriksaankultur',$this->is_pemeriksaankultur);
		$criteria->compare('is_pemeriksaanpewarnaan',$this->is_pemeriksaanpewarnaan);
		$criteria->compare('is_pemeriksaancci',$this->is_pemeriksaancci);
		$criteria->compare('is_pemeriksaanpcr',$this->is_pemeriksaanpcr);
		$criteria->compare('is_pemeriksaanviralload',$this->is_pemeriksaanviralload);
		$criteria->compare('is_pemeriksaantbc',$this->is_pemeriksaantbc);
		$criteria->compare('pemeriksaan',$this->pemeriksaan,true);
		$criteria->compare('is_kirimhasil',$this->is_kirimhasil);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function searchHasil()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);

		$criteria->addBetweenCondition('DATE(t.tgl_pemeriksaan)', $this->tgl_awal, $this->tgl_akhir);

		$criteria->compare('LOWER(no_lab)',strtolower($this->no_lab),true);
		$criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);
		$criteria->compare('no_rekam_medik',$this->no_rekam_medik,true);
		$criteria->compare('gelardepan',$this->gelardepan,true);
		$criteria->compare('dpjp_id',$this->dpjp_id);
		$criteria->compare('LOWER(nama_dpjp)',strtolower($this->nama_dpjp),true);
		$criteria->compare('gelarbelakang_id',$this->gelarbelakang_id);
		$criteria->compare('gelarbelakang_nama',$this->gelarbelakang_nama,true);
		$criteria->compare('daftartindakan_id',$this->daftartindakan_id);
		$criteria->compare('LOWER(daftartindakan_nama)',strtolower($this->daftartindakan_nama),true);
		$criteria->compare('samplelab_id',$this->samplelab_id);
		$criteria->compare('LOWER(samplelab_nama)',strtolower($this->samplelab_nama),true);
		$criteria->compare('carabayar_id',$this->carabayar_id);
		$criteria->compare('LOWER(carabayar_nama)',strtolower($this->carabayar_nama),true);
		$criteria->compare('is_pemeriksaankultur',$this->is_pemeriksaankultur);
		$criteria->compare('is_pemeriksaanpewarnaan',$this->is_pemeriksaanpewarnaan);
		$criteria->compare('is_pemeriksaancci',$this->is_pemeriksaancci);
		$criteria->compare('is_pemeriksaanpcr',$this->is_pemeriksaanpcr);
		$criteria->compare('is_pemeriksaanviralload',$this->is_pemeriksaanviralload);
		$criteria->compare('is_pemeriksaantbc',$this->is_pemeriksaantbc);
		$criteria->compare('LOWER(pemeriksaan)',strtolower($this->pemeriksaan),true);
		$criteria->compare('is_kirimhasil',$this->is_kirimhasil);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function getNamaLengkap()
    {
        return (isset($this->gelardepan) ? $this->gelardepan : "").' '.$this->nama_dpjp.(isset($this->gelarbelakang_nama) ? ', '.$this->gelarbelakang_nama : "");
    }


	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return HasilpemeriksaanmikrobiologiV the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
