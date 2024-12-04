<?php

require_once 'managegroup.civix.php';
// phpcs:disable
use CRM_Managegroup_ExtensionUtil as E;
// phpcs:enable

/**
 * Implements hook_civicrm_config().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_config/
 */
function managegroup_civicrm_config(&$config) {
  _managegroup_civix_civicrm_config($config);
}

/**
 * Implements hook_civicrm_install().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_install
 */
function managegroup_civicrm_install() {
  _managegroup_civix_civicrm_install();
}

/**
 * Implements hook_civicrm_enable().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_enable
 */
function managegroup_civicrm_enable() {
  _managegroup_civix_civicrm_enable();
}

/**
 * Implements hook_civicrm_entityTypes().
 *
 * Declare entity types provided by this module.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_entityTypes
 */
function managegroup_civicrm_entityTypes(&$entityTypes) {
  $entityTypes['CRM_Contact_DAO_Group']['fields_callback'][]
    = function ($class, &$fields) {
    $fields['inactive_date'] = [
      'name' => 'inactive_date',
      'type' => CRM_Utils_Type::T_TIMESTAMP,
      'title' => ts('When Group should be Inactive'),
      'description' => 'Date for settng Group Inactive.',
      'required' => FALSE,
      'where' => 'civicrm_group.inactive_date',
      'table_name' => 'civicrm_group',
      'entity' => 'Group',
      'bao' => 'CRM_Contact_DAO_Group',
      'localizable' => 0,
    ];

    $fields['inactive_action'] = [
      'name' => 'inactive_action',
      'type' => CRM_Utils_Type::T_INT,
      'title' => ts('Action on Inactive'),
      'description' => 'Action on Inactive',
      'required' => FALSE,
      'where' => 'civicrm_group.inactive_action',
      'table_name' => 'civicrm_group',
      'entity' => 'Group',
      'bao' => 'CRM_Contact_DAO_Group',
      'localizable' => 0,
      'default' => '1',
      'html' => [
        'type' => 'Select',
      ],
      'pseudoconstant' => [
        'callback' => 'CRM_Managegroup_Utils::getInactiveAction',
      ],
    ];
  };
}

function managegroup_civicrm_buildForm($formName, &$form) {
  if ($formName == 'CRM_Group_Form_Edit' &&
    ($form->getAction() == CRM_Core_Action::ADD ||
      $form->getAction() == CRM_Core_Action::UPDATE)) {
    $list = CRM_Managegroup_Utils::getInactiveAction();
    $form->add('datepicker', 'inactive_date', ts('InActive Date'), [], FALSE,
      ['time' => TRUE]);
    $form->add('select', 'inactive_action', ts('InActive Action'), ['' =>
        '- select -'] + $list, FALSE);
  }
}

/**
 * Implementation of hook_civicrm_links
 */
function managegroup_civicrm_links($op, $objectName, $objectId, &$links, &$mask, &$values) {
  if ($objectName == 'Group' && in_array($op, ['group.selector.row'])) {
    $values['id'] = $objectId;
    $links[] = [
      'name' => ts('Associated Mailings'),
      'url' => 'civicrm/group/mailinglist',
      'qs' => 'reset=1&id=%%id%%',
      'title' => ts('Associated Mailings'),
      'extra' => "target='_blank'",
      //'class' => ['no-popup'],
    ];
    $links[] = [
      'name' => ts('Associated Reminder'),
      'url' => 'civicrm/group/reminderlist',
      'qs' => 'reset=1&id=%%id%%',
      'title' => ts('Associated Reminder'),
      'extra' => "target='_blank'",
      //'class' => ['no-popup'],
    ];
  }
}

/**
 * Implements hook_civicrm_check().
 */
function managegroup_civicrm_check(&$messages) {
  $checks = new CRM_Managegroup_Check($messages);
  $messages = $checks->checkRequirements();
}
