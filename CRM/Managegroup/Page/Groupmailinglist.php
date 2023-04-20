<?php
use CRM_Managegroup_ExtensionUtil as E;

class CRM_Managegroup_Page_Groupmailinglist extends CRM_Core_Page {

  public function run() {
    // Example: Set the page-title dynamically; alternatively, declare a static title in xml/Menu/*.xml
    CRM_Utils_System::setTitle(E::ts('Group Mailing List'));
    $gid = CRM_Utils_Request::retrieve('id', 'Integer', $this, FALSE);
    $sql = "SELECT m.id, m.name, m.scheduled_date, m.created_date, mg.entity_id, mg.group_type,
       mjob.status as mailing_job_status,
       mjob.end_date as mailing_job_end_date
FROM civicrm_mailing m
inner JOIN `civicrm_mailing_group` mg on (m.id = mg.mailing_id)
LEFT JOIN civicrm_mailing_job mjob ON mjob.mailing_id = m.id AND mjob.parent_id IS NULL AND mjob.is_test != 1
WHERE mg.entity_table = 'civicrm_group'
and mg.entity_id = %1";
    $params = [1 => [$gid, 'Positive']];
    $dao = CRM_Core_DAO::executeQuery($sql, $params);
    $mailingGroups = [];
    while ($dao->fetch()) {
      $url = CRM_Utils_System::url(
        'civicrm/mailing/report',
        'mid=' . $dao->id . '&reset=1'
      );
      $mailingGroups[$dao->id] = [
        'name' => "<a href='{$url}' target='_blank'>{$dao->name}</a>",
        'scheduled_date' => $dao->scheduled_date,
        'created_date' => $dao->created_date,
        'mailing_job_status' => $dao->mailing_job_status,
        'mailing_job_end_date' => $dao->mailing_job_end_date,
        'group_type' => $dao->group_type,
      ];
    }

    $this->assign('mailingGroups', $mailingGroups);

    parent::run();
  }

}

