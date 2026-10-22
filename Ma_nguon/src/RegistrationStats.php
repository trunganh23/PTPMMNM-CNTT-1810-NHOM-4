<?php
declare(strict_types=1);

function registrationStats($db, ?int $eventId = null): array
{
    if ($eventId !== null) {
        $sql = "SELECT e.id AS event_id, e.title, COUNT(r.id)::int AS total
                FROM events e
                LEFT JOIN registrations r ON e.id = r.event_id
                WHERE e.id = $1
                GROUP BY e.id, e.title";
        $res = pg_query_params($db, $sql, [$eventId]);
        if (!$res) {
            return [];
        }
        $row = pg_fetch_assoc($res);
        if (!$row) {
            return [];
        }
        return [
            'event_id' => (int)$row['event_id'],
            'title'    => $row['title'],
            'total'    => (int)$row['total'],
        ];
    }

    $sql = "SELECT e.id AS event_id, e.title, COUNT(r.id)::int AS total
            FROM events e
            LEFT JOIN registrations r ON e.id = r.event_id
            GROUP BY e.id, e.title
            ORDER BY e.id ASC";
    $res = pg_query($db, $sql);
    if (!$res) {
        return [];
    }
    $list = [];
    while ($row = pg_fetch_assoc($res)) {
        $list[] = [
            'event_id' => (int)$row['event_id'],
            'title'    => $row['title'],
            'total'    => (int)$row['total'],
        ];
    }
    return $list;
}
