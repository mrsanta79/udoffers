<?php

namespace Entry;

use User\User;

class Entry {
    public static function getAllEntries() {
        $query = mysqli_query(db(), "SELECT * FROM entries");

        $result = mysqli_fetch_all($query, MYSQLI_ASSOC);

        foreach ($result as $key => $item) {
            $result[$key]['id'] = intval($result[$key]['id']);
            $result[$key]['created_at'] = intval($result[$key]['created_at']);

            // Assign user data
            $result[$key]['creator'] = User::getUserById($result[$key]['created_by']);
        }

        return $result;
    }

    public static function getEntryById(int $id) {
        if (!isset($id) || empty($id)) {
            throw new \Error('Entry ID is required');
        }

        $query = mysqli_query(db(), "SELECT * FROM entries WHERE id = '$id'");
        if (mysqli_num_rows($query) < 1) {
            return false;
        }

        $entry = mysqli_fetch_object($query);

        $entry->id = intval($entry->id);
        $entry->created_at = intval($entry->created_at);

        // Assign user data
        $entry->creator = User::getUserById($entry->created_by);

        return $entry;
    }

    public static function createEntry($data) {
        $conn = db();

        $data['created_at'] = strtotime('now');

        $data = (object)$data;

        $query = mysqli_query($conn, "INSERT INTO entries (name, background, created_by, created_at) VALUES ('$data->name', '$data->background', '$data->created_by', '$data->created_at')");

        if (!$query) {
            return false;
        }

        $id = mysqli_insert_id($conn);

        // Get entry details
        $entry = self::getEntryById($id);
        return $entry;
    }

    public static function deleteEntry(int $id) {
        $query = mysqli_query(db(), "DELETE FROM entries WHERE id = '$id'");

        if (!$query) {
            return false;
        }

        return true;
    }
}