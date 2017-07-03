<?php
namespace app\commands;

use yii\console\Controller;
use Yii;

/*
 * Инициализация Rbac модуля
 * Добавление разрешений и ролей *
 */
class RbacController extends Controller
{
    public function actionInit()
    {
        $auth = Yii::$app->authManager;


        // добавляем разрешение "userAccess"
        $userAccess = $auth->createPermission('userAccess');
        $userAccess->description = 'Пользовательский доступ';
        $auth->add($userAccess);

        // добавляем разрешение "modAccess"
        $modAccess = $auth->createPermission('modAccess');
        $modAccess->description = 'Доступ модератора(управление новостями)';
        $auth->add($modAccess);

        // добавляем разрешение "adminAccess"
        $adminAccess = $auth->createPermission('adminAccess');
        $adminAccess->description = 'Доступ администратора - полный доступ';
        $auth->add($adminAccess);

        // добавляем роль "User" и даём роли разрешение "userAccess"
        $user = $auth->createRole('User');
        $auth->add($user);
        $auth->addChild($user, $userAccess);

        // добавляем роль "Moderator" и даём роли разрешение "modAccess"
        // а также все разрешения роли "User"
        $moderator = $auth->createRole('Moderator');
        $auth->add($moderator);
        $auth->addChild($moderator, $modAccess);
        $auth->addChild($moderator, $user);

        // добавляем роль "Admin" и даём роли разрешение "adminAccess"
        // а также все разрешения роли "Moderator"
        $admin = $auth->createRole('Admin');
        $auth->add($admin);
        $auth->addChild($admin, $adminAccess);
        $auth->addChild($admin, $moderator);

        // Назначение ролей пользователям. 1 и 2 это IDs возвращаемые IdentityInterface::getId()
        // обычно реализуемый в модели User.
        $auth->assign($admin, 1);
    }

}