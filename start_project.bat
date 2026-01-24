@echo off
echo ========================================================
echo Memulai Website Absensi Mutiara...
echo Path PHP: C:\xamppp\php
echo Path MySQL: C:\xamppp\mysql
echo ========================================================

echo.
echo 1. Memastikan Database Siap...
C:\xamppp\mysql\bin\mysql.exe -u root -e "CREATE DATABASE IF NOT EXISTS absensi_mutiara;"

echo.
echo 2. Menjalankan Migrasi (Update Database)...
set PHP_BIN=C:\xamppp\php\php.exe
set PHP_INI=%CD%\php.ini
"%PHP_BIN%" -c "%PHP_INI%" artisan migrate --force

echo.
echo 3. Menjalankan Server...
echo Akses website di: http://localhost:8000
echo (Tekan Ctrl+C untuk berhenti)
echo.

"%PHP_BIN%" -c "%PHP_INI%" -S 0.0.0.0:8000 -t public
