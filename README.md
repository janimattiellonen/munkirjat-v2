Munkirjat-v2
============

Munkirjat.com v2 using Symfony2


## Requirements

* VirtualBox
* Vagrant
* Ansible

Verified to work with VirtualBox 4.3.10, Vagrant 1.6.3 and Ansible 1.7.1

## Installation

### Linux

1) `vagrant up`
2) `Add 192.168.111.249  munkirjat.localhost` to `/etc/hosts`
3) browse to munkirjat.localhost

### OS X

1) `vagrant up`

2) `vagrant ssh`

3) `sudo su`

4) `passwd`

5) exit vagrant

6) `ssh root@192.168.111.249`

7) `/etc/init.d/nginx stop`

8) `/etc/init.d/php5-fpm stop`

9) `usermod -u 501 vagrant` (If you get user logged in then `pkill -STOP -u vagrant` and log in again)

10) `find / -uid 1000 -exec chown -h 501 '{}' \+` (ignore any warnings/errors)

11) `find / -gid 1000 -exec chgrp -h 501 '{}' \+` (ignore any warnings/errors)

12) `/etc/init.d/nginx start`

13) `/etc/init.d/php5-fpm start`

14 Add 192.168.111.249  munkirjat.localhost` to `/etc/hosts`

15) browse to munkirjat.localhost
