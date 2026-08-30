<?php

/**
 * This is the model class for table "pegawaikaryawan_v".
 *
 * The followings are the available columns in table 'pegawaikaryawan_v':
 * @property integer $pegawai_id
 * @property string $gelardepan
 * @property string $nama_pegawai
 * @property string $gelarbelakang_nama
 * @property string $jeniskelamin
 * @property string $nama_keluarga
 * @property string $tempatlahir_pegawai
 * @property string $tgl_lahirpegawai
 * @property string $alamat_pegawai
 * @property boolean $pegawai_aktif
 * @property string $agama
 * @property string $golongandarah
 * @property string $alamatemail
 * @property string $notelp_pegawai
 * @property string $nomobile_pegawai
 * @property string $photopegawai
 * @property integer $pendidikan_id
 * @property string $pendidikan_nama
 * @property integer $pendkualifikasi_id
 * @property string $pendkualifikasi_nama
 * @property string $nomorindukpegawai
 * @property integer $pangkat_id
 * @property integer $kelompokpegawai_id
 * @property integer $jabatan_id
 */
class PegawaikaryawanV extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return PegawaikaryawanV the static model class
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
        return 'pegawaikaryawan_v';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('pegawai_id, pendidikan_id, pendkualifikasi_id, pangkat_id, kelompokpegawai_id, jabatan_id', 'numerical', 'integerOnly'=>true),
            array('gelardepan', 'length', 'max'=>10),
            array('nama_pegawai, nama_keluarga, notelp_pegawai, nomobile_pegawai, pendidikan_nama, pendkualifikasi_nama', 'length', 'max'=>50),
            array('gelarbelakang_nama', 'length', 'max'=>15),
            array('jeniskelamin, agama', 'length', 'max'=>20),
            array('tempatlahir_pegawai, nomorindukpegawai', 'length', 'max'=>30),
            array('golongandarah', 'length', 'max'=>2),
            array('alamatemail', 'length', 'max'=>100),
            array('photopegawai', 'length', 'max'=>200),
            array('tgl_lahirpegawai, alamat_pegawai, pegawai_aktif', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('pegawai_id, gelardepan, nama_pegawai, gelarbelakang_nama, jeniskelamin, nama_keluarga, tempatlahir_pegawai, tgl_lahirpegawai, alamat_pegawai, pegawai_aktif, agama, golongandarah, alamatemail, notelp_pegawai, nomobile_pegawai, photopegawai, pendidikan_id, pendidikan_nama, pendkualifikasi_id, pendkualifikasi_nama, nomorindukpegawai, pangkat_id, kelompokpegawai_id, jabatan_id', 'safe', 'on'=>'search'),
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
            'pegawai_id' => 'Pegawai',
            'gelardepan' => 'Gelardepan',
            'nama_pegawai' => 'Nama Pegawai',
            'gelarbelakang_nama' => 'Gelarbelakang Nama',
            'jeniskelamin' => 'Jenis Kelamin',
            'nama_keluarga' => 'Nama Keluarga',
            'tempatlahir_pegawai' => 'Tempatlahir Pegawai',
            'tgl_lahirpegawai' => 'Tanggal Lahirpegawai',
            'alamat_pegawai' => 'Alamat Pegawai',
            'pegawai_aktif' => 'Pegawai Aktif',
            'agama' => 'Agama',
            'golongandarah' => 'Golongandarah',
            'alamatemail' => 'Alamatemail',
            'notelp_pegawai' => 'Notelp Pegawai',
            'nomobile_pegawai' => 'Nomobile Pegawai',
            'photopegawai' => 'Photopegawai',
            'pendidikan_id' => 'Pendidikan',
            'pendidikan_nama' => 'Pendidikan Nama',
            'pendkualifikasi_id' => 'Pendkualifikasi',
            'pendkualifikasi_nama' => 'Pendkualifikasi Nama',
            'nomorindukpegawai' => 'Nomorindukpegawai',
            'pangkat_id' => 'Pangkat',
            'kelompokpegawai_id' => 'Kelompokpegawai',
            'jabatan_id' => 'Jabatan',
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

        $criteria->compare('pegawai_id',$this->pegawai_id);
        $criteria->compare('LOWER(gelardepan)',strtolower($this->gelardepan),true);
        $criteria->compare('LOWER(nama_pegawai)',strtolower($this->nama_pegawai),true);
        $criteria->compare('LOWER(gelarbelakang_nama)',strtolower($this->gelarbelakang_nama),true);
        $criteria->compare('LOWER(jeniskelamin)',strtolower($this->jeniskelamin),true);
        $criteria->compare('LOWER(nama_keluarga)',strtolower($this->nama_keluarga),true);
        $criteria->compare('LOWER(tempatlahir_pegawai)',strtolower($this->tempatlahir_pegawai),true);
        $criteria->compare('LOWER(tgl_lahirpegawai)',strtolower($this->tgl_lahirpegawai),true);
        $criteria->compare('LOWER(alamat_pegawai)',strtolower($this->alamat_pegawai),true);
        $criteria->compare('pegawai_aktif',$this->pegawai_aktif);
        $criteria->compare('LOWER(agama)',strtolower($this->agama),true);
        $criteria->compare('LOWER(golongandarah)',strtolower($this->golongandarah),true);
        $criteria->compare('LOWER(alamatemail)',strtolower($this->alamatemail),true);
        $criteria->compare('LOWER(notelp_pegawai)',strtolower($this->notelp_pegawai),true);
        $criteria->compare('LOWER(nomobile_pegawai)',strtolower($this->nomobile_pegawai),true);
        $criteria->compare('LOWER(photopegawai)',strtolower($this->photopegawai),true);
        $criteria->compare('pendidikan_id',$this->pendidikan_id);
        $criteria->compare('LOWER(pendidikan_nama)',strtolower($this->pendidikan_nama),true);
        $criteria->compare('pendkualifikasi_id',$this->pendkualifikasi_id);
        $criteria->compare('LOWER(pendkualifikasi_nama)',strtolower($this->pendkualifikasi_nama),true);
        $criteria->compare('LOWER(nomorindukpegawai)',strtolower($this->nomorindukpegawai),true);
        $criteria->compare('pangkat_id',$this->pangkat_id);
        $criteria->compare('kelompokpegawai_id',$this->kelompokpegawai_id);
        $criteria->compare('jabatan_id',$this->jabatan_id);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
        $criteria->compare('pegawai_id',$this->pegawai_id);
        $criteria->compare('LOWER(gelardepan)',strtolower($this->gelardepan),true);
        $criteria->compare('LOWER(nama_pegawai)',strtolower($this->nama_pegawai),true);
        $criteria->compare('LOWER(gelarbelakang_nama)',strtolower($this->gelarbelakang_nama),true);
        $criteria->compare('LOWER(jeniskelamin)',strtolower($this->jeniskelamin),true);
        $criteria->compare('LOWER(nama_keluarga)',strtolower($this->nama_keluarga),true);
        $criteria->compare('LOWER(tempatlahir_pegawai)',strtolower($this->tempatlahir_pegawai),true);
        $criteria->compare('LOWER(tgl_lahirpegawai)',strtolower($this->tgl_lahirpegawai),true);
        $criteria->compare('LOWER(alamat_pegawai)',strtolower($this->alamat_pegawai),true);
        $criteria->compare('pegawai_aktif',$this->pegawai_aktif);
        $criteria->compare('LOWER(agama)',strtolower($this->agama),true);
        $criteria->compare('LOWER(golongandarah)',strtolower($this->golongandarah),true);
        $criteria->compare('LOWER(alamatemail)',strtolower($this->alamatemail),true);
        $criteria->compare('LOWER(notelp_pegawai)',strtolower($this->notelp_pegawai),true);
        $criteria->compare('LOWER(nomobile_pegawai)',strtolower($this->nomobile_pegawai),true);
        $criteria->compare('LOWER(photopegawai)',strtolower($this->photopegawai),true);
        $criteria->compare('pendidikan_id',$this->pendidikan_id);
        $criteria->compare('LOWER(pendidikan_nama)',strtolower($this->pendidikan_nama),true);
        $criteria->compare('pendkualifikasi_id',$this->pendkualifikasi_id);
        $criteria->compare('LOWER(pendkualifikasi_nama)',strtolower($this->pendkualifikasi_nama),true);
        $criteria->compare('LOWER(nomorindukpegawai)',strtolower($this->nomorindukpegawai),true);
        $criteria->compare('pangkat_id',$this->pangkat_id);
        $criteria->compare('kelompokpegawai_id',$this->kelompokpegawai_id);
        $criteria->compare('jabatan_id',$this->jabatan_id);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
}
?>
