# Enterprise Linux Lab Report

- Student name: Heymans Nick
- Github repo: <https://github.com/HoGentTIN/elnx-2021-ha-HeymansNickk>

derde itteratie: Opzetten monitoring en loadtesting

## Requirements
- De monitoring server geeft een duidelijk overzicht van alle servers en hun resources.
- De webservers worden geloadtest.

## Test plan

### Monitor - Prometheus
1. via systemctl
- ssh naar de monitor server
- run commando `systemctl status prometheus`
- als service prometheus op "Active: active (running)" staat is de eerste test geslaagd
1. via de webpagina
- open browser en surf naar `http://192.168.69.9:9090/targets`
- als de prometheus webpagina beschikbaar is en alle servers als "up" weegeeft is de test geslaagd


### Monitor - Grafana
1. via systemctl
- ssh naar de monitor server
- run commando `systemctl status grafana-server`
- als service grafana-server op "Active: active (running)" staat is de eerste test geslaagd
1. via de webpagina
- open browser en surf naar 192.168.69.9:3000/
- als de grafana webpagina beschikbaar is, is de test geslaagd

### Loadtesting
1. via systemctl
- ssh naar de monitor server
- run commando `systemctl status grafana-server`
- als service grafana-server op "Active: active (running)" staat is de eerste test geslaagd
1. via de webpagina
- open browser en surf naar 192.168.69.9:3000/
- als de grafana webpagina beschikbaar is, is de test geslaagd


## Documentation

- Ik heb tijdens deze opdracht geexperimenteerd met verschillende monitoring oplossingen. De eerst optie was op elke server Cockpit installeren en dan een zelfgeschreven inventory file meegeven aan de monitoring server zodat deze alle servers op 1 dashboard kon weergeven. Dit werkte echter alleen als de monitoring server als laatste werd opgezet en als één van de andere servers werd heropgestart kwam deze niet automatisch terug op het dashboard.

- De tweede optie die ik uitgeprobeerd het was de opensource monitoring tool Zabbix. De manuele installatie verliep redelijk vlot en werkte naar behoren, maar de automatisatie met ansible verliep zeer moeizaam. Ik heb verschillende rollen uitgeprobeerd(robertdebock, dj-wasabi) maar ik kreeg bij elk rol dezelfde 'Database error'.

- Uiteindelijk heb ik, op aanbevelen van Robin Ophalvens, gekozen voor Pometheus en Grafana als monitoring oplossing. Prometheus haalt alle data van de servers op. Grafana kan Prometheus gebruiken als data source en staat ons toe om de "ruwe" data die we van Prometheus krijgen om te zetten naar gemakkelijk te begrijpen grafieken.

## Test report

### Monitor - Prometheus
1. via systemctl
![image van de service](https://i.imgur.com/6WSWu78.png) 
2. via de webpagina
![image van de pagina](https://i.imgur.com/tDSxRKa.png) 

### Monitor - Grafana
1. via systemctl
![image van de service](https://i.imgur.com/VfnkR5Y.png) 
2. via de webpagina
![image van de pagina](https://i.imgur.com/whKjMDO.png) 
![image van de pagina](https://i.imgur.com/VZsl7P1.png) 


## Resources

- http://woshub.com/zabbix-install-configure-guide/
- https://galaxy.ansible.com/robertdebock/zabbix_repository
- https://galaxy.ansible.com/dj-wasabi