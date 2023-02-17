#!/bin/bash

for fic in *.html
do
    nom_html=$(basename $fic .html)
    docker container run -ti --rm -v "$(pwd)":/work sae103-html2pdf "html2pdf $fic $nom_html.pdf"
done

mv *.pdf regions_pdf/
rm regions_pdf/*.html