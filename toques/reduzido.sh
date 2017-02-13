#!/bin/bash
hoje="$(date +%Y%m%d)"
fdsemana="$(date +%u)"
echo $hoje
echo $fdsemana
if [ $(grep -c $hoje /cygdrive/d/ampps/www/clarim/toques/feriados) -ne 0 ]; then
    $(cygstart /cygdrive/d/ampps/www/clarim/toques/$1)
	exit 0;
fi
if [ $fdsemana -ge 5 ]; then
	$(cygstart /cygdrive/d/ampps/www/clarim/toques/$1)
	exit 0;
fi