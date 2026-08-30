<?php
if (isset($_GET['sukses'])) {
    Yii::app()->user->setFlash('success', "Data berhasil disimpan !");
}
?>
<?php $this->widget('bootstrap.widgets.BootAlert'); ?>

<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'permintaan-darah-pmi-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'renameDetail(); return requiredCheck(this);'),
    'focus' => '',
        ));
?>

<div class="panel panel-primary panel-gradient">
    <div class="panel-heading">
        <div class="panel-title"><strong>Permintaan Darah ke PMI</strong></div>
    </div>
    <div class="panel-body">
        <div class="panel panel-success panel-shadow">
            <div class="panel-heading">
                <div class="panel-title"><span class='judul'>Data Permintaan Darah</span></div>
            </div>
            <div class="panel-body">
                <div class="row-fluid">
                    <?php $this->renderPartial('_formPermintaan', array('form'=>$form,
                        'model'=>$model,
                        'modDetail'=>$modDetail)); 
                    ?>
                </div>
            </div>
        </div>
        <div class="panel panel-success panel-shadow">
            <div class="panel-heading">
                <div class="panel-title"><span class='judul'>Tabel Permintaan Darah</span></div>
            </div>
            <div class="panel-body">
                <div class="row-fluid" style="overflow: auto;">
                    <?php $this->renderPartial('_formDetail', array('form'=>$form,
                        'model'=>$model,
                        'modDetail'=>$modDetail,
                        'arrDetail'=>$arrDetail)); 
                    ?>
                </div>
            </div>
        </div>
        
        <div class="row-fluid">
            <div class="form-actions">
                <?php
                if(!isset($_GET['sukses'])){
                    echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('id'=>'btn_submit','class'=>'btn btn-primary submit', 'type'=>'submit'));
                    echo "&nbsp;";
                    echo CHtml::link(Yii::t('mds', '{icon} Cetak', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info', 'disabled'=>'true'));
                    echo "&nbsp;";
                }else{
                    echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('disabled'=>true,'id'=>'btn_submit','class'=>'btn btn-primary', 'type'=>'button','onkeypress'=>'formSubmit(this,event);'));
                    echo "&nbsp;";
                    echo CHtml::link(Yii::t('mds', '{icon} Cetak', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info','onclick'=>"myAlert('Comming Soon');return false"));
                    echo "&nbsp;";
                }
                echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                '#', 
                array('class'=>'btn btn-danger',
                    'onclick'=>'myConfirm("Apakah Anda yakin ingin mengulang ?","Perhatian!",function(r) {if(r) window.location = "'.$this->createUrl('index').'";} ); return false;'));
                echo "&nbsp;";
                $content = $this->renderPartial('laboratorium.views.pemakaianBahan.tips.tipsPemakaianBahan',array(),true);
                $this->widget('UserTips',array('type'=>'transaksi','content'=>$content));
                ?>
            </div>
        </div>
    </div>
</div>

<?php $this->endWidget(); ?>

<script>
    
    var row_detail = <?php echo CJSON::encode(array('html' => $this->renderPartial("_rowTabel", array('form'=>$form,'model'=>$model,'modDetail'=>$modDetail), true))); ?>;
    
    function tambahDetail(obj) {
        $("#tab_detail").append(row_detail.html);
        renameDetail();
        generatePicker();
        $("#tab_detail tr:last .integer").maskMoney(
            {"symbol":"","defaultZero":true,"allowZero":true,"decimal":",","thousands":"","precision":0}
        );
    }
    
    function hapusDetail(obj) {
        $(obj).parents("tr").remove();
    }
    
    function renameDetail() {
        var cnt = 0;
        $("#tab_detail > tr").each(function() {
            $(this).find(".row_num").html(cnt+1);
            $(this).find('input,select,textarea').each(function(){ //element <input>
                var old_name = $(this).attr("name").replace(/]/g,"");
                var old_name_arr = old_name.split("[");
                if(old_name_arr.length == 3){
                    $(this).attr("id",old_name_arr[0]+"_"+cnt+"_"+old_name_arr[2]);
                    $(this).attr("name",old_name_arr[0]+"["+cnt+"]["+old_name_arr[2]+"]");
                }
            });
            cnt++;
        });
    }
    
    function generatePicker(){
        jQuery('input[name$="[tgl_perlu]"]').datepicker(
            jQuery.extend(
                {
                    showMonthAfterYear:false
                }, 
                jQuery.datepicker.regional['id'],
                {
                    'dateFormat':'dd M yy',
                    'showSecond':false,
                    'timeOnlyTitle':'Pilih Waktu',
                    'timeFormat':'hh:mm:ss',
                    'changeYear':true,
                    'changeMonth':true,
                    'showAnim':'fold',
                    'yearRange':'-80y:+20y',
                }
            )
        );
        $('input[name$="[tgl_perlu]"]').each(function() {
            var obj = $(this);
            $(this).parent().find(".add-on").click(function() {
                $(obj).focus();
            });
        });
    }
    
    $(document).ready(function () {
        $('form').bind('click keyup select change', function (event) {
            cekDisabled(this);
        });
        $(document).on('click keyup select change', function () {
            cekDisabled('form');
        });

        cekDisabled('form');
        
        <?php if(isset($_GET['sukses'])){ ?>
            $('input,select,textarea').attr('disabled',true);
        <?php } ?>
    });
    
</script>