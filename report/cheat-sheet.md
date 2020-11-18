# Cheat sheet

Use this file to write down the most important commands you encounter, so you can look them up quickly. Put some clear structure in this document, or split it up if it becomes too large. [Use Markdown correctly](https://help.github.com/articles/getting-started-with-writing-and-formatting-on-github/). For inspiration and a motivation for why you should keep this type of cheat sheets, take a look at <https://github.com/bertvv/cheat-sheets/>.

## Vim survival guide

- When starting up Vim, you're in *normal mode*.
- To enter text, first go to *insert mode*.

| Taak                       | Commando |
| :---                       | :---     |
| Normal mode -> insert mode | `i`      |
| Insert mode -> normal mode | `<Esc>`  |
| Opslaan                    | `:w`     |
| Opslaan en afsluiten       | `:wq`    |
| Afsluiten zonder opslaan   | `:q!`    |

## Vagrant commands

| Taak                       | Commando |
| :---                       | :---     |
| Vagrant versie tonen | `vagrant version` |
| Vagrant omgeving lanceren | `vagrant up` |
| Vagrant omgeving opzetten zonder provisioning | `vagrant up --no-provision` |
| Vagrant omgeving opzetten met specifieke machines | `vagrant up` _namen van de machines_ |
| Vagrant machine suspenden  | `vagrant suspend` _naam van de machine_ |
| Vagrant machine herprovisionen na verandering | `vagrant provision` _naam van de machine_ ; |
| Vagrant omgeving verwijderen | `vagrant destroy` |
| Vagrant omgeving verwijderen zonder confirmatie | `vagrant destroy -f` |


## Mysql commands

| Taak                       | Commando |
| :---                       | :---     |
| Alle databanken tonen | `SHOW DATABASES;` |
| Aanduiden welke databank er als default moet gebruikt worden voor de volgende commands | `use` _naam van de databank_ ; |
| Alle tables laten zien | `SHOW TABLES;` |
| Beschrijf de columns van een table | `DESCRIBE` _naam van de table_ ; |
| Alle gegevens van een table opvragen | `SELECT * FROM` _naam van de table_ ; |
| Table verwijderen | `DROP TABLE` _naam van de table_ ; |
| Database verwijderen | `DROP DATABASE` _naam van de database_; |
