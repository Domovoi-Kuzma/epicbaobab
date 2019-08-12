<?php
/**
 * Created by PhpStorm.
 * User: Sasha
 * Date: 08.08.2019
 * Time: 13:44
 */
/**
 * Class ModelInsertForm
 *
 * модель для запроса данных, которые отображаются на форме добавления сотрудника/встречи
 * (это одна форма, модель подкидывает в неё различные параметры в зависимости от...)
 * запрашивается пока только список из опций (список встреч для создания сотр.)/(список сотр. для создания встречи)
 * плюс класс подкидывает некоторые строки типа "список встреч" для отображения в заголовке страницы
 *
 * отображается на viewInsertForm.php
 */
class ModelInsertForm extends  CFormModel
{
    /**
     * @var string $name
     * текстовое поле на форме.
     */
    public $name;
    /**
     * @var string $title
     * заголовок страницы в окне браузера
     */
    public $title;
    /**
     * @var string $buttonAction
     * действие в кнопке Submit
     */
    public $buttonAction;
    /**
     * @var string $dbtable
     * таблица, из которой берётся список (например встреч для выставления отношений у нового сотрудника)
     */
    public $dbtable;
    /**
     * @var string $buddyField
     * название колонки из $dbtable с именами, из которой берётся список
     */
    public $buddyField;
    /**
     * @var string
     * текст, добавляемый перед именем например "сотрудник " если в списке "сотрудник Иванов"
     */
    public $prefix;
    /**
     * @var array $options SQL query result
     */
    public $options;

    /**
     * ModelInsertForm constructor.
     * @param $title  инициализация текста в заголовке формы
     * @param $what   опция либо 'employees' для работы со страницей сотрудников,
     *                      либо 'meets' для работы со страницей встреч,
     */
    function __construct($title, $what)
    {
        $this->title = $title;

        if ($what == 'employees')
        {
            $this->dbtable = 'meets';//editing employee requires list of meetings
            $this->buddyField = 'Meeting';
            $this->prefix = 'совещание ';
            $this->buttonAction = 'site/insert_employees';
        }
        else//if ($what == 'meets')
        {
            $this->dbtable = 'people';//editing employee requires list of people (to show in checkbox)
            $this->buddyField = 'Name';
            $this->prefix = 'коллега ';
            $this->buttonAction = 'site/insert_meets';
        }
    }

    /**
     * QueryNames
     * выполняет запрос к БД списка пунктов для отображения в списке чекбоксов для выставления отношений у нового сотрудника
     */
    public function QueryNames(){
        $sql = "SELECT * FROM $this->dbtable";
        $nameslist = Yii::app()->db->createCommand($sql)->queryAll();
        foreach( $nameslist as $optionalName)
            $this->options[$optionalName["ID"]] = $this->prefix.$optionalName[$this->buddyField];

    }
}