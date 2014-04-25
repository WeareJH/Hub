#!/bin/sh

cwd=$(pwd)

function install_bower {
    dir=$1
    cwd=$2

    for folder in ${dir}; do

        dirname="$cwd/$folder"
        echo "$dirname\n"

        if [[ ! -d "$dirname" ]]; then
            continue
        fi;


        cd $dirname
        echo $dirname

        if [ -e bower.json ]; then
            bower install
        fi
    done

    cd $cwd

}

install_bower "module/*" $cwd
install_bower "vendor/*/*" $cwd
#root install
bower install


