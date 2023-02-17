#!/usr/bin/bash

for code_region in $(cut -d ',' -f 5 < regions.conf | cut -d '.' -f 1 | tr '\n' ' ')
do
    # génère un QR code :
    docker run -ti --rm -v "$(pwd)":/work sae103-qrcode qrencode -o qrcodes/$code_region.png "https://bigbrain.biz/$code_region"
done