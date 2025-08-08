<?php
header('Content-Type: application/json');
require_once '../db.php';

$today      = date('Y-m-d');
$date       = $_GET['date']       ?? $today;
$room       = $_GET['room']       ?? 'all';
$trend      = $_GET['trend']      ?? 'Bulan';
$weekStart  = $_GET['week_start'] ?? date('Y-m-d', strtotime('monday this week'));
$weekEnd    = date('Y-m-d', strtotime($weekStart.' +6 day')); // 7 hari

$out = [
  'total_pasien'  => ['dewasa'=>0,'anak'=>0],
  'kunjungan'     => ['IGD/UGD'=>0,'Poliklinik'=>0],
  'kapasitas'     => ['dewasa'=>0,'anak'=>0],
  'tren'          => [],
  'jadwal_dokter' => [],
  'konferensi'    => []
];

/* Total pasien dari birthdate */
$sql = "
SELECT
  SUM(CASE WHEN TIMESTAMPDIFF(YEAR, birthdate, CURDATE()) >= 18 THEN 1 ELSE 0 END) AS dewasa,
  SUM(CASE WHEN TIMESTAMPDIFF(YEAR, birthdate, CURDATE()) <  18 THEN 1 ELSE 0 END) AS anak
FROM patients";
if ($res = $conn->query($sql)) {
  $r = $res->fetch_assoc();
  $out['total_pasien']['dewasa'] = (int)($r['dewasa'] ?? 0);
  $out['total_pasien']['anak']   = (int)($r['anak'] ?? 0);
}

/* Kunjungan Harian pada $date */
$stmt = $conn->prepare("SELECT jenis, jumlah FROM visits WHERE tanggal = ?");
$stmt->bind_param('s', $date);
$stmt->execute();
$res = $stmt->get_result();
while ($row = $res->fetch_assoc()) $out['kunjungan'][$row['jenis']] = (int)$row['jumlah'];

/* Kapasitas Ruangan (pakai kategori+kapasitas kalau ada) */
$hasKategori  = $conn->query("SHOW COLUMNS FROM rooms LIKE 'kategori'")->num_rows > 0;
$hasKapasitas = $conn->query("SHOW COLUMNS FROM rooms LIKE 'kapasitas'")->num_rows > 0;
if ($hasKategori && $hasKapasitas) {
  if ($room === 'Dewasa' || $room === 'Anak-anak') {
    $stmt = $conn->prepare("SELECT SUM(kapasitas) AS total FROM rooms WHERE kategori = ?");
    $stmt->bind_param('s', $room);
    $stmt->execute();
    $total = ($stmt->get_result()->fetch_assoc()['total'] ?? 0);
    $out['kapasitas'][$room === 'Dewasa' ? 'dewasa' : 'anak'] = (int)$total;
  } else {
    $sql = "SELECT
              SUM(CASE WHEN kategori='Dewasa' THEN kapasitas ELSE 0 END) AS dewasa,
              SUM(CASE WHEN kategori='Anak-anak' THEN kapasitas ELSE 0 END) AS anak
            FROM rooms";
    if ($res = $conn->query($sql)) {
      $r = $res->fetch_assoc();
      $out['kapasitas']['dewasa'] = (int)($r['dewasa'] ?? 0);
      $out['kapasitas']['anak']   = (int)($r['anak'] ?? 0);
    }
  }
}

/* Tren kesehatan by periode ($trend) */
$stmt = $conn->prepare("SELECT penyakit, karakteristik, pasien, sembuh
                        FROM health_trends
                        WHERE periode = ? OR ? = 'auto'");
$auto = 'auto';
$stmt->bind_param('ss', $trend, $auto);
$stmt->execute();
$res = $stmt->get_result();
while ($row = $res->fetch_assoc()) $out['tren'][] = $row;

/* Jadwal dokter untuk range weekStart..weekEnd */
$stmt = $conn->prepare("
  SELECT d.name AS nama_dokter, d.specialty AS spesialis,
         s.tanggal, DATE_FORMAT(s.mulai, '%H:%i') AS mulai, DATE_FORMAT(s.selesai, '%H:%i') AS selesai, s.jenis
  FROM schedules s
  JOIN doctors d ON d.id = s.doctor_id
  WHERE s.tanggal BETWEEN ? AND ?
  ORDER BY s.tanggal, s.mulai
  LIMIT 40");
$stmt->bind_param('ss', $weekStart, $weekEnd);
$stmt->execute();
$res = $stmt->get_result();
while ($row = $res->fetch_assoc()) $out['jadwal_dokter'][] = $row;

/* Konferensi mendatang (boleh difilter date=) */
$stmt = $conn->prepare("SELECT judul, DATE_FORMAT(tanggal,'%Y-%m-%d') AS tanggal, DATE_FORMAT(jam,'%H:%i') AS jam
                        FROM conferences
                        WHERE tanggal >= ?
                        ORDER BY tanggal, jam
                        LIMIT 20");
$stmt->bind_param('s', $date);
$stmt->execute();
$res = $stmt->get_result();
while ($row = $res->fetch_assoc()) $out['konferensi'][] = $row;

echo json_encode($out);
