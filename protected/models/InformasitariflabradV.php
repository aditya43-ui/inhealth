<?php

/**
 * This is the model class for table "informasitariflabrad_v".
 *
 * The followings are the available columns in table 'informasitariflabrad_v':
 * @property string $daftartindakan_kode
 * @property string $daftartindakan_nama
 * @property string $daftartindakan_namalainnya
 * @property string $daftartindakan_katakunci
 * @property integer $perdatarif_id
 * @property string $perdanama_sk
 * @property string $noperda
 * @property string $tglperda
 * @property string $perdatentang
 * @property string $ditetapkanoleh
 * @property string $tempatditetapkan
 * @property integer $jenistarif_id
 * @property string $jenistarif_nama
 * @property integer $tariftindakan_id
 * @property integer $komponentarif_id
 * @property string $komponentarif_nama
 * @property double $harga_tariftindakan
 * @property integer $persendiskon_tind
 * @property double $hargadiskon_tind
 * @property integer $persencyto_tind
 * @property integer $jeniskelas_id
 * @property string $jeniskelas_nama
 * @property integer $kelaspelayanan_id
 * @property string $kelaspelayanan_nama
 * @property string $kelaspelayanan_namalainnya
 * @property integer $daftartindakan_id
 * @property string $jenispemeriksaanlab_nama
 * @property integer $pemeriksaanlab_id
 * @property string $pemeriksaanlab_kode
 * @property string $pemeriksaanlab_nama
 * @property string $pemeriksaanlab_namalainnya
 */
class InformasitariflabradV extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return InformasitariflabradV the static model class
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
        return 'informasitariflabrad_v';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('perdatarif_id, jenistarif_id, tariftindakan_id, komponentarif_id, persendiskon_tind, persencyto_tind, jeniskelas_id, kelaspelayanan_id, daftartindakan_id, pemeriksaanlab_id', 'numerical', 'integerOnly'=>true),
            array('harga_tariftindakan, hargadiskon_tind', 'numerical'),
            array('daftartindakan_kode, noperda', 'length', 'max'=>20),
            array('daftartindakan_nama, daftartindakan_namalainnya, perdanama_sk', 'length', 'max'=>200),
            array('daftartindakan_katakunci, ditetapkanoleh, tempatditetapkan', 'length', 'max'=>30),
            array('jenistarif_nama, komponentarif_nama, jeniskelas_nama', 'length', 'max'=>25),
            array('kelaspelayanan_nama, kelaspelayanan_namalainnya', 'length', 'max'=>50),
            array('tglperda, perdatentang, jenispemeriksaanlab_nama, pemeriksaanlab_kode, pemeriksaanlab_nama, pemeriksaanlab_namalainnya', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('daftartindakan_kode, daftartindakan_nama, daftartindakan_namalainnya, daftartindakan_katakunci, perdatarif_id, perdanama_sk, noperda, tglperda, perdatentang, ditetapkanoleh, tempatditetapkan, jenistarif_id, jenistarif_nama, tariftindakan_id, komponentarif_id, komponentarif_nama, harga_tariftindakan, persendiskon_tind, hargadiskon_tind, persencyto_tind, jeniskelas_id, jeniskelas_nama, kelaspelayanan_id, kelaspelayanan_nama, kelaspelayanan_namalainnya, daftartindakan_id, jenispemeriksaanlab_nama, pemeriksaanlab_id, pemeriksaanlab_kode, pemeriksaanlab_nama, pemeriksaanlab_namalainnya', 'safe', 'on'=>'search'),
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
            'daftartindakan_kode' => 'Kode Daftar Tindakan',
            'daftartindakan_nama' => 'Daftar Tindakan',
            'daftartindakan_namalainnya' => 'Nama Daftar Tindakan Lain',
            'daftartindakan_katakunci' => 'Daftar Tindakan Katakunci',
            'perdatarif_id' => 'Perda Tarif',
            'perdanama_sk' => 'Perda Nama SK',
            'noperda' => 'No. Perda',
            'tglperda' => 'Tanggal Perda',
            'perdatentang' => 'Perda Tentang',
            'ditetapkanoleh' => 'Ditetapkan Oleh',
            'tempatditetapkan' => 'Ditetapkan Di',
            'jenistarif_id' => 'Jenis Tarif',
            'jenistarif_nama' => 'Jenis Tarif',
            'tariftindakan_id' => 'Nominal Tarif',
            'komponentarif_id' => 'Komponen Tarif',
            'komponentarif_nama' => 'Komponen Tarif',
            'harga_tariftindakan' => 'Harga Nominal Tarif',
            'persendiskon_tind' => 'Persen Keringanan',
            'hargadiskon_tind' => 'Harga Keringanan',
            'persencyto_tind' => 'Persen Cyto',
            'jeniskelas_id' => 'Jenis Kelas',
            'jeniskelas_nama' => 'Jenis Kelas',
            'kelaspelayanan_id' => 'Kelas Pelayanan',
            'kelaspelayanan_nama' => 'Kelas Pelayanan',
            'kelaspelayanan_namalainnya' => 'Kelas Pelayanan Nama lain',
            'daftartindakan_id' => 'Daftar Tindakan',
            'jenispemeriksaanlab_nama' => 'Jenis Pemeriksaan',
            'pemeriksaanlab_id' => 'Pemeriksaan',
            'pemeriksaanlab_kode' => 'Kode Pemeriksaan',
            'pemeriksaanlab_nama' => 'Nama Pemeriksaan',
            'pemeriksaanlab_namalainnya' => 'Pemeriksaan Nama lainnya',
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

        $criteria->compare('LOWER(daftartindakan_kode)',strtolower($this->daftartindakan_kode),true);
        $criteria->compare('LOWER(daftartindakan_nama)',strtolower($this->daftartindakan_nama),true);
        $criteria->compare('LOWER(daftartindakan_namalainnya)',strtolower($this->daftartindakan_namalainnya),true);
        $criteria->compare('LOWER(daftartindakan_katakunci)',strtolower($this->daftartindakan_katakunci),true);
        $criteria->compare('perdatarif_id',$this->perdatarif_id);
        $criteria->compare('LOWER(perdanama_sk)',strtolower($this->perdanama_sk),true);
        $criteria->compare('LOWER(noperda)',strtolower($this->noperda),true);
        $criteria->compare('LOWER(tglperda)',strtolower($this->tglperda),true);
        $criteria->compare('LOWER(perdatentang)',strtolower($this->perdatentang),true);
        $criteria->compare('LOWER(ditetapkanoleh)',strtolower($this->ditetapkanoleh),true);
        $criteria->compare('LOWER(tempatditetapkan)',strtolower($this->tempatditetapkan),true);
        $criteria->compare('jenistarif_id',$this->jenistarif_id);
        $criteria->compare('LOWER(jenistarif_nama)',strtolower($this->jenistarif_nama),true);
        $criteria->compare('tariftindakan_id',$this->tariftindakan_id);
        $criteria->compare('komponentarif_id',$this->komponentarif_id);
        $criteria->compare('LOWER(komponentarif_nama)',strtolower($this->komponentarif_nama),true);
        $criteria->compare('harga_tariftindakan',$this->harga_tariftindakan);
        $criteria->compare('persendiskon_tind',$this->persendiskon_tind);
        $criteria->compare('hargadiskon_tind',$this->hargadiskon_tind);
        $criteria->compare('persencyto_tind',$this->persencyto_tind);
        $criteria->compare('jeniskelas_id',$this->jeniskelas_id);
        $criteria->compare('LOWER(jeniskelas_nama)',strtolower($this->jeniskelas_nama),true);
        $criteria->compare('kelaspelayanan_id',$this->kelaspelayanan_id);
        $criteria->compare('LOWER(kelaspelayanan_nama)',strtolower($this->kelaspelayanan_nama),true);
        $criteria->compare('LOWER(kelaspelayanan_namalainnya)',strtolower($this->kelaspelayanan_namalainnya),true);
        $criteria->compare('daftartindakan_id',$this->daftartindakan_id);
        $criteria->compare('LOWER(jenispemeriksaanlab_nama)',strtolower($this->jenispemeriksaanlab_nama),true);
        $criteria->compare('pemeriksaanlab_id',$this->pemeriksaanlab_id);
        $criteria->compare('LOWER(pemeriksaanlab_kode)',strtolower($this->pemeriksaanlab_kode),true);
        $criteria->compare('LOWER(pemeriksaanlab_nama)',strtolower($this->pemeriksaanlab_nama),true);
        $criteria->compare('LOWER(pemeriksaanlab_namalainnya)',strtolower($this->pemeriksaanlab_namalainnya),true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }
      
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
        $criteria->compare('LOWER(daftartindakan_kode)',strtolower($this->daftartindakan_kode),true);
        $criteria->compare('LOWER(daftartindakan_nama)',strtolower($this->daftartindakan_nama),true);
        $criteria->compare('LOWER(daftartindakan_namalainnya)',strtolower($this->daftartindakan_namalainnya),true);
        $criteria->compare('LOWER(daftartindakan_katakunci)',strtolower($this->daftartindakan_katakunci),true);
        $criteria->compare('perdatarif_id',$this->perdatarif_id);
        $criteria->compare('LOWER(perdanama_sk)',strtolower($this->perdanama_sk),true);
        $criteria->compare('LOWER(noperda)',strtolower($this->noperda),true);
        $criteria->compare('LOWER(tglperda)',strtolower($this->tglperda),true);
        $criteria->compare('LOWER(perdatentang)',strtolower($this->perdatentang),true);
        $criteria->compare('LOWER(ditetapkanoleh)',strtolower($this->ditetapkanoleh),true);
        $criteria->compare('LOWER(tempatditetapkan)',strtolower($this->tempatditetapkan),true);
        $criteria->compare('jenistarif_id',$this->jenistarif_id);
        $criteria->compare('LOWER(jenistarif_nama)',strtolower($this->jenistarif_nama),true);
        $criteria->compare('tariftindakan_id',$this->tariftindakan_id);
        $criteria->compare('komponentarif_id',$this->komponentarif_id);
        $criteria->compare('LOWER(komponentarif_nama)',strtolower($this->komponentarif_nama),true);
        $criteria->compare('harga_tariftindakan',$this->harga_tariftindakan);
        $criteria->compare('persendiskon_tind',$this->persendiskon_tind);
        $criteria->compare('hargadiskon_tind',$this->hargadiskon_tind);
        $criteria->compare('persencyto_tind',$this->persencyto_tind);
        $criteria->compare('jeniskelas_id',$this->jeniskelas_id);
        $criteria->compare('LOWER(jeniskelas_nama)',strtolower($this->jeniskelas_nama),true);
        $criteria->compare('kelaspelayanan_id',$this->kelaspelayanan_id);
        $criteria->compare('LOWER(kelaspelayanan_nama)',strtolower($this->kelaspelayanan_nama),true);
        $criteria->compare('LOWER(kelaspelayanan_namalainnya)',strtolower($this->kelaspelayanan_namalainnya),true);
        $criteria->compare('daftartindakan_id',$this->daftartindakan_id);
        $criteria->compare('LOWER(jenispemeriksaanlab_nama)',strtolower($this->jenispemeriksaanlab_nama),true);
        $criteria->compare('pemeriksaanlab_id',$this->pemeriksaanlab_id);
        $criteria->compare('LOWER(pemeriksaanlab_kode)',strtolower($this->pemeriksaanlab_kode),true);
        $criteria->compare('LOWER(pemeriksaanlab_nama)',strtolower($this->pemeriksaanlab_nama),true);
        $criteria->compare('LOWER(pemeriksaanlab_namalainnya)',strtolower($this->pemeriksaanlab_namalainnya),true);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
} 
?>
