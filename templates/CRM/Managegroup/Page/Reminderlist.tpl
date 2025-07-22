<div class="crm-block crm-content-block crm-group-reminderlist-block">
  <div class="crm-submit-buttons">
    <a href="javascript:self.close()" class="button cancel">{ts}Close{/ts}</a>
  </div>

  {if ! $reminderGroups}
    <div class="messages status no-popup">
      <div class="icon inform-icon"></div>
      {ts}No scheduled reminders found that use this group.{/ts}
    </div>
  {else}
    <div class="crm-results-block">
      <div class="crm-search-results">
        <table class="selector row-highlight">
          <thead>
            <tr>
              <th class="col sortable">{ts}Reminder Name{/ts}</th>
              <th class="col sortable">{ts}Use Type{/ts}</th>
              <th class="col sortable">{ts}Created Date{/ts}</th>
              <th class="col sortable">{ts}Updated Date{/ts}</th>
              <th class="col sortable">{ts}Last Use Date{/ts}</th>
              <th class="col">{ts}Status{/ts}</th>
            </tr>
          </thead>
          <tbody>
            {foreach from=$reminderGroups item=row}
              {if $row}
                <tr class="{cycle values='odd-row,even-row'}">
                  <td><strong>{$row.name}</strong></td>
                  <td>
                    <span class="crm-tag">
                      {$row.limit_to}
                    </span>
                  </td>
                  <td>{$row.created_date|crmDate}</td>
                  <td>{$row.modified_date|crmDate}</td>
                  <td>{$row.last_use|crmDate}</td>
                  <td>
                    {if $row.is_active}
                      <span class="crm-status-active">{ts}Active{/ts}</span>
                    {else}
                      <span class="crm-status-inactive">{ts}Inactive{/ts}</span>
                    {/if}
                  </td>
                </tr>
              {/if}
            {/foreach}
          </tbody>
        </table>
      </div>
    </div>
  {/if}
</div>
