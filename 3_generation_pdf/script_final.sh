#!/bin/bash
chmod +x script_extraction_donnees.php

./script_extraction_donnees.php


mkdir qrcodes


chmod +x script_generation_qrcode_linux.sh

./script_generation_qrcode_linux.sh


mkdir photos_commerciaux

cp images/*.svg photos_commerciaux/


chmod +x script_traitement_photos_linux.sh

./script_traitement_photos_linux.sh

chmod +x script_generation_html.php

./script_generation_html.php

 
mkdir regions_pdf

cp *.html regions_pdf/


chmod +x script_generation_pdf.sh

./script_generation_pdf.sh



tar czvf regions_pdf.tar.gz regions_pdf

