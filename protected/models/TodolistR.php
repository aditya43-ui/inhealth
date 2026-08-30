<?php

/**
 * This is the model class for table "todolist_r".
 *
 * The followings are the available columns in table 'todolist_r':
 * @property integer $todolist_id
 * @property string $tgltodolist
 * @property string $todolist_nama
 * @property boolean $todolist_aktif
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan_id
 * @property integer $create_modul_id
 */
class TodolistR extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TodolistR the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'todolist_r';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tgltodolist, todolist_nama, todolist_aktif, create_time, create_loginpemakai_id, create_ruangan_id, create_modul_id', 'required'),
			array('create_loginpemakai_id, update_loginpemakai_id, create_ruangan_id, create_modul_id', 'numerical', 'integerOnly'=>true),
			array('todolist_nama', 'length', 'max'=>300),
			array('update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('todolist_id, tgltodolist, todolist_nama, todolist_aktif, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan_id, create_modul_id', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
                    'userCreate'=>array(self::BELONGS_TO,  'LoginpemakaiK','create_loginpemakai_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'todolist_id' => 'Todolist',
			'tgltodolist' => 'Due Date',
			'todolist_nama' => 'Nama Todolist',
			'todolist_aktif' => 'Aktif',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan_id' => 'Create Ruangan',
			'create_modul_id' => 'Create Modul',
                        'tgltodolist_new' => 'Due Date',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CdbCriteria that can return criterias.
	 */
	public function criteriaSearch()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('todolist_id',$this->todolist_id);
		$criteria->compare('LOWER(tgltodolist)',strtolower($this->tgltodolist),true);
		$criteria->compare('LOWER(todolist_nama)',strtolower($this->todolist_nama),true);
		$criteria->compare('todolist_aktif',$this->todolist_aktif);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id);
		$criteria->compare('create_ruangan_id',$this->create_ruangan_id);
		$criteria->compare('create_modul_id',$this->create_modul_id);

		return $criteria;
	}
        
        
    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria=$this->criteriaSearch();
        $criteria->limit=10;

        return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
        ));
    }


    public function searchPrint()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria=$this->criteriaSearch();
        $criteria->limit=-1; 

        return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
                'pagination'=>false,
        ));
    }
}