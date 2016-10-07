FROM tutum/lamp:latest
	# Clear the appdir
	RUN rm -fr /app 

	# We'll need memcached and the php5 extension
	RUN apt-get update && apt-get install -y \
	    php5-memcached  \
	    memcached       \
	    && rm -rf /var/lib/apt/list/*
	RUN service apache2 restart
	RUN service memcached start

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
		
	
	# Move the app over
	COPY ./application /app/application
	COPY ./public /app/public
	COPY ./mysql-setup.sh /
	COPY ./samplegitdb.sql.gz /
	RUN rm -f /var/www/html && ln -s /app/public /var/www/html

	# Configure proper permissions to directory && yii
	RUN chown -R www-data:www-data /app /usr/local/yii
	RUN chmod -R 755 /app

	# Expose the ports for http and mysqld
	EXPOSE 80 3306
CMD ["/run.sh"]
