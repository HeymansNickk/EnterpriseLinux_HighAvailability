# Actuataak: ssh security met Fail2Ban

### introductie Fail2Ban 

Fail2Ban scanned log files zoals `/var/log/auth.log´ en banned ip adressen die teveel mislukte inlogpogingen doen. Deze adressen worden , voor een instelbare hoeveelheid tijd, op een zwarte lijst geplaatst. Fail2Ban maakt het bannen en unbannen van ip-adressen gamekkelijk door automatisch nieuwe regels toe te voegen aan de firewall zodat een connectie vanaf een gebanned ip-adres direct wordt tegengehouden. Het is mogelijk om voor elke service specfieke regels op te stellen. Deze groepen regels noemen we "jails".

### installatie en configuratie

- Fail2Ban installeren kan gemakkelijk via het commando `yum install fail2ban`
- Het standaard configuratie bestand is `/etc/fail2ban/jail.conf` maar dit bestand word steeds overschreven als we een upgrade doen van Fail2Ban. We gaan het bestand dus kopieren naar een ander bastand zodat onze configuratie niet verloren gaat tijdens de volgende upgrade. We kopieren het `jail.conf` bestand naar een nieuwe bestand genaamd `jail.local` met commando `sudo cp /etc/fail2ban/jail.conf /etc/fail2ban/jail.local`. We kunnen nu beginnen aan de configuratie.
- Enkele standaard variabele die zeker geconfigureerd moeten worden zijn:
  - **ignoreip**: Dit is een whitelist van ip-adressen die nooit zullen gebanned worden. De standaard warde is het loacalhost ip-adres(127.0.0.1) en zijn ipv6 versie(::1). Alle ip-adress die nooit gebanned mogen worden moeten hier gespecifierrd worden.
  - **bantime**: Dit is hoelang een ip-adress gebanned word na een bepaalde hoeveelheid mislukte inlogpogingen. De tijd kan gespecificeerd worden in minute (“m”) of uren (“h”). Als de ip-adress permanent gebanned moeten blijven kunnen we de -1 waarde toekennen.
  - **findtime**: De tijdspanne waarin er teveel loginpoginen plaatsvinden waardoor er gebanned wordt. (vb. 5 poginen(*maxretry*) in 1 minuut (*bantime*))
  - **maxretry**: De maximum hoeveelheid mislukte inlogpoggingen.
- Om ervoor te zorgen dat de "sshd" jail word gebruikt moeten we 
- Dus samengevat werkt Fail2Ban als volgt: Als er een bepaalt ip-adress de maximum hoeveelheid inlogpogingen (***maxretry***) overschrijd, binnen een bepaalde tijd (***findtime***), wordt het voor een bepaalde tijd (***bantime***) gebanned. Enkel de ip-adressen die vooraf gespecificeerd worden (***ignoreip***) kunnen een ongelimiteerd aantal inlogpogingen doen. 
- De waarden die gebruikt zullen worden in deze opstelling zijn:
  - ignoreip: 127.0.0.1/8 ::1 192.168.69.14
  - bantime: 15m
  - findtime: 2m
  - maxretry: 5
- Om ervoor te zorgen dat de "sshd" jail word gebruikt moeten we ze in ´/etc/fail2ban/jail.local´ enablen.
![image van jail.local](https://i.imgur.com/A2jaVmh.png) 
![image van jail status](https://i.imgur.com/CIwb4Ty.png) 

### Fail2Ban opstarten
Eenmaal onze configuratie in `/etc/fail2ban/jail.local` afgerond is moeten we enkel Fail2Ban nog opstarten. Dit doen we simpelweg met het commando `sudo systemctl start fail2ban`. Met het commando `sudo fail2ban-client status` kunnen we zien hoeveel, en welke, ip-adressen er in de jail zitten (en dus gebanned zijn voor 15 minuten).

### Testen van Fail2Ban
Als we vanaf een pc (met een ip-adres dat niet in de ***ignoreip*** lijst staat) een ssh connectie proberen op te zetten naar de server en meer dan 5 (***maxretry***) keer een fout wachtwoord ingeven binnen de 2 minuten(***findtime***), dan wordt het ip-adres voor 15 minuten (***bantime***) op de banlist geplaatst. Als we vervolgens nog een proberen om een ssh connectie op te zetten vanop hetzelfde ip-adress krijgen we de melding `ssh: connect to host vagrant@192.168.69.11 port 22: connection refused`.
![image van fail2ban test](https://i.imgur.com/MuSVMNc.png) 


### Automatiseren met ansible
Voor de automatisatie met ansible heb ik gekozen om de rol van nbigot te gebruiken. De rol laat ons toe om enkele waarden(zoals ignoreip, bantime, findtime en maxretry) te configureren met ansible variabelen.


### Resources
- https://galaxy.ansible.com/nbigot/ansible-fail2ban
- https://www.howtogeek.com/675010/how-to-secure-your-linux-computer-with-fail2ban/
- https://www.youtube.com/watch?v=kgdoVeyoO2E