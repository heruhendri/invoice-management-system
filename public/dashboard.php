diff --git a/public/dashboard.php b/public/dashboard.php
index 8e41b96560b25c0a5c590b588fa8b77f31f5ec4d..0f48132b41690b84a84d1164262c4c0b24284f52 100644
--- a/public/dashboard.php
+++ b/public/dashboard.php
@@ -1,12 +1,256 @@
+<?php
+include "../config/config.php";
+if (!isset($_SESSION['admin'])) {
+    exit;
+}
 
-<?php include "../config/config.php";
-if(!isset($_SESSION['admin'])) exit;
+$stats = [
+    'customers' => 0,
+    'invoices' => 0,
+    'paid' => 0,
+    'pending' => 0,
+    'revenue' => 0,
+];
+
+$stats['customers'] = (int) ($conn->query("SELECT COUNT(*) AS total FROM customers")->fetch_assoc()['total'] ?? 0);
+$stats['invoices'] = (int) ($conn->query("SELECT COUNT(*) AS total FROM invoices")->fetch_assoc()['total'] ?? 0);
+$stats['paid'] = (int) ($conn->query("SELECT COUNT(*) AS total FROM invoices WHERE status='paid'")->fetch_assoc()['total'] ?? 0);
+$stats['pending'] = (int) ($conn->query("SELECT COUNT(*) AS total FROM invoices WHERE status<>'paid'")->fetch_assoc()['total'] ?? 0);
+$stats['revenue'] = (float) ($conn->query("SELECT COALESCE(SUM(amount),0) AS total FROM invoices WHERE status='paid'")->fetch_assoc()['total'] ?? 0);
+
+$recentInvoices = $conn->query("SELECT invoices.id, invoices.amount, invoices.currency, invoices.status, invoices.due_date, customers.name
+FROM invoices JOIN customers ON customers.id = invoices.customer_id
+ORDER BY invoices.id DESC LIMIT 5");
+
+$collectionRate = $stats['invoices'] > 0 ? round(($stats['paid'] / $stats['invoices']) * 100) : 0;
 ?>
-<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
-<div class="container mt-4">
-<h4>Dashboard (<?= $_SESSION['admin']['role']?>)</h4>
-<a href="customers.php">Customers</a> |
-<a href="invoices.php">Invoices</a> |
-<a href="export.php">Export</a> |
-<a href="logout.php">Logout</a>
+<!doctype html>
+<html lang="en">
+<head>
+    <meta charset="UTF-8">
+    <meta name="viewport" content="width=device-width, initial-scale=1.0">
+    <title>Invoice Dashboard</title>
+    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
+    <style>
+        :root {
+            --bg-1: #0b1020;
+            --bg-2: #121a33;
+            --card-bg: rgba(255, 255, 255, 0.08);
+            --card-border: rgba(255, 255, 255, 0.15);
+            --text-soft: rgba(255, 255, 255, 0.8);
+            --accent: #7c5cff;
+            --accent-2: #16c6ff;
+        }
+
+        body {
+            min-height: 100vh;
+            color: #fff;
+            background: radial-gradient(circle at top right, #1d2b64 0%, var(--bg-1) 45%, #060910 100%);
+            font-family: Inter, Segoe UI, sans-serif;
+        }
+
+        .glass {
+            background: var(--card-bg);
+            border: 1px solid var(--card-border);
+            border-radius: 20px;
+            backdrop-filter: blur(8px);
+            box-shadow: 0 12px 35px rgba(0, 0, 0, 0.35);
+        }
+
+        .brand-pill {
+            display: inline-flex;
+            align-items: center;
+            gap: 8px;
+            background: rgba(124, 92, 255, 0.2);
+            color: #d7ccff;
+            border: 1px solid rgba(124, 92, 255, 0.4);
+            border-radius: 999px;
+            padding: 6px 12px;
+            font-size: 13px;
+            font-weight: 600;
+        }
+
+        .hero h1 {
+            font-size: clamp(1.5rem, 4vw, 2.2rem);
+            font-weight: 700;
+            margin-bottom: 8px;
+        }
+
+        .hero p {
+            color: var(--text-soft);
+            margin: 0;
+        }
+
+        .stat-card h6 {
+            color: var(--text-soft);
+            margin-bottom: 10px;
+        }
+
+        .stat-card h3 {
+            margin: 0;
+            font-size: 1.7rem;
+            font-weight: 700;
+        }
+
+        .metric-dot {
+            width: 10px;
+            height: 10px;
+            border-radius: 50%;
+            display: inline-block;
+            margin-right: 6px;
+        }
+
+        .progress {
+            height: 9px;
+            background: rgba(255, 255, 255, 0.2);
+        }
+
+        .progress-bar {
+            background: linear-gradient(90deg, var(--accent), var(--accent-2));
+        }
+
+        .table thead th {
+            color: #cfd6ff;
+            font-weight: 600;
+            border-color: rgba(255, 255, 255, 0.12);
+        }
+
+        .table td {
+            color: #f8f9ff;
+            border-color: rgba(255, 255, 255, 0.08);
+            vertical-align: middle;
+        }
+
+        .badge-soft {
+            background: rgba(22, 198, 255, 0.2);
+            color: #b4eeff;
+            border: 1px solid rgba(22, 198, 255, 0.4);
+            padding: 6px 10px;
+            border-radius: 10px;
+            font-size: 12px;
+        }
+
+        .badge-soft.warn {
+            background: rgba(255, 170, 35, 0.2);
+            color: #ffdca1;
+            border-color: rgba(255, 170, 35, 0.4);
+        }
+
+        .menu-link {
+            text-decoration: none;
+            color: #fff;
+            padding: 10px 14px;
+            border-radius: 12px;
+            border: 1px solid rgba(255, 255, 255, 0.14);
+            transition: .2s ease;
+            display: inline-block;
+        }
+
+        .menu-link:hover {
+            transform: translateY(-2px);
+            border-color: rgba(124, 92, 255, 0.7);
+            color: #fff;
+            background: rgba(124, 92, 255, 0.22);
+        }
+    </style>
+</head>
+<body>
+<div class="container py-4 py-md-5">
+    <div class="glass p-4 p-md-5 mb-4 hero">
+        <span class="brand-pill">Invoice Management • <?= strtoupper(htmlspecialchars($_SESSION['admin']['role'])) ?></span>
+        <div class="d-md-flex justify-content-between align-items-end mt-3 gap-3">
+            <div>
+                <h1>Dashboard Invoice Modern</h1>
+                <p>Pantau performa penagihan, status invoice, dan aktivitas terbaru dalam satu tampilan.</p>
+            </div>
+            <div class="d-flex gap-2 flex-wrap mt-3 mt-md-0">
+                <a class="menu-link" href="customers.php">👥 Customers</a>
+                <a class="menu-link" href="invoices.php">🧾 Invoices</a>
+                <a class="menu-link" href="export.php">📤 Export</a>
+                <a class="menu-link" href="logout.php">🚪 Logout</a>
+            </div>
+        </div>
+    </div>
+
+    <div class="row g-3 mb-3">
+        <div class="col-md-6 col-xl-3">
+            <div class="glass p-4 stat-card h-100">
+                <h6>Total Customers</h6>
+                <h3><?= number_format($stats['customers']) ?></h3>
+            </div>
+        </div>
+        <div class="col-md-6 col-xl-3">
+            <div class="glass p-4 stat-card h-100">
+                <h6>Total Invoices</h6>
+                <h3><?= number_format($stats['invoices']) ?></h3>
+            </div>
+        </div>
+        <div class="col-md-6 col-xl-3">
+            <div class="glass p-4 stat-card h-100">
+                <h6>Paid Invoices</h6>
+                <h3><?= number_format($stats['paid']) ?></h3>
+            </div>
+        </div>
+        <div class="col-md-6 col-xl-3">
+            <div class="glass p-4 stat-card h-100">
+                <h6>Revenue Collected</h6>
+                <h3>Rp <?= number_format($stats['revenue'], 0, ',', '.') ?></h3>
+            </div>
+        </div>
+    </div>
+
+    <div class="row g-3">
+        <div class="col-lg-4">
+            <div class="glass p-4 h-100">
+                <h5 class="mb-3">Collection Health</h5>
+                <p class="mb-2"><span class="metric-dot" style="background:#16c6ff"></span>Paid: <strong><?= $stats['paid'] ?></strong></p>
+                <p class="mb-3"><span class="metric-dot" style="background:#ffaa23"></span>Pending: <strong><?= $stats['pending'] ?></strong></p>
+                <div class="progress mb-2">
+                    <div class="progress-bar" style="width: <?= $collectionRate ?>%"></div>
+                </div>
+                <small class="text-light-emphasis"><?= $collectionRate ?>% invoice sudah dibayar.</small>
+            </div>
+        </div>
+        <div class="col-lg-8">
+            <div class="glass p-4 h-100">
+                <h5 class="mb-3">Invoice Terbaru</h5>
+                <div class="table-responsive">
+                    <table class="table table-borderless align-middle mb-0">
+                        <thead>
+                        <tr>
+                            <th>#ID</th>
+                            <th>Customer</th>
+                            <th>Nilai</th>
+                            <th>Jatuh Tempo</th>
+                            <th>Status</th>
+                        </tr>
+                        </thead>
+                        <tbody>
+                        <?php if ($recentInvoices && $recentInvoices->num_rows): ?>
+                            <?php while ($inv = $recentInvoices->fetch_assoc()): ?>
+                                <tr>
+                                    <td>#<?= $inv['id'] ?></td>
+                                    <td><?= htmlspecialchars($inv['name']) ?></td>
+                                    <td><?= htmlspecialchars($inv['currency']) ?> <?= number_format($inv['amount'], 0, ',', '.') ?></td>
+                                    <td><?= htmlspecialchars($inv['due_date']) ?></td>
+                                    <td>
+                                        <span class="badge-soft <?= $inv['status'] === 'paid' ? '' : 'warn' ?>">
+                                            <?= strtoupper(htmlspecialchars($inv['status'])) ?>
+                                        </span>
+                                    </td>
+                                </tr>
+                            <?php endwhile; ?>
+                        <?php else: ?>
+                            <tr>
+                                <td colspan="5" class="text-center py-4 text-light-emphasis">Belum ada invoice.</td>
+                            </tr>
+                        <?php endif; ?>
+                        </tbody>
+                    </table>
+                </div>
+            </div>
+        </div>
+    </div>
 </div>
+</body>
+</html>

