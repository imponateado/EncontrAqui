<?php

$content = [
    [
        'nomeFantasia' => 'padaria do seu joão',
        'logradouro' => 'rua do joão',
        'numero' => '300',
        'complemento' => 'perto da padaria concorrente'
    ],
    [
        'nomeFantasia' => 'padaria concorrente',
        'logradouro' => 'rua do joão',
        'numero' => '301',
        'complemento' => 'perto da padaria do joão'
    ],
    [
        'nomeFantasia' => 'empresa com nome criativo',
        'logradouro' => 'rua de nome criativo aqui',
        'numero' => '415',
        'complemento' => 'complemento criativo'
    ],
    [
        'nomeFantasia' => 'outra empresa com outro nome criativo',
        'logradouro' => 'rua de nome criativo',
        'numero' => '567',
        'complemento' => 'complemento também criativo'
    ],
    [
        'nomeFantasia' => '',
        'logradouro' => '',
        'numero' => '',
        'complemento' => ''
    ]
];

echo json_encode($content);

/*
estrutura:
nomeFantasia
logradouro
numero
complemento
*/