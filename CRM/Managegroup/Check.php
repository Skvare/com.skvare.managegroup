<?php

use CRM_Managegroup_ExtensionUtil as E;

/**
 * Class CRM_Managegroup_Check
 */
class CRM_Managegroup_Check {

  /**
   * @var array
   */
  private $messages;

  /**
   * CRM_Managegroup_Check constructor.
   *
   * @param array $messages
   *
   * @throws \API_Exception
   * @throws \Civi\API\Exception\UnauthorizedException
   */
  public function __construct($messages) {
    $this->messages = $messages;
  }

  /**
   * @return array
   * @throws \API_Exception
   * @throws \CiviCRM_API3_Exception
   * @throws \Civi\API\Exception\UnauthorizedException
   */
  public function checkRequirements() {
    $this->checkIfGroupisSetToInactive();

    return $this->messages;
  }

  /**
   * Check Group is set to inactive or disable.
   *
   * @throws \API_Exception
   * @throws \CiviCRM_API3_Exception
   * @throws \Civi\API\Exception\UnauthorizedException
   */
  private function checkIfGroupisSetToInactive() {
    $resultGroups = civicrm_api3('Group', 'get', [
      'sequential' => 1,
      'return' => ["id", "title", "inactive_date", "inactive_action"],
      'is_active' => 1,
      'inactive_date' => ['IS NOT NULL' => 1],
    ]);
    $groupsDetails = [];
    if (!empty($resultGroups['values'])) {
      foreach ($resultGroups['values'] as $group) {
        if (!empty($group['inactive_date'])) {
          $groupsDetail = [];
          $groupsDetail['id'] = $group['id'];
          $groupsDetail['title'] = $group['title'];
          $groupsDetail['is_overdue'] = CRM_Utils_Date::overdue($group['inactive_date']);
          $groupsDetail['inactive_date'] = CRM_Utils_Date::customFormat($group['inactive_date']);
          if ($group['inactive_action'] == 2) {
            $groupsDetail['action'] = 'Delete';
          }
          else {
            $groupsDetail['action'] = 'Disable';
          }
          $groupsDetails[] = $groupsDetail;
        }
      }
      if (!empty($groupsDetails)) {
        $html = '<table>';
        $html .= '<tr><th>Group</th><th>Action Type</th><th>Action Date</th></tr>';
        foreach ($groupsDetails as $groupsDetail) {
          $style = $groupsDetail['is_overdue'] ? 'status crm-error' : '';
          $url = CRM_Utils_System::url(
            'civicrm/group',
            'id=' . $groupsDetail['id'] . '&action=update&reset=1'
          );
          $groupsDetail['title'] = "<a href='{$url}' target='_blank'>" . $groupsDetail['title'] . '</a>';
          $html .= '<tr><td>' . $groupsDetail['title'] . '</td><td>' . $groupsDetail['action'] . "</td><td><span class='{$style}'>" . $groupsDetail['inactive_date'] . '</span></td></tr>';
        }
        $html .= '<tr><td colspan="3">These Group(s) are going to be deleted or disabled as per the action set on it.</td></tr>';
        $html .= '</table>';
        if (!empty($html)) {
          $message =
            new CRM_Utils_Check_Message(
              __FUNCTION__,
              $html,
              E::ts('Groups Operations'),
              \Psr\Log\LogLevel::INFO,
              'fa-bug'
            );
	  $this->messages[] = $message;
        }
      }

      return;
    }
  }
}
