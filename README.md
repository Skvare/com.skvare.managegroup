# com.skvare.managegroup

![Screenshot](/images/manage_group.png)

Extension to take action on group to disable it after set date.

Sometime groups were created several year back and no more used at moment, if these groups are type of Smart Group, then it lot of time build group cache when
system have hundreds of smart group (which my be, no more used).

If the admin knows the usages of any group, then they can set a date to disable the group in advance.

The extension is licensed under [AGPL-3.0](LICENSE.txt).

## Requirements

* PHP v7.2+
* CiviCRM 5.45+

## Installation (Web UI)

Learn more about installing CiviCRM extensions in the [CiviCRM Sysadmin Guide](https://docs.civicrm.org/sysadmin/en/latest/customize/extensions/).

## Installation (CLI, Zip)

Sysadmins and developers may download the `.zip` file for this extension and
install it with the command-line tool [cv](https://github.com/civicrm/cv).

```bash
cd <extension-dir>
cv dl com.skvare.managegroup@https://github.com/Skvare/com.skvare.managegroup/archive/master.zip
```

## Installation (CLI, Git)

Sysadmins and developers may clone the [Git](https://en.wikipedia.org/wiki/Git) repo for this extension and
install it with the command-line tool [cv](https://github.com/civicrm/cv).

```bash
git clone https://github.com/Skvare/com.skvare.managegroup.git
cv en managegroup
```

## Getting Started

Manage Group -> Click on Settings.
You can see two fields:
* InActive Date
* InActive Action

## Scheduled Job
* Scheduled jobs are run on a daily basis to check if any active group has an
inactive date set and that date is overdue.
* So based on the action set for that group, either group gets disabled or
  gets deleted (default action is disable group).


## Check CiviMails associated with the Group.

* Link is available in front of the group to see if any mailing is linked with this group, and
what is the last date it was used in a tabular format with other details.


![Screenshot](/images/group_in_mailing.png)


## See Group action status on System Status screen.

![Screenshot](/images/action_status.png)
