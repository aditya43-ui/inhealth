<?php

/**
 * This is the model class for table "dokumenpengadaan_m".
 *
 * The followings are the available columns in table 'dokumenpengadaan_m':
 * 
 * @package      application.models 
 * @author      M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @author Aida Rahmawati <aidarahmawati@.com>
 * @version     2.0.0
 * @link      <http://piindonesia.co.id>
 * 
 * @property integer $dokumenpengadaan_id
 * @property integer $jenispengadaan_id
 * @property string $dokumenpengadaan_nama
 * @property string $dokumenpengadaan_namalain
 * @property string $dokumenpengadaan_deskripsi
 * @property boolean $dokumenpengadaan_wajib
 * @property string $dokumenpengadaan_jenistransaksi
 * @property integer $dokumenpengadaan_urutan
 * @property boolean $file_zip
 * @property boolean $file_rar
 * @property boolean $file_word
 * @property boolean $file_pdf
 * @property boolean $file_excel
 * @property boolean $file_image
 * @property boolean $dokumenpengadaan_aktif
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property PengadaandokumenpendukungT[] $pengadaandokumenpendukungTs
 * @property JenispengadaanM $jenispengadaan
 * 
 */
class DokumenpengadaanM extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return DokumenpengadaanM the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'dokumenpengadaan_m';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('dokumenpengadaan_jenistransaksi, dokumenpengadaan_nama, dokumenpengadaan_wajib, dokumenpengadaan_aktif, create_time, create_loginpemakai_id, create_ruangan', 'required'),
            array('jenispengadaan_id, dokumenpengadaan_urutan, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly' => true),
            array('dokumenpengadaan_nama, dokumenpengadaan_namalain, dokumenpengadaan_jenistransaksi', 'length', 'max' => 100),
            array('metodepengadaan_id, dokumenpengadaan_deskripsi, file_zip, file_rar, file_word, file_pdf, file_excel, file_image, update_time', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('dokumenpengadaan_id, jenispengadaan_id, dokumenpengadaan_nama, dokumenpengadaan_namalain, dokumenpengadaan_deskripsi, dokumenpengadaan_wajib, dokumenpengadaan_jenistransaksi, dokumenpengadaan_urutan, file_zip, file_rar, file_word, file_pdf, file_excel, file_image, dokumenpengadaan_aktif, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'pengadaandokumenpendukungTs' => array(self::HAS_MANY, 'PengadaandokumenpendukungT', 'dokumenpengadaan_id'),
            'jenispengadaan' => array(self::BELONGS_TO, 'JenispengadaanM', 'jenispengadaan_id'),
            'metodepengadaan' => array(self::BELONGS_TO, 'MetodepengadaanM', 'metodepengadaan_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'dokumenpengadaan_id' => 'Dokumenpengadaan',
            'jenispengadaan_id' => 'Jenis Pengadaan',
            'dokumenpengadaan_nama' => 'Nama',
            'dokumenpengadaan_namalain' => 'Nama Lain',
            'dokumenpengadaan_deskripsi' => 'Deskripsi',
            'dokumenpengadaan_wajib' => 'Wajib',
            'dokumenpengadaan_jenistransaksi' => 'Jenis Transaksi',
            'dokumenpengadaan_urutan' => 'Urutan',
            'file_zip' => 'File Zip',
            'file_rar' => 'File Rar',
            'file_word' => 'File Word',
            'file_pdf' => 'File Pdf',
            'file_excel' => 'File Excel',
            'file_image' => 'File Image',
            'dokumenpengadaan_aktif' => 'Aktif',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
            'create_loginpemakai_id' => 'Create Loginpemakai',
            'update_loginpemakai_id' => 'Update Loginpemakai',
            'create_ruangan' => 'Create Ruangan',
            'metodepengadaan_id' => 'Metode Pengadaan',
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

        $criteria->compare('dokumenpengadaan_id', $this->dokumenpengadaan_id);
        $criteria->compare('jenispengadaan_id', $this->jenispengadaan_id);
        $criteria->compare('metodepengadaan_id', $this->metodepengadaan_id);
        $criteria->compare('dokumenpengadaan_nama', $this->dokumenpengadaan_nama, true);
        $criteria->compare('dokumenpengadaan_namalain', $this->dokumenpengadaan_namalain, true);
        $criteria->compare('dokumenpengadaan_deskripsi', $this->dokumenpengadaan_deskripsi, true);
        $criteria->compare('dokumenpengadaan_wajib', $this->dokumenpengadaan_wajib);
        $criteria->compare('dokumenpengadaan_jenistransaksi', $this->dokumenpengadaan_jenistransaksi, true);
        $criteria->compare('dokumenpengadaan_urutan', $this->dokumenpengadaan_urutan);
        $criteria->compare('file_zip', $this->file_zip);
        $criteria->compare('file_rar', $this->file_rar);
        $criteria->compare('file_word', $this->file_word);
        $criteria->compare('file_pdf', $this->file_pdf);
        $criteria->compare('file_excel', $this->file_excel);
        $criteria->compare('file_image', $this->file_image);
        $criteria->compare('dokumenpengadaan_aktif', $this->dokumenpengadaan_aktif);
        $criteria->compare('create_time', $this->create_time, true);
        $criteria->compare('update_time', $this->update_time, true);
        $criteria->compare('create_loginpemakai_id', $this->create_loginpemakai_id);
        $criteria->compare('update_loginpemakai_id', $this->update_loginpemakai_id);
        $criteria->compare('create_ruangan', $this->create_ruangan);
        $criteria->order = 'dokumenpengadaan_jenistransaksi';

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Load data untuk dicetak
     * @return \CActiveDataProvider
     */
    public function searchPrint() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('dokumenpengadaan_id', $this->dokumenpengadaan_id);
        $criteria->compare('metodepengadaan_id', $this->metodepengadaan_id);
        $criteria->compare('jenispengadaan_id', $this->jenispengadaan_id);
        $criteria->compare('dokumenpengadaan_nama', $this->dokumenpengadaan_nama, true);
        $criteria->compare('dokumenpengadaan_namalain', $this->dokumenpengadaan_namalain, true);
        $criteria->compare('dokumenpengadaan_deskripsi', $this->dokumenpengadaan_deskripsi, true);
        $criteria->compare('dokumenpengadaan_wajib', $this->dokumenpengadaan_wajib);
        $criteria->compare('dokumenpengadaan_jenistransaksi', $this->dokumenpengadaan_jenistransaksi, true);
        $criteria->compare('dokumenpengadaan_urutan', $this->dokumenpengadaan_urutan);
        $criteria->compare('file_zip', $this->file_zip);
        $criteria->compare('file_rar', $this->file_rar);
        $criteria->compare('file_word', $this->file_word);
        $criteria->compare('file_pdf', $this->file_pdf);
        $criteria->compare('file_excel', $this->file_excel);
        $criteria->compare('file_image', $this->file_image);
        $criteria->compare('dokumenpengadaan_aktif', $this->dokumenpengadaan_aktif);
        $criteria->limit = -1;
        $criteria->order = 'dokumenpengadaan_jenistransaksi';

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => false,
        ));
    }

}
