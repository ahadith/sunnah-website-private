
FROM tutum/lamp:latest
	# Clear the appdir
	RUN rm -fr /app 

	# Move the app over
	COPY . /app
	RUN mv /app/mysql-setup.sh /mysql-setup.sh

	# Get composer
	RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
	RUN php composer-setup.php --install-dir=/bin --filename=composer
	RUN php -r "unlink('composer-setup.php');"
	
	# Get Yii via Composer and configure permissions
	WORKDIR /usr/local/yii
	RUN php /bin/composer require yiisoft/yii=1.1.15
	RUN php /bin/composer install --working-dir=/usr/local/yii
	RUN mv /usr/local/yii/vendor/yiisoft/yii/* /usr/local/yii
	RUN rm -rf /usr/local/vendor
	RUN chown -R www-data:www-data /var/www/
	RUN chown -R www-data:www-data /usr/local/yii
	RUN chmod -R 777 /var/www
	RUN chmod -R 777 /usr/local/yii
	
	# We'll need memcached and the php5 extension
	RUN apt-get update
	RUN apt-get install -y php5-memcached memcached
	RUN service apache2 restart
	RUN service memcached start

	# Allow apache2/httpd/www-data to write to it
	RUN chown -R www-data:www-data /app
	RUN chmod -R 777 /app
	
	EXPOSE 80 3306
CMD ["/run.sh"]
