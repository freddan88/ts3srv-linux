------------
START README
------------

Updated: 2018-08-25

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
Language: Bash

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
Download ts3server (Linux) and upload to: /srv and rename the folder to ts3
URL: https://www.teamspeak.com/en/downloads#server

You can also browse different versions on:
	http://dl.4players.de/ts/releases
	
Example download 64Bit version for Linux and rename
	cd /srv/ts3
	wget http://dl.4players.de/ts/releases/3.8.0/teamspeak3-server_linux_amd64-3.8.0.tar.bz2
	tar xjf teamspeak3-server_linux_amd64-3.8.0.tar.bz2
	mv teamspeak3-server_linux_amd64-3.8.0.tar.bz2 ts3
	
2. 
Download the script to: /etc/init.d
Example:
	cd /etc/init.d
	wget https://github.com/freddan88/ts3srv-linux/raw/master/init-ts3srv
	
3. 
Change permission and finalize installation
Example:
	chmod 755 /etc/init.d/init-ts3srv
	/etc/init.d/init-ts3srv finalize
	
4. 
On first start ts3server.ini and ts3db.ini is created
Example:
	ts3srv run
	
5. 
Read and accept the license
Example:
	cat /srv/ts3/LICENSE
	nano /srv/ts3/ts3server.ini
	Change: license_accepted=0 < TO > license_accepted=1

6.
Start the server again
Example:
	ts3srv run
	
7. 
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
	4. Removes the teamspeak 3 user 'ts3' from your system
	
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

YaTQA Query Tool Teamspeak 3 Server: http://yat.qa
YaTQA Query Tool Teamspeak 3 Manual: https://yat.qa/manual/#consolesyntax

https://gaming.stackexchange.com/questions/51926/how-can-i-directly-link-to-a-teamspeak-server-on-my-website

----------
END README
----------
