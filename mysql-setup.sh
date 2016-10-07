#!/bin/bash

gunzip /samplegitdb.sql.gz
mysql --user=root --password= -e "CREATE DATABASE hadithdb;"
mysql --user=root --password= hadithdb < /samplegitdb.sql
