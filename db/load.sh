#!/bin/sh

BASE_DIR=$(dirname "$(readlink -f "$0")")
if [ "$1" != "test" ]; then
    psql -h localhost -U prueba -d prueba < $BASE_DIR/prueba.sql
    if [ -f "$BASE_DIR/prueba_test.sql" ]; then
        psql -h localhost -U prueba -d prueba < $BASE_DIR/prueba_test.sql
    fi
    echo "DROP TABLE IF EXISTS migration CASCADE;" | psql -h localhost -U prueba -d prueba
fi
psql -h localhost -U prueba -d prueba_test < $BASE_DIR/prueba.sql
echo "DROP TABLE IF EXISTS migration CASCADE;" | psql -h localhost -U prueba -d prueba_test
