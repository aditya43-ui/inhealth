<?php

/**
 * This is the model class for table "laporanrekapsayhello_v".
 *
 * The followings are the available columns in table 'laporanrekapsayhello_v':
 * @property integer $pendaftaran
 * @property string $tgl_sayhello
 * @property string $nama
 * @property string $tgl_krs
 * @property string $alamat
 * @property integer $ruang
 * @property string $diagnosa
 * @property string $kondisi_pasien
 * @property string $kesimpulan
 */
class LaporanrekapsayhelloV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LaporanrekapsayhelloV the static model class
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
		return 'laporanrekapsayhello_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pendaftaran, ruang', 'numerical', 'integerOnly'=>true),
			array('diagnosa', 'length', 'max'=>200),
			array('kesimpulan', 'length', 'max'=>100),
			array('tgl_sayhello, nama, tgl_krs, alamat, kondisi_pasien', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pendaftaran, tgl_sayhello, nama, tgl_krs, alamat, ruang, diagnosa, kondisi_pasien, kesimpulan', 'safe', 'on'=>'search'),
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
			'pendaftaran' => 'Pendaftaran',
			'tgl_sayhello' => 'Tgl. Say Hello',
			'nama' => 'Nama',
			'tgl_krs' => 'Tgl. KRS',
			'alamat' => 'Alamat',
			'ruang' => 'Ruang',
			'diagnosa' => 'Diagnosa',
			'kondisi_pasien' => 'Kondisi Pasien',
			'kesimpulan' => 'Kesimpulan',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CdbCriteria that can return criterias.
	 */
	public function criteriaSearch()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		if(!empty($this->pendaftaran)){
			$criteria->addCondition('pendaftaran = '.$this->pendaftaran);
		}
		$criteria->compare('LOWER(tgl_sayhello)',strtolower($this->tgl_sayhello),true);
		$criteria->compare('LOWER(nama)',strtolower($this->nama),true);
		$criteria->compare('LOWER(tgl_krs)',strtolower($this->tgl_krs),true);
		$criteria->compare('LOWER(alamat)',strtolower($this->alamat),true);
		if(!empty($this->ruang)){
			$criteria->addCondition('ruang = '.$this->ruang);
		}
		$criteria->compare('LOWER(diagnosa)',strtolower($this->diagnosa),true);
		$criteria->compare('LOWER(kondisi_pasien)',strtolower($this->kondisi_pasien),true);
		$criteria->compare('LOWER(kesimpulan)',strtolower($this->kesimpulan),true);

		return $criteria;
	}
        
        
        /**
         * Retrieves a list of models based on the current search/filter conditions.
         * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
         */
        public function search()
        {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=$this->criteriaSearch();
            $criteria->limit=10;

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
        }


        public function searchPrint()
        {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=$this->criteriaSearch();
            $criteria->limit=-1; 

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
                    'pagination'=>false,
            ));
        }
}