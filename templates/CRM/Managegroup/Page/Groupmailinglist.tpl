<div class="crm-block crm-content-block crm-group-view-form-block">
{if ! $mailingGroups}
   <div class='help'>No record available.</div>
{else}
  <table class="selector row-highlight">
    <tr>
      <th class="col">{ts}Mailing Name{/ts}</th>
      <th class="col">{ts}Created Date{/ts}</th>
      <th class="col">{ts}Scheduled Date{/ts}</th>
      <th class="col">{ts}End Date{/ts}</th>
      <th class="col">{ts}Status{/ts}</th>
      <th class="col">{ts}Group Use{/ts}</th>
    </tr>
      {foreach from=$mailingGroups item=row}
        {if $row}
          <tr>
            <td>{$row.name}</td>
            <td>{$row.created_date|crmDate}</td>
            <td>{$row.scheduled_date|crmDate}</td>
            <td>{$row.mailing_job_end_date|crmDate}</td>
            <td>{$row.mailing_job_status}</td>
            <td>{$row.group_type}</td>
          </tr>
        {/if}
      {/foreach}
    </tr>
  </table>
{/if}
</div>
