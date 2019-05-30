@echo off

echo.
echo CREATE SCHEMA
echo -------------
echo vendor\bin\doctrine orm:schema-tool:create
echo.
echo UPDATE SCHEMA
echo -------------
echo vendor\bin\doctrine orm:schema-tool:update --force
echo.
echo Copy perintah di atas 
echo.

set PHP_DIR=D:\04_PROJECT\FRAMEWORK\PHP\SLIM-DOCTRINE\php
set PATH=%PATH%;%PHP_DIR%
set PATH=%PATH%;%PHP_DIR%\instantclient_12_2
set HOME_DIR=%~dp0
cmd.exe /K "cd %HOME_DIR%"
