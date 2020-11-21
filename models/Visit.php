<?php

namespace Visit;

class Visit {
    public static function getTodayVisits() {
        $date = date('d/m/Y', strtotime('today'));
        $query = mysqli_query(db(), "SELECT * FROM visits WHERE date = '$date'");

        if(mysqli_num_rows($query) < 1) {
            return 0;
        }

        $row = mysqli_fetch_object($query);
        $todayVisits = $row->count;

        return $todayVisits;
    }

    public static function getTotalVisits() {
        $query = mysqli_query(db(), "SELECT * FROM visits");
        $totalVisits = 0;

        while($row = mysqli_fetch_object($query)) {
            $totalVisits += (int)$row->count;
        }

        return $totalVisits;
    }

    public static function updateVisitCount() {
        // Check if row already exists
        $date = date('d/m/Y', strtotime('today'));
        $query = mysqli_query(db(), "SELECT * FROM visits WHERE date = '$date'");

        if(mysqli_num_rows($query) > 0) {
            $row = mysqli_fetch_object($query);
            $count = (int)$row->count + 1;

            // Update
            mysqli_query(db(), "UPDATE visits SET count = '$count' WHERE date = '$date'");

            return true;
        } else {
            $count = 1;

            // Insert
            mysqli_query(db(), "INSERT INTO visits (date, count) VALUES ('$date', '$count')");

            return true;
        }
    }
}