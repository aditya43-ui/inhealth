<?php

class RKPasienblacklistT extends PasienblacklistT
{


    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return PegawaiM the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'pasienblacklist_id' => 'Pasienblacklist',
            'pendaftaran_id' => 'Pendaftaran',
            'pegawai_id' => 'Pegawai',
            'pasienblacklist_no' => 'No. Blacklist',
            'pasienblacklist_tgl' => 'Tgl. Blacklist',
            'pasienblacklist_karenakasus' => 'Karena Kasus',
            'pasienblacklist_ket' => 'Keterangan',
            'isblacklist' => 'Blacklist',
            'create_time' => 'Waktu Create',
            'update_time' => 'Waktu Update',
            'create_loginpemakai_id' => 'Create Login Pemakai',
            'update_loginpemakai_id' => 'Update Login Pemakai',
            'create_ruangan' => 'Create Ruangan',
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

        $criteria->compare('pasienblacklist_id', $this->pasienblacklist_id);
        $criteria->compare('pendaftaran_id', $this->pendaftaran_id);
        $criteria->compare('pegawai_id', $this->pegawai_id);
        $criteria->compare('pasienblacklist_no', $this->pasienblacklist_no, true);
        $criteria->compare('pasienblacklist_tgl', $this->pasienblacklist_tgl, true);
        $criteria->compare('pasienblacklist_karenakasus', $this->pasienblacklist_karenakasus, true);
        $criteria->compare('pasienblacklist_ket', $this->pasienblacklist_ket, true);
        $criteria->compare('isblacklist', $this->isblacklist);
        $criteria->compare('create_time', $this->create_time, true);
        $criteria->compare('update_time', $this->update_time, true);
        $criteria->compare('create_loginpemakai_id', $this->create_loginpemakai_id, true);
        $criteria->compare('update_loginpemakai_id', $this->update_loginpemakai_id, true);
        $criteria->compare('create_ruangan', $this->create_ruangan, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function searchPrint($pasienblacklist_id)
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->addCondition('pasienblacklist_id = ' . $pasienblacklist_id);


        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
}
