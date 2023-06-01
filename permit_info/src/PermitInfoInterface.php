<?php

namespace Drupal\permit_info;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface defining a permit information entity type.
 */
interface PermitInfoInterface extends ContentEntityInterface, EntityOwnerInterface, EntityChangedInterface {

}
