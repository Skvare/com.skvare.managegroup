# Manage Groups with Scheduled Actions

![Extension Overview](/images/manage_group.png)

A CiviCRM extension that provides automated group management with scheduled disable/delete actions, plus comprehensive tracking of group usage in mailings and reminders.

## Overview

This extension solves a common problem in CiviCRM installations: unused groups consuming system resources, particularly Smart Groups that rebuild cache frequently. When you have hundreds of groups created over the years, many may no longer be actively used but continue to impact performance.

**Key Features:**
- **Scheduled Actions**: Set future dates to automatically disable or delete groups
- **Mailing Tracking**: View which mailings use each group and when they were last sent
- **Reminder Tracking**: See which scheduled reminders are associated with each group
- **Performance Optimization**: Reduce system load by automatically managing unused groups
- **Safety First**: Default action is to disable (not delete) groups to preserve data

## Screenshots

| Feature | Screenshot |
|---------|------------|
| Group Management Interface | ![Group Management](/images/manage_group.png) |
| Mailing Associations | ![Group in Mailing](/images/group_in_mailing.png) |
| Reminder Associations | ![Group in Mailing](/images/group_in_reminder.png) |
| System Status | ![Action Status](/images/action_status.png) |

## Requirements

- **PHP**: 7.2 or higher
- **CiviCRM**: 5.38 or higher (tested up to 5.70+)
- **Permissions**: Users need appropriate CiviCRM permissions for group management

## Installation

### Web UI Installation
1. Navigate to **Administer** → **System Settings** → **Extensions**
2. Click **Add New** and upload the extension package
3. Enable the extension

### CLI Installation (Zip)
```bash
cd <extension-directory>
cv dl com.skvare.managegroup@https://github.com/Skvare/com.skvare.managegroup/archive/master.zip
cv en managegroup
```

### CLI Installation (Git)
```bash
git clone https://github.com/Skvare/com.skvare.managegroup.git
cv en managegroup
```

## Configuration & Usage

### Setting Up Scheduled Actions

1. **Navigate to Groups**: Go to **Contacts** → **Manage Groups**
2. **Edit a Group**: Click **Settings** next to any group
3. **Configure Scheduling**:
   - **Inactive Date**: Set the date and time when the group should be processed
   - **Inactive Action**: Choose between:
     - **Disable** (recommended): Makes the group inactive but preserves all data
     - **Delete**: Permanently removes the group and all associated data

### Scheduled Job Setup

The extension creates a scheduled job that runs daily to process groups with overdue inactive dates.

**To configure the scheduled job:**
1. Navigate to **Administer** → **System Settings** → **Scheduled Jobs**
2. Find **"Group Action Management"** job
3. Set appropriate frequency (daily recommended)
4. Ensure the job is enabled

### Tracking Group Usage

#### View Associated Mailings
- From the Groups list, click **Associated Mailings** next to any group
- See detailed information about:
  - Mailing names and creation dates
  - Scheduled and completion dates
  - Current mailing status
  - How the group was used (include/exclude)

#### View Associated Reminders
- From the Groups list, click **Associated Reminders** next to any group
- Review information about:
  - Reminder names and types
  - Creation and last modification dates
  - Last usage dates
  - Current reminder status

## System Status Integration

The extension provides system status checks accessible via **Administer** → **System Settings** → **System Status**:

- **Pending Actions**: Groups with overdue inactive dates
- **Scheduled Actions**: Upcoming group actions

## Best Practices

### Before Setting Up Actions
1. **Audit Group Usage**: Use the mailing and reminder tracking features to understand group utilization
2. **Start with Disable**: Use the "Disable" action initially rather than "Delete" to maintain data safety
3. **Plan Timing**: Set inactive dates well in advance to allow for final reviews

### Performance Considerations
- Smart Groups with complex criteria benefit most from scheduled management
- Regular cleanup of unused groups can significantly improve system performance
- Monitor system status regularly for pending actions

### Data Safety
- **Test First**: Try the extension in a development environment
- **Backup**: Always backup your database before bulk group operations
- **Use Disable**: Prefer disabling over deleting to maintain referential integrity

## Troubleshooting

### Common Issues

**Groups not being processed**
- Verify the scheduled job is enabled and running
- Check system status for any error messages
- Ensure proper permissions are set

**Missing menu items**
- Clear CiviCRM cache: **Administer** → **System Settings** → **Cleanup Caches and Update Paths**
- Verify extension is properly enabled

**Permission errors**
- Ensure users have appropriate permissions:
  - `access CiviCRM` for basic functionality
  - `administer CiviCRM` for group management
  - `access CiviMail` for mailing associations

### Support Resources

- **Documentation**: [GitHub Repository](https://github.com/Skvare/com.skvare.managegroup)
- **Issues**: [Report Issues](https://github.com/Skvare/com.skvare.managegroup/issues)
- **Support**: Professional support available through [Skvare](mailto:sunil@skvare.com)

## Technical Details

### Database Changes
The extension adds two fields to the `civicrm_group` table:
- `inactive_date` (TIMESTAMP): When the group should be processed
- `inactive_action` (INT): Action to take (1=Disable, 2=Delete)

### API Integration
The extension integrates with CiviCRM's API v3/v4 for:
- Group management operations
- Mailing and reminder queries
- Scheduled job execution

### Hooks Implemented
- `hook_civicrm_buildForm`: Adds fields to group edit forms
- `hook_civicrm_links`: Adds action links to group listings
- `hook_civicrm_entityTypes`: Defines custom fields
- `hook_civicrm_check`: System status integration

## License

This extension is licensed under [AGPL-3.0](LICENSE.txt).

## Contributors

- **Author**: Sunil Pawar ([@Skvare](https://github.com/Skvare))
- **Maintainer**: [Skvare](https://skvare.com)

## Changelog

### Version 1.1
- Enhanced UI templates with better styling and user experience
- Improved system status integration
- Updated documentation and screenshots
- Added comprehensive group usage tracking
- Performance optimizations

### Version 1.0
- Initial release
- Basic scheduled group actions
- Mailing association tracking

**Supporting Organizations**
[Skvare](https://skvare.com/contact)

---

**[Contact us](https://skvare.com/contact) for support or to learn more** about implementing automated group management in your CiviCRM environment.
