<?php

Class CRM_Managegroup_Utils {

  /**
   * Get action for group.
   *
   * @return string[]
   */
  public static function getInactiveAction(): array {
    return [
      '1' => 'Disable',
      '2' => 'Delete'
    ];
  }
}
