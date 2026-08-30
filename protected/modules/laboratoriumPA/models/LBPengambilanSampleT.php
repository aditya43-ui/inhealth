<?php
/**
 * This is the model class for table "pengambilansample_t".
 *
 * The followings are the available columns in table 'pengambilansample_t':
 * @property integer $pengambilansample_id
 * @property integer $samplelab_id
 * @property integer $kirimsamplelab_id
 * @property integer $pasienmasukpenunjang_id
 * @property string $tglpengambilansample
 * @property string $no_pengambilansample
 * @property integer $jmlpengambilansample
 * @property string $tempatsimpansample
 * @property string $keterangansample
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 */
class LBPengambilanSampleT extends PengambilansampleT
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return PengambilansampleT the static model class
     */
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }
    
    public function getSampleLabItems(){
        return SamplelabM::model()->findAll('samplelab_aktif=true ORDER BY samplelab_nama');
    }
    
}
?>
