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

Video expaining how to install using MySQL/MariaDB (optional)
Link: https://www.youtube.com/watch?v=QwWq8czW40M

YaTQA Tool to query Teamspeak 3 Server (optional): http://yat.qa

------------
Description:
------------
Script to manage Teamspeak 3 Server on Linux
Currently tested for Ubuntu, Debian and CentOS

-------------
Instructions:
------------
1. Create a new directory for the user that will be added
Example:
	mkdir /srv/ts3

2. Create a new user that will run your Teamspeak Server
Example:
	useradd -r -U -c "ts3server" -d /srv/ts3 -s /bin/sh ts3

3. Download ts3server and change permissions on the folder
Download:
	Teamspeak 3 Server and upload to /srv/ts3
	URL: https://www.teamspeak.com/en/downloads#server

Example:
	chown -R ts3:ts3 /srv/ts3
	chmod -R 774 /srv/ts3/libts3db*
	chmod -R 774 /srv/ts3/ts3server*

4. Download the script and upload to /etc/init.d
Example:
	cd /etc/init.d
	wget https://github.com/freddan88/ts3srv-linux/raw/master/init-ts3srv

5. Edit the script to include your path, user and script (optional)
Example:
	nano /etc/init.d/init-ts3srv

Config:
	DIR=/srv/ts3 "Path to ts3server-files"
	EXE=ts3server_startscript.sh "Script"
	USER=ts3 "User for ts3server"

6. Change permission and start the server
Example:
	chmod 754 /etc/init.d/init-ts3srv
	/etc/init.d/init-ts3srv start

7. Accept the license and start the service
Example:
	nano /srv/ts3/ts3server.ini
	Change: license_accepted=0 <to> license_accepted=1
	/etc/init.d/init-ts3srv start

8. Configure Autostart
Example:
	CentOS
	------
	chkconfig --add init-ts3srv // Enable
	chkconfig --del init-ts3srv // Disable

	Ubuntu
	------
	update-rc.d init-ts3srv defaults // Enable
	update-rc.d init-ts3srv remove // Disable

	Debian
	------
	update-rc.d init-ts3srv defaults // Enable
	update-rc.d init-ts3srv remove // Disable

------------------
Actions and usage:
------------------

/etc/init.d/init-ts3srv start
	1. Checks for ts3server.ini (configuration) and if not found creates it
	2. Checks if license is accepted and then starts the server if it is
	3. If the license is not accepted the server will ask you to accept it

/etc/init.d/init-ts3srv stop
	Stop the server and removes the pid-file

/etc/init.d/init-ts3srv restart
	Restarts the server

/etc/init.d/init-ts3srv status
	Checks if ts3server is running echos pid

/etc/init.d/init-ts3srv
	Shows usage and parameters

----------
END README
----------
