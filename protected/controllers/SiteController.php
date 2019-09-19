<?php
/**
 * Created by PhpStorm.
 */
/**
 * Class SiteController
 */
class SiteController extends Controller
{
    /**
     * Declares class-based actions.
     */
    public function actions()
    {
        return array(
            // captcha action renders the CAPTCHA image displayed on the contact page
            'captcha'=>array(
                'class'=>'CCaptchaAction',
                'backColor'=>0xFFFFFF,
            ),
            // page action renders "static" pages stored under 'protected/views/site/pages'
            // They can be accessed via: index.php?r=site/page&view=FileName
            'page'=>array(
                'class'=>'CViewAction',
            ),
        );
    }
    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */
    public function actionIndex()
    {
        // renders the view file 'protected/views/site/index.php'
        // using the default layout 'protected/views/layouts/main.php'
        $this->render('index');
    }
    /**
     * This is the action to handle external exceptions.
     */
    public function actionError()
    {
        if ($error=Yii::app()->errorHandler->error){
            if (Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error', $error);
        }
    }
    /**
     * Вывод списка сотрудников
     * @author  Sasha
     * @data    21.08.2019
     */
    public function actionEmployees()
    {
        $this->render('viewEmployees',array('employees'=>People::model()->findAll()));
    }
    /**
     * Вывод списка встреч
     * @author  Sasha
     * @data    21.08.2019
     */
    public function actionMeeting()
    {
        $this->render('viewMeetings',array('meetings'=>Meets::model()->findAll()));
    }
    /**
     * AJAX сценарий, вызываемый, когда пользователь нажимает по лайку/дизлайку
     * @param integer $id ключ лайкнутой встречи.
     * @author  Sasha
     * @data    04.09.2019
     */
    public function actionToggleLike($meeting_id)
    {
        Like::Toggle($meeting_id);
        $this->renderPartial('viewLikeButton', [
            'isCurrent' =>Like::isCurrentLikeByMeet($meeting_id),
            'likeCount' =>Like::getCountByMeet($meeting_id),
            'tooltip'   =>Like::getOtherLikesByMeet($meeting_id),
            ]
        );
    }

    /**
     * Вывод формы добавления или само добавление сотрудника
     * @author  Sasha
     * @data    21.08.2019
     */
    public function actionInsertEmployee()
    {
        $model=new People();
        if (isset($_POST['ID'])){
            $model->saveAs();
            $this->redirect($this->createUrl('employees'));
        }
        else{
            $this->render('viewInsertEmployeeForm',
                [
                    'model'     =>$model,
                    'action'    =>$this->createUrl('insertEmployee'),
                    'optionsM'  =>Meets::model()->findAll(),
                    'optionsD'  =>Department::model()->findAll(),
                ]);
        }
    }

    /**
     * Вывод формы добавления или само добавление встречи
     * @author  Sasha
     * @data    21.08.2019
     */
    public function actionInsertMeeting()
    {
        $model=new Meets();
        if (isset($_POST['ID'])) {
            $model->saveAs();
            $this->redirect($this->createUrl('meeting'));
        }
        else {
            $this->render('viewInsertMeetingForm', [
                'model'     =>$model,
                'action'    =>$this->createUrl('insertMeeting'),
                'optionsP'  =>People::model()->findAll(),
                'optionsR'  =>Room::model()->findAll(),
            ]);
        }
    }
    /**
     * Удаление записи
     * @param integer $id ключ сотрудника.
     * @throws CHttpException
     * @author  Sasha
     * @data    21.08.2019
     */
    public function actionDeleteEmployee($id)
    {
        if (1!=People::model()->deleteByPk($id))
            throw new CHttpException(404,"Записи сотрудника с ключом $id нет в базе");
        $this->redirect($this->createUrl('employees'));
    }

    /**
     * Удаление встречи из базы
     * @param integer $id ключ встречи.
     * @throws CHttpException
     * @author  Sasha
     * @data    21.08.2019
     */
    public function actionDeleteMeeting($id)
    {
        if (Meets::model()->deleteByPk($id)!=1)
            throw new CHttpException(404,"Записи встречи с ключом $id нет в базе");
        $this->redirect($this->createUrl('meeting'));
    }

    /**
     * Редактирование записи сотрудника
     * @param integer $id ключ записи в БД
     * @throws CHttpException
     * @author  Sasha
     * @data    21.08.2019
     */
    public function actionEditEmployee($id)
    {
        if (isset($_POST['ID'])){
            $record=People::model()->findByPk($_POST['ID']);
            if (is_null($record))
                throw new CHttpException(404,"Записи сотрудника с ключом $id нет в базе");
            $record->saveAs();

            $this->redirect($this->createUrl('employees'));
        }
        else {
            $record=People::model()->findByPk($id);
            if (is_null($record))
                throw new CHttpException(404,"Записи сотрудника с ключом $id нет в базе");

            $this->render('viewInsertEmployeeForm',
                [
                    'model'     =>  $record,
                    'action'    =>$this->createUrl('editEmployee', ['id'=>$id]),
                    'optionsM'  =>Meets::model()->findAll(),
                    'optionsD'  =>Department::model()->findAll(),
                ]);
        }
    }
    /**
     *  Редактирование записи встречи.
     * @param integer $id ключ в таблице встреч
     * @throws CHttpException
     * @author  Sasha
     * @data 21.08.2019
     */
    public function actionEditMeeting($id)
    {
        if (isset($_POST['ID'])) {
            $record=Meets::model()->findByPk($_POST['ID']);
            if (is_null($record))
                throw new CHttpException(404,"Записи встречи с ключом $id нет в базе");
            $record->saveAs();
            $this->redirect($this->createUrl('meeting'));
        }
        else {
            $record=Meets::model()->findByPk($id);
            if (is_null($record))
                throw new CHttpException(404,"Записи встречи с ключом $id нет в базе");
            $this->render('viewInsertMeetingForm',
                [
                    'model'     =>  $record,
                    'action'    =>  $this->createUrl('editMeeting', ['id'=>$id]),
                    'optionsP'=>People::model()->findAll(),
                    'optionsR'=>Room::model()->findAll(),
                ]);
        }
    }
    /**
     * Действие для страницы 'поиск больших встреч'
     * @author  Sasha
     * @data    21.08.2019
     */
    public function actionMemberCountForm()
    {
        if (isset($_POST['count'])) {
            $count=intval($_POST['count']);
            $meetingList = Meets::getAllByMemberCount($count);
            $this->render('viewMemberCountForm', array('meetingList' => $meetingList));
        }
        else
            $this->render('viewMemberCountForm', array());
    }

    /**
     * Позволяет выбрать комнату и выводит список событий в ней
     * с параметром all выводит список всех комнат
     * @param  string $id ключ комнаты базе
     * @throws CHttpException
     * @author  Sasha
     * @data    21.08.2019
     */
    public function actionRoomExplore($id)
    {
        if ($id!='all' ) {
            $model=Room::model()->findByPk($id);
            if (is_null($model))
                throw new CHttpException(404, "Записи комнаты с ключом $id нет в базе");
            $this->render('viewRoomTree',array('model'=>$model,));
        }
        else{
            $this->render('viewRoomList',array('items'=>Room::model()->findAll(),));
        }
    }

    /**
     * Удаляет комнату
     * @param integer $id ключ комнаты базе
     * @throws CHttpException
     * @author  Sasha
     * @data    21.08.2019
     */
    public function actionRoomDelete($id)
    {
        if (Room::model()->deleteByPk($id) != 1)
            throw new CHttpException(404,"Записи комнаты с ключом $id нет в базе");
        $this->redirect($this->createUrl('roomExplore/all'));
    }
    /**
     * Добавление новой записи комнаты в базу
     * @author  Sasha
     * @data    21.08.2019
     */
    public function actionInsertRoom()
    {
        $model = new Room();
        if (isset($_POST['ID'])) {
            $model->saveAs();
            $this->redirect($this->createUrl('roomExplore/all'));
        }
        else {
            $this->render('viewRoomForm',
                [
                    'model' => $model,
                    'action' => 'insertRoom',
                ]);
        }
    }
    /**
     * Редактирование записи комнаты
     * @param integer $id ключ записи в БД
     * @throws CHttpException
     * @author  Sasha
     * @data    21.08.2019
     */
    public function actionEditRoom($id)
    {
        if (isset($_POST['ID'])) {
            $model=Room::model()->findByPk(intval($_POST['ID']));
            if (is_null($model))
                throw new CHttpException(404, "Записи комнаты с ключом $id нет в базе");
            $model->SaveAs();
            $this->redirect($this->createUrl('roomExplore/all'));
        }
        else {
            $model=Room::model()->findByPk($id);
            if (is_null($model))
                throw new CHttpException(404, "Записи комнаты с ключом $id нет в базе");
            $this->render('viewRoomForm',
                [
                    'model' => $model,
                    'action' => 'editRoom',
                ]);
        }
    }
    /**
     * Позволяет выбрать отдел и выводит список сотрудников в нём
     * с параметром all выводит список всех отделов
     * @param  string $id ключ отдела в базе
     * @throws CHttpException
     * @author  Sasha
     * @data    21.08.2019
     */
    public function actionDeptExplore($id)
    {
        if ($id!='all' ) {
            $model=Department::model()->findByPk($id);
            if (is_null($model))
                throw new CHttpException(404, "Записи отдела с ключом $id нет в базе");
            $this->render('viewDepartmentTree',array('model'=>$model,));
        }
        else{
            $this->render('viewDepartmentList',array('items'=>Department::model()->findAll(),));
        }
    }

    /**
     * Удаляет отдел
     * @param  integer $id ключ отдела базе
     * @throws CHttpException
     * @author  Sasha
     * @data    21.08.2019
     */
    public function actionDeptDelete($id)
    {
        if (Department::model()->deleteByPk($id) != 1)
            throw new CHttpException(404, "Записи отдела с ключом $id нет в базе");
        $this->redirect($this->createUrl('deptExplore/all'));
    }
    /**
     * Добавление новой записи отдела в базу
     * @author  Sasha
     * @data    21.08.2019
     */
    public function actionInsertDepartment()
    {
        $model = new Department();
        if (isset($_POST['ID'])) {
            $model->saveAs();
            $this->redirect($this->createUrl('deptExplore/all'));
        } else {
            $this->render('viewDepartmentForm',
                [
                    'model' => $model,
                    'action' => 'insertDepartment',
                ]);
        }
    }
    /**
     * Редактирование записи отдела
     * @param integer $id ключ записи в БД
     * @throws CHttpException
     * @author  Sasha
     * @data    21.08.2019
     */
    public function actionEditDepartment($id)
    {
        if (isset($_POST['ID'])) {
            $model=Department::model()->findByPk(intval($_POST['ID']));
            if (is_null($model))
                throw new CHttpException(404, "Ошибка! Не найден отдел с ключём $id");
            $model->SaveAs();
            $this->redirect($this->createUrl('deptExplore/all'));
        }
        else {
            $model=Department::model()->findByPk($id);
            if (is_null($model))
                throw new CHttpException(404, "Ошибка! Не найден отдел с ключём $id");
            $this->render('viewDepartmentForm',
                [
                    'model' => $model,
                    'action' => 'editDepartment',
                ]);
        }
    }

    public function actionRating()
    {
        $this->render('rating');
    }
    public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }

    /**
     * Задаёт ограничения на посещение страниц категориям пользователей
     * @return array
     */
    public function accessRules()
    {
        return array(
            array('allow',
                'actions' => array('employees', 'meeting', 'memberCountForm', 'roomExplore', 'deptExplore'),
                'users'=>array('admin', 'signed'),
            ),
            array('deny',
                'actions' => array('employees', 'meeting', 'memberCountForm', 'roomExplore', 'deptExplore'),
                'users'=>array('guest'),
            ),
        );
    }

}