<?php

/**
 * This is the model class for table "asesmenawalradiologi_t".
 *
 * The followings are the available columns in table 'asesmenawalradiologi_t':
 * @property integer $asesmenawalradiologi_id
 * @property integer $pendaftaran_id
 * @property integer $pasienadmisi_id
 * @property integer $penanggungjawab_id
 * @property integer $pasien_id
 * @property integer $pegawai_id
 * @property string $tanggal_asesmenawal
 * @property string $keluhan
 * @property string $penilaian_nyeri
 * @property string $keterangan_lain
 * @property boolean $is_pernahdifoto
 * @property boolean $is_adakeluhan
 * @property boolean $is_programhamil
 * @property string $pemeriksaan_radiagnostik
 * @property string $pemeriksaan_radiologiimaging
 * @property string $pemeriksaan_radiologiintervensional
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 * @property string $foto_apa
 * @property integer $brp_kali
 * @property integer $bulan_ke_brp
 * @property string $keluhan_apa
 * @property string $keluarga_yg_menyatakan
 * @property string $yang_menyatakan
 * @property string $statuspersetujuan
 * @property string $saksi2
 * @property string $saksi1
 *
 * The followings are the available model relations:
 * @property PasienM $pasien
 * @property PasienadmisiT $pasienadmisi
 * @property PegawaiM $pegawai
 * @property PenanggungjawabM $penanggungjawab
 * @property PendaftaranT $pendaftaran
 * @property AsesmenawalradiologidetT[] $asesmenawalradiologidetTs
 */
class AsesmenawalradiologiT extends CActiveRecord
{
    public $pegawai_nama, $statusmerokok, $keb_konsumsialkohol;
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'asesmenawalradiologi_t';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('pendaftaran_id, pasien_id, pegawai_id, create_time, create_loginpemakai_id, create_ruangan', 'required'),
            array('pendaftaran_id, pasienadmisi_id, penanggungjawab_id, pasien_id, pegawai_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, brp_kali, bulan_ke_brp', 'numerical', 'integerOnly'=>true),
            array('keluhan_apa, keluarga_yg_menyatakan, yang_menyatakan, statuspersetujuan, saksi2, saksi1', 'length', 'max'=>200),
            array('tanggal_asesmenawal, keluhan, penilaian_nyeri, keterangan_lain, is_pernahdifoto, is_adakeluhan, is_programhamil, pemeriksaan_radiagnostik, pemeriksaan_radiologiimaging, pemeriksaan_radiologiintervensional, update_time, foto_apa', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('asesmenawalradiologi_id, pendaftaran_id, pasienadmisi_id, penanggungjawab_id, pasien_id, pegawai_id, tanggal_asesmenawal, keluhan, penilaian_nyeri, keterangan_lain, is_pernahdifoto, is_adakeluhan, is_programhamil, pemeriksaan_radiagnostik, pemeriksaan_radiologiimaging, pemeriksaan_radiologiintervensional, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, foto_apa, brp_kali, bulan_ke_brp, keluhan_apa, keluarga_yg_menyatakan, yang_menyatakan, statuspersetujuan, saksi2, saksi1', 'safe', 'on'=>'search'),
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
            'pasien' => array(self::BELONGS_TO, 'PasienM', 'pasien_id'),
            'pasienadmisi' => array(self::BELONGS_TO, 'PasienadmisiT', 'pasienadmisi_id'),
            'pegawai' => array(self::BELONGS_TO, 'PegawaiM', 'pegawai_id'),
            'penanggungjawab' => array(self::BELONGS_TO, 'PenanggungjawabM', 'penanggungjawab_id'),
            'pendaftaran' => array(self::BELONGS_TO, 'PendaftaranT', 'pendaftaran_id'),
            'asesmenawalradiologidetTs' => array(self::HAS_MANY, 'AsesmenawalradiologidetT', 'asesmenawalradiologi_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'asesmenawalradiologi_id' => 'Asesmenawalradiologi',
            'pendaftaran_id' => 'Pendaftaran',
            'pasienadmisi_id' => 'Pasienadmisi',
            'penanggungjawab_id' => 'Penanggungjawab',
            'pasien_id' => 'Pasien',
            'pegawai_id' => 'Pegawai',
            'tanggal_asesmenawal' => 'Tanggal Asesmen Awal',
            'keluhan' => 'Keluhan',
            'penilaian_nyeri' => 'Penilaian Nyeri',
            'keterangan_lain' => 'Keterangan Lain',
            'is_pernahdifoto' => 'Is Pernahdifoto',
            'is_adakeluhan' => 'Is Adakeluhan',
            'is_programhamil' => 'Is Programhamil',
            'pemeriksaan_radiagnostik' => 'Pemeriksaan Radiagnostik',
            'pemeriksaan_radiologiimaging' => 'Pemeriksaan Radiologiimaging',
            'pemeriksaan_radiologiintervensional' => 'Pemeriksaan Radiologiintervensional',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
            'create_loginpemakai_id' => 'Create Loginpemakai',
            'update_loginpemakai_id' => 'Update Loginpemakai',
            'create_ruangan' => 'Create Ruangan',
            'foto_apa' => 'Foto Apa',
            'brp_kali' => 'Brp Kali',
            'bulan_ke_brp' => 'Bulan Ke Brp',
            'keluhan_apa' => 'Keluhan Apa',
            'keluarga_yg_menyatakan' => 'Keluarga Yg Menyatakan',
            'yang_menyatakan' => 'Yang Menyatakan',
            'statuspersetujuan' => 'Statuspersetujuan',
            'saksi2' => 'Saksi2',
            'saksi1' => 'Saksi1',
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

        $criteria->compare('asesmenawalradiologi_id',$this->asesmenawalradiologi_id);
        $criteria->compare('pendaftaran_id',$this->pendaftaran_id);
        $criteria->compare('pasienadmisi_id',$this->pasienadmisi_id);
        $criteria->compare('penanggungjawab_id',$this->penanggungjawab_id);
        $criteria->compare('pasien_id',$this->pasien_id);
        $criteria->compare('pegawai_id',$this->pegawai_id);
        $criteria->compare('tanggal_asesmenawal',$this->tanggal_asesmenawal,true);
        $criteria->compare('keluhan',$this->keluhan,true);
        $criteria->compare('penilaian_nyeri',$this->penilaian_nyeri,true);
        $criteria->compare('keterangan_lain',$this->keterangan_lain,true);
        $criteria->compare('is_pernahdifoto',$this->is_pernahdifoto);
        $criteria->compare('is_adakeluhan',$this->is_adakeluhan);
        $criteria->compare('is_programhamil',$this->is_programhamil);
        $criteria->compare('pemeriksaan_radiagnostik',$this->pemeriksaan_radiagnostik,true);
        $criteria->compare('pemeriksaan_radiologiimaging',$this->pemeriksaan_radiologiimaging,true);
        $criteria->compare('pemeriksaan_radiologiintervensional',$this->pemeriksaan_radiologiintervensional,true);
        $criteria->compare('create_time',$this->create_time,true);
        $criteria->compare('update_time',$this->update_time,true);
        $criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
        $criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id);
        $criteria->compare('create_ruangan',$this->create_ruangan);
        $criteria->compare('foto_apa',$this->foto_apa,true);
        $criteria->compare('brp_kali',$this->brp_kali);
        $criteria->compare('bulan_ke_brp',$this->bulan_ke_brp);
        $criteria->compare('keluhan_apa',$this->keluhan_apa,true);
        $criteria->compare('keluarga_yg_menyatakan',$this->keluarga_yg_menyatakan,true);
        $criteria->compare('yang_menyatakan',$this->yang_menyatakan,true);
        $criteria->compare('statuspersetujuan',$this->statuspersetujuan,true);
        $criteria->compare('saksi2',$this->saksi2,true);
        $criteria->compare('saksi1',$this->saksi1,true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return AsesmenawalradiologiT the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}