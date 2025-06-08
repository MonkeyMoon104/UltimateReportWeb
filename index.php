<?php
require_once __DIR__ . '/include/db.php';
require_once __DIR__ . '/include/functions.php';
require_once __DIR__ . '/include/lang.php';

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
    <title><?= __('dashboard_title') ?></title>
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
    <h1 class="clickable" onclick="window.location.href='index.php'"><?= __('valid_reports') ?> <?= __('player') ?></h1>

    <?php if (empty($validReports)): ?>
        <p><?= __('empty') ?></p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th><?= __('player') ?></th>
                    <th><?= __('valid_reports') ?></th>
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
    <h1><?= __('dashboard_title') ?></h1>

    <div class="dashboard">
        <div class="card">
            <h2><?= __('total_reports') ?></h2>
            <p><?= $stats['total'] ?? 0 ?></p>
        </div>
        <div class="card">
            <h2><?= __('pending') ?></h2>
            <p><?= $stats['pending'] ?? 0 ?></p>
        </div>
        <div class="card" onclick="window.location.href='index.php?view=valid'" style="cursor:pointer;">
            <h2><?= __('valid') ?></h2>
            <p><?= $stats['valid'] ?? 0 ?></p>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th><?= __('id') ?></th>
                <th><?= __('target') ?></th>
                <th><?= __('reason') ?></th>
                <th><?= __('date') ?></th>
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