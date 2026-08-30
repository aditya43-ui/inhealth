<?php

/**
 * This is the model class for table "daftarpemberianobatrutin_v".
 *
 * The followings are the available columns in table 'daftarpemberianobatrutin_v':
 * @property integer $catatanpemberianobatdet_id
 * @property integer $catatanpemberianobat_id
 * @property integer $pendaftaran_id
 * @property integer $pasienadmisi_id
 * @property integer $pasien_id
 * @property integer $penjualanresep_id
 * @property string $tglpenjualan
 * @property string $tglpenyerahan
 * @property integer $reseptur_id
 * @property string $tglreseptur
 * @property string $noresep
 * @property integer $racikan_id
 * @property string $racikan_nama
 * @property integer $obatalkes_id
 * @property string $obatalkes_nama
 * @property integer $subjenis_id
 * @property string $subjenis_nama
 * @property string $dosisobat
 * @property string $aturanpakaiobat
 * @property string $carapemberian
 * @property integer $pegawai_id
 * @property string $penerima_peg_nama
 * @property string $penerimaan_status
 * @property string $penerimaan_waktu
 * @property integer $jadwalpemberianobat_id
 * @property string $jadwal
 * @property string $tanda
 * @property string $tanggal_pemberian
 * @property string $jam_pemberian
 * @property string $initial
 */
class DaftarpemberianobatrutinV extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'daftarpemberianobatrutin_v';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('catatanpemberianobatdet_id, catatanpemberianobat_id, pendaftaran_id, pasienadmisi_id, pasien_id, penjualanresep_id, reseptur_id, racikan_id, obatalkes_id, subjenis_id, pegawai_id, jadwalpemberianobat_id', 'numerical', 'integerOnly'=>true),
            array('noresep, racikan_nama, penerima_peg_nama, jadwal, initial', 'length', 'max'=>50),
            array('obatalkes_nama', 'length', 'max'=>200),
            array('subjenis_nama, dosisobat, aturanpakaiobat, carapemberian, tanda', 'length', 'max'=>100),
            array('penerimaan_status', 'length', 'max'=>20),
            array('tglpenjualan, tglpenyerahan, tglreseptur, penerimaan_waktu, tanggal_pemberian, jam_pemberian', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('catatanpemberianobatdet_id, catatanpemberianobat_id, pendaftaran_id, pasienadmisi_id, pasien_id, penjualanresep_id, tglpenjualan, tglpenyerahan, reseptur_id, tglreseptur, noresep, racikan_id, racikan_nama, obatalkes_id, obatalkes_nama, subjenis_id, subjenis_nama, dosisobat, aturanpakaiobat, carapemberian, pegawai_id, penerima_peg_nama, penerimaan_status, penerimaan_waktu, jadwalpemberianobat_id, jadwal, tanda, tanggal_pemberian, jam_pemberian, initial', 'safe', 'on'=>'search'),
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
            'catatanpemberianobatdet_id' => 'Catatanpemberianobatdet',
            'catatanpemberianobat_id' => 'Catatanpemberianobat',
            'pendaftaran_id' => 'Pendaftaran',
            'pasienadmisi_id' => 'Pasienadmisi',
            'pasien_id' => 'Pasien',
            'penjualanresep_id' => 'Penjualanresep',
            'tglpenjualan' => 'Tglpenjualan',
            'tglpenyerahan' => 'Tglpenyerahan',
            'reseptur_id' => 'Reseptur',
            'tglreseptur' => 'Tglreseptur',
            'noresep' => 'Noresep',
            'racikan_id' => 'Racikan',
            'racikan_nama' => 'Racikan Nama',
            'obatalkes_id' => 'Obatalkes',
            'obatalkes_nama' => 'Obatalkes Nama',
            'subjenis_id' => 'Subjenis',
            'subjenis_nama' => 'Subjenis Nama',
            'dosisobat' => 'Dosisobat',
            'aturanpakaiobat' => 'Aturanpakaiobat',
            'carapemberian' => 'Carapemberian',
            'pegawai_id' => 'Pegawai',
            'penerima_peg_nama' => 'Penerima Peg Nama',
            'penerimaan_status' => 'Penerimaan Status',
            'penerimaan_waktu' => 'Penerimaan Waktu',
            'jadwalpemberianobat_id' => 'Jadwalpemberianobat',
            'jadwal' => 'Jadwal',
            'tanda' => 'Tanda',
            'tanggal_pemberian' => 'Tanggal Pemberian',
            'jam_pemberian' => 'Jam Pemberian',
            'initial' => 'Initial',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search()
    {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria=new CDbCriteria;

        $criteria->compare('catatanpemberianobatdet_id',$this->catatanpemberianobatdet_id);
        $criteria->compare('catatanpemberianobat_id',$this->catatanpemberianobat_id);
        $criteria->compare('pendaftaran_id',$this->pendaftaran_id);
        $criteria->compare('pasienadmisi_id',$this->pasienadmisi_id);
        $criteria->compare('pasien_id',$this->pasien_id);
        $criteria->compare('penjualanresep_id',$this->penjualanresep_id);
        $criteria->compare('tglpenjualan',$this->tglpenjualan,true);
        $criteria->compare('tglpenyerahan',$this->tglpenyerahan,true);
        $criteria->compare('reseptur_id',$this->reseptur_id);
        $criteria->compare('tglreseptur',$this->tglreseptur,true);
        $criteria->compare('noresep',$this->noresep,true);
        $criteria->compare('racikan_id',$this->racikan_id);
        $criteria->compare('racikan_nama',$this->racikan_nama,true);
        $criteria->compare('obatalkes_id',$this->obatalkes_id);
        $criteria->compare('obatalkes_nama',$this->obatalkes_nama,true);
        $criteria->compare('subjenis_id',$this->subjenis_id);
        $criteria->compare('subjenis_nama',$this->subjenis_nama,true);
        $criteria->compare('dosisobat',$this->dosisobat,true);
        $criteria->compare('aturanpakaiobat',$this->aturanpakaiobat,true);
        $criteria->compare('carapemberian',$this->carapemberian,true);
        $criteria->compare('pegawai_id',$this->pegawai_id);
        $criteria->compare('penerima_peg_nama',$this->penerima_peg_nama,true);
        $criteria->compare('penerimaan_status',$this->penerimaan_status,true);
        $criteria->compare('penerimaan_waktu',$this->penerimaan_waktu,true);
        $criteria->compare('jadwalpemberianobat_id',$this->jadwalpemberianobat_id);
        $criteria->compare('jadwal',$this->jadwal,true);
        $criteria->compare('tanda',$this->tanda,true);
        $criteria->compare('tanggal_pemberian',$this->tanggal_pemberian,true);
        $criteria->compare('jam_pemberian',$this->jam_pemberian,true);
        $criteria->compare('initial',$this->initial,true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return DaftarpemberianobatrutinV the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public function searchPemberian()
    {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria=new CDbCriteria;
        $criteria->select = 'catatanpemberianobat_id, noresep, tglreseptur, tglpenyerahan, racikan_nama, obatalkes_nama, subjenis_nama, dosisobat, aturanpakaiobat, penerimaan_status, penerimaan_waktu, penerima_peg_nama';
        $criteria->group = $criteria->select;
        $criteria->addCondition("pendaftaran_id = '" .$this->pendaftaran_id . "'");

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }
}