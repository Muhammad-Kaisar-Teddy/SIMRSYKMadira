<?php
/**
 * SIMRS YK Madira - Main Entry Point
 * 
 * This file serves as the main router for the application
 */

// Start session
session_start();

// Include database configuration
require_once 'src/config/database/db.php';

// Simple routing logic
$page = isset($_GET['page']) ? $_GET['page'] : 'splash';

switch ($page) {
    case 'splash':
        include 'src/views/auth/splash.html';
        break;
    case 'login':
        include 'src/views/auth/login.html';
        break;
    case 'dashboard-admin':
        include 'src/views/admin/dashboard-admin.html';
        break;
    case 'dashboard-user':
        include 'src/views/user/dashboard-user.html';
        break;
    case 'booking':
        include 'src/views/user/booking.html';
        break;
    case 'pasien':
        include 'src/views/user/pasien.html';
        break;
    case 'rekam-medis':
        include 'src/views/user/rekam-medis.html';
        break;
    case 'fasilitas-tarif':
        include 'src/views/user/fasilitas-tarif.html';
        break;
    case 'admin-bookings':
        include 'src/views/admin/bookings.html';
        break;
    case 'admin-doctors':
        include 'src/views/admin/doctors.html';
        break;
    default:
        include 'src/views/auth/splash.html';
        break;
}
?>
