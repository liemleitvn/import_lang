#!/bin/sh
echo "Creating JA Localization Data..."
php artisan import:import ja
echo "Done create JA Localization Data!"
echo " "
echo "Creating EN Localization Data..."
php artisan import:import en
echo "Done create EN Localization Data!"
echo ""
echo "Creating ZH Localization Data..."
php artisan import:import zh
echo "Done create ZH Localization Data!"
echo " "
echo "Creating TW Localization Data..."
php artisan import:import tw
echo "Done create TW Localization Data!"
echo " "
