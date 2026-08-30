<?php

/**
 * Model extend untuk informasireviewpejabatpengadaan_v
 *
 * @author Aida Rahmawati <aidarahmawati@.com>
 * 
 * @package application.modules.pengadaan
 * @subpackage models
 * @category model
 */
class ADInformasireviewpejabatpengadaanV extends InformasireviewpejabatpengadaanV {

    public $tgl_awal, $tgl_akhir;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return BahasilpemeriksaanpekerjaanT the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * Load Informasi Review Pejabat Pengadaan 
     * @return \CActiveDataProvider
     */
    public function searchInformasi() {
        $criteria = $this->criteriaSearch();
        $criteria->addBetweenCondition("date(t.create_time)", $this->tgl_awal, $this->tgl_akhir);
        $criteria->addCondition('info.create_loginpemakai_id = '. Yii::app()->user->getState('loginpemakai_id'). 
                                ' OR '.' t.pegpa_id = '.Yii::app()->user->getState('pegawai_id'). 
                                ' OR '.' t.pegppk_id = '.Yii::app()->user->getState('pegawai_id'). 
                                ' OR '.' t.pegpengadaan_id = '.Yii::app()->user->getState('pegawai_id'). 
                                ' OR '. ' t.pegkpa_id = '.Yii::app()->user->getState('pegawai_id'));
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Load informasi untuk dicetak 
     * @return \CActiveDataProvider
     */
    public function searchInformasiPrint() {
        $criteria = $this->criteriaSearch();
        $criteria->addBetweenCondition("date(t.create_time)", $this->tgl_awal, $this->tgl_akhir);
        $criteria->addCondition('info.create_loginpemakai_id = '. Yii::app()->user->getState('loginpemakai_id'). 
                                ' OR '.' t.pegpa_id = '.Yii::app()->user->getState('pegawai_id'). 
                                ' OR '.' t.pegppk_id = '.Yii::app()->user->getState('pegawai_id'). 
                                ' OR '.' t.pegpengadaan_id = '.Yii::app()->user->getState('pegawai_id'). 
                                ' OR '. ' t.pegkpa_id = '.Yii::app()->user->getState('pegawai_id'));

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => false,
        ));
    }

    /**
     * Load status berdasarkan infoumumpengadaan_status
     * @return type
     */
    public static function getStatusReviewItems() {
        $cri = new CDbCriteria();
        $cri->select = 't.infoumumpengadaan_status';
        $cri->group = $cri->select;
        $cri->order = 'infoumumpengadaan_status asc';
        return InfoumumpengadaanT::model()->findAll($cri);
    }

}
