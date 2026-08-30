<?php

/**
 * This is the model class for table "skoraldrette_t".
 * @author Elham Budianto <elhambudianto@.com>
 * @package application.models
 * 
 * The followings are the available columns in table 'skoraldrette_t':
 * @property integer $skoraldrette_id
 * @property integer $skorpascaanastesi_id
 * @property string $aldrette_sirkulasi_jam
 * @property integer $aldrette_sirkulasi_0
 * @property integer $aldrette_sirkulasi_5
 * @property integer $aldrette_sirkulasi_15
 * @property integer $aldrette_sirkulasi_30
 * @property integer $aldrette_sirkulasi_45
 * @property integer $aldrette_sirkulasi_1
 * @property integer $aldrette_sirkulasi_2
 * @property integer $aldrette_sirkulasi_3
 * @property integer $aldrette_sirkulasi_4
 * @property integer $aldrette_sirkulasi_keluar
 * @property string $aldrette_kesadaran_jam
 * @property integer $aldrette_kesadaran_0
 * @property integer $aldrette_kesadaran_5
 * @property integer $aldrette_kesadaran_15
 * @property integer $aldrette_kesadaran_30
 * @property integer $aldrette_kesadaran_45
 * @property integer $aldrette_kesadaran_1
 * @property integer $aldrette_kesadaran_2
 * @property integer $aldrette_kesadaran_3
 * @property integer $aldrette_kesadaran_4
 * @property integer $aldrette_kesadaran_keluar
 * @property string $aldrette_oksigensi_jam
 * @property integer $aldrette_oksigensi_0
 * @property integer $aldrette_oksigensi_5
 * @property integer $aldrette_oksigensi_15
 * @property integer $aldrette_oksigensi_30
 * @property integer $aldrette_oksigensi_45
 * @property integer $aldrette_oksigensi_1
 * @property integer $aldrette_oksigensi_2
 * @property integer $aldrette_oksigensi_3
 * @property integer $aldrette_oksigensi_4
 * @property integer $aldrette_oksigensi_keluar
 * @property string $aldrette_pernafasan_jam
 * @property integer $aldrette_pernafasan_0
 * @property integer $aldrette_pernafasan_5
 * @property integer $aldrette_pernafasan_15
 * @property integer $aldrette_pernafasan_30
 * @property integer $aldrette_pernafasan_45
 * @property integer $aldrette_pernafasan_1
 * @property integer $aldrette_pernafasan_2
 * @property integer $aldrette_pernafasan_3
 * @property integer $aldrette_pernafasan_4
 * @property integer $aldrette_pernafasan_keluar
 * @property string $aldrette_aktifitas_jam
 * @property integer $aldrette_aktifitas_0
 * @property integer $aldrette_aktifitas_5
 * @property integer $aldrette_aktifitas_15
 * @property integer $aldrette_aktifitas_30
 * @property integer $aldrette_aktifitas_45
 * @property integer $aldrette_aktifitas_1
 * @property integer $aldrette_aktifitas_2
 * @property integer $aldrette_aktifitas_3
 * @property integer $aldrette_aktifitas_4
 * @property integer $aldrette_aktifitas_keluar
 * @property integer $aldrette_total_0
 * @property integer $aldrette_total_15
 * @property integer $aldrette_total_30
 * @property integer $aldrette_total_45
 * @property integer $aldrette_total_1
 * @property integer $aldrette_total_2
 * @property integer $aldrette_total_3
 * @property integer $aldrette_total_4
 * @property integer $aldrette_total_keluar
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_pengguna_id
 * @property integer $update_pengguna_id
 * @property integer $create_ruangan
 * @property integer $aldrette_total_5
 * @property integer $sistolik
 * @property integer $diastolik
 */
class SkoraldretteT extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return SkoraldretteT the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'skoraldrette_t';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('skorpascaanastesi_id, create_time, create_pengguna_id, create_ruangan', 'required'),
            array('skorpascaanastesi_id, aldrette_sirkulasi_0, aldrette_sirkulasi_5, aldrette_sirkulasi_15, aldrette_sirkulasi_30, aldrette_sirkulasi_45, aldrette_sirkulasi_1, aldrette_sirkulasi_2, aldrette_sirkulasi_3, aldrette_sirkulasi_4, aldrette_sirkulasi_keluar, aldrette_kesadaran_0, aldrette_kesadaran_5, aldrette_kesadaran_15, aldrette_kesadaran_30, aldrette_kesadaran_45, aldrette_kesadaran_1, aldrette_kesadaran_2, aldrette_kesadaran_3, aldrette_kesadaran_4, aldrette_kesadaran_keluar, aldrette_oksigensi_0, aldrette_oksigensi_5, aldrette_oksigensi_15, aldrette_oksigensi_30, aldrette_oksigensi_45, aldrette_oksigensi_1, aldrette_oksigensi_2, aldrette_oksigensi_3, aldrette_oksigensi_4, aldrette_oksigensi_keluar, aldrette_pernafasan_0, aldrette_pernafasan_5, aldrette_pernafasan_15, aldrette_pernafasan_30, aldrette_pernafasan_45, aldrette_pernafasan_1, aldrette_pernafasan_2, aldrette_pernafasan_3, aldrette_pernafasan_4, aldrette_pernafasan_keluar, aldrette_aktifitas_0, aldrette_aktifitas_5, aldrette_aktifitas_15, aldrette_aktifitas_30, aldrette_aktifitas_45, aldrette_aktifitas_1, aldrette_aktifitas_2, aldrette_aktifitas_3, aldrette_aktifitas_4, aldrette_aktifitas_keluar, aldrette_total_0, aldrette_total_15, aldrette_total_30, aldrette_total_45, aldrette_total_1, aldrette_total_2, aldrette_total_3, aldrette_total_4, aldrette_total_keluar, create_pengguna_id, update_pengguna_id, create_ruangan, aldrette_total_5, sistolik, diastolik', 'numerical', 'integerOnly' => true),
            array('aldrette_sirkulasi_jam, aldrette_kesadaran_jam, aldrette_oksigensi_jam, aldrette_pernafasan_jam, aldrette_aktifitas_jam, update_time', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('skoraldrette_id, skorpascaanastesi_id, aldrette_sirkulasi_jam, aldrette_sirkulasi_0, aldrette_sirkulasi_5, aldrette_sirkulasi_15, aldrette_sirkulasi_30, aldrette_sirkulasi_45, aldrette_sirkulasi_1, aldrette_sirkulasi_2, aldrette_sirkulasi_3, aldrette_sirkulasi_4, aldrette_sirkulasi_keluar, aldrette_kesadaran_jam, aldrette_kesadaran_0, aldrette_kesadaran_5, aldrette_kesadaran_15, aldrette_kesadaran_30, aldrette_kesadaran_45, aldrette_kesadaran_1, aldrette_kesadaran_2, aldrette_kesadaran_3, aldrette_kesadaran_4, aldrette_kesadaran_keluar, aldrette_oksigensi_jam, aldrette_oksigensi_0, aldrette_oksigensi_5, aldrette_oksigensi_15, aldrette_oksigensi_30, aldrette_oksigensi_45, aldrette_oksigensi_1, aldrette_oksigensi_2, aldrette_oksigensi_3, aldrette_oksigensi_4, aldrette_oksigensi_keluar, aldrette_pernafasan_jam, aldrette_pernafasan_0, aldrette_pernafasan_5, aldrette_pernafasan_15, aldrette_pernafasan_30, aldrette_pernafasan_45, aldrette_pernafasan_1, aldrette_pernafasan_2, aldrette_pernafasan_3, aldrette_pernafasan_4, aldrette_pernafasan_keluar, aldrette_aktifitas_jam, aldrette_aktifitas_0, aldrette_aktifitas_5, aldrette_aktifitas_15, aldrette_aktifitas_30, aldrette_aktifitas_45, aldrette_aktifitas_1, aldrette_aktifitas_2, aldrette_aktifitas_3, aldrette_aktifitas_4, aldrette_aktifitas_keluar, aldrette_total_0, aldrette_total_15, aldrette_total_30, aldrette_total_45, aldrette_total_1, aldrette_total_2, aldrette_total_3, aldrette_total_4, aldrette_total_keluar, create_time, update_time, create_pengguna_id, update_pengguna_id, create_ruangan, aldrette_total_5, sistolik, diastolik', 'safe', 'on' => 'search'),
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
            'skoraldrette_id' => 'Skoraldrette',
            'skorpascaanastesi_id' => 'Skorpascaanastesi',
            'aldrette_sirkulasi_jam' => 'Aldrette Sirkulasi Jam',
            'aldrette_sirkulasi_0' => 'Aldrette Sirkulasi 0',
            'aldrette_sirkulasi_5' => 'Aldrette Sirkulasi 5',
            'aldrette_sirkulasi_15' => 'Aldrette Sirkulasi 15',
            'aldrette_sirkulasi_30' => 'Aldrette Sirkulasi 30',
            'aldrette_sirkulasi_45' => 'Aldrette Sirkulasi 45',
            'aldrette_sirkulasi_1' => 'Aldrette Sirkulasi 1',
            'aldrette_sirkulasi_2' => 'Aldrette Sirkulasi 2',
            'aldrette_sirkulasi_3' => 'Aldrette Sirkulasi 3',
            'aldrette_sirkulasi_4' => 'Aldrette Sirkulasi 4',
            'aldrette_sirkulasi_keluar' => 'Aldrette Sirkulasi Keluar',
            'aldrette_kesadaran_jam' => 'Aldrette Kesadaran Jam',
            'aldrette_kesadaran_0' => 'Aldrette Kesadaran 0',
            'aldrette_kesadaran_5' => 'Aldrette Kesadaran 5',
            'aldrette_kesadaran_15' => 'Aldrette Kesadaran 15',
            'aldrette_kesadaran_30' => 'Aldrette Kesadaran 30',
            'aldrette_kesadaran_45' => 'Aldrette Kesadaran 45',
            'aldrette_kesadaran_1' => 'Aldrette Kesadaran 1',
            'aldrette_kesadaran_2' => 'Aldrette Kesadaran 2',
            'aldrette_kesadaran_3' => 'Aldrette Kesadaran 3',
            'aldrette_kesadaran_4' => 'Aldrette Kesadaran 4',
            'aldrette_kesadaran_keluar' => 'Aldrette Kesadaran Keluar',
            'aldrette_oksigensi_jam' => 'Aldrette Oksigensi Jam',
            'aldrette_oksigensi_0' => 'Aldrette Oksigensi 0',
            'aldrette_oksigensi_5' => 'Aldrette Oksigensi 5',
            'aldrette_oksigensi_15' => 'Aldrette Oksigensi 15',
            'aldrette_oksigensi_30' => 'Aldrette Oksigensi 30',
            'aldrette_oksigensi_45' => 'Aldrette Oksigensi 45',
            'aldrette_oksigensi_1' => 'Aldrette Oksigensi 1',
            'aldrette_oksigensi_2' => 'Aldrette Oksigensi 2',
            'aldrette_oksigensi_3' => 'Aldrette Oksigensi 3',
            'aldrette_oksigensi_4' => 'Aldrette Oksigensi 4',
            'aldrette_oksigensi_keluar' => 'Aldrette Oksigensi Keluar',
            'aldrette_pernafasan_jam' => 'Aldrette Pernafasan Jam',
            'aldrette_pernafasan_0' => 'Aldrette Pernafasan 0',
            'aldrette_pernafasan_5' => 'Aldrette Pernafasan 5',
            'aldrette_pernafasan_15' => 'Aldrette Pernafasan 15',
            'aldrette_pernafasan_30' => 'Aldrette Pernafasan 30',
            'aldrette_pernafasan_45' => 'Aldrette Pernafasan 45',
            'aldrette_pernafasan_1' => 'Aldrette Pernafasan 1',
            'aldrette_pernafasan_2' => 'Aldrette Pernafasan 2',
            'aldrette_pernafasan_3' => 'Aldrette Pernafasan 3',
            'aldrette_pernafasan_4' => 'Aldrette Pernafasan 4',
            'aldrette_pernafasan_keluar' => 'Aldrette Pernafasan Keluar',
            'aldrette_aktifitas_jam' => 'Aldrette Aktifitas Jam',
            'aldrette_aktifitas_0' => 'Aldrette Aktifitas 0',
            'aldrette_aktifitas_5' => 'Aldrette Aktifitas 5',
            'aldrette_aktifitas_15' => 'Aldrette Aktifitas 15',
            'aldrette_aktifitas_30' => 'Aldrette Aktifitas 30',
            'aldrette_aktifitas_45' => 'Aldrette Aktifitas 45',
            'aldrette_aktifitas_1' => 'Aldrette Aktifitas 1',
            'aldrette_aktifitas_2' => 'Aldrette Aktifitas 2',
            'aldrette_aktifitas_3' => 'Aldrette Aktifitas 3',
            'aldrette_aktifitas_4' => 'Aldrette Aktifitas 4',
            'aldrette_aktifitas_keluar' => 'Aldrette Aktifitas Keluar',
            'aldrette_total_0' => 'Aldrette Total 0',
            'aldrette_total_15' => 'Aldrette Total 15',
            'aldrette_total_30' => 'Aldrette Total 30',
            'aldrette_total_45' => 'Aldrette Total 45',
            'aldrette_total_1' => 'Aldrette Total 1',
            'aldrette_total_2' => 'Aldrette Total 2',
            'aldrette_total_3' => 'Aldrette Total 3',
            'aldrette_total_4' => 'Aldrette Total 4',
            'aldrette_total_keluar' => 'Aldrette Total Keluar',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
            'create_pengguna_id' => 'Create Pengguna',
            'update_pengguna_id' => 'Update Pengguna',
            'create_ruangan' => 'Create Ruangan',
            'aldrette_total_5' => 'Aldrette Total 5',
            'sistolik' => 'Sistolik',
            'diastolik' => 'Diastolik',
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

        $criteria->compare('skoraldrette_id', $this->skoraldrette_id);
        $criteria->compare('skorpascaanastesi_id', $this->skorpascaanastesi_id);
        $criteria->compare('aldrette_sirkulasi_jam', $this->aldrette_sirkulasi_jam, true);
        $criteria->compare('aldrette_sirkulasi_0', $this->aldrette_sirkulasi_0);
        $criteria->compare('aldrette_sirkulasi_5', $this->aldrette_sirkulasi_5);
        $criteria->compare('aldrette_sirkulasi_15', $this->aldrette_sirkulasi_15);
        $criteria->compare('aldrette_sirkulasi_30', $this->aldrette_sirkulasi_30);
        $criteria->compare('aldrette_sirkulasi_45', $this->aldrette_sirkulasi_45);
        $criteria->compare('aldrette_sirkulasi_1', $this->aldrette_sirkulasi_1);
        $criteria->compare('aldrette_sirkulasi_2', $this->aldrette_sirkulasi_2);
        $criteria->compare('aldrette_sirkulasi_3', $this->aldrette_sirkulasi_3);
        $criteria->compare('aldrette_sirkulasi_4', $this->aldrette_sirkulasi_4);
        $criteria->compare('aldrette_sirkulasi_keluar', $this->aldrette_sirkulasi_keluar);
        $criteria->compare('aldrette_kesadaran_jam', $this->aldrette_kesadaran_jam, true);
        $criteria->compare('aldrette_kesadaran_0', $this->aldrette_kesadaran_0);
        $criteria->compare('aldrette_kesadaran_5', $this->aldrette_kesadaran_5);
        $criteria->compare('aldrette_kesadaran_15', $this->aldrette_kesadaran_15);
        $criteria->compare('aldrette_kesadaran_30', $this->aldrette_kesadaran_30);
        $criteria->compare('aldrette_kesadaran_45', $this->aldrette_kesadaran_45);
        $criteria->compare('aldrette_kesadaran_1', $this->aldrette_kesadaran_1);
        $criteria->compare('aldrette_kesadaran_2', $this->aldrette_kesadaran_2);
        $criteria->compare('aldrette_kesadaran_3', $this->aldrette_kesadaran_3);
        $criteria->compare('aldrette_kesadaran_4', $this->aldrette_kesadaran_4);
        $criteria->compare('aldrette_kesadaran_keluar', $this->aldrette_kesadaran_keluar);
        $criteria->compare('aldrette_oksigensi_jam', $this->aldrette_oksigensi_jam, true);
        $criteria->compare('aldrette_oksigensi_0', $this->aldrette_oksigensi_0);
        $criteria->compare('aldrette_oksigensi_5', $this->aldrette_oksigensi_5);
        $criteria->compare('aldrette_oksigensi_15', $this->aldrette_oksigensi_15);
        $criteria->compare('aldrette_oksigensi_30', $this->aldrette_oksigensi_30);
        $criteria->compare('aldrette_oksigensi_45', $this->aldrette_oksigensi_45);
        $criteria->compare('aldrette_oksigensi_1', $this->aldrette_oksigensi_1);
        $criteria->compare('aldrette_oksigensi_2', $this->aldrette_oksigensi_2);
        $criteria->compare('aldrette_oksigensi_3', $this->aldrette_oksigensi_3);
        $criteria->compare('aldrette_oksigensi_4', $this->aldrette_oksigensi_4);
        $criteria->compare('aldrette_oksigensi_keluar', $this->aldrette_oksigensi_keluar);
        $criteria->compare('aldrette_pernafasan_jam', $this->aldrette_pernafasan_jam, true);
        $criteria->compare('aldrette_pernafasan_0', $this->aldrette_pernafasan_0);
        $criteria->compare('aldrette_pernafasan_5', $this->aldrette_pernafasan_5);
        $criteria->compare('aldrette_pernafasan_15', $this->aldrette_pernafasan_15);
        $criteria->compare('aldrette_pernafasan_30', $this->aldrette_pernafasan_30);
        $criteria->compare('aldrette_pernafasan_45', $this->aldrette_pernafasan_45);
        $criteria->compare('aldrette_pernafasan_1', $this->aldrette_pernafasan_1);
        $criteria->compare('aldrette_pernafasan_2', $this->aldrette_pernafasan_2);
        $criteria->compare('aldrette_pernafasan_3', $this->aldrette_pernafasan_3);
        $criteria->compare('aldrette_pernafasan_4', $this->aldrette_pernafasan_4);
        $criteria->compare('aldrette_pernafasan_keluar', $this->aldrette_pernafasan_keluar);
        $criteria->compare('aldrette_aktifitas_jam', $this->aldrette_aktifitas_jam, true);
        $criteria->compare('aldrette_aktifitas_0', $this->aldrette_aktifitas_0);
        $criteria->compare('aldrette_aktifitas_5', $this->aldrette_aktifitas_5);
        $criteria->compare('aldrette_aktifitas_15', $this->aldrette_aktifitas_15);
        $criteria->compare('aldrette_aktifitas_30', $this->aldrette_aktifitas_30);
        $criteria->compare('aldrette_aktifitas_45', $this->aldrette_aktifitas_45);
        $criteria->compare('aldrette_aktifitas_1', $this->aldrette_aktifitas_1);
        $criteria->compare('aldrette_aktifitas_2', $this->aldrette_aktifitas_2);
        $criteria->compare('aldrette_aktifitas_3', $this->aldrette_aktifitas_3);
        $criteria->compare('aldrette_aktifitas_4', $this->aldrette_aktifitas_4);
        $criteria->compare('aldrette_aktifitas_keluar', $this->aldrette_aktifitas_keluar);
        $criteria->compare('aldrette_total_0', $this->aldrette_total_0);
        $criteria->compare('aldrette_total_15', $this->aldrette_total_15);
        $criteria->compare('aldrette_total_30', $this->aldrette_total_30);
        $criteria->compare('aldrette_total_45', $this->aldrette_total_45);
        $criteria->compare('aldrette_total_1', $this->aldrette_total_1);
        $criteria->compare('aldrette_total_2', $this->aldrette_total_2);
        $criteria->compare('aldrette_total_3', $this->aldrette_total_3);
        $criteria->compare('aldrette_total_4', $this->aldrette_total_4);
        $criteria->compare('aldrette_total_keluar', $this->aldrette_total_keluar);
        $criteria->compare('create_time', $this->create_time, true);
        $criteria->compare('update_time', $this->update_time, true);
        $criteria->compare('create_pengguna_id', $this->create_pengguna_id);
        $criteria->compare('update_pengguna_id', $this->update_pengguna_id);
        $criteria->compare('create_ruangan', $this->create_ruangan);
        $criteria->compare('aldrette_total_5', $this->aldrette_total_5);
        $criteria->compare('sistolik', $this->sistolik);
        $criteria->compare('diastolik', $this->diastolik);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

}
