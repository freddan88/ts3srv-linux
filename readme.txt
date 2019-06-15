------------
START README
------------

Updated: 2019-06-09

------
Links:
------

URL: http://www.leemann.se/fredrik
Donate: https://www.paypal.me/freddan88
YouTube: https://www.youtube.com/user/FreLee54

Github-main: https://github.com/freddan88
Github-page: https://github.com/freddan88/ts3srv-linux

Download Teamspeak Client: https://www.teamspeak.com/en/downloads
Download Teamspeak Server: https://www.teamspeak.com/en/downloads#server

Video:
Tutorial: https://github.com/freddan88/ts3srv-linux/blob/master/readme.txt
Download: http://www.leemann.se/fredrik/file_downloads/ts3srv_linux-init.zip

Platform: Linux
Language: Bash + PHP

----------------------------------------------------
License MIT: https://choosealicense.com/licenses/mit
----------------------------------------------------

------------
Description:
------------

Script to manage Teamspeak 3 Server on Linux
Currently tested for Debian/Ubuntu and CentOS

-------------
Instructions:
------------

1.
Download software and dependencies

Debian/Ubuntu:
	apt-get install nano wget tar bzip2 net-tools sqlite3
CentOS:
	yum install nano wget tar bzip2 net-tools sqlite

2.
Download ts3server (Linux) and upload to: /srv and rename the folder to ts3
URL: https://www.teamspeak.com/en/downloads#server

You can also browse different versions on:
	http://dl.4players.de/ts/releases

Download 64Bit version for Linux using wget and rename the folder to ts3
Example:
	cd /srv
	wget http://dl.4players.de/ts/releases/3.8.0/teamspeak3-server_linux_amd64-3.8.0.tar.bz2
	tar xjf teamspeak3-server_linux_amd64-3.8.0.tar.bz2
	mv teamspeak3-server_linux_amd64 ts3

3.
Download the script to: /etc/init.d
Example:
	cd /etc/init.d
	wget https://github.com/freddan88/ts3srv-linux/raw/master/init-ts3srv

4.
Change permission and finalize installation
Example:
	chmod 755 /etc/init.d/init-ts3srv
	/etc/init.d/init-ts3srv finalize

5.
On first start ts3server.ini and ts3db.ini is created
Example:
	ts3srv run

6.
Read and accept the license
Example:
	cat /srv/ts3/LICENSE
	nano /srv/ts3/ts3server.ini
	Change: license_accepted=0 < TO > license_accepted=1

7.
Start the server again
Example:
	ts3srv run

8.
Configure Autostart
Examples:

	Debian/Ubuntu
	------
	update-rc.d init-ts3srv defaults // Enable
	update-rc.d init-ts3srv remove // Disable
	ls -al /etc/rc*/*ts3srv // List service

	CentOS
	------
	chkconfig --add init-ts3srv // Enable
	chkconfig --del init-ts3srv // Disable
	chkconfig // List services

IF YOU DIDN'T SEE ANY MESSAGE ABOUT SERVER ADMIN TOKEN THEN READ THE LOG FILES
Example:
	cat /srv/ts3/logs/*

Sample output:
2019-06-08 18:11:09.925214|WARNING |VirtualServer |1  |--------------------------------------------------------
2019-06-08 18:11:09.925235|WARNING |VirtualServer |1  |ServerAdmin privilege key created, please use the line below
2019-06-08 18:11:09.925250|WARNING |VirtualServer |1  |token=YOUR SECRET TOKEN
2019-06-08 18:11:09.925264|WARNING |VirtualServer |1  |--------------------------------------------------------

---------------------
Use MariaDB or MySQL:
---------------------

1.
Stop the server and configure init-script
Example:
	ts3srv stop
	nano /etc/init.d/init-ts3srv
	Change: DB_SERVICE_NAME=sqlite < TO > DB_SERVICE_NAME=mysqld

2.
Install MariaDB and secure it
	https://downloads.mariadb.org/mariadb/repositories
	mysql_secure_installation

3. Install PHP
Example PHP 7.3

	Debian:
	apt-get install lsb-release apt-transport-https ca-certificates
	wget -O /etc/apt/trusted.gpg.d/php.gpg https://packages.sury.org/php/apt.gpg
	echo "deb https://packages.sury.org/php/ $(lsb_release -sc) main" | tee /etc/apt/sources.list.d/php7.3.list
	apt-get update
	apt-get install php7.3 php7.3-{cli,fpm,pdo,mysql,zip,gd,mbstring,curl,xml,bcmath,json,ldap}

	CentOS6:
	yum install https://dl.fedoraproject.org/pub/epel/epel-release-latest-6.noarch.rpm
	yum install http://rpms.remirepo.net/enterprise/remi-release-6.rpm
	yum install yum-utils
	yum-config-manager --disable remi-php54
	yum-config-manager --enable remi-php73
        yum install php php-{cli,fpm,pdo,mysql,zip,gd,mbstring,mcrypt,curl,xml,bcmath,json,ldap,fileinfo}

	CentOS7:
	yum install epel-release
	yum install http://rpms.remirepo.net/enterprise/remi-release-7.rpm
	yum install yum-utils
	yum-config-manager --disable remi-php54
	yum-config-manager --enable remi-php73
        yum install php php-{cli,fpm,pdo,mysql,zip,gd,mbstring,mcrypt,curl,xml,bcmath,json,ldap,fileinfo}

Resources:
	https://computingforgeeks.com/how-to-install-php-7-3-on-debian-9-debian-8/
	https://kifarunix.com/installing-php-7-3-3-on-centos-7-6/
	https://www.tecmint.com/install-php-7-in-centos-6/

4.
Create a new database for your teamspeak-server
Example:
	mysqladmin -u root -p create ts3db

5.
Locate the socket-file
Example:
	mysqladmin -u root -p version

Defaults
Debian: /var/run/mysqld/mysqld.sock
CentOS: /var/lib/mysql/mysql.sock

6.
Edit the main configuration-file
    cd /srv/ts3
	cp ts3server.ini ts3server_bak.ini
	nano ts3server.ini

Change to:
	dbplugin=ts3db_mariadb
	dbpluginparameter=ts3db.ini
	dbsqlcreatepath=create_mariadb/

6.
Edit the database configuration-file
    cd /srv/ts3
	cp ts3db.ini ts3db_bak.ini
	nano ts3db.ini

To use MySQL/MariaDB (TCP/IP)
	[config]
	host=127.0.0.1
	port=3306
	username=root
	password=fredrik
	database=ts3db
	socket=

To use MySQL/MariaDB (SOCKET)
	[config]
	host=localhost
	port=3306
	username=root
	password=fredrik
	database=ts3db
	socket=/var/lib/mysql/mysql.sock

7. Start the server to start using the new database
Example:
	ts3srv run

8. Create a new password for serveradmin
Example:
	cd srv/ts3srv
	wget https://github.com/freddan88/ts3srv-linux/raw/master/passwd_serveradmin.php
	php passwd_serveradmin.php <Your password>

(DEFAULT PASSWORD IF NON GIVEN IS: Passw0rd)

Resource:
https://forum.teamspeak.com/threads/48255-Don-t-have-your-Server-Admin-Query-password-Look-here

------------------
Actions and usage:
------------------

ts3srv start
	"This is used by init at boot to force start of your Teamspeak 3 server"

ts3srv run
	1. Checks for ts3db.ini (configuration) and if not found creates it
	2. Checks for ts3server.ini (configuration) and if not found creates it
	3. Checks if license is accepted and then starts the server if it is
	4. If the license is not accepted the server will ask you to accept it

ts3srv stop
	"Stop the Teamspeak 3 server and removes the pid-file"

ts3srv restart
	"Restarts the service"

ts3srv status
	"Checks if ts3server is running and displays information about the process and network"
	- Netstat may not work on CentOS but you can install it using: yum install -y net-tools

ts3srv conf
	"Display all configuration files in terminal"

ts3srv finalize
	1. Creates a symbolic link in /usr/local/sbin/ts3srv
	2. Adds the user ts3 to your system with shell /bin/sh
	3. Will copy files to your ts3-root and change permissions

ts3srv remove_finalization
	1. Will change permissions and owner to root on ts3-root
	2. Removes the symbolic link from /usr/local/sbin/ts3srv
	3. Removes autostart of ts3server if this is configured
    4. Removes init-script from the /etc/init.d directory
	5. Removes the teamspeak 3 user 'ts3' from your system

Delete init-script manually
	Example:
	rm -f /etc/init.d/init-ts3srv

ts3srv passwd_serveradmin
	"Will help you set a new password for serveradmin that can be used to query your server"
	- This command only works on servers using the internal database [ ts3server.sqlitedb ]

ts3srv
	"Shows usage and parameters"
	Example:
	Usage: run|stop|restart|status|conf|finalize|remove_finalization|passwd_serveradmin

-----
Other
-----

You can edit this script if you would like to install into another directory
Example:
	nano /etc/init.d/init-ts3srv

Config:
	DIR=/srv/ts3 "Path to ts3server-files"
	EXE=ts3server_startscript.sh "Script"
	USER=ts3 "User for ts3server"

Video TS3 Server permissions:
Link: https://www.youtube.com/watch?v=CDzk2KbYcVk

Use sqlite3 to browse the local database for teamspeak3
Example:
	root@host:~# sqlite3 /srv/ts3/ts3server.sqlitedb
	------------------------------------------------
	sqlite> .mode line
	sqlite> SELECT * FROM clients;
	sqlite> .exit
	
Use MariaDB/MySQL to browse the database for teamspeak3
Example:
	root@host:~# mysql -u root -p
	-----------------------------
	MariaDB [(none)]> show databases;
	MariaDB [(none)]> use ts3db;
	MariaDB [ts3db]> show tables;
	MariaDB [ts3db]> SELECT * FROM channel_properties;
	MariaDB [ts3db]> exit;

YaTQA Query Tool Teamspeak 3 Server: http://yat.qa
YaTQA Query Tool Teamspeak 3 Manual: https://yat.qa/manual/#consolesyntax

Default user for serverquery: serveradmin
Default port for serverquery: 10011

Password for serveradmin is set during installation.
Password can be changed by running:
    ts3srv passwd_serveradmin <- Local database (SQLite)
    php passwd_serveradmin.php <- Local or remote database (MySQL/MariaDB)

Query your server using Telnet:
https://forum.teamspeak.com/threads/91465-How-to-use-the-Server-Query

- In the more recent versions of teamspeak3 server you can also you SSH for serverQuery´s
Default port for serverquery SSH: 10022

https://gaming.stackexchange.com/questions/51926/how-can-i-directly-link-to-a-teamspeak-server-on-my-website

PHP script to set new password for serveradmin when using MySQL or MariaDB
https://forum.teamspeak.com/threads/48255-Don-t-have-your-Server-Admin-Query-password-Look-here!

Strong random password generator:
https://passwordsgenerator.net/

Install PHP 7.3 on Debian8/9, CentOS6/7:
https://computingforgeeks.com/how-to-install-php-7-3-on-debian-9-debian-8/
https://kifarunix.com/installing-php-7-3-3-on-centos-7-6/

----------
END README
----------
