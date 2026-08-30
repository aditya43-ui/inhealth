<?php
class ASEvaluasiaskepdetT extends EvaluasiaskepdetT
{
	
	public $isdiagnosa,$diagnosakep_nama;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'evaluasiaskepdet_id' => 'ID',
			'diagnosakep_id' => 'Diagnosa',
			'evaluasiaskep_id' => 'Evaluasi',
			'evaluasiaskepdet_subjektif' => 'Subjektif',
			'evaluasiaskepdet_objektif' => 'Objektif',
			'evaluasiaskepdet_assessment' => 'Assessment',
			'evaluasiaskepdet_planning' => 'Planning',
			'evaluasiaskepdet_hasil' => 'Hasil',
		);
	}
}