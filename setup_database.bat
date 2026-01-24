@echo off
echo ========================================================
echo SETUP AWAL DATABASE (Fresh Install)
echo PERINGATAN: Jalankan ini hanya jika database KOSONG.
echo ========================================================

echo.
echo 1. Membuat Database...
C:\xamppp\mysql\bin\mysql.exe -u root -e "CREATE DATABASE IF NOT EXISTS absensi_mutiara;"

echo.
echo 2. Reset & Seed Database...
set PHP_BIN=C:\xamppp\php\php.exe
set PHP_INI=%CD%\php.ini
"%PHP_BIN%" -c "%PHP_INI%" artisan migrate:fresh --seed --force

echo.
echo Selesai! Sekarang jalankan start_project.bat
pause
