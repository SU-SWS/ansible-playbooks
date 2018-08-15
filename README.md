# SU-SWS Ansible Playbooks
Collection of Ansible playbooks and roles used to migrate SWS sites, and configure Acquia servers.

**Version: master**

Maintainers: [kbrownell](https://github.com/kbrownell), [jbickar](https://github.com/jbickar)

Changelog: [Changelog.txt](CHANGELOG.txt)

## Description

This is a small collection of Ansible roles that we are using to migrate sites from one environment to another, as well as configure Acquia servers with our customizations.

## Installation

1. If not already installed, `pip3 install ansible` or `brew install ansible`
2. Install jmespath: `pip3 install jmespath`
3. `git clone git@github.com:SU-SWS/ansible-playbooks.git`
4. `cd ansible-playbooks`
5. `git clone git@github.com:SU-SWS/ansible-sync`

## Migrating Sites

### Creating and Migrating Sites
````
ansible-playbook -i inventory/sites full-migration-playbook.yml
````
This playbook allows you to copy sites from `sites.stanford.edu` or `people.stanford.edu`. It supports virtual hosts.

1. Copy `default.sites` into the `/inventory` directory and modify it to include only the sites you want to migrate, grouped by their site type. You can name it whatever you wish.
2. Copy `default.migration_vars.yml` to the root `ansible-playbooks` directory and name it `migration_vars.yml`. Populate it with your information.
    1. **NOTE**: Do not use your own ACSF account, as the API key cannot be reset. Use the credentials for the dedicated API user.
3. Make sure you have an active Kerberos ticket, and are on Stanford VPN (if necessary), for connecting to the sites/people servers.
4. Run: `ansible-playbook -i inventory/[inventory-filename] full-migration-playbook.yml` with the inventory you created or modified.

### Creating Sites on ACSF (only)
````
ansible-playbook -i inventory/sites acsf-site-setup-playbook.yml
````
This playbook allows you to create sites on ACSF based on values of sites on `sites.stanford.edu` or `people.stanford.edu`. It supports virtual hosts.

It **only** sets up the sites on ACSF; it does **not** migrate them. When creating new sites via the ACSF API, the factory will queue the new site creation and only create 3 at a time. Thus, this playbook can be run prior to a mass migration.

1. Copy `default.sites` into the `/inventory` directory and modify it to include only the sites you want to create, grouped by their site type. You can name it whatever you wish.
2. Copy `default.migration_vars.yml` to the root `ansible-playbooks` directory and name it `migration_vars.yml`. Populate it with your information.
    1. **NOTE**: Do not use your own ACSF account, as the API key cannot be reset. Use the credentials for the dedicated API user.
3. Make sure you have an active Kerberos ticket, and are on Stanford VPN (if necessary), for connecting to the sites/people servers.
4. Run: `ansible-playbook -i inventory/[inventory-filename] acsf-site-setup-playbook.yml` with the inventory you created or modified.

### Migrating Sites on ACSF (only)
````
ansible-playbook -i inventory/sites migration-sync-only-playbook.yml
````
This playbook allows you to migrate sites from `sites.stanford.edu` or `people.stanford.edu` to ACSF.

It **only** syncs the content of the sites to ACSF; it does **not** create them. The sites **must** exist on ACSF, or else you will be a sad puppy.

1. Copy `default.sites` into the `/inventory` directory and modify it to include only the sites you want to create, grouped by their site type. You can name it whatever you wish.
2. Copy `default.migration_vars.yml` to the root `ansible-playbooks` directory and name it `migration_vars.yml`. Populate it with your information.
    1. **NOTE**: Do not use your own ACSF account, as the API key cannot be reset. Use the credentials for the dedicated API user.
3. Make sure you have an active Kerberos ticket, and are on Stanford VPN (if necessary), for connecting to the sites/people servers.
4. Run: `ansible-playbook -i inventory/[inventory-filename] migration-sync-only-playbook.yml` with the inventory you created or modified.

### Adding Virtual Hosts as Custom Domains to Sites on ACSF (only)
````
ansible-playbook -i inventory/sites add-vhost-playbook.yml
````
This playbook allows you to add vhosts as custom domains to sites on ACSF.

It **only** add custom domains to sites *already on* ACSF; it does **not** create or migrate them. The sites **must** exist on ACSF, or else this playbook will fail.

1. Copy `default.sites` into the `/inventory` directory and modify it to include only the sites you want to create, grouped by their site type. You can name it whatever you wish.
2. Copy `default.migration_vars.yml` to the root `ansible-playbooks` directory and name it `migration_vars.yml`. Populate it with your information.
    1. **NOTE**: Do not use your own ACSF account, as the API key cannot be reset. Use the credentials for the dedicated API user.
3. Run: `ansible-playbook -i inventory/[inventory-filename] add-vhost-playbook.yml` with the inventory you created or modified.

### Release Process and Versioning

We track which version of the migration script was used to migrate individual sites.  When creating a new release, make sure to update the `migration_version` variable in `group_vars/all.yml`. This sets the Drupal variable `sws_migration_version` to the version number (e.g., `0.0.1`)

For final pre-launch site migrations use _only_ a tagged version of this playbook.

After creating a release, change the `migration_version` variable back to `master`. Thus:
- dev/test site migrations should have:
    - `sws_migration_version` = `master`
- production launched migrations should have:
    - `sws_migration_version` = `M.m.p`

## Configuring ACSF Servers
````
ansible-playbook -i inventory/servers server-settings-playbook.yml
````

1. Copy `default.servers` to `inventory/servers`.
2. Copy `default.server_vars.yml` to the root `ansible-playbooks` directory and name it `server_vars.yml`. Populate it with your information.
3. Run: `ansible-playbook -i inventory/servers server-settings-playbook.yml`

## Troubleshooting

### Failed Tasks

If a task fails, you can re-run the playbook from where it failed with:

```
ansible-playbook -i inventory/[inventory-filename] migration-playbook.yml --tags "[rolename]"
```

You can also add `-v(vvv)` for more debug information.

### SSL Issues

If you are on OSX and are having SSL certificate troubles please view: https://docs.ansible.com/ansible/latest/reference_appendices/python_3_support.html

It may help to add one of the following to `migration_vars.yml`
```
ansible_python_interpreter=/usr/local/bin/python3
ansible_python_interpreter=/usr/bin/python3
```

Or run `ansible-playbook` with the `-e ansible_python_interpreter=/usr/local/bin/python3` option.

## Contribution / Collaboration

You are welcome to contribute functionality, bug fixes, or documentation to this module. If you would like to suggest a fix or new functionality you may add a new issue to the GitHub issue queue or you may fork this repository and submit a pull request. For more help please see [GitHub's article on fork, branch, and pull requests](https://help.github.com/articles/using-pull-requests)
