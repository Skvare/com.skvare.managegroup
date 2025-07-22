<table id="managegroup_ext_settings" style="display:none;">
  <tr class="custom_field-row" id="managegroup_ext_settings_inactive_date">
    <td class="label">{$form.inactive_date.label}</td>
    <td class="html-adjust">{$form.inactive_date.html}<br>
      <span class="description">
      {ts}Specify the date and time when this group should be automatically disabled or deleted. Leave blank to keep the group active indefinitely.{/ts}
      </span>
    </td>
  </tr>
  <tr class="custom_field-row" id="managegroup_ext_settings_inactive_action">
    <td class="label">{$form.inactive_action.label}</td>
    <td class="html-adjust">{$form.inactive_action.html}<br>
      <span class="description">
      {ts}Choose the action to perform when the inactive date is reached. <strong>Disable</strong> will make the group inactive but preserve its data. <strong>Delete</strong> will permanently remove the group and cannot be <undone class="{/ts}"></undone>
      </span>
    </td>
  </tr>
</table>

{literal}
<script type="text/javascript">
    CRM.$(function($) {
      $('#managegroup_ext_settings_inactive_action').insertAfter('.crm-group-form-block-isActive');
      $('#managegroup_ext_settings_inactive_date').insertAfter('.crm-group-form-block-isActive');
    });
</script>
{/literal}
