# Overzicht van de opstelling
| Servers |                   |
| :------ | :---------------- |
| lb      | Loadbalancer      |
| web1-6  | Webservers        |
| db      | Database server   |
| monitor | Monitoring server |

## Algemeen

| Rollen          | Gebruikt voor            |
| :-------------- | :----------------------- |
| bertvv.rh-base  | Basic linux configuratie |
| nbigot.fail2ban | Rol voor actuataak       |

### bertvv.rh-base
Deze rol wordt gebruikt om de basic setup van een RedHat-basied linux distribution (zoals CentOS). De rol is verantwoordelijk voor het managen van repositories, het installeren/verwijderen van specifieke packages, het aan/uit zetten van services, basic account managaging en firewall/SELinux configuratie.

#### Variabelen
```yml
rhbase_repositories:
  - epel-release

rhbase_install_packages:
  - git
  - tree
  - vim
  - htop
  - wget
  - vim
  - bash-completion
  - policycoreutils
  - setroubleshoot-server
  
rhbase_firewall_allow_ports: 
  - 9090/tcp
  - 9100/tcp
```
- *rhbase_repositories* zorgt ervoor dat er extra repositorie kunnen worden gebruikt.
- *rhbase_install_packages* installeerd gespecificeerde packages.
- *rhbase_firewall_allow_ports* zet bepaalde poorten open in de firewall.


### nbigot.fail2ban
Dit is de rol die gebruikt om Fail2Ban te installeren en configureren. Voor verdere uitleg zie [actuataak](./actua/Actuataak.md)

#### Variabelen
```yml
fail2ban_loglevel: INFO
fail2ban_logtarget: /var/log/fail2ban.log

fail2ban_ignoreself: "true"
fail2ban_ignoreips: "127.0.0.1/8 ::1 192.168.69.14"

fail2ban_bantime: 900
fail2ban_findtime: 120
fail2ban_maxretry: 5
```
- *fail2ban_loglevel* duidt het log level van Fail2Ban aan. Momenteel wordt alle info gelogt.
- *fail2ban_logtarget* is de locatie van de log file.
- *fail2ban_ignoreself* zorgt ervoor dat het ip-adres van de server zelf niet gebanned kan worden.
- *fail2ban_ignoreips* zijn de whitelist adressen.
- *fail2ban_bantime* stelt de bantime in. 
- *fail2ban_findtime* stelt de findtime variabele in. 
- *fail2ban_maxretry* stelt de max retry variabele in. 

## Loadbalancer

| Rollen                     | Gebruikt voor                    |
| :------------------------- | :------------------------------- |
| geerlingguy.haproxy        | Load Balancing rol               |
| cloudalchemy.node-exporter | Stuurt data door naar prometheus |
| nbigot.fail2ban            | Rol voor actuataak               |

### geerlingguy.haproxy 
Deze rol installeerd en configureerd HAProxy. HAProxy is zo geconfigureerd dat hij alle inkomende requests doorstuurd naar 1 van de achterliggende webservers (web1-6). Hij kiest de webserver aan de hand van het "roundrobin" algoritme.

#### Variabelen
```yml
rhbase_firewall_allow_services:
  - http
  - https

haproxy_backend_servers:
  - name: web1
    address: 192.168.69.11:80
  - name: web2
    address: 192.168.69.12:80
  - name: web3
    address: 192.168.69.13:80
  - name: web4
    address: 192.168.69.14:80
  - name: web5
    address: 192.168.69.15:80
  - name: web6
    address: 192.168.69.16:80
```
- *haproxy_backend_servers* steld alle achterliggende servers in zodat HAProxy weet waar hij de requests naartoe kan sturen.

### cloudalchemy.node-exporter
Deze rol stelt onze monitoring server in staat om data over deze server op te vragen.

## Webservers

| Rollen                     | Gebruikt voor                                   |
| :------------------------- | :---------------------------------------------- |
| httpd-test                 | Installeerd Apache en zet custom php webpaginas |
| cloudalchemy.node-exporter | Stuurt data door naar prometheus                |

### http-test
Deze rol is verantwoordelijk voor het installeren van Apache en voegt ook mijn php pagina's toe.

#### Variabelen
```yml
rhbase_install_packages:
  - php
  - php-opcache

rhbase_firewall_allow_services:
  - http
  - https
  - mysql

rhbase_selinux_booleans:
  - httpd_can_network_connect
  - httpd_can_network_connect_db
  - mysql_connect_http
```
- *rhbase_install_packages* steld alle achterliggende servers in zodat HAProxy weet waar hij de requests naartoe kan sturen.
- *rhbase_firewall_allow_services* past de firewall aan zodat de gespecificeerde services door worden gelaten.
- *rhbase_selinux_booleans* configureerd enkele SELinux booleans.

## Database

| Rollen                     | Gebruikt voor                    |
| :------------------------- | :------------------------------- |
| bertvv.mariadb             | Rol om mariadb te instaleren     |
| cloudalchemy.node-exporter | Stuurt data door naar prometheus |

### bertvv.mariadb
Deze rol installeerd MariaDB en laat ons toe om via variabele een volledige database server op te zetten.

#### Variabelen

```yml
rhbase_firewall_allow_services: 
  - mysql

rhbase_firewall_allow_ports: 
  - 3306/tcp

mariadb_bind_address: '192.168.69.17'

mariadb_root_password: test

mariadb_users:
  - name: nick
    password: itsasekrit
    priv: 'test.*:ALL'
    append_privs: 'yes'
    host: '192.168.69.%'

mariadb_databases:
  - name: test
    init_script: ../files/InitScript.sql
```
- *mariadb_bind_address* stelt het bind adress van mariadb in. 
- *mariadb_root_password* stelt het root wachtwoord in. 
- *mariadb_users* zorgt ervoor dat we user en hun permisies kunnen aanmaken.
- *mariadb_databases* creert databanken aan de hand van het script dat op de *init_script* locatie staat. 

## Monitor

| Rollen                  | Gebruikt voor                   |
| :---------------------- | :------------------------------ |
| cloudalchemy.prometheus | Rol om prometheus te instaleren |
| cloudalchemy.grafana    | Rol om Grafana te instaleren    |

### cloudalchemy.prometheus
Deze rol installeerd en configureerd Prometheus. Prometheus steld ons in staat om data van de verschillende servers/nodes(die de cloudalchemy.node-exporter rol hebben) op te vragen. 

### Variabelen
```yml
prometheus_global:
  scrape_interval: 5s
  scrape_timeout: 5s
  evaluation_interval: 60s 

prometheus_targets:
  node:  # This is a base file name. File is located in "{{ prometheus_config_dir }}/file_sd/<<BASENAME>>.yml"
    - targets:              #
        - 192.168.69.11:9100
        - 192.168.69.12:9100
        - 192.168.69.13:9100
      labels:               #
        env: Webservers    
        job: node  
    - targets:              #
        - 192.168.69.10:9100
      labels:               #
        env: Loadbalancer    
        job: node 
    - targets:              #
        - 192.168.69.17:9100
      labels:               #
        env: Database 
        job: node 
```
- *prometheus_global* stelt doe timing van de dataverzameling in.
- *prometheus_targets* zijn alle targets die door prometheus gemonitord worden. 
- *labels* laat ons toe om verschillende servers te groeperen.
- *env* is de naam van de groep
- *job* is de soort server (in dit geval zijn alle servers gewone nodes)

### cloudalchemy.grafana
Grafana gebruikt de data die prometheus heeft verzameld en staat ons toe er grafieken en dashboards van te maken.

#### Variabelen
```yml
grafana_datasources:
  - name: prometheus
    type: prometheus
    access: proxy
    url: 'http://192.168.69.9:9090/'
    basicAuth: false

grafana_security:
  admin_user: admin
  admin_password: admin

grafana_dashboards:
  - dashboard_id: 10180
    revision_id: 1
    datasource: prometheus
  - dashboard_id: 1860
    revision_id: 21
    datasource: prometheus
```
- *grafana_datasources* stelt prometheus in als datasource die zal gebruikt worden in onze dashboards.
- *grafana_security* stelt de user en password van grafana in.
- *grafana_dashboards* laat ons toe om verschillende dashboard templates automatisch importeren.