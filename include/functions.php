<?php

function getReportStats($mysqli) {
    $data = [
        'total' => 0,
        'pending' => 0,
        'valid' => 0
    ];

    $result = $mysqli->query("SELECT COUNT(*) AS total FROM reports");
    if ($result) {
        $row = $result->fetch_assoc();
        $data['total'] = (int)$row['total'];
    }

    $result = $mysqli->query("SELECT target, COUNT(*) as count FROM reports GROUP BY target");
    if ($result) {
        $pendingCount = 0;
        while ($row = $result->fetch_assoc()) {
            $pendingCount += (int)$row['count'];
        }
        $data['pending'] = $pendingCount;
    }

    $result = $mysqli->query("SELECT SUM(count) as valid FROM valid_reports");
    if ($result) {
        $row = $result->fetch_assoc();
        $data['valid'] = (int)$row['valid'];
    }

    return $data;
}

function getAllReports($mysqli) {
    $reports = [];
    $result = $mysqli->query("SELECT id, reporter, target, reason, date FROM reports ORDER BY date DESC");
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $reports[] = $row;
        }
    }
    return $reports;
}

function getValidReportsByPlayer($mysqli) {
    $validReports = [];
    $result = $mysqli->query("SELECT player, count FROM valid_reports ORDER BY count DESC");
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $validReports[] = $row;
        }
    }
    return $validReports;
}