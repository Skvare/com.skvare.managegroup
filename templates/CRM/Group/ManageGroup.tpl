<table id="managegroup_ext_settings" style="display:none;">
  <tr class="custom_field-row" id="managegroup_ext_settings_inactive_date">
    <td class="label">{$form.inactive_date.label}</td>
    <td class="html-adjust">{$form.inactive_date.html}<br>
      <span class="description">
      Specify the date and time when this group will be disabled or deleted.
      </span>
    </td>
  </tr>
  <tr class="custom_field-row" id="managegroup_ext_settings_inactive_action">
    <td class="label">{$form.inactive_action.label}</td>
    <td class="html-adjust">{$form.inactive_action.html}<br>
      <span class="description">
      Choose the action to be taken on the above specified date, default action is disable the group.
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
