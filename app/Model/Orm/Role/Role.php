<?php

namespace App\Model;

use Nextras\Orm\Entity\Entity;
use Nextras\Orm\Entity\IEntity;
use Nextras\Orm\Relationships\HasMany;
use Nextras\Orm\Relationships\ManyHasMany;

/**
 * Role
 * @property int $id {primary}
 * @property string $intName
 * @property HasMany|User[] $users {1:m User::$role}
 * @property ManyHasMany|Action[]|HasMany $actions {m:m Action::$roles, isMain=TRUE}
 */
class Role extends Entity
{
    const INT_NAME_ADMIN = "ADMIN";
}
