<?php

/**
 * This is the model class for table "laporanhutangtitipanapotik_v".
 *
 * The followings are the available columns in table 'laporanhutangtitipanapotik_v':
 * @property string $tglresep
 * @property string $noresep
 * @property integer $pendaftaran_id
 * @property string $no_pendaftaran
 * @property integer $pasien_id
 * @property string $no_rekam_medik
 * @property string $namadepan
 * @property string $nama_pasien
 * @property string $instalasiasal_nama
 * @property string $ruanganasal_nama
 * @property double $jmlbayar_oa
 * @property string $kso
 * @property double $netto
 * @property integer $jenisobatalkes_id
 */
class HutangtitipanapotikV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return HutangtitipanapotikV the static model class
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
		return 'laporanhutangtitipanapotik_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pendaftaran_id, pasien_id, jenisobatalkes_id', 'numerical', 'integerOnly'=>true),
			array('jmlbayar_oa, netto', 'numerical'),
			array('noresep, nama_pasien', 'length', 'max'=>50),
			array('no_pendaftaran, namadepan', 'length', 'max'=>20),
			array('no_rekam_medik', 'length', 'max'=>10),
			array('instalasiasal_nama, ruanganasal_nama', 'length', 'max'=>100),
			array('tglresep, kso', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('tglresep, noresep, pendaftaran_id, no_pendaftaran, pasien_id, no_rekam_medik, namadepan, nama_pasien, instalasiasal_nama, ruanganasal_nama, jmlbayar_oa, kso, netto, jenisobatalkes_id', 'safe', 'on'=>'search'),
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
			'tglresep' => 'Tglresep',
			'noresep' => 'Noresep',
			'pendaftaran_id' => 'Pendaftaran',
			'no_pendaftaran' => 'No. Pendaftaran',
			'pasien_id' => 'Pasien',
			'no_rekam_medik' => 'No. Rekam Medik',
			'namadepan' => 'Namadepan',
			'nama_pasien' => 'Nama Pasien',
			'instalasiasal_nama' => 'Instalasiasal Nama',
			'ruanganasal_nama' => 'Ruanganasal Nama',
			'jmlbayar_oa' => 'Jmlbayar Oa',
			'kso' => 'Kso',
			'netto' => 'Netto',
			'jenisobatalkes_id' => 'Jenisobatalkes',
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

		$criteria->compare('LOWER(tglresep)',strtolower($this->tglresep),true);
		// $criteria->compare('LOWER(noresep)',strtolower($this->noresep),true);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('LOWER(no_pendaftaran)',strtolower($this->no_pendaftaran),true);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('LOWER(no_rekam_medik)',strtolower($this->no_rekam_medik),true);
		$criteria->compare('LOWER(namadepan)',strtolower($this->namadepan),true);
		$criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);
		$criteria->compare('LOWER(instalasiasal_nama)',strtolower($this->instalasiasal_nama),true);
		$criteria->compare('LOWER(ruanganasal_nama)',strtolower($this->ruanganasal_nama),true);
		$criteria->compare('jmlbayar_oa',$this->jmlbayar_oa);
		$criteria->compare('LOWER(kso)',strtolower($this->kso),true);
		$criteria->compare('netto',$this->netto);
		$criteria->compare('jenisobatalkes_id',$this->jenisobatalkes_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('LOWER(tglresep)',strtolower($this->tglresep),true);
		// $criteria->compare('LOWER(noresep)',strtolower($this->noresep),true);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('LOWER(no_pendaftaran)',strtolower($this->no_pendaftaran),true);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('LOWER(no_rekam_medik)',strtolower($this->no_rekam_medik),true);
		$criteria->compare('LOWER(namadepan)',strtolower($this->namadepan),true);
		$criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);
		$criteria->compare('LOWER(instalasiasal_nama)',strtolower($this->instalasiasal_nama),true);
		$criteria->compare('LOWER(ruanganasal_nama)',strtolower($this->ruanganasal_nama),true);
		$criteria->compare('jmlbayar_oa',$this->jmlbayar_oa);
		$criteria->compare('LOWER(kso)',strtolower($this->kso),true);
		$criteria->compare('netto',$this->netto);
		$criteria->compare('jenisobatalkes_id',$this->jenisobatalkes_id);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
}