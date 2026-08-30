<?php

/**
 * This is the model class for table "asesmenspiritual_ulangpasiendet_t".
 *
 * The followings are the available columns in table 'asesmenspiritual_ulangpasiendet_t':
 * @property integer $asesmenspiritual_ulangpasiendet_id
 * @property integer $asesmenspiritual_ulangpasien_id
 * @property integer $kamarruangan_id
 * @property string $tanggal
 * @property boolean $sumber_data_pasien
 * @property boolean $sumber_data_keluarga
 * @property string $penerimaankondisi_pasien
 * @property string $penerimaankondisi_keluarga
 * @property string $ekspresi
 * @property string $penilaian_kondisipasien
 * @property string $ibadahsholatpasien_sebelumsakit
 * @property string $ibadahsholatpasien_selamasakit
 * @property string $ibadahsholatkeluarga_sebelumsakit
 * @property string $ibadahsholatkeluarga_selamasakit
 * @property string $pernyataankeluarga_hafalan
 * @property string $pernyataankeluarga_mediabersuci
 * @property string $penilaian_ibadah
 * @property string $kesimpulan
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property AsesmenspiritualUlangpasienT $asesmenspiritualUlangpasien
 */
class AsesmenspiritualUlangpasiendetT extends CActiveRecord {

    public $kamarruangan_nama;
    public $sumber, $jenis;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'asesmenspiritual_ulangpasiendet_t';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('asesmenspiritual_ulangpasien_id, create_time, create_loginpemakai_id, create_ruangan','required'),
            array('asesmenspiritual_ulangpasien_id, kamarruangan_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan','numerical','integerOnly' => true),
            array('tanggal, sumber_data_pasien, sumber_data_keluarga, penerimaankondisi_pasien, penerimaankondisi_keluarga, ekspresi, penilaian_kondisipasien, ibadahsholatpasien_sebelumsakit, ibadahsholatpasien_selamasakit, ibadahsholatkeluarga_sebelumsakit, ibadahsholatkeluarga_selamasakit, pernyataankeluarga_hafalan, pernyataankeluarga_mediabersuci, penilaian_ibadah, kesimpulan, update_time','safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('asesmenspiritual_ulangpasiendet_id, asesmenspiritual_ulangpasien_id, kamarruangan_id, tanggal, sumber_data_pasien, sumber_data_keluarga, penerimaankondisi_pasien, penerimaankondisi_keluarga, ekspresi, penilaian_kondisipasien, ibadahsholatpasien_sebelumsakit, ibadahsholatpasien_selamasakit, ibadahsholatkeluarga_sebelumsakit, ibadahsholatkeluarga_selamasakit, pernyataankeluarga_hafalan, pernyataankeluarga_mediabersuci, penilaian_ibadah, kesimpulan, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan','safe','on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'asesmenspiritualUlangpasien' => array(self::BELONGS_TO, 'AsesmenspiritualUlangpasienT','asesmenspiritual_ulangpasien_id'),
            'kamarruangan' => array(self::BELONGS_TO, 'KamarruanganM','kamarruangan_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'asesmenspiritual_ulangpasiendet_id' => 'Asesmenspiritual Ulangpasiendet',
            'asesmenspiritual_ulangpasien_id' => 'Asesmenspiritual Ulangpasien',
            'kamarruangan_id' => 'Kamarruangan',
            'tanggal' => 'Tanggal',
            'sumber_data_pasien' => 'Sumber Data Pasien',
            'sumber_data_keluarga' => 'Sumber Data Keluarga',
            'penerimaankondisi_pasien' => 'Penerimaankondisi Pasien',
            'penerimaankondisi_keluarga' => 'Penerimaankondisi Keluarga',
            'ekspresi' => 'Ekspresi',
            'penilaian_kondisipasien' => 'Penilaian Kondisipasien',
            'ibadahsholatpasien_sebelumsakit' => 'Ibadahsholatpasien Sebelumsakit',
            'ibadahsholatpasien_selamasakit' => 'Ibadahsholatpasien Selamasakit',
            'ibadahsholatkeluarga_sebelumsakit' => 'Ibadahsholatkeluarga Sebelumsakit',
            'ibadahsholatkeluarga_selamasakit' => 'Ibadahsholatkeluarga Selamasakit',
            'pernyataankeluarga_hafalan' => 'Pernyataankeluarga Hafalan',
            'pernyataankeluarga_mediabersuci' => 'Pernyataankeluarga Mediabersuci',
            'penilaian_ibadah' => 'Penilaian Ibadah',
            'kesimpulan' => 'Kesimpulan',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
            'create_loginpemakai_id' => 'Create Loginpemakai',
            'update_loginpemakai_id' => 'Update Loginpemakai',
            'create_ruangan' => 'Create Ruangan',
            'kamarruangan_nama' => 'Ruangan'
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
    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('asesmenspiritual_ulangpasiendet_id', $this->asesmenspiritual_ulangpasiendet_id);
        $criteria->compare('asesmenspiritual_ulangpasien_id', $this->asesmenspiritual_ulangpasien_id);
        $criteria->compare('kamarruangan_id', $this->kamarruangan_id);
        $criteria->compare('tanggal', $this->tanggal, true);
        $criteria->compare('sumber_data_pasien', $this->sumber_data_pasien);
        $criteria->compare('sumber_data_keluarga', $this->sumber_data_keluarga);
        $criteria->compare('penerimaankondisi_pasien', $this->penerimaankondisi_pasien, true);
        $criteria->compare('penerimaankondisi_keluarga', $this->penerimaankondisi_keluarga, true);
        $criteria->compare('ekspresi', $this->ekspresi, true);
        $criteria->compare('penilaian_kondisipasien', $this->penilaian_kondisipasien, true);
        $criteria->compare('ibadahsholatpasien_sebelumsakit', $this->ibadahsholatpasien_sebelumsakit, true);
        $criteria->compare('ibadahsholatpasien_selamasakit', $this->ibadahsholatpasien_selamasakit, true);
        $criteria->compare('ibadahsholatkeluarga_sebelumsakit', $this->ibadahsholatkeluarga_sebelumsakit, true);
        $criteria->compare('ibadahsholatkeluarga_selamasakit', $this->ibadahsholatkeluarga_selamasakit, true);
        $criteria->compare('pernyataankeluarga_hafalan', $this->pernyataankeluarga_hafalan, true);
        $criteria->compare('pernyataankeluarga_mediabersuci', $this->pernyataankeluarga_mediabersuci, true);
        $criteria->compare('penilaian_ibadah', $this->penilaian_ibadah, true);
        $criteria->compare('kesimpulan', $this->kesimpulan, true);
        $criteria->compare('create_time', $this->create_time, true);
        $criteria->compare('update_time', $this->update_time, true);
        $criteria->compare('create_loginpemakai_id', $this->create_loginpemakai_id);
        $criteria->compare('update_loginpemakai_id', $this->update_loginpemakai_id);
        $criteria->compare('create_ruangan', $this->create_ruangan);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return AsesmenspiritualUlangpasiendetT the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public static function simpanData($model, $post, $multiple = false) {

        $sukses = 1;
        $pesan = '';

        if (!$multiple) {
            $modDet = $model;
            $modDet->attributes = $post;

            $modDet = self::set_audit($model, $modDet, $post);

            $sukses &= $modDet->save();

            if (!$sukses) {
                $pesan .= 'asesmen spiritual ulang pasien detail <br/>:' . MyExceptionMessage::getErrorMessage($model);
            }
        } else {
            $mod = get_called_class();
            $modDet = [];

            foreach ($post as $key => $val) {
                $modDet[$key] = new $mod;
                if (!empty($val['asesmenspiritual_ulangpasiendet_id'])) {
                    $cek = $mod::model()->findByPk($val['asesmenspiritual_ulangpasiendet_id']);
                    if (!empty($cek)) {
                        $modDet[$key] = $cek;
                    }
                }
                $modDet[$key]->attributes = $val;

                $modDet[$key] = self::set_audit($model, $modDet[$key], $val);

                $sukses &= $modDet[$key]->save();

                if (!$sukses) {
                    $pesan .= 'asesmen spiritual ulang pasien detail <br/>:' . MyExceptionMessage::getErrorMessage($modDet[$key]);
                }
            }
        }

        return [
            'model' => $modDet,
            'sukses' => $sukses,
            'pesan' => $pesan
        ];
    }

    /**
     * 
     * @param type $model
     * @param type $modDet
     * @param type $post
     * @return type
     */
    public static function set_audit($model, $modDet, $post) {

        $modDet->attributes = $post;
        $modDet->tanggal = !empty($modDet->tanggal) ? MyFormatter::formatDateTimeForDb($modDet->tanggal) : null;

        if (isset($post['sumber'])) {
            if ($post['sumber'] == 'pasien') {
                $modDet->sumber_data_pasien = true;
            } else if ($post['sumber'] == 'keluarga') {
                $modDet->sumber_data_keluarga = true;
            }
        }     

        foreach ($modDet->metadata->tableSchema->columns as $columnName => $column) {         
            if (is_array($modDet->$columnName)) {
                $modDet->$columnName = implode(",", $modDet->$columnName);
            }
        }


        if (empty($model->asesmenspiritual_ulangpasiendet_id)) {
            $modDet->create_time = date('Y-m-d H:i:s');
            $modDet->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
            $modDet->create_ruangan = Yii::app()->user->getState('ruangan_id');
        } else {
            $modDet->update_time = date('Y-m-d H:i:s');
            $modDet->update_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
        }

        return $modDet;
    }

    public function pilihanData($prinout = false) {
        $penerimaankondisisakit = LookupM::getItemsUrutan('penerimaankondisisakit');
        $ekspresi = LookupM::getItemsUrutan('ekspresi');
        $ibadahsholat = LookupM::getItemsUrutan('ibadahsholat');
        $hafalan = LookupM::getItemsUrutan('hafalan');
        $mediabersuci = LookupM::getItemsUrutan('mediabersuci');
        $penilaian = LookupM::getItemsUrutan('penilaian');

        $penerimaankondisisakit = ($prinout)?$penerimaankondisisakit:$this->arrayBagiDua($penerimaankondisisakit);
        $ekspresi = ($prinout)?$ekspresi:$this->arrayBagiDua($ekspresi);
        $penilaian = ($prinout)?$penilaian:$this->arrayBagiDua($penilaian);

        return [
            'penerimaankondisisakit' => $penerimaankondisisakit,
            'ekspresi' => $ekspresi,
            'ibadahsholat' => $ibadahsholat,
            'hafalan' => $hafalan,
            'mediabersuci' => $mediabersuci,
            'penilaian' => $penilaian
        ];
    }

    public function arrayBagiDua($arr) {
        $temp = [];
        $a = 0;
        $no = 1;

        $bagi = floor(count($arr) / 2);
        $bagi = ($bagi == 0) ? 1 : $bagi;

        foreach ($arr as $key => $val) {
            $temp[$a][$key] = $val;

            if ($no % ($bagi) == 0) {
                $a++;
            }
            $no++;
        }

        return $temp;
    }
    
    public function loadInput(){
        $this->penerimaankondisi_pasien = !empty($this->penerimaankondisi_pasien)?explode(',',$this->penerimaankondisi_pasien):[];
        $this->ekspresi = !empty($this->ekspresi)?explode(',',$this->ekspresi):[];
        $this->penilaian_kondisipasien = !empty($this->penilaian_kondisipasien)?explode(',',$this->penilaian_kondisipasien):[];
        $this->penerimaankondisi_keluarga = !empty($this->penerimaankondisi_keluarga)?explode(',',$this->penerimaankondisi_keluarga):[];
        $this->ibadahsholatpasien_sebelumsakit = !empty($this->ibadahsholatpasien_sebelumsakit)?explode(',',$this->ibadahsholatpasien_sebelumsakit):[];
        $this->ibadahsholatpasien_selamasakit = !empty($this->ibadahsholatpasien_selamasakit)?explode(',',$this->ibadahsholatpasien_selamasakit):[];
        $this->ibadahsholatkeluarga_sebelumsakit = !empty($this->ibadahsholatkeluarga_sebelumsakit)?explode(',',$this->ibadahsholatkeluarga_sebelumsakit):[];
        $this->ibadahsholatkeluarga_selamasakit = !empty($this->ibadahsholatkeluarga_selamasakit)?explode(',',$this->ibadahsholatkeluarga_selamasakit):[];
        $this->pernyataankeluarga_hafalan = !empty($this->pernyataankeluarga_hafalan)?explode(',',$this->pernyataankeluarga_hafalan):[];
        $this->pernyataankeluarga_mediabersuci = !empty($this->pernyataankeluarga_mediabersuci)?explode(',',$this->pernyataankeluarga_mediabersuci):[];
        $this->penilaian_ibadah = !empty($this->penilaian_ibadah)?explode(',',$this->penilaian_ibadah):[];            
        $this->kamarruangan_nama = !empty($this->kamarruangan)?$this->kamarruangan->kamarruangan_nokamar.' - '.$this->kamarruangan->kamarruangan_nobed:'';
    }
}
