<?php

/**
 * This is the model class for table "jadwalhemodialisa_v".
 *
 * The followings are the available columns in table 'jadwalhemodialisa_v':
 * @property string $jadwalhemodialisa_hari
 * @property string $jadwalhemodialisa_tgl_ke
 * @property boolean $jadwalhemodialisa_status
 * @property integer $shift_hd_id
 * @property string $shift_hd_nama
 * @property string $kamarruangan_nokamar
 * @property string $no_rekam_medik
 * @property string $nama_pasien
 * @property string $jeniskelamin
 * @property string $tanggal_lahir
 * @property string $no_mobile_pasien
 * @property string $alamat_pasien
 * 
 * @author Aida Rahmawati <aidarahmawati@.com>
 * @package application.models
 * @category model
 */
class JadwalhemodialisaV extends CActiveRecord {

    public $tgl_awal, $tgl_akhir;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return JadwalhemodialisaV the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'jadwalhemodialisa_v';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('shift_hd_id', 'numerical', 'integerOnly' => true),
            array('jadwalhemodialisa_hari, jeniskelamin, no_mobile_pasien', 'length', 'max' => 20),
            array('shift_hd_nama, kamarruangan_nokamar', 'length', 'max' => 100),
            array('no_rekam_medik', 'length', 'max' => 10),
            array('nama_pasien', 'length', 'max' => 50),
            array('jadwalhemodialisa_tgl_ke, jadwalhemodialisa_status, tanggal_lahir, alamat_pasien', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('jadwalhemodialisa_hari, jadwalhemodialisa_tgl_ke, jadwalhemodialisa_status, shift_hd_id, shift_hd_nama, kamarruangan_nokamar, no_rekam_medik, nama_pasien, jeniskelamin, tanggal_lahir, no_mobile_pasien, alamat_pasien', 'safe', 'on' => 'search'),
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
            'jadwalhemodialisa_hari' => 'Jadwalhemodialisa Hari',
            'jadwalhemodialisa_tgl_ke' => 'Jadwalhemodialisa Tgl Ke',
            'jadwalhemodialisa_status' => 'Jadwalhemodialisa Status',
            'shift_hd_id' => 'Shift Hd',
            'shift_hd_nama' => 'Shift Hd Nama',
            'kamarruangan_nokamar' => 'Kamarruangan Nokamar',
            'no_rekam_medik' => 'No Rekam Medik',
            'nama_pasien' => 'Nama Pasien',
            'jeniskelamin' => 'Jeniskelamin',
            'tanggal_lahir' => 'Tanggal Lahir',
            'no_mobile_pasien' => 'No Mobile Pasien',
            'alamat_pasien' => 'Alamat Pasien',
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

        $criteria->compare('jadwalhemodialisa_hari', $this->jadwalhemodialisa_hari, true);
        $criteria->compare('jadwalhemodialisa_tgl_ke', $this->jadwalhemodialisa_tgl_ke, true);
        $criteria->compare('jadwalhemodialisa_status', $this->jadwalhemodialisa_status);
        $criteria->compare('shift_hd_id', $this->shift_hd_id);
        $criteria->compare('shift_hd_nama', $this->shift_hd_nama, true);
        $criteria->compare('kamarruangan_nokamar', $this->kamarruangan_nokamar, true);
        $criteria->compare('no_rekam_medik', $this->no_rekam_medik, true);
        $criteria->compare('nama_pasien', $this->nama_pasien, true);
        $criteria->compare('jeniskelamin', $this->jeniskelamin, true);
        $criteria->compare('tanggal_lahir', $this->tanggal_lahir, true);
        $criteria->compare('no_mobile_pasien', $this->no_mobile_pasien, true);
        $criteria->compare('alamat_pasien', $this->alamat_pasien, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function searchInfoJadwal() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('jadwalhemodialisa_hari', $this->jadwalhemodialisa_hari, true);
        $criteria->compare('jadwalhemodialisa_tgl_ke', $this->jadwalhemodialisa_tgl_ke, true);
        $criteria->compare('jadwalhemodialisa_status', $this->jadwalhemodialisa_status);
        $criteria->compare('shift_hd_id', $this->shift_hd_id);
        $criteria->compare('shift_hd_nama', $this->shift_hd_nama, true);
        $criteria->compare('kamarruangan_nokamar', $this->kamarruangan_nokamar, true);
        $criteria->compare('no_rekam_medik', $this->no_rekam_medik, true);
        $criteria->compare('LOWER(nama_pasien)', strtolower($this->nama_pasien), true);
        $criteria->compare('LOWER(jeniskelamin)', strtolower($this->jeniskelamin), true);
        $criteria->compare('tanggal_lahir', $this->tanggal_lahir, true);
        $criteria->compare('no_mobile_pasien', $this->no_mobile_pasien, true);
        $criteria->compare('alamat_pasien', $this->alamat_pasien, true);

        if (!empty($this->tgl_awal) && !empty($this->tgl_akhir)) {
            $criteria->addBetweenCondition('jadwalhemodialisa_tgl_ke', $this->tgl_awal, $this->tgl_akhir);
        }

        $criteria->order = 'jadwalhemodialisa_tgl_ke DESC';

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * RSST-15367 
     * Generate Laporan 
     * @return type
     */
    public function generateLaporan() {
        $cri = new CDbCriteria();
        $cri->addBetweenCondition('jadwalhemodialisa_tgl_ke', $this->tgl_awal, $this->tgl_akhir);
        $cri->compare('no_rekam_medik', $this->no_rekam_medik, true);
        $cri->compare('shift_id', $this->shift_hd_id);
        $cri->compare('LOWER(nama_pasien)', strtolower($this->nama_pasien), true);
        $model = LaporanjadwalhemodialisaV::model()->findAll($cri);

        $arr = array();
        if (!empty($model)) {
            foreach ($model as $det) {
                $tgl = $det['jadwalhemodialisa_tgl_ke'];
                $id = $det['jadwalhemodialisa_id'];
                $arr[$tgl]['tanggal'] = $tgl;
                $j = 1;
                for ($i = 1; $i <= 4; $i++) { // i <= 4 (jumlah kondisi shift pagi non infeksius dan infeksius)
                    $arr[$tgl]['init'][$j]['detail'][$id]['jadwalhemodialisa_id'] = ""; // set default variabel kosong 
                    $arr[$tgl]['init'][$j]['detail'][$id]['no_rekam_medik'] = "";
                    $arr[$tgl]['init'][$j]['detail'][$id]['tanggal_lahir'] = "";
                    $arr[$tgl]['init'][$j]['detail'][$id]['nama_pasien'] = "";
                    $arr[$tgl]['init'][$j]['detail'][$id]['jeniskelamin'] = "";
                    $arr[$tgl]['init'][$j]['detail'][$id]['bpjs'] = "";
                    $arr[$tgl]['init'][$j]['detail'][$id]['umum'] = "";
                    $arr[$tgl]['init'][$j]['detail'][$id]['jamkesda'] = "";
                    $arr[$tgl]['init'][$j]['detail'][$id]['b'] = "";
                    $arr[$tgl]['init'][$j]['detail'][$id]['c'] = "";
                    $arr[$tgl]['init'][$j]['detail'][$id]['hiv'] = "";
                    $arr[$tgl]['init'][$j]['detail'][$id]['hcv'] = "";
                    $arr[$tgl]['init'][$j]['detail'][$id]['hbsag'] = "";
                    $arr[$tgl]['init'][$j]['detail'][$id]['covid'] = "";
                    $j++;
                }
            }

            foreach ($arr as $key => $det2) { // jumlah per tanggal x 4 
                if (!empty($det2['init'])) {
                    foreach ($det2['init'] as $key2 => $det3) {
                        $crit2 = new CDbCriteria();
                        $crit2->addCondition("date(jadwalhemodialisa_tgl_ke) = '" . $key . "'");
                        $crit2->compare('no_rekam_medik', $this->no_rekam_medik, true);
                        $crit2->compare('LOWER(nama_pasien)', strtolower($this->nama_pasien), true);
                        if ($key2 == 1) {
                            $crit2->addCondition('shift_id = ' . Params::SHIFT_HD_PAGI);
                            $crit2->addCondition("status_infeksius_hd is null or status_infeksius_hd = '" . Params::STATUS_INFEKSIUS_HD_TIDAK_ADA . "'");
                        } else if ($key2 == 2) {
                            $crit2->addCondition('shift_id = ' . Params::SHIFT_HD_PAGI);
                            $crit2->addCondition("status_infeksius_hd != '" . Params::STATUS_INFEKSIUS_HD_TIDAK_ADA . "'");
                        } else if ($key2 == 3) {
                            $crit2->addCondition('shift_id = ' . Params::SHIFT_HD_SIANG);
                            $crit2->addCondition("status_infeksius_hd is null or status_infeksius_hd = '" . Params::STATUS_INFEKSIUS_HD_TIDAK_ADA . "'");
                        } else if ($key2 == 4) {
                            $crit2->addCondition('shift_id = ' . Params::SHIFT_HD_SIANG);
                            $crit2->addCondition("status_infeksius_hd != '" . Params::STATUS_INFEKSIUS_HD_TIDAK_ADA . "'");
                        }

                        $modCari = LaporanjadwalhemodialisaV::model()->findAll($crit2);

                        if (!empty($modCari)) {
                            $i = 1;
                            foreach ($modCari as $cari) {
                                $id = $cari->jadwalhemodialisa_id;
                                $arr[$key]['init'][$key2]['detail'][$id]['jadwalhemodialisa_id'] = $id;
                                $arr[$key]['init'][$key2]['detail'][$id]['no_rekam_medik'] = $cari->no_rekam_medik;
                                $arr[$key]['init'][$key2]['detail'][$id]['tanggal_lahir'] = date("d/m/Y", strtotime($cari->tanggal_lahir));
                                $arr[$key]['init'][$key2]['detail'][$id]['nama_pasien'] = $cari->nama_pasien;
                                $arr[$key]['init'][$key2]['detail'][$id]['jeniskelamin'] = (strtolower($cari->jeniskelamin) == Params::JENIS_KELAMIN_LAKI_LAKI) ? "L" : "P";                                
                                $arr[$key]['init'][$key2]['detail'][$id]['bpjs'] = (strtolower($cari->carabayar_nama) == strtolower("BPJS")) ? "V" : "";
                                $arr[$key]['init'][$key2]['detail'][$id]['umum'] = (strtolower($cari->penjamin_nama) == strtolower("Umum")) ? "V" : "";
                                $arr[$key]['init'][$key2]['detail'][$id]['jamkesda'] = (strtolower($cari->carabayar_nama) == strtolower("JAMKESDA")) ? "V" : "";
                                $arr[$key]['init'][$key2]['detail'][$id]['b'] = (strtolower($cari->status_infeksius_hd) == strtolower(Params::STATUS_INFEKSIUS_HD_HEPATITIS_B)) ? "V" : "";
                                $arr[$key]['init'][$key2]['detail'][$id]['c'] = (strtolower($cari->status_infeksius_hd) == strtolower(Params::STATUS_INFEKSIUS_HD_HEPATITIS_C)) ? "V" : "";
                                $arr[$key]['init'][$key2]['detail'][$id]['hiv'] = (strtolower($cari->status_infeksius_hd) == strtolower(Params::STATUS_INFEKSIUS_HD_HIV)) ? "V" : "";
                                $arr[$key]['init'][$key2]['detail'][$id]['hcv'] = (strtolower($cari->status_infeksius_hd) == strtolower(Params::STATUS_INFEKSIUS_HD_HCV)) ? "V" : "";
                                $arr[$key]['init'][$key2]['detail'][$id]['hbsag'] = (strtolower($cari->status_infeksius_hd) == strtolower(Params::STATUS_INFEKSIUS_HD_HBSAG)) ? "V" : "";
                                $arr[$key]['init'][$key2]['detail'][$id]['covid'] = (strtolower($cari->status_infeksius_hd) == strtolower(Params::STATUS_INFEKSIUS_HD_COVID)) ? "V" : "";
                                
                            }
                        }
                    }
                }
            }
        }
        
        ksort($arr);
        return($arr);
    }

}
