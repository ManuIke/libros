#!/bin/sh

if [ "$1" = "travis" ]; then
    psql -U postgres -c "CREATE DATABASE prueba_test;"
    psql -U postgres -c "CREATE USER prueba PASSWORD 'prueba' SUPERUSER;"
else
    [ "$1" = "test" ] || sudo -u postgres dropdb --if-exists prueba
    sudo -u postgres dropdb --if-exists prueba_test
    [ "$1" = "test" ] || sudo -u postgres dropuser --if-exists prueba
    [ "$1" = "test" ] || sudo -u postgres psql -c "CREATE USER prueba PASSWORD 'prueba' SUPERUSER;"
    [ "$1" = "test" ] || sudo -u postgres createdb -O prueba prueba
    [ "$1" = "test" ] || sudo -u postgres psql -d prueba -c "CREATE EXTENSION pgcrypto;" 2>/dev/null
    sudo -u postgres createdb -O prueba prueba_test
    sudo -u postgres psql -d prueba_test -c "CREATE EXTENSION pgcrypto;" 2>/dev/null
    [ "$1" = "test" ] && exit
    LINE="localhost:5432:*:prueba:prueba"
    FILE=~/.pgpass
    if [ ! -f $FILE ]; then
        touch $FILE
        chmod 600 $FILE
    fi
    if ! grep -qsF "$LINE" $FILE; then
        echo "$LINE" >> $FILE
    fi
fi
