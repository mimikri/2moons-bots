# 2moons-bots
bots for 2moons browsergame engine

the bots
what they do
each bot gets a fleet, wich has ress income and fleet income
the fleet of each bot lands on a randomly choosen planet of it's own planets
when landing it gives it's ress income since the last land on a planet to the planet
after a while it will take of to space and leave some of it's ships on the planet
the fleets grow and can be shot, if timing is good(hunting gameloop) for worriors, to secure their income
the ress are protected with smaller fleet(ress farm gameloop) for smaller players

variate bot types
- how much ress contingent ist put to ship type
- how much percent of shiptype are left on the planets when lift
- how much of the ress contingent is spend to ress or to ships
- how long fleets stay in space or on planet
- different bot types wich bots can be part of
- diffent fleets for different bottypes
- multiplicator for first playerpoints as contingent bots get per month
- relation how much met,deut,cryst is put to the planets

thoughts
traditionaly bots try to mimic other players.
this bots have an other aproach.
they are as server friendly as possible.
simplifying all steps a bot would do and
they aim to provide a gameloop rather then mimic other players

installing the bots
copy cronjob and installer, 
start installer
- make is_bot flags in user and planet table(important for adminpanel, to easyer get botplanets,without making too much preasure on the db)
- make inicial bot tables(with bot types includes but not bots)
- make bots and enter id into bots_table
- set bots ships arrays
- clear planets,give research
- set cron in db
set link in adm menu
set class in admin.php
open admin.php
make cron in db
