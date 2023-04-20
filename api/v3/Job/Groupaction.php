<?php
use CRM_Managegroup_ExtensionUtil as E;

/**
 * Job.Groupaction API specification (optional)
 * This is used for documentation and validation.
 *
 * @param array $spec description of fields supported by this API call
 *
 * @see https://docs.civicrm.org/dev/en/latest/framework/api-architecture/
 */
function _civicrm_api3_job_Groupaction_spec(&$spec) {
}

/**
 * Job.Groupaction API
 *
 * @param array $params
 *
 * @return array
 *   API result descriptor
 *
 * @see civicrm_api3_create_success
 *
 * @throws API_Exception
 */
function civicrm_api3_job_Groupaction($params) {
  // Fetch Active Group with date set for to mark inactive.
  $resultGroups = civicrm_api3('Group', 'get', [
    'sequential' => 1,
    'return' => ["id", "title", "inactive_date", "inactive_action"],
    'is_active' => 1,
    'inactive_date' => ['IS NOT NULL' => 1],
  ]);
  $disableGroups = $deleteGroups = [];
  $returnValues = '';
  if (!empty($resultGroups['values'])) {
    foreach ($resultGroups['values'] as $group) {
      // Check inactive_date is passed.
      if (!empty($group['inactive_date']) && CRM_Utils_Date::overdue($group['inactive_date'])) {
        // Default action is disable group.
        if ($group['inactive_action'] == 1 || empty($group['inactive_action'])) {
          // Group group disable.
          try {
            $result = civicrm_api3('Group', 'create', [
              'id' => $group['id'],
              'is_active' => 0,
            ]);
            $disableGroups[] = $group['title'] . ' ( ' . $group['id'] . ') ';
          }
          catch (CiviCRM_API3_Exception $e) {

          }
        }
        elseif ($group['inactive_action'] == 2) {
          // Delete group.
          $result = civicrm_api3('Group', 'delete', [
            'id' => $group['id'],
          ]);
          $deleteGroups[] = $group['title'] . ' ( ' . $group['id'] . ') ';
        }
      }
    }
  }

  if (!empty($disableGroups)) {
    $returnValues .= 'Disable Group: ' . implode(', ', $disableGroups);
  }
  if (!empty($deleteGroups)) {
    $returnValues .= 'Deleted Group: ' . implode(', ', $deleteGroups);
  }

  return civicrm_api3_create_success($returnValues, $params, 'Job', 'Groupaction');
}
