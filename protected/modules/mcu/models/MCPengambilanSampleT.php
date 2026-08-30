<?php
class MCPengambilanSampleT extends PengambilansampleT
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
    
    public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('samplelab_id, pasienmasukpenunjang_id, tglpengambilansample, no_pengambilansample, jmlpengambilansample', 'required'),
			array('samplelab_id, kirimsamplelab_id, pasienmasukpenunjang_id, jmlpengambilansample', 'numerical', 'integerOnly'=>true),
			array('no_pengambilansample', 'length', 'max'=>50),
			array('tempatsimpansample', 'length', 'max'=>100),
			array('keterangansample, update_time, update_loginpemakai_id', 'safe'),
                        array('create_time','default','value'=>date( 'Y-m-d H:i:s', time()),'setOnEmpty'=>false,'on'=>'insert'),
                        array('update_time','default','value'=>date( 'Y-m-d H:i:s', time()),'setOnEmpty'=>false,'on'=>'update,insert'),
                        array('create_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'insert'),
                        array('create_ruangan','default','value'=>Yii::app()->user->getState('ruangan_id'),'on'=>'insert'),
                        array('update_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'update,insert'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pengambilansample_id, samplelab_id, kirimsamplelab_id, pasienmasukpenunjang_id, tglpengambilansample, no_pengambilansample, jmlpengambilansample, tempatsimpansample, keterangansample, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
		);
	}
}
?>
