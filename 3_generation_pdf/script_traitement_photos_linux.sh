# !/usr/bin/bash

for fic in photos_commerciaux/*.svg
do
    nom_image=$(basename $fic .svg)
    docker container run --rm -ti -v "$(pwd)":/work sae103-imagick "magick photos_commerciaux/$nom_image.svg photos_commerciaux/$nom_image.png"
    docker container run --rm -ti -v "$(pwd)":/work sae103-imagick "magick convert photos_commerciaux/$nom_image.png -crop 555x555+22+0 photos_commerciaux/$nom_image.png"
    docker container run --rm -ti -v "$(pwd)":/work sae103-imagick "magick convert photos_commerciaux/$nom_image.png -resize 200x200 photos_commerciaux/$nom_image.png"
    docker container run --rm -ti -v "$(pwd)":/work sae103-imagick "magick photos_commerciaux/$nom_image.png -colorspace gray photos_commerciaux/$nom_image.png"
    rm photos_commerciaux/$nom_image.svg
done