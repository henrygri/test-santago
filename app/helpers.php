<?php

/**
 * custom helpers
 */

function formatDate($date) {
    return \Carbon\Carbon::parse($date)->format('d/m/Y');
}

function formatStatoCliente($stato) {
    return str_replace('_',' ',$stato);
}

function getColorStatoCliente($stato) {
    $color = 'transparent';
    switch($stato) {
        case 'da_lavorare': $color = '#66b85f'; break;
        case 'da_ricontattare': $color = '#e0ca4a'; break;
        case 'contattato': $color = '#e0ca4a'; break;
        case 'parking': $color = '#eb5353'; break;
        case 'non_qualificato': $color = '#c0c0c0'; break;
        default: break;
    }

    return $color;
}

function getColorStatoOfferta($stato) {
    $color = '#000';
    switch($stato) {
        case 'in attesa': $color = '#e0ca4a'; break;
        case 'accettata': $color = '#66b85f'; break;
        case 'rifiutata': $color = '#eb5353'; break;
        case 'annullata': $color = '#eb5353'; break;
        default: break;
    }

    return $color;
}

function getColorStatoCommessa($stato) {
    $color = '#000';
    switch($stato) {
        case 'Aperta': $color = '#66b85f'; break;
        case 'Chiusa': $color = '#e0ca4a'; break;
        case 'Annullata': $color = '#eb5353'; break;
        default: break;
    }

    return $color;
}