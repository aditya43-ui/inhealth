<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">Master <b>Jenis Gerak Dasar</b></div>
    </div>
    <div class="panel-body">
      <?php
        Yii::app()->clientScript->registerScript('search', "
        $('.search-button').click(function(){
                $('.search-form').toggle();
                return false;
        });
        $('#jenisgerakdasar-m-search').submit(function(){
                $.fn.yiiGridView.update('jenisgerakdasar-m-grid', {
                        data: $(this).serialize()
                });
                return false;
        });
        ");

        $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="icon-accordion icon-white"></i>')),'#',array('class'=>'search-button btn')); ?>
        <div class="cari-lanjut3 search-form" style="display:none">
            <?php $this->renderPartial($this->path_view.'_search',array(
                    'model'=>$model,
            )); ?>
        </div><!-- search-form -->
        <br /><br />
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">Tabel <b>Jenis Gerak Dasar</b></div>
            </div>
            <div class="panel-body">
              <?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
                  'id'=>'jenisgerakdasar-m-grid',
                  'dataProvider'=>$model->search(),
                  // 'filter'=>false,
                  'template'=>"{summary}\n{items}\n{pager}",
                  'itemsCssClass'=>'table table-striped table-bordered table-condensed',
                  'columns'=>array(
                    array(
                            'header'=>'No',
                            'type'=>'raw',
                            'value'=>'$row+1',
                            'filter'=>false,
                    ),
                    array(
                        'header'=>'Pemeriksaan Fisik Gerak Dasar',
                        'type'=>'raw',
                        'value'=>'(isset($data->periksafungsigerakdasar)?$data->periksafungsigerakdasar->periksafungsigerakdasar_nama:"")',
                        'filter'=>false,
                    ),
                    array(
                        'header'=>'Nama Pemeriksaan',
                        'type'=>'raw',
                        'value'=>'$data->fungsigerakdasarsinistra_nama',
                        'filter'=>false,
                    ),
                    array(
                        'header'=>'Nama Lainnya',
                        'type'=>'raw',
                        'value'=>'$data->fungsigerakdasarsinistra_namalainnya',
                        'filter'=>false,
                    ),
                    array(
                        'header'=>'Urutan',
                        'type'=>'raw',
                        'value'=>'$data->fungsigerakdasarsinistra_urutan',
                        'filter'=>false,
                    ),
                    array(
                        'header'=>'<center>Status</center>',
                        'type'=>'raw',
                        'value'=>'($data->fungsigerakdasarsinistra_aktif == 1) ? "Aktif" : "Tidak Aktif"',
                        'htmlOptions'=>array('style'=>'text-align:center;'),
                    ),
                    array(
                        'header'=>Yii::t('zii','View'),
                        'class'=>'bootstrap.widgets.BootButtonColumn',
                        'template'=>'{view}',
                        'buttons'=>array(
                            'view' => array(
                                'options'=>array('rel' => 'tooltip' , 'title'=> 'Lihat Pemeriksaan MMT'),
                              ),
                         ),
                    ),
                    array(
                      'header'=>Yii::t('zii','Update'),
                      'class'=>'bootstrap.widgets.BootButtonColumn',
                      'template'=>'{update}',
                      'buttons'=>array(
                          'update' => array (
                              // 'visible'=>'Yii::app()->controller->checkAccess(array("action"=>Params::DEFAULT_UPDATE))',
                              'options'=>array('rel' => 'tooltip' , 'title'=> 'Ubah Pemeriksaan MMT'),
                            ),
                       ),
                    ),
                  array(
                      'header'=>'Hapus',
                      'type'=>'raw',
                      'value'=>'($data->fungsigerakdasarsinistra_aktif)?CHtml::link("<i class=\'icon-form-silang\'></i> ","javascript:removeTemporary($data->fungsigerakdasarsinistra_id)",array("id"=>"$data->fungsigerakdasarsinistra_id","rel"=>"tooltip","title"=>"Menonaktifkan Jenis Gerak Dasar"))." ".CHtml::link("<i class=\'icon-form-sampah\'></i> ", "javascript:deleteRecord($data->fungsigerakdasarsinistra_id)",array("id"=>"$data->fungsigerakdasarsinistra_id","rel"=>"tooltip","title"=>"Hapus Jenis Gerak Dasar")):CHtml::link("<i class=\'icon-form-sampah\'></i> ", "javascript:deleteRecord($data->fungsigerakdasarsinistra_id)",array("id"=>"$data->fungsigerakdasarsinistra_id","rel"=>"tooltip","title"=>"Hapus Jenis Gerak Dasar"));',
                      'htmlOptions'=>array('style'=>'text-align: center; width:80px'),
                  ),
                ),
                'afterAjaxUpdate'=>'function(id, data){
                    jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});
                    $("table").find("input[type=text]").each(function(){
                        cekForm(this);
                    })
                    $("table").find("select").each(function(){
                        cekForm(this);
                    })
                }',
              )); ?>
            </div>
        </div>

        <?php
        echo CHtml::link(Yii::t('mds', '{icon} Tambah Pemeriksaan', array('{icon}'=>'<i class="icon-plus icon-white"></i>')), $this->createUrl('FungsiGerakDasarSinistraM/create',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'))."&nbsp&nbsp";
        echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="icon-book icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PDF\')'))."&nbsp&nbsp";
        echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'EXCEL\')'))."&nbsp&nbsp";
        echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="entypo-print"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PRINT\')'))."&nbsp&nbsp";
        $content = $this->renderPartial('../tips/master',array(),true);
        $this->widget('UserTips',array('type'=>'transaksi','content'=>$content));
        ?>
    </div>
  </div>
<?php
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/print');
// $url=  Yii::app()->createAbsoluteUrl(Yii::app()->controller->module->id.'/'.Yii::app()->controller->id);

$js = <<< JSCRIPT
function cekForm(obj)
{
    $("#jenisgerakdasar-m-search :input[name='"+ obj.name +"']").val(obj.value);
}
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#jenisgerakdasar-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);
?>
  <script type="text/javascript">
      function removeTemporary(id){
          var url = '<?php echo Yii::app()->createAbsoluteUrl(Yii::app()->controller->module->id.'/'.Yii::app()->controller->id."/removeTemporary"); ?>';
          var answer = confirm('Yakin akan menonaktifkan data ini untuk sementara?');
              if (answer){
                   $.post(url, {id: id},
                       function(data){
                          if(data.status == 'proses_form'){
                                  $.fn.yiiGridView.update('jenisgerakdasar-m-grid');
                              }else{
                                  myAlert('Data Gagal di Nonaktifkan')
                              }
                  },"json");
             }
      }

      function deleteRecord(id){
          var id = id;
          var url = '<?php echo Yii::app()->createAbsoluteUrl(Yii::app()->controller->module->id.'/'.Yii::app()->controller->id."/delete"); ?>';
          var answer = confirm('Yakin Akan Menghapus Data ini ?');
              if (answer){
                   $.post(url, {id: id},
                       function(data){
                          if(data.status == 'proses_form'){
                                  $.fn.yiiGridView.update('jenisgerakdasar-m-grid');
                              }else{
                                  myAlert('Data Gagal di Hapus')
                              }
                  },"json");
             }
      }
  </script>
