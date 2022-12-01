<?php


namespace app\controllers;


use app\models\User;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

class UserController extends SecuredController
{

    public function actionView($id)
    {
        $user = $this->findOrDie($id, User::class);

        if (!$user->is_contractor) {
            throw new NotFoundHttpException('Пользователь не найден');
        }

        return $this->render('view', ['user' => $user]);
    }
}