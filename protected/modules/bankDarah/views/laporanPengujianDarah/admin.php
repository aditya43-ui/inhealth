<?php
/**
* - digunakan sebagai Laporan Pengujian Darah
* @author : Elham Budianto & Yusuf Putra
* @email : elhambudianto1@gmail.com
* @wiki : ..
**/
?>
<?php
$this->breadcrumbs=array(
    'Laporan BOR'    
);

$url = Yii::app()->createUrl('bankDarah/laporanPengujianDarah/frameGrafikPengujian&id=1');
 
 Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
            $('.search-form').toggle();
            return false;
    });
    $('#penilaian-indikator-m-search').submit(function(){
            $.fn.yiiGridView.update('penilaianiki-indikator-m-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");
        $this->widget('bootstrap.widgets.BootAlert');
        //$this->renderPartial('_tabMenu',array());


Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/dropdownMulti.js', CClientScript::POS_END); 
?>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary panel-gradient">
            <div class="panel-heading">
                <div class="panel-title">Laporan <strong>Pengujian Konfirmasi Golongan Darah</strong></div>
            </div>
            <div class="panel-body">
                <div class="panel panel-success panel-shadow">
                    <div class="panel-heading">
                        <div class="panel-title"><i class="entypo-search"></i> Pencarian</div>
                    </div>
                    <div class="panel-body search-form">
                        <?php $this->renderPartial('_search',array(
                                'model'=>$model,
                            )); 
                        ?>

                    </div>
                </div>								
                <div class="panel panel-success panel-shadow">
                    <div class="panel-heading">
                        <div class="panel-title">Tabel <strong>Uji Konfirmasi Golongan Darah ABO & Rhesus Donor</strong></div>
                    </div>
                    <div class="panel-body overflow-x" >
                        
                                <?php $this->renderPartial('_table', array('model'=>$model)); ?>
                        
                    </div>
                </div>
                <!--
                <div class="panel panel-success panel-shadow">
                    <div class="panel-heading">
                        <div class="panel-title">Grafik</div>
                    </div>
                    <div class="panel-body">
                        <div class="block-tabel">
                                <?php //$this->renderPartial('_tab'); ?>
                                <iframe class="biru" src="" id="Grafik" width="100%" height='0'  onload="javascript:resizeIframe(this);">
                                </iframe>        
                        </div>
                    </div>
                </div>	
                -->
                <?php
               
                echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="icon-book icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PDF\')'))."&nbsp&nbsp"; 
                echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'EXCEL\')'))."&nbsp&nbsp"; 
                echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PRINT\')'))."&nbsp&nbsp"; 
                $content = $this->renderPartial('../tips/master',array(),true);
                $this->widget('UserTips',array('type'=>'transaksi','content'=>$content));
                $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
                $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
                $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/print');
            ?>
<?php
$js = <<< JSCRIPT
        function cekForm(obj)
{
    $("#penilaian-indikator-m-search :input[name='"+ obj.name +"']").val(obj.value);
}
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#penilaian-indikator-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);                        
?>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
   function Pencarian() {
     var data = $('#searchLaporan').serialize();
     console.log(data);
    $('#table-laporan').addClass("animation-loading");
    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('getLaporan'); ?>',
        data: {data:data},
        dataType: "json",
        success:function(data){
            $("#table-laporan tbody tr").remove(); 
            $('#table-laporan> tbody').append(data);
            $('#table-laporan').removeClass("animation-loading");
            //renameInputRowBarang($("#table-laporan"));
        },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    });
    }
    function listRuangan(idInstalasi)
    {
        console.log(idInstalasi);
    $.get("<?php echo Yii::app()->createUrl('actionDynamic/SetDropdownRuangannew'); ?>", { instalasasi:idInstalasi },
        function(data){
           
            $('#BDLaporanPengujianDarah_asalruangan_id').html(data.listRuangan);
    }, "json");
    }
</script>
