<?php

/**
 * This is the model class for table "rekeningakuntansi_v".
 *
 * The followings are the available columns in table 'rekeningakuntansi_v':
 * @property integer $rekening1_id
 * @property string $kdrekening1
 * @property string $nmrekening1
 * @property string $nmrekeninglain1
 * @property string $rekening1_nb
 * @property boolean $rekening1_aktif
 * @property integer $rekening2_id
 * @property string $kdrekening2
 * @property string $nmrekening2
 * @property string $nmrekeninglain2
 * @property string $rekening2_nb
 * @property boolean $rekening2_aktif
 * @property integer $rekening3_id
 * @property string $kdrekening3
 * @property string $nmrekening3
 * @property string $nmrekeninglain3
 * @property string $rekening3_nb
 * @property boolean $rekening3_aktif
 * @property integer $rekening4_id
 * @property string $kdrekening4
 * @property string $nmrekening4
 * @property string $nmrekeninglain4
 * @property string $rekening4_nb
 * @property boolean $rekening4_aktif
 * @property integer $rekening5_id
 * @property string $kdrekening5
 * @property string $nmrekening5
 * @property string $nmrekeninglain5
 * @property string $rekening5_nb
 * @property string $keterangan
 * @property integer $nourutrek
 * @property boolean $rekening5_aktif
 * @property string $kelompokrek
 * @property boolean $sak
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 * @property integer $kelrekening_id
 * @property string $koderekeningkel
 * @property string $namakelrekening
 * @property boolean $kelrekening_aktif
 */
class RekeningakuntansiV_ver1 extends CActiveRecord {

    public $rekDebit, $rekKredit, $namaRekening, $saldokredit, $saldodebit, $saldonormal;
    public $rek_column;
    public $tr_class;
    public $nourut;
    //public $kelrekening_id;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return RekeningakuntansiV the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'rekeningakuntansi_v';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
			array('struktur_id, kelompok_id, jenis_id, obyek_id, rincianobyek_id, nourutrek', 'numerical', 'integerOnly'=>true),
			array('kdstruktur, kdkelompok, kdjenis, kdobyek, kdrincianobyek', 'length', 'max'=>5),
			array('nmstruktur, nmstrukturlain', 'length', 'max'=>100),
			array('struktur_nb, kelompok_nb, jenis_nb, obyek_nb, rincianobyek_nb', 'length', 'max'=>1),
			array('nmkelompok, nmkelompoklain', 'length', 'max'=>200),
			array('nmjenis, nmjenislain', 'length', 'max'=>300),
			array('nmobyek, nmobyeklain', 'length', 'max'=>400),
			array('nmrincianobyek, nmrincianobyeklain', 'length', 'max'=>500),
			array('kelompokrek', 'length', 'max'=>20),
			array('struktur_aktif, kelompok_aktif, jenis_aktif, obyek_aktif, keterangan, rincianobyek_aktif, sak, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, debitkredit, kdrekening5, kelrekening_id, rekening1_id, rekening2_id, nmrekening5, rekening3_id, rekening4_id, rekening5_id, rekening5_nb', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.

                        array('struktur_id, kdstruktur, nmstruktur, rekDebit, rekKredit, nmstrukturlain, struktur_nb, struktur_aktif, kelompok_id, kdkelompok, nmkelompok, nmkelompoklain, kelompok_nb, kelompok_aktif, jenis_id, kdjenis, nmjenis, nmjenislain, jenis_nb, jenis_aktif, obyek_id, kdobyek, nmobyek, nmobyeklain, obyek_nb, obyek_aktif, rincianobyek_id, kdrincianobyek, nmrincianobyek, nmrincianobyeklain, rincianobyek_nb, keterangan, nourutrek, rincianobyek_aktif, kelompokrek, sak, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, rekening5_nb', 'safe', 'on'=>'search'),

		);
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
			'struktur_id' => 'Struktur',

			'kdstruktur' => 'Kode Struktur',
			'nmstruktur' => 'Nama Struktur',
			'nmstrukturlain' => 'Nama Struktur Lain',
			'struktur_nb' => 'Struktur NB',
			'struktur_aktif' => 'Struktur Aktif',
			'kelompok_id' => 'Kelompok',
			'kdkelompok' => 'Kode Kelompok',
			'nmkelompok' => 'Nama Kelompok',
			'nmkelompoklain' => 'Nama Kelompok Lain',
			'kelompok_nb' => 'Kelompok NB',
			'kelompok_aktif' => 'Kelompok Aktif',
			'jenis_id' => 'Jenis',
			'kdjenis' => 'Kode Jenis',
			'nmjenis' => 'Nama Jenis',
			'nmjenislain' => 'Nama Jenis Lain',
			'jenis_nb' => 'Jenis NB',
			'jenis_aktif' => 'Jenis Aktif',
			'obyek_id' => 'Obyek',
			'kdobyek' => 'Kode Obyek',
			'nmobyek' => 'Nama Obyek',
			'nmobyeklain' => 'Nama Obyek Lain',
			'obyek_nb' => 'Obyek NB',
			'obyek_aktif' => 'Obyek Aktif',
			'rincianobyek_id' => 'Rincian Obyek',
			'kdrincianobyek' => 'Kode Rincian Obyek',
			'nmrincianobyek' => 'Nama Rincian Obyek',
			'nmrincianobyeklain' => 'Nama Rincian Obyek Lain',
			'rincianobyek_nb' => 'Rincian Obyek NB',
			'keterangan' => 'Keterangan',
			'nourutrek' => 'No. Urut Rek.',
			'rincianobyek_aktif' => 'Rincian Obyek Aktif',
			'kelompokrek' => 'Kelompok Rek.',
			'sak' => 'Sak',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
		);
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CdbCriteria that can return criterias.
     */
    public function criteriaSearch() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('struktur_id',$this->struktur_id);
		$criteria->compare('LOWER(kdstruktur)',strtolower($this->kdstruktur),true);
		$criteria->compare('LOWER(nmstruktur)',strtolower($this->nmstruktur),true);
		$criteria->compare('LOWER(nmstrukturlain)',strtolower($this->nmstrukturlain),true);
		$criteria->compare('LOWER(struktur_nb)',strtolower($this->struktur_nb),true);
		$criteria->compare('struktur_aktif',$this->struktur_aktif);
		$criteria->compare('kelompok_id',$this->kelompok_id);
		$criteria->compare('LOWER(kdkelompok)',strtolower($this->kdkelompok),true);
		$criteria->compare('LOWER(nmkelompok)',strtolower($this->nmkelompok),true);
		$criteria->compare('LOWER(nmkelompoklain)',strtolower($this->nmkelompoklain),true);
		$criteria->compare('LOWER(kelompok_nb)',strtolower($this->kelompok_nb),true);
		$criteria->compare('kelompok_aktif',$this->kelompok_aktif);
		$criteria->compare('jenis_id',$this->jenis_id);
		$criteria->compare('LOWER(kdjenis)',strtolower($this->kdjenis),true);
		$criteria->compare('LOWER(nmjenis)',strtolower($this->nmjenis),true);
		$criteria->compare('LOWER(nmjenislain)',strtolower($this->nmjenislain),true);
		$criteria->compare('LOWER(jenis_nb)',strtolower($this->jenis_nb),true);
		$criteria->compare('jenis_aktif',$this->jenis_aktif);
		$criteria->compare('obyek_id',$this->obyek_id);
		$criteria->compare('LOWER(kdobyek)',strtolower($this->kdobyek),true);
		$criteria->compare('LOWER(nmobyek)',strtolower($this->nmobyek),true);
		$criteria->compare('LOWER(nmobyeklain)',strtolower($this->nmobyeklain),true);
		$criteria->compare('LOWER(obyek_nb)',strtolower($this->obyek_nb),true);
		$criteria->compare('obyek_aktif',$this->obyek_aktif);
		$criteria->compare('rincianobyek_id',$this->rincianobyek_id);
		$criteria->compare('LOWER(kdrincianobyek)',strtolower($this->kdrincianobyek),true);
		$criteria->compare('LOWER(nmrincianobyek)',strtolower($this->nmrincianobyek),true);
		$criteria->compare('LOWER(nmrincianobyeklain)',strtolower($this->nmrincianobyeklain),true);
		$criteria->compare('LOWER(rincianobyek_nb)',strtolower($this->rincianobyek_nb),true);
		$criteria->compare('LOWER(keterangan)',strtolower($this->keterangan),true);
		$criteria->compare('nourutrek',$this->nourutrek);
		$criteria->compare('rincianobyek_aktif',$this->rincianobyek_aktif);
		$criteria->compare('LOWER(kelompokrek)',strtolower($this->kelompokrek),true);
		$criteria->compare('sak',$this->sak);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);

		$criteria->compare('LOWER(kdrekening5)', strtolower($this->kdrekening5),true);
		$criteria->compare('LOWER(nmrekening5)', strtolower($this->nmrekening5),true);
		$criteria->compare('LOWER(rekening5_nb)', strtolower($this->rekening5_nb));
		if (!empty($this->rekening1_id)){
			$criteria->addCondition(" rekening1_id  = ".$this->rekening1_id);
		}

		if (!empty($this->rekening2_id)){
			$criteria->addCondition(" rekening2_id  = ".$this->rekening2_id);
		}

		if (!empty($this->rekening3_id)){
			$criteria->addCondition(" rekening3_id  = ".$this->rekening3_id);
		}

		if (!empty($this->rekening4_id)){
			$criteria->addCondition(" rekening4_id  = ".$this->rekening4_id);
		}

        return $criteria;
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = $this->criteriaSearch();
        $criteria->limit = 10;

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    // 11-06-2013
    // v.1
    public function searchAccounts() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        if (!empty($this->rekening1_id)) {
            $criteria->addCondition('rekening1_id = ' . $this->rekening1_id);
        }
        $criteria->compare('LOWER(kdrekening1)', strtolower($this->kdrekening1), true);
        $criteria->compare('LOWER(nmrekening1)', strtolower($this->nmrekening1), true);
        $criteria->compare('LOWER(nmrekeninglain1)', strtolower($this->nmrekeninglain1), true);
//        $criteria->compare('LOWER(rekening1_nb)', strtolower($this->rekening1_nb), true);
        $criteria->compare('rekening1_aktif', $this->rekening1_aktif);
        if (!empty($this->rekening2_id)) {
            $criteria->addCondition('rekening2_id = ' . $this->rekening2_id);
        }
        $criteria->compare('LOWER(kdrekening2)', strtolower($this->kdrekening2), true);
        $criteria->compare('LOWER(nmrekening2)', strtolower($this->nmrekening2), true);
        $criteria->compare('LOWER(nmrekeninglain2)', strtolower($this->nmrekeninglain2), true);
        $criteria->compare('rekening2_aktif', $this->rekening2_aktif);
        if (!empty($this->rekening3_id)) {
            $criteria->addCondition('rekening3_id = ' . $this->rekening3_id);
        }
        $criteria->compare('LOWER(kdrekening3)', strtolower($this->kdrekening3), true);
        $criteria->compare('LOWER(nmrekening3)', strtolower($this->nmrekening3), true);
        $criteria->compare('LOWER(nmrekeninglain3)', strtolower($this->nmrekeninglain3), true);
        $criteria->compare('rekening3_aktif', $this->rekening3_aktif);
        if (!empty($this->rekening4_id)) {
            $criteria->addCondition('rekening4_id = ' . $this->rekening4_id);
        }
        $criteria->compare('LOWER(kdrekening4)', strtolower($this->kdrekening4), true);
        $criteria->compare('LOWER(nmrekening4)', strtolower($this->nmrekening4), true);
        $criteria->compare('LOWER(nmrekeninglain4)', strtolower($this->nmrekeninglain4), true);
        $criteria->compare('rekening4_aktif', $this->rekening4_aktif);
        if (!empty($this->rekening5_id)) {
            $criteria->addCondition('rekening5_id = ' . $this->rekening5_id);
        }
        $criteria->compare('LOWER(kdrekening5)', strtolower($this->kdrekening5), true);
        $criteria->compare('LOWER(nmrekening5)', strtolower($this->nmrekening5), true);
        $criteria->compare('LOWER(nmrekeninglain5)', strtolower($this->nmrekeninglain5), true);
        $criteria->compare('LOWER(rekening5_nb)', strtolower($this->rekening5_nb), true);

        $criteria->compare('LOWER(keterangan)', strtolower($this->keterangan), true);
        if (!empty($this->nourutrek)) {
            $criteria->addCondition('nourutrek = ' . $this->nourutrek);
        }
        $criteria->compare('rekening5_aktif', $this->rekening5_aktif);
        $criteria->compare('LOWER(kelompokrek)', strtolower($this->kelompokrek), true);
        $criteria->compare('sak', $this->sak);
        $criteria->compare('LOWER(create_time)', strtolower($this->create_time), true);
        $criteria->compare('LOWER(update_time)', strtolower($this->update_time), true);
        $criteria->compare('LOWER(create_loginpemakai_id)', strtolower($this->create_loginpemakai_id), true);
        $criteria->compare('LOWER(update_loginpemakai_id)', strtolower($this->update_loginpemakai_id), true);
        $criteria->compare('LOWER(create_ruangan)', strtolower($this->create_ruangan), true);
        if (!empty($this->kelrekening_id)) {
            $criteria->addCondition('kelrekening_id = ' . $this->kelrekening_id);
        }
        $criteria->compare('LOWER(koderekeningkel)', strtolower($this->koderekeningkel), true);
        $criteria->compare('LOWER(namakelrekening)', strtolower($this->namakelrekening), true);
        $criteria->compare('kelrekening_aktif', $this->kelrekening_aktif);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function searchPrint() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = $this->criteriaSearch();
        $criteria->limit = -1;

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => false,
        ));
    }

	public function searchDebit() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = $this->criteriaSearch();
        //$criteria->addCondition("rekening5_nb = 'D'");

        $criteria->limit = 10;

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function searchKredit() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = $this->criteriaSearch();
       // $criteria->addCondition("rekening5_nb = 'K'");

        $criteria->limit = 10;

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

	public function namaRekening()
	{
		if($this->nmrincianobyek!= ""){
			return $this->nmrincianobyek;
                }else if($this->nmobyek != ""){
                    return $this->nmobyek;
                }else if($this->nmjenis != ""){
                    return $this->nmjenis;
                }else if($this->nmkelomopok != ""){
                    return $this->nmkelomopok;
                }else if($this->nmjenis != ""){
                    return $this->nmjenis;
                }
	}
        public function namaRekeningLain()
	{
		if($this->nmrincianobyeklain!= null){
			return $this->nmrincianobyeklain;
                }else if($this->nmobyeklain != null){
                    return $this->nmobyeklain;
                }else if($this->nmjenislain != null){
                    return $this->nmjenislain;
                }else if($this->nmkelomopoklain != null){
                    return $this->nmkelomopoklain;
                }else if($this->nmjenislain != null){
                    return $this->nmjenislain;
                }
	}

}
