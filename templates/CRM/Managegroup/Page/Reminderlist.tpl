<div class="crm-block crm-content-block crm-group-view-form-block">
    {if ! $reminderGroups}
      <div class='help'>No record available.</div>
    {else}
      <table class="selector row-highlight">
        <tr>
          <th class="col">{ts}Reminder Name{/ts}</th>
          <th class="col">{ts}Use Type{/ts}</th>
          <th class="col">{ts}Created Date{/ts}</th>
          <th class="col">{ts}Updated Date{/ts}</th>
          <th class="col">{ts}Last Use Date{/ts}</th>
          <th class="col">{ts}Status{/ts}</th>
        </tr>
          {foreach from=$reminderGroups item=row}
              {if $row}
                <tr>
                  <td>{$row.name}</td>
                  <td>{$row.limit_to}</td>
                  <td>{$row.created_date|crmDate}</td>
                  <td>{$row.modified_date|crmDate}</td>
                  <td>{$row.last_use|crmDate}</td>
                  <td>{$row.is_active}</td>
                </tr>
              {/if}
          {/foreach}
        </tr>
      </table>
    {/if}
</div>
