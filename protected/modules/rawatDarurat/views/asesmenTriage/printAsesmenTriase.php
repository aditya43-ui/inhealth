<?php
/**
* - digunakan untuk menampilkan prinout asesmen triage
* 
* @author       M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
* @website      <piindonesia.co.id>
 *@wiki         <https://piiproject.atlassian.net/wiki/display/MDO>
*/
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/prinout.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/themes/neon18/assets/css/custom.css');

echo $this->renderPartial('application.views.headerReport.headerDefault',array('judulLaporan'=>$judulLaporan, 'colspan'=>10));      
?>
<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'rjanamnesa-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
    'focus' => '#RJAnamnesaT_keluhanutama_annoninput .maininput',
));
?>
<table class="table border">
    <tr>
        <td colspan="4">
             <div class="control-group">

                    <label class="control-label" style="width:100%;text-align: left;">
                        <?php echo $form->checkBox($modAsesTriase,'trauma',array('onchange'=>'cekTrauma(this);','val'=>'trauma')) ?> Trauma &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  
                        <?php echo $form->checkBox($modAsesTriase,'nontrauma',array('onchange'=>'cekTrauma(this);','val'=>'nontrauma')) ?> Non Trauma                            
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <?php echo $form->checkBox($modAsesTriase,'isobstetri') ?> Obstetri
                  </label>
            </div>             
        </td>
    </tr>    
</table>

<?php echo $this->renderPartial($this->path_view.'print._printformTriase',array('modLookup'=>$modLookup,'dataTriase'=>$dataTriase,'form'=>$form,'modAsesTriase'=>$modAsesTriase,'modAsesTriDet'=>$modAsesTriDet,'getTriase'=>$getTriase),true); ?>

<?php echo $this->renderPartial($this->path_view.'print._printformNyeri',array('modFisik'=>$modFisik,'form'=>$form),true); ?>                                                    

<?php echo $this->renderPartial($this->path_view.'print._printformResikoJatuh',array('modFisik'=>$modFisik,'form'=>$form),true); ?>                                                    

<table class="table noborder" id="petugas_triase">
        <thead>
            <tr>
                <th colspan="3">Petugas Triase</th>
            </tr>
        </thead>
        <tbody>
            <?php
                echo "<tr>";
                
                $cekPeg = RDAsesmentriasepegT::model()->findByAttributes(array('asesmentriase_id'=>$modAsesTriase->asesmentriase_id));
                if (empty($cekPeg)){
                    echo '';
                }else{
                    $i = 1;
                    foreach ($modTriPeg as $detPeg){
                        $peg = PegawaiM::model()->findByPk($detPeg->pegawai_id);
                        
                        echo "<td>".(!empty($peg)?$peg->namaLengkap:'')."</td>";
                        
                        if ($i % 3 == 0){
                            echo "</tr>";
                            if ($i != count((array)$modTriPeg)){
                                echo "<tr>";
                            }else{
                                echo "</tr>";
                            }
                        }else{
                            if ($i == count((array)$modTriPeg)){
                                echo "</tr>";
                            }
                        }
                        
                        $i++;
                    }
                }
                echo "</tr>";
                
                $modTriPeg = new RDAsesmentriasepegT;
            ?>
        </tbody>        
    </table>
<?php $this->endWidget(); ?>

<table style="width: 100%; border: none;">
    <tr>
        <td colspan="9">&nbsp;</td>
    </tr>
    <tr>
        <td colspan="3" align="center" valign="middle">Pasien / Keluarga pasien</td>
        <td colspan="3"></td>
        <td colspan="3" align="center" valign="middle"><?php echo Yii::app()->user->getState('kabupaten_nama').", ".MyFormatter::formatDateTimeId(date('Y-m-d',strtotime($modAsesTriase->tglasesmentriase))); ?><br>Dokter Pemeriksa</td>
    </tr>
    <tr>
        <td colspan="9">&nbsp;</td>
    </tr>
    <tr>
        <td colspan="9">&nbsp;</td>
    </tr>
    <tr>
        <td colspan="9">&nbsp;</td>
    </tr>
    <tr>
        <td colspan="3" align="center" valign="middle"></td>
        <td colspan="3"></td>
        <td colspan="3" align="center" valign="middle"><?php echo (isset($modPendaftaran->pegawai->gelardepan)?$modPendaftaran->pegawai->gelardepan:'').' '.$modPendaftaran->pegawai->nama_pegawai.' '.(isset($modPendaftaran->pegawai->gelarbelakang_nama)?$modPendaftaran->pegawai->gelarbelakang_nama:''); ?></td>
    </tr>

</table>
