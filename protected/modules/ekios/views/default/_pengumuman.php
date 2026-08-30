<style type="text/css">

.alert-info{
	background-color: transparent;
	border-color: transparent;
}

#ticker {
    height: 350px;
    overflow: hidden;
    padding-left: 31px;
    padding-top: 42px;
    width: 268px;
}

#tickerul {
	height: 400px;
	overflow: hidden;
	width: 230px;
}
#tickerul li {
	height: 400px;
	width: 230px;
}

#ticker div {
    height: 330px;
    margin: 2px;
    overflow: hidden;
}

</style>
<div><p></p><h3><center><a onclick="viewPengumuman();" href="javascript:void(0)"><p></p></center></h3></div>
<div id="ticker">
	<div class="alert alert-info" >
		<!-- <center><b><a href="javascript:void(0);" onclick="viewPengumuman('.$pengumuman->pengumuman_id.');">Pengumuman Statis</a></b></center>
		<br/> -->
		<!-- <span class="author-pengumuman">dibuat oleh sang admin 18 Juni 2013</span><br/>
		<br/><span class="author-pengumuman"></span><br/> -->
			<!-- Isi dari pengumuman statis -->
		<?php 
			//echo "Testing";
			
		?>

		<div id="tickerul">
		<?php
			$modPengumuman = Pengumuman::model()->findAll('status_publish > 0 ORDER BY create_time DESC');

			//echo "Testing";
			
			
			foreach ($modPengumuman as $kunci => $data) {
				echo '<li class="list-ticker"></a>
					  <center><b>';
					echo CHtml::Link($data->judul."<br>",Yii::app()->controller->createUrl("Default/ViewPengumuman",array("id"=>$data->pengumuman_id)),
		               array("class"=>"", 
		                     "target"=>"iframeViewPengumuman",
		                     "onclick"=>"$(\"#dialogViewPengumuman\").dialog(\"open\");",
		                     "rel"=>"tooltip",
		                     "title"=>"Klik untuk melihat detail pengumuman",
		               ));		  
				echo'</b>
					  <span class="author-pengumuman">Dibuat pada '.$data->create_time.'</span></center><hr>
					  <span class="author-pengumuman"></span>'.$data->isi;
				echo '</li>';
			}

			//exit;
		?>
		
			<!-- <li class="list-ticker">				
				<a href="http://workshop.rs/2009/12/jqbargraph-jquery-graph-plugin/">jqBarGraph</a> is jQuery plugin that gives you freedom to easily display your data as graphs. There are three types of graphs: simple, multi and stacked.is jQuery plugin that gives you freedom to easily display your data as graphs. There are three types of graphs: simple, multi and stacked.is jQuery plugin that gives you freedom to easily display your data as graphs. There are three types of graphs: simple, multi and stacked.
			</li>
			<li class="list-ticker">
				Learn how to create <a href="http://workshop.rs/2010/07/create-image-gallery-in-4-lines-of-jquery/">image gallery in 4 lines of Jquery</a>
			</li>
			<li>
				<a href="http://workshop.rs/2009/12/image-gallery-with-fancy-transitions-effects">jqFancyTransitions</a> is easy-to-use jQuery plugin for displaying your photos as slideshow with fancy transition effects.
			</li>
			<li class="list-ticker">
				<a href="http://workshop.rs/2010/02/moobargraph-ajax-graph-for-mootools/">mooBarGraph</a> is AJAX graph plugin for MooTools which support two types of graphs, simple bar and stacked bar graph.
			</li> -->
		</div>
	</div>
</div>
<?php 
// Dialog buat lihat menampilkan detail asuransi =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( 
    'id'=>'dialogViewPengumuman',
    'options'=>array(
        'title'=>'Detail Pengumuman',
        'autoOpen'=>false,
        'modal'=>true,
        'minWidth'=>800,
        'minHeight'=>400,
        'resizable'=>false,
        'close'=>'js:function(){$.fn.yiiGridView.update(\'pengumuman-m-grid\', {})}'
    ),
));
?>
<iframe src="" name="iframeViewPengumuman" width="100%" height="300px" >

</iframe>
<?php $this->endWidget(); ?>

<script>
	function tick(){
		$('#tickerul li:first').slideUp( function () { $(this).appendTo($('#tickerul')).slideDown(); });
	}
	setInterval(function(){ tick () }, 25000);


</script>