#!/usr/bin/env bash

TMP=/tmp/daemonservice
PIDFILE=$TMP/daemonservice.pid
mkdir -p $TMP
USER=$(id --user --name)
USGMSG="Usage: $0 ./daemon.php {start|stop|status|restart}"

case $# in
    2) SCRIPT=$1; ACTION=$2 ;;
    *) echo $USGMSG; exit 1 ;;
esac

if [ ! -f $SCRIPT ]; then
    echo "$SCRIPT doesnt exists!"
    exit 1
fi

case $ACTION in
    start)
        if [ -f $PIDFILE ] && kill -0 $(cat $PIDFILE); then
            echo 'Service already running'
            exit 1
        fi
        echo 'Staring service'
        nohup php $SCRIPT & echo $! > $PIDFILE
        ;;
    stop)
        if [ ! -f $PIDFILE ] || ! kill -0 $(cat "$PIDFILE"); then
            echo 'Service not running'
            exit 1
        fi
        echo 'Stopping service…'
        kill -15 $(cat "$PIDFILE") && rm -f "$PIDFILE"
        echo 'Service stopped'
       ;;
    restart)
       stop
       start
       ;;
    status)
        if [ -f $PIDFILE ] && kill -0 $(cat "$PIDFILE"); then
            echo 'Service running'
        else
            echo 'Service not running'
        fi
       ;;
    *)
       echo $USGMSG
esac
