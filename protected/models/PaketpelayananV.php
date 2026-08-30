<?php

/**
 * This is the model class for table "paketpelayanan_v".
 *
 * The followings are the available columns in table 'paketpelayanan_v':
 * @property integer $daftartindakan_id
 * @property string $daftartindakan_nama
 * @property integer $kategoritindakan_id
 * @property string $kategoritindakan_nama
 * @property integer $kelompoktindakan_id
 * @property string $kelompoktindakan_nama
 * @property string $tindakanmedis_nama
 * @property string $tipepaket_nama
 * @property integer $kelaspelayanan_id
 * @property string $kelaspelayanan_nama
 * @property integer $jeniskelas_id
 * @property integer $carabayar_id
 * @property string $carabayar_nama
 * @property integer $penjamin_id
 * @property string $penjamin_nama
 * @property integer $ruangan_id
 * @property string $namatindakan
 * @property double $tarifpaketpel
 * @property double $subsidiasuransi
 * @property double $subsidipemerintah
 * @property double $subsidirumahsakit
 * @property double $iurbiaya
 * @property boolean $tipepaket_aktif
 * @property string $tglkesepakatantarif
 * @property string $nokesepakatantarif
 * @property double $tarifpaket
 * @property double $paketsubsidiasuransi
 * @property double $paketsubsidipemerintah
 * @property double $paketsubsidirs
 * @property double $paketiurbiaya
 * @property string $keterangan_tipepaket
 * @property integer $tipepaket_id
 */
class PaketpelayananV extends CActiveRecord
{
    public $hargacyto_tind, $totaltarifakhir_cyto;
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return PaketpelayananV the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'paketpelayanan_v';
    }
    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('daftartindakan_id, kategoritindakan_id, kelompoktindakan_id, kelaspelayanan_id, jeniskelas_id, carabayar_id, penjamin_id, ruangan_id, tipepaket_id', 'numerical', 'integerOnly' => true),
            array('tarifpaketpel, subsidiasuransi, subsidipemerintah, subsidirumahsakit, iurbiaya, tarifpaket, paketsubsidiasuransi, paketsubsidipemerintah, paketsubsidirs, paketiurbiaya', 'numerical'),
            array('daftartindakan_nama, tindakanmedis_nama', 'length', 'max' => 200),
            array('kategoritindakan_nama', 'length', 'max' => 30),
            array('kelompoktindakan_nama, tipepaket_nama, kelaspelayanan_nama, carabayar_nama, penjamin_nama, nokesepakatantarif', 'length', 'max' => 50),
            array('namatindakan', 'length', 'max' => 100),
            array('tipepaket_aktif, tglkesepakatantarif, keterangan_tipepaket', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('daftartindakan_id, daftartindakan_nama, kategoritindakan_id, kategoritindakan_nama, kelompoktindakan_id, kelompoktindakan_nama, tindakanmedis_nama, tipepaket_nama, kelaspelayanan_id, kelaspelayanan_nama, jeniskelas_id, carabayar_id, carabayar_nama, penjamin_id, penjamin_nama, ruangan_id, namatindakan, tarifpaketpel, subsidiasuransi, subsidipemerintah, subsidirumahsakit, iurbiaya, tipepaket_aktif, tglkesepakatantarif, nokesepakatantarif, tarifpaket, paketsubsidiasuransi, paketsubsidipemerintah, paketsubsidirs, paketiurbiaya, keterangan_tipepaket, tipepaket_id', 'safe', 'on' => 'search'),
        );
    }
    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array();
    }
    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'daftartindakan_id' => 'Daftartindakan',
            'daftartindakan_nama' => 'Nama Daftar Tindakan',
            'kategoritindakan_id' => 'Kategoritindakan',
            'kategoritindakan_nama' => 'Nama Kategori Tindakan',
            'kelompoktindakan_id' => 'Kelompoktindakan',
            'kelompoktindakan_nama' => 'Kelompoktindakan Nama',
            'tindakanmedis_nama' => 'Tindakanmedis Nama',
            'tipepaket_nama' => 'Tipe Paket',
            'kelaspelayanan_id' => 'Kelas Pelayanan',
            'kelaspelayanan_nama' => 'Kelas Pelayanan',
            'jeniskelas_id' => 'Jenis Kelas',
            'carabayar_id' => 'Jenis Penjamin',
            'carabayar_nama' => 'Jenis Penjamin',
            'penjamin_id' => 'Penjamin',
            'penjamin_nama' => 'Penjamin',
            'ruangan_id' => 'Ruangan',
            'namatindakan' => 'Namatindakan',
            'tarifpaketpel' => 'Tarifpaketpel',
            'subsidiasuransi' => 'Tanggungan Asuransi',
            'subsidipemerintah' => 'Tanggungan Pemerintah',
            'subsidirumahsakit' => 'Tanggungan Rumah Sakit',
            'iurbiaya' => 'Iurbiaya',
            'tipepaket_aktif' => 'Tipepaket Aktif',
            'tglkesepakatantarif' => 'Tglkesepakatantarif',
            'nokesepakatantarif' => 'Nokesepakatantarif',
            'tarifpaket' => 'Tarifpaket',
            'paketsubsidiasuransi' => 'Tanggungan Asuransi Paket',
            'paketsubsidipemerintah' => 'Tanggungan Pemerintah Paket',
            'paketsubsidirs' => 'Tanggungan Rumah Sakit Paket',
            'paketiurbiaya' => 'Iur Biaya',
            'keterangan_tipepaket' => 'Keterangan Tipepaket',
            'tipepaket_id' => 'Tipepaket',
            'daftartindakan_kode' => 'Kode Daftar Tindakan',
            'harga_tariftindakan' => 'Harga Nominal Tarif'
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
        $criteria = new CDbCriteria;
        $criteria->compare('daftartindakan_id', $this->daftartindakan_id);
        $criteria->compare('LOWER(daftartindakan_nama)', strtolower($this->daftartindakan_nama), true);
        $criteria->compare('kategoritindakan_id', $this->kategoritindakan_id);
        $criteria->compare('LOWER(kategoritindakan_nama)', strtolower($this->kategoritindakan_nama), true);
        $criteria->compare('kelompoktindakan_id', $this->kelompoktindakan_id);
        $criteria->compare('LOWER(kelompoktindakan_nama)', strtolower($this->kelompoktindakan_nama), true);
        $criteria->compare('LOWER(tindakanmedis_nama)', strtolower($this->tindakanmedis_nama), true);
        $criteria->compare('LOWER(tipepaket_nama)', strtolower($this->tipepaket_nama), true);
        $criteria->compare('kelaspelayanan_id', $this->kelaspelayanan_id);
        $criteria->compare('LOWER(kelaspelayanan_nama)', strtolower($this->kelaspelayanan_nama), true);
        $criteria->compare('jeniskelas_id', $this->jeniskelas_id);
        $criteria->compare('carabayar_id', $this->carabayar_id);
        $criteria->compare('LOWER(carabayar_nama)', strtolower($this->carabayar_nama), true);
        $criteria->compare('penjamin_id', $this->penjamin_id);
        $criteria->compare('LOWER(penjamin_nama)', strtolower($this->penjamin_nama), true);
        $criteria->compare('ruangan_id', $this->ruangan_id);
        $criteria->compare('LOWER(namatindakan)', strtolower($this->namatindakan), true);
        $criteria->compare('tarifpaketpel', $this->tarifpaketpel);
        $criteria->compare('subsidiasuransi', $this->subsidiasuransi);
        $criteria->compare('subsidipemerintah', $this->subsidipemerintah);
        $criteria->compare('subsidirumahsakit', $this->subsidirumahsakit);
        $criteria->compare('iurbiaya', $this->iurbiaya);
        $criteria->compare('tipepaket_aktif', $this->tipepaket_aktif);
        $criteria->compare('LOWER(tglkesepakatantarif)', strtolower($this->tglkesepakatantarif), true);
        $criteria->compare('LOWER(nokesepakatantarif)', strtolower($this->nokesepakatantarif), true);
        $criteria->compare('tarifpaket', $this->tarifpaket);
        $criteria->compare('paketsubsidiasuransi', $this->paketsubsidiasuransi);
        $criteria->compare('paketsubsidipemerintah', $this->paketsubsidipemerintah);
        $criteria->compare('paketsubsidirs', $this->paketsubsidirs);
        $criteria->compare('paketiurbiaya', $this->paketiurbiaya);
        $criteria->compare('LOWER(keterangan_tipepaket)', strtolower($this->keterangan_tipepaket), true);
        $criteria->compare('tipepaket_id', $this->tipepaket_id);
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
    public function searchInformasi()
    {
        $criteria = new CDbCriteria();
        $criteria->compare('kelaspelayanan_id', $this->kelaspelayanan_id);
        $criteria->compare('lower(tipepaket_nama)', strtolower($this->tipepaket_nama), true);
        $criteria->compare('carabayar_id', $this->carabayar_id);
        $criteria->compare('penjamin_id', $this->penjamin_id);
        $criteria->group = $criteria->select = 'tipepaket_id, tipepaket_nama, '
            . 'kelaspelayanan_id, kelaspelayanan_nama, '
            . 'carabayar_id, carabayar_nama, '
            . 'penjamin_id, penjamin_nama, '
            . 'tarifpaket, paketsubsidiasuransi, paketiurbiaya';
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
    public function searchPrint()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.
        $criteria = new CDbCriteria;
        $criteria->compare('daftartindakan_id', $this->daftartindakan_id);
        $criteria->compare('LOWER(daftartindakan_nama)', strtolower($this->daftartindakan_nama), true);
        $criteria->compare('kategoritindakan_id', $this->kategoritindakan_id);
        $criteria->compare('LOWER(kategoritindakan_nama)', strtolower($this->kategoritindakan_nama), true);
        $criteria->compare('kelompoktindakan_id', $this->kelompoktindakan_id);
        $criteria->compare('LOWER(kelompoktindakan_nama)', strtolower($this->kelompoktindakan_nama), true);
        $criteria->compare('LOWER(tindakanmedis_nama)', strtolower($this->tindakanmedis_nama), true);
        $criteria->compare('LOWER(tipepaket_nama)', strtolower($this->tipepaket_nama), true);
        $criteria->compare('kelaspelayanan_id', $this->kelaspelayanan_id);
        $criteria->compare('LOWER(kelaspelayanan_nama)', strtolower($this->kelaspelayanan_nama), true);
        $criteria->compare('jeniskelas_id', $this->jeniskelas_id);
        $criteria->compare('carabayar_id', $this->carabayar_id);
        $criteria->compare('LOWER(carabayar_nama)', strtolower($this->carabayar_nama), true);
        $criteria->compare('penjamin_id', $this->penjamin_id);
        $criteria->compare('LOWER(penjamin_nama)', strtolower($this->penjamin_nama), true);
        $criteria->compare('ruangan_id', $this->ruangan_id);
        $criteria->compare('LOWER(namatindakan)', strtolower($this->namatindakan), true);
        $criteria->compare('tarifpaketpel', $this->tarifpaketpel);
        $criteria->compare('subsidiasuransi', $this->subsidiasuransi);
        $criteria->compare('subsidipemerintah', $this->subsidipemerintah);
        $criteria->compare('subsidirumahsakit', $this->subsidirumahsakit);
        $criteria->compare('iurbiaya', $this->iurbiaya);
        $criteria->compare('tipepaket_aktif', $this->tipepaket_aktif);
        $criteria->compare('LOWER(tglkesepakatantarif)', strtolower($this->tglkesepakatantarif), true);
        $criteria->compare('LOWER(nokesepakatantarif)', strtolower($this->nokesepakatantarif), true);
        $criteria->compare('tarifpaket', $this->tarifpaket);
        $criteria->compare('paketsubsidiasuransi', $this->paketsubsidiasuransi);
        $criteria->compare('paketsubsidipemerintah', $this->paketsubsidipemerintah);
        $criteria->compare('paketsubsidirs', $this->paketsubsidirs);
        $criteria->compare('paketiurbiaya', $this->paketiurbiaya);
        $criteria->compare('LOWER(keterangan_tipepaket)', strtolower($this->keterangan_tipepaket), true);
        $criteria->compare('tipepaket_id', $this->tipepaket_id);
        // Klo limit lebih kecil dari nol itu berarti ga ada limit 
        $criteria->limit = -1;
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => false,
        ));
    }
    public function getKelasPelayananItems()
    {
        return KelaspelayananM::model()->findAll("kelaspelayanan_aktif = TRUE ORDER BY kelaspelayanan_nama ASC");
    }
}
