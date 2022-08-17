<?php
/**
 * Created by PhpStorm.
 * User: Petr Šebela
 * Date: 24. 9. 2020
 * Time: 20:35
 */

declare(strict_types=1);

namespace App\Model;

use Nextras\Orm\Entity\Entity;
use Nextras\Orm\Relationships\HasMany;
use Nextras\Orm\Relationships\ManyHasMany;

/**
 * Class Action
 * @package App\Model
 * @property int $id {primary}
 * @property string $name
 * @property HasMany|Action[] $actions {1:m Action::$right}
 */
class Right extends Entity
{

}