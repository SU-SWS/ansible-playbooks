# SU-SWS Ansible Playbooks
Collection of Ansible playbooks and roles used to migrate SWS sites.

##### Version: 1.x

Maintainers: [kbrownell](https://github.com/kbrownell), [jbickar](https://github.com/jbickar)

Changelog: [Changelog.txt](CHANGELOG.txt)

Description
---

This is a small collection of Ansible roles that we are using to migrate sites from one server to another.

Installation
---

1. If not already installed, `pip install ansible` or `brew install ansible`
2. `git clone git@github.com:SU-SWS/ansible-playbooks.git`
3. `cd ansible-playbooks`
4. Look at the `/inventory` directory and either modify or create a file that includes only the sites you want to migrate, grouped by their site type.
5. Make sure you have an active Kerberos ticket.
6. Run: `ansible-playbook -i inventory/[inventory-filename] -c local migration-playbook.yml` with the inventory you created or modified.

Troubleshooting
---

If a task fails, you can re-run the playbook from where it failed with: `ansible-playbook -i inventory/[inventory-filename] -c local migration-playbook.yml --start-at-task="name of the task you want to start from"`.

You can also add `-v(vvv)` for more debug information. 

Contribution / Collaboration
---

You are welcome to contribute functionality, bug fixes, or documentation to this module. If you would like to suggest a fix or new functionality you may add a new issue to the GitHub issue queue or you may fork this repository and submit a pull request. For more help please see [GitHub's article on fork, branch, and pull requests](https://help.github.com/articles/using-pull-requests)
