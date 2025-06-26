<?php

namespace app\components;

use Yii;
use yii\base\Component; // Важно: Наследуемся от Component
use app\models\User;

class AccessChecker extends Component
{
    /**
     * Проверяет, имеет ли пользователь указанную роль.
     *
     * @param string $role Имя роли (например, 'admin', 'editor', 'client').
     * @param int|null $userId ID пользователя (если не указан, используется текущий пользователь).
     *
     * @return bool True, если пользователь имеет указанную роль, false в противном случае.
     */
    public function checkAccess($role, $userId = null)
    {
        $userId = $userId || Yii::$app->user->id;

        if ($userId === null || Yii::$app->user->isGuest) {
            return false; // Гостям доступ запрещен
        }

        $user = User::findOne($userId);

        if ($user === null) {
            return false; // Пользователь не найден
        }

        return $user->role_id === $role;
    }
}