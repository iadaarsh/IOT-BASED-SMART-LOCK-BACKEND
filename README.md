# About Lock Backend

This is the backend of the [HomeLock App](https://github.com/suvambasak/HomeLock.git) and [Door Lock](https://github.com/suvambasak/door-lock.git). The socket server communicates with the door lock and that web services handle the android app activities.

## Setup

### Installation and Dependencies
- [Donwload](https://www.apachefriends.org/download.html) and install XAMPP 
```bash
$ cd Downloads
$ sudo chmod +x xampp-linux-x64-7.3.28-1-installer.run
$ sudo ./xampp-linux-x64-7.3.28-1-installer.run
```
- Install two python packages `python3-pymysql`, `python3-crypto`
```bash
$ sudo apt install python3-pymysql python3-crypto
```

### Start Server
- Install git and clone the repository inside `htdocs`
```bash
$ sudo apt install git
$ sudo chmod -R user /opt/lampp/htdocs/
$ cd /opt/lampp/htdocs/
$ git clone https://github.com/suvambasak/lock-server.git
$ sudo chmod +x lock-server/socket_server/Server.py
$ sudo ./Server.sh
```
### Import Database
- Goto: http://localhost/phpmyadmin/
- Inside `Import` tab > Choose file > `db/lockdb.sql` > Go