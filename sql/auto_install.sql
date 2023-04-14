ALTER TABLE `civicrm_group`
  ADD `inactive_date` TIMESTAMP NULL DEFAULT NULL COMMENT 'When Group action happen';

ALTER TABLE `civicrm_group`
  ADD `inactive_action` INT UNSIGNED NULL DEFAULT NULL COMMENT 'Inactive action';
