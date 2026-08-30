<?php

/**
 * This is the model class for table "notadinaspengadaan_t".
 *
 * @author  Andyka Putra <andykaputra@.com>
 * @author  Yusuf Putra Anugrah <yusufputra@.com>
 * @package application.models
 * 
 * The followings are the available columns in table 'notadinaspengadaan_t':
 * @property integer $notadinaspengadaan_id
 * @property integer $pengumumanpemenang_id
 * @property integer $persiapanpengadaan_id
 * @property string $notadinaspengadaan_nomor
 * @property string $notadinaspengadaan_tanggal
 * @property string $nomor_notadinas
 * @property integer $supplier_id
 * @property double $harga_negosiasi
 * @property integer $pegawai_id
 * @property string $peg_jabatan
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 * @property integer $konfigtemplatesurat_id
 *
 * The followings are the available model relations:
 * @property SupplierM $supplier
 * @property PegawaiM $pegawai
 * @property PersiapanpengadaanT $persiapanpengadaan
 * @property PengumumanpemenangT $pengumumanpemenang
 */
class NotadinaspengadaanT extends CActiveRecord
{
    public $supplier_nama, $supplier_alamat, $supplier_npwp ;
    public $noindukpegawai, $nama_pegawai;
    public $isi_surat;
    
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return NotadinaspengadaanT the static model class
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
        return 'notadinaspengadaan_t';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('notadinaspengadaan_nomor, supplier_id, pegawai_id, create_time, create_loginpemakai_id, create_ruangan, konfigtemplatesurat_id', 'required'),
            array('pengumumanpemenang_id, persiapanpengadaan_id, supplier_id, pegawai_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, konfigtemplatesurat_id', 'numerical', 'integerOnly'=>true),
            array('harga_negosiasi', 'numerical'),
            array('notadinaspengadaan_nomor, nomor_notadinas', 'length', 'max'=>50),
            array('peg_jabatan', 'length', 'max'=>100),
            array('isverifikasi, pengumuman_nomor, pengumuman_tanggal, update_time, notadinaspengadaan_tanggal, nomor_notadinas', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('notadinaspengadaan_id, pengumumanpemenang_id, persiapanpengadaan_id, notadinaspengadaan_nomor, notadinaspengadaan_tanggal, nomor_notadinas, supplier_id, harga_negosiasi, pegawai_id, peg_jabatan, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, konfigtemplatesurat_id', 'safe', 'on'=>'search'),
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
            'supplier' => array(self::BELONGS_TO, 'SupplierM', 'supplier_id'),
            'pegawai' => array(self::BELONGS_TO, 'PegawaiM', 'pegawai_id'),
            'persiapanpengadaan' => array(self::BELONGS_TO, 'PersiapanpengadaanT', 'persiapanpengadaan_id'),
            'pengumumanpemenang' => array(self::BELONGS_TO, 'PengumumanpemenangT', 'pengumumanpemenang_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'notadinaspengadaan_id' => 'Nota Dinas Pengadaan',
            'pengumumanpemenang_id' => 'Pengumuman Pemenang',
            'persiapanpengadaan_id' => 'Persiapan Pengadaan',
            'notadinaspengadaan_nomor' => 'Nomor Transaksi',
            'notadinaspengadaan_tanggal' => 'Notadinaspengadaan Tanggal',
            'nomor_notadinas' => 'Nomor Notadinas',
            'supplier_id' => 'Supplier',
            'harga_negosiasi' => 'Harga Negosiasi',
            'pegawai_id' => 'Pejabat Pengadaan',
            'peg_jabatan' => 'Jabatan Pengadaan',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
            'create_loginpemakai_id' => 'Create Loginpemakai',
            'update_loginpemakai_id' => 'Update Loginpemakai',
            'create_ruangan' => 'Create Ruangan',
            'konfigtemplatesurat_id' => 'Template Surat',
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

        $criteria->compare('notadinaspengadaan_id',$this->notadinaspengadaan_id);
        $criteria->compare('pengumumanpemenang_id',$this->pengumumanpemenang_id);
        $criteria->compare('persiapanpengadaan_id',$this->persiapanpengadaan_id);
        $criteria->compare('notadinaspengadaan_nomor',$this->notadinaspengadaan_nomor,true);
        $criteria->compare('notadinaspengadaan_tanggal',$this->notadinaspengadaan_tanggal,true);
        $criteria->compare('nomor_notadinas',$this->nomor_notadinas,true);
        $criteria->compare('supplier_id',$this->supplier_id);
        $criteria->compare('harga_negosiasi',$this->harga_negosiasi);
        $criteria->compare('pegawai_id',$this->pegawai_id);
        $criteria->compare('peg_jabatan',$this->peg_jabatan,true);
        $criteria->compare('create_time',$this->create_time,true);
        $criteria->compare('update_time',$this->update_time,true);
        $criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
        $criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id);
        $criteria->compare('create_ruangan',$this->create_ruangan);
        $criteria->compare('konfigtemplatesurat_id',$this->konfigtemplatesurat_id);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }
}