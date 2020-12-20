# Enterprise Linux Lab Report

- Student name: Heymans Nick
- Github repo: <https://github.com/HoGentTIN/elnx-2021-ha-HeymansNickk>

Eerste itteratie: Opzetten van webserver met nginx en wordpress

## Requirements
- web1: webserver is vanaf hostmachine beschikbaar.
- web1: Nginx draait en toont testpagina 
- web1: Wordpress draait en toont pagina


## Test plan

### Beschikbaarheid
- open terminal op hostmachine
- run commando `ping 192.168.69.10`
- Als de server juist is geconfigureerd word er een pong teruggestuurd.

### Nginx en wordpress
1. via systemctl
- ssh naar web1
- run commando `systemctl status nginx`
- als service ngnix op "Active: active (running)" staat is de eerste test geslaagd
1. via de webpagina
- open browser en surf naar 192.168.69.10/
- als de webpagina beschikbaar is, is de test geslaagd

### PHP
- surfen naar 192.168.69.10/phpinfo.php
- Als alle gegevens over de php versie worden weergeven is de test geslaagd.

## Documentation

- Nginx is een zeer krachtige en effeciente webserver.
- Wordpress is een opensource contentmagementsysteem die PHP gebruikt.
- Ik had deze combinatie gekozen omdat we deze in projecten 3 ook gebruikten, maar deze blijkt moeilijk te configuren zijn. Het is ook ni zo gemakkelijk om een werkende demo te maken van deze opstelling die duidelijk alle functionaliteit toont. Ik ga om deze reden in het vervolg werken met Apache en zelf een demo PHP pagina schrijven

## Test report
### Beschikbaarheid
- De server reageerd en we kunnen er dus vanuit gaan dat het netwerkgedeelte correct is.

### Nginx en wordpress
- De nginx testpagina word getoont maar wordpress kan geen databank vinden (er is er ook geen aanwezig op het systeem).

### PHP
- De php info pagina toont ons data php versie 7.4.12 is geïstalleerd.


## Troubleshooting

- Bij het aanpassen van een host only adapter wil virtualbox de aanpassing niet opslaan.
  - Oplossing: via ncpa.cpl de adapter aanpasen
- Ansible werk niet op de met vagrant aangemaakte vm's omdat de geïstalleerde guest additions niet overeenkwamen met de guest additions op de vm's
  - Stappen:
    - Ik had eerst een plugin (vagrant-vbguest) geïstalleerd maar deze bleek niet te werken.
    - Ik had ook vagrant geïstalleerd via chocolatey, maar op de site van vagrant stond dat het best niet via een package manager werd geïstalleerd (https://i.imgur.com/iyuQp9h.png).
    - Uiteindelijk heb ik vagrant en virtualbox volledig opnieuw geïstalleerd, maar hiermee wa het probleem nog niet opgelost.
    - Er bleek een plugin file te zijn die het verwijderen van vagrant had overleefd en ik bleef dus werken met de (onstabiele) plugin.
    - Pas later had ik door dat het probleem kwam door dit bestand en heb ik het verwijderen.

## Resources

- https://galaxy.ansible.com/bertvv
- https://galaxy.ansible.com/geerlingguy
- https://github.com/bertvv/ansible-skeleton
- https://github.com/bertvv/ansible-role-rh-base
- https://github.com/dotless-de/vagrant-vbguest
- https://sysadmincasts.com/episodes/43-19-minutes-with-ansible-part-1-4
- https://www.youtube.com/playlist?list=PL2_OBreMn7FqZkvMYt6ATmgC0KAGGJNAN
- https://sysadmincasts.com/episodes/45-learning-ansible-with-vagrant-part-2-4
- https://sysadmincasts.com/episodes/46-configuration-management-with-ansible-part-3-4
- https://sysadmincasts.com/episodes/47-zero-downtime-deployments-with-ansible-part-4-4
- https://learn.hashicorp.com/tutorials/vagrant/getting-started-install?in=vagrant/getting-started
