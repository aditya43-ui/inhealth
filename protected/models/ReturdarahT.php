<?php

/**
 * This is the model class for table "returdarah_t".
 * @author Elham Budianto <elhambudianto1@gmail.com>
 * @package application.models
 * The followings are the available columns in table 'returdarah_t':
 * @property integer $returdarah_id
 * @property integer $petugas_penerima_id
 * @property integer $petugas_analisa_id
 * @property integer $ujikompatibilitas_id
 * @property string $tgl_retur_darah
 * @property string $no_retur_darah
 * @property string $keterangan
 * @property boolean $is_ruangan
 * @property boolean $is_bdt
 * @property boolean $is_itd
 * @property string $ruangan_tgl_penyerahan
 * @property integer $bdt_suhucoolbox
 * @property string $tgl_analisa
 * @property boolean $is_kadaluarsa
 * @property boolean $is_sealer_habis
 * @property boolean $is_tabung_terbuka
 * @property boolean $is_bocor
 * @property boolean $is_gumpalan_plasma
 * @property boolean $is_hemolisis
 * @property boolean $is_endapan
 * @property string $kesimpulan
 */
class ReturdarahT extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return ReturdarahT the static model class
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
        return 'returdarah_t';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('petugas_penerima_id, petugas_analisa_id, ujikompatibilitas_id, bdt_suhucoolbox', 'numerical', 'integerOnly' => true),
            array('no_retur_darah', 'length', 'max' => 100),
            array('kesimpulan', 'length', 'max' => 250),
            array('tgl_retur_darah, keterangan, is_ruangan, is_bdt, is_itd, ruangan_tgl_penyerahan, tgl_analisa, is_kadaluarsa, is_sealer_habis, is_tabung_terbuka, is_bocor, is_gumpalan_plasma, is_hemolisis, is_endapan', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('returdarah_id, petugas_penerima_id, petugas_analisa_id, ujikompatibilitas_id, tgl_retur_darah, no_retur_darah, keterangan, is_ruangan, is_bdt, is_itd, ruangan_tgl_penyerahan, bdt_suhucoolbox, tgl_analisa, is_kadaluarsa, is_sealer_habis, is_tabung_terbuka, is_bocor, is_gumpalan_plasma, is_hemolisis, is_endapan, kesimpulan', 'safe', 'on' => 'search'),
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
            'returdarah_id' => 'Returdarah',
            'petugas_penerima_id' => 'Petugas Penerima',
            'petugas_analisa_id' => 'Petugas Analisa',
            'ujikompatibilitas_id' => 'Ujikompatibilitas',
            'tgl_retur_darah' => 'Tgl. Retur Darah',
            'no_retur_darah' => 'No. Retur Darah',
            'keterangan' => 'Keterangan',
            'is_ruangan' => 'Is Ruangan',
            'is_bdt' => 'Is Bdt',
            'is_itd' => 'Is Itd',
            'ruangan_tgl_penyerahan' => 'Ruangan Tgl. Penyerahan',
            'bdt_suhucoolbox' => 'Bdt Suhucoolbox',
            'tgl_analisa' => 'Tgl. Analisa',
            'is_kadaluarsa' => 'Kadaluarsa',
            'is_sealer_habis' => 'Sealer Habis',
            'is_tabung_terbuka' => 'Tubing Terbuka',
            'is_bocor' => 'Bocor pada kantong darah atau selang',
            'is_gumpalan_plasma' => 'Gumpalan pada Plasma',
            'is_hemolisis' => 'Hemolisis antara Sel Darah Merah dan Plasma',
            'is_endapan' => 'Endapan sel Darah Merah (warna ungu kehitaman)',
            'kesimpulan' => 'Kesimpulan',
            'is_plasma_pink' => 'Warna Plasma Pink',
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

        $criteria->compare('returdarah_id', $this->returdarah_id);
        $criteria->compare('petugas_penerima_id', $this->petugas_penerima_id);
        $criteria->compare('petugas_analisa_id', $this->petugas_analisa_id);
        $criteria->compare('ujikompatibilitas_id', $this->ujikompatibilitas_id);
        $criteria->compare('tgl_retur_darah', $this->tgl_retur_darah, true);
        $criteria->compare('no_retur_darah', $this->no_retur_darah, true);
        $criteria->compare('keterangan', $this->keterangan, true);
        $criteria->compare('is_ruangan', $this->is_ruangan);
        $criteria->compare('is_bdt', $this->is_bdt);
        $criteria->compare('is_itd', $this->is_itd);
        $criteria->compare('ruangan_tgl_penyerahan', $this->ruangan_tgl_penyerahan, true);
        $criteria->compare('bdt_suhucoolbox', $this->bdt_suhucoolbox);
        $criteria->compare('tgl_analisa', $this->tgl_analisa, true);
        $criteria->compare('is_kadaluarsa', $this->is_kadaluarsa);
        $criteria->compare('is_sealer_habis', $this->is_sealer_habis);
        $criteria->compare('is_tabung_terbuka', $this->is_tabung_terbuka);
        $criteria->compare('is_bocor', $this->is_bocor);
        $criteria->compare('is_gumpalan_plasma', $this->is_gumpalan_plasma);
        $criteria->compare('is_hemolisis', $this->is_hemolisis);
        $criteria->compare('is_endapan', $this->is_endapan);
        $criteria->compare('kesimpulan', $this->kesimpulan, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
}
