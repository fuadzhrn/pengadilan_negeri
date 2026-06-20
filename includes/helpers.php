<?php

function badgeStatusProses($status) {
    switch ($status) {
        case 'Diproses':
            return 'bg-primary';
        case 'Selesai':
            return 'bg-success';
        case 'Ditolak':
            return 'bg-danger';
        default:
            return 'bg-warning text-dark';
    }
}
