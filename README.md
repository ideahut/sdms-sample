# sdms-sample
Sample project for composer <b>ideahut/sdms</b>



### Create schema

    $ /path/to/slim-rest-api/vendor/bin/doctrine orm:schema-tool:create

# Windows	
	php vendor\bin\doctrine orm:schema-tool:create
	
    
### Update schema

    $ /path/to/slim-rest-api/vendor/bin/doctrine orm:schema-tool:update --force
	
# Windows
	php vendor\bin\doctrine orm:schema-tool:update --force


COMPOSER
========
set PHP_DIR=D:\04_PROJECT\FRAMEWORK\PHP\SLIM-DOCTRINE\php
%PHP_DIR%\php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
%PHP_DIR%\php -r "if (hash_file('sha384', 'composer-setup.php') === '48e3236262b34d30969dca3c37281b3b4bbe3221bda826ac6a9a62d6444cdb0dcd0615698a5cbe587c3f0fe57a54d8f5') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
%PHP_DIR%\php composer-setup.php
%PHP_DIR%\php -r "unlink('composer-setup.php');"

composer require slim/slim
composer require doctrine/orm
composer require monolog/monolog
composer require awurth/slim-validation
composer require predis/predis

*)Jika sudah punya composer.json, jalankan perintah:
	php composer.phar install
*)Untuk melihat daftar vendor dan versinya:
	php composer.phar show



SQL SERVER
==========
1. Buka Microsoft SQL Server Management Studio.
2. Create New Login, lewat Security => New Login, dan pilih SQL Server Authentication. Isi name dan password.
3. Pilih Server Role: dbcreator, sysadmin
4. Login menggunakan user baru, dan Create New Database
5. Copy file php_pdo_sqlsrv_55_ts.dll ke folder <PHP>/ext, dan edit php.ini dengan menambah extension=php_pdo_sqlsrv_55_ts.dll
6. Enable network: SQL Server Network Configuration | Protocols for SQLEXPRESS >> TCP/IP protocol >> find the IPAll section >> Port: 1433
7. Edit table dan set semua default value VERSION_ = 1
8. Edit file Doctrine\DBAL\Types\DateTimeType:
	public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if( $value === null) {
		  return null;
		}
		$value = $value->format($platform->getDateTimeFormatString());
		if( strlen($value) == 26 &&
			$platform->getDateTimeFormatString() == 'Y-m-d H:i:s.u' && 
			($platform instanceof \Doctrine\DBAL\Platforms\SQLServer2008Platform || 
			 $platform instanceof \Doctrine\DBAL\Platforms\SQLServer2005Platform)
		) 
		{
		  $value = substr($value, 0, \strlen($value)-3);
		}
	   return $value;
    }
	


ORACLE
======
1. https://docs.oracle.com/cd/E17781_01/admin.112/e18585/toc.htm#XEGSG110
2. Tambahkan instantclient_12_2 ke %PATH%
3. Copy ke folder ext: php_oci8.dll utk php7 atau php_oci8_12c.dll utk php5
4. Edit file \Doctrine\DBAL\Platforms\OraclePlatform.php, fungsi getGuidExpression() menjadi return 'SYS.STANDARD.TO_CHAR(SYS_GUID()) FROM DUAL';
5. Format Tanggal ada di Doctrine\DBAL\Event\Listeners\OracleSessionInit
6  SQL> create user php_slim_doctrine identified by php_slim_doctrine;
   SQL> grant CREATE SESSION, ALTER SESSION, CREATE DATABASE LINK, CREATE MATERIALIZED VIEW, CREATE PROCEDURE, CREATE PUBLIC SYNONYM, CREATE ROLE, CREATE SEQUENCE, CREATE SYNONYM, CREATE TABLE, CREATE TRIGGER, CREATE TYPE, CREATE VIEW, UNLIMITED TABLESPACE to php_slim_doctrine;
6. SQL Command (user: system):
	SELECT * FROM v$nls_parameters WHERE PARAMETER like 'NLS_TIME%' or PARAMETER like 'NLS_DATE%';
		NLS_DATE_FORMAT			: DD-MON-RR
		NLS_DATE_LANGUAGE		: AMERICAN
		NLS_TIME_FORMAT			: HH.MI.SSXFF AM
		NLS_TIMESTAMP_FORMAT	: DD-MON-RR HH.MI.SSXFF AM
		NLS_TIME_TZ_FORMAT		: HH.MI.SSXFF AM TZR
		NLS_TIMESTAMP_TZ_FORMAT	: DD-MON-RR HH.MI.SSXFF AM TZR
	ALTER SYSTEM SET NLS_TIME_FORMAT='HH24:MI:SS' SCOPE=SPFILE;
	ALTER SYSTEM SET NLS_DATE_FORMAT='YYYY-MM-DD HH24:MI:SS' SCOPE=SPFILE;	
	ALTER SYSTEM SET NLS_TIMESTAMP_FORMAT='YYYY-MM-DD HH24:MI:SS' SCOPE=SPFILE;
	ALTER SYSTEM SET NLS_TIME_TZ_FORMAT='HH24:MI:SS TZH:TZM' SCOPE=SPFILE;
	ALTER SYSTEM SET NLS_TIMESTAMP_TZ_FORMAT='YYYY-MM-DD HH24:MI:SS TZH:TZM' SCOPE=SPFILE;
	<<atau>>
	ALTER SESSION SET NLS_TIME_FORMAT='HH24:MI:SS';
	ALTER SESSION SET NLS_DATE_FORMAT='YYYY-MM-DD HH24:MI:SS';	
	ALTER SESSION SET NLS_TIMESTAMP_FORMAT='YYYY-MM-DD HH24:MI:SS';
	ALTER SESSION SET NLS_TIME_TZ_FORMAT='HH24:MI:SS TZH:TZM';
	ALTER SESSION SET NLS_TIMESTAMP_TZ_FORMAT='YYYY-MM-DD HH24:MI:SS TZH:TZM';
	<<atau>>
	*) SQL> create pfile='D:\ORCL.ini' FROM SPFILE;
	*) Shutdown the database.
	*) Edit 'D:\ORCL.ini':
		NLS_TIME_FORMAT=HH24:MI:SS
	    NLS_DATE_FORMAT=YYYY-MM-DD HH24:MI:SS
	    NLS_TIMESTAMP_FORMAT=YYYY-MM-DD HH24:MI:SS
	    NLS_TIME_TZ_FORMAT=HH24:MI:SS TZH:TZM
	   	NLS_TIMESTAMP_TZ_FORMAT=YYYY-MM-DD HH24:MI:SS TZH:TZM
	    NLS_NUMERIC_CHARACTERS=.,
	*) SQL> startup pfile='D:\ORCL.ini'
	*) create spfile from pfile='D:\ORCL.ini'
	<<atau>>
	EXEC dbms_session.set_nls ('NLS_TIME_FORMAT','''HH24:MI:SS''');
	EXEC dbms_session.set_nls ('NLS_DATE_FORMAT','''YYYY-MM-DD HH24:MI:SS''');
	EXEC dbms_session.set_nls ('NLS_TIMESTAMP_FORMAT','''YYYY-MM-DD HH24:MI:SS''');
	EXEC dbms_session.set_nls ('NLS_TIME_TZ_FORMAT','''HH24:MI:SS TZH:TZM''');
	EXEC dbms_session.set_nls ('NLS_TIMESTAMP_TZ_FORMAT','''YYYY-MM-DD HH24:MI:SS TZH:TZM''');
	<<atau>>
	OracleSessionInit	
	$conn = $args->getConnection();
    foreach ($this->_defaultSessionVars as $option => $value) {
        if ($option === 'CURRENT_SCHEMA') {
            $i = $conn->executeUpdate("EXEC dbms_session.set_nls ('" . $option . "', ''" . $value . "'')");
            var_dump($i);
        } else {
            $conn->executeUpdate("EXEC dbms_session.set_nls ('" . $option . "', '''" . $value . "''')");
        }    
    }
7. Restart server.
8. startup force;


POSTGRES
========
1. Tambahkan baris berikut ke httpd-php:
		LoadFile "${APP_DIR}\pgsql_client\libpq.dll"
   pgsql_client diambil dari folder bin di server (hanya yang dll dan sesuaikan dengan arsitektur apache apakah x32 atau x64)
2. Untuk mengaktifkan UUID generator ketik di query tool sbb:
		CREATE EXTENSION IF NOT EXISTS "uuid-ossp";
   Di function akan muncul daftar fungsi untuk mengenerate UUID.	
3. Untuk ID yang sequence, jika terjadi kegagalan insert karena duplicate,
   maka cek di Sequences, pilih sequence table. Klik kanan dan pilih Propertis, selanjutnya pilih tab Definition.
   Ganti Current Value sesuai dengan ID terakhir yang ada di table. 
   Kasus ini terjadi karena query insert di query tool menyertakan ID, sehingga tidak auto increment.
   Akibatnya fungsi sequence tidak diupdate.


TRIKS
=====
1. Tambah line berikut di index.php setelah vendor/autoload.php
   \Doctrine\Common\Annotations\AnnotationRegistry::registerLoader('class_exists');
