<?php

/**
 * This is the model class for table "tbl_client".
 *
 * The followings are the available columns in table 'tbl_client':
 * @property integer $id
 * @property string $name
 * @property integer $create_user_id
 * @property string $create_time
 * @property integer $update_user_id
 * @property string $update_time
 * @property integer $ad_1
 * @property integer $ad_2
 * @property integer $ad_3
 * @property integer $ad_4
 * @property integer $active
 *
 * The followings are the available model relations:
 * @property Upload $ad3
 * @property Upload $ad1
 * @property Upload $ad2
 * @property User $createUser
 * @property User $updateUser
 * @property Upload[] $uploads
 */
class Client extends MyActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_client';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, active', 'required'),
			array('create_user_id, update_user_id, ad_1, ad_2, ad_3, ad_4', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>64),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, create_user_id, create_time, update_user_id, update_time, ad_1, ad_2, ad_3, ad_4, active', 'safe', 'on'=>'search'),
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
                        'ad4' => array(self::BELONGS_TO, 'Upload', 'ad_4'),
			'ad3' => array(self::BELONGS_TO, 'Upload', 'ad_3'),
			'ad1' => array(self::BELONGS_TO, 'Upload', 'ad_1'),
			'ad2' => array(self::BELONGS_TO, 'Upload', 'ad_2'),
			'createUser' => array(self::BELONGS_TO, 'User', 'create_user_id'),
			'updateUser' => array(self::BELONGS_TO, 'User', 'update_user_id'),
			'uploads' => array(self::HAS_MANY, 'Upload', 'client_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Name',
			'create_user_id' => 'Create User',
			'create_time' => 'Create Time',
			'update_user_id' => 'Update User',
			'update_time' => 'Update Time',
			'ad_1' => 'Ad 1',
			'ad_2' => 'Ad 2',
			'ad_3' => 'Ad 3',
                        'ad_4' => 'Ad 4',
                        'active' => 'Active',
		);
	}
        
        public function scopes()
	{
		return array(
			'active'=>array(
                                'condition'=>'active = 1',
                        ),
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('create_user_id',$this->create_user_id);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_user_id',$this->update_user_id);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('ad_1',$this->ad_1);
		$criteria->compare('ad_2',$this->ad_2);
		$criteria->compare('ad_3',$this->ad_3);
                $criteria->compare('ad_4',$this->ad_4);
                $criteria->compare('active',$this->active);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Client the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public function beforeSave()
        {
            if(parent::beforeSave())
            {
                if($this->active == 1)
                {
                    $activeClients = Client::model()->findAll(array(
                        'condition'=>'active = 1'
                    ));

                    if(!empty($activeClients))
                    {
                        foreach($activeClients as $client)
                        {
                            $client->saveAttributes(array(
                                        'active'=>0,
                                ));
                        }
                    }
                }
                return true;
            }
        }
}
