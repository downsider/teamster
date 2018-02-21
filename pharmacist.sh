!#/bin/bash
mkdir app && mkdir app/pid && chmod 777 app/pid
vendor/bin/pharmacist verify
rm -rf app
