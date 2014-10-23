<?php

/**
 * @file
 * Contains \Drupal\micro\MicroEntityAccessControlHandler.
 */

namespace Drupal\micro;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;

class MicroEntityAccessControlHandler extends EntityAccessControlHandler {

  /**
   * Performs access checks.
   */
  protected function checkAccess(EntityInterface $entity, $operation, $langcode, AccountInterface $account) {
    $access = parent::checkAccess($entity, $operation, $langcode, $account);

    if ($access->isNeutral()) {
      switch ($operation) {
        case 'view':
          $permission = 'view micro - ' . $entity->bundle() . ' entity';
          break;
        default:
          $permission = 'administer micro - ' . $entity->bundle() . ' entity';
          break;
      }

      return AccessResult::allowedIfHasPermission($account, $permission);
    }

    return $access;
  }

  /**
   * Performs create access checks.
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    $access = parent::checkCreateAccess($account, $context, $entity_bundle); // TODO: Change the autogenerated stub
    if ($access->isAllowed()) {
      return $access;
    }

    return AccessResult::allowedIfHasPermission($account, 'administer micro - ' . $entity_bundle . ' entity');
  }


}
