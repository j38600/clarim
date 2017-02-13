#!/bin/bash
hoje="$(date +%Y-%m-%d)"
echo $hoje
if [ $(grep -c $hoje /cygdrive/d/ampps/www/clarim/toques/feriados) -eq 0 ]; then
    $(cygstart /cygdrive/d/ampps/www/clarim/toques/$1)
fi