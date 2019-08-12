<?php

/**
 * Class ModelInsertForm
 *
 * модель для запроса данных, которые отображаются на форме добавления сотрудника/встречи
 * (это одна форма, модель подкидывает в неё различные параметры в зависимости от...)
 * запрашивается пока только список из опций (список встреч для создания сотр.)/(список сотр. для создания встречи)
 * плюс класс подкидывает некоторые строки типа "список встреч" для отображения в заголовке страницы
 *
 */
class ModelInsertForm extends  CFormModel
{
    public $name;           //текстовое поле на форме.
    public $title;          //заголовок страницы в окне браузера
    public $formtitle;      //текст в теге <h1> на странице
    public $buttonAction;   //действие в кнопке Submit

    public $dbtable;        //таблица, из которой берётся список (например сотрудников)
    public $buddyField;     //название её колонки с именами, из которой берётся список
    public $prefix;         //текст, добавляемый перед именем например "сотрудник " если в списке "сотрудник Иванов"

    public $options;        //SQL query result

    /**
     * ModelInsertForm constructor.
     * @param $title
     * @param $what
     */
    function __construct($title, $what)
    {
        $this->title = $title;

        if ($what == 'employees')
        {
            $this->formtitle='сотрудника';
            $this->dbtable = 'meets';//editing employee requires list of meetings
            $this->buddyField = 'Meeting';
            $this->prefix = 'совещание ';
            $this->buttonAction = 'site/insert_employees';
        }
        else//if ($what == 'meets')
        {
            $this->formtitle='совещания';
            $this->dbtable = 'people';//editing employee requires list of meetings
            $this->buddyField = 'Name';
            $this->prefix = 'коллега ';
            $this->buttonAction = 'site/insert_meets';
        }
    }

    public function attributeNames(){
        return array();
    }

    public function QueryNames(){
        $sql = "SELECT * FROM $this->dbtable";
        $nameslist = Yii::app()->db->createCommand($sql)->queryAll();
        foreach( $nameslist as $optionalName)
            $this->options[$optionalName["ID"]] = $this->prefix.$optionalName[$this->buddyField];

    }
}