<?php

require_once 'managegroup.civix.php';
use CRM_Managegroup_ExtensionUtil as E;

/**
 * Implements hook_civicrm_config().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_config/
 */
function managegroup_civicrm_config(&$config) {
  _managegroup_civix_civicrm_config($config);
}

/**
 * Implements hook_civicrm_xmlMenu().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_xmlMenu
 */
function managegroup_civicrm_xmlMenu(&$files) {
  _managegroup_civix_civicrm_xmlMenu($files);
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
 * Implements hook_civicrm_postInstall().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_postInstall
 */
function managegroup_civicrm_postInstall() {
  _managegroup_civix_civicrm_postInstall();
}

/**
 * Implements hook_civicrm_uninstall().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_uninstall
 */
function managegroup_civicrm_uninstall() {
  _managegroup_civix_civicrm_uninstall();
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
 * Implements hook_civicrm_disable().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_disable
 */
function managegroup_civicrm_disable() {
  _managegroup_civix_civicrm_disable();
}

/**
 * Implements hook_civicrm_upgrade().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_upgrade
 */
function managegroup_civicrm_upgrade($op, CRM_Queue_Queue $queue = NULL) {
  return _managegroup_civix_civicrm_upgrade($op, $queue);
}

/**
 * Implements hook_civicrm_managed().
 *
 * Generate a list of entities to create/deactivate/delete when this module
 * is installed, disabled, uninstalled.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_managed
 */
function managegroup_civicrm_managed(&$entities) {
  _managegroup_civix_civicrm_managed($entities);
}

/**
 * Implements hook_civicrm_caseTypes().
 *
 * Add CiviCase types provided by this extension.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_caseTypes
 */
function managegroup_civicrm_caseTypes(&$caseTypes) {
  _managegroup_civix_civicrm_caseTypes($caseTypes);
}

/**
 * Implements hook_civicrm_angularModules().
 *
 * Add Angular modules provided by this extension.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_angularModules
 */
function managegroup_civicrm_angularModules(&$angularModules) {
  // Auto-add module files from ./ang/*.ang.php
  _managegroup_civix_civicrm_angularModules($angularModules);
}

/**
 * Implements hook_civicrm_alterSettingsFolders().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_alterSettingsFolders
 */
function managegroup_civicrm_alterSettingsFolders(&$metaDataFolders = NULL) {
  _managegroup_civix_civicrm_alterSettingsFolders($metaDataFolders);
}

/**
 * Implements hook_civicrm_entityTypes().
 *
 * Declare entity types provided by this module.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_entityTypes
 */
function managegroup_civicrm_entityTypes(&$entityTypes) {
  foreach ($entityTypes as $groupKey => $entityType) {
    if ($entityType['name'] === 'Group') {
      $entityTypes[$groupKey]['fields_callback'][] = function ($class, &$fields) {
        $fields['inactive_date'] = [
          'name' => 'inactive_date',
          'type' => CRM_Utils_Type::T_TIMESTAMP,
          'title' => E::ts('When Group should be Inactive'),
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
          'title' => E::ts('Action on Inactive'),
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
  }
  _managegroup_civix_civicrm_entityTypes($entityTypes);
}

/**
 * Implements hook_civicrm_themes().
 */
function managegroup_civicrm_themes(&$themes) {
  _managegroup_civix_civicrm_themes($themes);
}

function managegroup_civicrm_buildForm($formName, &$form) {
  if ($formName == 'CRM_Group_Form_Edit' &&
    ($form->getAction() == CRM_Core_Action::ADD ||
      $form->getAction() == CRM_Core_Action::UPDATE)) {
    $list = CRM_Managegroup_Utils::getInactiveAction();
    $form->add('datepicker', 'inactive_date', E::ts('InActive Date'), [], FALSE,
      ['time' => TRUE]);
    $form->add('select', 'inactive_action', E::ts('InActive Action'), ['' =>
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
      'name' => E::ts('Associated Mailings'),
      'url' => 'civicrm/group/mailinglist',
      'qs' => 'reset=1&id=%%id%%',
      'title' => E::ts('Associated Mailings'),
      //'extra' => "target='_blank'",
      //'class' => ['no-popup'],
    ];
    $links[] = [
      'name' => E::ts('Associated Reminder'),
      'url' => 'civicrm/group/reminderlist',
      'qs' => 'reset=1&id=%%id%%',
      'title' => E::ts('Associated Reminder'),
      //'extra' => "target='_blank'",
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
