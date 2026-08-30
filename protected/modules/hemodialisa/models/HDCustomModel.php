<?php
/**
 * custom model, menggavbungkan data dari tabel - tabel tertentu
 * issue RSST-2633
 * @package application.modules.hemodialisa
 * @subpackage models  
 * @author      M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     2.0.0
 * @link    <http://172.9.1.15/simpp/docs/>
 * @link    <http://piindonesia.co.id>
 */
class HDCustomModel extends CFormModel
{	
    public $tgl_awal;
    public $tgl_akhir;
    
    public function rules()
    {
        return array(
            array('tgl_awal','safe','on'=>'search')
        );
    }

    /**
     * menambahkan label pada attibutenya
     * @return type
     */
    public function attributeLabels()
    {
        return array(

        );
    }
    
   public function listWaterTreatment(){
       
        $cri = new CDbCriteria();
        $cri->addCondition(" DATE(tgl_monitoring) = '".$this->tgl_awal."' ");
        
        $cri2 = clone $cri;
        $cri3 = clone $cri;
        $cri4 = clone $cri;
        
        $cri5 = new CDbCriteria();
        $cri5->addCondition(" DATE(tgl_minitoring) = '".$this->tgl_awal."' ");
        
        $chlorine = HdChlorineT::model()->find($cri);
        $hardness = HdHardnessT::model()->find($cri2);
        $tds = HdTdsT::model()->find($cri3);
        $tpc = HdTpcT::model()->find($cri4);
        $brine = HdBrinetankT::model()->find($cri5);

        $data = [
            '0' => [
                'no'=> 1,
                'water_treatment' => 'Chlorine',
                'status' => CustomFunction::set_pilihan_ceklis(!empty($chlorine)?true:false)
            ],
            '1' => [
                'no'=> 2,
                'water_treatment' => 'Hardness',
                'status' => CustomFunction::set_pilihan_ceklis(!empty($hardness)?true:false)
            ],
            '2' => [
                'no'=> 3,
                'water_treatment' => 'Total Disolve Solid',
                'status' => CustomFunction::set_pilihan_ceklis(!empty($tds)?true:false)
            ],
            '3' => [
                'no'=> 4,
                'water_treatment' => 'Total Product Capacity',
                'status' => CustomFunction::set_pilihan_ceklis(!empty($tpc)?true:false)
            ],
            '4' => [
                'no'=> 5,
                'water_treatment' => 'Brine Tank',
                'status' => CustomFunction::set_pilihan_ceklis(!empty($brine)?true:false)
            ]
        ];
       
        return new CArrayDataProvider($data, array(
            'keyField'=>'no',
            'id'=>'listWater',
                'totalItemCount'=>count($data),
                'pagination' => array(
                    'pageSize' => count($data),
                    'pageVar' => 'page'
                ),			
        ));  
   }
}
