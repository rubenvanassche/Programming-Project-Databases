#Please note that most of our queries are in this form:
$results = DB::select("SELECT * FROM bet WHERE user_id = ?
                     AND EXISTS (
                        SELECT * FROM `match`
                        WHERE id = match_id
                        AND date < CURDATE())", array($user_id));
#These are raw queries, but prepared as to avoid sql injections.
#in this file we'll use a more readable format.
#We don't show the array of variables to be prepared. You don't need to know their names to be able to interpret the query.
#In some queries, something like .self::TABLE_CARD. appears. At first we used this so that we would be able to change the table name 
#without having to update all queries. Soon we realised we weren't going to change them and stopped using this.


#########
#Bet.php#
#########
# Add a bet to the database, the ? corresponds to the variables used for this insert.
INSERT INTO `".self::TABLE_BET."` (match_id, user_id, hometeam_score, awayteam_score, first_goal, hometeam_yellows, hometeam_reds, awayteam_yellows, awayteam_reds, betdate) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)

#Get past bets by user_id
SELECT * FROM bet WHERE user_id = $user_id
AND EXISTS (
  SELECT * FROM `match`
  WHERE id = match_id
  AND date < CURDATE())

#Get future bets by user_id
SELECT * FROM bet WHERE user_id = $user_id
AND EXISTS (
  SELECT * FROM `match`
  WHERE id = match_id
  AND date > CURDATE())

#Used in method to check whether a certain user has bet on a certain match.
SELECT id FROM `bet` WHERE user_id = $user_id AND match_id = $match_id

#Select one bet on a certain match (select evaluated to check whether or not there are bets at all on that match)
SELECT evaluated FROM `bet` WHERE match_id = $match_id LIMIT 1

#Select all bets on a certain match.
SELECT * FROM bet WHERE match_id = $match_id

#Update bet row to show that it's been evaluated.
UPDATE bet SET evaluated = 1 WHERE id = $bet->id

#Update user's betscore after evaluating a bet.
UPDATE user SET betscore = $points WHERE id = $bet->user_id

#Select all matches played before this moment in time.
SELECT id FROM `match` WHERE date < $now

############
##Card.php##
############
#Get id from selected card from `cards`.
SELECT id FROM `".self::TABLE_CARD."` WHERE match_id = ? AND player_id = ? AND time = ? AND color = ?

#Add a card to the database.
INSERT INTO `".self::TABLE_CARD."` (player_id, match_id, color, time) VALUES (?, ?, ?, ?)

#############
##Coach.php##
#############
#Select a coach's id by name.
SELECT id FROM `".self::TABLE_COACH."` WHERE name = ?

#Add a coach to the database.
INSERT INTO `".self::TABLE_COACH."` (name) VALUES (?)

#Select a coach's name by id.
SELECT name FROM coach WHERE id = ?

#################
#Competition.php#
#################
#Select a competition's id by name.
SELECT id FROM `".self::TABLE_COMPETITION."` WHERE name = ?

#Add a competition to the database.
INSERT INTO `".self::TABLE_COMPETITION."` (name) VALUES (?)

#Link a team to a competition.
INSERT INTO `'.self::TABLE_TEAM_PER_COMPETITION.'` (team_id, competition_id) VALUES (?, ?)

#Get all competitions.
SELECT * FROM `.self::TABLE_COMPETITION.`

#Get all teams from a certain competition sorted by name.
SELECT team.name, team.id as teamid, country.abbreviation
FROM team, teamPerCompetition, country
WHERE country.id = team.country_id
AND team.id = teamPerCompetition.team_id
AND teamPerCompetition.competition_id = ?
ORDER BY team.name

#Get all matches from a certain competition sorted by descending date.
SELECT id, hometeam_id, awayteam_id
FROM `match`
WHERE competition_id = ?
ORDER BY date DESC

###############
#Continent.php#
###############
#Select a continent's id by name.
SELECT id FROM `".self::TABLE_CONTINENT."` WHERE name = ?

#Add a continent to the database.
INSERT INTO `".self::TABLE_CONTINENT."` (name) VALUES (?)

#############
#Country.php#
#############
#Get country's id by name.
SELECT id FROM `".self::TABLE_COUNTRY."` WHERE name = ?

#Add country to the database.
INSERT INTO `".self::TABLE_COUNTRY."` (name, continent_id, abbreviation) VALUES (?, ?, ?)

#Get country by id.
SELECT * FROM `".self::TABLE_COUNTRY."` WHERE id = ?

#Get countries (id and name).
SELECT id, name FROM `".self::TABLE_COUNTRY"`

#Get country's name by id.
SELECT name FROM ".self::TABLE_COUNTRY." WHERE id = ?

##########
#Goal.php#
##########
#Get the id of the given goal.
SELECT id FROM `".self::TABLE_GOAL."` WHERE match_id = ? AND team_id = ? AND player_id = ? AND time = ?

#Add a goal to the database.
INSERT INTO `".self::TABLE_GOAL."` (match_id, team_id, player_id, time) VALUES (?, ?, ?, ?)

#Get the goals of a given team made in a given match.
SELECT id FROM `".self::TABLE_GOAL."` WHERE match_id = ? AND team_id = ?

###########
#Match.php#
###########
#Get the ids of a given match.
SELECT * FROM `".self::TABLE_MATCH."` WHERE hometeam_id = ? AND awayteam_id = ? AND competition_id = ? AND date = ?

#Add a match to the database.
INSERT INTO `".self::TABLE_MATCH."` (hometeam_id, awayteam_id, competition_id, date, phase, group_nr) VALUES (?, ?, ?, ?, ?, ?)

#Link a player to a match.
INSERT INTO `'.self::TABLE_PLAYER_PER_MATCH.'` (player_id, match_id, intime, outtime) VALUES (?, ?, ?, ?)

#Update a player's information about that match because of the substitution.
UPDATE `".self::TABLE_PLAYER_PER_MATCH."` SET `outtime` = ? WHERE `player_id` = ? AND `match_id` = ?

#Get all matches past today's date.
SELECT `id` FROM `match` WHERE `competition_id` = ? AND `date` <= ?

#Trivial selects
SELECT id FROM `competition` WHERE name = ?

SELECT * FROM `match` WHERE id = ?

SELECT * FROM `match` WHERE hometeam_id = ? AND awayteam_id = ?

SELECT * FROM `match` WHERE hometeam_id = ?

SELECT * FROM `match` WHERE awayteam_id = ?

#Get $amount of recent matches.
SELECT * FROM `match` WHERE date < CURDATE() ORDER BY date DESC LIMIT $amount

#Get $amount of future matches.
SELECT * FROM `match` WHERE date > CURDATE() ORDER BY date LIMIT $amount

#Get the score of a given match.
SELECT
  (SELECT COUNT(id) FROM goal WHERE team_id = `match`.hometeam_id AND match_id = `match`.id) as hometeam_score,
  (SELECT COUNT(id) FROM goal WHERE team_id = `match`.awayteam_id AND match_id = `match`.id) as awayteam_score
  FROM `match` WHERE id = ?

#Get information about a match given a match_id.
SELECT date,
hometeam_id,
awayteam_id,
(SELECT name FROM team WHERE id = `match`.hometeam_id) AS hometeam,
(SELECT name FROM team WHERE id = `match`.awayteam_id) AS awayteam,
(SELECT COUNT(id) FROM goal WHERE team_id = `match`.hometeam_id AND match_id = `match`.id) as hometeam_score,
(SELECT COUNT(id) FROM goal WHERE team_id = `match`.awayteam_id AND match_id = `match`.id) as awayteam_score
FROM `match` WHERE id = ?

#Get goals from a given team in a given match.
SELECT time, (SELECT name FROM player WHERE id = goal.player_id) as player,
(SELECT id FROM player WHERE id = goal.player_id) as player_id FROM goal
WHERE match_id = ? AND team_id = ?

#Get cards from a given team in a given match.
ELECT color, time, (SELECT name FROM player WHERE player.id = cards.player_id) AS player,
player_id FROM cards
WHERE match_id = ?
AND EXISTS(
  SELECT playerPerTeam.player_id FROM playerPerTeam
  WHERE playerPerTeam.player_id = cards.player_id
  AND playerPerTeam.team_id = ?)

#Get all substitutions from a given team in a given match.
SELECT intime, outtime, name, player_id FROM playerPerMatch, player
WHERE match_id = ?
AND player.id = playerPerMatch.player_id
AND player_id
IN (
  SELECT player_id
  FROM playerPerTeam
  WHERE team_id = ?

#Get the phase of a given match.
SELECT phase, group_nr FROM `match` where id = ?

#Get the score of a given match.
SELECT
(SELECT COUNT(id) FROM goal WHERE team_id = `match`.hometeam_id AND match_id = `match`.id) as hometeam_score,
(SELECT COUNT(id) FROM goal WHERE team_id = `match`.awayteam_id AND match_id = `match`.id) as awayteam_score
FROM `match` WHERE id = ?

#Get the team_id from the team that scored the first goal in a match.
SELECT team_id
FROM goal
WHERE match_id = ?
AND time = (
  SELECT min(time)
  FROM goal
  WHERE match_id = ?)

#Get all yellow cards from a team in a certain match.
SELECT count(player_id) AS yellows FROM cards WHERE color = 'yellow'
AND match_id = ?
AND EXISTS (
  SELECT playerPerTeam.player_id
  FROM playerPerTeam
  WHERE playerPerTeam.player_id = cards.player_id
  AND playerPerTeam.team_id = ?)

#Get all red cards from a team in a certain match.
SELECT count(player_id) AS reds FROM cards WHERE color = 'red'
AND match_id = ?
AND EXISTS (
  SELECT playerPerTeam.player_id
  FROM playerPerTeam
  WHERE playerPerTeam.player_id = cards.player_id
  AND playerPerTeam.team_id = ?)

#Get the match given a hometeam_id, awayeam_id and date.
SELECT * FROM `match` WHERE hometeam_id = ? AND awayteam_id = ? AND date = ?

#Get all matches that are to be played in the next coming $days.
SELECT `match`.id, date, hometeam_id, awayteam_id, (SELECT name FROM team WHERE id = `match`.hometeam_id) AS hometeam,
(SELECT name FROM team WHERE id = `match`.awayteam_id) AS awayteam
FROM `match`
WHERE DATEDIFF(`date`, CURDATE()) <= ?
AND DATEDIFF(`date`, CURDATE()) >= 0

#Get all matches that are to be played in the next coming $days and where $user hasn't bet on yet.
SELECT `match`.id, date, hometeam_id, awayteam_id,
(SELECT name FROM team WHERE id = `match`.hometeam_id) AS hometeam,
(SELECT name FROM team WHERE id = `match`.awayteam_id) AS awayteam
FROM `match`, `bet`
WHERE DATEDIFF(`date`, CURDATE()) <= ?
AND DATEDIFF(`date`, CURDATE()) >= 0
AND `match`.id NOT IN (
  SELECT match_id
  FROM `bet`
  WHERE `bet`.user_id = ?)

###################
#Notifications.php#
###################
# Add a notification to the database, the ? corresponds to the variables used for this insert.
INSERT INTO `notifications` (actor_id, subject_id, object_id, type_id, status, created_date, updated_date) VALUES (?, ?, ?, ?, ?, ?, ?)

#Select a notification inner joined with the actor (user) and subject (user)
#that is meant for the subject and that has not yet been seen. (Limited to 20)
SELECT nf.*, actor.username AS actor_name, subject.username AS subject_name
FROM notifications nf
INNER JOIN user actor ON nf.actor_id = actor.id
INNER JOIN user subject ON nf.subject_id = subject.id
WHERE subject_id = $subjectID
AND status = 'unseen'
LIMIT 0, 20

#This does the same as the previous query, however it only selects notifications of a certain type.
SELECT nf.*, actor.username AS actor_name, subject.username AS subject_name
FROM notifications nf
INNER JOIN user actor ON nf.actor_id = actor.id
INNER JOIN user subject ON nf.subject_id = subject.id
WHERE subject_id = $subjectID
AND status = 'unseen'
AND type_id = $type
LIMIT 0, 20

#Trivial selects
SELECT * FROM `userGroupInvites` WHERE `id` = $objectId

SELECT * FROM `userGroupMessages` WHERE `id` = $objectId

SELECT name
FROM userGroup
WHERE id = {$row['object']->usergroupId}

SELECT username
FROM user
WHERE id = {$row['actor_id']}

SELECT * FROM `notifications` WHERE subject_id = ? AND status = 'unseen'

#Select the name of the usergroup and the username of the user that correspond
#to the object's references.
SELECT ug.name, us.username
FROM userGroup as ug, user as us
WHERE ug.id = {$row['object']->usergroup_id}
AND us.id = {$row['object']->user_id}

############
#Player.php#
############
#Get the player's id by name.
SELECT id FROM `".self::TABLE_PLAYER."` WHERE name = ?

#Add a player to the database.
INSERT INTO `".self::TABLE_PLAYER."` (name) VALUES (?)

#Get the player's information by id.
SELECT * FROM `".self::TABLE_PLAYER."` WHERE id = ?

#Get the goals of the player with the given player id.
SELECT goal.time,
goal.match_id,
`match`.date,
(SELECT name FROM team WHERE team.id = `match`.hometeam_id) as hometeam,
(SELECT name FROM team WHERE team.id = `match`.awayteam_id) as awayteam
FROM `match`, goal
WHERE `match`.id = goal.match_id
AND goal.player_id = ?

#Count the goals made by a certain player.
SELECT COUNT(id) as count FROM goal WHERE player_id = ?

#Get the cards of a certain player (by id)
SELECT cards.time,
cards.color,
cards.match_id,
(SELECT date FROM `match` WHERE  `match`.id = cards.match_id) as date,
(SELECT name FROM team,`match`  WHERE  team.id = `match`.hometeam_id AND `match`.id = cards.match_id) as hometeam,
(SELECT name FROM team,`match`  WHERE  team.id = `match`.awayteam_id AND `match`.id = cards.match_id) as awayteam
FROM cards WHERE player_id = ?
ORDER BY date desc, time asc

#Get matches played by a certain player
SELECT `match`.*,
(SELECT name FROM team WHERE team.id = `match`.hometeam_id) AS hometeam,
(SELECT name FROM team WHERE team.id = `match`.awayteam_id) AS awayteam
FROM `match`, `playerPerMatch`
WHERE `playerPerMatch`.player_id = ?
AND `playerPerMatch`.match_id = `match`.id

################
#Prediction.php#
################

#No new queries (uses methods of other models)

#########
#RSS.php#
#########

#No queries.

############
#Search.php#
############
#Search for teams
SELECT name, id, (SELECT abbreviation FROM country WHERE id = team.country_id) as abbreviation FROM teams WHERE name LIKE %?%

#Search for players
SELECT name, id FROM player WHERE name LIKE %?%

#Search for matches
SELECT id FROM `match` WHERE hometeam_id IN (SELECT id FROM team WHERE name LIKE %?%) OR awayteam_id IN (SELECT id FROM team WHERE name LIKE %?%)

#Search for users
SELECT username, id FROM user WHERE username LIKE %?%

# search for usergroups
SELECT name, id, private FROM usergroup WHERE name LIKE %?%

##########
#Team.php#
##########
#Get team by id.
SELECT id FROM `".self::TABLE_TEAM."` WHERE name = (?)

#Insert team with given data.
INSERT INTO `".self::TABLE_TEAM."` (name, country_id, fifapoints) VALUES ( ?, ?, ?)

#Update points and coach from given team.
UPDATE `".self::TABLE_TEAM."` SET fifapoints = ?, coach_id = ? WHERE id = ?

#Link a given player (with a certain position) to a given team.
SELECT * FROM `".self::TABLE_PLAYER_PER_TEAM."` WHERE player_id = ? AND team_id = ?

#Get the team by id.
SELECT * FROM `".self::TABLE_TEAM."` WHERE id = ?

#Get all teams.
SELECT team.id, team.name, team.fifapoints, country.abbreviation, continent.name AS continent FROM team, country, continent WHERE team.country_id = country.id AND country.continent_id = continent.id

#Get the team of a player (by id).
SELECT team_id FROM `".self::TABLE_PLAYER_PER_TEAM."` WHERE player_id = ?

#Get all players of a given team (by id).
SELECT player.id, player.name,
(SELECT position FROM playerPerTeam WHERE player_id = player.id AND team_id = ?) as position
FROM player
WHERE player.id IN
  (SELECT player_id FROM playerPerTeam WHERE team_id = ?)

#Get the matches of a given team.
SELECT `match`.date,
`match`.id as match_id,
(SELECT name FROM team WHERE team.id = `match`.hometeam_id) as hometeam,
(SELECT name FROM team WHERE team.id = `match`.awayteam_id) as awayteam
FROM `match`
WHERE hometeam_id = ? OR awayteam_id = ?

#Get fifa points of a team by id.
SELECT team.fifapoints FROM `team` WHERE id = ?

##########
#User.php#
##########
#Used to check whether or not a certain facebook user already exists in our database.
SELECT COUNT(id) as count FROM user WHERE facebookid = ?

#Insert user into the databse (through facebook).
INSERT INTO user (firstname, lastname, facebookid, email, username, country_id) VALUES (?,?,?,?,?,'20')

#Trivial selects.
SELECT id, firstname, lastname FROM user WHERE email = ?

SELECT registrationcode, email FROM user WHERE username = ?

SELECT * FROM user WHERE id = ?

SELECT * FROM user

SELECT username FROM user WHERE email = ?

SELECT picture FROM user WHERE id = ?

SELECT facebookid FROM user WHERE id = ?

#Insert user into the database (without facebook).
INSERT INTO user (username, firstname, lastname, email, password, country_id, registrationcode, picture) VALUES (?, ?, ?, ?, ?, ?, ?, ?)

#Update the registration code (user has activated their account)
UPDATE user SET registrationcode = '' WHERE username = ?

#Update a user's password by id.
UPDATE user SET password = ? WHERE id = ?

#Update a user's information with the provided information.
UPDATE user
SET firstname = ?, lastname = ?, email = ?, country_id = ?, about = ?, age = ?
WHERE id = ?

#Change a user's profile picture by id.
UPDATE user SET picture = ? WHERE id = ?

#Get all users who want to recieve email.
SELECT * FROM user WHERE `recieve_email` = 1

###############
#UserGroup.php#
###############
#Used to check if the user is a member of the usergroup.
SELECT * FROM userPerUserGroup WHERE user_id = ? AND userGroup_id = ?

#Check if a certain subject user has been invited.
SELECT *
FROM `notifications` as notif
WHERE subject_id = ? AND status = 'unseen'
AND ? IN
  (SELECT usergroupId
   FROM `userGroupInvites`
   WHERE id = notif.object_id)

#trivial selects
SELECT private FROM `userGroup` WHERE id = ?

SELECT id FROM userGroup WHERE name = ?

SELECT name FROM userGroup WHERE id = ?

SELECT * FROM userGroup

#Insert a user invite to the database.
INSERT INTO `userGroupInvites` (userId, usergroupId, invitedById, created) VALUES (?, ?, ?, ?)

#Used to check whether or not a userGroup with that name already exists.
SELECT COUNT(id) AS count FROM userGroup WHERE name = ?

#Insert a userGroup to the database.
INSERT INTO userGroup (name, private, created) VALUES (?, ?, ?)

#Add a user to a userGroup.
INSERT INTO userPerUserGroup (user_id, userGroup_id, created) VALUES (?, ?, ?)

#Get all usernames, betscores, user ids and the moment since they're member of a certain userGroup.
SELECT (SELECT username FROM user WHERE id = userPerUserGroup.user_id) as username,
(SELECT betscore FROM user WHERE id = userPerUserGroup.user_id) as betscore,
(SELECT id FROM user WHERE id = userPerUserGroup.user_id) as id,
created
FROM userPerUserGroup
WHERE userGroup_id = ?

#Get a certain user's userGroupInvites with information (thanks to inner join) from the userGroup, inviter,...
SELECT ug.name, inviter.username, notif.created_date, notif.id AS notif_id, ug.id AS ug_id
FROM notifications notif
INNER JOIN userGroupInvites ugi ON notif.object_id = ugi.id
INNER JOIN user inviter ON notif.actor_id = inviter.id
INNER JOIN userGroup ug ON ugi.usergroupId = ug.id
WHERE notif.subject_id = ?
AND notif.status = 'unseen'

#Get a certain userGroup's invited users with information about the inviter and invitee.
SELECT
(SELECT username FROM user WHERE id = userGroupInvites.invitedById) as inviter,
(SELECT username FROM user WHERE id = userGroupInvites.userId) as invitee,
created, invitedById, userId FROM userGroupInvites WHERE usergroupId = ?

#Get a userGroup's past bets.
SELECT match_id, betdate, user_id, (SELECT username FROM user WHERE user.id = bet.user_id) AS better FROM bet
WHERE EXISTS (SELECT user_id FROM userPerUserGroup
WHERE userPerUserGroup.user_id = bet.user_id
AND userGroup_id = ?)
AND EXISTS (
  SELECT id FROM `match`
  WHERE `match`.id = bet.match_id
  AND `match`.date < NOW())

#Get a userGroup's future bets.
SELECT match_id, betdate, user_id, (SELECT username FROM user WHERE user.id = bet.user_id) AS better FROM bet
WHERE EXISTS (SELECT user_id FROM userPerUserGroup
WHERE userPerUserGroup.user_id = bet.user_id
AND userGroup_id = ?)
AND EXISTS (
  SELECT id FROM `match`
  WHERE `match`.id = bet.match_id
  AND `match`.date > NOW())

#A user accepts his userGroupInvite.
UPDATE notifications notif SET status = 'accepted' WHERE notif.id = ?

#A user declines his userGroupInvite.
UPDATE notifications notif SET status = 'declined' WHERE notif.id = ?

#Get all userGroups from a certain user.
SELECT *
FROM userGroup ug
INNER JOIN userPerUserGroup upug ON ug.id = upug.userGroup_id
WHERE upug.user_id = ?

#Get all participants in a certain userGroup discussion.
SELECT DISTINCT user_id
FROM `userGroupMessagesContent`
WHERE message_id = ? AND user_id <> ?

#######################
#UserGroupMessages.php#
#######################
#Get all discussions in a usergroup (by id).
SELECT created, id, title,
(SELECT username FROM user WHERE id = userGroupMessages.user_id) as username,
(SELECT COUNT(id) as count FROM userGroupMessagesContent WHERE message_id = userGroupMessages.id) as count
FROM userGroupMessages WHERE usergroup_id = ?
ORDER BY created DESC

#Get information about a discussion.
SELECT created, title,
(SELECT username FROM user WHERE id = userGroupMessages.user_id) as username
FROM userGroupMessages WHERE id = ?

#Get all content from a discussion.
SELECT created, content,
(SELECT username FROM user WHERE id = userGroupMessagesContent.user_id) as username, user_id
FROM userGroupMessagesContent
WHERE message_id = ?
ORDER BY created ASC

#Add new discussion to the usergroup.
INSERT INTO userGroupMessages (usergroup_id, user_id, title, created) VALUES (?,?,?,?)

#Add new reply to the discussion.
INSERT INTO userGroupMessagesContent (user_id, message_id, content, created) VALUES (?,?,?,?)

##############
#CREATE TABLE#
##############

--
-- Table structure for table `bet`
--

CREATE TABLE IF NOT EXISTS `bet` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `match_id` int(11) NOT NULL,
  `hometeam_score` int(5) NOT NULL,
  `awayteam_score` int(5) NOT NULL,
  `first_goal` tinyint(1) DEFAULT NULL,
  `hometeam_yellows` int(5) DEFAULT NULL,
  `hometeam_reds` int(5) DEFAULT NULL,
  `awayteam_yellows` int(5) DEFAULT NULL,
  `awayteam_reds` int(5) DEFAULT NULL,
  `evaluated` tinyint(1) NOT NULL DEFAULT '0',
  `betdate` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
)

-- --------------------------------------------------------

--
-- Table structure for table `cards`
--

CREATE TABLE IF NOT EXISTS `cards` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `player_id` int(11) DEFAULT NULL,
  `match_id` int(11) DEFAULT NULL,
  `color` enum('yellow','red') DEFAULT NULL,
  `time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `player_ids` (`player_id`),
  KEY `match` (`match_id`)
)

-- --------------------------------------------------------

--
-- Table structure for table `coach`
--

CREATE TABLE IF NOT EXISTS `coach` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(60) DEFAULT NULL,
  PRIMARY KEY (`id`)
)

-- --------------------------------------------------------

--
-- Table structure for table `competition`
--

CREATE TABLE IF NOT EXISTS `competition` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(60) DEFAULT NULL,
  PRIMARY KEY (`id`)
)

-- --------------------------------------------------------

--
-- Table structure for table `continent`
--

CREATE TABLE IF NOT EXISTS `continent` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(40) DEFAULT NULL,
  PRIMARY KEY (`id`)
)

-- --------------------------------------------------------

--
-- Table structure for table `country`
--

CREATE TABLE IF NOT EXISTS `country` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(60) DEFAULT NULL,
  `continent_id` int(11) DEFAULT NULL,
  `abbreviation` char(4) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `continent` (`continent_id`)
)

-- --------------------------------------------------------

--
-- Table structure for table `goal`
--

CREATE TABLE IF NOT EXISTS `goal` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `match_id` int(11) DEFAULT NULL,
  `time` tinyint(4) DEFAULT NULL,
  `player_id` int(11) DEFAULT NULL,
  `team_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `match` (`match_id`),
  KEY `player` (`player_id`),
  KEY `team` (`team_id`)
)

-- --------------------------------------------------------

--
-- Table structure for table `match`
--

CREATE TABLE IF NOT EXISTS `match` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `hometeam_id` int(11) DEFAULT NULL,
  `awayteam_id` int(11) DEFAULT NULL,
  `competition_id` int(11) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `phase` enum('group stage','16th finals','8th finals','quarter-finals','semi-finals','3rd place final','final') DEFAULT NULL,
  `group_nr` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `hometeam` (`hometeam_id`),
  KEY `awayteam` (`awayteam_id`),
  KEY `competition` (`competition_id`)
)

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE IF NOT EXISTS `notifications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `actor_id` int(11) DEFAULT NULL,
  `subject_id` int(11) DEFAULT NULL,
  `object_id` int(11) DEFAULT NULL,
  `type_id` int(11) DEFAULT NULL,
  `status` varchar(100) DEFAULT NULL COMMENT ' To store status of notification i.e seen or not unseen ',
  `created_date` datetime DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
)

-- --------------------------------------------------------

--
-- Table structure for table `player`
--

CREATE TABLE IF NOT EXISTS `player` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(60) DEFAULT NULL,
  PRIMARY KEY (`id`)
)


-- --------------------------------------------------------

--
-- Table structure for table `playerPerMatch`
--

CREATE TABLE IF NOT EXISTS `playerPerMatch` (
  `player_id` int(11) NOT NULL DEFAULT '0',
  `match_id` int(11) NOT NULL DEFAULT '0',
  `intime` tinyint(4) DEFAULT NULL,
  `outtime` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`player_id`,`match_id`),
  KEY `player_per_match` (`match_id`)
)

-- --------------------------------------------------------

--
-- Table structure for table `playerPerTeam`
--

CREATE TABLE IF NOT EXISTS `playerPerTeam` (
  `player_id` int(11) NOT NULL DEFAULT '0',
  `team_id` int(11) NOT NULL DEFAULT '0',
  `position` enum('goalkeeper','defender','midfielder','attacker') DEFAULT NULL,
  PRIMARY KEY (`player_id`,`team_id`),
  KEY `player_per_team` (`team_id`)
)

-- --------------------------------------------------------

--
-- Table structure for table `team`
--

CREATE TABLE IF NOT EXISTS `team` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(40) DEFAULT NULL,
  `country_id` int(11) DEFAULT NULL,
  `coach_id` int(11) DEFAULT NULL,
  `fifapoints` int(11) DEFAULT NULL,
  `twitterAccount` varchar(40) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `country` (`country_id`),
  KEY `coach` (`coach_id`)
) 

-- --------------------------------------------------------

--
-- Table structure for table `teamPerCompetition`
--

CREATE TABLE IF NOT EXISTS `teamPerCompetition` (
  `team_id` int(11) NOT NULL DEFAULT '0',
  `competition_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`team_id`,`competition_id`),
  KEY `tpc_competition` (`competition_id`)
)

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `facebookid` varchar(30) NOT NULL,
  `username` varchar(100) NOT NULL,
  `firstname` varchar(60) NOT NULL,
  `lastname` varchar(60) NOT NULL,
  `email` varchar(60) NOT NULL,
  `password` varchar(255) NOT NULL,
  `country_id` int(10) NOT NULL,
  `session_id` varchar(24) DEFAULT NULL,
  `registrationcode` varchar(24) DEFAULT NULL,
  `betscore` int(11) NOT NULL DEFAULT '0',
  `about` varchar(1024) NOT NULL,
  `recieve_email` tinyint(1) NOT NULL DEFAULT '1',
  `age` int(3) NOT NULL,
  `picture` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) 

-- --------------------------------------------------------

--
-- Table structure for table `userGroup`
--

CREATE TABLE IF NOT EXISTS `userGroup` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(60) NOT NULL,
  `private` tinyint(1) NOT NULL DEFAULT '0',
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) 

-- --------------------------------------------------------

--
-- Table structure for table `userGroupInvites`
--

CREATE TABLE IF NOT EXISTS `userGroupInvites` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) NOT NULL,
  `usergroupId` int(11) NOT NULL,
  `invitedById` int(11) NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) 

-- --------------------------------------------------------

--
-- Table structure for table `userGroupMessages`
--

CREATE TABLE IF NOT EXISTS `userGroupMessages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usergroup_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(60) NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) 

-- --------------------------------------------------------

--
-- Table structure for table `userGroupMessagesContent`
--

CREATE TABLE IF NOT EXISTS `userGroupMessagesContent` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `message_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) 

-- --------------------------------------------------------

--
-- Table structure for table `userPerUserGroup`
--

CREATE TABLE IF NOT EXISTS `userPerUserGroup` (
  `user_id` int(11) NOT NULL,
  `userGroup_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`user_id`,`userGroup_id`),
  KEY `userGroup_id` (`userGroup_id`)
) 


All INSERT queries can be found in /sql/coachcenter.sql (along with the above CREATE TABLE statements)

