<?php

function formatTanggal($waktu)
{
    $bulan_array = [
        1 => 'Januari',
        2 => 'Februari',
        3 => 'Maret',
        4 => 'April',
        5 => 'Mei',
        6 => 'Juni',
        7 => 'Juli',
        8 => 'Agustus',
        9 => 'September',
        10 => 'Oktober',
        11 => 'November',
        12 => 'Desember',
    ];

    $bl = date('n', strtotime($waktu));
    $bulan = $bulan_array[$bl];
    $tahun = date('Y', strtotime($waktu));

    return "$bulan $tahun";
}

function formatTanggalLengkap($waktu)
{
    // $hari_array = [
    //     'Minggu',
    //     'Senin',
    //     'Selasa',
    //     'Rabu',
    //     'Kamis',
    //     'Jumat',
    //     'Sabtu'
    // ];
    // $hr = date('w', strtotime($waktu));
    // $hari = $hari_array[$hr];

    // $tanggal = date('j', strtotime($waktu));

    $tanggal = date('d', strtotime($waktu));

    $bulan_array = [
        1 => 'Januari',
        2 => 'Februari',
        3 => 'Maret',
        4 => 'April',
        5 => 'Mei',
        6 => 'Juni',
        7 => 'Juli',
        8 => 'Agustus',
        9 => 'September',
        10 => 'Oktober',
        11 => 'November',
        12 => 'Desember',
    ];

    $bl = date('n', strtotime($waktu));
    $bulan = $bulan_array[$bl];
    $tahun = date('Y', strtotime($waktu));

    return "$tanggal $bulan $tahun";
}

function formatTanggalHariLengkap($waktu)
{
    $hari_array = [
        'Minggu',
        'Senin',
        'Selasa',
        'Rabu',
        'Kamis',
        'Jumat',
        'Sabtu'
    ];
    $hr = date('w', strtotime($waktu));
    $hari = $hari_array[$hr];

    // $tanggal = date('j', strtotime($waktu));

    $tanggal = date('d', strtotime($waktu));

    $bulan_array = [
        1 => 'Januari',
        2 => 'Februari',
        3 => 'Maret',
        4 => 'April',
        5 => 'Mei',
        6 => 'Juni',
        7 => 'Juli',
        8 => 'Agustus',
        9 => 'September',
        10 => 'Oktober',
        11 => 'November',
        12 => 'Desember',
    ];

    $bl = date('n', strtotime($waktu));
    $bulan = $bulan_array[$bl];
    $tahun = date('Y', strtotime($waktu));

    return "$hari, $tanggal $bulan $tahun";
}

function formatTanggalWaktu($waktu)
{
    $tanggal = date('d', strtotime($waktu));

    $bulan_array = [
        1 => 'Januari',
        2 => 'Februari',
        3 => 'Maret',
        4 => 'April',
        5 => 'Mei',
        6 => 'Juni',
        7 => 'Juli',
        8 => 'Agustus',
        9 => 'September',
        10 => 'Oktober',
        11 => 'November',
        12 => 'Desember',
    ];

    $bl = date('n', strtotime($waktu));
    $bulan = $bulan_array[$bl];
    $tahun = date('Y', strtotime($waktu));
    $jam = date('H:i:s', strtotime($waktu));

    return "$tanggal $bulan $tahun $jam";
}

function formatTanggalWaktuLengkap($waktu)
{
    $hari_array = [
        'Minggu',
        'Senin',
        'Selasa',
        'Rabu',
        'Kamis',
        'Jumat',
        'Sabtu'
    ];
    $hr = date('w', strtotime($waktu));
    $hari = $hari_array[$hr];

    // $tanggal = date('j', strtotime($waktu));

    $tanggal = date('d', strtotime($waktu));

    $bulan_array = [
        1 => 'Januari',
        2 => 'Februari',
        3 => 'Maret',
        4 => 'April',
        5 => 'Mei',
        6 => 'Juni',
        7 => 'Juli',
        8 => 'Agustus',
        9 => 'September',
        10 => 'Oktober',
        11 => 'November',
        12 => 'Desember',
    ];

    $bl = date('n', strtotime($waktu));
    $bulan = $bulan_array[$bl];
    $tahun = date('Y', strtotime($waktu));
    $jam = date('H:i:s A', strtotime($waktu));

    return "$hari, $tanggal $bulan $tahun $jam";
}
