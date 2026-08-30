<?php
Yii::import('pendaftaranPenjadwalan.models.PPPendaftaranT');
/**
 * RND-7811 : INI SUDAH TIDAK DIGUNAKAN LAGI, FUNCTION PINDAHKAN KE CONTROLLER MASING2
 */
class ActionAjaxController extends Controller
{
    public function actionCekPulsaKasir() {
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }
        
        $is_ada = 0;

        $ruangan = RuanganpegawaiM::model()->findByAttributes(['ruangan_id'=>66, 'pegawai_id'=>Yii::app()->user->getState('pegawai_id')]);
        if(!empty($ruangan)){
            
            $cr = new CDbCriteria();
            $cr->compare('ruangan_id', Yii::app()->user->getState('ruangan_id'));
            $cr->compare('pegawai_id', Yii::app()->user->getState('pegawai_id'));
            $cr->compare('tglpengisiansaldo::date', date('Y-m-d'));
            
            $saldo = PengisiansaldoawalT::model()->find($cr);

            if (!empty($saldo)) {
                $is_ada = 1;
            }else{
                $is_ada = 0;
            }
        }else{
            $is_ada = 1;
        }

        // $cr = new CDbCriteria();
        // $cr->compare('ruangan_id', Yii::app()->user->getState('ruangan_id'));
        // $cr->compare('tglpengisiansaldo::date', date('Y-m-d'));
        
        // $saldo = PengisiansaldoawalT::model()->find($cr);
        
        // if (!empty($saldo)) {
        //     $is_ada = 1;
        // }
        
        
        
        
        //if ()
        
        
        
        
        echo CJSON::encode(array(
            'is_ada'=>$is_ada
        ));
    }
    //-- SistemAdministrator --//
    //function ajax get data Harga Tipe Paket Pelayanan dari sistemAdministrator/paketpelayananM
    public function actionGetTipePaket()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $idTipePaket = $_POST['idTipePaket'];
            $modTipePaket = TipepaketM::model()->findByPk($idTipePaket);
            $data['asuransi'] = $modTipePaket->paketsubsidiasuransi;
            $data['pemerintah'] = $modTipePaket->paketsubsidipemerintah;
            $data['rs'] = $modTipePaket->paketsubsidirs;
            $data['iurbiaya'] = $modTipePaket->paketiurbiaya;
            $data['kelaspelayanan_id'] = $modTipePaket->kelaspelayanan_id;
            $data['tarifpaketpel'] = $modTipePaket->tarifpaket;
            $modPaket = PaketpelayananM::model()->findAll('tipepaket_id = '.$idTipePaket);
            
            $tr = '';
            if (count((array)$modPaket)>0){
                foreach ($modPaket as $i=>$row){
                    $modTarifTindakan = TariftindakanM::model()->findByAttributes(array('daftartindakan_id' => $row->daftartindakan_id, 'komponentarif_id'=>  6, 'kelaspelayanan_id'=>$modTipePaket->kelaspelayanan_id));
                
                    $tr .= "<tr>
                            <td>".CHtml::TextField('noUrut', ($i+1), array('class' => 'span1 noUrut', 'readonly' => TRUE)) .
                                CHtml::activeHiddenField($row, '['.$row->daftartindakan_id.']tipepaket_id') .
                                CHtml::activeHiddenField($row, '['.$row->daftartindakan_id.']daftartindakan_id') .
                                CHtml::activeHiddenField($row, '['.$row->daftartindakan_id.']ruangan_id') .
                                CHtml::activeHiddenField($row, '['.$row->daftartindakan_id.']paketpelayanan_id') ."</td>
                            <td>".$row->tipepaket->tipepaket_nama . "</td>
                            <td>".$row->daftartindakan->daftartindakan_nama . "</td>
                            <td>".CHtml::activeDropDownList($row, '['.$row->daftartindakan_id.']ruangan_id', CHtml::listData(RuanganM::model()->findAll(), 'ruangan_id', 'ruangan_nama'), array('empty'=>'-- Pilih --', 'class' => 'span2 ruangan', 'onkeypress' => "return $(this).focusNextInputField(event)")) . "</td>
                            <td>".CHtml::activeTextField($row, '['.$row->daftartindakan_id.']namatindakan', array( 'class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event)")) . "</td>
                            <td>".CHtml::TextField('totaltarif[]', $modTarifTindakan->harga_tariftindakan, array('readonly' => true, 'class' => 'span2 totalTarif', 'onkeypress' => "return $(this).focusNextInputField(event)")) . "</td>
                            <td>".CHtml::activeTextField($row, '['.$row->daftartindakan_id.']tarifpaketpel', array('parent'=>'SAPaketpelayananM_tarifpaketpel', 'class' => 'span1 tarifpaket numbersOnly', 'onblur' => 'sum(this);', 'onkeypress' => "return $(this).focusNextInputField(event)")) . "</td>
                            <td>".CHtml::activeTextField($row, '['.$row->daftartindakan_id.']subsidiasuransi', array('parent'=>'SAPaketpelayananM_subsidiasuransi', 'class' => 'span1 subisidiAsuransi numbersOnly', 'onblur' => 'sum(this);', 'onkeypress' => "return $(this).focusNextInputField(event)")) . "</td>
                            <td>".CHtml::activeTextField($row, '['.$row->daftartindakan_id.']subsidipemerintah', array('parent'=>'SAPaketpelayananM_subsidipemerintah', 'class' => 'span1 subisidiPemerintah numbersOnly', 'onblur' => 'sum(this);', 'onkeypress' => "return $(this).focusNextInputField(event)")) . "</td>
                            <td>".CHtml::activeTextField($row, '['.$row->daftartindakan_id.']subsidirumahsakit', array('parent'=>'SAPaketpelayananM_subsidirumahsakit',  'class' => 'span1 subisidiRS numbersOnly', 'onblur' => 'sum(this);', 'onkeypress' => "return $(this).focusNextInputField(event)")) . "</td>
                            <td>".CHtml::activeTextField($row, '['.$row->daftartindakan_id.']iurbiaya', array('parent'=>'SAPaketpelayananM_iurbiaya', 'class' => 'span1 iurBiaya numbersOnly', 'onblur' => 'sum(this);', 'onkeypress' => "return $(this).focusNextInputField(event)")) . "</td>

                            <td>".CHtml::link("<i class='icon-remove'></i>", '', array('href'=>'','onclick'=>'remove2(this);return false;'))."</td>
                        </tr>";
                }
            }
            $data['tr'] = $tr;

            echo json_encode($data);
            Yii::app()->end();
        }
    }
    
    //-- sistemAdministrator --//
    //function ajax get data Penjamin untuk form Master Tanggungan Penjamin
    public function actionGetPenjamin()
    {
        if(Yii::app()->request->isAjaxRequest) { 
            $idCaraBayar=$_POST['idCaraBayar'];
            $idKelasPelayanan = $_POST['idKelasPelayanan'];
            $modPenjamin = PenjaminpasienM::model()->findAllByAttributes(array('carabayar_id'=>$idCaraBayar));
//            $TanggunganPenjamin = TanggunganpenjaminM::model()->with('penjamin')->findAllByAttributes(array('carabayar_id'=>$idCaraBayar));
            $tr='';
            if (count((array)$modPenjamin) > 0){
                foreach ($modPenjamin as $i=>$row){
                    $tanggungan = TanggunganpenjaminM::model()->findByAttributes(array('carabayar_id'=>$idCaraBayar, 'penjamin_id'=>$row->penjamin_id, 'kelaspelayanan_id'=>$idKelasPelayanan));
                    if (count((array)$tanggungan) == 1){
                        $tampilDetail = $tanggungan;
                    }
                    else{
                        $tampilDetail = new TanggunganpenjaminM;
                        $tampilDetail->kelaspelayanan_id = $idKelasPelayanan;
                        $tampilDetail->carabayar_id = $idCaraBayar;
                        $tampilDetail->penjamin_id = $row->penjamin_id;
                        $tampilDetail->subsidiasuransitind = 0;
                        $tampilDetail->subsidipemerintahtind=0;
                        $tampilDetail->subsidirumahsakittind=0;
                        $tampilDetail->iurbiayatind=0;
                        $tampilDetail->subsidiasuransioa=0;
                        $tampilDetail->subsidipemerintahoa=0;
                        $tampilDetail->subsidirumahsakitoa=0;
                        $tampilDetail->iurbiayaoa=0;
                        $tampilDetail->persentanggcytopel=0;
                        $tampilDetail->makstanggpel=0;
                    }
                    $tr .="<tr>
                                <td>".CHtml::TextField('noUrut',($i+1),array('class'=>'span1 noUrut','readonly'=>TRUE)).
                                      CHtml::activeHiddenField($tampilDetail, '['.$i.']penjamin_id') .
                                      CHtml::activeHiddenField($tampilDetail, '['.$i.']carabayar_id') .
                                      CHtml::activeHiddenField($tampilDetail, '['.$i.']kelaspelayanan_id') .
                                      CHtml::activeHiddenField($tampilDetail, '['.$i.']tanggunganpenjamin_id') .
                               "</td>
                                <td>".$tampilDetail->penjamin->penjamin_nama."</td>
                                <td>".CHtml::activeTextField($tampilDetail,'['.$i.']subsidiasuransitind',array('group'=>'group1','class'=>'span1 asuransitind numbersOnly', 'onblur'=>'change(this);', 'onkeypress' => "return $(this).focusNextInputField(event)"))."</td>
                                <td class='cols_hide'>".CHtml::activeTextField($tampilDetail,'['.$i.']subsidipemerintahtind',array('group'=>'group1','class'=>'span1 numbersOnly pemerintahtind', 'onblur'=>'change(this);', 'onkeypress' => "return $(this).focusNextInputField(event)"))."</td>
                                <td>".CHtml::activeTextField($tampilDetail,'['.$i.']subsidirumahsakittind',array('group'=>'group1','class'=>'span1 numbersOnly rumahsakittind', 'onblur'=>'change(this);', 'onkeypress' => "return $(this).focusNextInputField(event)"))."</td>
                                <td>".CHtml::activeTextField($tampilDetail,'['.$i.']iurbiayatind',array('group'=>'group1','class'=>'span1 numbersOnly iurbiayatind', 'onblur'=>'change(this);', 'onkeypress' => "return $(this).focusNextInputField(event)"))."</td>
                                <td>".CHtml::activeTextField($tampilDetail,'['.$i.']subsidiasuransioa',array('group'=>'group2','class'=>'span1 numbersOnly asuransioa', 'onblur'=>'change(this);', 'onkeypress' => "return $(this).focusNextInputField(event)"))."</td>
                                <td class='cols_hide'>".CHtml::activeTextField($tampilDetail,'['.$i.']subsidipemerintahoa',array('group'=>'group2','class'=>'span1 numbersOnly pemerintahoa', 'onblur'=>'change(this);', 'onkeypress' => "return $(this).focusNextInputField(event)"))."</td>
                                <td>".CHtml::activeTextField($tampilDetail,'['.$i.']subsidirumahsakitoa',array('group'=>'group2','class'=>'span1 numbersOnly rumahsakitoa', 'onblur'=>'change(this);', 'onkeypress' => "return $(this).focusNextInputField(event)"))."</td>
                                <td>".CHtml::activeTextField($tampilDetail,'['.$i.']iurbiayaoa',array('group'=>'group2','class'=>'span1 numbersOnly iurbiayaoa', 'onblur'=>'change(this);', 'onkeypress' => "return $(this).focusNextInputField(event)"))."</td>
                                <td>".CHtml::activeTextField($tampilDetail,'['.$i.']persentanggcytopel',array('group'=>'group3','class'=>'span1 numbersOnly persentanggung', 'onblur'=>'change(this);', 'onkeypress' => "return $(this).focusNextInputField(event)"))."</td>
                                <td>".CHtml::activeTextField($tampilDetail,'['.$i.']makstanggpel',array('class'=>'span1 numbersOnly makstanggpel', 'onblur'=>'change(this);', 'onkeypress' => "return $(this).focusNextInputField(event)"))."</td>
                                <td>".CHtml::link("<i class='icon-remove'></i>", '', array('href'=>'','onclick'=>'remove(this);return false;'))."</td>
                            </tr>
                            ";     

                }
            }
           
           $data['tr']=$tr;
           echo json_encode($data);
         Yii::app()->end();
        }
    }
    
    //-- Rawat Jalan --//
    //function ajax get data Diagnosa Keperawatan untuk form Transaksi Asuhan Keperawatan
    public function actionGetDiagnosaKeperawatan(){
        if(Yii::app()->request->isAjaxRequest) { 
            $idDiagnosaKeperawatan = $_POST['idDiagnosaKeperawatan'];
            $modDiagnosaKeperawatan = DiagnosakeperawatanM::model()->findByPk($idDiagnosaKeperawatan);
            $modRencana = RencanakeperawatanM::model()->findAllByAttributes(array('diagnosakeperawatan_id'=>$modDiagnosaKeperawatan->diagnosakeperawatan_id));
            $modImplementasi = ImplementasikeperawatanM::model()->findAllByAttributes(array('diagnosakeperawatan_id'=>$modDiagnosaKeperawatan->diagnosakeperawatan_id));
            $data1 ='';
            $data2 ='';
            $tr = $tr2 = $tr3 = '';
            if (count((array)$modRencana) > 0 ){
                $data1 .= '<ul id="intervensi">';
                foreach($modRencana as $row){
                    if (empty($row->iskolaborasiintervensi)){
                        $row->iskolaborasiintervensi = 0;
                    }
                    $data1 .= '<li>'.CHtml::checkBox('rencana_intervensi[][]', false, array('value'=>$row->rencanakeperawatan_id, 'onclick'=>'submitIntervensi(this);', 'class'=>'intervensi_check', 'textData'=>$row->rencana_intervensi, 'valuedata'=>$row->rencanakeperawatan_id, 'kolaborasi'=>$row->iskolaborasiintervensi, 'value'=>$row->rencanakeperawatan_id)).'<span>'.$row->rencana_intervensi.'</span></li>';
                }
                $data1 .= '</ul>';
            }
            if (count((array)$modImplementasi) > 0 ){
                $data2 .= '<ul id="implementasi">';
                foreach($modImplementasi as $row){
                    $data2 .= '<li>'.CHtml::checkBox('rencana_implementasi[][]', false, array('onclick'=>'warnai(this)', 'class'=>'implementasi_check','textData'=>$row->implementasi_nama, 'valueData'=>$row->implementasikeperawatan_id, 'value'=>$row->implementasikeperawatan_id)).'<span>'.$row->implementasi_nama.'</span></li>';
                }
                $data2 .= '</ul>';
            }
            if (count((array)$modDiagnosaKeperawatan) > 0){
                $model = new AsuhankeperawatanT;                
                $tr .="<tr>
                            <td><div class='input-append'>
                                ".CHtml::textField('nama_diagnosa',$modDiagnosaKeperawatan->diagnosa_keperawatan, array('class'=>'span2','readOnly'=>true))."
                            <span class='add-on'><i class='icon-list-alt'></i></span></div>
                                ".CHtml::activeHiddenField($model, 'diagnosakeperawatan_id[]', array('value'=>$idDiagnosaKeperawatan, 'class'=>'span3', 'onkeypress' => "return $(this).focusNextInputField(event)"))."
                                ".CHtml::hiddenField('urutan[]', '',array('class'=>'span2 urutan', 'onkeypress' => "return $(this).focusNextInputField(event)"))."
                            </td>
                            <td>".$data1."</td>
                            <td>".$data2."</td>                            
                        </tr>
                        ";
                //<td>".CHtml::activeDropDownList($model, 'evaluasi_assesment[]', CHtml::listData($models, $valueField, $textField), $htmlOptions)($model, 'evaluasi_obbjektif', array('cols'=>3, 'rows=>2', 'class'=>'span2', 'onkeypress' => "return $(this).focusNextInputField(event)"))."</td>
                $tr2 .="<tr>
                            <td width='160px'><div class='input-append'>
                                ".CHtml::textField('nama_diagnosa',$modDiagnosaKeperawatan->diagnosa_keperawatan, array('class'=>'span2','readOnly'=>true))."
                            <span class='add-on'><i class='icon-list-alt'></i></span></div>
                                ".CHtml::activeHiddenField($model, 'diagnosa_id[]',array('value'=>$modDiagnosaKeperawatan->diagnosa_id, 'class'=>'span2 urutan', 'onkeypress' => "return $(this).focusNextInputField(event)")).
                                  CHtml::hiddenField('urutan[]', '',array('class'=>'span2 urutan', 'onkeypress' => "return $(this).focusNextInputField(event)"))."</td>
                            <td>".CHtml::activeTextArea($model, 'evaluasi_subjektif[]', array('cols'=>3, 'rows=>2', 'class'=>'span2', 'onkeypress' => "return $(this).focusNextInputField(event)"))."</td>
                            <td>".CHtml::activeTextArea($model, 'evaluasi_objektif[]', array('cols'=>3, 'rows=>2', 'class'=>'span2', 'onkeypress' => "return $(this).focusNextInputField(event)"))."</td>
                            <td>".CHtml::activeDropDownList($model, 'evaluasi_assesment[]', LookupM::getItems('evaluasi_assesment'), array('empty'=>'-- Pilih --', 'class'=>'span2', 'onkeypress' => "return $(this).focusNextInputField(event)"))."</td>
                            <td>".CHtml::activeTextArea($model, 'askep_tujuan[]', array('cols'=>3, 'rows=>2', 'class'=>'span2', 'onkeypress' => "return $(this).focusNextInputField(event)"))."</td>                               
                            <td>".CHtml::activeTextArea($model, 'askep_kriteriahasil[]', array('cols'=>3, 'rows=>2', 'class'=>'span2', 'onkeypress' => "return $(this).focusNextInputField(event)"))."</td>
                        </tr>";
                $tr3 .= "<tr>
                            
                            <td width='160px'><div class='input-append'>
                                ".CHtml::textField('nama_diagnosa',$modDiagnosaKeperawatan->diagnosa_keperawatan, array('class'=>'span2','readOnly'=>true))."
                            <span class='add-on'><i class='icon-list-alt'></i></span></div>
                                              ".CHtml::hiddenField('urutan[]', '',array('class'=>'span2 urutan', 'onkeypress' => "return $(this).focusNextInputField(event)"))."</td>
                            <td>
                            <table class='block'>
                                <tr>
                                    <td>
                                        <div class='boxtindakan'>
                                            <h6>Intervensi</h6>
                                            <div class='isi_inter'>
                                                <ul></ul>
                                            </div>
                                        </div>
                                     </td>                                     
                                    <td>
                                        <div class='boxtindakan'>
                                            <h6>Yang Diambil</h6>
                                            <div class='ambil_inter'>
                                                <ul></ul>
                                            </div>
                                        </div>
                                     </td>                                                          
                                     </tr>
                                     <tr>
                                    <td>
                                        <div class='boxtindakan'>
                                            <h6>Kolaborasi</h6>
                                            <div class='isi_kolab'>
                                                <ul></ul>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class='boxtindakan'>
                                            <h6>Yang Diambil</h6>
                                            <div class='ambil_kolab'>
                                                <ul></ul>
                                            </div>
                                        </div>
                                    </td>
                              </tr>
                          </table>
                          </td>
                        </tr>
                            ";
            }
           $data['tr']=$tr;
           $data['tr2']=$tr2;
           $data['tr3']=$tr3;
//           $data['jam']=$jam;
           $data['id']=$idDiagnosaKeperawatan;
           echo json_encode($data);
         Yii::app()->end();
        }
    }
   
    //-- Rawat Jalan --//
    //function ajax get Text Tekanan Darah untuk form Pemeriksaan Fisik
    
    
    //-- Rawat Jalan --//
    //function ajax get Text Tekanan Body Mass Index untuk form Pemeriksaan Fisik
    

    

    

    //-- Rawat Jalan --//
    //function ajax get Value from device untuk form Pemeriksaan Fisik
   
    
    public function actionGetScoreApacheRI(){
        if (Yii::app()->request->isAjaxRequest){
            $score = $_POST['score'];
            $id = $_POST['id'];
            $id = explode('_',$id);
            if (!empty($id[3])){
                $aktif = true;
            }else{
                $aktif = false;
            }
            $scoreId = $id[2];

            $criteria2 = new CDbCriteria();
            $criteria2->select = 'max(point_minimal) as max_point';
            $criteria2->compare('apachescore_id',$scoreId);
            if (($aktif == true)&&($scoreId == 10)){
                $criteria2->compare('point_arf',true);
            }
            $modApache = ScorepointM::model()->find($criteria2);

            $criteria = new CDbCriteria();
            $criteria->compare('apachescore_id',$scoreId);
            if ($score > $modApache->max_point){
                if (($aktif == true)&&($scoreId == 10)){
                    $criteria->compare('point_arf',true);
                }
                $criteria->addCondition('point_minimal <= '.$score.' and point_maksimal = 0');
            }else{
                $criteria->addCondition($score.' >= point_minimal');
                $criteria->addCondition($score.' <= point_maksimal');
                
            }

            $data['pointscore']= ScorepointM::model()->find($criteria)->point_score;
            echo json_encode($data);
            Yii::app()->end();
        }
    }
    
    

    public function actionGetJadwalMakan()
    {
       if(Yii::app()->request->isAjaxRequest) { 
           $jeniswaktu = $_POST['jeniswaktu'];
            $jenisdietid=$_POST['jenisdietid'];
            $tipedietid = $_POST['tipedietid'];
            $jeniswaktuid = $_POST['jeniswaktuid'];
            $menudietid = $_POST['menudietid'];
            $modJadwalMakan = new JadwalMakanM;
            $modJenisdiet = JenisdietM::model()->findByPk($jenisdietid);
            $modTipeDiet=TipeDietM::model()->findByPK($tipedietid);
            $modJenisWaktu = JenisWaktuM::model()->findByPK($jeniswaktuid);
            
            $modMenuDiet = MenuDietM::model()->findByPK($menudietid);
            $return = array();
            $tipejeniswaktu = JenisWaktuM::model()->findAll('jeniswaktu_aktif = true ORDER BY jeniswaktu_id');
            
                $tr .="<tr><td>";
                $tr .= CHtml::checkBox('JadwalMakanM[][checkList]',true,array('class'=>'cekList'));
                $tr .= "</td><td>";
                $tr .= $modJenisdiet->jenisdiet_nama;
                $tr .= CHtml::activeHiddenField($modJadwalMakan, '[]jenisdiet_id', array('value'=>$modJenisdiet->jenisdiet_id));
                $tr .= CHtml::activeHiddenField($modJadwalMakan, '[]tipediet_id',array('value'=>$modTipeDiet->tipediet_id));
                $tr .= CHtml::activeHiddenField($modJadwalMakan, '[]jeniswaktu_id',array('value'=>$modJenisWaktu->jeniswaktu_id)); 
                $tr .= "</td><td>";
                $tr .= $modTipeDiet->tipediet_nama;
                $tr .= "</td>";
                
                foreach ($tipejeniswaktu as $waktu){
                    if (in_array($waktu->jeniswaktu_id, $jeniswaktuid)){
                    $tr .= "<td>";
                    $tr .= CHtml::hiddenField('JadwalMakanM[][menudiet_id]['.$waktu->jeniswaktu_id.']',$modMenuDiet->menudiet_id, array('class'=>'menudiet'));
                    $tr .= '<div class="input-append">';
                    $tr .= CHtml::textField('namaMenuDiet',$modMenuDiet->menudiet_nama, array('class'=>'adamenudiet span2'));
                    $tr .= '<span class="add-on"><a href="javascript:void(0);" onclick="openDialog(this);return false;"><i class="icon-list-alt icon-search"></i><i class="entypo-search"></i></a></span>';
                    $tr .= '</div>';
//                    $tr .= $modMenuDiet->menudiet_nama;
                    $tr .="</td>";
                    }
                    else{
                        $tr .= "<td>";
                    $tr .= CHtml::hiddenField('JadwalMakanM[][menudiet_id]['.$waktu->jeniswaktu_id.']', '', array('class'=>'menudiet'));
                    $tr .= '<div class="input-append">';
                    $tr .= CHtml::textField('namaMenuDiet','', array('class'=>'adamenudiet span2'));
                    $tr .= '<span class="add-on"><a href="javascript:void(0);" onclick="openDialog(this);return false;"><i class="icon-list-alt icon-search"></i><i class="entypo-search"></i></a></span>';
                    $tr .= '</div>';
//                    $tr .= $modMenuDiet->menudiet_nama;
                    $tr .="</td>";
                    }
                }
                    
                $tr .= "</tr>";   
            $return .= $tr;
           $data['return']=$return;
           echo json_encode($data);
         Yii::app()->end();
        }
    } 

    public function actionGetBahanMakanan(){
        
        
      if (Yii::app()->request->isAjaxRequest){
            
            
//            $tr = '<tr>
//                    <td>'
//                        .CHtml::checkBox('checkList[]',true,array('class'=>'cekList','onclick'=>'hitungSemua()'))
////                        .CHtml::checkBox($modDetail,'checkList[]', array('value'=>1, 'class'=>'cekList','onclick'=>'hitungSemua()'))
//                        .CHtml::activeHiddenField($modDetail,'golbahanmakanan_id[]', array('value'=>$model->golbahanmakanan_id))
//                        .CHtml::activeHiddenField($modDetail,'bahanmakanan_id[]', array('value'=>$model->bahanmakanan_id))
//                        .CHtml::activeHiddenField($modDetail,'jmlkemasan[]', array('value'=>$model->jmldlmkemasan))            
//                        .CHtml::activeHiddenField($modDetail,'harganettobhn[]', array('value'=>$model->harganettobahan))
//                        .CHtml::activeHiddenField($modDetail,'ukuranbahan[]', array('value'=>$ukuran))
//                        .CHtml::activeHiddenField($modDetail,'merkbahan[]', array('value'=>$merk))
//                    .'</td>
//                    <td>'.CHtml::textField('noUrut[]',true,array('class'=>'noUrut span1', 'readonly'=>true)).'</td>
//                    <td>'.$model->golbahanmakanan->golbahanmakanan_nama.'</td>
//                    <td>'.$model->jenisbahanmakanan.'</td>
//                    <td>'.$model->kelbahanmakanan.'</td>
//                    <td>'.$model->namabahanmakanan.'</td>
//                    <td>'.$model->jmlpersediaan.'</td>
//                    <td>'.CHtml::activeDropDownList($modDetail, 'satuanbahan[]', LookupM::getItems('satuanbahanmakanan'), array('class'=>'satuanbahan span1')).'</td>
//                    <td>'.$model->harganettobahan.'</td>
//                    <td>'.$model->hargajualbahan.'</td>
//                    <td>'.$model->discount.'</td>
//                    <td>'.$model->tglkadaluarsabahan.'</td>
//                    
//                    <td>'.CHtml::activeTextField($modDetail, 'qtypengajuan[]', array('value'=>$qty, 'class'=>'span1 numbersOnly qty', 'onkeyup'=>'hitung(this);')).'</td>
//                    <td>'.CHtml::TextField('subNetto[]',$subNetto,array('value'=>$subNetto, 'class'=>'subNetto span2','readonly'=>true)).'</td>
//                    </tr>';
            
            $idBahan = $_POST['id'];
            $qty = $_POST['qty'];
            $ukuran = $_POST['ukuran'];
            $merk = $_POST['merk'];
            $satuanbahan = $_POST['satuanbahan'];
            
            if (!is_numeric($qty)){
                $qty = 0;
            }
            
            $model = BahanmakananM::model()->with('golbahanmakanan')->findByPk($idBahan);
            if ($satuanbahan != $model->satuanbahan){
                $model->satuanbahan = $satuanbahan;
            }
            
            $modDetail = new PengajuanbahandetailT;
            $subNetto = $qty*$model->harganettobahan;
            
            $nourut = 1;
                $tr ="<tr>
                        <td>".CHtml::checkBox('checkList',true,array('class'=>'cekList','onclick'=>'hitungSemua();')).                              
                              CHtml::activeHiddenField($modDetail,'['.$idBahan.']golbahanmakanan_id',array('value'=>$model->golbahanmakanan_id, 'class'=>'golbahanmakanan_id')).
                              CHtml::activeHiddenField($modDetail,'['.$idBahan.']bahanmakanan_id',array('value'=>$model->bahanmakanan_id, 'class'=>'bahanmakanan_id')).
                              CHtml::activeHiddenField($modDetail,'['.$idBahan.']jmlkemasan',array('value'=>$model->jmldlmkemasan, 'class'=>'jmldlmkemasan')).
                              CHtml::activeHiddenField($modDetail,'['.$idBahan.']harganettobhn',array('value'=>$model->harganettobahan, 'class'=>'harganettobhn')).
                              CHtml::activeHiddenField($modDetail,'['.$idBahan.']ukuranbahan',array('value'=>$ukuran, 'class'=>'ukuranbahan')).
                              CHtml::activeHiddenField($modDetail,'['.$idBahan.']merkbahan',array('value'=>$merk, 'class'=>'merkbahan')).
                       "</td>
                        <td>".CHtml::TextField('noUrut','',array('class'=>'span1 noUrut','readonly'=>TRUE))."</td>
                        <td>".$model->golbahanmakanan->golbahanmakanan_nama."</td>
                        <td>".$model->jenisbahanmakanan."</td>
                        <td>".$model->kelbahanmakanan."</td>
                        <td>".$model->namabahanmakanan."</td>
                        <td>".$model->jmlpersediaan."</td>
                        <td>".CHtml::activeDropDownList($modDetail,'['.$idBahan.']satuanbahan', LookupM::getItems('satuanbahanmakanan'), array('class'=>'satuanbahan span1'))."</td>
                        <td>".$model->harganettobahan."</td>
                        <td>".$model->hargajualbahan."</td>
                        <td>".$model->discount."</td>
                        <td>".$model->tglkadaluarsabahan."</td>
                        <td>".CHtml::activetextField($modDetail,'['.$idBahan.']qtypengajuan',array('value'=>$qty,'class'=>'span1 numbersOnly qty','onkeyup'=>'hitung(this);'))."</td>
                        <td>".CHtml::activetextField($modDetail,'['.$idBahan.']subNetto',array('value'=>$subNetto,'class'=>'span1 numbersOnly subNetto','readonly'=>true))."</td>
                        <td>".CHtml::link("<span class='icon-remove'>&nbsp;</span>",'',array('href'=>'#','onclick'=>'remove(this);return false;','style'=>'text-decoration:none;', 'class'=>'cancel'))."</td>
                      </tr>";
               $data['tr']=$tr;
            echo json_encode($data);
            Yii::app()->end();
        }
    }
    
    public function actionGetBahanMakananDariPenerimaan(){
        if (Yii::app()->request->isAjaxRequest){
            $idBahan = $_POST['id'];
            $qty = $_POST['qty'];
            $ukuran = $_POST['ukuran'];
            $merk = $_POST['merk'];
            $satuanbahan = $_POST['satuanbahan'];
            if (!is_numeric($qty)){
                $qty = 0;
            }
            $model = BahanmakananM::model()->with('golbahanmakanan')->findByPk($idBahan);
            $modDetail = new TerimabahandetailT();
            $subNetto = $qty*$model->harganettobahan;
//            $modDetail->satuanbahan[] = $satuanbahan;
            $tr = '<tr>
                    <td>'
                        .CHtml::checkBox('checkList[]',true,array('class'=>'cekList','onclick'=>'hitungSemua()'))
                        .CHtml::activeHiddenField($modDetail, 'golbahanmakanan_id[]', array('value'=>$model->golbahanmakanan_id))
                        .CHtml::activeHiddenField($modDetail, 'bahanmakanan_id[]', array('value'=>$model->bahanmakanan_id))
                        .CHtml::activeHiddenField($modDetail, 'harganettobhn[]', array('value'=>$model->harganettobahan))
                        .CHtml::activeHiddenField($modDetail, 'jmlkemasan[]', array('value'=>$model->jmldlmkemasan))            
                        .CHtml::activeHiddenField($modDetail, 'hargajualbhn[]', array('value'=>$model->hargajualbahan))
                        .CHtml::activeHiddenField($modDetail, 'ukuran_bahanterima[]', array('value'=>$ukuran))
                        .CHtml::activeHiddenField($modDetail, 'merk_bahanterima[]', array('value'=>$merk))
                    .'</td>
                    <td>'.CHtml::textField('noUrut[]',true,array('class'=>'noUrut span1', 'readonly'=>true)).'</td>
                    <td>'.$model->golbahanmakanan->golbahanmakanan_nama.'</td>
                    <td>'.$model->jenisbahanmakanan.'</td>
                    <td>'.$model->kelbahanmakanan.'</td>
                    <td>'.$model->namabahanmakanan.'</td>
                    <td>'.$model->jmlpersediaan.'</td>
                    <td>'.CHtml::activeDropDownList($modDetail, 'satuanbahan[]', LookupM::getItems('satuanbahanmakanan'), array( 'class'=>'span1 satuanbahan')).'</td>
                    <td>'.$model->harganettobahan.'</td>
                    <td>'.$model->hargajualbahan.'</td>
                    <td>'.CHtml::activeTextField($modDetail, 'discount[]', array('value'=>$model->discount, 'class'=>'discount span1 numbersOnly', 'onkeyup'=>'hitungTotalDiscount();')).'</td>
                    <td>'.$model->tglkadaluarsabahan.'</td>
                    
                    <td>'.CHtml::activeTextField($modDetail, 'qty_terima[]', array('value'=>$qty, 'class'=>'span1 numbersOnly qty', 'onkeyup'=>'hitung(this);')).'</td>
                    <td>'.CHtml::TextField('subNetto[]',$subNetto,array('value'=>$subNetto, 'class'=>'subNetto span2','readonly'=>true)).'</td>
                    </tr>';
            echo json_encode($tr);
            Yii::app()->end();
        }
    }
    
    public function actionGetMenuDietDetail(){
        if (Yii::app()->request->isAjaxRequest){
            $pasien_id = (isset($_POST['pasien_id']) ? $_POST['pasien_id'] : null);
            $pendaftaran_id = (isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null);
            $pasienadmisi_id =  (isset($_POST['pasienadmisi_id']) ? $_POST['pasienadmisi_id'] : null);
            $menudiet_id =  (isset($_POST['idMenuDiet']) ? $_POST['idMenuDiet'] : null);
            $ruangan_id = (isset($_POST['idRuangan']) ? $_POST['idRuangan'] : null);
            $instalasi_id = (isset($_POST['idInstalasi']) ? $_POST['idInstalasi'] : null);
            
            $urt = $_POST['urt'];
            $jumlah = $_POST['jumlah'];
            $jeniswaktu = $_POST['jeniswaktu'];
            $pendaftaranId =  (isset($_POST['pendaftaranId']) ? $_POST['pendaftaranId'] : null);
            $pasienAdmisi =  (isset($_POST['pasienAdmisi']) ? $_POST['pasienAdmisi'] : null);
            $modDetail = new PesanmenudetailT();
            $modJenisWaktu = JeniswaktuM::model()->findAll('jeniswaktu_aktif = true');
            $diet = MenuDietM::model()->findByPK($menudiet_id);
            $jumlahPasien = count((array)$pasienAdmisi);
            if ($jumlahPasien == 0){
                $jumlahPasien = 1;
            }
            $tr = '';
            for($i = 0; $i < $jumlahPasien; $i++) {
            $modDetail = new PesanmenudetailT();
                if (empty($pasienAdmisi)) {
                    $model = InfokunjunganriV::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id, 'ruangan_id' => $ruangan_id, 'pasienadmisi_id' => $pasienadmisi_id));
                } else {
                    $model = InfokunjunganriV::model()->findByAttributes(array('pendaftaran_id' => $pendaftaranId[$i], 'ruangan_id' => $ruangan_id, 'pasienadmisi_id' => $pasienAdmisi[$i]));
//                    echo print_r($model->attributes);
//                    exit();
                }
                $tr .= '<tr>
                        <td>'
//                            .CHtml::activeHiddenField($modDetail, '[]ruangan_id',array('value'=>$model->ruangan_id))
                            .CHtml::checkBox('PesanmenudetailT[][checkList]',true, array('class'=>'cekList','onclick'=>'hitungSemua()'))
                            .CHtml::activeHiddenField($modDetail, '[]pendaftaran_id', array('value'=>$model->pendaftaran_id))
                            .CHtml::activeHiddenField($modDetail, '[]pasien_id', array('value'=>$model->pasien_id))
                            .CHtml::activeHiddenField($modDetail, '[]pasienadmisi_id', array('value'=>$model->pasienadmisi_id))
                        .'</td>
                        <td>'.RuanganM::model()->with('instalasi')->findByPk($ruangan_id)->instalasi->instalasi_nama.'</td>
                        <td>'.$model->ruangan_nama.'/<br/>'.$model->no_pendaftaran.'</td>
                        <td>'.$model->no_rekam_medik.'/<br/>'.$model->nama_pasien.'</td>
                        <td>'.$model->umur.'</td>
                        <td>'.$model->jeniskelamin.'</td>';
                foreach ($modJenisWaktu as $v){
                    if (in_array($v->jeniswaktu_id, $jeniswaktu)){
                        $tr .='<td>'.CHtml::hiddenField('PesanmenudetailT[][jeniswaktu_id]['.$v->jeniswaktu_id.']', $v->jeniswaktu_id )
                       .CHtml::dropDownList('PesanmenudetailT[][menudiet_id]['.$v->jeniswaktu_id.']', '', Chtml::listData(MenuDietM::model()->findAll(), 'menudiet_id', 'menudiet_nama'), array('empty'=>'-- Pilih --', 'class'=>'span2 menudiet', 'options'=>array("$menudiet_id"=>array("selected"=>"selected")))).'</td>';
                    }else{
                        $tr .='<td>'.CHtml::hiddenField('PesanmenudetailT[][jeniswaktu_id]['.$v->jeniswaktu_id.']', $v->jeniswaktu_id )
                       .CHtml::dropDownList('PesanmenudetailT[][menudiet_id]['.$v->jeniswaktu_id.']', '', Chtml::listData(MenuDietM::model()->findAll(), 'menudiet_id', 'menudiet_nama'), array('empty'=>'-- Pilih --', 'class'=>'span2 menudiet', )).'</td>';
                    }
                }
                 $tr .='<td>'.CHtml::activeTextField($modDetail, '[]jml_pesan_porsi', array('value'=>$jumlah, 'class'=>' span1 numbersOnly')).'</td>
                        <td>'.CHtml::activeDropDownList($modDetail, '[]satuanjml_urt', LookupM::getItems('ukuranrumahtangga'), array('empty'=>'-- Pilih --', 'class'=>'span2 urt', 'options'=>array("$urt"=>array("selected"=>"selected")))).'</td>
                        </tr>';
            }
            
            echo json_encode($tr);
            Yii::app()->end();
        }
    }
    
    public function actionGetMenuDietDetailKirim(){
        if (Yii::app()->request->isAjaxRequest){
            $pasien_id = $_POST['pasien_id'];
            $pendaftaran_id = $_POST['pendaftaran_id'];
            $pasienadmisi_id = $_POST['pasienadmisi_id'];
            $idMenuDiet = $_POST['idMenuDiet'];
            $idRuangan = $_POST['idRuangan'];
            $idInstalasi = $_POST['idInstalasi'];
            $idDaftarTindakan = $_POST['idDaftarTindakan'];
            $idKelasPelayanan = $_POST['idKelasPelayanan'];
//            $satuanTarif = $_POST['satuanTarif'];
            $urt = $_POST['urt'];
            $jumlah = $_POST['jumlah'];
            $jeniswaktu = $_POST['jeniswaktu'];
            $pendaftaranId = $_POST['pendaftaranId'];
            $pasienAdmisi = $_POST['pasienAdmisi'];
            $modDetail = new PesanmenudetailT();
            $modJenisWaktu = JeniswaktuM::model()->findAll('jeniswaktu_aktif = true');
            $diet = MenuDietM::model()->findByPK($idMenuDiet);
            $pendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
            $tarifTindakan = TariftindakanM::model()->findAllByAttributes(array('daftartindakan_id'=>$idDaftarTindakan,'kelaspelayanan_id'=>$idKelasPelayanan,'komponentarif_id'=>Params::KOMPONENTARIF_ID_TOTAL));
              foreach($tarifTindakan as $key=>$tarif){
                  if(count((array)$tarif) > 0){
                      $satuanTarif = $tarif->harga_tariftindakan;
                  }else{
                      $tarifTindakan = TariftindakanM::model()->findAllByAttributes(array('daftartindakan_id'=>$idDaftarTindakan,'kelaspelayanan_id'=>Params::KELASPELAYANAN_ID_TANPA_KELAS,'komponentarif_id'=>Params::KOMPONENTARIF_ID_TOTAL));
                      foreach($tarifTindakan as $key=>$tarif){
                          if(count((array)$tarif) > 0){
                              $satuanTarif = $tarif->harga_tariftindakan;
                          }else{
                              $satuanTarif = 0;
                          }
                      }
                  }

              }
              
            $jumlahPasien = count((array)$pasienAdmisi);
            if ($jumlahPasien == 0){
                $jumlahPasien = 1;
            }
            for($i = 0; $i < $jumlahPasien; $i++) {
            $modDetail = new PesanmenudetailT();
//            echo $pasienAdmisi;exit;
                if (!empty($pasienadmisi_id)) {
                    $model = InfokunjunganriV::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id, 'ruangan_id' => $idRuangan, 'pasienadmisi_id' => $pasienadmisi_id));
                    $modPendaftaran = PendaftaranT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id, 'ruangan_id' => $idRuangan, 'pasienadmisi_id' => $pasienadmisi_id));
                } else {
                    $model = InfokunjunganriV::model()->findByAttributes(array('pendaftaran_id' => $pendaftaranId[$i]));
                    $modPendaftaran = PendaftaranT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaranId[$i]));
                }
                $tr .= '<tr>
                        <td>'  //  .CHtml::activeHiddenField($modDetail, '[]ruangan_id',array('value'=>$model->ruangan_id))
                            .CHtml::checkBox('PesanmenudetailT[][checkList]',true, array('class'=>'cekList','onclick'=>'hitungSemua()'))
                            .CHtml::activeHiddenField($modDetail, '[]pendaftaran_id', array('value'=>$model->pendaftaran_id))
                            .CHtml::activeHiddenField($modDetail, '[]pasien_id', array('value'=>$model->pasien_id))
                            .CHtml::activeHiddenField($modDetail, '[]pasienadmisi_id', array('value'=>$model->pasienadmisi_id))
                        .'</td>
                        <td>'.RuanganM::model()->with('instalasi')->findByPk($idRuangan)->instalasi->instalasi_nama.'</td>
                        <td>'.$model->ruangan_nama.'/<br/>'.$model->no_pendaftaran.'</td>
                        <td>'.$model->no_rekam_medik.'/<br/>'.$model->nama_pasien.'</td>
                        <td>'.$model->umur.'</td>
                        <td>'.$model->jeniskelamin.'</td>';
                foreach ($modJenisWaktu as $v){
                    if (in_array($v->jeniswaktu_id, $jeniswaktu)){
                        $tr .='<td>'.CHtml::hiddenField('PesanmenudetailT[][jeniswaktu_id]['.$v->jeniswaktu_id.']', $v->jeniswaktu_id )
                       .CHtml::hiddenField('PesanmenudetailT[][daftartindakan_id]['.$v->jeniswaktu_id.']', $idDaftarTindakan)                                
                            .CHtml::hiddenField('PesanmenudetailT[][carabayar_id]['.$v->jeniswaktu_id.']', $model->carabayar_id)
                        .CHtml::hiddenField('PesanmenudetailT[][penjamin_id]['.$v->jeniswaktu_id.']', $model->penjamin_id)
                       .CHtml::hiddenField('PesanmenudetailT[][kelaspelayanan_id]['.$v->jeniswaktu_id.']', $idKelasPelayanan)
                       .CHtml::hiddenField('PesanmenudetailT[][jeniskasuspenyakit_id]['.$v->jeniswaktu_id.']', $model->jeniskasuspenyakit_id)
                       .CHtml::textField('PesanmenudetailT[][satuanTarif]['.$v->jeniswaktu_id.']', $satuanTarif,array('class'=>'span2'))
                       .CHtml::dropDownList('PesanmenudetailT[][menudiet_id]['.$v->jeniswaktu_id.']', '', Chtml::listData(MenuDietM::model()->findAll(), 'menudiet_id', 'menudiet_nama'), array('empty'=>'-- Pilih --', 'class'=>'span2 menudiet', 'options'=>array("$idMenuDiet"=>array("selected"=>"selected")))).'</td>';
                    }else{
                        $tr .='<td>'.CHtml::hiddenField('PesanmenudetailT[][jeniswaktu_id]['.$v->jeniswaktu_id.']', $v->jeniswaktu_id )
                        .CHtml::hiddenField('PesanmenudetailT[][carabayar_id]['.$v->jeniswaktu_id.']', $model->carabayar_id)
                        .CHtml::hiddenField('PesanmenudetailT[][penjamin_id]['.$v->jeniswaktu_id.']', $model->penjamin_id)
                       .CHtml::hiddenField('PesanmenudetailT[][daftartindakan_id]['.$v->jeniswaktu_id.']', $idDaftarTindakan)
                        .CHtml::hiddenField('PesanmenudetailT[][kelaspelayanan_id]['.$v->jeniswaktu_id.']', $idKelasPelayanan)
                        .CHtml::hiddenField('PesanmenudetailT[][jeniskasuspenyakit_id]['.$v->jeniswaktu_id.']', $model->jeniskasuspenyakit_id)
                        .CHtml::textField('PesanmenudetailT[][satuanTarif]['.$v->jeniswaktu_id.']', $satuanTarif,array('class'=>'span2','style'=>'width:60px;'))
                       .CHtml::dropDownList('PesanmenudetailT[][menudiet_id]['.$v->jeniswaktu_id.']', '', Chtml::listData(MenuDietM::model()->findAll(), 'menudiet_id', 'menudiet_nama'), array('empty'=>'-- Pilih --', 'class'=>'span2 menudiet', )).'</td>';
                    }
                }
                 $tr .='<td>'.CHtml::activeTextField($modDetail, '[]jml_kirim', array('value'=>$jumlah, 'class'=>' span1 numbersOnly')).'</td>
                        <td>'.CHtml::activeDropDownList($modDetail, '[]satuanjml_urt', LookupM::getItems('ukuranrumahtangga'), array('empty'=>'-- Pilih --','style'=>'width:80px;',  'class'=>'span2 urt', 'options'=>array("$urt"=>array("selected"=>"selected")))).'</td>
                        <td>'.CHtml::activeDropDownList($modDetail, '[]status_menu', LookupM::getItems('statusmakanan'), array('empty'=>'-- Pilih --','style'=>'width:80px;', 'class'=>'span2 urt', 'options'=>array("SASET"=>array("selected"=>"selected")))).'</td>
                        </tr>';
            }
            
            echo json_encode($tr);
            Yii::app()->end();
        }
    }
    
    public function actionGetMenuDietDetailDariKirim(){
        if (Yii::app()->request->isAjaxRequest){
            $pendaftaran_id = $_POST['pendaftaran_id'];
            $pasienadmisi_id = $_POST['pasienadmisi_id'];
            $idMenuDiet = $_POST['idMenuDiet'];
            $idRuangan = $_POST['idRuangan'];
            $idInstalasi = $_POST['idInstalasi'];
            $urt = $_POST['urt'];
            $jumlah = $_POST['jumlah'];
            $jeniswaktu = $_POST['jeniswaktu'];
            $pendaftaranId = $_POST['pendaftaranId'];
            $pasienAdmisi = $_POST['pasienAdmisi'];
            $butuh = $_POST['butuh'];
            $total = $_POST['total'];
            if (isset($butuh)){
                if(in_array($idMenuDiet, $butuh)){
                    foreach ($butuh as $i=>$dataRow){
                        if($dataRow == $idMenuDiet){
                            $total = $total[$i];
                        }
                    }
                }
                else{
                    $total = 0;
                }
            }
            else{
                $total = 0;
            }
            $modJenisWaktu = JeniswaktuM::model()->findAll('jeniswaktu_aktif = true');
            $jumlahPasien = count((array)$pasienAdmisi);
            if ($jumlahPasien == 0){
                $jumlahPasien = 1;
            }
            $hasil = true;
            if (Yii::app()->user->getState('krngistokgizi') == true){
                $bahanMenu = BahanMenuDietM::model()->findAllByAttributes(array('menudiet_id'=>$idMenuDiet));    
                $kelipatan = count(JeniswaktuM::getJenisWaktu());
                if (count((array)$bahanMenu) > 0){
                    foreach ($bahanMenu as $v){
                        if ($total !=0){
                            $jumlahButuh = $kelipatan*$v->jmlbahan*($jumlah+($total/$kelipatan))*$jumlahPasien;
                        }
                        else{
                            $jumlahButuh = $kelipatan*$v->jmlbahan*$jumlah*$jumlahPasien;
                        }
                        
                        if (StokbahanmakananT::validasiStok($jumlahButuh, $v->bahanmakanan_id) == false){
                            $hasil = false;
                        }
                    }
                }
                else{
                    $hasil = false;
                }
            }
            
            if ($hasil == true){
                for($i = 0; $i < $jumlahPasien; $i++) {
                    $modDetail = new KirimmenupasienT;
                    if (empty($pasienAdmisi)) {
                        $model = InfokunjunganriV::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id, 'ruangan_id' => $idRuangan, 'pasienadmisi_id' => $pasienadmisi_id));
                    } else {
                        $model = InfokunjunganriV::model()->findByAttributes(array('pendaftaran_id' => $pendaftaranId[$i], 'ruangan_id' => $idRuangan, 'pasienadmisi_id' => $pasienAdmisi[$i]));
                    }
                    $tr .= '<tr>
                                <td>'
                            . CHtml::checkBox('KirimmenupasienT[][checkList]', true, array('class' => 'cekList', 'onclick' => 'hitungSemua()'))
                            . CHtml::activeHiddenField($modDetail, '[]ruangan_id', array('value' => $model->ruangan_id))
                            . CHtml::activeHiddenField($modDetail, '[]pendaftaran_id', array('value' => $model->pendaftaran_id))
                            . CHtml::activeHiddenField($modDetail, '[]pasien_id', array('value' => $model->pasien_id))
                            . CHtml::activeHiddenField($modDetail, '[]pasienadmisi_id', array('value' => $model->pasienadmisi_id))
                            . '</td>
                                <td>' . RuanganM::model()->with('instalasi')->findByPk($idRuangan)->instalasi->instalasi_nama . '/
                                <br/>' . $model->ruangan_nama . '</td>
                                <td>' . $model->no_pendaftaran . '/
                                <br/>' . $model->no_rekam_medik . '</td>
                                <td>' . $model->nama_pasien . '</td>
                                <td>' . $model->umur . '</td>
                                <td>' . $model->jeniskelamin . '</td>';
                    foreach ($modJenisWaktu as $v) {
                        if (in_array($v->jeniswaktu_id, $jeniswaktu)) {
                            $tr .='<td>' . CHtml::hiddenField('KirimmenupasienT[][jeniswaktu_id][' . $v->jeniswaktu_id . ']', $v->jeniswaktu_id)
                                    . CHtml::dropDownList('KirimmenupasienT[][menudiet_id][' . $v->jeniswaktu_id . ']', '', Chtml::listData(MenuDietM::model()->findAll(), 'menudiet_id', 'menudiet_nama'), array('onchange'=>'cekStokMenu(this)','empty' => '-- Pilih --', 'class' => 'span2 menudiet', 'options' => array("$idMenuDiet" => array("selected" => "selected")))) . '</td>';
                        } else {
                            $tr .='<td>' . CHtml::hiddenField('KirimmenupasienT[][jeniswaktu_id][' . $v->jeniswaktu_id . ']', $v->jeniswaktu_id)
                                    . CHtml::dropDownList('KirimmenupasienT[][menudiet_id][' . $v->jeniswaktu_id . ']', '', Chtml::listData(MenuDietM::model()->findAll(), 'menudiet_id', 'menudiet_nama'), array('onchange'=>'cekStokMenu(this)','empty' => '-- Pilih --', 'class' => 'span2 menudiet',)) . '</td>';
                        }
                    }
                    $tr .='<td>' . CHtml::activeTextField($modDetail, '[]jml_kirim', array('value' => $jumlah, 'class' => ' span1 numbersOnly jmlKirim', 'onblur'=>'cekStokMenuInput(this)')) . '</td>
                                <td>' . CHtml::activeDropDownList($modDetail, '[]satuanjml_urt', LookupM::getItems('ukuranrumahtangga'), array('empty' => '-- Pilih --', 'class' => 'span2 urt', 'options' => array("$urt" => array("selected" => "selected")))) . '</td>
                                </tr>';
                }
            }
            
            echo json_encode($tr);
            Yii::app()->end();
        }
    }
    
    public function actionGetMenuDietPegawai(){
        if (Yii::app()->request->isAjaxRequest){
            $pegawai_id = (isset($_POST['idPegawai']) ? $_POST['idPegawai'] : null);
            $menudiet_id = (isset($_POST['idMenuDiet']) ? $_POST['idMenuDiet'] : null);
            $ruangan_id = (isset($_POST['idRuangan']) ? $_POST['idRuangan'] : null);
            $instalasi_id = (isset($_POST['idInstalasi']) ? $_POST['idInstalasi'] : null);
            
            $urt = $_POST['urt'];
            $jumlah = $_POST['jumlah'];
            $jeniswaktu = $_POST['jeniswaktu'];
            $modDetail = new PesanmenupegawaiT();
            $pegawaiId = (isset($_POST['pegawaiId']) ? $_POST['pegawaiId'] : null);
            
            $jumlahPesan = count((array)$pegawaiId);
            if ($jumlahPesan < 1) {
                $pegawaiId = array($pegawai_id);
            }
            $tr = '';
            foreach ($pegawaiId as $pegawai_id) {
                $modDetail = new PesanmenupegawaiT();
                $model = PegawaiM::model()->findByPk($pegawai_id);
                $nama = $model->nama_pegawai;
                $jeniskelamin = $model->jeniskelamin;
                $tr .= '<tr>
                        <td>'
                        . CHtml::checkBox('PesanmenupegawaiT[][' . $ruangan_id . '][checkList]', true, array('class' => 'cekList', 'onclick' => 'hitungSemua()'))
                        . CHtml::activeHiddenField($modDetail, '[][' . $ruangan_id . ']pegawai_id', array('value' => $model->pegawai_id))
                        . CHtml::hiddenField('PesanmenupegawaiT[][' . $ruangan_id . '][ruangan_id]', $ruangan_id)
                        . '</td>
                        <td>' . RuanganM::model()->with('instalasi')->findByPk($ruangan_id)->instalasi->instalasi_nama . '/<br/>' . RuanganM::model()->findByPk($ruangan_id)->ruangan_nama . '</td>
                        <td>' . CHtml::textField('nama', $nama, array('readonly' => true, 'class' => 'span2 nama')) . '</td>
                        <td>' . $jeniskelamin . '</td>';
                foreach (JeniswaktuM::getJenisWaktu() as $v) {
                    if (in_array($v->jeniswaktu_id, $jeniswaktu)) {
                        $tr .='<td>' . CHtml::hiddenField('PesanmenupegawaiT[][' . $ruangan_id . '][jeniswaktu_id][' . $v->jeniswaktu_id . ']', $v->jeniswaktu_id)
                                . CHtml::dropDownList('PesanmenupegawaiT[][' . $ruangan_id . '][menudiet_id][' . $v->jeniswaktu_id . ']', '', Chtml::listData(MenuDietM::model()->findAll(), 'menudiet_id', 'menudiet_nama'), array('empty' => '-- Pilih --', 'class' => 'span2 menudiet', 'options' => array("$menudiet_id" => array("selected" => "selected")))) . '</td>';
                    } else {
                        $tr .='<td>' . CHtml::hiddenField('PesanmenupegawaiT[][' . $ruangan_id . '][jeniswaktu_id][' . $v->jeniswaktu_id . ']', $v->jeniswaktu_id)
                                . CHtml::dropDownList('PesanmenupegawaiT[][' . $ruangan_id . '][menudiet_id][' . $v->jeniswaktu_id . ']', '', Chtml::listData(MenuDietM::model()->findAll(), 'menudiet_id', 'menudiet_nama'), array('empty' => '-- Pilih --', 'class' => 'span2 menudiet',)) . '</td>';
                    }
                }
                $tr .= '<td>' . CHtml::activeTextField($modDetail, '[][' . $ruangan_id . ']jml_pesan_porsi', array('value' => $jumlah, 'class' => ' span1 numbersOnly',)) . '</td>
                        <td>' . CHtml::activeDropDownList($modDetail, '[][' . $ruangan_id . ']satuanjml_urt', LookupM::getItems('ukuranrumahtangga'), array('empty' => '-- Pilih --', 'class' => 'span2 urt', 'options' => array("$urt" => array("selected" => "selected")))) . '</td>
                        </tr>';
            }
            echo json_encode($tr);
            Yii::app()->end();
        }
    }
    
    public function actionGetMenuDietPegawaiDariKirim(){
        if (Yii::app()->request->isAjaxRequest){
            $idPegawai = $_POST['idPegawai'];
            $idMenuDiet = $_POST['idMenuDiet'];
            $idRuangan = $_POST['idRuangan'];
            $idInstalasi = $_POST['idInstalasi'];
            $urt = $_POST['urt'];
            $jumlah = $_POST['jumlah'];
            $jeniswaktu = $_POST['jeniswaktu'];
            $modDetail = new PesanmenupegawaiT();
            $pegawaiId = $_POST['pegawaiId'];
            $butuh = $_POST['butuh'];
            $total = $_POST['total'];
            if (isset($butuh)){
                if(in_array($idMenuDiet, $butuh)){
                    foreach ($butuh as $i=>$dataRow){
                        if($dataRow == $idMenuDiet){
                            $total = $total[$i];
                        }
                    }
                }
                else{
                    $total = 0;
                }
            }
            else{
                $total = 0;
            }
            $hasil = true;
            $jumlahPesan = count((array)$pegawaiId);
            if (Yii::app()->user->getState('krngistokgizi') == true){
                $bahanMenu = BahanMenuDietM::model()->findAllByAttributes(array('menudiet_id'=>$idMenuDiet));
                $kelipatan = count(JeniswaktuM::getJenisWaktu());
                foreach ($bahanMenu as $v){
                    $jumlahPesanPegawai = $jumlahPesan;
                    if ($jumlahPesan < 0) {
                        $jumlahPesanPegawai = 1;
                    }
                    if ($total !=0){
                        $jumlahButuh = $kelipatan*$v->jmlbahan*($jumlah+($total/$kelipatan))*$jumlahPesanPegawai;
                    }
                    else{
                        $jumlahButuh = $kelipatan*$v->jmlbahan*$jumlah*$jumlahPesanPegawai;
                    }
                    
                    if (StokbahanmakananT::validasiStok($jumlahButuh, $v->bahanmakanan_id) == false){
                        $hasil = false;
                    }
                }
            }
            
            if ($hasil == true){
                if ($jumlahPesan < 1) {
                    $pegawaiId = array($idPegawai);
                }

                foreach ($pegawaiId as $idPegawai) {
                    $modDetail = new KirimmenupegawaiT();
                    $model = PegawaiM::model()->findByPk($idPegawai);
                    $nama = $model->nama_pegawai;
                    $jeniskelamin = $model->jeniskelamin;
                    $tr .= '<tr>
                            <td>'
                            . CHtml::checkBox('KirimmenupegawaiT[][checkList]', true, array('class' => 'cekList', 'onclick' => 'hitungSemua()'))
                            . CHtml::activeHiddenField($modDetail, '[]pegawai_id', array('value' => $model->pegawai_id))
                            . CHtml::hiddenField('KirimmenupegawaiT[][ruangan_id]', $idRuangan)
                            . '</td>
                            <td>' . RuanganM::model()->with('instalasi')->findByPk($idRuangan)->instalasi->instalasi_nama . '/<br/>' . RuanganM::model()->findByPk($idRuangan)->ruangan_nama . '</td>
                            <td>' . CHtml::textField('nama', $nama, array('readonly' => true, 'class' => 'span2 nama')) . '</td>
                            <td>' . $jeniskelamin . '</td>';
                    foreach (JeniswaktuM::getJenisWaktu() as $v) {
                        if (in_array($v->jeniswaktu_id, $jeniswaktu)) {
                            $tr .='<td>' . CHtml::hiddenField('KirimmenupegawaiT[][jeniswaktu_id][' . $v->jeniswaktu_id . ']', $v->jeniswaktu_id)
                                    . CHtml::dropDownList('KirimmenupegawaiT[][menudiet_id][' . $v->jeniswaktu_id . ']', '', Chtml::listData(MenuDietM::model()->findAll(), 'menudiet_id', 'menudiet_nama'), array('onchange'=>'cekStokMenu(this)', 'empty' => '-- Pilih --', 'class' => 'span2 menudiet', 'options' => array("$idMenuDiet" => array("selected" => "selected")))) . '</td>';
                        } else {
                            $tr .='<td>' . CHtml::hiddenField('KirimmenupegawaiT[][jeniswaktu_id][' . $v->jeniswaktu_id . ']', $v->jeniswaktu_id)
                                    . CHtml::dropDownList('KirimmenupegawaiT[][menudiet_id][' . $v->jeniswaktu_id . ']', '', Chtml::listData(MenuDietM::model()->findAll(), 'menudiet_id', 'menudiet_nama'), array('onchange'=>'cekStokMenu(this)', 'empty' => '-- Pilih --', 'class' => 'span2 menudiet',)) . '</td>';
                        }
                    }
                    $tr .= '<td>' . CHtml::activeTextField($modDetail, '[]jml_kirim', array('value' => $jumlah, 'class' => ' span1 numbersOnly jmlKirim', 'onblur'=>'cekStokMenuInput(this)')) . '</td>
                            <td>' . CHtml::activeDropDownList($modDetail, '[]satuanjml_urt', LookupM::getItems('ukuranrumahtangga'), array('empty' => '-- Pilih --', 'class' => 'span2 urt', 'options' => array("$urt" => array("selected" => "selected")))) . '</td>
                            </tr>';
                }
            }
            
            echo json_encode($tr);
            Yii::app()->end();
        }
    }
    
    public function actionGetBahanMenuDiet()
    {
       if(Yii::app()->request->isAjaxRequest)
           { 
                $menudiet_id=$_POST['menudiet_id'];
                $bahanmakanan_id = $_POST['bahanmakanan_id'];
                $jmlbahan = $_POST['jmlbahan'];
                $satuan = $_POST['satuan'];
                $modBahanMenuDiet = new BahanMenuDietM;
                $modMenuDiet = MenuDietM::model()->findByPk($menudiet_id);
                $modBahanMakanan=BahanmakananM::model()->findByPK($bahanmakanan_id);
                $return = array();
                    $tr .="<tr><td>";
                    $tr .= CHtml::checkBox('checkList[]',true,array('class'=>'cekList', 'onkeypress'=>"return $(this).focusNextInputField(event);"));
                    $tr .= "</td><td>";
                    $tr .= $modMenuDiet->menudiet_nama;
                    $tr .= CHtml::hiddenField('menudiet_id[]',$modMenuDiet->menudiet_id);
                    $tr .= CHtml::hiddenField('bahanmakanan_id[]',$modBahanMakanan->bahanmakanan_id);
                    $tr .= "</td><td>";
                    $tr .= $modBahanMakanan->namabahanmakanan;
                    $tr .= "</td><td>";
                    $tr .= CHtml::textField('jmlbahan[]',$jmlbahan, array('onkeypress'=>"return $(this).focusNextInputField(event);"));
                    $tr .="</td><td>";
                    $tr .= $satuan;
                    $tr .="</td>";
                    $tr .= "</tr>";   
                $return .= $tr;
               $data['return']=$return;
               echo json_encode($data);
             Yii::app()->end();
        }    
    } 
    
    public function actionGetStokBahanMakanan(){
        if (Yii::app()->request->isAjaxRequest){
            $value = $_POST['value'];
            $total = $_POST['total'];
            $hasil = true;
            if (Yii::app()->user->getState('krngistokgizi') == true){
                if (isset($value)){
                    $bahanMenu = BahanMenuDietM::model()->findAllByAttributes(array('menudiet_id'=>$value));    
                    $kelipatan = $total;
                    if (count((array)$bahanMenu) > 0){
                        foreach ($bahanMenu as $v){
                            $jumlahButuh = $kelipatan*$v->jmlbahan;
                            if (StokbahanmakananT::validasiStok($jumlahButuh, $v->bahanmakanan_id) == false){
                                $hasil = false;
                            }
                        }
                    }
                    else{
                        $hasil = false;
                    }
                }
            }
            echo $hasil;
            Yii::app()->end();
        }
    }
    
    public function actionGetStokBahanMakananInput(){
        if (Yii::app()->request->isAjaxRequest){
            $total = $_POST['total'];
            $butuh = $_POST['butuh'];
            $hasil = true;
            if (Yii::app()->user->getState('krngistokgizi') == true){
                if (isset($butuh)){
                    foreach ($butuh as $i=>$dataRow){
                        $total = $total[$i];
                        if (StokbahanmakananT::validasiStokMenu($total, $dataRow) == false){
                            $hasil =false;
                        }
                    }
                }
            }

            echo $hasil;
            Yii::app()->end();
        }
    }

	public function actionKelasruangan()
    {
        if(Yii::app()->request->isAjaxRequest) { 
            $instalasi_id = $_POST['instalasi_id'];
            $ruanganid = $_POST['ruanganid'];
            $kelaspelayanan_id = $_POST['kelaspelayanan_id'];
            
            $modinstalasi = InstalasiM::model()->findByPK($instalasi_id);
            $modruangan = RuanganM::model()->findByPK($ruanganid);
            $modkelaspelayanan = KelaspelayananM::model()->findByPK($kelaspelayanan_id);
            
            $modkelasruangan = new KelasruanganM;
                $tr = "<tr>";
                $tr .= "<td>"
                            .$modinstalasi->instalasi_nama
                            .CHtml::hiddenField('ruangan_id['.$kelaspelayanan_id.']',$ruanganid,array('readonly'=>true))
                            .CHtml::hiddenField('kelaspelayanan_id[]',$kelaspelayanan_id,array('readonly'=>true))
                            ."</td>";
                $tr .= "<td>".$modruangan->ruangan_nama."</td>";
                $tr .= "<td>".$modkelaspelayanan->kelaspelayanan_nama."</td>";
                $tr .= "<td>".$modkelaspelayanan->kelaspelayanan_namalainnya."</td>";
                $tr .= "<td>".CHtml::link("<i class='icon-remove'></i>", '#', array('onclick'=>'hapusBaris(this); return false;'))."</td>";
                $tr .= "</tr>";

           $data['tr']=$tr;
           echo json_encode($data);
         Yii::app()->end();
        }
    }
    public function actionTindakanruangan()
    {
        if(Yii::app()->request->isAjaxRequest) { 
            $instalasi_id = $_POST['instalasi_id'];
            $ruanganid = $_POST['ruanganid'];
            $daftartindakan_id = $_POST['daftartindakan_id'];
            
            $modinstalasi = InstalasiM::model()->findByPK($instalasi_id);
            $modruangan = RuanganM::model()->findByPK($ruanganid);
            $moddaftartindakan = DaftartindakanM::model()->findByPK($daftartindakan_id);
            
            $modtindakanruangan = TindakanruanganM::model()->findByAttributes(array('ruangan_id'=>$ruanganid, 'daftartindakan_id' =>$daftartindakan_id));
//            if (count((array)$modtindakanruangan) < 1){
            
                $tr = "<tr>";
                $tr .= "<td>"
                            .$modinstalasi->instalasi_nama
                            .CHtml::hiddenField('Tindakanruangan['.$daftartindakan_id.'][ruangan_id]',$ruanganid,array('readonly'=>true))
                            .CHtml::hiddenField('Tindakanruangan['.$daftartindakan_id.'][daftartindakan_id]',$daftartindakan_id,array('readonly'=>true))
                            ."</td>";
                $tr .= "<td>".$modruangan->ruangan_nama."</td>";
                $tr .= "<td>".$moddaftartindakan->daftartindakan_nama."</td>";
                $tr .= "<td>".CHtml::link("<i class='icon-remove'></i>", '#', array('onclick'=>'hapusBaris(this);'))."</td>";
                $tr .= "</tr>";
//            }
           $data['tr']=$tr;
           echo json_encode($data);
         Yii::app()->end();
        }
    }
    
    public function actionRuanganpegawai()
    {
        if(Yii::app()->request->isAjaxRequest) { 
            $instalasi_id = $_POST['instalasi_id'];
            $ruanganid = $_POST['ruanganid'];
            $pegawai_id = $_POST['pegawai_id'];
            
            $modinstalasi = InstalasiM::model()->findByPK($instalasi_id);
            $modruangan = RuanganM::model()->findByPK($ruanganid);
            $modpegawai = PegawaiM::model()->findByPK($pegawai_id);
            
            $modkelasruangan = new KelasruanganM;
                $tr = "<tr>";
                $tr .= "<td>"
                            .$modinstalasi->instalasi_nama
                            .CHtml::hiddenField('ruangan_id[]',$ruanganid,array('readonly'=>true))
                            .CHtml::hiddenField('pegawai_id[]',$pegawai_id,array('readonly'=>true))
                            ."</td>";
                $tr .= "<td>".$modruangan->ruangan_nama."</td>";
                $tr .= "<td>".$modruangan->ruangan_namalainnya."</td>";
                $tr .= "<td>".$modpegawai->NamaLengkap."</td>";
                $tr .= "<td>".CHtml::link("<i class='icon-remove'></i>", '#', array('onclick'=>'hapusBaris(this); return false;'))."</td>";
                $tr .= "</tr>";

           $data['tr']=$tr;
           echo json_encode($data);
         Yii::app()->end();
        }
    }
    
    public function actionKasuspenyakitdiagnosa()
    {
        if(Yii::app()->request->isAjaxRequest) { 
            $diagnosa_id = $_POST['diagnosa_id'];
            $obatakes_id = $_POST['obatalkes_id'];
            
            $moddiagnosa = DiagnosaM::model()->findByPK($diagnosa_id);
            $modobatalkes = ObatalkesM::model()->findByPK($obatakes_id);
            $model = new DiagnosaobatM;
                $tr = "<tr>";
                $tr .= "<td>"
                            .$moddiagnosa->diagnosa_kode
                            .CHtml::activehiddenField($model,'[]diagnosa_id',array('readonly'=>true,'value'=>$diagnosa_id,'class'=>'diagnosa'))
                            .CHtml::activehiddenField($model,'[]obatalkes_id',array('readonly'=>true,'value'=>$obatakes_id))
                            ."</td>";
                $tr .= "<td>".$moddiagnosa->diagnosa_nama."</td>";
                $tr .= "<td>".$modobatalkes->obatalkes_nama."</td>";
                $tr .= "<td>".CHtml::link("<i class='icon-remove'></i>", '#', array('onclick'=>'hapusBaris(this);'))."</td>";
                $tr .= "</tr>";

           $data['tr']=$tr;
           echo json_encode($data);
         Yii::app()->end();
        }
    }
    
    public function actionKasuspenyakitobatM()
    {
        if(Yii::app()->request->isAjaxRequest) { 
            $jeniskasuspenyakit_id = $_POST['jeniskasuspenyakit_id'];
            $obatalkes_id = $_POST['obatalkes_id'];
            
            $modjeniskasuspenyakit = JeniskasuspenyakitM::model()->findByPK($jeniskasuspenyakit_id);
            $modobatalkes = ObatalkesM::model()->findByPK($obatalkes_id);
            
            $modKasuspenyakitobat = new KasuspenyakitobatM;
                $tr = "<tr>";
                $tr .= "<td>"
                            .$modjeniskasuspenyakit->jeniskasuspenyakit_nama
                            .CHtml::activehiddenField($modKasuspenyakitobat,'[]jeniskasuspenyakit_id',array('readonly'=>true,'value'=>$jeniskasuspenyakit_id,'class'=>'jenispenyakit'))
                            .CHtml::activehiddenField($modKasuspenyakitobat,'[]obatalkes_id',array('readonly'=>true,'value'=>$obatalkes_id))
                            ."</td>";
                $tr .= "<td>".$modobatalkes->obatalkes_kode."</td>";
                $tr .= "<td>".$modobatalkes->obatalkes_nama."</td>";
                $tr .= "<td>".CHtml::link("<i class='icon-remove'></i>", '#', array('onclick'=>'hapusBaris(this);'))."</td>";
                $tr .= "</tr>";

           $data['tr']=$tr;
           echo json_encode($data);
         Yii::app()->end();
        }
    }
    //INI UNTUK APA ? KARNA HAK AKSES SUDAH DI ATUR DI SRBAC
    public function actionCekHakRetur()
    {
//        if(!Yii::app()->user->checkAccess('Retur')){
        if(!Yii::app()->user->checkAccess('Admin')){
            //throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));
            $data['cekAkses'] = false;
        } else {
            //echo 'punya hak akses';
            $data['cekAkses'] = true;
            $data['userid'] = Yii::app()->user->id;
            $data['username'] = Yii::app()->user->name;
        }

        echo CJSON::encode($data);
        Yii::app()->end();
    }

    public function actionCekHakBatalBayar()
    {
        if(!Yii::app()->user->checkAccess('BatalBayar')){
            //throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));
            // echo Yii::app()->user->checkAccess('BatalBayar');
            $data['cekAkses'] = true;
        } else {
            //echo 'punya hak akses';
            $data['cekAkses'] = true;
            $data['userid'] = Yii::app()->user->id;
            $data['username'] = Yii::app()->user->name;
        }

        echo CJSON::encode($data);
        Yii::app()->end();
    }
    /*
     * --modul Kepegawaian
     * mendapatkan detail pegawai dari nip yang diinputkan pada transaksi Penggajian
     */
    public function actionGetPegawaiFromNip(){
        if (Yii::app()->request->isAjaxRequest){
            $nip = $_POST['nip'];
            $criteria = new CDbCriteria();
            $criteria->compare('LOWER(nomorindukpegawai)', $nip);
            $criteria->with = array('jabatan','pangkat');
            $criteria->limit = 1;
            $model = PegawaiM::model()->find($criteria);
            $attributes = $model->attributeNames();
            
            foreach($attributes as $j=>$attribute) {
                $data->attributes["$attribute"] = $data->$attribute;
                $data->attributes["jabatan_nama"]=$data->jabatan->jabatan_nama;
                $data->attributes["pangkat_nama"]=$data->pangkat->jabatan_nama;
            }
            foreach($attributes as $j=>$attribute) {
                $returnVal["$attribute"] = $model->$attribute;
                $returnVal["jabatan_nama"]=$model->jabatan->jabatan_nama;
                $returnVal["pangkat_nama"]=$model->pangkat->jabatan_nama;
            }

            echo json_encode($returnVal);
            Yii::app()->end();
        }
    }
    /*
     * --modul Kepegawaian
     * mendapatakan detail pegawai dari nofingerprint yang diinputkan pada transaksi Presensi
     */
    public function actionGetPegawaiFromNoFinger(){
        if (Yii::app()->request->isAjaxRequest){
            $nofinger = $_POST['nofinger'];
            $criteria = new CDbCriteria();
            $criteria->compare('nofingerprint', $nofinger);
            $criteria->with = array('jabatan','pangkat');
            $criteria->limit = 1;
            $model = PegawaiM::model()->find($criteria);
            $attributes = $model->attributeNames();

            foreach($attributes as $j=>$attribute) {
                $returnVal["$attribute"] = $model->$attribute;
            }
            $returnVal["jabatan_nama"]=$model->jabatan->jabatan_nama;
            $returnVal["pangkat_nama"]=$model->pangkat->jabatan_nama;

            echo json_encode($returnVal);
            Yii::app()->end();
        }
    }
    
    public function actionmonitoringrawatjalanAutoRefresh(){
        if (Yii::app()->request->isAjaxRequest){
            $auto = $_POST['auto'];
            MonitoringrawatjalanV::model()->updateAll();
            Yii::app()->end();
        }
    }
     /*
     * --modul Remunerasi
     * mendapatakan detail Komponen Jasa dari  yang diinputkan pada transaksi Komponen Jasa
     */
     public function actionGetKomponenjasa()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $model = REKomponenjasaM::model()->findAllByAttributes(array('komponenjasa_id'=>$model->komponenjasa_id),array('order'=>'komponenjasa_id'));
            $i=1;
            foreach ($model as $row)
            {
                $urlDelete = Yii::app()->createUrl('Remunerasi/KomponenjasaM/deleteKomponenjasa',array('komponenjasa_id'=>$row->komponenjasa_id));
                $tr .= '<tr>';
                    $tr .= '<td>'.$i.' </td>';
                    $tr .= '<td>'.$row->kelompoktindakan->kelompoktindakan_nama.'</td>';
                    $tr .= '<td>'.$row->ruangan->ruangan_nama.'</td>';
                    $tr .= '<td>'.$row->komponenjasa_kode.'</td>';
                    $tr .= '<td>'.$row->komponenjasa_nama.'</td>';
                    $tr .= '<td>'.$row->komponenjasa_singkatan.' bulan</td>';
                    $tr .= '<td>'.$row->besaranjasa.'</td>';
                    $tr .= '<td>'.$row->potongan.'</td>';
                    $tr .= '<td>'.$row->jasadireksi.'</td>';
                    $tr .= '<td>'.$row->kuebesar.'</td>';
                    $tr .= '<td>'.$row->jasadokter.'</td>';
                    $tr .= '<td>'.$row->jasaparamedis.'</td>';
                    $tr .= '<td>'.$row->jasaunit.'</td>';
                    $tr .= '<td>'.$row->jasabalanceins.'</td>';
                    $tr .= '<td>'.$row->jasaemergency.'</td>';
                    $tr .= '<td>'.$row->biayaumum.'</td>';

                    $tr .= '<td>'.CHtml::link('<i class="icon-trash"></i>',$urlDelete,array('onclick'=>'return (!confirm("Anda yakin akan menghapus item ini ?")) ? false : true')).'</td>';
                $tr .= '</tr>';
                $i++;
            }
                
               $data['tr']=$tr;

               echo json_encode($data);
             Yii::app()->end();
        }
    }
    
    public function actionGetSupplierKode(){
        if (Yii::app()->request->isAjaxRequest){
            $kode = $_POST['supplier_kode'];
            $criteria = new CDbCriteria();
            $criteria->compare('supplier_kode', $kode);
            $criteria->limit = 1;
            $model = SupplierM::model()->find($criteria);
            $attributes = $model->attributeNames();

            foreach($attributes as $j=>$attribute) {
                $returnVal["$attribute"] = $model->$attribute;
            }

            echo json_encode($returnVal);
            Yii::app()->end();
        }
    }
    
     public function actionGetKodeBarangSupplier(){ 
        if (Yii::app()->request->isAjaxRequest){
            $kodebarang = $_POST['obatalkes_kode'];
            $criteria = new CDbCriteria();
            $criteria->compare('obatalkes_kode', $kodebarang);
            $criteria->limit = 1;
            $model = ObatalkesM::model()->find($criteria);
            $attributes = $model->attributeNames();

            foreach($attributes as $j=>$attribute) {
                $returnVal["$attribute"] = $model->$attribute;
            }

            echo json_encode($returnVal);
            Yii::app()->end();
        }
    }
    
    public function actionGetBarcodeBarangSupplier(){ 
        if (Yii::app()->request->isAjaxRequest){
            $barcodebarang = $_POST['obatalkes_barcode'];
            $criteria = new CDbCriteria();
            $criteria->compare('obatalkes_barcode', $barcodebarang);
            $criteria->limit = 1;
            $model = ObatalkesM::model()->find($criteria);
            $attributes = $model->attributeNames();

            foreach($attributes as $j=>$attribute) {
                $returnVal["$attribute"] = $model->$attribute;
            }

            echo json_encode($returnVal);
            Yii::app()->end();
        }
    }
     public function actionGetObatSupplier(){
        if (Yii::app()->request->isAjaxRequest){
            $idObat = $_POST['idObat'];
            $idSupplier = $_POST['idSupplier'];
            $modBarang = ObatalkesM::model()->findByPk($idObat);
         
            $modDetail = new ObatsupplierM();
            $modDetail->obatalkes_id = $idObat;
            $modDetail->supplier_id = $idSupplier;
            
            $tr = $this->renderPartial('_detailBarangSupplier', array('modBarang'=>$modBarang, 'modDetail'=>$modDetail), true);
            echo json_encode($tr);
            Yii::app()->end();
        }
    }
    

    public function actionGetStockBarangRetail(){
        if (Yii::app()->request->isAjaxRequest){
            $idBarang = $_POST['idBarang'];
            $qty = $_POST['qty'];
            $modBarang = ProdukposV::model()->findByAttributes(array('brg_id'=>$idBarang));
            $modObat = new ObatalkespasienT();
            $criteria = new CDBCriteria();
            $criteria->addCondition('obatalkes_id = '.$idBarang);
            $criteria->order = 'tglstok_in '.((Params::KONFIG_FIFO) ? "ASC" : "DESC");
            $modStok = StokobatalkesT::model()->find($criteria);
            $data["stok"] = StokobatalkesT::getJumlahStok($idBarang);
            $data["disc"] = $modBarang->discount;
            $data["sub"] = $modBarang->hargajual;
            $data["netto"] =$modBarang->harganetto;
            $modObat->obatalkes_id = $modBarang->brg_id;
            $modObat->qty_oa = $qty;
            $modObat->hargajual_oa = ((!empty($modBarang->hargajual)) ? $modBarang->hargajual : 0)*$qty;
            $modObat->harganetto_oa = ((!empty($modBarang->harganetto)) ? $modBarang->harganetto : 0)*$qty;
            $modObat->discount = $modBarang->discount*$modBarang->hargajual*$qty/100;
            $modObat->sumberdana_id = $modBarang->sumberdana_id;
            $modObat->biayaadministrasi = $modBarang->ppn_persen*$modBarang->hargajual*$qty/100;
            
            $tr['tr'] = $this->renderPartial('_detailStokBarangRetail', array('modBarang'=>$modBarang, 'modObat'=>$modObat, 'data'=>$data, 'modStok'=>$modStok), true);
            $tr['stok'] = $data["stok"];
            $tr['barang']['harga'] = $modObat->hargajual_oa;
            $tr['barang']['qty'] = $qty;
            $tr['barang']['nama'] = $modBarang->stock_name;
            $tr['barang']['minimal'] = (!empty($modBarang->minimalstok)) ? $modBarang->minimalstok : 0 ;
            echo json_encode($tr);
            Yii::app()->end();
        }
    }
    
    public function actionGetIdBarangStock(){
        if (Yii::app()->request->isAjaxRequest){
            $obj = $_POST['objName'];
            $value = $_POST['objValue'];
            $modBarang = ProdukposV::model()->findByAttributes(array($obj=>$value));
            
            echo json_encode($modBarang->attributes);
            Yii::app()->end();
        }
    }
    
    
    public function actionGetListSubKategori()
    {
        if(Yii::app()->getRequest()->getIsAjaxRequest()) {
            $data= SubjenisM::model()->findAllByAttributes(array('jenisobatalkes_id'=>$_POST['idJenis'],'subjenis_id'=>$_POST['idSub']),array('order'=>'subjenis_nama'));
            $data=CHtml::listData($data,'subjenis_id','subjenis_nama');

            foreach($data as $value=>$name)
            {
                if($value==$_POST['idSub'])
                    $SubkategoriOption .= CHtml::tag('option',array('value'=>$value,'selected'=>true),CHtml::encode($name),true);
                else
                    $SubkategoriOption .= CHtml::tag('option',array('value'=>$value),CHtml::encode($name),true);
            }

            $dataList['listKabupaten'] = $subkategoriOption;

            echo json_encode($dataList);
            Yii::app()->end();
        }
    }

//    public function actionGetObatalkesKode(){
//        if (Yii::app()->request->isAjaxRequest){
//            $kodeobatalkes = $_POST['obatalkes_kode'];
//            $criteria = new CDbCriteria();
//            $criteria->compare('obatalkes_kode', $kodeobatalkes);
//            $criteria->limit = 1;
//            $model = ObatalkesM::model()->find($criteria);
//            $attributes = $model->attributeNames();
//
//            foreach($attributes as $j=>$attribute) {
//                $returnVal["$attribute"] = $model->$attribute;
//            }
//
//            echo json_encode($returnVal);
//            Yii::app()->end();
//        }
//    }
    
     public function actionPemeriksaanhasil()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $pemeriksaanlab_id = $_POST['pemeriksaanlab_id'];
            $nilairujukan_id = $_POST['nilairujukan_id'];
            $dataNilairujukan = NilairujukanM::model()->findAllByAttributes(array('nilairujukan_id'=>$nilairujukan_id));
            $model = new PemeriksaanlabdetM;
            foreach ($dataNilairujukan as $modNilairujukan) {
                $tr = '<tr>';
                    $tr .=
                            '<td>'
                             .CHtml::activeTextField($model,'[]pemeriksaanlabdet_nourut',array('class'=>'span1'))
                             .CHtml::activeHiddenField($model,'[]nilairujukan_id',array('class'=>'span1','readonly'=>true,'value'=>$nilairujukan_id))
                             .'</td>';
                    $tr .= '<td>'.$modNilairujukan->kelompokdet.'</td>';
                    $tr .= '<td>'.$modNilairujukan->namapemeriksaandet.'</td>';
                    $tr .= '<td>'.$modNilairujukan->kelompokumur->kelkumurhasillabnama.'</td>';
                    $tr .= '<td>'.$modNilairujukan->nilairujukan_jeniskelamin.'</td>';
                    $tr .= '<td>'.$modNilairujukan->nilairujukan_metode.'</td>';
                    $tr .= '<td>'.CHtml::link('<i class="icon-remove"></i>','',array('id'=>'removebtn','style'=>'cursor:pointer;','class'=>'pemeriksaanlabdet','onclick'=>'hapusBaris(this); return false;')).'</td>';
                $tr .= '</tr>';
            }
            $data['tr'] = $tr;
            echo json_encode($data);
            Yii::app()->end();
        }
    }
    
        public function actionGetProdukpos() 
        {
                $model = REProdukposV;
                $criteria = new CDbCriteria;
                
                $criteria->compare('category_id',$_GET['category_id']);
                $criteria->compare('subcategory_id',$_GET['subcategory_id']);
                $criteria->compare('LOWER(stock_code)',strtolower($_GET['stock_code']),true);
                $criteria->compare('LOWER(stock_name)',strtolower($_GET['stock_name']),true);
                $criteria->compare('LOWER(barang_barcode)',strtolower($_GET['barang_barcode']),true);
                $criteria->compare('LOWER(price_name)',strtolower($_GET['price_name']),true);
                $criteria->order='brg_id asc';
                $criteria->order = $_GET['sidx'].' '.$_GET['sord'];
                
                $searchOn = $_REQUEST['_search'];
                $fld = $_REQUEST['searchField'];
                $fldata = $_REQUEST['searchString'];
                $foper = $_REQUEST['searchOper'];
                $criteria->condition = $wh;
                $dataProvider=new CActiveDataProvider('ProdukposV', array(
                    'criteria'=>$criteria,
                    'pagination'=>array(
                        'pageSize'=>$_GET['rows'],
                        'currentPage'=>$_GET['page']-1,
                    ),
                ));
        $responce->page = $_GET['page'];
        $responce->records = $dataProvider->getTotalItemCount();
        $responce->total = ceil($responce->records / $_GET['rows']);
        $rows = $dataProvider->getData();
        $no = 1;
        if ($_GET['page'] > 1) {
            $page = $_GET['page'] - 1;
            $no = $page.'1';
        }
        foreach ($rows as $i=>$row) 
        {
                $responce->rows[$i]['cell'] = array(//'',
                    $no,
                    $row->category_name
                    .' / '.$row->subcategory_name
                    .CHtml::hiddenField('REProdukposV['.$row->brg_id.'][brg_id]',$row->brg_id,array('readonly'=>true))
                    .CHtml::checkBox('REProdukposV['.$row->brg_id.'][cekList]',true,array('onclick'=>'setUrutan() getTotal()','class'=>'cekList','style'=>'display:none;')),
                    $row->stock_code.' / '.$row->barang_barcode, 
                    $row->stock_name,
                    CHtml::textField('REProdukposV['.$row->brg_id.'][hargajual]',$row->hargajual, array("id"=>"hargajual","class"=>"span1 hargajual numbersOnly margin", "onmouseover"=>"getTotal()", "onkeypress"=>"getTotal()")),
                    CHtml::textField('REProdukposV['.$row->brg_id.'][discount]',$row->discount, array("id"=>"discount","class"=>"span1 numbersOnly margin", "onmouseover"=>"getTotal()", "onkeypress"=>"getTotal()")),
                    CHtml::hiddenField('REProdukposV['.$row->brg_id.'][ppn]',$row->ppn_persen, array("id"=>"ppn","class"=>"span1 numbersOnly margin", "onmouseover"=>"getTotal()", "onkeypress"=>"getTotal()")).''.$row->ppn_persen,
                    CHtml::textField('REProdukposV['.$row->brg_id.'][harganetto]',$row->harganetto, array("id"=>"harganetto","class"=>"span1 numbersOnly margin", "onmouseover"=>"getTotal()", "onkeypress"=>"getTotal()")),
                    CHtml::hiddenField('REProdukposV['.$row->brg_id.'][ratarata]',$row->movingavarage, array("id"=>"hargaratarata","class"=>"span1 numbersOnly margin", "onmouseover"=>"getTotal()", "onkeypress"=>"getTotal()")).''.$row->movingavarage,
                    CHtml::textField('stok',StokobatalkesT::getJumlahStok($row->brg_id, Yii::app()->user->ruangan_id), array('class'=>'stok span1','readonly'=>true, "onmouseover"=>"getTotal()", "onkeypress"=>"getTotal()")),
                );
                $no++;
        }
        echo json_encode($responce);
        }
         
        /**
         * method to get type of paket with parameter daftar tindakan, kelaspelayanan, 
         * digunakan di :
         * 1. ActionAjaxController/saveTindakanPelayanan
         * @param object $model PendaftaranT
         * @param object $karcis KarcisM
         * @return int
         */
        public function tipePaketKarcis($model,$karcis)
        {
            $criteria = new CDbCriteria;
            
            $daftartindakan_id = (isset($karcis->daftartindakan_id) ? $karcis->daftartindakan_id : null);
            $criteria->with = array('tipepaket');
            $criteria->compare('daftartindakan_id', $daftartindakan_id);
            $criteria->compare('tipepaket.carabayar_id', $model->carabayar_id);
            $criteria->compare('tipepaket.penjamin_id', $model->penjamin_id);
            $criteria->compare('tipepaket.kelaspelayanan_id', $model->kelaspelayanan_id);
            $result = Params::TIPEPAKET_ID_NONPAKET;
            $paket = PaketpelayananM::model()->find($criteria);
                if(isset($paket->tipepaket_id)) $result = $paket->tipepaket_id;

            return $result;
        }
        
        //-- Rawat Jalan --//
        //-- Function Untuk Pembatalan Rawat Inap --//
        public function actionCekLoginPembatalRawatInap() 
    {
        if(Yii::app()->request->isAjaxRequest){
            $username = $_POST['username'];
            $password = md5($_POST['password']);
            $idRuangan = Yii::app()->user->getState('ruangan_id');
            
            $user = LoginpemakaiK::model()->findByAttributes(array('nama_pemakai' => $username,
                                                                   'loginpemakai_aktif' =>TRUE,
                                                                   'katakunci_pemakai'=>$password ));
            if ($user === null) {//Jika Username dan Password Salah
                $data['error'] = "Login Pemakai salah!";
                $data['cssError'] = 'username';
            }else{//Jika Username dan Passwrd Benar
                
                $ruangan_user = RuanganpemakaiK::model()->findByAttributes(array('loginpemakai_id'=>$user->loginpemakai_id,
                                                                                 'ruangan_id'=> $idRuangan));
                if($ruangan_user===null) {//Jika Ruangan Salah
                    $data['error'] = 'ruangan salah!';
                } else { //JIka ruangan Benar
                    $data['error'] = '';
                    $cek = Yii::app()->authManager->checkAccess('Administrator',$user->loginpemakai_id);
                    if($cek){//Jika User Mempunyai Hak Akses
                        $data['status'] = 'success';
                        $data['userid'] = $user->loginpemakai_id;
                        $data['username'] = $user->nama_pemakai;
                    } else {//JIka user Tidak mempunyai Hak Akses
                        $data['status'] = 'Gagal';
                    }
                }
            }
            
            echo json_encode($data);
            Yii::app()->end();
        }
    }
    
    // -- Modul Gudang Farmasi -- //
    public function actionGetObatAlkesSupplier(){
        if(Yii::app()->request->isAjaxRequest) { 
            $idObat = $_POST['idObatAlkes'];
            $idSupplier = $_POST['idSupplier'];
            
            $modSupplier = SupplierM::model()->findByPk($idSupplier);
            $modObatSupplier = new ObatsupplierM;
            $modObatAlkes=ObatalkesM::model()->findByPk($idObat);
            $nourut = 1;
                $tr="<tr>
                        <td>".CHtml::TextField('noUrut','',array('class'=>'span1 noUrut','readonly'=>TRUE)).                              
                              CHtml::activeHiddenField($modObatSupplier,'['.$idObat.']obatalkes_id',array('value'=>$modObatAlkes->obatalkes_id, 'class'=>'obatAlkes')).
                              CHtml::activeHiddenField($modObatSupplier,'['.$idObat.']supplier_id',array('value'=>$modSupplier->supplier_id, 'class'=>'supplier')).
                       "</td>
                        <td>".$modSupplier->supplier_nama."</td>
                        <td>".$modObatAlkes->obatalkes_nama."</td>
                        <td>".CHtml::activeDropDownList($modObatSupplier, '['.$idObat.']satuankecil_id', CHtml::listData(SatuankecilM::model()->findAll(), 'satuankecil_id', 'satuankecil_nama'), array('empty'=>'-- Pilih --', 'class' => 'span2 satuankecil', 'onkeypress' => "return $(this).focusNextInputField(event)"))."</td>
                        <td>".CHtml::activeDropDownList($modObatSupplier, '['.$idObat.']satuanbesar_id', CHtml::listData(SatuanbesarM::model()->findAll(), 'satuanbesar_id', 'satuanbesar_nama'), array('empty'=>'-- Pilih --', 'class' => 'span2 satuanbesar', 'onkeypress' => "return $(this).focusNextInputField(event)"))."</td>
                        <td>".CHtml::activetextField($modObatSupplier,'['.$idObat.']hargabelibesar',array('onkeyup'=>'setHargaJual(this);','value'=>ceil($modObatAlkes->harganetto),'class'=>'span1 numbersOnly netto','readonly'=>FALSE))."</td>
                        <td>".CHtml::activetextField($modObatSupplier,'['.$idObat.']hargabelikecil',array('value'=>ceil($modObatAlkes->harganetto),'class'=>'span1 numbersOnly hargajual','readonly'=>FALSE))."</td>
                        <td>".CHtml::activetextField($modObatSupplier,'['.$idObat.']diskon_persen',array('class'=>'span1 numbersOnly diskon_persen','readonly'=>FALSE,'value'=>0))."</td>
                        <td>".CHtml::activetextField($modObatSupplier,'['.$idObat.']ppn_persen',array('class'=>'span1 numbersOnly ppn_persen','readonly'=>FALSE,'value'=>0))."</td>
                        <td>".CHtml::link("<span class='icon-remove'>&nbsp;</span>",'',array('href'=>'#','onclick'=>'remove(this);return false;','style'=>'text-decoration:none;', 'class'=>'cancel'))."</td>
                      </tr>";
           
           $data['tr']=$tr;
//           $data['obatalkes']=$idSupplier;
           echo json_encode($data);
         Yii::app()->end();
        }
    }
    
    public function actionGetSupplier(){
        if(Yii::app()->request->isAjaxRequest) { 
            $idSupplier = $_POST['idSupplier'];
            $modObatSupplier = ObatsupplierM::model()->findAll('supplier_id='.$idSupplier);
            $data['supplier_id'] = $idSupplier;
            
           echo json_encode($data);
         Yii::app()->end();
        }
    }
    public function actionGetSupplierPenerimaan(){
        if(Yii::app()->request->isAjaxRequest) { 
            $idSupplier = $_POST['idSupplier'];
            $modObatSupplier = ObatsupplierM::model()->findAll('supplier_id='.$idSupplier);
            $data['supplier_id'] = $idSupplier;
            
           echo json_encode($data);
         Yii::app()->end();
        }
    }
    

    /**
     * method get list jadwal dokter
     * digunakan di : 
     * 1. Pendaftaran -> rawat Jalan
     */
    public function actionGetListJadwalDokter(){
        if (Yii::app()->request->isAjaxRequest){
            $result = '<tr><td colspan=8><i>Data Tidak Ditemukan</i></td></tr>';
            if (isset($_POST['id'])){
                $idInstalasi = $_POST['id'];
                $sql = 'select jadwaldokter_m.pegawai_id, pegawai_m.nama_pegawai, jadwaldokter_m.instalasi_id, jadwaldokter_m.ruangan_id, ruangan_m.ruangan_nama, jadwaldokter_m.jadwaldokter_hari 
                                from jadwaldokter_m
                                left join pegawai_m on pegawai_m.pegawai_id = jadwaldokter_m.pegawai_id
                                left join ruangan_m on ruangan_m.ruangan_id = jadwaldokter_m.ruangan_id
                                where jadwaldokter_m.instalasi_id=:instalasi
                                group by jadwaldokter_m.pegawai_id, pegawai_m.nama_pegawai, ruangan_m.ruangan_nama, jadwaldokter_m.instalasi_id, jadwaldokter_m.ruangan_id, jadwaldokter_m.jadwaldokter_hari';
                $modJadwal = Yii::app()->db->createCommand($sql)->queryAll(true, array(":instalasi"=>$idInstalasi));
                if (count((array)$modJadwal)> 0){
                    $result = $this->renderPartial('_getListJadwalDokter', array('modJadwal'=>$modJadwal), true);   
                }
            }
            echo json_encode($result);
            Yii::app()->end();
        }
    }

    // Script Ubah Status Periksa //
    
    public function actionUbahStatusPeriksaRJ(){
        if(Yii::app()->request->isAjaxRequest) {
            $pendaftaran_id = $_POST['pendaftaran_id'];
            $format = new MyFormatter();
            $model = PendaftaranT::model()->findByPk($id);
            $model->tglselesaiperiksa = date('Y-m-d H:i:s');            
            if(isset($_POST['PendaftaranT'])){
                $update = PendaftaranT::model()->updateByPk($id,array('statusperiksa'=>$_POST['PendaftaranT']['statusperiksa'],'tglselesaiperiksa'=>($_POST['PendaftaranT']['tglselesaiperiksa'])));
                    if($update){
                         $data['pesan']='Berhasil';
                    }else{
                        $data['pesan']='Gagal';
                    }
                  echo json_encode($data);
             Yii::app()->end();
            }
        }
    }
    
    // End Ubah Status Periksa //
   
    
    public function actionGetListKamarRI(){
//        if(Yii::app()->request->isAjaxRequest){
            $idRuangan = $_POST['idRuangan'];
            
            $model =InformasikamarinapV::model()->findAll('kamarruangan_aktif = true order by ruangan_id, kelaspelayanan_id, kamarruangan_nokamar, kamarruangan_nobed');
            $row = $this->renderKamarRuangan($model);
            if (isset($_POST['idRuangan'])){
                $ruangan = $_POST['idRuangan'];
                $model =InformasikamarinapV::model()->findAll(((!empty($ruangan)) ? "ruangan_id =".$ruangan." and " : "").'kamarruangan_aktif = true order by ruangan_id, kelaspelayanan_id, kamarruangan_nokamar, kamarruangan_nobed');
                $row = $this->renderKamarRuangan($model);
                
                echo json_encode($row);
                Yii::app()->end();
            }
            
           if (Yii::app()->request->isAjaxRequest)
            {   
                echo CJSON::encode(array(
                    'status'=>'create_form', 
                    'div'=>$this->renderPartial('_informasiKamarRI',array('model'=>$model,'row'=>$row),true)));
                exit;               
            }
//        }
    }
    
    protected function renderKamarRuangan($model){
            $result = '';
//            if (!is_array($model)){
//                $model = array($model);
//            }
                $tempRuangan = '';
                $list1 = array();
                
                foreach ($model as $i=>$row){
                    if ($row->ruangan_id != $tempRuangan){
                        $tempJumlah = 0;
                        $list1[$row->ruangan_id]['name'] = $row->ruangan_nama;
                        $list1[$row->ruangan_id]['ruangan_id'] = $row->ruangan_id;
                        $list1[$row->ruangan_id]['kamar'][$row->kelaspelayanan_id]['name'] = $row->kamarruangan_nokamar;
                        $list1[$row->ruangan_id]['kamar'][$row->kelaspelayanan_id]['kelaspelayanan'] = $row->kelaspelayanan_namalainnya;
                        $list1[$row->ruangan_id]['kamar'][$row->kelaspelayanan_id]['jml'] = $row->kamarruangan_jmlbed;
                        $list1[$row->ruangan_id]['kamar'][$row->kelaspelayanan_id]['kamar'][$row->kamarruangan_nokamar]['name'] = $row->kamarruangan_nokamar;
                        $list1[$row->ruangan_id]['kamar'][$row->kelaspelayanan_id]['kamar'][$row->kamarruangan_nokamar]['bed'][$i]['no'] = $row->kamarruangan_nobed;
                        $list1[$row->ruangan_id]['kamar'][$row->kelaspelayanan_id]['kamar'][$row->kamarruangan_nokamar]['bed'][$i]['status'] = $row->kamarruangan_status;
                        $list1[$row->ruangan_id]['kamar'][$row->kelaspelayanan_id]['kamar'][$row->kamarruangan_nokamar]['bed'][$i]['id'] = $row->kamarruangan_id;
                        $list1[$row->ruangan_id]['kamar'][$row->kelaspelayanan_id]['kamar'][$row->kamarruangan_nokamar]['bed'][$i]['keterangan'] = $row->keterangan_kamar;
                        $tempJumlah = $row->kamarruangan_jmlbed;
                        $tempRuangan = $row->ruangan_id;
                    }
                    else{
                        $list1[$tempRuangan]['kamar'][$row->kelaspelayanan_id]['name'] = $row->kamarruangan_nokamar;
                        $list1[$tempRuangan]['kamar'][$row->kelaspelayanan_id]['kelaspelayanan'] = $row->kelaspelayanan_namalainnya;
                        if ($row->kamarruangan_jmlbed >= $tempJumlah){
                            $list1[$tempRuangan]['kamar'][$row->kelaspelayanan_id]['jml'] = $row->kamarruangan_jmlbed;
                            $tempJumlah = $row->kamarruangan_jmlbed;
                        }
                        $list1[$tempRuangan]['kamar'][$row->kelaspelayanan_id]['kamar'][$row->kamarruangan_nokamar]['name'] = $row->kamarruangan_nokamar;
                        $list1[$tempRuangan]['kamar'][$row->kelaspelayanan_id]['kamar'][$row->kamarruangan_nokamar]['bed'][$i]['no'] = $row->kamarruangan_nobed;
                        $list1[$tempRuangan]['kamar'][$row->kelaspelayanan_id]['kamar'][$row->kamarruangan_nokamar]['bed'][$i]['status'] = $row->kamarruangan_status;
                        $list1[$tempRuangan]['kamar'][$row->kelaspelayanan_id]['kamar'][$row->kamarruangan_nokamar]['bed'][$i]['id'] = $row->kamarruangan_id;
                        $list1[$tempRuangan]['kamar'][$row->kelaspelayanan_id]['kamar'][$row->kamarruangan_nokamar]['bed'][$i]['keterangan'] = $row->keterangan_kamar;
                    }
                }
//                echo '<pre>';
//                echo print_r($list1);
//                exit();
                foreach ($list1 as $i=>$v){
				
                 $result .= '<div class="contentKamar">';
				 			
						$ruangan = RuanganM::model()->findByPk($v['ruangan_id']);
                        $dataRuangan ='';
						
                        if (count((array)$ruangan) == 1){
                            $dataRuangan .='<table width=\'100px\'>';
                            $dataRuangan .='<tr><td rowspan=2><img src=\''.Yii::app()->baseUrl.'/images/'.$ruangan->ruangan_image.'\' class=\'image_ruangan\'></td><td>Fasilitas</td><td>'.((!empty($ruangan->ruangan_fasilitas)) ? $ruangan->ruangan_fasilitas : " - ").'</td></tr>';
                            $dataRuangan .='<tr><td>Lokasi</td><td>'.((!empty($ruangan->ruangan_lokasi)) ? $ruangan->ruangan_lokasi : " - ").'</td></tr>';
                            $dataRuangan .='</table>';
                        }
                        foreach ($v['kamar'] as $j=>$w){
                            $result .='<div class="pintu"></div><h3 class="popover-title"><img src=\''. Yii::app()->baseUrl.'/images/blue-home-icon.png\' style=\'height:30px;\'/>'.$v['name'].' - '.$w['kelaspelayanan'].' - '.$w['jml'].'<a href="" class="pull-right poping" data-content="'.$dataRuangan.'" onclick="return false;"><img src=\''. Yii::app()->baseUrl.'/images/fasilitas.png\' style=\'height:30px;\'/>Detail</a></h3>
                                <ul>';
                            foreach ($w['kamar'] as $x=>$y){
                                $result .='<li class="bed">
                                    <div class="popover-inner">
                                        <h6 class="popover-title">'.$y['name'].'</h3>
                                        <div class="popover-content">';
                                    foreach ($y['bed'] as $a=>$b){                
//                                        echo $b['id']."<br>";
                                        $kamar = MasukkamarT::model()->find('kamarruangan_id = '.$b['id'].' order by tglmasukkamar desc');
//                                        echo "<pre>";
//                                        echo print_r($kamar->admisi->pasien->nama_pasien);
//                                        echo "</pre>";
                                      
                                        $dataPasien = '';
                                        if (count((array)$kamar) == 1){
                                            $dataPasien .='<table>';
                                            $dataPasien .='<tr><td>No RM </td><td>: '.$kamar->admisi->pasien->no_rekam_medik.'</td></tr>';
                                            $dataPasien .='<tr><td>Nama </td><td>: '.$kamar->admisi->pasien->nama_pasien.'</td></tr>';
                                            $dataPasien .='<tr><td>Jenis Kelamin </td><td>: '.$kamar->admisi->pasien->jeniskelamin.'</td></tr>';
                                            $dataPasien .= '</table>';
//                                            $dataPasien .='<p><label class=\'control-label\'>Nama :</label> '.$kamar->admisi->pasien->nama_pasien.'</p>';
//                                            $dataPasien .='<p><label class=\'control-label\'>Jenis Kelamin :</label> '.$kamar->admisi->pasien->jeniskelamin.'</p>';
                                        }
					if($b['keterangan'] == "MENUNGGU" || $b['keterangan'] == "PASIEN MENUNGGU DI RUANGAN"){
                                            $result .='<p><a href="" class="btn '.(($b['status']) ? 'btn-danger' : 'btn-primary').'" rel="popover" data-content="'.(($b['status']) ? 'Pasien Masih Menunggu Di Ruangan' : $dataPasien).'" onclick="return false"><img src=\''. Yii::app()->baseUrl.'/images/'.(($b['status']) ?  'RanjangRumahSakit3' : 'RanjangRumahSakit').'.png\'/>No. Bed : '.$b['no'].'</a></p>';
                                        }else{
                                             $result .='<p><a href="" class="btn '.(($b['status']) ? 'btn-danger' : 'btn-primary').'" rel="popover" data-content="'.(($b['status']) ? 'Pasien Kosong' : $dataPasien).'" onclick="return false"><img src=\''. Yii::app()->baseUrl.'/images/'.(($b['status']) ?  'RanjangRumahSakit2' : 'RanjangRumahSakit').'.png\'/>No. Bed : '.$b['no'].'</a></p>';
                                        }				
//                                        $result .='<p><a href="" class="btn '.(($b['status']) ? 'btn-danger' : 'btn-primary').'" rel="popover" data-content="'.(($b['status']) ? 'Pasien Kosong' : $dataPasien).'" onclick="return false"><img src=\''. Yii::app()->baseUrl.'/images/'.(($b['status']) ?  'RanjangRumahSakit2' : 'RanjangRumahSakit').'.png\'/>No. Bed : '.$b['no'].'</a></p>';
                                    }
                                    for($d=1;$d<=($w['jml'] - (count((array)$y['bed'])));$d++){
//                                        echo $d;
                                        $result .='<p><a href="" class="btn btn-info" onclick="return false"><img src=\''. Yii::app()->baseUrl.'/images/delete.png\'/>Kosong</a></p>';
                                    }
                                        $result .='</div>
                                    </div>
                                </li>';
                            }
                            $result .='</ul>';
                        }
                       
                    $result .='</div>';
                }
            
//            exit();
            return $result;
        }
        
        
      // Added function BuatSessionUbahStatusKonfirmasiBooking & UbahStatusKonfirmasiBooking, 2 APRIL 2013 //
        
        
        

        
         
     // End function BuatSessionUbahStatusKonfirmasiBooking //
        
    // -- GANTI PERIODE LAPORAN -- //
    
    
    // -- END GANTI PERIODE LAPORAN -- //
    
    public function actionGetDataPegawai()
    {
        if(Yii::app()->request->isAjaxRequest){
            $data = PegawaiM::model()->findByAttributes(array('pegawai_id'=>$_POST['idPegawai']));
            $post = array(
                'nomorindukpegawai'=>$data->nomorindukpegawai,
                'pegawai_id'=>$data->pegawai_id,
                'nama_pegawai'=>$data->nama_pegawai,
                'tempatlahir_pegawai'=>$data->tempatlahir_pegawai,
                'tgl_lahirpegawai' => $data->tgl_lahirpegawai,
                'jabatan_nama'=> (isset($data->jabatan->jabatan_nama) ? $data->jabatan->jabatan_nama : ''),
                'pangkat_nama'=> (isset($data->pangkat->pangkat_nama) ? $data->pangkat->pangkat_nama : ''),
                'kategoripegawai'=>$data->kategoripegawai,
                'kategoripegawaiasal'=>$data->kategoripegawaiasal,
                'kelompokpegawai_nama'=> (isset($data->kelompokpegawai->kelompokpegawai_nama) ? $data->kelompokpegawai->kelompokpegawai_nama : ''),
                'pendidikan_nama'=> (isset($data->pendidikan->pendidikan_nama) ? $data->pendidikan->pendidikan_nama : ''),
                'jeniskelamin'=>$data->jeniskelamin,
                'statusperkawinan'=>$data->statusperkawinan,
                'alamat_pegawai'=>$data->alamat_pegawai,
                'photopegawai'=>(!is_null($data->photopegawai) ? $data->photopegawai : ''),
            );
            echo CJSON::encode($post);
            Yii::app()->end();
        }
    }
    
    
    
    
    

    
    
    

        

        
    
    public function actionUbahKelompokPenyakit()
    {
        $model = new PendaftaranT;
        $menu = (isset($_REQUEST['menu']) ? $_REQUEST['menu'] : "");
        if(isset($_POST['PendaftaranT']))
        {
            if($_POST['PendaftaranT']['jeniskasuspenyakit_id'] != "")
            {
                $model->attributes = $_POST['PendaftaranT'];
                $transaction = Yii::app()->db->beginTransaction();
                try {
                    $attributes = array('jeniskasuspenyakit_id'=>$_POST['PendaftaranT']['jeniskasuspenyakit_id']);
                    $save = $model::model()->updateByPk($_POST['PendaftaranT']['pendaftaran_id'], $attributes);
                    if($save)
                    {
                        $transaction->commit();
                        echo CJSON::encode(array(
                            'status'=>'proses_form', 
                            'div'=>"<div class='flash-success'>Berhasil merubah Kelompok Penyakit.</div>",
                            ));
                    }else{
                        echo CJSON::encode(array(
                            'status'=>'proses_form', 
                            'div'=>"<div class='flash-error'>Data gagal disimpan.</div>",
                            ));                    
                    }
                    exit;
                }catch(Exception $exc) {
                    $transaction->rollback();
                }                
            }else{
                echo CJSON::encode(
                    array(
                        'status'=>'proses_form',
                        'div'=>"<div class='flash-success'>Berhasil merubah Kelompok Penyakit.</div>",
                    )
                );
                exit;
            }
        }
        
        if (Yii::app()->request->isAjaxRequest)
        {
            echo CJSON::encode(array(
                'status'=>'create_form', 
                'div'=>$this->renderPartial('_formUbahKelompokPenyakit', array('model'=>$model, 'menu'=>$menu), true)));
            exit;               
        }
    }
    
    
    
    public function actionUbahDokterPeriksaRI()
    {
        $model = new PasienadmisiT;
        if(isset($_POST['PasienadmisiT']))
        {
            if($_POST['PasienadmisiT']['pegawai_id'] != "")
            {
                $model->attributes = $_POST['PasienadmisiT'];
                $transaction = Yii::app()->db->beginTransaction();
                try {
                    $attributes = array('pendaftaran_id'=>$_POST['PasienadmisiT']['pendaftaran_id']);
                    $data = $model::model()->findByAttributes($attributes);
                    
                    $attributes = array('pegawai_id'=>$_POST['PasienadmisiT']['pegawai_id']);
                    $save = $model::model()->updateByPk($data['pasienadmisi_id'], $attributes);
                    
                    if($save)
                    {
                        $transaction->commit();
                        echo CJSON::encode(array(
                            'status'=>'proses_form', 
                            'div'=>"<div class='flash-success'>Berhasil merubah Dokter Periksa.</div>",
                            ));
                    }else{
                        echo CJSON::encode(array(
                            'status'=>'proses_form', 
                            'div'=>"<div class='flash-error'>Data gagal disimpan.</div>",
                            ));                    
                    }
                    exit;
                }catch(Exception $exc){
                    $transaction->rollback();
                }                
            }else{
                echo CJSON::encode(
                    array(
                        'status'=>'proses_form',
                        'div'=>"<div class='flash-success'>Berhasil merubah Dokter Periksa.</div>",
                    )
                );
                exit;
            }
        }
        
        if (Yii::app()->request->isAjaxRequest)
        {
            echo CJSON::encode(array(
                'status'=>'create_form', 
                'div'=>$this->renderPartial('_formUbahDokterPeriksaRI', array('model'=>$model), true)));
            exit;               
        }
    }    
    
    public function actionUbahKelasPelayanan()
    {
        $model = new PendaftaranT;
        $menu = (isset($_REQUEST['menu']) ? $_REQUEST['menu'] : "");
        if(isset($_POST['PendaftaranT']))
        {
            if($_POST['PendaftaranT']['kelaspelayanan_id'] != "")
            {
                $model->attributes = $_POST['PendaftaranT'];
                $transaction = Yii::app()->db->beginTransaction();
                try {
                    $attributes = array('kelaspelayanan_id'=>$_POST['PendaftaranT']['kelaspelayanan_id']);
                    $save = $model::model()->updateByPk($_POST['PendaftaranT']['pendaftaran_id'], $attributes);
                    if($save)
                    {
                        $transaction->commit();
                        echo CJSON::encode(array(
                            'status'=>'proses_form', 
                            'div'=>"<div class='flash-success'>Berhasil merubah Kelas Pelayanan.</div>",
                            ));
                    }else{
                        echo CJSON::encode(array(
                            'status'=>'proses_form', 
                            'div'=>"<div class='flash-error'>Data gagal disimpan.</div>",
                            ));                    
                    }
                    exit;
                }catch(Exception $exc) {
                    $transaction->rollback();
                }
            }else{
                echo CJSON::encode(
                    array(
                        'status'=>'proses_form',
                        'div'=>"<div class='flash-success'>Berhasil merubah data Kelas Pelayanan.</div>",
                    )
                );
                exit;
            }
        }
        
        if (Yii::app()->request->isAjaxRequest)
        {
            echo CJSON::encode(array(
                'status'=>'create_form', 
                'div'=>$this->renderPartial('_formUbahKelasPelayananRJ', array('model'=>$model,'menu'=>$menu), true)));
            exit;               
        }
    }
    
    public function actionUbahKelasPelayananRI()
    {
        $model = new PasienadmisiT;
        if(isset($_POST['PasienadmisiT']))
        {
            if($_POST['PasienadmisiT']['kelaspelayanan_id'] != "")
            {
                $model->attributes = $_POST['PasienadmisiT'];
                $transaction = Yii::app()->db->beginTransaction();
                try {
                    $attributes = array('pendaftaran_id'=>$_POST['PasienadmisiT']['pendaftaran_id']);
                    $data = $model::model()->findByAttributes($attributes);
                    
                    $attributes = array('kelaspelayanan_id'=>$_POST['PasienadmisiT']['kelaspelayanan_id']);
                    $save = $model::model()->updateByPk($data['pasienadmisi_id'], $attributes);
                    
                    if($save)
                    {
                        $transaction->commit();
                        echo CJSON::encode(array(
                            'status'=>'proses_form', 
                            'div'=>"<div class='flash-success'>Berhasil merubah Kelas Pelayanan.</div>",
                            ));
                    }else{
                        echo CJSON::encode(array(
                            'status'=>'proses_form', 
                            'div'=>"<div class='flash-error'>Data gagal disimpan.</div>",
                            ));                    
                    }
                    exit;
                }catch(Exception $exc) {
                    $transaction->rollback();
                }
            }else{
                echo CJSON::encode(
                    array(
                        'status'=>'proses_form',
                        'div'=>"<div class='flash-success'>Berhasil merubah data Kelas Pelayanan.</div>",
                    )
                );
                exit;
            }
        }
        
        if (Yii::app()->request->isAjaxRequest)
        {
            echo CJSON::encode(array(
                'status'=>'create_form', 
                'div'=>$this->renderPartial('_formUbahKelasPelayananRI', array('model'=>$model), true)));
            exit;               
        }
    }

    public function actionGetLamaKontrak()
    {
        if(Yii::app()->getRequest()->getIsAjaxRequest()) {
            $format = new MyFormatter;
            $tgl_awal = $format->formatDateTimeForDb($_POST['tgl_awal']);
            $tgl_akhir = $format->formatDateTimeForDb($_POST['tgl_akhir']);
//            $dob=$tglLahir; 
//            $today=date("Y-m-d");
            list($y,$m,$d)=explode('-',$tgl_awal);
            list($ty,$tm,$td)=explode('-',$tgl_akhir);
            
            if($td-$d<0){
                $day=($td+30)-$d;
                $tm--;
            }
            else{
                $day=$td-$d;
            }
            if($tm-$m<0){
                $month=($tm+12)-$m;
                $ty--;
            }
            else{
                $month=$tm-$m;
            }
            $year=$ty-$y;
            
            $data['kontrak'] = str_pad($year, 2, '0', STR_PAD_LEFT).' Thn '. str_pad($month, 2, '0', STR_PAD_LEFT) .' Bln '. str_pad($day, 2, '0', STR_PAD_LEFT).' Hr';
            
            echo json_encode($data);
            Yii::app()->end();
        }
    }
    

     public function actionUbahRekeningDebitKreditPenerimaan()
    {
        $model = new JenispenerimaanM;
        if(isset($_POST['JenispenerimaanM']))
        {
            $model->attributes = $_POST['JenispenerimaanM'];
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $attributes = array('rekeningdebit_id'=>$_POST['JenispenerimaanM']['rekeningdebit_id'],'rekeningkredit_id'=>$_POST['JenispenerimaanM']['rekeningkredit_id']);
                $save = JenispenerimaanM::model()->updateByPk($_POST['JenispenerimaanM']['jenispenerimaan_id'], $attributes);
                if($save)
                {
                    $transaction->commit();
                    echo CJSON::encode(array(
                        'status'=>'proses_form', 
                        'div'=>"<div class='flash-success'>Berhasil merubah data Rekening.</div>",
                        ));                    
                }else{
                    echo CJSON::encode(array(
                        'status'=>'proses_form', 
                        'div'=>"<div class='flash-error'>Data gagal disimpan.</div>",
                        ));                    
                }
                exit;
            }catch(Exception $exc) {
                $transaction->rollback();
            }
        }

        if (Yii::app()->request->isAjaxRequest)
        {
            echo CJSON::encode(array(
                'status'=>'create_form', 
                'div'=>$this->renderPartial('_formUbahRekeningDebitKreditPenerimaan', array('model'=>$model), true)));
            exit;               
        }
    }    

    public function actionGetTreeMenu()
    {
        if(Yii::app()->getRequest()->getIsAjaxRequest())
        {
            $criteria=new CDbCriteria;
            $rekeningSatu = new Rekening1M;
            $rekeningDua = new Rekening2M;
            $rekeningTiga = new Rekening3M;
            $rekeningEmpat = new Rekening4M;
            $rekeningLima = new Rekening5M;
            
            $params = array('rekening1_aktif' => true);
            $criteria->order = 'rekening1_id';
            $result = $rekeningSatu->findAllByAttributes($params, $criteria);
            $parent_satu = '';
            foreach($result as $val)
            {
                $params_dua = array(
                    'rekening2_aktif' => true,
                    'rekening1_id' => $val->rekening1_id,
                );
                $criteria->order = 'rekening2_id';
                $result_dua = $rekeningDua->findAllByAttributes($params_dua, $criteria);
                $parent_dua = '';
                foreach($result_dua as $val_dua)
                {
                    $params_tiga = array(
                        'rekening3_aktif' => true,
                        'rekening1_id' => $val_dua->rekening1_id,
                        'rekening2_id' => $val_dua->rekening2_id,
                    );
                    $criteria->order = 'rekening3_id';
                    $result_tiga = $rekeningTiga->findAllByAttributes($params_tiga, $criteria);
                    $parent_tiga = '';
                    foreach($result_tiga as $val_tiga)
                    {
                        $params_empat = array(
                            'rekening4_aktif' => true,
                            'rekening1_id' => $val_tiga->rekening1_id,
                            'rekening2_id' => $val_tiga->rekening2_id,
                            'rekening3_id' => $val_tiga->rekening3_id,
                        );
                        $criteria->order = 'rekening4_id';
                        $result_empat = $rekeningEmpat->findAllByAttributes($params_empat, $criteria);
                        $parent_empat = '';
                        foreach($result_empat as $val_empat)
                        {
                            $params_lima = array(
                                'rekening5_aktif' => true,
                                'rekening1_id' => $val_empat->rekening1_id,
                                'rekening2_id' => $val_empat->rekening2_id,
                                'rekening3_id' => $val_empat->rekening3_id,
                                'rekening4_id' => $val_empat->rekening4_id,
                            );
                            $criteria->order = 'rekening5_id';
                            $result_lima = $rekeningLima->findAllByAttributes($params_lima, $criteria);
                            $parent_lima = '';
                            foreach($result_lima as $val_lima)
                            {
                                $parent_lima .= "<li><span class='file'>". $val_lima->nmrekening5 ."<span style='float:right'><a value='". $val_lima->rekening5_id ."' href='#' onclick='editObyekDetailRekening(this);return false;' rel='tooltip' data-original-title='Klik untuk edit Detail Obyek Rekening'><i class='icon-pencil-brown'></i></a></span></span></li>";
                            }

                            $kode_kelompok_lima = $val->kdrekening1 . '_' . $val_dua->kdrekening2 . '_' . $val_tiga->kdrekening3 . '_' . $val_empat->kdrekening4;
                            $id_kelompok_lima = $val_empat->rekening1_id . '_' . $val_empat->rekening2_id . '_' . $val_empat->rekening3_id . '_' . $val_empat->rekening4_id;
                            if(count((array)$result_lima) > 0)
                            {
                                $parent_empat .= "<li><span class='folder'>". $val_empat->nmrekening4 ."<span style='float:right'><a max_kode='". $val_lima->kdrekening5 ."' id_rek='". $id_kelompok_lima ."' kode_rek='". $kode_kelompok_lima ."' href='#' onclick='tambahObyekDetailRekening(this);return false;' rel='tooltip' data-original-title='Klik untuk menambah detail Objek Rekening'><i class='icon-plus-sign'></i></a></span><span style='float:right'><a value='". $val_empat->rekening4_id ."' href='#' onclick='editObyekRekening(this);return false;' rel='tooltip' data-original-title='Klik untuk edit Obyek Rekening'><i class='icon-pencil-brown'></i></a></span></span><ul>". $parent_lima ."</ul></li>";
                            }else{
                                $parent_empat .= "<li class='expandable'><span class='folder'>". $val_empat->nmrekening4 ."<span style='float:right'><a max_kode='0' id_rek='". $id_kelompok_lima ."' kode_rek='". $kode_kelompok_lima ."' href='#' onclick='tambahObyekDetailRekening(this);return false;' rel='tooltip' data-original-title='Klik untuk menambah detail Objek Rekening'><i class='icon-plus-sign'></i></a></span><span style='float:right'><a value='". $val_empat->rekening4_id ."' href='#' onclick='editObyekRekening(this);return false;' rel='tooltip' data-original-title='Klik untuk edit Obyek Rekening'><i class='icon-pencil-brown'></i></a></span></span></li>";                                            
                            }
                        }
//                                    
                        $kode_kelompok_empat = $val->kdrekening1 . '_' . $val_dua->kdrekening2 . '_' . $val_tiga->kdrekening3;
                        $id_kelompok_empat = $val_tiga->rekening1_id . '_' . $val_tiga->rekening2_id . '_' . $val_tiga->rekening3_id;
                        if(count((array)$result_empat) > 0)
                        {
                            $parent_tiga .= "<li><span class='folder'>". $val_tiga->nmrekening3 ."<span style='float:right'><a max_kode='". $val_empat->kdrekening4 ."' id_rek='". $id_kelompok_empat ."' kode_rek='". $kode_kelompok_empat ."' href='#' onclick='tambahObyekRekening(this);return false;' rel='tooltip' data-original-title='Klik untuk menambah Objek Rekening'><i class='icon-plus-sign'></i></a></span><span style='float:right'><a value='". $val_tiga->rekening3_id ."' href='#' onclick='editJenisRekening(this);return false;' rel='tooltip' data-original-title='Klik untuk edit Jenis Rekening'><i class='icon-pencil-brown'></i></a></span></span><ul>". $parent_empat ."</ul></li>";
                        }else{
                            $parent_tiga .= "<li class='expandable'><span class='folder'>". $val_tiga->nmrekening3 ."<span style='float:right'><a max_kode='0' id_rek='". $id_kelompok_empat ."' kode_rek='". $kode_kelompok_empat ."' href='#' onclick='tambahObyekRekening(this);return false;' rel='tooltip' data-original-title='Klik untuk menambah Objek Rekening'><i class='icon-plus-sign'></i></a></span><span style='float:right'><a value='". $val_tiga->rekening3_id ."' href='#' onclick='editJenisRekening(this);return false;' rel='tooltip' data-original-title='Klik untuk edit Jenis Rekening'><i class='icon-pencil-brown'></i></a></span></span></li>";
                        }


                    }

                    $kode_kelompok = $val->kdrekening1 . '_' . $val_dua->kdrekening2;
                    $id_kelompok = $val_dua->rekening1_id . '_' . $val_dua->rekening2_id;
                    if(count((array)$result_tiga) > 0)
                    {
                        $parent_dua .= "<li id='". $id_kelompok ."'><span class='folder'>". $val_dua->nmrekening2 ."<span style='float:right'><a max_kode='". $val_tiga->kdrekening3 ."' id_rek='". $id_kelompok ."' kode_rek='". $kode_kelompok ."' href='#' onclick='tambahJenisRekening(this);return false;' rel='tooltip' data-original-title='Klik untuk menambah Jenis Rekening'><i class='icon-plus-sign'></i></a></span><span style='float:right'><a value='". $val_dua->rekening2_id ."' href='#' onclick='editKelompokRekening(this);return false;' rel='tooltip' data-original-title='Klik untuk edit Kelompok Rekening'><i class='icon-pencil-brown'></i></a></span></span><ul>". $parent_tiga ."</ul></li>";
                    }else{
                        $parent_dua .= "<li id='". $id_kelompok ."' class='expandable'><span class='folder'>". $val_dua->nmrekening2 ."<span style='float:right'><a max_kode='0' id_rek='". $id_kelompok ."' kode_rek='". $kode_kelompok ."' href='#' onclick='tambahJenisRekening(this);return false;' rel='tooltip' data-original-title='Klik untuk menambah Jenis Rekening'><i class='icon-plus-sign'></i></a></span><span style='float:right'><a value='". $val_dua->rekening2_id ."' href='#' onclick='editKelompokRekening(this);return false;' rel='tooltip' data-original-title='Klik untuk edit Kelompok Rekening'><i class='icon-pencil-brown'></i></a></span></span></li>";
                    }

                }

                $value_kode = $val->kdrekening1;
                $value_id = $val->rekening1_id;
                if(count((array)$result_dua) > 0)
                {
                    $parent_satu .= "<li id='". $value_id ."'><span class='folder'>". $val->nmrekening1 ."<span style='float:right'><a max_kode='". $val_dua->kdrekening2 ."' id_rek='". $value_id ."' kode_rek='". $value_kode ."' href='#' onclick='tambahKelompokRekening(this);return false;' rel='tooltip' data-original-title='Klik untuk menambah Kelompok Rekening'><i class='icon-plus-sign'></i></a></span><span style='float:right'><a value='". $val->rekening1_id ."' href='#' onclick='editStrukturRekening(this);return false;' rel='tooltip' data-original-title='Klik untuk edit Struktur Rekening'><i class='icon-pencil-brown'></i></a></span></span><ul>". $parent_dua ."</ul></li>";
                }else{
                    $parent_satu .= "<li id='". $value_id ."' class='expandable'><span class='folder'>". $val->nmrekening1 ."<span style='float:right'><a max_kode='0' id_rek='". $value_id ."' kode_rek='". $value_kode ."' href='#' onclick='tambahKelompokRekening(this);return false;' rel='tooltip' data-original-title='Klik untuk menambah Kelompok Rekening'><i class='icon-plus-sign'></i></a></span><span style='float:right'><a value='". $val->rekening1_id ."' href='#' onclick='editStrukturRekening(this);return false;' rel='tooltip' data-original-title='Klik untuk edit Struktur Rekening'><i class='icon-pencil-brown'></i></a></span></span></li>";
                }                
            }

            if(count((array)$result) > 0)
            {
                $text = '<span class="folder">Struktur Rekening<span style="float:right"><a max_kode = "'. $val->kdrekening1 .'" href="#" onclick="tambahStrukturRekening(this);return false;" rel="tooltip" data-original-title="Klik untuk menambah Struktur Rekening"><i class="icon-plus-sign"></i></a></span></span>';
                $parent_satu = $text . '<ul>' . $parent_satu . '</ul>';
            }
            echo json_encode($parent_satu);
            Yii::app()->end();
        }
    }
	
    public function actionGetDataObatAlkes()
    {
        if(Yii::app()->request->isAjaxRequest)
        {
            $criteria = new CDbCriteria();
            $criteria->compare('obatalkes_nama', $_GET['obatalkes_id']);
            $models = ObatalkesM::model()->findAll($criteria);
            echo CJSON::encode($model->attribute);
            Yii::app()->end();
        }
    }   

    public function actionGetPasienLama()
    {

      if(isset($_POST['norm']) && $_POST['norm']!='')
      {
        $criteria = new CDbCriteria();
        $criteria->compare('no_rekam_medik', $_POST['norm']);
        $models = PasienM::model()->find($criteria);

        echo CJSON::encode($models->attributes);
        Yii::app()->end();
        
      }
    } 
    
    /** fungsi untuk update cetakan  **/
    public function actionUpdateJumlahCetakan()
    {
        if(Yii::app()->getRequest()->getIsAjaxRequest())
        {
            $uangmuka = RincianCetakan::model()->findByAttributes($_POST['id']);
            if($uangmuka)
            {
                
                /** update informasi cetakan **/
                $update = $uangmuka;
                $update->jumlah = ($uangmuka['jumlah']+1);
                
                $is_update = true;
                if(!$update->save())
                {
                    $is_update = false;
                }
                
                $result = array(
                    'status'=>($is_update == false ? 'not': 'ok'),
                    'jumlah'=>$uangmuka['jumlah']
                );
                
            }else{
                
                /** insert informasi cetakan **/
                $attributes = array(
                    'jumlah'=>1
                );
                $insert = new RincianCetakan;
                $insert->attributes = $_POST['id'];
                $insert->jumlah = 1;
                
                $is_insert = true;
                if(!$insert->save())
                {
                    $is_insert = false;
                }
                $result = array(
                    'status'=>($is_insert == false ? 'not': 'ok'),
                    'jumlah'=>1
                );
            }
            
            echo CJSON::encode($result);
            Yii::app()->end();
        }
    }     
    
    
    /* 
     * ambil data rekening berdasarkan penerimaan Kas 
     * modul > akutansi > penerimaan_kas
     */
    public function actionGetDataRekeningByJnsPenerimaan()
    {
        if(Yii::app()->getRequest()->getIsAjaxRequest())
        {
            $jenispenerimaan_id = $_POST['jenispenerimaan_id'];
            $criteria = new CDbCriteria;
            $criteria->select = '*, jnspenerimaanrek_m.saldonormal';
            $criteria->join = '
                JOIN jnspenerimaanrek_m ON 
                    jnspenerimaanrek_m.rekening1_id = t.struktur_id AND
                    jnspenerimaanrek_m.rekening2_id = t.kelompok_id AND
                    jnspenerimaanrek_m.rekening3_id = t.jenis_id AND
                    jnspenerimaanrek_m.rekening4_id = t.obyek_id AND
                    jnspenerimaanrek_m.rekening5_id = t.rincianobyek_id                
            ';
            $criteria->condition = 'jnspenerimaanrek_m.jenispenerimaan_id = :jenispenerimaan_id';
            $criteria->params = array(':jenispenerimaan_id'=>$jenispenerimaan_id);
            $model = RekeningakuntansiV::model()->findAll($criteria);
            if($model)
            {
                echo CJSON::encode(
                    $this->renderPartial('__formKodeRekening', array('model'=>$model), true)
                );                
            }
            Yii::app()->end();
        }        
    }
    
        public function actionAmbilDataRekening()
        {
            if(Yii::app()->getRequest()->getIsAjaxRequest())
            {
                $data = array();
                $params = array();
                foreach($_POST['id_rekening'] as $key=>$val)
                {
                    if($key != 'status')
                    {
                        if(strlen(trim($val)) > 0)
                        {
                            $data[] = $key . ' = :' . $key;
                            $params[(string) ':'.$key] = $val;
                        }                        
                    }
                }
                
                $criteria = new CDbCriteria;
                $criteria->select = '*';
                $criteria->condition = implode($data, ' AND ');
                $criteria->params = $params;
                $model = RekeningakuntansiV::model()->findAll($criteria);
                if($model)
                {
                    echo CJSON::encode(
                        $this->renderPartial('__formKodeRekening', array('model'=>$model, 'status'=>$_POST['id_rekening']['status']), true)
                    );                
                }
                Yii::app()->end();
            }
        }    
    public function actionListAntrianRuangan(){
        if(Yii::app()->request->isAjaxRequest) { 
                $ruangan = $_POST['ruangan'];
                $form='';
            if(!empty($ruangan)){
                        $criteria=new CDbCriteria;
                        $criteria->compare('ruangan_id', $ruangan);
    //                    $criteria->compare('LOWER(hari)', strtolower($hariCari));

                        $modJadwalBukaPoli= JadwalbukapoliM::model()->findAll($criteria);
                        if (count((array)$modJadwalBukaPoli) > 0){
                            foreach($modJadwalBukaPoli as $key=>$antrian){
                                $jadwal = $antrian->maxantiranpoli;     
                            }
                             
                        }else{
                            $jadwal = 0;
                        }

                    $data['maxAntrianRuangan']=$jadwal;
                   echo json_encode($data);
             Yii::app()->end();
            }
        }
    }
    public function actionListAntrianDokter(){
        if(Yii::app()->request->isAjaxRequest) { 
                $ruangan = (isset($_POST['ruangan']) ? $_POST['ruangan'] : null);
                $pegawai = (isset($_POST['pegawai']) ? $_POST['pegawai'] : null);
                $form='';
            if(!empty($ruangan)){
                        $criteria=new CDbCriteria;
                        $criteria->compare('ruangan_id', $ruangan);
                        $criteria->compare('pegawai_id', $pegawai);
    //                    $criteria->compare('LOWER(hari)', strtolower($hariCari));

                        $modJadwalDokter= JadwaldokterM::model()->findAll($criteria);
                        if (count((array)$modJadwalDokter) > 0){
                            foreach($modJadwalDokter as $key=>$antrian){
                                $jadwal = $antrian->maximumantrian;     
                            }
                             
                        }else{
                            $jadwal = 0;
                        }

                    $data['maxAntrianDokter']=$jadwal;
                   echo json_encode($data);
             Yii::app()->end();
            }
        }
    }
    
    public function actionubahLokasirak()
    {
        $model = new DokrekammedisM;
        if(isset($_POST['DokrekammedisM']))
        {
            $model->attributes = $_POST['DokrekammedisM'];
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $attributes = array('lokasirak_id'=>$_POST['DokrekammedisM']['lokasirak_id']);
                $save = DokrekammedisM::model()->updateByPk($_POST['DokrekammedisM']['dokrekammedis_id'], $attributes);
                if($save)
                {
                    $transaction->commit();
                    echo CJSON::encode(array(
                        'status'=>'proses_form', 
                        'div'=>"<div class='flash-success'>Berhasil merubah data Lokasi Rak.</div>",
                        ));                    
                }else{
                    echo CJSON::encode(array(
                        'status'=>'proses_form', 
                        'div'=>"<div class='flash-error'>Data gagal disimpan.</div>",
                        ));                    
                }
                exit;
            }catch(Exception $exc) {
                $transaction->rollback();
            }
        }

        if (Yii::app()->request->isAjaxRequest)
        {
            echo CJSON::encode(array(
                'status'=>'create_form', 
                'div'=>$this->renderPartial('_ubahLokasiRak', array('model'=>$model), true)));
            exit;               
        }
    }

    public function actionPasienDokumen()
    {
        if (Yii::app()->request->isAjaxRequest){
            $idDokRM = $_POST['idpasien'];
            $model = DokrekammedisM::model()->findByPk($idDokRM);

            $modPasien = PasienM::model()->findByPk($model->pasien_id);
            $modLokasirak = LokasirakM::model()->findByPk($model->lokasirak_id);
            $modSubrak = SubrakM::model()->findByPk($model->subrak_id);
            $attributes = $model->attributeNames();
            foreach($attributes as $j=>$attribute) {
                $returnVal["$attribute"] = $model->$attribute;
            }
            
            $returnVal["nama_pasien"] = $modPasien->nama_pasien;
            $returnVal["lokasirak_nama"] = $modLokasirak->lokasirak_nama;
            $returnVal["subrak_nama"] = $modSubrak->subrak_nama;
            echo json_encode($returnVal);
            Yii::app()->end();
        }
    }


    public function actionubahSubrak()
    {
        $model = new DokrekammedisM;
        if(isset($_POST['DokrekammedisM']))
        {
            $model->attributes = $_POST['DokrekammedisM'];
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $attributes = array('subrak_id'=>$_POST['DokrekammedisM']['subrak_id']);
                $save = DokrekammedisM::model()->updateByPk($_POST['DokrekammedisM']['dokrekammedis_id'], $attributes);
                if($save)
                {
                    $transaction->commit();
                    echo CJSON::encode(array(
                        'status'=>'proses_form', 
                        'div'=>"<div class='flash-success'>Berhasil merubah data Sub Rak.</div>",
                        ));                    
                }else{
                    echo CJSON::encode(array(
                        'status'=>'proses_form', 
                        'div'=>"<div class='flash-error'>Data gagal disimpan.</div>",
                        ));                    
                }
                exit;
            }catch(Exception $exc) {
                $transaction->rollback();
            }
        }

        if (Yii::app()->request->isAjaxRequest)
        {
            echo CJSON::encode(array(
                'status'=>'create_form', 
                'div'=>$this->renderPartial('_ubahSubRak', array('model'=>$model), true)));
            exit;               
        }
    }

    public function actionCekPasien()
    {
      if (Yii::app()->request->isAjaxRequest){
        $pasien_id = (isset($_POST['pasien_id']) ? $_POST['pasien_id'] : null);
        $returnVal = array();
        $criteria = new CDbCriteria;
        $criteria->compare('pasien_id', $pasien_id);   
        $criteria->addCondition('tgl_pendaftaran BETWEEN \''.date('Y-m-d').' 00:00:00\' AND \''.date('Y-m-d 23:59:59').'\'');
        $model = PendaftaranT::model()->find($criteria);
        if(isset($model)){
            $returnVal["no_rekam_medik"]  = $model->pasien->no_rekam_medik;
            $returnVal["nama_pasien"]     = $model->pasien->nama_pasien;
            $returnVal["no_pendaftaran"]  = $model->no_pendaftaran;
            $returnVal["statusperiksa"]   = $model->statusperiksa;
            $returnVal["tgl_pendaftaran"] = $model->tgl_pendaftaran;
            $returnVal["ruangan_nama"]    = $model->ruangan->ruangan_namalainnya;
            $returnVal["jumlah"] = count((array)$model);
        }
        echo json_encode($returnVal);
        Yii::app()->end();
      }
    }

    public function actionAmbilPasienId()
    {
      if (Yii::app()->request->isAjaxRequest){
        $no_rekam_medik = (isset($_POST['no_rekam_medik']) ? $_POST['no_rekam_medik'] : null);

        $model = PasienM::model()->findByAttributes(array('no_rekam_medik'=>$no_rekam_medik));
        $returnVal["pasien_id"]  = (isset($model->pasien_id) ? $model->pasien_id : null);

        echo json_encode($returnVal);
        Yii::app()->end();
      }
    }
    
    /**
    * menampilkan pendaftaran pasien yang belum melunasi pembayaran
    */
    public function actionGetDataPendaftaranByNopendaftaran(){
        if(Yii::app()->request->isAjaxRequest) {
            $criteria = new CDbCriteria();
            $criteria->with = array('pasien','instalasi','ruangan','pembayaranpelayanan','obatalkespasien','tindakanpelayanan');
            $criteria->addCondition("LOWER(t.no_pendaftaran) = '". strtolower($_GET['term'])."'");
            $criteria->limit = 5;
            $model = PendaftaranT::model()->find($criteria);
            if($model){
                $returnVal['label'] = $model->no_pendaftaran.' - '.$model->pasien->nama_pasien;
                $returnVal['value'] = $model->no_pendaftaran;
                $attributes = $model->attributeNames();
                foreach($attributes as $j=>$attribute) {
                    $returnVal["$attribute"] = $model->$attribute;
                }
                $attrPasiens = PasienM::model()->attributeNames();
                foreach($attrPasiens as $j=>$attrPas) {
                    $returnVal["$attrPas"] = $model->pasien->$attrPas;
                }
                $returnVal["instalasi_nama"] = $model->instalasi->instalasi_nama;
                $returnVal["ruangan_nama"] = $model->ruangan->ruangan_nama;
                $returnVal["jeniskasuspenyakit_nama"] = $model->jeniskasuspenyakit->jeniskasuspenyakit_nama;
                $returnVal["carabayar_nama"] = $model->carabayar->carabayar_nama;
                $returnVal["penjamin_nama"] = $model->penjamin->penjamin_nama;
            }
            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }

    /*
     * untuk informasi di farmasiApotek/InfoPasienPulang
     */    
        public function actionUbahStatusFarmasi(){
            if(Yii::app()->request->isAjaxRequest) {
                $idpendaftaran = $_POST['idpendaftaran'];
                $status = $_POST['status'];
                
                $model = PendaftaranT::model()->findByPk($idpendaftaran);        
                if($status == "RI"){
                    $update = PasienadmisiT::model()->updateByPk($model->pasienadmisi_id,array('statusfarmasi'=>true));
                        if($update){
                             $data['pesan']='Berhasil';
                        }else{
                            $data['pesan']='Gagal';
                        }
                }else{
                    $update = PendaftaranT::model()->updateByPk($idpendaftaran,array('statusfarmasi'=>true));
                    if($update){
                         $data['pesan']='Berhasil';
                    }else{
                        $data['pesan']='Gagal';
                    }
                }
                
                echo json_encode($data);
                 Yii::app()->end();
            }
        }
        
        /** untuk menampilkan kode barang pada field secara dynamic **/
        public function actionGetKodeBarangSubSubKel($encode=false,$model_nama='',$attr='')
        {            
            if(Yii::app()->request->isAjaxRequest) {
                $modKodeBarang = new SubsubkelompokM;
                if($model_nama !=='' && $attr == ''){
                    $subsubkelompok_id = $_POST["$model_nama"]['subsubkelompok_id'];
                }
                 elseif ($model_nama == '' && $attr !== '') {
                    $subsubkelompok_id = $_POST["$attr"];
                }
                elseif ($model_nama !== '' && $attr !== '') {
                    $subsubkelompok_id = $_POST["$model_nama"]["$attr"];
                }
                //var_dump($golongan_id);die;
                $kodebarang = null;
                if($subsubkelompok_id){
                    //var_dump($golongan_id);die;
                    $kodebarang = $modKodeBarang->getDataKodeSSKItems($subsubkelompok_id);
                   
//                    $kelurahan = KelurahanM::model()->findAll('kecamatan_id='.$kecamatan_id.'');
                    $kodebarang = CHtml::listData($kodebarang,'subsubkelompok_id','subsubkelompok_kode');
                }

                if($encode){
                    echo CJSON::encode($kodebarang);
                } else {
                    if(empty($kodebarang)){
                       // echo CHtml::tag('input', array('value'=>''),CHtml::encode(''),true);
                        $data['kodebarang'] = '';
                    }else{
                        //echo CHtml::tag('input', array('value'=>''),CHtml::encode(''),true);
                        foreach($kodebarang as $value=>$name)
                        {
                             $data['kodebarang'] = $name;
                            //echo CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
                        }
                    }
                    
                    echo CJSON::encode($data);
                }
            }
            Yii::app()->end();
                
        }
        
        public function actionDataRincian()
        {
            if(Yii::app()->request->isAjaxRequest) 
            {
                $rincian = InformasipasiensudahbayarV::model()->getRincianCetak($_POST['pendaftaranid']);                
                $data = array();
                
                
                    $data['nama'] = $rincian['nama'];
                    $data['tanggal'] = $rincian['tanggal'];
                    $data['ruangan'] = $rincian['ruangan'];
       
                
                 echo CJSON::encode($data);
            }
            Yii::app()->end();
        }
        
        public function actionSetUmur()
        {
            if(Yii::app()->getRequest()->getIsAjaxRequest()) {
                $data['umur'] = null;
                if(isset($_POST['tanggal_lahir']) && !empty($_POST['tanggal_lahir'])){
                    $umur = explode(' ',CustomFunction::hitungUmur($_POST['tanggal_lahir']));
                    $data['umur'] = $umur[0];
                }
                echo json_encode($data);
                Yii::app()->end();
            }
        }
        
        public function actionCekNoRM()
        {
            if(Yii::app()->getRequest()->getIsAjaxRequest()) {
                                
                $rm_last = PasienM::model()->find(array(
                    'condition'=>'ispasienluar = false',
                    'order'=>'no_rekam_medik desc'
                ));
                //echo $no_rekam_medik." ".$rm_last->no_rekam_medik; die;
                                
                $returnVal['no_rekam_medik'] = $rm_last->no_rekam_medik;
                echo CJSON::encode($returnVal);
                Yii::app()->end();
                
            }                              
        }
        
        
        public function actionGetKelasMasukKamar()
        {
            if(Yii::app()->request->isAjaxRequest) {
                $ruangan_id = (isset($_POST['ruangan_id']) ? $_POST['ruangan_id'] : null);
                $kamarruangan_id = (isset($_POST['kamarruangan_id']) ? $_POST['kamarruangan_id'] : null);                
                $gabung = isset($_POST['rawatgabung'])?$_POST['rawatgabung']:'';                
                $rawatgabung = ($gabung == 'true')?'1':'0';    
                
                if (!empty($ruangan_id)){
                    if ($ruangan_id == Params::RUANGAN_ID_BERSALIN){
                        $option = '';
                        $kelas = MasukkamarT::model()->find("tglkeluarkamar IS NULL AND ruangan_id = '".$ruangan_id."'  AND kamarruangan_id = '".$kamarruangan_id."' "); 
                        if (!empty($kelas)){
                            $option = $kelas->kelaspelayanan_id;
                        }
                         
                        $dataList['kelaspelayanan_id'] = $option;
                        echo json_encode($dataList);
                    }
                }
                
            }
            
             Yii::app()->end();
        }
        
         
    public function actionGetKelasPelKamarRuangan(){
        if (Yii::app()->request->isAjaxRequest){
            $ruangan_id = $_POST['ruangan_id'];
            $data = "";   
            $kelas= "";
            $kamar= "";
            
            if (!empty($ruangan_id)){
                //kelas pelayanan
                $cri = new CDbCriteria();
                $cri->join = " JOIN kelasruangan_m kr ON kr.kelaspelayanan_id = t.kelaspelayanan_id ";
                $cri->addCondition(" kr.ruangan_id = '".$ruangan_id."' ");
                $cri->order = "t.kelaspelayanan_nama ASC";
                $kelasPelayanan = KelaspelayananM::model()->findAll($cri);
                
                //kamar ruangan
                $cri = new CDbCriteria();                
                $cri->addCondition(" ruangan_id = '".$ruangan_id."' ");
                $cri->addCondition(" kamarruangan_aktif = TRUE ");
                $cri->order = "t.kamarruangan_nokamar ASC";
                $kamarRuangan = KamarruanganM::model()->findAll($cri);
                
                if (count((array)$kelasPelayanan)>1){
                     $kelas .= "<option value = '' >-- Pilih --</option>";
                }elseif (count((array)$kelasPelayanan)==0){
                    $kelas .= "<option value = '' >-- Pilih --</option>";
                }
                
                if (count((array)$kamarRuangan)>1){
                    $kamar .= "<option value = '' >-- Pilih --</option>";
                }elseif (count((array)$kamarRuangan)==0){
                    $kamar .= "<option value = '' >-- Pilih --</option>";
                }
                
                foreach ($kelasPelayanan as $klsPel)
                {                     
                    $kelas .= "<option value='$klsPel->kelaspelayanan_id'>$klsPel->kelaspelayanan_nama</option>";
                }                                                       
                
                foreach ($kamarRuangan as $kmrR)
                {                     
                    $kamar .= "<option value='$kmrR->kamarruangan_id'>$kmrR->kamarruangan_nokamar - $kmrR->kamarruangan_nobed</option>";
                }
            }else{                
                 $kelas .= "<option value = '' >-- Pilih --</option>";
                 $kamar .= "<option value = '' >-- Pilih --</option>";                                    
            }
            $data['kelasPelayanan'] = $kelas;    
            $data['kamarRuangan'] = $kamar;    
            echo json_encode($data); 
        
        Yii::app()->end();
        }
    }
        
	public function actionGetPegTriase(){
		if (Yii::app()->request->isAjaxRequest){
			
			$id = isset($_POST['id'])?$_POST['id']:null;
			
			if ($id == '---'){
				$id = null;
			}
			
			if (!empty($id)){
				$peg = AsesmentriasepegT::model()->findAllByAttributes(array('asesmentriase_id' => $id));

				$returnVal = array();

				if (count((array)$peg)>0){                
					foreach($peg as $key => $val){					
						$returnVal["pegawai_id"][] = $val->pegawai_id;
					}
				}	
			}


			echo CJSON::encode(array(					
					'peg'=>$returnVal));
			
			 Yii::app()->end();
		}
	}
    
    /**
     * @author Deni Hamdani <denihamdani@piindonesia,co.id>
     * 
     * Submit penambahan lookup signa obat. Jika signa-nya sama dengan yang ada
     * di data lookup-nya, maka akan dibuat pesan peringatan bahwa signa obat
     * telah ada sebelumnya.
     */
    public function actionTambahSigna() {
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }
        $msg = "Signa berhasil ditambahkan";
        
        $signa = $_POST['signa'];
        
        $criteria = new CDbCriteria();
        $criteria->compare('lower(lookup_value)', strtolower($signa), true);
        $criteria->addCondition("lookup_type = 'signa_oa'");
        
        $dat = LookupM::model()->find($criteria);
        
        if (!empty($dat)) {
            $msg = "Signa sudah ditambahkan sebelumnya";
            goto i_json;
        }
        
        $dat = LookupM::model()->findByAttributes(array(
            'lookup_type'=>'signa_oa',
        ), array(
            'condition'=>'lookup_urutan is not null',
            'order'=>'lookup_urutan desc',
        ));
        
        $urutan = 1;
        if (!empty($dat) && !empty($dat->lookup_urutan)) {
            $urutan = $dat->lookup_urutan + 1;
        }
        
        $model = new LookupM;
        $model->lookup_type = 'signa_oa';
        $model->lookup_name = $model->lookup_value = $signa;
        $model->lookup_aktif = true;
        $model->lookup_urutan = $urutan;
        $model->create_time = date('Y-m-d H:i:s');
        $model->create_loginpemakai_id = Yii::app()->user->id;
        $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
        
        // print_r($model->attributes); die;
        
        if (!$model->save()) {
            $msg = "Signa gagal ditambahkan";
        }
        
        i_json:
            echo CJSON::encode(array('msg'=>$msg));
        
    }
    
    public function actionCekJurnalBelumPosting() {
        if (!Yii::app()->request->isAjaxRequest)
            Yii::app()->end();
        
        
        $periodeposting_id = $_POST['periode'];
        $periode = PeriodepostingM::model()->findByPk($periodeposting_id);
        
        $cr = new CDbCriteria();
        $cr->join = 'join jurnalrekening_t j on j.jurnalrekening_id = t.jurnalrekening_id';
        $cr->select = 't.jurnaldetail_id';
        $cr->addCondition('t.jurnalposting_id is null');
        //$cr->compare('j.rekperiod_id', $periode->rekperiode_id);
		$cr->addBetweenCondition('DATE(j.tglbuktijurnal)', $periode->tglperiodeposting_awal, $periode->tglperiodeposting_akhir);        
        
        $jurnal = JurnaldetailT::model()->find($cr);
        
        $ok = 1;
        
        if (!empty($jurnal)) {
            $ok = 0;
        };
        
        echo CJSON::encode(array('ok' => $ok));
        
    }
    
    public function actionCekPeriodeBelumClosing() {
        if (!Yii::app()->request->isAjaxRequest)
            Yii::app()->end();
        
        
        $rekperiod_id = $_POST['periode'];
        
        $period = RekperiodM::model()->findByPk($rekperiod_id);
        
        $cr = new CDbCriteria();
        $cr->addCondition("(sampaidgn::date < '".$period->perideawal."'::date and sampaidgn::date < '".$period->sampaidgn."'::date)");
        $cr->addCondition("isclosing = false and rekperiod_id <> ".$rekperiod_id);
        
        // echo "<pre>";
        // print_r($cr);
        // exit;
        $periode_lama = RekperiodM::model()->find($cr);
        
        // var_dump($periode_lama->attributes); die;
        
        $ok = 1;
        
        if (!empty($periode_lama)) $ok = 0;
        
        echo CJSON::encode(array('ok' => $ok));
    }
    
    public function actionCekJurnalBelumPostingAkun() {
        if (!Yii::app()->request->isAjaxRequest)
            Yii::app()->end();
        
        
        $rekperiod_id = $_POST['periode'];
        
        $cr = new CDbCriteria();
        $cr->join = 'join jurnalrekening_t j on j.jurnalrekening_id = t.jurnalrekening_id';
        $cr->select = 't.jurnaldetail_id';
        $cr->addCondition('t.jurnalposting_id is null');
		$cr->compare('j.rekperiod_id', $rekperiod_id);        
        
        $jurnal = JurnaldetailT::model()->find($cr);
        
        $ok = 1;
        
        if (!empty($jurnal)) {
            $ok = 0;
        };
        
        echo CJSON::encode(array('ok' => $ok));
        
    }
	
	public function actionCekJurnalBelumPostingByTanggal() {
        if (!Yii::app()->request->isAjaxRequest)
            Yii::app()->end();
                
		$tgl_awal = isset($_POST['tgl_awal'])? MyFormatter::formatDateTimeForDb($_POST['tgl_awal']):null;
		$tgl_akhir = isset($_POST['tgl_akhir'])?  MyFormatter::formatDateTimeForDb($_POST['tgl_akhir']):null;
		       
		$cr = new CDbCriteria();
		/*$cri->addCondition(" jurnalposting_id is null ");
		$cri->addBetweenCondition("DATE(tglbuktijurnal)", $tgl_awal, $tgl_akhir);
		$jurnal = InformasijurnaltransaksiV::model()->find($cri);*/
		//$cri
		$cr->join = 'join jurnalrekening_t j on j.jurnalrekening_id = t.jurnalrekening_id';
        $cr->select = 't.jurnaldetail_id';
        $cr->addCondition('t.jurnalposting_id is null');
		$cr->addBetweenCondition('DATE(j.tglbuktijurnal)', $tgl_awal, $tgl_akhir);        
		$cr->limit = 1;
        
        $jurnal = JurnaldetailT::model()->find($cr);
        
        $ok = 1;
        
        if (!empty($jurnal)) {
            $ok = 0;
        };
        
        echo CJSON::encode(array('ok' => $ok));
        
    }
	
	public function actionCekNoFaktur()
	{
		if(Yii::app()->getRequest()->getIsAjaxRequest()) {
			$fakturpembelian_id = isset($_POST['fakturpembelian_id'])?$_POST['fakturpembelian_id']:null;
			$nofaktur = isset($_POST['nofaktur'])?$_POST['nofaktur']:null;

			$faktur = FakturpembelianT::model()->findByPk($fakturpembelian_id);

			$criNo = new CDbCriteria();
			$criNo->addCondition(" nofaktur = '".$nofaktur."' ");
			$no = FakturpembelianT::model()->find($criNo);

			if ($faktur->nofaktur == $nofaktur){
				$st = 'ya';
			}else{
				if (empty($no)){
					$st = 'ya';
				}else{
					$st = 'tidak';
				}
			}

			$returnVal['boleh'] = $st;
			echo CJSON::encode($returnVal);
			Yii::app()->end();

		}                              
	}
	
	public function actionCekShift()
	{
		if(Yii::app()->getRequest()->getIsAjaxRequest()) {
			$shift_id = isset($_POST['shift_id'])?$_POST['shift_id']:null;			

			$shift = ShiftM::model()->findByPk($shift_id);

			$data['shift_jamawal'] = !empty($shift)?$shift->shift_jamawal:'';
			$data['shift_jamakhir'] = !empty($shift)?$shift->shift_jamakhir:'';
								
			echo CJSON::encode($data);
			Yii::app()->end();

		}                              
	}
    
    public function actionSetSatuanObat()
    {
        if(Yii::app()->request->isAjaxRequest) { 
            $obatalkes_id = isset($_POST['obatalkes_id']) ? $_POST['obatalkes_id'] : null;
            $form = "";
            $pesan = "";
			$satuankecil_nama="";
			$satuanterkecil_nama="";
            $format = new MyFormatter();
            $modObatAlkes = ObatalkesM::model()->findByPk($obatalkes_id);
            
            if(!empty($modObatAlkes)){
				$satuankecil_nama = isset($modObatAlkes->satuankecil) ? $modObatAlkes->satuankecil->satuankecil_nama : null;
				$satuanterkecil_nama = !empty($modObatAlkes->satuanterkecil) ? $modObatAlkes->satuanterkecil->satuankecil_nama : null;
            }else{
                $pesan = "Obat tidak mencukupi!";
            }
            
            echo CJSON::encode(array('form'=>$form, 'pesan'=>$pesan,
				'satuankecil'=>$satuankecil_nama,
				'satuanterkecil'=>$satuanterkecil_nama
			));
            Yii::app()->end(); 
        }
    }
    
    
    public function actionCariMenu(){
            if(Yii::app()->getRequest()->getIsAjaxRequest()) {
                
                $term = isset($_POST['term'])?$_POST['term']:null;
                        
                $criteria = new CDbCriteria();
                $criteria->join = "  LEFT JOIN kelompokmenu_k kelompokmenu ON kelompokmenu.kelmenu_id = t.kelmenu_id ";
                $criteria->compare('LOWER(t.menu_nama)',strtolower($term),true);
                $criteria->addCondition(" modul_id = '".Yii::app()->user->getState('modul_id')."' ");
                $criteria->addCondition('t.menu_aktif = true  ');
                $criteria->order = 'kelompokmenu.kelmenu_urutan, menu_urutan';
                $menu = MenumodulK::model()->findAll($criteria);
                $m = MenuModul::getMenuModulAdmin($menu);                                
                
                $menus=array();
                
                
                
                if(count((array)$menu)>0){
                    foreach ($m as $index => $arrMenu){		
                        if (count((array)$arrMenu['menus']) < 1){
                            $menus[] = array(
                                'label' => '<i class="'.$arrMenu['icon'].'"></i><span>'.$arrMenu['label'].'</span>',
                                'url' => !empty($arrMenu['url'])?$arrMenu['url']:'#',
                                'active' => $this->id=='competitorReport'?true:false,
                                );
                            
                        }else{
                            foreach ($arrMenu['menus'] as $i=>$menu) { 
                                $subRoute = strtolower($menu['url']['route']);
                                $pecahSub = explode('/',$subRoute);
                                if (isset($pecahSub[1])){
                                    $r = '/'.$pecahSub[1];
                                    $con = $pecahSub[1];
                                }else{
                                    $r = '';
                                    $con = '';
                                }
                                $modCon = $pecahSub[0].$r;

                                //$subActive1 = strtolower(Yii::app()->controller->module->id.'/'.Yii::app()->controller->id);
                                //$subActive2 = strtolower(Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/'.Yii::app()->controller->action->id);


                                if (!isset($ven[$con])){
                                    $result[]  = array(
                                                    'label' => '<i class="'.$menu['icon'].'"></i><span>'.$menu['label'].'</span>',
                                                    'url' => (!empty($menu['url']['route']))?Yii::app()->createUrl($menu['url']['route'],$menu['url']['params']):Yii::app()->createUrl('/comingsoon'),
                                                    'active' => true,
                                            );	
                                }else{
                                    if (Params::cekAkses(Yii::app()->user->getState('peranpengguna_id'))){
                                        $result[]  = array(
                                                'label' => '<i class="'.$menu['icon'].'"></i><span>'.$menu['label'].'</span>',
                                                'url' => (!empty($menu['url']['route']))?Yii::app()->createUrl($menu['url']['route'],$menu['url']['params']):Yii::app()->createUrl('/comingsoon'),
                                                'active' => true,
                                        );	
                                    }
                                }

                            }                         
                            $menus[] = array(
                                'label' => '<i class="fa '.$arrMenu['icon'].'"></i><span>'.$arrMenu['label'].'</span>',
                                'url' => '#',
                                'items' => $result
                            );

                            $result = array();
                        }
            }              
        } 
            
                $gen_menu = $this->renderPartial('application.views.layouts._genMenu',array('menus'=>$menus,'term'=>$term),true,false);
              
                
                $data['html'] = $gen_menu;

                echo json_encode($data);
                Yii::app()->end();
            }
        }
        
        public function actionTambahLookup(){
            if (Yii::app()->request->isAjaxRequest){
                
                $value = $_POST['value'];
                $type = $_POST['type'];
                $drop = '';
                
                $model = new LookupM;
                $ok = true;
                $pesan = '';
                $data = [];
                $trans = Yii::app()->db->beginTransaction();
                try{                    
                    $arr = [
                        'lookup_type' => $type,
                        'lookup_name' => $value,
                        'lookup_value' => $value
                    ];
                    $proses = LookupM::simpanData($model, $arr);
                    $pesan .= $proses['pesan'];
                    $ok &= $proses['sukses'];
                    $model = $proses['model'];

                    if ($ok){
                        $trans->commit();
                        
                        $look = LookupM::getItemsUrutan($type);
                        $drop .= '<option value="">-- Pilih --</option>';
                        foreach($look as $key => $val){
                            $drop .= '<option value="'.$key.'">'.$val.'</option>';
                        }                        
                    }else{
                        $trans->rollback();                        
                    }                                        
                }catch(Exception $e){
                    $pesan .= $e->getMessage();
                    $trans->rollback();
                    $ok = false;
                }
                
                
                
                $data = [
                    'infors' => $model->lookup_value,
                    'sukses' => ($ok)?1:0,
                    'pesan' => $pesan,
                    'drop' => $drop
                ];
                
                echo json_encode($data);
                Yii::app()->end();
            }
        }


        public function actionGetJenisWaktuForCheckBox() {
            if (Yii::app()->request->isAjaxRequest) {
    
                $cb = '';
                $waktu = JeniswaktuM::getJenisWaktu();
    
                foreach ($waktu as $i => $w) {
                    $cb .= CHtml::checkBox('dlg[' . $i . '][jeniswaktu_id]', false, array('value' => $w->jeniswaktu_id, 'class' => 'check_jeniswaktu')) . ' <label>' . $w->jeniswaktu_nama . '</label><br/>';
                }
                $data['sukses'] = 1;
                $data['checkbox'] = $cb;
                echo json_encode($data);
                Yii::app()->end();
            }
        }
        
        public function actionGetJenisWaktuForDrop() {
            if (Yii::app()->request->isAjaxRequest) {
    
                $drop = "<option value=''>-- Pilih --</option>";
                
                $waktu = JeniswaktuM::getJenisWaktu();
    
                foreach ($waktu as $i => $w) {
                    $drop .= "<option value='" . $w->jeniswaktu_id . "'>" . $w->jeniswaktu_nama . "</option>";
                }
                
                $data['sukses'] = 1;
                $data['drop'] = $drop;
                echo json_encode($data);
                Yii::app()->end();
            }
        }
}
?>

