# Side note: SSH Key and your Server

I followed this site: https://www.hostinger.com/tutorials/ssh/how-to-set-up-ssh-keys 
first type the following in a terminal to generate an ssh key file
```
ssh-keygen -t rsa
```
next is the option to create a password for your SSH connection

to add the ssh key to your remote site type the following into a terminal
```
ssh-copy-id user@server_ip
```
where user is the username for the server (eg. root) and server_ip is the actual server’s ip address
next is a warning to accept sending the key type ‘yes’
then type the server’s password
That is it

Now typing 
```
ssh user@server_ip
```
now type the server’s password again
should give remote access
image of the file location