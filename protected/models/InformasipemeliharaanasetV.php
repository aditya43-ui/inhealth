<?php

/**
 * This is the model class for table "informasipemeliharaanaset_v".
 *
 * The followings are the available columns in table 'informasipemeliharaanaset_v':
 * @property integer $pemeliharaanaset_id
 * @property string $pemeliharaanaset_no
 * @property string $pemeliharaanaset_tgl
 * @property string $pemeliharaanaset_ket
 * @property integer $pegawaimengetahui_id
 * @property string $pegawaimengetahui_nama
 * @property string $gelarbelakang_pegawaimengetahui
 * @property string $gelarbelakang_pegtugas1
 * @property string $gelarbelakang_pegtugas2
 * @property integer $gelarbelakangpegawaimengetahui_id
 * @property integer $gelarbelakangpegtugas1_id
 * @property integer $gelarbelakangpegtugas2_id
 * @property integer $pegtugas1_id
 * @property string $pegtugas1_nama
 * @property string $gelardepan_pegawaimengetahui
 * @property string $gelardepan_pegtugas1
 * @property string $gelardepan_pegtugas2
 * @property string $pegtugas2_nama
 * @property integer $pegtugas2_id
 * @property string $noinduk_pegawaimengetahui
 * @property string $noinduk_pegtugas1
 * @property string $noinduk_pegtugas2
 * @property string $noidentitas_pegawaimengetahui
 * @property string $noidentitas_pegtugas1
 * @property string $noidentitas_pegtugas2
 * @property string $jenisidentitas_pegtugas2
 * @property string $jenisidentitas_pegtugas1
 * @property string $jenisidentitas_pegawaimengetahui
 */
class InformasipemeliharaanasetV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InformasipemeliharaanasetV the static model class
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
		return 'informasipemeliharaanaset_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pemeliharaanaset_id, pegawaimengetahui_id, gelarbelakangpegawaimengetahui_id, gelarbelakangpegtugas1_id, gelarbelakangpegtugas2_id, pegtugas1_id, pegtugas2_id', 'numerical', 'integerOnly'=>true),
			array('pemeliharaanaset_no, jenisidentitas_pegtugas2, jenisidentitas_pegtugas1, jenisidentitas_pegawaimengetahui', 'length', 'max'=>20),
			array('pegawaimengetahui_nama, pegtugas1_nama, pegtugas2_nama', 'length', 'max'=>50),
			array('gelarbelakang_pegawaimengetahui, gelarbelakang_pegtugas1, gelarbelakang_pegtugas2', 'length', 'max'=>15),
			array('gelardepan_pegawaimengetahui, gelardepan_pegtugas1, gelardepan_pegtugas2', 'length', 'max'=>10),
			array('noinduk_pegawaimengetahui, noinduk_pegtugas1, noinduk_pegtugas2', 'length', 'max'=>30),
			array('noidentitas_pegawaimengetahui, noidentitas_pegtugas1, noidentitas_pegtugas2', 'length', 'max'=>100),
			array('pemeliharaanaset_tgl, pemeliharaanaset_ket', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pemeliharaanaset_id, pemeliharaanaset_no, pemeliharaanaset_tgl, pemeliharaanaset_ket, pegawaimengetahui_id, pegawaimengetahui_nama, gelarbelakang_pegawaimengetahui, gelarbelakang_pegtugas1, gelarbelakang_pegtugas2, gelarbelakangpegawaimengetahui_id, gelarbelakangpegtugas1_id, gelarbelakangpegtugas2_id, pegtugas1_id, pegtugas1_nama, gelardepan_pegawaimengetahui, gelardepan_pegtugas1, gelardepan_pegtugas2, pegtugas2_nama, pegtugas2_id, noinduk_pegawaimengetahui, noinduk_pegtugas1, noinduk_pegtugas2, noidentitas_pegawaimengetahui, noidentitas_pegtugas1, noidentitas_pegtugas2, jenisidentitas_pegtugas2, jenisidentitas_pegtugas1, jenisidentitas_pegawaimengetahui', 'safe', 'on'=>'search'),
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
			'pemeliharaanaset_id' => 'Pemeliharaanaset',
			'pemeliharaanaset_no' => 'No. Pemeliharaan Aset',
			'pemeliharaanaset_tgl' => 'Pemeliharaanaset Tgl',
			'pemeliharaanaset_ket' => 'Ket. Pemeliharaan Aset',
			'pegawaimengetahui_id' => 'Pegawaimengetahui',
			'pegawaimengetahui_nama' => 'Pegawaimengetahui Nama',
			'gelarbelakang_pegawaimengetahui' => 'Gelarbelakang Pegawaimengetahui',
			'gelarbelakang_pegtugas1' => 'Gelarbelakang Pegtugas1',
			'gelarbelakang_pegtugas2' => 'Gelarbelakang Pegtugas2',
			'gelarbelakangpegawaimengetahui_id' => 'Gelarbelakangpegawaimengetahui',
			'gelarbelakangpegtugas1_id' => 'Gelarbelakangpegtugas1',
			'gelarbelakangpegtugas2_id' => 'Gelarbelakangpegtugas2',
			'pegtugas1_id' => 'Pegtugas1',
			'pegtugas1_nama' => 'Pegtugas1 Nama',
			'gelardepan_pegawaimengetahui' => 'Gelardepan Pegawaimengetahui',
			'gelardepan_pegtugas1' => 'Gelardepan Pegtugas1',
			'gelardepan_pegtugas2' => 'Gelardepan Pegtugas2',
			'pegtugas2_nama' => 'Pegtugas2 Nama',
			'pegtugas2_id' => 'Pegtugas2',
			'noinduk_pegawaimengetahui' => 'Noinduk Pegawaimengetahui',
			'noinduk_pegtugas1' => 'Noinduk Pegtugas1',
			'noinduk_pegtugas2' => 'Noinduk Pegtugas2',
			'noidentitas_pegawaimengetahui' => 'Noidentitas Pegawaimengetahui',
			'noidentitas_pegtugas1' => 'Noidentitas Pegtugas1',
			'noidentitas_pegtugas2' => 'Noidentitas Pegtugas2',
			'jenisidentitas_pegtugas2' => 'Jenisidentitas Pegtugas2',
			'jenisidentitas_pegtugas1' => 'Jenisidentitas Pegtugas1',
			'jenisidentitas_pegawaimengetahui' => 'Jenisidentitas Pegawaimengetahui',
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

		if(!empty($this->pemeliharaanaset_id)){
			$criteria->addCondition('pemeliharaanaset_id = '.$this->pemeliharaanaset_id);
		}
		$criteria->compare('LOWER(pemeliharaanaset_no)',strtolower($this->pemeliharaanaset_no),true);
		$criteria->compare('LOWER(pemeliharaanaset_tgl)',strtolower($this->pemeliharaanaset_tgl),true);
		$criteria->compare('LOWER(pemeliharaanaset_ket)',strtolower($this->pemeliharaanaset_ket),true);
		if(!empty($this->pegawaimengetahui_id)){
			$criteria->addCondition('pegawaimengetahui_id = '.$this->pegawaimengetahui_id);
		}
		$criteria->compare('LOWER(pegawaimengetahui_nama)',strtolower($this->pegawaimengetahui_nama),true);
		$criteria->compare('LOWER(gelarbelakang_pegawaimengetahui)',strtolower($this->gelarbelakang_pegawaimengetahui),true);
		$criteria->compare('LOWER(gelarbelakang_pegtugas1)',strtolower($this->gelarbelakang_pegtugas1),true);
		$criteria->compare('LOWER(gelarbelakang_pegtugas2)',strtolower($this->gelarbelakang_pegtugas2),true);
		if(!empty($this->gelarbelakangpegawaimengetahui_id)){
			$criteria->addCondition('gelarbelakangpegawaimengetahui_id = '.$this->gelarbelakangpegawaimengetahui_id);
		}
		if(!empty($this->gelarbelakangpegtugas1_id)){
			$criteria->addCondition('gelarbelakangpegtugas1_id = '.$this->gelarbelakangpegtugas1_id);
		}
		if(!empty($this->gelarbelakangpegtugas2_id)){
			$criteria->addCondition('gelarbelakangpegtugas2_id = '.$this->gelarbelakangpegtugas2_id);
		}
		if(!empty($this->pegtugas1_id)){
			$criteria->addCondition('pegtugas1_id = '.$this->pegtugas1_id);
		}
		$criteria->compare('LOWER(pegtugas1_nama)',strtolower($this->pegtugas1_nama),true);
		$criteria->compare('LOWER(gelardepan_pegawaimengetahui)',strtolower($this->gelardepan_pegawaimengetahui),true);
		$criteria->compare('LOWER(gelardepan_pegtugas1)',strtolower($this->gelardepan_pegtugas1),true);
		$criteria->compare('LOWER(gelardepan_pegtugas2)',strtolower($this->gelardepan_pegtugas2),true);
		$criteria->compare('LOWER(pegtugas2_nama)',strtolower($this->pegtugas2_nama),true);
		if(!empty($this->pegtugas2_id)){
			$criteria->addCondition('pegtugas2_id = '.$this->pegtugas2_id);
		}
		$criteria->compare('LOWER(noinduk_pegawaimengetahui)',strtolower($this->noinduk_pegawaimengetahui),true);
		$criteria->compare('LOWER(noinduk_pegtugas1)',strtolower($this->noinduk_pegtugas1),true);
		$criteria->compare('LOWER(noinduk_pegtugas2)',strtolower($this->noinduk_pegtugas2),true);
		$criteria->compare('LOWER(noidentitas_pegawaimengetahui)',strtolower($this->noidentitas_pegawaimengetahui),true);
		$criteria->compare('LOWER(noidentitas_pegtugas1)',strtolower($this->noidentitas_pegtugas1),true);
		$criteria->compare('LOWER(noidentitas_pegtugas2)',strtolower($this->noidentitas_pegtugas2),true);
		$criteria->compare('LOWER(jenisidentitas_pegtugas2)',strtolower($this->jenisidentitas_pegtugas2),true);
		$criteria->compare('LOWER(jenisidentitas_pegtugas1)',strtolower($this->jenisidentitas_pegtugas1),true);
		$criteria->compare('LOWER(jenisidentitas_pegawaimengetahui)',strtolower($this->jenisidentitas_pegawaimengetahui),true);

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