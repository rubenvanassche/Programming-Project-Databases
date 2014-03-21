<?php

/**
 * @class InvalidTableException
 * @brief Thrown in case you are using a wrong table.
 */
class InvalidTableException extends Exception {

    /**
     * @brief Constructor.
     *
     * @param table The table you tried to access.
     */
    public function __construct( $table ) {
        parent::__construct( "Invalid table to use: ".$table );
        return;
    }
}

/**
 * @class MissingFieldException
 * @brief Thrown in case a field of the entity is missing when inserting the 
 * entity into the database.
 */
class MissingFieldException extends Exception {

    /**
     * @var missing
     * @brief The record that's missing into the database.
     */
    public $missing;

    /**
     * @brief Constructor
     *
     * @param missing What record is missing.
     * @param table In which table.
     */
    public function __construct( $missing, $table ) {
        $msg = "Missing ".$missing." in table ".$table.".";
        parent::__construct( $msg );

        $this->missing = $missing;
    }
}

/**
 * @class InsertException
 * @brief Thrown whenever you fail to insert the data into the database.
 */
class InsertException extends Exception {

    /**
     * @brief Constructor.
     *
     * @param what What you tried to insert.
     * @param where Into which table are you trying to insert.
     * @param why Why it failed to insert (optional).
     */
    public function __construct( $what, $where, $why="insertion not successfull" ) {
        $msg = "Failed to insert ".$what." into table ".$where.": ".$why;
        parent::__construct( $msg );
        return;
    }
}

/**
 * @class DuplicateException
 * @brief Thrown in case an entry is already in the database.
 */
class DuplicateException extends InsertException {

    /**
     * @brief Constructor.
     *
     * @param duplicate The duplicate that's already in the database.
     * @param table The name of the table where you can find the duplicate.
     */
    public function __construct( $duplicate, $table ) {
        $msg = $duplicate." already in table ".$table.".";
        parent::__construct( $duplicate, $table, $msg );
        return;
    }
}

/**
 * @class Stats
 * @brief Contains all statistics about all stuffs.
 * @details This class encapsulates the database queries.
 */
class Stats {

    const TABLE_CARDS = 'cards';
    const TABLE_COACH = 'coach';
    const TABLE_COMPETITION = 'competition';
    const TABLE_CONTINENT = 'continent';
    const TABLE_COUNTRY = 'country';
    const TABLE_GOAL = 'goal';
    const TABLE_MATCH = 'match';
    const TABLE_PLAYER = 'player';
    const TABLE_PLAYER_PER_MATCH = 'playerPerMatch';
    const TABLE_PLAYER_PER_TEAM = 'playerPerTeam';
    const TABLE_TEAM = 'team';
    const TABLE_TEAM_PER_COMPETITION = 'teamPerCompetition';

    /**
     * @brief Get the id by giving the name of an enitity.
     *
     * @param table The table to query the id.
     * @param name The name to query the id.
     *
     * @throw InvalidTableException Not a valid table to get the id by name
     * @return Array of the id's with the matching name.
     */
    public function getIDsByName( $table, $name ) {
        // first, list all allowed table to get the id by name
        $allowed_tables = array(
            Stats::TABLE_COACH,
            Stats::TABLE_COMPETITION,
            Stats::TABLE_CONTINENT,
            Stats::TABLE_COUNTRY,
            Stats::TABLE_PLAYER,
            Stats::TABLE_TEAM,
        );

        if ( in_array( $table, $allowed_tables ) ) {
            // query to get the id with the given name
            $query = 'SELECT id FROM `'.$table.'` WHERE name = "?"';
            $values = array( $name );
            return DB::select( $query, $values );
        } else {
            throw new InvalidTableException( $table );
        } // end if-else
    }

    /**
     * @brief Add a competition to the statistics.
     *
     * @param name The name of the competition.
     *
     * @throw DuplicateException The competition is already in the database.
     * @throw InsertException Failed to insert (no specific raisons).
     * @return The id of the competition.
     */
    public function addCompetition( $name ) {
        if ( empty( $this->getIDsByName( Stats::TABLE_COMPETITION, $name ) ) ) {

            $query = "INSERT INTO `".Stats::TABLE_COMPETITION."` (name) VALUES (?)";
            $values = array( $name );
            $result = DB::insert( $query, $values );

            // succeed?
            if( 1 == $result ) {
                return $this->getIDsByName( Stats::TABLE_COMPETITION, $name )[0]->id;
            } else {
                throw new InsertException( $name, Stats::TABLE_COMPETITION );
            } // end if-else

        } else {
            throw new DuplicateException( $name, Stats::TABLE_COMPETITION );
        } // end if-else
    }

    /**
     * @brief Add a continent to the statistics.
     *
     * @param name The name of the continent.
     *
     * @throw DuplicateException The continent is already in the database.
     * @throw InsertException Failed to insert (no specific raisons).
     * @return The id of the continent.
     */
    public function addContinent( $name ) {
        if ( empty( $this->getIDsByName( Stats::TABLE_CONTINENT, $name ) ) ) {

            $query = "INSERT INTO `".Stats::TABLE_CONTINENT."` (name) VALUES (?)";
            $values = array( $name );
            $result = DB::insert( $query, $values );

            // succeed?
            if( 1 == $result ) {
                return $this->getIDsByName( Stats::TABLE_CONTINENT, $name );
            } else {
                throw new InsertException( $name, Stats::TABLE_CONTINENT );
            } // end if-else

        } else {
            throw new DuplicateException( $name, Stats::TABLE_CONTINENT );
        } // end if-else
    }

    /**
     * @brief Add a country into the statistics.
     *
     * @param country The name of the country you want to add.
     * @param continent The name of the continent the country is a part of.
     * @param abbreviation The abbreviation of the country (used for displaying 
     * flags).
     *
     * @throw MissingFieldException One of the fields is missing.
     * @throw DuplicateException The country is already in the database.
     * @throw InsertException Failed to insert (no specific raisons).
     * @return True
     */
    public function addCountry( $country, $continent, $abbreviation ) {
        if ( empty( $this->getIDsByName( Stats::TABLE_COUNTRY, $country ) ) ) {

            // get the ids of the continent
            $continentIDs = $this->getIDsByName( Stats::TABLE_CONTINENT, $continent );

            if ( empty( $continentIDs ) )
                throw new MissingFieldException( $continent, Stats::TABLE_CONTINENT );

            $query = 'INSERT INTO `'.Stats::TABLE_COUNTRY.'` (name, continent_id, abbreviation) VALUES (?, ?, ?)';
            $values = array( $name, $continentIDs[0]->id, $abbreviation );
            $result = DB::insert( $query, $values );

            // succeed?
            if( 1 == $result ) {
                return $this->getIDsByName( Stats::TABLE_COUNTRY, $country )[0]->id;
            } else {
                throw new InsertException( $name, Stats::TABLE_COUNTRY );
            } // end if-else

        } else {
            throw new DuplicateException( $country, Stats::TABLE_COUNTRY );
        } // end if-else
    }

    /**
     * @brief Add a coach into the system.
     *
     * @param name The name of the coach.
     *
     * @throw DuplicateException The coach is already in the database.
     * @throw InsertException Failed to insert (no specific raisons).
     * @return The id of the coach.
     */
    public function addCoach( $name ) {
        if ( empty( $this->getIDsByName( Stats::TABLE_COACH, $name ) ) ) {

            $query = "INSERT INTO `".Stats::TABLE_COACH."` (name) VALUES (?)";
            $values = array( $name );
            $result = DB::insert( $query, $values );

            // succeed?
            if( 1 == $result ) {
                return $this->getIDsByName( Stats::TABLE_COACH, $name )[0]->id;
            } else {
                throw new InsertException( $name, Stats::TABLE_COACH );
            } // end if-else

        } else {
            throw new DuplicateException( $name, Stats::TABLE_COACH );
        } // end if-else
    }

    /**
     * @brief Add a team into the statistics.
     *
     * @param team The name of the team.
     * @param country The name of the country of the team.
     * @param coach The coach of the team.
     * @param points The (FIFA) points of the team.
     *
     * @throw MissingFieldException One of the fields is missing.
     * @throw DuplicateException The team is already in the database.
     * @throw InsertException Failed to insert (no specific raisons).
     * @return The id of the team.
     */
    public function addTeam( $team, $country, $coach, $points ) {
        if ( empty( $this->getIDsByName( Stats::TABLE_TEAM, $team ) ) ) {

            // get the ids of the country and coach
            $countryIDs = $this->getIDsByName( Stats::TABLE_COUNTRY, $country );
            $coachIDs = $this->getIDsByName( Stats::TABLE_COACH, $coach );

            if ( empty( $countryIDs ) )
                throw new MissingFieldException( $country, Stats::TABLE_COUNTRY );

            if ( empty( $coachIDs ) )
                throw new MissingFieldException( $coach, Stats::TABLE_COACH );

            $query = 'INSERT INTO `'.Stats::TABLE_TEAM.'` (name, country_id, coach_id, fifapoints) VALUES (?, ?, ?, ?)';
            $values = array( $team, $countryIDs[0]->id, $coachIDs[0]->id, $points );
            $result = DB::insert( $query, $values );

            // succeed?
            if( 1 == $result ) {
                return $this->getIDsByName( Stats::TABLE_TEAM, $country )[0]->id;
            } else {
                throw new InsertException( $name, Stats::TABLE_TEAM );
            } // end if-else

        } else {
            throw new DuplicateException( $country, Stats::TABLE_TEAM );
        } // end if-else
    }

    /**
     * @brief add a team per competition.
     *
     * @param team The name of the team.
     * @param competition The name of the competition.
     *
     * @throw MissingFieldException One of the fields is missing.
     * @throw DuplicateException The team is already added to the competition.
     * @throw InsertException Failed to insert (no specific raisons).
     * @return True
     */
    public function addTeamPerCompetition( $team, $competition ) {
        // get the team and competition ids
        $teamIDs = $this->getIDsByName( Stats::TABLE_TEAM, $team );
        if ( empty( $teamIDs ) )
            throw new MissingFieldException( $team, Stats::TABLE_TEAM );

        $competitionIDs = $this->getIDsByName( Stats::TABLE_COMPETITION, $competition );
        if ( empty( $competitionIDs ) )
            throw new MissingFieldException( $competition, Stats::TABLE_COMPETITION );

        // check whether the team is already linked to the competition
        $query = 'SELECT * FROM `'.Stats::TABLE_TEAM_PER_COMPETITION.'` WHERE team_id = ? AND competition_id = ?';
        $values = array( $teamIDs[0]->id, $competitionIDs[0]->id );
        $results = DB::select( $query, $values );
        if ( !empty( $results ) )
            throw new DuplicateException( "Link team ".$team." to competition ".$competition, Stats::TABLE_TEAM_PER_COMPETITION );

        // okay, link the team to the competition
        $query = 'INSERT INTO `'.Stats::TABLE_TEAM_PER_COMPETITION.'` (team_id, competition_id) VALUES (?, ?)';
        $values = array( $teamIDs[0]->id, $competitionIDs[0]->id );
        $result = DB::insert( $query, $values );

        // success?
        if ( 1 == $result ) {
            return true;
        } else {
            throw new InsertException( "Link team ".$team." to competition ".$competition, Stats::TABLE_TEAM_PER_COMPETITION );
        } // end if-else
    }

    /**
     * @brief Add a match into the statistics.
     *
     * @param homeTeam The name of the home team.
     * @param awayTeam The name of the away team.
     * @param competition The name of the competition.
     * @param date The date of the match.
     *
     * @throw MissingFieldException One of the fields is missing.
     * @throw DuplicateException The team is already added to the competition.
     * @throw InsertException Failed to insert (no specific raisons).
     * @return True
     */
    public function addMatch( $homeTeam, $awayTeam, $competition, $date ) {
        // get the IDs of the hometeam, awayteam and the competition
        $homeTeamIDs = $this->getIDsByName( Stats::TABLE_TEAM, $homeTeam );
        if ( empty( $homeTeamIDs ) )
            throw new MissingFieldException( $homeTeam, Stats::TABLE_TEAM );

        $awayTeamIDs = $this->getIDsByName( Stats::TABLE_TEAM, $awayTeam );
        if ( empty( $awayTeamIDs ) )
            throw new MissingFieldException( $awayTeam, Stats::TABLE_TEAM );

        $competitionIDs = $this->getIDsByName( Stats::TABLE_COMPETITION, $competition );
        if ( empty( $competitionIDs ) )
            throw new MissingFieldException( $competition, Stats::TABLE_COMPETITION );

        // check whether the home and away teams are both linked to the 
        // competition.
        $query = 'SELECT * FROM `'.Stats::TABLE_TEAM_PER_COMPETITION.'` WHERE team_id = ? AND competition_id = ?';
        $values = array( $homeTeamIDs[0]->id, $competitionIDs[0]->id );
        $results = DB::select( $query, $values );
        if ( empty( $results ) )
            throw new MissingFieldException( $team, Stats::TABLE_TEAM_PER_COMPETITION);

        $query = 'SELECT * FROM `'.Stats::TABLE_TEAM_PER_COMPETITION.'` WHERE team_id = ? AND competition_id = ?';
        $values = array( $homeTeamIDs[0]->id, $competitionIDs[0]->id );
        $results = DB::select( $query, $values );
        if ( empty( $results ) )
            throw new MissingFieldException( $team, Stats::TABLE_TEAM_PER_COMPETITION);

        // Check whether the match is already added into the table
        $query = 'SELECT * FROM `'.Stats::TABLE_MATCH.'` WHERE hometeam_id = ? AND awayteam_id = ? AND competition_id = ? AND date = ?';
        $values = array( $homeTeamIDs[0]->id, $awayTeamIDs[0]->id, $competitionIDs[0]->id, $date );
        $results = DB::select( $query, $values );
        if ( !empty( $results ) )
            throw new DuplicateException( "Match ".$homeTeam." - ".$awayTeam, Stats::TABLE_MATCH );

        // Okay, now insert the match into the table
        $query = 'INSERT INTO `'.Stats::TABLE_MATCH.'` (hometeam_id, awayteam_id, competition_id, date) VALUES (?, ?, ?, ?)';
        $values = array( $homeTeamIDs[0]->id, $awayTeamIDs[0]->id, $competitionIDs[0]->id, $date );
        $results = DB::insert( $query, $values );

        // success?
        if ( 1 == $result ) {
            return true;
        } else {
            throw new InsertException( "Match ".$homeTeam." - ".$awayTeam, Stats::TABLE_MATCH );
        } // end if-else
    }

    /**
     * @brief Add player into the statistics.
     *
     * @param name The name of the player
     * @param injured True if the player is already injured (optional).
     *
     * @throw DuplicateException The player is already added into the statistics.
     * @throw InsertException Failed to insert (no specific raisons).
     * @return The id of the player.
     */
    public function addPlayer( $name, $injured=false ) {
        if ( empty( $this->getIDsByName( Stats::TABLE_PLAYER, $name ) ) ) {

            $query = "INSERT INTO `".Stats::TABLE_PLAYER."` (name) VALUES (?, ?)";
            $values = array( $name, $injured );
            $result = DB::insert( $query, $values );

            // succeed?
            if( 1 == $result ) {
                return $this->getIDsByName( Stats::TABLE_PLAYER, $name )[0]->id;
            } else {
                throw new InsertException( $name, Stats::TABLE_PLAYER );
            } // end if-else

        } else {
            throw new DuplicateException( $name, Stats::TABLE_PLAYER );
        } // end if-else
    }

    /**
     * @brief Link a player to a team.
     *
     * @param player The name of the player.
     * @param team The name of the team.
     *
     * @throw MissingFieldException One of the fields is missing.
     * @throw DuplicateException The player is already linked to the team.
     * @throw InsertException Failed to insert (no specific raisons).
     * @return True
     */
    public function addPlayerPerTeam( $player, $team ) {
        // get the team and player ids
        $teamIDs = $this->getIDsByName( Stats::TABLE_TEAM, $team );
        if ( empty( $teamIDs ) )
            throw new MissingFieldException( $team, Stats::TABLE_TEAM );

        $playerIDs = $this->getIDsByName( Stats::TABLE_PLAYER, $player );
        if ( empty( $playerIDs ) )
            throw new MissingFieldException( $player, Stats::TABLE_PLAYER );

        // check whether the player is already linked to the team
        $query = 'SELECT * FROM `'.Stats::TABLE_PLAYER_PER_TEAM.'` WHERE player_id = ? AND team_id = ?';
        $values = array( $playerIDs[0]->id, $teamIDs[0]->id );
        $results = DB::select( $query, $values );
        if ( !empty( $results ) )
            throw new DuplicateException( "Link player ".$player." to team ".$team, Stats::TABLE_PLAYER_PER_TEAM );

        // okay, link the player to the team
        $query = 'INSERT INTO `'.Stats::TABLE_PLAYER_PER_TEAM.'` (player_id, team_id) VALUES (?, ?)';
        $values = array( $playerIDs[0]->id, $teamIDs[0]->id );
        $result = DB::insert( $query, $values );

        // success?
        if ( 1 == $result ) {
            return true;
        } else {
            throw new InsertException( "Link player ".$player." to team ".$team, Stats::TABLE_PLAYER_PER_TEAM );
        } // end if-else

        // success?
        if ( 1 == $result ) {
            return true;
        } else {
            throw new InsertException( "Link player ".$player." to team ".$team, Stats::TABLE_PLAYER_PER_MATCH );
        } // end if-else
    }
}
