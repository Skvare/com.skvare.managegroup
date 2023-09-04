<?php
use CRM_Managegroup_ExtensionUtil as E;

class CRM_Managegroup_Page_Reminderlist extends CRM_Core_Page {

  public function run() {
    // Example: Set the page-title dynamically; alternatively, declare a static title in xml/Menu/*.xml
    CRM_Utils_System::setTitle(E::ts('Reminder List'));
    $gid = CRM_Utils_Request::retrieve('id', 'Integer', $this, FALSE);
    $sql = "SELECT cas.id, cas.title, cas.limit_to, cas.is_active, cas.created_date, cas.modified_date, action_log.last_use
            FROM civicrm_action_schedule cas
                inner JOIN `civicrm_group` g on (g.id = cas.group_id)
                left join (
                    SELECT action_schedule_id, max(action_date_time) as last_use
                    FROM `civicrm_action_log`
                    GROUP by action_schedule_id
                ) action_log ON (action_log.action_schedule_id = cas.id)
            WHERE  cas.group_id = %1 order by cas.modified_date desc";
    $params = [1 => [$gid, 'Positive']];
    $dao = CRM_Core_DAO::executeQuery($sql, $params);
    $reminderGroups = [];
    while ($dao->fetch()) {
      $url = CRM_Utils_System::url(
        'civicrm/admin/scheduleReminders',
        'action=update&mid=' . $dao->id . '&reset=1'
      );
      $limitTo = '';
      if ($dao->limit_to == '0') {
        $limitTo = 'Also include';
      }
      elseif ($dao->limit_to == '1') {
        $limitTo = 'Limit to';
      }
      $reminderGroups[$dao->id] = [
        'name' => "<a href='{$url}' target='_blank'>{$dao->title}</a>",
        'created_date' => $dao->created_date,
        'modified_date' => $dao->modified_date,
        'is_active' => $dao->is_active ? 'Active' : 'InActive',
        'limit_to' => $limitTo,
        'last_use' => $dao->last_use,
      ];
    }

    $this->assign('reminderGroups', $reminderGroups);

    parent::run();
  }

}
