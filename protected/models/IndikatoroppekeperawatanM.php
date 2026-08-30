<?php

/**
 * This is the model class for table "indikatoroppekeperawatan_m".
 * @author  Andyka Putra <andykaputra@.com>
 * @author Yudhit Widy Wicaksono <yudhitwicaksono@.com>
 * @package application.models
 * The followings are the available columns in table 'indikatoroppekeperawatan_m':
 * @property integer $indikatoroppekeperawatan_id
 * @property string $kode_indikator
 * @property string $nama_indikator
 * @property double $standar_nilai
 * @property string $golongan_indikator
 * @property string $rekomendasi
 * @property boolean $is_aktif
 * @property integer $create_loginpemakai_id
 * @property string $create_time
 * @property integer $update_loginpemakai_id
 * @property string $update_time
 *
 * The followings are the available model relations:
 * @property OppeperilakuT[] $oppeperilakuTs
 * @property OppepelatihanT[] $oppepelatihanTs
 * @property OppekehadiranT[] $oppekehadiranTs
 * @property OppecaringT[] $oppecaringTs
 * @property OppeasesmenT[] $oppeasesmenTs
 * @property OppebimbinganT[] $oppebimbinganTs
 * @property OppeclinicalcareT[] $oppeclinicalcareTs
 */
class IndikatoroppekeperawatanM extends CActiveRecord
{
    public $nama_perawat, $nama_pegawai, $nip_perawat, $bulan_kehadiran, $prosentase_kehadiran, $bulan_caring, $nilai_rata, $bulan_pelatihan, $skor, $bulan_bimbingan, $bulan_clinicalcare, $prosentase_clinicalcare, $bulan_asesmen, $prosentase_asesmen;
    public $pegawai_id, $bulan_pilih, $bulan_pilih_awal, $bulan_pilih_akhir;
    
    /**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return IndikatoroppekeperawatanM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'indikatoroppekeperawatan_m';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('kode_indikator, nama_indikator, standar_nilai, golongan_indikator, rekomendasi, create_loginpemakai_id, create_time', 'required'),
            array('create_loginpemakai_id, update_loginpemakai_id', 'numerical', 'integerOnly' => true),
            array('standar_nilai', 'numerical'),
            array('kode_indikator', 'length', 'max' => 25),
            array('nama_indikator', 'length', 'max' => 255),
            array('golongan_indikator, rekomendasi', 'length', 'max' => 100),
            array('update_time', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('indikatoroppekeperawatan_id, kode_indikator, nama_indikator, standar_nilai, golongan_indikator, rekomendasi, is_aktif, create_loginpemakai_id, create_time, update_loginpemakai_id, update_time', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'oppeperilakuTs' => array(self::HAS_MANY, 'OppeperilakuT', 'indikatoroppekeperawatan_id'),
            'oppepelatihanTs' => array(self::HAS_MANY, 'OppepelatihanT', 'indikatoroppekeperawatan_id'),
            'oppekehadiranTs' => array(self::HAS_MANY, 'OppekehadiranT', 'indikatoroppekeperawatan_id'),
            'oppecaringTs' => array(self::HAS_MANY, 'OppecaringT', 'indikatoroppekeperawatan_id'),
            'oppeasesmenTs' => array(self::HAS_MANY, 'OppeasesmenT', 'indikatoroppekeperawatan_id'),
            'oppebimbinganTs' => array(self::HAS_MANY, 'OppebimbinganT', 'indikatoroppekeperawatan_id'),
            'oppeclinicalcareTs' => array(self::HAS_MANY, 'OppeclinicalcareT', 'indikatoroppekeperawatan_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'indikatoroppekeperawatan_id' => 'ID Indikator',
            'kode_indikator' => 'Kode Indikator',
            'nama_indikator' => 'Nama Indikator',
            'standar_nilai' => 'Standar Nilai',
            'golongan_indikator' => 'Golongan Indikator',
            'rekomendasi' => 'Rekomendasi',
            'is_aktif' => 'Aktif',
            'create_loginpemakai_id' => 'Create Login Pemakai',
            'create_time' => 'Waktu Create',
            'update_loginpemakai_id' => 'Update Login Pemakai',
            'update_time' => 'Waktu Update',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;
        $criteria->compare('indikatoroppekeperawatan_id', $this->indikatoroppekeperawatan_id);
        $criteria->compare('LOWER(kode_indikator)', strtolower($this->kode_indikator), true);
        $criteria->compare('LOWER(nama_indikator)', strtolower($this->nama_indikator), true);
        $criteria->compare('standar_nilai', $this->standar_nilai);
        $criteria->compare('LOWER(golongan_indikator)', strtolower($this->golongan_indikator), true);
        $criteria->compare('LOWER(rekomendasi)', strtolower($this->rekomendasi), true);
        $criteria->compare('is_aktif', isset($this->is_aktif) ? $this->is_aktif : true);
        $criteria->compare('create_loginpemakai_id', $this->create_loginpemakai_id);
        $criteria->compare('create_time', $this->create_time, true);
        $criteria->compare('update_loginpemakai_id', $this->update_loginpemakai_id);
        $criteria->compare('update_time', $this->update_time, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

        
        /**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function searchOppeKeperawatan()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
                
                $criteria->select = 't.*, '
                        . 'ok.nama_perawat, ok.bulan_kehadiran, ok.nip_perawat, ok.prosentase_kehadiran, '
                        . 'oc.bulan_caring, oc.nama_perawat, oc.nip_perawat, oc.nilai_rata, '
                        . 'op.bulan_pelatihan, op.nama_perawat, op.nip_perawat, op.skor, '
                        . 'ob.bulan_bimbingan, ob.nama_perawat, ob.nip_perawat, ob.skor, '
                        . 'ocli.bulan_clinicalcare, ocli.nama_perawat, ocli.nip_perawat, ocli.prosentase_clinicalcare, '
                        . 'oa.bulan_asesmen, oa.nama_perawat, oa.nip_perawat, oa.prosentase_asesmen ';
                $criteria->join = 'JOIN oppekehadiran_t ok ON ok.indikatoroppekeperawatan_id = t.indikatoroppekeperawatan_id '
                        . 'JOIN oppecaring_t oc ON oc.indikatoroppekeperawatan_id = t.indikatoroppekeperawatan_id '
                        . 'JOIN oppepelatihan_t op ON op.indikatoroppekeperawatan_id = t.indikatoroppekeperawatan_id '
                        . 'JOIN oppebimbingan_t ob ON ob.indikatoroppekeperawatan_id = t.indikatoroppekeperawatan_id '
                        . 'JOIN oppeclinicalcare_t ocli ON ocli.indikatoroppekeperawatan_id = t.indikatoroppekeperawatan_id '
                        . 'JOIN oppeasesmen_t oa ON oa.indikatoroppekeperawatan_id = t.indikatoroppekeperawatan_id ';
		$criteria->compare('t.indikatoroppekeperawatan_id',$this->indikatoroppekeperawatan_id);
		$criteria->compare('t.kode_indikator',$this->kode_indikator,true);
		$criteria->compare('t.nama_indikator',$this->nama_indikator,true);
		$criteria->compare('t.standar_nilai',$this->standar_nilai);
		$criteria->compare('t.golongan_indikator',$this->golongan_indikator,true);
		$criteria->compare('t.rekomendasi',$this->rekomendasi,true);
		$criteria->compare('t.is_aktif',$this->is_aktif);
		$criteria->compare('t.create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('t.create_time',$this->create_time,true);
		$criteria->compare('t.update_loginpemakai_id',$this->update_loginpemakai_id);
		$criteria->compare('t.update_time',$this->update_time,true);
//                $criteria->group = $criteria->select;

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        /**
         * Load data program studi
         * @return type
         */
        public function getIndikatorOPPE() {
            return CHtml::listData(
                $this->findAll('is_aktif = true order by nama_indikator ASC'), 'indikatoroppekeperawatan_id', 'nama_indikator'
            );
        }
}
        
