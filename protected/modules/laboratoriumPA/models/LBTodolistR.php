<?php

class LBTodolistR extends TodolistR
{
    public $durasi, $tgltodolist_new;

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}


	public function criteriaSearch()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		if(!empty($this->todolist_id)){
			$criteria->addCondition("todolist_id = ".$this->todolist_id); 			
		}
		$criteria->addCondition('DATE(tgltodolist) >=\''.date('Y-m-d H:m:s').'\'');
		$criteria->compare('LOWER(todolist_nama)',strtolower($this->todolist_nama),true);
		$criteria->compare('todolist_aktif',$this->todolist_aktif);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->addCondition('create_loginpemakai_id = '.Yii::app()->user->id);
		if(!empty($this->update_loginpemakai_id)){
			$criteria->addCondition('update_loginpemakai_id = '.$this->update_loginpemakai_id);
		}
		$criteria->addCondition('create_ruangan_id = '.Yii::app()->user->getState('ruangan_id'));
		$criteria->addCondition('create_modul_id = '.Yii::app()->session['modul_id']);
		$criteria->order = 'tgltodolist';

		return $criteria;
	}
        
        
    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function searchTodolistWidget()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria=$this->criteriaSearch();
        $criteria->limit=5;

        return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
        ));
    }

}