<?php Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/js/orgchart/jquery.orgchart.css'); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/orgchart/jquery-1.11.1.min.js'); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/orgchart/jquery.orgchart.js'); ?>
<style type="text/css">
	#orgChart{
		width: auto;
		height: auto;
	}

	#orgChartContainer{
		width: 1000px;
		height: auto;
		overflow: auto;
		background: #eeeeee;
	}
	.node{
		width: 250px !important;
		height: auto !important;
	}
</style>
	
<div id="orgChart"></div>

<script type="text/javascript">
<?php
echo "var data = [";
if(count((array)$modOrgAsal) > 0){	
	foreach($modOrgAsal AS $i => $asl){
		//$icon_edit = '<a href="'.$this->createUrl('update',array('id'=>$org->organigram_id,'from'=>'organigram')).'" onclick="ubahData(this); return false;" rel="tooltip" class="update" title="Ubah"><i class="icon-form-ubah"></i></a>';
		$icon_edit = "<a href='".$this->createUrl('update',array('id'=>$asl['organigram_id'],'from'=>'organigram'))."' onclick='ubahData(this); return false;' rel='tooltip' class='update' title='Ubah'><i class='icon-form-ubah'></i></a>";
		if(isset($_GET['caraPrint'])){
			$icon_edit = "";
		}
		/*echo "{id: ".$org->organigram_id.', name: "'
				.(isset($org->pegawai->jabatan->jabatan_nama) ? $org->pegawai->jabatan->jabatan_nama : $org->organigram_unitkerja)
			.$icon_edit
			."<br>".(!empty($org->pegawai_id) ? $org->pegawai->NamaLengkap : "-").'", parent: '.(empty($org->organigramasal_id) ? "0" : $org->organigramasal_id)."},\n";*/
		echo "{id: ".$asl['organigram_id'].', '
			. 'name:"'.$icon_edit.$asl['organigram_unitkerja']."<br>".$asl['nama_pegawai'].'",'
			. 'parent: '.(empty($asl['organigramasal_id']) ? "0" : $asl['organigramasal_id'])."},\n";
	}
	
}

if(count((array)$modOrg) > 0){	
	foreach($modOrg AS $i => $det){
		//$icon_edit = '<a href="'.$this->createUrl('update',array('id'=>$org->organigram_id,'from'=>'organigram')).'" onclick="ubahData(this); return false;" rel="tooltip" class="update" title="Ubah"><i class="icon-form-ubah"></i></a>';
		$org_id = null;
		$nama = $det['organigram_unitkerja']."<br><ol style='text-align:left';>";
		
		foreach($det['det'] as $j => $org){
			$org_id = $org['organigram_id'];
			$icon_edit = "<a href='".$this->createUrl('update',array('id'=>$org['organigram_id'],'from'=>'organigram'))."' onclick='ubahData(this); return false;' rel='tooltip' class='update' title='Ubah'><i class='icon-form-ubah'></i></a>";
			if(isset($_GET['caraPrint'])){
				$icon_edit = "";
			}
			/*echo "{id: ".$org->organigram_id.', name: "'
					.(isset($org->pegawai->jabatan->jabatan_nama) ? $org->pegawai->jabatan->jabatan_nama : $org->organigram_unitkerja)
				.$icon_edit
				."<br>".(!empty($org->pegawai_id) ? $org->pegawai->NamaLengkap : "-").'", parent: '.(empty($org->organigramasal_id) ? "0" : $org->organigramasal_id)."},\n";*/
			$nama .= "<li style='padding-bottom:10px;'> ".$icon_edit.$org['nama_pegawai']."</li>";
		}
		$nama .= '</ol>';
		
		echo "{id: ".$org_id.', '
			. 'name:"'.$nama.'",'
			. 'parent: '.(empty($det['organigramasal_id']) ? "0" : $det['organigramasal_id'])."},\n";
	}
	
}
echo " ];";
?>
	
$(function(){
	org_chart = $('#orgChart').orgChart({
		data: data,
		showControls: false,
		allowEdit: false,
		onAddNode: function(node){ 
			org_chart.newNode(node.data.id); 
		},
		onDeleteNode: function(node){
			org_chart.deleteNode(node.data.id); 
		},
		onClickNode: function(node){
		}

	});
});
/**
 * ubah data organigram
 * @param {type} obj
 * @returns {Boolean}
 */
function ubahData(obj){
	parent.window.location.href = obj.href;
	return false;
}

function printOrganigram(){
	window.open("<?php echo $this->createUrl('organigram'); ?>&caraPrint=PRINT","",'location=_new, width=900px');
}
</script>

<div class="form-actions">
	<?php 
	if(!isset($_GET['caraPrint'])){
		echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="entypo-print"></i>')),array('class' => 'btn btn-danger', 'type'=>'button','onclick'=>'printOrganigram()')); 
	}
	?>
</div>