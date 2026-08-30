<?php

/**
 * This is the model class for table "hasilpemeriksaantindakan_t".
 *
 * The followings are the available columns in table 'hasilpemeriksaantindakan_t':
 * @property integer $hasilpemeriksaantindakan_id
 * @property integer $pegawai_id
 * @property integer $ruangan_id
 * @property integer $pasien_id
 * @property integer $tindakanpelayanan_id
 * @property integer $daftartindakan_id
 * @property integer $pendaftaran_id
 * @property integer $pasienmasukpenunjang_id
 * @property integer $pasienadmisi_id
 * @property string $tglpemeriksaantindakan
 * @property string $hasilpemeriksaantindakan
 * @property string $kesimpulantindakan
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 * @property string $tgl_dokfiletindakan
 * @property string $dokfiletindakan_filepath
 * @property string $upload_tanggal
 * @property string $dokfiletindakan_nama
 */
class HasilpemeriksaantindakanT extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'hasilpemeriksaantindakan_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pegawai_id, ruangan_id, pasien_id, tindakanpelayanan_id, daftartindakan_id, pendaftaran_id, pasienmasukpenunjang_id, pasienadmisi_id', 'numerical', 'integerOnly'=>true),
			array('dokfiletindakan_nama', 'length', 'max'=>100),
			array('tglpemeriksaantindakan, hasilpemeriksaantindakan, kesimpulantindakan, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, tgl_dokfiletindakan, dokfiletindakan_filepath, upload_tanggal', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('hasilpemeriksaantindakan_id, pegawai_id, ruangan_id, pasien_id, tindakanpelayanan_id, daftartindakan_id, pendaftaran_id, pasienmasukpenunjang_id, pasienadmisi_id, tglpemeriksaantindakan, hasilpemeriksaantindakan, kesimpulantindakan, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, tgl_dokfiletindakan, dokfiletindakan_filepath, upload_tanggal, dokfiletindakan_nama', 'safe', 'on'=>'search'),
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
			'daftartindakan' => array(self::BELONGS_TO, 'DaftartindakanM', 'daftartindakan_id'),
			'ruangan' => array(self::BELONGS_TO, 'RuanganM', 'ruangan_id'),
			'pegawai' => array(self::BELONGS_TO, 'PegawaiM', 'pegawai_id'),
			'pasienmasukpenunjang' => array(self::BELONGS_TO, 'PasienmasukpenunjangT', 'pasienmasukpenunjang_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'hasilpemeriksaantindakan_id' => 'Hasilpemeriksaantindakan',
			'pegawai_id' => 'Pegawai',
			'ruangan_id' => 'Ruangan',
			'pasien_id' => 'Pasien',
			'tindakanpelayanan_id' => 'Tindakanpelayanan',
			'daftartindakan_id' => 'Daftartindakan',
			'pendaftaran_id' => 'Pendaftaran',
			'pasienmasukpenunjang_id' => 'Pasienmasukpenunjang',
			'pasienadmisi_id' => 'Pasienadmisi',
			'tglpemeriksaantindakan' => 'Tglpemeriksaantindakan',
			'hasilpemeriksaantindakan' => 'Hasilpemeriksaantindakan',
			'kesimpulantindakan' => 'Kesimpulantindakan',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai_id' => 'Create Loginpemakai',
			'update_loginpemakai_id' => 'Update Loginpemakai',
			'create_ruangan' => 'Create Ruangan',
			'tgl_dokfiletindakan' => 'Tgl Dokfiletindakan',
			'dokfiletindakan_filepath' => 'Dokfiletindakan Filepath',
			'upload_tanggal' => 'Upload Tanggal',
			'dokfiletindakan_nama' => 'Dokfiletindakan Nama',
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

		$criteria->compare('hasilpemeriksaantindakan_id',$this->hasilpemeriksaantindakan_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('tindakanpelayanan_id',$this->tindakanpelayanan_id);
		$criteria->compare('daftartindakan_id',$this->daftartindakan_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('pasienmasukpenunjang_id',$this->pasienmasukpenunjang_id);
		$criteria->compare('pasienadmisi_id',$this->pasienadmisi_id);
		$criteria->compare('tglpemeriksaantindakan',$this->tglpemeriksaantindakan,true);
		$criteria->compare('hasilpemeriksaantindakan',$this->hasilpemeriksaantindakan,true);
		$criteria->compare('kesimpulantindakan',$this->kesimpulantindakan,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id,true);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id,true);
		$criteria->compare('create_ruangan',$this->create_ruangan,true);
		$criteria->compare('tgl_dokfiletindakan',$this->tgl_dokfiletindakan,true);
		$criteria->compare('dokfiletindakan_filepath',$this->dokfiletindakan_filepath,true);
		$criteria->compare('upload_tanggal',$this->upload_tanggal,true);
		$criteria->compare('dokfiletindakan_nama',$this->dokfiletindakan_nama,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function searchRiwayat()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		if(!empty($this->pendaftaran_id)) {
			$criteria->addCondition('pendaftaran_id = ' . $this->pendaftaran_id);
		}
		
		$criteria->order = 'tglpemeriksaantindakan desc';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return HasilpemeriksaantindakanT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
