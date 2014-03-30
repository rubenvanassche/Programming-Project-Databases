<?php

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
    public static function addTeamPerCompetition( $team, $competition ) {
        // get the team and competition ids
        $teamIDs = self::getIDsByName( self::TABLE_TEAM, $team );
        if ( empty( $teamIDs ) )
            throw new MissingFieldException( $team, self::TABLE_TEAM );

        $competitionIDs = self::getIDsByName( self::TABLE_COMPETITION, $competition );
        if ( empty( $competitionIDs ) )
            throw new MissingFieldException( $competition, self::TABLE_COMPETITION );

        // check whether the team is already linked to the competition
        $query = 'SELECT * FROM `'.self::TABLE_TEAM_PER_COMPETITION.'` WHERE team_id = ? AND competition_id = ?';
        $values = array( $teamIDs[0]->id, $competitionIDs[0]->id );
        $results = DB::select( $query, $values );
        if ( !empty( $results ) )
            throw new DuplicateException( "Link team ".$team." to competition ".$competition, self::TABLE_TEAM_PER_COMPETITION );

        // okay, link the team to the competition
        $query = 'INSERT INTO `'.self::TABLE_TEAM_PER_COMPETITION.'` (team_id, competition_id) VALUES (?, ?)';
        $values = array( $teamIDs[0]->id, $competitionIDs[0]->id );
        $result = DB::insert( $query, $values );

        // success?
        if ( 1 == $result ) {
            return true;
        } else {
            throw new InsertException( "Link team ".$team." to competition ".$competition, self::TABLE_TEAM_PER_COMPETITION );
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
    public static function addMatch( $homeTeam, $awayTeam, $competition, $date ) {
        // get the IDs of the hometeam, awayteam and the competition
        $homeTeamIDs = self::getIDsByName( self::TABLE_TEAM, $homeTeam );
        if ( empty( $homeTeamIDs ) )
            throw new MissingFieldException( $homeTeam, self::TABLE_TEAM );

        $awayTeamIDs = self::getIDsByName( self::TABLE_TEAM, $awayTeam );
        if ( empty( $awayTeamIDs ) )
            throw new MissingFieldException( $awayTeam, self::TABLE_TEAM );

        $competitionIDs = self::getIDsByName( self::TABLE_COMPETITION, $competition );
        if ( empty( $competitionIDs ) )
            throw new MissingFieldException( $competition, self::TABLE_COMPETITION );

        // check whether the home and away teams are both linked to the 
        // competition.
        $query = 'SELECT * FROM `'.self::TABLE_TEAM_PER_COMPETITION.'` WHERE team_id = ? AND competition_id = ?';
        $values = array( $homeTeamIDs[0]->id, $competitionIDs[0]->id );
        $results = DB::select( $query, $values );
        if ( empty( $results ) )
            throw new MissingFieldException( $homeTeam, self::TABLE_TEAM_PER_COMPETITION);

        $query = 'SELECT * FROM `'.self::TABLE_TEAM_PER_COMPETITION.'` WHERE team_id = ? AND competition_id = ?';
        $values = array( $awayTeamIDs[0]->id, $competitionIDs[0]->id );
        $results = DB::select( $query, $values );
        if ( empty( $results ) )
            throw new MissingFieldException( $awayTeam, self::TABLE_TEAM_PER_COMPETITION);

        // Check whether the match is already added into the table
        $query = 'SELECT * FROM `'.self::TABLE_MATCH.'` WHERE hometeam_id = ? AND awayteam_id = ? AND competition_id = ? AND date = ?';
        $values = array( $homeTeamIDs[0]->id, $awayTeamIDs[0]->id, $competitionIDs[0]->id, $date );
        $results = DB::select( $query, $values );
        if ( !empty( $results ) )
            throw new DuplicateException( "Match ".$homeTeam." - ".$awayTeam, self::TABLE_MATCH );

        // Okay, now insert the match into the table
        $query = 'INSERT INTO `'.self::TABLE_MATCH.'` (hometeam_id, awayteam_id, competition_id, date) VALUES (?, ?, ?, ?)';
        $values = array( $homeTeamIDs[0]->id, $awayTeamIDs[0]->id, $competitionIDs[0]->id, $date );
        $result = DB::insert( $query, $values );

        // success?
        if ( 1 == $result ) {
            return true;
        } else {
            throw new InsertException( "Match ".$homeTeam." - ".$awayTeam, self::TABLE_MATCH );
        } // end if-else
    }

}
