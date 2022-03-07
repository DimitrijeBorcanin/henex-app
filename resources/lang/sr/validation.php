<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted' => ':attribute mora biti prihvaćen.',
    'accepted_if' => ':attribute mora biti prihvaćen kada je :other :value.',
    'active_url' => ':attribute nije ispravan URL.',
    'after' => ':attribute mora biti datum posle :date.',
    'after_or_equal' => ':attribute mora biti posle ili jednak :date.',
    'alpha' => ':attribute sme sadržati samo slova.',
    'alpha_dash' => ':attribute sme sadržati samo slova, cifre, crtice i donje crte.',
    'alpha_num' => ':attribute sme sadržati samo slova i cifre.',
    'array' => ':attribute mora biti niz.',
    'before' => ':attribute mora biti pre :date.',
    'before_or_equal' => ':attribute mora biti pre ili jednak :date.',
    'between' => [
        'numeric' => ':attribute mora biti između :min i :max.',
        'file' => ':attribute mora biti između :min i :max kilobajta.',
        'string' => ':attribute mora biti između :min i :max karaktera.',
        'array' => ':attribute mora imati između :min i :max članova.',
    ],
    'boolean' => ':attribute mora biti tačan ili netačan.',
    'confirmed' => 'Potvrda se ne podudara sa :attribute.',
    'current_password' => 'lozinka je neispravna.',
    'date' => ':attribute nije ispravan datum.',
    'date_equals' => ':attribute mora biti datum jednak :date.',
    'date_format' => ':attribute mora biti u formatu :format.',
    'declined' => ':attribute mora biti odbijen.',
    'declined_if' => ':attribute mora biti odbijen kada je :other :value.',
    'different' => ':attribute i :other moraju biti različiti.',
    'digits' => ':attribute mora imati :digits cifara.',
    'digits_between' => ':attribute sme biti između :min i :max cifara.',
    'dimensions' => ':attribute ima loše dimenzije slike.',
    'distinct' => ':attribute ima ponovljenu vrednost.',
    'email' => ':attribute mora biti ispravna email adresa.',
    'ends_with' => ':attribute se mora završiti sa: :values.',
    'enum' => 'izabrani :attribute je neispravan.',
    'exists' => 'izabrani :attribute je neispravan.',
    'file' => ':attribute mora biti datoteka.',
    'filled' => ':attribute mora imati vrednost.',
    'gt' => [
        'numeric' => ':attribute mora biti veći od :value.',
        'file' => ':attribute mora biti veći od :value kilobajta.',
        'string' => ':attribute mora biti veći od :value karaktera.',
        'array' => ':attribute mora imati više od :value članova.',
    ],
    'gte' => [
        'numeric' => ':attribute mora biti veći ili jednak :value.',
        'file' => ':attribute mora biti veći ili jednak :value kilobajta.',
        'string' => ':attribute mora biti veći ili jednak :value karaktera.',
        'array' => ':attribute mora imati :value ili više članova.',
    ],
    'image' => ':attribute mora biti slika.',
    'in' => 'izabrani :attribute je neispravan.',
    'in_array' => ':attribute polje ne postoji u :or.',
    'integer' => ':attribute mora biti celobrojan.',
    'ip' => ':attribute mora biti ispravna IP adresa.',
    'ipv4' => ':attribute mora biti ispravna IPv4 adresa.',
    'ipv6' => ':attribute mora biti ispravna IPv6 adresa.',
    'json' => ':attribute mora biti ispravan JSON string.',
    'lt' => [
        'numeric' => ':attribute mora biti manji od :value.',
        'file' => ':attribute mora biti manji od :value kilobajta.',
        'string' => ':attribute mora biti manji od :value karaktera.',
        'array' => ':attribute mora imati manje od :value članova.',
    ],
    'lte' => [
        'numeric' => ':attribute mora biti manji ili jednak :value.',
        'file' => ':attribute mora biti manji ili jednak :value kilobajta.',
        'string' => ':attribute mora biti manji ili jednak :value karaktera.',
        'array' => ':attribute ne sme imati više od :value članova.',
    ],
    'mac_address' => ':attribute mora biti ispravna MAC adresa.',
    'max' => [
        'numeric' => ':attribute ne sme biti veći od :max.',
        'file' => ':attribute ne sme biti veći od :max kilobajta.',
        'string' => ':attribute ne sme biti veći od :max karaktera.',
        'array' => ':attribute ne sme imati više od :max članova.',
    ],
    'mimes' => ':attribute mora biti datoteka tipa: :values.',
    'mimetypes' => ':attribute mora biti datoteka tipa: :values.',
    'min' => [
        'numeric' => ':attribute mora biti najmanje :min.',
        'file' => ':attribute mora biti najmanje :min kilobajta.',
        'string' => ':attribute mora biti najmanje :min karaktera.',
        'array' => ':attribute mora imati najmanje :min članova.',
    ],
    'multiple_of' => ':attribute mora biti umnožak od :value.',
    'not_in' => 'izabrani :attribute je neispravan.',
    'not_regex' => ':attribute format je neispravan.',
    'numeric' => ':attribute mora biti broj.',
    'password' => 'lozinka je neispravna.',
    'present' => ':attribute polje mora postojati.',
    'prohibited' => ':attribute polje je zabranjeno.',
    'prohibited_if' => ':attribute polje je zabranjeno kada je :other :value.',
    'prohibited_unless' => ':attribute polje je zabranjeno osim ako je :other :values.',
    'prohibits' => ':attribute polje zabranjuje da postoji :other.',
    'regex' => ':attribute format je neispravan.',
    'required' => ':attribute polje je obavezno.',
    'required_array_keys' => ':attribute polje ne sme imati unose za: :values.',
    'required_if' => ':attribute polje je obavezno kada je :other :value.',
    'required_unless' => ':attribute polje je obavezno osim ako je :other :values.',
    'required_with' => ':attribute polje je obavezno kada :values postoji.',
    'required_with_all' => ':attribute polje je obavezno kada :values postoje.',
    'required_without' => ':attribute polje je obavezno kada :values ne postoji.',
    'required_without_all' => ':attribute polje je obavezno kada nijedno od :values ne postoji.',
    'same' => ':attribute i :other se moraju podudarati.',
    'size' => [
        'numeric' => ':attribute mora biti :size.',
        'file' => ':attribute mora biti :size kilobajta.',
        'string' => ':attribute mora biti :size karaktera.',
        'array' => ':attribute mora imati :size članova.',
    ],
    'starts_with' => ':attribute mora počinjati sa jednim od sledećih vrednosti: :values.',
    'string' => ':attribute mora biti string.',
    'timezone' => ':attribute mora biti ispravna vremenska zona.',
    'unique' => ':attribute je već zauzet.',
    'uploaded' => ':attribute nije uspeo sa otpremanjem.',
    'url' => ':attribute mora biti ispravan URL.',
    'uuid' => ':attribute mora biti ispravan UUID.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [],

];
