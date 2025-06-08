<?php
require_once __DIR__ . '/include/db.php';
require_once __DIR__ . '/include/functions.php';

$view = $_GET['view'] ?? 'dashboard';

if ($view === 'valid') {
    $validReports = getValidReportsByPlayer($mysqli);
} else {
    $stats = getReportStats($mysqli);
    $reports = getAllReports($mysqli);
}

function formatDateItalianTimeFirst($datetime) {
    $dt = DateTime::createFromFormat('Y-m-d H:i:s', $datetime);
    if (!$dt) {
        return htmlspecialchars($datetime);
    }
    return $dt->format('H:i:s') . ' ' . $dt->format('d/m/Y');
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8" />
    <title>Ultimate Reports Dashboard</title>
    <link rel="stylesheet" href="assets/style.css" />
    <style>
      h1.clickable {
          cursor: pointer;
          color: #00b8cc !important;
          text-align: center;
          margin-bottom: 40px;
          font-weight: 700;
          text-shadow: 0 0 6px #00b8ccaa !important;
          text-decoration: none !important;
          user-select: text;
      }
      h1.clickable:hover,
      h1.clickable:active,
      h1.clickable:visited {
          color: #00b8cc !important;
          text-shadow: 0 0 6px #00b8ccaa !important;
          text-decoration: none !important;
      }
    </style>
</head>
<body>

<?php if ($view === 'valid'): ?>
    <h1 class="clickable" onclick="window.location.href='index.php'">Report Validi per Giocatore</h1>

    <?php if (empty($validReports)): ?>
        <p>Empty</p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>Giocatore</th>
                    <th>Report Validi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($validReports as $row): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['player']) ?></td>
                        <td><?= htmlspecialchars($row['count']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

<?php else: ?>
    <h1>Ultimate Reports Dashboard</h1>

    <div class="dashboard">
        <div class="card">
            <h2>Totale Report</h2>
            <p><?= $stats['total'] ?? 0 ?></p>
        </div>
        <div class="card">
            <h2>Pending</h2>
            <p><?= $stats['pending'] ?? 0 ?></p>
        </div>
        <div class="card" onclick="window.location.href='index.php?view=valid'" style="cursor:pointer;">
            <h2>Validi</h2>
            <p><?= $stats['valid'] ?? 0 ?></p>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Target</th>
                <th>Motivo</th>
                <th>Data</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($reports as $report): ?>
                <tr>
                    <td><?= htmlspecialchars($report['id']) ?></td>
                    <td><?= htmlspecialchars($report['target']) ?></td>
                    <td class="motivo"><?= htmlspecialchars($report['reason']) ?></td>
                    <td><?= formatDateItalianTimeFirst($report['date']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

<?php endif; ?>

</body>
</html>
