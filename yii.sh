#!/bin/bash

DIR=$(dirname ${BASH_SOURCE})
cd $DIR

# Debugging PHP CLI scripts with PhpStorm
# @link https://confluence.jetbrains.com/display/PhpStorm/Debugging+PHP+CLI+scripts+with+PhpStorm#DebuggingPHPCLIscriptswithPhpStorm-StartingaDebuggingSessionfromtheCommandLine
export XDEBUG_CONFIG="remote_enable=1 remote_mode=req remote_port=9005 remote_host=host.docker.internal remote_connect_back=0"

php yii $@