<?php

// Konstanta untuk persegi panjang
const PANJANG = 8;
const LEBAR = 5;

$luas = PANJANG * LEBAR;
echo "Luas dari persegi panjang dengan P=8 dan L=5 adalah: " . $luas . "<br>";

$keliling = 2 * (PANJANG + LEBAR);
echo "Keliling dari persegi panjang dengan P=8 dan L=5 adalah: " . $keliling . "<br>";

// Konstanta untuk balok
const PANJANG_BALOK = 7;
const LEBAR_BALOK = 3;
const TINGGI_BALOK = 6;

$volume = PANJANG_BALOK * LEBAR_BALOK * TINGGI_BALOK;
echo "Volume dari Balok dengan P=7 dan L=3 dan T=6 adalah: " . $volume . "<br>";

$LuasPermukaanBalok = 2 * ((PANJANG_BALOK * LEBAR_BALOK) + (PANJANG_BALOK * TINGGI_BALOK) + (LEBAR_BALOK * TINGGI_BALOK));
echo "Luas Permukaan dari Balok dengan P=7 dan L=3 dan T=6 adalah: " . $LuasPermukaanBalok . "<br>";

// Konstanta untuk tabung
const JARI_JARI = 15;
const TINGGI_TABUNG = 10;
const PHI = 3.14;

$volume_tabung = PHI * (JARI_JARI ** 2) * TINGGI_TABUNG;
echo "Volume dari Tabung dengan Jari-Jari=15 dan Tinggi=10 adalah: " . $volume_tabung . "<br>";

$LuasPermukaanTabung = 2 * PHI * JARI_JARI * (JARI_JARI + TINGGI_TABUNG);
echo "Luas Permukaan dari Tabung dengan Jari-Jari=15 dan Tinggi=10 adalah: " . $LuasPermukaanTabung . "<br>";

?>