	<div class="panel panel-primary panel-success">
		<div class="panel-heading">
			<div class="panel-title"> <i class="entypo-search"></i> Pencarian</div>
		</div>
		<div class="panel-body">
<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
	'action' => Yii::app()->createUrl($this->route),
	'method' => 'get',
	'type' => 'horizontal',
	'id' => 'searchLaporan',
	'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
		));
?>

<style>
	#cbBulan {
		overflow: auto;
	}
	
	#cbBulan div {
		width:100px;
        float:left;
	}
</style>

        <div class="row">
            <div class="col-sm-6">
                <div class="control-group">
                    <?php echo CHtml::label("Periode Laporan", 'tgl_rekam', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <div class="daterange daterange-inline add-ranges input-inline" style="width: 280px;" data-format="D MMMM YYYY" data-start-date="<?php echo date('d F Y', strtotime($model->tgl_awal)) ?>" data-end-date="<?php echo date('d F Y', strtotime($model->tgl_akhir)) ?>">
                            <i class="entypo-calendar"></i>
                            <span><?php echo date('d M Y', strtotime($model->tgl_awal)) ?> - <?php echo date('d M Y', strtotime($model->tgl_akhir)) ?></span>
                            <?php echo $form->hiddenField($model, 'tgl_awal', array('class' => 'start tgl_awal')) ?>
                            <?php echo $form->hiddenField($model, 'tgl_akhir', array('class' => 'end tgl_akhir')) ?>
                        </div>
                </div>
        </div>
	</div>
</div>

<div class="form-actions">
	<?php
                echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')), 
                array('class' => 'btn btn-primary', 'type' => 'button', 'id' => 'btn_simpan', 'onclick'=>'cekPencarian();'));?>
	<?php
	echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="'.MyIcon::getIcons('ulang').'"></i>')), $this->createUrl($this->id . '/Index'), array('class' => 'btn btn-danger',
		'onclick' => 'return refreshForm(this);'));
	
	echo $this->renderPartial('akuntansi.views.laporanAkuntansi/_tombolPrinoutNonGrafik',true);
	?>
</div>
<?php
$this->endWidget();
?>
<script>
	function cekPencarian() {
        
        var tgl_awal = $(".tgl_awal").val();
        var tgl_akhir = $(".tgl_akhir").val();
        
		$.post('<?php echo Yii::app()->createUrl('/actionAjax/cekJurnalBelumPostingByTanggal')?>', {tgl_awal: tgl_awal, tgl_akhir: tgl_akhir}, function(data) {
			if (data.ok == 1) $("#searchLaporan").submit();
			else {
				myConfirm("Masih ada jurnal yang belum diposting. Apakah Anda akan melanjutkan?", "Perhatian", function(r) {
					if (r) {
						$("#searchLaporan").submit();
					}
				});
			}
		}, 'json');
	}
	
	function pilihSemuaBulan() {
		if ($("#pilihSemua").is(':checked')) {
			$("#cbBulan").find("input[type=\'checkbox\']").attr("checked", "checked");
		} else {
			$("#cbBulan").find("input[type=\'checkbox\']").attr("checked", false);
		}
	}
    
    function pilihSemuaSegmen() {
		if ($("#pilihSemuaSg").is(':checked')) {
			$("#cbSegmen").find("input[type=\'checkbox\']").attr("checked", "checked");
		} else {
			$("#cbSegmen").find("input[type=\'checkbox\']").attr("checked", false);
		}
	}
	$(document).ready(function(){
        <?php if (isset($_GET['caraPrint'])) { ?>
            
        <?php } else { ?>
            $("#pilihSemuaSg").attr('checked', "checked");
            pilihSemuaSegmen();
        <?php } ?>
    });
    pilihSemuaBulan();
</script>
		</div>
	</div>