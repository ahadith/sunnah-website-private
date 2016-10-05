#!/bin/bash

gunzip /app/samplegitdb.sql.gz
mysql --user=root --password= -e "CREATE DATABASE hadithdb;"
mysql --user=root --password= hadithdb < /app/samplegitdb.sql
