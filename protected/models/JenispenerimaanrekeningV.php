<?php

/**
 * This is the model class for table "jenispenerimaanrekening_v".
 *
 * The followings are the available columns in table 'jenispenerimaanrekening_v':
 * @property integer $jenispenerimaan_id
 * @property string $jenispenerimaan_kode
 * @property string $jenispenerimaan_nama
 * @property string $jenispenerimaan_namalain
 * @property boolean $jenispenerimaan_aktif
 * @property integer $jnspenerimaanrek_id
 * @property integer $kelrekening_id
 * @property string $koderekeningkel
 * @property string $namakelrekening
 * @property integer $struktur_id
 * @property string $kdstruktur
 * @property string $nmstruktur
 * @property string $nmstrukturlain
 * @property string $struktur_nb
 * @property boolean $struktur_aktif
 * @property integer $kelompok_id
 * @property string $kdkelompok
 * @property string $nmkelompok
 * @property string $nmkelompoklain
 * @property string $kelompok_nb
 * @property boolean $kelompok_aktif
 * @property integer $jenis_id
 * @property string $kdjenis
 * @property string $nmjenis
 * @property string $nmjenislain
 * @property string $jenis_nb
 * @property boolean $jenis_aktif
 * @property integer $obyek_id
 * @property string $kdobyek
 * @property string $nmobyek
 * @property string $nmobyeklain
 * @property string $obyek_nb
 * @property boolean $obyek_aktif
 * @property integer $rincianobyek_id
 * @property string $kdrincianobyek
 * @property string $nmrincianobyek
 * @property string $nmrincianobyeklain
 * @property string $rincianobyek_nb
 * @property string $keterangan
 * @property integer $nourutrek
 * @property boolean $rincianobyek_aktif
 * @property string $kelompokrek
 * @property boolean $sak
 * @property string $saldonormal
 */
class JenispenerimaanrekeningV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return JenispenerimaanrekeningV the static model class
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
		return 'jenispenerimaanrekening_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('jenispenerimaan_id, jnspenerimaanrek_id, kelrekening_id, rekening1_id, rekening2_id, rekening3_id, rekening4_id, rekening5_id, nourutrek', 'numerical', 'integerOnly'=>true),
			array('jenispenerimaan_kode, jenispenerimaan_nama, jenispenerimaan_namalain, koderekeningkel', 'length', 'max'=>50),
			array('namakelrekening, nmrekening1, nmrekening5', 'length', 'max'=>100),
			array('kdrekening1, kdrekening2, kdrekening3, kdrekening4, kdrekening5', 'length', 'max'=>5),
			array('rekening1_nb, rekening2_nb, rekening3_nb, rekening4_nb, rekening5_nb', 'length', 'max'=>1),
			array('nmrekening2, nmrekeninglain2', 'length', 'max'=>200),
			array('nmrekening3, nmrekeninglain3', 'length', 'max'=>300),
			array('nmrekening4, nmrekeninglain4', 'length', 'max'=>400),
			array('nmrekening5, nmrekeninglain4', 'length', 'max'=>500),
			array('kelompokrek', 'length', 'max'=>20),
			array('jenispenerimaan_aktif, struktur_aktif, kelompok_aktif, jenis_aktif, obyek_aktif, keterangan, rincianobyek_aktif, sak', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('jenispenerimaan_id, jenispenerimaan_kode, jenispenerimaan_nama, jenispenerimaan_namalain, jenispenerimaan_aktif, jnspenerimaanrek_id, kelrekening_id, koderekeningkel, namakelrekening, rekening1_id, kdrekening1, nmrekening1, nmrekeninglain1, rekening1_nb, rekening1_aktif, '
				. 'rekening2_id, kdrekening2, nmrekening2, nmrekeninglain2, rekneing2_nb, rekening2_aktif, '
				. 'rekening3_id, kdrekening3, nmrekening3, nmrekeninglain3, rekening3_nb, rekening3_aktif, '
				. 'rekening4_id, kdrekening4, nmrekening4, nmrekeninglain4, rekening4_nb, rekening4_aktif, '
				. 'rekening5_id, kdrekening5, nmrekening5, nmrekeninglain5, rekening5_nb, '
				. 'keterangan, nourutrek, rekening5_aktif, kelompokrek, sak', 'safe', 'on'=>'search'),
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
			'jenispenerimaan_id' => 'Jenispenerimaan',
			'jenispenerimaan_kode' => 'Jenispenerimaan Kode',
			'jenispenerimaan_nama' => 'Jenispenerimaan Nama',
			'jenispenerimaan_namalain' => 'Jenispenerimaan Namalain',
			'jenispenerimaan_aktif' => 'Jenispenerimaan Aktif',
			'jnspenerimaanrek_id' => 'Jnspenerimaanrek',
			'kelrekening_id' => 'Kelrekening',
			'koderekeningkel' => 'Koderekeningkel',
			'namakelrekening' => 'Namakelrekening',
			'rekening1_id' => 'Struktur',
			'kdrekening1' => 'Kdstruktur',
			'nmrekening1' => 'Nmstruktur',
			'nmrekeninglain1' => 'Nmstrukturlain',
			'rekening1_nb' => 'Struktur Nb',
			'rekening1_aktif' => 'Struktur Aktif',
			'rekening2_id' => 'Kelompok',
			'kdrekening2' => 'Kdkelompok',
			'nmrekening2' => 'Nmkelompok',
			'nmrekeninglain2' => 'Nmkelompoklain',
			'rekening2_nb' => 'Kelompok Nb',
			'rekening2_aktif' => 'Kelompok Aktif',
			'rekening3_id' => 'Jenis',
			'kdrekening3' => 'Kdjenis',
			'nmrekening3' => 'Nmjenis',
			'nmrekeninglain3' => 'Nmjenislain',
			'rekening3_nb' => 'Jenis Nb',
			'rekening3_aktif' => 'Jenis Aktif',
			'rekening4_id' => 'Obyek',
			'kdrekening4' => 'Kdobyek',
			'nmrekening4' => 'Nmobyek',
			'nmrekeninglain4' => 'Nmobyeklain',
			'rekening4_nb' => 'Obyek Nb',
			'rekening4_aktif' => 'Obyek Aktif',
			'rekening5_id' => 'Rincianobyek',
			'kdrekening5' => 'Kdrincianobyek',
			'nmrekening5' => 'Nmrincianobyek',
			'nmrekeninglain5' => 'Nmrincianobyeklain',
			'rekening5_nb' => 'Rincianobyek Nb',
			'keterangan' => 'Keterangan',
			'nourutrek' => 'Nourutrek',
			'rekening5_aktif' => 'Rincianobyek Aktif',
			'kelompokrek' => 'Kelompokrek',
			'sak' => 'Sak',
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

		if(!empty($this->jenispenerimaan_id)){
			$criteria->addCondition('jenispenerimaan_id = '.$this->jenispenerimaan_id);
		}
		$criteria->compare('LOWER(jenispenerimaan_kode)',strtolower($this->jenispenerimaan_kode),true);
		$criteria->compare('LOWER(jenispenerimaan_nama)',strtolower($this->jenispenerimaan_nama),true);
		$criteria->compare('LOWER(jenispenerimaan_namalain)',strtolower($this->jenispenerimaan_namalain),true);
		$criteria->compare('jenispenerimaan_aktif',$this->jenispenerimaan_aktif);
		if(!empty($this->jnspenerimaanrek_id)){
			$criteria->addCondition('jnspenerimaanrek_id = '.$this->jnspenerimaanrek_id);
		}
		if(!empty($this->kelrekening_id)){
			$criteria->addCondition('kelrekening_id = '.$this->kelrekening_id);
		}
		$criteria->compare('LOWER(koderekeningkel)',strtolower($this->koderekeningkel),true);
		$criteria->compare('LOWER(namakelrekening)',strtolower($this->namakelrekening),true);
		if(!empty($this->rekening1_id)){
			$criteria->addCondition('rekening1_id = '.$this->rekening1_id);
		}
		$criteria->compare('LOWER(kdrekening1)',strtolower($this->kdrekening1),true);
		$criteria->compare('LOWER(nmrekening1)',strtolower($this->nmrekening1),true);
		$criteria->compare('LOWER(nmrekeninglain1)',strtolower($this->nmrekeninglain1),true);
		$criteria->compare('LOWER(rekening1_nb)',strtolower($this->rekening1_nb),true);
		$criteria->compare('rekneing1_aktif',$this->rekneing1_aktif);
		if(!empty($this->rekening2_id)){
			$criteria->addCondition('rekening2_id = '.$this->rekening2_id);
		}
		$criteria->compare('LOWER(kdrekening2)',strtolower($this->kdrekening2),true);
		$criteria->compare('LOWER(nmrekening2)',strtolower($this->nmrekening2),true);
		$criteria->compare('LOWER(nmrekeninglain2)',strtolower($this->nmrekeninglain2),true);
		$criteria->compare('LOWER(rekening2_nb)',strtolower($this->rekening2_nb),true);
		$criteria->compare('rekening2_aktif',$this->rekening2_aktif);
		if(!empty($this->rekening3_id)){
			$criteria->addCondition('rekening3_id = '.$this->rekening3_id);
		}
		$criteria->compare('LOWER(kdrekening3)',strtolower($this->kdrekening3),true);
		$criteria->compare('LOWER(nmrekening3)',strtolower($this->nmrekening3),true);
		$criteria->compare('LOWER(nmrekeninglain3)',strtolower($this->nmrekeninglain3),true);
		$criteria->compare('LOWER(rekening3_nb)',strtolower($this->rekening3_nb),true);
		$criteria->compare('rekening3_aktif',$this->rekening3_aktif);
		if(!empty($this->rekening4_id)){
			$criteria->addCondition('rekening4_id = '.$this->rekening4_id);
		}
		$criteria->compare('LOWER(kdrekening4)',strtolower($this->kdrekening4),true);
		$criteria->compare('LOWER(nmrekening4)',strtolower($this->nmrekening4),true);
		$criteria->compare('LOWER(nmrekeninglain4)',strtolower($this->nmrekeninglain4),true);
		$criteria->compare('LOWER(rekening4_nb)',strtolower($this->rekening4_nb),true);
		$criteria->compare('rekening4_aktif',$this->rekening4_aktif);
		if(!empty($this->rekening5_id)){
			$criteria->addCondition('rekening5_id = '.$this->rekening5_id);
		}
		$criteria->compare('LOWER(kdrekening5)',strtolower($this->kdrekening5),true);
		$criteria->compare('LOWER(nmrekening5)',strtolower($this->nmrekening5),true);
		$criteria->compare('LOWER(nmrekeninglain5)',strtolower($this->nmrekeninglain5),true);
		$criteria->compare('LOWER(rekening5_nb)',strtolower($this->rekening5_nb),true);
		$criteria->compare('LOWER(keterangan)',strtolower($this->keterangan),true);
		if(!empty($this->nourutrek)){
			$criteria->addCondition('nourutrek = '.$this->nourutrek);
		}
		$criteria->compare('rekening5_aktif',$this->rekening5_aktif);
		$criteria->compare('LOWER(kelompokrek)',strtolower($this->kelompokrek),true);
		$criteria->compare('sak',$this->sak);

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