
CREATE TABLE IF NOT EXISTS `uni1_bots` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `owner_id` int(11) DEFAULT 0 COMMENT 'user id of bot',
  `ress_bonus_time` int(11) DEFAULT 0,
  `stationed_planet_id` int(11) DEFAULT 0 COMMENT 'if the fleet is stationed on a planet, this is the id of the planet',
  `next_fleet_action` int(11) DEFAULT 0 COMMENT 'when landing or lifting the fleet, the time of next activity is put here.',
  `action_index` int(11) DEFAULT 0 COMMENT '0 = fleet is in space, 1 = fleet is on planet',
  `ships_array` text DEFAULT NULL COMMENT 'serialized ships array, like this: array(array(''bonus_time'' => 0, ''name'' => $ship[''name''], ''amount'' => 0) , ...)',
  `bot_type` int(11) DEFAULT 0 COMMENT 'different types use different bot_setting row',
  PRIMARY KEY (`id`),
  KEY `id` (`id`),
  KEY `next_action` (`next_fleet_action`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=102 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


CREATE TABLE IF NOT EXISTS `uni1_bot_setting` (
  `id` float NOT NULL DEFAULT 0,
  `name` varchar(50) DEFAULT 'honk' COMMENT 'this is the name of the bot_type for better orientation in administration',
  `metal_per_second` decimal(65,10) DEFAULT 0.0000000000 COMMENT 'metal per planet per sec (gets set automaticly at the start of a period)',
  `crystal_per_second` decimal(65,10) DEFAULT 0.0000000000 COMMENT 'crystem per planet per sec',
  `deuterium_per_second` decimal(65,10) DEFAULT 0.0000000000 COMMENT 'deuterium per planet per sec',
  `last_set` int(11) DEFAULT 0 COMMENT 'timestamp from the start of the running period(30 days)',
  `last_bot` int(11) DEFAULT 0 COMMENT 'id of the last bot wich have got his ress production',
  `ress_contingent` bigint(50) DEFAULT 0 COMMENT 'max res output for planets for the period',
  `ress_ships_contingent` bigint(50) DEFAULT 0,
  `full_contingent` bigint(50) DEFAULT 0 COMMENT 'max ress+ships(in ress) output for this period (30 days)',
  `full_contingent_used` decimal(65,10) DEFAULT 0.0000000000 COMMENT 'saves how many ress in fleet and resshave been outputted, since the start of the 30 day period',
  `ress_ships_contingent_used` decimal(65,10) DEFAULT 0.0000000000,
  `ress_contingent_used` decimal(65,10) DEFAULT 0.0000000000 COMMENT 'saves how much ress are put to plannets of all bots, since the start of the 30 day period',
  `first_points_multiplicator` int(11) DEFAULT 1 COMMENT 'multiplicate with first playerpoints * 1000 to set the ress value wich will be put into the universe',
  `bot_status` int(11) DEFAULT 1 COMMENT '0 = bots turned off, for protection of uni income',
  `ress_value_metal` float DEFAULT 0.5 COMMENT 'defines how much of the ress on the planets will be metal (0.3 = 30%)',
  `ress_value_crystal` float DEFAULT 0.3 COMMENT 'defines how much of the ress on the planets will be crystal (0.3 = 30%)',
  `ress_value_deuterium` float DEFAULT 0.2 COMMENT 'defines how much of the ress on the planets will be deuterium (0.3 = 30%)',
  `max_fleet_seconds_in_space` int(11) DEFAULT 10800 COMMENT 'fleet stays in spae for min 1h , this defines the max. time is chosen random between min and max. in seconds',
  `min_fleet_seconds_in_space` int(11) DEFAULT 3600,
  `max_fleet_seconds_on_planet` int(11) DEFAULT 7200 COMMENT 'fleet stays on planet for min 10min , this defines the max. time is chosen random between min and max. in seconds',
  `min_fleet_seconds_on_planet` int(11) DEFAULT 720,
  `ships_array` text DEFAULT NULL COMMENT 'serialized ships array, like this: array(array(shipvalue, name, leave_on_planet,cintingent_used,per_second,contingent) , ...)',
  `number_of_bots` int(11) DEFAULT 100 COMMENT 'is used to devide the monthly income under the bots',
  `ress_factor` float DEFAULT 0.1 COMMENT 'factor is used to determine how much of the monthly contingent is spend to ress , the rest is for fleet',
  `is_bot` int(11) DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


