<?php

/**
 * This is the model class for table "pendidikankualifikasi_m".
 *
 * The followings are the available columns in table 'pendidikankualifikasi_m':
 * @property integer $pendkualifikasi_id
 * @property string $pendkualifikasi_kode
 * @property string $pendkualifikasi_nama
 * @property string $pendkualifikasi_namalainnya
 * @property string $pendkualifikasi_keterangan
 * @property boolean $pendkualifikasi_aktif
 */
class PendidikankualifikasiM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PendidikankualifikasiM the static model class
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
		return 'pendidikankualifikasi_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pendkualifikasi_nama, pendkualifikasi_aktif, kelompokpegawai_id, pendidikan_id, jmlkeblaki, jmlkebperempuan', 'required'),
			array('pendkualifikasi_kode', 'length', 'max'=>10),
			array('pendkualifikasi_nama, pendkualifikasi_namalainnya', 'length', 'max'=>50),
			array('pendkualifikasi_keterangan, jmlkeblaki, jmlkebperempuan, pendidikan_id, kelompokpegawai_id', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('jmlkeblaki, jmlkebperempuan, pendidikan_id, kelompokpegawai_id,pendkualifikasi_id, pendkualifikasi_kode, pendkualifikasi_nama, pendkualifikasi_namalainnya, pendkualifikasi_keterangan, pendkualifikasi_aktif', 'safe', 'on'=>'search'),
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
			'pendkualifikasi_id' => 'ID',
			'pendkualifikasi_kode' => ' Kode',
			'pendkualifikasi_nama' => ' Kualifikasi Pendidikan',
			'pendkualifikasi_namalainnya' => ' Nama Lainnya',
			'pendkualifikasi_keterangan' => ' Keterangan',
			'jmlkeblaki' => ' Jumlah Kebutuhan Laki-laki',
			'jmlkebperempuan' => ' Jumlah Kebutuhan Perempuan',
			'pendkualifikasi_aktif' => ' Aktif',
			'pendidikan_id' => 'Pendidikan',
			'kelompokpegawai_id' => 'Kelompok Pegawai',
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

		$criteria->compare('pendkualifikasi_id',$this->pendkualifikasi_id);
		$criteria->compare('LOWER(pendkualifikasi_kode)',strtolower($this->pendkualifikasi_kode),true);
		$criteria->compare('LOWER(pendkualifikasi_nama)',strtolower($this->pendkualifikasi_nama),true);
		$criteria->compare('LOWER(pendkualifikasi_namalainnya)',strtolower($this->pendkualifikasi_namalainnya),true);
		$criteria->compare('LOWER(pendkualifikasi_keterangan)',strtolower($this->pendkualifikasi_keterangan),true);
		$criteria->compare('pendkualifikasi_aktif',isset($this->pendkualifikasi_aktif)?$this->pendkualifikasi_aktif:true);
//                $criteria->addCondition('pendkualifikasi_aktif is true');

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('pendkualifikasi_id',$this->pendkualifikasi_id);
		$criteria->compare('LOWER(pendkualifikasi_kode)',strtolower($this->pendkualifikasi_kode),true);
		$criteria->compare('LOWER(pendkualifikasi_nama)',strtolower($this->pendkualifikasi_nama),true);
		$criteria->compare('LOWER(pendkualifikasi_namalainnya)',strtolower($this->pendkualifikasi_namalainnya),true);
		$criteria->compare('LOWER(pendkualifikasi_keterangan)',strtolower($this->pendkualifikasi_keterangan),true);
//		$criteria->compare('pendkualifikasi_aktif',$this->pendkualifikasi_aktif);


                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
        
        public function beforeSave() {
            $this->pendkualifikasi_nama=ucwords(strtolower($this->pendkualifikasi_nama));
            $this->pendkualifikasi_namalainnya = strtoupper($this->pendkualifikasi_namalainnya);
            return parent::beforeSave();
        }
}