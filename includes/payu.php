<?php
function payu_hash(array $payu, array $fields): string
{
    $hashString = implode('|', [
        $payu['key'],
        $fields['txnid'],
        $fields['amount'],
        $fields['productinfo'],
        $fields['firstname'],
        $fields['email'],
        '', '', '', '', '',
        $payu['salt'],
    ]);
    return strtolower(hash('sha512', $hashString));
}

function verify_payu_response(array $payu, array $post): bool
{
    $status = $post['status'] ?? '';
    $hash = $post['hash'] ?? '';
    $reverse = implode('|', [
        $payu['salt'],
        $status,
        '', '', '', '', '',
        $post['email'] ?? '',
        $post['firstname'] ?? '',
        $post['productinfo'] ?? '',
        $post['amount'] ?? '',
        $post['txnid'] ?? '',
        $payu['key'],
    ]);
    return hash_equals(strtolower(hash('sha512', $reverse)), strtolower($hash));
}
