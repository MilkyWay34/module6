<?php

namespace app\controllers;

use app\helpers\UIHelper;
use app\models\Category;
use app\models\File;
use app\models\Opinion;
use app\models\Reply;
use app\models\Status;
use app\models\Task;
use frexin\logic\actions\CancelAction;
use frexin\logic\actions\DenyAction;
use frexin\logic\AvailableActions;
use Yii;
use yii\data\Pagination;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

class TasksController extends SecuredController
{
    public function actionIndex(): string
    {
        $task = new Task();
        $task->load(Yii::$app->request->post());

        $tasksQuery = $task->getSearchQuery();
        $categories = Category::find()->all();

        $countQuery = clone $tasksQuery;
        $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => 5]);
        $models = $tasksQuery->offset($pages->offset)->limit($pages->limit)->all();

        return $this->render('index', ['models' => $models, 'pages' => $pages, 'task' => $task, 'categories' => $categories]);
    }

    /**
     * @throws NotFoundHttpException
     */
    public function actionView($id): string
    {
        $task = $this->findOrDie($id, Task::class);
        $reply = new Reply;
        $opinion = new Opinion;

        return $this->render('view', ['model' => $task, 'newReply' => $reply, 'opinion' => $opinion]);
    }
}