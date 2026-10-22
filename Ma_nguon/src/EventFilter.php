<?php
declare(strict_types=1);

function filterEvents(
    array $events,
    string $query = '',
    string $category = '',
    bool $availableOnly = false
): array {
    $result = [];

    foreach ($events as $event) {
        $matchesQuery = ($query === '') || (stripos($event['title'], $query) !== false);
        $matchesCategory = ($category === '') || ($event['category'] === $category);
        $isAvailable = ($event['capacity'] - $event['registered']) > 0;
        $matchesAvailable = !$availableOnly || $isAvailable;

        if ($matchesQuery && $matchesCategory && $matchesAvailable) {
            $result[] = $event;
        }
    }

    return $result;
}
