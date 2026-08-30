
<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class MAInfoprevmaintenV extends InfoprevmaintenV
{
    public $tgl_awal, $tgl_akhir;
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return KabupatenM the static model class
     */
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }
	
    /**
     * @return array customized attribute labels (name=>label)
     */
    public function searchInformasi(){          	
        $criteria=new CDbCriteria;
        $criteria->addBetweenCondition('DATE(tglprevmainten)', $this->tgl_awal, $this->tgl_akhir);
        $criteria->compare('LOWER(invperalatan_namabrg)',strtolower($this->invperalatan_namabrg),true);
        $criteria->compare('LOWER(invperalatan_kode)',strtolower($this->invperalatan_kode),true);

        return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
        ));
    }
    
    //Untuk menampilkan ceklis
    public function getCeklis($id)
    {
        $cekPrev =  PrevmaintenT::model()->findByPk($id); 
        $cekAllPrev = PrevmaintendetT::model()->findAllByAttributes(array('prevmainten_id'=>$cekPrev->prevmainten_id, 'ipmchecklist_status'=>true));
                
                $res = array();
                
                foreach ($cekAllPrev as $item) {
                    
                    if (!$item->ipmchecklist_status) {
                        continue;
                    }
                    
                    $ipm = IpmchecklistM::model()->findByPk($item->ipmchecklist_id);
                    
                    if (empty($res[$ipm->ipm_jenis])) {
                        $res[$ipm->ipm_jenis] = array();
                    }
                    
                    $res[$ipm->ipm_jenis][] = $item;
                }
                
                $str = "";
                
                foreach ($res as $jenis => $grup) {
                $str .= '<div class="ceklis'.$item->prevmainten_id.'" style="display:none;" >';
                    $str .= "<strong>".$jenis."</strong>";
                    $str .= '<ul style="list-style-type:none; margin-left:-5px">';
                    foreach ($grup as $item) { 
                        if (!$item->ipmchecklist_status) {
                            continue;
                        }
                        $str .= '<li><ul style="list-style-type:'.($item->ipmchecklist_status ? 'disc' : 'circle').'"><li>';

                        $ceklis = IpmchecklistM::model()->findByPk($item->ipmchecklist_id);
                        $str .= $ceklis->ipm_listnama;

                        $str .= '</li></ul></li>';

                    }
                    
                    $str .= '</ul></div>';
                    
                }
        echo $str;
    }
    
    //Untuk menampilkan tombol skip / wo
    public function getSkipWO($id)
    {
        $format = new MyFormatter;
        $cekInfoPrev = InfoprevmaintenV::model()->findByAttributes(array('prevmainten_id'=>$id));
        $cekWO = MAWorkorderT::model()->findByAttributes(array('prevmainten_id'=>$id));
        $cekPrev = PrevmaintenT::model()->findByAttributes(array('prevmainten_id'=>$id));
        $button = '';
            if ($cekInfoPrev->tglprevmainten <= date("Y-m-d")  && empty($cekWO) && $cekPrev->prevmainten_skip==null){
                $button .= CHtml::Link("Skip",Yii::app()->controller->createUrl("PrevmaintenT/skip",array('prevmainten_id'=>$id,"frame"=>1,"popup"=>"true")),
                            array("class"=>"", 
                                    "target"=>"iframeSkip",
                                    "onclick"=>"$(\"#dialogSkip\").dialog(\"open\");",
                                    'rel'=>'tooltip',
                                    'title'=>'Klik untuk melakukan Skip',
                                    'class'=>'btn btn-sm btn-success'
                            ))."<br>&nbsp";

                $button .= CHtml::Link("WO",Yii::app()->controller->createUrl("workOrder/index",array('prevmainten_id'=>$id,"frame"=>1,"popup"=>"true")),
                            array("class"=>"", 
                                    "target"=>"iframeWO",
                                    "onclick"=>"$(\"#dialogWO\").dialog(\"open\");",
                                    'rel'=>'tooltip',
                                    'title'=>'Klik untuk melakukan Work Order',
                                    'class'=>'btn btn-sm btn-info'
                            ));

            }elseif (!empty($cekWO)){
                $button .= "WO";

            }elseif($cekPrev->prevmainten_skip==true){
                $button .= "Skip";
            }elseif($cekInfoPrev->tglprevmainten >= date("Y-m-d") && empty($cekWO) && $cekPrev->prevmainten_skip==null){
                $button .= CHtml::Link("WO",Yii::app()->controller->createUrl("workOrder/index",array('prevmainten_id'=>$id,"frame"=>1,"popup"=>"true")),
                            array("class"=>"", 
                                    "target"=>"iframeWO",
                                    "onclick"=>"$(\"#dialogWO\").dialog(\"open\");",
                                    'rel'=>'tooltip',
                                    'title'=>'Klik untuk melakukan Work Order',
                                    'class'=>'btn btn-sm btn-info'
                            ));
            }
        echo $button;
    }
    
    //Untuk menampilkan keterangan skip
    public function getKetSkip($id){
        $cekPrev = PrevmaintenT::model()->findByAttributes(array('prevmainten_id'=>$id));
        $ket = '';
        if($cekPrev->prevmainten_skip==true){
            $modLog = LoginpemakaiK::model()->findByPk($cekPrev->prevmainten_pegawaiskip);
            if(!empty($modLog->pegawai_id)){
                $modPeg = PegawaiM::model()->findByPk($modLog->pegawai_id);
                $nama = $modPeg->nama_pegawai;
            }
            $ket .= !empty($cekPrev->prevmainten_tglskip) ? date('d M Y', strtotime($cekPrev->prevmainten_tglskip)):""; $ket .= ' - '; 
            $ket .= !empty($nama) ? $nama :""; $ket .= ' - '; 
            $ket .= $cekPrev->prevmainten_alasanskip;
        }
        echo $ket;
    }
    
    //Untuk menampilkan unit kerja
    public function getUnitKerja($id){
        $cekInfoPrev = InfoprevmaintenV::model()->findByAttributes(array('prevmainten_id'=>$id));
        $cekPeralatan = InvperalatanT::model()->findByAttributes(array('invperalatan_id'=>$cekInfoPrev->invperalatan_id));
        $cekRuanganUnit = UnitkerjaruanganM::model()->findAllByAttributes(array('ruangan_id'=>$cekPeralatan->ruangan_id));
        $unitkerja = '';
        foreach ($cekRuanganUnit as $value){
            $cekUnitKerja = UnitkerjaM::model()->findByAttributes(array('unitkerja_id'=>$value->unitkerja_id));
            $unitkerja .= $cekUnitKerja->namaunitkerja;                                            
            $unitkerja .= '<br>';
        }
        echo $unitkerja;
    }
}
?>
