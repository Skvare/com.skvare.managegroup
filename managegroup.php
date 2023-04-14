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
    $form->add('datepicker', 'inactive_date', ts('InActive Date'), [], FALSE,
      ['time' => TRUE]);
    $form->add('select', 'inactive_action', ts('InActive Action'), ['' =>
        '- select -'] + $list, FALSE);
  }
}

// --- Functions below this ship commented out. Uncomment as required. ---

/**
 * Implements hook_civicrm_preProcess().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_preProcess
 */
//function managegroup_civicrm_preProcess($formName, &$form) {
//
//}

/**
 * Implements hook_civicrm_navigationMenu().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_navigationMenu
 */
//function managegroup_civicrm_navigationMenu(&$menu) {
//  _managegroup_civix_insert_navigation_menu($menu, 'Mailings', [
//    'label' => E::ts('New subliminal message'),
//    'name' => 'mailing_subliminal_message',
//    'url' => 'civicrm/mailing/subliminal',
//    'permission' => 'access CiviMail',
//    'operator' => 'OR',
//    'separator' => 0,
//  ]);
//  _managegroup_civix_navigationMenu($menu);
//}
