<?php

/**
 * This is the model class for table "jenispengeluaranrekening_v".
 *
 * The followings are the available columns in table 'jenispengeluaranrekening_v':
 * @property integer $jenispengeluaran_id
 * @property string $jenispengeluaran_kode
 * @property string $jenispengeluaran_nama
 * @property string $jenispengeluaran_namalain
 * @property boolean $jenispengeluaran_aktif
 * @property integer $jnspengeluaranrek_id
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
class JenispengeluaranrekeningV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return JenispengeluaranrekeningV the static model class
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
		return 'jenispengeluaranrekening_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('jenispengeluaran_id, jnspengeluaranrek_id, kelrekening_id, struktur_id, kelompok_id, jenis_id, obyek_id, rincianobyek_id, nourutrek', 'numerical', 'integerOnly'=>true),
			array('jenispengeluaran_kode, kelompokrek', 'length', 'max'=>20),
			array('jenispengeluaran_nama, jenispengeluaran_namalain, namakelrekening, nmstruktur, nmstrukturlain', 'length', 'max'=>100),
			array('koderekeningkel', 'length', 'max'=>50),
			array('kdstruktur, kdkelompok, kdjenis, kdobyek, kdrincianobyek', 'length', 'max'=>5),
			array('struktur_nb, kelompok_nb, jenis_nb, obyek_nb, rincianobyek_nb', 'length', 'max'=>1),
			array('nmkelompok, nmkelompoklain', 'length', 'max'=>200),
			array('nmjenis, nmjenislain', 'length', 'max'=>300),
			array('nmobyek, nmobyeklain', 'length', 'max'=>400),
			array('nmrincianobyek, nmrincianobyeklain', 'length', 'max'=>500),
			array('saldonormal', 'length', 'max'=>10),
			array('jenispengeluaran_aktif, struktur_aktif, kelompok_aktif, jenis_aktif, obyek_aktif, keterangan, rincianobyek_aktif, sak', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('jenispengeluaran_id, jenispengeluaran_kode, jenispengeluaran_nama, jenispengeluaran_namalain, jenispengeluaran_aktif, jnspengeluaranrek_id, kelrekening_id, koderekeningkel, namakelrekening, struktur_id, kdstruktur, nmstruktur, nmstrukturlain, struktur_nb, struktur_aktif, kelompok_id, kdkelompok, nmkelompok, nmkelompoklain, kelompok_nb, kelompok_aktif, jenis_id, kdjenis, nmjenis, nmjenislain, jenis_nb, jenis_aktif, obyek_id, kdobyek, nmobyek, nmobyeklain, obyek_nb, obyek_aktif, rincianobyek_id, kdrincianobyek, nmrincianobyek, nmrincianobyeklain, rincianobyek_nb, keterangan, nourutrek, rincianobyek_aktif, kelompokrek, sak, saldonormal', 'safe', 'on'=>'search'),
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
			'jenispengeluaran_id' => 'Jenispengeluaran',
			'jenispengeluaran_kode' => 'Jenispengeluaran Kode',
			'jenispengeluaran_nama' => 'Jenispengeluaran Nama',
			'jenispengeluaran_namalain' => 'Jenispengeluaran Namalain',
			'jenispengeluaran_aktif' => 'Jenispengeluaran Aktif',
			'jnspengeluaranrek_id' => 'Jnspengeluaranrek',
			'kelrekening_id' => 'Kelrekening',
			'koderekeningkel' => 'Koderekeningkel',
			'namakelrekening' => 'Namakelrekening',
			'struktur_id' => 'Struktur',
			'kdstruktur' => 'Kdstruktur',
			'nmstruktur' => 'Nmstruktur',
			'nmstrukturlain' => 'Nmstrukturlain',
			'struktur_nb' => 'Struktur Nb',
			'struktur_aktif' => 'Struktur Aktif',
			'kelompok_id' => 'Kelompok',
			'kdkelompok' => 'Kdkelompok',
			'nmkelompok' => 'Nmkelompok',
			'nmkelompoklain' => 'Nmkelompoklain',
			'kelompok_nb' => 'Kelompok Nb',
			'kelompok_aktif' => 'Kelompok Aktif',
			'jenis_id' => 'Jenis',
			'kdjenis' => 'Kdjenis',
			'nmjenis' => 'Nmjenis',
			'nmjenislain' => 'Nmjenislain',
			'jenis_nb' => 'Jenis Nb',
			'jenis_aktif' => 'Jenis Aktif',
			'obyek_id' => 'Obyek',
			'kdobyek' => 'Kdobyek',
			'nmobyek' => 'Nmobyek',
			'nmobyeklain' => 'Nmobyeklain',
			'obyek_nb' => 'Obyek Nb',
			'obyek_aktif' => 'Obyek Aktif',
			'rincianobyek_id' => 'Rincianobyek',
			'kdrincianobyek' => 'Kdrincianobyek',
			'nmrincianobyek' => 'Nmrincianobyek',
			'nmrincianobyeklain' => 'Nmrincianobyeklain',
			'rincianobyek_nb' => 'Rincianobyek Nb',
			'keterangan' => 'Keterangan',
			'nourutrek' => 'Nourutrek',
			'rincianobyek_aktif' => 'Rincianobyek Aktif',
			'kelompokrek' => 'Kelompokrek',
			'sak' => 'Sak',
			'saldonormal' => 'Saldo Normal',
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

		if(!empty($this->jenispengeluaran_id)){
			$criteria->addCondition('jenispengeluaran_id = '.$this->jenispengeluaran_id);
		}
		$criteria->compare('LOWER(jenispengeluaran_kode)',strtolower($this->jenispengeluaran_kode),true);
		$criteria->compare('LOWER(jenispengeluaran_nama)',strtolower($this->jenispengeluaran_nama),true);
		$criteria->compare('LOWER(jenispengeluaran_namalain)',strtolower($this->jenispengeluaran_namalain),true);
		$criteria->compare('jenispengeluaran_aktif',$this->jenispengeluaran_aktif);
		if(!empty($this->jnspengeluaranrek_id)){
			$criteria->addCondition('jnspengeluaranrek_id = '.$this->jnspengeluaranrek_id);
		}
		if(!empty($this->kelrekening_id)){
			$criteria->addCondition('kelrekening_id = '.$this->kelrekening_id);
		}
		$criteria->compare('LOWER(koderekeningkel)',strtolower($this->koderekeningkel),true);
		$criteria->compare('LOWER(namakelrekening)',strtolower($this->namakelrekening),true);
		if(!empty($this->struktur_id)){
			$criteria->addCondition('struktur_id = '.$this->struktur_id);
		}
		$criteria->compare('LOWER(kdstruktur)',strtolower($this->kdstruktur),true);
		$criteria->compare('LOWER(nmstruktur)',strtolower($this->nmstruktur),true);
		$criteria->compare('LOWER(nmstrukturlain)',strtolower($this->nmstrukturlain),true);
		$criteria->compare('LOWER(struktur_nb)',strtolower($this->struktur_nb),true);
		$criteria->compare('struktur_aktif',$this->struktur_aktif);
		if(!empty($this->kelompok_id)){
			$criteria->addCondition('kelompok_id = '.$this->kelompok_id);
		}
		$criteria->compare('LOWER(kdkelompok)',strtolower($this->kdkelompok),true);
		$criteria->compare('LOWER(nmkelompok)',strtolower($this->nmkelompok),true);
		$criteria->compare('LOWER(nmkelompoklain)',strtolower($this->nmkelompoklain),true);
		$criteria->compare('LOWER(kelompok_nb)',strtolower($this->kelompok_nb),true);
		$criteria->compare('kelompok_aktif',$this->kelompok_aktif);
		if(!empty($this->jenis_id)){
			$criteria->addCondition('jenis_id = '.$this->jenis_id);
		}
		$criteria->compare('LOWER(kdjenis)',strtolower($this->kdjenis),true);
		$criteria->compare('LOWER(nmjenis)',strtolower($this->nmjenis),true);
		$criteria->compare('LOWER(nmjenislain)',strtolower($this->nmjenislain),true);
		$criteria->compare('LOWER(jenis_nb)',strtolower($this->jenis_nb),true);
		$criteria->compare('jenis_aktif',$this->jenis_aktif);
		if(!empty($this->obyek_id)){
			$criteria->addCondition('obyek_id = '.$this->obyek_id);
		}
		$criteria->compare('LOWER(kdobyek)',strtolower($this->kdobyek),true);
		$criteria->compare('LOWER(nmobyek)',strtolower($this->nmobyek),true);
		$criteria->compare('LOWER(nmobyeklain)',strtolower($this->nmobyeklain),true);
		$criteria->compare('LOWER(obyek_nb)',strtolower($this->obyek_nb),true);
		$criteria->compare('obyek_aktif',$this->obyek_aktif);
		if(!empty($this->rincianobyek_id)){
			$criteria->addCondition('rincianobyek_id = '.$this->rincianobyek_id);
		}
		$criteria->compare('LOWER(kdrincianobyek)',strtolower($this->kdrincianobyek),true);
		$criteria->compare('LOWER(nmrincianobyek)',strtolower($this->nmrincianobyek),true);
		$criteria->compare('LOWER(nmrincianobyeklain)',strtolower($this->nmrincianobyeklain),true);
		$criteria->compare('LOWER(rincianobyek_nb)',strtolower($this->rincianobyek_nb),true);
		$criteria->compare('LOWER(keterangan)',strtolower($this->keterangan),true);
		if(!empty($this->nourutrek)){
			$criteria->addCondition('nourutrek = '.$this->nourutrek);
		}
		$criteria->compare('rincianobyek_aktif',$this->rincianobyek_aktif);
		$criteria->compare('LOWER(kelompokrek)',strtolower($this->kelompokrek),true);
		$criteria->compare('sak',$this->sak);
		$criteria->compare('LOWER(saldonormal)',strtolower($this->saldonormal),true);

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