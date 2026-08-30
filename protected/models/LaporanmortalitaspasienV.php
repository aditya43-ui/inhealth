<?php

/**
 * This is the model class for table "laporanmortalitaspasien_v".
 *
 * The followings are the available columns in table 'laporanmortalitaspasien_v':
 * @property integer $pasien_id
 * @property integer $pendaftaran_id
 * @property string $tglmorbiditas
 * @property string $kasusdiagnosa
 * @property integer $umur_0_28hr
 * @property integer $umur_28hr_1thn
 * @property integer $umur_1_4thn
 * @property integer $umur_5_14thn
 * @property integer $umur_15_24thn
 * @property integer $umur_25_44thn
 * @property integer $umur_45_64thn
 * @property integer $umur_65
 * @property integer $diagnosa_id
 * @property string $diagnosa_kode
 * @property string $diagnosa_nama
 * @property string $diagnosa_namalainnya
 * @property integer $diagnosa_nourut
 * @property integer $golonganumur_id
 * @property string $kondisipulang
 * @property string $carakeluar
 */
class LaporanmortalitaspasienV extends CActiveRecord
{
        public $data, $jumlah, $tick; //attributes untuk table
        public $tgl_awal, $tgl_akhir;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LaporanmortalitaspasienV the static model class
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
		return 'laporanmortalitaspasien_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pasien_id, pendaftaran_id, umur_0_28hr, umur_28hr_1thn, umur_1_4thn, umur_5_14thn, umur_15_24thn, umur_25_44thn, umur_45_64thn, umur_65, diagnosa_id, diagnosa_nourut, golonganumur_id', 'numerical', 'integerOnly'=>true),
			array('kasusdiagnosa', 'length', 'max'=>20),
			array('diagnosa_kode', 'length', 'max'=>10),
			array('diagnosa_nama', 'length', 'max'=>100),
			array('diagnosa_namalainnya, kondisipulang, carakeluar', 'length', 'max'=>50),
			array('tglmorbiditas', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('tgl_awal, tgl_akhir, pasien_id, pendaftaran_id, tglmorbiditas, kasusdiagnosa, umur_0_28hr, umur_28hr_1thn, umur_1_4thn, umur_5_14thn, umur_15_24thn, umur_25_44thn, umur_45_64thn, umur_65, diagnosa_id, diagnosa_kode, diagnosa_nama, diagnosa_namalainnya, diagnosa_nourut, golonganumur_id, kondisipulang, carakeluar', 'safe', 'on'=>'search'),
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
			'pasien_id' => 'Pasien',
			'pendaftaran_id' => 'Pendaftaran',
			'tglmorbiditas' => 'Tglmorbiditas',
			'kasusdiagnosa' => 'Kasusdiagnosa',
			'umur_0_28hr' => '0 - 28hr',
			'umur_28hr_1thn' => '28hr - 1thn',
			'umur_1_4thn' => '1 - 4thn',
			'umur_5_14thn' => '5 - 14thn',
			'umur_15_24thn' => '15 - 24thn',
			'umur_25_44thn' => '25 - 44thn',
			'umur_45_64thn' => '45 - 64thn',
			'umur_65' => '65thn',
			'diagnosa_id' => 'Diagnosa',
			'diagnosa_kode' => 'Diagnosa Kode',
			'diagnosa_nama' => 'Nama Diagnosa',
			'diagnosa_namalainnya' => 'Diagnosa Namalainnya',
			'diagnosa_nourut' => 'Diagnosa Nourut',
			'golonganumur_id' => 'Golonganumur',
			'kondisipulang' => 'Kondisipulang',
			'carakeluar' => 'Carakeluar',
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

		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('LOWER(tglmorbiditas)',strtolower($this->tglmorbiditas),true);
		$criteria->compare('LOWER(kasusdiagnosa)',strtolower($this->kasusdiagnosa),true);
		$criteria->compare('umur_0_28hr',$this->umur_0_28hr);
		$criteria->compare('umur_28hr_1thn',$this->umur_28hr_1thn);
		$criteria->compare('umur_1_4thn',$this->umur_1_4thn);
		$criteria->compare('umur_5_14thn',$this->umur_5_14thn);
		$criteria->compare('umur_15_24thn',$this->umur_15_24thn);
		$criteria->compare('umur_25_44thn',$this->umur_25_44thn);
		$criteria->compare('umur_45_64thn',$this->umur_45_64thn);
		$criteria->compare('umur_65',$this->umur_65);
		$criteria->compare('diagnosa_id',$this->diagnosa_id);
		$criteria->compare('LOWER(diagnosa_kode)',strtolower($this->diagnosa_kode),true);
		$criteria->compare('LOWER(diagnosa_nama)',strtolower($this->diagnosa_nama),true);
		$criteria->compare('LOWER(diagnosa_namalainnya)',strtolower($this->diagnosa_namalainnya),true);
		$criteria->compare('diagnosa_nourut',$this->diagnosa_nourut);
		$criteria->compare('golonganumur_id',$this->golonganumur_id);
		$criteria->compare('LOWER(kondisipulang)',strtolower($this->kondisipulang),true);
		$criteria->compare('LOWER(carakeluar)',strtolower($this->carakeluar),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('LOWER(tglmorbiditas)',strtolower($this->tglmorbiditas),true);
		$criteria->compare('LOWER(kasusdiagnosa)',strtolower($this->kasusdiagnosa),true);
		$criteria->compare('umur_0_28hr',$this->umur_0_28hr);
		$criteria->compare('umur_28hr_1thn',$this->umur_28hr_1thn);
		$criteria->compare('umur_1_4thn',$this->umur_1_4thn);
		$criteria->compare('umur_5_14thn',$this->umur_5_14thn);
		$criteria->compare('umur_15_24thn',$this->umur_15_24thn);
		$criteria->compare('umur_25_44thn',$this->umur_25_44thn);
		$criteria->compare('umur_45_64thn',$this->umur_45_64thn);
		$criteria->compare('umur_65',$this->umur_65);
		$criteria->compare('diagnosa_id',$this->diagnosa_id);
		$criteria->compare('LOWER(diagnosa_kode)',strtolower($this->diagnosa_kode),true);
		$criteria->compare('LOWER(diagnosa_nama)',strtolower($this->diagnosa_nama),true);
		$criteria->compare('LOWER(diagnosa_namalainnya)',strtolower($this->diagnosa_namalainnya),true);
		$criteria->compare('diagnosa_nourut',$this->diagnosa_nourut);
		$criteria->compare('golonganumur_id',$this->golonganumur_id);
		$criteria->compare('LOWER(kondisipulang)',strtolower($this->kondisipulang),true);
		$criteria->compare('LOWER(carakeluar)',strtolower($this->carakeluar),true);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
}