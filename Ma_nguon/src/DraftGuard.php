<?php
declare(strict_types=1);

function canComplete(array $session, int $targetEventId, int $now, int $ttl): bool
{
    if (!isset($session['draft']) || !is_array($session['draft'])) {
        return false;
    }

    $draft = $session['draft'];
    if (!isset($draft['data']) || !is_array($draft['data']) || !isset($draft['created_at'])) {
        return false;
    }

    $createdAt = $draft['created_at'];
    $data = $draft['data'];

    if ($ttl <= 0 || $createdAt > $now) {
        return false;
    }

    if (($now - $createdAt) >= $ttl) {
        return false;
    }

    if (!isset($data['event_id']) || (int)$data['event_id'] !== $targetEventId || $targetEventId <= 0) {
        return false;
    }

    return true;
}
