<?php

/**
 * This is the model class for table "user".
 *
 * The followings are the available columns in table 'user':
 * @property integer $ID
 * @property string $username
 * @property string $password
 * @property string $profile
 */
class User extends CActiveRecord
{
    /**
     * Сохраняет параметры $_POST в модель и в БД
     * @return bool успешность сохранения
     * @author  Sasha
     * @data    09.09.2019
     */
	public function saveAs()
	{
		$this->username=(isset($_POST['username']))?$_POST['username']:'';
		$this->profile =(isset($_POST['profile'])) ?$_POST['profile'] :'';
        if (!empty($_POST['password'])) {
            $this->hashPassword($_POST['password']);
        }
        return $this->save();
	}
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'user';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('username, password', 'length', 'max'=>255),
			array('profile', 'length', 'max'=>6),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('ID, username, password, profile', 'safe', 'on'=>'search'),
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
            'likes' => array(self::HAS_MANY, 'Like', 'user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'ID' => 'ID',
			'username' => 'Username',
			'password' => 'Password',
			'profile' => 'Profile',
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

		$criteria->compare('ID',$this->ID);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('profile',$this->profile,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}


	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return User the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	/**
	 * Checks if the given password is correct.
	 * @param string $password the password to be validated
	 * @return boolean whether the password is valid
	 */
	public function validatePassword($password)
	{
		return CPasswordHelper::verifyPassword($password,$this->password);
	}

    /**
     * Более подходящий для моей формы вариант getErrors()
     * возможно найду ему замену в std методах yii
     * @return string message
     * @author  Sasha
     * @date    05.09.2019
     */
	public function getAllErrors() {
        $source=$this->getErrors();
        $logstr="";
        foreach($source as $property) {
            foreach ($property as $unfitness)
                $logstr .= $unfitness . ", ";
        }
        return $logstr;
    }

	/**
	 * Generates the password hash.
	 * @param string $password
	 * @return string hash
	 */
	public function hashPassword($password)
	{
        $this->password=CPasswordHelper::hashPassword($password);
	}
}
