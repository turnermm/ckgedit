#!/bin/bash
# This script is under public domain do with it whatever you want (yes, that includes eating it).
if [ $# -lt 1 ]; then
    echo "Usage: $(basename $0) [animal domain or directory]"
    exit 1
fi


ANIMAL=${PWD}/${1}
ANIMAL_TITLE=$1

if [ -d $ANIMAL ]; then
    echo "ERROR: $ANIMAL exists already!"
    exit 1
fi

echo ">> adding animal $1"

echo ">> creating directory structure ..."
mkdir -p ${ANIMAL}/{data/{attic,cache,index,locks,media,media_attic,media_meta,meta,pages,tmp},conf}
find ${ANIMAL}/ -type d -exec chmod 777 {} \;
touch ${ANIMAL}/conf/{local.php,local.protected.php,acl.auth.php,users.auth.php,plugins.local.php}
chmod 666 ${ANIMAL}/conf/{local.php,acl.auth.php,users.auth.php,plugins.local.php}

echo ">> creating basic configuration ..."
echo "<?php
\$conf['title'] = '${ANIMAL_TITLE}';
\$conf['lang'] = 'en';
\$conf['useacl'] = 1;
\$conf['animal'] = '${ANIMAL_TITLE}';
\$conf['animal_inc'] = '${ANIMAL}/';
\$conf['superuser'] = '@admin';" > ${ANIMAL}/conf/local.php

echo ">> setting fixed configuration ..."
echo "<?php
\$conf['savedir'] = DOKU_CONF.'../data';
\$conf['updatecheck'] = 0;" > ${ANIMAL}/conf/local.protected.php

echo ">> setting basic permissions ..."
echo "# <?php exit()?>
* @admin 255
* @ALL 1" > ${ANIMAL}/conf/acl.auth.php

echo ">> adding admin user ..."
echo '# <?php exit()?>
admin:$1$cce258b2$U9o5nK0z4MhTfB5QlKF23/:admin:admin@mail.org:admin,user' > ${ANIMAL}/conf/users.auth.php

echo ">> IMPORTANT: Don't forget to change your admin username + password!"
echo ">> finished!"
echo ">> bye!"

exit 0

# vim:ts=4:sw=4:noet:enc=utf-8: