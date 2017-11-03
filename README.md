# SU-SWS Ansible Playbooks
Collection of Ansible playbooks and roles used to migrate SWS sites, and configure Acquia servers.

**Version: 1.x**

Maintainers: [kbrownell](https://github.com/kbrownell), [jbickar](https://github.com/jbickar)

Changelog: [Changelog.txt](CHANGELOG.txt)

## Description

This is a small collection of Ansible roles that we are using to migrate sites from one environment to another, as well as configure Acquia servers with our customizations.

## Installation

1. If not already installed, `pip install ansible` or `brew install ansible`
2. `git clone git@github.com:SU-SWS/ansible-playbooks.git`
3. `cd ansible-playbooks`

## Migrating Sites
````
ansible-playbook -i inventory/sites migration-playbook.yml
````
This playbook allows you to copy sites from `sites.stanford.edu` or `people.stanford.edu`. It supports virtual hosts.

1. Copy `default.sites` into the `/inventory` directory and modify it to include only the sites you want to migrate, grouped by their site type. You can name it whatever you wish.
2. Copy `default.migration_vars.yml` to the root `ansible-playbooks` directory and name it `migration_vars.yml`. Populate it with your information.
    1. **NOTE**: Do not use your own ACSF account, as the API key cannot be reset. Use the credentials for the dedicated API user.
3. Make sure you have an active Kerberos ticket, and are on Stanford VPN (if necessary), for connecting to the .
4. Run: `ansible-playbook -i inventory/[inventory-filename] migration-playbook.yml` with the inventory you created or modified.

## Configuring ACSF Servers
````
ansible-playbook -i inventory/servers server-settings-playbook.yml
````

1. Copy `default.servers` to `inventory/servers`.
2. Copy `default.server_vars.yml` to the root `ansible-playbooks` directory and name it `server_vars.yml`. Populate it with your information.
3. Run: `ansible-playbook -i inventory/servers server-settings-playbook.yml` 

## Troubleshooting

If a task fails, you can re-run the playbook from where it failed with: 

```
ansible-playbook -i inventory/[inventory-filename] migration-playbook.yml --tags "[rolename]"
```

You can also add `-v(vvv)` for more debug information.

## Contribution / Collaboration

You are welcome to contribute functionality, bug fixes, or documentation to this module. If you would like to suggest a fix or new functionality you may add a new issue to the GitHub issue queue or you may fork this repository and submit a pull request. For more help please see [GitHub's article on fork, branch, and pull requests](https://help.github.com/articles/using-pull-requests)
