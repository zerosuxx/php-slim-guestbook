FROM zerosuxx/php-cli-dev:7.2.9

RUN apt-get update
RUN apt-get -y install libsqlite3-dev libsqlite3-0 mysql-client
RUN apt-get clean
RUN  rm -rf /var/lib/apt/lists/*
RUN docker-php-ext-install pdo_mysql
RUN docker-php-ext-install pdo_sqlite
RUN docker-php-ext-install mysqli