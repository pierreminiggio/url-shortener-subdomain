DNS configuration to add for each domain I'm adding to be used by the URL Shortener :
```
link-shortener-user IN A 151.80.58.150

* IN CNAME link-shortener-user
```

Apache Configuration :
```
nano /etc/httpd/conf.d/vhost.conf
```

```
<VirtualHost *:80>
ServerName url-shortener-user.[domain].[tld]
ServerAlias www.url-shortener-user.[domain].[tld]
ServerAlias *.[domain].[tld]
ServerAdmin pierre@miniggiodev.fr
DocumentRoot /var/www/html/url-shortener-subdomain/
ErrorLog /var/www/logs/url-shortener-subdomain_error.log
CustomLog /var/www/logs/url-shortener-subdomain_access.log combined
<Directory "/var/www/html/url-shortener-subdomain/">
    AllowOverride All
</Directory>
RewriteEngine on
RewriteCond %{SERVER_NAME} =*.[domain].[tld] [OR]
RewriteCond %{SERVER_NAME} =www.url-shortener-user.[domain].[tld] [OR]
RewriteCond %{SERVER_NAME} =url-shortener-user.[domain].[tld]
RewriteRule ^ https://%{SERVER_NAME}%{REQUEST_URI} [END,NE,R=permanent]
</VirtualHost>
```

```
nano /etc/httpd/conf.d/vhost-le-ssl.conf
```

```
<IfModule mod_ssl.c>
<VirtualHost *:443>
ServerName url-shortener-user.[domain].[tld]
ServerAlias www.url-shortener-user.[domain].[tld]
ServerAlias *.[domain].[tld]
ServerAdmin pierre@miniggiodev.fr
DocumentRoot /var/www/html/url-shortener-subdomain/
ErrorLog /var/www/logs/url-shortener-subdomain_error.log
CustomLog /var/www/logs/url-shortener-subdomain_access.log combined
<Directory "/var/www/html/url-shortener-subdomain/">
    AllowOverride All
</Directory>

#Include /etc/letsencrypt/options-ssl-apache.conf
#SSLCertificateFile /etc/letsencrypt/live/url-shortener-user.[domain].[tld]/fullchain.pem
#SSLCertificateKeyFile /etc/letsencrypt/live/url-shortener-user.[domain].[tld]/privkey.pem
</VirtualHost>
</IfModule>
```

Restart Apache
```
service httpd restart
```

Generate certificate :
```
certbot certonly -d url-shortener-user.[domain].[tld] -d www.url-shortener-user.[domain].[tld]
```

Uncomment the certificate loading lines :
```
nano /etc/httpd/conf.d/vhost-le-ssl.conf
```

```
#Include /etc/letsencrypt/options-ssl-apache.conf
#SSLCertificateFile /etc/letsencrypt/live/url-shortener-user.[domain].[tld]/fullchain.pem
#SSLCertificateKeyFile /etc/letsencrypt/live/url-shortener-user.[domain].[tld]/privkey.pem
```

Expand certificate to include users (list to be updated as users register) :
```
certbot -d url-shortener-user.[domain].[tld] -d www.url-shortener-user.[domain].[tld] -d pierreminiggio.[domain].[tld] -d www.pierreminiggio.[domain].[tld] -d kmjoshimusic.[domain].[tld] -d www.kmjoshimusic.[domain].[tld] -d sayantavfx.[domain].[tld] -d www.sayantavfx.[domain].[tld] -d terre.[domain].[tld] -d www.terre.[domain].[tld]
```
