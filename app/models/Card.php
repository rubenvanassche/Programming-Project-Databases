<?php

class Card {

    const TABLE_CARD = "cards";

    public static function getIDs( $player_id, $match_id, $color, $time ) {
        $query = "SELECT id FROM `".self::TABLE_CARD."` WHERE match_id = ? AND player_id = ? AND time = ? AND color = ?";
        $values = array( $match_id, $player_id, $time, $color );

        return DB::select( $query, $values );
    }

    public static function add( $player_id, $match_id, $color, $time ) {
        $query = "INSERT INTO `".self::TABLE_CARD."` (player_id, match_id, color, time) VALUES (?, ?, ?, ?)";
        $values = array( $player_id, $match_id, $color, $time );

        DB::insert( $query, $values );

        return self::getIDs( $player_id, $match_id, $color, $time );
    }

}
