<?php

/**
 * This is the model class for table "pendidikanpegawai_r".
 *
 * The followings are the available columns in table 'pendidikanpegawai_r':
 * @property integer $pendidikanpegawai_id
 * @property integer $kabupaten_id
 * @property integer $pegawai_id
 * @property integer $propinsi_id
 * @property string $jenispendidikan
 * @property integer $nourut_pend
 * @property string $namasek_univ
 * @property string $almtsek_univ
 * @property string $tglmasuk
 * @property string $tgllulus
 * @property integer $lamapendidikan_bln
 * @property string $no_ijazah_sert
 * @property string $tgl_ijazah_sert
 * @property string $ttd_ijazah_sert
 * @property double $nilailulus
 * @property string $gradelulus
 * @property string $keteranganpend
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 */
class PendidikanpegawaiR extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PendidikanpegawaiR the static model class
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
		return 'pendidikanpegawai_r';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pendidikan_id, pegawai_id, jenispendidikan, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('kabupaten_id, pegawai_id, propinsi_id, nourut_pend, lamapendidikan_bln', 'numerical', 'integerOnly'=>true),
			array('nilailulus', 'numerical'),
			array('jenispendidikan', 'length', 'max'=>50),
			array('namasek_univ', 'length', 'max'=>200),
			array('no_ijazah_sert, ttd_ijazah_sert', 'length', 'max'=>100),
			array('gradelulus', 'length', 'max'=>20),
			array('almtsek_univ, tglmasuk, tgllulus, tgl_ijazah_sert, keteranganpend, update_time, update_loginpemakai_id', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pendidikanpegawai_id, kabupaten_id, pegawai_id, propinsi_id, jenispendidikan, nourut_pend, namasek_univ, almtsek_univ, tglmasuk, tgllulus, lamapendidikan_bln, no_ijazah_sert, tgl_ijazah_sert, ttd_ijazah_sert, nilailulus, gradelulus, keteranganpend, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
                                    'pendidikan'=>array(self::BELONGS_TO,'PendidikanM','pendidikan_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pendidikanpegawai_id' => 'Pendidikan Pegawai',
			'kabupaten_id' => 'Kabupaten',
			'pegawai_id' => 'Pegawai',
			'propinsi_id' => 'Provinsi',
			'pendidikan_id' => 'Pendidikan',
			'jenispendidikan' => 'Jenis pendidikan',
			'nourut_pend' => 'No. Urut Penddidikan',
			'namasek_univ' => 'Nama Univ.',
			'almtsek_univ' => 'Alamat Univ.',
			'tglmasuk' => 'Tgl. Masuk',
			'tgllulus' => 'Tgl. Lulus',
			'lamapendidikan_bln' => 'Lama Pendidikan (Bulan)',
			'no_ijazah_sert' => 'No. Ijazah Sert',
			'tgl_ijazah_sert' => 'Tanggal Ijazah Sert',
			'ttd_ijazah_sert' => 'Ttd Ijazah Sert',
			'nilailulus' => 'Nilai Lulus',
			'gradelulus' => 'Grade Lulus',
			'keteranganpend' => 'Keterangan',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
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

		$criteria->compare('pendidikanpegawai_id',$this->pendidikanpegawai_id);
		$criteria->compare('kabupaten_id',$this->kabupaten_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('propinsi_id',$this->propinsi_id);
		$criteria->compare('LOWER(jenispendidikan)',strtolower($this->jenispendidikan),true);
		$criteria->compare('nourut_pend',$this->nourut_pend);
		$criteria->compare('LOWER(namasek_univ)',strtolower($this->namasek_univ),true);
		$criteria->compare('LOWER(almtsek_univ)',strtolower($this->almtsek_univ),true);
		$criteria->compare('LOWER(tglmasuk)',strtolower($this->tglmasuk),true);
		$criteria->compare('LOWER(tgllulus)',strtolower($this->tgllulus),true);
		$criteria->compare('lamapendidikan_bln',$this->lamapendidikan_bln);
		$criteria->compare('LOWER(no_ijazah_sert)',strtolower($this->no_ijazah_sert),true);
		$criteria->compare('LOWER(tgl_ijazah_sert)',strtolower($this->tgl_ijazah_sert),true);
		$criteria->compare('LOWER(ttd_ijazah_sert)',strtolower($this->ttd_ijazah_sert),true);
		$criteria->compare('nilailulus',$this->nilailulus);
		$criteria->compare('LOWER(gradelulus)',strtolower($this->gradelulus),true);
		$criteria->compare('LOWER(keteranganpend)',strtolower($this->keteranganpend),true);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('pendidikanpegawai_id',$this->pendidikanpegawai_id);
		$criteria->compare('kabupaten_id',$this->kabupaten_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('propinsi_id',$this->propinsi_id);
		$criteria->compare('LOWER(jenispendidikan)',strtolower($this->jenispendidikan),true);
		$criteria->compare('nourut_pend',$this->nourut_pend);
		$criteria->compare('LOWER(namasek_univ)',strtolower($this->namasek_univ),true);
		$criteria->compare('LOWER(almtsek_univ)',strtolower($this->almtsek_univ),true);
		$criteria->compare('LOWER(tglmasuk)',strtolower($this->tglmasuk),true);
		$criteria->compare('LOWER(tgllulus)',strtolower($this->tgllulus),true);
		$criteria->compare('lamapendidikan_bln',$this->lamapendidikan_bln);
		$criteria->compare('LOWER(no_ijazah_sert)',strtolower($this->no_ijazah_sert),true);
		$criteria->compare('LOWER(tgl_ijazah_sert)',strtolower($this->tgl_ijazah_sert),true);
		$criteria->compare('LOWER(ttd_ijazah_sert)',strtolower($this->ttd_ijazah_sert),true);
		$criteria->compare('nilailulus',$this->nilailulus);
		$criteria->compare('LOWER(gradelulus)',strtolower($this->gradelulus),true);
		$criteria->compare('LOWER(keteranganpend)',strtolower($this->keteranganpend),true);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
        
        public function getPendidikanItems() {
            return PendidikanM::model()->findAll('pendidikan_aktif=TRUE ORDER BY Pendidikan_nama');
        }
}