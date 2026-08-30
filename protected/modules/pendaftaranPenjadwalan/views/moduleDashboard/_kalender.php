<div class="row">
<?php
$array = array();
foreach ($modTodolist as $i => $todoList) {
	$array[] = array('title'=>$todoList->todolist_nama,
				'start'=>$todoList->tgltodolist,
				'color'=>($todoList->todolist_aktif==true)?'#6698D1':'#81D166',
				'allDay'=>true,
				'url'=>'javascript:void(0);'
				);
}
foreach ($modPengumumanKalender as $b => $pengumuman) {
	$array[] = array('title'=>$pengumuman->judul,
				'start'=>  MyFormatter::formatDateTimeForDb($pengumuman->create_time),
				'color'=>'#40D67F',
				'allDay'=>true,
				'url'=>'javascript:void(0);'
				);
}
$this->widget('ext.EFullCalendar.EFullCalendar', array(
						    // FullCalendar's options.
						    // Documentation available at
						    // http://arshaw.com/fullcalendar/docs/
						    'options'=>array(
						        'header'=>array(
						            'left'=>'prev,next',
						            'center'=>'title',
						            'right'=>'today'
						        ),
						        'lazyFetching'=>true,
						        'events'=>$array
    						),
						    'htmlOptions'=>array(
						        // you can scale it down as well, try 80%
						        // 'style'=>'background:none',
						        'class'=> 'span12'
						    ),
));
?>
</div>