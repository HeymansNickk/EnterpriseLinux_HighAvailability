# Enterprise Linux Lab Report

- Student name: Heymans Nick
- Github repo: <https://github.com/HoGentTIN/elnx-2021-ha-HeymansNickk>

tweede itteratie: Opzetten van webserver met apache en mariadb en het loadbalancen tussen de webservers.

## Requirements
- webservers: apache draait en toont de zelfgeschreven php pagina 
- db: de database is aangemaakt en opgevuld.
- er word tussen de webservers geloadbalanced met HAProxy

## Test plan

### Webserver
1. via systemctl
- ssh naar web1
- run commando `systemctl status httpd`
- als service httpd op "Active: active (running)" staat is de eerste test geslaagd
1. via de webpagina
- open browser en surf naar 192.168.69.11/
- als de webpagina beschikbaar is, is de test geslaagd

### db
1. via systemctl
- ssh naar db
- run commando `systemctl status mysql`
- als service mysql op "Active: active (running)" staat is de eerste geslaagd 
- Ga naar mysal en kijk of de database is aangemaakt met commando `SHOW DATABASES;`
- kijk of de database is opgevuld met commando `use test;` en `SHOW TABLES;`.
- Kijk naar de testdata met commando `SELECT * FROM test;`

### Loadbalancer
1. via de webpagina
- open browser en surf naar 192.168.69.10/
- als de webpagina beschikbaar is, is de test geslaagd
- als er via een andere browser naar het ip adress word gesurfd zal er een andere webserver getoont worden.


- De loadbalancer gebruikt HAProxy om het verkeer tussen de verschillende webservers te balancen. 

## Documentation

- Ik heb voor apache gekozen als webserver omdat deze zeer simpel is om op te zetten en om te configuren. Hierdoor zal het ook simpeler zijn om een demo te geven van de opstelling. Ik heb een php pagina (index.php en search.php) geschreven die gegevens uit de databank haalt en deze weergeeft. Deze pagina geeft ook terug door welke webserver hij word geserved. 

- Op da de databank server word de Mariadb rol van Bert Van Vreckem(https://github.com/bertvv/ansible-role-mariadb) gebruikt aangezien deze stabiel is en gemakkelijk te configureren is. Ik had in het begin problemen om een configuratie SQL script mee te geven om de databank op te vullen. Dit bleek uiteindelijk een vergeten '../' te zijn in de variabele.
```
mariadb_databases:
  - name: test
    init_script: files/InitScript.sql
```
moest worden
```
mariadb_databases:
  - name: test
    init_script: ../files/InitScript.sql
```

- De loadbalancer was redelijk simpel om op te zetten. Ik heb de HAProxy rol van Jeff Geerling(https://github.com/geerlingguy/ansible-role-haproxy) gebruikt omdat zijn rollen altijd zeer goed werken en zeer uitgebreid zijn. Er moet niet zoveel geconfigureerd worden, enkel de ip adressen van de webservers moeten meegegeven worden en het load balancing algoritme kan ook meegegoven worden. Het standaard algoritme is 'roundrobin', dit algoritme gaat de servers gewoon in volgorde af en is dus vooral handig als alle server dezelfde resources hebben. Een ander mogelijk algoritme is 'leastconn', dit zorgt ervoor dat er verbinding word gemaakt met de server die het minst aantal open sessies heeft. Het word daarom ook vaak gebruikt voor langere sessies. Als elke server hetzelfde aantal open sessies heeft word er gebruik gemaakt van het eerder besproken 'roundrobin' algoritme.


## Test report

### Webserver

1. via systemctl

![image van de service](https://i.imgur.com/iQmDFmG.png) 

2. via de webpagina

![image van de pagina](https://i.imgur.com/AJOclP4.png) 

### db

1. via systemctl

![image van de service](https://i.imgur.com/3ABZM6v.png) 

![image van de databases](https://i.imgur.com/5YIHzyV.png) 

![image van de database tables](https://i.imgur.com/MGg4nTt.png) 

![image van de inhoud van de table test](https://i.imgur.com/8ijefJw.png) 

### Loadbalancer

1. via de webpagina

![image van de pagina](https://i.imgur.com/kT4OE6T.png) 

![image van de andere browser](https://i.imgur.com/xSazZsL.png) 

## Resources

- https://github.com/geerlingguy/ansible-role-haproxy
- https://www.haproxy.org/#docs
- https://github.com/bertvv/ansible-role-mariadb